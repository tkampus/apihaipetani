<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookmark extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'id_chat',
    ];

    public static function getWhereEmail($email1, $email2)
    {
        return self::where('email', $email1)
            ->join('chats', 'bookmarks.id_chat', '=', 'chats.id')
            ->select(
                'bookmarks.id as id_bookmark',
                'chats.id as id_chats',
                'chats.email_pengirim',
                'chats.email_penerima',
                'chats.text_pesan',
                'chats.gambar_pesan',
                'chats.created_at'
            )
            ->where(function ($query) use ($email2) {
                $query->where('email_pengirim', $email2)
                    ->orWhere('email_penerima', $email2);
            })
            ->get();
    }
}
