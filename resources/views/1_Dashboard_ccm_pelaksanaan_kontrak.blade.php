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
                                                <a class="nav-link text-active-primary pb-4 active"
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
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
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
                                                {{-- <option value="" {{$dop_get == "" ? "selected" : ""}}></option> --}}
                                                <option value="" selected></option>
                                                @foreach ($proyeks as $proyek)
                                                    <option value="{{ $proyek->divcode }}" {{ $proyek_get == $proyek->divcode ? 'selected' : '' }} >{{ $proyek->unit_kerja }}</option>
                                                    {{-- <option value="{{ $proyek->kode_proyek }}" >{{ $proyek->nama_proyek }} ({{$proyek->kode_proyek}})</option> --}}
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <form action="" method="GET">
                                            <button type="submit" class="btn btn-secondary">Reset</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End :: Filter-->

                        <br>

                        <!--begin::Card Line col-12-->
                        <div class="row mx-1">
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

                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col-4">
                                <!--begin::COLUMN CHART-->
                                <div id="contract-stage"></div>
                                <!-- data table is inserted here -->
                                <!--end::COLUMN CHART-->
                            </div>
                            <!--end-begin::Card column-->
                            <div class="col-4">
                                <!--begin::COLUMN CHART-->
                                <div id="contract-classification"></div>
                                <!-- data table is inserted here -->
                                <!--end::COLUMN CHART-->
                            </div>
                            <!--end-begin::Card column-->
                            <div class="col-4">
                                <!--begin::PIE CHART-->
                                <figure class="highcharts-figure">
                                    <div id="contract-jo"></div>
                                    <!-- data table is inserted here -->
                                </figure>
                                <!--end::PIE CHART-->
                            </div>
                            <!--end::Card column-->
                        </div>
                        <!--end::Card Diagram Column dan Donut-->

                        <!--begin::Title-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col">
                                <!--begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-1" style="background-color: #063F5C;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: 100%;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title w-100">
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white pt-1 fw-semibold fs-2 mx-auto">Resume CCM</span>
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
                        <!--end::Title-->

                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col-6">
                                <!--begin::PIE CHART-->
                                <figure class="highcharts-figure">
                                    <div id="contract-divisi"></div>
                                    <!-- data table is inserted here -->
                                </figure>
                                <!--end::PIE CHART-->
                            </div>
                            <!--end::begin::Card column-->
                            <!--begin::Card column-->
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
                        <!--end::Card Diagram Column dan Donut-->

                        <!--begin::Title-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col">
                                <!--begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-1" style="background-color: #063F5C;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: 100%;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title w-100">
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white pt-1 fw-semibold fs-2 mx-auto">Resume CCM</span>
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
                        <!--end::Title-->
                        {{-- <div class="col-4">
                            <!--begin::Card Status-->
                            <div class="col mx-3">
                                <!--begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #017EB8;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">Rp. 500.000.000</span>
                                                    <!--end::Amount-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Nilai Perubahan</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                        <span id="data-persen">52%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end-begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin Items::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">Rp. 500.000.000</span>
                                                    <!--end::Amount-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">VO</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                        <span id="data-persen">8%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end-begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">Rp. 500.000.000</span>
                                                    <!--end::Amount-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Klaim</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                        <span id="data-persen">11%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card column-->

                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #ae1b60;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Amount-->
                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">Rp. 500.000.000</span>
                                                    <!--end::Amount-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Anti Klaim</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                        <span id="data-persen">11%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 20-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card column-->

                                <!--end-begin::Card column-->
                                <div class="row">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Card widget 20-->
                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #1fb026;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="data-items">Rp. 500.000.000</span>
                                                    <!--begin::Amount-->
                                                    <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Asuransi</span>
                                                    <!--end::Amount-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                                        <span id="data-persen">11%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                        <div class="bg-white rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
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
                        </div> --}}

                        <!--begin::Card Line col-12-->
                        <div class="card mx-8">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col table-responsive">
                                        <table class="table text-center table-row-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="fw-bolder">Kategori</th>
                                                    <th class="fw-bolder">Total</th>
                                                    <th class="fw-bolder">Nilai</th>
                                                    <th class="fw-bolder">Nilai (dalam persen)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nilai_perubahan_table as $perubahan)
                                                    <tr>
                                                        <th>{{$perubahan->jenis_claim}}</th>
                                                        <td>{{$perubahan->total_proyek}}</td>
                                                        <td class="text-end">{{$perubahan->total_nilai}}</td>
                                                        <td>{{$perubahan->total_persen}}</td>
                                                    </tr>
                                                @endforeach
                                                {{-- <tr>
                                                    <th>Klaim</th>
                                                    <td>10</td>
                                                    <td class="text-end">Rp. 500.000.000</td>
                                                    <td>10%</td>
                                                </tr>
                                                <tr>
                                                    <th>Anti Klaim</th>
                                                    <td>10</td>
                                                    <td class="text-end">Rp. 500.000.000</td>
                                                    <td>10%</td>
                                                </tr>
                                                <tr>
                                                    <th>Asuransi</th>
                                                    <td>10</td>
                                                    <td class="text-end">Rp. 500.000.000</td>
                                                    <td>10%</td>
                                                </tr> --}}
                                                <tr class="text-bg-dark">
                                                    <th scope="row">Total Nilai</th>
                                                    <th>40</th>
                                                    <th class="text-end">Rp. 200.000.000.000</th>
                                                    <th>40%</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card Line col-12-->
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

