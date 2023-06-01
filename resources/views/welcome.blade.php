<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Gaji Karyawan</title>

    <!-- bootstrap.min.css -->
    <link rel="stylesheet" href="/bootstrap_5/css/bootstrap.min.css">

    {{-- toastr css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    {{-- datatables css --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- {{-- judul --}} -->
                <h3>Formulir Gaji Karyawan</h3>

                <div class="table-responsive mb-3">
                    <!-- {{-- table --}} -->
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">NIP Karyawan</th>
                                <th scope="col">Nama Karyawan</th>
                                <th scope="col">Kode Jabatan</th>
                                <th scope="col">Kode Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_create_data">
                            <tr>
                                <p style="font-weight: bold">Bulan</p>
                                <input type="month" id="bulan" class="form-control" style="width: 30%">
                            </tr>
                            <tr>
                                <td>
                                    <!-- {{-- aku tidak perlu attribute name jadi aku akan mengambil value-value lewat class --}} -->
                                    <input type="number" class="nip_karyawan form-control">
                                </td>
                                <td>
                                    <input type="text" class="nama_karyawan form-control">
                                </td>
                                <td>
                                    <select class="kode_jabatan form-select">
                                        {{-- #kode_jabatan_1 digunakan untuk memilih kode_jabatan 1 setelah aku berhasil menyimpan gaji karyawan --}}
                                        <option id="kode_jabatan_1" value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="kode_status form-select">
                                        {{-- #kode_status_1 digunakan untuk memilih kode_status 1 setelah aku berhasil menyimpan gaji karyawan --}}
                                        <option id="kode_status_1" value="M">M</option>
                                        <option value="S">S</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- {{-- tombol tambah --}} -->
                    <button class="btn btn-success" id="tambah">+</button>
                    <button id="simpan" type="button" class="btn btn-primary">Simpan</button>

                    {{-- table gaji --}}
                    <table id="table_gaji" class="table table-striped table-bordered table-hover" style="width:100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Total Gaji</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Total Gaji</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- {{-- bootstrap.bundle.min.js --}} -->
    <script src="/bootstrap_5/js/bootstrap.bundle.min.js"></script>
    <!-- {{-- jquery.min.js --}} -->
    <script src="/js/jquery-3.6.4.min.js"></script>
    <!-- {{-- sweetalert 2 --}} -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- toastr js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>

    {{-- datatables js --}}
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- {{-- script --}} -->
    <script>
        // read data gaji
        // panggil #table lalu gunakan datatable
        let table = $("#table_gaji").DataTable({
            // tampilkan processing, sebelum datanya di muat
            processing: true,
            // jika gaji sudah lebih dari 10.000 maka loading nya tidak akan lama karena server side nya true
            serverSide: true,
            // lakukan ajax, panggil route home.read_gaji
            ajax: "{{ route('home.read_gaji') }}",
            // jika selesai dan berhasil maka buat element tbody, tr, td dan isi valuenya
            columns: [
                {
                    // lakukan pengulangan terhadap nomor
                    // data: DT_BarisIndex
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    // dapat_disortir: salah berarti aku menghilangkan icon anak panah agar aku tidak membalik data
                    sortable: false
                },
                // sesuai nama column
                {
                    data: 'bulan',
                    name: 'bulan'
                },
                {
                    data: 'total_gaji',
                    name: 'total_gaji'
                },
                // tombol yg dikirim rawColumns
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    // aku mematikan pencarian column yang  berisi tombol edit, jadi ketika aku mencari edit maka data kosong
                    searchable: false
                }
            ],
        });


        // jadi nanti value nya akan di tambah jika aku menambah baris baru
        // berisi angka 1
        let baris = 1;

        // menambah formulir tambah
        // jika #tambah di click maka jalankan fungsi berikut
        $("#tambah").on("click", function() {
            // jadi nanti value nya akan di tambah jika aku click tombol +
            // panggil variable baris lalu value nya di tambah 1, berarti ada baris1, baris2, dan seterusnya
            baris += 1;
            // jadi nanti akan ada id="baris2", "baris3", dst.
            // .baris_baru aku gunakan agar setelah aku click tombol simpan maka semua data disimpan lalu aku hapus .baris_baru dan turunannya
            var html = `<tr id="baris${baris}" class="baris_baru">`;
            // berisi panggil value variable html lalu isinya ditambah
            // aku tidak perlu attribute name jadi aku akan mengambil value-value lewat class
            html +=
                `<td><input type="text" class="nip_karyawan form-control"></td>`;
            html +=
                `<td><input type="text" class="nama_karyawan form-control"></td>`;
            html +=
                `<td>
                    <select class="kode_jabatan form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </td>`;
            html +=
                `<td>
                    <select class="kode_status form-select">
                        <option value="M">M</option>
                        <option value="S">S</option>
                    </select>
                </td>`;
            // attribute data-rows bersi baris2, baris3, dst.
            html += `<td><button class="hapus btn btn-danger btn-sm" data-row="baris${baris}">-</button></td>`;
            html += "</tr>";

            // panggil element tbody lalu tambahkan value variable html sebagai anak terakhir
            $("#tbody_create_data").append(html);
        });

        // hapus formulir tambah
        // aku perlu $(document) karena tombol hapus nya ditambah setelah aku click tombol + atau tambah
        // jika document di click, yang id nya adalah #hapus maka jalankan fungsi berikut
        $(document).on('click', '.hapus', function() {
            // berisi panggil #hapus lalu panggil value dari attribute data-row nya, anggaplah berisi baris2
            let hapus = $(this).data('row');
            // anggaplah panggil #baris2 lalu hapus
            $('#' + hapus).remove();
        });

        // simpan data
        // jika #simpan di click maka jalankan fungsi berikut
        $("#simpan").on("click", function() {
            // berisi array agar aku bisa menyimpan banyak nip_karyawan
            let nip_karyawan = [];
            let nama_karyawan = [];
            let kode_jabatan = [];
            let kode_status = [];

            // tangkap value input bulan
            let value_dari_input_bulan = $("#bulan").val();
            // jika value dari input bulan sama dengan kosong maka
            if (value_dari_input_bulan === "") {
                // tampilkan peringatan menggunakan sweetalert "
                Swal.fire('Input bulan harus diisi.');
                // harus di return agar kode dibawah tidak berjalan
                return;
            };

            // lakukan pengulangan terhdapat semua .nip_karyawan
            // setiap .nip_karyawan, jalankan fungsi berikut
            $(".nip_karyawan").each(function() {
                // mulai pengulangan
                // berisi panggil value dari .nip_karyawan
                let value_dari_class_nip_karyawan = $(this).val();
                // jika value dari .nip_karyawan sama dengan kosong maka
                if (value_dari_class_nip_karyawan === "") {
                    // tampilkan peringatan menggunakan sweetalert "NIP karyawan barang wajib diisi"
                    Swal.fire('NIP karyawan wajib diisi.');
                    return;
                }
                // contoh NIP Karyawan = 20230525
                // lain jika panjang value dari .nama lebih kecil dari 8
                else if (value_dari_class_nip_karyawan.length < 8) {
                    // tampilkan peringatan menggunakan sweetalert "Nama minimal 8"
                    Swal.fire('NIP karyawan minimal 8.');
                    return;
                }
                // lain jika panjang value_dari_class_nip_karyawan melebihi 8
                else if (value_dari_class_nip_karyawan.length > 8) {
                    // tampilkan peringatan menggunakan sweetalert "Maksimal nama adalah 30 huruf"
                    Swal.fire('Maksimal NIP karyawan adalah 8.');
                    return;
                };

                // panggil array nip_karyawan, dorong setiap value pada .nip_karyawan
                nip_karyawan.push($(this).val());
            });

            // lakukan pengulangan
            // setiap .nama_karyawan, jalankan fungsi berikut
            $(".nama_karyawan").each(function() {
                // mulai pengulangan
                // berisi panggil value dari .nama_karyawan
                let value_dari_class_nama_karyawan = $(this).val();
                // jika value dari .nama_karyawan sama dengan kosong maka
                if (value_dari_class_nama_karyawan === "") {
                    // tampilkan peringatan menggunakan sweetalert "Nama karyawan barang wajib diisi"
                    Swal.fire('Nama karyawan wajib diisi.');
                    return;
                }
                // contoh Nama karyawan = 20230525
                // lain jika panjang value dari .nama lebih kecil dari 3
                else if (value_dari_class_nama_karyawan.length < 3) {
                    // tampilkan peringatan menggunakan sweetalert "Nama minimal 3 huruf"
                    Swal.fire('Nama karyawan minimal 3 huruf.');
                    return;
                }
                // lain jika panjang value_dari_class_nama_karyawan melebihi 50
                else if (value_dari_class_nama_karyawan.length > 50) {
                    // tampilkan peringatan menggunakan sweetalert "Maksimal nama adalah 59 huruf huruf"
                    Swal.fire('Maksimal Nama karyawan adalah 50 huruf.');
                    return;
                };

                // panggil array nama_karyawan, dorong setiap value pada .nama_karyawan
                nama_karyawan.push($(this).val());
            });

            // lakukan pengulangan
            // setiap .kode_jabatan, jalankan fungsi berikut
            $(".kode_jabatan").each(function() {
                // mulai pengulangan
                // berisi panggil value dari .kode_jabatan
                let value_dari_class_kode_jabatan = $(this).val();

                // panggil array kode_jabatan, dorong setiap value pada .kode_jabatan
                kode_jabatan.push($(this).val());
            });

            // lakukan pengulangan
            // setiap .kode_status, jalankan fungsi berikut
            $(".kode_status").each(function() {
                // mulai pengulangan
                // berisi panggil value dari .kode_status
                let value_dari_class_kode_status = $(this).val();

                // panggil array kode_status, dorong setiap value pada .kode_status
                kode_status.push($(this).val());
            });

            // console.log(nip_karyawan, nama_karyawan, kode_jabatan, kode_status);

            // ambil value input #bulan
            let bulan = $("#bulan").val();

            // lakukan ajax untuk mengirim semua value input
            $.ajax({
                // url panggil route gaji_barang.store
                url: "{{ route('home.simpan_gaji_karyawan') }}",
                // tipe memanggil route tipe post / kirim
                type: 'POST',
                // kirimkan aata berupa object
                data: {
                    // key nip_karyawan berisi array nip_karyawan
                    nip_karyawan: nip_karyawan,
                    nama_karyawan: nama_karyawan,
                    kode_jabatan: kode_jabatan,
                    kode_status: kode_status,
                    // key bulan berisi value variable bulan
                    bulan: bulan,
                    // csrf_token untuk mencegah serangan csrf
                    "_token": "{{ csrf_token() }}"
                }
            })
                // jika selesai dan berhasil maka jalankan fungsi berikut
                .done(function(response) {
                    // notifikasi
                    // panggil toastr tipe sukses dan tampilkan pesannya
                    toastr.success(`${response.message}.`);
                    // panggil semua input, lalu value nya dikosongkan
                    $("input").val("");
                    // panggil setiap .baris_baru lalu hapus element dan turunannya 
                    $(".baris_baru").each(function() {
                        // panggil .baris_baru lalu hapus element dan turunannya
                        $(this).remove();
                    });

                    // panggil #kode_jabatan_1 lalu pilih dia
                    // panggil #kode_jabatan_1, menopang dipilih, benar
                    $("#kode_jabatan_1").prop("selected", true);
                    $("#kode_status_1").prop("selected", true);

                    // muat ulang data pada table gaji_detail
                    // table.ajax.muat_ulang
                    table.ajax.reload();

                    // cetak value tanggapan.data
                    // console.log(response.data);
                });
        });
    </script>
</body>

</html>
