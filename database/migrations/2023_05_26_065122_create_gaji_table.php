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
        // skema buat table gaji, jalankan fungsi Cetakbiru, $meja
        Schema::create('gaji', function (Blueprint $table) {
            // buat tipe data big integer yang auto increment, column gaji_id
            $table->bigIncrements('gaji_id');
            // pakai string agar bisa menyimpan "2023-05", bulan anggaplah berisi "2023-05"
            // $meja->tanggal, column bulan
            $table->string("bulan");
            // total_gaji
            $table->bigInteger('total_gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
