<?php

namespace App\Http\Controllers\API;

use App\Models\chat;
use App\Models\bookmark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class bookmarkController extends BaseController
{
    public function set(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'id_chat' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logik
        if (chat::checkEmailInChat($user->email, $data['id_chat'])) {
            if (bookmark::where('email', $user->email)->where('id_chat', $data['id_chat'])->exists()) {
                return $this->sendError('Duplikat bookmark!', ['bookmark' => 'Bookmark pesan sudah ada!']);
            } else {
                $datas = bookmark::create([
                    'email' => $user->email,
                    'id_chat' => $data['id_chat'],
                ]);
                return $this->sendResponse($datas, 'Berhasil menambahkan bookmark!');
            }
        } else {
            return $this->sendError('Validation Error!', ['error' => 'Kesalahan id pesan, id pesan tidak ditemukan!']);
        }
    }
    public function get(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // Validasi 
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logika 
        $datas = bookmark::getWhereEmail($user->email, $data['email']);
        return $this->sendResponse($datas);
    }

    public function del(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi 
        $validator = Validator::make($data, [
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logik
        $bookmark = bookmark::where('id', $data['id'])->where('email', $user->email)->first();
        if ($bookmark) {
            $bookmark->delete();
        } else {
            return $this->sendError('Bookmark not fount!', ['error' => 'Bookmark dengan id tidak ditemukan!']);
        }
        return $this->sendResponse([], 'Berhasil menghapus bookmark!');
    }
}
