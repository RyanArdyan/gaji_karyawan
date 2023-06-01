<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiDetail extends Model
{
    use HasFactory;

    // secara bawaan nama table menggunakan jamak versi inggris
    // lindungi $meja berisi gaji_detail
    protected $table = 'gaji_detail';
    // secara bawaan primary key nya adalah id makanya aku mengubah nya
    // lindungi $utamaKunci nya adalah id maka nya aku mengubahnya
    protected $primaryKey = 'gaji_detail_id';
    // agar fitur create data dan update data secara massal berfungsi
    // lindungi $penjaga berisi array
    protected $guarded = [];

    // // eager loading mencegah kueri N+1, bersemangat memuat secara bawaan, ini penting untuk membuat api, jadi saat aku mengambil satu baris gaji_detail maka 1 baris dari table gaji juga akan terbawa
    // // lindungi dengan relasi gaji
    // protected $with = ["gaji"];

    // relasi
    // belongs to / satu gaji_detail milik 1 gaji
    public function gaji()
    {
        // argumen pertama adalah berelasi dengan models/gaji
        // argumen kedua adalah foreign key di table gaji_detail
        // argumen ketiga adalah primary key di table gaji
        return $this->belongsTo(Gaji::class, 'gaji_id', 'gaji_id');
    }

    // relasi
    // belongs to / satu gaji_detail milik 1 jabatan
    public function jabatan()
    {
        // argumen pertama adalah berelasi dengan models/jabatan
        // argumen kedua adalah foreign key di table gaji_detail
        // argumen ketiga adalah primary key di table jabatan
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'jabatan_id');
    }
}
