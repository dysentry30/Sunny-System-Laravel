<!--begin::Nilai OK-->
                                            <td class="text-end">
                                                @php
                                                if ($proyek->tipe_proyek == 'R') {
                                                    $total_rkap = $proyek->Forecasts->filter(function($f) {
                                                        return $f->periode_prognosa == (int) date("m") && $f->tahun == (int) date("Y") ;
                                                    })->sum(function($f) {
                                                        return (int) $f->rkap_forecast;
                                                    });
                                                } else {
                                                    $total_rkap = $proyek->nilai_rkap ?? $proyek->nilaiok_awal;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_rkap, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Nilai OK-->

                                            <!--begin::Forecast-->
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
                                                    {{ number_format((int)$total_forecast, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Forecast-->
                                            
                                            <!--begin::Realisasi-->
                                            <td class="text-end">
                                                @php
                                                if ($proyek->tipe_proyek == 'R' && $proyek->stage == 8) {
                                                    $total_realisasi = $proyek->Forecasts->filter(function($f) {
                                                        return $f->periode_prognosa == (int) date("m") && $f->tahun == (int) date("Y") ;
                                                    })->sum(function($f) {
                                                        return (int) $f->realisasi_forecast;
                                                    });
                                                } else {
                                                    $total_realisasi = $proyek->nilai_perolehan;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_realisasi, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi--><!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <title>Data Set Proyek</title>
    
    <!-- begin::DataTables -->
    <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <!-- end::DataTables -->

    <link rel="shortcut icon" href="{{ asset('/media/logos/Icon-Sunny.png') }}" />
    <!--begin::Fonts-->

    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> --}}
    <link rel="stylesheet" href="{{ asset('/css/cssFont.css') }}" />
    <!--end::Fonts-->

    <!-- begin::Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}
    <link href="{{ asset('/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"> --}}
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap-icons.css') }}">
    <!-- end::Bootstrap CSS -->

    <!-- begin::Froala CSS -->
    {{-- <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' /> --}}
    <link href='{{ asset('/froala/froala_editor.pkgd.min.css') }}' rel='stylesheet'
        type='text/css' />
    <!-- end::Froala CSS -->
    
    <!-- Begin:: Leaflet Map -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin=""/> --}}
    <!-- End:: Leaflet Map -->

    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/stage.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/calendar.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->


    {{-- begin:: Disable Native Date Browser --}}
    <style>
        input[type="date"]::-webkit-input-placeholder {
            visibility: hidden !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
        }

        .select2-selection__rendered{
            color: #181c32 !important;
        }

        /* change color sortable to default text-gray-400 */
        th a{
            color: #b5b5c3 !important;
        }
        tr td, tr td a{
            color: #3f4254 !important;
        }
        .swal2-select {
            border-radius: 0;
            border: 0;
            border-bottom: 1px dashed #606061;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 8px !important;
            border: none !important;
            width: 40px !important;
        }
        div.dataTables_wrapper div.dataTables_length {
            margin-right: 5px !important;
            width: none !important;
        }
        
        .buttons-html5 {
            border-radius: 5px !important;
            border: none !important;
        }
        .buttons-colvis {
            border: none !important;
            border-radius: 5px !important;
        }
        div.dataTables_wrapper div.dataTables_filter input{
            border-radius: 5px !important;
        }
        
        /* @media (min-width: 992px) {
            [data-kt-aside-minimize=on] .aside {
                width: 50px !important;
                transition: width 0.3s ease;
            }
        } */
        
        .fr-wrapper div:not(.fr-element.fr-view):nth-child(1) {
            display: none;
        }

        div.dt-button-collection button.dt-button.active:not(.disabled) {
            background: #0db0d9 !important;
            color: white;
            border-radius: 4px;
            padding: 10px;
            border: none;
            font-weight: normal;
            
        }
        
        div.dt-button-collection button.dt-button:not(.disabled) {
            font-weight: normal;
            border: none;
            border-radius: 4px;
            padding: 10px;

        }

    </style>
    {{-- end:: Disable Native Date Browser --}}
