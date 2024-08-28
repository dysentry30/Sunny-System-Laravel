@extends('template.main')
@section('title', 'Nota Rekomendasi')
<!--begin::Main-->
@section('content')

    {{-- Begin :: css --}}
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
    {{-- End :: css --}}

    @php
        $is_super_user = str_contains(Auth::user()->name, 'PIC') || Auth::user()->check_administrator;
    @endphp

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Nota Rekomendasi</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">


                        <!--begin::Card header-->
                        <div class="card-header border-0">

                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    {{-- <select style="display: none !important" id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>

                                    </select> --}}
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    {{-- <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unitkerjas as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>
                                                    {{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="filterJenis" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter-jenis"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="I" {{ $filterJenis == 'I' ? 'selected' : '' }}>Internal</option>
                                            <option value="N" {{ $filterJenis == 'N' ? 'selected' : '' }}>External</option>
                                            <option value="J" {{ $filterJenis == 'J' ? 'selected' : '' }}>JO</option>
                                        </select>
                                    </div>
                                    <!--end:: Input Filter-->

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/rekomendasi";
                                        }
                                    </script>
                                    <!--end:: RESET--> --}}
                                </form>
                                <!--end:: BUTTON FILTER-->
                            </div>
                            <!--begin::Card title-->

                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
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
                                        <!--begin:::Tab item Claim-->
                                        {{-- <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_user_view_pengajuan"
                                                style="font-size:14px;">Pengajuan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                href="#kt_user_view_rekomendasi" style="font-size:14px;">Verifikasi
                                                Assessment</a>
                                        </li>
                                        <!--end:::Tab item -->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                href="#kt_user_view_persetujuan" style="font-size:14px;">Persetujuan Nota
                                                Rekomendasi 1</a>
                                        </li>
                                        <!--end:::Tab item --> --}}
                                    </ul>

                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div id="tab-content" class="tab-content">

                                <div class="tab-pane fade show active" id="kt_view_prosess_rekomendasi" role="tabpanel">
                                    <table class="table display align-middle table-row-dashed fs-6" id="rekomendasi-proses">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">Proyek</th>
                                                <th class="min-w-auto">Divisi</th>
                                                <th class="min-w-auto">Departemen</th>
                                                <th class="min-w-auto">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Status Form Permohonan NR I</th>
                                                <th class="min-w-auto" colspan="2">Status NR I</th>
                                                <th class="min-w-auto">Level Risiko</th>
                                                <th class="min-w-auto">Hasil NR I</th>
                                                <th class="min-w-auto">Progress</th>
                                                <th class="min-w-auto">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                                <th class="min-w-auto">Rincian</th>
                                                {{-- <th class="min-w-auto" style="display: none">Action</th> --}}
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                            // if (!empty($matriks_user)) {
                                            //     $proyek_approval = collect([]);
                                            //     if ($matriks_user->contains('kategori', 'Pengajuan')) {
                                            //         $proyek_approval = $proyeks_pengajuan;
                                            //     } elseif ($matriks_user->contains('kategori', 'Penyusun')) {
                                            //         $proyek_approval = $proyeks_penyusun;
                                            //     } elseif ($matriks_user->contains('kategori', 'Verifikasi')) {
                                            //         $proyek_approval = $proyeks_varifikasi;
                                            //     }elseif ($matriks_user->contains('kategori', 'Rekomendasi')) {
                                            //         $proyek_approval = $proyeks_rekomendasi;
                                            //     }elseif ($matriks_user->contains('kategori', 'Persetujuan')) {
                                            //         $proyek_approval = $proyeks_persetujuan;
                                            //     }else{
                                            //         $proyek_approval = [];
                                            //     }
                                            // }else{
                                            //     $proyek_approval = $proyeks_proses_rekomendasi;
                                            // }
                                        @endphp
                                        <tbody>
                                            {{-- @if (!empty($proyek_approval)) --}}
                                                {{-- @foreach ($proyek_approval as $proyek) --}}
                                                @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
                                                @php
                                                    $proyek = $nota_rekomendasi->Proyek;
                                                @endphp
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}" target="_blank" class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <td>
                                                            {{ $proyek->UnitKerja?->Divisi?->nama_kantor }}
                                                        </td>
                                                        <td>
                                                            {{ $proyek->Departemen?->nama_departemen }}
                                                        </td>
                                                        <td>
                                                            <small
                                                                class="badge {{ $proyek->is_rkap ? 'badge-light-primary' : 'badge-light-danger' }}">{{ $proyek->is_rkap ? 'RKAP' : 'Non RKAP' }}</small>
                                                        </td>
                                                        <td><a href="/customer/view/{{ $proyek->proyekBerjalan?->customer?->id_customer }}/{{ $proyek->proyekBerjalan?->customer?->name }}" class="text-hover-primary">{{ $proyek->proyekBerjalan?->customer?->name }}</a></td>
                                                        <td>{{ $proyek->proyekBerjalan?->customer?->jenis_instansi }}</td>
                                                        <td>{{ $proyek->SumberDana?->kode_sumber }}</td>
                                                        <td>{{ number_format((int) $proyek->nilaiok_awal, 0, '.', '.' ?? '0') }}
                                                        </td>
                                                        <td>{{ $proyek->klasifikasi_pasdin }}</td>
                                                        <td>
                                                            {{ !$nota_rekomendasi->review_assessment ? 'Belum Diajukan' : 'Sudah Diajukan' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($nota_rekomendasi->is_disetujui)
                                                                <small class="badge badge-light-success">
                                                                    <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal"
                                                                        class="text-success">Disetujui</a>
                                                                </small>
                                                            @elseif($nota_rekomendasi->is_disetujui == false && !is_null($nota_rekomendasi->is_disetujui))
                                                                <small class="badge badge-light-danger">
                                                                    <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal" class="text-danger">Ditolak</a>
                                                                </small>
                                                            @elseif($nota_rekomendasi->is_request_rekomendasi && !$nota_rekomendasi->review_assessment)
                                                                <small class="badge badge-light-primary">Proses
                                                                    Pengajuan</small>
                                                            @elseif(
                                                                $nota_rekomendasi->review_assessment == true &&
                                                                    (is_null($nota_rekomendasi->is_draft_recommend_note) || $nota_rekomendasi->is_draft_recommend_note))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyusunan</small>
                                                            @elseif(
                                                                !is_null($nota_rekomendasi->is_penyusun_approved) &&
                                                                    $nota_rekomendasi->is_penyusun_approved &&
                                                                    is_null($nota_rekomendasi->is_verifikasi_approved))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Verifikasi</small>
                                                            @elseif($nota_rekomendasi->is_verifikasi_approved == true && is_null($nota_rekomendasi->is_recommended))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Rekomendasi</small>
                                                            @elseif($nota_rekomendasi->is_recommended == true && is_null($nota_rekomendasi->is_disetujui))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyetujuan</small>
                                                            @endif
    
                                                            @if (!is_null($nota_rekomendasi->revisi_note))
                                                                @php
                                                                    $revisi_note = collect(json_decode($nota_rekomendasi->revisi_note))->last();
                                                                    $nama_verifikator = \App\Models\User::find($revisi_note->user_id)->name;
                                                                @endphp
                                                                @if (!empty($matriks_user))
                                                                    @if (
                                                                        ($matriks_user->contains('kategori', 'Penyusun') &&
                                                                            $matriks_user->where('kategori', 'Penyusun')
                                                                                ?->where('departemen', $proyek->departemen_proyek)
                                                                                ?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)
                                                                                ?->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)
                                                                                ?->first()) ||
                                                                            ($matriks_user->contains('kategori', 'Verifikasi') &&
                                                                                $matriks_user->where('kategori', 'Verifikasi')
                                                                                    ?->where('departemen', $proyek->departemen_proyek)
                                                                                    ?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)
                                                                                    ?->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)
                                                                                    ?->first()))
                                                                        <button type="button" class="badge badge-danger"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}">Lihat
                                                                            Catatan Revisi</button>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $style = '';
                                                                $matriks_group = [];
                                                                // if ($proyek->is_verifikasi_approved && $proyek->is_recommended) {
                                                                //     $style = 'bg-success';
                                                                // } elseif ($proyek->is_verifikasi_approved && $proyek->is_recommended) {
                                                                //     $style = 'bg-warning';
                                                                // } elseif (!is_null($proyek->is_recommended) && !$proyek->is_recommended) {
                                                                //     $style = 'bg-danger';
                                                                // } else {
                                                                //     $style = 'bg-secondary';
                                                                // }
    
                                                                $matriks_category_array = $matriks_category->toArray();
                                                                // dd($matriks_category_array);
    
                                                                if (array_key_exists($proyek->klasifikasi_pasdin, $matriks_category_array)) {
                                                                    $matriks_klasifikasi = $matriks_category_array[$proyek->klasifikasi_pasdin];
                                                                    // dump($matriks_klasifikasi);
    
                                                                    if ($nota_rekomendasi->is_request_rekomendasi && !$nota_rekomendasi->review_assessment) {
                                                                        $kategori_approval = 'Pengajuan';
                                                                        // dump(!empty($matriks_klasifikasi['Pengajuan'][$proyek->Proyek->departemen_proyek]));
                                                                        if (array_key_exists('Pengajuan', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Pengajuan'][$proyek->departemen_proyek])) {
                                                                            $collect_matriks = collect(json_decode($nota_rekomendasi->approved_pengajuan))->keyBy('user_id');
                                                                            $matriks_group = $matriks_klasifikasi['Pengajuan'][$proyek->departemen_proyek];
                                                                        } else {
                                                                            $matriks_group = [];
                                                                            $collect_matriks = [];
                                                                        }
                                                                    } elseif ($nota_rekomendasi->review_assessment == true && is_null($nota_rekomendasi->is_verifikasi_approved) && is_null($nota_rekomendasi->is_penyusun_approved)) {
                                                                        $kategori_approval = 'Penyusun';
                                                                        if (array_key_exists('Penyusun', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Penyusun'][$proyek->departemen_proyek])) {
                                                                            $matriks_group = $matriks_klasifikasi['Penyusun'][$proyek->departemen_proyek];
                                                                            $collect_matriks = collect(json_decode($nota_rekomendasi->approved_penyusun))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($nota_rekomendasi->review_assessment == true && $nota_rekomendasi->is_penyusun_approved && is_null($nota_rekomendasi->is_verifikasi_approved)) {
                                                                        $kategori_approval = 'Verifikasi';
                                                                        if (array_key_exists('Verifikasi', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Verifikasi'][$proyek->departemen_proyek])) {
                                                                            $matriks_group = $matriks_klasifikasi['Verifikasi'][$proyek->departemen_proyek];
                                                                            $collect_matriks = collect(json_decode($nota_rekomendasi->approved_verifikasi))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($nota_rekomendasi->is_verifikasi_approved == true && is_null($nota_rekomendasi->is_recommended)) {
                                                                        $kategori_approval = 'Rekomendasi';
                                                                        if (array_key_exists('Rekomendasi', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Rekomendasi'][$proyek->departemen_proyek])) {
                                                                            $matriks_group = $matriks_klasifikasi['Rekomendasi'][$proyek->departemen_proyek];
                                                                            $collect_matriks = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($nota_rekomendasi->is_recommended == true && is_null($nota_rekomendasi->is_disetujui)) {
                                                                        $kategori_approval = 'Persetujuan';
                                                                        if (array_key_exists('Persetujuan', $matriks_klasifikasi) && !empty($matriks_klasifikasi['Persetujuan'][$proyek->departemen_proyek])) {
                                                                            $matriks_group = $matriks_klasifikasi['Persetujuan'][$proyek->departemen_proyek];
                                                                            $collect_matriks = collect(json_decode($nota_rekomendasi->approved_persetujuan))->keyBy('user_id');
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
                                                            <div class="text-center d-flex flex-row align-items-center justify-content-center gap-2 flex-nowrap">
                                                                @forelse (!empty($matriks_group) ? collect($matriks_group)->sortBy('urutan') : $matriks_group as $key => $matriks)
                                                                    @php
                                                                        if (!empty($collect_matriks) && $collect_matriks->isNotEmpty()) {
                                                                            $select_user = $collect_matriks
                                                                                ?->filter(function ($value, $key) use ($matriks, $collect_matriks) {
                                                                                    // return $key == $matriks->Pegawai?->User?->id;
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
                                                            @if (!empty($nota_rekomendasi->revisi_pengajuan_note))
                                                                @if (($matriks_user->contains('kategori', 'Pengajuan') &&
                                                                $matriks_user->where('kategori', 'Pengajuan')
                                                                    ?->where('departemen', $proyek->departemen_proyek)
                                                                    ?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)
                                                                    ?->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)
                                                                    ?->first()) ||
                                                                    ($matriks_user->contains('kategori', 'Penyusun') &&
                                                                    $matriks_user->where('kategori', 'Penyusun')
                                                                    ?->where('departemen', $proyek->departemen_proyek)
                                                                    ?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)
                                                                    ?->where('klasifikasi_proyek', $proyek->klasifikasi_pasdin)
                                                                    ?->first()))
                                                                    <div class="text-center mt-2">
                                                                        <a href="#kt_modal_view_proyek_revisi_pengajuan_note_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal">
                                                                            <small class="badge badge-danger">Lihat Catatan Revisi</small>
                                                                        </a>
                                                                    </div>                                                                    
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $nilaiKriteriaPenggunaJasa = $nota_rekomendasi->KriteriaPenggunaJasaDetail?->sum('nilai') ?? null;
                                                                $style = 'badge-light-dark';
                                                                $text = 'Belum Ditentukan';
                                                                if (!empty($nilaiKriteriaPenggunaJasa)) {
                                                                    $text =
                                                                        App\Models\PenilaianPenggunaJasa::all()
                                                                            ->filter(function ($item) use ($nilaiKriteriaPenggunaJasa) {
                                                                                return $item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai > $nilaiKriteriaPenggunaJasa;
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
                                                                if (!empty($nota_rekomendasi->approved_rekomendasi_final)) {
                                                                    $check_data = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                                                                    if ((!is_null($nota_rekomendasi->is_recommended) && !$nota_rekomendasi->is_recommended) || $check_data->where('status', '=', 'rejected')->count() > 0) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('catatan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                }else{
                                                                    $status_rekomendasi = "-";
                                                                    $style = "badge-light-secondary";
                                                                }
                                                            @endphp
                                                            <small>
                                                                <p class="badge {{ $style }} m-0">{{ $status_rekomendasi }}</p>
                                                            </small>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="text-center d-flex flex-row align-items-center justify-content-center flex-nowrap">
                                                                <div class="circle bg-success"
                                                                    style="height:25px; width:25px; border-radius:50%;">
                                                                    <small><a href="#kt_modal_view_proyek_history_progress_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal"
                                                                        class="text-success">Klik</a></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-sm {{ $proyek->is_cancel ? "text-bg-danger" : "" }}">{{ $proyek->is_cancel ? "Proyek Cancel" : "" }}</span>
                                                        </td>
                                                        @if ($is_pic)
                                                            <td>
                                                                {{-- @if (!is_null($proyek->is_request_rekomendasi))
                                                                    @if ($proyek->is_request_rekomendasi && !$proyek->review_assessment)
                                                                        <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                            data-bs-toggle="modal"
                                                                            class="btn btn-sm btn-primary text-white">Submit</a>
                                                                    @elseif ($proyek->review_assessment == true && (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                        <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal"
                                                                            class="btn btn-sm btn-primary text-white">Submit</a>
                                                                    @else
                                                                        <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal"
                                                                            class="btn btn-sm btn-primary text-white">Submit</a>
                                                                    @endif
                                                                @endif --}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if (($matriks_user->contains('kategori', 'Persetujuan') && $matriks_user->where('kategori', 'Persetujuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_recommended)  || ($matriks_user->contains('kategori', 'Rekomendasi') && $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_verifikasi_approved) || ($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_penyusun_approved))
                                                                    @if ($matriks_user->contains('kategori', 'Persetujuan')  && $matriks_user->where('kategori', 'Persetujuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_recommended)
                                                                            <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                                target="_blank" data-bs-toggle="modal"
                                                                                {{-- class="btn btn-sm btn-primary text-white">{{ $proyek->is_disetujui ? "Lihat Detail" : "Approve" }}</a> --}}
                                                                                class="btn btn-sm btn-primary text-white">{{ $nota_rekomendasi->is_disetujui || (collect(json_decode($nota_rekomendasi->approved_persetujuan))->contains('user_id', auth()->user()->id) && collect(json_decode($nota_rekomendasi->approved_persetujuan))?->first()?->status == 'approved') ? "Rincian" : "Approve" }}</a>
                                                                    @elseif($matriks_user->contains('kategori', 'Rekomendasi') && $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_verifikasi_approved)
                                                                    <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal"
                                                                            class="btn btn-sm btn-primary text-white">{{ $nota_rekomendasi->is_recommended || (collect(json_decode($nota_rekomendasi->approved_rekomendasi_final))->contains('user_id', auth()->user()->id) && collect(json_decode($nota_rekomendasi->approved_rekomendasi_final))?->first()?->status == 'approved') ? "Rincian" : "Rekomendasikan" }}</a>
                                                                    @elseif($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_penyusun_approved)
                                                                        @if ($proyek->is_request_rekomendasi || (($matriks_user->filter(function($value)use($proyek){
                                                                            return $value->unit_kerja == $proyek->UnitKerja->Divisi->id_divisi &&
                                                                            $value->klasifikasi_proyek == $proyek->klasifikasi_pasdin &&
                                                                            $value->departemen == $proyek->departemen_proyek &&
                                                                            $value->kategori == "Verifikasi" &&
                                                                            $value->urutan > 1;
                                                                        })->count() > 0 && (collect(json_decode($nota_rekomendasi->approved_verifikasi))->isEmpty()))))
                                                                        @else
                                                                            <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                                target="_blank" data-bs-toggle="modal"
                                                                                {{-- class="btn btn-sm btn-primary text-white">{{ $proyek->is_verifikasi_approved ? "Lihat Detail" : "Verifikasi" }}</a> --}}
                                                                                class="btn btn-sm btn-primary text-white">{{ $nota_rekomendasi->is_verifikasi_approved || (collect(json_decode($nota_rekomendasi->approved_verifikasi))->contains('user_id', auth()->user()->id) && collect(json_decode($nota_rekomendasi->approved_verifikasi))?->first()?->status == 'approved') ? "Rincian" : "Verifikasi" }}</a>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                        @if ($is_user_exist_in_matriks_approval)
                                                                            @if ($matriks_user->contains('kategori', 'Pengajuan') && $matriks_user->where('kategori', 'Pengajuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first())
                                                                                @if (!empty($nota_rekomendasi->approved_rekomendasi))
                                                                                    <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                                        target="_blank" data-bs-toggle="modal"
                                                                                        class="btn btn-sm btn-primary text-white">Lihat Detail</a>
                                                                                @else
                                                                                    <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                                        data-bs-toggle="modal"
                                                                                        class="btn btn-sm btn-primary text-white">Ajukan</a>
                                                                                @endif
                                                                            @elseif ($matriks_user->contains('kategori', 'Penyusun') && $matriks_user->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first())
                                                                                @if ($nota_rekomendasi->is_request_rekomendasi || (($matriks_user->filter(function($value)use($proyek){
                                                                                    return $value->unit_kerja == $proyek->UnitKerja->Divisi->id_divisi &&
                                                                                    $value->klasifikasi_proyek == $proyek->klasifikasi_pasdin &&
                                                                                    $value->departemen == $proyek->departemen_proyek &&
                                                                                    $value->kategori == "Penyusun" &&
                                                                                    $value->urutan > 1;
                                                                                })->count() > 0 && (collect(json_decode($nota_rekomendasi->approved_penyusun))->isEmpty() ||collect(json_decode($nota_rekomendasi->approved_penyusun))->contains('status', 'draft')))))
                                                                                
                                                                                @elseif ($nota_rekomendasi->KriteriaPenggunaJasaDetail->count() > \App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->count())
                                                                                    <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                                        target="_blank" data-bs-toggle="modal"
                                                                                        class="btn btn-sm btn-primary text-white">{{ $nota_rekomendasi->is_penyusun_approved || (collect(json_decode($nota_rekomendasi->approved_penyusun))?->first()?->user_id == auth()->user()->id) && (collect(json_decode($nota_rekomendasi->approved_penyusun))?->first()?->status == 'approved') ? "Rincian" : "Submit" }}</a>
                                                                                @elseif ($nota_rekomendasi->review_assessment)
                                                                                    <a href="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}"
                                                                                        target="_blank" data-bs-toggle="modal"
                                                                                        class="btn btn-sm btn-primary text-white">Isi Kriteria Risiko</a>
                                                                                @endif                                                                       
                                                                            @endif 
                                                                        @else
                                                                            {{-- <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-primary text-white">Submit</a> --}}
                                                                        @endif
                                                                    @endif
                                                            </td>
                                                        @endif

                                                        <td class="text-center">
                                                            <a href="#kt_modal_rincian_proyek_{{ $proyek->kode_proyek }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary text-white">Rincian</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            {{-- @endif --}}
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="kt_view_finish_rekomendasi" role="tabpanel">
                                    <table class="table display align-middle table-row-dashed fs-6" id="rekomendasi-finish">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">Proyek</th>
                                                <th class="min-w-auto">Divisi</th>
                                                <th class="min-w-auto">Departemen</th>
                                                <th class="min-w-auto">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto" colspan="2">Status NR I</th>
                                                <th class="min-w-auto">Level Risiko</th>
                                                {{-- <th class="min-w-auto">File Penilaian Risiko</th> --}}
                                                <th class="min-w-auto">Hasil NR I</th>
                                                <th class="min-w-auto">Is Cancel</th>
                                                {{-- <th class="min-w-auto">Upload Dokumen Final</th> --}}
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                            if (!empty($matriks_user)) {
                                                $proyek_approval_finish = collect([]);
                                                if ($matriks_user->contains('kategori', 'Pengajuan')) {
                                                    $proyek_approval_finish = $proyeks_rekomendasi_final;
                                                } elseif ($matriks_user->contains('kategori', 'Penyusun')) {
                                                    $proyek_approval_finish = $proyeks_rekomendasi_final;
                                                } elseif ($matriks_user->contains('kategori', 'Verifikasi')) {
                                                    $proyek_approval_finish = $proyeks_rekomendasi_final;
                                                }elseif ($matriks_user->contains('kategori', 'Rekomendasi')) {
                                                    $proyek_approval_finish = $proyeks_rekomendasi_final;
                                                }elseif ($matriks_user->contains('kategori', 'Persetujuan')) {
                                                    $proyek_approval_finish = $proyeks_rekomendasi_final;
                                                }else{
                                                    $proyek_approval_finish = [];
                                                }
                                            }else{
                                                $proyek_approval_finish = $proyeks_proses_rekomendasi;
                                            }
                                        @endphp
                                        <tbody>
                                            @if (!empty($proyek_approval_finish))
                                                @foreach ($proyek_approval_finish as $nota_rekomendasi)
                                                @php
                                                    $proyek = $nota_rekomendasi->Proyek;
                                                @endphp
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        
                                                        <td><a href="/proyek/view/{{ $proyek->kode_proyek }}" target="_blank">{{ $proyek->nama_proyek }}</a></td>
                                                        <td>
                                                            {{ $proyek->UnitKerja?->Divisi?->nama_kantor }}
                                                        </td>
                                                        <td>
                                                            {{ $proyek->Departemen?->nama_departemen }}
                                                        </td>
                                                        <td>
                                                            <small
                                                                class="badge {{ $proyek->is_rkap ? 'badge-light-primary' : 'badge-light-danger' }}">{{ $proyek->is_rkap ? 'RKAP' : 'Non RKAP' }}</small>
                                                        </td>
                                                        <td>{{ $proyek->proyekBerjalan?->customer?->name }}</td>
                                                        <td>{{ $proyek->proyekBerjalan?->customer?->jenis_instansi }}</td>
                                                        <td>{{ $proyek->SumberDana?->kode_sumber }}</td>
                                                        <td>{{ number_format((int) $proyek->nilaiok_awal, 0, '.', '.' ?? '0') }}
                                                        </td>
                                                        <td>{{ $proyek->klasifikasi_pasdin }}</td>
                                                        <td>
                                                            @if ($nota_rekomendasi->is_disetujui)
                                                                <small class="badge badge-light-success">
                                                                    <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal"
                                                                        class="text-success">Disetujui</a>
                                                                </small>
                                                            @elseif($nota_rekomendasi->is_disetujui == false && !is_null($nota_rekomendasi->is_disetujui))
                                                                <small class="badge badge-light-danger">
                                                                    <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal" class="text-danger">Ditolak</a>
                                                                </small>
                                                            @elseif($nota_rekomendasi->is_request_rekomendasi && !$nota_rekomendasi->review_assessment)
                                                                <small class="badge badge-light-primary">Proses
                                                                    Pengajuan</small>
                                                            @elseif($nota_rekomendasi->review_assessment == true && (is_null($nota_rekomendasi->is_draft_recommend_note) || $nota_rekomendasi->is_draft_recommend_note))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyusunan</small>
                                                            @elseif(!is_null($nota_rekomendasi->is_draft_recommend_note) && (!is_null($nota_rekomendasi->is_draft_recommend_note) && $nota_rekomendasi->is_draft_recommend_note) && is_null($nota_rekomendasi->is_verifikasi_approved))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Verifikasi</small>
                                                            @elseif($nota_rekomendasi->is_verifikasi_approved == true && is_null($nota_rekomendasi->is_recommended))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Rekomendasi</small>
                                                            @elseif($nota_rekomendasi->is_recommended == true && is_null($nota_rekomendasi->is_disetujui))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyetujuan</small>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="text-center d-flex flex-row align-items-center justify-content-center flex-nowrap">
                                                                <div class="circle bg-success"
                                                                    style="height:25px; width:25px; border-radius:50%;">
                                                                    <small><a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                        data-bs-toggle="modal"
                                                                        class="text-success">Klik</a></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $nilaiKriteriaPenggunaJasa = $nota_rekomendasi->KriteriaPenggunaJasaDetail?->sum('nilai') ?? null;
                                                                $style = 'badge-light-dark';
                                                                $text = 'Belum Ditentukan';
                                                                if (!empty($nilaiKriteriaPenggunaJasa)) {
                                                                    $text =
                                                                        App\Models\PenilaianPenggunaJasa::all()
                                                                            ->filter(function ($item) use ($nilaiKriteriaPenggunaJasa) {
                                                                                return $item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai > $nilaiKriteriaPenggunaJasa;
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

                                                        <td class="text-center align-center">
                                                            @php
                                                                if (!empty($nota_rekomendasi->approved_rekomendasi_final)) {
                                                                    $check_data = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                                                                    if (!is_null($nota_rekomendasi->is_recommended) && !$nota_rekomendasi->is_recommended) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('catatan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                }else{
                                                                    $status_rekomendasi = "-";
                                                                    $style = "badge-light-secondary";
                                                                }
                                                            @endphp
                                                            <small class="d-flex flex-row justify-content-between">
                                                                <p class="badge {{ $style }}">{{ $status_rekomendasi }}</p>
                                                                <br>
                                                                @if ($matriks_user->count() < 30 && (($matriks_user?->contains('kategori', 'Pengajuan') && $matriks_user?->where('kategori', 'Pengajuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first()) ||
                                                                ($matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '>', 1)?->first())
                                                                ))
                                                                    
                                                                @else
                                                                    @if (empty($nota_rekomendasi->file_persetujuan))
                                                                    @if ($nota_rekomendasi->Proyek->is_cancel)
                                                                    @else
                                                                    <button type="button" class="btn btn-primary p-2" onclick="generateFile('{{ $proyek->kode_proyek }}')">
                                                                        Generate
                                                                    </button>  
                                                                    @endif
                                                                    @else
                                                                    <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}">
                                                                        View
                                                                    </button>
                                                                    @endif
                                                                @endif
                                                                {{-- <a href="#kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}" class="btn btn-sm btn-primary text-white" data-bs-toggle="model">Download</a> --}}
                                                            </small>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-sm {{ $proyek->is_cancel ? "text-bg-danger" : "" }}">{{ $proyek->is_cancel ? "Proyek Cancel" : "" }}</span>
                                                        </td>
                                                        {{-- <td class="text-center">
                                                            @if (($matriks_user?->contains('kategori', 'Pengajuan') && $matriks_user?->where('kategori', 'Pengajuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first()) ||
                                                            ($matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '>', 1)?->first()))
                                                            @else
                                                                @if (!empty($nota_rekomendasi->file_persetujuan))
                                                                    <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#kt_modal_upload_final_file_{{ $proyek->kode_proyek }}">
                                                                        Upload File
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    {{-- Begin::Tab Content Kriteria Pengguna Jasa --}}
    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
    @php
        $proyek = $nota_rekomendasi->Proyek;
    @endphp
        <form action="/kriteria-pengguna-jasa/detail/save" method="POST" id="form-kriteria-{{ $proyek->kode_proyek }}"
            enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
            @csrf
            <div class="modal fade" id="kt_user_view_kriteria_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Form Legalitas Pengguna Jasa</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary"data-bs-dismiss="modal"  onclick="deleteBackdrop()">
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
                                value="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}">
                            <div class="row fv-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">Item</th>
                                            <th class="min-w-auto">Keterangan</th>
                                            <th class="min-w-auto">Upload Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('position');
                                            $index = 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                @foreach ($legalitasJasa as $key => $item)
                                                    <div class="form-check" id="kriteria">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_legalitas" id="is_legalitas_{{ $key }}"
                                                            value="{{ $key + 1 }}">
                                                        <label for="is_legalitas_{{ $key }}"
                                                            class="form-check-label">
                                                            {!! nl2br($item->item) !!}
                                                        </label>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td class="d-none">
                                                <input type="hidden" name="nilai[]" value=""
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}" id="nilai">
                                                <input type="hidden" name="index[]" value="{{ $index }}"
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}" id="nilai">
                                            </td>
                                            <td class="text-center">
                                                <textarea name="keterangan[]" form="form-kriteria-{{ $proyek->kode_proyek }}" id="" cols="30"
                                                    rows="10"></textarea>
                                            </td>
                                            <td>
                                                <input type="file" name="dokumen_penilaian_0[]" id="file-dokumen-{{ $proyek->kode_proyek }}-{{ $key }}" onchange="checkSizeFile(this, '{{ $proyek->kode_proyek }}', '0', 'save-{{ $proyek->kode_proyek }}-new')"
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}" multiple id="dokumen_kriteria" accept=".pdf"
                                                    class="form-control form-control-sm form-control-solid">
                                                <small class="text-danger d-none" id="alert-file-{{ $proyek->kode_proyek }}-0">Total ukuran file max 20MB. Periksa kembali!</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="kode_proyek" value="{{ $proyek->kode_proyek }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                data-bs-toggle="modal"
                                data-bs-target="#kt_user_modal2_kriteria_{{ $proyek->kode_proyek }}" id="new_save"
                                style="background-color:#008CB4">Next</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <div class="modal fade" id="kt_user_modal2_kriteria_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Form Kriteria Pengguna Jasa</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"  onclick="deleteBackdrop()">
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
                                value="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}">
                            <div class="row fv-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">Kategori</th>
                                            <th class="min-w-50px">Item</th>
                                            <th class="min-w-auto">Bobot</th>
                                            <th class="min-w-auto">Kriteria 1</th>
                                            <th class="min-w-auto">Kriteria 2</th>
                                            <th class="min-w-auto">Kriteria 3</th>
                                            <th class="min-w-auto">Kriteria 4</th>
                                            <th class="min-w-auto">Score</th>
                                            <th class="min-w-auto">Keterangan</th>
                                            <th class="min-w-auto">Upload Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('position')->values();
                                        @endphp
                                        @foreach ($kriteriaPengguna as $key => $item)
                                            <tr>
                                                <td>{{ $item->kategori }}</td>
                                                <td>{{ $item->item }}</td>
                                                <td class="text-center">
                                                    <p>{{ $item->bobot }}</p>
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_1))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_1"
                                                                onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 1 }}', '{{ $key }}')"
                                                                value="1">
                                                            <label for="is_kriteria_{{ $key }}_1"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_1) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_2))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_2"
                                                                onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 2 }}', '{{ $key }}')"
                                                                value="2">
                                                            <label for="is_kriteria_{{ $key }}_2"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_2) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_3))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_3"
                                                                onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 3 }}', '{{ $key }}')"
                                                                value="3">
                                                            <label for="is_kriteria_{{ $key }}_3"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_3) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_4))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_4"
                                                                onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 4 }}', '{{ $key }}')"
                                                                value="4">
                                                            <label for="is_kriteria_{{ $key }}_4"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_4) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" name="nilai[]"
                                                        class="form-control form-control-solid"
                                                        form="form-kriteria-{{ $proyek->kode_proyek }}"
                                                        id="nilai_{{ $key }}" readonly>
                                                </td>
                                                <td>
                                                    <textarea name="keterangan[]" form="form-kriteria-{{ $proyek->kode_proyek }}" id="" cols="30"
                                                        rows="10"></textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_penilaian_{{ $key + 1 }}[]"
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
                            <button type="button" class="btn btn-sm btn-light btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}" id="new_save">
                                Back</button>
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
    @endforeach
    {{-- End::Tab Content Kriteria Pengguna Jasa --}}

    {{-- Begin::Tab Content Kriteria Pengguna Jasa --}}
    {{-- @php
        if ($matriks_user->contains('kategori', 'Rekomendasi')) {
            $data = $proyeks_persetujuan;
        } else {
            $data = $proyeks_rekomendasi;
        }
        @endphp --}}
    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
    @php
        $proyek = $nota_rekomendasi->Proyek;
        $approved_penyusun_1 = collect(json_decode($nota_rekomendasi->approved_penyusun));
        // $is_edit = !$proyek->is_request_rekomendasi && is_null($proyek->is_verifikasi_approved) && ((!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) || is_null($proyek->is_draft_recommend_note) && $matriks_user?->contains('kategori', 'Penyusun')) && !$approved_penyusun_1->contains('status', 'approved');
        $is_edit = !$proyek->is_request_rekomendasi && is_null($nota_rekomendasi->is_penyusun_approved) && ((!is_null($nota_rekomendasi->is_draft_recommend_note) && $nota_rekomendasi->is_draft_recommend_note) || is_null($nota_rekomendasi->is_draft_recommend_note) && $matriks_user?->contains('kategori', 'Penyusun')) && !$approved_penyusun_1->contains('status', 'approved') || $nota_rekomendasi->is_revisi;
    @endphp 
        @if ($is_edit)
            <form action="/kriteria-pengguna-jasa/detail/edit" method="POST"
                id="form-edit-kriteria-{{ $proyek->kode_proyek }}" enctype="multipart/form-data">
        @else
            <form id="form-edit-kriteria-{{ $proyek->kode_proyek }}">
        @endif
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
                        <h2>Form Legalitas Pengguna Jasa</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        @if (!empty($matriks_user))
                            @if ($matriks_user?->contains('kategori', 'Rekomendasi') && $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_verifikasi_approved && (!is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note))
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"></button>
                            @elseif($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first())
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"></button>
                            @else
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"></button>
                            @endif
                        @endif
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
                        <input type="hidden" name="modal" value="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}">
                        <div class="row fv-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="min-w-auto">Item</th>
                                        <th class="min-w-auto">Keterangan</th>
                                        <th class="min-w-auto">Upload Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy('position');
                                        $kriteriaDetails = App\Models\KriteriaPenggunaJasaDetail::where('kode_proyek', $proyek->kode_proyek)
                                            ->orderBy('index')
                                            ->get()
                                            ->unique('index')
                                            ->keyBy('index');
                                        $index = 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            @foreach ($legalitasJasa as $key => $item)
                                                <div class="form-check" id="kriteria">
                                                    <input class="form-check-input" type="radio" name="is_legalitas"
                                                        id="is_legalitas_{{ $key }}"
                                                        value="{{ $key + 1 }}"
                                                        {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$index]->kriteria == $key + 1 ? 'checked' : '' }}
                                                        {{ $is_edit ? '' : 'disabled' }}>
                                                    <label for="is_legalitas_{{ $key }}"
                                                        class="form-check-label">
                                                        {!! nl2br($item->item) !!}
                                                    </label>
                                                </div>
                                                <br>
                                            @endforeach
                                        </td>
                                        <td class="d-none">
                                            <input type="hidden" name="nilai[]" value=""
                                                form="form-edit-kriteria-{{ $proyek->kode_proyek }}" id="nilai"
                                                {{ $is_edit ? '' : 'disabled' }}>
                                        </td>
                                        <td class="text-center">
                                            <textarea name="keterangan[]" form="form-edit-kriteria-{{ $proyek->kode_proyek }}" id="" cols="30"
                                                rows="10" {{ $is_edit ? '' : 'disabled' }}>{!! $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$index]->keterangan : '' !!}</textarea>
                                        </td>
                                        <td class="text-center">
                                            @if ($matriks_user?->contains('kategori', 'Rekomendasi') && (!is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note))
                                                {{-- <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$index]->id_document) : '' }}"
                                                    class="text-hover-primary">{{ $kriteriaDetails[$index]->id_document }}</a> --}}
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Document</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $id = $kriteriaDetails[$index]->id;
                                                                $files = json_decode($kriteriaDetails[$index]->id_document);
                                                                // $files = (is_array($files) && count($files)) > 0 ? $files : array($files);
                                                                $files = (is_array($files) && count($files)) > 0 ? $files : [];
                                                            @endphp
                                                            @foreach ($files as $file_index => $file)
                                                                <tr>
                                                                    <td>
                                                                        <small>
                                                                            <a href="{{ $kriteriaDetails->isNotEmpty() && !empty($file) ? asset('file-kriteria-pengguna-jasa' . '\\' . $file) : '' }}"
                                                                                class="text-hover-primary">{{ !empty($file) ? $file : '' }}</a>
                                                                        </small>
                                                                    </td>
                                                                    <form action=""></form>
                                                                    @if (!empty($file))
                                                                    <form action="/kriteria-pengguna-jasa/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="id" id="id" value="{{$id}}">
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="file-name" id="file-name" value="{{$file}}">
                                                                        <td class="text-center">
                                                                            <button type="submit" form="delete-file-{{$id}}-{{$file_index + 1}}" class="btn btn-sm btn-outline-danger text-hover-white {{ $is_edit ? "" : "disabled" }}">
                                                                                <i class="bi bi-trash3-fill text-danger"></i>
                                                                            </button>
                                                                        </td>
                                                                    </form>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            @else
                                                @if ($is_edit)
                                                    <input type="file" name="dokumen_penilaian_0[]"
                                                        form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                        id="dokumen_kriteria"
                                                        multiple
                                                        accept=".pdf"
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
                                                                $id = $kriteriaDetails[$index]->id;
                                                                $files = json_decode($kriteriaDetails[$index]->id_document);
                                                                // $files = (is_array($files) && count($files)) > 0 ? $files : null;
                                                                $files = (is_array($files) && count($files)) > 0 ? $files : [];
                                                            @endphp
                                                            @if (!is_null($files))
                                                            @foreach ($files as $file_index => $file)
                                                                <tr>
                                                                    <td>
                                                                        <small>
                                                                            <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $file) : '' }}"
                                                                                class="text-hover-primary">{{ $file }}</a>
                                                                        </small>
                                                                    </td>
                                                                    <form action=""></form>
                                                                    <form action="/kriteria-pengguna-jasa/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
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
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="index[]" value="{{ $index }}"
                                {{ $is_edit ? '' : 'disabled' }}>
                            <input type="hidden" name="kode_proyek" value="{{ $proyek->kode_proyek }}"
                                {{ $is_edit ? '' : 'disabled' }}>
                            <input type="hidden" name="id_detail[]"
                                value="{{ $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$index]->id : '' }}"
                                {{ $is_edit ? '' : 'disabled' }}>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                            data-bs-toggle="modal"
                            data-bs-target="#kt_user_edit_modal2_kriteria_{{ $proyek->kode_proyek }}" id="new_save"
                            style="background-color:#008CB4">Next</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <div class="modal fade" id="kt_user_edit_modal2_kriteria_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Form Kriteria Pengguna Jasa</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        @if (!empty($matriks_user))
                            @if ($matriks_user?->contains('kategori', 'Rekomendasi') && $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() && $nota_rekomendasi->is_verifikasi_approved && (!is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note))
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"></button>
                            @elseif($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first())
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"></button>
                            @else
                            <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"></button>
                            @endif
                        @endif
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
                                        <th class="min-w-auto">Kategori</th>
                                        <th class="min-w-50px">Item</th>
                                        <th class="min-w-auto">Bobot</th>
                                        <th class="min-w-auto">Kriteria 1</th>
                                        <th class="min-w-auto">Kriteria 2</th>
                                        <th class="min-w-auto">Kriteria 3</th>
                                        <th class="min-w-auto">Kriteria 4</th>
                                        <th class="min-w-auto">Score</th>
                                        <th class="min-w-auto">Keterangan</th>
                                        <th class="min-w-auto">Upload Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 1')->get()->sortBy("position")->values();
                                    @endphp
                                    @foreach ($kriteriaPengguna as $keys => $item)
                                        <tr>
                                            <td>{{ $item->kategori }}</td>
                                            <td>{{ $item->item }}</td>
                                            <td class="text-center">
                                                <p>{{ $item->bobot }}</p>
                                            </td>
                                            <td>
                                                @if (!is_null($item->kriteria_1))
                                                    <div class="form-check" id="kriteria">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_kriteria_{{ $keys + 1 }}"
                                                            id="is_kriteria_{{ $keys }}_1"
                                                            onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 1 }}', '{{ $keys }}')"
                                                            value="1"
                                                            {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys + 1]->kriteria == 1 ? 'checked' : '' }}
                                                            {{ $is_edit ? '' : 'disabled' }}>
                                                        <label for="is_kriteria_{{ $keys }}_1"
                                                            class="form-check-label">
                                                            {!! nl2br($item->kriteria_1) !!}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!is_null($item->kriteria_2))
                                                    <div class="form-check" id="kriteria">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_kriteria_{{ $keys + 1 }}"
                                                            id="is_kriteria_{{ $keys }}_2"
                                                            onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 2 }}', '{{ $keys }}')"
                                                            value="2"
                                                            {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys + 1]->kriteria == 2 ? 'checked' : '' }}
                                                            {{ $is_edit ? '' : 'disabled' }}>
                                                        <label for="is_kriteria_{{ $keys }}_2"
                                                            class="form-check-label">
                                                            {!! nl2br($item->kriteria_2) !!}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!is_null($item->kriteria_3))
                                                    <div class="form-check" id="kriteria">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_kriteria_{{ $keys + 1 }}"
                                                            id="is_kriteria_{{ $keys }}_3"
                                                            onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 3 }}', '{{ $keys }}')"
                                                            value="3"
                                                            {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys + 1]->kriteria == 3 ? 'checked' : '' }}
                                                            {{ $is_edit ? '' : 'disabled' }}>
                                                        <label for="is_kriteria_{{ $keys }}_3"
                                                            class="form-check-label">
                                                            {!! nl2br($item->kriteria_3) !!}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!is_null($item->kriteria_4))
                                                    <div class="form-check" id="kriteria">
                                                        <input class="form-check-input" type="radio"
                                                            name="is_kriteria_{{ $keys + 1 }}"
                                                            id="is_kriteria_{{ $keys }}_4"
                                                            onchange="setNilaiKriteria(this, '{{ (int) $item->bobot * 4 }}', '{{ $keys }}')"
                                                            value="4"
                                                            {{ $kriteriaDetails->isNotEmpty() && $kriteriaDetails[$keys + 1]->kriteria == 4 ? 'checked' : '' }}
                                                            {{ $is_edit ? '' : 'disabled' }}>
                                                        <label for="is_kriteria_{{ $keys }}_4"
                                                            class="form-check-label">
                                                            {!! nl2br($item->kriteria_4) !!}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number" name="nilai[]"
                                                    class="form-control form-control-solid"
                                                    form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                    value="{{ $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys + 1]->nilai : 0 }}"
                                                    id="nilai_{{ $keys }}" readonly
                                                    {{ $is_edit ? '' : 'disabled' }}>
                                            </td>
                                            <td>
                                                <textarea name="keterangan[]" form="form-edit-kriteria-{{ $proyek->kode_proyek }}" id="" cols="30"
                                                    rows="10" {{ $is_edit ? '' : 'disabled' }}>{!! $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys + 1]->keterangan : '' !!}</textarea>
                                            </td>

                                            <td class="text-start">
                                                @if (
                                                    $matriks_user?->contains('kategori', 'Rekomendasi') &&
                                                        (!is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note))
                                                    {{-- <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$keys + 1]->id_document) : '' }}"
                                                        class="text-hover-primary">{{ $kriteriaDetails[$keys + 1]->id_document }}</a> --}}
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Document</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $id = $kriteriaDetails[$keys + 1]->id;
                                                                    $files = json_decode($kriteriaDetails[$keys + 1]->id_document);
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
                                                                            <form action="/kriteria-pengguna-jasa/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
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
                                                    <input type="file" name="dokumen_penilaian_{{$keys + 1}}[]"
                                                        form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                        id="dokumen_kriteria"
                                                        multiple
                                                        accept=".pdf"
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
                                                                    $id = $kriteriaDetails[$keys + 1]->id;
                                                                    $files = json_decode($kriteriaDetails[$keys + 1]->id_document);
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
                                                                            <form action="/kriteria-pengguna-jasa/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
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
                                                value="{{ $kriteriaDetails->isNotEmpty() ? $kriteriaDetails[$keys + 1]->id : '' }}"
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
                            data-bs-target="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}" id="new_save">
                            Back</button>
                        @if (
                            $matriks_user?->contains('kategori', 'Rekomendasi') &&
                                (!is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note) || $matriks_user?->contains('kategori', 'Pengajuan') || $approved_penyusun_1->contains('status', 'approved'))
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
    @endforeach
    {{-- End::Tab Content Kriteria Pengguna Jasa --}}

    <!--Begin::Root-->
    @php
        // $proyeks = $is_super_user ? $proyeks_persetujuan : $proyeks_pengajuan;
    @endphp
    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
    @php
        $proyek = $nota_rekomendasi->Proyek;
    @endphp
        <div class="modal fade" id="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p class="p-1">Pengajuan Rekomendasi Seleksi Pengguna Jasa Non Green Lane</p>
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
                                    <td>{{ $proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lokasi Proyek</td>
                                    <td>{{ $proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Instansi Pengguna Jasa</td>
                                    <td>{{ $proyek->proyekBerjalan->Customer->jenis_instansi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Sumber Pendanaan Proyek</td>
                                    <td>{{ $proyek->sumber_dana }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Perkiraan Nilai Proyek</td>
                                    <td>Rp. {{ number_format($proyek->nilaiok_awal, 0, '.', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->klasifikasi_pasdin ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- @if (!empty($proyek->file_rekomendasi))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{asset("file-rekomendasi" . "\\" . $proyek->file_rekomendasi)}}" width="auto" height="600px" ></iframe>
                            </div>
                        @endif --}}
                        @if (!empty($proyek->DokumenPendukungPasarDini))
                            <hr>
                            <h5>File Preview Pendukung Pasar Dini: </h5>
                            <div class="text-center">
                                @foreach ($proyek->DokumenPendukungPasarDini as $dokumen)
                                <iframe src="{{ asset('dokumen-pendukung-pasdin' . '\\' . $dokumen->id_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->AHU))
                            <h5>File Preview AHU: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->AHU as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->CompanyProfile))
                            <hr>
                            <h5>File Preview Company Profile: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->CompanyProfile as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->LaporanKeuangan))
                            <hr>
                            <h5>File Preview Laporan Keuangan: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->LaporanKeuangan as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($nota_rekomendasi->file_pengajuan))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $nota_rekomendasi->file_pengajuan) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @php
                            $approved_data = collect([json_decode($nota_rekomendasi->approved_rekomendasi)])->flatten();
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
                                    // if(is_array($d->user_id)) {
                                    //     return in_array(Auth::user()->id, $d->user_id);
                                    // }
                                    // return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                })
                                ->firstWhere('user_id', '!=', null);
                            if ($is_data_null) {
                                $approved_data = collect();
                            }
                            // dump($is_user_id_exist, $is_data_null, $approved_data->count() != $all_super_user_counter);
                        @endphp
                        {{-- @if (
                            $is_user_exist_in_matriks_approval &&
                                empty($is_user_id_exist) &&
                                ($is_data_null || $approved_data->count() != $all_super_user_counter))
                            <form action="" method="GET">
                                @csrf
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <input type="button" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_view_proyek_tolak_pengajuan_{{ $proyek->kode_proyek }}"
                                    name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                                <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                            </form>
                        @elseif(!empty($is_user_id_exist))
                            @switch($is_user_id_exist->status)
                                @case('approved')
                                    <small class="badge badge-light-success">Disetujui</small>
                                @break

                                @case('rejected')
                                    <small class="badge badge-light-danger">Ditolak</small>
                                @break

                                @default
                            @endswitch
                        @endif --}}
                        @if (is_null($nota_rekomendasi->review_assessment) && empty($nota_rekomendasi->review_assessment))                            
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            <input type="button" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_view_proyek_tolak_pengajuan_{{ $proyek->kode_proyek }}"
                                name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                            <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success" onclick="return addLoading(this)">
                        </form>
                    @elseif(!empty($is_user_id_exist))
                    @endif
                    </div>
                </div>
            </div>
        </div>

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
                                <textarea name="alasan-ditolak" class="form-control form-control-solid" id="alasan-ditolak" cols="1"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="tolak" class="btn btn-sm btn-danger"
                                value="Ditolak dengan alasan" onclick="return addLoading(this)">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">

                    <form action="" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">Isi catatan revisi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="revisi-note" class="form-control form-control-solid" id="revisi-note" cols="1"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="verifikasi-revisi" class="btn btn-sm btn-primary"
                                value="Revisi" onclick="return addLoading(this)">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="kt_modal_view_proyek_revisi_pengajuan_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_revisi_pengajuan_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">

                    <form action="" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">Isi catatan revisi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="revisi-pengajuan-note" class="form-control form-control-solid" id="revisi-pengajuan-note" cols="1"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="revisi-pengajuan" class="btn btn-sm btn-primary"
                                value="Revisi" onclick="return addLoading(this)">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
        @php
            $proyek = $nota_rekomendasi->Proyek;
            $hasil_assessment = collect(json_decode($nota_rekomendasi->hasil_assessment));
            $is_exist_customer = $proyek->proyekBerjalan?->customer;
            $internal_score = 0;
            $eksternal_score = 0;

            if ($hasil_assessment->isNotEmpty()) {
                $internal_score = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == 'Internal') {
                        return $ra->score;
                    }
                });
                $eksternal_score = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == 'Eksternal') {
                        return $ra->score;
                    }
                });
            }
        @endphp
        <div class="modal fade" id="kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    @if (is_null($nota_rekomendasi->is_draft_recommend_note) || $nota_rekomendasi->is_draft_recommend_note)
                        <form action="" method="GET">
                    @endif
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p>Nota Rekomendasi Tahap I Seleksi Pengguna Jasa Non Green Lane</p>
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
                                @php
                                    $nilaiKriteriaPenggunaJasa =
                                        $nota_rekomendasi->KriteriaPenggunaJasaDetail
                                            ?->filter(function ($score) {
                                                return $score->item != null;
                                            })
                                            ->sum('nilai') ?? null;
                                    $style = 'badge-light-dark';
                                    $text = 'Belum Ditentukan';
                                    if (!empty($nilaiKriteriaPenggunaJasa)) {
                                        $text =
                                            App\Models\PenilaianPenggunaJasa::all()
                                                ->filter(function ($item) use ($nilaiKriteriaPenggunaJasa) {
                                                    if ($item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai >= $nilaiKriteriaPenggunaJasa) {
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
                                <tr>
                                    <td>1</td>
                                    <td>Nama Proyek</td>
                                    <td>{{ $proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lokasi Proyek</td>
                                    <td>{{ $proyek->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Instansi Pengguna Jasa</td>
                                    <td>{{ $proyek->proyekBerjalan->Customer->jenis_instansi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Sumber Pendanaan Proyek</td>
                                    <td>{{ $proyek->sumber_dana }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Perkiraan Nilai Proyek</td>
                                    <td>Rp. {{ number_format($proyek->nilaiok_awal, 0, '.', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek->klasifikasi_pasdin ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>
                                        <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                            target="_blank" class="text-hover-primary">
                                            Assessment Eksternal Atas Pengguna Jasa
                                        </a>
                                    </td>
                                    <td>{{ $eksternal_score ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>
                                        <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                            target="_blank" class="text-hover-primary">
                                            Assessment Internal Atas Pengguna Jasa
                                        </a>
                                    </td>
                                    <td>{{ $internal_score ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>
                                        <a href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}" target="_blank"
                                            data-bs-toggle="modal" class="text-hover-primary">
                                            Profile Risiko Pengguna Jasa
                                        </a>
                                    </td>
                                    <td>
                                        <small class="badge {{ $style }}">
                                            {{ $text }}
                                        </small>
                                        (score : {{ $nilaiKriteriaPenggunaJasa }})
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>

                        {{-- <textarea name="note-rekomendasi" id="note-rekomendasi" rows="4" class="form-control form-control-solid"></textarea> --}}
                        @if (!empty($proyek->DokumenPendukungPasarDini))
                            <h5>File Preview Pendukung Pasar Dini: </h5>
                            <div class="text-center">
                                @foreach ($proyek->DokumenPendukungPasarDini as $dokumen)
                                <iframe src="{{ asset('dokumen-pendukung-pasdin' . '\\' . $dokumen->id_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                            <hr>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->AHU))
                            <h5>File Preview AHU: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->AHU as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->CompanyProfile))
                            <hr>
                            <h5>File Preview Company Profile: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->CompanyProfile as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($proyek->proyekBerjalan->customer->LaporanKeuangan))
                            <hr>
                            <h5>File Preview Laporan Keuangan: </h5>
                            <div class="text-center">
                                @foreach ($proyek->proyekBerjalan->customer->LaporanKeuangan as $dokumen)
                                <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                    width="100%" height="600px"></iframe>
                                @endforeach
                            </div>
                        @endif
                        @if (!empty($nota_rekomendasi->file_pengajuan))
                            <h5>Form Pengajuan Rekomendasi: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $nota_rekomendasi->file_pengajuan) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @endif
                        @if (!empty($nota_rekomendasi->file_rekomendasi))
                            <hr>
                            <h5>Hasil Assessment: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-rekomendasi' . '\\' . $nota_rekomendasi->file_rekomendasi) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer row">
                        @if (is_null($nota_rekomendasi->is_recommended) && $nota_rekomendasi->review_assessment)
                            <label for="note-rekomendasi" class="text-start">Catatan: </label>
                            @if ($matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '=', 2)?->first())
                                <textarea class="form-control form-control-solid" id="note-rekomendasi" name="note-rekomendasi" rows="10" readonly>{{ $nota_rekomendasi->catatan_nota_rekomendasi }}</textarea>
                            @else
                                <textarea class="form-control form-control-solid" id="note-rekomendasi" name="note-rekomendasi" rows="10" {{ !is_null($nota_rekomendasi->is_draft_recommend_note) && !$nota_rekomendasi->is_draft_recommend_note || empty($matriks_user) || collect(json_decode($nota_rekomendasi->approved_penyusun))->contains('status', 'approved')  ? 'disabled' : '' }}>{!! empty($nota_rekomendasi->catatan_nota_rekomendasi) ? 'Profile Risiko Pengguna Jasa = ' . $text . ' (Score : ' . $nilaiKriteriaPenggunaJasa . ")\n\n" : $nota_rekomendasi->catatan_nota_rekomendasi !!}</textarea>
                            @endif
                            <br>
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            @if (str_contains($proyek->klasifikasi_pasdin, "Besar") || str_contains($proyek->klasifikasi_pasdin, "Mega"))
                                @if ((is_null($nota_rekomendasi->is_draft_recommend_note) || $nota_rekomendasi->is_draft_recommend_note) && !empty($matriks_user) && $matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '=', 1)?->first())
                                    @if (!collect(json_decode($nota_rekomendasi->approved_penyusun))->contains('status', 'approved'))
                                    <input type="submit" name="save-draft-note-rekomendasi" value="Simpan Sebagai Draft"
                                        class="btn btn-sm btn-primary" onclick="return addLoading(this)">
                                    @endif
                                    <input type="submit" onclick="return addLoading(this)" name="input-rekomendasi-with-note" value="Submit"
                                        class="btn btn-sm btn-success" {{ collect(json_decode($nota_rekomendasi->approved_penyusun))->where('user_id', auth()->user()->id)->first()?->status == "approved" ? 'disabled' : '' }}>
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_revisi_pengajuan_{{ $proyek->kode_proyek }}"
                                        class="btn btn-sm btn-danger" value="Ajukan Revisi">
                                @endif
                            @else
                                    @if ($matriks_user?->contains('kategori', 'Penyusun') && $matriks_user?->where('kategori', 'Penyusun')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '=', 1)?->first())
                                        @if (!collect(json_decode($nota_rekomendasi->approved_penyusun))->contains('status', 'approved'))
                                            <input type="submit" onclick="return addLoading(this)" name="save-draft-note-rekomendasi" value="Simpan Sebagai Draft"
                                                class="btn btn-sm btn-primary">
                                        @endif
                                        @if (empty($nota_rekomendasi->approved_penyusun) || collect(json_decode($nota_rekomendasi->approved_penyusun))?->contains('status', 'draft'))
                                            <input type="submit" onclick="return addLoading(this)" name="input-rekomendasi-with-note" value="Submit"
                                                class="btn btn-sm btn-success" {{ collect(json_decode($nota_rekomendasi->approved_penyusun))->where('user_id', auth()->user()->id)->first()?->status == "approved" ? 'disabled' : '' }}>
                                            <input type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_revisi_pengajuan_{{ $proyek->kode_proyek }}"
                                                class="btn btn-sm btn-danger" value="Ajukan Revisi">
                                        @endif
                                    @else
                                        @if (empty(collect(json_decode($nota_rekomendasi->approved_penyusun))->where('user_id', auth()->user()->id)->first()) && !is_null($nota_rekomendasi->approved_penyusun) && !collect(json_decode($nota_rekomendasi->approved_penyusun))->contains('status', 'draft'))
                                            <input type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}"
                                                class="btn btn-sm btn-primary" value="Ajukan Revisi">
                                            <input type="submit" onclick="return addLoading(this)" name="input-rekomendasi-with-note" value="Submit"
                                                class="btn btn-sm btn-success" {{ collect(json_decode($nota_rekomendasi->approved_penyusun))->where('user_id', auth()->user()->id)->first()?->status == "approved" ? 'disabled' : '' }}>
                                        @endif
                                    @endif
                                {{-- @endif --}}
                            @endif
                        @endif
                    </div>
                    @if (is_null($nota_rekomendasi->is_draft_recommend_note) || $nota_rekomendasi->is_draft_recommend_note)
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
        @php
            $proyek = $nota_rekomendasi->Proyek;
            $hasil_assessment = collect(json_decode($nota_rekomendasi->hasil_assessment));
            $is_exist_customer = $proyek->proyekBerjalan?->customer;
            $internal_score = 0;
            $eksternal_score = 0;

            if ($hasil_assessment->isNotEmpty()) {
                $internal_score = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == 'Internal') {
                        return $ra->score;
                    }
                });
                $eksternal_score = $hasil_assessment->sum(function ($ra) {
                    if ($ra->kategori == 'Eksternal') {
                        return $ra->score;
                    }
                });
            }
        @endphp
        <div class="modal fade" id="kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <form action="" method="GET">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Proyek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <b>
                                <p>Nota Rekomendasi Tahap I Seleksi Pengguna Jasa Non Green Lane</p>
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
                                        <td>{{ $proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Lokasi Proyek</td>
                                        <td>{{ $proyek->Provinsi->province_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Nama Pengguna Jasa</td>
                                        <td>{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Instansi Pengguna Jasa</td>
                                        <td>{{ $proyek->proyekBerjalan->Customer->jenis_instansi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Sumber Pendanaan Proyek</td>
                                        <td>{{ $proyek->sumber_dana }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Perkiraan Nilai Proyek</td>
                                        <td>Rp. {{ number_format($proyek->nilaiok_awal, 0, '.', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Kategori Proyek</td>
                                        <td>{{ $proyek->klasifikasi_pasdin ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>
                                            <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                                target="_blank" class="text-hover-primary">
                                                Assessment Eksternal Atas Pengguna Jasa
                                            </a>
                                        </td>
                                        <td>{{ $eksternal_score ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>
                                            <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                                target="_blank" class="text-hover-primary">
                                                Assessment Internal Atas Pengguna Jasa
                                            </a>
                                        </td>
                                        <td>{{ $internal_score ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Catatan</td>
                                        <td>
                                            <p class="0">{!! nl2br($nota_rekomendasi->catatan_nota_rekomendasi) !!}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>

                            @if (!empty($nota_rekomendasi->file_pengajuan))
                            <h5>Form Pengajuan Rekomendasi: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $nota_rekomendasi->file_pengajuan) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                            @endif
                            @if (!empty($proyek->proyekBerjalan->customer->AHU))
                                <hr>
                                <h5>File Preview AHU: </h5>
                                <div class="text-center">
                                    @foreach ($proyek->proyekBerjalan->customer->AHU as $dokumen)
                                    <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                        width="100%" height="600px"></iframe>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($proyek->proyekBerjalan->customer->CompanyProfile))
                                <hr>
                                <h5>File Preview Company Profile: </h5>
                                <div class="text-center">
                                    @foreach ($proyek->proyekBerjalan->customer->CompanyProfile as $dokumen)
                                    <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                        width="100%" height="600px"></iframe>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($proyek->proyekBerjalan->customer->LaporanKeuangan))
                                <hr>
                                <h5>File Preview Laporan Keuangan: </h5>
                                <div class="text-center">
                                    @foreach ($proyek->proyekBerjalan->customer->LaporanKeuangan as $dokumen)
                                    <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                        width="100%" height="600px"></iframe>
                                    @endforeach
                                </div>
                            @endif
                            @if (!empty($nota_rekomendasi->file_penilaian_risiko))
                                <hr>
                                <h5>File Penilaian Risiko Pengguna Jasa: </h5>
                                <div class="text-center">
                                    <iframe src="{{ asset('file-profile-risiko' . '\\' . $nota_rekomendasi->file_penilaian_risiko) }}"
                                        width="100%" height="600px"></iframe>
                                </div>
                            @endif
                            
                            @if (!empty($nota_rekomendasi->file_rekomendasi))
                                <hr>
                                <h5>Hasil Assessment: </h5>
                                <div class="text-center">
                                    <iframe src="{{ asset('file-rekomendasi' . '\\' . $nota_rekomendasi->file_rekomendasi) }}"
                                        width="100%" height="600px"></iframe>
                                </div>
                            @endif

                            @if (!empty($nota_rekomendasi->file_persetujuan))
                                <hr>
                                <h5>Hasil Rekomendasi: </h5>
                                <div class="text-center">
                                    <iframe src="{{ asset('file-persetujuan' . '\\' . $nota_rekomendasi->file_persetujuan) }}"
                                        width="100%" height="600px"></iframe>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer row">
                            <span><b>Hasil Kriteria Pengguna Jasa</b> <a
                                href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal">Lihat</a></span>
                            <br>
                            {{-- <label for="note-rekomendasi" class="text-start">Catatan Rekomendasi: </label>
                            <textarea class="form-control" id="note-rekomendasi" name="note-rekomendasi"></textarea>
                            <br> --}}
                            @php
                                $approved_verifikasi = collect(json_decode($nota_rekomendasi->approved_verifikasi));
                                $is_user_exist_penyusun = $approved_verifikasi->contains('user_id', Auth::user()->id);

                                $approved_rekomendasi_final = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                                $is_user_exist_rekomendasi = $approved_rekomendasi_final->contains('user_id', Auth::user()->id);

                                $approved_persetujuan = collect(json_decode($nota_rekomendasi->approved_persetujuan));
                                $is_user_exist_persetujuan = $approved_persetujuan->contains('user_id', Auth::user()->id);
                            @endphp
                            @if (!empty($matriks_user))
                                @if (is_null($nota_rekomendasi->is_verifikasi_approved) &&
                                $matriks_user->contains('kategori', 'Verifikasi') &&
                                $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() &&
                                !$is_user_exist_penyusun)
                                @if (is_null($nota_rekomendasi->is_revisi))
                                    <form action="" method="get">
                                        @csrf
                                        <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                            id="kode-proyek">

                                        <input type="submit" onclick="return addLoading(this)" name="verifikasi-setujui" value="Setujui"
                                            class="btn btn-sm btn-success">
                                        
                                        {{-- @if ($matriks_user->contains('kategori', 'Verifikasi') && $matriks_user->where('kategori', 'Verifikasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->where('urutan', '=', 1)?->first()) --}}
                                            <input type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_view_proyek_revisi_{{ $proyek->kode_proyek }}"
                                                class="btn btn-sm btn-primary" value="Ajukan Revisi">
                                        {{-- @endif --}}
                                            
                                        <input type="submit" onclick="return addLoading(this)" name="verifikasi-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                                    </form>
                                @else
                                    
                                @endif
                            @elseif (is_null($nota_rekomendasi->is_recommended) &&
                                $matriks_user->contains('kategori', 'Rekomendasi') &&
                                $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() &&
                                $nota_rekomendasi->is_verifikasi_approved &&
                                !$is_user_exist_rekomendasi)
                                <form action="" method="get">
                                    @csrf
                                    <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                        id="kode-proyek">
                                    <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                                    {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                    @php
                                        $alasan = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
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
                                    <label for="kategori-rekomendasi" class="text-start"><span class="required">Kategori
                                            Rekomendasi: </span></label>
                                    {{-- <select onchange="disableEnableTextArea(this)" id="kategori-rekomendasi" name="kategori-rekomendasi" --}}
                                    {{-- <select id="kategori-rekomendasi" onchange="showModalTolakRekomendasi(this, '{{$proyek->kode_proyek}}')" name="kategori-rekomendasi" --}}
                                    <select id="kategori-rekomendasi-{{ $proyek->kode_proyek }}" name="kategori-rekomendasi"
                                        class="form-select form-select-solid w-auto" style="margin-right: 2rem;"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                        data-select2-id="select2-data-kategori-rekomendasi-{{ $proyek->kode_proyek }}" tabindex="-1"
                                        aria-hidden="true" onchange="disableEnableTextArea(this, '{{ $proyek->kode_proyek }}')">
                                        <option value=""></option>
                                        <option value="Direkomendasikan">Direkomendasikan</option>
                                        <option value="Direkomendasikan dengan catatan">Direkomendasikan dengan catatan
                                        </option>
                                        <option value="Tidak Direkomendasikan">Tidak Direkomendasikan</option>
                                    </select>
                                    <br>
                                    <label for="kategori-rekomendasi" class="text-start"><span class="">Catatan:
                                        </span></label>
                                    <textarea name="alasan-ditolak" id="alasan-ditolak-{{ $proyek->kode_proyek }}" class="form-control form-control-solid"cols="1" rows="5" disabled></textarea>
                                    <br>
                                    <input type="submit" onclick="return addLoading(this)" class="btn btn-sm btn-success" name="rekomendasi-setujui"
                                        value="Submit">
                                </form>
                            @elseif (is_null($nota_rekomendasi->is_disetujui) &&
                                $matriks_user?->contains('kategori', 'Persetujuan') &&
                                $matriks_user->where('kategori', 'Persetujuan')?->where('departemen', $proyek->departemen_proyek)?->where('unit_kerja', $proyek->UnitKerja->Divisi->id_divisi)?->where("klasifikasi_proyek", $proyek->klasifikasi_pasdin)?->first() &&
                                $nota_rekomendasi->is_recommended &&
                                !$is_user_exist_persetujuan)
                                <form action="" method="get">
                                    @csrf
                                    @if (!empty($nip))
                                        <input type="hidden" value="{{ $nip }}" name="user"
                                            id="user">
                                    @endif
                                    <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                        id="kode-proyek">
                                    {{-- <label class="text-start"><b>Catatan Penyusun:</b></label>
                                    <p>{!! nl2br($proyek->recommended_with_note) !!}</p>
                                    <br> --}}
                                    <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                                    {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                    @php
                                        $alasan = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                                    @endphp
                                    @foreach ($alasan as $note)
                                    <span>
                                        {{ App\Models\User::find($note->user_id)->name }} :
                                        <p>{!! nl2br($note->catatan) !!}</p>
                                    </span>
                                        
                                    @endforeach
                                    <br>

                                    <label class="text-start"><b>Catatan Persetujuan:</b></label>
                                    {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                    @php
                                        $alasanPersetujuan = collect(json_decode($nota_rekomendasi->approved_persetujuan));
                                    @endphp
                                    @foreach ($alasanPersetujuan as $note)
                                    <span>
                                        {{ App\Models\User::find($note->user_id)->name }} :
                                        <p>{!! nl2br($note->catatan) !!}</p>
                                    </span>
                                        
                                    @endforeach
                                    <br>
                                    <label for="" class="text-start"><span class="required">Catatan:
                                        </span></label>
                                    <textarea name="catatan-persetujuan" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                                    <input type="submit" onclick="return addLoading(this)" name="persetujuan-setujui" value="Disetujui"
                                        class="btn btn-sm btn-success">
                                    <input type="button" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_view_proyek_tolak_persetujuan_{{ $proyek->kode_proyek }}"
                                        name="persetujuan-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                                </form>
                            @else
                                <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                                {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                @php
                                    $alasan = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                                @endphp
                                @foreach ($alasan as $note)
                                <span>
                                    {{ App\Models\User::find($note->user_id)->name }} :
                                    <p>{!! nl2br($note->catatan) !!}</p>
                                </span>
                                @endforeach
                                <br>
                                @if (!empty($nota_rekomendasi->approved_persetujuan))
                                    <label class="text-start"><b>Catatan Persetujuan:</b></label>
                                    {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                    @php
                                        $alasanPersetujuan = collect(json_decode($proyek->approved_persetujuan));
                                    @endphp
                                    @foreach ($alasanPersetujuan as $note)
                                    <span>
                                        {{ App\Models\User::find($note->user_id)->name }} :
                                        <p>{!! nl2br($note->catatan) !!}</p>
                                    </span>
                                        
                                    @endforeach
                                @endif
                                <br>
                                <br>
                                <br>
                                
                            @endif
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="kt_modal_view_proyek_tolak_rekomendasi_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_tolak_rekomendasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">

                    <form action="" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">Alasan Ditolak Rekomendasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" value="Tidak Direkomendasikan" name="kategori-rekomendasi"
                                    id="kategori-rekomendasi_{{ $proyek->kode_proyek }}">
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="alasan-ditolak" class="form-control form-control-solid"
                                    id="alasan-ditolak_{{ $proyek->kode_proyek }}" cols="1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="rekomendasi-setujui" class="btn btn-sm btn-danger"
                                value="Ditolak dengan alasan">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="kt_modal_view_proyek_di_rekomendasikan_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_di_rekomendasikan_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">

                    <form action="" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">Alasan Di Rekomendasikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" value="Direkomendasikan" name="kategori-rekomendasi"
                                    id="kategori-rekomendasi_{{ $proyek->kode_proyek }}">
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="alasan-ditolak" class="form-control form-control-solid"
                                    id="alasan-ditolak_{{ $proyek->kode_proyek }}" cols="1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="rekomendasi-setujui" class="btn btn-sm btn-success"
                                value="Direkomendasikan">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="kt_modal_view_proyek_rekomendasi_dengan_catatan_{{ $proyek->kode_proyek }}"
            tabindex="-1" aria-labelledby="kt_modal_view_proyek_rekomendasi_dengan_catatan_{{ $proyek->kode_proyek }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">

                    <form action="" method="get">
                        <div class="modal-header">
                            <h5 class="modal-title">Alasan Rekomendasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" value="Direkomendasikan dengan catatan" name="kategori-rekomendasi"
                                    id="kategori-rekomendasi_{{ $proyek->kode_proyek }}">
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="alasan-ditolak" class="form-control form-control-solid"
                                    id="alasan-ditolak_{{ $proyek->kode_proyek }}" cols="1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="rekomendasi-setujui" class="btn btn-sm btn-success"
                                value="Direkomendasikan dengan alasan">
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
                                <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                                <textarea name="alasan-ditolak" class="form-control form-control-solid" id="alasan-ditolak" cols="1"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" onclick="return addLoading(this)" name="persetujuan-tolak" class="btn btn-sm btn-danger"
                                value="Ditolak dengan alasan">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

    @foreach ($proyek_approval_finish as $nota_rekomendasi_finish)
    @php
        $proyek = $nota_rekomendasi_finish->Proyek;
    @endphp
        <div class="modal fade" id="kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">History Pengajuan Nota Rekomendasi Tahap I</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $approved_pengajuan = collect(json_decode($nota_rekomendasi_finish->approved_rekomendasi));
                            // $approved_penyusun = collect(json_decode($proyek->approved_penyusun));
                            $approved_verifikasi = collect(json_decode($nota_rekomendasi_finish->approved_verifikasi));
                            $approved_rekomendasi = collect(json_decode($nota_rekomendasi_finish->approved_rekomendasi_final));
                            $approved_persetujuan = collect(json_decode($nota_rekomendasi_finish->approved_persetujuan));
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
                                                                        <b>{{ App\Models\User::find($d->user_id)->Pegawai->Jabatan?->nama_jabatan }}</b><br>
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
                                                                            {{-- <b>{{ Carbon\Carbon::parse($d->tanggal)->setTimezone('UTC')->translatedFormat('d F Y H:i:s') }}</b> --}}
                                                                            <b>{{ Carbon\Carbon::parse(date('d M Y H:i:s', strtotime($d->tanggal)))->translatedFormat('d F Y H:i:s') }}</b>
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
    @endforeach

    @foreach ($proyeks_proses_rekomendasi as $nota_rekomendasi)
    @php
        $proyek = $nota_rekomendasi->Proyek;
    @endphp
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
                        $revisi_note = collect(json_decode($nota_rekomendasi->revisi_note));
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
                                                                {{-- <b>{{ Carbon\Carbon::create($data->tanggal)->translatedFormat('d F Y H:i:s') }}</b><br> --}}
                                                                <b>{{ Carbon\Carbon::parse(date('d M Y H:i:s', strtotime($data->tanggal)))->translatedFormat('d F Y H:i:s') }}</b>
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

    <div class="modal fade" id="kt_modal_view_proyek_revisi_pengajuan_note_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_revisi_note_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Revisi Nota Rekomendasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $revisi_note = collect(json_decode($nota_rekomendasi->revisi_pengajuan_note));
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
                                                                {{-- <b>{{ Carbon\Carbon::create($data->tanggal)->translatedFormat('d F Y H:i:s') }}</b><br> --}}
                                                                <b>{{ Carbon\Carbon::parse(date('d M Y H:i:s', strtotime($data->tanggal)))->translatedFormat('d F Y H:i:s') }}</b>
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

    <div class="modal fade" id="kt_modal_view_proyek_history_progress_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Pengajuan Nota Rekomendasi Tahap I</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $approved_pengajuan = collect(json_decode($nota_rekomendasi->approved_rekomendasi));
                        // $approved_penyusun = collect(json_decode($proyek->approved_penyusun));
                        $approved_verifikasi = collect(json_decode($nota_rekomendasi->approved_verifikasi));
                        $approved_rekomendasi = collect(json_decode($nota_rekomendasi->approved_rekomendasi_final));
                        $approved_persetujuan = collect(json_decode($nota_rekomendasi->approved_persetujuan));
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
                                                                    <b>{{ App\Models\User::find($d->user_id)->Pegawai->Jabatan?->nama_jabatan }}</b><br>
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
                                                                        {{-- <b>{{ Carbon\Carbon::create($d->tanggal)->translatedFormat('d F Y H:i:s') }}</b> --}}
                                                                        <b>{{ Carbon\Carbon::parse(date('d M Y H:i:s', strtotime($d->tanggal)))->translatedFormat('d F Y H:i:s') }}</b>
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


    @php
        $proyek = $nota_rekomendasi->Proyek;
        $hasil_assessment = collect(json_decode($nota_rekomendasi->hasil_assessment));
        $is_exist_customer = $proyek->proyekBerjalan?->customer;
        $internal_score = 0;
        $eksternal_score = 0;

        if ($hasil_assessment->isNotEmpty()) {
            $internal_score = $hasil_assessment->sum(function ($ra) {
                if ($ra->kategori == 'Internal') {
                    return $ra->score;
                }
            });
            $eksternal_score = $hasil_assessment->sum(function ($ra) {
                if ($ra->kategori == 'Eksternal') {
                    return $ra->score;
                }
            });
        }
    @endphp
    <div class="modal fade" id="kt_modal_rincian_proyek_{{ $proyek->kode_proyek }}" tabindex="-1"
        aria-labelledby="kt_modal_rincian_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Proyek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>
                        <p>Nota Rekomendasi Tahap I Seleksi Pengguna Jasa Non Green Lane</p>
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
                            @php
                                $nilaiKriteriaPenggunaJasa =
                                    $nota_rekomendasi->KriteriaPenggunaJasaDetail
                                        ?->filter(function ($score) {
                                            return $score->item != null;
                                        })
                                        ->sum('nilai') ?? null;
                                $style = 'badge-light-dark';
                                $text = 'Belum Ditentukan';
                                if (!empty($nilaiKriteriaPenggunaJasa)) {
                                    $text =
                                        App\Models\PenilaianPenggunaJasa::all()
                                            ->filter(function ($item) use ($nilaiKriteriaPenggunaJasa) {
                                                if ($item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai >= $nilaiKriteriaPenggunaJasa) {
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
                            <tr>
                                <td>1</td>
                                <td>Nama Proyek</td>
                                <td>{{ $proyek->nama_proyek }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Lokasi Proyek</td>
                                <td>{{ $proyek->Provinsi->province_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nama Pengguna Jasa</td>
                                <td>{{ $proyek->proyekBerjalan->name_customer ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Instansi Pengguna Jasa</td>
                                <td>{{ $proyek->proyekBerjalan->Customer->jenis_instansi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Sumber Pendanaan Proyek</td>
                                <td>{{ $proyek->sumber_dana }}</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Perkiraan Nilai Proyek</td>
                                <td>Rp. {{ number_format($proyek->nilaiok_awal, 0, '.', '.') }}</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Kategori Proyek</td>
                                <td>{{ $proyek->klasifikasi_pasdin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>
                                    <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                        target="_blank" class="text-hover-primary">
                                        Assessment Eksternal Atas Pengguna Jasa
                                    </a>
                                </td>
                                <td>{{ $eksternal_score ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    <a href="/customer/view/{{ $proyek->proyekBerjalan->customer->id_customer }}/{{ $proyek->proyekBerjalan->customer->name }}"
                                        target="_blank" class="text-hover-primary">
                                        Assessment Internal Atas Pengguna Jasa
                                    </a>
                                </td>
                                <td>{{ $internal_score ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>
                                    <a href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}" target="_blank"
                                        data-bs-toggle="modal" class="text-hover-primary">
                                        Profile Risiko Pengguna Jasa
                                    </a>
                                </td>
                                <td>
                                    <small class="badge {{ $style }}">
                                        {{ $text }}
                                    </small>
                                    (score : {{ $nilaiKriteriaPenggunaJasa }})
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Catatan</td>
                                <td>
                                    @if (!is_null($nota_rekomendasi->is_penyusun_approved))
                                        {!! nl2br($nota_rekomendasi->catatan_nota_rekomendasi) !!}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>

                    {{-- <textarea name="note-rekomendasi" id="note-rekomendasi" rows="4" class="form-control form-control-solid"></textarea> --}}
                    @if (!empty($proyek->DokumenPendukungPasarDini))
                        <h5>File Preview Pendukung Pasar Dini: </h5>
                        <div class="text-center">
                            @foreach ($proyek->DokumenPendukungPasarDini as $dokumen)
                            <iframe src="{{ asset('dokumen-pendukung-pasdin' . '\\' . $dokumen->id_document) }}"
                                width="100%" height="600px"></iframe>
                            @endforeach
                        </div>
                        <hr>
                    @endif
                    @if (!empty($proyek->proyekBerjalan->customer->AHU))
                        <h5>File Preview AHU: </h5>
                        <div class="text-center">
                            @foreach ($proyek->proyekBerjalan->customer->AHU as $dokumen)
                            <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                width="100%" height="600px"></iframe>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($proyek->proyekBerjalan->customer->CompanyProfile))
                        <hr>
                        <h5>File Preview Company Profile: </h5>
                        <div class="text-center">
                            @foreach ($proyek->proyekBerjalan->customer->CompanyProfile as $dokumen)
                            <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                width="100%" height="600px"></iframe>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($proyek->proyekBerjalan->customer->LaporanKeuangan))
                        <hr>
                        <h5>File Preview Laporan Keuangan: </h5>
                        <div class="text-center">
                            @foreach ($proyek->proyekBerjalan->customer->LaporanKeuangan as $dokumen)
                            <iframe src="{{ asset('customer-file' . '\\' . $dokumen->file_document) }}"
                                width="100%" height="600px"></iframe>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($nota_rekomendasi->file_pengajuan))
                        <h5>Form Pengajuan Rekomendasi: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-pengajuan' . '\\' . $nota_rekomendasi->file_pengajuan) }}"
                                width="100%" height="600px"></iframe>
                        </div>
                    @endif
                    @if (!empty($nota_rekomendasi->file_rekomendasi))
                        <hr>
                        <h5>Hasil Assessment: </h5>
                        <div class="text-center">
                            <iframe src="{{ asset('file-rekomendasi' . '\\' . $nota_rekomendasi->file_rekomendasi) }}"
                                width="100%" height="600px"></iframe>
                        </div>
                    @endif
                </div>
                <div class="modal-footer row">
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    @foreach ($proyek_approval_finish as $proyek)
    <div class="modal fade" id="kt_modal_view_dokumen_persetujuan_{{ $proyek->kode_proyek }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Dokumen Persetujuan Nota Rekomendasi Tahap I</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($proyek->file_rekomendasi))
                    {{-- <h5>Dokumen Persetujuan Nota Rekomendasi 1: </h5> --}}
                    <div class="text-center">
                        <iframe src="{{ asset('file-persetujuan/' . $proyek->file_persetujuan) }}"
                            width="100%" height="600px"></iframe>
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
    <!--Begin::Modal Upload Final File-->
    <form action="/rekomendasi/dokumen-final/{{ $proyek->kode_proyek }}/upload" method="post" enctype="multipart/form-data" onsubmit="addLoading(this)">
        @csrf
        <div class="modal fade" id="kt_modal_upload_final_file_{{ $proyek->kode_proyek }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Upload File Nota Rekomendasi I - Final</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <p>Upload File</p>
                        <input type="file" class="form-control form-control-sm form-input-solid" name="dokumen-nota-rekomendasi-1" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </form>
    <!--End::Modal Upload Final File-->
    @endforeach

    @if (!empty($proyek_from_url))
        <div class="modal fade" id="kt_modal_view_proyek_wa_{{ $proyek_from_url->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_{{ $proyek_from_url->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"  onclick="deleteBackdrop()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <b>
                            <p class="p-1">Pengajuan Rekomendasi Seleksi Pengguna Jasa Non Green Lane</p>
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
                                    <td>{{ $proyek_from_url->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lokasi Proyek</td>
                                    <td>{{ $proyek_from_url->Provinsi->province_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Nama Pengguna Jasa</td>
                                    <td>{{ $proyek_from_url->proyekBerjalan->name_customer ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Instansi Pengguna Jasa</td>
                                    <td>{{ $proyek_from_url->proyekBerjalan->Customer->jenis_instansi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Sumber Pendanaan Proyek</td>
                                    <td>{{ $proyek_from_url->sumber_dana }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Perkiraan Nilai Proyek</td>
                                    <td>Rp. {{ number_format($proyek_from_url->nilaiok_awal, 0, '.', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Kategori Proyek</td>
                                    <td>{{ $proyek_from_url->klasifikasi_pasdin ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- @if (!empty($proyek_from_url->file_rekomendasi))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{asset("file-rekomendasi" . "\\" . $proyek_from_url->file_rekomendasi)}}" width="auto" height="600px" ></iframe>
                            </div>
                        @endif --}}
                        @if (!empty($proyek_from_url->file_pengajuan))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $proyek_from_url->file_pengajuan) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @php
                            $approved_data = collect([json_decode($proyek_from_url->approved_rekomendasi)])->flatten();
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
                                    // if(is_array($d->user_id)) {
                                    //     return in_array(Auth::user()->id, $d->user_id);
                                    // }
                                    // return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                })
                                ->firstWhere('user_id', '!=', null);
                            if ($is_data_null) {
                                $approved_data = collect();
                            }
                            // dump($is_user_id_exist, $is_data_null, $approved_data->count() != $all_super_user_counter);
                        @endphp
                        {{-- @if (
                            $is_user_exist_in_matriks_approval &&
                                empty($is_user_id_exist) &&
                                ($is_data_null || $approved_data->count() != $all_super_user_counter))
                            <form action="" method="GET">
                                @csrf
                                <input type="hidden" name="kode-proyek" value="{{ $proyek_from_url->kode_proyek }}">
                                <input type="button" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_view_proyek_tolak_pengajuan_{{ $proyek_from_url->kode_proyek }}"
                                    name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                                <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                            </form>
                        @elseif(!empty($is_user_id_exist))
                            @switch($is_user_id_exist->status)
                                @case('approved')
                                    <small class="badge badge-light-success">Disetujui</small>
                                @break

                                @case('rejected')
                                    <small class="badge badge-light-danger">Ditolak</small>
                                @break

                                @default
                            @endswitch
                        @endif --}}
                        @if (is_null($proyek_from_url->review_assessment) && empty($proyek_from_url->review_assessment))                            
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek_from_url->kode_proyek }}">
                            <input type="button" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_view_proyek_tolak_pengajuan_{{ $proyek_from_url->kode_proyek }}"
                                name="tolak" value="Tolak" class="btn btn-sm btn-danger">
                            <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                        </form>
                    @elseif(!empty($is_user_id_exist))
                        {{-- @php
                            $status_approval = $is_user_id_exist->first();
                        @endphp --}}
                        @switch($is_user_id_exist->status)
                            @case('approved')
                                <small class="badge badge-light-success">Disetujui</small>
                            @break

                            @case('rejected')
                                <small class="badge badge-light-danger">Ditolak</small>
                            @break

                            @default
                        @endswitch
                    @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    <!--end::Data Tables-->

    <script>
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })
        function addLoading(elt) {
            LOADING_BODY.block();
            return true;
        }
        async function generateFile(kode_proyek) {
            Swal.fire({
                title: '',
                text: "Apakah anda yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    LOADING_BODY.block();
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    const sendData = await fetch(`{{ url('/rekomendasi/${kode_proyek}/generate') }}`, {
                        method: "POST",
                        body: formData
                    }).then(res => res.json());
                    if (sendData.success) {
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'success'}).then(()=>{
                            location.reload();
                        })
                    } else{
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'error'}).then(()=>{
                            location.reload();
                        })
                    }
                }
    
            })
        }
    </script>

    <script>
        function openModalPersetujuan() {
            const searchParams = new URLSearchParams(window.location.search);
            const getModalElt = searchParams.get("open");
            const modalElt = document.getElementById(getModalElt);
            //console.log(modalElt);

            if(modalElt) {
                const modalBoots = new bootstrap.Modal(modalElt);
                modalBoots.show();
            }
        }

        $(document).ready(function() {
            // console.log("TES");
            
                
            openModalPersetujuan();
            
            const rekomendasiOpen = "{{ $rekomendasi_open ?? null }}";
            if (rekomendasiOpen) {
                const modalOpen = document.querySelector(`#${rekomendasiOpen}`);
                const modalOpenBoots = new bootstrap.Modal(modalOpen, {});
                modalOpenBoots.show();
            }

            // setTimeout(() => {
            //     const exportBtn = document.querySelectorAll(".buttons-excel");
            //     exportBtn.forEach(item => {
            //         item.style.display = "none";
            //     });
            // }, 0);

        });
    </script>
    <script>
        $('#rekomendasi-proses').DataTable( {
                // dom: 'Bfrtip',
                dom: 'Bfrtip',
                pageLength : 20,
                order: [[0, 'desc']],
                buttons: [
                    'excel'
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        $('#rekomendasi-finish').DataTable( {
            dom: 'Bfrtip',
            pageLength : 20,
            // order: false,
            buttons: [
                'excel'
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    </script>


    <script>
        function confirmDeleteFile(e, fileName) {
            Swal.fire({
                title: '',
                text: `Apakah anda yakin ingin menghapus file ${fileName}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    e.submit();
                }
                return false;
            });
            return false;
        }
        // const modals = document.querySelectorAll(".modal");
        // setTimeout(() => {
        //     modals.forEach(modal => {
        //         const inputs = modal.querySelectorAll(".modal-dialog .modal-content .modal-body input, .modal-dialog .modal-content .modal-body select, .modal-dialog .modal-content .modal-body textarea");
        //         inputs.forEach(input => {
        //             input.setAttribute("readonly", true);
        //         })
        //     });
        // }, 500);
    </script>

    {{-- Begin :: Export To Excel Data --}}
    {{-- <script>
        function exportToExcel(e, tableElt) {
            // console.log(e.parentElement);
            document.querySelector(`${tableElt}_wrapper .buttons-excel`).click();
            return;
        }
    </script> --}}
    {{-- End :: Export To Excel Data --}}

    <script>
        function disableEnableTextArea(e, kode_proyek) {
            const value = e.value;
            if (value == "Direkomendasikan") {
                // e.parentElement.querySelector("#note-rekomendasi").setAttribute("readonly", true);
                if (!document.querySelector(`#alasan-ditolak-${kode_proyek}`).hasAttribute("disabled")) {
                    document.querySelector(`#alasan-ditolak-${kode_proyek}`).setAttribute("disabled", true);
                }
            } else {
                // e.parentElement.querySelector("#note-rekomendasi").removeAttribute("readonly");
                document.querySelector(`#alasan-ditolak-${kode_proyek}`).removeAttribute("disabled");
            }
        }
    </script>

    {{-- Begin :: show modal rekomendasi ketika pilih ditolak --}}
    <script>
        function showModalTolakRekomendasi(e, kodeProyek) {
            const value = e.value;
            if (value == "Tidak Direkomendasikan") {
                const button = document.getElementById("show-modal-tolak");
                button.click();
            } else if (value == "Direkomendasikan") {
                const button = document.getElementById("show-modal-direkomendasikan");
                button.click();
            } else {
                const button = document.getElementById("show-modal-rekomendasi-dengan-catatan");
                button.click();
            }
        }
    </script>
    {{-- End :: show modal rekomendasi ketika pilih ditolak --}}

    <script>
        function setNilaiKriteria(e, total, key) {

            let columnNilai = e.parentElement.parentElement.parentElement.querySelector(`#nilai_${key}`);
            return columnNilai.value = parseInt(total);
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
                }else{
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
                    item.files.forEach(file=>{
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
            }else{
                return true;
            }
        }
    </script>

    <script>
        function deleteBackdrop(){
            let backdrop = document.querySelector('.modal-backdrop');
            backdrop.remove();
        }
    </script>
@endsection
