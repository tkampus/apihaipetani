<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('u_petanis', function (Blueprint $table) {
            $table->string('nohp')->unique();
            $table->binary('gambar')->nullable();
            $table->string('email');
            $table->string('nik');
            $table->string('jeniskelamin');
            $table->date('tanggallahir');
            $table->string('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_petanis');
    }
};
