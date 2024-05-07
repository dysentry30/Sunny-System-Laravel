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
                                <td>Nama Pengguna Jasa</td>
                                <td>{{ $proyek->ProyekBerjalan->Customer->name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>KSO / Non KSO</td>
                                <td>
                                    <p class="m-0">{{ $proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                    </p>
                                    @if ($proyek->PorsiJO->isNotEmpty())
                                        <br>
                                        @foreach ($proyek->PorsiJO as $partner)
                                            <p class="m-0">Nama Partner : {{ $partner->company_jo }} - (Porsi : {{ $partner->porsi_jo }}%)</p>
                                        @endforeach
                                    @endif
                                    <br>
                                    <p class="m-0">Posisi WIKA : {{ (int)$proyek->porsi_jo < 50 ? "Member" : "Leader" }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Lokasi</td>
                                <td>{{ $proyek->Provinsi->province_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>Nilai Penawaran</td>
                                <td>Rp.
                                    {{ number_format($proyek->is_rkap ? $proyek->nilai_rkap : $proyek->nilaiok_awal, 0, '.', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td>Jenis Kontrak</td>
                                <td>{{ $proyek->jenis_terkontrak }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td>Cara Pembayaran</td>
                                <td>{{ $proyek->sistem_bayar ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">8</td>
                                <td>Uang Muka</td>
                                <td>{{ $proyek->is_uang_muka ? "Ya" . "|" . $proyek->uang_muka . "%" : "Tidak" }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">9</td>
                                <td>Waktu Pelaksanaan Pekerjaan</td>
                                <td>{{ $proyek->waktu_pelaksanaan }} Hari</td>
                            </tr>
                            <tr>
                                <td class="text-center">10</td>
                                <td>Pekerjaan Utama</td>
                                <td>{!! $proyek->pekerjaan_utama !!}</td>
                            </tr>
                            <tr>
                                <td class="text-center">11</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->klasifikasi_pasdin }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">12</td>
                                <td>Penanda Tangan</td>
                                <td>{{ $penandatanganSelected->user_id }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">13</td>
                                <td>Jabatan</td>
                                <td>{{ $penandatanganSelected->jabatan }}</td>
                            </tr>
                            <tr>
                                <td class="text-center">14</td>
                                <td>Tanggal Approve</td>
                                <td>{{ $penandatanganSelected->tanggal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->





    <script src="{{ asset('/bootstrap/popper.min.js') }}"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
</body>

</html>
