# Petani dan Ahli API

## Instalasi

1. Instal package Sanctum.
2. Konfigurasi file `.env` untuk mengatur database dan pengaturan lainnya.
3. Masukkan data sampel dengan menjalankan perintah `php artisan app:resetsampel`.
4. konfigurasi penyimpanan storage dengan menjalankan perintah `php artisan storage:link`.

## API yang Sudah Tersedia

1. **Daftar**

    - Endpoint: `/api/daftar`
    - Input:
        - `email`
        - `password`
        - `c-password`
    - Output:
        - `username`
        - `token`

2. **Login**

    - Endpoint: `/api/login`
    - Input:
        - `email`
        - `password`
    - Output:
        - `username`
        - `token`

3. **Logout**

    - Endpoint: `/api/logout`
    - Authorization: Bearer Token

4. **Get Profil**

    - Endpoint: `/api/getprofil`
    - Authorization: Bearer Token

5. **Update Profil**

    - Endpoint: `/api/upprofil`
    - Authorization: Bearer Token
    - Input (user role petani):
        - `username`
        - `telp`
        - `nik`
        - `tanggallahir`
        - `jeniskelamin`
        - `alamat`
    - Input (user role ahli):
        - `username`
        - `telp`
        - `nik`
        - `tanggallahir`
        - `jeniskelamin`
        - `alamat`
        - `nip`
        - `keahlian1`
        - `keahlian2`
        - `kantor`

6. **Get FAQ**

    - Endpoint: `/api/getfaq`
    - Input:
        - `kategori` (all, pertanian, peternakan, teknologi, pasar, lingkungan)
    - Output:
        - `[]`

7. **Set Masukan**

    - Endpoint: `/api/setmasukan`
    - Authorization: Bearer Token
    - Input:
        - `masukan`

8. **Get Bookmark**

    - Endpoint: `/api/getbookmark`
    - Authorization: Bearer Token
    - Input:
        - `email`
    - Output:
        - `[]`

9. **Set Bookmark**

    - Endpoint: `/api/setbookmark`
    - Authorization: Bearer Token
    - Input:
        - `id_chat`

10. **Hapus Bookmark**

    - Endpoint: `/api/delbookmark`
    - Authorization: Bearer Token
    - Input:
        - `id` = id bookmark

11. **Get Ahli**

    - Endpoint: `/api/getahli`
    - Authorization: Bearer Token
    - Input: Tidak ada

12. **Get Riwayat Obrolan**

    - Endpoint: `/api/getallchat`
    - Authorization: Bearer Token
    - Input:
        - `email`

13. **Get Chat**

    - Endpoint: `/api/getchat`
    - Authorization: Bearer Token
    - Input:
        - `email`

14. **Set Chat**

    - Endpoint: `/api/setchat`
    - Authorization: Bearer Token
    - Input:
        - `email`

15. **Get Event**

    - Endpoint: `/api/getevent`

## API yang Belum Tersedia

1. **Notifikasi**

    - Endpoint: `/api/notifikasi`
    - Authorization: Bearer Token
    - Input:
        - (masukkan input yang dibutuhkan untuk notifikasi)

2. **Log Aktivitas**
    - Endpoint: `/api/logaktivitas`
    - Authorization: Bearer Token
    - Input:
        - (masukkan input yang dibutuhkan untuk log aktivitas)
