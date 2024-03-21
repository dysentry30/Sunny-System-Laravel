<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .fc-col-header-cell {
            background-color: #4fc4ff;
        }

        .fc-col-header-cell-cushion {
            color: white
        }

        .fc-daygrid-day-number{
            color: black !important;
        }
    </style>

    <title>Dashboard TV</title>
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--Begin::Navbar-->
    <nav class="navbar bg-white">
        <div class="container-fluid shadow">
            <a class="navbar-brand" href="#">
                <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                    {{-- <a class="d-inline-block align-text-top" href="#" onclick="toggleFullscreen()"> --}}
                        <img src="{{ asset('/media/logos/Logo2.png') }}" onclick="toggleFullscreen()" alt="Logo" width="80"
                            class="d-inline-block align-text-top">
                    {{-- </a> --}}
                    <p class="m-0"><b>Customer Relationship Management</b></p>
                </div>
            </a>
        </div>
    </nav>
    <!--End::Navbar-->
    <!--Begin::Container-->
    <div class="container-fluid card card-flush h-lg-100" id="kt_contacts_main">
        <!--Begin::Card Body-->
        <div class="card-body pt-5">
            <!--begin:::Tabs Navigasi-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-5 pb-3">
                <!--begin:::Tab item Dashboard-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_user_view_overview_dashboard" style="font-size:14px;">Dashboard</a>
                </li>
                <!--end:::Tab item Dashboard-->
                <!--begin:::Tab Item Schedule-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_user_view_overview_schedule" style="font-size:14px;">Schedule</a>
                </li>
                <!--end:::Tab Item Schedule-->
            </ul>
            <!--END:::Tabs Navigasi-->
            <!--begin::Root-->
            {{-- <div class=" d-flex flex-column flex-root"> --}}
            <!--Begin::Tab Dashboard-->
            <div class="tab-pane fade show active" id="kt_user_view_overview_dashboard" role="tabpanel">
                <!--begin::Page-->
                <div class="page row pt-5">
                    <div class="">
                        <figure class="highcharts-figure">
                            <div id="highchart-forecast"></div>
                        </figure>
                    </div>
                    <div class="row mt-5 pt-5">
                        <div class="col-4">
                            <div class="card" style="background-color: #46AAF5">
                                <div class="card-body">
                                    <h3 class="text-white">Nilai OK RKAP</h3>
                                    <h1 class="text-white" style="font-size: 3rem" id="nilai-rkap">Rp. -</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card" style="background-color: #F7C13E">
                                <div class="card-body">
                                    <h3 class="text-white">Nilai Forecast</h3>
                                    <h1 class="text-white" style="font-size: 3rem" id="nilai-forecast">Rp. -</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card" style="background-color: #61CB65">
                                <div class="card-body">
                                    <h3 class="text-white">Nilai Realisasi</h3>
                                    <h1 class="text-white" style="font-size: 3rem" id="nilai-realisasi">Rp. -</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Page-->
            </div>
            <!--End::Tab Dashboard-->
            <!--Begin::Tab Schedule-->
            <div class="tab-pane fade" id="kt_user_view_overview_schedule" role="tabpanel">
                <!--begin::Page-->
                <div class="page row pt-5">
                    <div id='calendar'></div>
                    <div class="d-flex flex-row align-items-center justify-content-center my-4 gap-5">
                        <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                            <div class="circle"
                                style="height:25px; width:25px; border-radius:50%;background-color: #46AAF5">
                                <small style="color:#46AAF5">Klik</small>
                            </div>
                            <p class="m-0"><b>Jadwal Prakualifikasi</b></p>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-center gap-3">
                            <div class="circle"
                                style="height:25px; width:25px; border-radius:50%;background-color: #F7C13E">
                                <small style="color:#F7C13E">Klik</small>
                            </div>
                            <span>
                                <p class="m-0"><b>Jadwal Tender</b></p>
                            </span>
                        </div>
                    </div>
                </div>
                <!--end::Page-->
            </div>
            <!--End::Tab Schedule-->
            {{-- </div> --}}
            <!--end::Root-->
        </div>
        <!--End::Card Body-->
    </div>
    <!--End::Container-->

    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
    <script src="/js/highcharts/highcharts.js"></script>
    <script src="/js/highcharts/series-label.js"></script>
    <script src="/js/highcharts/exporting.js"></script>
    <script src="/js/highcharts/export-data.js"></script>
    <script src="/js/highcharts/drilldown.js"></script>
    <script src="/js/highcharts/funnel.js"></script>
    <script src="/js/highcharts/accessibility.js"></script>
    <script src="/js/highcharts/highcharts-3d.js"></script>
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.11/index.global.min.js'></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>


    <script>
        const chart = Highcharts.chart('highchart-forecast', {
            chart: {
                type: 'line',
                // height: (9 / 16 * 100) + '%', // 16:9 ratio
                height: 570, // 16:9 ratio
                margin: [50, 70, 100, 70],
                shadow: true
            },
            title: {
                text: '<b class="h1 py-5">Forecast Bulanan (Dalam Jutaan)</b>',
                align: 'center'
            },

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
                format: '<b>{point.key}</b><br>',
                itemStyle: {
                    fontSize: '20px',
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
                name: 'Nilai OK RKAP',
                data: []
            }, {
                name: 'Nilai Forecast',
                data: []
            }, {
                name: 'Nilai Realisasi',
                data: []
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 800
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


        async function getDataChartForecast() {
            try {
                const response = await fetch('/dashboard-tv/get-data-forecast', {
                    method: 'GET'
                }).then(res => res.json());
                return response
            } catch (error) {
                return {
                    Success: false,
                    Message: error
                }
            }
        }

        async function getChat() {
            chart.showLoading()
            const dataApi = await getDataChartForecast();
            const eltRKAP = document.querySelector('#nilai-rkap');
            const eltForecast = document.querySelector('#nilai-forecast');
            const eltRealisasi = document.querySelector('#nilai-realisasi');

            chart.hideLoading()
            if (dataApi.Success) {
                chart.series[0].setData(dataApi.NilaiRKAP)
                chart.series[1].setData(dataApi.NilaiForecast)
                chart.series[2].setData(dataApi.NilaiRealisasi)

                eltRKAP.innerHTML = "Rp. " + dataApi.NilaiRKAP[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                eltForecast.innerHTML = "Rp. " + dataApi.NilaiForecast[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                eltRealisasi.innerHTML = "Rp. " + dataApi.NilaiRealisasi[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            } else {
                alert("Error => " + dataApi.Message)
            }
        }
        getChat();
    </script>

    <script>
        $(document).ready(function() {
            // Function to switch to next tab
            async function switchToNextTab() {
                // Get active tab
                let activeTab = document.querySelector('.nav-tabs .nav-link.active');
                // Get next sibling tab
                let nextTab = activeTab.parentElement.nextElementSibling?.querySelector('.nav-link');
                let activeWorkPlace = document.querySelector('.tab-pane.fade.show.active .page');
                let nextWorkPlace = activeWorkPlace.parentElement.nextElementSibling?.querySelector('.page');

                const eltRKAP = document.querySelector('#nilai-rkap');
                const eltForecast = document.querySelector('#nilai-forecast');
                const eltRealisasi = document.querySelector('#nilai-realisasi');

                activeWorkPlace.style.display = 'none';
                
                // If next tab is not available, switch to the first tab
                if (!nextTab && !nextWorkPlace) {
                    // chart.showLoading()
                    const dataApi = await getDataChartForecast();
                    if (dataApi.Success) {
                        // chart.hideLoading()
                        chart.series[0].setData(dataApi.NilaiRKAP)
                        chart.series[1].setData(dataApi.NilaiForecast)
                        chart.series[2].setData(dataApi.NilaiRealisasi)

                        eltRKAP.innerHTML = "Rp. " + dataApi.NilaiRKAP[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                        eltForecast.innerHTML = "Rp. " + dataApi.NilaiForecast[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                        eltRealisasi.innerHTML = "Rp. " + dataApi.NilaiRealisasi[11].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    } else {
                        alert("Error => " + dataApi.Message)
                    }
                    nextTab = document.querySelector('.nav-tabs .nav-link:first-child');
                    nextWorkPlace = document.querySelector('.tab-pane.fade .page');
                }
                // Activate the next tab
                nextWorkPlace.style.display = '';
                nextTab.click();
            }

            // Automatically switch tabs every 1 minutes
            setInterval(switchToNextTab, 0.2*60*1000);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                initialView: 'dayGridMonth',
                aspectRatio: 2.8,
                handleWindowResize: true,
                weekends: true,
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    start: '',
                    center: 'title',
                    end: ''
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long',
                },
                dayHeaderFormat: {
                    weekday: 'long'
                },
                eventSources: [{
                        url: '/dashboard-tv/get-event',
                        method: 'GET',
                        extraParams: {
                            category: 'jadwal-pq',
                        },
                        failure: function(err) {
                            alert(err);
                        },
                        color: '#46AAF5',
                        textColor: 'white'
                    },
                    {
                        url: '/dashboard-tv/get-event',
                        method: 'GET',
                        extraParams: {
                            category: 'jadwal-tender',
                        },
                        failure: function(err) {
                            alert(err);
                        },
                        color: '#F7C13E',
                        textColor: 'white'
                    },

                ]


            });
            calendar.render();
        });
    </script>

    <script>
        function toggleFullscreen() {
            const elem = document.getElementById("kt_body");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else {
                document.exitFullscreen();
            }
        }
    </script>

</body>

</html>