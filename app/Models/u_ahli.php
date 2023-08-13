<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class u_ahli extends Model
{
    use HasFactory;
    protected $fillable = [
        'nohp',
        'email',
        'nik',
        'jeniskelamin',
        'tanggallahir',
        'alamat',
        // ahli
        'nip',
        'bintang',
        'keahlian1',
        'keahlian2',
        'kantor'
    ];
    protected static function booted()
    {
        // Set nilai default untuk kolom yang diinginkan sebelum model disimpan
        static::creating(function ($model) {
            $model->email = '';
            $model->nik = '';
            $model->tanggallahir = date('Y-m-d');
            $model->jeniskelamin = 'laki-laki';
            $model->alamat = '';
            $model->nip = '';
            $model->bintang = 3.1;
            $model->keahlian1 = '';
            $model->keahlian2 = '';
            $model->kantor = '';
        });
    }
}
