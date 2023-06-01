<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// route tipe dapatkan, jika user di url awal maka panggil HomeController, method index, name nya adalah home.index
Route::get('/', [HomeController::class, 'index'])->name('home.index');
// route tipe kirim, jika user di url berikut maka panggil HomeController, method simpan_gaji_karyawan, name nya adalah home.simpan_gaji_karyawan
Route::post('/simpan-gaji-karyawan', [HomeController::class, 'simpan_gaji_karyawan'])->name('home.simpan_gaji_karyawan');

// route tipe dapatkan, jika user di url berikut maka panggil HomeController, method read, name nya adalah home.read_gaji
Route::get('/read-gaji', [HomeController::class, 'read'])->name('home.read_gaji');
// route tipe dapatkan, jika user di url berikut maka tangkap dan kirimkan gaji_id lalu panggil HomeController, method detail_gaji, name nya adalah home.detail_gaji
Route::get('/detail-gaji/{gaji_id}', [HomeController::class, 'detail_gaji'])->name('home.detail_gaji');
