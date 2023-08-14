<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\event;
use App\Models\chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class imgController extends Controller
{
    public function inpugambar(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();

        $validator = Validator::make($data, [
            'no_penerima' => 'required|regex:/^\d{10,12}$/',
            'text_pesan' => 'nullable|string',
            'gambar_pesan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data['no_pengirim'] = $user->nohp;
        $data['status'] = 1;

        $gambar = $req->file('gambar_pesan');
        if ($gambar) {
            $gambarStream = fopen($gambar->getRealPath(), 'rb');
            $data['gambar_pesan'] = fread($gambarStream, filesize($gambar->getRealPath()));
            fclose($gambarStream);
        }

        try {
            $chat = new Chat();
            $chat->no_pengirim = $data['no_pengirim'];
            $chat->no_penerima = $data['no_penerima'];
            $chat->text_pesan = $data['text_pesan'] ?? null;
            $chat->gambar_pesan = $data['gambar_pesan'] ?? null;
            $chat->status = $data['status'];

            $chat->save();

            return response()->json(['message' => 'Chat berhasil ditambahkan',], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan chat'], 500);
        }
    }
}
