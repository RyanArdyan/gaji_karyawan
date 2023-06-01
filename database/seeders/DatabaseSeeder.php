<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class DatabaseSeeder extends Seeder
{
    /**
     * Kirim aplikasi database
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // jalankan php artisan db:seed agar baris-baris data berikut akan masuk ket table
        // jabatan buat
        Jabatan::create([
            // column nama_jabatan akan berisi 'Administrasi
            'nama_jabatan' => 'Administrasi',
            'gaji_pokok' => 800000, // 800.000
        ]);

        Jabatan::create([
            // column nama_jabatan akan berisi 'Operasional
            'nama_jabatan' => 'Operasional',
            'gaji_pokok' => 850000, // 850.000
        ]);
    }
}
