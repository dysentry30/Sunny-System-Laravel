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
                        <div class="card-header border-0 pt-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <form action="/dashboard" class="d-flex flex-row w-600px" method="get">
                                    {{-- Begin:: Select Options --}}
                                    <select id="periode-prognosa" name="periode-prognosa" class="form-select form-select-solid select2-hidden-accessible w-200px" style="margin-right: 2rem;" data-control="select2" data-hide-search="true" data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$month == "" ? "selected": ""}}></option>
                                        <option value="1" {{$month == 1 ? "selected": ""}}>Januari
                                        </option>
                                        <option value="2" {{$month == 2 ? "selected": ""}}>Februari
                                        </option>
                                        <option value="3" {{$month == 3 ? "selected": ""}}>Maret</option>
                                        <option value="4" {{$month == 4 ? "selected": ""}}>April</option>
                                        <option value="5" {{$month == 5 ? "selected": ""}}>Mei</option>
                                        <option value="6" {{$month == 6 ? "selected": ""}}>Juni</option>
                                        <option value="7" {{$month == 7 ? "selected": ""}}>Juli</option>
                                        <option value="8" {{$month == 8 ? "selected": ""}}>Agustus
                                        </option>
                                        <option value="9" {{$month == 9 ? "selected": ""}}>September
                                        </option>
                                        <option value="10" {{$month == 10 ? "selected": ""}}>Oktober
                                        </option>
                                        <option value="11" {{$month == 11 ? "selected": ""}}>November
                                        </option>
                                        <option value="12" {{$month == 12 ? "selected": ""}}>Desember
                                        </option>
                                    </select>
                                    {{-- End:: Select Options --}}
                                    
                                    {{-- Begin:: Select Options --}}
                                    <select id="tahun-history" name="tahun-history" class="form-select form-select-solid select2-hidden-accessible w-200px mx-2" data-control="select2" data-hide-search="true" data-placeholder="Tahun" data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        <option {{$year == "" ? "selected": ""}}></option>
                                        <option value="2021" {{$year == 2021 ? "selected": ""}}>2021
                                        </option>
                                        <option value="2022" {{$year == 2022 ? "selected": ""}}>2022
                                        </option>
                                        <option value="2023" {{$year == 2023 ? "selected": ""}}>2023</option>
                                        <option value="2024" {{$year == 2024 ? "selected": ""}}>2024</option>
                                        <option value="2025" {{$year == 2025 ? "selected": ""}}>2025</option>
                                        <option value="2026" {{$year == 2026 ? "selected": ""}}>2026</option>
                                        <option value="2027" {{$year == 2027 ? "selected": ""}}>2027</option>
                                        <option value="2028" {{$year == 2028 ? "selected": ""}}>2028
                                        </option>
                                        <option value="2029" {{$year == 2029 ? "selected": ""}}>2029
                                        </option>
                                        <option value="2030" {{$year == 2030 ? "selected": ""}}>2030
                                        </option>
                                        <option value="2031" {{$year == 2031 ? "selected": ""}}>2031
                                        </option>
                                        <option value="2032" {{$year == 2032 ? "selected": ""}}>2032
                                        </option>
                                    </select>
                                    {{-- End:: Select Options --}}

                                    {{-- Begin:: Action Filter --}}
                                    <button type="submit" class="btn btn-sm btn-primary w-250px" id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        Filter</button>
                                    {{-- End:: Action Filter --}}

                                    {{-- Begin:: Action Filter --}}
                                    <button type="button" onclick="resetFilter()" class="btn btn-sm btn-flex btn-light text-center btn-active-primary w-200px mx-2" id="kt_toolbar_primary_button">Reset</button>
                                    {{-- End:: Action Filter --}}
                                </form>
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <hr><br>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">
                            <!--begin::FORECAST LINE CHART-->
                            <figure class="highcharts-figure">
                                <div id="forecast-line" style="display:">
                                </div>
                                <!--begin::Table Proyek-->
                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="datatable" style="display:">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto">Kode Proyek</th>
                                            <th class="min-w-auto">Nama Proyek</th>
                                            <th class="min-w-auto">Unit Kerja</th>
                                            <th class="min-w-auto">Bulan</th>
                                            <th class="min-w-auto">Nilai Forecast</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    @foreach ($proyeks as $proyek)
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>

                                                <!--begin::Name=-->
                                                <td>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Email=-->
                                                <td>
                                                    {{ $proyek->nama_proyek }}
                                                </td>
                                                <!--end::Email=-->
                                                <!--begin::Company=-->
                                                <td>
                                                    {{ $proyek->UnitKerja->unit_kerja }}
                                                </td>
                                                <!--end::Company=-->
                                                
                                                <!--begin::Bulan=-->
                                                <td>
                                                    @foreach ($proyek->HistoryForecasts as $month_forecast)
                                                    {{ $month_forecast->month_forecast }}<br>
                                                    @endforeach
                                                </td>
                                                <!--end::Bulan=-->
                                                
                                                <!--begin::Nilai OK=-->
                                                <td>
                                                    @foreach ($proyek->HistoryForecasts as $nilai_forecast)
                                                    {{ $nilai_forecast->nilai_forecast }}<br>
                                                    @endforeach
                                                </td>
                                                <!--end::Nilai OK=-->
                                            </tr>
                                    @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table Proyek-->
                            </figure>
                            <!--end::FORECAST LINE CHART-->
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
                            
                            <div id="marketing-pipeline">
                                <!--begin::MARKETING PIPELINE-->
                                <!--end::MARKETING PIPELINE-->
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
<script src="https://code.highcharts.com/modules/funnel.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!--end::CDN High Chart-->

