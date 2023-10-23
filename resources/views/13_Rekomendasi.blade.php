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
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-pengajuan">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">Proyek</th>
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
                                                <th class="min-w-auto">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1;
                                            if (!empty($matriks_user)) {
                                                $proyek_approval = collect([]);
                                                if ($matriks_user->contains('kategori', 'Pengajuan')) {
                                                    $proyek_approval = $proyeks_pengajuan;
                                                } elseif ($matriks_user->contains('kategori', 'Penyusun')) {
                                                    $proyek_approval = $proyeks_penyusun;
                                                } elseif ($matriks_user->contains('kategori', 'Verifikasi')) {
                                                    $proyek_approval = $proyeks_varifikasi;
                                                }elseif ($matriks_user->contains('kategori', 'Rekomendasi')) {
                                                    $proyek_approval = $proyeks_rekomendasi;
                                                }elseif ($matriks_user->contains('kategori', 'Persetujuan')) {
                                                    $proyek_approval = $proyeks_persetujuan;
                                                }else{
                                                    $proyek_approval = [];
                                                }
                                            }else{
                                                $proyek_approval = $all_proyeks;
                                            }
                                        @endphp
                                        <tbody>
                                            {{-- @if (!empty($proyek_approval)) --}}
                                                {{-- @foreach ($proyek_approval as $proyek) --}}
                                                @foreach ($proyeks_proses_rekomendasi as $proyek)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}" target="_blank" class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
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
                                                            {{ !$proyek->review_assessment ? 'Belum Diajukan' : 'Sudah Diajukan' }}
                                                        </td>
                                                        <td>
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
                                                            @elseif($proyek->is_request_rekomendasi && !$proyek->review_assessment)
                                                                <small class="badge badge-light-primary">Proses
                                                                    Pengajuan</small>
                                                            @elseif($proyek->review_assessment == true && (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyusunan</small>
                                                            @elseif(!is_null($proyek->is_draft_recommend_note) && (!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) && is_null($proyek->is_verifikasi_approved))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Verifikasi</small>
                                                            @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Rekomendasi</small>
                                                            @elseif($proyek->is_recommended == true && is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyetujuan</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $style = '';
                                                                $matriks_group = [];
                                                                if ($proyek->is_verifikasi_approved && $proyek->is_recommended && empty($proyek->recommended_with_note)) {
                                                                    $style = 'bg-success';
                                                                } elseif ($proyek->is_verifikasi_approved && $proyek->is_recommended && !empty($proyek->recommended_with_note)) {
                                                                    $style = 'bg-warning';
                                                                } elseif (!is_null($proyek->is_recommended) && !$proyek->is_recommended) {
                                                                    $style = 'bg-danger';
                                                                } else {
                                                                    $style = 'bg-secondary';
                                                                }

                                                                $matriks_category_array = $matriks_category->toArray(); 

                                                                if (array_key_exists($proyek->klasifikasi_pasdin, $matriks_category_array)) {
                                                                    $matriks_klasifikasi = $matriks_category_array[$proyek->klasifikasi_pasdin];
    
                                                                    if ($proyek->is_request_rekomendasi && !$proyek->review_assessment) {
                                                                        $kategori_approval = 'Pengajuan';
                                                                        if (array_key_exists('Pengajuan', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Pengajuan'];
                                                                        } else {
                                                                            $matriks_group = [];
                                                                            $collect_matriks = [];
                                                                        }
                                                                    } elseif ($proyek->review_assessment == true && is_null($proyek->is_verifikasi_approved)) {
                                                                        $kategori_approval = 'Penyusun';
                                                                        if (array_key_exists('Penyusun', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Penyusun'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_penyusun))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended)) {
                                                                        $kategori_approval = 'Rekomendasi';
                                                                        if (array_key_exists('Rekomendasi', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Rekomendasi'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_rekomendasi_final))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($proyek->is_recommended == true && is_null($proyek->is_disetujui)) {
                                                                        $kategori_approval = 'Persetujuan';
                                                                        if (array_key_exists('Persetujuan', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Persetujuan'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_persetujuan))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    }
                                                                }else {
                                                                    $matriks_group = [];
                                                                    $collect_matriks = [];
                                                                }
                                                            @endphp
                                                            <div class="text-center d-flex flex-row gap-2 flex-nowrap">
                                                                @foreach (!empty($matriks_group) ? $matriks_group->sortBy('urutan') : $matriks_group as $matriks)
                                                                @php
                                                                    if(!empty($collect_matriks)){
                                                                        $select_user = $collect_matriks?->filter(function($value, $key)use($matriks){
                                                                            return $key == $matriks->Pegawai->User->id;
                                                                        })->first();

                                                                        if (empty($select_user)) {
                                                                            $style = 'bg-secondary';
                                                                        }else{
                                                                            if ($select_user->status == "approved" && empty($select_user->alasan)) {
                                                                                $style = 'bg-success';
                                                                            }elseif ($select_user->status == "approved" && !empty($select_user->alasn)) {
                                                                                $style = 'bg-warning';
                                                                            }else{
                                                                                $style = 'bg-danger';
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                    <div class="circle {{ $style }} text-white"
                                                                        style="height:25px; width:25px; border-radius:50%;">
                                                                        <small>{{ $matriks->kode_unit_kerja }}</small>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $nilaiKriteriaPenggunaJasa = $proyek->KriteriaPenggunaJasaDetail?->sum('nilai') ?? null;
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
                                                                        case 'Risiko Risiko Tinggi':
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
                                                        <td>
                                                            @php
                                                                if (!empty($proyek->approved_persetujuan)) {
                                                                    $check_data = collect(json_decode($proyek->approved_persetujuan));
                                                                    if ($check_data->where('status', '=', 'rejected')->count() > 0) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif (!empty($proyek->persetujuan_note)) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                } elseif (!empty($proyek->approved_rekomendasi_final)) {
                                                                    $check_data = collect(json_decode($proyek->approved_rekomendasi_final));
                                                                    if (!is_null($proyek->is_recommended) && !$proyek->is_recommended) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('alasan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                } elseif (!empty($proyek->approved_penyusun)) {
                                                                    $check_data = collect(json_decode($proyek->approved_penyusun));
                                                                    if (!is_null($proyek->is_penyusun_approved) && !$proyek->is_penyusun_approved) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('alasan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                }else {
                                                                    $status_rekomendasi = "-";
                                                                    $style = "badge-light-secondary";
                                                                }
                                                            @endphp
                                                            <small>
                                                                <p class="badge {{ $style }} m-0">{{ $status_rekomendasi }}</p>
                                                            </small>
                                                        </td>
                                                        <td>-</td>
                                                        @if (empty($matriks_user))
                                                            <td>
                                                                @if (!is_null($proyek->is_request_rekomendasi))
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
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if ($matriks_user->contains('kategori', 'Persetujuan')  || $matriks_user->contains('kategori', 'Rekomendasi') || $matriks_user->contains('kategori', 'Verifikasi'))
                                                                    <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                        target="_blank" data-bs-toggle="modal"
                                                                        class="btn btn-sm btn-primary text-white">Submit</a>
                                                                @else
                                                                    @if ($is_user_exist_in_matriks_approval)
                                                                        @if ($matriks_user->contains('kategori', 'Pengajuan'))
                                                                            <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                                data-bs-toggle="modal"
                                                                                class="btn btn-sm btn-primary text-white">Submit</a>
                                                                        @elseif ($matriks_user->contains('kategori', 'Penyusun'))
                                                                            @if ($proyek->is_request_rekomendasi)
                                                                                <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                                    target="_blank" data-bs-toggle="modal"
                                                                                    class="btn btn-sm btn-primary text-white disabled" role="button">Submit</a>
                                                                            @elseif ($proyek->KriteriaPenggunaJasaDetail->count() > \App\Models\KriteriaPenggunaJasa::all()->count())
                                                                                <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                                    target="_blank" data-bs-toggle="modal"
                                                                                    class="btn btn-sm btn-primary text-white">Submit</a>
                                                                            @else
                                                                                <a href="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}"
                                                                                    target="_blank" data-bs-toggle="modal"
                                                                                    class="btn btn-sm btn-primary text-white">Submit</a>
                                                                            @endif                                                                        
                                                                        @endif 
                                                                    @else
                                                                        <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-primary text-white">Submit</a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            {{-- @endif --}}
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="kt_view_finish_rekomendasi" role="tabpanel">
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-pengajuan">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">Proyek</th>
                                                <th class="min-w-auto">RKAP</th>
                                                <th class="min-w-auto">Pengguna Jasa</th>
                                                <th class="min-w-auto">Instansi Pengguna Jasa</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto" colspan="2">Status NR I</th>
                                                <th class="min-w-auto">Level Risiko</th>
                                                <th class="min-w-auto">Hasil NR I</th>
                                                <th class="min-w-auto">Is Cancel</th>
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
                                                $proyek_approval_finish = $all_proyeks;
                                            }
                                        @endphp
                                        <tbody>
                                            @if (!empty($proyek_approval_finish))
                                                @foreach ($proyek_approval_finish as $proyek)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        @if (empty($matriks_user))
                                                            <td>
                                                                @if (!is_null($proyek->is_request_rekomendasi))
                                                                    @if ($proyek->is_request_rekomendasi && !$proyek->review_assessment)
                                                                        <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                            data-bs-toggle="modal"
                                                                            class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                    @elseif ($proyek->review_assessment == true && (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                        <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal"
                                                                            class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                    @else
                                                                        <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                            target="_blank" data-bs-toggle="modal"
                                                                            class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if ($matriks_user->contains('kategori', 'Persetujuan')  || $matriks_user->contains('kategori', 'Rekomendasi') || $matriks_user->contains('kategori', 'Verifikasi'))
                                                                    <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                        target="_blank" data-bs-toggle="modal"
                                                                        class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                @else
                                                                    @if ($is_user_exist_in_matriks_approval)
                                                                        @if ($matriks_user->contains('kategori', 'Pengajuan'))
                                                                            <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                                data-bs-toggle="modal"
                                                                                class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                        @elseif ($matriks_user->contains('kategori', 'Penyusun'))
                                                                            @if ($proyek->KriteriaPenggunaJasaDetail->count() > \App\Models\KriteriaPenggunaJasa::all()->count())
                                                                                <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                                    target="_blank" data-bs-toggle="modal"
                                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                            @else
                                                                                <a href="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}"
                                                                                    target="_blank" data-bs-toggle="modal"
                                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                            @endif                                                                        
                                                                        @endif 
                                                                    @else
                                                                        <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                            target="_blank"
                                                                            class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endif
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
                                                            @elseif($proyek->is_request_rekomendasi && !$proyek->review_assessment)
                                                                <small class="badge badge-light-primary">Proses
                                                                    Pengajuan</small>
                                                            @elseif($proyek->review_assessment == true && (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyusunan</small>
                                                            @elseif(!is_null($proyek->is_draft_recommend_note) && (!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) && is_null($proyek->is_verifikasi_approved))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Verifikasi</small>
                                                            @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Rekomendasi</small>
                                                            @elseif($proyek->is_recommended == true && is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-primary">Proses
                                                                    Penyetujuan</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- @php
                                                                $style = '';
                                                                if ($proyek->is_verifikasi_approved && $proyek->is_recommended && empty($proyek->recommended_with_note)) {
                                                                    $style = 'bg-success';
                                                                } elseif ($proyek->is_verifikasi_approved && $proyek->is_recommended && !empty($proyek->recommended_with_note)) {
                                                                    $style = 'bg-warning';
                                                                } elseif (!is_null($proyek->is_recommended) && !$proyek->is_recommended) {
                                                                    $style = 'bg-danger';
                                                                } else {
                                                                    $style = 'bg-secondary';
                                                                }

                                                                $matriks_category_array = $matriks_category->toArray(); 

                                                                if (array_key_exists($proyek->klasifikasi_pasdin, $matriks_category_array)) {
                                                                    $matriks_klasifikasi = $matriks_category_array[$proyek->klasifikasi_pasdin];
    
                                                                    if ($proyek->is_request_rekomendasi && !$proyek->review_assessment) {
                                                                        $kategori_approval = 'Pengajuan';
                                                                        if (array_key_exists('Pengajuan', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Pengajuan'];
                                                                        } else {
                                                                            $matriks_group = [];
                                                                            $collect_matriks = [];
                                                                        }
                                                                    } elseif ($proyek->review_assessment == true && is_null($proyek->is_verifikasi_approved)) {
                                                                        $kategori_approval = 'Penyusun';
                                                                        if (array_key_exists('Penyusun', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Penyusun'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_penyusun))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended)) {
                                                                        $kategori_approval = 'Rekomendasi';
                                                                        if (array_key_exists('Rekomendasi', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Rekomendasi'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_rekomendasi_final))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    } elseif ($proyek->is_recommended == true && is_null($proyek->is_disetujui)) {
                                                                        $kategori_approval = 'Persetujuan';
                                                                        if (array_key_exists('Persetujuan', $matriks_klasifikasi)) {
                                                                            $matriks_group = $matriks_category[$proyek->klasifikasi_pasdin]['Persetujuan'];
                                                                            $collect_matriks = collect(json_decode($proyek->approved_persetujuan))->keyBy('user_id');
                                                                        } else {
                                                                            $matriks_group = [];
                                                                        }
                                                                    }
                                                                }else {
                                                                    $matriks_group = [];
                                                                    $collect_matriks = [];
                                                                }
                                                            @endphp

                                                            <div class="text-center d-flex flex-row gap-2 flex-nowrap">
                                                                @foreach (!empty($matriks_group) ? $matriks_group->sortBy('urutan') : $matriks_group as $matriks)
                                                                @php
                                                                    if(!empty($collect_matriks)){
                                                                        $select_user = $collect_matriks?->filter(function($value, $key)use($matriks){
                                                                            return $key == $matriks->Pegawai->User->id;
                                                                        })->first();

                                                                        if (empty($select_user)) {
                                                                            $style = 'bg-secondary';
                                                                        }else{
                                                                            if ($select_user->status == "approved" && empty($select_user->alasan)) {
                                                                                $style = 'bg-success';
                                                                            }elseif ($select_user->status == "approved" && !empty($select_user->alasn)) {
                                                                                $style = 'bg-warning';
                                                                            }else{
                                                                                $style = 'bg-danger';
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                    <div class="circle {{ $style }} text-white"
                                                                        style="height:25px; width:25px; border-radius:50%;">
                                                                        <small>{{ $matriks->kode_unit_kerja }}</small>
                                                                    </div>
                                                                @endforeach
                                                            </div> --}}

                                                            <div class="circle bg-success"
                                                                style="height:25px; width:25px; border-radius:50%;">
                                                                <small><a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal"
                                                                    class="text-success">Klik</a></small>
                                                            </div>

                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $nilaiKriteriaPenggunaJasa = $proyek->KriteriaPenggunaJasaDetail?->sum('nilai') ?? null;
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
                                                                        case 'Risiko Risiko Tinggi':
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
                                                        <td>
                                                            @php
                                                                if (!empty($proyek->approved_persetujuan)) {
                                                                    $check_data = collect(json_decode($proyek->approved_persetujuan));
                                                                    if ($check_data->where('status', '=', 'rejected')->count() > 0) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif (!empty($proyek->persetujuan_note)) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                } elseif (!empty($proyek->approved_rekomendasi_final)) {
                                                                    $check_data = collect(json_decode($proyek->approved_rekomendasi_final));
                                                                    if (!is_null($proyek->is_recommended) && !$proyek->is_recommended) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('alasan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                } elseif (!empty($proyek->approved_penyusun)) {
                                                                    $check_data = collect(json_decode($proyek->approved_penyusun));
                                                                    if (!is_null($proyek->is_penyusun_approved) && !$proyek->is_penyusun_approved) {
                                                                        $status_rekomendasi = "Tidak Direkomendasikan";
                                                                        $style = "badge-light-danger";
                                                                    }elseif ($check_data->where('alasan', '!=', null)->count() > 0) {
                                                                        $status_rekomendasi = "Direkomendasikan dengan catatan";
                                                                        $style = "badge-light-warning";
                                                                    }else {
                                                                        $status_rekomendasi = "Direkomendasikan";
                                                                        $style = "badge-light-success";
                                                                    }
                                                                }else {
                                                                    $status_rekomendasi = "-";
                                                                    $style = "badge-light-secondary";
                                                                }
                                                            @endphp
                                                            <small>
                                                                <p class="badge {{ $style }} m-0">{{ $status_rekomendasi }}</p>
                                                            </small>
                                                        </td>
                                                        <td>-</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                                {{-- Begin :: Tab Content Proyek Pengajuan Rekomendasi --}}
                                <div class="tab-pane fade" id="kt_user_view_pengajuan" role="tabpanel">
                                    {{-- <a href="#" onclick="exportToExcel(this, '#rekomendasi-pengajuan')" class="btn btn-sm btn-success"><i class="bi bi-file-spreadsheet-fill"></i>Export to Excel</a> --}}
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-pengajuan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mengusulkan</th>
                                                <th class="min-w-auto">Risiko</th>
                                                {{-- <th class="min-w-auto">Status Pengajuan</th> --}}
                                                <th class="min-w-auto">Status Persetujuan</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks_pengajuan))
                                                @forelse ($proyeks_pengajuan as $proyek)
                                                    @php
                                                        $customer = $proyek->proyekBerjalan->Customer ?? null;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                                                        $is_approved =
                                                            $approved_data->every(function ($item) {
                                                                return !empty($item) && $item->status == 'approved';
                                                            }) && $approved_data->count() == $all_super_user_counter;
                                                        // dd($approved_data);
                                                        $is_review_assessment = false;
                                                        if ($is_approved) {
                                                            $is_review_assessment = $is_approved && empty($proyek->review_assessment);
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function ($d) {
                                                                return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                            });
                                                        }
                                                        $is_pending = !$is_approved && $approved_data->count() <= $all_super_user_counter;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            @if ($is_user_exist_in_matriks_approval)
                                                                <a href="#kt_modal_view_proyek_{{ $proyek->kode_proyek }}"
                                                                    data-bs-toggle="modal"
                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                            @else
                                                                <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                    target="_blank"
                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $provinsi = App\Models\Provinsi::find($proyek->provinsi)->first()->province_name;
                                                                } catch (\Throwable $th) {
                                                                    $provinsi = $proyek->provinsi;
                                                                }
                                                            @endphp
                                                            <small>{{ $provinsi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->name ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->jenis_instansi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $sumber_dana = App\Models\SumberDana::where('nama_sumber', '=', $customer->sumber_dana)->first()->nama_sumber;
                                                                } catch (\Throwable $th) {
                                                                    $sumber_dana = $proyek->sumber_dana;
                                                                }
                                                            @endphp
                                                            <small>{{ $sumber_dana ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ number_format((int) $proyek->nilaiok_awal, 0, '.', '.' ?? '0') }}</small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{ $proyek->klasifikasi_pasdin ?? '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if ($proyek->klasifikasi_pasdin == 'Proyek Kecil' || $proyek->klasifikasi_pasdin == 'Proyek Menengah')
                                                                    GM Pemasaran Operasi
                                                                @else
                                                                    Kepala Divisi Operasi
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $nilaiKriteriaPenggunaJasa = $proyek->KriteriaPenggunaJasaDetail?->sum('nilai') ?? null;
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
                                                                        case 'Risiko Risiko Tinggi':
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
                                                        {{-- <td> --}}
                                                        {{-- @if (($proyek->is_request_rekomendasi && !$proyek->review_assessment) || (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                @if (!empty(Auth::user()->Pegawai->MatriksApproval) && Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Pengajuan'))
                                                                    <small class="badge badge-light-warning">Request Pengajuan</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses Pengajuan</small>
                                                                @endif
                                                            @elseif ($proyek->review_assessment && is_null($proyek->recommended_with_note))
                                                                <small class="badge badge-light-primary">Proses Verifikasi</small>
                                                            @elseif ($proyek->review_assessment && (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                                                                <small class="badge badge-light-success">Pengajuan Disetujui</small>
                                                            @elseif ($proyek->review_assessment == false && $proyek->is_recommended == false && $proyek->is_disetujui == false)
                                                                <small class="badge badge-light-danger">Pengajuan Ditolak</small>
                                                            @endif --}}
                                                        {{-- @if ($proyek->review_assessment && $proyek->review_assessment && !$proyek->is_recommended && !$proyek->is_recommended_with_note)
                                                                <small class="badge badge-light-success">Pengajuan Disetujui</small>
                                                            @elseif($is_pending && $proyek->is_disetujui == null)
                                                                <small class="badge badge-light-info">Proses Pengajuan</small>
                                                            @elseif($is_review_assessment)
                                                                <small class="badge badge-light-primary">Review Assessment</small>
                                                            @elseif($proyek->is_recommended && empty($proyek->recommended_with_note))
                                                                <small class="badge badge-light-success">Direkomendasikan</small>
                                                            @elseif($proyek->is_recommended && !empty($proyek->recommended_with_note))
                                                                <small class="badge badge-light-success">Direkomendasikan dengan catatan</small>
                                                            @elseif(!$is_pending && !$proyek->is_recommended || !$proyek->review_assessment)
                                                                <small class="badge badge-light-danger">Tidak Direkomendasikan</small>
                                                            @endif --}}
                                                        {{-- </td> --}}
                                                        <td class="text-center">
                                                            {{-- @if ($proyek->is_disetujui)
                                                                <small class="badge badge-light-success">
                                                                    <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal" class="text-success">Disetujui</a>
                                                                </small>
                                                            @elseif($proyek->is_disetujui == false && !is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-danger">
                                                                    <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal" class="text-danger">Ditolak</a>
                                                                </small>
                                                            @elseif($proyek->is_request_rekomendasi && !$proyek->review_assessment)
                                                                <small class="badge badge-light-primary">Proses Pengajuan</small>
                                                                <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal"><i class="bi bi-pencil-fill"></i></a>
                                                            @elseif($proyek->review_assessment == true && is_null($proyek->is_verifikasi_approved))
                                                                <small class="badge badge-light-primary">Proses Penyusun</small>
                                                                <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal"><i class="bi bi-pencil-fill"></i></a>
                                                            @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended))
                                                                <small class="badge badge-light-primary">Proses Rekomendasi</small>
                                                                <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal"><i class="bi bi-pencil-fill"></i></a>
                                                            @elseif($proyek->is_recommended == true && is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-primary">Proses Penyetujuan</small>
                                                                <a href="#kt_modal_view_proyek_history_{{$proyek->kode_proyek}}" data-bs-toggle="modal"><i class="bi bi-pencil-fill"></i></a>
                                                            @endif --}}
                                                            <a href="#kt_modal_view_proyek_history_{{ $proyek->kode_proyek }}"
                                                                data-bs-toggle="modal"><i
                                                                    class="bi bi-exclamation-circle-fill fa-lg text-primary"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    title="Show Status"></i></i></a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <td><p>There is no data</p></td> --}}
                                                @endforelse
                                            @else
                                                {{-- <td><p>There is no data</p></td> --}}
                                            @endif

                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Proyek Pengajuan Rekomendasi --}}

                                {{-- Begin :: Tab Content Proyek Tabs Rekomendasi --}}
                                <div class="tab-pane fade" id="kt_user_view_rekomendasi" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-persetujuan">
                                        <!--begin::Table head-->
                                        <thead class="">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mengusulkan</th>
                                                <th class="min-w-auto">Score Assessment</th>
                                                <th class="min-w-auto">Tier</th>
                                                <th class="min-w-auto">Status Pengajuan</th>
                                                <th class="min-w-auto">Status Persetujuan</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks_rekomendasi))
                                                @forelse ($proyeks_rekomendasi as $proyek)
                                                    @php
                                                        $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                                                        $hasil_assessment = collect([json_decode($proyek->hasil_assessment)])->flatten();
                                                        $avg_score_assessment = $hasil_assessment->sum('score');
                                                        $is_approved =
                                                            $approved_data->every(function ($item) {
                                                                return !empty($item) && $item->status == 'approved';
                                                            }) && $approved_data->count() == $all_super_user_counter;
                                                        // dd($approved_data);
                                                        $is_review_assessment = false;
                                                        if ($is_approved) {
                                                            $is_review_assessment = $is_approved && empty($proyek->review_assessment);
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function ($d) {
                                                                return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                            });
                                                        }
                                                        $is_pending = !$is_approved && $approved_data->count() < $all_super_user_counter && !$proyek->is_recommended;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{-- <a href="#kt_modal_view_proyek_rekomendasi_{{$proyek->kode_proyek}}" target="_blank" data-bs-toggle="modal" class="text-hover-primary">{{ $proyek->nama_proyek }}</a>    --}}
                                                            @if ($proyek->KriteriaPenggunaJasaDetail->count() > \App\Models\KriteriaPenggunaJasa::all()->count())
                                                                <a href="#kt_modal_view_proyek_rekomendasi_{{ $proyek->kode_proyek }}"
                                                                    target="_blank" data-bs-toggle="modal"
                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                            @else
                                                                <a href="#kt_user_view_kriteria_{{ $proyek->kode_proyek }}"
                                                                    target="_blank" data-bs-toggle="modal"
                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $provinsi = App\Models\Provinsi::find($proyek->provinsi)->first()->province_name;
                                                                } catch (\Throwable $th) {
                                                                    $provinsi = $proyek->provinsi;
                                                                }
                                                            @endphp
                                                            <small>{{ $provinsi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->name ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->jenis_instansi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $sumber_dana = App\Models\SumberDana::where('nama_sumber', '=', $customer->sumber_dana)->first()->nama_sumber;
                                                                } catch (\Throwable $th) {
                                                                    $sumber_dana = $proyek->sumber_dana;
                                                                }
                                                            @endphp
                                                            <small>{{ $sumber_dana ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ number_format((int) $proyek->nilaiok_awal, 0, '.', '.' ?? '0') }}</small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{ $proyek->klasifikasi_pasdin ?? '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if ($proyek->klasifikasi_pasdin == 'Proyek Kecil' || $proyek->klasifikasi_pasdin == 'Proyek Menengah')
                                                                    GM Pemasaran Operasi
                                                                @else
                                                                    Kepala Divisi Operasi
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>{{ $avg_score_assessment }}</td>
                                                        <td>
                                                            @if ($customer->proyekBerjalans->where('stage', '=', 8)->count() > 0)
                                                                @if ($avg_score_assessment > 45)
                                                                    A
                                                                @elseif($avg_score_assessment < 45 && $avg_score_assessment > 25)
                                                                    B
                                                                @else
                                                                    C
                                                                @endif
                                                            @else
                                                                @if ($avg_score_assessment > 22.5)
                                                                    A
                                                                @elseif($avg_score_assessment < 22.5 && $avg_score_assessment > 15)
                                                                    B
                                                                @else
                                                                    C
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (
                                                                ($proyek->is_request_rekomendasi && !$proyek->review_assessment) ||
                                                                    (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Pengajuan'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Pengajuan</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Pengajuan</small>
                                                                @endif
                                                            @elseif ($proyek->review_assessment && is_null($proyek->recommended_with_note))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Verifikasi'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Verifikasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Verifikasi</small>
                                                                @endif
                                                            @elseif ($proyek->review_assessment && (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                                                                <small class="badge badge-light-success">Pengajuan
                                                                    Disetujui</small>
                                                            @endif
                                                            {{-- @dump(!$proyek->is_recommended || !$proyek->is_recommended_with_note) --}}
                                                            {{-- @if ($proyek->review_assessment && !$proyek->is_recommended && !$proyek->is_recommended_with_note)
                                                                <small class="badge badge-light-success">Pengajuan Disetujui</small>
                                                            @elseif($is_pending && $proyek->review_assessment && (!$proyek->is_recommended || !$proyek->is_recommended_with_note))
                                                                <small class="badge badge-light-info">Proses Pengajuan</small>
                                                            @elseif($is_review_assessment)
                                                                <small class="badge badge-light-primary">Review Assessment</small>
                                                            @elseif($proyek->is_recommended)
                                                                <small class="badge badge-light-success">Direkomendasikan</small>
                                                            @elseif($proyek->is_recommended_with_note)
                                                                <small class="badge badge-light-success">Direkomendasikan dengan catatan</small>
                                                            @elseif(!$proyek->is_recommended || !$is_approved)
                                                                <small class="badge badge-light-danger">Tidak Direkomendasikan</small>
                                                            @endif --}}
                                                        </td>
                                                        <td>
                                                            @if ($proyek->is_disetujui)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @elseif($proyek->is_disetujui == false && !is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-danger">Ditolak</small>
                                                            @elseif($proyek->review_assessment == true && is_null($proyek->is_verifikasi_approved))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Penyusun'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Verifikasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Verifikasi</small>
                                                                @endif
                                                            @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Rekomendasi'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Rekomendasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Rekomendasi</small>
                                                                @endif
                                                            @elseif($proyek->is_recommended == true && is_null($proyek->is_disetujui))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Penyetujuan'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Penyetujuan</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Penyetujuan</small>
                                                                @endif
                                                            @endif
                                                            {{-- @if ($proyek->is_disetujui)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @elseif(!is_null($proyek->is_disetujui) && ($proyek->is_recommended || $proyek->is_recommended_with_note))
                                                                <small class="badge badge-light-danger">Ditolak</small>
                                                            @elseif(!$proyek->is_recommended && empty($proyek->recommended_with_note))
                                                                <small class="badge badge-light-warning">Need Review</small>
                                                            @elseif(!$proyek->is_recommended && $is_pending || $proyek->review_assessment)
                                                                <small class="badge badge-light-primary">Request</small>
                                                            @endif --}}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <td><p>There is no data</p></td> --}}
                                                @endforelse
                                            @else
                                                {{-- <td><p>There is no data</p></td> --}}
                                            @endif

                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Proyek Tabs Rekomendasi --}}

                                {{-- Begin :: Tab Content Proyek Persetujuan Rekomendasi --}}
                                <div class="tab-pane fade" id="kt_user_view_persetujuan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-persetujuan">
                                        <!--begin::Table head-->
                                        <thead class="">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mengusulkan</th>
                                                <th class="min-w-auto">Status</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks_persetujuan))
                                                @forelse ($proyeks_persetujuan as $proyek)
                                                    @php
                                                        $customer = $proyek->proyekBerjalan->Customer;
                                                        $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
                                                        $is_approved = $approved_data->every(function ($item) {
                                                            return !empty($item) && $item->status == 'approved';
                                                        });
                                                        $is_data_null = $approved_data->every(function ($d) {
                                                            return $d == null;
                                                        });

                                                        if ($is_data_null) {
                                                            $approved_data = collect();
                                                        }

                                                        // dd($approved_data);
                                                        if ($is_approved) {
                                                            // $approved_data_first = $approved_data;
                                                        } else {
                                                            $is_user_id_exist = $approved_data->filter(function ($d) {
                                                                return !empty($d->user_id) && $d->user_id == Auth::user()->id;
                                                            });
                                                        }
                                                        $is_pending = $proyek->is_request_rekomendasi;
                                                        // dump($all_super_user_counter);
                                                        // dump($approved_data->count(), $all_super_user_counter);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="#kt_modal_view_proyek_persetujuan_{{ $proyek->kode_proyek }}"
                                                                target="_blank" data-bs-toggle="modal"
                                                                class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $provinsi = App\Models\Provinsi::find($proyek->provinsi)->first()->province_name;
                                                                } catch (\Throwable $th) {
                                                                    $provinsi = $proyek->provinsi;
                                                                }
                                                            @endphp
                                                            <small>{{ $provinsi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->name ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ $customer->jenis_instansi ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            @php
                                                                try {
                                                                    $sumber_dana = App\Models\SumberDana::where('nama_sumber', '=', $customer->sumber_dana)->first()->nama_sumber;
                                                                } catch (\Throwable $th) {
                                                                    $sumber_dana = $proyek->sumber_dana;
                                                                }
                                                            @endphp
                                                            <small>{{ $sumber_dana ?? '-' }}</small>
                                                        </td>
                                                        <td>
                                                            <small>{{ number_format((int) $proyek->nilaiok_awal, 0, '.', '.' ?? '0') }}</small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                {{ $proyek->klasifikasi_pasdin ?? '-' }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                @if ($proyek->klasifikasi_pasdin == 'Proyek Kecil' || $proyek->klasifikasi_pasdin == 'Proyek Menengah')
                                                                    GM Pemasaran Operasi
                                                                @else
                                                                    Kepala Divisi Operasi
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td>
                                                            @if ($proyek->is_disetujui)
                                                                <small class="badge badge-light-success">Disetujui</small>
                                                            @elseif($proyek->is_disetujui == false && !is_null($proyek->is_disetujui))
                                                                <small class="badge badge-light-danger">Ditolak</small>
                                                            @elseif($proyek->review_assessment == true && is_null($proyek->is_verifikasi_approved))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Penyusun'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Verifikasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Verifikasi</small>
                                                                @endif
                                                            @elseif($proyek->is_verifikasi_approved == true && is_null($proyek->is_recommended))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Rekomendasi'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Rekomendasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Rekomendasi</small>
                                                                @endif
                                                            @elseif($proyek->is_recommended == true && is_null($proyek->is_disetujui))
                                                                @if (
                                                                    !empty(Auth::user()->Pegawai->MatriksApproval) &&
                                                                        Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Penyetujuan'))
                                                                    <small class="badge badge-light-warning">Request
                                                                        Penyetujuan</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Proses
                                                                        Penyetujuan</small>
                                                                @endif
                                                                {{-- @elseif($proyek->is_recommended != null && $proyek->is_verifikasi_approved && $proyek->is_disetujui == null)
                                                                @if (Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Persetujuan'))
                                                                    <small class="badge badge-light-info">Procces in Rekomendasi</small>
                                                                @elseif (Auth::user()->Pegawai->MatriksApproval->contains("kategori", "Rekomendasi"))
                                                                    <small class="badge badge-warning">Need Rekomendasi</small>
                                                                @else
                                                                    <small class="badge badge-light-primary">Request to Rekomendasi</small>
                                                                @endif
                                                            @elseif($proyek->is_recommended == true && $proyek->review_assessment && $proyek->is_disetujui == null)
                                                                @if (Auth::user()->Pegawai->MatriksApproval->contains('kategori', 'Persetujuan'))
                                                                    <small class="badge badge-warning">Need Approval</small>
                                                                @elseif (Auth::user()->Pegawai->MatriksApproval->contains("kategori", "Rekomendasi"))
                                                                    <small class="badge badge-light-primary">Request Persetujuan</small>
                                                                @else
                                                                    @if ($proyek->is_verifikasi_approved)
                                                                        <small class="badge badge-light-primary">Request Persetujuan</small>
                                                                    @else
                                                                        <small class="badge badge-warning">Need Submit</small>
                                                                    @endif
                                                                @endif --}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <td><p>There is no data</p></td> --}}
                                                @endforelse
                                            @else
                                                {{-- <td><p>There is no data</p></td> --}}
                                            @endif

                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Proyek Persetujuan Rekomendasi --}}
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
    @foreach ($proyeks_proses_rekomendasi as $proyek)
        <form action="/kriteria-pengguna-jasa/detail/save" method="POST" id="form-kriteria-{{ $proyek->kode_proyek }}"
            enctype="multipart/form-data">
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
                                            $legalitasJasa = App\Models\LegalitasPerusahaan::all();
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
                                                <input type="file" name="dokumen_penilaian[]"
                                                    form="form-kriteria-{{ $proyek->kode_proyek }}" id="dokumen_kriteria"
                                                    class="form-control form-control-sm form-control-solid">
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
                                            $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::all();
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
                                                    <input type="file" name="dokumen_penilaian[]"
                                                        form="form-kriteria-{{ $proyek->kode_proyek }}"
                                                        id="dokumen_kriteria"
                                                        class="form-control form-control-sm form-control-solid">
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
                                form="form-kriteria-{{ $proyek->kode_proyek }}" id="new_save"
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
    @foreach ($proyeks_proses_rekomendasi as $key => $proyek)
    @php
        $is_edit = !$proyek->is_request_rekomendasi && is_null($proyek->is_verifikasi_approved) && ((!is_null($proyek->is_draft_recommend_note) && $proyek->is_draft_recommend_note) || is_null($proyek->is_draft_recommend_note));
    @endphp
        @if ($is_edit)
            <form action="/kriteria-pengguna-jasa/detail/edit" method="POST"
                id="form-edit-kriteria-{{ $proyek->kode_proyek }}" enctype="multipart/form-data">
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
                                        $legalitasJasa = App\Models\LegalitasPerusahaan::all();
                                        $kriteriaDetails = App\Models\KriteriaPenggunaJasaDetail::where('kode_proyek', $proyek->kode_proyek)
                                            ->orderBy('index')
                                            ->get()
                                            ->unique('index');
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
                                            @if (
                                                $matriks_user?->contains('kategori', 'Rekomendasi') &&
                                                    (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                                                <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$index]->id_document) : '' }}"
                                                    class="text-hover-primary">{{ $kriteriaDetails[$index]->id_document }}</a>
                                            @else
                                                <input type="file" name="dokumen_penilaian[]"
                                                    form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                    id="dokumen_kriteria"
                                                    class="form-control form-control-sm form-control-solid"
                                                    {{ $is_edit ? '' : 'disabled' }}>
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
                                                            <tr>
                                                                <td>
                                                                    <small>
                                                                        <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$index]->id_document) : '' }}"
                                                                            class="text-hover-primary">{{ $kriteriaDetails[$index]->id_document }}</a>
                                                                    </small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <i class="bi bi-trash3-fill text-danger"></i>
                                                                </td>
                                                            </tr>
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
                                        $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::all();
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
                                                        (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                                                    <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$keys + 1]->id_document) : '' }}"
                                                        class="text-hover-primary">{{ $kriteriaDetails[$keys + 1]->id_document }}</a>
                                                @else
                                                    <input type="file" name="dokumen_penilaian[]"
                                                        form="form-edit-kriteria-{{ $proyek->kode_proyek }}"
                                                        id="dokumen_kriteria"
                                                        class="form-control form-control-sm form-control-solid"
                                                        {{ $is_edit ? '' : 'disabled' }}>
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
                                                                <tr>
                                                                    <td>
                                                                        <small>
                                                                            <a href="{{ $kriteriaDetails->isNotEmpty() ? asset('file-kriteria-pengguna-jasa' . '\\' . $kriteriaDetails[$keys + 1]->id_document) : '' }}"
                                                                                class="text-hover-primary">{{ $kriteriaDetails[$keys + 1]->id_document }}</a>
                                                                        </small>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <i class="bi bi-trash3-fill text-danger"></i>
                                                                    </td>
                                                                </tr>
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
                                (!is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note))
                            <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                data-bs-dismiss="modal" style="background-color:#008CB4">Close</button>
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
        @if ($is_edit)
            </form>
        @endif
    @endforeach
    {{-- End::Tab Content Kriteria Pengguna Jasa --}}

    <!--Begin::Root-->
    @php
        $proyeks = $is_super_user ? $proyeks_persetujuan : $proyeks_pengajuan;
    @endphp
    @foreach ($proyeks_proses_rekomendasi as $proyek)
        <div class="modal fade" id="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_{{ $proyek->kode_proyek }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <iframe src="{{asset("file-rekomendasi" . "\\" . $proyek->file_rekomendasi)}}" width="800px" height="600px" ></iframe>
                            </div>
                        @endif --}}
                        @if (!empty($proyek->file_pengajuan))
                            <hr>
                            <h5>File Preview: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @php
                            $approved_data = collect([json_decode($proyek->approved_rekomendasi)])->flatten();
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
                        @if (
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
                                value="Ditolak dengan alasan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($proyeks_proses_rekomendasi as $proyek)
        @php
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_exist_customer = $proyek->proyekBerjalan?->customer;
            $internal_score = 0;
            $eksternal_score = 0;

            // if ($is_exist_customer) {
            //     $internal_score = $scorePenggunaJasa;
            //     $eksternal_score = $scorePenggunaJasa;
            // }else{
            //     $eksternal_score = $scorePenggunaJasa;
            // }
            if ($hasil_assessment->isNotEmpty()) {
                if (is_null($is_exist_customer)) {
                    $internal_score = $hasil_assessment->sum(function ($ra) {
                        if ($ra->kategori == 'Internal') {
                            return $ra->score;
                        }
                    });
                }
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
                    @if (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note)
                        <form action="" method="GET">
                    @endif
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        $proyek->KriteriaPenggunaJasaDetail
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
                                                    // dd($item, $nilaiKriteriaPenggunaJasa);
                                                    if ($item->dari_nilai <= $nilaiKriteriaPenggunaJasa && $item->sampai_nilai >= $nilaiKriteriaPenggunaJasa) {
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
                        @if (!empty($proyek->file_pengajuan))
                            <h5>Form Pengajuan Rekomendasi: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-pengajuan' . '\\' . $proyek->file_pengajuan) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                        @endif
                        @if (!empty($proyek->file_rekomendasi))
                            <hr>
                            <h5>Hasil Assessment: </h5>
                            <div class="text-center">
                                <iframe src="{{ asset('file-rekomendasi' . '\\' . $proyek->file_rekomendasi) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer row">
                        {{-- @php
                                $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                                $is_user_exist = $approved_verifikasi->contains("user_id", Auth::user()->id);
                                dump($)
                            @endphp --}}
                        @if (is_null($proyek->is_recommended))
                            <label for="note-rekomendasi" class="text-start">Catatan: </label>
                            <textarea class="form-control form-control-solid" id="note-rekomendasi" name="note-rekomendasi" rows="10"
                                {{ !is_null($proyek->is_draft_recommend_note) && !$proyek->is_draft_recommend_note || empty($matriks_user) ? 'readonly' : '' }}>{!! is_null($proyek->is_draft_recommend_note)
                                    ? 'Profile Risiko Pengguna Jasa = ' . $text . ' (Score : ' . $nilaiKriteriaPenggunaJasa . ")\n\n"
                                    : $proyek->recommended_with_note !!}</textarea>
                            <br>
                            @csrf
                            <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
                            @if ((is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note) && !empty($matriks_user))
                                <input type="submit" name="save-draft-note-rekomendasi" value="Simpan Sebagai Draft"
                                    class="btn btn-sm btn-primary">
                                <input type="submit" name="input-rekomendasi-with-note" value="Submit"
                                    class="btn btn-sm btn-success">
                            @endif
                        @elseif(!$proyek->is_recommended)
                            <span class="badge badge-light-danger">Ditolak</span>
                        @elseif($proyek->is_recommended)
                            <span class="badge badge-light-success">Direkomendasikan</span>
                        @elseif($proyek->is_recommended_with_note)
                            <span class="badge badge-light-success">Direkomendasikan dengan catatan</span>
                        @endif
                    </div>
                    @if (is_null($proyek->is_draft_recommend_note) || $proyek->is_draft_recommend_note)
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($proyeks_proses_rekomendasi as $proyek)
        @php
            $hasil_assessment = collect(json_decode($proyek->hasil_assessment));
            $is_exist_customer = $proyek->proyekBerjalan?->customer;
            $internal_score = 0;
            $eksternal_score = 0;

            // if ($is_exist_customer) {
            //     $internal_score = $scorePenggunaJasa;
            //     $eksternal_score = $scorePenggunaJasa;
            // }else{
            //     $eksternal_score = $scorePenggunaJasa;
            // }

            if ($hasil_assessment->isNotEmpty()) {
                if (is_null($is_exist_customer)) {
                    $internal_score = $hasil_assessment->sum(function ($ra) {
                        if ($ra->kategori == 'Internal') {
                            return $ra->score;
                        }
                    });
                }
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
                                        <td>Assessment Eksternal Atas Pengguna Jasa</td>
                                        <td>{{ $eksternal_score ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Assessment Internal Atas Pengguna Jasa</td>
                                        <td>{{ $internal_score ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Catatan</td>
                                        <td>
                                            <p class="p-0">{!! nl2br($proyek->recommended_with_note) ?? '-' !!}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>

                            @if (!empty($proyek->file_persetujuan))
                                <hr>
                                <h5>Hasil Rekomendasi: </h5>
                                <div class="text-center">
                                    <iframe src="{{ asset('file-persetujuan' . '\\' . $proyek->file_persetujuan) }}"
                                        width="800px" height="600px"></iframe>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer row">

                            {{-- <label for="note-rekomendasi" class="text-start">Catatan Rekomendasi: </label>
                            <textarea class="form-control" id="note-rekomendasi" name="note-rekomendasi"></textarea>
                            <br> --}}
                            @php
                                $approved_verifikasi = collect(json_decode($proyek->approved_verifikasi));
                                $is_user_exist_penyusun = $approved_verifikasi->contains('user_id', Auth::user()->id);

                                $approved_rekomendasi_final = collect(json_decode($proyek->approved_rekomendasi_final));
                                $is_user_exist_rekomendasi = $approved_rekomendasi_final->contains('user_id', Auth::user()->id);

                                $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
                                $is_user_exist_persetujuan = $approved_persetujuan->contains('user_id', Auth::user()->id);
                            @endphp
                            @if (!empty($matriks_user))
                                @if (is_null($proyek->is_verifikasi_approved) &&
                                        $matriks_user->contains('kategori', 'Verifikasi') &&
                                        !$is_user_exist_penyusun)
                                    <form action="" method="get">
                                        @csrf
                                        <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                            id="kode-proyek">

                                        <input type="submit" name="verifikasi-setujui" value="Submit"
                                            class="btn btn-sm btn-success">
                                        <input type="submit" name="verifikasi-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                                    </form>
                                @elseif (is_null($proyek->is_recommended) &&
                                        $matriks_user->contains('kategori', 'Rekomendasi') &&
                                        $proyek->is_verifikasi_approved &&
                                        !$is_user_exist_rekomendasi)
                                    <form action="" method="get">
                                        @csrf
                                        <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                            id="kode-proyek">
                                        <span><b>Hasil Kriteria Pengguna Jasa</b> <a
                                                href="#kt_user_edit_kriteria_{{ $proyek->kode_proyek }}"
                                                class="btn btn-sm btn-primary" data-bs-toggle="modal">Lihat</a></span>
                                        <br>
                                        <button type="button" data-bs-toggle="modal" id="show-modal-tolak"
                                            style="display: none"
                                            data-bs-target="#kt_modal_view_proyek_tolak_rekomendasi_{{ $proyek->kode_proyek }}">clickhere</button>
                                        <label for="kategori-rekomendasi" class="text-start"><span class="required">Kategori
                                                Rekomendasi: </span></label>
                                        {{-- <select onchange="disableEnableTextArea(this)" id="kategori-rekomendasi" name="kategori-rekomendasi" --}}
                                        {{-- <select id="kategori-rekomendasi" onchange="showModalTolakRekomendasi(this, '{{$proyek->kode_proyek}}')" name="kategori-rekomendasi" --}}
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
                                        <label for="kategori-rekomendasi" class="text-start"><span class="required">Catatan:
                                            </span></label>
                                        <textarea name="alasan-ditolak" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                                        <br>
                                        <input type="submit" class="btn btn-sm btn-success" name="rekomendasi-setujui"
                                            value="Submit">
                                    </form>
                                @elseif (is_null($proyek->is_disetujui) &&
                                        $matriks_user?->contains('kategori', 'Persetujuan') &&
                                        $proyek->is_recommended &&
                                        !$is_user_exist_persetujuan)
                                    <form action="" method="get">
                                        @csrf
                                        @if (!empty($nip))
                                            <input type="hidden" value="{{ $nip }}" name="user"
                                                id="user">
                                        @endif
                                        <input type="hidden" value="{{ $proyek->kode_proyek }}" name="kode-proyek"
                                            id="kode-proyek">
                                        <label class="text-start"><b>Catatan Penyusun:</b></label>
                                        <p>{!! nl2br($proyek->recommended_with_note) !!}</p>
                                        <br>
                                        <label class="text-start"><b>Catatan Rekomendasi:</b></label>
                                        {{-- @dump(json_decode($proyek->approved_rekomendasi_final)[0]->alasan) --}}
                                        @php
                                            $alasan = collect(json_decode($proyek->approved_rekomendasi_final));
                                        @endphp
                                        @foreach ($alasan as $note)
                                        <span>
                                            {{ App\Models\User::find($note->user_id)->name }} :
                                            <p>{!! nl2br($note->alasan) !!}</p>
                                        </span>
                                            
                                        @endforeach
                                        <br>
                                        <label for="" class="text-start"><span class="required">Catatan:
                                            </span></label>
                                        <textarea name="catatan-persetujuan" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                                        <input type="submit" name="persetujuan-setujui" value="Disetujui"
                                            class="btn btn-sm btn-success">
                                        <input type="button" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_view_proyek_tolak_persetujuan_{{ $proyek->kode_proyek }}"
                                            name="persetujuan-tolak" value="Ditolak" class="btn btn-sm btn-danger">
                                    </form>
                                @else
                                    @if ($proyek->is_disetujui)
                                        <small class="badge badge-light-success">Disetujui</small>
                                    @elseif ($proyek->review_assessment)
                                        <small class="badge badge-light-primary">Request</small>
                                    @elseif($proyek->is_disetujui == false || $proyek->is_verifikasi_approved == false || $proyek->is_recommended == false)
                                        <small class="badge badge-light-danger">Ditolak</small>
                                    @endif
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
                            <input type="submit" name="persetujuan-tolak" class="btn btn-sm btn-danger"
                                value="Ditolak dengan alasan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($proyek_approval_finish as $proyek)
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
                            $approved_pengajuan = collect(json_decode($proyek->approved_rekomendasi));
                            $approved_penyusun = collect(json_decode($proyek->approved_penyusun));
                            $approved_rekomendasi = collect(json_decode($proyek->approved_rekomendasi_final));
                            $approved_persetujuan = collect(json_decode($proyek->approved_persetujuan));
                            $data_approved_merged = collect();
                            if ($approved_pengajuan->isNotEmpty() || $approved_penyusun->isNotEmpty() || $approved_verifikasi->isNotEmpty() || $approved_rekomendasi->isNotEmpty() || $approved_persetujuan->isNotEmpty()) {
                                $data_approved_merged = collect()->mergeRecursive(['Pengajuan' => $approved_pengajuan->flatten(), 'Penyusun' => $approved_penyusun->flatten(), 'Rekomendasi' => $approved_rekomendasi->flatten(), 'Persetujuan' => $approved_persetujuan->flatten()]);
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
                                                                        <b>{{ App\Models\User::find($d->user_id)->Pegawai->Jabatan->nama_jabatan }}</b><br>
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
                                                                            @if ($d->status == 'approved' && !empty($d->alasan))
                                                                                <b>Direkomendasikan Dengan Catatan</b>
                                                                            @elseif ($d->status == 'approved')
                                                                                <b>Direkomendasikan</b>
                                                                            @else
                                                                                <b class="text-danger">Tidak
                                                                                    Direkomendasikan</b>
                                                                            @endif
                                                                        @endif
                                                                        <br>

                                                                        @if (!empty($d->alasan))
                                                                            Alasan:
                                                                            <b>{!! $d->alasan !!}</b><br>
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
    <!--end::Modals-->
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
        $(document).ready(function() {
            $("#rekomendasi-pengajuan").DataTable({
                // dom: '<"float-start"f><"#example"t>rtip',
                // dom: 'Brti',
                dom: 'Bfrtip',
                pageLength: 20,
                buttons: [
                    'excel'
                ],
            });

            setTimeout(() => {
                const exportBtn = document.querySelectorAll(".buttons-excel");
                exportBtn.forEach(item => {
                    item.style.display = "none";
                });
            }, 0);

            const rekomendasiOpen = "{{ $rekomendasi_open ?? null }}";
            if (rekomendasiOpen) {
                const modalOpen = document.querySelector(`#${rekomendasiOpen}`);
                const modalOpenBoots = new bootstrap.Modal(modalOpen, {});
                modalOpenBoots.show();
            }
        });
    </script>


    <script>
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
        function disableEnableTextArea(e) {
            const value = e.value;
            if (value == "Direkomendasikan" || value == "Tidak Direkomendasikan") {
                // e.parentElement.querySelector("#note-rekomendasi").setAttribute("readonly", true);
                if (!e.parentElement.querySelector("#note-rekomendasi").hasAttribute("disabled")) {
                    e.parentElement.querySelector("#note-rekomendasi").setAttribute("disabled", true);
                }
            } else {
                // e.parentElement.querySelector("#note-rekomendasi").removeAttribute("readonly");
                e.parentElement.querySelector("#note-rekomendasi").removeAttribute("disabled");
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
@endsection
