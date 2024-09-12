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
                            <div class="card-header">
                                <div class="card-title">
                                    <form action="" class="d-flex flex-row " method="get">
                                        <!-- Begin :: Select Options Unit Kerja -->
                                        <select onchange="selectDOP(this)" id="dop" name="dop"
                                            class="form-select form-select-solid w-auto"
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                            data-placeholder="Direktorat" data-select2-id="select2-data-dop" tabindex="-1"
                                            aria-hidden="true">
                                            <option value=""></option>
                                            @foreach ($dops as $dop)
                                                <option value="{{ $dop }}" {{ $dopSelect == $dop ? "selected" : "" }}>{{ $dop }}</option>
                                            @endforeach
                                        </select>
                                        <!-- End :: Select Options Unit Kerja -->
                                        <!-- Begin :: Select Options Unit Kerja -->
                                        <select onchange="selectUnitKerja(this)" id="unit-kerja" name="unit-kerja"
                                            class="form-select form-select-solid w-auto ms-2"
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="false"
                                            data-placeholder="Unit Kerja" data-select2-id="select2-data-unit-kerja" tabindex="-1"
                                            aria-hidden="true">
                                            <option value=""></option>
                                            @foreach ($unitKerja as $unitKerja)
                                                <option value="{{ $unitKerja->divcode }}" {{ $unitKerjaSelect == $unitKerja->divcode ? "selected" : "" }}>{{ $unitKerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                        <!-- End :: Select Options Unit Kerja -->
                                        @php
                                            $years = (int) date('Y');
                                        @endphp
                                        <!--begin::Select Options-->
                                        <select id="tahun" name="tahun"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                            data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                            @if ($tahun == null)
                                                @for ($i = 2021; $i <= (int) date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            @else
                                                @for ($i = 2021; $i <= (int) date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
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
                                                window.location.href = "/dashboard-four-eyes";
                                            }
                                        </script>
                                        <!--end:: RESET-->
                                    </form>
                                    <!--begin::RESET FILTER-->
                                </div>
                            </div>

                            <div class="card-body">
                                <!--BEGIN::PIE CHART PENGGUNA JASA-->
                                <h1 class="text-center my-4 bg-warning p-5">PENGGUNA JASA</h1>
                                <br>
                                <br>
    
                                <div class="d-flex flex-column mt-3">
                                    <div class="row align-items-center justify-content-center">
                                        <figure class="col-6 p-0 highcharts-figure">
                                            <div id="owner"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('owner')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-owner" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                            </div>
                                        </figure>
                                        <figure class="col-6 p-0 highcharts-figure">
                                            <div id="sumber-dana-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('sumber-dana-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-sumber-dana-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                    </div>
                                    <br>
                                    <div class="row align-items-center justify-content-center">
                                        <figure class="col-6 highcharts-figure">
                                            <div id="profile-risiko-owner"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('profile-risiko-owner')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-profile-risiko-owner" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="hasil-assessment-owner"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('hasil-assessment-owner')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-hasil-assessment-owner" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
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
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('status-wika-kso')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-status-wika-kso" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="profile-kso-eksternal"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('profile-kso-eksternal')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-profile-kso-eksternal" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                    </div>
                                    <br>
                                    <div class="row align-items-center justify-content-center">
                                        <figure class="col-6 highcharts-figure">
                                            <div id="instansi-mitra-kso"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('instansi-mitra-kso')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-instansi-mitra-kso" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="profile-kso-internal"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('profile-kso-internal')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-profile-kso-internal" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
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
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('uang-muka-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-uang-muka-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="cara-pembayaran-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('cara-pembayaran-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-cara-pembayaran-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                    </div>
                                    <br>
                                    <div class="row align-items-center justify-content-center">
                                        <figure class="col-6 highcharts-figure">
                                            <div id="kategori-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('kategori-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-kategori-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="jenis-kontrak-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('jenis-kontrak-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-jenis-kontrak-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                    </div>
                                    <div class="row align-items-center justify-content-center">
                                        <figure class="col-6 highcharts-figure">
                                            <div id="profile-risiko-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('profile-risiko-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-profile-risiko-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                        <figure class="col-6 highcharts-figure">
                                            <div id="hasil-rekomendasi-proyek"></div>
                                            <div class="d-flex justify-content-end d-none py-4">
                                                <button class="btn btn-sm btn-light btn-active-primary fs-6 me-3"
                                                    onclick="hideTable('hasil-rekomendasi-proyek')"><i class="bi bi-bar-chart-fill fs-6"></i> Show
                                                    Chart</button>
                                            </div>
                                            <div id="table-container-hasil-rekomendasi-proyek" class="container d-flex align-items-center justify-content-center" style="max-height: 500px;overflow-y:scroll">
                                        </figure>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <!--BEGIN::PIE CHART MITRA KSO-->
                            </div>
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
        function selectDOP(e) {
            document.getElementById("unit-kerja").value = "";
            e.form.submit();
        }

        function selectUnitKerja(e) {
            document.getElementById("dop").value = "";
            e.form.submit();
        }
    </script>

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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableOwner(this, 'owner');
                            }
                        }
                    }
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableOwner(this, 'sumber-dana-proyek');
                            }
                        }
                    }
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableOwner(this, 'profile-risiko-owner');
                            }
                        }
                    }
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableOwner(this, 'hasil-assessment-owner');
                            }
                        }
                    }
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

    <!--Begin::Clickable Owner-->
    <script>

        function generateTableOwner(point, kategori) {
            try {

                const proyeks = point.proyeks;
                
                const tableContainer = document.getElementById(`table-container-${kategori}`);
                const pieChartContainer = document.getElementById(kategori);            
                
                // Clear previous table
                tableContainer.innerHTML = '';
    
                // Create table elements
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');
    
                // Create header row
                thead.style.position = "sticky";
                thead.style.top = 0;
                const headerRow = document.createElement('tr');
                const headers = ['Nama Proyek', 'Nama Owner', "Unit Kerja", "Jenis Instansi", "Sumber Dana"];
                headers.forEach(headerText => {
                    const th = document.createElement('th');
                    th.textContent = headerText;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
    
                // Create data row
                proyeks.forEach(proyek => {                    
                    const dataRow = document.createElement('tr');
                    const nameProyekCell = document.createElement('td');
                    const nameOwnerCell = document.createElement('td');
                    const unitKerjaCell = document.createElement('td');
                    const jenisInstansiCell = document.createElement('td');
                    const sumberDanaCell = document.createElement('td');
                    
                    nameProyekCell.innerHTML = proyek.nama_proyek;
                    nameOwnerCell.innerHTML = proyek.nama_owner;
                    unitKerjaCell.innerHTML = proyek.unit_kerja;
                    jenisInstansiCell.innerHTML = proyek.jenis_instansi;
                    sumberDanaCell.innerHTML = proyek.sumber_dana;
        
                    dataRow.appendChild(nameProyekCell);
                    dataRow.appendChild(nameOwnerCell);
                    dataRow.appendChild(unitKerjaCell);
                    dataRow.appendChild(jenisInstansiCell);
                    dataRow.appendChild(sumberDanaCell);

                    tbody.appendChild(dataRow);
                });
    
                // Append table elements to the table
                table.appendChild(thead);
                table.appendChild(tbody);
    
                // Append table to the container
                tableContainer.appendChild(table);
                pieChartContainer.nextElementSibling.classList.remove("d-none");
    
                pieChartContainer.style.display = "none";                
            } catch (error) {
                alert(error);
            }            
        }

        function hideTable(kategori){
            const pieChartContainer = document.getElementById(kategori);
            const tableContainer = document.getElementById(`table-container-${kategori}`);
            
            tableContainer.firstChild.remove();
            pieChartContainer.style.display = "";
            pieChartContainer.nextElementSibling.classList.add("d-none");
        }

    </script>
    <!--End::Clickable Owner-->



    

    <!--Begin::Status KSO WIKA-->
    <script>
        const pieChatPosisiWika = JSON.parse('{!! $pieChatPosisiWika !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTablePartner(this, 'status-wika-kso');
                            }
                        }
                    }
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
                data: pieChatPosisiWika
            }]
        });
    </script>
    <!--End::Status KSO WIKA-->
    
    <!--Begin::Profile RIsiko Eksternal-->
    <script>
        const pieChatProfileRisikoEksternalPartner = JSON.parse('{!! $pieChatProfileRisikoEksternalPartner !!}');        
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTablePartner(this, 'profile-kso-eksternal');
                            }
                        }
                    }
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
                data: pieChatProfileRisikoEksternalPartner
            }]
            
        });
    </script>
    <!--ENd::Profile RIsiko Eksternal-->

    <!--Begin::Instansi Mitra KSO-->
    <script>
        const pieChatJenisInstansiPartner = JSON.parse('{!! $pieChatJenisInstansiPartner !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTablePartner(this, 'instansi-mitra-kso');
                            }
                        }
                    }
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
                data: pieChatJenisInstansiPartner
            }]
        });
    </script>
    <!--ENd::Instansi Mitra KSO-->

    <!--Begin::Profile Risiko Internal-->
    <script>
        const pieChatProfileRisikointernalPartner = JSON.parse('{!! $pieChatProfileRisikointernalPartner !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTablePartner(this, 'profile-kso-internal');
                            }
                        }
                    }
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
                data: pieChatProfileRisikointernalPartner
            }]
        });
    </script>
    <!--ENd::Profile Risiko Internal-->

    <!--Begin::Table Partner Selection-->
    <script>
        function generateTablePartner(point, kategori) {
            try {

                const proyeks = point.proyeks;                              
                
                const tableContainer = document.getElementById(`table-container-${kategori}`);
                const pieChartContainer = document.getElementById(kategori);            
                
                // Clear previous table
                tableContainer.innerHTML = '';
    
                // Create table elements
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');
    
                // Create header row
                thead.style.position = "sticky";
                thead.style.top = 0;
                const headerRow = document.createElement('tr');
                const headers = ['Nama Proyek', "Nama Partner", "Unit Kerja", "Jenis Instansi", "Posisi Wika", "Klasifikasi Proyek"];
                headers.forEach(headerText => {
                    const th = document.createElement('th');
                    th.textContent = headerText;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
    
                // Create data row
                proyeks.forEach(proyek => {                    
                    const dataRow = document.createElement('tr');
                    const nameProyekCell = document.createElement('td');
                    // const nameOwnerCell = document.createElement('td');
                    const namePartnerCell = document.createElement('td');
                    const unitKerjaCell = document.createElement('td');
                    const jenisInstansiCell = document.createElement('td');
                    const posisiWikaCell = document.createElement('td');
                    const klasifikasiProyekCell = document.createElement('td');
                    
                    nameProyekCell.innerHTML = proyek.nama_proyek;
                    // nameOwnerCell.innerHTML = proyek.nama_owner;
                    namePartnerCell.innerHTML = proyek.nama_owner;
                    unitKerjaCell.innerHTML = proyek.unit_kerja;
                    jenisInstansiCell.innerHTML = proyek.jenis_instansi;
                    posisiWikaCell.innerHTML = proyek.posisi_wika;
                    klasifikasiProyekCell.innerHTML = proyek.klasifikasi_proyek;
        
                    dataRow.appendChild(nameProyekCell);
                    // dataRow.appendChild(nameOwnerCell);
                    dataRow.appendChild(namePartnerCell);
                    dataRow.appendChild(unitKerjaCell);
                    dataRow.appendChild(jenisInstansiCell);
                    dataRow.appendChild(posisiWikaCell);
                    dataRow.appendChild(klasifikasiProyekCell);

                    tbody.appendChild(dataRow);
                });
    
                // Append table elements to the table
                table.appendChild(thead);
                table.appendChild(tbody);
    
                // Append table to the container
                tableContainer.appendChild(table);
                pieChartContainer.nextElementSibling.classList.remove("d-none");
    
                pieChartContainer.style.display = "none";                
            } catch (error) {
                alert(error);
            }            
        }

        // function generateTablePefindo(point, kategori) {
        //     try {

        //         const partners = point.proyeks;
                              
                
        //         const tableContainer = document.getElementById(`table-container-${kategori}`);
        //         const pieChartContainer = document.getElementById(kategori);            
                
        //         // Clear previous table
        //         tableContainer.innerHTML = '';
    
        //         // Create table elements
        //         const table = document.createElement('table');
        //         const thead = document.createElement('thead');
        //         const tbody = document.createElement('tbody');
    
        //         // Create header row
        //         thead.style.position = "sticky";
        //         thead.style.top = 0;
        //         const headerRow = document.createElement('tr');
        //         const headers = ['Nama Pelanggan', 'Grade', "Score", "Keterangan"];
        //         headers.forEach(headerText => {
        //             const th = document.createElement('th');
        //             th.textContent = headerText;
        //             headerRow.appendChild(th);
        //         });
        //         thead.appendChild(headerRow);
    
        //         // Create data row
        //         partners.forEach(partner => {                    
        //             const dataRow = document.createElement('tr');
        //             const nameOwnerCell = document.createElement('td');
        //             const gradeCell = document.createElement('td');
        //             const scoreCell = document.createElement('td');
        //             const keteranganCell = document.createElement('td');
                    
        //             nameOwnerCell.innerHTML = partner.nama_pelanggan;
        //             gradeCell.innerHTML = partner.grade;
        //             scoreCell.innerHTML = partner.score;
        //             keteranganCell.innerHTML = partner.keterangan;

        //             dataRow.appendChild(nameOwnerCell);
        //             dataRow.appendChild(gradeCell);
        //             dataRow.appendChild(scoreCell);
        //             dataRow.appendChild(keteranganCell);

        //             tbody.appendChild(dataRow);
        //         });
    
        //         // Append table elements to the table
        //         table.appendChild(thead);
        //         table.appendChild(tbody);
    
        //         // Append table to the container
        //         tableContainer.appendChild(table);
        //         pieChartContainer.nextElementSibling.classList.remove("d-none");
    
        //         pieChartContainer.style.display = "none";                
        //     } catch (error) {
        //         alert(error);
        //     }            
        // }
    </script>
    <!--End::Table Partner Selection-->




    <!--Begin::Uang Muka Proyek-->
    <script>
        const pieChatUangMuka = JSON.parse('{!! $pieChatUangMuka !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'uang-muka-proyek');
                            }
                        }
                    }
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
                data: pieChatUangMuka
            }]
        });
    </script>
    <!--End::Uang Muka Proyek-->

    <!--Begin::Cara Pembayaran-->
    <script>
        const pieChatCaraPembayaran = JSON.parse('{!! $pieChatCaraPembayaran !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'cara-pembayaran-proyek');
                            }
                        }
                    }
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
                data: pieChatCaraPembayaran
            }]
        });
    </script>
    <!--Begin::Cara Pembayaran-->

    <!--Begin::Kategori Proyek-->
    <script>
        const pieChatKategoriProyek = JSON.parse('{!! $pieChatKategoriProyek !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'kategori-proyek');
                            }
                        }
                    }
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
                data: pieChatKategoriProyek
            }]
        });
    </script>
    <!--End::Kategori Proyek-->

    <!--Begin::Jenis Kontrak Proyek-->
    <script>
        const pieChatJenisKontrak = JSON.parse('{!! $pieChatJenisKontrak !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'jenis-kontrak-proyek');
                            }
                        }
                    }
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
                data: pieChatJenisKontrak
            }]
        });
    </script>
    <!--End::Jenis Kontrak Proyek-->

    <!--Begin::Profile Risiko Proyek-->
    <script>
        const pieChatProfileRisikoProyek = JSON.parse('{!! $pieChatProfileRisikoProyek !!}')
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
               pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
           },
           plotOptions: {
               pie: {
                   allowPointSelect: true,
                   borderWidth: 2,
                   cursor: 'pointer',
                   dataLabels: {
                       enabled: true,
                       format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                       distance: 20
                   },
               },
               series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'profile-risiko-proyek');
                            }
                        }
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
               name: 'Owner',
               animation: {
                   duration: 2000
               },
               colorByPoint: true,
               data: pieChatProfileRisikoProyek
           }]
       });
    </script>
    <!--End::Profile Risiko Proyek-->

    <!--Begin::Hasil Assessment Proyek-->
    <script>
        const pieChatHasilRekomendasiProyek = JSON.parse('{!! $pieChatHasilRekomendasiProyek !!}')
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
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> : <b>{point.y} | {point.persentase}%</b><br/>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    borderWidth: 2,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>Total : {point.y} | {point.persentase}%',
                        distance: 20
                    },
                },
                series: {
                    point: {
                        events: {
                            click: function () {
                                generateTableProject(this, 'hasil-rekomendasi-proyek');
                            }
                        }
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
                name: 'Owner',
                animation: {
                    duration: 2000
                },
                colorByPoint: true,
                data: pieChatHasilRekomendasiProyek
            }]
        });
    </script>
    <!--End::Hasil Assessment Proyek-->

    <!--Begin::Table Project Selection-->
    <script>
        function generateTableProject(point, kategori) {
            try {

                const proyeks = point.proyeks;                
                
                const tableContainer = document.getElementById(`table-container-${kategori}`);
                const pieChartContainer = document.getElementById(kategori);            
                
                // Clear previous table
                tableContainer.innerHTML = '';
    
                // Create table elements
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');
    
                // Create header row
                thead.style.position = "sticky";
                thead.style.top = 0;
                const headerRow = document.createElement('tr');
                const headers = ['Nama Proyek', 'Nama Owner', "Unit Kerja", "KSO / Non KSO", "Jenis Kontrak", "Klasifikasi Proyek", "Uang Muka", "Cara Pembayaran"];
                headers.forEach(headerText => {
                    const th = document.createElement('th');
                    th.textContent = headerText;
                    headerRow.appendChild(th);
                });
                thead.appendChild(headerRow);
    
                // Create data row
                proyeks.forEach(proyek => {                    
                    const dataRow = document.createElement('tr');
                    const nameProyekCell = document.createElement('td');
                    const nameOwnerCell = document.createElement('td');
                    const unitKerjaCell = document.createElement('td');
                    const ksoNonKSOCell = document.createElement('td');
                    const jenisKontrakCell = document.createElement('td');
                    const klasifikasiProyekCell = document.createElement('td');
                    const uangMukaCell = document.createElement('td');
                    const caraPembayaranCell = document.createElement('td');
                    
                    nameProyekCell.innerHTML = proyek.nama_proyek;
                    nameOwnerCell.innerHTML = proyek.nama_owner;
                    unitKerjaCell.innerHTML = proyek.unit_kerja;
                    ksoNonKSOCell.innerHTML = proyek.kso_non_kso ? "Ya" : "Tidak";
                    jenisKontrakCell.innerHTML = proyek.jenis_kontrak;
                    klasifikasiProyekCell.innerHTML = proyek.klasifikasi_proyek;
                    uangMukaCell.innerHTML = proyek.uang_muka;
                    caraPembayaranCell.innerHTML = proyek.cara_pembayaran;
        
                    dataRow.appendChild(nameProyekCell);
                    dataRow.appendChild(nameOwnerCell);
                    dataRow.appendChild(unitKerjaCell);
                    dataRow.appendChild(ksoNonKSOCell);
                    dataRow.appendChild(jenisKontrakCell);
                    dataRow.appendChild(klasifikasiProyekCell);
                    dataRow.appendChild(uangMukaCell);
                    dataRow.appendChild(caraPembayaranCell);

                    tbody.appendChild(dataRow);
                });
    
                // Append table elements to the table
                table.appendChild(thead);
                table.appendChild(tbody);
    
                // Append table to the container
                tableContainer.appendChild(table);
                pieChartContainer.nextElementSibling.classList.remove("d-none");
    
                pieChartContainer.style.display = "none";                
            } catch (error) {
                alert(error);
            }            
        }
    </script>
    <!--End::Table Project Selection-->
@endsection