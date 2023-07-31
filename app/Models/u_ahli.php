<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class u_ahli extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'telp',
        'nik',
        'jeniskelamin',
        'tanggallahir',
        'alamat',
        // ahli
        'nip',
        'keahlian1',
        'keahlian2',
        'kantor'
    ];
    protected static function booted()
    {
        // Set nilai default untuk kolom yang diinginkan sebelum model disimpan
        static::creating(function ($model) {
            $model->telp = '';
            $model->nik = '';
            $model->tanggallahir = date('Y-m-d');
            $model->jeniskelamin = 'laki-laki';
            $model->alamat = '';
            $model->nip = '';
            $model->keahlian1 = '';
            $model->keahlian2 = '';
            $model->kantor = '';
        });
    }
}
