<?php

namespace App\Http\Controllers\API;

use App\Models\faq;
use App\Models\chat;
use App\Models\User;
use App\Models\event;
use App\Models\u_ahli;
use App\Models\masukan;
use App\Models\u_petani;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class appController extends BaseController
{
    public function daftar(Request $req): JsonResponse
    {
        // validasi
        $validator = Validator::make($req->all(), [
            'nohp' => 'required|regex:/^\d{10,12}$/|unique:users,nohp',
            'password' => 'required',
            'c-password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // buat akun
        $input = $req->all();
        $input['role'] = 'petani';
        $input['username'] = 'user_' . Str::random(6);
        $input['remember_token'] = 'token_' . Str::random(15);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // buat tabel data user
        switch ($req->role) {
            case 'petani':
                $petani = u_petani::create($input);
                break;
            case 'ahli':
                $ahli = u_ahli::create($input);
                break;
            default:
                return $this->sendError('Role Error!', ['error' => 'Undifined Role']);
                break;
        }

        // buat request
        $success['token'] = $user->createToken($user->remember_token)->plainTextToken;
        $success['username'] = $user->username;
        return $this->sendResponse($success, 'User register successfully!');
    }

    public function masuk(Request $req): JsonResponse
    {
        // validasi
        if (Auth::attempt(
            [
                'nohp' => $req->nohp,
                'password' => $req->password
            ]
        )) {
            $user = Auth::user();
            $success['token'] = $user->createToken($user->remember_token)->plainTextToken;
            $success['username'] = $user->username;

            return $this->sendResponse($success, 'User login successfully!');
        } else {
            return $this->sendError('Unauthorised', ['error' => 'Email atau Password salah!']);
        }
    }

    public function keluar(Request $req): JsonResponse
    {
        $req->user()->currentAccessToken()->delete();
        $success = '';
        return $this->sendResponse($success, 'User logout successfully!');
    }
    public function setmasukan(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // logik
        $masukan = masukan::create([
            'nohp' => $user->nohp,
            'masukan' => $data['masukan']
        ]);
        return $this->sendResponse($masukan, 'Berhasil input masukan');
    }

    public function getevent(Request $req)
    {
        $data = event::latest()->first();
        return $this->sendResponse($data);
    }

    public function getimagechat($id)
    {
        $event = chat::find($id);
        return Response::make($event->gambar_pesan, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $event->judul . '.jpeg"',
        ]);
    }
    public function getimageevent($id)
    {
        $event = event::find($id);
        return Response::make($event->gambar, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $event->judul . '.jpeg"',
        ]);
    }
}
