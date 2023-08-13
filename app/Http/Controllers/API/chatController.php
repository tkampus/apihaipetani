<?php

namespace App\Http\Controllers\API;

use App\Models\chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class chatController extends BaseController
{
    public function getriwayat(Request $req)
    {
        $user = Auth::user();
        // tanpa validasi 
        // logik
        $data = chat::where('no_pengirim', $user->nohp)
            ->orwhere('no_penerima', $user->nohp)
            ->orderBy('id', 'desc')
            ->get();
        $datas = [];
        foreach ($data as $chat) {
            $user2 = ($chat->no_pengirim == $user->nohp) ? $chat->no_penerima : $chat->no_pengirim;
            $chat['isMyMessage'] = ($chat->no_pengirim == $user->nohp) ? true : false;
            if (!isset($datas[$user2])) {
                $datas[$user2] = $chat;
                // $datas[$user2] = [];
            }
            // $datas[$user2][] = $chat;
        }
        return $this->sendResponse($datas);
    }
    public function getahli(Request $req): JsonResponse
    {
        $user = Auth::user();
        // tanpa validasi 
        // logik
        $data = user::where('role', 'ahli')
            ->join('u_ahlis', 'users.nohp', '=', 'u_ahlis.nohp')
            ->select('users.username', 'u_ahlis.nohp', 'u_ahlis.bintang', 'u_ahlis.keahlian1', 'u_ahlis.keahlian2')
            ->get();
        return $this->sendResponse($data);
    }
    public function getchat(Request $req): JsonResponse
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'nohp' => 'required|regex:/^\d{10,12}$/',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logik
        $datas = chat::getchat($user->nohp, $data['nohp']);
        foreach ($datas as $chat) {
            if ($chat->gambar_pesan) {
                $chat->gambar_pesan = base64_encode($chat->gambar_pesan);
            }
        }
        // logika untuk semua chat dengan $data['nohp'], statusn chatnay menjadi 2
        return $this->sendResponse($datas);
    }
    public function setchat(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'no_penerima' => 'required|regex:/^\d{10,12}$/',
            'text_pesan' => 'nullable|string',
            'gambar_pesan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // logik imgae jiak gambar_text != null
        if (isset($data['gambar_pesan'])) {
            // return 'sknk';
            $imagePath = $data['gambar_pesan']->getPathname();
            $data['gambar_pesan'] = file_get_contents($imagePath);
        } else {
            $data['gambar_pesan'] = NULL;
        }

        $data['no_pengirim'] = $user->nohp;
        $data['status'] = 1;
        // logik untuk mengirim gambar ke datase eror
        $success = Chat::create($data);
        // $success['gambar_pesan'] = 'gambar';
        // $success = 'lklbl,';
        return $this->sendResponse($success, 'Chat berhasil di tambahkan');
    }
}
