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
        // skema buat table jabatan, jalankan fungsi Cetakbiru, $meja
        Schema::create('jabatan', function (Blueprint $table) {
            // buat tipe data big integer yang auto increment, column user_id
            $table->bigIncrements('jabatan_id');
            // tipe string, column nama_jabatan, harus unique tidak boleh sama
            $table->string('nama_jabatan')->unique();
            // tipe integer, column gaji_pokok
            $table->integer('gaji_pokok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
