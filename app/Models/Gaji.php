<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    // secara bawaan nama table menggunakan jamak versi inggris
    // lindungi $meja berisi gaji
    protected $table = 'gaji';
    // secara bawaan primary key nya adalah id makanya aku mengubah nya
    // lindungi $utamaKunci nya adalah id maka nya aku mengubahnya
    protected $primaryKey = 'gaji_id';
    // agar fitur create data dan update data secara massal berfungsi
    // lindungi $penjaga berisi array
    protected $guarded = [];

    // 1 gaji punya banyak gaji detail
    public function gaji_detail()
    {
        // kembalikkan class gaji memiliki banyak gaji_detail
        return $this->hasMany(GajiDetail::class);
    }
}
