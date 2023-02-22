{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'CCM Dashboard')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')

    <style>
        .chart-outer {
            display: flex;
        }

        .highcharts-data-table {
            background: white;
            min-width: 30%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            font-size: 15px;
        }

        .highcharts-data-table th {
            pointer-events: none; 
        }

        #highcharts-data-table-0,
        #highcharts-data-table-1 {
            margin: 0;
        }

        .highcharts-data-table table {
            border-collapse: collapse;
            border-spacing: 0;
            background: white;
            min-width: 100%;
            margin-top: 10px;
            font-family: sans-serif;
            font-size: 0.9em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            border: 0px solid silver;
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tbody tr:hover {
            background: #1c99dc;
            color: white
        }

        .highcharts-data-table tbody tr:hover td {
            color: white
        }

        .highcharts-data-table caption {
            border-bottom: none;
            font-size: 1.1em;
            font-weight: bold;
        }

        [role="progressbar"] {
            /* transition: all 1.5s cubic-bezier(0.165, 0.840, 0.440, 1.000); */
            transition: width 1s ease-in-out;
        }

    </style>

    <div class="background-blur"></div>

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
                    <div style=" height:auto" class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                            class="d-flex align-items-center flex-wrap me-3 row">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard | CCM
                                </h1>
                                <!--end::Title-->
                                <div class="row">
                                    <div class="col">
                                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm/perolehan-kontrak" style="font-size:14px;">Perolehan Kontrak</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm/pelaksanaan-kontrak" style="font-size:14px;">Pelaksanaan Kontrak</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active"
                                                    href="/dashboard-ccm/pemeliharaan-kontrak" style="font-size:14px;">Pemeliharaan Kontrak</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->
                    
                    <!--begin::Content-->
                    <!--begin::Body Dashboard-->
                    <div id="dashboard-body" style="overflow-x: hidden" class="mt-3">

                        <!--Begin :: Filter-->
                        <div class="card">
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-3">
                                        <select onchange="selectFilter(this)" id="dop" name="dop"
                                                class="form-select form-select-solid w-auto"
                                                style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                data-placeholder="Direktorat" data-select2-id="select2-data-dop" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($dops as $dop)
                                                    <option value="{{ $dop->dop }}" {{ $dop_get == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option>
                                                @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <select onchange="selectFilter(this)" id="unit-kerja" name="unit-kerja"
                                                class="form-select form-select-solid w-auto"
                                                style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($unit_kerjas as $unit_kerjas)
                                                    <option value="{{ $unit_kerjas->divcode }}" {{ $unit_kerja_get == $unit_kerjas->divcode ? 'selected' : '' }} >{{ $unit_kerjas->unit_kerja }}</option>
                                                @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <select onchange="selectFilter(this)" id="proyek" name="proyek"
                                                class="form-select form-select-solid w-auto"
                                                style="margin-right: 2rem;" data-control="select2" data-hide-search="false"
                                                data-placeholder="Proyek" data-select2-id="select2-data-proyek" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($contracts_pemeliharaan as $p)
                                                    <option value="{{ $p->project_id }}" {{ $proyek_get == $p->project_id ? 'selected' : '' }} >{{ $p->project->nama_proyek }} ({{$p->project_id}})</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <form action="" method="GET">
                                            <button type="submit" class="btn btn-secondary">Reset</button>
                                        </form>
                                    </div>
                                </div> --}}
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-2">                                        
                                            <select onchange="this.form.submit()" id="dop" name="dop"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Direktorat" data-select2-id="select2-data-dop" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($dops as $dop)
                                                        <option value="{{ $dop->dop }}" {{ $dop_get == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select onchange="this.form.submit()" id="unit-kerja" name="unit-kerja"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($unit_kerjas as $unit_kerjas)
                                                        <option value="{{ $unit_kerjas->divcode }}" {{ $unit_kerja_get == $unit_kerjas->divcode ? 'selected' : '' }} >{{ $unit_kerjas->unit_kerja }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select onchange="selectFilter(this)" id="kode-proyek" name="proyek"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="false"
                                                    data-placeholder="Proyek" data-select2-id="select2-data-proyek" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($contracts_pemeliharaan as $kontrak)
                                                        <option value="{{ $kontrak->project_id }}" {{ $proyek_get == $kontrak->project_id ? 'selected' : '' }} >{{ $kontrak->nama_proyek }} ({{ $kontrak->project_id }})</option>
                                                        {{-- <option value="{{ $proyek->kode_proyek }}" >{{ $proyek->nama_proyek }} ({{$proyek->kode_proyek}})</option> --}}
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select id="bulan" name="bulan"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option {{ $month == '' ? 'selected' : '' }}></option>
                                                    <option value="1" {{ $bulan_get == 1 ? 'selected' : '' }}>Januari</option>
                                                    <option value="2" {{ $bulan_get == 2 ? 'selected' : '' }}>Februari</option>
                                                    <option value="3" {{ $bulan_get == 3 ? 'selected' : '' }}>Maret</option>
                                                    <option value="4" {{ $bulan_get == 4 ? 'selected' : '' }}>April</option>
                                                    <option value="5" {{ $bulan_get == 5 ? 'selected' : '' }}>Mei</option>
                                                    <option value="6" {{ $bulan_get == 6 ? 'selected' : '' }}>Juni</option>
                                                    <option value="7" {{ $bulan_get == 7 ? 'selected' : '' }}>Juli</option>
                                                    <option value="8" {{ $bulan_get == 8 ? 'selected' : '' }}>Agustus</option>
                                                    <option value="9" {{ $bulan_get == 9 ? 'selected' : '' }}>September</option>
                                                    <option value="10" {{ $bulan_get == 10 ? 'selected' : '' }}>Oktober</option>
                                                    <option value="11" {{ $bulan_get == 11 ? 'selected' : '' }}>November</option>
                                                    <option value="12" {{ $bulan_get == 12 ? 'selected' : '' }}>Desember</option>
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select id="tahun" name="tahun"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Tahun" data-select2-id="select2-data-tahun" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($tahun as $t)
                                                        <option value="{{$t}}" {{ $tahun_get == $t ? 'selected' : '' }}>{{$t}}</option>
                                                    @endforeach 
                                            </select>
                                        </div>
                                        
                                        <div class="col-2" data-control="select-2" data-select2-id="select-data-submit">
                                                <button type="submit" class="btn btn-light btn-active-primary">Filter</button>
                                                <button type="button" onclick="resetFilter()" class="btn btn-light btn-active-primary">Reset</button>
                                                <script>
                                                    function resetFilter() {
                                                        window.location.href = "/dashboard-ccm/pelaksanaan-kontrak";
                                                    }
                                                </script>
                                        </div>

                                </div>
                            </form>
                            </div>
                        </div>
                        <!--End :: Filter-->

                        <br>

                        <!--begin::Title-->
                        <div class="mb-4">
                            <div class="col-12">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">{{ "SP00".sprintf("%02d", mt_rand(0, 99)) }}- {{ $proyek->UnitKerja->unit_kerja }} &nbsp; - &nbsp; {{ $proyek->nama_proyek }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Title-->
                        <div class="mb-4">
                            <div class="col-12">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">Pemilik Pekerjaan : {{ $proyek->proyekBerjalan->name_customer ?? 'NA' }} &nbsp; - &nbsp; Nilai Kontrak : Rp {{ number_format($proyek->nilai_perolehan, 0, ".", ".") }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        @php
                        if (!empty($proyek->ContractManagements->ContractBast)) {
                            $bast_1 = $proyek->ContractManagements->ContractBast->filter(function($item){
                                return $item->bast == 1;
                            })->first();
                            $bast_2 = $proyek->ContractManagements->ContractBast->filter(function($item){
                                return $item->bast == 2;
                            })->first();
                        }else {
                            $bast_1 = "-";
                            $bast_2 = "-";
                        };
                        @endphp
                        <!--begin::Row-->
                        <div class="row mb-0">
                            <!--begin::Card-->
                            <div class="ms-6 col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RA START</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_mulai_terkontrak)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                                <!--begin::Card widget 20-->
                                <div class="mt-3 rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RI KONTRAK</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_akhir_terkontrak)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RA EFEKTIF </span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_akhir_terkontrak)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                                <!--begin::Card widget 20-->
                                <div class="mt-3 rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RI EFEKTIF</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_akhir_terkontrak)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--begin::Card-->
                            <!--end::Card-->
                            <div class="col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RA BAST 1</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_selesai_fho)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                                <!--begin::Card widget 20-->
                                <div class="mt-3  rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RI BAST 1</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ !empty($bast_1) ? Carbon\Carbon::create($bast_1->tanggal_dokumen)->translatedFormat("d M Y") : "-"  }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RA BAST 2</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ Carbon\Carbon::create($proyek->tanggal_selesai_fho)->translatedFormat("d M Y") ?? "-" }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                                <!--begin::Card widget 20-->
                                <div class="mt-3 rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-2 opacity-75 fw-bold text-white me-2 lh-1 ls-n2" id="data-items">RI BAST 2</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white pt-1 fs-3">{{ !empty($bast_2) ? Carbon\Carbon::create($bast_2->tanggal_dokumen)->translatedFormat("d M Y") : "-"  }}</span>
                                            <!--end::Subtitle-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="py-0 rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #027DB8;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            <!--begin::Amount-->
                                            <span class="fs-1 fw-bold text-white me-2 lh-1 ls-n2 opacity-75" id="data-items">PROJECT STATUS</span>
                                            <!--end::Amount-->
                                        </div>  
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Header-->
                                    <div class="card-body py-7">
                                        <!--begin::Subtitle-->
                                        @if (empty($proyek->tanggal_mulai_terkontrak))
                                        <span class="text-white fs-1">Persiapan</span>
                                        @elseif ($proyek->tanggal_mulai_terkontrak < now()->translatedFormat("Y-m-d") && $proyek->tanggal_akhir_terkontrak > now()->translatedFormat("Y-m-d") )
                                        <span class="text-white fs-1">Pelaksanaan</span>
                                        @elseif ($proyek->tanggal_selesai_pho )
                                        <span class="text-white fs-1">Pemeliharaan</span>
                                        @elseif ($proyek->tanggal_selesai_fho < now()->translatedFormat("Y-m-d") )
                                        <span class="text-white fs-1">Proyek Selesai</span>
                                        @else
                                        <span class="text-white fs-1">-</span>
                                        @endif 
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col pt-0">
                                <!--begin::Card widget 20-->
                                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #BB2F5D; border-radius: 0%">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            @php
                                                $timeStatus = mt_rand(10, 95);
                                                $timePending = 100 - (int) $timeStatus;
                                            @endphp
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ !empty($time_status) ? $time_status : "0%" }}</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">TIME STATUS</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex align-items-end pt-0 pb-6">
                                        <!--begin::Progress-->
                                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                                            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                <span>{{ !empty($time_status) ? $time_status : "0%" }}</span>
                                                {{-- <span>-{{ $timePending }}%</span> --}}
                                            </div>
                                            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $time_status }};" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <!--end::Progress-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col pt-0 me-6">
                                <!--begin::Card widget 20-->
                                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #9D4C83; border-radius: 0%">
                                    <!--begin::Header-->
                                    <div class="card-header pt-5">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex flex-column">
                                            @php
                                                $progresStatus = mt_rand(10, 95);
                                                $progresPending = 100 - (int) $progresStatus;
                                            @endphp
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $percen_progress_status }}</span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">PROGRESS STATUS</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex align-items-end pt-0 pb-6">
                                        <!--begin::Progress-->
                                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                                            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                <span>{{ $percen_progress_status }}</span>
                                                {{-- <span>-{{ $progresPending }}%</span> --}}
                                            </div>
                                            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ (int)$percen_progress_status }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <!--end::Progress-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Card Diagram-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            {{-- <div class="col-2 ">
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    @if (empty($proyek->ContractManagements))
                                                    <a target="_blank" class="text-gray-800 fs-3" href="#">Lihat Kontrak</a>
                                                    @else    
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/contract-management/view/{{ urlencode(urlencode($proyek->ContractManagements->id_contract)) }}">Lihat Kontrak</a>
                                                    @endif
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/proyek/view/{{ $proyek->kode_proyek }}">Lihat Proyek</a>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    @if (empty($proyek->ContractManagements))
                                                    <a target="_blank" class="text-gray-800 fs-3" href="#">Lihat Kontrak</a>
                                                    @else    
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/contract-management/view/{{ urlencode(urlencode($proyek->ContractManagements->id_contract)) }}">Lihat Kontrak</a>
                                                    @endif
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/proyek/view/{{ $proyek->kode_proyek }}">Lihat Proyek</a>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    @if (empty($proyek->ContractManagements))
                                                    <a target="_blank" class="text-gray-800 fs-3" href="#">Lihat Kontrak</a>
                                                    @else    
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/contract-management/view/{{ urlencode(urlencode($proyek->ContractManagements->id_contract)) }}">Lihat Kontrak</a>
                                                    @endif
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/proyek/view/{{ $proyek->kode_proyek }}">Lihat Proyek</a>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    @if (empty($proyek->ContractManagements))
                                                    <a target="_blank" class="text-gray-800 fs-3" href="#">Lihat Kontrak</a>
                                                    @else    
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/contract-management/view/{{ urlencode(urlencode($proyek->ContractManagements->id_contract)) }}">Lihat Kontrak</a>
                                                    @endif
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                                <!--begin::Link-->
                                <div class="col mb-4">
                                    <!--begin::Card body-->
                                    <div class="pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #E4E6EF;background-image:url('/assets/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Card body-->
                                            <div class="btn rounded-0 btn-active-primary card-body d-flex align-items-end pt-3">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column  w-100">
                                                    <a target="_blank" class="text-gray-800 fs-3" href="/proyek/view/{{ $proyek->kode_proyek }}">Lihat Proyek</a>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Link-->
                            </div> --}}
                            <!--end begin::Card column-->
                            <div class="col-12">
                                
                                <!--begin::Title-->
                                <div class="mb-4">
                                    <div class="col-12">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-secondary">
                                            <h2 class="m-0 text-center">Resume CCM</h2>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                </div>
                                <!--end::Title-->

                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::COLUMN CHART-->
                                            <div id="contract-divisi"></div>
                                            <!-- data table is inserted here -->
                                            <!--end::COLUMN CHART-->
                                    </div>
                                    <!--end-begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::PIE CHART-->
                                            <figure class="highcharts-figure">
                                                <div id="changes-status"></div>
                                                <!-- data table is inserted here -->
                                            </figure>
                                            <!--end::PIE CHART-->
                                    </div>
                                    <!--end::Card column-->
                                </div>
                                <!--end::Row-->

                                {{-- <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::COLUMN CHART-->
                                            <div id="contract-stage"></div>
                                            <!-- data table is inserted here -->
                                            <!--end::COLUMN CHART-->
                                    </div>
                                    <!--end-begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::PIE CHART-->
                                            <figure class="highcharts-figure">
                                                <div id="contract-divisi"></div>
                                                <!-- data table is inserted here -->
                                            </figure>
                                            <!--end::PIE CHART-->
                                    </div>
                                    <!--end::Card column-->
                                </div>

                                <div class="row">
                                    <!--begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::COLUMN CHART-->
                                            <div id="contract-classification"></div>
                                            <!-- data table is inserted here -->
                                            <!--end::COLUMN CHART-->
                                    </div>
                                    <!--end-begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::PIE CHART-->
                                            <figure class="highcharts-figure">
                                                <div id="contract-jo"></div>
                                                <!-- data table is inserted here -->
                                            </figure>
                                            <!--end::PIE CHART-->
                                    </div>
                                    <!--end::Card column-->
                                </div>
                                <!--end::Row-->
                                <div class="row">
                                    <!--begin::Card column-->
                                    <div class="col">
                                            <!--begin::COLUMN CHART-->
                                            <div id="changes-status"></div>
                                            <!-- data table is inserted here -->
                                            <!--end::COLUMN CHART-->
                                    </div>
                                </div> --}}
                            </div>
                            <!--end::Card column-->
                        </div>
                        <!--end::Card Diagram-->

                        <br>

                        <!--begin::Tabel Header-->
                        <div class="row mb-4 mx-3">
                            <div class="col-2">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-success">
                                    <h2 class="m-0 text-center">URAIAN</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-success">
                                    <h2 class="m-0 text-center">POTENTIAL</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-success">
                                    <h2 class="m-0 text-center">SUBS</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-4">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="py-2 bg-success">
                                    <h4 class="m-0 text-center">SUBMISIONS STATUS</h4>
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="m-0 text-center">REVISION</h6>
                                        </div>
                                        <div class="col">
                                            <h6 class="m-0 text-center">NEGOITATION</h6>
                                        </div>
                                        <div class="col">
                                            <h6 class="m-0 text-center">APPROVED</h6>
                                        </div>
                                        <div class="col">
                                            <h6 class="m-0 text-center">REJECTED</h6>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-success">
                                    <h2 class="m-0 text-center">DISPUTE</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Tabel Header-->

                        <!--begin::Table Body-->
                        @foreach ($detail_perubahan_kontrak as $table)
                        {{-- @dd($table) --}}
                        <div class="row mb-4 mx-3">
                            <div class="col-2">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-success">
                                    <h2 class="m-0 text-center">{{ $table[0] }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[4] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[5] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[6] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[7] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[8] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[9] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                            <div class="col">
                                <!--begin::Title body-->
                                <a href="/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $proyek->ContractManagements->id_contract }}">
                                    <!--begin::Title body-->
                                    <div style="border-radius: 0px" class="card-body bg-secondary">
                                        <h2 class="m-0 text-center">{{ $table[10] ?? 0 }}</h2>
                                    </div>
                                    <!--end::Title body-->
                                </a>
                                <!--end::Title body-->
                            </div>
                        </div>
                        @endforeach
                        <!--end::Table Body-->
                        
                        <br>

                        <!--begin::Tabel Header-->
                        <div class="row mb-4 mx-3">
                            <div class="col-9">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">CCM STATUS</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center"><i class="bi bi-percent text-dark fs-3"></i> PERUBAHAN VS KONTRAK</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Tabel Header-->

                        <!--begin::Table Body-->
                        @foreach ($detail_perubahan_kontrak as $table)
                        {{-- @dd($table) --}}
                        <div class="row mb-4 mx-3">
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">{{ $table[0] }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">{{ $table[1] }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-5">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">Rp {{ number_format($table[2], 0, ".", ".") }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">{{ $table[3] }} </h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        @endforeach
                        <!--end::Table Body-->

                        <!--begin::Tabel Header-->
                        <div class="row mb-4 mx-3">
                            <div class="col-9">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">TOTAL NILAI PERUBAHAN : Rp {{ number_format($total_pengajuan, 0, ".", ".") }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">{{ $persentasePerubahan }}</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Tabel Header-->

                        <br>

                        <!--begin::Title-->
                        <div class="mb-4">
                            <div class="col-12">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">KPI - Key Performance Index</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Card-->
                            <div class="ms-6 col mb-6 pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #027DB8;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-row">
                                            <!--begin::Amount-->
                                            <span class="text-white fs-3 ms-6">Proses Pre-Claim : </span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white fs-3 ms-12 fw-bolder">{{ $percen_pre_claim }}</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="col mb-6 pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-row">
                                            <!--begin::Amount-->
                                            <span class="text-white fs-3 ms-6">Proses During-Claim : </span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white fs-3 ms-12 fw-bolder">{{ $percen_during_claim }}</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="me-6 col mb-6 pt-0">
                                <!--begin::Card widget 20-->
                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-repeat: no-repeat;background-size: auto;">
                                    <!--begin::Header-->
                                    <div class="card-header">
                                        <!--begin::Title-->
                                        <div class="card-body d-flex flex-row">
                                            <!--begin::Amount-->
                                            <span class="text-white fs-3 ms-6">Proses Post-Claim : </span>
                                            <!--end::Amount-->
                                            <!--begin::Subtitle-->
                                            <span class="text-white fs-3 ms-12 fw-bolder">{{ $percen_post_claim }}</span>
                                            <!--end::Subtitle-->
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Header-->
                                </div>
                                <!--end::Card widget 20-->
                            </div>
                            <!--begin::Card-->
                        </div>
                        <!--end::Row-->

                        <br>

                        <!--begin::Title-->
                        <div class="row mb-4">
                            <div class="col-6">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">INSURANCE STATUS</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-6">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">BOND STATUS</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Title-->
                        <div class="row mb-4">
                            <div class="col-6">
                                <!--begin::Title body-->
                                <div class="row mb-4 ms-3">
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-success">
                                            <p class="fw-bolder m-0 text-center">Asuransi</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-success">
                                            <p class="fw-bolder m-0 text-center">Tgl Penerbitan</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-success">
                                            <p class="fw-bolder m-0 text-center">Tgl Berakhir</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-success">
                                            <p class="fw-bolder m-0 text-center">Status</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                </div>
                                <!--end::Title body-->
                               <!--begin::Title body-->
                               @if (!empty($proyek->ContractManagements->Asuransi))
                               @php
                                   $asuransiTableView = $proyek->ContractManagements->Asuransi->groupBy("kategori_asuransi")->map(function($item, $key){
                                       return $item->sortByDesc("created_at")->first();    
                                   })->values();
                               @endphp
                           @foreach ($asuransiTableView as $asuransi)
                           <div class="row mb-4 ms-3">
                               <div class="col-3">
                                   <!--begin::Title body-->
                                   <div style="border-radius: 0px" class="card-body bg-secondary">
                                       <p class="fw-bolder m-0 text-center">{{ $asuransi->kategori_asuransi }}</p>
                                   </div>
                                   <!--end::Title body-->
                               </div>
                               <div class="col-3">
                                   <!--begin::Title body-->
                                   <div style="border-radius: 0px" class="card-body bg-secondary">
                                       <p class="fw-bolder m-0 text-center">{{ Carbon\Carbon::create($asuransi->tanggal_penerbitan)->translatedFormat("d/m/Y") }}</p>
                                   </div>
                                   <!--end::Title body-->
                               </div>
                               <div class="col-3">
                                   <!--begin::Title body-->
                                   <div style="border-radius: 0px" class="card-body bg-secondary">
                                       <p class="fw-bolder m-0 text-center">{{ Carbon\Carbon::create($asuransi->tanggal_berakhir)->translatedFormat("d/m/Y") }}</p>
                                   </div>
                                   <!--end::Title body-->
                               </div>
                               <div class="col-3">
                                   <!--begin::Title body-->
                                   <div style="border-radius: 0px" class="card-body bg-secondary">
                                       <p class="fw-bolder m-0 text-center">{{ $asuransi->is_expired == 0 ? "VALID" : "EXPIRED" }}</p>
                                   </div>
                                   <!--end::Title body-->
                               </div>
                           </div>
                           @endforeach
                           @endif
                           <!--end::Title body-->
                            </div>
                            <div class="col-6">
                                <!--begin::Title body-->
                                <div class="row mb-4 me-3">
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-warning">
                                            <p class="fw-bolder m-0 text-center">Jaminan</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-warning">
                                            <p class="fw-bolder m-0 text-center">Tgl Penerbitan</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-warning">
                                            <p class="fw-bolder m-0 text-center">Tgl Berakhir</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Title body-->
                                        <div style="border-radius: 0px" class="card-body bg-warning">
                                            <p class="fw-bolder m-0 text-center">Status</p>
                                        </div>
                                        <!--end::Title body-->
                                    </div>
                                </div>
                                <!--end::Title body-->
                               <!--end::Title body-->
                               @if (!empty($proyek->ContractManagements->Jaminan))
                               @php
                                   $jaminanTableView = $proyek->ContractManagements->Jaminan->groupBy("kategori_jaminan")->map(function($item, $key){
                                       return $item->sortByDesc("created_at")->first();    
                                   })->values();
                               @endphp
                                   <!--begin::Title body-->
                                   @foreach ($jaminanTableView as $jaminan)
                                   <div class="row mb-4 me-3">
                                       <div class="col-3">
                                           <!--begin::Title body-->
                                           <div style="border-radius: 0px" class="card-body bg-secondary">
                                               <p class="fw-bolder m-0 text-center">{{ $jaminan->kategori_jaminan }}</p>
                                           </div>
                                           <!--end::Title body-->
                                       </div>
                                       <div class="col-3">
                                           <!--begin::Title body-->
                                           <div style="border-radius: 0px" class="card-body bg-secondary">
                                               <p class="fw-bolder m-0 text-center">{{ Carbon\Carbon::create($jaminan->tanggal_penerbitan)->translatedFormat("d/m/Y") }}</p>
                                           </div>
                                           <!--end::Title body-->
                                       </div>
                                       <div class="col-3">
                                           <!--begin::Title body-->
                                           <div style="border-radius: 0px" class="card-body bg-secondary">
                                               <p class="fw-bolder m-0 text-center">{{ Carbon\Carbon::create($jaminan->tanggal_berakhir)->translatedFormat("d/m/Y") }}</p>
                                           </div>
                                           <!--end::Title body-->
                                       </div>
                                       <div class="col-3">
                                           <!--begin::Title body-->
                                           <div style="border-radius: 0px" class="card-body bg-secondary">
                                               <p class="fw-bolder m-0 text-center">{{ $jaminan->is_expired == 0 ? "VALID" : "EXPIRED" }}</p>
                                           </div>
                                           <!--end::Title body-->
                                       </div>
                                   </div>
                                   @endforeach
                                   <!--end::Title body-->
                               @endif
                            </div>
                        </div>
                        <!--end::Title-->
                        
                        
                    </div>
                    <!--end::Body Dashboard-->
                    <!--end::Content-->

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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://rawgit.com/highcharts/rounded-corners/master/rounded-corners.js"></script>
<script>
    Highcharts.setOptions({
        chart: {
            style: {
                fontFamily: 'Poppins'
            }
        },
        colors: ["#017EB8", "#28B3AC", "#F7AD1A", "#9FE7F5", "#E86340", "#063F5C"],
        // colors: ["#239DB5", "#71B383", "#EE8E52", "#EBC44F", "#8D5690", "#E85170",  "#4282A6"],
        // colors: ["#009EF7", "#50CD89", "#F1416C", "#FFC700", "#7239EA", "#43CED7", "#FA8B28"],
    });
</script>

@endsection
{{-- End::Main --}}
@section('js-script')

    <!--begin::Highchart Donut Changes Overview-->
    {{-- <script>
        const changesOverview = JSON.parse('{!! json_encode($kategori_kontrak) !!}');
        Highcharts.chart('contract-divisi', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Changes Overview',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: changesOverview
            }]
        });
    </script> --}}
    <!--end::Highchart Donut Changes Overview-->

    <!--begin::Highchart Donut Changes Overview-->
    <script>
        const changesOverview = JSON.parse('{!! $changes_overview->toJson() !!}');
        Highcharts.chart('contract-divisi', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Changes Overview',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: changesOverview
            }]
        });
    </script>
    <!--end::Highchart Donut Changes Overview-->

    <!--begin::Highchart Donut Changes Status -->
    <script>
        const changeStatus = JSON.parse('{!! $change_status_out->toJson() !!}');
        Highcharts.chart('changes-status', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Changes Status',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: changeStatus
            }]
        });
    </script>
    <!--end::Highchart Donut Changes Status -->

    <!--begin::Highchart Donut Pemilik Pekerjaan-->
    <script>
        Highcharts.chart('contract-stage', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5,
                }
            },
            title: {
                text: 'Pemilik Pekerjaan',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: [
                    ['Pemerintah', 3],
                    ['Others', 2],
                    ['BUMN', 7],
                    ['Swasta', 3],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Pemilik Pekerjaan-->

    <!--begin::Highchart Donut Jenis Kontrak -->
    <script>
        Highcharts.chart('contract-classification', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Jenis Kontrak',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: [
                    ['Lumpsum', 8],
                    ['Unit Price', 16],
                    ['Gabungan', 12],
                    ['Turn Key', 9],
                    ['Others', 4],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Jenis Kontrak -->

    <!--begin::Highchart Donut Kontrak JO dan Non-JO -->
    <script>
        Highcharts.chart('contract-jo', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Bentuk Proyek',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 0,
                    depth: 5,
                    showInLegend: false,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kontrak',
                data: [
                    ['JO', 8],
                    ['Non-JO', 16],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Kontrak JO dan Non-JO -->
    
    
    <!-- Begin :: Animation Progress Bar -->
    <script>
        function animateProgressBar() {
            const progressbarElts = document.querySelectorAll("div[role='progressbar']");
            progressbarElts.forEach(item => {
                const dataPersen = item.parentElement.parentElement.querySelector("#data-persen");
                let width = Number(dataPersen.innerText.replace("%", ""));
                item.style.width = width + "%";
            });
        }
        animateProgressBar();
    </script>
    <!-- End :: Animation Progress Bar -->

    <!-- Begin :: Animation Counter Number -->
    <script>
        function animateCounterNumber(selector, firstPrefix = "", lastPrefix = "") {
            const animateCounterElts = document.querySelectorAll(`${selector}`);
            animateCounterElts.forEach(item => {
                let data;
                if(firstPrefix != ""){
                    data = Number(item.innerText.replaceAll(firstPrefix, "").replaceAll(".", ""));
                } else {
                    data = Number(item.innerText.replaceAll(lastPrefix, ""));
                }
                item.innerText = `${firstPrefix}0${lastPrefix}`;
                let i = 0;
                const interval = setInterval(() => {
                    console.log({i, data});
                    if(i == data || i >= data) {
                        clearInterval(interval);
                        if(firstPrefix == "Rp. "){
                            data = Intl.NumberFormat(["id"]).format(data);
                        }
                        item.innerText = `${firstPrefix}${data}${lastPrefix}`;
                        return;
                    };
                    if(firstPrefix == "Rp. "){
                        // i+= Math.floor((data / 15) + data);
                        i+= Math.floor(data/15);
                        item.innerText = `${firstPrefix}${Intl.NumberFormat(["id"]).format(i)}${lastPrefix}`;
                    } else {
                        i++;
                        item.innerText = `${firstPrefix}${i}${lastPrefix}`;
                    }
                }, 15);
            });
        }
        // animateCounterNumber("#data-persen", "", "%");
        // animateCounterNumber("#data-items", "Rp. ");
    </script>
    <!-- End :: Animation Counter Number -->

    <!-- Begin :: Select Filter Dropdown -->
    <script>
        function selectFilter(e) {
            const value = e.value;
            const type = e.getAttribute("id");
            let url = "";
            if(type == "dop") {
                url = `/dashboard-ccm/pemeliharaan-kontrak?dop=${value}`;
            } else if (type == "unit-kerja"){
                url = `/dashboard-ccm/pemeliharaan-kontrak?unit-kerja=${value}`;
            } else {
                url = `/dashboard-ccm/pemeliharaan-kontrak?kode-proyek=${value}`;
            }
            window.location.href = url;
            return;
        }
    </script>
    <!-- End :: Select Filter Dropdown -->

@endsection
