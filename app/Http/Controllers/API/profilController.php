<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\u_ahli;
use App\Models\u_petani;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public function up(Request $req)
    {
        $user = Auth::user();
        $data = $req->all();
        // validasi
        $validator = Validator::make($data, [
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
        // logik up user username
        $username['username'] = $data['username'];
        User::where('nohp', $user->nohp)->update($username);
        unset($data['username']);
        $data['nohp'] = $user->nohp;
        // get profil petani/ahli
        switch ($user->role) {
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
        // return $profil;
        $gambar = $req->file('gambar');
        if ($gambar) {
            // ================================================== disimpan binray di badabase
            // $gambarStream = fopen($gambar->getRealPath(), 'rb');
            // $profil['gambar'] = fread($gambarStream, filesize($gambar->getRealPath()));
            // fclose($gambarStream);
            // =================================================== disipan di storage web api
            // if ($data['gambar']) {
            //     if ($profil['gmabar']) {
            //         Storage::delete($profil['gambar']);
            //     }
            // }
            // $gambar = $req->file('gambar');
            // $namaGambar = Str::random(30) . '.' . $gambar->getClientOriginalExtension();
            // $path = $gambar->storeAs('public/gambar/profil', $namaGambar);
            $data['gambar'] = $this->saveimg('profil', $req->file('gambar'), $profil['gambar']);
            // ==================================================

        }
        try {
            unset($profil['id']);
            $profil->update($data);
        } catch (Exception $e) {
            Storage::delete($data['gambar']);
            return $this->sendError(['error' => 'Terjadi kesalahan saat menyimpan chat', 'data' => $e->getMessage()]);
        }
        // return 
        $profil['nohp'] = $user['nohp'];
        $profil['gambar'] = route('getimgprofil', ['nohp' => $user['nohp'], 'role' => $user['role']]);
        return $this->sendResponse($profil, 'Update profil successfully!');
    }
}
