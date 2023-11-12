{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', $subtitle)
{{-- End::Title --}}

<style>
    .buttons-html5 {
        border-radius: 5px !important;
        border: none !important;
        font-weight: normal !important;
    }
    .buttons-colvis {
        border: none !important;
        border-radius: 5px !important;
    }
    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
        /* background-color: red !important; */
        --bs-table-accent-bg: #8ecae650 !important;
    }

    .table>:not(caption)>*>* {
        padding: 0.25rem 0.25rem !important;
    }

    .dataTables_filter{
        padding: 0 !important;
        margin-left: 5px !important;
        color: #B5B5C3;

    }
    
</style>


<!--begin::Main-->
@section('content')

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
                                <h1 class="d-flex align-items-center fs-3 my-1">{{ $subtitle }}
                                </h1>
                                <!--end::Title-->
                            </div>

                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_proyek" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button>

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
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
                                                {{-- <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"
                                                    id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button> --}}
                                                {{-- <a href="/proyek/export-proyek"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    id="kt_toolbar_export">
                                                    <i class="bi bi-download"></i>Export Excel
                                                </a> --}}
                                                <a target="_blank" href="/proyek-datatables/set"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Set Data - proyek
                                                </a>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div>
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
                    <div class="card mx-6" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 ps-6 pt-2 mb-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    {{-- <select id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $column == '' ? 'selected' : '' }}></option>
                                        <option value="nama_proyek" {{ $column == 'nama_proyek' ? 'selected' : '' }}>Nama Proyek</option>
                                        <option value="kode_proyek" {{ $column == 'kode_proyek' ? 'selected' : '' }}>Kode Proyek</option>
                                        <option value="tahun_perolehan" {{ $column == 'tahun_perolehan' ? 'selected' : '' }}>Tahun Perolehan</option>
                                        <option value="stage" {{$column == "stage" ? "selected" : ""}}>Stage</option>
                                        <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>
                                        <option value="tipe_proyek" {{$column == "tipe_proyek" ? "selected" : ""}}>Tipe Proyek</option>

                                    </select> --}}
                                    <!--End:: Select Options-->

                                    
                                    <!--begin:: Input Filter-->

                                    <!--begin::Select Options-->
                                    <div style="" id="filterTahun" class="d-flex align-items-center position-relative me-3">
                                        <select id="tahun-proyek" name="tahun-proyek"
                                            class="form-select form-select-solid select2-hidden-accessible mx-3"
                                            data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                            tabindex="-1" aria-hidden="true">
                                                <option value="">{{ $selected_year }}</option>
                                                @foreach ($tahun_proyeks as $tahun)
                                                    <option value="{{$tahun}}" {{$selected_year == $tahun ? "selected" : ""}}>{{$tahun}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <!--end::Select Options-->

                                    <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unitkerjas as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>
                                                    {{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div style="" id="filterStage" class="d-flex align-items-center position-relative">
                                        <select name="filter-stage"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilih Stage"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="1" {{ $filterStage == '1' ? 'selected' : '' }}>Pasar Dini
                                            </option>
                                            <option value="2" {{ $filterStage == '2' ? 'selected' : '' }}>Pasar Potensial
                                            </option>
                                            <option value="3" {{ $filterStage == '3' ? 'selected' : '' }}>Prakualifikasi
                                            </option>
                                            <option value="4" {{ $filterStage == '4' ? 'selected' : '' }}>Tender Diikuti
                                            </option>
                                            <option value="5" {{ $filterStage == '5' ? 'selected' : '' }}>Perolehan</option>
                                            <option value="6" {{ $filterStage == '6' ? 'selected' : '' }}>Menang</option>
                                            <option value="7" {{ $filterStage == '7' ? 'selected' : '' }}>Kalah</option>
                                            <option value="8" {{ $filterStage == '8' ? 'selected' : '' }}>Terkontrak
                                            </option>
                                            {{-- <option value="9" {{ $filterStage == '9' ? 'selected' : '' }}>Terendah</option> --}}
                                            {{-- <option value="10" {{ $filterStage == '10' ? 'selected' : '' }}>Selesai</option> --}}
                                        </select>
                                    </div>

                                    <div id="filterJenis" class="d-flex align-items-center position-relative">
                                        <select name="filter-jenis"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="I" {{ $filterJenis == 'I' ? 'selected' : '' }}>Internal</option>
                                            <option value="N" {{ $filterJenis == 'N' ? 'selected' : '' }}>External</option>
                                            <option value="J" {{ $filterJenis == 'J' ? 'selected' : '' }}>JO</option>
                                        </select>
                                    </div>

                                    <div id="filterTipe" class="d-flex align-items-center position-relative">
                                        <select name="filter-tipe"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Tipe Proyek"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="R" {{ $filterTipe == 'R' ? 'selected' : '' }}>Retail</option>
                                            <option value="P" {{ $filterTipe == 'P' ? 'selected' : '' }}>Non-Retail</option>
                                        </select>
                                    </div>
                                    <!--end:: Input Filter-->

                                        {{-- <div id="filter" class="d-flex align-items-center position-relative">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <input type="text" data-kt-customer-table-filter="search"
                                                name="filter" value="{{ $filter }}"
                                                class="form-control form-control-solid ms-2 ps-12 w-auto"
                                                placeholder="Input Filter" />
                                        </div> --}}

                                    <script>
                                        // function changes(e) {
                                        //     if (e.value == "stage") {
                                        //         // console.log(e);
                                        //         // window.location.href = "/proyek?column=stage";
                                        //         document.getElementById("filterStage").style.display = "";
                                        //         document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").value = "";
                                        //     } else if (e.value == "unit_kerja") {
                                        //         document.getElementById("filterUnit").style.display = "";
                                        //         document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").value = "";
                                        //     } else if (e.value == "jenis_proyek") {
                                        //         document.getElementById("filterJenis").style.display = "";
                                        //         document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").value = "";
                                        //     } else if (e.value == "tipe_proyek") {
                                        //         document.getElementById("filterTipe").style.display = "";
                                        //         document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filter").value = "";
                                        //     } else {
                                        //         document.getElementById("filter").style.display = "";
                                        //         document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterStage").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                        //         document.getElementById("filterTipe").style.setProperty("display", "none", "important");
                                        //     }
                                        // }
                                    </script>

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
                                            window.location.href = "/proyek";
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER-->
                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->

                        @php
                            $proyeks = $proyeks->reverse();
                        @endphp
                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body px-3 pt-0">
                            <!--begin::Table Proyek-->
                            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase text-sm gs-0">
                                        <th class="min-w-auto ps-3"><small>Kode Proyek</small></th>
                                        <th class="w-20"><small>Nama Proyek</small></th>
                                        <th class="min-w-auto"><small>Unit Kerja</small></th>
                                        <th class="min-w-auto text-center"><small>Stage</small></th>
                                        <th class="min-w-auto"><small>Tahun RA Perolehan</small></th>
                                        <th class="min-w-auto"><small>Bulan RA Perolehan</small></th>
                                        <th class="min-w-auto"><small>Nilai RKAP</small></th>
                                        <th class="min-w-auto"><small>Nilai Diluar RKAP</small></th>
                                        <th class="min-w-auto"><small>Nilai Forecast</small></th>
                                        <th class="min-w-auto"><small>Nilai Realisasi</small></th>
                                        <th class="min-w-auto"><small>Pelanggan</small></th>
                                        <th class="min-w-auto text-center"><small>Jenis Proyek</small></th>
                                        <th class="min-w-auto text-center"><small>Tipe Proyek</small></th>
                                        @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                            <th class="min-w-auto text-center"><small>Action</small></th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-800">
                                    @foreach ($proyeks as $proyek)
                                        <tr>
                                            <!--begin::Name-->
                                            <td class="ps-3">
                                                <small>
                                                    <a target="_blank" href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->kode_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Email-->
                                            <td>
                                                <small>
                                                    <a target="_blank" href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Email-->
                                            <!--begin::Company-->
                                            <td class="w-10" style="max-width: 120px">
                                                <small>
                                                    {{ $proyek->UnitKerja->unit_kerja }}
                                                </small>
                                            </td>
                                            <!--end::Company-->

                                            <!--begin::Stage-->
                                            @php
                                                if ($proyek->stage == 0 || $proyek->stage == 7 || $proyek->stage == 10 || $proyek->is_cancel ){
                                                    $stageColor = "badge-light-danger";
                                                } else if ($proyek->stage == 8 || $proyek->stage == 9){
                                                    $stageColor = "badge-light-success";
                                                } else {
                                                    $stageColor = "badge-light-primary";
                                                }                                                    
                                            @endphp
                                            <td class="text-center" style="max-width: 80px">
                                                @if ($proyek->is_cancel)
                                                <small class="badge fs-8 {{ $stageColor }}">
                                                    Canceled
                                                </small>
                                                @else
                                                <small class="badge {{ $stageColor }}">
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
                                                            Gugur PQ
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
                                                    $total_rkap = $proyek->Forecasts->filter(function($f) use($selected_year){
                                                        if($selected_year < (int) date("Y")) {
                                                            $month = 12;
                                                        } else {
                                                            $month = (int) date("m");
                                                        }
                                                        return $f->periode_prognosa == $month && $f->tahun == (int) $selected_year ;
                                                    })->sum(function($f) {
                                                        return (int) $f->rkap_forecast;
                                                    });
                                                } else {
                                                    $total_rkap = $proyek->nilai_rkap;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_rkap, 0, '.', '.') ?? '0' }}
                                                </small>
                                            </td>
                                            <!--end::Nilai OK-->
                                            <!--begin::Nilai OK-->
                                            <td class="text-end">
                                                @if ($proyek->is_rkap == true)
                                                    <small>
                                                        0
                                                    </small>
                                                @else
                                                    <small>
                                                        {{ number_format((int)$proyek->nilaiok_awal, 0, '.', '.') ?? '0' }}
                                                    </small>
                                                @endif
                                            </td>
                                            <!--end::Nilai OK-->

                                            <!--begin::Forecast-->
                                            <td class="text-end">
                                                @php
                                                    $total_forecast = $proyek->Forecasts->filter(function($f) use($selected_year){
                                                        $date = date_create($f->created_at);
                                                        if($selected_year < (int) date("Y")) {
                                                            $month = 12;
                                                        } else {
                                                            $month = (int) date("m");
                                                        }
                                                        return $f->periode_prognosa == $month && date_format($date, "Y") == $selected_year;
                                                    })->sum(function($f) {
                                                        return (int) $f->nilai_forecast;
                                                    });
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_forecast, 0, '.', '.') ?? '0' }}
                                                </small>
                                            </td>
                                            <!--end::Forecast-->
                                            
                                            <!--begin::Realisasi-->
                                            <td class="text-end">
                                                @php
                                                if ($proyek->stage == 8) {
                                                    $total_realisasi = $proyek->Forecasts->filter(function($f) use($selected_year){
                                                        if($selected_year < (int) date("Y")) {
                                                            $month = 12;
                                                        } else {
                                                            $month = (int) date("m");
                                                        }
                                                        return $f->periode_prognosa == $month && $f->tahun == (int) $selected_year ;
                                                    })->sum(function($f) {
                                                        return (int) $f->realisasi_forecast;
                                                    });
                                                } else {
                                                    $total_realisasi = 0;
                                                }
                                                @endphp
                                                <small>
                                                    {{ number_format((int)$total_realisasi, 0, '.', '.') ?? '0' }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi-->

                                            <!--begin::customer-->
                                            <td class="text-break text-start {{ $proyek->proyekBerjalan ? '' : 'text-danger' }} text-truncate" style="max-width: 120px">
                                                <small class="{{ $proyek->proyekBerjalan ? '' : 'badge badge-light-danger' }}">
                                                    {{-- {{ $proyek->proyekBerjalan->name_customer ?? "*Belum Ditentukan" }} --}}
                                                    @if ($proyek->proyekBerjalan)
                                                    <a target="_blank" href="/customer/view/{{ $proyek->proyekBerjalan->id_customer }}/{{ $proyek->proyekBerjalan->name_customer }}" class="text-gray-800 text-hover-primary">{{ $proyek->proyekBerjalan->name_customer }}</a>
                                                    @else
                                                    *Belum Ditentukan
                                                    @endif
                                                </small>
                                            </td>
                                            <!--end::customer-->

                                            <!--begin::Jenis Proyek-->
                                            <td class="text-center">
                                                <small>
                                                    {{ $proyek->jenis_proyek == "I" ? "Internal" : ($proyek->jenis_proyek == "N" ? "External" : "JO") }}
                                                </small>
                                            </td>
                                            <!--end::Jenis Proyek-->

                                            <!--begin::Tipe Proyek-->
                                            <td class="text-center">
                                                <small>
                                                    {{ $proyek->tipe_proyek == "R" ? "Retail" : "Non-Retail" }}
                                                </small>
                                            </td>
                                            <!--end::Tipe Proyek-->

                                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                                <!--begin::Action-->
                                                <td class="text-center px-3">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $proyek->kode_proyek }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-danger">Delete
                                                    </button>
                                                    </form>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action-->
                                            @endif
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


    <!--begin::Modal New Proyek-->
    <form action="/proyek/save" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New Proyek</h2>
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

                        <!--begin::Get Modal JS-->
                        <input type="hidden" class="modal-name" name="modal-name">
                        <!--end::Get Modal JS-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-12">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid char-counter" data-max-char="40" id="nama-proyek"
                                        name="nama-proyek" value="{{ old('nama-proyek') }}" placeholder="Nama Proyek" />
                                    <div class="d-flex flex-row justify-content-end">
                                        <small class="">0/40</small>
                                    </div>
                                    @error('nama-proyek')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--Begin::Row Kanan-->
                        <div class="row fv-row">
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Unit Kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    @php
                                        $unit_kerja = str_contains(Auth::user()->unit_kerja, ",") ? collect(explode(",", Auth::user()->unit_kerja)) : Auth::user()->unit_kerja;
                                    @endphp
                                    <select name="unit-kerja" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja" onchange="setDepartemen(this)">
                                        <option></option>
                                        @foreach ($unitkerjas as $unitkerja)
                                            <option value="{{ $unitkerja->divcode }}"
                                                {{ old('unit-kerja') == $unitkerja->divcode ? 'selected' : '' }} {{ Auth::user()->unit_kerja == $unitkerja->divcode ? 'selected' : '' }}>
                                                {{ $unitkerja->unit_kerja }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit-kerja')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                            <div class="col-6" id="div-departemen" style="visibility: hidden">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Departemen</span>
                                    </label>
                                    <select name="departemen-proyek" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Departemen Proyek" id="departemen-proyek">
                                    <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            async function setDepartemen(e){
                                const data = e.value;
                                let html = '<option value=""></option>'
                                // console.log(data)
                                if(data == "H" || data == "G" || data == "P" || data == "J"){
                                    document.getElementById("div-departemen").style.visibility = ''
                                    let departemenElt = document.getElementById("departemen-proyek");
                                    const response = await fetch(`/proyek/get-departemen/${data}`, {
                                        method: 'GET',
                                    }).then(result => result.json())
    
                                    response.data.forEach(data => {
                                        html += `<option value="${data.kode_departemen}">${data.nama_departemen}</option>`
                                    });
                                    
                                    departemenElt.innerHTML = html;
                                }else{
                                    document.getElementById("div-departemen").style.visibility = "hidden";
                                    document.getElementById("div-departemen").style.value = null;
                                }

                                // console.log(response)

                                // then((data)=>{
                                //     // console.log(data)
                                //     if(data.status == "success"){
                                //         const departemen = data.data
                                //         // console.log(departemen)
                                //         const departemenEach = departemen.forEach(function(item, key, arr)=>{
                                //             // console.log()
                                //             // return item
                                //            arr[key] =  document.createElement("option");
                                //            option[key].text = item.nama_departemen
                                //            option[key].value = item.kode_departemen
                                //            departemenElt.add(option)
                                //         })
                                //         console.log(departemenEach)
                                //     }else{
                                //         // departemenElt.innerHTML = ""
                                //         // departemenElt.value = ""
                                //     }
                                // }).catch((err)=>{
                                //     console.log(err)
                                // })
                                // console.log(departemenElt)
                            }
                        </script>
                        <!--ENd::Row Kanan-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jenis Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="jenis-proyek" onchange="tampilJOCategory(this)" name="jenis-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek">
                                        {{-- <option selected></option>
                                        <option value="I" {{ old('jenis-proyek') == 'I' ? 'selected' : '' }}>
                                            Internal</option>
                                        <option value="N" {{ old('jenis-proyek') == 'N' ? 'selected' : '' }}>
                                            External</option>
                                        <option value="J" {{ old('jenis-proyek') == 'J' ? 'selected' : '' }}>
                                            JO</option> --}}
                                        <option></option>
                                        @foreach ($jenisProyek as $jenis)
                                            <option value="{{ $jenis->kode_jenis }}"
                                                {{ old('jenis-proyek') == $jenis->kode_jenis ? 'selected' : '' }}>
                                                {{ $jenis->jenis_proyek }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis-proyek')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Tipe Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select onchange="proyekRetail(this)" id="tipe-proyek" name="tipe-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tipe Proyek">
                                        {{-- <option selected></option>
                                        <option value="R" {{ old('tipe-proyek') == 'R' ? 'selected' : '' }}>
                                            Retail</option>
                                        <option value="P" {{ old('tipe-proyek') == 'P' ? 'selected' : '' }}>
                                            Non-Retail</option> --}}
                                        <option></option>
                                        @foreach ($tipeProyek as $tipe)
                                            <option value="{{ $tipe->kode_tipe }}"
                                                {{ old('tipe-proyek') == $tipe->kode_tipe ? 'selected' : '' }}>
                                                {{ $tipe->tipe_proyek }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipe-proyek')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <script>
                            function proyekRetail(e) {
                                // console.log(e.value);
                                if (e.value == "R") {
                                    document.getElementById('div-rkap').style.visibility = "hidden";
                                    document.getElementById('nilai-rkap').style.value = null;
                                } else {
                                    document.getElementById('div-rkap').style.visibility = "";
                                }                                
                            }

                        </script>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6" style="visibility: hidden">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7" id="input-jo-detail" style="display: none;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori JO</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="kategori-jo" name="kategori-jo" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilih JO">
                                        <option selected></option>
                                        <option value="30" {{ old('kategori-jo') == "30"  ? 'selected' : '' }}>JO Integrated Leader</option>
                                        <option value="31" {{ old('kategori-jo') == "31" ? 'selected' : '' }}>JO Integrated Member</option>
                                        <option value="40" {{ old('kategori-jo') == "40" ? 'selected' : '' }}>JO Portion Leader</option>
                                        <option value="41" {{ old('kategori-jo') == "41" ? 'selected' : '' }}>JO Portion Member</option>
                                        <option value="50" {{ old('kategori-jo') == "50" ? 'selected' : '' }}>JO Mix Integrated - Portion</option>
                                        {{-- @foreach ($sumberdanas as $sumberdana)
                                            <option value="{{ $sumberdana->nama_sumber }}"
                                        @endforeach --}}
                                    </select>
                                    @error('kategori-jo')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div id="div-rkap" class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nilai OK (Exclude Ppn)</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid reformat"
                                        id="nilai-rkap" name="nilai-rkap" value="{{ old('nilai-rkap') }}"
                                        placeholder="Nilai OK (Exclude Ppn)" />
                                    @error('nilai-rkap')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">RA Tahun Perolehan</span>
                                    </label>
                                    <!--end::Label-->
                                    @php
                                        $years = (int) date('Y');
                                        $bulans = (int) date('m');
                                        // dd($bulans);
                                    @endphp
                                    <!--begin::Input-->
                                    <select id="tahun-perolehan" name="tahun-perolehan"
                                        class="form-select form-select-solid select2-hidden-accessible" onchange="validationRAPerolehan(this)"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        @for ($i = 2021; $i < $years + 10; $i++)
                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('tahun-perolehan')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">RA Bulan Perolehan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="bulan-pelaksanaan" name="bulan-pelaksanaan"
                                        class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Bulan Pelaksanaan">
                                        <option></option>
                                        <option value="1" {{ $bulans == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ $bulans == 2 ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ $bulans == 3 ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ $bulans == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ $bulans == 5 ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ $bulans == 6 ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ $bulans == 7 ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ $bulans == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ $bulans == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $bulans == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $bulans == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $bulans == 12 ? 'selected' : '' }}>Desember</option>
                                    </select>
                                    @error('bulan-pelaksanaan')
                                        <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Pelanggan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="customer" name="customer"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="false"
                                        data-placeholder="Pilih Customer">
                                        <option></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id_customer }}"> {{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                style="background-color:#008CB4" id="proyek_new_save">Save</button>
                        </div>
                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::Modal New Proyek-->

    <!--begin::modal DELETE-->
    @foreach ($proyeks as $proyek)
        <form action="/proyek/delete/{{ $proyek->kode_proyek }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $proyek->kode_proyek }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}
                            </h2>
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
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::modal DELETE-->


@endsection
@section('js-script')
    <!--begin::Data Tables-->
    {{-- <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start me-3"f><"#example"t>Brtip',
                pageLength : 15,
                order: [[0, 'desc']],
                // scrollY : "1000px",
                // scrollX : true,
                // scrollCollapse: true,
                // paging : false,
                // fixedColumns:   {
                //     left: 2,
                //     right: 0
                // },
                buttons: [
                    'csv', 'excel', 'print'
                    // 'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    <!--end::Data Tables-->
    
    <script>
    $('#kt_modal_create_proyek').on('show.bs.modal', function() {
        $("#customer").select2({
            dropdownParent: $("#kt_modal_create_proyek")
        });
    });
    let isYearValidated = false;
    async function validationRAPerolehan(e) {
        const selectedYear = e.options[e.selectedIndex].text;
        const currentYear = new Date().getFullYear();
        if(selectedYear < currentYear && !isYearValidated) {
            const resultDialog = await Swal.fire({
                title: 'Anda yakin ingin memilih tahun sebelum tahun sekarang?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
                }).then((result) => {
                if (result.isConfirmed) {
                    $(e).val(selectedYear);
                    $(e).select2({
                        minimumResultsForSearch: -1
                    });
                    isYearValidated = true;
                } else {
                    $(e).val("2022");
                    $(e).select2({
                        minimumResultsForSearch: -1
                    });
                }
                return isYearValidated;
            });
            isYearValidated = resultDialog;
        } else {
            isYearValidated = false;
        }
    }
</script>

{{-- Begin :: JO Detail Modal Pop Up --}}
<script>
    const modalJODetail = document.querySelector("#input-jo-detail");
    const inputSelectJODetailElt = modalJODetail.querySelector("#kategori-jo");
    function tampilJOCategory(e) {
        const valueJO = e.value;
        if(valueJO == "J") {
            modalJODetail.style.display = "";
            inputSelectJODetailElt.disabled = "";
        } else {
            modalJODetail.style.display = "none";
            inputSelectJODetailElt.disabled = "true";
        }
    }
</script>
{{-- End :: JO Detail Modal Pop Up --}}

{{-- Begin :: JO Detail Save --}}
{{-- <script>
    function changeValueJODetail(e) {
        const selectJOElt = e.parentElement.parentElement.querySelector("select");
        const valueJODetail = {value: selectJOElt.value, text: selectJOElt.options[selectJOElt.selectedIndex].text};
        const inputJODetail = document.querySelector("#jo-category");
        const textJODetail = inputJODetail.parentElement.querySelector("small");
        inputJODetail.value = valueJODetail.value;
        textJODetail.innerHTML = `JO Category: <b>${valueJODetail.text}</b>`;
        modalJODetail.hide();
    }
</script> --}}
{{-- End :: JO Detail Save --}}
@endsection

<!--end::Main-->
