<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiDetail;
use Illuminate\Support\Facades\Validator;
// package laravel datatables
use DataTables;

class HomeController extends Controller
{
    // menampilkan halaman home
    // publik fungsi index
    public function index()
    {
        // kembalikkan ke tampilan welcome
        return view('welcome');
    }

    // baca semua data gaji
    public function read()
    {
        // syntax punya laravel, ambil semua gaji, urutkan dari dari data terbaru ke data terlama
        // berisi gaji::terakhir()->dapatkan
        $semua_gaji = Gaji::latest()->get();
        // syntax punya yajra
        // kembalikkan datatables dari variable semua_gaji
        return DataTables::of($semua_gaji)
            // lakukan pengulangan nomor
            // tambah index kolom
            ->addIndexColumn()
            // buat tombol edit
            ->addColumn('action', function (gaji $gaji) {
                // berisi buat element html
                // $btn = '
                //     <button data-id="' . $gaji->gaji_id . '" class="tombol_edit btn btn-warning btn-sm">
                //         <i class="fas fa-pencil-alt"></i> Edit
                //     </button>
                // ';
                // Jika tombol detail di click maka panggil route home.detail_gaji, lalu kirimkan value detail_gaji, column gaji_id
                $btn = "<a href='/detail-gaji/$gaji->gaji_id' class='btn btn-sm btn-success'>Detail</a>";
                // kembalikkan value variable btn
                return $btn;
            })
            // jika column berisi elemnt html, relasi antar table, memanggil helpers dan melakukan concatenation maka buat kolom-kolom mentah
            ->rawColumns(['action'])
            // buat nyata
            ->make(true);
    }

    // parameter $request berisi semua data yang dikirimkan script seperti nip_karyawan, nama_karyawan dan lain-lain.
    public function simpan_gaji_karyawan(Request $request)
    {
        // tangkap nip_karyawan yang dikirimkan, anggaplah berisi ["20230501", "20230401"]
        // berisi $permintaan->nip_karyawan yg dikirim lewat script
        $nip_karyawan = $request->nip_karyawan;
        $nama_karyawan = $request->nama_karyawan;
        $kode_jabatan = $request->kode_jabatan;
        $kode_status = $request->kode_status;
        $bulan = $request->bulan;

        // simpan gaji sementara dulu
        $detail_gaji = Gaji::create([
            'bulan' => $bulan,
            'total_gaji' => 0
        ]);

        // buat $total_gaji yang awalnya berisi 0, lalu disetiap pengulangan kan ada $detail_gaji_detail, column subtotal_gaji, maka panggil $total_gaji yg isi nya 0, tinggal += $detail_gaji_detail, column subtotal_gaji.
        $total_gaji = 0;

        // lakukan pengulangan
        // selama 0 lebih kecil dari panjang value array nip_karyawan maka lakukan pengulangan, anggaplah ada 2 pengulangan
        for ($i = 0; $i < count($nip_karyawan); $i++) {
            // inisialisasi model GajiDetail
            $detail_gaji_detail = new GajiDetail();
            // table gaji_detail, column gaji_id diisi dengan value $detail_gaji, column gaji_id
            $detail_gaji_detail->gaji_id = $detail_gaji->gaji_id;



            // misalnya column nip_karyawan milik table gaji_detail akan diisi array nip_karyawan, index 0, index 1, dst.
            // column nip_karyawan di table GajiDetail diisi $nip_karyawan[$i]
            $detail_gaji_detail->nip_karyawan = $nip_karyawan[$i];
            $detail_gaji_detail->nama_karyawan = $nama_karyawan[$i];
            // intval mengubah string ke integer
            $detail_gaji_detail->jabatan_id = intval($kode_jabatan[$i]);
            $detail_gaji_detail->kode_status = $kode_status[$i];

            // jika kode_jabatan sama dengan 1 maka 
            if ($kode_jabatan[$i] === "1") {
                $gaji_pokok = 800000; // 800.000

                // jika value kode_status sama dengan "M" maka
                if ($kode_status[$i] === "M") {
                    // tunjangan berisi 200.000
                    $tunjangan = 200000;
                } 
                // lain jika value $kode_status[$i] berisi "S" maka
                else if ($kode_status[$i] === "S") {
                    $tunjangan = 100000; // 100.000
                };
            }
            // lain jika kode_jabatan sama dengan 2 maka
            else if ($kode_jabatan[$i] === "2") {
                $gaji_pokok = 850000; // 850.000

                // jika value kode_status sama dengan "M" maka
                if ($kode_status[$i] === "M") {
                    // tunjangan berisi 250.000
                    $tunjangan = 250000;
                } 
                // lain jika value $kode_status[$i] berisi "S" maka
                else if ($kode_status[$i] === "S") {
                    $tunjangan = 150000; // 150.000
                };
            };

            // column tunjangan diisi value variable $tunjangan
            $detail_gaji_detail->tunjangan = $tunjangan;
            $detail_gaji_detail->subtotal_gaji = $gaji_pokok + $tunjangan;

            // gaji_detail disimpan
            $detail_gaji_detail->save();

            // fitur update total_gaji pada table gaji
            // panggil $detail_gaji, column total_gaji lalu di tambah sama dengan value $detail_gaji_detail, column subtotal_gaji, misalnya 0 + 1.000.000 = 1.000.000 lalu 1.000.000 + 2.500.000 = 3.500.000
            $detail_gaji->total_gaji += $detail_gaji_detail->subtotal_gaji;
            $detail_gaji->update();
        };

        // kembalikkan tanggapan berupa json lalu kirimkan data berupa array
        return response()->json([
            // key status berisi value 200
            'status' => 200,
            'message' => 'Berhasil menyimpan.',
            'data' => $request->all(),
        ]);
    }

    // paramter $gaji_id berisi gaji_id yg dikirimkan di url
    public function detail_gaji($gaji_id)
    {
        // ambil beberapa baris data table gaji_detail berdasarkan column gaji_id
        // GajiDetail dimana value column gaji_id sama dengan parameter $gaji_id, dapatkan beberapa baris data
        $beberapa_gaji_detail = GajiDetail::where('gaji_id', $gaji_id)->get();
        // kembalikkan ke tampilan detail_gaji, kirimkan data berupa array yang berisi beberapa_gaji_detail
        return view('detail_gaji', ['beberapa_gaji_detail' => $beberapa_gaji_detail]);
    }
}
