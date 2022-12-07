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
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm/pelaksanaan-kontrak" style="font-size:14px;">Pelaksanaan Kontrak</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active"
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
                                        <div class="col-4">
                                            <select onchange="selectDOP(this)" id="dop" name="dop"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Direktorat" data-select2-id="select2-data-dop" tabindex="-1"
                                                    aria-hidden="true">
                                                    {{-- <option value="" {{$dop_get == "" ? "selected" : ""}}></option> --}}
                                                    <option value="" selected></option>
                                                    @foreach ($dops as $dop)
                                                        {{-- <option value="{{ $dop->dop }}" {{ $dop_get == $dop->dop ? 'selected' : '' }} >{{ $dop->dop }}</option> --}}
                                                        <option value="{{ $dop->dop }}" >{{ $dop->dop }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <select onchange="selectDOP(this)" id="unit-kerja" name="unit-kerja"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                                    aria-hidden="true">
                                                    {{-- <option value="" {{$dop_get == "" ? "selected" : ""}}></option> --}}
                                                    <option value="" selected></option>
                                                    @foreach ($unit_kerjas as $unit_kerjas)
                                                        {{-- <option value="{{ $unit_kerjas->divcode }}" {{ $unit_kerjas_get == $unit_kerjas->divcode ? 'selected' : '' }} >{{ $unit_kerjas->unit_kerja }}</option> --}}
                                                        <option value="{{ $unit_kerjas->divcode }}" >{{ $unit_kerjas->unit_kerja }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <select onchange="selectDOP(this)" id="proyek" name="proyek"
                                                    class="form-select form-select-solid w-auto"
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="false"
                                                    data-placeholder="Proyek" data-select2-id="select2-data-proyek" tabindex="-1"
                                                    aria-hidden="true">
                                                    {{-- <option value="" {{$dop_get == "" ? "selected" : ""}}></option> --}}
                                                    <option value="" selected></option>
                                                    @foreach ($proyeks as $proyek)
                                                        {{-- <option value="{{ $proyek->divcode }}" {{ $proyek_get == $proyek->divcode ? 'selected' : '' }} >{{ $proyek->unit_kerja }}</option> --}}
                                                        <option value="{{ $proyek->kode_proyek }}" >{{ $proyek->nama_proyek }} ({{$proyek->kode_proyek}})</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!--End :: Filter-->

                        <br>

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

                        <!--begin::Title-->
                        <div class="mb-4">
                            <div class="col-12">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    <h2 class="m-0 text-center">Resume <i class="h2 px-1">Outstanding</i> CCM</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card body-->
                            <div class="row">
                                <!--begin::Card column-->
                                <div class="col-4">
                                        <!--begin::COLUMN CHART-->
                                        <div id="contract-stage">
                                            <!-- data table is inserted here -->
                                        </div>
                                        <!--end::COLUMN CHART-->
                                </div>
                                <!--end-begin::Card column-->
                                <div class="col-4">
                                        <!--begin::PIE CHART-->
                                        <div id="kso">
                                            <!-- data table is inserted here -->
                                        </div>
                                        <!--end::PIE CHART-->
                                </div>
                                <!--end-begin::Card column-->
                                <div class="col-4">
                                        <!--begin::PIE CHART-->
                                            <div id="contract-classification">
                                                <!-- data table is inserted here -->
                                            </div>
                                        <!--end::PIE CHART-->
                                </div>
                                <!--end::Card column-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card body-->
                            {{-- <div class="row">
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
                                            <div id="contract-jo"></div>
                                            <!-- data table is inserted here -->
                                        <!--end::PIE CHART-->
                                </div>
                                <!--end::Card column-->
                            </div> --}}
                            <!--end::Card body-->
                        </div>
                        <!--end::Card Diagram Column dan Donut-->

                        <br>

                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card body-->
                            <div class="row">
                                <!--begin::Card column-->
                                <div class="col-6">
                                    <!--begin::COLUMN CHART-->
                                    <div id="contract-divisi"></div>
                                    <!-- data table is inserted here -->
                                    <!--end::COLUMN CHART-->
                                </div>
                                <div class="col-6">
                                    <!--begin::COLUMN CHART-->
                                    <div id="changes-status"></div>
                                    <!-- data table is inserted here -->
                                    <!--end::COLUMN CHART-->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card Diagram Column dan Donut-->

                        <br>

                        <!--begin::Title-->
                        <div class="row mb-4">
                            <div class="col-9">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">TOTAL NILAI : Rp 2.850.000.000.000</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    <h2 class="m-0 text-center">18,6 %</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        <!--end::Title-->

                        <!--begin::Table Body-->
                        {{-- @foreach ($nilai_perubahan_table as $table) --}}
                        <div class="row mb-4">
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-warning">
                                    {{-- <h2 class="m-0 text-center">{{ $table->jenis_claim }}</h2> --}}
                                    <h2 class="m-0 text-center">VO</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-1">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    {{-- <h2 class="m-0 text-center">{{ $table->total_proyek }}</h2> --}}
                                    <h2 class="m-0 text-center">12</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-5">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    {{-- <h2 class="m-0 text-center">{{ $table->total_nilai }}</h2> --}}
                                    <h2 class="m-0 text-center">Rp 1.140.000.000.000</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                            <div class="col-3">
                                <!--begin::Title body-->
                                <div style="border-radius: 0px" class="card-body bg-secondary">
                                    {{-- <h2 class="m-0 text-center">{{ $table->total_persen }}</h2> --}}
                                    <h2 class="m-0 text-center">7,2 %</h2>
                                </div>
                                <!--end::Title body-->
                            </div>
                        </div>
                        {{-- @endforeach --}}
                        <!--end::Table Body-->

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

    <!--begin::Highchart Donut Pemilik Pekerjaan-->
    <script>
        Highcharts.chart('contract-stage', {
            chart: {
                // height: 250,
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
                    ['Pemerintah', 3],
                    ['Others', 2],
                    ['BUMN', 7],
                    ['Swasta', 3],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Pemilik Pekerjaan-->

    <!--begin::Highchart Donut Changes Overview-->
    <script>
        Highcharts.chart('contract-divisi', {
            chart: {
                // height: 250,
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
                    ['Insurance', 8],
                    ['VO', 16],
                    ['Claim', 12],
                    ['Anti Claim', 4],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Changes Overview-->

    <!--begin::Highchart Donut Jenis Kontrak -->
    <script>
        Highcharts.chart('contract-classification', {
            chart: {
                // height: 250,
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
                    ['Lumpsum', 8],
                    ['Unit Price', 16],
                    ['Gabungan', 12],
                    ['Turn Key', 9],
                    ['Others', 4],
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut Jenis Kontrak -->

    <!--begin::Highchart Donut Bentuk Proyek -->
    <script>
        Highcharts.chart('contract-jo', {
            chart: {
                type: 'pie',
                // height: 250,
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
                // height: 330,
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
        Highcharts.chart('chart-line', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'TOTAL NILAI KONTRAK : Rp 15.890.000.000',
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
                    data: [
                        {
                            name: "Divisi Infra 1",
                            y: 1999123058123,
                        },
                        {
                            name: "Divisi Infra 2",
                            y: 2999123058123,
                        },
                    ]
                },
            ]
        });
    </script>
    <!--end::Highchart Block Nilai Tender -->

    <!--begin::Highchart KSO dan Non-KSO -->
    <script>
        Highcharts.chart('kso', {
            chart: {
                type: 'pie',
                // height: 330,
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'KSO dan NON-KSO',
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
                    ['KSO', 8],
                    ['Non-KSO', 16],
                ]
            }]
        });
    </script>
    <!--end::Highchart KSO dan KON -->

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
        function animateProgressBar() {
            const progressbarElts = document.querySelectorAll("div[role='progressbar']");
            progressbarElts.forEach(item => {
                const dataPersen = item.parentElement.parentElement.querySelector("#data-persen");
                let width = Number(dataPersen.innerText.replace("%", ""));
                item.style.width = width + "%";
            });
        }
        animateProgressBar();
    </script>
    {{-- End :: Animation Progress Bar --}}

    {{-- Begin :: Animation Counter Number --}}
    <script>
        function animateCounterNumber(selector, firstPrefix = "", lastPrefix = "") {
            const animateCounterElts = document.querySelectorAll(`${selector}`);
            animateCounterElts.forEach(item => {
                let data;
                if(firstPrefix != ""){
                    data = Number(item.innerText.replaceAll(firstPrefix, "").replaceAll(".", ""));
                } else {
                    data = Number(item.innerText.replaceAll(lastPrefix, ""));
                }
                item.innerText = `${firstPrefix}0${lastPrefix}`;
                let i = 0;
                const interval = setInterval(() => {
                    console.log({i, data});
                    if(i == data || i >= data) {
                        clearInterval(interval);
                        if(firstPrefix == "Rp. "){
                            data = Intl.NumberFormat(["id"]).format(data);
                        }
                        item.innerText = `${firstPrefix}${data}${lastPrefix}`;
                        return;
                    };
                    if(firstPrefix == "Rp. "){
                        // i+= Math.floor((data / 15) + data);
                        i+= Math.floor(data/15);
                        item.innerText = `${firstPrefix}${Intl.NumberFormat(["id"]).format(i)}${lastPrefix}`;
                    } else {
                        i++;
                        item.innerText = `${firstPrefix}${i}${lastPrefix}`;
                    }
                }, 15);
            });
        }
        animateCounterNumber("#data-persen", "", "%");
        animateCounterNumber("#data-items", "Rp. ");
    </script>
    {{-- End :: Animation Counter Number --}}

@endsection
