<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Gaji Karyawan</title>

    <!-- bootstrap.min.css -->
    <link rel="stylesheet" href="/bootstrap_5/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- {{-- judul --}} -->
                <h3>Detail Gaji Karyawan</h3>

                <div class="table-responsive mb-3">
                    {{-- table detail gaji --}}
                    <table class="table table-striped table-bordered table-hover" style="width:100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- lakukan looping terhadap beberapa_gaji_detail --}}
                            {{-- @untuk_setiap($beberapa_gaji_detail sebagai $gaji_detail) --}}
                            @foreach($beberapa_gaji_detail as $gaji_detail)
                            <tr>
                                {{-- cetak $pengulangan->iterasi --}}
                                <td>{{ $loop->iteration }}</td>
                                {{-- cetak value gaji_detail, column nip_karyawan --}}
                                <td>{{ $gaji_detail->nip_karyawan }}</td>
                                <td>{{ $gaji_detail->nama_karyawan }}</td>
                                {{-- table gaji_detail berelasi dengan table jabatan, lalu cetak value column nama_jabatan --}}
                                <td>{{ $gaji_detail->jabatan->nama_jabatan }}</td>
                                {{-- jika value $gaji_detail, column kode_status sama dengan "m" maka --}}
                                @if ($gaji_detail->kode_status === "m")
                                {{-- cetak menikah --}}
                                <td>Menikah</td>
                                {{-- @lain_jika jika value $gaji_detail, column kode_status sama dengan "s" maka --}}
                                @elseif ($gaji_detail->kode_status === "s")
                                {{-- cetak Single --}}
                                <td>Single</td>
                                @endif
                                <td>{{ $gaji_detail->jabatan->gaji_pokok }}</td>
                                <td>{{ $gaji_detail->tunjangan }}</td>
                                <td>{{ $gaji_detail->subtotal_gaji }}</td>
                            </tr>
                            {{-- akhir_untuk_setiap --}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Total Gaji</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- {{-- bootstrap.bundle.min.js --}} -->
    <script src="/bootstrap_5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