</head>
<!--end::Head-->


<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">




    <!--begin:: CONTENT-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" style="padding-left: 0px !important" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar" style="left: 0px !important">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Data Set - Proyek
                                </h1>
                                <!--end::Title-->
                            </div>

                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="/proyek" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        id="proyek-back">
                                        Back</a>

                                    {{-- <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_proyek" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button> --}}

                                    <!--begin::Wrapper-->
                                    {{-- <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                            id="kt_menu_6155ac804a1c2">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="">
                                                <!--begin::Item-->
                                                <a href="/proyek/export-proyek"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </a>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div> --}}
                                    <!--end::Wrapper-->


                                </div>
                                <!--end::Actions-->
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-1">
                            <!--begin::Card title-->
                            <div class="card-title">

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        {{-- <option {{ $column == '' ? 'selected' : '' }}></option> --}}
                                        <option value="nama_proyek" {{ $column == 'nama_proyek' ? 'selected' : '' }}>Nama
                                            Proyek</option>
                                        <option value="kode_proyek" {{ $column == 'kode_proyek' ? 'selected' : '' }}>Kode
                                            Proyek</option>
                                        <option value="tahun_perolehan"
                                            {{ $column == 'tahun_perolehan' ? 'selected' : '' }}>Tahun Perolehan</option>
                                        <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                        <option value="stage" {{$column == "stage" ? "selected" : ""}}>Stage</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>
                                        <option value="tipe_proyek" {{$column == "tipe_proyek" ? "selected" : ""}}>Tipe Proyek</option>

                                    </select>
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    {{-- @if ($column == 'stage') --}}
                                        <div style="display: none !important" id="filterStage" class="d-flex align-items-center position-relative">
                                            <select name="filter-stage"
                                                class="form-select form-select-solid w-auto ms-2"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilih Stage"
                                                tabindex="-1" aria-hidden="true">
                                                <option></option>
                                                <option value="1" {{ $filter == '1' ? 'selected' : '' }}>Pasar Dini
                                                </option>
                                                <option value="2" {{ $filter == '2' ? 'selected' : '' }}>Pasar Potensial
                                                </option>
                                                <option value="3" {{ $filter == '3' ? 'selected' : '' }}>Prakualifikasi
                                                </option>
                                                <option value="4" {{ $filter == '4' ? 'selected' : '' }}>Tender Diikuti
                                                </option>
                                                <option value="5" {{ $filter == '5' ? 'selected' : '' }}>Perolehan</option>
                                                <option value="6" {{ $filter == '6' ? 'selected' : '' }}>Menang</option>
                                                <option value="7" {{ $filter == '7' ? 'selected' : '' }}>Kalah</option>
                                                <option value="8" {{ $filter == '8' ? 'selected' : '' }}>Terkontrak
                                                </option>
                                                <option value="9" {{ $filter == '9' ? 'selected' : '' }}>Terendah</option>
                                                <option value="10" {{ $filter == '10' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                    {{-- @elseif ($column == 'jenis_proyek') --}}
                                        <div style="display: none !important" id="filterJenis" class="d-flex align-items-center position-relative">
                                            <select name="filter-jenis"
                                                class="form-select form-select-solid w-auto ms-2"
                                                data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek"
                                                tabindex="-1" aria-hidden="true">
                                                <option></option>
                                                <option value="I" {{ $filter == 'I' ? 'selected' : '' }}>Internal</option>
                                                <option value="N" {{ $filter == 'N' ? 'selected' : '' }}>External</option>
                                                <option value="J" {{ $filter == 'J' ? 'selected' : '' }}>JO</option>
                                            </select>
                                        </div>
                                        <div style="display: none !important" id="filterTipe" class="d-flex align-items-center position-relative">
                                            <select name="filter-tipe"
                                                class="form-select form-select-solid w-auto ms-2"
                                                data-control="select2" data-hide-search="true" data-placeholder="Tipe Proyek"
                                                tabindex="-1" aria-hidden="true">
                                                <option></option>
                                                <option value="R" {{ $filter == 'R' ? 'selected' : '' }}>Retail</option>
                                                <option value="P" {{ $filter == 'P' ? 'selected' : '' }}>Non-Retail</option>
                                            </select>
                                        </div>
                                    {{-- @elseif ($column == 'unit_kerja') --}}
                                        <div style="display: none !important" id="filterUnit" class="d-flex align-items-center position-relative">
                                            <select name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                                data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                                <option></option>
                                                @foreach ($unitkerjas as $unitkerja)
                                                    <option value="{{ $unitkerja->divcode }}"
                                                        {{ old('unit-kerja') == $unitkerja->divcode ? 'selected' : '' }}>
                                                        {{ $unitkerja->unit_kerja }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    {{-- @else --}}
                                        <div id="filter" class="d-flex align-items-center position-relative">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <input type="text" data-kt-customer-table-filter="search"
                                                name="filter" value="{{ $filter }}"
                                                class="form-control form-control-solid ms-2 ps-12 w-auto"
                                                placeholder="Input Filter" />
                                        </div>
                                    {{-- @endif --}}

                                    <script>
                                        function changes(e) {
                                            if (e.value == "stage") {
                                                // console.log(e);
                                                // window.location.href = "/proyek?column=stage";
                                                document.getElementById("filterStage").style.display = "";
                                                document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                                document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                                document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").value = "";
                                            } else if (e.value == "unit_kerja") {
                                                document.getElementById("filterUnit").style.display = "";
                                                document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                                document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                                document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").value = "";
                                            } else if (e.value == "jenis_proyek") {
                                                document.getElementById("filterJenis").style.display = "";
                                                document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                                document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                                document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").value = "";
                                            } else if (e.value == "tipe_proyek") {
                                                document.getElementById("filterTipe").style.display = "";
                                                document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                                document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                                document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").style.setProperty("display", "none", "important");
                                                document.getElementById("filter").value = "";
                                            } else {
                                                document.getElementById("filter").style.display = "";
                                                document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                                document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                                document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                                document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                            }
                                        }
                                    </script>
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
                                            window.location.href = "/proyek-datatables/set";
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER-->


                            </div>
                            <!--begin::Card title-->

                            <!--begin::Paginate-->
                            {{-- <div class="align-items-center d-flex flex-row-reverse">
												<div>
													{{ $proyeks->links() }}
												</div>

												<div class="p-2" style="color:gray">
													Showing
													{{ $proyeks->firstItem() }}
													to
													{{ $proyeks->lastItem() }}
													of
													{{ $proyeks->total()}}
													entries
												</div>
											</div> --}}
                            <!--end::Paginate-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table Proyek-->
                            <table id="example" class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase text-sm gs-0">
                                        <th class="min-w-auto"><small>Kode Proyek</small></th>
                                        <th class="min-w-auto"><small>Nama Proyek</small></th>
                                        <th class="min-w-auto"><small>Unit Kerja</small></th>
                                        <th class="min-w-auto"><small>Stage</small></th>
                                        <th class="min-w-auto"><small>Tahun RA Perolehan</small></th>
                                        <th class="min-w-auto"><small>Bulan RA Perolehan</small></th>
                                        <th class="min-w-auto"><small>Nilai RKAP</small></th>
                                        <th class="min-w-auto"><small>Nilai Forecast</small></th>
                                        <th class="min-w-auto"><small>Nilai Realisasi</small></th>
                                        <th class="min-w-auto"><small>Pelanggan</small></th>
                                        <th class="min-w-auto text-center"><small>Jenis Proyek</small></th>
                                        <th class="min-w-auto"><small>Sumber Dana</small></th>
                                        <th class="min-w-auto"><small>Status Pasar Dini</small></th>
                                        <th class="min-w-auto"><small>Asal Info proyek</small></th>
                                        <th class="min-w-auto"><small>Nilai OK Review (Valas) (Exclude Tax)</small></th>
                                        <th class="min-w-auto"><small>Mata Uang Review</small></th>
                                        <th class="min-w-auto"><small>Bulan Pelaksanaan Review</small></th>
                                        <th class="min-w-auto"><small>Laporan Pasar Dini</small></th>
                                        <th class="min-w-auto"><small>Negara</small></th>
                                        <th class="min-w-auto"><small>Status Pasar Potensial</small></th>
                                        <th class="min-w-auto"><small>SBU</small></th>
                                        <th class="min-w-auto"><small>Klasifikasi</small></th>
                                        <th class="min-w-auto"><small>Sub Klasifikasi</small></th>
                                        <th class="min-w-auto"><small>DOP</small></th>
                                        <th class="min-w-auto"><small>Company</small></th>
                                        <th class="min-w-auto"><small>Laporan pasar Potensial</small></th>
                                        <th class="min-w-auto"><small>Proyek Strategis</small></th>
                                        <th class="min-w-auto"><small>Jadwal PQ</small></th>
                                        <th class="min-w-auto"><small>HPS / Pagu (Rupiah)</small></th>
                                        <th class="min-w-auto"><small>Porsi JO (%)</small></th>
                                        <th class="min-w-auto"><small>Laporan Prakualifikasi</small></th>
                                        <th class="min-w-auto"><small>Jadwal Pemasukan Tender</small></th>
                                        <th class="min-w-auto"><small>Lokasi Tender</small></th>
                                        <th class="min-w-auto"><small>Nilai Penawaran Keseluruhan</small></th>
                                        <th class="min-w-auto"><small>Laporan Tender Diikuti</small></th>
                                        <th class="min-w-auto"><small>Nilai Perolehan</small></th>
                                        <th class="min-w-auto"><small>Peringkat Wika</small></th>
                                        <th class="min-w-auto"><small>% OE Wika</small></th>
                                        <th class="min-w-auto"><small>Laporan Perolehan</small></th>
                                        <th class="min-w-auto"><small>Aspek Pesaing</small></th>
                                        <th class="min-w-auto"><small>Aspek Non Pesaing</small></th>
                                        <th class="min-w-auto"><small>Usulan Saran Perbaikan</small></th>
                                        <th class="min-w-auto"><small>Laporan Menag / Kalah</small></th>
                                        <th class="min-w-auto"><small>Nilai Kontrak Keseluruhan</small></th>
                                        <th class="min-w-auto"><small>Nilai Kontrak (Porsi WIKA)</small></th>
                                        <th class="min-w-auto"><small>Klasifikasi Proyek</small></th>
                                        <th class="min-w-auto"><small>Jenis Kontrak</small></th>
                                        <th class="min-w-auto"><small>Sistem Pembayaran</small></th>
                                        <th class="min-w-auto"><small>No SPK External</small></th>
                                        <th class="min-w-auto"><small>Tanggal SPK Internal</small></th>
                                        <th class="min-w-auto"><small>Tahun RI Perolehan</small></th>
                                        <th class="min-w-auto"><small>Bulan RI Perolehan</small></th>
                                        <th class="min-w-auto"><small>No Kontrak</small></th>
                                        <th class="min-w-auto"><small>Tanggal Kontrak</small></th>
                                        <th class="min-w-auto"><small>Tanggal Mulai Kontrak</small></th>
                                        <th class="min-w-auto"><small>Tanggal Akhir Kontrak</small></th>
                                        <th class="min-w-auto"><small>Tanggal Selesai Bash PHO</small></th>
                                        <th class="min-w-auto"><small>Tanggal Selesai Bash FHO</small></th>
                                        <th class="min-w-auto"><small>Laporan Terkontrak</small></th>

                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    $proyeks = $proyeks->reverse();
                                @endphp
                                <tbody class="fw-bold text-gray-800">
                                    @foreach ($proyeks as $proyek)
                                        <tr>
                                            <!--begin::Name-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->kode_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Email-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Email-->
                                            <!--begin::Company-->
                                            <td>
                                                <small>
                                                    {{ $proyek->UnitKerja->unit_kerja }}
                                                </small>
                                            </td>
                                            <!--end::Company-->

                                            <!--begin::Stage-->
                                            @php
                                                if ($proyek->stage == 0 || $proyek->stage == 7 || $proyek->stage == 10 || $proyek->is_cancel ){
                                                    $stageColor = "text-danger";
                                                } else if ($proyek->stage == 8 || $proyek->stage == 9){
                                                    $stageColor = "text-success";
                                                } else {
                                                    $stageColor = "";
                                                }                                                    
                                            @endphp
                                            <td class="{{ $stageColor }}">
                                                @if ($proyek->is_cancel)
                                                    Canceled Proyek
                                                @else
                                                <small>
                                                    @switch($proyek->stage)
                                                        @case('0')
                                                            Gugur PQ
                                                        @break

                                                        @case('1')
                                                            Pasar Dini
                                                        @break

                                                        @case('2')
                                                            Pasar Potensial
                                                        @break

                                                        @case('3')
                                                            Prakualifikasi
                                                        @break

                                                        @case('4')
                                                            Tender Diikuti
                                                        @break

                                                        @case('5')
                                                            Perolehan
                                                        @break

                                                        @case('6')
                                                            Menang
                                                        @break

                                                        @case('7')
                                                            Kalah
                                                        @break

                                                        @case('8')
                                                            Terkontrak
                                                        @break

                                                        @case('9')
                                                            Terendah
                                                        @break

                                                        @case('10')
                                                            Gugur Prakualifikasi
                                                        @break

                                                        @default
                                                            *Belum Ditentukan
                                                    @endswitch
                                                </small>
                                                @endif
                                            </td>
                                            <!--end::Stage-->
                                            
                                            <!--begin::Pelaksanaan-->
                                            <td class="text-center {{ $proyek->tahun_perolehan >= 2021 ? '' : 'text-danger' }}">
                                                <small>
                                                    {{ $proyek->tahun_perolehan }}
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Pelaksanaan-->
                                            <td class="">
                                                <small>
                                                    @switch($proyek->bulan_pelaksanaan)
                                                        @case('1')
                                                            Januari
                                                        @break

                                                        @case('2')
                                                            Februari
                                                        @break

                                                        @case('3')
                                                            Maret
                                                        @break

                                                        @case('4')
                                                            April
                                                        @break

                                                        @case('5')
                                                            Mei
                                                        @break

                                                        @case('6')
                                                            Juni
                                                        @break

                                                        @case('7')
                                                            Juli
                                                        @break

                                                        @case('8')
                                                            Agustus
                                                        @break

                                                        @case('9')
                                                            September
                                                        @break

                                                        @case('10')
                                                            Oktober
                                                        @break

                                                        @case('11')
                                                            November
                                                        @break

                                                        @case('12')
                                                            Desember
                                                        @break

                                                        @default
                                                            *Belum Ditentukan
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Nilai OK-->
                                            <td class="text-end">
                                                @php
                                                if ($proyek->tipe_proyek == 'R') {
                                                    $total_rkap = $proyek->Forecasts->filter(function($f) {
                                                        return $f->periode_prognosa == (int) date("m") && $f->tahun == (int) date("Y") ;
                                                    })->sum(function($f) {
                                                        return (int) $f->rkap_forecast;
                                                    });
                                                } else {
                                                    $total_rkap = $proyek->nilai_rkap ?? $proyek->nilaiok_awal;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_rkap, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Nilai OK-->

                                            <!--begin::Forecast-->
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
                                                    {{ number_format((int)$total_forecast, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Forecast-->
                                            
                                            <!--begin::Realisasi-->
                                            <td class="text-end">
                                                @php
                                                if ($proyek->tipe_proyek == 'R' && $proyek->stage == 8) {
                                                    $total_realisasi = $proyek->Forecasts->filter(function($f) {
                                                        return $f->periode_prognosa == (int) date("m") && $f->tahun == (int) date("Y") ;
                                                    })->sum(function($f) {
                                                        return (int) $f->realisasi_forecast;
                                                    });
                                                } else {
                                                    $total_realisasi = $proyek->nilai_perolehan;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_realisasi, 0, '.', '.') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi-->

                                            <!--begin::Realisasi-->
                                            <td class="text-start {{ $proyek->proyekBerjalan ? '' : 'text-danger' }}">
                                                <small>
                                                    {{ $proyek->proyekBerjalan->name_customer ?? "*Belum Ditentukan" }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi-->


                                            <!--begin::Jenis Proyek-->
                                            <td class="text-center">
                                                <small>
                                                    @switch($proyek->jenis_proyek)
                                                        @case('I')
                                                            Internal
                                                        @break

                                                        @case('N')
                                                            External
                                                        @break

                                                        @case('J')
                                                            JO
                                                        @break

                                                        @default
                                                            -
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::Jenis Proyek-->

                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->sumber_dana ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->status_pasdin ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->info_asal_proyek ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nilai_valas_review ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->mata_uang_review ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->bulan_review ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_kualitatif_pasdin	 ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->negara ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->status_pasar ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->sbu ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->klasifikasi ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->sub_klasifikasi ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->dop ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->company ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_kualitatif_paspot ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-center">
                                                <small>
                                                    @switch($proyek->proyek_strategis)
                                                        @case('1')
                                                            Ya
                                                        @break

                                                        @default
                                                            Tidak
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->jadwal_pq ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->hps_pagu ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->porsi_jo ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_prakualifikasi ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->jadwal_tender ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->lokasi_tender ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->penawaran_tender ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_tender ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nilai_perolehan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->peringkat_wika ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->oe_wika ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_perolehan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->aspek_pesaing ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->aspek_non_pesaing ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->saran_perbaikan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_menang ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nilai_kontrak_keseluruhan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nilai_perolehan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->klasifikasi_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->jenis_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->sistem_bayar ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nospk_external ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tglspk_internal ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tahun_ri_perolehan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    @switch($proyek->bulan_ri_perolehan)
                                                        @case('1')
                                                            Januari
                                                        @break

                                                        @case('2')
                                                            Februari
                                                        @break

                                                        @case('3')
                                                            Maret
                                                        @break

                                                        @case('4')
                                                            April
                                                        @break

                                                        @case('5')
                                                            Mei
                                                        @break

                                                        @case('6')
                                                            Juni
                                                        @break

                                                        @case('7')
                                                            Juli
                                                        @break

                                                        @case('8')
                                                            Agustus
                                                        @break

                                                        @case('9')
                                                            September
                                                        @break

                                                        @case('10')
                                                            Oktober
                                                        @break

                                                        @case('11')
                                                            November
                                                        @break

                                                        @case('12')
                                                            Desember
                                                        @break

                                                        @default
                                                            *Belum Ditentukan
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->nomor_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tanggal_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tanggal_mulai_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tanggal_akhir_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tanggal_selesai_pho ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->tanggal_selesai_fho ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->
                                            <!--begin::column-->
                                            <td class="text-start">
                                                <small>
                                                    {{ $proyek->laporan_terkontrak ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::column-->

                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table Proyek-->


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
    <!--end :: CONTENT-->


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



    <!--end::Main-->
    
    <!--begin::Javascript-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                initComplete: function(settings, json) {
                    const btns = document.querySelectorAll(".dt-buttons .dt-button");
                    btns.forEach(btn => {
                        btn.classList.add("btn");
                        btn.classList.add("btn-active-primary");
                    });
                    // const btnsCollection = document.querySelectorAll("div.dt-button-collection button.dt-button.active");
                    // console.log(btnsCollection);
                    // btnsCollection.forEach(btn => {
                    //     btn.classList.add("btn");
                    //     btn.classList.add("btn-active-primary");
                    // });
                },
                dom: 'lBfrtip',
                stateSave : true,
                scrollX : true,
                // iDisplayLength : 25,
                // pageLength : 500,
                // lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 5 ]
                        }
                    },
                    'colvis'
                ]
            } );
    } );
    </script>
    <!--end::Javascript-->

</body>
<!--end::Body-->


</html>