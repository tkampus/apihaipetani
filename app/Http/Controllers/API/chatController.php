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
    public function getriwayat(Request $req): JsonResponse
    {
        $user = Auth::user();
        // tanpa validasi 
        // logik
        $data = chat::where('email_pengirim', $user->email)
            ->orwhere('email_penerima', $user->email)
            ->orderByDesc('id')
            ->get();
        $datas = [];
        foreach ($data as $chat) {
            $user2 = ($chat->email_pengirim == $user->email) ? $chat->email_penerima : $chat->email_pengirim;
            if (!isset($datas[$user2])) {
                $datas[$user2] = [];
            }
            $datas[$user2][] = $chat;
        }
        return $this->sendResponse($datas);
    }
    public function getahli(Request $req): JsonResponse
    {
        $user = Auth::user();
        // tanpa validasi 
        // logik
        $data = user::where('role', 'ahli')
            ->join('u_ahlis', 'users.email', '=', 'u_ahlis.email')
            ->select('users.username', 'u_ahlis.email', 'u_ahlis.keahlian1', 'u_ahlis.keahlian2')
            ->get();
        return $this->sendResponse($data);
    }
    public function getchat(Request $req): JsonResponse
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logik
        $datas = chat::getchat($user->email, $data['email']);
        return $this->sendResponse($datas);
    }
    public function setchat(Request $req): JsonResponse
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'email_penerima' => 'required|email',
            'text_pesan' => 'nullable|string',
            'gambar_pesan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // logik imgae jiak gambar_text != null
        if ($data['gambar_image'] != null) {
            $imagePath = $req->file('gambar')->getPathname();
            $data['gambar_pesan'] = file_get_contents($imagePath);
        }

        $data['email_pengirim'] = $user->email;
        // logik untuk mengirim gambar ke datase eror

        $success = Chat::create($data);
        return $this->sendResponse($success, 'Chat berhasil di tambahkan');
    }
}
