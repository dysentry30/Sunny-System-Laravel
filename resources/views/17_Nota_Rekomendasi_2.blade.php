@extends('template.main')
@section('title', 'Nota Rekomendasi 2')

@section('content')

    <!--Begin::CSS-->
    <style>
        .timeline-centered {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-centered:before,
        .timeline-centered:after {
            content: " ";
            display: table;
        }

        .timeline-centered:after {
            clear: both;
        }

        .timeline-centered:before,
        .timeline-centered:after {
            content: " ";
            display: table;
        }

        .timeline-centered:after {
            clear: both;
        }

        .timeline-centered:before {
            content: '';
            position: absolute;
            display: block;
            width: 4px;
            background: #f5f5f6;
            left: 50%;
            top: 20px;
            bottom: 20px;
            margin-left: -4px;
        }

        .timeline-centered .timeline-entry {
            position: relative;
            width: 50%;
            float: right;
            margin-bottom: 70px;
            clear: both;
        }

        .timeline-centered .timeline-entry:before,
        .timeline-centered .timeline-entry:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry:after {
            clear: both;
        }

        .timeline-centered .timeline-entry:before,
        .timeline-centered .timeline-entry:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry:after {
            clear: both;
        }

        .timeline-centered .timeline-entry.begin {
            margin-bottom: 0;
        }

        .timeline-centered .timeline-entry.left-aligned {
            float: left;
        }

        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner {
            margin-left: 0;
            margin-right: -18px;
        }

        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-time {
            left: auto;
            right: -100px;
            text-align: left;
        }

        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-icon {
            float: right;
        }

        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-content {
            margin-left: 0;
            margin-right: 70px;
        }

        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-content:after {
            left: auto;
            right: 0;
            margin-left: 0;
            margin-right: -9px;
            -moz-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .timeline-centered .timeline-entry .timeline-entry-inner {
            position: relative;
            margin-left: -22px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner:before,
        .timeline-centered .timeline-entry .timeline-entry-inner:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner:after {
            clear: both;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner:before,
        .timeline-centered .timeline-entry .timeline-entry-inner:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner:after {
            clear: both;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time {
            position: absolute;
            left: -100px;
            text-align: right;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span {
            display: block;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:first-child {
            font-size: 15px;
            font-weight: bold;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:last-child {
            font-size: 12px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon {
            background: #fff;
            color: #737881;
            display: block;
            width: 40px;
            height: 40px;
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            text-align: center;
            -moz-box-shadow: 0 0 0 5px #f5f5f6;
            -webkit-box-shadow: 0 0 0 5px #f5f5f6;
            box-shadow: 0 0 0 5px #f5f5f6;
            line-height: 40px;
            font-size: 15px;
            float: left;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-primary {
            background-color: #303641;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-secondary {
            background-color: #ee4749;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-success {
            background-color: #00a651;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-info {
            background-color: #21a9e1;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-warning {
            background-color: #fad839;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-danger {
            background-color: #cc2424;
            color: #fff;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content {
            position: relative;
            background: #f5f5f6;
            padding: 1.7em;
            margin-left: 70px;
            -webkit-background-clip: padding-box;
            -moz-background-clip: padding;
            background-clip: padding-box;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content:after {
            content: '';
            display: block;
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 9px 9px 9px 0;
            border-color: transparent #f5f5f6 transparent transparent;
            left: 0;
            top: 10px;
            margin-left: -9px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2,
        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content p {
            color: #737881;
            font-family: "Noto Sans", sans-serif;
            font-size: 12px;
            margin: 0;
            line-height: 1.428571429;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content p+p {
            margin-top: 15px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 a {
            color: #303641;
        }

        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 span {
            -webkit-opacity: .6;
            -moz-opacity: .6;
            opacity: .6;
            -ms-filter: alpha(opacity=60);
            filter: alpha(opacity=60);
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bd-violet-bg);
            --bs-tooltip-color: var(--bs-white);
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .form-check-input:disabled~.form-check-label,
        .form-check-input[disabled]~.form-check-label {
            opacity: 100 !important;
        }
    </style>
    <!--End::CSS-->


    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Nota Rekomendasi 2
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Page title-->
                        </div>
                        <!--begin::Container-->
                    </div>
                    <!--begin::Toolbar-->
                    <!--begin::Card "style edited"-->
                    <div class="card mx-6" Id="List-vv" style="position: relative; overflow: hidden;">
                        <!--begin::Card header-->
                        <div class="card-header border-0 ps-6 pt-2 mb-0">
                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_proses_paparan"
                                                style="font-size:14px;">Proses Paparan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_prosess_rekomendasi"
                                                style="font-size:14px;">Dalam Proses</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_finish_rekomendasi"
                                                style="font-size:14px;">Proses Selesai</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                    </ul>

                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body px-6 pt-0">
                            <!--Begin :: Tab Content-->
                            <div id="tab-content" class="tab-content">
                                <!--Begin :: Tab Pane - Pengajuan Pemaparan-->
                                <div class="tab-pane fade show active" id="kt_view_proses_paparan" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table display align-middle table-row-dashed fs-6" id="pemaparan-proses">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-250px">Proyek</th>
                                                <th class="min-w-auto">Divisi</th>
                                                <th class="min-w-auto">Departemen</th>
                                                <th class="min-w-50px">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">KSO / Non KSO</th>
                                                <th class="min-w-auto">Jenis Kontrak</th>
                                                <th class="min-w-auto">Sistem Bayar</th>
                                                <th class="min-w-auto">Uang Muka (%)</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Tanggal Pengajuan</th>
                                                <th class="min-w-auto">Tanggal Persetujuan</th>
                                                <th class="min-w-50px">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($proyeks_proses_paparan as $proyek)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                            <td>{{ $proyek->Proyek->UnitKerja->Divisi->nama_kantor }}</td>
                                            <td>{{ $proyek->Proyek->Departemen->nama_departemen }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $proyek->Proyek->is_rkap ? 'badge-light-success' : 'badge-light-warning' }}">{{ $proyek->Proyek->is_rkap ? 'RKAP' : 'Non RKAP' }}</span>
                                            </td>
                                            <td>
                                                <a href="/customer/view/{{ $proyek->Proyek->proyekBerjalan?->customer?->id_customer }}/{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}"
                                                    target="_blank"
                                                    class="text-hover-primary">{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}</a>
                                            </td>
                                            <td class="text-center">
                                                {{ $proyek->Proyek->proyekBerjalan->customer->jenis_instansi }}</td>
                                            <td class="text-center">
                                                {{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                            </td>
                                            <td class="text-center">{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                            <td class="text-center">{{ $proyek->Proyek->sistem_bayar }}</td>
                                            <td class="text-end">
                                                {{ number_format((int) $proyek->Proyek->uang_muka, 0, '', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($proyek->Proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '', '.') }}
                                            </td>
                                            <td class="text-center">{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                            <td class="text-center">{{ !empty($proyek->tanggal_paparan_diajukan) ? \Carbon\Carbon::create($proyek->tanggal_paparan_diajukan)->translatedFormat('d F Y') : '' }}</td>
                                            <td class="text-center">{{ !empty($proyek->tanggal_paparan_disetujui) ? \Carbon\Carbon::create($proyek->tanggal_paparan_disetujui)->translatedFormat('d F Y') : '' }}</td>
                                            <td class="text-center">
                                                @if ($proyek->Proyek->is_cancel)
                                                <p class="badge badge-danger">Cancel</p>                                                    
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($proyek->is_request_paparan)
                                                    @if ($matriks_paparan->contains('kategori', 'Persetujuan') && $matriks_paparan->where('kategori', 'Persetujuan')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first())
                                                        @if (!is_null($proyek->tanggal_paparan_diajukan))
                                                            <a href="#kt_modal_view_req_paparan_setuju_{{ $proyek->kode_proyek }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary text-white">Approve Paparan</a>
                                                        @endif
                                                    @elseif ($matriks_paparan->contains('kategori', 'Pengajuan') && $matriks_paparan->where('kategori', 'Pengajuan')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first())
                                                        @if (is_null($proyek->tanggal_paparan_diajukan))
                                                            <a href="#kt_modal_view_req_paparan_{{ $proyek->kode_proyek }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary text-white">Ajukan Paparan</a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Pengajuan Pemaparan-->
                                <!--Begin :: Tab Pane - Proses Rekomendasi-->
                                <div class="tab-pane fade" id="kt_view_prosess_rekomendasi" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table display align-middle table-row-dashed fs-6" id="rekomendasi-proses">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-250px">Proyek</th>
                                                <th class="min-w-auto">Divisi</th>
                                                <th class="min-w-auto">Departemen</th>
                                                <th class="min-w-50px">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">KSO / Non KSO</th>
                                                <th class="min-w-auto">Jenis Kontrak</th>
                                                <th class="min-w-auto">Sistem Bayar</th>
                                                <th class="min-w-auto">Uang Muka (%)</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Status Form Permohonan NR 2</th>
                                                <th class="min-w-auto" colspan="2">Status NR 2</th>
                                                <th class="min-w-auto">Level Risiko</th>
                                                <th class="min-w-auto">Hasil NR 2</th>
                                                <th class="min-w-50px">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($proyeks_proses_rekomendasi as $proyek)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                                    <td>{{ $proyek->Proyek->UnitKerja->Divisi->nama_kantor }}</td>
                                                    <td>{{ $proyek->Proyek->Departemen->nama_departemen }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge {{ $proyek->Proyek->is_rkap ? 'badge-light-success' : 'badge-light-warning' }}">{{ $proyek->Proyek->is_rkap ? 'RKAP' : 'Non RKAP' }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="/customer/view/{{ $proyek->Proyek->proyekBerjalan?->customer?->id_customer }}/{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}"
                                                            target="_blank"
                                                            class="text-hover-primary">{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $proyek->Proyek->proyekBerjalan->customer->jenis_instansi }}</td>
                                                    <td class="text-center">
                                                        {{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                                    </td>
                                                    <td class="text-center">{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                                    <td class="text-center">{{ $proyek->Proyek->sistem_bayar }}</td>
                                                    <td class="text-end">
                                                        {{ number_format((int) $proyek->Proyek->uang_muka, 0, '', '.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($proyek->Proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '', '.') }}
                                                    </td>
                                                    <td class="text-center">{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                                    <td class="text-center">
                                                        {{ $proyek->is_pengajuan_approved ? 'Sudah Diajukan' : 'Belum Diajukan' }}
                                                    </td>

                                                    <!--Begin::Status NR 2-->
                                                    <td class="text-center">
                                                        @if ($proyek->is_disetujui)
                                                            <small class="badge badge-light-success">
                                                                <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal"
                                                                    class="text-success">Disetujui</a>
                                                            </small>
                                                        @elseif($proyek->is_disetujui == false && !is_null($proyek->is_disetujui))
                                                            <small class="badge badge-light-danger">
                                                                <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal" class="text-danger">Ditolak</a>
                                                            </small>
                                                        @elseif($proyek->is_request_rekomendasi && !$proyek->is_pengajuan_approved)
                                                            <small class="badge badge-light-primary">Proses
                                                                Pengajuan</small>
                                                        @elseif(
                                                            $proyek->is_pengajuan_approved == true &&
                                                                (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                            <small class="badge badge-light-primary">Proses
                                                                Penyusunan</small>
                                                        @elseif(
                                                            !is_null($proyek->is_penyusun_approved) &&
                                                                $proyek->is_penyusun_approved &&
                                                                is_null($proyek->is_verifikasi_approved))
                                                            <small class="badge badge-light-primary">Proses
                                                                Verifikasi</small>
                                                        @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_rekomendasi_approved))
                                                            <small class="badge badge-light-primary">Proses
                                                                Rekomendasi</small>
                                                        @elseif($proyek->is_rekomendasi_approved == true && is_null($proyek->is_disetujui))
                                                            <small class="badge badge-light-primary">Proses
                                                                Penyetujuan</small>
                                                        @endif

                                                        @if ($proyek->is_revisi)
                                                            @php
                                                                $revisi_note = collect(json_decode($proyek->revisi_note))->last();
                                                                $nama_verifikator = \App\Models\User::find($revisi_note->user_id)->name;
                                                            @endphp
                                                            @if (!empty($matriks_user))
                                                                @if (
                                                                    ($matriks_user->contains('kategori', 'Penyusun') &&
                                                                        $matriks_user->where('kategori', 'Penyusun')
                                                                            ?->where('departemen_code', $proyek->Proyek->departemen_proyek)
                                                                            ?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)
                                                                            ?->where('klasifikasi_proyek', $proyek->Proyek->klasifikasi_pasdin)
                                                                            ?->first()) ||
                                                                        ($matriks_user->contains('kategori', 'Verifikasi') &&
                                                                            $matriks_user->where('kategori', 'Verifikasi')
                                                                                ?->where('departemen_code', $proyek->Proyek->departemen_proyek)
                                                                                ?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)
                                                                                ?->where('klasifikasi_proyek', $proyek->Proyek->klasifikasi_pasdin)
                                                                                ?->first()))
                                                                    <button type="button" class="badge badge-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}">Lihat
                                                                        Catatan Revisi</button>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <!--End::Status NR 2-->

                                                    <!--Begin::User Matriks Approval NR 2-->
                                                    <td class="text-center">
                                                        @php
                                                            $style = '';
                                                            $matriks_group = [];

                                                            $matriks_category_array = $matriks_category->toArray();

                                                            if (array_key_exists($proyek->Proyek->klasifikasi_pasdin, $matriks_category_array)) {
                                                                $matriks_klasifikasi = $matriks_category_array[$proyek->Proyek->klasifikasi_pasdin];

                                                                if ($proyek->is_request_rekomendasi && !$proyek->is_pengajuan_approved) {
                                                                    $kategori_approval = 'Pengajuan';
                                                                    if (array_key_exists('Pengajuan', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Pengajuan'][$proyek->Proyek->departemen_proyek])) {
                                                                        $collect_matriks = collect(json_decode($proyek->approved_pengajuan))->keyBy('user_id');
                                                                        $matriks_group = $matriks_klasifikasi['Pengajuan'][$proyek->Proyek->departemen_proyek];
                                                                    } else {
                                                                        $matriks_group = [];
                                                                        $collect_matriks = [];
                                                                    }
                                                                } elseif ($proyek->is_pengajuan_approved == true && is_null($proyek->is_verifikasi_approved) && is_null($proyek->is_penyusun_approved)) {
                                                                    $kategori_approval = 'Penyusun';
                                                                    if (array_key_exists('Penyusun', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Penyusun'][$proyek->Proyek->departemen_proyek])) {
                                                                        $matriks_group = $matriks_klasifikasi['Penyusun'][$proyek->Proyek->departemen_proyek];
                                                                        $collect_matriks = collect(json_decode($proyek->approved_penyusun))->keyBy('user_id');
                                                                    } else {
                                                                        $matriks_group = [];
                                                                    }
                                                                } elseif ($proyek->is_pengajuan_approved == true && $proyek->is_penyusun_approved && is_null($proyek->is_verifikasi_approved)) {
                                                                    $kategori_approval = 'Verifikasi';
                                                                    if (array_key_exists('Verifikasi', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Verifikasi'][$proyek->Proyek->departemen_proyek])) {
                                                                        $matriks_group = $matriks_klasifikasi['Verifikasi'][$proyek->Proyek->departemen_proyek];
                                                                        $collect_matriks = collect(json_decode($proyek->approved_verifikasi))->keyBy('user_id');
                                                                    } else {
                                                                        $matriks_group = [];
                                                                    }
                                                                } elseif ($proyek->is_verifikasi_approved == true && is_null($proyek->is_rekomendasi_approved)) {
                                                                    $kategori_approval = 'Rekomendasi';
                                                                    if (array_key_exists('Rekomendasi', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Rekomendasi'][$proyek->Proyek->departemen_proyek])) {
                                                                        $matriks_group = $matriks_klasifikasi['Rekomendasi'][$proyek->Proyek->departemen_proyek];
                                                                        $collect_matriks = collect(json_decode($proyek->approved_rekomendasi))->keyBy('user_id');
                                                                    } else {
                                                                        $matriks_group = [];
                                                                    }
                                                                } elseif ($proyek->is_rekomendasi_approved == true && is_null($proyek->is_disetujui)) {
                                                                    $kategori_approval = 'Persetujuan';
                                                                    if (array_key_exists('Persetujuan', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Persetujuan'][$proyek->Proyek->departemen_proyek])) {
                                                                        $matriks_group = $matriks_klasifikasi['Persetujuan'][$proyek->Proyek->departemen_proyek];
                                                                        $collect_matriks = collect(json_decode($proyek->approved_persetujuan))->keyBy('user_id');
                                                                    } else {
                                                                        $matriks_group = [];
                                                                    }
                                                                }
                                                            } else {
                                                                $matriks_group = [];
                                                                $collect_matriks = [];
                                                            }
                                                        @endphp

                                                        {{-- @dump($matriks_group) --}}
                                                        <div class="text-center d-flex flex-row gap-2 flex-nowrap">
                                                            @forelse (!empty($matriks_group) ? collect($matriks_group)->sortBy('urutan') : $matriks_group as $key => $matriks)
                                                                @php
                                                                    if (!empty($collect_matriks) && $collect_matriks->isNotEmpty()) {
                                                                        $select_user = $collect_matriks
                                                                            ?->filter(function ($value, $key) use ($matriks, $collect_matriks) {
                                                                                return $key == \App\Models\User::where('nip', '=', $matriks['nama_pegawai'])->first()?->id;
                                                                            })
                                                                            ->first();
                                                                        if (empty($select_user)) {
                                                                            $style = 'bg-secondary text-dark';
                                                                        } else {
                                                                            if ($select_user->status == 'draft') {
                                                                                $style = 'bg-secondary text-dark';
                                                                            } elseif ($select_user->status == 'approved' && empty($select_user->catatan)) {
                                                                                $style = 'bg-success';
                                                                            } elseif ($select_user->status == 'approved' && !empty($select_user->catatan)) {
                                                                                $style = 'bg-warning';
                                                                            } else {
                                                                                $style = 'bg-danger';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $style = 'bg-secondary text-dark';
                                                                    }
                                                                @endphp
                                                                <div class="circle {{ $style }} text-dark text-center"
                                                                    style="height:1.5vw; width:1.5vw; border-radius:50%;">
                                                                    <small
                                                                        style="font-size: 10px">{{ $matriks['kode_unit_kerja'] }}</small>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </td>
                                                    <!--End::User Matriks Approval NR 2-->

                                                    <td class="text-center">
                                                        @php
                                                            $nilaiAssessmentProjectSelection = $proyek->KriteriaProjectSelectionDetail?->sum('nilai') ?? null;
                                                            $style = 'badge-light-dark';
                                                            $text = 'Belum Ditentukan';
                                                            if (!empty($nilaiAssessmentProjectSelection)) {
                                                                $text =
                                                                    App\Models\PenilaianChecklistProjectSelection::all()
                                                                        ->filter(function ($item) use ($nilaiAssessmentProjectSelection) {
                                                                            return $item->dari_nilai <= $nilaiAssessmentProjectSelection && $item->sampai_nilai >= $nilaiAssessmentProjectSelection;
                                                                        })
                                                                        ->first()->nama ?? '-';
                                                                switch ($text) {
                                                                    case 'Risiko Rendah':
                                                                        $style = 'badge-light-success';
                                                                        break;
                                                                    case 'Risiko Tinggi':
                                                                        $style = 'badge-light-warning';
                                                                        break;
                                                                    case 'Risiko Moderat':
                                                                        $style = 'badge-warning';
                                                                        break;
                                                                    case 'Risiko Ekstrem':
                                                                        $style = 'badge-danger';
                                                                        break;

                                                                    default:
                                                                        $style = '';
                                                                        break;
                                                                }
                                                            }
                                                        @endphp
                                                        <small class="badge {{ $style }}">
                                                            {{ $text }}
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            if (!empty($proyek->approved_rekomendasi)) {
                                                                $check_data = collect(json_decode($proyek->approved_rekomendasi));
                                                                if (!is_null($proyek->is_rekomendasi_approved) && !$proyek->is_rekomendasi_approved) {
                                                                    $status_rekomendasi = 'Tidak Direkomendasikan';
                                                                    $style = 'badge-light-danger';
                                                                } elseif ($check_data->where('catatan', '!=', null)->count() > 0) {
                                                                    $status_rekomendasi = 'Direkomendasikan dengan catatan';
                                                                    $style = 'badge-light-warning';
                                                                } else {
                                                                    $status_rekomendasi = 'Direkomendasikan';
                                                                    $style = 'badge-light-success';
                                                                }
                                                            } else {
                                                                $status_rekomendasi = '-';
                                                                $style = 'badge-light-secondary';
                                                            }
                                                        @endphp
                                                        <small>
                                                            <p class="badge {{ $style }} m-0">
                                                                {{ $status_rekomendasi }}</p>
                                                        </small>
                                                    </td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center">
                                                    @if ($is_user_exist_in_matriks_approval)
                                                        @if ($matriks_user->contains('kategori', 'Persetujuan')  && $matriks_user->where('kategori', 'Persetujuan')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() && $proyek->is_rekomendasi_approved)
                                                            <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                target="_blank" data-bs-toggle="modal"
                                                                {{-- onclick="showModal('{{ $proyek->kode_proyek }}')" --}}
                                                                class="btn btn-sm btn-primary text-white">{{ $proyek->is_disetujui || (collect(json_decode($proyek->approved_persetujuan))->contains('user_id', auth()->user()->id) && collect(json_decode($proyek->approved_persetujuan))?->first()?->status == 'approved') ? "Rincian" : "Approve" }}</a>
                                                        @elseif($matriks_user->contains('kategori', 'Rekomendasi') && $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() && $proyek->is_verifikasi_approved)
                                                            <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                target="_blank" data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary text-white">{{ $proyek->is_rekomendasi_approved || (collect(json_decode($proyek->approved_rekomendasi))->contains('user_id', auth()->user()->id) && collect(json_decode($proyek->approved_rekomendasi))?->first()?->status == 'approved') ? "Rincian" : "Rekomendasikan" }}</a>
                                                        @elseif($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() && $proyek->is_penyusun_approved)
                                                            @if ($proyek->is_request_rekomendasi || (($matriks_user->filter(function($value)use($proyek){
                                                                return $value->divisi_id == $proyek->Proyek->UnitKerja->Divisi->id_divisi &&
                                                                $value->klasifikasi_proyek == $proyek->Proyek->klasifikasi_pasdin &&
                                                                $value->departemen_code == $proyek->Proyek->departemen_proyek &&
                                                                $value->kategori == "Verifikasi" &&
                                                                $value->urutan > 1;
                                                            })->count() > 0 && (collect(json_decode($proyek->approved_verifikasi))->isEmpty()))))
                                                            
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-primary text-white" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_verifikasi_{{ $proyek->kode_proyek }}">
                                                                    {{ $proyek->is_verifikasi_approved || (collect(json_decode($proyek->approved_verifikasi))->contains('user_id', auth()->user()->id) && collect(json_decode($proyek->approved_verifikasi))?->first()?->status == 'approved') ? "Rincian" : "Verifikasi" }}
                                                                </button>
                                                                {{-- <a href="#kt_modal_view_proyek_verifikasi_{{ $proyek->kode_proyek }}"
                                                                    target="_blank" data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-primary text-white">{{ $proyek->is_verifikasi_approved || (collect(json_decode($proyek->approved_verifikasi))->contains('user_id', auth()->user()->id) && collect(json_decode($proyek->approved_verifikasi))?->first()?->status == 'approved') ? "Rincian" : "Verifikasi" }}</a> --}}
                                                            @endif
                                                        @elseif ($matriks_user->contains('kategori', 'Penyusun') && $matriks_user->where('kategori', 'Penyusun')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first())
                                                            @if ($proyek->is_request_rekomendasi || is_null($proyek->is_sudah_pemaparan) ||(($matriks_user->filter(function($value)use($proyek){
                                                                return $value->divisi_id == $proyek->Proyek->UnitKerja->Divisi->id_divisi &&
                                                                $value->klasifikasi_proyek == $proyek->Proyek->klasifikasi_pasdin &&
                                                                $value->departemen_code == $proyek->Proyek->departemen_proyek &&
                                                                $value->kategori == "Penyusun" &&
                                                                $value->urutan > 1;
                                                            })->count() > 0 && (collect(json_decode($proyek->approved_penyusun))->isEmpty() || collect(json_decode($proyek->approved_penyusun))->contains('status', 'draft')))))

                                                            @elseif ($proyek->KriteriaProjectSelectionDetail->count() >= $kriteriaAssessmentProjectSelection->count())
                                                                <a href="#kt_modal_view_proyek_penyusun_{{ $proyek->kode_proyek }}"
                                                                    target="_blank" data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-primary text-white">{{ $proyek->is_penyusun_approved || (collect(json_decode($proyek->approved_penyusun))?->first()?->user_id == auth()->user()->id) && (collect(json_decode($proyek->approved_penyusun))?->first()?->status == 'approved') ? "Rincian" : "Submit" }}</a>
                                                            @elseif ($proyek->is_pengajuan_approved)
                                                                @if (is_null($proyek->is_sudah_pemaparan))
                                                                    {{-- <a href="#kt_modal_view_pemaparan_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal"
                                                                        class="btn btn-sm btn-primary text-white">Isi Pemaparan</a> --}}
                                                                @else
                                                                    <a href="#kt_user_modal_assessment_{{ $proyek->kode_proyek }}"
                                                                        target="_blank" data-bs-toggle="modal"
                                                                        class="btn btn-sm btn-primary text-white">Isi Kriteria Risiko</a>
                                                                @endif
                                                            @endif
                                                        @elseif ($matriks_user->contains('kategori', 'Pengajuan') && $matriks_user->where('kategori', 'Pengajuan')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first())
                                                            @if (!empty($proyek->approved_pengajuan) && !is_null($proyek->approved_pengajuan))
                                                                <a href="#kt_modal_view_pengajuan_{{ $proyek->kode_proyek }}"
                                                                    target="_blank" data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-primary text-white">Lihat Detail</a>
                                                            @else
                                                                <a href="#kt_modal_view_pengajuan_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal"
                                                                    class="btn btn-sm btn-primary text-white">Ajukan</a>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a href="#kt_modal_view_pengajuan_{{ $proyek->kode_proyek }}"
                                                            target="_blank" data-bs-toggle="modal"
                                                            class="btn btn-sm btn-primary text-white">Lihat Detail</a>
                                                    @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                                <!--End :: Tab Pane - Proses Rekomendasi-->


                                <!--Begin :: Tab Pane - Finish Rekomendasi-->
                                <div class="tab-pane fade show" id="kt_view_finish_rekomendasi" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table display align-middle table-row-dashed fs-6"
                                        id="rekomendasi-finish">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-250px">Proyek</th>
                                                <th class="min-w-auto">Divisi</th>
                                                <th class="min-w-auto">Departemen</th>
                                                <th class="min-w-50px">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">KSO / Non KSO</th>
                                                <th class="min-w-auto">Jenis Kontrak</th>
                                                <th class="min-w-auto">Sistem Bayar</th>
                                                <th class="min-w-auto">Uang Muka (%)</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Status Form Permohonan NR 2</th>
                                                <th class="min-w-auto" colspan="2">Status NR 2</th>
                                                <th class="min-w-auto">Level Risiko</th>
                                                <th class="min-w-auto">Hasil NR 2</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($proyeks_rekomendasi_final as $proyek)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                                    <td>{{ $proyek->Proyek->UnitKerja->Divisi->nama_kantor }}</td>
                                                    <td>{{ $proyek->Proyek->Departemen->nama_departemen }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge {{ $proyek->Proyek->is_rkap ? 'badge-light-success' : 'badge-light-warning' }}">{{ $proyek->Proyek->is_rkap ? 'RKAP' : 'Non RKAP' }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="/customer/view/{{ $proyek->Proyek->proyekBerjalan?->customer?->id_customer }}/{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}"
                                                            target="_blank"
                                                            class="text-hover-primary">{{ $proyek->Proyek->proyekBerjalan?->customer?->name }}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $proyek->Proyek->proyekBerjalan->customer->jenis_instansi }}</td>
                                                    <td class="text-center">
                                                        {{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                                    </td>
                                                    <td class="text-center">{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                                    <td class="text-center">{{ $proyek->Proyek->sistem_bayar }}</td>
                                                    <td class="text-end">
                                                        {{ number_format((int) $proyek->Proyek->uang_muka, 0, '', '.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($proyek->Proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '', '.') }}
                                                    </td>
                                                    <td class="text-center">{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                                    <td class="text-center">
                                                        {{ $proyek->is_pengajuan_approved ? 'Sudah Diajukan' : 'Belum Diajukan' }}
                                                    </td>

                                                    <!--Begin::Status NR 2-->
                                                    <td class="text-center">
                                                        @if ($proyek->is_disetujui)
                                                            <small class="badge badge-light-success">
                                                                <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal"
                                                                    class="text-success">Disetujui</a>
                                                            </small>
                                                        @elseif($proyek->is_disetujui == false && !is_null($proyek->is_disetujui))
                                                            <small class="badge badge-light-danger">
                                                                <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal" class="text-danger">Ditolak</a>
                                                            </small>
                                                        @elseif($proyek->is_request_rekomendasi && !$proyek->is_pengajuan_approved)
                                                            <small class="badge badge-light-primary">Proses
                                                                Pengajuan</small>
                                                        @elseif(
                                                            $proyek->is_pengajuan_approved == true &&
                                                                (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                            <small class="badge badge-light-primary">Proses
                                                                Penyusunan</small>
                                                        @elseif(
                                                            !is_null($proyek->is_penyusun_approved) &&
                                                                $proyek->is_penyusun_approved &&
                                                                is_null($proyek->is_verifikasi_approved))
                                                            <small class="badge badge-light-primary">Proses
                                                                Verifikasi</small>
                                                        @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_rekomendasi_approved))
                                                            <small class="badge badge-light-primary">Proses
                                                                Rekomendasi</small>
                                                        @elseif($proyek->is_rekomendasi_approved == true && is_null($proyek->is_disetujui))
                                                            <small class="badge badge-light-primary">Proses
                                                                Penyetujuan</small>
                                                        @endif

                                                        @if ($proyek->is_revisi)
                                                            @php
                                                                $revisi_note = collect(json_decode($proyek->revisi_note))->last();
                                                                $nama_verifikator = \App\Models\User::find($revisi_note->user_id)->name;
                                                            @endphp
                                                            @if (!empty($matriks_user))
                                                                @if (
                                                                    ($matriks_user->contains('kategori', 'Penyusun') &&
                                                                        $matriks_user->where('kategori', 'Penyusun')
                                                                            ?->where('departemen_code', $proyek->Proyek->departemen_proyek)
                                                                            ?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)
                                                                            ?->where('klasifikasi_proyek', $proyek->Proyek->klasifikasi_pasdin)
                                                                            ?->first()) ||
                                                                        ($matriks_user->contains('kategori', 'Verifikasi') &&
                                                                            $matriks_user->where('kategori', 'Verifikasi')
                                                                                ?->where('departemen_code', $proyek->Proyek->departemen_proyek)
                                                                                ?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)
                                                                                ?->where('klasifikasi_proyek', $proyek->Proyek->klasifikasi_pasdin)
                                                                                ?->first()))
                                                                    <button type="button" class="badge badge-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}">Lihat
                                                                        Catatan Revisi</button>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <!--End::Status NR 2-->

                                                    <!--Begin::User Matriks Approval NR 2-->
                                                    <td class="text-center">
                                                        <div class="circle bg-success"
                                                            style="height:25px; width:25px; border-radius:50%;">
                                                            <small><a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                data-bs-toggle="modal"
                                                                class="text-success">Klik</a></small>
                                                        </div>                                                        
                                                    </td>
                                                    <!--End::User Matriks Approval NR 2-->

                                                    <td class="text-center">
                                                        @php
                                                            $nilaiAssessmentProjectSelection = $proyek->KriteriaProjectSelectionDetail?->sum('nilai') ?? null;
                                                            $style = 'badge-light-dark';
                                                            $text = 'Belum Ditentukan';
                                                            if (!empty($nilaiAssessmentProjectSelection)) {
                                                                $text =
                                                                    App\Models\PenilaianChecklistProjectSelection::all()
                                                                        ->filter(function ($item) use ($nilaiAssessmentProjectSelection) {
                                                                            return $item->dari_nilai <= $nilaiAssessmentProjectSelection && $item->sampai_nilai > $nilaiAssessmentProjectSelection;
                                                                        })
                                                                        ->first()->nama ?? '-';
                                                                switch ($text) {
                                                                    case 'Risiko Rendah':
                                                                        $style = 'badge-light-success';
                                                                        break;
                                                                    case 'Risiko Tinggi':
                                                                        $style = 'badge-light-warning';
                                                                        break;
                                                                    case 'Risiko Moderat':
                                                                        $style = 'badge-warning';
                                                                        break;
                                                                    case 'Risiko Ekstrem':
                                                                        $style = 'badge-danger';
                                                                        break;

                                                                    default:
                                                                        $style = '';
                                                                        break;
                                                                }
                                                            }
                                                        @endphp
                                                        <small class="badge {{ $style }}">
                                                            {{ $text }}
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            if (!empty($proyek->approved_rekomendasi)) {
                                                                $check_data = collect(json_decode($proyek->approved_rekomendasi));
                                                                if (!is_null($proyek->is_rekomendasi_approved) && !$proyek->is_rekomendasi_approved) {
                                                                    $status_rekomendasi = 'Tidak Direkomendasikan';
                                                                    $style = 'badge-light-danger';
                                                                } elseif ($check_data->where('catatan', '!=', null)->count() > 0) {
                                                                    $status_rekomendasi = 'Direkomendasikan dengan catatan';
                                                                    $style = 'badge-light-warning';
                                                                } else {
                                                                    $status_rekomendasi = 'Direkomendasikan';
                                                                    $style = 'badge-light-success';
                                                                }
                                                            } else {
                                                                $status_rekomendasi = '-';
                                                                $style = 'badge-light-secondary';
                                                            }
                                                        @endphp
                                                        <small>
                                                            <p class="badge {{ $style }} m-0">
                                                                {{ $status_rekomendasi }}</p>
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="d-flex flex-row justify-content-between">
                                                            <br>
                                                            @if (($matriks_user?->contains('kategori', 'Pengajuan') && $matriks_user?->where('kategori', 'Pengajuan')?->where('departemen', $proyek->Proyek->departemen_proyek)?->where('unit_kerja', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first()) ||
                                                            ($matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->Proyek->departemen_proyek)?->where('unit_kerja', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->where('urutan', '>', 1)?->first())
                                                            )
                                                                
                                                            @else
                                                                @if (empty($proyek->file_persetujuan))
                                                                <button type="button" class="btn btn-primary p-2" onclick="generateFile('{{ $proyek->kode_proyek }}')">
                                                                    Generate
                                                                </button>  
                                                                @else
                                                                <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}">
                                                                    View
                                                                </button>
                                                                @endif
                                                            @endif
                                                            {{-- <a href="#kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}" class="btn btn-sm btn-primary text-white" data-bs-toggle="model">Download</a> --}}
                                                        </small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                                <!--End :: Tab Pane - Finish Rekomendasi-->
                            </div>
                            <!--Begin :: Tab Content-->

                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--end::Card "style edited"-->
                </div>
                <!--begin::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--begin::Page-->
    </div>
    <!--begin::Root-->

    <!--End::Modal Proses Paparan-->
    @foreach ($proyeks_proses_paparan as $proyek)
    <!--Begin::Pengajuan Paparan-->
    <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/paparan" method="post" enctype="multipart/form-data">
    @csrf
        <div class="modal fade" id="kt_modal_view_req_paparan_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_req_paparan_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pengajuan Paparan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            <input type="hidden" name="kategori" value="Pengajuan">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Tanggal Pengajuan: </span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-pengajuan-paparan" name="tanggal-pengajuan-paparan"
                                    value=""
                                    placeholder="Date" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3" for="file-notulensi" required>File Notulensi</label>
                                <input type="file" class="form-control form-control-solid" name="file-pemaparan[]" multiple accept=".pdf">
                             </div>
                             <!--end::Input group-->
                             <!--begin::Input group-->
                             <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3" for="file-notulensi" required>File Daftar Hadir</label>
                                <input type="file" class="form-control form-control-solid" name="file-absensi-paparan[]" multiple accept=".pdf">
                             </div>
                             <!--end::Input group-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>    
    </form>
    <!--End::Pengajuan Paparan-->

    <!--Begin::Persetujuan Paparan-->
    <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/paparan" method="post">
    @csrf
        <div class="modal fade" id="kt_modal_view_req_paparan_setuju_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_req_paparan_setuju_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Persetujuan Paparan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            <input type="hidden" name="kategori" value="Persetujuan">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Tanggal Persetujuan: </span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-persetujuan-paparan" name="tanggal-persetujuan-paparan"
                                    value="{{ $proyek->tanggal_paparan_diajukan }}"
                                    placeholder="Date" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>    
    </form>
    <!--End::Persetujuan Paparan-->
    @endforeach
    <!--End::Modal Proses Paparan-->

    <!--Begin::Modal Proses Rekomendasi-->
    @foreach ($proyeks_proses_rekomendasi as $proyek)

    <!--Begin::Form Proses Pengajuan-->
    <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/pengajuan" method="post" id="pengajuan-form">
        @csrf
        <div class="modal fade" id="kt_modal_view_pengajuan_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_pengajuan_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p class="p-1">Pengajuan Rekomendasi Seleksi Proyek Non Green Lane</p>
                        </b>
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-bg-dark">
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nama Proyek</td>
                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->Proyek->proyekBerjalan->customer->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KSO / Non KSO</td>
                                    <td>
                                        <p class="m-0">{{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                        </p>
                                        @if ($proyek->Proyek->PorsiJO->isNotEmpty())
                                            <br>
                                            @foreach ($proyek->Proyek->PorsiJO as $partner)
                                                <p class="m-0">Nama Partner : {{ $partner->company_jo }}</p>
                                                <p class="m-0">WIKA : {{ (int)$partner->porsi_jo < (int)$proyek->Proyek->porsi_jo ? "Leader" : "Member" }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Lokasi</td>
                                    <td>{{ $proyek->Proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Nilai Penawaran</td>
                                    <td>Rp.
                                        {{ number_format($proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '.', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jenis Kontrak</td>
                                    <td>{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Cara Pembayaran</td>
                                    <td>{{ $proyek->Proyek->sistem_bayar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Uang Muka</td>
                                    <td>{{ $proyek->Proyek->is_uang_muka ? "Ya" . "|" . $proyek->Proyek->uang_muka . "%" : "Tidak" }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Waktu Pelaksanaan Pekerjaan</td>
                                    <td>{{ $proyek->Proyek->waktu_pelaksanaan }} Hari</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Pekerjaan Utama</td>
                                    <td>{!! $proyek->Proyek->pekerjaan_utama !!}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if (!empty($proyek->file_pengajuan))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-nota-rekomendasi-2\\file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @php
                            $approved_data = collect([json_decode($proyek->approved_pengajuan)])->flatten();
                            $is_data_null = $approved_data->every(function ($d) {
                                return $d == null;
                            });
                            $is_user_id_exist = $approved_data
                                ->map(function ($d) {
                                    if (!empty($d) && $d->user_id == Auth::user()->id) {
                                        $new_class = new stdClass();
                                        $new_class->user_id = $d->user_id;
                                        $new_class->status = $d->status;
                                        return $new_class;
                                    }
                                })
                                ->firstWhere('user_id', '!=', null);
                            if ($is_data_null) {
                                $approved_data = collect();
                            }
                        @endphp
                        @if ($is_user_exist_in_matriks_approval)
                            @if (is_null($proyek->is_pengajuan_approved) && empty($proyek->is_pengajuan_approved))
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <input type="button" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_view_proyek_tolak_pengajuan_{{ $proyek->kode_proyek }}"
                                    name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                                <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                            @elseif(!empty($is_user_id_exist))
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="kt_modal_view_proyek_tolak_pengajuan_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_tolak_pengajuan_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <form action="" method="get">
                    <div class="modal-header">
                        <h5 class="modal-title">Alasan Ditolak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            <textarea name="alasan-ditolak" form="pengajuan-form" class="form-control form-control-solid" id="alasan-ditolak" cols="1"
                                rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="tolak" form="pengajuan-form" class="btn btn-sm btn-danger"
                            value="Ditolak dengan alasan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Form Proses Pengajuan-->
    
    {{-- @cannot('super-admin') --}}


    <!--Begin::Form Confirm Pemaparan-->
    <div class="modal fade" id="kt_modal_view_pemaparan_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_pemaparan_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/pemaparan" method="POST">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Apakah sudah melakukan pemaparan ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- <div class="modal-body">
                        <div class="">
                            <select id="is-pemaparan" name="is-pemaparan"
                                class="form-select form-select-solid w-auto" style="margin-right: 2rem;"
                                data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                data-select2-id="select2-data-is-pemaparan" tabindex="-1"
                                aria-hidden="true">
                                <option value=""></option>
                                <option value="Sudah Pemaparan">Sudah Pemaparan</option>
                                <option value="Belum Pemaparan">Belum Pemaparan</option>
                            </select>
                            <br>
                        </div>
                    </div> --}}
                    <div class="modal-footer row">
                        <div class="d-flex flex-row-reverse gap-2">
                            <input type="submit" value="Sudah" class="btn btn-sm btn-primary" name="sudah_pemaparan">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Belum</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Form Confirm Pemaparan-->

    <!--Begin::Create Form Proses Assessment Penyusun-->
    <form action="/nota-rekomendasi-2/assessment-project-selection/detail/save" method="POST" id="form-kriteria-{{ $proyek->kode_proyek }}"
        enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
        @csrf
        <div class="modal fade" id="kt_user_modal_assessment_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Form Assessment Project Selection</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-lg"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
                        <input type="hidden" name="modal"
                            value="#kt_user_modal_assessment_{{ $proyek->kode_proyek }}">
                        <div class="row fv-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="min-w-auto" rowspan="2">No</th>
                                        <th class="min-w-250px" rowspan="2">Parameter</th>
                                        <th class="min-w-auto" rowspan="2">Bobot</th>
                                        <th class="min-w-300px" colspan="2">Checklist Kriteria</th>
                                        <th class="min-w-auto" rowspan="2">Score</th>
                                        <th class="min-w-auto" rowspan="2">Keterangan</th>
                                        <th class="min-w-auto" rowspan="2">Upload Dokumen</th>
                                    </tr>
                                    <tr>
                                        <th class="min-w-auto">Ya</th>
                                        <th class="min-w-auto">Tidak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($kriteriaAssessmentProjectSelection as $key => $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->parameter }}</td>
                                            <td class="text-center">
                                                <p>{{ $item->bobot }}</p>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex flex-column align-items-center justify-content-center" id="kriteria">
                                                    <input class="form-check-input" type="radio"
                                                        name="is_kriteria_{{ $key + 1 }}"
                                                        id="is_kriteria_{{ $key }}_1"
                                                        onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 1 }}', '{{ $key }}')"
                                                        value="1">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex flex-column align-items-center justify-content-center" id="kriteria">
                                                    <input class="form-check-input" type="radio"
                                                        name="is_kriteria_{{ $key + 1 }}"
                                                        id="is_kriteria_{{ $key }}_2"
                                                        onchange="setNilaiKriteria(this, 0, '{{ $key }}')"
                                                        value="2">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" name="nilai[]"
                                                    class="form-control form-control-solid"
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}"
                                                    id="nilai_{{ $key }}" readonly>
                                            </td>
                                            <td>
                                                <textarea name="keterangan[]" form="form-kriteria-{{ $proyek->kode_proyek }}" id="" cols="40"
                                                    rows="10"></textarea>
                                            </td>
                                            <td>
                                                <input type="file" name="dokumen_kriteria_{{ $key + 1 }}[]"
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}"
                                                    id="dokumen_kriteria"
                                                    multiple
                                                    accept=".pdf"
                                                    onchange="checkSizeFile(this, '{{ $proyek->kode_proyek }}', {{ $key+1 }}, 'save-{{ $proyek->kode_proyek }}-new')"
                                                    class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none" id="alert-file-{{ $proyek->kode_proyek }}-{{ $key+1 }}">Total ukuran file max 20MB. Periksa kembali!</small>
                                            </td>
                                            <td class="d-none">
                                                <input type="hidden" name="index[]" value="{{ $key + 1 }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" name="kode_proyek" value="{{ $proyek->kode_proyek }}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            form="form-kriteria-{{ $proyek->kode_proyek }}" id="save-{{ $proyek->kode_proyek }}-new"
                            style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--End::Create Form Proses Assessment Penyusun-->
    
    
    <!--Begin::Edit Form Proses Assessment Penyusun-->
    @php
        $approved_penyusun_1 = collect(json_decode($proyek->approved_penyusun));
        // $is_edit = !$proyek->is_request_rekomendasi && is_null($proyek->is_verifikasi_approved) && ((!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) || is_null($proyek->is_draft_recommend_note) && $matriks_user?->contains('kategori', 'Penyusun')) && !$approved_penyusun_1->contains('status', 'approved');
        $is_edit = !$proyek->is_request_rekomendasi && is_null($proyek->is_penyusun_approved) && ((!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) || is_null($proyek->is_draft_recommend_note) && $matriks_user?->contains('kategori', 'Penyusun')) && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->Proyek->departemen_proyek)?->where('unit_kerja', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin) && !$approved_penyusun_1->contains('status', 'approved');
        $kriteriaDetails = $kriteriaAssessmentProjectSelectionDetail->where('kode_proyek', $proyek->kode_proyek)
            ->sortBy('index')
            ->unique('index')
            ->keyBy('index');
    @endphp 
    {{-- @if ($is_edit) --}}
        <form action="/nota-rekomendasi-2/assessment-project-selection/detail/edit" method="POST"
            id="form-edit-kriteria-{{ $proyek->kode_proyek }}" enctype="multipart/form-data">
    {{-- @endif --}}
    @csrf
    <div class="modal fade" id="kt_user_edit_kriteria_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Form Kriteria Assessment Project Selection</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">
                    <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}">
                    <div class="row fv-row">
                        <table>
                            <thead>
                                <tr>
                                    <th class="min-w-auto" rowspan="2">No.</th>
                                    <th class="min-w-250px" rowspan="2">Parameter</th>
                                    <th class="min-w-auto" rowspan="2">Bobot</th>
                                    <th class="min-w-300px" colspan="2">Checklist Kriteria</th>
                                    <th class="min-w-auto" rowspan="2">Score</th>
                                    <th class="min-w-auto" rowspan="2">Keterangan</th>
                                    <th class="min-w-auto" rowspan="2">Upload Dokumen</th>
                                </tr>
                                <tr>
                                    <th class="min-w-auto">Ya</th>
                                    <th class="min-w-auto">Tidak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($kriteriaAssessmentProjectSelection as $keys => $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->parameter }}</td>
                                        <td class="text-center">
                                            <p>{{ $item->bobot }}</p>
                                        </td>
                                        <td>
                                            <div class="form-check" id="kriteria">
                                                <input class="form-check-input" type="radio"
                                                    name="is_kriteria_{{ $keys + 1 }}"
                                                    id="is_kriteria_{{ $keys }}_1"
                                                    onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 1 }}', '{{ $keys }}')"
                                                    value="1"
                                                    {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys]->is_true == true ? 'checked' : '' }}
                                                    {{ $is_edit ? '' : 'disabled' }}>
                                                <label for="is_kriteria_{{ $keys }}_1"
                                                    class="form-check-label">
                                                    {!! nl2br($item->kriteria_1) !!}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check" id="kriteria">
                                                <input class="form-check-input" type="radio"
                                                    name="is_kriteria_{{ $keys + 1 }}"
                                                    id="is_kriteria_{{ $keys }}_2"
                                                    onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 2 }}', '{{ $keys }}')"
                                                    value="2"
                                                    {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys]->is_true == false ? 'checked' : '' }}
                                                    {{ $is_edit ? '' : 'disabled' }}>
                                                <label for="is_kriteria_{{ $keys }}_2"
                                                    class="form-check-label">
                                                    {!! nl2br($item->kriteria_2) !!}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="nilai[]"
                                                class="form-control form-control-solid"
                                                form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                value="{{ $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys]->nilai : 0 }}"
                                                id="nilai_{{ $keys }}" readonly
                                                {{ $is_edit ? '' : 'disabled' }}>
                                        </td>
                                        <td>
                                            <textarea name="keterangan[]" form="form-edit-kriteria-{{ $proyek->kode_proyek }}" id="" cols="40"
                                                rows="10" {{ $is_edit ? '' : 'disabled' }}>{!! $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys]->keterangan : '' !!}</textarea>
                                        </td>

                                        <td class="text-start">
                                            @if (
                                                $matriks_user?->contains('kategori', 'Rekomendasi') &&
                                                    (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                                                {{-- <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$keys]->id_document) : '' }}"
                                                    class="text-hover-primary">{{ $kriteriaDetails[$keys]->id_document }}</a> --}}
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Document</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $id = $kriteriaDetails[$keys]->id;
                                                                $files = json_decode($kriteriaDetails[$keys]->id_document);
                                                                $files = (is_array($files) && count($files)) > 0 ? $files : [];
                                                                // dd($files);
                                                            @endphp
                                                            @if (!empty($files))
                                                                @foreach ($files as $file_index => $file)
                                                                    {{-- @dd($id, $file_index, $file) --}}
                                                                    <tr>
                                                                        <td>
                                                                            <small>
                                                                                {{-- <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $file) : '' }}" --}}
                                                                                <a href="{{ asset('file-kriteria-pengguna-jasa' . '\\' . $file) }}"
                                                                                    class="text-hover-primary">{{ $file }}</a>
                                                                            </small>
                                                                        </td>
                                                                        <form action=""></form>
                                                                        <form action="/nota-rekomendasi-2/assessment-project-selection/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="id" id="id" value="{{$id}}">
                                                                            <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="file-name" id="file-name" value="{{$file}}">
                                                                            <td class="text-center">
                                                                                <button type="submit" form="delete-file-{{$id}}-{{$file_index + 1}}" class="btn btn-sm btn-outline-danger text-hover-white {{ $is_edit ? "" : "disabled" }}">
                                                                                    <i class="bi bi-trash3-fill text-danger"></i>
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                            @else
                                            @if ($is_edit)
                                                <input type="file" name="dokumen_kriteria_{{$keys + 1}}[]"
                                                    form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                    id="dokumen_kriteria"
                                                    multiple
                                                    class="form-control form-control-sm form-control-solid"
                                                    {{ $is_edit ? '' : 'disabled' }}>
                                            @endif
                                                    
                                                @if ($kriteriaDetails->isNotEmpty())
                                                    <br>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Document</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $id = $kriteriaDetails[$keys]->id;
                                                                $files = json_decode($kriteriaDetails[$keys]->id_document);
                                                                $files = (is_array($files) && count($files)) > 0 ? $files : [];
                                                                // dd($files);
                                                            @endphp
                                                            @if (!empty($files))
                                                                @foreach ($files as $file_index => $file)
                                                                    {{-- @dd($id, $file_index, $file) --}}
                                                                    <tr>
                                                                        <td>
                                                                            <small>
                                                                                {{-- <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $file) : '' }}" --}}
                                                                                <a href="{{ asset('file-kriteria-pengguna-jasa' . '\\' . $file) }}"
                                                                                    class="text-hover-primary">{{ $file }}</a>
                                                                            </small>
                                                                        </td>
                                                                        <form action=""></form>
                                                                        <form action="/nota-rekomendasi-2/assessment-project-selection/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="id" id="id" value="{{$id}}">
                                                                            <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="file-name" id="file-name" value="{{$file}}">
                                                                            <td class="text-center">
                                                                                <button type="submit" form="delete-file-{{$id}}-{{$file_index + 1}}" class="btn btn-sm btn-outline-danger text-hover-white {{ $is_edit ? "" : "disabled" }}">
                                                                                    <i class="bi bi-trash3-fill text-danger"></i>
                                                                                </button>
                                                                            </td>
                                                                        </form>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endif
                                        </td>
                                        <input type="hidden" name="index[]" value="{{ $keys + 1 }}"
                                            {{ $is_edit ? '' : 'disabled' }}>
                                        <input type="hidden" name="id_detail[]"
                                            value="{{ $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys]->id : '' }}"
                                            {{ $is_edit ? '' : 'disabled' }}>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="kode_proyek" value="{{ $proyek->kode_proyek }}"
                            {{ $is_edit ? '' : 'disabled' }}>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_view_proyek_penyusun_{{ $proyek->kode_proyek }}" id="new_save">
                        Back</button>
                    {{-- @if (
                        $matriks_user?->contains('kategori', 'Rekomendasi') &&
                            (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note) || $matriks_user?->contains('kategori', 'Penyusun') || $approved_penyusun_1->contains('status', 'approved')) --}}
                    @if (!$is_edit)
                        <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                data-bs-toggle="modal"
                                data-bs-target="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                style="background-color:#008CB4">Close</button>
                    @else
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            form="form-edit-kriteria-{{ $proyek->kode_proyek }}" id="new_save"
                            style="background-color:#008CB4">Save</button>
                    @endif

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- @if ($is_edit) --}}
        </form>
    {{-- @endif --}}
    <!--End::Edit Form Proses Assessment Penyusun-->

    <!--Begin::Form Proses Penyusun-->
    <div class="modal fade" id="kt_modal_view_proyek_penyusun_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_penyusun_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                @if (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note)
                    <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/penyusun" method="POST">
                    @csrf
                @endif
                <div class="modal-header">
                    <h5 class="modal-title">Detail Proyek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>
                        <p class="p-1">Pengajuan Rekomendasi Seleksi Proyek Non Green Lane</p>
                    </b>
                    <table class="table table-striped">
                        @php
                            $nilaiAssessmentProjectSelection =
                                $proyek->KriteriaProjectSelectionDetail
                                    ?->sum('nilai') ?? null;
                            $style = 'badge-light-dark';
                            $text = 'Belum Ditentukan';
                            if (!empty($nilaiAssessmentProjectSelection)) {
                                $text =
                                    App\Models\PenilaianChecklistProjectSelection::all()
                                        ->filter(function ($item) use ($nilaiAssessmentProjectSelection) {
                                            // dd($item, $nilaiAssessmentProjectSelection);
                                            if ($item->dari_nilai <= $nilaiAssessmentProjectSelection && $item->sampai_nilai >= $nilaiAssessmentProjectSelection) {
                                                // dd($item);
                                                return $item;
                                            }
                                        })
                                        ->first()->nama ?? '-';

                                switch ($text) {
                                    case 'Risiko Rendah':
                                        $style = 'badge-light-success';
                                        break;
                                    case 'Risiko Tinggi':
                                        $style = 'badge-light-warning';
                                        break;
                                    case 'Risiko Moderat':
                                        $style = 'badge-warning';
                                        break;
                                    case 'Risiko Ekstrem':
                                        $style = 'badge-danger';
                                        break;

                                    default:
                                        $style = '';
                                        break;
                                }
                            }
                        @endphp
                        <thead>
                            <tr class="text-bg-dark">
                                <th>No</th>
                                <th>Item</th>
                                <th>Uraian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nama Proyek</td>
                                <td>{{ $proyek->Proyek->nama_proyek }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama Pengguna Jasa</td>
                                <td>{{ $proyek->Proyek->proyekBerjalan->customer->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>KSO / Non KSO</td>
                                <td>
                                    <p class="m-0">{{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                    </p>
                                    @if ($proyek->Proyek->PorsiJO->isNotEmpty())
                                        <br>
                                        @foreach ($proyek->Proyek->PorsiJO as $partner)
                                            <p class="m-0">Nama Partner : {{ $partner->company_jo }}</p>
                                            <p class="m-0">WIKA : {{ (int)$partner->porsi_jo < (int)$proyek->Proyek->porsi_jo ? "Leader" : "Member" }}</p>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Lokasi</td>
                                <td>{{ $proyek->Proyek->Provinsi->province_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Nilai Penawaran</td>
                                <td>Rp.
                                    {{ number_format($proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '.', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Jenis Kontrak</td>
                                <td>{{ $proyek->Proyek->jenis_terkontrak }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Cara Pembayaran</td>
                                <td>{{ $proyek->Proyek->sistem_bayar ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Uang Muka</td>
                                <td>{{ $proyek->Proyek->is_uang_muka ? "Ya" . " | " . $proyek->Proyek->uang_muka . "%" : "Tidak" }}</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Waktu Pelaksanaan Pekerjaan</td>
                                <td>{{ $proyek->Proyek->waktu_pelaksanaan }} Hari</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Pekerjaan Utama</td>
                                <td>{!! $proyek->Proyek->pekerjaan_utama ?? '-' !!}</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>
                                    <a href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}" target="_blank"
                                        data-bs-toggle="modal" class="text-hover-primary">
                                        Hasil Assessment Project Selection
                                    </a>
                                </td>
                                <td>
                                    <small class="badge {{ $style }}">
                                        {{ $text }}
                                    </small>
                                    (score : {{ $nilaiAssessmentProjectSelection }})
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>

                    {{-- <textarea name="note-rekomendasi" id="note-rekomendasi" rows="4" class="form-control form-control-solid"></textarea> --}}
                    @if (!empty($proyek->file_pengajuan))
                        <h5>Form Pengajuan Rekomendasi: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-nota-rekomendasi-2\\file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                width="800px" height="600px"></iframe>
                        </div>
                    @endif
                </div>
                <div class="modal-footer row">
                    @php
                        if (empty($proyek->catatan_nota_rekomendasi)) {
                            $text_catatan = 'Hasil Assessment Project Selection = ' . $text . ' (Score : ' . $nilaiAssessmentProjectSelection . ")\n\n";
                        }else{
                            $text_catatan = $proyek->catatan_nota_rekomendasi;
                        }

                        //Check kondisi edit dan readonly
                        $is_edit_penyusun = false;

                        if ((is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note) && !empty($matriks_user) && $matriks_user?->contains('kategori', 'Penyusun') &&
                            $matriks_user->where('kategori', 'Penyusun')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first()) {
                            $is_edit_penyusun = true;
                        }

                        $catatan_master = collect(json_decode($proyek->catatan_master));
                    @endphp
                    @if (is_null($proyek->is_rekomendasi_approved))
                        <label for="note-rekomendasi" class="text-start">Self Assessment: </label>
                        <textarea class="form-control form-control-solid" id="note-rekomendasi" name="note-rekomendasi" rows="10" {{ !is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note || empty($matriks_user) || collect(json_decode($proyek->approved_penyusun))->contains('status', 'approved')  ? 'disabled' : '' }}>{!! trim($text_catatan) !!}</textarea>
                        <br>
                        <label for="catatan-rekomendasi" class="text-start" >
                            Catatan: 
                        <a Id="Plus" data-bs-toggle="collapse" href="#kt_expand_catatan_{{ $proyek->kode_proyek }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i id="hide-button"
                            class="bi bi-arrows-collapse"></i></i>
                        </a>
                        </label>
                        <br>
                        <div class="collapse" id="kt_expand_catatan_{{ $proyek->kode_proyek }}">
                            <div class="card card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">No.</th>
                                            <th class="min-w-auto">Kategori</th>
                                            <th class="min-w-auto">Action</th>
                                            <th class="min-w-auto">Uraian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masterCatatanRekomendasi as $key => $kategori)
                                            <tr>
                                                <td class="text-center align-middle">{{ $kategori->urutan }}</td>
                                                <td class="text-start align-middle">{{ $kategori->kategori }}</td>
                                                <td class="text-center align-middle">
                                                    @if ($catatan_master->isNotEmpty())
                                                        <input class="form-check-input" type="checkbox" value="{{ $kategori->urutan }}" name="master_selected_{{ $kategori->urutan }}" id="master_selected_{{ $kategori->urutan }}" onchange="disabledTextArea(this)" {{ !empty($catatan_master) && $catatan_master[$key]->checked ? 'checked' : '' }} {{ $is_edit_penyusun ? '' : 'disabled' }}>
                                                    @else
                                                        <input class="form-check-input" type="checkbox" value="{{ $kategori->urutan }}" name="master_selected_{{ $kategori->urutan }}" id="master_selected_{{ $kategori->urutan }}" onchange="disabledTextArea(this)" {{ $is_edit_penyusun ? '' : 'disabled' }}>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($catatan_master->isNotEmpty())
                                                        <textarea name="catatan_nota_rekomendasi_master[]" id="catatan_nota_rekomendasi_master" class="form-control form-control-solid" readonly>{!! $catatan_master[$key]->checked ? $catatan_master[$key]->uraian : '' !!}</textarea>
                                                    @else
                                                        <textarea name="catatan_nota_rekomendasi_master[]" id="catatan_nota_rekomendasi_master" class="form-control form-control-solid" readonly>{!! '' !!}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <script>
                                            function disabledTextArea(e) {
                                                const checkBox = e.checked;
                                                const textAreaTarget = e.parentElement.nextElementSibling.firstElementChild

                                                if (checkBox) {
                                                    textAreaTarget.removeAttribute('readonly');
                                                } else {
                                                    textAreaTarget.setAttribute('readonly', true);
                                                }
                                            }
                                        </script>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        <br>
                        @csrf
                        <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                        @if ($is_edit_penyusun)
                            @if (!collect(json_decode($proyek->approved_penyusun))->contains('status', 'approved'))
                            <input type="submit" name="save-draft-note-rekomendasi" value="Simpan Sebagai Draft"
                                class="btn btn-sm btn-primary">
                            @endif
                            <input type="submit" name="input-rekomendasi-with-note" value="Submit"
                                class="btn btn-sm btn-success" {{ collect(json_decode($proyek->approved_penyusun))->where('user_id', auth()->user()->id)->first()?->status == "approved" ? 'disabled' : '' }}>

                        @endif
                    @endif
                </div>
                @if (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note)
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!--End::Form Proses Penyusun-->

    <!--Begin::Form Proses Verifikasi-->
    <div class="modal fade" id="kt_modal_view_proyek_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/verifikasi" method="POST" id="verifikasi-form-{{ $proyek->kode_proyek }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>Nota Rekomendasi Tahap II Seleksi Project Non Green Lane</p>
                        </b>
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-bg-dark">
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nama Proyek</td>
                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->Proyek->proyekBerjalan->customer->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KSO / Non KSO</td>
                                    <td>
                                        <p class="m-0">{{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                        </p>
                                        @if ($proyek->Proyek->PorsiJO->isNotEmpty())
                                            <br>
                                            @foreach ($proyek->Proyek->PorsiJO as $partner)
                                                <p class="m-0">Nama Partner : {{ $partner->company_jo }}</p>
                                                <p class="m-0">WIKA : {{ (int)$partner->porsi_jo < (int)$proyek->Proyek->porsi_jo ? "Leader" : "Member" }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Lokasi</td>
                                    <td>{{ $proyek->Proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Nilai Penawaran</td>
                                    <td>Rp.
                                        {{ number_format($proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '.', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jenis Kontrak</td>
                                    <td>{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Cara Pembayaran</td>
                                    <td>{{ $proyek->Proyek->sistem_bayar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Uang Muka</td>
                                    <td>{{ $proyek->Proyek->is_uang_muka ? "Ya" . " | " . $proyek->Proyek->uang_muka . "%" : "Tidak" }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Waktu Pelaksanaan Pekerjaan</td>
                                    <td>{{ $proyek->Proyek->waktu_pelaksanaan }} Hari</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Pekerjaan Utama</td>
                                    <td>{!! $proyek->Proyek->pekerjaan_utama ?? '-' !!}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Self Assessment</td>
                                    <td>{!! nl2br($proyek->catatan_nota_rekomendasi) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>

                        @if (!empty($proyek->file_pengajuan))
                        <h5>Form Pengajuan Rekomendasi: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-nota-rekomendasi-2\\file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                width="800px" height="600px"></iframe>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer row">
                        <span><b>Hasil Assessment Profile Risiko</b> <a
                            href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}"
                            class="btn btn-sm btn-primary" data-bs-toggle="modal">Lihat</a></span>
                        <br>
                        @php
                            $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                            $is_user_exist_penyusun = $approved_verifikasi->contains('user_id', Auth::user()->id);
                        @endphp
                        @if (!empty($matriks_user))
                            @if (is_null($proyek->is_verifikasi_approved) &&
                                $matriks_user->contains('kategori', 'Verifikasi') &&
                                $matriks_user->where('kategori', 'Verifikasi')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() &&
                                !$is_user_exist_penyusun)
                                @csrf
                                <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                    id="kode-proyek">

                                <input type="submit" name="verifikasi-setujui" value="Setujui"
                                    class="btn btn-sm btn-success">
                                
                                {{-- @if ($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->where('urutan', '=', 1)?->first()) --}}
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}"
                                        class="btn btn-sm btn-primary" value="Ajukan Revisi">
                                {{-- @endif --}}
                                    
                                <input type="submit" name="verifikasi-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                            @endif
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/verifikasi" method="POST" id="revisi-verifikasi-form-{{ $proyek->kode_proyek }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Isi catatan revisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- <input type="hidden" form="verifikasi-form" name="kode-proyek" value="{{ $proyek->kode_proyek }}"> --}}
                            <textarea name="revisi-note" class="form-control form-control-solid" form="revisi-verifikasi-form-{{ $proyek->kode_proyek }}" id="revisi-note" cols="1" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="verifikasi-revisi" form="revisi-verifikasi-form-{{ $proyek->kode_proyek }}" class="btn btn-sm btn-primary" value="Revisi">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Form Proses Verifikasi-->

    <!--Begin::Form Proses Rekomendasi-->
    <div class="modal fade" id="kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/rekomendasi" method="POST" id="rekomendasi-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>Nota Rekomendasi Tahap II Seleksi Project Non Green Lane</p>
                        </b>
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-bg-dark">
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nama Proyek</td>
                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->Proyek->proyekBerjalan->customer->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KSO / Non KSO</td>
                                    <td>
                                        <p class="m-0">{{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                        </p>
                                        @if ($proyek->Proyek->PorsiJO->isNotEmpty())
                                            <br>
                                            @foreach ($proyek->Proyek->PorsiJO as $partner)
                                                <p class="m-0">Nama Partner : {{ $partner->company_jo }}</p>
                                                <p class="m-0">WIKA : {{ (int)$partner->porsi_jo < (int)$proyek->Proyek->porsi_jo ? "Leader" : "Member" }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Lokasi</td>
                                    <td>{{ $proyek->Proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Nilai Penawaran</td>
                                    <td>Rp.
                                        {{ number_format($proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '.', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jenis Kontrak</td>
                                    <td>{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Cara Pembayaran</td>
                                    <td>{{ $proyek->Proyek->sistem_bayar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Uang Muka</td>
                                    <td>{{ $proyek->Proyek->is_uang_muka ? "Ya" . " | " . $proyek->Proyek->uang_muka . "%" : "Tidak" }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Waktu Pelaksanaan Pekerjaan</td>
                                    <td>{{ $proyek->Proyek->waktu_pelaksanaan }} Hari</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Pekerjaan Utama</td>
                                    <td>{!! $proyek->Proyek->pekerjaan_utama ?? '-' !!}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Catatan</td>
                                    <td>{!! nl2br($proyek->catatan_nota_rekomendasi) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>

                        @if (!empty($proyek->file_pengajuan))
                        <h5>Form Pengajuan Rekomendasi: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-nota-rekomendasi-2\\file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                width="800px" height="600px"></iframe>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer row">
                        <span><b>Hasil Assessment Profile Risiko</b> <a
                            href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}"
                            class="btn btn-sm btn-primary" data-bs-toggle="modal">Lihat</a></span>
                        <br>
                        @php
                            $approved_rekomendasi = collect(json_decode($proyek->approved_rekomendasi));
                                $is_user_exist_rekomendasi = $approved_rekomendasi->contains('user_id', Auth::user()->id);
                        @endphp
                        @if (is_null($proyek->is_rekomendasi_approved) &&
                            $matriks_user->contains('kategori', 'Rekomendasi') &&
                            $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() &&
                            $proyek->is_verifikasi_approved &&
                            !$is_user_exist_rekomendasi)
                            <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                id="kode-proyek">
                            <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                            @php
                                $alasan = collect(json_decode($proyek->approved_rekomendasi));
                            @endphp
                            @foreach ($alasan as $note)
                            <span>
                                {{ App\Models\User::find($note->user_id)->name }} :
                                <p>{!! nl2br($note->catatan) !!}</p>
                            </span>
                            @endforeach
                            <br>
                            <button type="button" data-bs-toggle="modal" id="show-modal-tolak"
                                style="display: none"
                                data-bs-target="#kt_modal_view_proyek_tolak_rekomendasi_{{ $proyek->kode_proyek }}">clickhere</button>
                            <label for="kategori-rekomendasi" class="text-start"><span class="required">Kategori Rekomendasi: </span></label>
                            <select id="kategori-rekomendasi" name="kategori-rekomendasi"
                                class="form-select form-select-solid w-auto" style="margin-right: 2rem;"
                                data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                data-select2-id="select2-data-kategori-rekomendasi" tabindex="-1"
                                aria-hidden="true">
                                <option value=""></option>
                                <option value="Direkomendasikan">Direkomendasikan</option>
                                <option value="Direkomendasikan dengan catatan">Direkomendasikan dengan catatan
                                </option>
                                <option value="Tidak Direkomendasikan">Tidak Direkomendasikan</option>
                            </select>
                            <br>
                            <label for="kategori-rekomendasi" class="text-start"><span class="">Catatan:
                                </span></label>
                            <textarea name="alasan-ditolak" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                            <br>
                            <input type="submit" class="btn btn-sm btn-success" name="rekomendasi-setujui"
                                value="Submit">
                        @else
                            <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                            @php
                                $alasan = collect(json_decode($proyek->approved_rekomendasi));
                            @endphp
                            @foreach ($alasan as $note)
                            <span>
                                {{ App\Models\User::find($note->user_id)->name }} :
                                <p>{!! nl2br($note->catatan) !!}</p>
                            </span>
                            @endforeach
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Form Proses Rekomendasi-->

    <!--Begin::Form Proses Persetujuan-->
    <div class="modal fade" id="kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="/nota-rekomendasi-2/{{ $proyek->kode_proyek }}/persetujuan" method="POST" id="persetujuan-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>Nota Rekomendasi Tahap II Seleksi Project Non Green Lane</p>
                        </b>
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-bg-dark">
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Uraian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nama Proyek</td>
                                    <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->Proyek->proyekBerjalan->customer->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>KSO / Non KSO</td>
                                    <td>
                                        <p class="m-0">{{ $proyek->Proyek->PorsiJO->isNotEmpty() ? 'KSO' : 'Non KSO' }}
                                        </p>
                                        @if ($proyek->Proyek->PorsiJO->isNotEmpty())
                                            <br>
                                            @foreach ($proyek->Proyek->PorsiJO as $partner)
                                                <p class="m-0">Nama Partner : {{ $partner->company_jo }}</p>
                                                <p class="m-0">WIKA : {{ (int)$partner->porsi_jo < (int)$proyek->Proyek->porsi_jo ? "Leader" : "Member" }}</p>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Lokasi</td>
                                    <td>{{ $proyek->Proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Nilai Penawaran</td>
                                    <td>Rp.
                                        {{ number_format($proyek->is_rkap ? $proyek->Proyek->nilai_rkap : $proyek->Proyek->nilaiok_awal, 0, '.', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Jenis Kontrak</td>
                                    <td>{{ $proyek->Proyek->jenis_terkontrak }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Cara Pembayaran</td>
                                    <td>{{ $proyek->Proyek->sistem_bayar ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Uang Muka</td>
                                    <td>{{ $proyek->Proyek->is_uang_muka ? "Ya" . " | " . $proyek->Proyek->uang_muka . "%" : "Tidak" }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Waktu Pelaksanaan Pekerjaan</td>
                                    <td>{{ $proyek->Proyek->waktu_pelaksanaan }} Hari</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Catatan</td>
                                    <td>{!! nl2br($proyek->catatan_nota_rekomendasi) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>

                        @if (!empty($proyek->file_pengajuan))
                        <h5>Form Pengajuan Rekomendasi: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-nota-rekomendasi-2\\file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                width="800px" height="600px"></iframe>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer row">
                        <span><b>Hasil Assessment Profile Risiko</b> <a
                            href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}"
                            class="btn btn-sm btn-primary" data-bs-toggle="modal">Lihat</a></span>
                        <br>
                        @php
                            $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
                            $is_user_exist_persetujuan = $approved_persetujuan->contains('user_id', Auth::user()->id);
                        @endphp
                        @if (is_null($proyek->is_disetujui) &&
                            $matriks_user->contains('kategori', 'Persetujuan') &&
                            $matriks_user->where('kategori', 'Persetujuan')?->where('departemen_code', $proyek->Proyek->departemen_proyek)?->where('divisi_id', $proyek->Proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->Proyek->klasifikasi_pasdin)?->first() &&
                            $proyek->is_verifikasi_approved &&
                            !$is_user_exist_persetujuan)
                            <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                id="kode-proyek">
                            <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                            @php
                                $alasan = collect(json_decode($proyek->approved_rekomendasi));
                            @endphp
                            @foreach ($alasan as $note)
                            <span>
                                {{ App\Models\User::find($note->user_id)->name }} :
                                <p>{!! nl2br($note->catatan) !!}</p>
                            </span>
                            @endforeach
                            <br>
                            <label class="text-start"><b>Catatan Persetujuan:</b></label>
                            @php
                                $alasan = collect(json_decode($proyek->approved_persetujuan));
                            @endphp
                            @foreach ($alasan as $note)
                            <span>
                                {{ App\Models\User::find($note->user_id)->name }} :
                                <p>{!! nl2br($note->catatan) !!}</p>
                            </span>
                            @endforeach
                            <br>
                            <label for="" class="text-start"><span class="required">Catatan:</span></label>
                            <textarea name="catatan-persetujuan" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                            <br>
                            <input type="submit" name="persetujuan-setujui" value="Disetujui"
                                class="btn btn-sm btn-success">
                            <input type="button" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_view_proyek_tolak_persetujuan_{{ $proyek->kode_proyek }}"
                                name="persetujuan-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                        @else
                            <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                            @php
                                $alasan = collect(json_decode($proyek->approved_rekomendasi));
                            @endphp
                            @foreach ($alasan as $note)
                            <span>
                                {{ App\Models\User::find($note->user_id)->name }} :
                                <p>{!! nl2br($note->catatan) !!}</p>
                            </span>
                            @endforeach
                            @if (!empty($proyek->approved_persetujuan))
                                <label class="text-start"><b>Catatan Persetujuan:</b></label>
                                @php
                                    $alasan = collect(json_decode($proyek->approved_persetujuan));
                                @endphp
                                @foreach ($alasan as $note)
                                <span>
                                    {{ App\Models\User::find($note->user_id)->name }} :
                                    <p>{!! nl2br($note->catatan) !!}</p>
                                </span>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_view_proyek_tolak_persetujuan_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_tolak_persetujuan_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <form action="" method="get">
                    <div class="modal-header">
                        <h5 class="modal-title">Alasan Ditolak Persetujuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" form="persetujuan-form" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            <textarea name="alasan-ditolak" form="persetujuan-form" class="form-control form-control-solid" id="alasan-ditolak" cols="1"
                                rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="persetujuan-tolak" form="persetujuan-form" class="btn btn-sm btn-danger"
                            value="Ditolak dengan alasan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End::Form Proses Persetujuan-->

    <!--Begin::Modal Revisi-->
    <div class="modal fade" id="kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Revisi Nota Rekomendasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $revisi_note = collect(json_decode($proyek->revisi_note));
                    @endphp
                    {{-- Begin :: History --}}
                    <div class="row">
                        @php
                            $row = 1;
                        @endphp
                        <div class="timeline-centered">
                            @forelse ($revisi_note as $key => $data)
                                <article class="timeline-entry {{ $row % 2 == 0 ? 'left-aligned' : '' }}">

                                    <div class="timeline-entry-inner">
                                        <time class="timeline-time"></time>
                                            <div class="timeline-icon bg-success">
                                                <i class="entypo-feather"></i>
                                            </div>

                                        <div class="timeline-content">
                                            <div class="row">
                                                <h5>Catatan Revisi {{ $row }}:</h5>
                                                <div class="card text-bg-light my-3">
                                                    <div class="card-body">
                                                        <small>
                                                            Nama:
                                                            <b>{{ App\Models\User::find($data->user_id)->name }}</b><br>
                                                            Jabatan:
                                                            <b>{{ App\Models\User::find($data->user_id)->Pegawai->Jabatan?->nama_jabatan }}</b><br>
                                                            @if (!empty($data->tanggal))
                                                                Tanggal:
                                                                <b>{{ Carbon\Carbon::create($data->tanggal)->translatedFormat('d F Y H:i:s') }}</b><br>
                                                            @endif
                                                            @if (!empty($data->catatan))
                                                                Catatan:
                                                                <b>{!! nl2br($data->catatan) !!}</b><br>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                @php
                                    $row++;
                                @endphp
                            @empty
                                <p class="text-center"><b>Belum ada catatan revisi</b></p>
                            @endforelse
                        </div>
                    </div>
                    {{-- End :: History --}}
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!--End::Modal Revisi-->
            
    {{-- @endcannot --}}


    @endforeach
    <!--End::Modal Proses Rekomendasi-->
    
    
    <!--Begin::Modal Rekomendasi Selesai-->
    @foreach ($proyeks_rekomendasi_final as $proyek)
    <div class="modal fade" id="kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Pengajuan Nota Rekomendasi Tahap I</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $approved_pengajuan = collect(json_decode($proyek->approved_pengajuan));
                        // $approved_penyusun = collect(json_decode($proyek->approved_penyusun));
                        $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                        $approved_rekomendasi = collect(json_decode($proyek->approved_rekomendasi));
                        $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
                        $data_approved_merged = collect();
                        if ($approved_pengajuan->isNotEmpty() || $approved_verifikasi->isNotEmpty() || $approved_rekomendasi->isNotEmpty() || $approved_persetujuan->isNotEmpty()) {
                            $data_approved_merged = collect()->mergeRecursive(['Pengajuan' => $approved_pengajuan->flatten(), 'Penyusun' => $approved_verifikasi->flatten(), 'Rekomendasi' => $approved_rekomendasi->flatten(), 'Persetujuan' => $approved_persetujuan->flatten()]);
                        }
                    @endphp
                    {{-- Begin :: History --}}
                    <div class="row">
                        @php
                            $row = 1;
                        @endphp
                        <div class="timeline-centered">
                            @forelse ($data_approved_merged as $key => $data)
                                @if ($data->isNotEmpty())
                                    {{-- @dd($data) --}}

                                    <article class="timeline-entry {{ $row % 2 == 0 ? 'left-aligned' : '' }}">

                                        <div class="timeline-entry-inner">
                                            <time class="timeline-time"></time>
                                            @if ($data->contains('status', 'rejected'))
                                                <div class="timeline-icon bg-danger">
                                                    <i class="entypo-feather"></i>
                                                </div>
                                            @else
                                                <div class="timeline-icon bg-success">
                                                    <i class="entypo-feather"></i>
                                                </div>
                                            @endif

                                            <div class="timeline-content">
                                                <div class="row">
                                                    <h5>Tanggung jawab {{ $key }} diberikan oleh:</h5>
                                                    @foreach ($data as $d)
                                                        <div class="card text-bg-light my-3">
                                                            <div class="card-body">
                                                                <small>
                                                                    Nama:
                                                                    <b>{{ App\Models\User::find($d->user_id)->name }}</b><br>
                                                                    Jabatan:
                                                                    <b>{{ App\Models\User::find($d->user_id)->Pegawai?->Jabatan?->nama_jabatan }}</b><br>
                                                                    Status Approval:
                                                                    @if ($d->status == 'approved')
                                                                        <span><b
                                                                                class="text-success">Menyetujui</b></span>
                                                                    @else
                                                                        <span><b class="text-danger">Menolak</b></span>
                                                                    @endif
                                                                    <br>

                                                                    @if (!empty($d->tanggal))
                                                                        Tanggal:
                                                                        <b>{{ Carbon\Carbon::create($d->tanggal)->translatedFormat('d F Y H:i:s') }}</b>
                                                                        <br>
                                                                    @endif

                                                                    @if ($key == 'Rekomendasi')
                                                                        Status :
                                                                        @if ($d->status == 'approved' && !empty($d->catatan))
                                                                            <b>Direkomendasikan Dengan Catatan</b>
                                                                        @elseif ($d->status == 'approved')
                                                                            <b>Direkomendasikan</b>
                                                                        @else
                                                                            <b class="text-danger">Tidak
                                                                                Direkomendasikan</b>
                                                                        @endif
                                                                    @endif
                                                                    <br>

                                                                    @if (!empty($d->catatan))
                                                                        Catatan:
                                                                        <b>{!! nl2br($d->catatan) !!}</b><br>
                                                                    @endif
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @else
                                @endif
                                @php
                                    $row++;
                                @endphp
                            @empty
                                <p class="text-center"><b>Belum ada history rekomendasi</b></p>
                            @endforelse
                        </div>
                    </div>
                    {{-- End :: History --}}
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Dokumen Persetujuan Nota Rekomendasi Tahap I</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($proyek->file_persetujuan))
                    {{-- <h5>Dokumen Persetujuan Nota Rekomendasi 1: </h5> --}}
                    <div class="text-center">
                        <iframe src="{{ asset('file-nota-rekomendasi-2\\file-persetujuan' . '\\' . $proyek->file_persetujuan) }}"
                            width="800px" height="600px"></iframe>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
          </div>
        </div>
    </div>
    @endforeach
    <!--End::Modal Rekomendasi Selesai-->
    

@endsection

@section('js-script')
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>

    <script>
        $('#rekomendasi-proses').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            order: [
                [0, 'desc']
            ],
            buttons: [
                'excel'
            ]
        });
    </script>
    <script>
        function setNilaiKriteria(e, total, key) {

            let columnNilai = e.parentElement.parentElement.parentElement.querySelector(`#nilai_${key}`);
            return columnNilai.value = parseFloat(total);
        }
    </script>

    <script>
        function checkSizeFile(elt, kodeProyek, index, buttonSaveId, isEdit = null) {
            if (isEdit == null) {
                if (elt.files.length < 1) {
                    elt.nextElementSibling.classList.add('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.remove('disabled');
                    return;
                }
                // console.log(elt.files);
                let sizeFileCollect = 0;
                let fileOversize = [];

                elt.files.forEach(item => {
                    sizeFileCollect += item.size
                });

                if (sizeFileCollect > 20971520) {
                    elt.nextElementSibling.classList.remove('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.add('disabled');
                } else {
                    elt.nextElementSibling.innerHTML = ""
                    elt.nextElementSibling.classList.add('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.remove('disabled');
                }
            }
        }

        function validateFileSize(e) {
            const files = e.querySelectorAll("input[type='file']");
            let totalSizeFile = 0

            files.forEach(item => {
                if (item.files.length > 0) {
                    item.files.forEach(file => {
                        totalSizeFile += file.size;
                    })
                }
            })
            //Maximum file 40 MB => dibuat 42 MB
            if (totalSizeFile > 44040192) {
                Toast.fire({
                    html: "Ukuran file lebih dari 40 MB. Periksa kembali!",
                    icon: "error",
                });
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script>
        function deleteBackdrop() {
            let backdrop = document.querySelector('.modal-backdrop');
            backdrop.remove();
        }
    </script>

    <script>
        function showModal(kodeProyek) {
            const idModal = 'kt_modal_view_proyek_rekomendasi_'+kodeProyek;
            console.log(document.getElementById(idModal));
            const myModal = new bootstrap.Modal(document.getElementById(idModal), {});
            // const myModal = bootstrap.Modal.getOrCreateInstance('#kt_modal_view_proyek_rekomendasi_'+kodeProyek);
            myModal.show();
        }
    </script>
@endsection
