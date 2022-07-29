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
                @extends('template.header')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard
                                </h1>
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
                        <div class="card-header pt-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <form action="/dashboard" class="d-flex flex-row w-600px" method="get">
                                    <!--begin::Select Options-->
                                    <select id="periode-prognosa" name="periode-prognosa"
                                        class="form-select form-select-solid select2-hidden-accessible w-200px"
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
                                    <select id="tahun-history" name="tahun-history"
                                        class="form-select form-select-solid select2-hidden-accessible w-200px ms-2"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        @if ($year == null)
                                            @for ($i = $years - 3; $i < $years + 10; $i++)
                                                <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        @else
                                            @for ($i = $year - 3; $i < $year + 10; $i++)
                                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                    <!--end::Select Options-->

                                    <!--begin::Action Filter-->
                                    <button type="submit" class="btn btn-sm btn-primary ms-4"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4">
                                        Filter</button>

                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                    <!--end::Action Filter-->
                                </form>
                                <!--begin::RESET FILTER-->
                                <script>
                                    function resetFilter() {
                                        $("#periode-prognosa").select2({
                                            minimumResultsForSearch: -1
                                        }).val("").trigger("change");

                                        $("#tahun-history").select2({
                                            minimumResultsForSearch: -1
                                        }).val("").trigger("change");

                                    }
                                </script>
                                <!--end::RESET FILTER-->
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->

                        <br>

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::FORECAST LINE CHART-->
                            <figure class="highcharts-figure py-12">
                                <div id="forecast-line" style="display:">
                                </div>
                                <!--begin::Table Proyek-->
                                <div class="" id="datatable" style="display:none;">
                                    <hr>
                                    <div class="text-center">
                                        <h2 id="title-table"></h2>
                                        <h4 id="total"></h4>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                            onclick="hideTable()"><i class="bi bi-graph-up-arrow fs-6"></i> Show
                                            Chart</button>
                                        <button class="btn btn-sm btn-light btn-active-danger fs-6"
                                            onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                        {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                    </div>
                                    <br>
                                    <table class="table align-middle table-row-dashed fs-6 gy-2">
                                        <!--begin::Table head-->
                                        <thead id="table-line-head">
                                            {{-- THead Here --}}
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold" id="table-line-body">
                                            {{-- Data Here --}}
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                            </figure>
                            <!--end::FORECAST LINE CHART-->
                            <hr>

                            <div class="py-12" id="forecast-3wulan">
                                <!--begin::FORECAST 3 WULAN CHART-->
                                <!--end::FORECAST 3 WULAN CHART-->
                            </div>
                            <hr>

                            <div class="py-12" id="monitoring-proyek">
                                <!--begin::MONITORING PROYEK-->
                                <!--end::MONITORING PROYEK-->
                            </div>
                            <hr>

                            <div class="py-12" id="marketing-pipeline">
                                <!--begin::MARKETING PIPELINE-->
                                <!--end::MARKETING PIPELINE-->
                            </div>
                            <hr>

                            <div class="py-12" id="claim">
                                <!--begin::MARKETING PIPELINE-->
                                <!--end::MARKETING PIPELINE-->
                            </div>
                            <hr>

                            <!--begin:: PARETO-->
                            <div class="px-8 py-12" id="monitoring-proyek">
                                <h1 class="text-center bold pb-8">
                                    Pareto Proyek
                                </h1>

                                <!--begin::Table pareto proyek  -->
                                <div class="tab-content" id="myTabContent">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2">
                                        <!--begin::Table head-->
                                        <thead>
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
                                                        <a href="#" id=""
                                                            class="text-gray-800 text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                        <!--end::Name-->
                                                        <!--begin::Unit Kerja-->
                                                    <td>
                                                        <a href="#" id=""
                                                            class="text-gray-800 text-hover-primary mb-1">{{ $proyek->UnitKerja->unit_kerja }}</a>
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
                                                        {{ number_format($proyek->forecast, 0, '.', ',') }}
                                                    </td>
                                                    <!--end::Nilai Forecast-->
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
                                <!--end::Table pareto proyek-->
                            </div>
                            <hr>

                            <div class="px-8 pb-18 py-12">
                                <h1 class="text-center bold">
                                    Pareto Claim
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
                                            style="font-size:14px;">Claim Asuransi</a>
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
                                                            <a href="#" id=""
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
                                                    <th class="min-w-auto">@sortablelink('nilai_claim', 'Nilai Claim')</th>
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
                                                            <a href="#" id=""
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
                                                    <th class="min-w-auto">@sortablelink('nilai_claim', 'Nilai Claim')</th>
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
                                                            <a href="#" id=""
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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/funnel.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!--end::CDN High Chart-->

    <!--begin::FORECAST LINE-->
    <script>
        let nilaiForecast = JSON.parse("{!! json_encode($nilaiForecastArray) !!}");
        let nilaiRkap = JSON.parse("{!! json_encode($nilaiRkapArray) !!}");
        let nilaiRealisasi = JSON.parse("{!! json_encode($nilaiRealisasiArray) !!}");

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
                },
                // label: {
                //     connectorAllowed: false
                // },
                // pointStart: 2021
            },

            series: [{
                    name: 'Forecast',
                    data: nilaiForecast,
                },
                {
                    name: 'Nilai OK',
                    data: nilaiRkap,
                },
                {
                    name: 'Nilai Realisasi',
                    data: nilaiRealisasi,
                }
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
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },

            credits: {
                enabled: false
            },
            // drilldown: {
            //     breadcrumbs: {
            //         // format: "{level.name}",
            //         position: {
            //             align: 'right',
            //         }
            //     },
            //     series: [
            //         {
            //             name: "Monthly Forecast",
            //             id: "Forecast",
            //             // type: 'column',
            //             data: [
            //                 [
            //                     21
            //                 ],
            //                 [
            //                     13
            //                 ],
            //                 [
            //                     50
            //                 ],
            //                 [
            //                     44
            //                 ],
            //                 [
            //                     28
            //                 ],
            //                 [
            //                     35
            //                 ],
            //                 [
            //                     21
            //                 ],
            //                 [
            //                     13
            //                 ],
            //                 [
            //                     50
            //                 ],
            //                 [
            //                     44
            //                 ],
            //                 [
            //                     28
            //                 ],
            //                 [
            //                     35
            //                 ]
            //             ]
            //         }
            //     ]
            // }

        });
    </script>
    <!--end::FORECAST LINE-->

    <!--begin::FORECAST 3WULAN-->
    <script>
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
    </script>
    <!--end::FORECAST 3WULAN-->

    <!--begin::MONITORING PROYEK-->
    <script>
        Highcharts.chart('monitoring-proyek', {
            chart: {
                type: 'pie'
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
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
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
            drilldown: {
                breadcrumbs: {
                    // format: "{level.name}",
                    position: {
                        align: 'right',
                    }
                },
                series: [{
                    name: "Proses",
                    id: "Proses",
                    type: 'column',
                    data: [
                        [
                            "v650",
                            21
                        ],
                        [
                            "v640",
                            13
                        ],
                        [
                            "v630",
                            50
                        ],
                        [
                            "v620",
                            44
                        ],
                        [
                            "v610",
                            28
                        ],
                        [
                            "v600",
                            35
                        ]
                    ]
                }]
            }
        });
    </script>
    <!--end::MONITORING PROYEK-->

    <!--begin::MARKETING PIPELINE-->
    <script>
        Highcharts.chart('marketing-pipeline', {
            chart: {
                type: 'funnel'
            },
            title: {
                text: '<b class="h1">Marketing Pipeline</b>'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b> : {point.y:,.0f}',
                        softConnector: true
                    },
                    center: ['35%', '50%'],
                    neckWidth: '35%',
                    neckHeight: '0%',
                    width: '45%'
                }
            },
            legend: {
                enabled: false
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            series: [{
                name: 'Jml Proyek',
                data: [
                    ['Proses Tender', {{ $prosesTender }}],
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
                type: 'column'
            },
            title: {
                text: '<b class="h1">Status Claim</b>'
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
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ' '
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            series: [{
                name: 'Claim',
                data: JSON.parse("{!! json_encode($claim_status_array) !!}")

            }, {
                name: 'Anti Claim',
                data: JSON.parse("{!! json_encode($anti_claim_status_array) !!}")

            }, {
                name: 'Claim Asuransi',
                data: JSON.parse("{!! json_encode($claim_asuransi_status_array) !!}")

            }]
        });
    </script>
    <!--end::CLAIM-->




    <!--Begin::Trigger Point Chart-->
    <script>
        function getFullscreenElement() {
            return document.fullscreenElement ||
                document.webkitFullscreenElement ||
                document.mozFullscreenElement ||
                document.msFullscreenElement;
        }

        const chartPoints = document.querySelectorAll("#forecast-line .highcharts-point");
        const periodePrognosa = document.querySelector("#periode-prognosa");
        // console.log(periodePrognosa.value);
        // console.log(chartPoints);
        chartPoints.forEach(point => {
            point.addEventListener("click", async function() {
                const data = point.getAttribute("aria-label").replaceAll(/[^a-z|^A-Z|^.]/gi, "").split(
                    ".");
                const month = data[0];
                const type = data[1];
                const date = new Date().getMonth() + 1;
                const prognosa = periodePrognosa.value != "" ? periodePrognosa.value : date;
                // console.log(prognosa);
                const filterRes = await fetch(`/dashboard/${prognosa}/${type}/${month}/`).then(res =>
                    res.json());
                // console.log(filterRes);
                const thead = document.querySelector("#table-line-head");
                const tbody = document.querySelector("#table-line-body");
                const table = document.querySelector("#datatable");
                const titleTable = table.querySelector("#title-table");
                const total = table.querySelector("#total");

                let theadHTML =
                    '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Kode Proyek</th>' +
                    '<th>Nama Proyek</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    '<th>Bulan</th>' +
                    '<th class="right-align">Nilai Forecast</th>'
                '</tr>';

                let tbodyHTML = ``;
                let totalForecast = 0;

                filterRes.forEach(filter => {
                    let stage = "";
                    totalForecast += Number(filter.nilai_forecast);
                    switch (filter.stage) {
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
                    switch (filter.month_forecast) {
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

                            <!--begin::Name=-->
                            <td>
                                <a href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                                    class="text-gray-800 text-hover-primary mb-1">${filter.kode_proyek}</a>
                            </td>
                            <!--end::Name=-->
                            <!--begin::Email=-->
                            <td>
                                ${filter.nama_proyek}
                            </td>
                            <!--end::Email=-->
                            <!--begin::Stage=-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage=-->

                            <!--begin::Unit Kerja=-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja=-->

                            <!--begin::Bulan=-->
                            <td>
                                ${bulan}
                            </td>
                            <!--end::Bulan=-->

                            <!--begin::Nilai Forecast=-->
                            <td class="text-end">
                                ${Intl.NumberFormat({}).format(filter.nilai_forecast)}
                            </td>
                            <!--end::Nilai Forecast=-->
                            </tr>`;
                });
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `Forecast - ${month}`;
                total.innerHTML =
                    `Total Forecast = <b>${Intl.NumberFormat({}).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector("#forecast-line");
                chartLine.style.display = "none";

                // Toggle Fullscreen
                table.style.backgroundColor = "white";
                if (getFullscreenElement()) {
                    table.requestFullscreen();
                    table.webkitRequestFullScreen();
                    table.msRequestFullscreen();
                } else {
                    // document.exitFullscreen();
                    // document.webkitExitFullscreen();
                    // document.msExitFullscreen();
                }

            });
        })

        function hideTable() {
            const table = document.querySelector("#datatable");
            const chartLine = document.querySelector("#forecast-line");
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
    <!--End::Trigger Point Chart-->
@endsection
