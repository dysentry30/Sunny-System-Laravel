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
        max-height: 450px !important;
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
                        <div style=" height:auto" class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Forecast {{"| " . $month_title}} (Dalam jutaan)
                                    </h1>
                                    <div class="row">
                                        <div class="col">
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                                <!--begin:::Tab item Forecast Bulanan-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 {{isset($is_forecast) ? "active" : ""}}"
                                                        href="/forecast"
                                                        style="font-size:14px;">Forecast Eksternal Bulanan</a>
                                                </li>
                                                <!--end:::Tab item Forecast Bulanan-->

                                                <!--begin:::Tab item Forecast Internal-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 {{isset($is_forecast) ? "" : "active"}}" href="/forecast-internal"
                                                        style="font-size:14px;">Forecast Bulanan Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast Internal-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast-kumulatif-eksternal"
                                                        style="font-size:14px;">Forecast Kumulatif Eksternal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast-kumulatif-eksternal-internal"
                                                        style="font-size:14px;">Forecast Kumulatif Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab Request Aprroval History-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/request-approval-history"
                                                        style="font-size:14px;">Request Approval History</a>
                                                </li>
                                                <!--end:::Tab Request Aprroval History-->
                                            </ul>
                                        </div>
                                        @php
                                            $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                                        @endphp

                                        <div class="row">
                                            <div class="d-flex {{$periode != (int) date("m") ? "col-6" : "col-6"}}">
                                                <script>
                                                    const historyForecast = JSON.parse('{!! $historyForecast->toJson() !!}');
                                                </script>
                                                @if ($unit_kerja instanceof \Illuminate\Support\Collection)
                                                    @php
                                                        $unit_kerja_count = $unit_kerja->count();
                                                    @endphp
                                                @else
                                                    @php
                                                        $unit_kerja_count = collect($unit_kerja)->count();
                                                    @endphp
                                                @endif
                                                @if (!str_contains(Auth::user()->name, "(PIC)"))
                                                    @if ($historyForecast->count() == $unit_kerja_count)
                                                        <div class="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Untuk Request Unlock, silahkan buka tab <b>Request Approval History</b>." data-bs-placement="top">
                                                            <button type="button" style="background-color: #008CB4;" id="lock-forecast"
                                                                onclick="lockMonthForecastBulanan(this)"
                                                                class="btn btn-sm btn-active-primary mt-4 me-6 disabled">
                                                                    <span class="text-white mx-2 fs-6">Unlock Forecast</span>
                                                                    <i class="bi bi-lock-fill text-white"></i>
                                                            </button>
                                                      </div>
                                                        @else
                                                        <button type="button" style="background-color: #008CB4;" id="lock-forecast"
                                                            onclick="lockMonthForecastBulanan(this)"
                                                            class="btn btn-sm btn-active-primary mt-4 me-6">
                                                                <span class="text-white mx-2 fs-6">Lock Forecast</span>
                                                                <i class="bi bi-unlock-fill text-white"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                                
                                                <button type="button" id="unlock-previous-forecast"
                                                onclick="unlockPreviousForecast()"
                                                class="btn btn-sm btn-light btn-active-primary mt-4 ms-0">
                                                        <span class="fs-6">Pilih Bulan Forecast</span>
                                                </button>

                                                
                                                @if ($periode != (int) date("m") && isset($periode))
                                                    <div class="d-flex flex-row col-5 align-items-center justify-content-center">
                                                        <button type="button" onClick="window.location.href='/forecast';" id="unlock-previous-forecast"
                                                            class="btn btn-sm btn-light btn-active-danger mt-4 me-3">
                                                                <span class="mx-2 fs-6">Pindah Forecast ke {{Carbon\Carbon::parse(new DateTime("now"))->translatedFormat("F")}}</span>
                                                        </button>
                                                        <i class="bi bi-info-circle-fill text-hover-primary mt-4" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Jika Tombol <b>Pindah Forecast Bulan Ini</b> di klik, maka halaman Forecast ini akan pindah ke halaman Forecast bulan sekarang"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="pt-2">
                                                <div class="col">
                                                    <form action=""></form>
                                                    <form action="#" class="row w-700px" method="GET">
                                                        <div class="col">
                                                            <!--Begin:: Select Options-->
                                                            <select id="column" name="column" class="form-select form-select-solid" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Pilih filter" data-select2-id="select2-filter-forecast" tabindex="-1" aria-hidden="true">
                                                                <option value="nama_proyek" {{$column == "nama_proyek" ? "selected": ""}}>Nama Proyek</option>
                                                                <option value=""></option>
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
                                                                    <button type="button" onclick="window.location.href = '{{isset($is_forecast) ? '/forecast' : '/forecast-internal'}}';" id="button-reset"
                                                                        class="btn btn-sm btn-light btn-active-danger mt-1">
                                                                            <span class="mx-2 fs-6">Reset</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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
                                                {{-- @if ($proyeks->count() > 0) --}}
                                                        
                                                    <div class="tab-content" id="myTabContent">

                                                        {{-- begin::Tab Forecast Bulanan --}}
                                                        <div class="tab-pane fade show active" style="border-width: 0px !important" id="kt_user_view_overview_forecast_bulanan" role="tabpanel">
                                                            <div class="loading-page d-flex flex-column align-items-center justify-content-center" style="width: 100%;height: 400px;position: relative;">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                                Mohon ditunggu...
                                                            </div>
                                                            <div class="content-table" style="display: none">
                                                                <!--begin::Table Forecast-->
                                                                <table class="table align-middle fs-6"
                                                                id="kt_forecast_table" style="border-width: 0px !important">
                                                                <!--begin::Table head-->
                                                                    <thead id="header" class="" style="border-width: 0px !important;">
                                                                        <tr style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                            <th style="padding: 0px 50px 0px 50px " id="proyek-title" class="w-auto text-center" rowspan="2">
                                                                                Proyek
                                                                            </th>
                                                                            <th class="text-center min-w-auto" colspan="3">Januari</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Februari</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Maret</th>
                                                                            <th class="text-center min-w-auto" colspan="3">April</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Mei</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Juni</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Juli</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Agustus</th>
                                                                            <th class="text-center min-w-auto" colspan="3">September</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Oktober</th>
                                                                            <th class="text-center min-w-auto" colspan="3">November</th>
                                                                            <th class="text-center min-w-auto" colspan="3">Desember</th>
                                                                            <th class="text-center pinForecast HidePin min-w-auto" colspan="3">Total &nbsp;&nbsp; <i class="text-center bi bi-pin-angle-fill" onclick="hidePin()"></i></th>
                                                                            <th class="text-center pinForecast ShowPin min-w-auto" colspan="3"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                Total &nbsp;&nbsp; <i class="bi bi-pin-fill text-primary" onclick="hidePin()"></i>
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
                                                                            <th class="text-center pinForecast ShowPin min-w-100px"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">OK
                                                                            </th>
                                                                            <th class="text-center pinForecast ShowPin min-w-100px"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                Forecast
                                                                            </th>
                                                                            <th class="text-center pinForecast ShowPin min-w-100px"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                Realisasi
                                                                            </th>
                                                                            <!--end::Sub-Judul Total-->
                                                                        </tr>
                                                                        <!--end::Table head-->
                                                                    </thead>

                                                                <!--begin::Table body-->

                                                                <tbody class="fw-bold text-gray-600" id="table-body" style="border-width: 0px !important">

                                                                    @php
                                                                        $month_counter = 1;
                                                                        $is_data_found = false;
                                                                        $total_ok = 0;
                                                                        $total_ok_tahunan = 0;
                                                                        $total_year_ok = 0;
                                                                        $total_forecast = 0;
                                                                        $total_month_forecast = 0;
                                                                        $total_year_forecast = 0;
                                                                        $index = 1;
                                                                        // if ($column == "unit_kerja") {
                                                                        //     $dops = $dops->filter(function($data) use($filter) {
                                                                        //         $is_unit_kerjas_exist = $data->UnitKerjas->contains(function($data) use($filter) {
                                                                        //             return str_contains(strtolower($data->unit_kerja), strtolower($filter)) && $data->Proyeks->count() > 0;
                                                                        //         });
                                                                        //         if ($data->UnitKerjas->count() > 0 && $is_unit_kerjas_exist) {
                                                                        //             return $data;
                                                                        //             // return $data->UnitKerjas->filter(function($unit_kerja) use($filter, $data) {
                                                                                        
                                                                        //             //     if ($unit_kerja->Proyeks->count() > 0 && str_contains(strtolower($unit_kerja->unit_kerja), strtolower($filter))) {
                                                                        //             //     }
                                                                        //             // });
                                                                        //         }
                                                                        //     });
                                                                        // }
                                                                        if(!Auth::user()->check_administrator) {

                                                                            if($unit_kerja instanceof \Illuminate\Support\Collection) {
                                                                                $dops = $dops->filter(function($dop) use($unit_kerja) {
                                                                                    return $dop->UnitKerjas->whereIn("divcode", $unit_kerja->toArray())->count() > 0 ? true : false;
                                                                                });
                                                                            } else {
                                                                                $dops = $dops->filter(function($dop) use($unit_kerja) {
                                                                                    return $dop->UnitKerjas->where("divcode", $unit_kerja)->count() > 0 ? true : false;
                                                                                });
                                                                            }
                                                                        }
                                                                        

                                                                        if($column != "" && !Auth::user()->check_administrator) {
                                                                            $dops = $dops->filter(function($dop) use($filter, $unit_kerja) {
                                                                                if($unit_kerja instanceof \Illuminate\Support\Collection) {
                                                                                    $dop->UnitKerjas = $dop->UnitKerjas->whereIn("divcode", $unit_kerja->toArray());
                                                                                } else {
                                                                                    $dop->UnitKerjas = $dop->UnitKerjas->where("divcode", "=", $unit_kerja);
                                                                                }
                                                                                return $dop->UnitKerjas->contains(function($unit) use($filter) {
                                                                                    $proyeks = $unit->Proyeks->filter(function($p) use($filter) {
                                                                                        return preg_match("/$filter/i", $p->nama_proyek);
                                                                                    });
                                                                                    return $proyeks->count() > 0;
                                                                                });
                                                                            });
                                                                        } else {
                                                                            $dops = $dops->filter(function($dop) use($filter) {
                                                                                return $dop->UnitKerjas->contains(function($unit) use($filter) {
                                                                                    $proyeks = $unit->Proyeks->filter(function($p) use($filter) {
                                                                                        return preg_match("/$filter/i", $p->nama_proyek);
                                                                                    });
                                                                                    return $proyeks->count() > 0;
                                                                                });
                                                                            });

                                                                        }
                                                                    @endphp
                                                                    <div class="accordion">
                                                                        <div class="accordion-item">
                                                                            @foreach ($dops as $dop)
                                                                            {{-- @if (count($dop->UnitKerjas) > 0) --}}
                                                                            {{-- @foreach ($proyeks as $proyek) --}}
                                                                        @php
                                                                            if(!Auth::user()->check_administrator && $unit_kerja instanceof \Illuminate\Support\Collection) {
                                                                                $dop->UnitKerjas = $dop->UnitKerjas->whereIn("divcode", $unit_kerja->toArray());
                                                                            } elseif(!empty(Auth::user()->unit_kerja)){
                                                                                $dop->UnitKerjas = $dop->UnitKerjas->where("divcode", "=", $unit_kerja);
                                                                            }
                                                                        @endphp
                                                                        <tr style="text-align: right; ">

                                                                            @php
                                                                                $dop_name = str_replace(' ', '-', $dop->dop);
                                                                            @endphp
                                                                            <td
                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 0px; text-align: left">
                                                                                <small class="accordion-header">
                                                                                    <button class="accordion-button btn-sm collapsed button-dop" type="button" data-bs-toggle="collapse" data-bs-target="#{{$dop_name}}" aria-expanded="true" aria-controls="{{$dop_name}}">
                                                                                    {{$dop->dop}}
                                                                                    </button>
                                                                                </small>
                                                                            </td>
                                                                            @php
                                                                                $nth = 0;
                                                                            @endphp
                                                                            @for ($i = 1; $i <= 12; $i++)
                                                                                {{-- @php
                                                                                    // $unitKerja->Proyeks->each(function($p) use($total_ok_per_divisi, $per_sejuta, $i) {
                                                                                    //     if((int) $p->bulan_awal == $i || (int) $p->bulan_pelaksanaan == $i ) $total_ok_per_divisi += (int) $p->nilai_rkap / $per_sejuta;
                                                                                    // });
                                                                                    if ($column != "") {
                                                                                        if(!isset($is_forecast)) {
                                                                                            $total_ok_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // return ($i == $p->bulan_awal || $i == $p->bulan_pelaksanaan) ? (int) $p->nilai_rkap : 0;
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return (int) $p->nilai_rkap;
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // });
                                                                                                });
                                                                                            });
        
                                                                                            $total_forecast_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if (preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->nilai_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                            
                                                                                            $total_realisasi_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return (int) $p->nilai_rkap;
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->realisasi_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        } else {
                                                                                            $total_ok_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // return ($i == $p->bulan_awal || $i == $p->bulan_pelaksanaan) ? (int) $p->nilai_rkap : 0;
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return (int) $p->nilai_rkap;
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // });
                                                                                                });
                                                                                            });
        
                                                                                            $total_forecast_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if (preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->nilai_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                            
                                                                                            $total_realisasi_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return (int) $p->nilai_rkap;
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->realisasi_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i) {
                                                                                                    // });
                                                                                                    // return $i == $p->bulan_ri_perolehan ? (int) $p->nilai_perolehan : 0;
                                                                                                });
                                                                                            });
                                                                                        }
                                                                                    } else {
                                                                                        if(!isset($is_forecast)) {
                                                                                            $total_ok_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if(!empty($p->Forecasts)) {
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    } else {
                                                                                                        return $p->nilai_rkap;
                                                                                                    }
                                                                                                });
                                                                                            });
        
                                                                                            $total_forecast_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                        if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                            return (int) $f->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                            });
                                                                                            
                                                                                            $total_realisasi_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                        if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i) {
                                                                                                    // });
                                                                                                    // return $i == $p->bulan_ri_perolehan ? (int) $p->nilai_perolehan : 0;
                                                                                                });
                                                                                            });
                                                                                        } else {
                                                                                            $total_ok_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if(!empty($p->Forecasts)) {
                                                                                                        return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    } else {
                                                                                                        return $p->nilai_rkap;
                                                                                                    }
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // });
                                                                                                });
                                                                                            });
        
                                                                                            $total_forecast_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                        if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                            return (int) $f->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                            });
                                                                                            
                                                                                            $total_realisasi_per_dop = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $column, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    return $p->Forecasts->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                        if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                    // return $p->Forecasts->sum(function($f) use($per_sejuta, $i) {
                                                                                                    // });
                                                                                                    // return $i == $p->bulan_ri_perolehan ? (int) $p->nilai_perolehan : 0;
                                                                                                });
                                                                                            });
                                                                                        }
                                                                                    }
                                                                                @endphp  --}}
                                                                                <!--begin::Januari Coloumn-->
                                                                                <td data-total-ok-per-dop-bulanan = "{{$i}}" data-dop = "{{$dop->dop}}" ></td>
                                                                                <td data-total-forecast-per-dop-bulanan = "{{$i}}" data-dop = "{{$dop->dop}}" ></td>
                                                                                <td data-total-realisasi-per-dop-bulanan = "{{$i}}" data-dop = "{{$dop->dop}}" ></td>
                                                                                <!--end::Januari Coloumn-->
                                                                            @endfor

                                                                            @php
                                                                                    if($column != "") {
                                                                                        if(isset($is_forecast)) {
                                                                                            $total_ok_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return $p->nilai_rkap;
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                            if($periode == $f->periode_prognosa) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                        // if($p->tipe_proyek == "R") {
                                                                                                        // } else {
                                                                                                        //     return (int) $p->nilai_rkap;
                                                                                                        // }
                                                                                                    }
                                                                                                    // return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    //     if($f->periode_prognosa == $periode) {
                                                                                                    //     }
                                                                                                    // });
                                                                                                });
                                                                                            });

                                                                                            $total_forecast_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                            return (int) $f->nilai_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });

                                                                                            $total_realisasi_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek) && $p->stage == 8) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                    // return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode) {
                                                                                                    // });
                                                                                                    // return $i == $p->bulan_ri_perolehan ? (int) $p->nilai_perolehan : 0;
                                                                                                });
                                                                                            });
                                                                                        } else {
                                                                                            $total_ok_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        // return $p->nilai_rkap;
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                            if($periode == $f->periode_prognosa) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                        // if($p->tipe_proyek == "R") {
                                                                                                        // } else {
                                                                                                        //     return (int) $p->nilai_rkap;
                                                                                                        // }
                                                                                                    }
                                                                                                    // return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    //     if($f->periode_prognosa == $periode) {
                                                                                                    //     }
                                                                                                    // });
                                                                                                });
                                                                                            });

                                                                                            $total_forecast_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                            return (int) $f->nilai_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });

                                                                                            $total_realisasi_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if(preg_match("/$filter/i", $p->nama_proyek) && $p->stage == 8) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        }

                                                                                    } else {
                                                                                        if(isset($is_forecast)) {
                                                                                            $total_ok_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    // return $p->nilai_rkap;
                                                                                                    return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                        if($periode == $f->periode_prognosa) {
                                                                                                            return (int) $f->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                    // if($p->tipe_proyek == "R") {
                                                                                                    // } else {
                                                                                                    //     return (int) $p->nilai_rkap;
                                                                                                    // }
                                                                                                });
                                                                                            });

                                                                                            $total_forecast_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                        return (int) $f->nilai_forecast;
                                                                                                    });
                                                                                                });
                                                                                            });

                                                                                            $total_realisasi_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->where("jenis_proyek", "!=", "I")->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if($p->stage == 8) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        } else {
                                                                                            $total_ok_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    // return $p->nilai_rkap;
                                                                                                    return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                        if($periode == $f->periode_prognosa) {
                                                                                                            return (int) $f->rkap_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                    // if($p->tipe_proyek == "R") {
                                                                                                    // } else {
                                                                                                    //     return (int) $p->nilai_rkap;
                                                                                                    // }
                                                                                                });
                                                                                            });

                                                                                            $total_forecast_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode, $filter) {
                                                                                                        return (int) $f->nilai_forecast;
                                                                                                    });
                                                                                                });
                                                                                            });

                                                                                            $total_realisasi_per_dop_tahunan = $dop->UnitKerjas->sum(function($unit_kerja) use($per_sejuta, $i, $periode, $filter) {
                                                                                                return $unit_kerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode, $filter) {
                                                                                                    if($p->stage == 8) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($per_sejuta, $i, $periode) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                            });
                                                                                        }
                                                                                    }
                                                                                    $total_ok_tahunan += (int) $total_ok_per_dop_tahunan;
                                                                                @endphp 
                                                                            <!--begin::Total Coloumn-->
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast HidePin">{{number_format($total_ok_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast HidePin">{{number_format($total_forecast_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast HidePin">{{number_format($total_realisasi_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast ShowPin text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                    <b>{{number_format($total_ok_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                </td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast ShowPin text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                    <b>{{number_format($total_forecast_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                </td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast ShowPin text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                    <b>{{number_format($total_realisasi_per_dop_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                </td>
                                                                            {{-- <td data-dop="{{$dop->dop}}" class="pinForecast total-ok-dop-tahunan HidePin">0</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast total-forecast-dop-tahunan HidePin">0</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast total-realisasi-dop-tahunan HidePin">0</td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast total-ok-dop-tahunan ShowPin text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                    <b>0</b>
                                                                                </td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast total-forecast-dop-tahunan ShowPin text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                    <b>0</b>
                                                                                </td>
                                                                            <td data-dop="{{$dop->dop}}" class="pinForecast ShowPin total-realisasi-dop-tahunan text-center"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                    <b>0</b>
                                                                                </td> --}}
                                                                            <!--end::Total Coloumn-->
                                                                        </tr>
                                                                        {{-- begin:: Foreach Unit Kerja --}}
                                                                        
                                                                        @foreach ($dop->UnitKerjas as $unitKerja)
                                                                            @php
                                                                                $unitKerja->Proyeks = $unitKerja->Proyeks;
                                                                            @endphp
                                                                            @php
                                                                                $unit_kerja_name = preg_replace("/[^\w]/", "-", $unitKerja->unit_kerja);                                                                                
                                                                                if($column == "nama_proyek") {
                                                                                    $unitKerja->Proyeks = $unitKerja->Proyeks->filter(function ($p) use ($filter) {
                                                                                        return preg_match("/$filter/i", $p->nama_proyek);
                                                                                    });
                                                                                }
                                                                                if(isset($is_forecast)) {
                                                                                    $unitKerja->Proyeks = $unitKerja->Proyeks->where("jenis_proyek", "!=", "I");
                                                                                }
                                                                            @endphp
                                                                            
                                                                            @if (count($unitKerja->Proyeks) > 0)
                                                                                <tr class="collapse"
                                                                                    id="{{ $dop_name }}"
                                                                                    style="text-align: right;">
                                                                                    <td
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 1rem !important; text-align: left">
                                                                                        <!--begin::Child=-->
                                                                                        <small class="accordion-header">
                                                                                            <button class="accordion-button collapsed btn-sm button-unit-kerja" type="button" data-bs-toggle="collapse" data-bs-target="#{{$unit_kerja_name}}" aria-expanded="true" aria-controls="{{$unit_kerja_name}}">
                                                                                            {{$unitKerja->unit_kerja}}
                                                                                            </button>
                                                                                        </small>
                                                                                        <!--end::Child=-->
                                                                                    </td>
                                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                                        {{-- @php
                                                                                            if ($column != "") {
                                                                                                $total_ok_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // return ($i == $p->bulan_awal || $i == $p->bulan_pelaksanaan) ? (int) $p->nilai_rkap : 0;
                                                                                                    if($p->tipe_proyek == "R") {
                                                                                                        if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                            return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                                if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                    return $f->nilai_rkap;
                                                                                                                }
                                                                                                            });
                                                                                                        }
                                                                                                    } else {
                                                                                                        if($p->bulan_awal == $i && preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                            return (int) $p->nilai_rkap;
                                                                                                        }
                                                                                                    }
                                                                                                    // return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                    // });
                                                                                                });
            
                                                                                                $total_forecast_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if (preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                            if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->nilai_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    }
                                                                                                });
                                                                                                
                                                                                                $total_realisasi_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $column, $filter) {
                                                                                                    if($p->tipe_proyek == "R") {
                                                                                                        if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                            return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i, $column, $filter) {
                                                                                                                if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                    return (int) $f->realisasi_forecast;
                                                                                                                }
                                                                                                            });
                                                                                                        }
                                                                                                    } else {
                                                                                                        if($p->stage == 8 && $i == $p->bulan_ri_perolehan && preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                            // dd($p);
                                                                                                            return (int) $p->nilai_perolehan;
                                                                                                        }
                                                                                                    }
                                                                                                    // return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i) {
                                                                                                    // });
                                                                                                    // return $i == $p->bulan_ri_perolehan ? (int) $p->nilai_perolehan : 0;
                                                                                                });
                                                                                            } else {
                                                                                                $total_ok_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i) {
                                                                                                    if($p->tipe_proyek == "R") {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i) {
                                                                                                            if($f->month_rkap == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->rkap_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    } else {
                                                                                                        if($p->bulan_awal == $i) {
                                                                                                            return (int) $p->nilai_rkap;
                                                                                                        }
                                                                                                    }
                                                                                                });
            
                                                                                                $total_forecast_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i) {
                                                                                                    return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i) {
                                                                                                        if($f->month_forecast == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                            return (int) $f->nilai_forecast;
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                                
                                                                                                $total_realisasi_per_divisi = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i) {
                                                                                                    if($p->tipe_proyek == "R") {
                                                                                                        return $p->Forecasts->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) use($per_sejuta, $i) {
                                                                                                            if($f->month_realisasi == $i && $f->periode_prognosa == (int) date("m")) {
                                                                                                                return (int) $f->realisasi_forecast;
                                                                                                            }
                                                                                                        });
                                                                                                    } else {
                                                                                                        if($p->stage == 8 && $i == $p->bulan_ri_perolehan) {
                                                                                                            // dd($p);
                                                                                                            return (int) $p->nilai_perolehan;
                                                                                                        }
                                                                                                    }
                                                                                                });
                                                                                            }
                                                                                        @endphp  --}}
                                                                                        <!--begin::Month Coloumn-->
                                                                                        <td data-total-ok-per-divisi-column="{{$i}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">0</td>
                                                                                        <td data-total-forecast-per-divisi-column="{{$i}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">0</td>
                                                                                        <td data-total-realisasi-per-divisi-column="{{$i}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">0</td>
                                                                                        <!--end::Month Coloumn-->
                                                                                        @php
                                                                                            $total_ok_per_divisi = 0;
                                                                                        @endphp
                                                                                    @endfor
                                                                                    @php
                                                                                    if ($column != "") {
                                                                                        $total_ok_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $filter, $column, $periode) {
                                                                                            if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                    if($periode == $f->periode_prognosa) {
                                                                                                        return (int) $f->rkap_forecast;
                                                                                                    }
                                                                                                });
                                                                                            }
                                                                                            // if($p->tipe_proyek == "R") {
                                                                                            // } else {
                                                                                            //     if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                            //         return (int) $p->nilai_rkap;
                                                                                            //     }
                                                                                            // }
                                                                                        });
                                                                                        $total_forecast_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $filter, $column, $periode) {
                                                                                            if(preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                                return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                    if($periode == $f->periode_prognosa) {
                                                                                                        return (int) $f->nilai_forecast;
                                                                                                    }
                                                                                                });
                                                                                            }
                                                                                        });
                                                                                        $total_realisasi_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $filter, $column, $periode) {
                                                                                            return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode, $p, $filter) {
                                                                                                if($p->stage == 8 && preg_match("/$filter/i", $p->nama_proyek) && $periode == $f->periode_prognosa) {
                                                                                                    return (int) $f->realisasi_forecast;
                                                                                                }
                                                                                            });
                                                                                            // if($p->tipe_proyek == "R" && preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                            // } else {
                                                                                            //     if($p->stage == 8 && preg_match("/$filter/i", $p->nama_proyek)) {
                                                                                            //         return (int) $p->nilai_perolehan;
                                                                                            //     }
                                                                                            // }
                                                                                        });
                                                                                    } else {
                                                                                        $total_ok_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode) {
                                                                                            return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                if($periode == $f->periode_prognosa) {
                                                                                                    return (int) $f->rkap_forecast;
                                                                                                }
                                                                                            });
                                                                                            // if($p->tipe_proyek == "R") {
                                                                                            // } else {
                                                                                            //     return (int) $p->nilai_rkap;
                                                                                            // }
                                                                                        });
                                                                                        $total_forecast_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode) {
                                                                                            return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode) {
                                                                                                if($periode == $f->periode_prognosa) {
                                                                                                    return (int) $f->nilai_forecast;
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                        $total_realisasi_per_divisi_tahunan = $unitKerja->Proyeks->sum(function($p) use($per_sejuta, $i, $periode) {
                                                                                            return $p->Forecasts->where("periode_prognosa", "=", $periode)->sum(function($f) use($periode, $p) {
                                                                                                if($p->stage == 8 && $periode == $f->periode_prognosa) {
                                                                                                    return (int) $f->realisasi_forecast;
                                                                                                }
                                                                                            });
                                                                                            // if($p->tipe_proyek == "R") {
                                                                                            // } else {
                                                                                            //     if($p->stage == 8) {
                                                                                            //         return (int) $p->nilai_perolehan;
                                                                                            //     }
                                                                                            // }
                                                                                        });
                                                                                    }
                                                                                    @endphp 
                                                                                    <!--begin::Total Coloumn-->
                                                                                    {{-- <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-ok-per-divisi-tahunan HidePin">0</td>
                                                                                    <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-forecast-per-divisi-tahunan HidePin">0</td>
                                                                                    <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-realisasi-per-divisi-tahunan HidePin">0</td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-ok-per-divisi-tahunan ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <b>0</b>
                                                                                    </td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-forecast-per-divisi-tahunan ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <b>0</b>
                                                                                    </td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast total-realisasi-per-divisi-tahunan ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <b>0</b>
                                                                                    </td> --}}
                                                                                    <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast HidePin">{{number_format($total_ok_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                                    <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast HidePin">{{number_format($total_forecast_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                                    <td data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast HidePin">{{number_format($total_realisasi_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <b>{{number_format($total_ok_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                    </td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <b>{{number_format($total_forecast_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                    </td>
                                                                                    <td data-dop="{{$dop->dop}}" data-unit-kerja="{{$unitKerja->unit_kerja}}" class="pinForecast ShowPin text-center"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <b>{{number_format($total_realisasi_per_divisi_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                                    </td>
                                                                                    <!--end::Total Coloumn-->
                                                                                </tr>
                                                                                {{-- begin:: Foreach Proyek --}}
                                                                                @if ($column != "")
                                                                                    @foreach ($unitKerja->Proyeks as $proyek)
                                                                                        @php
                                                                                            $forecasts = $proyek->Forecasts->where("periode_prognosa", "=", $periode)->map(function($f) use($per_sejuta) {
                                                                                                $f->rkap_forecast = (int) $f->rkap_forecast / $per_sejuta;
                                                                                                $f->nilai_forecast = round((int) $f->nilai_forecast / $per_sejuta);
                                                                                                // (int) $f->realisasi_forecast /= $per_sejuta;
                                                                                                return $f;
                                                                                            });
                                                                                        @endphp
                                                                                        <tr id="{{ $unit_kerja_name }}"
                                                                                            class="accordion-collapse collapse"
                                                                                            aria-labelledby="{{ $unit_kerja_name }}"
                                                                                            data-bs-parent="#{{ $unit_kerja_name }}"
                                                                                            style="text-align: right;">
                                                                                            <td
                                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 0px; text-align: left">
                                                                                                <!--begin::Child=-->
                                                                                                <p class="ms-12">
                                                                                                    <a target="_blank" href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                                                        class="text-hover-primary text-gray-600">{{ $proyek->nama_proyek }}</a>
                                                                                                </p>
                                                                                                <!--end::Child=-->
                                                                                            </td>

                                                                                            
                                                                                            @for ($i = 0; $i < 12; $i++)
                                                                                            @if ($proyek->tipe_proyek == "R" && $forecasts->count() > 0)
                                                                                                @foreach ($forecasts as $forecast)
                                                                                                    @if ($forecast->month_forecast == $month_counter)
                                                                                                        <!--begin::Nilai OK-->
                                                                                                        @if ($month_counter == (int) $forecast->month_rkap)
                                                                                                            @php
                                                                                                                $total_ok = $forecast->rkap_forecast;
                                                                                                            @endphp
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                {{ number_format($forecast->rkap_forecast, 0, ".", ".")}}
                                                                                                            </td>
                                                                                                            @else
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                0
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        <!--end::Nilai OK-->
                                                                                                        <!--begin::Nilai Forecast-->
                                                                                                        @php
                                                                                                            $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                            $total_year_forecast += $total_forecast;
                                                                                                            
                                                                                                        @endphp
                                                                                                        {{-- @if ($forecast->count() > 0) --}}
                                                                                                            <td>
                                                                                                                <a href="/proyek/view/{{$proyek->kode_proyek}}" target="_blank" class="text-hover-primary">
                                                                                                                    <div class="w-100" style="border-bottom: solid 1px gray" data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                        data-month="{{ $month_counter }}"
                                                                                                                        data-dop="{{$dop->dop}}"
                                                                                                                        data-column-forecast="{{ $month_counter }}"
                                                                                                                        data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                        {{ number_format((int) $forecast->nilai_forecast, 0, ',', '.') }}
                                                                                                                    </div>
                                                                                                                </a>
                                                                                                            </td>
                                                                                                        {{-- @else
                                                                                                            <td>
                                                                                                                <input type="text"
                                                                                                                    data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                    data-month="{{ $month_counter }}"
                                                                                                                    data-dop="{{$dop->dop}}"
                                                                                                                    data-column-forecast="{{ $month_counter }}"
                                                                                                                    data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                    class="form-control border-bottom-1"
                                                                                                                    style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                    id="nilai-forecast"
                                                                                                                    name="nilai-forecast"
                                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                                    value="0"
                                                                                                                    placeholder="" />
                                                                                                            </td>
                                                                                                        @endif --}}
                                                                                                        <!--begin::Nilai Forecast-->
                                                                                                        
                                                                                                        <!--begin::Nilai Realisasi-->
                                                                                                        @if (($month_counter == (int) $forecast->month_realisasi) && $proyek->stage == 8)
                                                                                                            @php
                                                                                                                // $getBulanRIPerolehanNumberOfMonth = array_search( $proyek->bulan_ri_perolehan, $arrNamaBulan);
                                                                                                                $nilai_terkontrak_formatted = (int) $forecast->realisasi_forecast / $per_sejuta ?? '-';
                                                                                                            @endphp
                                                                                                            <td data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                            {{ number_format($nilai_terkontrak_formatted ?? 0, 0, '.', '.') }}
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                0
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        @php
                                                                                                            $is_data_found = true;
                                                                                                        @endphp
                                                                                                        @break
                                                                                                    @endif
                                                                                                @endforeach
                                                                                                    @if (!$is_data_found)
                                                                                                        @php
                                                                                                            $is_data_found = false;
                                                                                                        @endphp
                                                                                                        <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                            data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                            0
                                                                                                        </td>

                                                                                                        <td
                                                                                                            class="">
                                                                                                            <a href="/proyek/view/{{$proyek->kode_proyek}}" target="_blank" class="text-hover-primary">
                                                                                                                <div class="w-100" style="border-bottom: solid 1px gray" data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                    data-month="{{ $month_counter }}"
                                                                                                                    data-dop="{{$dop->dop}}"
                                                                                                                    data-column-forecast="{{ $month_counter }}"
                                                                                                                    data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                    0
                                                                                                                </div>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                            0
                                                                                                        </td>
                                                                                                    @endif
                                                                                                @else
                                                                                                    @foreach ($forecasts as $forecast)
                                                                                                                @if ($month_counter == (int) $forecast->month_rkap)
                                                                                                                    <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                        data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                        {{ number_format($forecast->rkap_forecast, 0, ".", ".") }}
                                                                                                                    </td>
                                                                                                                @else
                                                                                                                    <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                        data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                        0
                                                                                                                    </td>
                                                                                                                @endif
                                                                                                            @if ($forecast->month_forecast == $month_counter)
                                                                                                                @php
                                                                                                                    $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                                    $total_year_forecast += $total_forecast;
                                                                                                                    
                                                                                                                @endphp
                                                                                                                <td>
                                                                                                                    <input type="text"
                                                                                                                        data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                        data-month="{{ $month_counter }}"
                                                                                                                        data-dop="{{$dop->dop}}"
                                                                                                                        data-column-forecast="{{ $month_counter }}"
                                                                                                                        data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                        class="form-control border-bottom-1"
                                                                                                                        style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                        id="nilai-forecast"
                                                                                                                        name="nilai-forecast"
                                                                                                                        onkeyup="reformatNumber(this)"
                                                                                                                        value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', '.') }}"
                                                                                                                        placeholder="" />
                                                                                                                </td>
                                                                                                            @else
                                                                                                                <td>
                                                                                                                    <input type="text"
                                                                                                                        data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                        data-month="{{ $month_counter }}"
                                                                                                                        data-dop="{{$dop->dop}}"
                                                                                                                        data-column-forecast="{{ $month_counter }}"
                                                                                                                        data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                        class="form-control border-bottom-1"
                                                                                                                        style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                        id="nilai-forecast"
                                                                                                                        name="nilai-forecast"
                                                                                                                        onkeyup="reformatNumber(this)"
                                                                                                                        value=""
                                                                                                                        placeholder="" />
                                                                                                                </td>
                                                                                                            @endif
                                                                                                            @if (($month_counter == (int) $forecast->month_realisasi) && $proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                                    @php
                                                                                                                        // $getBulanRIPerolehanNumberOfMonth = array_search( $proyek->bulan_ri_perolehan, $arrNamaBulan);
                                                                                                                        $nilai_terkontrak_formatted = (int) str_replace('.', '', $forecast->realisasi_forecast) / $per_sejuta ?? '-';
                                                                                                                    @endphp
                                                                                                                    <td
                                                                                                                        data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                        {{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', '.') }}
                                                                                                                    </td>
                                                                                                                @else
                                                                                                                    <td
                                                                                                                        data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                        0
                                                                                                                        </td>
                                                                                                                @endif
                                                                                                                @php
                                                                                                                    $is_data_found = true;
                                                                                                                @endphp
                                                                                                            @break
                                                                                                    @endforeach
                                                                                                    @if (!$is_data_found)
                                                                                                        <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                            data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                            0
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input type="text"
                                                                                                                data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                data-month="{{ $month_counter }}"
                                                                                                                data-dop="{{$dop->dop}}"
                                                                                                                data-column-forecast="{{ $month_counter }}"
                                                                                                                data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                class="form-control border-bottom-1"
                                                                                                                style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                id="nilai-forecast"
                                                                                                                name="nilai-forecast"
                                                                                                                onkeyup="reformatNumber(this)"
                                                                                                                value=""
                                                                                                                placeholder="" />
                                                                                                        </td>
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                            0
                                                                                                            </td>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @php
                                                                                                $is_data_found = false;
                                                                                                $total_ok = (int) str_replace(',', '', $proyek->nilai_rkap)/ $per_sejuta;
                                                                                                $month_counter++;
                                                                                            @endphp
                                                                                        @endfor
                                                                                        <!--begin::Total Side Coloumn-->
                                                                                        @php
                                                                                            $total_ok_formatted = number_format($total_ok, 0, ',', '.');
                                                                                            $total_forecast_formatted = number_format($total_forecast, 0, ',', '.');
                                                                                            if(!empty($proyek->bulan_ri_perolehan)) {
                                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_perolehan) / $per_sejuta;
                                                                                            } else {
                                                                                                $nilai_terkontrak_formatted = 0;
                                                                                            }
                                                                                            $total_forecast = 0;
                                                                                            $total_ok = 0;
                                                                                            $month_counter = 1;
                                                                                        @endphp
                                                                                        <td class="pinForecast HidePin">
                                                                                            <center>
                                                                                                <b>{{ $total_ok_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast HidePin"
                                                                                            data-id-proyek="{{ $proyek->kode_proyek }}">
                                                                                            <center>
                                                                                                <b>{{ $total_forecast_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast HidePin"
                                                                                            data-id-proyek-realisasi-bulanan="{{ $proyek->kode_proyek }}">
                                                                                            @if ($proyek->tipe_proyek == "R")
                                                                                                    @php
                                                                                                        $total_realisasi_tahunan = $forecasts->sum(function($f) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }) / $per_sejuta;
                                                                                                    @endphp
                                                                                                    <center>
                                                                                                        <b>{{ number_format($total_realisasi_tahunan ?? 0, 0, ',', '.') }}</b>
                                                                                                    </center>
                                                                                            @else 
                                                                                                @if ($proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                    <center>
                                                                                                        <b>{{ number_format(($nilai_terkontrak_formatted), 0, ',', '.')  }}</b>
                                                                                                    </center>
                                                                                                @else
                                                                                                    <center>
                                                                                                        <b>0</b>
                                                                                                    </center>
                                                                                                @endif
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin"
                                                                                            data-id-proyek-ok-bulanan-total="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -wekit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                            <center>
                                                                                                <b>{{ $total_ok_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin total-month-x-forecast"
                                                                                            data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                            <center>
                                                                                                <b>{{ $total_forecast_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin total-month-x-realisasi-bulanan"
                                                                                            data-id-proyek-realisasi-bulanan="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                            @if ($proyek->tipe_proyek == "R")
                                                                                                    @php
                                                                                                        $total_realisasi_tahunan = $forecasts->sum(function($f) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }) / $per_sejuta;
                                                                                                    @endphp
                                                                                                    <center>
                                                                                                        <b>{{ number_format($total_realisasi_tahunan ?? 0, 0, ',', '.') }}</b>
                                                                                                    </center>
                                                                                            @else 
                                                                                                @if ($proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                    <center>
                                                                                                        <b>{{ number_format(($nilai_terkontrak_formatted), 0, ',', '.')  }}</b>
                                                                                                    </center>
                                                                                                @else
                                                                                                    <center>
                                                                                                        <b>0</b>
                                                                                                    </center>
                                                                                                @endif
                                                                                            @endif
                                                                                        </td>
                                                                                        <!--end::Total Side Coloumn-->
                                                                                        @php
                                                                                            $nilai_terkontrak_formatted = 0;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @else
                                                                                    @foreach ($unitKerja->Proyeks as $proyek)
                                                                                    
                                                                                        <tr id="{{ $unit_kerja_name }}"
                                                                                            class="accordion-collapse collapse"
                                                                                            aria-labelledby="{{ $unit_kerja_name }}"
                                                                                            data-bs-parent="#{{ $unit_kerja_name }}"
                                                                                            style="text-align: right;">
                                                                                            <td
                                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 0px; text-align: left">
                                                                                                <!--begin::Child=-->
                                                                                                <p class="ms-12">
                                                                                                    <a target="_blank" href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                                                        class="text-hover-primary text-gray-600">{{ $proyek->nama_proyek }}</a>
                                                                                                </p>
                                                                                                <!--end::Child=-->
                                                                                            </td>
                                                                                            @php
                                                                                                $forecasts = $proyek->Forecasts->where("periode_prognosa", "=", $periode)->map(function($f) use($per_sejuta) {
                                                                                                    $f->rkap_forecast = (int) $f->rkap_forecast /$per_sejuta;
                                                                                                    $f->nilai_forecast = round((int) $f->nilai_forecast / $per_sejuta);
                                                                                                    return $f;
                                                                                                });
                                                                                            @endphp
                                                                                            @for ($i = 0; $i < 12; $i++)
                                                                                                @if ($proyek->tipe_proyek == "R" && $forecasts->count() > 0)
                                                                                                    @foreach ($forecasts as $forecast)
                                                                                                        @if ($forecast->month_forecast == $month_counter)
                                                                                                            <!--begin::Nilai OK-->
                                                                                                            @if ($month_counter == (int) $forecast->month_rkap)
                                                                                                                @php
                                                                                                                    $total_ok = $forecast->rkap_forecast;
                                                                                                                @endphp
                                                                                                                <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                    data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                    {{ number_format($forecast->rkap_forecast, 0, ".", ".")}}
                                                                                                                </td>
                                                                                                                @else
                                                                                                                <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                    data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                    0
                                                                                                                </td>
                                                                                                            @endif
                                                                                                            <!--end::Nilai OK-->
                                                                                                            <!--begin::Nilai Forecast-->
                                                                                                            @php
                                                                                                                $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                                $total_year_forecast += $total_forecast;
                                                                                                                
                                                                                                            @endphp
                                                                                                            {{-- @if ($forecast->count() > 0) --}}
                                                                                                                <td >
                                                                                                                    <a href="/proyek/view/{{$proyek->kode_proyek}}" target="_blank" class="text-hover-primary">
                                                                                                                        <div class="w-100" style="border-bottom: solid 1px gray" data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                            data-month="{{ $month_counter }}"
                                                                                                                            data-dop="{{$dop->dop}}"
                                                                                                                            data-column-forecast="{{ $month_counter }}"
                                                                                                                            data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                            {{ number_format((int) $forecast->nilai_forecast, 0, ',', '.') }}
                                                                                                                        </div>
                                                                                                                    </a>
                                                                                                                </td>
                                                                                                            {{-- @else
                                                                                                                <td>
                                                                                                                    <input type="text"
                                                                                                                        data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                        data-month="{{ $month_counter }}"
                                                                                                                        data-dop="{{$dop->dop}}"
                                                                                                                        data-column-forecast="{{ $month_counter }}"
                                                                                                                        data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                        class="form-control border-bottom-1"
                                                                                                                        style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                        id="nilai-forecast"
                                                                                                                        name="nilai-forecast"
                                                                                                                        onkeyup="reformatNumber(this)"
                                                                                                                        value="0"
                                                                                                                        placeholder="" />
                                                                                                                </td>
                                                                                                            @endif --}}
                                                                                                            <!--begin::Nilai Forecast-->
                                                                                                            
                                                                                                            <!--begin::Nilai Realisasi-->
                                                                                                            @if (($month_counter == (int) $forecast->month_realisasi) && $proyek->stage == 8)
                                                                                                                @php
                                                                                                                    // $getBulanRIPerolehanNumberOfMonth = array_search( $proyek->bulan_ri_perolehan, $arrNamaBulan);
                                                                                                                    $nilai_terkontrak_formatted = (int) $forecast->realisasi_forecast / $per_sejuta ?? '-';
                                                                                                                @endphp
                                                                                                                <td data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                {{ number_format($nilai_terkontrak_formatted ?? 0, 0, '.', '.') }}
                                                                                                                </td>
                                                                                                            @else
                                                                                                                <td data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                    0
                                                                                                                </td>
                                                                                                            @endif
                                                                                                            @php
                                                                                                                $is_data_found = true;
                                                                                                            @endphp
                                                                                                            @break
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                    @if (!$is_data_found)
                                                                                                        @php
                                                                                                            $is_data_found = false;
                                                                                                        @endphp
                                                                                                        @if ($proyek->bulan_pelaksanaan == $month_counter && $proyek->bulan_pelaksanaan != null)
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                {{ number_format((int) $proyek->nilai_rkap / $per_sejuta, 0, ",", ".") }}
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                0
                                                                                                            </td>
                                                                                                        @endif

                                                                                                        <td >
                                                                                                            <a href="/proyek/view/{{$proyek->kode_proyek}}" target="_blank" class="text-hover-primary">
                                                                                                                <div class="w-100" style="border-bottom: solid 1px gray" data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                    data-month="{{ $month_counter }}"
                                                                                                                    data-dop="{{$dop->dop}}"
                                                                                                                    data-column-forecast="{{ $month_counter }}"
                                                                                                                    data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                    class="">
                                                                                                                    0
                                                                                                                </div>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                        
                                                                                                        @if ($month_counter == (int) $proyek->bulan_ri_perolehan && $proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                            @php
                                                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_perolehan) ?? '-';
                                                                                                            @endphp
                                                                                                            <td
                                                                                                                data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                {{ number_format($nilai_terkontrak_formatted / $per_sejuta, 0, ',', '.') }}
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td
                                                                                                                data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                0
                                                                                                                </td>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @else
                                                                                                    @foreach ($forecasts as $forecast)
                                                                                                            @if ($forecast->month_forecast == $month_counter)
                                                                                                                @if ($month_counter == (int) $forecast->month_rkap)
                                                                                                                    <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                        data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                        {{ number_format($forecast->rkap_forecast / $per_sejuta, 0, ".", ".") }}
                                                                                                                    </td>
                                                                                                                @else
                                                                                                                    <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                        data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                        0
                                                                                                                    </td>
                                                                                                                @endif
                                                                                                                @php
                                                                                                                    $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                                    $total_year_forecast += $total_forecast;
                                                                                                                    
                                                                                                                @endphp
                                                                                                                <td>
                                                                                                                    <input type="text"
                                                                                                                        data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                        data-month="{{ $month_counter }}"
                                                                                                                        data-dop="{{$dop->dop}}"
                                                                                                                        data-column-forecast="{{ $month_counter }}"
                                                                                                                        data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                        class="form-control border-bottom-1"
                                                                                                                        style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                        id="nilai-forecast"
                                                                                                                        name="nilai-forecast"
                                                                                                                        onkeyup="reformatNumber(this)"
                                                                                                                        value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', '.') }}"
                                                                                                                        placeholder="" />
                                                                                                                </td>
                                                                                                            @if (($month_counter == (int) $forecast->month_realisasi) && $proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                                    @php
                                                                                                                        // $getBulanRIPerolehanNumberOfMonth = array_search( $proyek->bulan_ri_perolehan, $arrNamaBulan);
                                                                                                                    @endphp
                                                                                                                    <td
                                                                                                                        data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                        {{ number_format((int) str_replace(".", "", $forecast->realisasi_forecast) / $per_sejuta, 0, ',', '.') }}
                                                                                                                    </td>
                                                                                                                @else
                                                                                                                    <td
                                                                                                                        data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                        0
                                                                                                                        </td>
                                                                                                                @endif
                                                                                                                @php
                                                                                                                    $is_data_found = true;
                                                                                                                @endphp
                                                                                                            @break
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                    @if (!$is_data_found)
                                                                                                        @if ($proyek->bulan_pelaksanaan == $month_counter && $proyek->bulan_pelaksanaan != null)
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                {{ number_format((int) $proyek->nilai_rkap / $per_sejuta, 0, ",", ".") }}
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}" data-dop="{{$dop->dop}}"
                                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}" data-unit-kerja="{{$unitKerja->unit_kerja}}">
                                                                                                                0
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        <td>
                                                                                                            <input type="text"
                                                                                                                data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                                data-month="{{ $month_counter }}"
                                                                                                                data-dop="{{$dop->dop}}"
                                                                                                                data-column-forecast="{{ $month_counter }}"
                                                                                                                data-unit-kerja="{{$unitKerja->unit_kerja}}"
                                                                                                                class="form-control border-bottom-1"
                                                                                                                style="border: 0px;border-bottom: 1px solid #b5b5c3; border-radius: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                                id="nilai-forecast"
                                                                                                                name="nilai-forecast"
                                                                                                                onkeyup="reformatNumber(this)"
                                                                                                                value=""
                                                                                                                placeholder="" />
                                                                                                        </td>
                                                                                                        @if ($month_counter == (int) $proyek->bulan_ri_perolehan && $proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                            @php
                                                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_perolehan) ?? '-';
                                                                                                            @endphp
                                                                                                            <td
                                                                                                                data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                {{ number_format($nilai_terkontrak_formatted / $per_sejuta, 0, ',', '.') }}
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td
                                                                                                                data-column-realisasi-bulanan="{{ $month_counter }}" data-unit-kerja="{{$unitKerja->unit_kerja}}" data-dop="{{$dop->dop}}">
                                                                                                                0
                                                                                                                </td>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif
                                                                                            @php
                                                                                                $is_data_found = false;
                                                                                                $total_ok = (int) str_replace(',', '', $proyek->nilai_rkap)/ $per_sejuta;
                                                                                                $month_counter++;
                                                                                            @endphp
                                                                                        @endfor
                                                                                        <!--begin::Total Side Coloumn-->
                                                                                        @php
                                                                                            $total_ok_formatted = number_format($total_ok, 0, ',', '.');
                                                                                            $total_forecast_formatted = number_format($total_forecast, 0, ',', '.');
                                                                                            if(!empty($proyek->bulan_ri_perolehan)) {
                                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_perolehan) / $per_sejuta;
                                                                                            } else {
                                                                                                $nilai_terkontrak_formatted = 0;
                                                                                            }
                                                                                            $total_forecast = 0;
                                                                                            $total_ok = 0;
                                                                                            $month_counter = 1;
                                                                                        @endphp
                                                                                        <td class="pinForecast HidePin">
                                                                                            <center>
                                                                                                <b>{{ $total_ok_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast HidePin"
                                                                                            data-id-proyek="{{ $proyek->kode_proyek }}">
                                                                                            <center>
                                                                                                <b>{{ $total_forecast_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast HidePin"
                                                                                            data-id-proyek-realisasi-bulanan="{{ $proyek->kode_proyek }}">
                                                                                            @if ($proyek->tipe_proyek == "R")
                                                                                                    @php
                                                                                                        $total_realisasi_tahunan = $forecasts->sum(function($f) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }) / $per_sejuta;
                                                                                                    @endphp
                                                                                                    <center>
                                                                                                        <b>{{ number_format($total_realisasi_tahunan ?? 0, 0, ',', '.') }}</b>
                                                                                                    </center>
                                                                                            @else 
                                                                                                @if ($proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                    <center>
                                                                                                        <b>{{ number_format(($nilai_terkontrak_formatted), 0, ',', '.')  }}</b>
                                                                                                    </center>
                                                                                                @else
                                                                                                    <center>
                                                                                                        <b>0</b>
                                                                                                    </center>
                                                                                                @endif
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin"
                                                                                            data-id-proyek-ok-bulanan-total="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -wekit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                            <center>
                                                                                                <b>{{ $total_ok_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin total-month-x-forecast"
                                                                                            data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                            <center>
                                                                                                <b>{{ $total_forecast_formatted }}</b>
                                                                                            </center>
                                                                                        </td>
                                                                                        <td class="pinForecast ShowPin total-month-x-realisasi-bulanan"
                                                                                            data-id-proyek-realisasi-bulanan="{{ $proyek->kode_proyek }}"
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                            @if ($proyek->tipe_proyek == "R")
                                                                                                    @php
                                                                                                        $total_realisasi_tahunan = $forecasts->sum(function($f) {
                                                                                                            return (int) $f->realisasi_forecast;
                                                                                                        }) / $per_sejuta;
                                                                                                    @endphp
                                                                                                    <center>
                                                                                                        <b>{{ number_format($total_realisasi_tahunan ?? 0, 0, ',', '.') }}</b>
                                                                                                    </center>
                                                                                            @else 
                                                                                                @if ($proyek->bulan_ri_perolehan != null && $proyek->stage == 8)
                                                                                                    <center>
                                                                                                        <b>{{ number_format(($nilai_terkontrak_formatted), 0, ',', '.')  }}</b>
                                                                                                    </center>
                                                                                                @else
                                                                                                    <center>
                                                                                                        <b>0</b>
                                                                                                    </center>
                                                                                                @endif
                                                                                            @endif
                                                                                        </td>
                                                                                        <!--end::Total Side Coloumn-->
                                                                                        @php
                                                                                            $nilai_terkontrak_formatted = 0;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @endif
                                                                            {{-- end:: Foreach Proyek --}}
                                                                            
                                                                        @endif
                                                                        @php
                                                                            $total_forecast = 0;
                                                                            $total_ok = 0;
                                                                            $month_counter = 1;
                                                                            $total_year_forecast += $total_forecast;
                                                                        @endphp
                                                                    @endforeach
                                                                    {{-- end:: Foreach Unit Kerja --}}
                                                                    {{-- @endif --}}
                                                                @endforeach
                                                                        </div>
                                                                    </div>


                                                        </tbody>

                                                        <tfoot id="footer" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                            <div class="m-4">
                                                                <tr>
                                                                    <td
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 1rem; text-align: left">
                                                                        <!--begin::Child=-->
                                                                        <b>Total</b>
                                                                        <!--end::Child=-->
                                                                    </td>
                                                                    @for ($i = 0; $i < 12; $i++)
                                                                        <td
                                                                            data-total-ok-bulanan-column={{ $i + 1 }}>
                                                                            <center>
                                                                                <p class="placeholder-wave">
                                                                                    <span
                                                                                        class="placeholder col-4"></span>
                                                                                </p>
                                                                            </center>
                                                                        </td>
                                                                        <td
                                                                            data-total-forecast-column={{ $i + 1 }}>
                                                                            <center>
                                                                                <p class="placeholder-wave">
                                                                                    <span
                                                                                        class="placeholder col-4"></span>
                                                                                </p>
                                                                            </center>
                                                                        </td>
                                                                        <td
                                                                            data-total-realisasi-bulanan-column={{ $i + 1 }}>
                                                                            <center>
                                                                                <p class="placeholder-wave">
                                                                                    <span
                                                                                        class="placeholder col-4"></span>
                                                                                </p>
                                                                            </center>
                                                                        </td>
                                                                    @endfor
                                                                    {{-- begin::Total Year --}}
                                                                    {{-- <td
                                                                        class="pinForecast HidePin total-year-ok-bulanan">
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span class="placeholder col-4"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td> --}}
                                                                    <td
                                                                        class="pinForecast HidePin">
                                                                        <center>
                                                                            <p class="">
                                                                                <b class="col-4">{{number_format($total_ok_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                    <td
                                                                        class="pinForecast HidePin">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{number_format($nilaiTotalForecastTahun / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td>
                                                                    {{-- <td
                                                                        class="pinForecast HidePin total-year-forecast-bulanan">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{ number_format((int) $total_year_forecast, 0, ',', '.') }}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td> --}}
                                                                    <td
                                                                        class="pinForecast HidePin">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{number_format($nilaiTotalRealisasiTahun / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td>
                                                                    {{-- <td
                                                                        class="pinForecast HidePin total-year-realisasi-bulanan">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{ $proyek->nilai_perolehan }}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td> --}}
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center>
                                                                            <p class="mt-4">
                                                                                <b class="col-4">{{number_format($total_ok_tahunan / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                    {{-- <td class="pinForecast ShowPin total-year-ok-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span class="placeholder col-4"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td> --}}
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{number_format($nilaiTotalForecastTahun / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td>
                                                                    {{-- <td class="pinForecast ShowPin total-year-forecast-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{ number_format((int) $total_year_forecast, 0, ',', '.') }}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td> --}}
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{number_format($nilaiTotalRealisasiTahun / $per_sejuta, 0, ".", ".")}}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td>
                                                                    {{-- <td class="pinForecast ShowPin total-year-realisasi-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        @if (isset($unitKerja))
                                                                            <center>
                                                                                <b>{{ $proyek->nilai_perolehan }}</b>
                                                                            </center>
                                                                        @else 
                                                                            <center>
                                                                                <b>0</b>
                                                                            </center>
                                                                        @endif
                                                                    </td> --}}
                                                                    {{-- end::Total Year --}}
                                                                </tr>
                                                            </div>
                                                        </tfoot>
                                                            {{-- @endforeach --}}
                                                            </table>
                                                            </div>
                                    
                                                        </div>    
                                                        <!--end::Table body-->
                                                        <!--end:::Tab Forecast Bulanan-->
                                                    </div>
                                                {{-- @else 
                                                <div class="tab-content mt-10" id="myTabContent">
                                                    <div class="col">
                                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                                            <p>Data Proyek tidak ditemukan</p>
                                                            <a href="#" class="btn btn-md btn-active-primary text-white" style="background-color: #008CB4">Buat Proyek</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif --}}
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

{{-- <script src="/datatables/jquery-3.5.1.js"></script>
<script src="/datatables/jquery.dataTables.min.js"></script>
<script src="/datatables/dataTables.fixedColumns.min.js"></script> --}}

<script>
    // $(document).ready(function() {
    //     var table = $('#kt_forecast_table').DataTable( {
    //         scrollY:        "300px",
    //         scrollX:        true,
    //         scrollCollapse: true,
    //         paging:         false,
    //         fixedColumns:   {
    //             left: 1,
    //             right: 1
    //         }
    //     } );
    // } );
</script>

<script>
    const toaster = document.querySelector(".toast");
    const toastBody = document.querySelector(".toast-body")
    const toastBoots = new bootstrap.Toast(toaster, {});
    const perSejuta = Number("{{$per_sejuta}}");
    [historyForecast].forEach(unitKerja => {
        disabledAllInputs(unitKerja);
    })

    function reformatNumber(elt) {
        const valueFormatted = Intl.NumberFormat(["id"], {
            maximumFractionDigits: 0,
        }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
        elt.value = valueFormatted;
    }

    function updateData(attribute) {
        let totalColumnAttribute = "";
        let dataColumnAttribute = "";
        let totalYearForecast = "";
        let totalMonthXForecast = "";
        if (attribute.includes("internal")) {
            totalColumnAttribute = "data-total-forecast-internal-column";
            dataColumnAttribute = "data-column-forecast-internal";
            totalYearForecast = "total-year-forecast-internal";
            totalMonthXForecast = "total-month-x-forecast-internal";
            // dataIdProyekForecast = "data-id-proyek-forecast-internal";
        } else if (attribute.includes("sd")) {
            totalColumnAttribute = "data-total-column-forecast-sd";
            dataColumnAttribute = "data-column-forecast-sd";
            totalYearForecast = "total-year-forecast-sd";
            totalMonthXForecast = "total-month-x-forecast-sd";
            // dataIdProyekForecast = "data-id-proyek-forecast-sd";

        } else if (attribute.includes("eksternal")) {
            totalColumnAttribute = "data-total-column-forecast-sd-eksternal";
            dataColumnAttribute = "data-column-forecast-sd-eksternal";
            totalYearForecast = "total-year-forecast-sd-eksternal";
            totalMonthXForecast = "total-month-x-forecast-sd-eksternal";

        } else {
            totalColumnAttribute = "data-total-forecast-column";
            dataColumnAttribute = "data-column-forecast";
            totalYearForecast = "total-year-forecast";
            totalMonthXForecast = "total-month-x-forecast";
            // dataIdProyekForecast = "data-id-proyek";
        }

        const inputForecasts = document.querySelectorAll(`input[${attribute}]`);
        inputForecasts.forEach(input => {
            input.addEventListener("focusout", async e => {
                const nilaiForecast = Number(e.target.value.toString().replaceAll(".", ""));
                const kodeProyek = input.getAttribute(attribute);
                Swal.fire({
                    title: 'Yakin Update Forecast menjadi Rp. ' + Intl.NumberFormat(["id"]).format(nilaiForecast * perSejuta) + "?",
                    text: "Proyek Non-Retail tidak dapat menginput multi bulan.",
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: '#008CB4',
                    cancelButtonColor: '#BABABA',
                    confirmButtonText: 'Ya'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                // if (nilaiForecast == 0) {
                //     Toast.fire({
                //         html: "Inputan tidak boleh 0 atau kosong",
                //         icon: "error",
                //     });
                //     e.target.value = "";
                //     return; 
                // }
                const dataMonth = input.getAttribute("data-month");
                const dataColumn = input.getAttribute(dataColumnAttribute);
                const columnTotalYearForecast = document.querySelectorAll(`.${totalYearForecast}`);
                const columnDataYearForecast = document.querySelectorAll(`.${totalMonthXForecast}`);
                const dataColumnSame = document.querySelectorAll(`input[data-month="${dataMonth}"]`)
                const columnForecastElt = document.querySelectorAll(
                    `input[${dataColumnAttribute}="${dataColumn}"]`);
                const rowForecastElt = document.querySelectorAll(
                    `input[${attribute}="${kodeProyek}"]`);
                const rowTotalForecastElt = document.querySelectorAll(
                    `td[${attribute}="${kodeProyek}"]`);

                // const totalColumn = document.querySelector(
                //     `td[${totalColumnAttribute}="${dataColumn}"]`);
                let totalColumnForecast = 0;
                let totalColumnYearForecast = 0;
                let totalRowForecast = 0;



                const formData = new FormData();

                formData.append("_token", "{{ csrf_token() }}");
                formData.append("nilai_forecast", nilaiForecast);
                formData.append("forecast_month", dataMonth);
                formData.append("kode_proyek", kodeProyek);
                formData.append("periode_prognosa", "{{$periode}}");
                const saveNilaiForecastRes = await fetch("/proyek/forecast/save", {
                    method: "POST",
                    header: {
                        "content-type": "application/json"
                    },
                    body: formData
                }).then(res => res.json());
                if (saveNilaiForecastRes.status == "success") {
                    const nilaiFormatted = Intl.NumberFormat(["id"], {
                        maximumFractionDigits: 0,
                    }).format(nilaiForecast);

                    dataColumnSame.forEach(dataColumn => {
                        const getAttributeIdProyek = dataColumn.getAttributeNames()[1];
                        const getIdProyek = dataColumn.getAttribute(getAttributeIdProyek);
                        if (getIdProyek == kodeProyek) {
                            dataColumn.value = nilaiFormatted;
                        }
                    });

                    columnForecastElt.forEach(columnForecast => {
                        if (columnForecast.value != null) {
                            totalColumnForecast += Number(columnForecast.value.toString()
                                .replaceAll(".", ""));
                        }
                    })
                    rowForecastElt.forEach(rowForecast => {
                        if (rowForecast.value != null) {
                            totalRowForecast += Number(rowForecast.value.toString()
                                .replaceAll(".", ""));
                        }
                    });

                    const rowValueFormatted = Intl.NumberFormat(["id"], {
                        maximumFractionDigits: 0,
                    }).format(totalRowForecast);
                    const columnValueFormatted = Intl.NumberFormat(["id"], {
                        maximumFractionDigits: 0,
                    }).format(totalColumnForecast);

                    input.value = nilaiFormatted;
                    // toaster.classList.add("text-bg-success")
                    // toaster.classList.remove("text-bg-danger")
                    // toastBody.innerHTML = saveNilaiForecastRes.msg;
                    rowTotalForecastElt.forEach(rowForecast => {
                        rowForecast.innerHTML = `
                    <center>
                        <b>${rowValueFormatted}</b>
                    </center>
                    `;
                    });

                    //     totalColumn.innerHTML = `
                    // <td>
                    //     <center><b>${columnValueFormatted}</b></center>
                    // </td>
                    // `;

                    columnDataYearForecast.forEach(columnDataTotalYear => {
                        if (columnDataTotalYear.innerText != null || columnDataTotalYear
                            .innerText != "0") {
                            totalColumnYearForecast += Number(columnDataTotalYear.innerText
                                .toString().replaceAll(".", ""));
                        }
                    });

                    const columnTotalYearForecastFormatted = Intl.NumberFormat(["id"], {
                        maximumFractionDigits: 0,
                    }).format(totalColumnYearForecast);

                    columnTotalYearForecast.forEach(colTotal => {
                        colTotal.innerHTML = `
                    <center>
                        <b>${columnTotalYearForecastFormatted}</b>
                    </center>
                    `;
                    });

                    recalculateColumn();
                    Toast.fire({
                        html: saveNilaiForecastRes.msg,
                        icon: "success",
                    });
                    // Swal.fire({
                    //     html: saveNilaiForecastRes.msg,
                    //     target: '#custom-toaster',
                    //     customClass: {
                    //         container: 'position-absolute'
                    //     },
                    //     toast: true,
                    //     // timer: 3000,
                    //     confirmButtonColor: "#008cb4",
                    //     position: 'top-right'
                    // });
                } else {
                    Toast.fire({
                        html: saveNilaiForecastRes.msg,
                        icon: "error",
                    });
                    // Swal.fire({
                    //     html: saveNilaiForecastRes.msg,
                    //     target: '#custom-toaster',
                    //     customClass: {
                    //         container: 'position-absolute'
                    //     },
                    //     toast: true,
                    //     confirmButtonColor: "#008cb4",
                    //     // timer: 3000,
                    //     position: 'top-right'
                    // });
                    // toaster.classList.remove("text-bg-success")
                    // toaster.classList.add("text-bg-danger")
                    // toastBody.innerHTML = saveNilaiForecastRes.msg;
                }
                // let counterTimer = 3;
                // let width = 0;
                // const toasterTimer = document.querySelector("#toaster-timer");
                // const toasterTimerBefore = window.getComputedStyle(
                //     document.querySelector('#toaster-timer'), ':before'
                // ).getPropertyValue("width");
                // const timerOut = setInterval(() => {
                //     counterTimer--;
                //     width = Math.floor(toasterTimer.clientWidth / counterTimer);
                //     toasterTimerBefore.style.setProperty("width") += `${width}px`;
                //     toasterTimer.innerHTML =
                //         `<span style="position:relative;z-index:3;">${counterTimer}</span>`;
                //     if (counterTimer == 0) {
                //         clearInterval(timerOut);
                //     }
                // }, 1000);
                    }
                    return false;
                });
            });
        });
    }

    updateData("data-id-proyek");
    updateData("data-id-proyek-forecast-internal");
    updateData("data-id-proyek-forecast-sd");
    updateData("data-id-proyek-forecast-sd-eksternal");

    function recalculateColumn() {
        // begin Calculate Total Column Forecast Bulanan 
        const dataColumnTotalForecast = document.querySelectorAll(`td[data-total-forecast-column]`);
        let totalForecast = 0;
        dataColumnTotalForecast.forEach((forecast, i) => {
            const totalColumnForecast = forecast.getAttribute("data-total-forecast-column");
            let dataColumnForecast = document.querySelectorAll(
                `[data-column-forecast="${totalColumnForecast}"]`);
            // if(dataColumnForecast) {
            //     dataColumnForecast = document.querySelectorAll(
            //     `[data-column-forecast="${totalColumnForecast}"]`);
            // }
            dataColumnForecast.forEach(dataForecast => {
                // totalForecast += isNaN(Number(dataForecast.value.replaceAll(".", ""))) ? 0 : Number(
                //     dataForecast.innerText.replaceAll(".", ""));
                totalForecast += dataForecast.value ? Number(dataForecast.value.replaceAll(".", "")) : Number(dataForecast.innerText.replaceAll(".", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat(["id"], {
                    maximumFractionDigits: 0,
                }).format(totalForecast);
                forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
            }
            totalForecast = 0;
        });
        // end Calculate Total Column Forecast Bulanan

        // begin Calculate Total Column Forecast Internal 
        const dataColumnTotalForecastInternal = document.querySelectorAll(`td[data-total-forecast-internal-column]`);
        let totalForecastInternal = 0;
        dataColumnTotalForecastInternal.forEach((forecast, i) => {
            const totalColumnForecast = forecast.getAttribute("data-total-forecast-internal-column");
            const dataColumnForecast = document.querySelectorAll(
                `input[data-column-forecast-internal="${totalColumnForecast}"]`);
            dataColumnForecast.forEach(dataForecast => {
                totalForecastInternal += isNaN(Number(dataForecast.innerText.replaceAll(".", ""))) ? 0 :
                    Number(dataForecast.innerText.replaceAll(".", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat(["id"], {
                    maximumFractionDigits: 0,
                }).format(totalForecastInternal);
                forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
            }
            totalForecastInternal = 0;
        });
        // end Calculate Total Column Forecast Internal

        // begin Calculate Total Column Forecast S/D 
        const dataColumnTotalForecastSD = document.querySelectorAll(`td[data-total-column-forecast-sd]`);
        let totalForecastSD = 0;
        dataColumnTotalForecastSD.forEach((forecast, i) => {
            const totalColumnForecast = forecast.getAttribute("data-total-column-forecast-sd");
            const dataColumnForecast = document.querySelectorAll(
                `td[data-column-forecast-sd="${totalColumnForecast}"]`);
            dataColumnForecast.forEach(dataForecast => {
                totalForecastSD += isNaN(Number(dataForecast.innerText.replaceAll(".", ""))) ? 0 :
                    Number(dataForecast.innerText.replaceAll(".", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat(["id"], {
                    maximumFractionDigits: 0,
                }).format(totalForecastSD);
                forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
            }
            totalForecastSD = 0;
        });
        // end Calculate Total Column Forecast S/D

        // begin calculate total column OK Bulanan
        const dataColumnTotalOKBulanan = document.querySelectorAll(`td[data-total-ok-bulanan-column]`);
        let totalOKBulanan = 0;
        dataColumnTotalOKBulanan.forEach((forecast, i) => {
            const totalColumnForecast = forecast.getAttribute("data-total-ok-bulanan-column");
            const dataColumnForecast = document.querySelectorAll(
                `td[data-column-ok-bulanan="${totalColumnForecast}"]`);
            dataColumnForecast.forEach(dataForecast => {
                totalOKBulanan += isNaN(Number(dataForecast.innerText.replaceAll(".", ""))) ? 0 :
                    Number(dataForecast.innerText.replaceAll(".", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat(["id"], {
                    maximumFractionDigits: 0,
                }).format(totalOKBulanan);
                forecast.innerHTML = `
                <center><b>${formattedForecastValue}</b></center>
                `;
            }
            totalOKBulanan = 0;
        });
        // end calculate total column OK Bulanan

        // begin calculate total column Realisasi Bulanan
        const dataColumnTotalRealisasiBulanan = document.querySelectorAll(`td[data-total-realisasi-bulanan-column]`);
        let totalRealisasiBulanan = 0;
        dataColumnTotalRealisasiBulanan.forEach((forecast, i) => {
            const totalColumnForecast = forecast.getAttribute("data-total-realisasi-bulanan-column");
            const dataColumnForecast = Array.from(document.querySelectorAll(
            `td[data-column-realisasi-bulanan="${totalColumnForecast}"]`));
            dataColumnForecast.forEach(dataForecast => {
                const nilaiRealisasi = Number(dataForecast.innerText.trim().replaceAll(/[^0-9]/gi, ""));
                if(nilaiRealisasi) {
                    totalRealisasiBulanan += nilaiRealisasi;
                }
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat(["id"]).format(totalRealisasiBulanan);
                forecast.innerHTML = `
                    <td>
                        <center><b>${formattedForecastValue ?? 0}</b></center>
                    </td>
                    `;
            }
            totalRealisasiBulanan = 0;
        });
        // end calculate total column Realisasi Bulanan

        // Begin Forecast Internal Script
        // begin OK Total
        sumColumn("td[total-column-y-ok]", "total-column-y-ok", "td[data-column-ok-internal]",
            "data-column-ok-internal");
        // end OK Total

        // begin Realisasi
        sumColumn("td[total-column-y-realisasi]", "total-column-y-realisasi", "td[data-column-realisasi-internal]",
            "data-column-realisasi-internal");
        // end Realisasi

        // // begin Total Forecast Column
        // sumColumnYear(".total-year-forecast", ".total-month-x-forecast");
        // // end Total Forecast Column

        // begin Total Forecast Column Internal
        sumColumnYear(".total-year-forecast-interal", ".total-month-x-forecast-internal");
        // end Total Forecast Column Internal

        // begin Total OK Column Internal
        sumColumnYear(".total-year-ok-internal", ".total-month-x-ok-internal");
        // end Total OK Column Internal

        // begin Total OK Column Internal
        sumColumnYear(".total-year-realisasi-interal", ".total-month-x-realisasi-internal");
        // end Total OK Column Internal

        // End Forecast Internal Script

        // Begin Forecast S/D Script

        // begin ok
        sumColumn("td[data-total-column-ok-sd]", "data-total-column-ok-sd", "td[data-column-ok-sd]",
            "data-column-ok-sd");
        // end ok

        // begin forecast
        sumColumn("td[data-total-column-forecast-sd]", "data-total-column-forecast-sd",
            "input[data-column-forecast-sd]",
            "data-column-forecast-sd");
        // end forecast

        // begin forecast
        sumColumn("td[data-total-column-realisasi-sd]", "data-total-column-realisasi-sd",
            "td[data-column-realisasi-sd]",
            "data-column-realisasi-sd");
        // end forecast

        // begin year ok
        sumColumnYear(".total-year-ok-sd", ".total-month-x-ok-sd");
        // end year ok

        // begin year realisasi
        sumColumnYear(".total-year-realisasi-sd", ".total-month-x-realisasi-sd");
        // end year realisasi

        // End Forecast S/D Script

        // begin Forecast S/D Eksternal Script

        // begin S/D OK 
        sumColumn("td[data-total-column-ok-sd-eksternal]", "data-total-column-ok-sd-eksternal",
            "td[data-column-ok-sd-eksternal]", "data-column-ok-sd-eksternal");
        // end S/D OK 

        // begin S/D Forecast
        sumColumn("td[data-total-column-forecast-sd-eksternal]", "data-total-column-forecast-sd-eksternal",
            "input[data-column-forecast-sd-eksternal]", "data-column-forecast-sd-eksternal");
        // end S/D Forecast 

        // begin S/D Realisasi
        sumColumn("td[data-total-column-realisasi-sd-eksternal]", "data-total-column-realisasi-sd-eksternal",
            "td[data-column-realisasi-sd-eksternal]", "data-column-realisasi-sd-eksternal");
        // end S/D Realisasi 

        // Begin SUM TOTAL DOP PER MONTH
        sumColumnDOPMonth("td[data-total-ok-per-dop-bulanan]", "data-total-ok-per-dop-bulanan", "td[data-column-ok-bulanan]", "data-column-ok-bulanan");
        sumColumnDOPMonth("td[data-total-forecast-per-dop-bulanan]", "data-total-forecast-per-dop-bulanan", "data-column-forecast", "data-column-forecast");
        sumColumnDOPMonth("td[data-total-realisasi-per-dop-bulanan]", "data-total-realisasi-per-dop-bulanan", "td[data-column-realisasi-bulanan]", "data-column-realisasi-bulanan");
        // END SUM TOTAL DOP PER MONTH

        // begin S/D OK Year
        sumColumnYear("total-year-ok-sd-eksternal", ".total-month-x-ok-sd-eksternal");
        // end S/D OK Year 

        // begin S/D Forecast Year
        sumColumnYear("total-year-forecast-sd-eksternal", ".total-month-x-forecast-sd-eksternal");
        // end S/D Forecast Year 

        // begin S/D Realisasi Year
        sumColumnYear("total-year-realisasi-sd-eksternal", ".total-month-x-realisasi-sd-eksternal");
        // end S/D Realisasi Year 
        // end Forecast S/D Eksternal Script

        // Begin SUM TOTAL DOP PER YEAR
        sumColumnDOPYear(".total-ok-dop-tahunan", "data-total-ok-per-dop-bulanan");
        sumColumnDOPYear(".total-forecast-dop-tahunan", "data-total-forecast-per-dop-bulanan");
        sumColumnDOPYear(".total-realisasi-dop-tahunan", "data-total-realisasi-per-dop-bulanan");
        // End SUM TOTAL DOP PER YEAR

        // Begin SUM TOTAL Unit Kerja PER MONTH
        sumColumnUnitKerjaMonth("td[data-total-ok-per-divisi-column]", "data-total-ok-per-divisi-column", "data-column-ok-bulanan");
        sumColumnUnitKerjaMonth("td[data-total-forecast-per-divisi-column]", "data-total-forecast-per-divisi-column" , "data-column-forecast");
        sumColumnUnitKerjaMonth("td[data-total-realisasi-per-divisi-column]", "data-total-realisasi-per-divisi-column", "data-column-realisasi-bulanan");
        // End SUM TOTAL Unit Kerja PER MONTH

        // Begin SUM TOTAL Unit Kerja PER Year
        sumColumnUnitKerjaYear(".total-ok-per-divisi-tahunan", "data-total-ok-per-divisi-column");
        sumColumnUnitKerjaYear(".total-forecast-per-divisi-tahunan", "data-total-forecast-per-divisi-column");
        sumColumnUnitKerjaYear(".total-realisasi-per-divisi-tahunan", "data-total-realisasi-per-divisi-column");
        // End SUM TOTAL Unit Kerja PER Year

        // begin calculate Total Year OK Column
        // data-id-proyek-ok-bulanan
        const dataColumnTotalYearOKBulanan = document.querySelectorAll(`.total-year-ok-bulanan`);

        let totalYearOKBulanan = 0;
        dataColumnTotalYearOKBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(`.total-ok-dop-tahunan.ShowPin`);
            dataColumnForecast.forEach(dataForecast => {
                totalYearOKBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearOKBulanan);
            totalYearOKBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
        // end calculate Total Year OK Column

        // begin Calculate Total Column Year Forecast Bulanan 
        sumColumnYear(".total-year-forecast-bulanan", ".total-forecast-dop-tahunan");
        // end Calculate Total Column Forecast Bulanan

        // begin calculate Total Year Realisasi Column
        // total-year-realisasi-bulanan
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`.total-year-realisasi-bulanan`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(
                `.total-realisasi-dop-tahunan.ShowPin`);
            dataColumnForecast.forEach(dataForecast => {
                totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
        // end calculate Total Year Realisasi Column


    }

    window.addEventListener("DOMContentLoaded", () => {
        recalculateColumn();
        console.log("Data Loaded!");
        document.querySelector(".loading-page").remove();
        document.querySelector(".content-table").style.display = "";

    });

    function sumColumn(eltToShow, attributeShow, eltToSum, attributeSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const getColumnId = forecast.getAttribute(attributeShow);
            const dataColumnForecast = document.querySelectorAll(
                `[${attributeSum}="${getColumnId}"]`);
            dataColumnForecast.forEach(dataForecast => {
                if (eltToSum.includes("input")) {
                    totalYearRealisasiBulanan += Number(dataForecast.value.replaceAll(/[^0-9]/gi, ""));
                } else {
                    totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi,
                        ""));
                }
            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    function sumColumnYear(eltToShow, eltToSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(
                `${eltToSum}.ShowPin`);
            dataColumnForecast.forEach(dataForecast => {
                totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    function sumColumnDOPMonth(eltToShow, attributeShow, eltToSum, attributeSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const getColumnId = forecast.getAttribute(attributeShow);
            const getDOP = forecast.getAttribute("data-dop");
            const dataColumnForecast = document.querySelectorAll(
                `[${attributeSum}="${getColumnId}"][data-dop="${getDOP}"]`);
            dataColumnForecast.forEach(dataForecast => {
                if (dataForecast.tagName == "INPUT") {
                    totalYearRealisasiBulanan += Number(dataForecast.value.replaceAll(/[^0-9|^\-]/gi, ""));
                } else {
                    totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9|^\-]/gi,
                        ""));
                }

            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    function sumColumnUnitKerjaMonth(eltToShow, attributeShow, attributeSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const getColumnId = forecast.getAttribute(attributeShow);
            const getUnitKerja = forecast.getAttribute("data-unit-kerja");
            const dataColumnForecast = document.querySelectorAll(
                `[${attributeSum}="${getColumnId}"][data-unit-kerja="${getUnitKerja}"]`);
            dataColumnForecast.forEach(dataForecast => {
                if (dataForecast.tagName == "INPUT") {
                    totalYearRealisasiBulanan += Number(dataForecast.value.replaceAll(/[^0-9|^\-]/gi, ""));
                } else {
                    totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9|^\-]/gi,
                        ""));
                }

            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    function sumColumnUnitKerjaYear(eltToShow, attributeSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const getUnitKerja = forecast.getAttribute("data-unit-kerja");
            const dataColumnForecast = document.querySelectorAll(
                `[${attributeSum}][data-unit-kerja="${getUnitKerja}"]`);
            dataColumnForecast.forEach(dataForecast => {
                if (dataForecast.tagName == "INPUT") {
                    totalYearRealisasiBulanan += Number(dataForecast.value.replaceAll(/[^0-9|^\-]/gi, ""));
                } else {
                    totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9|^\-]/gi,
                        ""));
                }

            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }
    function sumColumnDOPYear(eltToShow, attributeSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const getDOP = forecast.getAttribute("data-dop");
            const dataColumnForecast = document.querySelectorAll(
                `[${attributeSum}][data-dop="${getDOP}"]`);
            dataColumnForecast.forEach(dataForecast => {
                if (dataForecast.tagName == "INPUT") {
                    totalYearRealisasiBulanan += Number(dataForecast.value.replaceAll(/[^0-9|^\-]/gi, ""));
                } else {
                    totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9|^\-]/gi,
                        ""));
                }

            });
            const formattedForecastValue = Intl.NumberFormat(["id"], {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "0" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    let monthEltBulanan = null;
    const modalBody = document.querySelector(".modal-body");
    const modalFooterBtn = document.querySelectorAll(".modal-footer button")[1];
    const modalBoots = new bootstrap.Modal(".modal", {});

    function lockMonthForecastBulanan(elt) {
        monthEltBulanan = elt;
        const getIconElt = monthEltBulanan.querySelector("i");
        let monthTitle = "{{ $month_title }}";
        if (getIconElt.classList.contains("bi-lock-fill")) {
            if (monthTitle) {
                modalBody.innerHTML = `
                    <p>Apakah anda yakin ingin membuka forecast pada bulan <b>{{ $month_title }}</b>?</p>
                `;
            } else {
                modalBody.innerHTML = `
                    @php
                        setlocale(LC_TIME, 'id.UTF-8');
                    @endphp
                    <p>Apakah anda yakin ingin membuka forecast pada bulan <b>{{ strftime('%B', mktime(0, 0, 0, date('m'))) }}</b>?</p>
                `;
            }
            modalFooterBtn.innerText = "Request Authorize";
        } else {
            if (monthTitle) {
                modalBody.innerHTML = `
                    <p>Apakah anda yakin ingin mengunci forecast pada bulan <b>{{ $month_title }}</b>?</p>
                `;
            } else {
                modalBody.innerHTML = `
                    @php
                        setlocale(LC_TIME, 'id.UTF-8');
                    @endphp
                    <p>Apakah anda yakin ingin mengunci forecast pada bulan <b>{{ strftime('%B', mktime(0, 0, 0, date('m'))) }}</b>?</p>
                `;
            }
            modalFooterBtn.innerText = "Lanjut";
        }
        modalBoots.show();
    }

    async function confirmedLock() {
        const currentDate = new Date();
        if(currentDate.getDate() < 15 && currentDate.getMonth() + 1 == "{{$periode == "" ? (int) date('m') : (int) $periode}}") {
            Toast.fire({
                html: "Mohon cek kembali <b>Pilih Bulan</b> Otorisasi",
                icon: "warning",
            });
            return;
        }
        const getIconElt = monthEltBulanan.querySelector("i");
        // monthEltBulanan.setAttribute("disabled", "");
        const formData = new FormData();
        if (monthEltBulanan) {
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("periode_prognosa", "{{$periode == "" ? (int) date('m') : (int) $periode}}" );
            if (getIconElt.classList.contains("bi-unlock-fill")) {
                const getLockRes = await fetch("/forecast/set-lock", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                Toast.fire({
                    html: getLockRes.msg,
                    icon: getLockRes.status == "failed" ? "error" : "success",
                });
                // Swal.fire({
                //     title: getLockRes.status == "success" ? "Success" : "Failed",
                //     text: getLockRes.msg,
                //     icon: getLockRes.status == "failed" ? "error" : "success",
                //     timer: 3000,
                //     showConfirmButton: false,
                // });
                // getIconElt.classList.remove("bi-unlock-fill");
                // getIconElt.classList.add("bi-lock-fill");
                monthEltBulanan.innerHTML = `
                    <span class="text-white mx-2 fs-6">Unlock Forecast</span>
                    <i class="bi bi-lock-fill text-white"></i>
                `;
                // toaster.classList.add("text-bg-success");
                // toastBody.innerText = getLockRes.msg;
            } else {
                const getLockRes = await fetch("/forecast/set-unlock", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: formData,
                }).then(res => res.json());
                getIconElt.classList.add("bi-unlock-fill");
                getIconElt.classList.remove("bi-lock-fill");
                Toast.fire({
                    html: getLockRes.msg,
                    icon: getLockRes.status == "failed" ? "error" : "success",
                });
                // Swal.fire({
                //     title: getLockRes.status == "success" ? "Success" : "Failed",
                //     text: getLockRes.msg,
                //     icon: getLockRes.status == "failed" ? "error" : "success",
                //     timer: 3000,
                //     showConfirmButton: false,
                // });
                monthEltBulanan.innerHTML = `
                    <span class="text-white mx-2 fs-6">Lock Forecast</span>
                    <i class="bi bi-unlock-fill text-white"></i>
                `;
                // toaster.classList.add("text-bg-success");
                // toastBody.innerText = getLockRes.msg;
            }
            // toastBoots.show();
            disabledAllInputs();
            modalBoots.hide();
        }
    }

    function cancelLock() {
        monthEltBulanan = null;
    }

    function disabledAllInputs(unitKerja = null) {
        let allInputsForecast = null;
        if(unitKerja) {
            allInputsForecast = document.querySelectorAll(`input[data-unit-kerja='${unitKerja}']`);
        } else {
            allInputsForecast = document.querySelectorAll("input[data-month]");
        }
        if (allInputsForecast) {
            allInputsForecast.forEach(input => {
                if (!input.hasAttribute("disabled")) {
                    input.setAttribute("disabled", "");
                }
            });
        }
    }

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
                        let url = `/{{Request::segment(1)}}/${monthForecast}/${new Date().getFullYear()}`;
                        location.href = url;
                    }
                })
        }
    }
</script>

{{-- Show Collapse --}}
<script>
    let isLoaded = false;
    const SwalLoading = Swal.mixin({
                title: 'Mohon Ditunggu!',
                html: 'Data sedang dimuatkan',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
    const accordionsDOPElt = document.querySelectorAll(".button-dop");
    accordionsDOPElt.forEach(accord => {
        accord.addEventListener('click', event => {
            const id = event.target.getAttribute("data-bs-target")
            const items = document.querySelectorAll(`.button-unit-kerja[data-bs-target="${id}"]`);
            // console.log(items);
        });

        // accord.addEventListener('show.bs.collapse', event => {
        //     if(!isLoaded) {
        //         isLoaded = true;
        //         SwalLoading.fire({
        //             didOpen: () => {
        //                 SwalLoading.showLoading();
        //             }
        //         });
        //         console.log("Loading");
        //     }
        // });

        // accord.addEventListener('shown.bs.collapse', event => {
        //     if(isLoaded) {
        //         SwalLoading.close();
        //         isLoaded = false;
        //         console.log("loaded");
        //     }
        // });
    })
</script>
{{-- Show Collapse --}}

{{-- Sticky Header --}}
<script>
    // var header = document.getElementById("header");
    // const tableContent = document.querySelector("content-table")
    // tableContent.onscroll = function() {myFunction()};
    // // var sticky = header.offsetTop;
    // function myFunction() {
    //     console.log(tableContent.pageYOffset, sticky);
    //     if (tableContent.pageYOffset > 30) {
    //         header.classList.add("sticky");
    //     } else {
    //         header.classList.remove("sticky");
    //     }
    // }
</script>
{{-- Sticky Header --}}
@endsection
{{-- end:: JS script --}}
