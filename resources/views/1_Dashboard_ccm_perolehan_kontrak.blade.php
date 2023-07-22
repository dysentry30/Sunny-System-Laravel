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

        
        .buttons-html5 {
            border-radius: 5px !important;
            border: none !important;
            font-weight: normal !important;
            padding: 8px 20px 8px 20px !important;
            margin-top: 10px !important;
        }
        .buttons-colvis {
            border: none !important;
            border-radius: 5px !important;
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
                                                <a class="nav-link text-active-primary pb-4 {{ str_contains(Request::Path(), 'dashboard') ? 'active' : '' }}"
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
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm/pemeliharaan-kontrak" style="font-size:14px;">Pemeliharaan Kontrak</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                                <!--begin::Wrapper-->
                                {{-- <div class="me-4">
                                    <!--begin::Menu-->
                                    <a href="#"
                                        class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                        <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Filter
                                    </a>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                        data-kt-menu="true" id="kt_menu_6155ac804a1c2">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Menu separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Form-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold">Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div>
                                                    <select class="form-select form-select-solid"
                                                        data-kt-select2="true" data-placeholder="Select option"
                                                        data-dropdown-parent="#kt_menu_6155ac804a1c2"
                                                        data-allow-clear="true">
                                                        <option></option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Pending</option>
                                                        <option value="2">In Process</option>
                                                        <option value="2">Rejected</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold">Member Type:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex">
                                                    <!--begin::Options-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="1" />
                                                        <span class="form-check-label">Author</span>
                                                    </label>
                                                    <!--end::Options-->
                                                    <!--begin::Options-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="2" checked="checked" />
                                                        <span class="form-check-label">Customer</span>
                                                    </label>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold">Notifications:</label>
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                                <div
                                                    class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="notifications" checked="checked" />
                                                    <label class="form-check-label">Enabled</label>
                                                </div>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true">Reset</button>
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    data-kt-menu-dismiss="true">Apply</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Menu 1-->
                                    <!--end::Menu-->
                                </div> --}}
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->
                    
                    <!--begin::Content-->
                    <!--begin::Body Dashboard-->
                    <div id="dashboard-body" style="overflow-x: hidden" class="mt-3">

                        <!--Begin :: Filter-->
                        {{-- <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <form action="" class="row" method="GET">
                                        <div class="col-2">
                                            <select id="dop-perolehan" onchange="filterUnitKerja(this)" name="dop"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Direktorat" data-select2-id="select2-data-dop-perolehan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($dops as $dop)
                                                        <option value="{{ $dop->dop }}" {{ $dop_get == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
    
                                        <div class="col-2">
                                            <select id="unit-kerja-perolehan" name="unit-kerja"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="false"
                                                    data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja-perolehan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($unit_kerjas as $unit_kerja)
                                                        <option value="{{ $unit_kerja->divcode }}" {{ $unit_kerja_get == $unit_kerja->divcode ? 'selected' : '' }} >{{ $unit_kerja->unit_kerja }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select id="tahun-perolehan" name="tahun"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Tahun" data-select2-id="select2-data-tahun-perolehan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected>{{ date("Y") }}</option>
                                                    @foreach ($tahun as $t)
                                                        <option value="{{$t}}" {{ $tahun_get == $t ? 'selected' : '' }}>{{$t}}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select id="bulan" name="bulan"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="false"
                                                    data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach (range(1, 12) as $m)
                                                        @php
                                                            $full_month = Carbon\Carbon::createFromFormat("m", $m)->translatedFormat("F");
                                                        @endphp
                                                        <option value="{{$m}}" {{ $bulan_get == $m ? 'selected' : '' }}>{{$full_month}}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-1">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                        <div class="col">
                                                <button type="submit" class="btn btn-secondary">Reset</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div> --}}
                        <!--End :: Filter-->

                        <!--Begin :: Filter-->
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="GET">
                                <div class="row">
                                        <div class="col-2" id="filterDOP">
                                            <select onchange="this.form.submit()" id="dop" name="dop"
                                                    style="margin-right: 2rem;"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Direktorat" data-select2-id="select2-data-dop" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($dops as $dop)
                                                        <option value="{{ $dop->dop }}" {{ $dop_select == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3" id="filterUK">
                                            <select onchange="this.form.submit()" id="unit-kerja" name="unit-kerja"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($unit_kerjas as $unit_kerjas)
                                                        <option value="{{ $unit_kerjas->divcode }}" {{ $unit_kerja_select == $unit_kerjas->divcode ? 'selected' : '' }} >{{ $unit_kerjas->unit_kerja }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="col-3">
                                            <select onchange="selectFilter(this)" id="proyek" name="proyek"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="false"
                                                    data-placeholder="Proyek" data-select2-id="select2-data-proyek" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach ($proyeks as $proyek)
                                                        <option value="{{ $proyek->divcode }}" {{ $proyek_get == $proyek->divcode ? 'selected' : '' }} >{{ $proyek->unit_kerja }}</option>
                                                        <option value="{{ $proyek->kode_proyek }}" >{{ $proyek->nama_proyek }} ({{$proyek->kode_proyek}})</option>
                                                    @endforeach
                                            </select>
                                        </div> --}}

                                        <div class="col-2" id="filterTahun">
                                            <select id="tahun" name="tahun"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Tahun" data-select2-id="select2-data-tahun" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($tahun as $t)
                                                        <option value="{{$t}}" {{ $tahun_get == $t ? 'selected' : '' }}>{{$t}}</option>
                                                    @endforeach 
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <select id="bulan" name="bulan"
                                                    class="form-select form-select-solid w-auto" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="" selected></option>
                                                    @foreach (range(1, 12) as $m)
                                                        @php
                                                            $full_month = Carbon\Carbon::createFromFormat("m", $m)->translatedFormat("F");
                                                        @endphp
                                                        <option value="{{$m}}" {{ $bulan_get == $m ? 'selected' : '' }}>{{$full_month}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-secondary">Filter</button>
                                            <button type="button" onclick="resetFilter()" class="btn btn-secondary">Reset</button>
                                            <script>
                                                function resetFilter() {
                                                    window.location.href = "/dashboard-ccm/perolehan-kontrak";
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--End :: Filter-->

                        <br>

                        {{-- <!--begin::Title-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col">
                                <div class="row">
                                    <div class="col-2">
                                        <!--begin::Card Status-->
                                        <div class="col mx-3">
                                            <!--begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="card-body pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-1" style="background-color: #063F5C;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title w-100">
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white pt-1 fw-semibold fs-3 mx-auto">Classification</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                        <!--begin::Card body-->
                                                        <div class="card-body d-flex align-items-end pt-0">
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card column-->
                                        </div>
                                        <!--end::Card Status-->
                                    </div>
                                    <div class="col-10">
                                        <!--begin::Card column-->
                                        <div class="row">
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Card widget 20-->
                                                <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-1" style="background-color: #063F5C;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: 100%;">
                                                    <!--begin::Header-->
                                                    <div class="card-header">
                                                        <!--begin::Title-->
                                                        <div class="card-title w-100">
                                                            <!--begin::Subtitle-->
                                                            <span class="text-white pt-1 fw-semibold fs-2 mx-auto">Tender Status</span>
                                                            <!--end::Subtitle-->
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Card body-->
                                                    <div class="card-body d-flex align-items-end pt-0">
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Card widget 20-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end-begin::Card column-->
                                    </div>
                                    <!--end::Card column-->
                                </div>
                            </div>
                            <!--end::Card column-->
                        </div>
                        <!--end::Title--> --}}

                        <!--begin::Title-->
                        <div class="row mb-4">
                            <div class="col-2 ms-10 me-0">
                                <!--begin::Title body-->
                                <div style="border-radius: 5px;" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">Classification</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col me-6">
                                <!--begin::Title body-->
                                <div style="border-radius: 5px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">Tender Status</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col">
                                <div class="row">
                                    <div class="col-2">
                                        <!--begin::Card Status-->
                                        <div class="col ms-3 me-0">
                                            <h2>CRM</h2>
                                            <!--begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $sasaran }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Sasaran</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin Items::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $cadangan }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Cadangan</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-0 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $potensial }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Potensi</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-0 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $naTender }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">N/A</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-6 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A ;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{$proyeks->count()}}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Total Proyeks</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card column-->
                                            <h2>MANKON</h2>
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-3 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #017EB8;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                {{-- <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2 tender-review-text" id="data-items">0</span> --}}
                                                                {{-- @php
                                                                    $tenderReview = 0;
                                                                    foreach ($proyeks as $key => $p) {
                                                                        $contract = $p->ContractManagements;
                                                                        if (!empty($contract)){
                                                                            if ($p->ContractManagements->reviewProjects->isNotEmpty() && $p->ContractManagements->inputRisks->isNotEmpty() && $p->ContractManagements->questionsProjects->isNotEmpty()) {
                                                                                $tenderReview += 1;
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp --}}
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="id-tender-review">{{ $tender_review }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Tender Status</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                        <!--begin::Card body-->
                                                        {{-- <div class="card-body d-flex align-items-end pt-0">
                                                            
                                                        </div> --}}
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-6 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #017EB8;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span id="id-data-collect" class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$proyeks->count()}}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-4">Data Collection</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                        <!--begin::Card body-->
                                                        {{-- <div class="card-body d-flex align-items-end pt-0">
                                                            
                                                        </div> --}}
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card column-->
                                        </div>
                                        <!--end::Card Status-->
                                    </div>
                                    <div class="col-2">
                                        <!--begin::Card Status-->
                                        <div class="col ms-6 mt-10">
                                            <!--begin::Card column-->
                                            <div class="row ">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $on_going_counter }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">On Going</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin Items::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $cancel_counter }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Cancel</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $win_counter }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Win</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                        <!--begin::Card body-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="mb-0 pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">{{ $lose_counter }}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Lose</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                        <!--begin::Card body-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0">
                                                    <!--begin::Card widget 20-->
                                                    <div class="rounded-0 py-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="col fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-persen">{{$success_rate}}</span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3"><i class='bi bi-percent text-white fs-3'></i> Success Rate</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end-begin::Card column-->
                                            <br>
                                            <div class="row">
                                                <!--begin::Card body-->
                                                <div class="pt-0 mt-9">
                                                    <!--begin::Card widget 20-->
                                                    <div class="py-9 rounded-0 py-0 card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90" style="background-color: #017EB8;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                        <!--begin::Header-->
                                                        <div class="card-header">
                                                            <!--begin::Title-->
                                                            <div class="card-title d-flex flex-column">
                                                                <!--begin::Amount-->
                                                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2 review-rate-text" id="review-persen"><i class="bi bi-percent text-white fs-3"></i></span>
                                                                <!--end::Amount-->
                                                                <!--begin::Subtitle-->
                                                                <span class="text-white opacity-75 pt-1 fw-semibold fs-3">Review Rate</span>
                                                                <!--end::Subtitle-->
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Header-->
                                                    </div>
                                                    <!--end::Card widget 20-->
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Card column-->
                                        </div>
                                        <!--end::Card Status-->
                                    </div>
                                    <div class="col-8">
                                        <!--begin::Card column-->
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
                                                        <div id="contract-jo"></div>
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
                                                        <div id="contract-stage"></div>
                                                        <!-- data table is inserted here -->
                                                    </figure>
                                                    <!--end::PIE CHART-->
                                            </div>
                                            <!--end::Card column-->
                                        </div>                                       
                                    </div>
                                    <!--end::Card column-->
                                </div>
                            </div>
                        </div>
                        <!--end::Card Diagram Column dan Donut-->
                        
                        <!--begin::Card Line col-12-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col">
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::LINE CHART-->
                                    <figure class="highcharts-figure">
                                        <div id="chart-line"></div>
                                        {{-- <div class="chart-outer" id="table-line">
                                            <!-- data table is inserted here -->
                                        </div> --}}
                                    </figure>
                                    <!--end::LINE CHART-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card column-->
                        </div>
                        <!--end::Card Line col-12-->

                    </div>
                    <!--end::Body Dashboard-->

                    <div class="card mx-8 px-0">
                    <!--begin::Card body-->
                        <div class="card-body pt-0 px-2">
                            <!--begin::Table-->
                            <table class="table align-middle table-bordered fs-6 gy-2" style="max-width: 100%" id="example">
                                <!--begin::Table head-->
                                <thead style="border: white 1px solid; background-color: #F7AD1A">
                                    <!--begin::Table row-->
                                    <tr class="text-start text-dark fw-bolder fs-7 text-uppercase gs-0">
                                        {{-- <th rowspan="2" class="min-w-auto px-4 align-middle text-center">NO</th> --}}
                                        <th rowspan="2" class="min-w-auto align-middle text-center fs-8">PROJECT</th>
                                        <th rowspan="2" width="15%" class="align-middle text-center fs-8">OWNER</th>
                                        <th rowspan="2" class="min-w-auto align-middle text-center fs-8">TYPE</th>
                                        <th colspan="2" class="min-w-auto align-middle text-center fs-8">EST. CONTRACT</th>
                                        <th colspan="8" class="min-w-auto align-middle text-center fs-8">DATA COLLECTION</th>
                                        <th colspan="3" class="min-w-auto align-middle text-center fs-8">TENDER STATUS</th>
                                        <th colspan="2" class="min-w-auto align-middle text-center fs-8">PIC</th>
                                        <th rowspan="2" class="min-w-auto align-middle text-center fs-8">STATUS &nbsp;&nbsp;</th>
                                    </tr>
                                    <tr class="text-start text-dark fw-bolder fs-7 text-uppercase gs-0 fs-8">
                                        <th class="min-w-auto align-middle text-center">AWARD</th>
                                        <th class="min-w-auto align-middle text-center">VALUE</th>
                                        <th class="min-w-auto align-middle text-center">NDA</th>
                                        <th class="min-w-auto align-middle text-center">LOI</th>
                                        <th class="min-w-auto align-middle text-center">MOU</th>
                                        <th class="min-w-auto align-middle text-center">ECA</th>
                                        <th class="min-w-auto align-middle text-center">ICA</th>
                                        <th class="min-w-auto align-middle text-center">DRAFT KONTRAK</th>
                                        <th class="min-w-auto align-middle text-center">RKS</th>
                                        <th class="min-w-auto align-middle text-center">ITB/TOR</th>
                                        <th class="min-w-auto align-middle text-center">TENDER REVIEW</th>
                                        <th class="min-w-auto align-middle text-center">RISK</th>
                                        <th class="min-w-auto align-middle text-center">DAFTAR PERTANYAAN</th>
                                        <th class="min-w-auto align-middle text-center">MANKON</th>
                                        <th class="min-w-auto align-middle text-center">BUSDEV&nbsp;&nbsp;</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600 fs-8">
                                    {{-- <tr>
                                        <td colspan="19" class="ps-3" style="border: white 1px solid; background-color: #F7DFAE">Sasaran</td>
                                    </tr> --}}
                                    @foreach ($contract_proyeks as $proyek)
                                    <tr>
                                            <!--begin::NIP-->
                                            <td>
                                                @php
                                                    $contract = $proyek->ContractManagements;
                                                @endphp
                                                <small>
                                                    @if (!empty($contract))
                                                        <a target="_blank" href="/contract-management/view/{{ $contract->id_contract }}" id="click-name"
                                                            class="ps-3 text-gray-800 text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                    @else
                                                        <p class="text-hover-primary mt-4" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="Proyek ini belum memiliki kontrak">{{ $proyek->nama_proyek }}</p>
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::NIP-->
                                            
                                            <!--begin::Ketua tender-->
                                            <td>
                                                <small>
                                                    {{ $proyek->proyekBerjalan->name_customer ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::Ketua tender-->
                                            
                                            <!--begin::Ketua tender-->
                                            <td>
                                                <small>
                                                    {{ $proyek->tipe_proyek == "J" ? "JO" : "NON JO"}}
                                                </small>
                                            </td>
                                            <!--end::Ketua tender-->
                                            
                                            <!--begin::unit-->
                                            <td>
                                                <small>
                                                    {{ $proyek->bulan_pelaksanaan }} - 
                                                    {{ $proyek->tahun_perolehan }} 
                                                </small>
                                            </td>
                                            <!--end::unit-->
                                            
                                            <!--begin::Role-->
                                            <td class="text-end">
                                                @php
                                                    $total_forecast = $proyek->Forecasts->filter(function($f) {
                                                        $date = date_create($f->created_at);
                                                        return $f->periode_prognosa == (int) date("m") && date_format($date, "Y") == date("Y");
                                                    })->sum(function($f) {
                                                        return (int) $f->nilai_forecast;
                                                    });
                                                @endphp
                                                <small>
                                                    {{ number_format((int) ( $total_forecast ?? $nilai_perolehan ?? $proyek->nilai_rkap ), 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Role-->
                                            
                                            <!--begin::NDA-->
                                            @php
                                                $dokumenCRM_NDA = $proyek->DokumenNda->first();
                                                $dokumenNDA = $contract->UploadFinal->where('category', '=', 'Dokumen NDA')->first();
                                                if(!empty($dokumenNDA)){
                                                    $statusWaktuUpload = new DateTime($dokumenNDA->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_NDA) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_NDA))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_NDA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenNDA) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenNDA))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenNDA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenNDA) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenNDA) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenNDA) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_NDA))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::NDA-->
                                            <!--begin::LOI-->
                                            @php
                                                $dokumenCRM_LOI = $proyek->AttachmentMenang->first();
                                                $dokumenLOI = $contract->UploadFinal->where('category', '=', 'Dokumen LOI')->first();
                                                if(!empty($dokumenLOI)){
                                                    $statusWaktuUpload = new DateTime($dokumenLOI->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_LOI) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_LOI))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_LOI->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenLOI) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenLOI))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenLOI->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenLOI) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenLOI) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenLOI) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_LOI))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::LOI-->
                                            <!--begin::MOU-->
                                            @php
                                                $dokumenCRM_MOU = $proyek->DokumenMou->first();
                                                $dokumenMOU = $contract->UploadFinal->where('category', '=', 'Dokumen MOU')->first();
                                                if(!empty($dokumenMOU)){
                                                    $statusWaktuUpload = new DateTime($dokumenMOU->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_MOU) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_MOU))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_MOU->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenMOU) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenMOU))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenMOU->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenMOU) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenMOU) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenMOU) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_MOU))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::MOU-->
                                            <!--begin::ECA-->
                                            @php
                                                $dokumenCRM_ECA = $proyek->DokumenEca->first();
                                                $dokumenECA = $contract->UploadFinal->where('category', '=', 'Dokumen ECA')->first();
                                                if(!empty($dokumenECA)){
                                                    $statusWaktuUpload = new DateTime($dokumenECA->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_ECA) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_ECA))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_ECA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenECA) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenECA))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenECA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenECA) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenECA) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenECA) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_ECA))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::ECA-->
                                            <!--begin::ICA-->
                                            @php
                                                $dokumenCRM_ICA = $proyek->DokumenIca->first();
                                                $dokumenICA = $contract->UploadFinal->where('category', '=', 'Dokumen ICA')->first();
                                                if(!empty($dokumenICA)){
                                                    $statusWaktuUpload = new DateTime($dokumenICA->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_ICA) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_ICA))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_ICA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenICA) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenICA))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenICA->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenICA) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenICA) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenICA) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_ICA))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::ICA-->
                                            <!--begin::DRAFT-->
                                                @php
                                                $dokumenCRM_Draft = $proyek->DokumenDraft->first();
                                                $dokumenDraft = $contract->UploadFinal->where('category', '=', 'Dokumen Draft Kontrak')->first();
                                                if(!empty($dokumenDraft)){
                                                    $statusWaktuUpload = new DateTime($dokumenDraft->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_Draft) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_Draft))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_Draft->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenDraft) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenDraft))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenDraft->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenDraft) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenDraft) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenDraft) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_Draft))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::DRAFT-->
                                            <!--begin::RKS-->
                                            @php
                                                $dokumenCRM_RKS = $proyek->DokumenRks->first();
                                                $dokumenRKS = $contract->UploadFinal->where('category', '=', 'Dokumen RKS / Project Spesification')->first();
                                                if(!empty($dokumenRKS)){
                                                    $statusWaktuUpload = new DateTime($dokumenRKS->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_RKS) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_RKS))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_RKS->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenRKS) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenRKS))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenRKS->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenRKS) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenRKS) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenRKS) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_RKS))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::RKS-->
                                            <!--begin::ITB-->
                                            @php
                                                $dokumenCRM_ITB = $proyek->DokumenItbTor->first();
                                                $dokumenITB = $contract->UploadFinal->where('category', '=', 'Dokumen ITB/TOR')->first();
                                                if(!empty($dokumenITB)){
                                                    $statusWaktuUpload = new DateTime($dokumenITB->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_ITB) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_ITB))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_ITB->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenITB) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenITB))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenITB->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenITB) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenITB) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenITB) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_ITB))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::ITB-->
                                            <!--begin::TENDER-->
                                            @php
                                                $dokumenCRM_Tender = $proyek->DokumenTender->first();
                                                $dokumenTender = $contract->UploadFinal->where('category', '=', 'Tinjauan Dokumen Kontrak - Perolehan')->first();
                                                if(!empty($dokumenTender)){
                                                    $statusWaktuUpload = new DateTime($dokumenTender->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_Tender) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_Tender))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_Tender->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenTender) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenTender))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenTender->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenTender) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenTender) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenTender) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_Tender))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::TENDER-->
                                            <!--begin::RISK-->
                                            @php
                                                $dokumenCRM_Risk = $proyek->RiskTenderProyek->first();
                                                $dokumenRisk = $contract->UploadFinal->where('category', '=', 'Dokumen Resiko - Perolehan')->first();
                                                if(!empty($dokumenRisk)){
                                                    $statusWaktuUpload = new DateTime($dokumenRisk->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                <small class="{{ !empty($dokumenCRM_Risk) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_Risk))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_Risk->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenRisk) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenRisk))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenRisk->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenRisk) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenRisk) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenRisk) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_Risk))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::RISK-->
                                            <!--begin::DAFTAR-->
                                            @php
                                                // $dokumenCRM_Aanwitjzing = $proyek->AanwitjzingTenderProyek->first();
                                                $dokumenAanwitjzing = $contract->UploadFinal->where('category', '=', 'Dokumen Aanwitjzing')->first();
                                                if(!empty($dokumenAanwitjzing)){
                                                    $statusWaktuUpload = new DateTime($dokumenAanwitjzing->created_at);
                                                    $currentDate = new DateTime();
                                                    $limitWaktu = $statusWaktuUpload->diff($currentDate)->d;
                                                }
                                            @endphp
                                            {{-- @dump($statusWaktuUpload) --}}
                                            <td class="text-center">
                                                {{-- <small class="{{ !empty($dokumenCRM_Aanwitjzing) ? 'badge badge-light-success' : 'badge badge-light-danger' }}">
                                                    @if (!empty($dokumenCRM_Aanwitjzing))
                                                    RFA <br>
                                                    {{ Carbon\Carbon::create($dokumenCRM_Aanwitjzing->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenAanwitjzing) ? 'badge badge-light-warning' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenAanwitjzing))
                                                    Approved <br>
                                                    {{ Carbon\Carbon::create($dokumenAanwitjzing->created_at)->format('d/m/Y') }}
                                                    @else
                                                    Open
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="{{ !empty($dokumenAanwitjzing) ? 'badge badge-light-primary' : 'badge badge-light-danger' }} my-1">
                                                    @if (!empty($dokumenAanwitjzing) && $limitWaktu > 14)
                                                        Late
                                                    @elseif (!empty($dokumenAanwitjzing) && $limitWaktu <= 14)
                                                        On Time
                                                    @elseif (!empty($dokumenCRM_Aanwitjzing))
                                                        On Going
                                                    @else
                                                        Open
                                                    @endif
                                                </small> --}}
                                                <small class="badge {{!empty($dokumenAanwitjzing) ? "badge-light-success" : "badge-light-danger"}}">
                                                    @if (!empty($dokumenAanwitjzing))
                                                        Approved
                                                    @else
                                                        Open
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::DAFTAR-->
                                            
                                            <!--begin::PIC-->
                                            <td class="text-center">-</td>
                                            <!--end::PIC-->
                                            <!--begin::PIC-->
                                            <td class="text-center">-</td>
                                            <!--end::PIC-->
                                            <!--begin::STATUS-->
                                            <td class="text-center">
                                                @php
                                                if (!empty($contract)) {
                                                    $status = !empty($dokumenNDA) && !empty($dokumenLOI) && !empty($dokumenMOU) && !empty($dokumenECA) && !empty($dokumenICA) && !empty($dokumenRKS) && !empty($dokumenITB) && !empty($dokumenTender) && !empty($dokumenRisk) && !empty($dokumenAanwitjzing);
                                                    // $status = $proyek->ContractManagements->reviewProjects->isNotEmpty() && $proyek->ContractManagements->inputRisks->isNotEmpty() && $proyek->ContractManagements->questionsProjects->isNotEmpty();
                                                    // $status = $proyek->DokumenNda->isNotEmpty() && $proyek->DokumenMou->isNotEmpty() && $proyek->AttachmentMenang->isNotEmpty() && $proyek->RiskTenderProyek->isNotEmpty() && $proyek->DokumenEca->isNotEmpty() && $proyek->DokumenIca->isNotEmpty();
                                                } else {
                                                    $status = false;
                                                }
                                                @endphp
                                                <p class="badge {{$status ? "badge-light-success" : "badge-light-danger"}} tender-review">{{$status ? "Closed" : "Open"}}</p>
                                            </td>
                                            <!--end::STATUS-->
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->

                        </div>
                        <!--end::Card body-->
                    </div>

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

    <!--begin::Highchart Donut Kontrak By Stage-->
    <script>
        const kontrakByStage = JSON.parse('{!! $kontrak_by_stage->toJson() !!}');
        Highcharts.chart('contract-stage', {
            chart: {
                type: 'pie',
                height: 300,
                options3d: {
                    enabled: true,
                    alpha: 5,
                }
            },
            title: {
                text: 'Tender Status',
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
                data: kontrakByStage,
            }]
        });
    </script>
    <!--end::Highchart Donut Kontrak By Stage-->

    <!--begin::Highchart Donut Kontrak By Divisi-->
    <script>
        const divisiChart = JSON.parse('{!! $divisi->toJson() !!}');
        Highcharts.chart('contract-divisi', {
            chart: {
                type: 'pie',
                height: 300,
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Tender Berdasarkan Divisi',
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
                data: divisiChart,
            }]
        });
    </script>
    <!--end::Highchart Donut Kontrak By Divisi-->

    <!--begin::Highchart Donut Kontrak Klasifikasi-->
    <script>
        const KlasifikasiTender = JSON.parse('{!! $klasifikasi_tender->toJson() !!}');
        Highcharts.chart('contract-classification', {
            chart: {
                type: 'pie',
                height: 300,
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Klasifikasi Tender',
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
                name: 'Tender',
                data: KlasifikasiTender
            }]
        });
    </script>
    <!--end::Highchart Donut Kontrak Klasifikasi-->

    <!--begin::Highchart Donut Kontrak JO dan Non-JO -->
    <script>
        const JONonJOCounter = JSON.parse('{!! $JO_Non_JO_counter->toJson() !!}');
        Highcharts.chart('contract-jo', {
            chart: {
                type: 'pie',
                height: 300,
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Tender JO & Non-JO',
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
                name: 'Tender',
                data: JONonJOCounter
            }]
        });
    </script>
    <!--end::Highchart Donut Kontrak JO dan Non-JO -->
    
    <!--begin::Highchart Block Nilai Tender -->
    <script>
        const nilaiTender = JSON.parse('{!! $nilai_tender_proyeks->toJson() !!}');
        const sumTender = nilaiTender.reduce((a, b) => a + Number(b.y), 0);
        console.log(nilaiTender, sumTender);

        Highcharts.chart('chart-line', {
            chart: {
                type: 'column',
            },
            title: {
                text: 'Nilai Tender : Rp '+ Intl.NumberFormat(["id"]).format(Math.round(sumTender)),
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            xAxis: {
                type: 'category'
            },
            subtitle: {
                text: 'Total Jumlah Kontrak : {{ $jumlahKontrak }}',
                style: {
                    fontWeight: 'bold',
                    fontSize: '15px'
                }
            },
            tooltip: {
                // headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                // pointFormat: '<tr><td style="padding:0">Nilai Tender: </td>' +
                //     '<td style="padding:0"><b>&nbsp;{point.y}</b></td></tr>',
                // footerFormat: '</table>',
                // shared: true,
                // useHTML: true
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },
            legend: {
                enabled: false,
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                    }
                }
            },
            series: [
                {
                    name: "Nilai Tender",
                    colorByPoint: true,
                    data: nilaiTender,
                },
            ]
        });
    </script>
    <!--end::Highchart Block Nilai Tender -->

    <!--begin::Highchart Line-->
    {{-- <script>
        Highcharts.chart('chart-line', {
            title: {
                text: 'Completion Rate Items VO, Claim & Anti Claims',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },

            subtitle: {
                // text: ''
            },

            yAxis: {
                title: {
                    text: ''
                }
            },

            xAxis: {
                accessibility: {
                    // rangeDescription: 'Range: 2010 to 2020'
                },
                categories: [
                        "TW VI", " TW I", "TW II", "TW III"
                    ],
            },

            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>&nbsp;{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                // shared: true,
                useHTML: true
            },
            
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    // pointStart: 1
                }
            },

            credits: {
                enabled: false
            },
            exporting: {
                showTable: true,
                allowHTML: true
            },

            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'20px',
                },
            },

            series: [{
                type: 'spline',
                name: '2020',
                data: [40, 25, 20, 30]
            }, {
                type: 'spline',
                name: '2021',
                data: [30, 17, 15, 20]
            }, {
                type: 'spline',
                name: '2022',
                data: [20, 5, 7, 10]
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

            });
    </script> --}}
    <!--end::Highchart Line-->

    <!-- Begin :: Animation Progress Bar -->
    <script>
        // function animateProgressBar() {
        //     const progressbarElts = document.querySelectorAll("div[role='progressbar']");
        //     progressbarElts.forEach(item => {
        //         const dataPersen = item.parentElement.parentElement.querySelector("#data-persen");
        //         let width = Number(dataPersen.innerText.replace("%", ""));
        //         item.style.width = width + "%";
        //     });
        // }
        // animateProgressBar();
    </script>
    <!-- End :: Animation Progress Bar -->

    <!-- Begin :: Animation Counter Number -->
    <script>
        // function animateCounterNumber(selector, lastPrefix) {
        //     const animateCounterElts = document.querySelectorAll(`${selector}`);
        //     animateCounterElts.forEach(item => {
        //         let data = Number(item.innerText.replace(lastPrefix, ""));
        //         item.innerText = `0${lastPrefix}`;
        //         let i = 0;
        //         const interval = setInterval(() => {
        //             if(i == data || ) clearInterval(interval);
        //             i += Math.floor(data/15);
        //             item.innerText = `${i}${lastPrefix}`;
        //         }, 15);
        //     });
        // }


        animateCounterNumber("#data-persen", "", " ");
        animateCounterNumber("#data-items", "", "");
    </script>
    <!-- End :: Animation Counter Number -->

    <!-- Begin :: Select Filter Dropdown -->
    <script>
        function selectFilter(e) {
            const value = e.value;
            const type = e.getAttribute("id");
            let url = "";
            if(type == "dop") {
                url = `/dashboard-ccm/perolehan-kontrak?dop=${value}`;
            } else if(type == "unit-kerja") {
                url = `/dashboard-ccm/perolehan-kontrak?unit-kerja=${value}`;
            } else {
                url = `/dashboard-ccm/perolehan-kontrak?kode-proyek=${value}`;
            }
            window.location.href = url;
            return;
        }
    </script>
    <!-- End :: Select Filter Dropdown -->

    <!-- Begin :: Select Filter Dropdown -->
    <script>
        // function selectFilter(e) {
        //     const value = e.value;
        //     const type = e.getAttribute("id");
        //     let url = "";
        //     let currentUrl = document.URL.replace(window.location.search, "") + "?";
        //     if(type == "dop") {
        //         url = currentUrl + `dop=${value}`;
        //     } 
        //     if(type == "unit-kerja") {
        //         url = currentUrl + `unit-kerja=${value}`;
        //     }
        //     window.location.href = url;
        //     return;
        // }
        const unitKerjas = JSON.parse('{!!$unit_kerjas_all->toJson()!!}');
        function filterUnitKerja(e) {
            let html = "";
            unitKerjas.forEach(unitKerja => {
                if(unitKerja.dop == e.value) {
                    html += `<option value="${ unitKerja.dop }" >${unitKerja.unit_kerja}</option>`;
                }
            });
            document.querySelector("#unit-kerja").innerHTML = html;
        }
    </script>
    <!-- End :: Select Filter Dropdown -->

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counterTenderReview = document.querySelectorAll(".tender-review");
            console.log(document.querySelector(".tender-review-text"));
            let tenderCount = 0;
            counterTenderReview.forEach(tender => {
                if(tender.innerHTML == "Closed") {
                    tenderCount ++;
                    // html += `<option value="${ unitKerja.dop }" >${unitKerja.unit_kerja}</option>`;
                }
            });
            document.querySelector(".tender-review-text").innerHTML = tenderCount;
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tenderReview = document.querySelector("#id-tender-review").innerHTML;
            const dataCollect = document.querySelector("#id-data-collect").innerHTML;
            // console.log(reviewRate);
            let review = Number(tenderReview) / Number(dataCollect) * 100;
            document.querySelector("#review-persen").innerHTML = review.toFixed(2)+' '+'<i class="bi bi-percent text-white fs-1">';
        });
    </script>

    <!--begin::Data Tables-->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                // dom: '<"float-start"f><"#example"t>rtip',
                pageLength : 25,
                scrollY : "1000px",
                scrollX : true,
                scrollCollapse: true,
                // paging : false,
                fixedColumns:   {
                    left: 2,
                    right: 0
                },
                buttons: [
                    // 'excel', 'print'
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    <!--end::Data Tables-->

@endsection
