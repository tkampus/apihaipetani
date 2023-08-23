<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\chat;
use App\Models\User;
use Illuminate\Support\Str;
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
                $chat->gambar_pesan = route('getimgchat', ['id' => $chat->id]);
            }
            if ($chat->no_pengirim == $user->nohp) {
                $chat['mymessage'] = true;
            } else {
                $chat['mymessage'] = false;
            }
        }
        return $this->sendResponse($datas);
    }
    public function setchat(Request $req): JsonResponse
    {
        $user = Auth::user();
        $data = $req->all();

        $validator = Validator::make($data, [
            'no_penerima' => 'required|regex:/^\d{10,12}$/',
            'text_pesan' => 'nullable|string',
            'gambar_pesan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError(['errors' => $validator->errors()]);
        }

        $data['no_pengirim'] = $user->nohp;
        $data['status'] = 1;

        $gambar = $req->file('gambar_pesan');
        if ($gambar) {
            // ================================================== disimpan binray di badabase
            // $gambarStream = fopen($gambar->getRealPath(), 'rb');
            // $data['gambar_pesan'] = fread($gambarStream, filesize($gambar->getRealPath()));
            // fclose($gambarStream);
            // =================================================== disimpan di text di dabase
            // $data['gambar_pesan'] = base64_encode(file_get_contents($req->file('gambar_pesan')->getRealPath()));
            // =================================================== disipan di storage web api
            $data['gambar_pesan'] = $this->saveimg('chat', $req->file('gambar_pesan'));
        }

        try {
            $chat = chat::create($data);
            if ($chat->gambar_pesan) {
                $chat->gambar_pesan = route('getimgchat', ['id' => $chat->id]);
            }
            return $this->sendResponse($chat, 'Chat berhasil ditambahkan');
        } catch (Exception $e) {
            return $this->sendError(['error' => 'Terjadi kesalahan saat menyimpan chat']);
        }
    }
}