<!--begin::FORECAST LINE-->
{{-- let arrayHistoryForecast = JSON.parse("{!! json_encode($arrayHistoryForecast) !!}");
let i = arrayHistoryForecast; --}}
<script>
    // let per = 1; //normal
    let per = 1000000; //jutaan
    let fc1 = {!! $fc1 !!} ;
    let fc2 = fc1 + {!! $fc2 !!} ;
    let fc3 = fc2 + {!! $fc3 !!} ;
    let fc4 = fc3 + {!! $fc4 !!} ;
    let fc5 = fc4 + {!! $fc5 !!} ;
    let fc6 = fc5 + {!! $fc6 !!} ;
    let fc7 = fc6 + {!! $fc7 !!} ;
    let fc8 = fc7 + {!! $fc8 !!} ;
    let fc9 = fc8 + {!! $fc9 !!} ;
    let fc10 = fc9 + {!! $fc10 !!} ;
    let fc11 = fc10 + {!! $fc11 !!} ;
    let fc12 = fc11 + {!! $fc12 !!} ;
    
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

        colors : ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
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
            // data: [Math.ceil(fc1/per), Math.ceil(fc2/per), Math.ceil(fc3/per), Math.ceil(fc4/per), Math.ceil(fc5/per), Math.ceil(fc6/per), Math.ceil(fc7/per), Math.ceil(fc8/per), Math.ceil(fc9/per), Math.ceil(fc10/per), Math.ceil(fc11/per), Math.ceil(fc12/per)],
            data: [
                    {
                        y: Math.ceil(fc1/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc2/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc3/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc4/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc5/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc6/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc7/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc8/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc9/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc10/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc11/per),
                        drilldown: "Forecast"
                    },
                    {
                        y: Math.ceil(fc12/per),
                        drilldown: "Forecast"
                    },
                    
                ]
        // }, 
        // {
        //     name: 'Nilai OK',
        //     data: [1491, 5406, 8974, 9985, 11249, 13812, 18028, 23812, 30143, 32143, 38143, 40143],
        // }, 
        // {
        //     name: 'Nilai Realisasi',
        //     data: [1174, 1772, 1600, 1977, 3318, 3437, 4214, 5938, 8977, 11018, 22437, 29214],
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
{{-- let triWulanForecast = JSON.parse("{!! json_encode($arrayHistoryForecast) !!}");
let j = triWulanForecast; --}}
<script>
    let fc_3 = {!! $fc1 + $fc2 + $fc3 !!} ;
    let fc_6 = fc_3 + {!! $fc4 + $fc5 + $fc6 !!} ;
    let fc_9 = fc_6 + {!! $fc7 + $fc8 + $fc9 !!} ;
    let fc_12 = fc_9 + {!! $fc10 + $fc11 + $fc12 !!} ;
    
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

        colors : ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
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
                text: ' '
            }

        },
        colors : ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
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
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Total Proyek<br/>'
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
                    },
                    {
                        name: "Menang",
                        y: {{ $menang }},
                        drilldown: "Menang",
                    },
                    {
                        name: "Kalah dan Cancel",
                        y: {{ $kalah }},
                        drilldown: "Kalah dan Cancel",
                    },
                    {
                        name: "Prakualifikasi",
                        y: {{ $prakualifikasi }},
                        drilldown: "Prakualifikasi",
                    }
                ]
            }
        ],
        credits: {
            enabled:false
        },
        drilldown: {
            breadcrumbs: {
                // format: "{level.name}",
                position: {
                    align: 'right',
                }
            },
            series: [
                {
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
                }
            ]
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
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
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
        colors : ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
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
            enabled:false
        },
    });
</script>
<!--end::MARKETING PIPELINE-->

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

@endsection