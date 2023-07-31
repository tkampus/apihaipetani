<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class u_petani extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'telp',
        'nik',
        'jeniskelamin',
        'tanggallahir',
        'alamat'
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
        });
    }
}
