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
                                        New</a>
                                    <!--end::Button-->

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6155ac804a1c2">
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
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button>
                                                <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                                </button>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Wrapper-->


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
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Dashboard" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">
                            <div id="forecast-line">
                                <!--begin::FORECAST LINE CHART-->
                                <!--end::FORECAST LINE CHART-->
                            </div>
                            <br><br><hr><br><br>

                            <div id="forecast-3wulan">
                                <!--begin::FORECAST 3 WULAN CHART-->
                                <!--end::FORECAST 3 WULAN CHART-->
                            </div>
                            <br><br><hr><br><br>
                            
                            <div id="monitoring-proyek">
                                <!--begin::MONITORING PROYEK-->
                                <!--end::MONITORING PROYEK-->
                            </div>
                            <br><br><hr><br><br>
                            
                            <div id="container">
                                <!--begin::MONITORING PROYEK-->
                                <!--end::MONITORING PROYEK-->
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
{{-- <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
<!--end::CDN High Chart-->

<!--begin::FORECAST LINE-->
<script>
    let arrayHistoryForecast = JSON.parse("{!! json_encode($arrayHistoryForecast) !!}");
    let i = arrayHistoryForecast;
    // let per = 1; //normal
    let per = 1000000; //jutaan
    // let per = 1000000000; //miliaran
    let fc1 = i[0] ;
    let fc2 = fc1 + i[1] ;
    let fc3 = fc2 + i[2] ;
    let fc4 = fc3 + i[3] ;
    let fc5 = fc4 + i[4] ;
    let fc6 = fc5 + i[5] ;
    let fc7 = fc6 + i[6] ;
    let fc8 = fc7 + i[7] ;
    let fc9 = fc8 + i[8] ;
    let fc10 = fc9 + i[9] ;
    let fc11 = fc10 + i[10] ;
    let fc12 = fc11 + i[11] ;
    
        Highcharts.chart('forecast-line', {

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
            categories:[
                "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","oktober","November","Desember",
            ],
            // accessibility: {
            //     rangeDescription: 'Range: 2010 to 2017'
            // }
        },

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

        series: [
        {
            name: 'Forecast',
            data: [fc1/per, fc2/per, fc3/per, fc4/per, fc5/per, fc6/per, fc7/per, fc8/per, fc9/per, fc10/per, fc11/per, fc12/per]
        }, 
        {
            name: 'Nilai OK',
            data: [1491, 5406, 8974, 9985, 11249, 13812, 18028, 23812, 30143, 32143, 38143, 40143],
            color: '#90ed7d'
        }, 
        {
            name: 'Nilai Realisasi',
            data: [1174, 1772, 1600, 1977, 3318, 3437, 4214, 5938, 8977, 11018, 22437, 29214],
            color: '#f1416c'
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
            enabled:false
        }

        });
        
</script>
<!--end::FORECAST LINE-->

<!--begin::FORECAST 3WULAN-->
<script>
    let triWulanForecast = JSON.parse("{!! json_encode($arrayHistoryForecast) !!}");
    let j = triWulanForecast;
    let fc_3 = j[0]+j[1]+j[2] ;
    let fc_6 = fc_3+j[3]+j[4]+j[5] ;
    let fc_9 = fc_6+j[6]+j[7]+j[8] ;
    let fc_12 = fc_9+j[9]+j[10]+j[11] ;
    
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
            categories:[
                "Januari-Maret",
                "April-Juni",
                "Juli-September",
                "oktober-Desember",
            ],
            // accessibility: {
            //     rangeDescription: 'Range: 2010 to 2017'
            // }
        },

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

        series: [
        {
            name: 'Forecast',
            data: [fc_3, fc_6, fc_9, fc_12]
        }, 
        {
            name: 'Nilai OK',
            data: [6491600000, 15406400000, 49742000000, 60851000000],
            color: '#90ed7d'
        }, 
        {
            name: 'Nilai Realisasi',
            data: [1174400000, 6772200000, 16005000000, 22077100000],
            color: '#f1416c'
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
            enabled:false
        },

        });
        
</script>
<!--end::FORECAST 3WULAN-->

<!--begin::MONITORING PROYEK-->
{{-- let arrayStage = {!! json_encode($stageProyek) !!} --}}
{{-- console.log(arrayStage); --}}
<script>
    Highcharts.chart('monitoring-proyek', {
        chart: {
            type: 'column'
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
                text: ' '
            }

        },
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
            headerFormat:    '<span style="font-size:11px">{series.name}</span><br>',
            // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [
            {
                name: "Proyek Stage",
                colorByPoint: true,
                data: [
                    {
                        name: "Proses",
                        y: {{ $proses }},
                        drilldown: "Proses",
                        color: "#7cb5ec"
                    },
                    {
                        name: "Menang",
                        y: {{ $menang }},
                        drilldown: "Menang",
                        color: "#90ed7d"
                    },
                    {
                        name: "Kalah dan Cancel",
                        y: {{ $kalah }},
                        drilldown: "Kalah dan Cancel",
                        color:"#f1416c"
                    },
                    {
                        name: "Prakualifikasi",
                        y: {{ $prakualifikasi }},
                        drilldown: "Prakualifikasi",
                            color:"#f9A962"
                    }
                ]
            }
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [
                {
                    name: "Proses",
                    id: "Proses",
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
                }
            ]
        }
    });
</script>
<!--end::MONITORING PROYEK-->

@endsection