@endsection
{{-- End::Main --}}
@section('js-script')

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

    <!--begin::Highchart Donut Pemilik Pekerjaan-->
    <script>
        const pemilikPekerjaan = JSON.parse('{!! $pemilik_pekerjaan->toJson() !!}');
        Highcharts.chart('contract-stage', {
            chart: {
                height: 250,
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
                    innerSize: 80,
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
                data: pemilikPekerjaan
            }]
        });
    </script>
    <!--end::Highchart Donut Pemilik Pekerjaan-->

    <!--begin::Highchart Donut Changes Overview-->
    <script>
        const changesOverview = JSON.parse('{!! $kategori_kontrak->toJson() !!}');
        Highcharts.chart('contract-divisi', {
            chart: {
                height: 250,
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
                    innerSize: 80,
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

    <!--begin::Highchart Donut Jenis Kontrak -->
    <script>
        const jenisKontrak = JSON.parse('{!! $jenis_kontrak->toJson() !!}');
        Highcharts.chart('contract-classification', {
            chart: {
                height: 250,
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
                    innerSize: 80,
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
                data: jenisKontrak
            }]
        });
    </script>
    <!--end::Highchart Donut Jenis Kontrak -->

    <!--begin::Highchart Donut Bentuk Proyek -->
    <script>
        Highcharts.chart('contract-jo', {
            chart: {
                type: 'pie',
                height: 250,
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
                    innerSize: 110,
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
    <!--end::Highchart Donut Bentuk Proyek -->
    
    <!--begin::Highchart Donut Changes Status -->
    <script>
        Highcharts.chart('changes-status', {
            chart: {
                type: 'pie',
                height: 330,
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
                    innerSize: 150,
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
                    ['Dispute', 8],
                    ['Revision', 16],
                    ['Reject', 2],
                    ['Approve', 10],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Changes Status -->
    
    <!--begin::Highchart Block Nilai Tender -->
    <script>
        const nilaiTender = JSON.parse('{!! $nilai_tender_proyeks->toJson() !!}');
        const sumTender = nilaiTender.reduce((a, b) => a + Number(b.y), 0);
        Highcharts.chart('chart-line', {
            chart: {
                type: 'column',
            },
            title: {
                text: 'Total Nilai Kontrak : Rp '+ Intl.NumberFormat(["id"]).format(Math.round(sumTender)),
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            xAxis: {
                type: 'category'
            },
            subtitle: {
                // text: '3D donut in Highcharts'
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
            series: [
                {
                    name: "Nilai Tender",
                    colorByPoint: true,
                    data: nilaiTender
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

    {{-- Begin :: Animation Progress Bar --}}
    <script>
        animateProgressBar();
    </script>
    {{-- End :: Animation Progress Bar --}}

    {{-- Begin :: Animation Counter Number --}}
    <script>
        animateCounterNumber("#data-persen", "", "%");
        animateCounterNumber("#data-items", "Rp. ");
    </script>
    {{-- End :: Animation Counter Number --}}

    {{-- Begin :: Select Filter Dropdown --}}
    <script>
        function selectFilter(e) {
            const value = e.value;
            const type = e.getAttribute("id");
            let url = "";
            if(type == "dop") {
                url = `/dashboard-ccm/pelaksanaan-kontrak?dop=${value}`;
            } else if(type == "unit-kerja") {
                url = `/dashboard-ccm/pelaksanaan-kontrak?unit-kerja=${value}`;
            } else {
                url = `/dashboard-ccm/pelaksanaan-kontrak?kode-proyek=${value}`;
            }
            window.location.href = url;
            return;
        }
    </script>
    {{-- End :: Select Filter Dropdown --}}

@endsection
