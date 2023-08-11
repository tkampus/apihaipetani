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
        Schema::create('u_ahlis', function (Blueprint $table) {
            // $table->id();
            $table->string('nohp')->unique();
            $table->string('email');
            $table->string('nik');
            $table->string('jeniskelamin');
            $table->date('tanggallahir');
            $table->string('alamat');
            // ahli
            $table->string('nip');
            $table->string('keahlian1');
            $table->string('keahlian2');
            $table->string('kantor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_ahlis');
    }
};
