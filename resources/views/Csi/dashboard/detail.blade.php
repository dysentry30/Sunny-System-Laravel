{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Dashboard CSI Detail')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard CSI - {{ $unitKerja }}
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--Begin::Button-->
                            <div class="d-flex align-items-center">
                                <a href="/csi/dashboard" class="btn btn-sm btn-primary text-end">Close</a>
                            </div>
                            <!--end::Button-->
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
                                    <a href="/csi/dashboard/{{ $unitKerja }}" class="btn btn-sm btn-secondary align-middle">Reset</a>
                                </form>
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 d-none">
                            <div class="row fv-row">

                                <!--Begin::Dashboard Sisi Kiri-->
                                <div class="col-6">
                                    <h3>A. MUTU PRODUK, MUTU WAKTU, SHE</h3>
                                     <!--begin::Table-->
                                     <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">No.</th>
                                                <th class="min-w-auto text-white">Uraian</th>
                                                <th class="min-w-auto text-white">Presentase Pencapaian</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td class="text-start">Mutu Hasil Pekerjaan</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[0] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td class="text-start">Pencapaian progress pekerjaan dalam penyelesaisan proyek</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[1] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3.</td>
                                                <td class="text-start">Kelengkapan alat - alat pelindung diri</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[2] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4.</td>
                                                <td class="text-start">Pemasangan rambu - rambu SHE</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[3] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5.</td>
                                                <td class="text-start">Kepatuhan pekerja dalam pemakaian alat - alat pelindung diri</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[4] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6.</td>
                                                <td class="text-start">Pengelolaan sampah dan limbah B3</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[5] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">7.</td>
                                                <td class="text-start">Penanganan keluhan masyarakat yang berhubungan dengan lingkungan sekitar proyek</td>
                                                <td class="text-center">{{ $nilaiRadarKanan[6] }}%</td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--begin::Table-->

                                    <br>
                                    <br>

                                    <figure class="highcharts-figure">
                                        <div id="radar-kiri"></div>
                                    </figure>
                                </div>
                                <!--End::Dashboard Sisi Kiri-->



                                <!--Begin::Dashboard Sisi Kanan-->
                                <div class="col-6">
                                    <h3>B. MUTU PELAYANAN</h3>
                                    <!--begin::Table-->
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example2">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">No.</th>
                                                <th class="min-w-auto text-white">Uraian</th>
                                                <th class="min-w-auto text-white">Presentase Pencapaian</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td class="text-start">Kerjasama, komunikasi, koordinasi</td>
                                                <td class="text-center">{{ $nilaiRadarKiri[0] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td class="text-start">Respon dalam penanganan dan penyelesaian permasalahan</td>
                                                <td class="text-center">{{ $nilaiRadarKiri[1] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3.</td>
                                                <td class="text-start">Ketepatan komitmen yang dijanjikan</td>
                                                <td class="text-center">{{ $nilaiRadarKiri[2] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4.</td>
                                                <td class="text-start">Tertib administrasi</td>
                                                <td class="text-center">{{ $nilaiRadarKiri[3] }}%</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5.</td>
                                                <td class="text-start">Profesionalisme sumber daya manusia WIKA di proyek</td>
                                                <td class="text-center">{{ $nilaiRadarKiri[4] }}%</td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--begin::Table-->

                                    <br>
                                    <br>

                                    <figure class="highcharts-figure">
                                        <div id="radar-kanan"></div>
                                    </figure>
                                </div>
                                <!--End::Dashboard Sisi Kanan-->

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
        $('#example2').DataTable({
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
    const radarKanan = JSON.parse('{!! json_encode($nilaiRadarKanan) !!}');
    const radarKiri= JSON.parse('{!! json_encode($nilaiRadarKiri) !!}');

    document.addEventListener("DOMContentLoaded", () => {
        const card = document.querySelector('.card-body');
        card.classList.remove('d-none');
    });
</script>

<script>
    Highcharts.chart('radar-kiri', {
        chart: {
            polar: true,
            type: 'line'
        },

        pane: {
            size: '80%'
        },

        title: {
            text: ''
        },

        xAxis: {
            categories: [
                'Mutu Hasil Pekerjaan',
                'Pencapaian progress pekerjaan dalam penyelesaisan proyek',
                'Kelengkapan alat - alat pelindung diri',
                'Pemasangan rambu - rambu SHE',
                'Kepatuhan pekerja dalam pemakaian alat - alat pelindung diri',
                'Pengelolaan sampah dan limbah B3',
                'Penanganan keluhan masyarakat yang berhubungan dengan lingkungan sekitar proyek',
            ],
            tickmarkPlacement: 'on',
            lineWidth: 0
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0,
            tickPositions: [0, 20, 40, 60, 80, 100]
        },

        tooltip: {
            shared: false,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>' +
                '{point.y:,.2f}%</b><br/>'
        },

        legend: {
            align: 'center',
            verticalAlign: 'bottom',
            layout: 'vertical'
        },

        series: [{
            name: 'Persentase Pencapaian',
            data: radarKanan,
            pointPlacement: 'on'
        }],

        credits: {
            enabled: false
        },
    });
</script>

<script>
    Highcharts.chart('radar-kanan', {
        chart: {
            polar: true,
            type: 'line'
        },

        pane: {
            size: '80%'
        },

        title: {
            text: ''
        },

        xAxis: {
            categories: [
                'Kerjasama, komunikasi, koordinasi',
                'Respon dalam penanganan dan penyelesaian permasalahan',
                'Ketepatan komitmen yang dijanjikan',
                'Tertib administrasi',
                'Profesionalisme sumber daya manusia WIKA di proyek',
            ],
            tickmarkPlacement: 'on',
            lineWidth: 0
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0,
            tickPositions: [0, 20, 40, 60, 80, 100]
        },

        tooltip: {
            shared: false,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>' +
                '{point.y:,.2f}%</b><br/>'
        },

        legend: {
            align: 'center',
            verticalAlign: 'bottom',
            layout: 'vertical'
        },

        colors: ["#ED6D3F", "#F7C13E"],

        series: [{
            name: 'Persentase Pencapaian',
            data: radarKiri,
            pointPlacement: 'on'
        }],

        credits: {
            enabled: false
        },
    });
</script>
    
@endsection

<!--end::Main-->
