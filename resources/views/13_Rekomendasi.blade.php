@extends('template.main')
@section('title', 'Nota Rekomendasi')
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
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Nota Rekomendasi</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">


                        <!--begin::Card header-->
                        <div class="card-header border-0">

                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    {{-- <select style="display: none !important" id="column" name="column" onchange="changes(this)"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>

                                    </select> --}}
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    {{-- <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unitkerjas as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnit == $unitkerja->divcode ? 'selected' : '' }}>
                                                    {{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="filterJenis" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter-jenis"
                                            class="form-select form-select-solid select2-hidden-accessible w-auto ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek"
                                            tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            <option value="I" {{ $filterJenis == 'I' ? 'selected' : '' }}>Internal</option>
                                            <option value="N" {{ $filterJenis == 'N' ? 'selected' : '' }}>External</option>
                                            <option value="J" {{ $filterJenis == 'J' ? 'selected' : '' }}>JO</option>
                                        </select>
                                    </div>
                                    <!--end:: Input Filter-->

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/rekomendasi";
                                        }
                                    </script>
                                    <!--end:: RESET--> --}}
                                </form>
                                <!--end:: BUTTON FILTER-->
                            </div>
                            <!--begin::Card title-->

                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" aria-selected="true" href="#kt_user_view_pengajuan"
                                                style="font-size:14px;">Pengajuan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_persetujuan" style="font-size:14px;">Persetujuan</a>
                                        </li>
                                        <!--end:::Tab item -->
                                    </ul>

                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div id="tab-content" class="tab-content">
                                {{-- Begin :: Tab Content Tender Awal --}}
                                <div class="tab-pane fade show active" id="kt_user_view_pengajuan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="rekomendasi-pengajuan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Lokasi</th>
                                                <th class="min-w-auto">Pemberi Kerja</th>
                                                <th class="min-w-auto">Instansi</th>
                                                <th class="min-w-auto">Sumber Dana</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Kategori Proyek</th>
                                                <th class="min-w-auto">Mangusulkan</th>
                                                <th class="min-w-auto">Status</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        {{-- <tbody class="fw-bold text-gray-600 fs-6">
                                            @forelse ($proyeks_perolehan as $proyek)
                                                @php
                                                    $total_forecast = $proyek->Forecasts->filter(function($f) {
                                                        $date = date_create($f->created_at);
                                                        return $f->periode_prognosa == (int) date("m") && date_format($date, "Y") == date("Y");
                                                    })->sum(function($f) {
                                                        return (int) $f->nilai_forecast;
                                                    });
                                                    // @dump($total_forecast)
                                                    if ($total_forecast == 0) {
                                                        $total_forecast = $proyek->nilai_rkap;
                                                    }
                                                @endphp
                                                @if ($total_forecast > 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        @if (!empty($proyek->ContractManagements))
                                                            <td>
                                                                <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->ContractManagements->id_contract) }}" id="click-name"
                                                                    class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <a href="#" id="click-name" class="text-hover-primary"><small class="badge badge-light-danger">
                                                                        Belum Ditentukan
                                                                    </small></a>
                                                            </td>
                                                        @endif
                                                        <!--end::Name=-->
                                                        <!--begin::Email-->
                                                        <td>
                                                            {{ $proyek->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email-->
                                                        <!--begin::Stage-->
                                                        <td>
                                                            @switch($proyek->stage)
                                                                @case('0')
                                                                    Gugur PQ
                                                                @break

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

                                                                @case('10')
                                                                    Gugur PQ
                                                                @break

                                                                @default
                                                                    *Belum Ditentukan
                                                            @endswitch
                                                        </td>
                                                        <!--end::Stage-->
                                                        <!--begin::Jenis-->
                                                        <td>
                                                            @switch($proyek->jenis_proyek)
                                                                @case('I')
                                                                    Internal
                                                                @break

                                                                @case('N')
                                                                    Eksternal
                                                                @break

                                                                @case('J')
                                                                    JO
                                                                @break

                                                            @endswitch
                                                        </td>
                                                        <!--end::Jenis-->
                                                        <!--begin::Forecast-->
                                                        <td class="text-end">
                                                            <small>
                                                                {{ number_format((int)$total_forecast, 0, '.', '.') ?? '-' }}
                                                            </small>
                                                        </td>
                                                        <!--end::Forecast-->
                                                        <!--begin::Email-->
                                                        <td>
                                                            {{ $proyek->tahun_perolehan }}
                                                        </td>
                                                        <!--end::Email-->
                                                        <!--begin::Email-->
                                                        <td>
                                                            {{ Carbon\Carbon::create(date("Y") ,$proyek->bulan_pelaksanaan)->translatedFormat("F") }}
                                                        </td>
                                                        <!--end::Email-->
                                                    </tr>
                                                @endif
                                            @empty
                                            @endforelse
                                        </tbody> --}}
                                        
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @if (!empty($proyeks))
                                            @forelse ($proyeks as $proyek)
                                            <tr>
                                                <td>
                                                    <small>{{ $proyek->nama_proyek }}</small>
                                                </td>
                                                <td>
                                                    <small>{{ $proyek->lokasi_tender }}</small>
                                                </td>
                                                <td>
                                                    <small>masih hardcode</small>
                                                </td>
                                                <td>
                                                    <small>masih hardcode</small>
                                                </td>
                                                <td>
                                                    <small>{{ $proyek->sumber_dana }}</small>
                                                </td>
                                                <td>
                                                    <small>{{ number_format((int)$proyek->nilaiok_awal, 0, '.', '.' ?? '0'); }}</small>
                                                </td>
                                                <td>
                                                    <small>
                                                        @switch($proyek->tipe_proyek)
                                                            @case('R')
                                                                Retail
                                                                @break
                                                            @case('P')
                                                                Non-Retail
                                                                @break
                                                            @default
                                                                *Belum Ditentukan
                                                        @endswitch
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>masih hardcode</small>
                                                </td>
                                                <td>
                                                    <small>masih hardcode</small>
                                                </td>
                                            </tr>
                                            @empty
                                                <td><p>There is no data</p></td>
                                            @endforelse
                                            @else
                                            <td><p>There is no data</p></td>
                                            @endif
                                            
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Tender Awal --}}
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

    <!--end::Modals-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    <!--end::Data Tables-->

    <script>
        $(document).ready(function() {
            $('#rekomendasi-pengajuan').DataTable( {
                // dom: '<"float-start"f><"#example"t>rtip',
                // dom: 'Brti',
                dom: 'frtip',
                scrollY : "1000px",
                scrollX : true,
                scrollCollapse: true,
                paging : false,
                pageLength : 20,
            } );
        });
    </script>
@endsection

