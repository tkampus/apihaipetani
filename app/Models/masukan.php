<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masukan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nohp',
        'masukan',
    ];
}
