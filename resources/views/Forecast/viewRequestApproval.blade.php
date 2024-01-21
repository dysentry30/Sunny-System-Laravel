{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}


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
@section('title', 'Request Approval History')
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

                <!--begin::Form-->
                {{-- <form action="#" method="get" enctype="multipart/form-data"> --}}
                    {{-- @csrf --}}


                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Toolbar-->
                        <div style="height:90px" class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Approval History
                                    </h1>
                                    <div class="row">
                                        <div class="col">
                                            <ul
                                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                                <!--begin:::Tab item Forecast Bulanan-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast/{{ (int) date("m") }}/{{ (int) date("Y") }}"
                                                        style="font-size:14px;">Forecast Eksternal
                                                        Bulanan</a>
                                                </li>
                                                <!--end:::Tab item Forecast Bulanan-->

                                                <!--begin:::Tab item Forecast Internal-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" href="/forecast-internal/{{ (int) date("m") }}/{{ (int) date("Y") }}"
                                                        style="font-size:14px;">Forecast Bulanan
                                                        Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast Internal-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        href="/forecast-kumulatif-eksternal"
                                                        style="font-size:14px;">Forecast Kumulatif Eksternal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab item Forecast S/D-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        href="/forecast-kumulatif-eksternal-internal"
                                                        style="font-size:14px;">Forecast Kumulatif Include Internal</a>
                                                </li>
                                                <!--end:::Tab item Forecast S/D-->

                                                <!--begin:::Tab Request Aprroval History-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active"
                                                        href="/request-approval-history" style="font-size:14px;">Request
                                                        Approval History</a>
                                                </li>
                                                <!--end:::Tab Request Aprroval History-->
                                            </ul>
                                        </div>
                                    </div>
                                    <!--begin::Title-->
                                </div>
                                <!--begin::Page title-->
                            </div>
                            <!--begin::Container-->
                        </div>
                        <!--begin::Toolbar-->

                        <!--begin::Card "style edited"-->
                        <div class="card mt-2 mb-0">
                            <!--begin::Card body-->
                            <div class="card-body pt-6 pb-0 mb-0">
                                <!--Begin :: Filter-->
                                <div class="card">
                                    <div class="card-title">
                                        <div class="row">
                                            <div class="col">
                                                @php
                                                $submonth = ((int) date('m')-1);
                                                if ($submonth == 0) {
                                                    // $submonth = 1;
                                                    $now = Carbon\Carbon::now()->day(1)->subMonths($submonth + 1);
                                                }else{
                                                    $now = Carbon\Carbon::now()->day(1)->subMonths($submonth);
                                                }
                                                // dump($now->addMonths(1), $submonth, (int) date('d'));
                                                @endphp
                                                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-5">
                                                    @php
                                                    if ((int) date('d') >= 25) {
                                                        $submonth = $submonth+1;
                                                    } else {
                                                        $submonth = $submonth;
                                                    }
                                                    @endphp
                                                    @foreach (range(1,$submonth) as $item)
                                                        <!--begin:::Tab item Pasar Dini-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary {{$item == $submonth ? "active" : ""}}" data-bs-toggle="tab"
                                                                href="#kt_user_view_forecasts_{{(int) $now->format("m")}}_{{$now->format("Y")}}"
                                                                style="font-size:14px;">{{$now->translatedFormat("F Y")}}</a>
                                                        </li>
                                                        @php
                                                            $now = $now->addMonths(1);
                                                        @endphp
                                                        <!--end:::Tab item Pasar Dini-->
                                                    @endforeach
                                                </ul>
                                            </div>
                                            {{-- <div class="col-1">
                                                <p class="mt-3 text-end">Periode : </p>
                                            </div>
                                            <div class="col-3">
                                                <form action="/request-approval-history/2022" method="get">
                                                    <!--begin::Select Options-->
                                                    <select onchange="this.form.submit()" id="periode-prognosa" name="periode-prognosa"
                                                        class="form-select form-select-solid w-100 ms-2 "
                                                        style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                        data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                                        aria-hidden="true">
                                                        <option {{ $periode == '' ? 'selected' : '' }}></option>
                                                        <option value="1" {{ $periode == 1 ? 'selected' : '' }}>Januari</option>
                                                        <option value="2" {{ $periode == 2 ? 'selected' : '' }}>Februari</option>
                                                        <option value="3" {{ $periode == 3 ? 'selected' : '' }}>Maret</option>
                                                        <option value="4" {{ $periode == 4 ? 'selected' : '' }}>April</option>
                                                        <option value="5" {{ $periode == 5 ? 'selected' : '' }}>Mei</option>
                                                        <option value="6" {{ $periode == 6 ? 'selected' : '' }}>Juni</option>
                                                        <option value="7" {{ $periode == 7 ? 'selected' : '' }}>Juli</option>
                                                        <option value="8" {{ $periode == 8 ? 'selected' : '' }}>Agustus</option>
                                                        <option value="9" {{ $periode == 9 ? 'selected' : '' }}>September</option>
                                                        <option value="10" {{ $periode == 10 ? 'selected' : '' }}>Oktober</option>
                                                        <option value="11" {{ $periode == 11 ? 'selected' : '' }}>November</option>
                                                        <option value="12" {{ $periode == 12 ? 'selected' : '' }}>Desember</option>
                                                    </select>
                                                    <!--end::Select Options-->
                                                </form>
                                            </div>
                                                
                                            <div class="col">
                                                <form action="" method="GET">
                                                    <button type="submit" class="btn btn-light">Reset</button>
                                                </form>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--End :: Filter-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card "style edited"-->

                        <!--begin::Post-->
                        <div class="post" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="w-100"
                                style="overflow: auto; background-color:white; white-space: nowrap;">
                                <!--begin::Contacts App- Edit Contact-->
                                @php
                                    $submonth = ((int) date('m')-1);
                                    if ($submonth == 0) {
                                        // $submonth = 1;
                                        $now = Carbon\Carbon::now()->day(1)->subMonths($submonth + 1);
                                    }else{
                                        $now = Carbon\Carbon::now()->day(1)->subMonths($submonth);
                                    }
                                    // $now = Carbon\Carbon::now()->day(1)->subMonths($submonth);
                                @endphp
                                <div class="tab-content">
                                    @php
                                    if ((int) date('d') >= 25) {
                                        $submonth = $submonth+1;
                                    } else {
                                        $submonth = $submonth;
                                    }
                                    @endphp
                                    @foreach (range(1, $submonth) as $item)
                                        <div class="tab-pane fade {{$item == $submonth ? "show active" : ""}}" id="kt_user_view_forecasts_{{(int) $now->format("m")}}_{{$now->format("Y")}}" role="tabpanel">
                                            <!--begin::All Content-->
                                            <div class="col-xl-15">

                                                <!--begin::Contacts-->
                                                <div class="card card-flush h-lg-100"
                                                    style="max-height: 70vh; overflow-y: scroll; scroll-behavior: smooth;"
                                                    id="kt_contacts_main">

                                                    <!--begin::Card body-->
                                                    <div class="card-body mt-0" style="background-color: white;">
                                                        @php
                                                            // $historyForecast_new = collect();
                                                            // $tes = $historyForecast->map(function($hf1) use($now){
                                                            //     return $hf1->map(function($hf2) use($now){
                                                            //         return collect($hf2)->filter(function($hFilter) use($now){
                                                            //             return $hFilter->tahun == $now->format('Y');
                                                            //         });
                                                            //     });
                                                            // });
                                                            $historyForecast_new = $historyForecast->map(function ($h, $key) use($now, &$historyForecast, &$historyForecast_new) {
                                                                $condition = true;
                                                                return $h->map(function ($histories) use(&$condition, $now, &$historyForecast_new) {
                                                                    return $histories->filter(function($hFilter) use($now){
                                                                        return $hFilter->periode_prognosa == $now->format('m') && $hFilter->tahun == $now->format('Y');
                                                                    });
                                                                    // return $histories->map(function($ph) use(&$condition, $now, &$historyForecast_new) {
                                                                    //     if($ph->periode_prognosa == (int) $now->format("m") && $ph->tahun == (int) $now->format("Y")) {
                                                                    //         return $ph;
                                                                    //     }
                                                                    // });
                                                                });
                                                            });
                                                            // dump($historyForecast_new, (int) $now->format("m"), (int) $now->format("Y"));
                                                        @endphp
                                                        @forelse ($historyForecast_new as $dop => $historyUnitKerjas)
                                                            @php
                                                                $historyUnitKerjas = $historyUnitKerjas->map(function($hu) {
                                                                    return $hu->filter(function($item) { return $item != null; });
                                                                });
                                                            @endphp
                                                            @if ($historyUnitKerjas->isNotEmpty())
                                                                <!--begin::Card Content-->
                                                                <div class="card-content mb-5">
                                                                    <div class="position-sticky start-0 bg-white border shadow-sm p-5 mb-3 text-center"
                                                                        style="z-index: 99; top:5px;">
                                                                        @php
                                                                            $month = "";
                                                                            switch ($historyUnitKerjas->avg("periode_prognosa")) {
                                                                                case 1:
                                                                                    $month = "Januari";
                                                                                    break;
                                                                                case 2:
                                                                                    $month = "Februari";
                                                                                    break;
                                                                                case 3:
                                                                                    $month = "Maret";
                                                                                    break;
                                                                                case 4:
                                                                                    $month = "April";
                                                                                    break;
                                                                                case 5:
                                                                                    $month = "Mei";
                                                                                    break;
                                                                                case 6:
                                                                                    $month = "Juni";
                                                                                    break;
                                                                                case 7:
                                                                                    $month = "Juli";
                                                                                    break;
                                                                                case 8:
                                                                                    $month = "Agustus";
                                                                                    break;
                                                                                case 9:
                                                                                    $month = "September";
                                                                                    break;
                                                                                case 10:
                                                                                    $month = "Oktober";
                                                                                    break;
                                                                                case 11:
                                                                                    $month = "November";
                                                                                    break;
                                                                                case 12:
                                                                                    $month = "Desember";
                                                                                    break;
                                                                            }
                                                                        @endphp
                                                                        {{-- <h4 class="h4">{{ $dop }} - Periode {{$month}} {{Carbon\Carbon::parse($historyUnitKerjas->first()->created_at, "UTC")->translatedFormat("F")}}</h4> --}}
                                                                        <h4 class="h4">{{ $dop }} - {{$now->translatedFormat("F")}} {{$now->translatedFormat("Y")}}</h4>
                                                                    </div>
                                                                    @php
                                                                        $is_history_exist = $historyUnitKerjas->search(function($item) { return $item->isNotEmpty(); })
                                                                    @endphp
                                                                    @if ($is_history_exist)
                                                                        @foreach ($historyUnitKerjas as $unit_kerja => $unit_kerja_history)
                                                                            @foreach ($unit_kerja_history as $periode => $history)
                                                                                <div class="row mb-5">
                                                                                    <div class="col">
                                                                                        <div
                                                                                            class="card border shadow-sm bg-body border-dashed">
                                                                                            <div class="card-body">
                                                                                                <div
                                                                                                    class="row d-flex align-items-center justify-content-between w-100">
                                                                                                    <div class="col-9 text-wrap">
                                                                                                        <div
                                                                                                            class="d-flex align-items-center mb-3">
                                                                                                            <div class="col-6">
                                                                                                                <div class="row">
                                                                                                                    <div class="col text-end">
                                                                                                                        <span>Unit Kerja:
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                    <div class="col">
                                                                                                                        <span><b>{{ $unit_kerja }}</b></span>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                @php
                                                                                                                    switch ($history->periode_prognosa) {
                                                                                                                        case 1:
                                                                                                                            $month = "Januari";
                                                                                                                            break;
                                                                                                                        case 2:
                                                                                                                            $month = "Februari";
                                                                                                                            break;
                                                                                                                        case 3:
                                                                                                                            $month = "Maret";
                                                                                                                            break;
                                                                                                                        case 4:
                                                                                                                            $month = "April";
                                                                                                                            break;
                                                                                                                        case 5:
                                                                                                                            $month = "Mei";
                                                                                                                            break;
                                                                                                                        case 6:
                                                                                                                            $month = "Juni";
                                                                                                                            break;
                                                                                                                        case 7:
                                                                                                                            $month = "Juli";
                                                                                                                            break;
                                                                                                                        case 8:
                                                                                                                            $month = "Agustus";
                                                                                                                            break;
                                                                                                                        case 9:
                                                                                                                            $month = "September";
                                                                                                                            break;
                                                                                                                        case 10:
                                                                                                                            $month = "Oktober";
                                                                                                                            break;
                                                                                                                        case 11:
                                                                                                                            $month = "November";
                                                                                                                            break;
                                                                                                                        case 12:
                                                                                                                            $month = "Desember";
                                                                                                                            break;
                                                                                                                    }
                                                                                                                @endphp

                                                                                                                <div class="row">
                                                                                                                    <div class="col text-end">
                                                                                                                        <span>Bulan Otorisasi:
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                    <div class="col">
                                                                                                                        <span><b>{{ $month }}</b></span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-6">
                                                                                                                <div class="row">
                                                                                                                    <div class="col">
                                                                                                                        <div
                                                                                                                            class="d-flex align-items-center">
                                                                                                                            <div class="col-4">
                                                                                                                                <span>Nilai
                                                                                                                                    RKAP:
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                            <div class="col">
                                                                                                                                <span><b>Rp.
                                                                                                                                        <span
                                                                                                                                            class="text-end">{{ number_format($history->rkap_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <div class="col">
                                                                                                                        <div
                                                                                                                            class="d-flex align-items-center">
                                                                                                                            <div class="col-4">
                                                                                                                                <span>Nilai
                                                                                                                                    Forecast:
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                            <div class="col">
                                                                                                                                <span><b>Rp.
                                                                                                                                        <span
                                                                                                                                            class="text-end">{{ number_format($history->nilai_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <div class="col">
                                                                                                                        <div
                                                                                                                            class="d-flex align-items-center">
                                                                                                                            <div class="col-4">
                                                                                                                                <span>Nilai
                                                                                                                                    Realisasi:
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                            <div class="col">
                                                                                                                                <span><b>Rp.
                                                                                                                                        <span
                                                                                                                                            class="text-end">{{ number_format($history->realisasi_forecast, 0, '.', '.') }}</span></b></span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-3">
                                                                                                        @if (Auth::user()->check_administrator || str_contains(Auth::user()->name, "PIC"))
                                                                                                            @if ($history->is_approved_1 == "t")
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-sm btn-success text-white disabled"
                                                                                                                        style="background-color: rgb(17, 179, 17)">Approved</button>
                                                                                                                    @if ($history->is_request_unlock == "f")
                                                                                                                        <form action=""></form>
                                                                                                                        <form action="/history/unlock" onsubmit="requestUnlock()" class="mt-4" method="POST">
                                                                                                                            @csrf
                                                                                                                            <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                                            <input type="hidden" name="periode-prognosa" value="{{$history->periode_prognosa}}">
                                                                                                                            <button type="submit"
                                                                                                                                class="btn btn-sm btn-active-primary text-white"
                                                                                                                                style="background-color:#008CB4;">Unlock Forecast</button>
                                                                                                                        </form>
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            @elseif($history->is_approved_1 == "f")
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>
                                                                                                                </div>
                                                                                                            @else
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        onclick="confirmAction(this, '{{ $unit_kerja }}', true, '{{$history->periode_prognosa}}')"
                                                                                                                        class="btn btn-sm btn-active-primary text-white"
                                                                                                                        style="background-color:#008CB4;">Approve</button>
                                                                                                                    <button type="button"
                                                                                                                        onclick="confirmAction(this, '{{ $unit_kerja }}', false, '{{$history->periode_prognosa}}')"
                                                                                                                        class="btn btn-sm btn-light btn-active-danger">Cancel</button>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            @if ($history->is_approved_1 == "t")
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-sm btn-success text-white disabled"
                                                                                                                        style="background-color: rgb(17, 179, 17)">Approved</button>
                                                                                                                    <form action=""></form>
                                                                                                                    @if($history->is_request_unlock == "f")
                                                                                                                        <button type="button"
                                                                                                                            class="btn btn-sm btn-active-primary text-white disabled ms-7"
                                                                                                                            style="background-color:#008CB4;">Menunggu Approval Unlock...</button>
                                                                                                                    @elseif($history->is_request_unlock == "t")
                                                                                                                        <form action="/forecast/set-unlock" onsubmit="requestUnlock()" class="mt-4" method="POST">
                                                                                                                            @csrf
                                                                                                                            <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                                            <input type="hidden" name="periode-prognosa" value="{{$history->periode_prognosa}}">
                                                                                                                            <button type="submit"
                                                                                                                            onclick="confirmDeleteHistory(this); return false"
                                                                                                                            class="btn btn-sm btn-danger text-white"
                                                                                                                            style="background-color:#008CB4;">Hapus History</button>
                                                                                                                        </form>
                                                                                                                    @else
                                                                                                                        <form action="/history/request-unlock" onsubmit="requestUnlock()" class="mt-4" method="POST">
                                                                                                                            @csrf
                                                                                                                            <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                                            <input type="hidden" name="periode-prognosa" value="{{$history->periode_prognosa}}">
                                                                                                                            <button type="submit"
                                                                                                                                class="btn btn-sm btn-active-primary text-white"
                                                                                                                                style="background-color:#008CB4;">Request Unlock</button>
                                                                                                                        </form>
                                                                                                                    @endif 
                                                                                                                </div>
                                                                                                            @elseif($history->is_approved_1 == "f")
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>
                                                                                                                    <form action=""></form>
                                                                                                                    <form action="/forecast/set-unlock"class="mt-4" method="POST">
                                                                                                                        @csrf
                                                                                                                        <input type="hidden" name="unit_kerja" value="{{$unit_kerja}}">
                                                                                                                        <input type="hidden" name="periode-prognosa" value="{{$history->periode_prognosa}}">
                                                                                                                        <button type="submit"
                                                                                                                        class="btn btn-sm btn-active-primary text-white"
                                                                                                                        style="background-color:#008CB4;">Hapus History</button>
                                                                                                                    </form>
                                                                                                                </div>
                                                                                                            @else
                                                                                                                <div
                                                                                                                    class="d-flex flex-row justify-content-evenly align-items-center w-100">
                                                                                                                    <button type="button"
                                                                                                                        class="btn btn-sm btn-active-primary text-white disabled"
                                                                                                                        style="background-color:#008CB4;">Menunggu untuk approval...</button>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else 
                                                                        <div class="row">
                                                                            <div class="col text-center">Data tidak ditemukan!</div>
                                                                        </div>    
                                                                    @endif
                                                                </div>
                                                                <hr>
                                                                <!--begin::Card Content-->
                                                            @else 
                                                                <div class="row">
                                                                    <div class="col text-center">Data tidak ditemukan!</div>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <div class="row">
                                                                <div class="col text-center">Data tidak ditemukan!</div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Contacts-->
                                            </div>
                                            <!--end::All Content-->
                                        </div>
                                        @php
                                            $now = $now->addMonths(1);
                                        @endphp
                                    @endforeach
                                </div>
                                <!--end::Contacts App- Edit Contact-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--begin::Content-->
                {{-- </form> --}}
                <!--begin::Form-->
            </div>
            <!--begin::Wrapper-->
        </div>
        <!--begin::Page-->
    </div>
    <!--begin::Root-->
@endsection

{{-- begin:: JS script --}}
@section('js-script')
    <script>
        let socketId = "";
        const socket = new WebSocket("ws://127.0.0.1:6001/testing-websocket");

        socket.onopen = function(e) {
            console.log("[open] Connection established");
        };

        socket.onmessage = function(event) {
            const data = JSON.parse(event.data);
            console.log(`[message] Data received from server: ${event.data}`);
            if(!socketId) {
                socketId = data.socketId;
            } 
            if(data.data == "Approved" || data.data == "Rejected" || data.data == "Unlock") {
                window.location.reload();
            }
        };

        function confirmAction(e, unitKerja, isApproved, periode) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                html: "Aksi ini tidak bisa <b>dikembalikan</b>!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                const formData = new FormData();
                formData.append("is_approved", Number(isApproved));
                formData.append("unit_kerja", unitKerja);
                formData.append("periode_prognosa", periode);
                formData.append("_token", "{{ csrf_token() }}");
                if (result.isConfirmed) {
                    const setLockRes = await fetch("/forecast/set-lock/unit-kerja", {
                        method: "POST",
                        header: {
                            "content-type": "application/json",
                        },
                        body: formData,
                    }).then(res => res.json());
                    if(isApproved) {
                        e.parentElement.innerHTML = `<button type="button"
                                                        class="btn btn-sm btn-success text-white disabled"
                                                        style="background-color: rgb(17, 179, 17)">Approved</button>`;
                        socket.send(JSON.stringify({
                            event: "History Forecast Approval",
                            data: "Approved",
                            socketId: socketId
                        }));
                        Swal.fire({
                            title: "",
                            html: setLockRes.msg,
                            icon: setLockRes.status.toLowerCase(),
                            toast: true,
                            confirmButtonColor: "#008CB4",
                            timer: 1500,
                            timerProgressBar: true,
                            position: 'top-end',
                        });
                        
                    } else {
                        e.parentElement.innerHTML = `
                        <button type="button"
                        class="btn btn-sm btn-danger text-white disabled">Approval ditolak</button>`;
                        socket.send(JSON.stringify({
                            event: "History Forecast Approval",
                            data: "Rejected",
                            socketId: socketId
                        }));
                        Swal.fire({
                            title: "",
                            html: `<b>${unitKerja}</b>, approval ditolak`,
                            icon: setLockRes.status.toLowerCase(),
                            toast: true,
                            confirmButtonColor: "#008CB4",
                            timer: 1500,
                            timerProgressBar: true,
                            position: 'top-end',
                        });
                        
                    }
                    return true;
                }
                return false;
            });
        }

        function confirmDeleteHistory(e) {
            const form = e.parentElement;
            Swal.fire({
                title: 'Forecast ini sudah di Lock. Apakah anda yakin?',
                html: "Aksi ini tidak bisa <b>dikembalikan</b>!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if(result.isConfirmed) {
                    form.submit();
                }
                return false;
            });
        }

        function requestUnlock() {
            socket.send(JSON.stringify({
                event: "Request Unlock History",
                data: "Unlock",
                socketId
            }));
            return true;
        }

    </script>
@endsection
{{-- End:: JS script --}}
