<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\u_ahli;
use App\Models\u_petani;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class profilController extends BaseController
{
    public function get(Request $req): JsonResponse
    {
        $user = Auth::user();
        switch ($user['role']) {
            case 'petani':
                $profil = u_petani::where('nohp', $user->nohp)->first();
                break;
            case 'ahli':
                $profil = u_ahli::where('nohp', $user->nohp)->first();
                break;
            default:
                return $this->sendError('Role Error!', ['error' => 'Undifined Role']);
                break;
        }
        // return $user;
        $profil['username'] = $user->username;
        if ($profil['gambar'] != null) {
            $profil['gambar'] =  route('getimgprofil', ['nohp' => $profil['nohp'], 'role' => $user['role']]);
        }
        return $this->sendResponse($profil);
    }
    public function up(Request $req): JsonResponse
    {
        $user = Auth::user();
        $profil = $req->all();
        // validasi
        $validator = Validator::make($profil, [
            'username' => 'string',
            'email' => 'email',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telp' => 'numeric',
            'nik' => 'numeric',
            'jeniskelamin' => 'in:laki-laki,perempuan',
            'tanggallahir' => 'date',
            'alamat' => 'string',
            'nip' => 'string',
            'keahlian1' => 'string',
            'keahlian2' => 'string',
            'kantor' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error!', $validator->errors());
        }
        // logik
        $username['username'] = $profil['username'];
        User::where('nohp', $user->nohp)->update($username);
        unset($profil['username']);
        $gambar = $req->file('gambar');
        if ($gambar) {
            $gambarStream = fopen($gambar->getRealPath(), 'rb');
            $profil['gambar'] = fread($gambarStream, filesize($gambar->getRealPath()));
            fclose($gambarStream);
        }
        try {
            switch ($user->role) {
                case 'petani':
                    u_petani::where('nohp', $user->nohp)->update($profil);
                    break;
                case 'ahli':
                    u_ahli::where('nohp', $user->nohp)->update($profil);
                    break;
                default:
                    return $this->sendError('Role Error!', ['error' => 'Undifined Role']);
                    break;
            }
        } catch (Exception $e) {
            return $this->sendError(['error' => 'Terjadi kesalahan saat menyimpan chat']);
        }
        $profil = $req->all();
        $profil['nohp'] = $user['nohp'];
        $profil['gambar'] = route('getimgprofil', ['nohp' => $user['nohp'], 'role' => $user['role']]);
        return $this->sendResponse($profil, 'Update profil successfully!');
    }
}
