{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Detail Kompetitor')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    {{-- @dd(memory_get_usage(true)) --}}
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
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
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Detail Kompetitor <b>{{ ' - '. $customer->name }}</b>
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">
                                <!--begin::Button-->
                                {{-- <button onclick="document.location.reload()" type="reset" class="btn btn-sm btn-light btn-active-danger pe-3 mx-2" id="cancel-button">
                                    Discard <i class="bi bi-x"></i></button> --}}
                                <!--end::Button-->

                                <!--begin::Button-->
                                <a href="/competitor" class="btn btn-sm btn-light btn-active-primary ms-3" id="customer-edit-close">Close</a>
                                <!--end::Button-->
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid">
                            <!--begin::Contacts App- Edit Contact-->
                            <div class="row g-7">
                                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                    <!--begin::Card Body-->
                                    <div class="card-body pt-5">
                                        <!--begin:::Tabs Navigasi-->
                                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                            <!--begin:::Tab item Pasar Dini-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                    href="#kt_user_view_overview_information"
                                                    style="font-size:14px;">Competitor Information</a>
                                            </li>
                                            <!--end:::Tab item Pasar Dini-->
                                        </ul>
                                        <!--END:::Tabs Navigasi-->
                                        <!--Begin::Tabs Show-->
                                        <div class="tab-pane fade show active" id="kt_user_view_overview_information" role="tabpanel">
                                            <div class="row fv-row">
                                                <div class="col-4">
                                                    <figure class="highcharts-figure">
                                                        <div id="pie-chart"></div>
                                                    </figure>
                                                </div>
                                                <div class="col-8">
                                                    <h3>List Proyek</h3>
                                                    <br>
                                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                                <th class="min-w-auto text-white">No.</th>
                                                                <th class="min-w-auto text-white">Nama Proyek</th>
                                                                <th class="min-w-auto text-white">Stage</th>
                                                                <th class="min-w-auto text-white">Status</th>
                                                                <th class="min-w-auto text-white">Keterangan</th>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody>
                                                            @foreach ($listTender as $index => $item)
                                                            <tr>
                                                                <td class="align-midlle text-center">{{ $index+1 }}</td>
                                                                <td class="align-midlle"><a target="_blank" href="/proyek/view/{{ $item->Proyek?->kode_proyek }}" class="text-hover-primary">{{ $item->Proyek?->nama_proyek }}</a></td>
                                                                <td class="align-middle text-center">
                                                                    @switch($item->Proyek?->stage)
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
                                                                <td class="align-midlle text-center">{{ $item->status }}</td>
                                                                <td class="align-midlle text-center">{{ $item->keterangan }}</td>
                                                            </tr>                                                                
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Tabs Show-->
                                    </div>
                                    <!--end::Card Body-->
                                </div>
                            </div>
                            <!--end::Contacts App- Edit Contact-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--begin::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
@endsection
<!--end::Main-->

@section('js-script')

<script src="/js/highcharts/highcharts.js"></script>
<script src="/js/highcharts/series-label.js"></script>
<script src="/js/highcharts/exporting.js"></script>
<script src="/js/highcharts/export-data.js"></script>
<script src="/js/highcharts/drilldown.js"></script>
<script src="/js/highcharts/funnel.js"></script>
<script src="/js/highcharts/accessibility.js"></script>
<script src="/js/highcharts/highcharts-3d.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<script>
    $('#example').DataTable({
        dom: 'rftip'
    });
</script>

<script>
    Highcharts.setOptions({
        chart: {
            style: {
                fontFamily: 'Poppins'
            }
        }
    });
</script>

<script>
    const dataChart = JSON.parse('{!! $dataPieChart !!}');
    console.log(dataChart);
    const pieChartCompetitiveIndex = Highcharts.chart('pie-chart', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        align: 'center',
        text: '<b class="h1">Competitive Index</b>'
    },
    subtitle: {
        align: 'center',
        text: 'Jumlah Tender Diikuti : ' + dataChart['totalTender']
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
        pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b>'
    },

    series: [{
        name: "Competitive Index",
        colorByPoint: true,
        data: [
            {
                name: "Menang : " + dataChart['jumlahMenang'],
                y: dataChart['jumlahMenang'],
                drilldown: "Menang",
            },
            {
                name: "Kalah : " + dataChart['jumlahKalah'],
                y: dataChart['jumlahKalah'],
                drilldown: "Kalah",
            },
        ]
    }],
    credits: {
        enabled: false
    },
});
</script>

@endsection