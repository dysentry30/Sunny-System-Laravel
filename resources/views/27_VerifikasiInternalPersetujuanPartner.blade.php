@extends('template.main')
@section('title', 'Verifikasi Internal Persetujuan Partner')

@section('content')

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
    </style>


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
                                <h1 class="d-flex align-items-center fs-3 my-1">Approval Verifikasi Internal Persetujuan KSO
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
                            <div class="card-title">
                                <div class="d-flex align-items-center my-width="100%" height="800px"">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab Assessment-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_dalam_proses"
                                                style="font-size:14px;">Dalam Proses</a>
                                        </li>
                                        <!--end:::Tab Assessment-->
                                        <!--begin:::Tab Assessment-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_prosess_selesai"
                                                style="font-size:14px;">Proses Selesai</a>
                                        </li>
                                        <!--end:::Tab Assessment-->

                                </div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body px-6 pt-0">
                            <div id="tab-content" class="tab-content">
                                <!--Begin::Dalam Proses-->
                                <div class="tab-pane fade show active" id="kt_view_dalam_proses" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2"
                                        id="proses-verifikasi">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Jenis Proyek</th>
                                                <th class="min-w-auto">Klasifikasi Proyek</th>
                                                <th class="min-w-auto">Nilai Proyek</th>
                                                <th class="min-w-auto" colspan="2">Status Pengajuan</th>
                                                <th class="min-w-auto">Hasil Pengajuan</th>
                                                <th class="min-w-auto">Revisi</th>
                                                <th class="min-w-auto">Progress</th>
                                                <th class="min-w-auto">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <!--begin::Table row-->
                                            @foreach ($dataProyekProsesVerifikasi as $item)
                                                <tr>
                                                    <td>{{ $item->Proyek->nama_proyek }}</td>
                                                    <td class="text-center">{{ $item->UnitKerja->unit_kerja }}</td>
                                                    <td class="text-center">{{ $item->Proyek->jenis_proyek == "J" ? "JO" : ($item->Proyek->jenis_proyek == "I" ? "Internal" : ($item->Proyek->jenis_proyek == "N" ? "Eksternal" : ""))  }}</td>
                                                    <td class="text-center">{{ $item->Proyek->klasifikasi_pasdin }}</td>
                                                    <td class="text-end">{{ number_format($item->Proyek->nilaiok_awal, 0, '', '.') }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $style = '';
                                                            $matriks_group = [];

                                                            $matriks_category_array = $matriks_category->toArray();

                                                            if (!$item->is_pengajuan_approved) {
                                                                $kategori_approval = 'Pengajuan';
                                                                if (array_key_exists('Pengajuan', $matriks_category_array) && !empty($matriks_category_array['Pengajuan'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi])) {
                                                                    $collect_matriks = collect(json_decode($item->pengajuan_approved))->keyBy('nip');
                                                                    $matriks_group = $matriks_category_array['Pengajuan'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi];
                                                                } else {
                                                                    $matriks_group = [];
                                                                    $collect_matriks = [];
                                                                }
                                                            } elseif ($item->is_pengajuan_approved == true && is_null($item->is_pengusul_approved)) {
                                                                $kategori_approval = 'Pengusul';
                                                                if (array_key_exists('Pengusul', $matriks_category_array) && !empty($matriks_category_array['Pengusul'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi])) {
                                                                    $matriks_group = $matriks_category_array['Pengusul'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi];
                                                                    $collect_matriks = collect(json_decode($item->rekomendasi_approved))->keyBy('nip');
                                                                } else {
                                                                    $matriks_group = [];
                                                                }
                                                            } elseif ($item->is_pengusul_approved == true && is_null($item->is_rekomendasi_approved)) {
                                                                $kategori_approval = 'Rekomendasi';
                                                                if (array_key_exists('Rekomendasi', $matriks_category_array) && !empty($matriks_category_array['Rekomendasi'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi])) {
                                                                    $matriks_group = $matriks_category_array['Rekomendasi'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi];
                                                                    $collect_matriks = collect(json_decode($item->rekomendasi_approved))->keyBy('nip');
                                                                } else {
                                                                    $matriks_group = [];
                                                                }
                                                            } elseif ($item->is_rekomendasi_approved == true && is_null($item->is_persetujuan_approved)) {
                                                                $kategori_approval = 'Persetujuan';
                                                                if (array_key_exists('Persetujuan', $matriks_category_array) && !empty($matriks_category_array['Persetujuan'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi])) {
                                                                    $matriks_group = $matriks_category_array['Persetujuan'][$item->Proyek->departemen_proyek][$item->Proyek->UnitKerja->Divisi->id_divisi];
                                                                    $collect_matriks = collect(json_decode($item->persetujuan_approved))->keyBy('nip');
                                                                } else {
                                                                    $matriks_group = [];
                                                                }
                                                            }
                                                        @endphp

                                                        {{-- @dump($matriks_group) --}}
                                                        <div class="text-center d-flex flex-row gap-2 flex-nowrap">
                                                            @forelse (!empty($matriks_group) ? collect($matriks_group)->sortBy('urutan') : $matriks_group as $key => $matriks)
                                                                @php
                                                                    if (!empty($collect_matriks) && $collect_matriks->isNotEmpty()) {
                                                                        $select_user = $collect_matriks
                                                                            ?->filter(function ($value, $key) use ($matriks, $collect_matriks) {
                                                                                return $key == \App\Models\User::where('nip', '=', $matriks['nama_pegawai'])->first()?->nip;
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
                                                    <td class="text-center">
                                                        <p class="m-0 badge badge-sm bg-primary">{{ $item->stage }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="m-0 badge badge-sm {{ !is_null($item->is_persetujuan_approved) && $item->is_persetujuan_approved ? "bg-success" : (!is_null($item->is_persetujuan_approved) && !$item->is_persetujuan_approved ? "bg-danger" : "bg-primary") }}">{{ !is_null($item->is_persetujuan_approved) && $item->is_persetujuan_approved ? "Disetujui" : (!is_null($item->is_persetujuan_approved) && !$item->is_persetujuan_approved ? "Ditolak" : "On Process") }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->is_revisi)
                                                            <a href="" class="badge badge-sm bg-primary">Lihat Catatan Revisi</a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="circle bg-success" style="height:25px; width:25px; border-radius:50%;">
                                                            <a href="#kt_modal_view_proyek_history_{{ $item->id }}" data-bs-toggle="modal" class="text-success">Klik</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->Proyek->is_cancel)
                                                            <p class="m-0 badge badge-sm bg-danger">Proyek Cancel</p>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{-- @canany(['super-admin', 'approver-crm', 'risk-crm']) --}}
                                                        @canany(['access-menu-approve'], 'PPPS')
                                                            @if ($item->is_persetujuan_approved)
                                                                <button class="btn btn-sm btn-primary" onclick="showModalAction('kt_modal_final', '{{ $item->kode_proyek }}')">Lihat</button>
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $item->divisi_id)->where('departemen_code', $item->departemen_id)->where('kategori', 'Persetujuan')->first() && $item->is_rekomendasi_approved)
                                                                @if (is_null($item->is_rekomendasi_approved) || (($matriks_user->filter(function($value)use($item){
                                                                    return $value->divisi_id == $item->divisi_id &&
                                                                    $value->departemen_code == $item->departemen_id &&
                                                                    $value->kategori == "Persetujuan" &&
                                                                    $value->urutan > 1;
                                                                })->count() > 0 && (collect(json_decode($item->persetujuan_approved))->isEmpty()))))

                                                                @else
                                                                    @if ($item->is_persetujuan_approved || (collect(json_decode($item->persetujuan_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($item->persetujuan_approved))?->first()?->status == 'approved'))
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_persetujuan_verifikasi_{{ $item->kode_proyek }}">Lihat</button>
                                                                    @else
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_persetujuan_verifikasi_{{ $item->kode_proyek }}">Approve</button>
                                                                    @endif
                                                                @endif
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $item->divisi_id)->where('departemen_code', $item->departemen_id)->where('kategori', 'Rekomendasi')->first() && $item->is_pengajuan_approved)
                                                                @if (is_null($item->is_pengusul_approved) || (($matriks_user->filter(function($value)use($item){
                                                                    return $value->divisi_id == $item->divisi_id &&
                                                                    $value->departemen_code == $item->departemen_id &&
                                                                    $value->kategori == "Rekomendasi" &&
                                                                    $value->urutan > 1;
                                                                })->count() > 0 && (collect(json_decode($item->rekomendasi_approved))->isEmpty()))))
                                                                @else
                                                                    @if ($item->is_rekomendasi_approved || (collect(json_decode($item->rekomendasi_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($item->rekomendasi_approved))?->first()?->status == 'approved'))
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_rekomendasi_verifikasi_{{ $item->kode_proyek }}">Lihat</button>
                                                                    @else
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_rekomendasi_verifikasi_{{ $item->kode_proyek }}">Approve</button>
                                                                    @endif
                                                                @endif
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $item->divisi_id)->where('departemen_code', $item->departemen_id)->where('kategori', 'Pengusul')->first() && $item->is_pengajuan_approved)
                                                                @if (is_null($item->is_pengajuan_approved) || (($matriks_user->filter(function($value)use($item){
                                                                    return $value->divisi_id == $item->divisi_id &&
                                                                    $value->departemen_code == $item->departemen_id &&
                                                                    $value->kategori == "Pengusul" &&
                                                                    $value->urutan > 1;
                                                                })->count() > 0 && (collect(json_decode($item->pengusul_approved))->isEmpty()))))
                                                                @else
                                                                    @if ($item->is_pengusul_approved || (collect(json_decode($item->pengusul_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($item->pengusul_approved))?->first()?->status == 'approved'))
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_pengusul_verifikasi_{{ $item->kode_proyek }}">Lihat</button>
                                                                    @else
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_pengusul_verifikasi_{{ $item->kode_proyek }}">Approve</button>
                                                                    @endif
                                                                @endif
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $item->divisi_id)->where('departemen_code', $item->departemen_id)->where('kategori', 'Pengajuan')->first() && is_null($item->is_pengajuan_approved))
                                                                @if (!$item->is_request_pengajuan || (($matriks_user->filter(function($value)use($item){
                                                                    return $value->divisi_id == $item->divisi_id &&
                                                                    $value->departemen_code == $item->departemen_id &&
                                                                    $value->kategori == "Pengajuan" &&
                                                                    $value->urutan > 1;
                                                                })->count() > 0 && (collect(json_decode($item->pengajuan_approved))->isEmpty()))))
                                                                @else
                                                                    @if ($item->is_pengajuan_approved || (collect(json_decode($item->pengajuan_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($item->pengajuan_approved))?->first()?->status == 'approved'))
                                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_pengajuan_verifikasi_{{ $item->kode_proyek }}">Lihat</button>
                                                                    @else
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_pengajuan_verifikasi_{{ $item->kode_proyek }}">Approve</button>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endcanany
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!--end::Table row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                                <!--End::Dalam Proses-->
                                <!--Begin::Proses Approval Selesai-->
                                <div class="tab-pane fade" id="kt_view_prosess_selesai" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2"
                                        id="proses-selesai-verifikasi">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Jenis Proyek</th>
                                                <th class="min-w-auto">Klasifikasi Proyek</th>
                                                <th class="min-w-auto">Nilai Proyek</th>
                                                <th class="min-w-auto">Hasil Pengajuan</th>
                                                <th class="min-w-auto">Progress</th>
                                                <th class="min-w-auto">Is Cancel</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <!--begin::Table row-->
                                            @foreach ($dataProyekFinishVerifikasi as $item)
                                                <tr>
                                                    <td>{{ $item->Proyek->nama_proyek }}</td>
                                                    <td class="text-center">{{ $item->UnitKerja->unit_kerja }}</td>
                                                    <td class="text-center">{{ $item->Proyek->jenis_proyek == "J" ? "JO" : ($item->Proyek->jenis_proyek == "I" ? "Internal" : ($item->Proyek->jenis_proyek == "N" ? "Eksternal" : ""))  }}</td>
                                                    <td class="text-center">{{ $item->Proyek->klasifikasi_pasdin }}</td>
                                                    <td class="text-end">{{ number_format($item->Proyek->nilaiok_awal, 0, '', '.') }}</td>
                                                    <td class="text-center">
                                                        <p class="m-0 badge badge-sm {{ !is_null($item->is_persetujuan_approved) && $item->is_persetujuan_approved ? "bg-success" : (!is_null($item->is_persetujuan_approved) && !$item->is_persetujuan_approved ? "bg-danger" : "bg-primary") }}">{{ !is_null($item->is_persetujuan_approved) && $item->is_persetujuan_approved ? "Disetujui" : (!is_null($item->is_persetujuan_approved) && !$item->is_persetujuan_approved ? "Ditolak" : "On Process") }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="circle bg-success" style="height:25px; width:25px; border-radius:50%;">
                                                            <a href="#kt_modal_view_proyek_history_final_{{ $item->id }}" data-bs-toggle="modal" class="text-success">Klik</a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->Proyek->is_cancel)
                                                            <p class="m-0 badge badge-sm bg-danger">Proyek Cancel</p>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{-- @canany(['super-admin', 'admin-crm', 'approver-crm', 'risk-crm']) --}}
                                                        @canany(['access-menu-read', 'access-menu-lock', 'access-menu-approve'], 'PPPS')
                                                            @if (!is_null($item->is_persetujuan_approved) && $item->is_persetujuan_approved)
                                                                <a href="{{ asset('file-nota-rekomendasi-2\\file-verifikasi-internal-persetujuan-partner\\') . $item->nama_dokumen }}" class="btn btn-sm btn-primary text-white" target="_blank">Download</a>
                                                            @endif
                                                        @endcanany
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!--end::Table row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                                <!--End::Proses Approval Selesai-->
                            </div>
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


    <!--Begin::Modal Pengajuan-->
    @foreach ($dataProyekProsesVerifikasi as $proyek)
        <form action="/verifikasi-internal-persetujuan-partner/pengajuan/{{ $proyek->id }}" method="post" onsubmit="addLoading(this)">
            @csrf
            <div class="modal fade" id="kt_modal_pengajuan_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-labelledby="kt_modal_pengajuan_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pengajuan Verifikasi Internal</h5>
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
                                        <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nama Pengguna Jasa</td>
                                        <td>{{ $proyek->Proyek->proyekBerjalan?->Customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Nilai Penawaran</td>
                                        <td>Rp.{{ number_format($proyek->Proyek->nilaiok_awal, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kategori Proyek</td>
                                        <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h2>Form Verifikasi Persetujuan KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentVerifikasi(this, '{{ $proyek->nama_dokumen }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                        </div>
                        @if ($proyek->is_pengajuan_approved || (collect(json_decode($proyek->pengajuan_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($proyek->pengajuan_approved))?->first()?->status == 'approved'))
                        @else
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-danger" type="button" onclick="showModalRevisi('{{ $proyek->kode_proyek }}', 'pengajuan', '{{ $proyek->id }}')">Ajukan Revisi</button>
                            <input type="submit" name="is_approved" value="Setujui" class="btn btn-sm btn-success">
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </form>

        <form action="/verifikasi-internal-persetujuan-partner/pengusul/{{ $proyek->id }}" method="post" onsubmit="addLoading(this)">
            @csrf
            <div class="modal fade" id="kt_modal_pengusul_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-labelledby="kt_modal_pengusul_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pengusul Verifikasi Internal</h5>
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
                                        <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nama Pengguna Jasa</td>
                                        <td>{{ $proyek->Proyek->proyekBerjalan?->Customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Nilai Penawaran</td>
                                        <td>Rp.{{ number_format($proyek->Proyek->nilaiok_awal, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kategori Proyek</td>
                                        <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h2>Form Verifikasi Persetujuan KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentVerifikasi(this, '{{ $proyek->nama_dokumen }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                        </div>
                        @if ($proyek->is_pengusul_approved || (collect(json_decode($proyek->pengusul_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($proyek->pengusul_approved))?->first()?->status == 'approved'))
                        @else
                        <div class="modal-footer">
                            {{-- <button class="btn btn-sm btn-danger" type="button" onclick="showModalRevisi('{{ $proyek->kode_proyek }}', 'pengusul', '{{ $proyek->id }}')">Ajukan Revisi</button> --}}
                            <input type="submit" name="is_approved" value="Setujui" class="btn btn-sm btn-success">
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </form>

        <form action="/verifikasi-internal-persetujuan-partner/rekomendasi/{{ $proyek->id }}" method="post" onsubmit="addLoading(this)">
            @csrf
            <div class="modal fade" id="kt_modal_rekomendasi_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-labelledby="kt_modal_rekomendasi_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Rekomendasi Verifikasi Internal</h5>
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
                                        <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nama Pengguna Jasa</td>
                                        <td>{{ $proyek->Proyek->proyekBerjalan?->Customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Nilai Penawaran</td>
                                        <td>Rp.{{ number_format($proyek->Proyek->nilaiok_awal, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kategori Proyek</td>
                                        <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h2>Form Verifikasi Persetujuan KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentVerifikasi(this, '{{ $proyek->nama_dokumen }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                            <br>
                            <hr>
                            <h2>Form Assessment Partner KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentAssessment(this, '{{ $proyek->kode_proyek }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                        </div>
                        @if ($proyek->is_rekomendasi_approved || (collect(json_decode($proyek->rekomendasi_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($proyek->rekomendasi_approved))?->first()?->status == 'approved'))
                        
                        @else
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-danger" type="button" onclick="showModalRevisi('{{ $proyek->kode_proyek }}', 'rekomendasi', '{{ $proyek->id }}')">Ajukan Revisi</button>
                            <input type="submit" name="is_approved" value="Rekomendasikan" class="btn btn-sm btn-success">
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </form>

        <form action="/verifikasi-internal-persetujuan-partner/persetujuan/{{ $proyek->id }}" method="post" onsubmit="addLoading(this)">
            @csrf
            <div class="modal fade" id="kt_modal_persetujuan_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-labelledby="kt_modal_persetujuan_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Persetujuan Verifikasi Internal</h5>
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
                                        <td>{{ $proyek->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nama Pengguna Jasa</td>
                                        <td>{{ $proyek->Proyek->proyekBerjalan?->Customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Nilai Penawaran</td>
                                        <td>Rp.{{ number_format($proyek->Proyek->nilaiok_awal, 0, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kategori Proyek</td>
                                        <td>{{ $proyek->Proyek->klasifikasi_pasdin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h2>Form Verifikasi Persetujuan KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentVerifikasi(this, '{{ $proyek->nama_dokumen }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                            <br>
                            <hr>
                            <h2>Form Assessment Partner KSO &nbsp;&nbsp;<span><i class="bi bi-eye-fill fs-3 text-hover-primary" style="cursor: pointer;" onclick="showDocumentAssessment(this, '{{ $proyek->kode_proyek }}')"></i></span></h2>
                            <div class="text-center">
                                
                            </div>
                        </div>
                        @if ($proyek->is_persetujuan_approved || (collect(json_decode($proyek->persetujuan_approved))->contains('nip', auth()->user()->nip) && collect(json_decode($proyek->persetujuan_approved))?->first()?->status == 'approved'))
                        @else
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-danger" type="button" onclick="showModalRevisi('{{ $proyek->kode_proyek }}', 'persetujuan', '{{ $proyek->id }}')">Ajukan Revisi</button>
                            <input type="submit" name="is_approved" value="Setujui" class="btn btn-sm btn-success">
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </form>

        <form action="" method="post" onsubmit="addLoading(this)">
            @csrf
            <div class="modal fade" id="kt_modal_revisi_verifikasi_{{ $proyek->kode_proyek }}" tabindex="-1"
                aria-labelledby="kt_modal_revisi_verifikasi_{{ $proyek->kode_proyek }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Revisi Verifikasi Internal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan-revisi" id="catatan-revisi" cols="30" rows="15" class="form-control form-control-solid"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <input type="submit" name="revisi" value="Revisi" class="btn btn-sm btn-success">
                        </div>
                    </div>
                </div>
            </div> 
        </form>

        <!--Begin::Modal Revisi Note-->
        <div class="modal fade" id="kt_modal_view_proyek_history_{{ $proyek->id }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_history_{{ $proyek->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">History Verifikasi Penentuan Proyek KSO / Non KSO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $pengajuan = collect(json_decode($proyek->pengajuan_approved));
                            $pengusul = collect(json_decode($proyek->pengusul_approved));
                            $rekomendasi = collect(json_decode($proyek->rekomendasi_approved));
                            $persetujuan = collect(json_decode($proyek->persetujuan_approved));

                            $data_approved_merged = collect();
                            if ($pengajuan->isNotEmpty() || $persetujuan->isNotEmpty() || $rekomendasi->isNotEmpty() || $pengusul->isNotEmpty()) {
                                $data_approved_merged = collect()->mergeRecursive(['Pengajuan' => $pengajuan->flatten(), 'Pengusul' => $pengusul->flatten(), 'Rekomendasi' => $rekomendasi->flatten(), 'Persetujuan' => $persetujuan->flatten()]);
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
                                                                    <b>{{ App\Models\User::where("nip",$d->nip)->first()->name ?? "-" }}</b><br>
                                                                    Jabatan:
                                                                    <b>{{ App\Models\User::where("nip",$d->nip)->first()->Pegawai->Jabatan?->nama_jabatan ?? "-" }}</b><br>
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
                                                                        <b>{{ $d->tanggal }}</b>
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
                                    @endif
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
        <!--End::Modal Revisi Note-->
    @endforeach
    <!--End::Modal Pengajuan-->

    @foreach ($dataProyekFinishVerifikasi as $proyek)
        <!--Begin::Modal Revisi Note-->
        <div class="modal fade" id="kt_modal_view_proyek_history_final_{{ $proyek->id }}" tabindex="-1"
            aria-labelledby="kt_modal_view_proyek_history_{{ $proyek->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">History Verifikasi Penentuan Proyek KSO / Non KSO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $pengajuan = collect(json_decode($proyek->pengajuan_approved));
                            $pengajuan = collect(json_decode($proyek->pengajuan_approved));
                            $rekomendasi = collect(json_decode($proyek->rekomendasi_approved));
                            $persetujuan = collect(json_decode($proyek->persetujuan_approved));

                            $data_approved_merged = collect();
                            if ($pengajuan->isNotEmpty() || $persetujuan->isNotEmpty() || $rekomendasi->isNotEmpty() || $pengusul->isNotEmpty()) {
                                $data_approved_merged = collect()->mergeRecursive(['Pengajuan' => $pengajuan->flatten(), 'Pengusul' => $pengusul->flatten(), 'Rekomendasi' => $rekomendasi->flatten(), 'Persetujuan' => $persetujuan->flatten()]);
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
                                                                    <b>{{ App\Models\User::where("nip",$d->nip)->first()->name ?? "-" }}</b><br>
                                                                    Jabatan:
                                                                    <b>{{ App\Models\User::where("nip",$d->nip)->first()->Pegawai->Jabatan?->nama_jabatan ?? "-" }}</b><br>
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
                                                                        <b>{{ $d->tanggal }}</b>
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
                                    @endif
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
        <!--End::Modal Revisi Note-->
    @endforeach

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
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })
        function addLoading(elt) {
            LOADING_BODY.block();
            elt.form.submit();
        }
        $('#proses-verifikasi').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            order: [
                [0, 'desc']
            ],
            buttons: [
                'excel'
            ]
        });
        $('#proses-selesai-verifikasi').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            order: false,
            buttons: [
                'excel'
            ]
        });
    </script>

    <script>
        function deleteBackdrop() {
            let backdrop = document.querySelector('.modal-backdrop');
            backdrop.remove();
        }
    </script>

    <script>
        async function getDataProyek(kodeProyek) {
            try {
                const res = await fetch(`/proyek/get-data-proyek/${kodeProyek}`).then(res => res.json());
                if (res.success) {
                    return res.data
                }
                alert(res.message);
            } catch (error) {
                alert(error)
            }
        }

        async function showModalAction(id_modal, kodeProyek) {
            LOADING_BODY.block();
            const dataProyek = await getDataProyek(kodeProyek);
            LOADING_BODY.release();

            const modalId = document.getElementById(id_modal)
            const modalSelected = new bootstrap.Modal(modalId);

            const modalBody = modalId.querySelector('.modal-body');
            const modalFooter = modalId.querySelector('.modal-footer');

            let dataPersetujuanApproval = null;
            let dataRekomendasiApproval = null;
            let dataPengajuanApproval = null;
            let dataRequestApproval = null;

            if (dataProyek.verifikasi_internal_persetujuan_partner != null) {
                if (dataProyek.verifikasi_proyek_nota_2.persetujuan_approved != null) {
                    dataPersetujuanApproval = JSON.parse(dataProyek.verifikasi_proyek_nota_2.persetujuan_approved);
                }

                if (dataProyek.verifikasi_proyek_nota_2.rekoemdasi_approved != null) {
                    dataRekomendasiApproval = JSON.parse(dataProyek.verifikasi_proyek_nota_2.rekoemdasi_approved);
                }

                if (dataProyek.verifikasi_proyek_nota_2.pengajuan_approved != null) {
                    dataPengajuanApproval = JSON.parse(dataProyek.verifikasi_proyek_nota_2.pengajuan_approved);
                }

                if (dataProyek.verifikasi_proyek_nota_2.request_pengajuan != null) {
                    dataRequestApproval = JSON.parse(dataProyek.verifikasi_proyek_nota_2.request_pengajuan);
                }
            }

            let htmlSelected = `
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
                        <td>${dataProyek.nama_proyek}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Nama Pengguna Jasa</td>
                        <td>${dataProyek.proyek_berjalan.customer.name}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Lokasi</td>
                        <td>${dataProyek.provinsi.province_name}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Nilai Penawaran</td>
                        <td>${new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(dataProyek.nilaiok_awal)}</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Kategori Proyek</td>
                        <td>${dataProyek.klasifikasi_pasdin}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <hr>
            <h4>File Preview</h4>
            <iframe src="${dataProyek.dokumen_verifikasi_path}" width="100%" height="800px"></iframe>
            `
            modalBody.innerHTML = htmlSelected;

            let htmlFooter = null;

            if (id_modal == "kt_modal_pengajuan") {
                if (dataRequestApproval != null && dataPengajuanApproval) {
                    
                }
                htmlFooter = `
                <button class="btn btn-sm btn-danger" onclick="showModalRevisi()">Ajukan Revisi</button>
                <input type="submit" name="setuju" value="Setujui" class="btn btn-sm btn-success">
                `                
            }





            modalSelected.show();
            
        }

        function showModalRevisi(kode_proyek, kategori, id) {
            const modalId = document.getElementById(`kt_modal_revisi_verifikasi_${kode_proyek}`)
            const modalSelected = new bootstrap.Modal(modalId);

            const form = modalId.parentElement.setAttribute('action', `/verifikasi-internal-persetujuan-partner/${kategori}/${id}`)

            modalSelected.show();
        }

        function showDocumentVerifikasi(elt, link) {
            try {
                const containerDocument = elt.parentElement.parentElement.nextElementSibling;
                const classAttributes = elt.getAttribute("class");
                 
                if (classAttributes.includes("bi-eye-fill")) {
                    if (containerDocument.children.length < 1) {
                        const iframeElt = document.createElement("iframe");
                        iframeElt.src = `{{ asset('file-nota-rekomendasi-2/file-verifikasi-internal-persetujuan-partner') . "/" }}${link}`;
                        iframeElt.setAttribute("width", "100%");
                        iframeElt.setAttribute("height", "800px");

                        containerDocument.appendChild(iframeElt);
                    }else{
                        containerDocument.style.display = ""; 
                    }
                    elt.classList.remove("bi-eye-fill");
                    elt.classList.add("bi-eye-slash-fill");
                }else{
                    elt.classList.remove("bi-eye-slash-fill");
                    elt.classList.add("bi-eye-fill");
                    containerDocument.style.display = "none";
                }

                
            } catch (error) {
                alert(error.message);
            }            
        }

        async function showDocumentAssessment(elt, kodeProyek) {
            try {
                const containerDocument = elt.parentElement.parentElement.nextElementSibling;
                const classAttributes = elt.getAttribute("class");
                const isTrue = '{{ auth()->user()->email == "m.abdi@wikamail.id" }}';
                
                 
                if (classAttributes.includes("bi-eye-fill")) {
                    if (containerDocument.children.length < 1) {
                        const res = await fetch(`/verifikasi-internal-persetujuan-partner/get-dokumen/${kodeProyek}`).then(res => res.json());
                        let files = [];
                        if (res.success) {
                            files = res.data;
                            files?.forEach(file => {
                                const iframeElt = document.createElement("iframe");
                                iframeElt.src = `{{ asset('file-nota-rekomendasi-2/file-kriteria-partner') . "/" }}${file}`;
                                iframeElt.setAttribute("width", "100%");
                                iframeElt.setAttribute("height", "800px");
        
                                containerDocument.appendChild(iframeElt);

                                if (isTrue == 1) {
                                    const a = document.createElement('a');
                                    a.href = `{{ asset('file-nota-rekomendasi-2/file-kriteria-partner') . "/" }}${file}`;
                                    a.download = '';
                                    document.body.appendChild(a);
                                    a.click();
                                    document.body.removeChild(a);  // Clean up
                                }
                            });
                        }                        
                    }else{
                        containerDocument.style.display = ""; 
                    }
                    elt.classList.remove("bi-eye-fill");
                    elt.classList.add("bi-eye-slash-fill");
                }else{
                    elt.classList.remove("bi-eye-slash-fill");
                    elt.classList.add("bi-eye-fill");
                    containerDocument.style.display = "none";
                }

                
            } catch (error) {
                alert(error.message);
            }            
        }
    </script>
@endsection
