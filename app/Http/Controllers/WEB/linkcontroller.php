<?php

namespace App\Http\Controllers\WEB;

use App\Models\chat;
use App\Models\event;
use App\Models\u_ahli;
use App\Models\u_petani;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class linkcontroller extends Controller
{
    public function getimgchat($id)
    {
        $chat = chat::find($id);
        // ================================================== disimpan binray di badabase
        // return Response::make($chat->gambar_pesan, 200, [
        //     'Content-Type' => 'image/jpeg',
        //     'Content-Disposition' => 'inline; filename="' . $chat->judul . '.jpeg"',
        // ]);
        // =================================================== disimpan di text di dabase
        // return '<img src="data:image/jpeg;base64,' . $chat->gambar_pesan . '" alt="Gambar Pesan">';
        // =================================================== disipan di storage web api
        // return $chat->gambar_pesan;
        return '<img src="' . Storage::url($chat->gambar_pesan) . '" alt="Gambar Pesan">';
    }
    public function getimgevent($id)
    {
        $event = event::find($id);
        // ================================================== disimpan binray di badabase
        // return Response::make($event->gambar, 200, [
        //     'Content-Type' => 'image/jpeg',
        //     'Content-Disposition' => 'inline; filename="' . $event->judul . '.jpeg"',
        // ]);
        // =================================================== disipan di storage web api
        return '<img src="' . Storage::url($event->gambar) . '" alt="Gambar Pesan">';
    }
    public function getimgprofil($role, $nohp)
    {
        switch ($role) {
            case 'petani':
                $data = u_petani::where('nohp', $nohp)->first();
                break;
            case 'ahli':
                $data = u_ahli::where('nohp', $nohp)->first();
                break;
            default:
                return 'gambar tidak ditemukan';
                break;
        }
        if ($data->gambar == null) {
            return 'belum pernah upload gambar';
        }
        // ================================================== disimpan binray di badabase
        // return Response::make($data->gambar, 200, [
        //     'Content-Type' => 'image/jpeg',
        //     'Content-Disposition' => 'inline; filename="' . $data->judul . '.jpeg"',
        // ]);
        // =================================================== disipan di storage web api
        return '<img src="' . Storage::url($data->gambar) . '" alt="Gambar Pesan">';
    }
}
