{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

@php
$arrNamaBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
@endphp

<!-- begin::DataTables -->
{{-- <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"> --}}
<!-- end::DataTables -->

<style>
    /* th, td { white-space: nowrap; } */
    div.dataTables_wrapper {
        width: 100%;
        /* height: 100%; */
        /* min-height: 1000px;  */
        margin: 0 auto;
    }

    .content-table {
        position: relative;
        height: 550px !important;
        overflow: scroll;
    }

    .content-table table {
        border-collapse: separate;
    }

    #header {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 255;
        top: 0;
    }

    #header th {
        border-bottom: 1px solid rgb(225, 225, 225);
    }

    #header tr #proyek-title {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 260;
        top: 0;
        left: 0;
    }

    #footer {
        position: sticky;
        position: --webkit-sticky;
        background-color: white;
        z-index: 255;
        bottom: 0;
    }
    /* .table>:not(caption)>*>* {
    padding: 0.5rem 0.5rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 0px;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    } */
</style>

{{-- Begin::Title --}}
@section('title', 'Forecast')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->


                <div class="custom-toaster">

                </div>


                <!--begin::Form-->
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf


                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Toolbar-->
                        <div style=" height:175px" class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Forecast {{"| " . $month_title}}
                                    </h1>
                                    <div class="row">
                                        <div class="col">
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                                <!--begin:::Tab item Forecast Bulanan-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast"
                                                        style="font-size:14px;">Forecast Eksternal Bulanan</a>
                                                </li>
                                                <!--end:::Tab item Forecast Bulanan-->

                                                <!--begin:::Tab item Forecast Internal-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast-internal"
                                                        style="font-size:14px;">Forecast Bulanan Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast Internal-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_forecast_bulanan_kumulatif_eksternal"
                                                        style="font-size:14px;">Forecast Kumulatif Eksternal</a>
                                                </li> --}}
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 {{isset($forecastEkstenal) ? "active" : ""}}" href="/forecast-kumulatif-eksternal"
                                                        style="font-size:14px;">Forecast Kumulatif Eksternal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_forecast_bulanan_kumulatif_interal"
                                                        style="font-size:14px;">Forecast Kumulatif Include Internal</a>
                                                </li> --}}
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 {{isset($forecastInternal) ? "active" : ""}}" href="/forecast-kumulatif-eksternal-internal"
                                                        style="font-size:14px;">Forecast Kumulatif Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->
                                            </ul>
                                        </div>

                                        <div class="row">
                                            <div class="d-flex {{$periode != (int) date("m") ? "col-6" : "col-6"}}">
                                                {{-- <script>
                                                    const historyForecast = "{{ count($historyForecast) }}";
                                                </script> --}}
                                                @if (Auth::user()->check_administrator)
                                                    <button type="button" style="background-color: #008CB4;" id="lock-forecast"
                                                        onclick="lockMonthForecastBulanan(this)"
                                                        class="btn btn-sm btn-active-primary mt-4">

                                                        @if (count($historyForecast) > 0 )
                                                            <span class="text-white mx-2 fs-6">Unlock Forecast</span>
                                                            <i class="bi bi-lock-fill text-white"></i>
                                                        @else
                                                            <span class="text-white mx-2 fs-6">Lock Forecast</span>
                                                            <i class="bi bi-unlock-fill text-white"></i>
                                                        @endif
                                                    </button>
                                                @endif

                                                    {{-- <button type="button" style="background-color: #008CB4;" id="lock-forecast"
                                                        class="btn btn-sm btn-active-primary mt-4">
                                                        <span class="text-white mx-2 fs-6">Check Authorize</span>
                                                        <i class="bi bi-lock-fill text-white"></i>
                                                    </button> --}}
                                                
                                                <button type="button" id="unlock-previous-forecast"
                                                onclick="unlockPreviousForecast()"
                                                class="btn btn-sm btn-light btn-active-primary mt-4 ms-6">
                                                        <span class="fs-6">Pilih Bulan Forecast</span>
                                                </button>

                                                
                                                @if ($periode != (int) date("m") && isset($periode))
                                                    <div class="d-flex flex-row col-5 align-items-center justify-content-center">
                                                        <button type="button" onClick="window.location.href='/{{Request::segment(1)}}';" id="unlock-previous-forecast"
                                                            class="btn btn-sm btn-light btn-active-danger mt-4 me-3">
                                                                <span class="mx-2 fs-6">Pindah Forecast ke {{Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F")}}</span>
                                                        </button>
                                                        <i class="bi bi-info-circle-fill text-hover-primary mt-4" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Jika Tombol <b>Pindah Forecast Bulan Ini</b> di klik, maka halaman Forecast ini akan pindah ke halaman Forecast bulan sekarang"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- <div class="pt-2">
                                                <div class="col">
                                                    <form action=""></form>
                                                    <form action="/forecast" class="row w-700px" method="GET">
                                                        <div class="col">
                                                            <!--Begin:: Select Options-->
                                                            <select id="column" name="column" class="form-select form-select-solid" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Pilih filter" data-select2-id="select2-filter-forecast" tabindex="-1" aria-hidden="true">
                                                                <option value="" {{$column == "" ? "selected": ""}}></option>
                                                                <option value="dop" {{$column == "dop" ? "selected": ""}}>DOP</option>
                                                                <option value="unit_kerja" {{$column == "unit_kerja" ? "selected": ""}}>Unit Kerja</option>
                                                                <option value="nama_proyek" {{$column == "nama_proyek" ? "selected": ""}}>Nama Proyek</option>
                                                            </select>
                                                            <!--End:: Select Options-->
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="filter" class="form-control form-control-solid" value="{{ $filter ?? "" }}" placeholder="Apa yang ingin anda cari?">
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="d-flex flex-row">
                                                                <div class="col">
                                                                    <button type="submit" id="button-filter"
                                                                        class="btn btn-sm btn-light btn-active-primary mt-1">
                                                                            <span class="mx-2 fs-6">Search</span>
                                                                    </button>
                                                                </div>
        
                                                                <div class="col">
                                                                    <button type="button" onclick="window.location.href = '/forecast';" id="button-reset"
                                                                        class="btn btn-sm btn-light btn-active-danger mt-1">
                                                                            <span class="mx-2 fs-6">Reset</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div> --}}
                                        </div>

                                        {{-- end::Tabs Forecast --}}
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Toolbar-->


                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid mt-15" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container"
                                class="w-100"
                                style="overflow: auto; background-color:white; white-space: nowrap;">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="">

                                    <!--begin::All Content-->
                                    <div class="col-xl-15">

                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <!--begin::Card body-->
                                            <div class="card-body mt-4" style="background-color: white;">
                                                        
                                                    <div class="tab-content" id="myTabContent">

                                                        <!-- begin::Tab Forecast Kumulatif Eksternal -->
                                                        <div class="tab-pane fade show active" style="border-width: 0px !important" id="kt_user_view_forecast_bulanan_kumulatif_eksternal" role="tabpanel">

                                                            <div class="content-table">
                                                                <!--begin::Table Forecast-->
                                                                <table class="table align-middle fs-6"
                                                                    id="kt_forecast_table" style="border-width: 0px !important">
                                                                    <!--begin::Table head-->
                                                                    <thead id="header" style="border-width: 0px !important">
                                                                        <tr style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                            <th style="padding: 0px 50px 0px 50px" id="proyek-title" class="w-auto text-center" rowspan="2">
                                                                                Proyek
                                                                            </th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Januari</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Februari</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Maret</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D April</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Mei</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Juni</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Juli</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Agustus</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D September</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Oktober</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D November</th>
                                                                            <th class="text-center min-w-auto" colspan="3">S/D Desember</th>
                                                                            <th class="text-center pinForecast HidePin min-w-auto" colspan="3">S/D Total &nbsp;&nbsp; <i class="text-center bi bi-pin-angle-fill" onclick="hidePin()"></i></th>
                                                                            <th class="text-center pinForecast ShowPin min-w-auto" colspan="3"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                S/D Total &nbsp;&nbsp; <i class="bi bi-pin-fill text-primary" onclick="hidePin()"></i>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <!--begin::Sub-Judul Januari-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Januari-->
                                                                            <!--begin::Sub-Judul Februari-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Februari-->
                                                                            <!--begin::Sub-Judul Maret-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Maret-->
                                                                            <!--begin::Sub-Judul April-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul April-->
                                                                            <!--begin::Sub-Judul Mei-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Mei-->
                                                                            <!--begin::Sub-Judul Juni-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Juni-->
                                                                            <!--begin::Sub-Judul Juli-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Juli-->
                                                                            <!--begin::Sub-Judul Agustus-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Agustus-->
                                                                            <!--begin::Sub-Judul September-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul September-->
                                                                            <!--begin::Sub-Judul Oktober-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Oktober-->
                                                                            <!--begin::Sub-Judul November-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul November-->
                                                                            <!--begin::Sub-Judul Desember-->
                                                                            <th class="text-center min-w-125px">OK</th>
                                                                            <th class="text-center min-w-125px">Forecast</th>
                                                                            <th class="text-center min-w-125px">Realisasi</th>
                                                                            <!--end::Sub-Judul Desember-->
                                                                            <!--begin::Sub-Judul Total-->
                                                                            <th class="text-center pinForecast HidePin min-w-100px">OK</th>
                                                                            <th class="text-center pinForecast HidePin min-w-100px">Forecast</th>
                                                                            <th class="text-center pinForecast HidePin min-w-100px">Realisasi</th>
                                                                            <th class="text-center pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">OK
                                                                            </th>
                                                                            <th class="text-center pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">Forecast
                                                                            </th>
                                                                            <th class="text-center pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">Realisasi</th>
                                                                            <!--end::Sub-Judul Total-->
                                                                        </tr>
                                                                        <!--end::Table head-->
                                                                    </thead>

                                                                    <!--begin::Table body-->

                                                                    <tbody class="fw-bold text-gray-600" id="table-body" style="border-width: 0px !important">

                                                                        
                                                                        <div class="accordion">
                                                                            <div class="accordion-item">
                                                                                {{-- @foreach ($dops as $dop) --}}
                                                                                @php
                                                                                    $footOK1 = [];
                                                                                    $footOK2 = [];
                                                                                    $footOK3 = [];
                                                                                    $footOK4 = [];
                                                                                    $footOK5 = [];
                                                                                    $footOK6 = [];
                                                                                    $footOK7 = [];
                                                                                    $footOK8 = [];
                                                                                    $footOK9 = [];
                                                                                    $footOK10 = [];
                                                                                    $footOK11 = [];
                                                                                    $footOK12 = [];
                                                                                    $footFC1 = [];
                                                                                    $footFC2 = [];
                                                                                    $footFC3 = [];
                                                                                    $footFC4 = [];
                                                                                    $footFC5 = [];
                                                                                    $footFC6 = [];
                                                                                    $footFC7 = [];
                                                                                    $footFC8 = [];
                                                                                    $footFC9 = [];
                                                                                    $footFC10 = [];
                                                                                    $footFC11 = [];
                                                                                    $footFC12 = [];
                                                                                    $footReal1 = [];
                                                                                    $footReal2 = [];
                                                                                    $footReal3 = [];
                                                                                    $footReal4 = [];
                                                                                    $footReal5 = [];
                                                                                    $footReal6 = [];
                                                                                    $footReal7 = [];
                                                                                    $footReal8 = [];
                                                                                    $footReal9 = [];
                                                                                    $footReal10 = [];
                                                                                    $footReal11 = [];
                                                                                    $footReal12 = [];
                                                                                    $totalOkAll = [];
                                                                                    $totalFcAll = [];
                                                                                    $totalRealAll = [];
                                                                                    $per = 1000000;
                                                                                @endphp
                                                                                @foreach ($forecastKumulatifEksternal as $key => $nilaiDOP)
                                                                                @php
                                                                                $keyButtonDOP = str_replace(" ", "", $key);
                                                                                @endphp
                                                                                {{-- @dump($keyButtonDOP) --}}
                                                                                    <tr style="text-align: right; ">
                                                                                        <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 0px; text-align: left">
                                                                                            <small class="accordion-header">
                                                                                                <button class="accordion-button btn-sm collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $keyButtonDOP }}" aria-expanded="true" aria-controls="">
                                                                                                    {{$key}}
                                                                                                </button>
                                                                                            </small>
                                                                                        </td>
                                                                                            {{-- @dd($forecastByProyek->kode_proyek) --}}
                                                                                            {{-- @dd($forecastByUnitKerja) --}}
                                                                                            @php 
                                                                                                $ok1 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 1) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc1 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 1) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real1 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 1) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                
                                                                                                $ok2 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 2) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc2 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 2) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real2 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 2) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok3 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 3) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc3 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 3) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real3 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 3) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok4 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 4) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc4 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 4) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real4 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 4) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok5 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 5) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc5 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 5) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real5 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 5) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok6 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 6) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc6 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 6) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real6 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 6) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok7 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 7) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc7 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 7) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real7 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 7) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok8 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 8) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc8 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 8) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real8 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 8) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok9 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 9) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc9 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 9) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real9 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 9) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok10 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 10) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc10 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 10) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real10 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 10) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok11 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 11) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc11 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 11) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real11 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 11) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                $ok12 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_rkap <= 12) {
                                                                                                            return (int) $forecast->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $fc12 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->sum(function($forecast){
                                                                                                        if ($forecast->month_forecast <= 12) {
                                                                                                            return (int) $forecast->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                $real12 = $nilaiDOP->sum(function($unitKerja){
                                                                                                    return $unitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                        if ($forecast->month_realisasi <= 12) {
                                                                                                            return (int) $forecast->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                            @endphp
                                                                                            <!--begin::Nilai DOP Bulan Januari-->
                                                                                            <td>{{ number_format((round($ok1 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc1 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real1 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Januari-->
                                                                                            <!--begin::Nilai DOP Bulan Februari-->
                                                                                            <td>{{ number_format((round($ok2 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc2 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real2 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Februari-->
                                                                                            <!--begin::Nilai DOP Bulan Maret-->
                                                                                            <td>{{ number_format((round($ok3 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc3 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real3 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Maret-->
                                                                                            <!--begin::Nilai DOP Bulan April-->
                                                                                            <td>{{ number_format((round($ok4 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc4 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real4 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan April-->
                                                                                            <!--begin::Nilai DOP Bulan Mei-->
                                                                                            <td>{{ number_format((round($ok5 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc5 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real5 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Mei-->
                                                                                            <!--begin::Nilai DOP Bulan Juni-->
                                                                                            <td>{{ number_format((round($ok6 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc6 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real6 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Juni-->
                                                                                            <!--begin::Nilai DOP Bulan Juli-->
                                                                                            <td>{{ number_format((round($ok7 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc7 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real7 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Juli-->
                                                                                            <!--begin::Nilai DOP Bulan Agustus-->
                                                                                            <td>{{ number_format((round($ok8 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc8 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real8 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Agustus-->
                                                                                            <!--begin::Nilai DOP Bulan September-->
                                                                                            <td>{{ number_format((round($ok9 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc9 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real9 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan September-->
                                                                                            <!--begin::Nilai DOP Bulan Oktober-->
                                                                                            <td>{{ number_format((round($ok10 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc10 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real10 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Oktober-->
                                                                                            <!--begin::Nilai DOP Bulan November-->
                                                                                            <td>{{ number_format((round($ok11 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc11 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real11 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan November-->
                                                                                            <!--begin::Nilai DOP Bulan Desember-->
                                                                                            <td>{{ number_format((round($ok12 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($fc12 / $per)),0 ,'.', '.') }}</td>
                                                                                            <td>{{ number_format((round($real12 / $per)),0 ,'.', '.') }}</td>
                                                                                            <!--end::Nilai DOP Bulan Desember-->

                                                                                        <!--begin::Total Coloumn-->
                                                                                        @php
                                                                                            $totalOkDOP = round(($ok1+$ok2+$ok3+$ok4+$ok5+$ok6+$ok7+$ok8+$ok9+$ok10+$ok11+$ok12)/$per);
                                                                                            $totalFcDOP = round(($fc1+$fc2+$fc3+$fc4+$fc5+$fc6+$fc7+$fc8+$fc9+$fc10+$fc11+$fc12)/$per);
                                                                                            $totalRealDOP = round(($real1+$real2+$real3+$real4+$real5+$real6+$real7+$real8+$real9+$real10+$real11+$real12)/$per);

                                                                                            if (count($nilaiDOP) > 0) {
                                                                                                array_push($footOK1, $ok1);
                                                                                                array_push($footOK2, $ok2);
                                                                                                array_push($footOK3, $ok3);
                                                                                                array_push($footOK4, $ok4);
                                                                                                array_push($footOK5, $ok5);
                                                                                                array_push($footOK6, $ok6);
                                                                                                array_push($footOK7, $ok7);
                                                                                                array_push($footOK8, $ok8);
                                                                                                array_push($footOK9, $ok9);
                                                                                                array_push($footOK10, $ok10);
                                                                                                array_push($footOK11, $ok11);
                                                                                                array_push($footOK12, $ok12);

                                                                                                array_push($footFC1, $fc1);
                                                                                                array_push($footFC2, $fc2);
                                                                                                array_push($footFC3, $fc3);
                                                                                                array_push($footFC4, $fc4);
                                                                                                array_push($footFC5, $fc5);
                                                                                                array_push($footFC6, $fc6);
                                                                                                array_push($footFC7, $fc7);
                                                                                                array_push($footFC8, $fc8);
                                                                                                array_push($footFC9, $fc9);
                                                                                                array_push($footFC10, $fc10);
                                                                                                array_push($footFC11, $fc11);
                                                                                                array_push($footFC12, $fc12);

                                                                                                array_push($footReal1, $real1);
                                                                                                array_push($footReal2, $real2);
                                                                                                array_push($footReal3, $real3);
                                                                                                array_push($footReal4, $real4);
                                                                                                array_push($footReal5, $real5);
                                                                                                array_push($footReal6, $real6);
                                                                                                array_push($footReal7, $real7);
                                                                                                array_push($footReal8, $real8);
                                                                                                array_push($footReal9, $real9);
                                                                                                array_push($footReal10, $real10);
                                                                                                array_push($footReal11, $real11);
                                                                                                array_push($footReal12, $real12);

                                                                                                array_push($totalOkAll, $totalOkDOP);
                                                                                                array_push($totalFcAll, $totalFcDOP);
                                                                                                array_push($totalRealAll, $totalRealDOP);
                                                                                            }
                                                                                        @endphp
                                                                                        <td class="pinForecast HidePin text-center fw-bolder">{{ number_format($totalOkDOP, 0 , '.', '.') }}</td>
                                                                                        <td class="pinForecast HidePin text-center fw-bolder">{{ number_format($totalFcDOP, 0 , '.', '.') }}</td>
                                                                                        <td class="pinForecast HidePin text-center fw-bolder">{{ number_format($totalRealDOP, 0 , '.', '.') }}</td>
                                                                                        <td class="pinForecast ShowPin text-center fw-bolder"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                            {{ number_format($totalOkDOP, 0, '.', '.') }}
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin text-center fw-bolder"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                            {{ number_format($totalFcDOP, 0, '.', '.') }}
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin text-center fw-bolder"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                            {{ number_format($totalRealDOP, 0, '.', '.') }}
                                                                                        </td>
                                                                                        <!--end::Total Coloumn-->
                                                                                    </tr>

                                                                                    <!--begin:: Foreach Unit Kerja-->
                                                                                    {{-- <div class="accordion-item"> --}}
                                                                                        @foreach ($nilaiDOP as $keyUnit => $nilaiUnitKerja)
                                                                                        {{-- @dump( (string) $keyUnit) --}}
                                                                                        @php
                                                                                            $ok1 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 1) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc1 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 1) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real1 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 1) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok2 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 2) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc2 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 2) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real2 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 2) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok3 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 3) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc3 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 3) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real3 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 3) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok4 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 4) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc4 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 4) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real4 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 4) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok5 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 5) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc5 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 5) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real5 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 5) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok6 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 6) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc6 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 6) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real6 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 6) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok7 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 7) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc7 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 7) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real7 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 7) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok8 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 8) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc8 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 8) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real8 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 8) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok9 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 9) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc9 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 9) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real9 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 9) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok10 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 10) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc10 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 10) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real10 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 10) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok11 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 11) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc11 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 11) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real11 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 11) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $ok12 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_rkap <= 12) {
                                                                                                        return (int) $forecast->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $fc12 = $nilaiUnitKerja->sum(function($forecast){
                                                                                                    if ($forecast->month_forecast <= 12) {
                                                                                                        return (int) $forecast->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            $real12 = $nilaiUnitKerja->where("stage", ">", 7)->sum(function($forecast){
                                                                                                    if ($forecast->month_realisasi <= 12) {
                                                                                                        return (int) $forecast->realisasi_forecast;
                                                                                                    }
                                                                                                });
                                                                                        @endphp
                                                                                        
                                                                                            <tr class="collapse" id="{{ $keyButtonDOP }}" style="text-align: right;">
                                                                                                <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 0.5rem !important; text-align: left">
                                                                                                    <!--begin::Child-->
                                                                                                    <small class="accordion-header">
                                                                                                        <button class="accordion-button collapsed btn-sm button-unit-kerja" type="button" data-bs-toggle="collapse" data-bs-target="#unit-{{ (string) $keyUnit }}" aria-expanded="true" aria-controls="">
                                                                                                            @foreach ($unitKerjas as $unitKerja)
                                                                                                                @if ($unitKerja->divcode == $keyUnit)
                                                                                                                    {{ $unitKerja->unit_kerja }}
                                                                                                                @endif 
                                                                                                            @endforeach
                                                                                                        </button>
                                                                                                    </small>
                                                                                                    <!--end::Child-->
                                                                                                </td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 1-->
                                                                                                    <td>{{ number_format((round($ok1 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc1 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real1 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 1-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 2-->
                                                                                                    <td>{{ number_format((round($ok2 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc2 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real2 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 2-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 3-->
                                                                                                    <td>{{ number_format((round($ok3 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc3 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real3 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 3-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 4-->
                                                                                                    <td>{{ number_format((round($ok4 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc4 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real4 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 4-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 5-->
                                                                                                    <td>{{ number_format((round($ok5 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc5 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real5 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 5-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 6-->
                                                                                                    <td>{{ number_format((round($ok6 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc6 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real6 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 6-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 7-->
                                                                                                    <td>{{ number_format((round($ok7 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc7 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real7 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 7-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 8-->
                                                                                                    <td>{{ number_format((round($ok8 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc8 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real8 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 8-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 9-->
                                                                                                    <td>{{ number_format((round($ok9 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc9 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real9 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 9-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 10-->
                                                                                                    <td>{{ number_format((round($ok10 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc10 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real10 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 10-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 11-->
                                                                                                    <td>{{ number_format((round($ok11 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc11 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real11 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 11-->
                                                                                                    <!--begin::Nilai UNIT KERJA Bulan 12-->
                                                                                                    <td>{{ number_format((round($ok12 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($fc12 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <td>{{ number_format((round($real12 / $per)),0 ,'.', '.') }}</td>
                                                                                                    <!--end::Nilai UNIT KERJA Bulan 12-->
                                                                                                <!--begin::Total Coloumn-->
                                                                                                @php
                                                                                                    $totalOkUnit = round(($ok1+$ok2+$ok3+$ok4+$ok5+$ok6+$ok7+$ok8+$ok9+$ok10+$ok11+$ok12)/$per);
                                                                                                    $totalFcUnit = round(($fc1+$fc2+$fc3+$fc4+$fc5+$fc6+$fc7+$fc8+$fc9+$fc10+$fc11+$fc12)/$per);
                                                                                                    $totalRealUnit = round(($real1+$real2+$real3+$real4+$real5+$real6+$real7+$real8+$real9+$real10+$real11+$real12)/$per);
                                                                                                @endphp
                                                                                                <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalOkUnit, 0 , '.', '.') }}</td>
                                                                                                <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalFcUnit, 0 , '.', '.') }}</td>
                                                                                                <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalRealUnit, 0 , '.', '.') }}</td>
                                                                                                <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                                    {{ number_format($totalOkUnit, 0 , '.', '.') }}
                                                                                                </td>
                                                                                                <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                                    {{ number_format($totalFcUnit, 0 , '.', '.') }}
                                                                                                </td>
                                                                                                <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                                    {{ number_format($totalRealUnit, 0 , '.', '.') }}
                                                                                                </td>
                                                                                                <!--end::Total Coloumn-->
                                                                                            </tr>

                                                                                            @foreach ($nilaiUnitKerja as $keyProyek => $nilaiProyek)
                                                                                            {{-- @dump($nilaiProyek) --}}
                                                                                            @php
                                                                                                $ok1 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 1) {
                                                                                                    $ok1 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc1 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 1) {
                                                                                                    $fc1 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real1 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 1 && $nilaiProyek->stage > 7) {
                                                                                                    $real1 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok2 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 2) {
                                                                                                    $ok2 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc2 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 2) {
                                                                                                    $fc2 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real2 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 2 && $nilaiProyek->stage > 7) {
                                                                                                    $real2 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok3 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 3) {
                                                                                                    $ok3 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc3 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 3) {
                                                                                                    $fc3 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real3 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 3 && $nilaiProyek->stage > 7) {
                                                                                                    $real3 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok4 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 4) {
                                                                                                    $ok4 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc4 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 4) {
                                                                                                    $fc4 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real4 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 4 && $nilaiProyek->stage > 7) {
                                                                                                    $real4 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok5 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 5) {
                                                                                                    $ok5 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc5 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 5) {
                                                                                                    $fc5 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real5 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 5 && $nilaiProyek->stage > 7) {
                                                                                                    $real5 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok6 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 6) {
                                                                                                    $ok6 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc6 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 6) {
                                                                                                    $fc6 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real6 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 6 && $nilaiProyek->stage > 7) {
                                                                                                    $real6 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok7 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 7) {
                                                                                                    $ok7 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc7 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 7) {
                                                                                                    $fc7 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real7 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 7 && $nilaiProyek->stage > 7) {
                                                                                                    $real7 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok8 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 8) {
                                                                                                    $ok8 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc8 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 8) {
                                                                                                    $fc8 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real8 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 8 && $nilaiProyek->stage > 7) {
                                                                                                    $real8 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok9 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 9) {
                                                                                                    $ok9 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc9 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 9) {
                                                                                                    $fc9 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real9 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 9 && $nilaiProyek->stage > 7) {
                                                                                                    $real9 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok10 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 10) {
                                                                                                    $ok10 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc10 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 10) {
                                                                                                    $fc10 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real10 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 10 && $nilaiProyek->stage > 7) {
                                                                                                    $real10 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok11 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 11) {
                                                                                                    $ok11 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc11 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 11) {
                                                                                                    $fc11 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real11 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 11 && $nilaiProyek->stage > 7) {
                                                                                                    $real11 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                                $ok12 = 0;
                                                                                                if ($nilaiProyek->month_rkap <= 12) {
                                                                                                    $ok12 += (int) $nilaiProyek->rkap_forecast;
                                                                                                };
                                                                                                $fc12 = 0;
                                                                                                if ($nilaiProyek->month_forecast <= 12) {
                                                                                                    $fc12 += (int) $nilaiProyek->nilai_forecast;
                                                                                                };
                                                                                                $real12 = 0;
                                                                                                if ($nilaiProyek->month_realisasi <= 12 && $nilaiProyek->stage > 7) {
                                                                                                    $real12 += (int) $nilaiProyek->realisasi_forecast;
                                                                                                };
                                                                                            @endphp
                                                                                            
                                                                                                <tr class="collapse" id="unit-{!! (string) $keyUnit !!}" style="text-align: right;">
                                                                                                    <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 1rem !important; text-align: left">
                                                                                                        <small class="accordion-header">
                                                                                                            <a target="_blank" href="/proyek/view/{{ $nilaiProyek->kode_proyek }}" class="text-hover-primary text-gray-600">{{ $nilaiProyek->nama_proyek }}</a>
                                                                                                        </small>
                                                                                                    </td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 1-->
                                                                                                        <td>{{ number_format((round($ok1 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc1 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real1 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 1-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 2-->
                                                                                                        <td>{{ number_format((round($ok2 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc2 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real2 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 2-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 3-->
                                                                                                        <td>{{ number_format((round($ok3 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc3 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real3 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 3-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 4-->
                                                                                                        <td>{{ number_format((round($ok4 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc4 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real4 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 4-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 5-->
                                                                                                        <td>{{ number_format((round($ok5 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc5 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real5 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 5-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 6-->
                                                                                                        <td>{{ number_format((round($ok6 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc6 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real6 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 6-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 7-->
                                                                                                        <td>{{ number_format((round($ok7 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc7 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real7 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 7-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 8-->
                                                                                                        <td>{{ number_format((round($ok8 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc8 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real8 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 8-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 9-->
                                                                                                        <td>{{ number_format((round($ok9 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc9 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real9 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 9-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 10-->
                                                                                                        <td>{{ number_format((round($ok10 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc10 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real10 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 10-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 11-->
                                                                                                        <td>{{ number_format((round($ok11 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc11 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real11 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 11-->
                                                                                                        <!--begin::Nilai UNIT KERJA Bulan 12-->
                                                                                                        <td>{{ number_format((round($ok12 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($fc12 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <td>{{ number_format((round($real12 / $per)),0 ,'.', '.') }}</td>
                                                                                                        <!--end::Nilai UNIT KERJA Bulan 12-->
                                                                                                    <!--begin::Total Coloumn-->
                                                                                                    @php
                                                                                                        $totalOkProyek = round(($ok1+$ok2+$ok3+$ok4+$ok5+$ok6+$ok7+$ok8+$ok9+$ok10+$ok11+$ok12)/$per);
                                                                                                        $totalFcProyek = round(($fc1+$fc2+$fc3+$fc4+$fc5+$fc6+$fc7+$fc8+$fc9+$fc10+$fc11+$fc12)/$per);
                                                                                                        $totalRealProyek = round(($real1+$real2+$real3+$real4+$real5+$real6+$real7+$real8+$real9+$real10+$real11+$real12)/$per);
                                                                                                    @endphp
                                                                                                    <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalOkProyek, 0 , '.', '.') }}</td>
                                                                                                    <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalFcProyek, 0 , '.', '.') }}</td>
                                                                                                    <td class="pinForecast HidePin fw-bolder text-center">{{ number_format($totalRealProyek, 0 , '.', '.') }}</td>
                                                                                                    <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                                        {{ number_format($totalOkProyek, 0 , '.', '.') }}
                                                                                                    </td>
                                                                                                    <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                                        {{ number_format($totalFcProyek, 0 , '.', '.') }}
                                                                                                    </td>
                                                                                                    <td class="pinForecast ShowPin fw-bolder text-center"
                                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                                        {{ number_format($totalRealProyek, 0 , '.', '.') }}
                                                                                                    </td>
                                                                                                    <!--end::Total Coloumn-->
                                                                                                </tr>
                                                                                            @endforeach

                                                                                        
                                                                                        @endforeach
                                                                                    {{-- </div> --}}
                                                                                    <!--end:: Foreach Unit Kerja-->

                                                                                @endforeach 
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        <tfoot id="footer" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                                            <div class="m-4">
                                                                                <tr>
                                                                                    <td style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 1rem; text-align: left">
                                                                                    <!--begin::Child-->
                                                                                    <b>Total</b>
                                                                                    <!--end::Child-->
                                                                                    </td>
                                                                                    @php
                                                                                        $sumOK = array_sum($totalOkAll);
                                                                                        $sumFC = array_sum($totalFcAll);
                                                                                        $sumReal = array_sum($totalRealAll);
                                                                                    @endphp
                                                                                    <!--begin::Total Foot 1-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK1))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC1))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal1))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 1-->
                                                                                    <!--begin::Total Foot 2-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK2))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC2))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal2))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 2-->
                                                                                    <!--begin::Total Foot 3-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK3))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC3))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal3))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 3-->
                                                                                    <!--begin::Total Foot 4-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK4))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC4))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal4))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 4-->
                                                                                    <!--begin::Total Foot 5-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK5))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC5))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal5))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 5-->
                                                                                    <!--begin::Total Foot 6-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK6))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC6))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal6))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 6-->
                                                                                    <!--begin::Total Foot 7-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK7))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC7))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal7))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 7-->
                                                                                    <!--begin::Total Foot 8-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK8))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC8))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal8))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 8-->
                                                                                    <!--begin::Total Foot 9-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK9))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC9))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal9))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 9-->
                                                                                    <!--begin::Total Foot 10-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK10))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC10))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal10))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 10-->
                                                                                    <!--begin::Total Foot 11-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK11))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC11))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal11))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 11-->
                                                                                    <!--begin::Total Foot 12-->
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footOK12))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footFC12))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <td class="text-end"><b>{{ number_format(round((array_sum($footReal12))/$per), 0 , '.', '.') }}</b></td>
                                                                                    <!--end::Total Foot 12-->
                                                                                    <!--Begin::Total Foot ALL-->
                                                                                    <td class="pinForecast HidePin text-center">
                                                                                        <b>{{ number_format($sumOK, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin text-center">
                                                                                        <b>{{ number_format($sumFC, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin text-center">
                                                                                        <b>{{ number_format($sumReal, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin text-center" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <b>{{ number_format($sumOK, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin text-center" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <b>{{ number_format($sumFC, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin text-center" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <b>{{ number_format($sumReal, 0, '.', '.') }}</b>
                                                                                    </td>
                                                                                    <!--End::Total Foot ALL-->
                                                                                </tr>
                                                                            </div>
                                                                        </tfoot>
                                                                            
                                                                    </tbody>

                                                                        {{-- @endforeach --}}
                                                                </table>
                                                                <!--end::Table body-->
                                                            </div>    
                                                        </div>
                                                        <!--end:::Tab Forecast Bulanan-->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                            <script>
                                function hidePin() {
                                    var hide = document.getElementsByClassName('pinForecast');
                                    hide.forEach(element => {
                                        if (element.classList.contains("HidePin")) {
                                            element.classList.add("ShowPin");
                                            element.classList.remove("HidePin");
                                        } else {
                                            element.classList.add("HidePin");
                                            element.classList.remove("ShowPin");
                                        }
                                    });
                                }
                            </script>
                            <!--end::Table Forecast-->

                        </div>
                    </div>



                </div>
                <!--end:::Tab isi content-->

            </div>
            <!--end::Card body-->


        </div>
        <!--end::Contacts App- Edit Contact-->

    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

</div>
<!--end::Content-->
</form>
<!--end::Form-->

</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->

{{-- begin::modal --}}
<div class="modal fade" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
    <h5 class="modal-title">Konfirmasi Kunci Forecast</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="cancelLock()"
        data-bs-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" onclick="confirmedLock()"
        style="background-color: #008CB4;">Lanjut</button>
</div>
</div>
</div>
</div>
{{-- end::modal --}}


<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
<span class="svg-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
fill="none">
<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
    transform="rotate(90 13 6)" fill="black" />
<path
    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
    fill="black" />
</svg>
</span>
<!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
@endsection
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}


{{-- begin:: JS script --}}
@section('js-script')

<script>
    async function unlockPreviousForecast() {
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                            ];
        // const historyForecastObj = Object.keys(historyForecast).map(data => Number(data));
        // const minMonth = Math.min(...historyForecastObj);
        // const maxMonth = Math.max(...historyForecastObj);
        // const date = new Date();
        // let getAvgMonth = [];
        // for(var i=minMonth; i <= maxMonth; i++) {
        //     const objectMonth = Object.keys(historyForecast[i]);
        //     let avgDate = null;
        //     for(var j=0; j < objectMonth.length; j++) {
        //         avgDate += new Date(objectMonth[j]).getTime();
        //     }
        //     avgDate /= objectMonth.length;
        //     getAvgMonth[`${i}`] = `${i}, ${new Date(avgDate)}`;
        //     // getAvgMonth.push({
        //     //     i: new Date(avgDate),
        //     // });
        //     avgDate = 0;
        // }
        
        // for(var i=minMonth; i <= maxMonth; i++) {
        //     let date = getAvgMonth[i].split(", ")[1];
        //     jsonVariable[`${i}, ${new Date(date).getFullYear()}`] = `${monthNames[i - 1]}, ${new Date(date).getFullYear()}`;        
        // }
        const jsonVariable = {};
        for(let i = 0; i < monthNames.length; i++) {
            jsonVariable[`${i + 1}`] = `${monthNames[i]}`;        
        }
        const {value: monthForecast} = await Swal.fire({
            title: 'Pilih Bulan Forecast',
            input: 'select',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#7e8299',
            inputOptions: jsonVariable,
            inputPlaceholder: 'Tekan di sini untuk memilih bulan',
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise(resolve => {
                    if (value == "") {
                        resolve("Silahkan pilih bulan forecast");
                    }
                    else {
                        resolve();
                    }
                })
            }
        });
        if (monthForecast) {
            Swal.fire({
                title: `Apakah anda yakin ingin melihat History Forecast pada bulan ${monthNames[monthForecast - 1]}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#7e8299',
                confirmButtonText: 'Lanjut'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        let url = `{{Request::segment(1)}}/${monthForecast}/${new Date().getFullYear()}`;
                        location.href = url;
                    }
                })
        }
    }
</script>

{{-- Show Collapse --}}
@endsection
{{-- end:: JS script --}}
