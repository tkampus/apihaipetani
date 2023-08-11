<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_pengirim',
        'no_penerima',
        'text_pesan',
        'gambar_pesan',
        'status',
    ];
    public static function checkEmailInChat($email, $id_chat)
    {
        return self::where(function ($query) use ($email) {
            $query
                ->where('no_pengirim', $email)
                ->orWhere('no_penerima', $email);
        })->where('id', $id_chat)->exists();
    }

    public static function getchat($email1, $email2)
    {
        $chats = self::where(function ($query) use ($email1, $email2) {
            $query->where('no_pengirim', $email1)
                ->where('no_penerima', $email2);
        })->orWhere(function ($query) use ($email1, $email2) {
            $query->where('no_pengirim', $email2)
                ->where('no_penerima', $email1);
        })->orderBy('created_at', 'asc')->get();

        // Mengonversi data gambar dari BLOB ke base64 encoded string
        foreach ($chats as $chat) {
            if ($chat->gambar_pesan) {
                $chat->gambar_pesan = base64_encode($chat->gambar_pesan);
            }
        }

        return $chats;
    }
}
