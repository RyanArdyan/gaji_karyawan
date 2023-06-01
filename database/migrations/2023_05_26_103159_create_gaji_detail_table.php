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
        // skema buat table gaji_detail, jalankan fungsi Cetak_biru, $meja
        Schema::create('gaji_detail', function (Blueprint $table) {
            // buat tipe data big integer yang auto increment, column gaji_detail_id
            $table->bigIncrements('gaji_detail_id');
            // foreign key atau kunci asing, relasinya adalah 1 gaji detail milik 1 gaji
            // buat foreign key column di table gaji_detail yaitu gaji_id yang berelasi dengean column gaji_id milik table gaji
            // jika suatu gaji dihapus misalnya bulan mei, 2023 maka hapus juga semua gaji detail terkait nya mengunakan onUpdate('cascade')
            $table->foreignId('gaji_id')->constrained('gaji')
                ->references('gaji_id')
                // padaPenghapusan('mengalir')
                ->onDelete('cascade')
                // padaPembaruan('mengalir')
                ->onUpdate('cascade');

            // jika jabatan "administrasi" memiliki gaji_detal maka halangi penghapusan menggunakan restrict
            $table->foreignId('jabatan_id')->constrained('jabatan')
                ->references('jabatan_id')
                // padaPenghapusan('membatasi')
                ->onDelete('restrict')
                // padaPembaruan('membatasi')
                ->onUpdate('restrict');

            // tipe char digunakan ketika panjang value nya tetap
            $table->char('nip_karyawan');
            // tipe string, column nama_karyawan value nya harus unique atau tidak boleh sama
            $table->string('nama_karyawan')->unique();
            // pake enum karena value nya antara "m" atau "s"
            $table->enum('kode_status', ["m", "s"]);
            // tipe integer, column tunjangan
            $table->integer('tunjangan');
            // tipe integer, column subtotal_gaji
            $table->integer('subtotal_gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_detail');
    }
};
