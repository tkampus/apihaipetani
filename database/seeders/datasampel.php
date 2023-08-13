<?php

namespace Database\Seeders;

use App\Models\bookmark;
use App\Models\faq;
use App\Models\chat;
use App\Models\User;
use App\Models\u_ahli;
use App\Models\u_petani;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class datasampel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // data sampel
        $user = [
            ['nohp' => '081234567890', 'username' => 'user1', 'password' => bcrypt('password1'), 'role' => 'petani', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '082145678901', 'username' => 'user2', 'password' => bcrypt('password2'), 'role' => 'petani', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '085678901234', 'username' => 'user10', 'password' => bcrypt('password10'), 'role' => 'petani', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '083212345678', 'username' => 'user4', 'password' => bcrypt('password4'), 'role' => 'petani', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '081312345678', 'username' => 'user5', 'password' => bcrypt('password5'), 'role' => 'petani', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '087612345678', 'username' => 'user6', 'password' => bcrypt('password6'), 'role' => 'ahli', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '085789012345', 'username' => 'user7', 'password' => bcrypt('password7'), 'role' => 'ahli', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '089876543210', 'username' => 'user8', 'password' => bcrypt('password8'), 'role' => 'ahli', 'remember_token' => 'token_' . Str::random(15),],
            ['nohp' => '082178901234', 'username' => 'user9', 'password' => bcrypt('password9'), 'role' => 'ahli', 'remember_token' => 'token_' . Str::random(15),],
            // admin
            ['nohp' => 'superadmin@haipetani.com', 'username' => 'Super Admin', 'password' => bcrypt('123'), 'role' => 'admin', 'remember_token' => 'token_' . Str::random(15),],

        ];
        $pesan = [
            ['no_pengirim' => '081234567890', 'no_penerima' => '082145678901', 'status' => 1, 'text_pesan' => 'Halo, apa kabar?', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '082145678901', 'no_penerima' => '081234567890', 'status' => 1, 'text_pesan' => 'Hai, saya baik-baik saja.', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081234567890', 'no_penerima' => '085678901234', 'status' => 1, 'text_pesan' => 'Apa kabar?', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '085678901234', 'no_penerima' => '081234567890', 'status' => 1, 'text_pesan' => 'Saya baik, terima kasih.', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081234567890', 'no_penerima' => '083212345678', 'status' => 1, 'text_pesan' => 'Halo!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081234567890', 'no_penerima' => '081312345678', 'status' => 1, 'text_pesan' => 'Selamat pagi!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '083212345678', 'no_penerima' => '081234567890', 'status' => 1, 'text_pesan' => 'Hai!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '082145678901', 'no_penerima' => '085678901234', 'status' => 1, 'text_pesan' => 'Halo user3!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '085678901234', 'no_penerima' => '082145678901', 'status' => 1, 'text_pesan' => 'Halo user2!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '085678901234', 'no_penerima' => '083212345678', 'status' => 1, 'text_pesan' => 'Apa kabar?', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '083212345678', 'no_penerima' => '085678901234', 'status' => 1, 'text_pesan' => 'Saya baik, terima kasih.', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '082145678901', 'no_penerima' => '083212345678', 'status' => 1, 'text_pesan' => 'Halo user4!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '083212345678', 'no_penerima' => '082145678901', 'status' => 1, 'text_pesan' => 'Halo user2!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081312345678', 'no_penerima' => '081234567890', 'status' => 1, 'text_pesan' => 'Selamat pagi juga!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081234567890', 'no_penerima' => '087612345678', 'status' => 1, 'text_pesan' => 'Apa kabar?', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '087612345678', 'no_penerima' => '081234567890', 'status' => 1, 'text_pesan' => 'Saya baik, terima kasih.', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '082145678901', 'no_penerima' => '081312345678', 'status' => 1, 'text_pesan' => 'Halo user5!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081312345678', 'no_penerima' => '082145678901', 'status' => 1, 'text_pesan' => 'Halo user2!', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '085678901234', 'no_penerima' => '081312345678', 'status' => 1, 'text_pesan' => 'Apa kabar?', 'gambar_pesan' => NULL,],
            ['no_pengirim' => '081312345678', 'no_penerima' => '085678901234', 'status' => 1, 'text_pesan' => 'Saya baik, terima kasih.', 'gambar_pesan' => NULL,],
        ];
        $faq = [
            ['judul' => 'Judul Pertanyaan 1', 'kategori' => 'pertanian', 'ciri2' => 'Ciri-ciri Pertanyaan 1', 'solusi' => 'Solusi Pertanyaan 1', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 2', 'kategori' => 'perternakan', 'ciri2' => 'Ciri-ciri Pertanyaan 2', 'solusi' => 'Solusi Pertanyaan 2', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 3', 'kategori' => 'teknologi', 'ciri2' => 'Ciri-ciri Pertanyaan 3', 'solusi' => 'Solusi Pertanyaan 3', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 4', 'kategori' => 'pasar', 'ciri2' => 'Ciri-ciri Pertanyaan 4', 'solusi' => 'Solusi Pertanyaan 4', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 5', 'kategori' => 'lingkungan', 'ciri2' => 'Ciri-ciri Pertanyaan 5', 'solusi' => 'Solusi Pertanyaan 5', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 6', 'kategori' => 'pertanian', 'ciri2' => 'Ciri-ciri Pertanyaan 6', 'solusi' => 'Solusi Pertanyaan 6', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 7', 'kategori' => 'teknologi', 'ciri2' => 'Ciri-ciri Pertanyaan 7', 'solusi' => 'Solusi Pertanyaan 7', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 8', 'kategori' => 'pertanian', 'ciri2' => 'Ciri-ciri Pertanyaan 8', 'solusi' => 'Solusi Pertanyaan 8', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 9', 'kategori' => 'perternakan', 'ciri2' => 'Ciri-ciri Pertanyaan 9', 'solusi' => 'Solusi Pertanyaan 9', 'created_at' => now(), 'updated_at' => now(),],
            ['judul' => 'Judul Pertanyaan 10', 'kategori' => 'lingkungan', 'ciri2' => 'Ciri-ciri Pertanyaan 10', 'solusi' => 'Solusi Pertanyaan 10', 'created_at' => now(), 'updated_at' => now(),],
        ];
        $bookmark = [
            ['nohp' => '081234567890', 'id_chat' => 1,],
            ['nohp' => '081234567890', 'id_chat' => 3,],
            ['nohp' => '081234567890', 'id_chat' => 4,],
            ['nohp' => '082145678901', 'id_chat' => 1,],
            ['nohp' => '082145678901', 'id_chat' => 6,],
            ['nohp' => '085678901234', 'id_chat' => 3,],
            ['nohp' => '085678901234', 'id_chat' => 7,],
            ['nohp' => '083212345678', 'id_chat' => 5,],
            ['nohp' => '083212345678', 'id_chat' => 6,],
        ];

        // eksekusi
        foreach ($user as $data) {
            user::create($data);
            switch ($data['role']) {
                case 'petani':
                    $petani = u_petani::create(collect($data)->only('nohp')->toArray());
                    break;
                case 'ahli':
                    $ahli = u_ahli::create(collect($data)->only('nohp')->toArray());
                    break;
            }
        }
        foreach ($faq as $data) {
            faq::create($data);
        }
        foreach ($pesan as $data) {
            chat::create($data);
        }
        foreach ($bookmark as $data) {
            bookmark::create($data);
        }
    }
}
