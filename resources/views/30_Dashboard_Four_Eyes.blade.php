@extends('template.main')

@section('title', 'Four Eyes Dashboard')

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
                                <h1 class="d-flex align-items-center fs-3 my-1 py-4">Dashboard | Four Eyes Principle
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Content-->
                    <!--begin::Body Dashboard-->
                    <div id="dashboard-body" style="overflow-x: hidden" class="mt-3">
                        <div class="card">

                            <!--BEGIN::PIE CHART PENGGUNA JASA-->
                            <h1 class="text-center my-4 bg-warning p-5">PENGGUNA JASA</h1>
                            <br>
                            <br>

                            <div class="d-flex flex-column mt-3">
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 p-0 highcharts-figure">
                                        <div id="owner"></div>
                                    </figure>
                                    <figure class="col-6 p-0 highcharts-figure">
                                        <div id="sumber-dana-proyek"></div>
                                    </figure>
                                </div>
                                <br>
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="profile-risiko-owner"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="hasil-assessment-owner"></div>
                                    </figure>
                                </div>
                            </div>

                            <br>
                            <br>
                            <!--END::PIE CHART PENGGUNA JASA-->


                            <!--BEGIN::PIE CHART MITRA KSO-->
                            <h1 class="text-center my-4 bg-warning p-5">CALON MITRA KSO</h1>
                            <br>
                            <br>

                            <div class="d-flex flex-column mt-3">
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="status-wika-kso"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="profile-kso-eksternal"></div>
                                    </figure>
                                </div>
                                <br>
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="instansi-mitra-kso"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="profile-kso-internal"></div>
                                    </figure>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!--BEGIN::PIE CHART MITRA KSO-->


                            <!--BEGIN::PIE CHART MITRA KSO-->
                            <h1 class="text-center my-4 bg-warning p-5">PEROLEHAN PROYEK</h1>
                            <br>
                            <br>

                            <div class="d-flex flex-column mt-3">
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="uang-muka-proyek"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="cara-pembayaran-proyek"></div>
                                    </figure>
                                </div>
                                <br>
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="kategori-proyek"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="jenis-kontrak-proyek"></div>
                                    </figure>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <figure class="col-6 highcharts-figure">
                                        <div id="profile-risiko-proyek"></div>
                                    </figure>
                                    <figure class="col-6 highcharts-figure">
                                        <div id="hasil-rekomendasi-proyek"></div>
                                    </figure>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!--BEGIN::PIE CHART MITRA KSO-->


                        </div>
                    </div>
                    <!--end::Body Dashboard-->
                    <!--end::Content-->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-script')

    <script src="/js/highcharts/highcharts.js"></script>
    <script src="/js/highcharts/series-label.js"></script>
    <script src="/js/highcharts/exporting.js"></script>
    <script src="/js/highcharts/export-data.js"></script>
    <script src="/js/highcharts/drilldown.js"></script>
    <script src="/js/highcharts/funnel.js"></script>
    <script src="/js/highcharts/accessibility.js"></script>
    <script src="/js/highcharts/highcharts-3d.js"></script>

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

    <!--Begin::Instansi Owner-->
    <script>
        const pieChatOwnerInstansi = JSON.parse('{!! $pieChatOwnerInstansi !!}');
        
         Highcharts.chart('owner', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Owner',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: pieChatOwnerInstansi
            }]
        });
    </script>

    <!--Begin::Clickable Jenis Instansi-->
    <script>
        const monitoringProyekPie = document.querySelectorAll("#owner .highcharts-point");
        monitoringProyekPie.forEach(point => {
            point.addEventListener("click", async e => {
                const eltTipe = point.parentElement.getAttribute("aria-label");
                const sliceTipe = eltTipe.split(",");
                const tipe = sliceTipe[0];
            });
        })

    </script>
    <!--End::Clickable Jenis Instansi-->

    <!--End::Instansi Owner-->
    
    <!--Begin::Sumber Dana Proyek-->
    <script>
        const pieChatSumberDana = JSON.parse('{!! $pieChatSumberDana !!}');
         Highcharts.chart('sumber-dana-proyek', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Sumber Dana Proyek',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: pieChatSumberDana
            }]
        });
    </script>
    <!--End::Sumber Dana Proyek-->
    <!--Begin::Profile Risiko Owner-->
    <script>
        const pieChatProfileRisikoOwner = JSON.parse('{!! $pieChatProfileRisikoOwner !!}');
         Highcharts.chart('profile-risiko-owner', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Profile Risiko Owner',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: pieChatProfileRisikoOwner
            }]
        });
    </script>
    <!--End::Profile Risiko Owner-->

    <!--Begin::Hasil Assessment Owner-->
    <script>
        const pieChatHasilAssessmentOwner = JSON.parse('{!! $pieChatHasilAssessmentOwner !!}')
         Highcharts.chart('hasil-assessment-owner', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Hasil Assessment Owner',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: pieChatHasilAssessmentOwner
            }]
        });
    </script>
    <!--End::Hasil Assessment Owner-->




    

    <!--Begin::Status KSO WIKA-->
    <script>
        Highcharts.chart('status-wika-kso', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Status Wika Dalam KSO',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Tidak KSO",
                        "y" : 20
                    },
                    {
                        'name': "WIKA Leader",
                        "y" : 20
                    },
                    {
                        'name': "WIKA Member",
                        "y" : 20
                    },
                    
                ]
            }]
        });
    </script>
    <!--End::Status KSO WIKA-->
    
    <!--Begin::Profile RIsiko Eksternal-->
    <script>
        Highcharts.chart('profile-kso-eksternal', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Profile Risiko KSO Pefindo (Eksternal)',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Greenlane",
                        "y" : 20
                    },
                    {
                        'name': "Rendah",
                        "y" : 20
                    },
                    {
                        'name': "Moderat",
                        "y" : 20
                    },
                    {
                        'name': "Tinggi",
                        "y" : 20
                    },
                    {
                        'name': "Ekstrim",
                        "y" : 20
                    },
                ]
            }]
            
        });
    </script>
    <!--ENd::Profile RIsiko Eksternal-->

    <!--Begin::Instansi Mitra KSO-->
    <script>
        Highcharts.chart('instansi-mitra-kso', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Instansi Mitra KSO',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Pemerintah",
                        "y" : 20
                    },
                    {
                        'name': "BUMN",
                        "y" : 20
                    },
                    {
                        'name': "BUMD",
                        "y" : 20
                    },
                    {
                        'name': "Swasta Nasional",
                        "y" : 20
                    },
                    {
                        'name': "Swasta Asing",
                        "y" : 20
                    },
                ]
            }]
        });
    </script>
    <!--ENd::Instansi Mitra KSO-->

    <!--Begin::Profile Risiko Internal-->
    <script>
        Highcharts.chart('profile-kso-internal', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Profile Mitra KSO (Internal)',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Greenlane",
                        "y" : 20
                    },
                    {
                        'name': "Rendah",
                        "y" : 20
                    },
                    {
                        'name': "Moderat",
                        "y" : 20
                    },
                    {
                        'name': "Tinggi",
                        "y" : 20
                    },
                    {
                        'name': "Ekstrim",
                        "y" : 20
                    },
                ]
            }]
        });
    </script>
    <!--ENd::Profile Risiko Internal-->




    <!--Begin::Uang Muka Proyek-->
    <script>
        Highcharts.chart('uang-muka-proyek', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Uang Muka',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Uang Muka',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Tidak Ada Uang Muka",
                        "y" : 9
                    },
                    {
                        'name': "Ada Uang Muka",
                        "y" : 20
                    },
                ]
            }]
        });
    </script>
    <!--End::Uang Muka Proyek-->

    <!--Begin::Cara Pembayaran-->
    <script>
        Highcharts.chart('cara-pembayaran-proyek', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Cara Pembayaran',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Cara Pembayaran',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Monthly",
                        "y" : 9
                    },
                    {
                        'name': "Milestone",
                        "y" : 20
                    },
                    {
                        'name': "CPF (Turn Key)",
                        "y" : 20
                    },
                ]
            }]
        });
    </script>
    <!--Begin::Cara Pembayaran-->

    <!--Begin::Kategori Proyek-->
    <script>
        Highcharts.chart('kategori-proyek', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Kategori Proyek',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Kategori Proyek',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Kecil",
                        "y" : 9
                    },
                    {
                        'name': "Menengah",
                        "y" : 20
                    },
                    {
                        'name': "Besar",
                        "y" : 20
                    },
                    {
                        'name': "Mega",
                        "y" : 2
                    },
                ]
            }]
        });
    </script>
    <!--End::Kategori Proyek-->

    <!--Begin::Jenis Kontrak Proyek-->
    <script>
        Highcharts.chart('jenis-kontrak-proyek', {
            chart: {
                // height: 250,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 5
                }
            },
            title: {
                text: 'Jenis Kontrak Proyek',
                style: {
                    fontWeight: 'bold',
                    fontSize: '20px'
                }
            },
            subtitle: {
                // text: '3D donut in Highcharts'
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y}',
                        distance: 20
                    },
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                showTable: false,
                allowHTML: true
            },
            series: [{
                name: 'Jenis Kontrak Proyek',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: [
                    {
                        'name': "Lumpsum",
                        "y" : 9
                    },
                    {
                        'name': "Mix",
                        "y" : 20
                    },
                    {
                        'name': "Cost-Plus",
                        "y" : 20
                    },
                    {
                        'name': "O & M",
                        "y" : 2
                    },
                    {
                        'name': "Unit Price",
                        "y" : 40
                    },
                ]
            }]
        });
    </script>
    <!--End::Jenis Kontrak Proyek-->

    <!--Begin::Profile Risiko Proyek-->
    <script>
        Highcharts.chart('profile-risiko-proyek', {
           chart: {
               // height: 250,
               type: 'pie',
               options3d: {
                   enabled: true,
                   alpha: 5
               }
           },
           title: {
               text: 'Profile Risiko Proyek',
               style: {
                   fontWeight: 'bold',
                   fontSize: '20px'
               }
           },
           subtitle: {
               // text: '3D donut in Highcharts'
           },
           tooltip: {
               headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
               pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
           },
           plotOptions: {
               pie: {
                   allowPointSelect: true,
                   borderWidth: 2,
                   cursor: 'pointer',
                   dataLabels: {
                       enabled: true,
                       format: '<b>{point.name}</b><br>Total : {point.y}',
                       distance: 20
                   },
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
               name: 'Owner',
               animation: {
                   duration: 2000
               },
               colorByPoint: true,
               data: [
                   {
                       'name': "Greenlane",
                       "y" : 20
                   },
                   {
                       'name': "Rendah",
                       "y" : 20
                   },
                   {
                       'name': "Moderat",
                       "y" : 20
                   },
                   {
                       'name': "Tinggi",
                       "y" : 20
                   },
                   {
                       'name': "Ekstrim",
                       "y" : 20
                   },
               ]
           }]
       });
   </script>
   <!--End::Profile Risiko Proyek-->

   <!--Begin::Hasil Assessment Proyek-->
   <script>
    Highcharts.chart('hasil-rekomendasi-proyek', {
       chart: {
           // height: 250,
           type: 'pie',
           options3d: {
               enabled: true,
               alpha: 5
           }
       },
       title: {
           text: 'Hasil Rekomendasi Proyek',
           style: {
               fontWeight: 'bold',
               fontSize: '20px'
           }
       },
       subtitle: {
           // text: '3D donut in Highcharts'
       },
       tooltip: {
           headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
           pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y}</b><br/>'
       },
       plotOptions: {
           pie: {
               allowPointSelect: true,
               borderWidth: 2,
               cursor: 'pointer',
               dataLabels: {
                   enabled: true,
                   format: '<b>{point.name}</b><br>Total : {point.y}',
                   distance: 20
               },
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
           name: 'Owner',
           animation: {
               duration: 2000
           },
           colorByPoint: true,
           data: [
               {
                   'name': "Greenlane",
                   "y" : 20
               },
               {
                   'name': "Direkomendasikan",
                   "y" : 20
               },
               {
                   'name': "Direkomendasikan dengan catatan",
                   "y" : 20
               },
               {
                   'name': "Tidak Direkomendasikan",
                   "y" : 20
               },
           ]
       }]
   });
</script>
<!--End::Hasil Assessment Proyek-->
@endsection