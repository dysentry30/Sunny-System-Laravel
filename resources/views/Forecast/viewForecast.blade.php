{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

@php
$arrNamaBulan = ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
@endphp

{{-- Begin::Title --}}
@section('title', 'View Forecast')
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
                @extends('template.header')
                <!--end::Header-->

                {{-- begin:: Toaster Notification --}}
                <div aria-live="polite" aria-atomic="true" class="position-sticky mx-5" style="z-index: 999">
                    <div class="toast-container top-0 end-0">
                        <div class="toast fade align-items-center text-bg-success border-0 " role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body text-white">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end:: Toaster Notification --}}


                <!--begin::Form-->
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf


                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Toolbar-->
                        <div style=" height:150px"class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Forecast
                                    </h1>
                                    <div>
                                        {{-- begin::Tabs Forecast --}}
                                        <ul
                                            class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                            <!--begin:::Tab item Forecast Bulanan-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                    href="#kt_user_view_overview_forecast_bulanan"
                                                    style="font-size:14px;">Forecast
                                                    Bulanan</a>


                                                <button type="button" style="background-color: #008CB4;"
                                                    onclick="lockMonthForecastBulanan(this)" class="btn btn-sm btn-active-primary mt-4">
                                                    <script>
                                                        const historyForecast = "{{ count($historyForecast) }}";
                                                    </script>
                                                    @if (count($historyForecast) > 0)
                                                        <span class="text-white mx-2 fs-6">Lock Forecast</span>
                                                        <i class="bi bi-lock-fill text-white"></i>
                                                    @else
                                                        <span class="text-white mx-2 fs-6">Lock Forecast</span>
                                                        <i class="bi bi-unlock-fill text-white"></i>
                                                    @endif
                                                </button>

                                            </li>
                                            <!--end:::Tab item Forecast Bulanan-->

                                            <!--begin:::Tab item Forecast Internal-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_forecast_internal"
                                                    style="font-size:14px;">Forecast Internal</a>
                                            </li>
                                            <!--end:::Tab item Forecast Internal-->

                                            <!--begin:::Tab item Forecast S/D-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_forecast_sd"
                                                    style="font-size:14px;">Forecast S/D</a>
                                            </li>
                                            <!--end:::Tab item Forecast S/D-->

                                            <!--begin:::Tab item Forecast S/D-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_forecast_sd_eksternal"
                                                    style="font-size:14px;">Forecast S/D Eksternal</a>
                                            </li>
                                            <!--end:::Tab item Forecast S/D-->
                                        </ul>
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
                                style="overflow: auto; background-color:white; white-space: nowrap;">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="">

                                    <!--begin::All Content-->
                                    <div class="col-xl-15">

                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">


                                            <!--begin::Card body-->
                                            <div class="card-body" style="background-color: white;">

                                                <div class="tab-content" id="myTabContent">
                                                    {{-- begin::Tab Forecast Bulanan --}}
                                                    <div class="tab-pane fade show active"
                                                        id="kt_user_view_overview_forecast_bulanan" role="tabpanel">
                                                        <!--begin::Table Forecast-->
                                                        <table class="table align-middle table-row-dashed fs-6"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr
                                                                    style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                    <th class="min-w-250px text-center" rowspan="2"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                        Proyek
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Januari
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Februari
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Maret
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            April
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Mei
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Juni
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Juli
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Agustus
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            September
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Oktober
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            November
                                                                        </center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>
                                                                            Desember
                                                                        </center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-auto"
                                                                        colspan="3">
                                                                        <center>Total &nbsp;&nbsp; <i
                                                                                class="bi bi-pin-angle-fill"
                                                                                onclick="hidePin()"></i></center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-auto"
                                                                        colspan="3"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center>Total &nbsp;&nbsp; <i
                                                                                class="bi bi-pin-fill text-primary"
                                                                                onclick="hidePin()"></i></center>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <!--begin::Sub-Judul Januari-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Januari-->
                                                                    <!--begin::Sub-Judul Februari-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Februari-->
                                                                    <!--begin::Sub-Judul Maret-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Maret-->
                                                                    <!--begin::Sub-Judul April-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul April-->
                                                                    <!--begin::Sub-Judul Mei-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Mei-->
                                                                    <!--begin::Sub-Judul Juni-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Juni-->
                                                                    <!--begin::Sub-Judul Juli-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Juli-->
                                                                    <!--begin::Sub-Judul Agustus-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Agustus-->
                                                                    <!--begin::Sub-Judul September-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul September-->
                                                                    <!--begin::Sub-Judul Oktober-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Oktober-->
                                                                    <!--begin::Sub-Judul November-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul November-->
                                                                    <!--begin::Sub-Judul Desember-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Desember-->
                                                                    <!--begin::Sub-Judul Total-->
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Total-->
                                                                </tr>
                                                                <!--end::Table head-->
                                                            </thead>

                                                            <!--begin::Table body-->

                                                            <tbody class="fw-bold text-gray-600" id="table-body">

                                                                @php
                                                                    $month_counter = 1;
                                                                    $is_data_found = false;
                                                                    $total_ok = 0;
                                                                    $total_year_ok = 0;
                                                                    $total_forecast = 0;
                                                                    $total_month_forecast = 0;
                                                                    $total_year_forecast = 0;
                                                                    $index = 1;
                                                                @endphp
                                                                @foreach ($dops as $dop)
                                                                    @if (count($dop->UnitKerjas) > 0)
                                                                        {{-- @foreach ($proyeks as $proyek) --}}

                                                                        <tr style="text-align: right; ">

                                                                            @php
                                                                                $dop_name = str_replace(' ', '-', $dop->dop);
                                                                            @endphp
                                                                            <td
                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                <a name="collalpse1" class=""
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#{{ $dop_name }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="{{ $dop_name }} ">
                                                                                    <i class="bi bi-chevron-down"></i>
                                                                                    {{-- {{ $dop->dop }} --}}
                                                                                    {{ $dop->dop }}
                                                                                </a>
                                                                            </td>

                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Total Coloumn-->
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                -</td>
                                                                            <!--end::Total Coloumn-->

                                                                        </tr>

                                                                        {{-- begin:: Foreach Unit Kerja --}}
                                                                        @foreach ($dop->UnitKerjas as $unitKerja)
                                                                            @if (count($unitKerja->proyeks) > 0)
                                                                                <tr class="collapse accordion-header"
                                                                                    id="{{ $dop_name }}"
                                                                                    style="text-align: right;">
                                                                                    <td
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                        <!--begin::Child=-->
                                                                                        <a class="ms-6" type="button"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="{{ $unitKerja->divcode }}">
                                                                                            <i
                                                                                                class="bi bi-chevron-down"></i>
                                                                                            {{ $unitKerja->unit_kerja }}
                                                                                        </a>
                                                                                        <!--end::Child=-->
                                                                                    </td>
                                                                                    <!--begin::Januari Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Januari Coloumn-->
                                                                                    <!--begin::Februari Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Februari Coloumn-->
                                                                                    <!--begin::Maret Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Maret Coloumn-->
                                                                                    <!--begin::April Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::April Coloumn-->
                                                                                    <!--begin::Mei Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Mei Coloumn-->
                                                                                    <!--begin::Juni Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Juni Coloumn-->
                                                                                    <!--begin::Juli Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Juli Coloumn-->
                                                                                    <!--begin::Agustus Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Agustus Coloumn-->
                                                                                    <!--begin::September Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::September Coloumn-->
                                                                                    <!--begin::Oktober Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Oktober Coloumn-->
                                                                                    <!--begin::November Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::November Coloumn-->
                                                                                    <!--begin::Desember Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Desember Coloumn-->
                                                                                    <!--begin::Total Coloumn-->
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        -</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        -</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        -</td>
                                                                                    <!--end::Total Coloumn-->
                                                                                </tr>
                                                                                {{-- begin:: Foreach Proyek --}}
                                                                                @foreach ($unitKerja->proyeks as $proyek)
                                                                                    <tr id="{{ $unitKerja->divcode }}"
                                                                                        class="collapse"
                                                                                        aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                        data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                        style="text-align: right;">
                                                                                        <td
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                            <!--begin::Child=-->
                                                                                            <p class="ms-12">
                                                                                                {{ $proyek->nama_proyek }}
                                                                                            </p>
                                                                                            <!--end::Child=-->
                                                                                        </td>

                                                                                        @for ($i = 0; $i < 12; $i++)
                                                                                            @if ($index > 3)
                                                                                                @php
                                                                                                    $index = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                            @foreach ($proyek->Forecasts as $forecast)
                                                                                                @if ($forecast->month_forecast == $i + 1)
                                                                                                    @php
                                                                                                        $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                    @endphp
                                                                                                    <td data-column-ok-bulanan="{{ $month_counter }}"
                                                                                                        data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}">
                                                                                                        {{ $proyek->nilai_rkap }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                            data-month="{{ $month_counter }}"
                                                                                                            data-column-forecast="{{ $month_counter }}"
                                                                                                            class="form-control"
                                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                            id="nilai-forecast"
                                                                                                            name="nilai-forecast"
                                                                                                            onkeyup="reformatNumber(this)"
                                                                                                            value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                            placeholder=". . . , -" />
                                                                                                    </td>
                                                                                                    @php
                                                                                                        $getBulanRIPerolehanNumberOfMonth = array_search($proyek->bulan_ri_perolehan, $arrNamaBulan);
                                                                                                        $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_kontrak_keseluruhan) ?? 0;
                                                                                                    @endphp
                                                                                                    @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                            {{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}
                                                                                                        </td>
                                                                                                    @else
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                            -</td>
                                                                                                    @endif
                                                                                                    @php
                                                                                                        $is_data_found = true;
                                                                                                    @endphp
                                                                                                @break
                                                                                            @endif
                                                                                            @php
                                                                                                $index++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                        @if (!$is_data_found)
                                                                                            <td data-column-ok-bulanan="{{ $month_counter }}"
                                                                                                data-id-proyek-ok-bulanan="{{ $proyek->kode_proyek }}">
                                                                                                {{ $proyek->nilai_rkap }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text"
                                                                                                    data-id-proyek="{{ $proyek->kode_proyek }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value=""
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                                <td
                                                                                                    data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                    {{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}
                                                                                                </td>
                                                                                            @else
                                                                                                <td
                                                                                                    data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                    -</td>
                                                                                            @endif
                                                                                        @endif
                                                                                        @php
                                                                                            $is_data_found = false;
                                                                                            $total_ok += (int) str_replace(',', '', $proyek->nilai_rkap);
                                                                                            $month_counter++;
                                                                                        @endphp
                                                                                    @endfor
                                                                                    <!--begin::Total Side Coloumn-->
                                                                                    @php
                                                                                        $total_ok_formatted = number_format($total_ok, 0, ',', ',');
                                                                                        $total_forecast_formatted = number_format($total_forecast, 0, ',', ',');
                                                                                        $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_kontrak_keseluruhan);
                                                                                        $total_forecast = 0;
                                                                                        $total_ok = 0;
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
                                                                                        <center>
                                                                                            <b>{{ number_format($nilai_terkontrak_formatted, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        data-id-proyek-ok-bulanan-total="{{ $proyek->kode_proyek }}"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
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
                                                                                        <center>
                                                                                            <b>{{ number_format($nilai_terkontrak_formatted, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <!--end::Total Side Coloumn-->
                                                                            @endforeach
                                                                            {{-- end:: Foreach Proyek --}}
                                                                        @endif
                                                                        @php
                                                                            $total_year_forecast += $total_forecast;
                                                                            $total_forecast = 0;
                                                                            $total_ok = 0;
                                                                            $month_counter = 1;
                                                                        @endphp
                                                                    @endforeach
                                                                    {{-- end:: Foreach Unit Kerja --}}
                                                                @endif
                                                            @endforeach

                                                        <tfoot
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                            <div class="m-4">
                                                                <tr>
                                                                    <td
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                        <!--begin::Child=-->
                                                                        Total
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
                                                                    <td
                                                                        class="pinForecast HidePin total-year-ok-bulanan">
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span class="placeholder col-4"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                    <td
                                                                        class="pinForecast HidePin total-year-forecast-bulanan">
                                                                        <center>
                                                                            <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td
                                                                        class="pinForecast HidePin total-year-realisasi-bulanan">
                                                                        <center>
                                                                            <b>{{ $proyek->nilai_kontrak_keseluruhan }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin total-year-ok-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span class="placeholder col-4"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin total-year-forecast-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        <center>
                                                                            <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin total-year-realisasi-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center>
                                                                            <b>{{ $proyek->nilai_kontrak_keseluruhan }}</b>
                                                                        </center>
                                                                    </td>
                                                                    {{-- end::Total Year --}}
                                                                </tr>
                                                            </div>
                                                        </tfoot>

                                                        </tbody>

                                                        {{-- @endforeach --}}
                                                    </table>
                                                </div>
                                                <!--end::Table body-->
                                                <!--end:::Tab Forecast Bulanan-->

                                                <!--begin:::Tab pane Forecast Internal-->
                                                <div class="tab-pane fade"
                                                    id="kt_user_view_overview_forecast_internal" role="tabpanel">
                                                    <table class="table align-middle table-row-dashed fs-6"
                                                        id="kt_customers_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr
                                                                style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                <th class="min-w-auto" rowspan="2"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                    <!--Begin::Svg Icon and Input Searc-->
                                                                    <span
                                                                        class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                        <i class="bi bi-search"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        data-kt-customer-table-filter="search"
                                                                        class="form-control form-control w-250px ps-15"
                                                                        placeholder="Search" /><br>
                                                                    <!--end::Svg Icon and Input Searc-->
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Januari</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Februari</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Maret</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>April</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Mei</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Juni</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Juli</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Agustus</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>September</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Oktober</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>November</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Desember</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-auto"
                                                                    colspan="3">
                                                                    <center>Total &nbsp;&nbsp; <i
                                                                            class="bi bi-pin-angle-fill"
                                                                            onclick="hidePin()"></i></center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-auto"
                                                                    colspan="3"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center>Total &nbsp;&nbsp; <i
                                                                            class="bi bi-pin-fill text-primary"
                                                                            onclick="hidePin()"></i></center>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <!--begin::Sub-Judul Januari-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Januari-->
                                                                <!--begin::Sub-Judul Februari-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Februari-->
                                                                <!--begin::Sub-Judul Maret-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Maret-->
                                                                <!--begin::Sub-Judul April-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul April-->
                                                                <!--begin::Sub-Judul Mei-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Mei-->
                                                                <!--begin::Sub-Judul Juni-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Juni-->
                                                                <!--begin::Sub-Judul Juli-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Juli-->
                                                                <!--begin::Sub-Judul Agustus-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Agustus-->
                                                                <!--begin::Sub-Judul September-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul September-->
                                                                <!--begin::Sub-Judul Oktober-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Oktober-->
                                                                <!--begin::Sub-Judul November-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul November-->
                                                                <!--begin::Sub-Judul Desember-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Desember-->
                                                                <!--begin::Sub-Judul Total-->
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Total-->
                                                            </tr>
                                                            <!--end::Table head-->
                                                        </thead>

                                                        <!--begin::Table body-->

                                                        <tbody class="fw-bold text-gray-600" id="table-body">

                                                            @php
                                                                $month_counter = 1;
                                                                $is_data_found = false;
                                                                $total_ok = 0;
                                                                $total_year_ok = 0;
                                                                $total_forecast = 0;
                                                                $total_month_forecast = 0;
                                                                $total_year_forecast = 0;
                                                                $index = 1;
                                                            @endphp
                                                            @foreach ($dops as $dop)
                                                                @if (count($dop->UnitKerjas) > 0)
                                                                    {{-- @foreach ($proyeks as $proyek) --}}

                                                                    <tr style="text-align: right; ">
                                                                        @php
                                                                            $dop_name = str_replace(' ', '-', $dop->dop);
                                                                        @endphp
                                                                        <td
                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                            <a name="collalpse1" class=""
                                                                                data-bs-toggle="collapse"
                                                                                href="#{{ $dop_name }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="{{ $dop_name }} ">
                                                                                <i class="bi bi-chevron-down"></i>
                                                                                {{-- {{ $dop->dop }} --}}
                                                                                {{ $dop->dop }}
                                                                            </a>
                                                                        </td>

                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Total Coloumn-->
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                            -</td>
                                                                        <!--end::Total Coloumn-->

                                                                    </tr>

                                                                    {{-- begin:: Foreach Unit Kerja --}}
                                                                    @foreach ($dop->UnitKerjas as $unitKerja)
                                                                        @if (count($unitKerja->proyeks) > 0)
                                                                            <tr class="collapse accordion-header"
                                                                                id="{{ $dop_name }}"
                                                                                style="text-align: right;">
                                                                                <td
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                    <!--begin::Child=-->
                                                                                    <a class="ms-6" type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="{{ $unitKerja->divcode }}">
                                                                                        <i
                                                                                            class="bi bi-chevron-down"></i>
                                                                                        {{ $unitKerja->unit_kerja }}
                                                                                    </a>
                                                                                    <!--end::Child=-->
                                                                                </td>
                                                                                <!--begin::Januari Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Januari Coloumn-->
                                                                                <!--begin::Februari Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Februari Coloumn-->
                                                                                <!--begin::Maret Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Maret Coloumn-->
                                                                                <!--begin::April Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::April Coloumn-->
                                                                                <!--begin::Mei Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Mei Coloumn-->
                                                                                <!--begin::Juni Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Juni Coloumn-->
                                                                                <!--begin::Juli Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Juli Coloumn-->
                                                                                <!--begin::Agustus Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Agustus Coloumn-->
                                                                                <!--begin::September Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::September Coloumn-->
                                                                                <!--begin::Oktober Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Oktober Coloumn-->
                                                                                <!--begin::November Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::November Coloumn-->
                                                                                <!--begin::Desember Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Desember Coloumn-->
                                                                                <!--begin::Total Coloumn-->
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                    -</td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                    -</td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                    -</td>
                                                                                <!--end::Total Coloumn-->
                                                                            </tr>
                                                                            {{-- begin:: Foreach Proyek --}}
                                                                            @foreach ($unitKerja->proyeks as $proyek)
                                                                                @if ($proyek->jenis_proyek == 'I')
                                                                                    <tr id="{{ $unitKerja->divcode }}"
                                                                                        class="collapse"
                                                                                        aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                        data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                        style="text-align: right;">
                                                                                        <td
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                            <!--begin::Child=-->
                                                                                            <p class="ms-12">
                                                                                                {{ $proyek->nama_proyek }}
                                                                                            </p>
                                                                                            <!--end::Child=-->
                                                                                        </td>

                                                                                        @for ($i = 0; $i < 12; $i++)
                                                                                            @if ($index > 3)
                                                                                                @php
                                                                                                    $index = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                            @php
                                                                                                $total_ok += (int) str_replace(',', '', $proyek->nilai_rkap);
                                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $proyek->nilai_kontrak_keseluruhan) ?? 0;
                                                                                                
                                                                                            @endphp
                                                                                            @foreach ($proyek->Forecasts as $forecast)
                                                                                                @if ($forecast->month_forecast == $i + 1)
                                                                                                    @php
                                                                                                        $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                    @endphp
                                                                                                    <td
                                                                                                        data-column-OK-internal="{{ $month_counter }}">
                                                                                                        <center>
                                                                                                            {{ $proyek->nilai_rkap }}
                                                                                                        </center>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            data-id-proyek-forecast-internal="{{ $proyek->kode_proyek }}"
                                                                                                            data-month="{{ $month_counter }}"
                                                                                                            data-column-forecast-internal="{{ $month_counter }}"
                                                                                                            class="form-control"
                                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                            id="nilai-forecast"
                                                                                                            name="nilai-forecast"
                                                                                                            onkeyup="reformatNumber(this)"
                                                                                                            value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                            placeholder=". . . , -" />
                                                                                                    </td>
                                                                                                    @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                            {{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}
                                                                                                        </td>
                                                                                                    @else
                                                                                                        <td
                                                                                                            data-column-realisasi-bulanan="{{ $month_counter }}">
                                                                                                            -</td>
                                                                                                    @endif
                                                                                                    @php
                                                                                                        $is_data_found = true;
                                                                                                    @endphp
                                                                                                @break
                                                                                            @endif
                                                                                            @php
                                                                                                $index++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                        @if (!$is_data_found)
                                                                                            <td
                                                                                                data-column-OK-internal="{{ $month_counter }}">
                                                                                                <center>
                                                                                                    {{ $proyek->nilai_rkap }}
                                                                                                </center>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    data-id-proyek-forecast-internal="{{ $proyek->kode_proyek }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast-internal="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value=""
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                                <td
                                                                                                    data-column-realisasi-internal="{{ $month_counter }}">
                                                                                                    {{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}
                                                                                                </td>
                                                                                            @else
                                                                                                <td
                                                                                                    data-column-realisasi-internal="{{ $month_counter }}">
                                                                                                    -</td>
                                                                                            @endif
                                                                                        @endif
                                                                                        @php
                                                                                            $is_data_found = false;
                                                                                            $month_counter++;
                                                                                        @endphp
                                                                                    @endfor
                                                                                    @php
                                                                                        $total_year_forecast += $total_forecast;
                                                                                        $total_forecast_formatted = number_format((int) $total_forecast, 0, ',', ',');
                                                                                        $total_ok_formatted = number_format((int) $total_ok, 0, ',', ',');
                                                                                        $total_forecast = 0;
                                                                                        $month_counter = 1;
                                                                                        $total_ok = 0;
                                                                                    @endphp
                                                                                    <!--begin::Total Coloumn-->
                                                                                    <td
                                                                                        class="pinForecast HidePin">
                                                                                        <center>
                                                                                            <b>{{ $total_ok_formatted }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin"
                                                                                        data-id-proyek-forecast-internal="{{ $proyek->kode_proyek }}">
                                                                                        <center>
                                                                                            <b>{{ $total_forecast_formatted }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td
                                                                                        class="pinForecast HidePin">
                                                                                        <center>
                                                                                            <b>{{ $proyek->nilai_kontrak_keseluruhan ?? '-' }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin total-month-x-ok-internal"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <center>
                                                                                            <b>{{ $total_ok_formatted }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin total-month-x-forecast-internal"
                                                                                        data-id-proyek-forecast-internal="{{ $proyek->kode_proyek }}"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <center>
                                                                                            <b>{{ $total_forecast_formatted }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin total-month-x-realisasi-internal"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <center>
                                                                                            <b>{{ $proyek->nilai_kontrak_keseluruhan ?? '-' }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <!--end::Total Coloumn-->
                                                                                    {{-- end:: Foreach Proyek --}}
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                    @php
                                                                        // $total_year_forecast += $total_forecast;
                                                                        // $total_forecast = 0;
                                                                        // $total_ok = 0;
                                                                        $month_counter = 1;
                                                                    @endphp
                                                                @endforeach
                                                                {{-- end:: Foreach Unit Kerja --}}
                                                            @endif
                                                        @endforeach

                                                    <tfoot
                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                        <div class="m-4">
                                                            <tr>
                                                                <td
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                    <!--begin::Child=-->
                                                                    Total
                                                                    <!--end::Child=-->
                                                                </td>
                                                                @for ($i = 0; $i < 12; $i++)
                                                                    <td total-column-y-ok={{ $i + 1 }}>
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span
                                                                                    class="placeholder col-12"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                    <td
                                                                        data-total-forecast-internal-column={{ $i + 1 }}>

                                                                    </td>
                                                                    <td
                                                                        total-column-y-realisasi={{ $i + 1 }}>
                                                                        <center>
                                                                            <p class="placeholder-wave">
                                                                                <span
                                                                                    class="placeholder col-12"></span>
                                                                            </p>
                                                                        </center>
                                                                    </td>
                                                                @endfor
                                                                {{-- begin::Total Year --}}
                                                                <td
                                                                    class="pinForecast HidePin total-year-ok-internal">
                                                                    <center>{{ $proyek->nilai_rkap }}
                                                                    </center>
                                                                </td>
                                                                <td
                                                                    class="pinForecast HidePin total-year-forecast-interal">
                                                                    <center>
                                                                        <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                    </center>
                                                                </td>
                                                                <td
                                                                    class="pinForecast HidePin total-year-realisasi-interal">
                                                                    <center>
                                                                        <p class="placeholder-wave">
                                                                            <span
                                                                                class="placeholder col-12"></span>
                                                                        </p>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast ShowPin total-year-ok-internal"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                    <center><b>{{ $proyek->nilai_rkap }}</b>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast ShowPin total-year-forecast-interal"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                    <center>
                                                                        <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast ShowPin total-year-realisasi-interal"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center>
                                                                        <p class="placeholder-wave">
                                                                            <span
                                                                                class="placeholder col-12"></span>
                                                                        </p>
                                                                    </center>
                                                                </td>
                                                                {{-- end::Total Year --}}
                                                            </tr>
                                                        </div>
                                                    </tfoot>

                                                    </tbody>

                                                    {{-- @endforeach --}}
                                                </table>
                                            </div>
                                            <!--end:::Tab pane Forecast Internal-->

                                            <!--begin:::Tab pane Forecast S/D-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_forecast_sd"
                                                role="tabpanel">
                                                <table class="table align-middle table-row-dashed fs-6"
                                                    id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr
                                                            style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                            <th class="min-w-auto" rowspan="2"
                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                <!--Begin::Svg Icon and Input Searc-->
                                                                <span
                                                                    class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                    <i class="bi bi-search"></i>
                                                                </span>
                                                                <input type="text"
                                                                    data-kt-customer-table-filter="search"
                                                                    class="form-control form-control w-250px ps-15"
                                                                    placeholder="Search" /><br>
                                                                <!--end::Svg Icon and Input Searc-->
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Januari</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Februari</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Maret</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>April</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Mei</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Juni</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Juli</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Agustus</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>September</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Oktober</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>November</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Desember</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-auto"
                                                                colspan="3">
                                                                <center>Total &nbsp;&nbsp; <i
                                                                        class="bi bi-pin-angle-fill"
                                                                        onclick="hidePin()"></i></center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-auto"
                                                                colspan="3"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center>Total &nbsp;&nbsp; <i
                                                                        class="bi bi-pin-fill text-primary"
                                                                        onclick="hidePin()"></i></center>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <!--begin::Sub-Judul Januari-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Januari-->
                                                            <!--begin::Sub-Judul Februari-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Februari-->
                                                            <!--begin::Sub-Judul Maret-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Maret-->
                                                            <!--begin::Sub-Judul April-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul April-->
                                                            <!--begin::Sub-Judul Mei-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Mei-->
                                                            <!--begin::Sub-Judul Juni-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Juni-->
                                                            <!--begin::Sub-Judul Juli-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Juli-->
                                                            <!--begin::Sub-Judul Agustus-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Agustus-->
                                                            <!--begin::Sub-Judul September-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul September-->
                                                            <!--begin::Sub-Judul Oktober-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Oktober-->
                                                            <!--begin::Sub-Judul November-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul November-->
                                                            <!--begin::Sub-Judul Desember-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Desember-->
                                                            <!--begin::Sub-Judul Total-->
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Total-->
                                                        </tr>
                                                        <!--end::Table head-->
                                                    </thead>

                                                    <!--begin::Table body-->

                                                    <tbody class="fw-bold text-gray-600" id="table-body">

                                                        @php
                                                            $month_counter = 1;
                                                            $is_data_found = false;
                                                            $total_ok = 0;
                                                            $total_year_ok = 0;
                                                            $total_forecast = 0;
                                                            $total_realisasi = 0;
                                                            $total_month_forecast = 0;
                                                            $total_year_forecast = 0;
                                                            $index = 1;
                                                        @endphp
                                                        @foreach ($dops as $dop)
                                                            @if (count($dop->UnitKerjas) > 0)
                                                                {{-- @foreach ($proyeks as $proyek) --}}

                                                                <tr style="text-align: right; ">

                                                                    @php
                                                                        $dop_name = str_replace(' ', '-', $dop->dop);
                                                                    @endphp
                                                                    <td
                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                        <a name="collalpse1" class=""
                                                                            data-bs-toggle="collapse"
                                                                            href="#{{ $dop_name }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="{{ $dop_name }} ">
                                                                            <i class="bi bi-chevron-down"></i>
                                                                            {{-- {{ $dop->dop }} --}}
                                                                            {{ $dop->dop }}
                                                                        </a>
                                                                    </td>

                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Total Coloumn-->
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        -</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        -</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        -</td>
                                                                    <!--end::Total Coloumn-->

                                                                </tr>

                                                                {{-- begin:: Foreach Unit Kerja --}}
                                                                @foreach ($dop->UnitKerjas as $unitKerja)
                                                                    @if (count($unitKerja->proyeks) > 0)
                                                                        <tr class="collapse accordion-header"
                                                                            id="{{ $dop_name }}"
                                                                            style="text-align: right;">
                                                                            <td
                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                <!--begin::Child=-->
                                                                                <a class="ms-6" type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="{{ $unitKerja->divcode }}">
                                                                                    <i
                                                                                        class="bi bi-chevron-down"></i>
                                                                                    {{ $unitKerja->unit_kerja }}
                                                                                </a>
                                                                                <!--end::Child=-->
                                                                            </td>
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Februari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Februari Coloumn-->
                                                                            <!--begin::Maret Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Maret Coloumn-->
                                                                            <!--begin::April Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::April Coloumn-->
                                                                            <!--begin::Mei Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Mei Coloumn-->
                                                                            <!--begin::Juni Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Juni Coloumn-->
                                                                            <!--begin::Juli Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Juli Coloumn-->
                                                                            <!--begin::Agustus Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Agustus Coloumn-->
                                                                            <!--begin::September Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::September Coloumn-->
                                                                            <!--begin::Oktober Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Oktober Coloumn-->
                                                                            <!--begin::November Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::November Coloumn-->
                                                                            <!--begin::Desember Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Desember Coloumn-->
                                                                            <!--begin::Total Coloumn-->
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                -</td>
                                                                            <!--end::Total Coloumn-->
                                                                        </tr>
                                                                        {{-- begin:: Foreach Proyek --}}
                                                                        @foreach ($unitKerja->proyeks as $proyek)
                                                                            <tr id="{{ $unitKerja->divcode }}"
                                                                                class="collapse"
                                                                                aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                style="text-align: right;">
                                                                                <td
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                    <!--begin::Child=-->
                                                                                    <p class="ms-12">
                                                                                        {{ $proyek->nama_proyek }}
                                                                                    </p>
                                                                                    <!--end::Child=-->
                                                                                </td>

                                                                                @for ($i = 0; $i < 12; $i++)
                                                                                    @if ($index > 3)
                                                                                        @php
                                                                                            $index = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @php
                                                                                        if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->nilai_kontrak_keseluruhan != null) {
                                                                                            $total_realisasi += (int) str_replace(',', '', $proyek->nilai_kontrak_keseluruhan);
                                                                                        }
                                                                                        
                                                                                        $total_ok += (int) str_replace(',', '', $proyek->nilai_rkap);
                                                                                    @endphp
                                                                                    @foreach ($proyek->Forecasts as $forecast)
                                                                                        @if ($forecast->month_forecast == $i + 1)
                                                                                            @php
                                                                                                $total_forecast += (int) str_replace(',', '', $forecast->nilai_forecast);
                                                                                            @endphp
                                                                                            <td
                                                                                                data-column-ok-sd="{{ $month_counter }}">
                                                                                                <center>
                                                                                                    {{ number_format($total_ok, 0, ',', ',') }}
                                                                                                </center>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    data-id-proyek-forecast-sd="{{ $proyek->kode_proyek }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast-sd="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->nilai_kontrak_keseluruhan != null)
                                                                                                <td
                                                                                                    data-column-realisasi-sd="{{ $month_counter }}">
                                                                                                    {{ number_format($total_realisasi, 0, ',', ',') }}
                                                                                                </td>
                                                                                            @else
                                                                                                <td
                                                                                                    data-column-realisasi-sd="{{ $month_counter }}">
                                                                                                    -</td>
                                                                                            @endif
                                                                                            @php
                                                                                                $is_data_found = true;
                                                                                            @endphp
                                                                                        @break
                                                                                    @endif
                                                                                    @php
                                                                                        $index++;
                                                                                    @endphp
                                                                                @endforeach
                                                                                @if (!$is_data_found)
                                                                                    <td
                                                                                        data-column-ok-sd="{{ $month_counter }}">
                                                                                        <center>
                                                                                            {{ number_format($total_ok, 0, ',', ',') }}
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            data-id-proyek-forecast-sd="{{ $proyek->kode_proyek }}"
                                                                                            data-month="{{ $month_counter }}"
                                                                                            data-column-forecast-sd="{{ $month_counter }}"
                                                                                            class="form-control"
                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                            id="nilai-forecast"
                                                                                            name="nilai-forecast"
                                                                                            onkeyup="reformatNumber(this)"
                                                                                            value=""
                                                                                            placeholder=". . . , -" />
                                                                                    </td>
                                                                                    @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                        <td
                                                                                            data-column-realisasi-sd="{{ $month_counter }}">
                                                                                            {{ number_format($total_realisasi, 0, ',', ',') }}
                                                                                        </td>
                                                                                    @else
                                                                                        <td
                                                                                            data-column-realisasi-sd="{{ $month_counter }}">
                                                                                            -</td>
                                                                                    @endif
                                                                                @endif
                                                                                @php
                                                                                    $is_data_found = false;
                                                                                    $month_counter++;
                                                                                @endphp
                                                                            @endfor
                                                                            @php
                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $total_realisasi) ?? 0;
                                                                                $total_ok_formatted = number_format($total_ok, 0, ',', ',');
                                                                                $total_forecast_formatted = number_format($total_forecast, 0, ',', ',');
                                                                                $total_forecast = 0;
                                                                                $total_ok = 0;
                                                                                $total_realisasi = 0;
                                                                            @endphp
                                                                            <!--begin::Total Coloumn-->
                                                                            <td
                                                                                class="pinForecast HidePin total-month-x-ok-sd">
                                                                                <center>
                                                                                    <b>{{ $total_ok_formatted }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast HidePin"
                                                                                data-id-proyek-forecast-sd="{{ $proyek->kode_proyek }}">
                                                                                <center>
                                                                                    <b>{{ $total_forecast_formatted }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td
                                                                                class="pinForecast HidePin total-month-x-realisasi-sd">
                                                                                <center>
                                                                                    <b>{{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                <center>
                                                                                    <b>{{ $total_ok_formatted }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin total-month-x-forecast-sd"
                                                                                data-id-proyek-forecast-sd="{{ $proyek->kode_proyek }}"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                <center>
                                                                                    <b>{{ $total_forecast_formatted }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                <center>
                                                                                    <b>{{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <!--end::Total Coloumn-->
                                                                    @endforeach
                                                                    {{-- end:: Foreach Proyek --}}
                                                                @endif
                                                                @php
                                                                    $total_year_forecast += $total_forecast;
                                                                    $total_year_ok += $total_realisasi;
                                                                    $total_forecast = 0;
                                                                    $total_ok = 0;
                                                                    $total_realisasi = 0;
                                                                    $month_counter = 1;
                                                                @endphp
                                                            @endforeach
                                                            {{-- end:: Foreach Unit Kerja --}}
                                                        @endif
                                                    @endforeach

                                                <tfoot
                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                    <div class="m-4">
                                                        <tr>
                                                            <td
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                <!--begin::Child=-->
                                                                Total
                                                                <!--end::Child=-->
                                                            </td>
                                                            @for ($i = 0; $i < 12; $i++)
                                                                <td
                                                                    data-total-column-ok-sd={{ $i + 1 }}>
                                                                    <center>
                                                                        <p class="placeholder-wave">
                                                                            <span
                                                                                class="placeholder col-4"></span>
                                                                        </p>
                                                                    </center>
                                                                </td>
                                                                <td
                                                                    data-total-column-forecast-sd={{ $i + 1 }}>
                                                                    <center>
                                                                        <p class="placeholder-wave">
                                                                            <span
                                                                                class="placeholder col-4"></span>
                                                                        </p>
                                                                    </center>
                                                                </td>
                                                                <td
                                                                    data-total-column-realisasi-sd={{ $i + 1 }}>
                                                                    <center>
                                                                        <p class="placeholder-wave">
                                                                            <span
                                                                                class="placeholder col-4"></span>
                                                                        </p>
                                                                    </center>
                                                                </td>
                                                            @endfor
                                                            {{-- begin::Total Year --}}
                                                            <td class="pinForecast HidePin total-year-ok-sd">
                                                                <center>{{ $proyek->nilai_rkap }}</center>
                                                            </td>
                                                            <td
                                                                class="pinForecast HidePin total-year-forecast-sd">
                                                                <center>
                                                                    <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            <td
                                                                class="pinForecast HidePin total-year-realisasi-sd">
                                                                <center>
                                                                    <b>{{ number_format($total_year_ok, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast ShowPin total-year-ok-sd"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                <center><b>{{ $proyek->nilai_rkap }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast ShowPin total-year-forecast-sd"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                <center>
                                                                    <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast ShowPin total-year-realisasi-sd"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center>
                                                                    <b>{{ number_format($total_year_ok, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            {{-- end::Total Year --}}
                                                        </tr>
                                                    </div>
                                                </tfoot>

                                                </tbody>

                                                {{-- @endforeach --}}
                                            </table>
                                        </div>
                                        <!--end:::Tab pane Forecast S/D-->

                                        <!--begin:::Tab pane Forecast S/D Eksternal-->
                                        <div class="tab-pane fade"
                                            id="kt_user_view_overview_forecast_sd_eksternal" role="tabpanel">
                                            <table class="table align-middle table-row-dashed fs-6"
                                                id="kt_customers_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr
                                                        style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                        <th class="min-w-auto" rowspan="2"
                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                            <!--Begin::Svg Icon and Input Searc-->
                                                            <span
                                                                class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                <i class="bi bi-search"></i>
                                                            </span>
                                                            <input type="text"
                                                                data-kt-customer-table-filter="search"
                                                                class="form-control form-control w-250px ps-15"
                                                                placeholder="Search" /><br>
                                                            <!--end::Svg Icon and Input Searc-->
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Januari</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Februari</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Maret</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>April</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Mei</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Juni</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Juli</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Agustus</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>September</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Oktober</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>November</center>
                                                        </th>
                                                        <th class="min-w-auto" colspan="3">
                                                            <center>Desember</center>
                                                        </th>
                                                        <th class="pinForecast HidePin min-w-auto"
                                                            colspan="3">
                                                            <center>Total &nbsp;&nbsp; <i
                                                                    class="bi bi-pin-angle-fill"
                                                                    onclick="hidePin()"></i></center>
                                                        </th>
                                                        <th class="pinForecast ShowPin min-w-auto"
                                                            colspan="3"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                            <center>Total &nbsp;&nbsp; <i
                                                                    class="bi bi-pin-fill text-primary"
                                                                    onclick="hidePin()"></i></center>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <!--begin::Sub-Judul Januari-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Januari-->
                                                        <!--begin::Sub-Judul Februari-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Februari-->
                                                        <!--begin::Sub-Judul Maret-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Maret-->
                                                        <!--begin::Sub-Judul April-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul April-->
                                                        <!--begin::Sub-Judul Mei-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Mei-->
                                                        <!--begin::Sub-Judul Juni-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Juni-->
                                                        <!--begin::Sub-Judul Juli-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Juli-->
                                                        <!--begin::Sub-Judul Agustus-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Agustus-->
                                                        <!--begin::Sub-Judul September-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul September-->
                                                        <!--begin::Sub-Judul Oktober-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Oktober-->
                                                        <!--begin::Sub-Judul November-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul November-->
                                                        <!--begin::Sub-Judul Desember-->
                                                        <th class="min-w-125px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="min-w-125px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Desember-->
                                                        <!--begin::Sub-Judul Total-->
                                                        <th class="pinForecast HidePin min-w-100px">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="pinForecast HidePin min-w-100px">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="pinForecast HidePin min-w-100px">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <th class="pinForecast ShowPin min-w-100px"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                            <center>OK</center>
                                                        </th>
                                                        <th class="pinForecast ShowPin min-w-100px"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                            <center>Forecast</center>
                                                        </th>
                                                        <th class="pinForecast ShowPin min-w-100px"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                            <center>Realisasi <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_create_namemodal">+</a>
                                                            </center>
                                                        </th>
                                                        <!--end::Sub-Judul Total-->
                                                    </tr>
                                                    <!--end::Table head-->
                                                </thead>

                                                <!--begin::Table body-->

                                                <tbody class="fw-bold text-gray-600" id="table-body">

                                                    @php
                                                        $month_counter = 1;
                                                        $is_data_found = false;
                                                        $total_ok = 0;
                                                        $total_year_ok = 0;
                                                        $total_forecast = 0;
                                                        $total_realisasi = 0;
                                                        $total_month_forecast = 0;
                                                        $total_year_forecast = 0;
                                                        $index = 1;
                                                    @endphp
                                                    @foreach ($dops as $dop)
                                                        @if (count($dop->UnitKerjas) > 0)
                                                            {{-- @foreach ($proyeks as $proyek) --}}

                                                            <tr style="text-align: right; ">

                                                                @php
                                                                    $dop_name = str_replace(' ', '-', $dop->dop);
                                                                @endphp
                                                                <td
                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                    <a name="collalpse1" class=""
                                                                        data-bs-toggle="collapse"
                                                                        href="#{{ $dop_name }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="{{ $dop_name }} ">
                                                                        <i class="bi bi-chevron-down"></i>
                                                                        {{-- {{ $dop->dop }} --}}
                                                                        {{ $dop->dop }}
                                                                    </a>
                                                                </td>

                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Januari Coloumn-->
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <td>-</td>
                                                                <!--end::Januari Coloumn-->
                                                                <!--begin::Total Coloumn-->
                                                                <td class="pinForecast HidePin">-</td>
                                                                <td class="pinForecast HidePin">-</td>
                                                                <td class="pinForecast HidePin">-</td>
                                                                <td class="pinForecast ShowPin"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                    -</td>
                                                                <td class="pinForecast ShowPin"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                    -</td>
                                                                <td class="pinForecast ShowPin"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    -</td>
                                                                <!--end::Total Coloumn-->

                                                            </tr>

                                                            {{-- begin:: Foreach Unit Kerja --}}
                                                            @foreach ($dop->UnitKerjas as $unitKerja)
                                                                @if (count($unitKerja->proyeks) > 0)
                                                                    <tr class="collapse accordion-header"
                                                                        id="{{ $dop_name }}"
                                                                        style="text-align: right;">
                                                                        <td
                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                            <!--begin::Child=-->
                                                                            <a class="ms-6" type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="{{ $unitKerja->divcode }}">
                                                                                <i
                                                                                    class="bi bi-chevron-down"></i>
                                                                                {{ $unitKerja->unit_kerja }}
                                                                            </a>
                                                                            <!--end::Child=-->
                                                                        </td>
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Februari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Februari Coloumn-->
                                                                        <!--begin::Maret Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Maret Coloumn-->
                                                                        <!--begin::April Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::April Coloumn-->
                                                                        <!--begin::Mei Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Mei Coloumn-->
                                                                        <!--begin::Juni Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Juni Coloumn-->
                                                                        <!--begin::Juli Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Juli Coloumn-->
                                                                        <!--begin::Agustus Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Agustus Coloumn-->
                                                                        <!--begin::September Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::September Coloumn-->
                                                                        <!--begin::Oktober Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Oktober Coloumn-->
                                                                        <!--begin::November Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::November Coloumn-->
                                                                        <!--begin::Desember Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Desember Coloumn-->
                                                                        <!--begin::Total Coloumn-->
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                            -</td>
                                                                        <!--end::Total Coloumn-->
                                                                    </tr>
                                                                    {{-- begin:: Foreach Proyek --}}
                                                                    @foreach ($unitKerja->proyeks as $proyek)
                                                                        @if ($proyek->jenis_proyek == 'E')

                                                                            <tr id="{{ $unitKerja->divcode }}"
                                                                                class="collapse"
                                                                                aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                style="text-align: right;">
                                                                                <td
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                    <!--begin::Child=-->
                                                                                    <p class="ms-12">
                                                                                        {{ $proyek->nama_proyek }}
                                                                                    </p>
                                                                                    <!--end::Child=-->
                                                                                </td>

                                                                                @for ($i = 0; $i < 12; $i++)
                                                                                    @if ($index > 3)
                                                                                        @php
                                                                                            $index = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @php
                                                                                        if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->nilai_kontrak_keseluruhan != null) {
                                                                                            $total_realisasi += (int) str_replace(',', '', $proyek->nilai_kontrak_keseluruhan);
                                                                                        }
                                                                                        
                                                                                        $total_ok += (int) str_replace(',', '', $proyek->nilai_rkap);
                                                                                    @endphp
                                                                                    @foreach ($proyek->Forecasts as $forecast)
                                                                                        @if ($forecast->month_forecast == $i + 1)
                                                                                            @php
                                                                                                $total_forecast += (int) str_replace(',', '', $forecast->nilai_forecast);
                                                                                            @endphp
                                                                                            <td
                                                                                                data-column-ok-sd-eksternal="{{ $month_counter }}">
                                                                                                <center>
                                                                                                    {{ number_format($total_ok, 0, ',', ',') }}
                                                                                                </center>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    data-id-proyek-forecast-sd-eksternal="{{ $proyek->kode_proyek }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast-sd-eksternal="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->nilai_kontrak_keseluruhan != null)
                                                                                                <td
                                                                                                    data-column-realisasi-sd-eksternal="{{ $month_counter }}">
                                                                                                    {{ number_format($total_realisasi, 0, ',', ',') }}
                                                                                                </td>
                                                                                            @else
                                                                                                <td
                                                                                                    data-column-realisasi-sd-eksternal="{{ $month_counter }}">
                                                                                                    -</td>
                                                                                            @endif
                                                                                            @php
                                                                                                $is_data_found = true;
                                                                                            @endphp
                                                                                        @break
                                                                                    @endif
                                                                                    @php
                                                                                        $index++;
                                                                                    @endphp
                                                                                @endforeach
                                                                                @if (!$is_data_found)
                                                                                    <td
                                                                                        data-column-ok-sd-eksternal="{{ $month_counter }}">
                                                                                        <center>
                                                                                            {{ number_format($total_ok, 0, ',', ',') }}
                                                                                        </center>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input
                                                                                            type="text"
                                                                                            data-id-proyek-forecast-sd-eksternal="{{ $proyek->kode_proyek }}"
                                                                                            data-month="{{ $month_counter }}"
                                                                                            data-column-forecast-sd-eksternal="{{ $month_counter }}"
                                                                                            class="form-control"
                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                            id="nilai-forecast"
                                                                                            name="nilai-forecast"
                                                                                            onkeyup="reformatNumber(this)"
                                                                                            value=""
                                                                                            placeholder=". . . , -" />
                                                                                    </td>
                                                                                    @if ($i + 1 >= array_search($proyek->bulan_ri_perolehan, $arrNamaBulan) && $proyek->bulan_ri_perolehan != null)
                                                                                        <td
                                                                                            data-column-realisasi-sd-eksternal="{{ $month_counter }}">
                                                                                            {{ number_format($total_realisasi, 0, ',', ',') }}
                                                                                        </td>
                                                                                    @else
                                                                                        <td
                                                                                            data-column-realisasi-sd-eksternal="{{ $month_counter }}">
                                                                                            -</td>
                                                                                    @endif
                                                                                @endif
                                                                                @php
                                                                                    $is_data_found = false;
                                                                                    $month_counter++;
                                                                                @endphp
                                                                            @endfor
                                                                            @php
                                                                                $nilai_terkontrak_formatted = (int) str_replace(',', '', $total_realisasi) ?? 0;
                                                                            @endphp
                                                                            <!--begin::Total Coloumn-->
                                                                            <td
                                                                                class="pinForecast HidePin total-month-x-ok-sd-eksternal">
                                                                                <center>
                                                                                    <b>{{ number_format($total_ok, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast HidePin"
                                                                                data-id-proyek-forecast-sd-eksternal="{{ $proyek->kode_proyek }}">
                                                                                <center>
                                                                                    <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td
                                                                                class="pinForecast HidePin total-month-x-realisasi-sd-eksternal">
                                                                                <center>
                                                                                    <b>{{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                <center>
                                                                                    <b>{{ number_format($total_ok, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin total-month-x-forecast-sd-eksternal"
                                                                                data-id-proyek-forecast-sd-eksternal="{{ $proyek->kode_proyek }}"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                <center>
                                                                                    <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                <center>
                                                                                    <b>{{ number_format($nilai_terkontrak_formatted ?? 0, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <!--end::Total Coloumn-->
                                                                    @endif
                                                                @endforeach
                                                                {{-- end:: Foreach Proyek --}}
                                                            @endif
                                                            @php
                                                                $total_year_forecast += $total_forecast;
                                                                $total_year_ok += $total_realisasi;
                                                                $total_forecast = 0;
                                                                $total_ok = 0;
                                                                $total_realisasi = 0;
                                                                $month_counter = 1;
                                                            @endphp
                                                        @endforeach
                                                        {{-- end:: Foreach Unit Kerja --}}
                                                    @endif
                                                @endforeach

                                            <tfoot
                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                <div class="m-4">
                                                    <tr>
                                                        <td
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                            <!--begin::Child=-->
                                                            Total
                                                            <!--end::Child=-->
                                                        </td>
                                                        @for ($i = 0; $i < 12; $i++)
                                                            <td
                                                                data-total-column-ok-sd-eksternal={{ $i + 1 }}>
                                                                <center>
                                                                    <p class="placeholder-wave">
                                                                        <span
                                                                            class="placeholder col-4"></span>
                                                                    </p>
                                                                </center>
                                                            </td>
                                                            <td
                                                                data-total-column-forecast-sd-eksternal={{ $i + 1 }}>
                                                                <center>
                                                                    <p class="placeholder-wave">
                                                                        <span
                                                                            class="placeholder col-4"></span>
                                                                    </p>
                                                                </center>
                                                            </td>
                                                            <td
                                                                data-total-column-realisasi-sd-eksternal={{ $i + 1 }}>
                                                                <center>
                                                                    <p class="placeholder-wave">
                                                                        <span
                                                                            class="placeholder col-4"></span>
                                                                    </p>
                                                                </center>
                                                            </td>
                                                        @endfor
                                                        {{-- begin::Total Year --}}
                                                        <td
                                                            class="pinForecast HidePin total-year-ok-sd-eksternal">
                                                            <center>{{ $proyek->nilai_rkap }}</center>
                                                        </td>
                                                        <td
                                                            class="pinForecast HidePin total-year-forecast-sd-eksternal">
                                                            <center>
                                                                <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                            </center>
                                                        </td>
                                                        <td
                                                            class="pinForecast HidePin total-year-realisasi-sd-eksternal">
                                                            <center>
                                                                <b>{{ number_format($total_year_ok, 0, ',', ',') }}</b>
                                                            </center>
                                                        </td>
                                                        <td class="pinForecast ShowPin total-year-ok-sd-eksternal"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                            <center><b>{{ $proyek->nilai_rkap }}</b>
                                                            </center>
                                                        </td>
                                                        <td class="pinForecast ShowPin total-year-forecast-sd-eksternal"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                            <center>
                                                                <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                            </center>
                                                        </td>
                                                        <td class="pinForecast ShowPin total-year-realisasi-sd-eksternal"
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                            <center>
                                                                <b>{{ number_format($total_year_ok, 0, ',', ',') }}</b>
                                                            </center>
                                                        </td>
                                                        {{-- end::Total Year --}}
                                                    </tr>
                                                </div>
                                            </tfoot>

                                            </tbody>

                                            {{-- @endforeach --}}
                                        </table>
                                    </div>
                                    <!--end:::Tab pane Forecast S/D Eksternal-->
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
    const toaster = document.querySelector(".toast");
    const toastBody = document.querySelector(".toast-body")
    const toastBoots = new bootstrap.Toast(toaster, {});

    if (historyForecast > 0) {
        disabledAllInputs();
    }

    function reformatNumber(elt) {
        const valueFormatted = Intl.NumberFormat("en-US", {
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
                const nilaiForecast = Number(e.target.value.toString().replaceAll(",", ""));
                const kodeProyek = input.getAttribute(attribute);
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
                const saveNilaiForecastRes = await fetch("/proyek/forecast/save", {
                    method: "POST",
                    header: {
                        "content-type": "application/json"
                    },
                    body: formData
                }).then(res => res.json());
                if (saveNilaiForecastRes.status == "success") {
                    const nilaiFormatted = Intl.NumberFormat("en-US", {
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
                                .replaceAll(",", ""));
                        }
                    })
                    rowForecastElt.forEach(rowForecast => {
                        if (rowForecast.value != null) {
                            totalRowForecast += Number(rowForecast.value.toString()
                                .replaceAll(
                                    ",",
                                    ""));
                        }
                    });

                    const rowValueFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(totalRowForecast);
                    const columnValueFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(totalColumnForecast);

                    input.value = nilaiFormatted;
                    toaster.classList.add("text-bg-success")
                    toaster.classList.remove("text-bg-danger")
                    toastBody.innerHTML = saveNilaiForecastRes.msg;
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
                                .toString().replaceAll(",",
                                    ""));
                        }
                    });

                    const columnTotalYearForecastFormatted = Intl.NumberFormat("en-US", {
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
                } else {
                    toaster.classList.remove("text-bg-success")
                    toaster.classList.add("text-bg-danger")
                    toastBody.innerHTML = saveNilaiForecastRes.msg;
                }
                toastBoots.show();
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
            const dataColumnForecast = document.querySelectorAll(
                `input[data-column-forecast="${totalColumnForecast}"]`);
            dataColumnForecast.forEach(dataForecast => {
                totalForecast += Number(dataForecast.value.replaceAll(",", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat("en-US", {
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

        // begin Calculate Total Column Year Forecast Bulanan 
        const dataColumnTotalYearForecast = document.querySelectorAll(`.total-year-forecast-bulanan`);
        let totalForecastYear = 0;
        const dataColumnForecast = document.querySelectorAll(
            `.total-month-x-forecast`);
        dataColumnForecast.forEach(dataForecast => {
            totalForecastYear += Number(dataForecast.innerText.replaceAll(",", ""));
        });
        const formattedForecastValue = Intl.NumberFormat("en-US", {
            maximumFractionDigits: 0,
        }).format(totalForecastYear);
        totalForecastYear = 0;

        dataColumnTotalYearForecast.forEach((forecast, i) => {
            forecast.innerHTML = `
        <td>
            <center><b>${formattedForecastValue}</b></center>
        </td>
        `;
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
                totalForecastInternal += Number(dataForecast.value.replaceAll(",", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat("en-US", {
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
                totalForecastSD += Number(dataForecast.value.replaceAll(",", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat("en-US", {
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
                totalOKBulanan += Number(dataForecast.innerText.replaceAll(",", ""));
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat("en-US", {
                    maximumFractionDigits: 0,
                }).format(totalOKBulanan);
                forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
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
            const dataColumnForecast = document.querySelectorAll(
                `td[data-column-realisasi-bulanan="${totalColumnForecast}"]`);
            dataColumnForecast.forEach(dataForecast => {
                totalRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, "") ?? 0);
            });
            if (totalColumnForecast) {
                const formattedForecastValue = Intl.NumberFormat("en-US", {
                    maximumFractionDigits: 0,
                }).format(totalRealisasiBulanan);
                forecast.innerHTML = `
            <td>
                <center><b>${Number.isNaN(formattedForecastValue) ? "-" : formattedForecastValue}</b></center>
            </td>
            `;
            }
            totalRealisasiBulanan = 0;
        });
        // end calculate total column Realisasi Bulanan

        // begin calculate Total Year OK Column
        // data-id-proyek-ok-bulanan
        const dataColumnTotalYearOKBulanan = document.querySelectorAll(`.total-year-ok-bulanan`);

        let totalYearOKBulanan = 0;
        dataColumnTotalYearOKBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(
                `td[data-id-proyek-ok-bulanan-total]`);
            dataColumnForecast.forEach(dataForecast => {
                if (dataForecast.classList.contains("ShowPin")) {
                    totalYearOKBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
                }
            });
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalYearOKBulanan);
            totalYearOKBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "-" : formattedForecastValue}</b></center>
        </td>
        `;
        });
        // end calculate Total Year OK Column

        // begin calculate Total Year Realisasi Column
        // total-year-realisasi-bulanan
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`.total-year-realisasi-bulanan`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(
                `.total-month-x-realisasi-bulanan`);
            dataColumnForecast.forEach(dataForecast => {
                totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
            });
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "-" : formattedForecastValue}</b></center>
        </td>
        `;
        });
        // end calculate Total Year Realisasi Column

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

    }

    recalculateColumn();

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
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "-" : formattedForecastValue}</b></center>
        </td>
        `;
        });
    }

    function sumColumnYear(eltToShow, eltToSum) {
        const dataColumnTotalYearRealisasiBulanan = document.querySelectorAll(`${eltToShow}`);

        let totalYearRealisasiBulanan = 0;
        dataColumnTotalYearRealisasiBulanan.forEach((forecast, i) => {
            const dataColumnForecast = document.querySelectorAll(
                `${eltToSum}`);
            dataColumnForecast.forEach(dataForecast => {
                totalYearRealisasiBulanan += Number(dataForecast.innerText.replaceAll(/[^0-9]/gi, ""));
            });
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalYearRealisasiBulanan);
            totalYearRealisasiBulanan = 0;
            forecast.innerHTML = `
        <td>
            <center><b>${Number.isNaN(formattedForecastValue) ? "-" : formattedForecastValue}</b></center>
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
        if (getIconElt.classList.contains("bi-lock-fill")) {
            modalBody.innerHTML = `
                @php
                    setlocale(LC_TIME, 'id.UTF-8');
                @endphp
                <p>Apakah anda yakin ingin membuka forecast pada bulan <b>{{ strftime('%B', mktime(0, 0, 0, date('m'))) }}</b>?</p>
            `;
            modalFooterBtn.innerText = "Request Authorize";
        } else {
            modalBody.innerHTML = `
                @php
                    setlocale(LC_TIME, 'id.UTF-8');
                @endphp
                <p>Apakah anda yakin ingin mengunci forecast pada bulan <b>{{ strftime('%B', mktime(0, 0, 0, date('m'))) }}</b>?</p>
            `;
            modalFooterBtn.innerText = "Lanjut";
        }
        modalBoots.show();
    }

    async function confirmedLock() {
        const getIconElt = monthEltBulanan.querySelector("i");
        const formData = new FormData();
        if (monthEltBulanan) {
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("periode_prognosa", "{{ date('m') }}");
            if (getIconElt.classList.contains("bi-unlock-fill")) {
                const getLockRes = await fetch("/forecast/set-lock", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                getIconElt.classList.remove("bi-unlock-fill");
                getIconElt.classList.add("bi-lock-fill");
                toaster.classList.add("text-bg-success");
                toastBody.innerText = getLockRes.msg;
            } else {
                const getLockRes = await fetch("/forecast/set-unlock", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                getIconElt.classList.add("bi-unlock-fill");
                getIconElt.classList.remove("bi-lock-fill");
                toaster.classList.add("text-bg-success");
                toastBody.innerText = getLockRes.msg;
            }
            toastBoots.show();
            disabledAllInputs();
            modalBoots.hide();
        }
    }

    function cancelLock() {
        monthEltBulanan = null;
    }

    function disabledAllInputs() {
        const allInputsForecast = document.querySelectorAll("input[data-month]");
        allInputsForecast.forEach(input => {
            if (input.hasAttribute("disabled")) {
                input.removeAttribute("disabled");
            } else {
                input.setAttribute("disabled", "");
            }
        });
    }
</script>
@endsection
{{-- end:: JS script --}}
