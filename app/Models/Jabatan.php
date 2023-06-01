<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    // secara bawaan nama table menggunakan jamak versi inggris
    // lindungi $meja berisi jabatan
    protected $table = 'jabatan';
    // secara bawaan primary key nya adalah id makanya aku mengubah nya
    // lindungi $utamaKunci nya adalah id maka nya aku mengubahnya
    protected $primaryKey = 'jabatan_id';
    // agar fitur create data dan update data secara massal berfungsi
    // lindungi $penjaga berisi array
    protected $guarded = [];

    // 1 jabatan punya banyak gaji_detail misalnya jabatan administrasi dimiliki oleh andi, budi dan ani
    // 1 jabatan punya banyak gaji detail
    public function gaji_detail()
    {
        // kembalikkan class jabatan memiliki banyak gaji_detail
        return $this->hasMany(GajiDetail::class);
    }
}
