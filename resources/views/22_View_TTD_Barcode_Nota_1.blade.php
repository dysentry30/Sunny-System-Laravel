<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <title>View Detail Nota Rekomendasi</title>
    <style>
        table thead tr th {
            background-color: #0DB0D9 !important;
            color: white !important;
            padding: 5px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        th.min-w-auto.text-end {
            text-align: center !important;
        }

        th.text-end {
            text-align: center !important;
        }

        table tbody tr td {
            padding: 5px !important;
        }

        table.dataTable {
            border-collapse: collapse !important;
        }

        .content-table table {
            border-collapse: collapse !important;
        }

        table,
        th,
        td,
        tr {
            border: 0.5px solid #333333 !important;
        }

        th a {
            color: white !important;
        }
    </style>
</head>


<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="container d-flex flex-column justify-content-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-bg-dark">
                                <th class="min-w-10px">No</th>
                                <th class="min-w-auto">Item</th>
                                <th class="min-w-auto">Uraian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Nama Proyek</td>
                                <td>{{ $proyek->nama_proyek ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Lokasi Proyek</td>
                                <td>{{ $proyek->Provinsi->province_name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Nama Pengguna Jasa</td>
                                <td>{{ $proyek->ProyekBerjalan->Customer->name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Instansi Pengguna Jasa</td>
                                <td>{{ $proyek->ProyekBerjalan->Customer->jenis_instansi ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>Sumber Pendanaan Proyek</td>
                                <td>{{ $proyek->sumber_dana ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td>Perkiraan Nilai Proyek</td>
                                <td>Rp.
                                    {{ number_format($proyek->is_rkap ? $proyek->nilai_rkap : $proyek->nilaiok_awal, 0, '.', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->klasifikasi_pasdin }}</td>
                            </tr>
                            @if ($kategori != "pengajuan")
                            <tr>
                                <td class="text-center">8</td>
                                <td>Assessment Eksternal Atas Proyek</td>
                                <td>{{ $assessmentEksternal }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">9</td>
                                <td>Assessment Internal Atas Proyek</td>
                                <td>{{ $assessmentInternal }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td>Catatan</td>
                                <td><p class="m-0">{!! nl2br($dataNotaRekomendasi->catatan_nota_rekomendasi) !!}</p></td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-center">{{ $kategori != "pengajuan" ? "11" : "8" }}</td>
                                <td>Penanda Tangan</td>
                                <td>{{ $penandatanganSelected->user_id }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $kategori != "pengajuan" ? "12" : "9" }}</td>
                                <td>Jabatan</td>
                                <td>{{ $penandatanganSelected->jabatan }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $kategori != "pengajuan" ? "13" : "10" }}</td>
                                <td>Tanggal Approve</td>
                                <td>{{ $penandatanganSelected->tanggal }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $kategori != "pengajuan" ? "14" : "11" }}</td>
                                <td>Catatan Approver</td>
                                <td>{!! nl2br($penandatanganSelected->catatan) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->


    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
</body>

</html>
