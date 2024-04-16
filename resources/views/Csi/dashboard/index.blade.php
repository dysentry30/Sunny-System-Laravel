{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Dashboard CSI')
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
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard CSI
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Card-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <form action="" class="d-flex flex-row gap-4">
                                    <select name="get-year" id="get-year"
                                    class="form-select form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilh Tahun"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="" selected></option>
                                    <option value="2023" {{ $getYear == '2023' ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ $getYear == '2024' ? 'selected' : '' }}>2024</option>
                                    </select>
                                    
                                    <select name="get-month" id="get-month"
                                    class="form-select form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilh Bulan"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="" selected></option>
                                    <option value="1" {{ $getMonth == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $getMonth == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $getMonth == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $getMonth == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $getMonth == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $getMonth == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $getMonth == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $getMonth == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $getMonth == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $getMonth == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $getMonth == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $getMonth == '12' ? 'selected' : '' }}>Desember</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                                    <a href="/csi/dashboard" class="btn btn-sm btn-secondary align-middle">Reset</a>
                                </form>
                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 d-none">
                            <div class="row fv-row">

                                <!--Begin::Dashboard Sisi Kanan-->
                                <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="persentase-total"></div>
                                    </figure>

                                    <p class="mt-1 fs-1 fw-bold"><b>Score : {{ $dataAverageTotalCsi[0] }} / Presentase : {{ $dataAverageTotalCsi[1] }}%</b></p>

                                    <!--Begin::Star-->

                                    <div class="star-container my-2 d-flex flex-row align-items-center justify-content-center" style="width:135px">
                                        <div class="star-icons" style="overflow:hidden; width:{{ $dataAverageTotalCsi[1] }}%">
                                          <div class="star" style="width: 250px">
                                            <i class="bi bi-star-fill" style="color: #61CB65; font-size:24px"></i>
                                            <i class="bi bi-star-fill" style="color: #61CB65; font-size:24px"></i>
                                            <i class="bi bi-star-fill" style="color: #61CB65; font-size:24px"></i>
                                            <i class="bi bi-star-fill" style="color: #61CB65; font-size:24px"></i>
                                            <i class="bi bi-star-fill" style="color: #61CB65; font-size:24px"></i>
                                          </div>
                                        </div>
                                    </div>

                                    <!--End::Star-->
                                    

                                    <div class="bg-success text-center rounded-pill my-4" style="width:40% ">
                                        <p class="m-0 fs-1 fw-bold text-white">{{ $tingkatKepuasanTotal }}</p>
                                    </div>
                                    
                                    <!--Begin::Keterangan-->
                                    <div class="container d-flex flex-column my-5">
                                        <p class="" style="font-weight: bold">Keterangan :</p>
                                        @foreach ($kategoriCSI as $key => $csi)
                                            <p class="" style="font-weight: bold">{{ $key + 1 }}. {{ $csi->dari }}% - {{ $csi->sampai }}% ({{ $csi->kategori }})</p>
                                        @endforeach
                                    </div>
                                    <!--End::Keterangan-->

                                </div>
                                <!--End::Dashboard Sisi Kanan-->



                                <!--Begin::Dashboard Sisi Kiri-->
                                <div class="col-6 d-flex flex-column justify-content-center">
                                    <figure class="highcharts-figure">
                                        <div id="persentase-divisi"></div>
                                    </figure>
                                    
                                    <!--begin::Table-->
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white" rowspan="2">Divisi</th>
                                                <th class="min-w-auto text-white" colspan="2">Rata - rata</th>
                                                <th class="min-w-auto text-white" rowspan="2">Keterangan</th>
                                            </tr>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">Score</th>
                                                <th class="min-w-auto text-white">(%)</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($dataAveragePerDivisiCsi as $item)
                                            <tr>
                                                <td class="text-center align-center">
                                                    @if (!empty($getMonth))
                                                        <a class="text-hover-primary" href="/csi/dashboard/{{ $item['key'] }}?get-year={{ $getYear }}&get-month={{ $getMonth }}">{{ $item['key'] }}</a>
                                                    @else
                                                        <a class="text-hover-primary" href="/csi/dashboard/{{ $item['key'] }}">{{ $item['key'] }}</a>
                                                    @endif
                                                </td>
                                                <td class="text-center align-center">{{ $item['sumPerDivisi'] }}</td>
                                                <td class="text-center align-center">{{ $item['persentasePerDivisi'] }}%</td>
                                                <td class="text-center align-center">{{ $item['keteranganPerDivisi'] }}</td>
                                            </tr>                                                
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--End::Dashboard Sisi Kiri-->

                            </div>
                        </div>
                        <!--end::Card body-->


                    </div>
                    <!--end::Card-->


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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>

    <script src="/js/highcharts/highcharts.js"></script>
    <script src="/js/highcharts/highcharts-more.js"></script>
    <script src="/js/highcharts/solid-gauge.js"></script>
    <script src="/js/highcharts/column.js"></script>

    <script>
        $('#example').DataTable({
            info: false,
            ordering: false,
            paging: false,
            filter: false
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    })
</script>

<script>
    const trackColors = Highcharts.getOptions().colors.map(color =>
        new Highcharts.Color(color).setOpacity(0.2).get()
    );
    const dataPersentaseTotal = JSON.parse("{!! json_encode($dataAverageTotalCsi) !!}");
    const dataPersentaseDivisiCSI = JSON.parse('{!! json_encode($dataAveragePerDivisiCsi) !!}');

    const mappingDataPerDivisiForHighchart = dataPersentaseDivisiCSI.map(function(item){
        return {
            "name" : item.key,
            "data" : [item.persentasePerDivisi],
            "total" : item.totalPerDivisi
        }
    });
    document.addEventListener("DOMContentLoaded", () => {
        const card = document.querySelector('.card-body');
        card.classList.remove('d-none');
    });
    Highcharts.chart('persentase-total', {

        chart: {
            type: 'solidgauge',
            height: '65%',
        },

        title: {
            text: 'Average Penilaian WIKA Holding',
            style: {
                fontSize: '24px',
                fontWeight: 'bold'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '16px'
            },
            valueSuffix: '%',
            pointFormat: '{series.name}<br>' +
                '<span style="font-size: 2em; color: {point.color}; ' +
                'font-weight: bold">{point.y}</span>',
            positioner: function (labelWidth) {
                return {
                    x: (this.chart.chartWidth - labelWidth) / 2,
                    y: (this.chart.plotHeight / 2) + 15
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{
                outerRadius: '87%',
                innerRadius: '63%',
                backgroundColor: trackColors[0],
                borderWidth: 0
            }]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false,
                rounded: true
            }
        },

        colors: ["#61CB65", "#ED6D3F", "#F7C13E"],

        series: [{
            name: 'Tingkat Kepuasan',
            colorByPoint: true,
            data: [{
                radius: '87%',
                innerRadius: '63%',
                y: dataPersentaseTotal[1]
            }]
        }],

        credits: {
            enabled: false
        },
    });
</script>

<script>
    Highcharts.chart('persentase-divisi', {
        chart: {
            type: 'column',
            height: '65%',
        },
        title: {
            text: 'Average Penilaian CSI Per Divisi Operasi',
            align: 'center',
            style: {
                fontSize: '24px',
                fontWeight: 'bold'
            }
        },
        xAxis: {
            categories: ['Divisi'],
            crosshair: true,
            accessibility: {
                description: 'Divisi'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Tingkat Kepuasan (%)'
            }
        },
        tooltip: {
            valueSuffix: ' %'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        colors: ["#61CB65", "#00B2FF","#ED6D3F", "#F7C13E"],
        series: mappingDataPerDivisiForHighchart,
        credits:{
            enabled:false
        }
    });
</script>
@endsection

<!--end::Main-->
