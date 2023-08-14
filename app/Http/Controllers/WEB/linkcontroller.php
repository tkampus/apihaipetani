<?php

namespace App\Http\Controllers\WEB;

use App\Models\chat;
use App\Models\event;
use App\Models\u_ahli;
use App\Models\u_petani;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class linkcontroller extends Controller
{
    public function getimgchat($id)
    {
        $event = chat::find($id);
        return Response::make($event->gambar_pesan, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $event->judul . '.jpeg"',
        ]);
    }
    public function getimgevent($id)
    {
        $event = event::find($id);
        return Response::make($event->gambar, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $event->judul . '.jpeg"',
        ]);
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
        return Response::make($data->gambar, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $data->judul . '.jpeg"',
        ]);
    }
}
