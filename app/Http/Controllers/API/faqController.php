<?php

namespace App\Http\Controllers\API;

use App\Models\faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;

class faqController extends BaseController
{
    public function get(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // cek
        if (isset($data['kategori'])) {
            if ($data['kategori'] == 'all') {
                $res = faq::all();
            } else {
                $res = faq::where('kategori', $data['kategori'])->get();
            }
            if ($res->isEmpty()) {
                return $this->sendError('Not Found', ['error' => 'Tidak ditemukan FAQ untuk kategori ini']);
            } else {
                return $this->sendResponse($res, 'Berhasil mengambil data FAQ');
            }
        } else {
            return $this->sendError('Undefined kategori', ['error' => 'Undefined kategori']);
        }
    }
    public function up(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
    }
    public function set(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
    }
    public function del(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
    }
}
