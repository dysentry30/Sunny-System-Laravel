<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    {{-- @php
        if ($kategori == "verifikasi_pengajuan_partner") {
            $title = "View Verifikasi Internal Penentuan Proyek KSO / Non KSO";
        } elseif ($kategori == "verifikasi_persetujuan_partner") {
            $title = "Permohonan Persetujuan Pembentukan Kerjasama Operasi (KSO)";
        } else {
            $title = "View Verifikasi Internal Proyek Greenlane/Non Greenlane";
        }
        
    @endphp --}}
    <title>Verifikasi Pengajuan</title>
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
                                <td>1</td>
                                <td>Nama Proyek</td>
                                <td>{{ $proyek->nama_proyek }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama Pengguna Jasa</td>
                                <td>{{ $proyek->proyekBerjalan?->Customer->name }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nilai Penawaran</td>
                                <td>Rp.{{ number_format($proyek->nilaiok_awal, 0, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->klasifikasi_pasdin }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Penandatangan</td>
                                <td>{{ $penandatanganSelected->nip }}</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Jabatan</td>
                                <td>{{ $penandatanganSelected->jabatan }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Tanggal Approve</td>
                                <td>{{ $penandatanganSelected->tanggal }}</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Catatan Approver</td>
                                <td>{{ $penandatanganSelected->catatan ?? "" }}</td>
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
