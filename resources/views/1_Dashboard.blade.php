{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Dashboard')
{{-- End::Title --}}

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
                    <div style=" height:75px" class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 row">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard
                                </h1>
                                <div class="row">
                                    <div class="col">
                                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                            <!--begin:::Tab item Forecast Bulanan-->
                                            @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                                <li class="nav-item">
                                                    <a onclick="showCRM()" class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                        href="#kt_view_dashboard_crm" style="font-size:14px;">Dashboard CRM</a>
                                                </li>
                                            @endif
                                            <!--end:::Tab item Forecast Bulanan-->

                                            <!--begin:::Tab item Forecast Internal-->
                                            @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                                                <li class="nav-item">
                                                    <a onclick="showCCM()" class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                        data-bs-toggle="tab" href="#kt_view_dashboard_ccm"
                                                        style="font-size:14px;">Dashboard CCM</a>
                                                </li>
                                            @endif
                                            <!--end:::Tab item Forecast Internal-->
                                        </ul>
                                        <script>
                                            function showCRM() {
                                                document.querySelector("#kt_view_dashboard_crm").style.display = "";
                                                document.querySelector("#kt_view_dashboard_ccm").style.display = "none";
                                            }
                                            function showCCM() {
                                                document.querySelector("#kt_view_dashboard_crm").style.display = "none";
                                                document.querySelector("#kt_view_dashboard_ccm").style.display = "";
                                            }
                                        </script>
                                    </div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            {{-- <div class="d-flex align-items-center py-1">
                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
                                        Filter</a>
                                    <a href="#" class="btn btn-sm btn-light btn-active-primary w-80px me-4" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"
                                        style="padding: 6px; margin-left:10px">
                                        Reset</a>
                                    <!--end::Button-->
                                </div> --}}
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header py-1">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <form action="/dashboard" class="d-flex flex-row " method="get">
                                    @if (Auth::user()->check_administrator)
                                        <!-- Begin :: Select Options Unit Kerja -->
                                        <select onchange="selectDOP(this)" id="dop" name="dop"
                                            class="form-select form-select-solid w-auto"
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                            data-placeholder="Direktorat" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="" {{$dop_get == "" ? "selected" : ""}}></option>
                                            @foreach ($dops as $dop)
                                                <option value="{{ $dop->dop }}" {{ $dop_get == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option>
                                            @endforeach
                                        </select>
                                        <!-- End :: Select Options Unit Kerja -->
                                        <script>
                                            function selectDOP(e) {
                                                document.getElementById("unit-kerja").value = "";
                                                e.form.submit();
                                            }
                                            </script>
                                    @endif
                                        <!-- Begin :: Select Options Unit Kerja -->
                                        <select onchange="selectUnitKerja(this)" id="unit-kerja" name="unit-kerja"
                                            class="form-select form-select-solid w-auto ms-2"
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                            data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="" {{$unit_kerja_get == "" ? "selected" : ""}}></option>
                                            @foreach ($unitKerja as $unit_kerja)
                                            @php
                                                    $is_unit_kerja_selected = $unit_kerja_get == $unit_kerja->divcode ? 'selected' : '';
                                                    @endphp
                                                <option value="{{ $unit_kerja->divcode }}" {{ $is_unit_kerja_selected }} >{{ $unit_kerja->unit_kerja }}</option>
                                                @endforeach
                                            </select>
                                            @if (Auth::user()->check_user_sales)
                                            <script>
                                                function selectUnitKerja(e) {
                                                e.form.submit();
                                            }
                                            </script>
                                            @endif
                                            @if (Auth::user()->check_administrator)
                                            <script>
                                                function selectUnitKerja(e) {
                                                document.getElementById("dop").value = "";
                                                e.form.submit();
                                            }
                                            </script>
                                            @endif
                                        <!-- End :: Select Options Unit Kerja -->

                                    <!--begin::Select Options-->
                                    <select onchange="this.form.submit()" id="periode-prognosa" name="periode-prognosa"
                                        class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                        style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                        data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $month == '' ? 'selected' : '' }}></option>
                                        <option value="1" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
                                    </select>
                                    <!--end::Select Options-->
                                    @php
                                        $years = (int) date('Y');
                                        // $day = (int) date("d");
                                        // $year = 2030 ;
                                    @endphp
                                    <!--begin::Select Options-->
                                    <select onchange="this.form.submit()" id="tahun-history" name="tahun-history"
                                        class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        @if ($year == null)
                                            @for ($i = $years - 2; $i < $years + 10; $i++)
                                                <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        @else
                                            @for ($i = $year - 2; $i < $year + 10; $i++)
                                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                    <!--end::Select Options-->

                                    <!--begin::Action Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/dashboard";
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--begin::RESET FILTER-->
                                {{-- <script>
                                    function resetFilter() {
                                        $("#periode-prognosa").select2({
                                            minimumResultsForSearch: -1
                                        }).val("").trigger("change");

                                        $("#tahun-history").select2({
                                            minimumResultsForSearch: -1
                                        }).val(Number(new Date().getFullYear())).trigger("change");

                                        $("#unit-kerja").select2({}).val("").trigger("change");
                                    }
                                </script> --}}
                                <!--end::RESET FILTER-->
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->

                        <br>

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="tab-pane fade {{ auth()->user()->check_admin_kontrak ? '' : 'show active' }}" id="kt_view_dashboard_crm" role="tabpanel">
                                @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                    <!--begin::FORECAST LINE CHART-->
                                    <figure class="highcharts-figure py-12">
                                        <div id="forecast-line" style="display:">
                                        </div>
                                        <!--begin::Table Proyek-->
                                        <div class="" id="datatable" style="display: none">
                                            <hr>
                                            <div class="text-center">
                                                <h2 id="title-table"></h2>
                                                <h4 id="total"></h4>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('#datatable','#forecast-line')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                                <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i class="bi bi-download"></i> Export Excel</a>
                                                <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                                    onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                        class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                            </div>
                                            <br>
                                            <div class="" style="max-height: 500px; overflow-y:scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-white" id="table-line-head" style="position: sticky; top: 0">
                                                        {{-- THead Here --}}
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold" id="table-line-body">
                                                        {{-- Data Here --}}
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table Proyek-->
                                        </div>
                                    </figure>
                                    <!--end::FORECAST LINE CHART-->
                                    <hr>

                                    {{-- <figure class="highcharts-figure py-12">
                                        <div class="py-12" id="forecast-3wulan">
                                            <!--begin::FORECAST 3 WULAN CHART-->
                                            <!--end::FORECAST 3 WULAN CHART-->
                                        </div>

                                        <!-- Begin :: Data Table Triwulan -->
                                        <div class="" id="datatable-triwulan" style="display:none;">
                                            <hr>
                                            <div class="text-center">
                                                <h2 id="title-table"></h2>
                                                <h4 id="total"></h4>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('#datatable-triwulan','#forecast-3wulan')"><i class="bi bi-graph-up-arrow fs-6"></i> Show
                                                    Chart</button>
                                                <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                                    onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                        class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                <!-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> -->
                                            </div>
                                            <br>
                                            <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                <!--begin::Table head-->
                                                <thead id="table-line-head">
                                                    <!-- THead Here -->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold" id="table-line-body">
                                                    <!-- Data Here -->
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table Proyek-->
                                        </div>
                                        <!-- End :: Data Table Triwulan -->
                                    </figure>
                                    <hr> --}}

                                    <figure class="highcharts-figure py-12" style="display:none;">
                                        <div class="py-12" id="nilai-realisasi">
                                            <!--begin::NILAI REALISASI-->
                                            <!--end::NILAI REALISASI-->
            
                                        </div>
                                        <div class="" id="datatable-realisasi" style="display: none;max-height: 500px; overflow-y:scroll">
                                            <hr>
                                            <div class="text-center">
                                                <h2 id="title-table"></h2>
                                                <h4 id="total"></h4>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('#datatable-realisasi','#nilai-realisasi')"><i class="bi bi-graph-up-arrow fs-6"></i> Show
                                                    Chart</button>
                                                <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                                    onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                        class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                            </div>
                                            <br>
                                            <div class="" style="max-height: 500px; overflow-y:scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead id="table-line-head" style="position: sticky; top: 0">
                                                        {{-- THead Here --}}
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold" id="table-line-body">
                                                        {{-- Data Here --}}
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table Proyek-->
                                        </div>
                                    </figure>
                                    {{-- <hr> --}}

                                    <figure class="highcharts-figure py-12">
                                        <div class="py-12" id="monitoring-proyek">
                                            <!--begin::MONITORING PROYEK-->
                                            <!--end::MONITORING PROYEK-->
                                        </div>
                                        <div class="" id="datatable-monitoring-proyek" style="display: none;">
                                            <hr>
                                            <div class="text-center">
                                                <h2 id="title-table"></h2>
                                                <h4 id="total"></h4>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('#datatable-monitoring-proyek','#monitoring-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                                <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i class="bi bi-download"></i> Export Excel</a>
                                                <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                                    onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                        class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                            </div>
                                            <br>
                                            <div class="" style="max-height: 500px; overflow-y:scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead id="table-line-head" class="bg-white" style="position: sticky; top: 0">
                                                        {{-- THead Here --}}
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold" id="table-line-body">
                                                        {{-- Data Here --}}
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table Proyek-->
                                        </div>
                                    </figure>
                                    <hr>
                                    
                                    <figure class="highcharts-figure py-12">
                                        <div class="py-12" id="terendah-terkontrak">
                                            <!--begin::TERENDAH - TERKONTRAK-->
                                            <!--end::TERENDAH - TERKONTRAK-->
                                        </div>
                                        <div class="" id="datatable-terendah-terkontrak" style="display: none;">
                                            <hr>
                                            <div class="text-center">
                                                <h2 id="title-table"></h2>
                                                <h4 id="total"></h4>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('#datatable-terendah-terkontrak','#terendah-terkontrak')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                                <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i class="bi bi-download"></i> Export Excel</a>
                                                <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                                    onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                        class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                            </div>
                                            <br>
                                            <div class="" style="max-height: 500px; overflow-y:scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead id="table-line-head" class="bg-white" style="position: sticky; top: 0">
                                                        {{-- THead Here --}}
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold" id="table-line-body">
                                                        {{-- Data Here --}}
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table Proyek-->
                                        </div>
                                    </figure>
                                    <hr>

                                    <div class="row">
                                        <div class="col py-12" id="index-jumlah">
                                            <!--begin::INDEX JUMLAH-->
                                            <!--end::INDEX JUMLAH-->
                                        </div>
                                        <span class="vr" style="padding: 0.5px"></span>
                                        <div class="col py-12" id="index-nilai">
                                            <!--begin::INDEX NILAI-->
                                            <!--end::INDEX NILAI-->
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    {{-- <div class="row">
                                        <div class="col py-12" id="sumber-dana-rkap">
                                            <!--begin::INDEX JUMLAH-->
                                            <!--end::INDEX JUMLAH-->
                                        </div>
                                        <span class="vr" style="padding: 0.5px"></span>
                                        <div class="col py-12" id="sumber-dana-realisasi">
                                            <!--begin::INDEX NILAI-->
                                            <!--end::INDEX NILAI-->
                                        </div>
                                    </div>
                                    <hr> --}}
                                    
                                    <div class="px-8 py-12" id="pareto-proyek">
                                        <h1 class="text-center bold pb-8">
                                            Pareto Proyek
                                        </h1>

                                        <!--begin::Table pareto proyek  -->
                                        <div class="tab-content" id="myTabContent">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <a href="/download-pareto" target="_blank" class="btn btn-sm btn-light btn-active-primary fs-6 mb-5"><i class="bi bi-download"></i> Export Excel</a>
                                            </div>
                                            <!--begin::Table-->
                                            <div class="" style="max-height: 750px; overflow-y:scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead class="bg-white" style="position: sticky; top:0">
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">@sortablelink('nama_proyek', 'Nama Proyek')</th>
                                                            <th class="min-w-auto">@sortablelink('unit_kerja', 'Unit Kerja')</th>
                                                            <th class="min-w-auto">@sortablelink('stage', 'Stage')</th>
                                                            <th class="min-w-auto text-end">@sortablelink('forecast', 'Nilai Forecast')</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold">
                                                        @foreach ($paretoProyek as $proyek)
                                                            {{-- @foreach ($proyek as $proyek) --}}
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                                </td>
                                                                <!--end::Name-->
                                                                <!--begin::Unit Kerja-->
                                                                <td>
                                                                    <a href="#" id="" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->UnitKerja->unit_kerja ?? "-" }}</a>
                                                                </td>
                                                                <!--end::Unit Kerja-->
    
                                                                <!--end::Stage-->
                                                                <td>
                                                                    @switch($proyek->stage)
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
    
                                                                        @default
                                                                            Selesai
                                                                    @endswitch
                                                                </td>
                                                                <!--end::Stage-->
    
                                                                <!--begin::Nilai Forecast-->
                                                                <td class="text-end">
                                                                    {{-- @php
                                                                        $nilaiForecast = 0;
                                                                        foreach ($proyek->Forecasts as $forecast)
                                                                        if ($forecast->nilai_forecast != "") {
                                                                            $nilaiForecast += $forecast->nilai_forecast;
                                                                        }
                                                                    @endphp --}}
                                                                    {{-- {{ number_format($nilaiForecast, 0, '.', ',') }} --}}
                                                                    {{-- @foreach ($proyek->Forecasts as $forecast)
                                                                            {{ $forecast->nilai_forecast }};
                                                                            @endforeach --}}
                                                                    {{-- {{ number_format($proyek->forecast, 0, '.', ',') }} --}}
                                                                    {{ number_format((int) str_replace('.', '', $proyek->nilai_perolehan), 0, '.', '.') }}
                                                                </td>
                                                                <!--end::Nilai Forecast-->
                                                            </tr>
                                                            {{-- @endforeach --}}
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <!--end::Table -->
                                            {{-- {{ $paretoClaim->links() }} --}}
                                            {{-- {!! $paretoClaim->append(Request::except('page'))->render() !!} --}}
                                        </div>
                                        <!--end::Table pareto proyek-->
                                    </div>
                                    <hr>
                                @endif
                            </div> 

                            <div class="tab-pane fade {{ auth()->user()->check_admin_kontrak ? 'show active' : '' }}" id="kt_view_dashboard_ccm" role="tabpanel" style="{{ auth()->user()->check_administrator ? 'display : none' : '' }}">
                                @if (auth()->user()->check_administrator || auth()->user()->check_admin_kontrak)
                                    <div class="py-12" id="marketing-pipeline">
                                        <!--begin::MARKETING PIPELINE-->
                                        <!--end::MARKETING PIPELINE-->
                                    </div>
                                    <hr>

                                    <div class="py-12" id="claim">
                                        <!--begin::STATUS CLAIM-->
                                        <!--end::STATUS CLAIM-->
                                    </div>
                                    <hr>

                                    <!--begin:: PARETO-->

                                    <div class="px-8 pb-18 py-12">
                                        <h1 class="text-center bold">
                                            Claim Management dan Change Request
                                        </h1>
                                        <!--begin::Tabs Navigasi-->
                                        <ul
                                            class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                            <!--begin:::Tab item Claim-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                    href="#kt_user_view_claim" style="font-size:14px;">Claim</a>
                                            </li>
                                            <!--end:::Tab item Claim-->

                                            <!--begin:::Tab item Anti Claim-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_anticlaim"
                                                    style="font-size:14px;">Anti Claim</a>
                                            </li>
                                            <!--end:::Tab item Anti Claim-->

                                            <!--begin:::Tab item -->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_asuransi"
                                                    style="font-size:14px;">Change Request</a>
                                            </li>
                                            <!--end:::Tab item -->
                                        </ul>
                                        <!--end::Tabs Navigasi-->


                                        <!--begin::Table Pannel Claim  -->
                                        <div class="tab-content" id="myTabContent">
                                            <!--begin::Pareto Claim-->
                                            <div class="tab-pane fade show active" id="kt_user_view_claim" role="tabpanel">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Nama Proyek')</th>
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Unit Kerja')</th>
                                                            <th class="min-w-auto">@sortablelink('nilai_claim', 'Nilai Claim')</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold">
                                                        @foreach ($paretoClaim as $claim)
                                                            {{-- @foreach ($claim as $claim) --}}
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $claim->first()->project->kode_proyek }}/Claim" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->nama_proyek }}</a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Unit Kerja-->
                                                                <td>
                                                                    <a href="#" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->UnitKerja->unit_kerja }}</a>
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Nilai Claim-->
                                                                <td>
                                                                    @php
                                                                        $nilaiClaim = 0;
                                                                        foreach ($claim as $nilai) {
                                                                            if ($nilai->nilai_claim != '') {
                                                                                $nilaiClaim += $nilai->nilai_claim;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{ number_format($nilaiClaim, 0, '.', ',') }}
                                                                </td>
                                                                <!--end::Nilai Claim-->
                                                            </tr>
                                                            {{-- @endforeach --}}
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table -->
                                                {{-- {{ $paretoClaim->links() }} --}}
                                                {{-- {!! $paretoClaim->append(Request::except('page'))->render() !!} --}}
                                            </div>
                                            <!--end::Pareto Claim-->

                                            <!--begin:::Pareto Anti Claim-->
                                            <div class="tab-pane fade" id="kt_user_view_anticlaim" role="tabpanel">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Nama Proyek')</th>
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Unit Kerja')</th>
                                                            <th class="min-w-auto">@sortablelink('nilai_claim', 'Nilai Anti Claim')</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold">
                                                        @foreach ($paretoAntiClaim as $claim)
                                                            {{-- @foreach ($claim as $claim) --}}
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $claim->first()->project->kode_proyek }}/Anti-Claim" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->nama_proyek }}</a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Unit Kerja-->
                                                                <td>
                                                                    <a href="#" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->UnitKerja->unit_kerja }}</a>
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Nilai Claim-->
                                                                <td>
                                                                    @php
                                                                        $nilaiClaim = 0;
                                                                        foreach ($claim as $nilai) {
                                                                            if ($nilai->nilai_claim != '') {
                                                                                $nilaiClaim += $nilai->nilai_claim;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{ number_format($nilaiClaim, 0, '.', ',') }}
                                                                </td>
                                                                <!--end::Nilai Claim-->
                                                            </tr>
                                                            {{-- @endforeach --}}
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table -->
                                            </div>
                                            <!--end:::Pareto Anti Claim-->

                                            <!--begin:::Pareto Asuransi-->
                                            <div class="tab-pane fade" id="kt_user_view_asuransi" role="tabpanel">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Nama Proyek')</th>
                                                            <th class="min-w-auto">@sortablelink('kode_proyek', 'Unit Kerja')</th>
                                                            <th class="min-w-auto">@sortablelink('nilai_claim', 'Nilai Change Request')</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-800">
                                                        @foreach ($paretoAsuransi as $claim)
                                                            {{-- @foreach ($claim as $claim) --}}
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $claim->first()->project->kode_proyek }}/Claim-Asuransi" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->nama_proyek }}</a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Unit Kerja-->
                                                                <td>
                                                                    <a href="#" id=""
                                                                        class="text-gray-800 text-hover-primary mb-1">{{ $claim->first()->project->UnitKerja->unit_kerja }}</a>
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Nilai Claim-->
                                                                <td>
                                                                    @php
                                                                        $nilaiClaim = 0;
                                                                        foreach ($claim as $nilai) {
                                                                            if ($nilai->nilai_claim != '') {
                                                                                $nilaiClaim += $nilai->nilai_claim;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{ number_format($nilaiClaim, 0, '.', ',') }}
                                                                </td>
                                                                <!--end::Nilai Claim-->
                                                            </tr>
                                                            {{-- @endforeach --}}
                                                        @endforeach
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table -->
                                            </div>
                                            <!--end:::Pareto Asuransi-->

                                        </div>
                                        <!--end::Table Pannel Claim-->
                                    </div>
                                    <!--end::: PARETO-->
                                    <hr>

                                @endif
                            </div>
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


@endsection
{{-- End::Main --}}
@section('js-script')
    <!--begin::CDN High Chart-->
    <script src="/js/highcharts/highcharts.js"></script>
    <script src="/js/highcharts/series-label.js"></script>
    <script src="/js/highcharts/exporting.js"></script>
    <script src="/js/highcharts/export-data.js"></script>
    <script src="/js/highcharts/drilldown.js"></script>
    <script src="/js/highcharts/funnel.js"></script>
    <script src="/js/highcharts/accessibility.js"></script>
    <script src="/js/highcharts/highcharts-3d.js"></script>
    <!--end::CDN High Chart-->

    <!--begin::FORECAST LINE-->
    <script>
        let nilaiForecast = JSON.parse("{!! json_encode($nilaiForecastArray) !!}");
        let nilaiRkap = JSON.parse("{!! json_encode($nilaiRkapArray) !!}");
        let nilaiRealisasi = JSON.parse("{!! json_encode($nilaiRealisasiArray) !!}");
        // console.log(nilaiRkap);

        const forecast1 = Highcharts.chart('forecast-line', {

            title: {
                text: '<b class="h1">Forecast per BULAN (Dalam Jutaan)</b>'
            },

            // subtitle: {
            //     text: '2022'
            // },

            yAxis: {
                title: {
                    text: ''
                }
            },

            xAxis: {
                categories: [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember",
                ],
                // accessibility: {
                //     rangeDescription: 'Range: 2010 to 2017'
                // }
            },

            colors: ["#46AAF5", "#F7C13E", "#61CB65", "#ED6D3F", "#9575CD"],
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                format : '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize:'20px',
                    // font: '20pt Trebuchet MS, Verdana, sans-serif',
                    // color: '#A0A0A0'
                },
            },

            
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return Intl.NumberFormat(["id"]).format(this.y);
                        }
                    }
                // allowPointSelect: true
                },
                // label: {
                //     connectorAllowed: false
                // },
            },
            
            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: '<span style="color:{series.color}">\u25CF</span>{point.y}'
            },

            series: [{
                    name: 'Nilai OK ' + nilaiRkap[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                    data: nilaiRkap,
                },
                {
                    name: 'Forecast ' + nilaiForecast[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                    data: nilaiForecast,
                },
                {
                    name: 'Nilai Realisasi ' + nilaiRealisasi[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                    data: nilaiRealisasi,
                },
                // {
                //     name: 'Nilai OK Review ' + nilaiForecast[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                //     data: nilaiForecast,
                // }
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom',
                        }
                    }
                }]
            },

            credits: {
                enabled: false
            },
        });
    </script>
    <!--end::FORECAST LINE-->

    <!--begin::FORECAST 3WULAN-->
    {{-- <script>
        let forecast3Wulan = JSON.parse("{!! json_encode($nilaiForecastTriwunalArray) !!}");

        Highcharts.chart('forecast-3wulan', {

            title: {
                text: '<b class="h1">Forecast per 3 BULAN</b>'
            },

            subtitle: {
                text: ' '
            },

            yAxis: {
                title: {
                    text: ' '
                }
            },

            xAxis: {
                categories: [
                    "Januari-Maret",
                    "April-Juni",
                    "Juli-September",
                    "Oktober-Desember",
                ],
                // accessibility: {
                //     rangeDescription: 'Range: 2010 to 2017'
                // }
            },

            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            legend: {
                // layout: 'vertical',
                // align: 'right',
                // verticalAlign: 'middle'
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            },

            plotOptions: {
                series: {
                    allowPointSelect: true
                }
                //     label: {
                //         connectorAllowed: false
                //     },
                //     pointStart: 2021
            },

            series: [{
                name: 'Forecast',
                data: forecast3Wulan
                // }, 
                // {
                //     name: 'Nilai OK',
                //     data: [6491600000, 15406400000, 49742000000, 60851000000],
                // }, 
                // {
                //     name: 'Nilai Realisasi',
                //     data: [1174400000, 6772200000, 16005000000, 22077100000],
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
            },

            credits: {
                enabled: false
            },

        });
    </script> --}}
    <!--end::FORECAST 3WULAN-->

    <!--begin::NILAI REALISASI-->
    {{-- <script>
        let kategoriunitKerja = {!! json_encode($kategoriunitKerja) !!};
        let arrayNilaiOk = {!! json_encode($nilaiOkKumulatif) !!};
        let nilaiOkKumulatif = arrayNilaiOk.map(nilaiOKsatuan => nilaiOKsatuan / 1000000);
        let sumNilaiOk = nilaiOkKumulatif.reduce((a, b) => a + b, 0);
        let arrayNilaiRealisasi = {!! json_encode($nilaiRealisasiKumulatif) !!};
        let nilaiRealisasiKumulatif = arrayNilaiRealisasi.map(nilaiRealsatuan => nilaiRealsatuan / 1000000);
        let sumNilaiRealisasi = nilaiRealisasiKumulatif.reduce((a, b) => a + b, 0);
        // console.log(nilaiOkKumulatif);
        // console.log(nilaiOkKumulatif.map(nilaiOKsatuan => nilaiOKsatuan / 1000000));
        Highcharts.chart('nilai-realisasi', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 5,
                    beta: 15,
                    viewDistance: 50,
                    depth: 100
                }
            },
            title: {
                text: '<b class="h1">Nilai Realisasi OK per Divisi dan EA (Dalam Jutaan)</b>'
            },
            xAxis: {
                categories: kategoriunitKerja,
                // categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'],
                labels: {
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: '',
                    skew3d: true
                }
            },
            tooltip: {
                headerFormat: '<b>{point.key}</b><br>',
                pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y}'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true
                    }
                },
                // column: {
                //     stacking: 'normal',
                //     depth: 40
                // }
            },
            credits: {
                enabled: false
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            series: [{
                name: 'Nilai OK Kumulatif ' + sumNilaiOk,
                data: nilaiOkKumulatif,
                // stack: 'male'
            }, {
                name: 'Nilai Realisasi Kumulatif ' + sumNilaiRealisasi,
                data: nilaiRealisasiKumulatif,
                // stack: 'female'
            }]
        });
    </script> --}}
    <!--end::NILAI REALISASI-->

    <!--begin::MONITORING PROYEK-->
    <script>
        Highcharts.chart('monitoring-proyek', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                align: 'center',
                text: '<b class="h1">Monitoring Proyek</b>'
            },
            subtitle: {
                align: 'center',
                text: ' '
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
                // categories : ["Proses","Menang","Kalah dan Cancel","Prakualifikasi"]
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.name}',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'20px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> Total Proyek<br/>'
            },

            series: [{
                name: "Proyek Stage",
                colorByPoint: true,
                data: [{
                        name: "Proses : " + {{ $proses }},
                        y: {{ $proses }},
                        drilldown: "Proses",
                    },
                    {
                        name: "Menang : " + {{ $menang }},
                        y: {{ $menang }},
                        drilldown: "Menang",
                    },
                    {
                        name: "Kalah dan Cancel : " + {{ $kalah }},
                        y: {{ $kalah }},
                        drilldown: "Kalah dan Cancel",
                    },
                    {
                        name: "Prakualifikasi : " + {{ $prakualifikasi }},
                        y: {{ $prakualifikasi }},
                        drilldown: "Prakualifikasi",
                    }
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script>
    <!--end::MONITORING PROYEK-->
    
    <!--begin::SEBARAN SUMBER DANA-->
    {{-- <script>
        Highcharts.chart('sumber-dana-rkap', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 25
                }
            },
            title: {
                align: 'center',
                text: '<b class="h2">Sebaran Sumber Dana RKAP</b>'
            },
            subtitle: {
                align: 'center',
                text: '<b>Berdasarkan Jumlah</b>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.x}',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [
                    {
                        // name: "BUMN: " + Intl.NumberFormat(["id"], { style: 'currency', currency: 'IDR', maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000)),
                        name: "BUMN",
                        y: 10000,
                        x: "BUMN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                    {
                        name: "Swasta Asing : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "Swasta Asing : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "Swasta Nasional: " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "Swasta Nasional : " + Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000)),
                    },
                    {
                        name: "APBN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "APBN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                    {
                        name: "APBD:" + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "APBD : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "PASG : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 100))}`,
                        y: 100,
                        x: "PASG : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 100))}`,
                    },
                    {
                        name: "Loan:" + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "Loan : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "INVS : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "INVS : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script> --}}
    {{-- <script>
        Highcharts.chart('sumber-dana-realisasi', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 25
                }
            },
            title: {
                align: 'center',
                text: '<b class="h2">Sebaran Sumber Dana Realisasi</b>'
            },
            subtitle: {
                align: 'center',
                text: '<b>Berdasarkan Jumlah</b>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.x}',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'15px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [
                    {
                        name: "BUMN: " + Intl.NumberFormat(["id"], { style: 'currency', currency: 'IDR', maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000)),
                        y: 10000,
                        x: "BUMN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                    {
                        name: "Swasta Asing : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "Swasta Asing : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "Swasta Nasional: " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "Swasta Nasional : " + Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000)),
                    },
                    {
                        name: "APBN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "APBN : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                    {
                        name: "APBD:" + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "APBD : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "PASG : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 100))}`,
                        y: 100,
                        x: "PASG : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 100))}`,
                    },
                    {
                        name: "Loan:" + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                        y: 1000,
                        x: "Loan : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 1000))}`,
                    },
                    {
                        name: "INVS : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                        y: 10000,
                        x: "INVS : " + `${Intl.NumberFormat(["id"], { maximumSignificantDigits: 2 }).format(Math.floor(Math.random() * 10000))}`,
                    },
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script> --}}
    <!--end::SEBARAN SUMBER DANA-->


    <!--begin::TERENDAH vs TERKONTRAK-->
    @php
        $nilaiAll = $nilaiTerendah + $nilaiTerkontrak;
    if ($nilaiAll != 0) {
        $presentaseTerendah = round($nilaiTerendah / $nilaiAll * 100);
        $presentaseTerkontrak = round($nilaiTerkontrak / $nilaiAll * 100);
    } else {
        $presentaseTerendah = 0;
        $presentaseTerkontrak = 0;
    }
    @endphp
    <script>
        let presentaseTerkontrak = {{ $presentaseTerkontrak }};
        let presentaseTerendah = {{ $presentaseTerendah }};
        Highcharts.chart('terendah-terkontrak', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                align: 'center',
                text: '<b class="h1">Terendah - Terkontrak</b>'
            },
            subtitle: {
                align: 'center',
                text: ' '
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.x}',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'20px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span> <br> Presentase {point.x}</b>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [{
                        name: "Terendah : " + "{{ number_format($nilaiTerendah, 0, '.' , '.' ) }}",
                        y: {{ $nilaiTerendah }},
                        x: "Terendah : " + presentaseTerendah + "%",
                    },
                    {
                        name: "Terkontrak : " + "{{ number_format($nilaiTerkontrak, 0, '.' , '.' ) }}",
                        y: {{ $nilaiTerkontrak }},
                        x: "Terkontrak : " + presentaseTerkontrak + "%",
                    }
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script>
    <!--end::TERENDAH vs TERKONTRAK-->

    <!--begin::Competitive Index-->
    @php
    $indexJumlahAll = $jumlahMenang + $jumlahKalah;
    if ($indexJumlahAll != 0) {
        $presentaseMenang = round($jumlahMenang / $indexJumlahAll * 100);
        $presentaseKalah = round($jumlahKalah / $indexJumlahAll * 100);
    } else {
        $presentaseMenang = 0;
        $presentaseKalah = 0;
    }
    @endphp
    <script>
        Highcharts.chart('index-jumlah', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 25
                }
            },
            title: {
                align: 'center',
                text: '<b class="h2">Competitive Index</b>'
            },
            subtitle: {
                align: 'center',
                text: '<b>Berdasarkan Jumlah</b>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#61CB65", "#ED6D3F"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.x} %',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'20px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [{
                        name: "Proyek Menang : " + {{ $jumlahMenang }},
                        y: {{ $jumlahMenang }},
                        x: "Menang : " + {{ $presentaseMenang }},
                    },
                    {
                        name: "Proyek Kalah : " + {{ $jumlahKalah }},
                        y: {{ $jumlahKalah }},
                        x: "Kalah : " + {{ $presentaseKalah }},
                    }
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script>
    @php
        $indexNilaiAll = $nilaiMenang + $nilaiKalah;
    if ($indexNilaiAll != 0) {
        $presentaseNilaiMenang = round($nilaiMenang / $indexNilaiAll * 100);
        $presentaseNilaiKalah = round($nilaiKalah / $indexNilaiAll * 100);
    } else {
        $presentaseNilaiMenang = 0;
        $presentaseNilaiKalah = 0;
    }
    @endphp
    <script>
        Highcharts.chart('index-nilai', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 25
                }
            },
            title: {
                align: 'center',
                text: '<b class="h2">Competitive Index</b>'
            },
            subtitle: {
                align: 'center',
                text: '<b>Berdasarkan Nilai</b>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }
                
            },
            colors: ["#61CB65", "#ED6D3F"],
            plotOptions: {
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.x} %',
                    },
                    showInLegend: true
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'20px',
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</b></span>'
            },

            series: [{
                name: "",
                colorByPoint: true,
                data: [{
                        name: "Nilai Menang : " + "{{ number_format($nilaiMenang, 0, ',' , ',' ) }}",
                        y: {{ $nilaiMenang }},
                        x: "Menang : " + {{ $presentaseNilaiMenang }},
                    },
                    {
                        name: "Nilai Kalah : " + "{{ number_format($nilaiKalah, 0, ',' , ',' ) }}",
                        y: {{ $nilaiKalah }},
                        x: "Kalah : " + {{ $presentaseNilaiKalah }},
                    }
                ]
            }],
            credits: {
                enabled: false
            },
        });
    </script>
    <!--end::Competitive Index-->

    <!--begin::MARKETING PIPELINE-->
    <script>
        Highcharts.chart('marketing-pipeline', {
            chart: {
                type: 'funnel'
            },
            title: {
                text: '<b class="h1">Status Proyek</b>'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b> : {point.y:,.0f}',
                        softConnector: true
                    },
                    center: ['35%', '50%'],
                    neckWidth: '25%',
                    neckHeight: '0%',
                    width: '35%'
                }
            },
            legend: {
                enabled: false
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            series: [{
                name: 'Jml Proyek',
                data: [
                    ['Perolehan', {{ $prosesTender }}],
                    ['Terkontrak', {{ $terkontrak }}],
                    ['Pelaksanaan', {{ $pelaksanaan }}],
                    ['Serah Terima Pekerjaan', {{ $serahTerima }}],
                    ['Penutupan', {{ $closing }}]
                ]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                dataLabels: {
                                    inside: true
                                },
                                center: ['50%', '50%'],
                                width: '100%'
                            }
                        }
                    }
                }]
            },
            credits: {
                enabled: false
            },
        });
    </script>
    <!--end::MARKETING PIPELINE-->

    <!--begin::CLAIM-->
    <script>
        Highcharts.chart('claim', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 5,
                    beta: 15,
                    viewDistance: 50,
                    depth: 100
                }
            },
            title: {
                text: '<b class="h1">Claim Management dan Change Request</b>'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Cancel',
                    'Disetujui',
                    'Ditolak',
                    'On Progress'
                ],
                // crosshair: true
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: '',
                    skew3d: true
                }
            },
            tooltip: {
                headerFormat: '<span style="color:{series.color};font-size:14px"><b>{point.key}</b></span><table>',
                pointFormat: '<tr><td style="color:{series.color};font-size:12px;padding:4px;">{series.name} : </td>' +
                    '<td style="font-size:12px;padding:6px"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                // column: {
                //     pointPadding: 0.2,
                //     borderWidth: 0
                // }
            },
            credits: {
                enabled: false
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: {
                    fontSize:'20px',
                },
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            series: [{
                name: 'Claim',
                data: JSON.parse("{!! json_encode($claim_status_array) !!}")

            }, {
                name: 'Anti Claim',
                data: JSON.parse("{!! json_encode($anti_claim_status_array) !!}")

            }, {
                name: 'Change Request',
                data: JSON.parse("{!! json_encode($claim_asuransi_status_array) !!}")

            }]
        });
    </script>
    <!--end::CLAIM-->

    <!--Begin::Trigger Point Chart Forecast-->
    <script>
        // Begin :: Checking is filter active
        const isFilterActive = !Boolean("{{empty($unit_kerja_get)}}");
        const filterGet = "{{$unit_kerja_get}}";
        // End :: Checking is filter active

        function getFullscreenElement() {
            return document.fullscreenElement ||
                document.webkitFullscreenElement ||
                document.mozFullscreenElement ||
                document.msFullscreenElement;
        }

        // BEGIN :: point trigger forecast per bulan
        const chartPointsForecastPerBulan = document.querySelectorAll("#forecast-line .highcharts-point");
        const periodePrognosa = document.querySelector("#periode-prognosa");
        // console.log(periodePrognosa.value);
        // console.log(chartPointsForecastPerBulan);
        chartPointsForecastPerBulan.forEach(point => {
            point.addEventListener("click", async function() {
                const data = point.getAttribute("aria-label").replaceAll(/[^a-z|^A-Z|^.]/gi, "").split(
                    ".");
                const month = data[0];
                const type = data[1];
                const date = new Date().getMonth() + 1;
                const prognosa = periodePrognosa.value != "" ? periodePrognosa.value : date;
                let url = `/dashboard/filter/${prognosa}/${type}/${month}`;
                const unitKerja = $("#unit-kerja").select2({}).val();
                if (unitKerja) {
                    url += `/${unitKerja}`;
                }
                const dop = $("#dop").select2({}).val();
                if (dop) {
                    let dopUrl = dop.replaceAll(" ", "-");
                    // console.log(dop, dopUrl);
                    url += `/${dopUrl}`;
                    // url += `/${dop}`;
                }
                // console.log(url);
                // console.log(prognosa);
                getDataTable("#datatable", "#forecast-line", url, type, prognosa, month);
                

                const table = document.querySelector("#datatable");
                const chartLine = document.querySelector("#forecast-line");
                hideTable(table, chartLine);

                // Toggle Fullscreen
                table.style.backgroundColor = "white";
                if (getFullscreenElement()) {
                    table.requestFullscreen();
                    table.webkitRequestFullScreen();
                    table.msRequestFullscreen();
                }

            });
        })
        // END :: point trigger forecast per bulan

        // BEGIN :: point trigger forecast triwulan
        const chartPointsForecastTriwulan = document.querySelectorAll("#forecast-3wulan .highcharts-point");
        chartPointsForecastTriwulan.forEach(point => {
            point.addEventListener("click", async e => {
                const data = point.getAttribute("aria-label").replaceAll(/[^a-z|^A-Z|^.|^-]/gi, "").split(
                    ".");
                const month = data[0];
                const type = data[1];
                const date = new Date().getMonth() + 1;
                const prognosa = periodePrognosa.value != "" ? periodePrognosa.value : date;
                const tableTriwulan = document.querySelector("#datatable-triwulan");

                let url = `/dashboard/triwulan/${prognosa}/${type}/${month}`;
                // console.log(url);
                const unitKerja = $("#unit-kerja").select2({}).val();
                if (unitKerja) {
                    url += `/${unitKerja}`;
                }

                getDataTable("#datatable-triwulan", "#forecast-3wulan", url, type, prognosa, month)
                // const triwulanDataTable = await fetch(`/dashboard/triwulan/${prognosa}/${type}/${month}`).then(res => res.json());
                // triwulanDataTable.forEach(data => {
                // });
                
            });
        });
        // END :: point trigger forecast triwulan

        // BEGIN :: point trigger nilai realisasi
        const chartPointsForecastRealisasi = document.querySelectorAll("#nilai-realisasi .highcharts-point");
        chartPointsForecastRealisasi.forEach(point => {
            point.addEventListener("click", async e => {
                const data = point.getAttribute("aria-label").replaceAll(/[^a-z|^A-Z|^.|^-|^ |^0-9]/gi, "").split(
                    ".");
                // const unitKerja = data[0].trim().replaceAll(" ", "-");
                let unitKerja = data[0].trim().split(" ");
                unitKerja.pop();
                unitKerja = unitKerja.join("-");
                const type = data[1].trim().replaceAll(" ", "-");
                const date = new Date().getMonth() + 1;
                const prognosa = periodePrognosa.value != "" ? periodePrognosa.value : date;
                const tableRealisasi = document.querySelector("#datatable-realisasi");
                
                let url = `/dashboard/realisasi/0/${type}/${unitKerja}`;
                // console.log(url, unitKerja);
                const unitKerjaCode = $("#unit-kerja").select2({}).val();
                if (unitKerjaCode) {
                    url += `/${unitKerjaCode}`;
                }
                
                getDataTable("#datatable-realisasi", "#nilai-realisasi", url, type, prognosa)
                // const triwulanDataTable = await fetch(`/dashboard/triwulan/${prognosa}/${type}/${month}`).then(res => res.json());
                // triwulanDataTable.forEach(data => {
                // });
                
            });
        });
        // END :: point trigger nilai realisasi

        async function getDataTable(tableElt, chartElt, url, type, prognosa, month = new Date("now")) {
            let {href, data: filterRes} = await fetch(url).then(res =>res.json());
            const table = document.querySelector(tableElt);
            const exportExcelBtn = table.querySelector("#export-excel-btn");
            const thead = table.querySelector("#table-line-head");
            const tbody = table.querySelector("#table-line-body");
            const titleTable = table.querySelector("#title-table");
            const total = table.querySelector("#total");
            const unitKerja = url.split("/");
            
            if (type == "Forecast") {
                if (tableElt.includes("triwulan")) {
                    filterRes = filterRes.sort((a, b) => a.month_forecast - b.month_forecast);
                }
                let tbodyHTML = ``;
                let totalForecast = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Forecast</th>`
                '</tr>';

                [filterRes].forEach(filtering => {
                    for(let filter in filtering) {
                    filter = filtering[filter];
                    let stage = "";
                    totalForecast += Number(filter.nilai_forecast);
                    switch (Number(filter.stage)) {
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan);
                    switch (Number(filter.month_forecast)) {
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }

                    tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                            <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                            class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin) }
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(filter.nilai_forecast)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });
                
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `${type} - ${month}`;
                total.innerHTML = `Total ${type} = <b>${Intl.NumberFormat({}).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else if (type == "NilaiOK") {
                let tbodyHTML = ``;
                let totalNilaiOk = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai OK</th>`
                '</tr>';

                [filterRes].forEach(filtering => {
                    for(let filter in filtering) {
                    filter = filtering[filter];
                    let stage = "";
                    totalNilaiOk += Number(filter.rkap_forecast);
                    switch (Number(filter.stage)) {
                        case 0:
                            stage = "Cancel";
                            break;
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan);
                    switch (Number(filter.month_rkap)) {
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }

                    tbodyHTML += `<tr>
                            <!--begin::Email-->
                            <td>
                                <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin)}
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(filter.rkap_forecast)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                
                    }
                });   
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Nilai OK - ${month}`;
                total.innerHTML = `Total Nilai OK = <b>${Intl.NumberFormat({}).format(totalNilaiOk)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector("#forecast-line");
                chartLine.style.display = "none";
            } else if (type == "NilaiRealisasi") {
                let tbodyHTML = ``;
                let totalNilaiRealisasi = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Realisasi</th>`
                '</tr>';

                [filterRes].forEach(filtering => {
                    for(let filter in filtering) {
                    filter = filtering[filter];
                    let stage = "";
                    totalNilaiRealisasi += Number(filter.realisasi_forecast);
                    switch (Number(filter.stage)) {
                        case 0:
                            stage = "Cancel";
                            break;
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan);
                    switch (Number(filter.month_realisasi)) {
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }

                    tbodyHTML += `<tr>
                            <!--begin::Email-->
                            <td>
                                <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin)}
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(filter.realisasi_forecast)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                
                    }
                });   
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Nilai Realisasi - ${month}`;
                total.innerHTML = `Total Nilai Realisasi = <b>${Intl.NumberFormat({}).format(totalNilaiRealisasi)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector("#forecast-line");
                chartLine.style.display = "none";
            } else if(type == "Nilai-OK-Kumulatif") {
                filterRes = filterRes.sort((a, b) => Number(b.nilai_rkap.replaceAll(",", "")) - Number(a.nilai_rkap.replaceAll(",", "")))
                let tbodyHTML = ``;
                let totalNilaiOk = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai OK</th>`
                '</tr>';

                filterRes.forEach(filter => {
                    let stage = "";
                    totalNilaiOk += Number(filter.nilai_rkap.replaceAll(",", ""));
                    switch (Number(filter.stage)) {
                        case 0:
                            stage = "Cancel";
                            break;
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan);
                    switch (Number(filter.bulan_pelaksanaan)) {
                        case 0:
                            stage = "Cancel";
                            break;
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }

                    tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                                <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>                                
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin)}
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(Number(filter.nilai_rkap.replaceAll(",", "")))}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                });
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Nilai OK Kumulatif - ${unitKerja[unitKerja.length - 1].replaceAll("-", " ")}`;
                total.innerHTML = `Total Nilai OK Kumulatif = <b>${Intl.NumberFormat({}).format(totalNilaiOk)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else if(type == "Nilai-Realisasi-Kumulatif") {
                filterRes = filterRes.sort((a, b) => Number(b.nilai_kontrak_keseluruhan.replaceAll(",", "")) - Number(a.nilai_kontrak_keseluruhan.replaceAll(",", "")))
                let tbodyHTML = ``;
                let totalNilaiOk = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Realisasi</th>`
                '</tr>';

                filterRes.forEach(filter => {
                    let stage = "";
                    totalNilaiOk += Number(filter.nilai_kontrak_keseluruhan.replaceAll(",", ""));
                    switch (Number(filter.stage)) {
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan);
                    switch (Number(filter.bulan_pelaksanaan)) {
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }

                    tbodyHTML += `<tr>

                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : filter.status_pasdin}
                            </td>
                            <!--end::Name-->
                            <!--begin::Email-->
                            <td>
                                <a href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(Number(filter.nilai_kontrak_keseluruhan.replaceAll(",", "")))}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                });
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Nilai Realisasi - ${unitKerja[unitKerja.length - 1].replaceAll("-", " ")}`;
                total.innerHTML = `Total Nilai Realisasi = <b>${Intl.NumberFormat({}).format(totalNilaiOk)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else {
                let tbodyHTML = ``;
                let totalNilaiLainnya = 0;

                let theadHTML =
                '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    `<th class="text-end">Nilai ${type}</th>`
                '</tr>';
                
                [filterRes].forEach(filtering => {
                    for(let filter in filtering) {
                    filter = filtering[filter];
                    let stage = "";
                    totalNilaiLainnya += Number(filter.nilai_perolehan || filter.nilai_rkap);
                    switch (Number(filter.stage)) {
                        case 0:
                            stage = "Cancel";
                            break;
                        case 1:
                            stage = "Pasar Dini";
                            break;
                        case 2:
                            stage = "Pasar Potensial";
                            break;
                        case 3:
                            stage = "Prakualifikasi";
                            break;
                        case 4:
                            stage = "Tender Diikuti";
                            break;
                        case 5:
                            stage = "Perolehan";
                            break;
                        case 6:
                            stage = "Menang";
                            break;
                        case 7:
                            stage = "Kalah";
                            break;
                        case 8:
                            stage = "Terkontrak";
                            break;
                        case 9:
                            stage = "Terendah";
                            break;
                        case 10:
                            stage = "Approval";
                            break;
                        default:
                            break;
                    }

                    let bulan = "";
                    // console.log(filter.bulan_pelaksanaan, filter);
                    switch (Number(filter.bulan_pelaksanaan || filter.bulan_awal)) {
                        case 1:
                            bulan = "Januari";
                            break;
                        case 2:
                            bulan = "Februari";
                            break;
                        case 3:
                            bulan = "Maret";
                            break;
                        case 4:
                            bulan = "April";
                            break;
                        case 5:
                            bulan = "Mei";
                            break;
                        case 6:
                            bulan = "Juni";
                            break;
                        case 7:
                            bulan = "Juli";
                            break;
                        case 8:
                            bulan = "Agustus";
                            break;
                        case 9:
                            bulan = "September";
                            break;
                        case 10:
                            bulan = "Oktober";
                            break;
                        case 11:
                            bulan = "November";
                            break;
                        case 12:
                            bulan = "Desember";
                            break;
                        default:
                            bulan = "Bulan Unknown"
                            break;
                    }
                    const unitKerja = typeof filter.unit_kerja == "object" ? filter.unit_kerja.unit_kerja : filter.unit_kerja 
                    tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                                <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : filter.status_pasdin}
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${unitKerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Bulan-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(filter.nilai_perolehan || filter.nilai_rkap)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });

                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Nilai ${type} - ${month}`;
                total.innerHTML = `Total Nilai ${type} = <b>${Intl.NumberFormat({}).format(totalNilaiLainnya)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            }
            exportExcelBtn.setAttribute("href", `/download/${href}`);
        }
        
        function hideTable(tableElt, chartElt) {
            const table = document.querySelector(tableElt);
            const chartLine = document.querySelector(chartElt);
            // const forecastFigure = document.querySelector(".highcharts-figure");
            if (getFullscreenElement()) {
                forecast1.fullscreen.toggle();
            } else {
                document.exitFullscreen();
            }
            // table.exitFullscreen();
            table.style.display = "none";
            chartLine.style.display = "";
        }

        function toggleFullscreen() {
            if(getFullscreenElement()) {
                document.exitFullscreen();
                document.webkitExitFullscreen();
                document.msExitFullscreen();
            }
        }
    </script>
    <!--End::Trigger Point Chart Forecast-->
    
    <!--Begin::Clickable Monitoring Proyek-->
    <script>
        const monitoringProyekPie = document.querySelectorAll("#monitoring-proyek .highcharts-point");
        monitoringProyekPie.forEach(point => {
            point.addEventListener("click", async e => {
                const tipe = point.parentElement.getAttribute("aria-label").replaceAll(/[^a-z][^A-Z]|proyek stage|\./gi, "");
                let url = `/dashboard/monitoring-proyek/${tipe}`;
                if(isFilterActive) {
                    url = `/dashboard/monitoring-proyek/${tipe}/${filterGet}`;
                }
                getDataTable("#datatable-monitoring-proyek", "#monitoring-proyek", url, tipe, 9);
                
            })
        })

    </script>
    <!--End::Clickable Monitoring Proyek-->

    <!--Begin::Clickable Terendah-Terkontrak -->
    <script>
        const terendahTerkontrakPie = document.querySelectorAll("#terendah-terkontrak .highcharts-point");
        terendahTerkontrakPie.forEach(point => {
            point.addEventListener("click", async e => {
                const tipe = point.parentElement.getAttribute("aria-label").replaceAll(/[^a-z][^A-Z]|proyek stage|\./gi, "");
                // console.log(tipe);
                getDataTable("#datatable-terendah-terkontrak", "#terendah-terkontrak", `/dashboard/terendah-terkontrak/${tipe}`, tipe, 9);
                
            })
        })

    </script>
    <!--End::Clickable Terendah-Terkontrak -->
    

@endsection
