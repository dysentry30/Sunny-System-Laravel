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
                                                    href="/dashboard-ccm" style="font-size:14px;">Head Office</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm" style="font-size:14px;">Division</a>
                                            </li>
                                            <!--end:::Tab Item Tab Pane-->
                                            <!--begin:::Tab Item Tab Pane-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4"
                                                    href="/dashboard-ccm" style="font-size:14px;">Project</a>
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
                    <div id="dashboard-body" class="mt-3">


                        <!--begin::Card Diagram Column dan Donut-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col-8">
                                <!--begin::Card body-->
                                <div class="row">
                                    <!--begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::COLUMN CHART-->
                                            <div id="donut-chart-2"></div>
                                            <!-- data table is inserted here -->
                                            <!--end::COLUMN CHART-->
                                    </div>
                                    <!--end-begin::Card column-->
                                    <div class="col-6">
                                            <!--begin::PIE CHART-->
                                            <figure class="highcharts-figure">
                                                <div id="donut-chart"></div>
                                                <!-- data table is inserted here -->
                                            </figure>
                                            <!--end::PIE CHART-->
                                    </div>
                                    <!--end::Card column-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end-begin::Card column-->
                            <div class="col-4">
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
                                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">78 Items</span>
                                                        <!--end::Amount-->
                                                        <!--begin::Subtitle-->
                                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">EPC</span>
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
                                                            <span>41 Pending</span>
                                                            <span>52%</span>
                                                        </div>
                                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 52%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">35 Items</span>
                                                        <!--end::Amount-->
                                                        <!--begin::Subtitle-->
                                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">DG</span>
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
                                                            <span>3 Pending</span>
                                                            <span>8%</span>
                                                        </div>
                                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 8%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">45 Items</span>
                                                        <!--end::Amount-->
                                                        <!--begin::Subtitle-->
                                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">DSU</span>
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
                                                            <span>5 Pending</span>
                                                            <span>11%</span>
                                                        </div>
                                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 11%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                            </div>
                            <!--end::Card column-->
                        </div>
                        <!--end::Card Diagram Column dan Donut-->
                        <br>
                        <!--begin::Card Line col-12-->
                        <div class="row mx-3">
                            <!--begin::Card column-->
                            <div class="col-12">
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::LINE CHART-->
                                    <figure class="highcharts-figure">
                                        <div class="chart-outer" id="table-line">
                                            <div id="chart-line" style="width: 70%; padding-right: 10px; overflow: unset;"></div>
                                            <!-- data table is inserted here -->
                                        </div>
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

    <!--begin::Highchart Donut-->
    <script>
        Highcharts.chart('donut-chart-2', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Contract By Stage',
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
                    '<td style="padding:0"><b>&nbsp;{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 150,
                    depth: 5,
                    showInLegend: true,
                    dataLabels: {
                        enabled: false,
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
                showTable: true,
                allowHTML: true
            },
            series: [{
                name: 'Medals',
                data: [
                    ['Tender', 3],
                    ['Signed', 2],
                    ['Executed', 7],
                    ['Maintenance', 3],
                    ['Delayed', 1]
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut-->

    <!--begin::Highchart Donut-->
    <script>
        Highcharts.chart('donut-chart', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Contract By Division',
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
                    '<td style="padding:0"><b>&nbsp;{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    innerSize: 200,
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
                showTable: true,
                allowHTML: true
            },
            series: [{
                name: 'Medals',
                data: [
                    ['DSU', 8],
                    ['EPC', 16],
                    ['DG', 12]
                ]
            }]
        });
    </script>
    <!--end::Highchart Donut-->

    <!--begin::Highchart Line-->
    <script>
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
    </script>
    <!--end::Highchart Line-->

@endsection
