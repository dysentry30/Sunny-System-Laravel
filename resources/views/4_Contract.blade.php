@extends('template.main')
@section('title', 'Contract Management')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Contract
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                {{-- <a href="contract-management/view" class="btn btn-sm btn-primary w-80px" id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                    New</a> --}}
                                <!--end::Button-->

                                <!--begin::Wrapper-->
                                {{-- <div class="me-4" style="margin-left:10px;">
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
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0" data-bs-toggle="modal" data-bs-target="#kt_modal_import" id="kt_toolbar_import">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                            </button>
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0" data-bs-toggle="modal" data-bs-target="#kt_modal_export" id="kt_toolbar_export">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                            </button>
                                            <!--end::Item-->
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

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">


                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-">

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

                                     <!--begin::Select Options-->
                                     <div style="" id="filterTahun" class="d-flex align-items-center position-relative me-3">
                                        <select id="tahun-proyek" name="tahun-proyek" onchange="this.form.submit()"
                                            class="form-select form-select-solid select2-hidden-accessible mx-3"
                                            data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected>{{date("Y")}}</option>
                                            @foreach ($tahun_proyeks as $tahun)
                                                    <option value="{{$tahun}}" {{$filterTahun == $tahun ? "selected" : ""}}>{{$tahun}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <!--end::Select Options-->

                                    <!--begin:: Input Filter-->
                                    <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select onchange="this.form.submit()" name="filter-unit" class="form-select form-select-solid w-200px ms-2"
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


                                    {{-- <script>
                                        function changes(e) {
                                            if (e.value == "unit_kerja") {
                                                document.getElementById("filterUnit").style.display = "";
                                                document.getElementById("filterJenis").style.setProperty("display", "none", "important");
                                                document.getElementById("filterJenis").value = "";
                                            } else {
                                                document.getElementById("filterJenis").style.display = "";
                                                document.getElementById("filterUnit").style.setProperty("display", "none", "important");
                                                document.getElementById("filterUnit").value = "";
                                            } 
                                        }
                                    </script> --}}
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
                                            window.location.href = "/contract-management";
                                        }
                                    </script>
                                    <!--end:: RESET-->
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
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" aria-selected="true" href="#kt_user_view_tender_awal"
                                                style="font-size:14px;">Perolehan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_pelaksanaan" style="font-size:14px;">Pelaksanaan</a>
                                        </li>
                                        <!--end:::Tab item -->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_closing_proyek" style="font-size:14px;">Pemeliharaan</a>
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
                                <div class="tab-pane fade show active" id="kt_user_view_tender_awal" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6" id="ccm-perolehan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Stage</th>
                                                <th class="min-w-auto">Jenis Proyek</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Tahun Perolehan</th>
                                                <th class="min-w-auto">Bulan Perolehan</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
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
                                                <tr>
                                                    <!--begin::Name=-->
                                                    @if (!empty($proyek))
                                                        <td>
                                                            <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->id_contract) }}" id="click-name"
                                                                class="text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a href="#" id="click-name" class="text-hover-primary"><small class="badge badge-light-danger">
                                                                    Belum Ditentukan
                                                                </small></a>
                                                        </td>
                                                    @endif
                                                    {{-- <td>
                                                        <a target="_blank" href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name" class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                    </td> --}}
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
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Tender Awal --}}

                                {{-- Begin :: Tab Content Pelaksanaan --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_pelaksanaan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table table-row-dashed" id="ccm-pelaksanaan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nomor Kontrak</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Jenis Proyek</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Tanggal Mulai</th>
                                                <th class="min-w-auto">Tanggal Selesai</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @forelse ($proyeks_pelaksanaan as $proyek)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    @if ($proyek->ContractManagements->no_contract != null)
                                                        <td>
                                                            <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->ContractManagements->id_contract) }}" id="click-name"
                                                                class="text-hover-primary">{{ $proyek->ContractManagements->no_contract }}</a>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->ContractManagements->id_contract) }}" id="click-name" class="text-hover-primary"><small class="badge badge-light-danger">
                                                                Belum Ditentukan</small></a>
                                                        </td>
                                                    @endif
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <p>{{ $proyek->nama_proyek }}</p>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Email-->
                                                    <td>
                                                        {{ $proyek->UnitKerja->unit_kerja }}
                                                    </td>
                                                    <!--end::Email-->

                                                    <!--begin::Email-->
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
                                                    <!--end::Email-->

                                                    <!--begin::Email-->
                                                    <td>
                                                        {{ number_format((int) $proyek->nilai_perolehan, 0, ".", ".") }}
                                                    </td>
                                                    <!--end::Email-->

                                                    <!--begin::Email-->
                                                    <td>
                                                        {{ Carbon\Carbon::create($proyek->tanggal_mulai_terkontrak)->translatedFormat("d F Y") ?? "-" }}
                                                    </td>
                                                    <!--end::Email-->

                                                    <!--begin::Email-->
                                                    <td>
                                                        {{ Carbon\Carbon::create($proyek->tanggal_akhir_terkontrak)->translatedFormat("d F Y") ?? "-" }}
                                                    </td>
                                                    <!--end::Email-->
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Pelaksanaan --}}

                                {{-- Begin :: Tab Content Closing Proyek --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_closing_proyek" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table table-row-dashed" id="ccm-pemeliharaan">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Nomor Kontrak</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">Jenis Proyek</th>
                                                <th class="min-w-auto">Nilai OK</th>
                                                <th class="min-w-auto">Tanggal Mulai</th>
                                                <th class="min-w-auto">Tanggal Selesai</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @forelse ($proyeks_pemeliharaan as $proyek)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    @if ($proyek->ContractManagements->no_contract != null)
                                                        <td>
                                                            <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->ContractManagements->id_contract) }}" id="click-name"
                                                                class="text-hover-primary">{{ $proyek->ContractManagements->no_contract }}</a>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a target="_blank" href="/contract-management/view/{{ url_encode($proyek->ContractManagements->id_contract) }}" id="click-name" class="text-hover-primary"><small class="badge badge-light-danger">
                                                                    Belum Ditentukan
                                                                </small></a>
                                                        </td>
                                                    @endif
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        {{ $proyek->nama_proyek }}
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Email-->
                                                    <td>
                                                        {{ $proyek->UnitKerja->unit_kerja }}
                                                    </td>
                                                    <!--end::Email-->
                                                    <!--begin::Jenis Proyek=-->
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
                                                    <!--end::Jenis Proyek=-->
                                                    <!--begin::Nilai OK=-->
                                                    <td>
                                                        {{ number_format((int) $proyek->nilai_perolehan, 0, ".", ".") }}
                                                    </td>
                                                    <!--end::Nilai OK=-->
                                                    <!--begin::Tanggal Mulai=-->
                                                    <td>
                                                        {{ $proyek->tanggal_mulai_terkontrak }}
                                                    </td>
                                                    <!--end::Tanggal Mulai=-->
                                                    <!--begin::Tanggal Selesai=-->
                                                    <td>
                                                        {{ $proyek->tanggal_akhir_terkontrak }}
                                                    </td>
                                                    <!--end::Tanggal Selesai=-->
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Closing Proyek --}}

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
            $('#ccm-perolehan, #ccm-pelaksanaan, #ccm-pemeliharaan').DataTable( {
                dom: '<"float-start"f><"#example"t>rtip',
                // dom: 'Brti',
                pageLength : 50,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data Tinjauan Dokumen Kontrak'
                    },
                        'copy', 'pdf', 'print'
                    ]
            } );
        });
    </script>
@endsection

<!--begin::modal DELETE-->
{{-- @foreach ($contracts as $contract)
	<form action="/contract-management/{{ $contract->id_contract }}/delete" method="post" enctype="multipart/form-data">
        @method('delete')
        @csrf
        <div class="modal fade" id="kt_modal_delete{{ $contract->id_contract }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Hapus : Nomor Kontrak {{ $contract->id_contract }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-lg"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
                        Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
                    </div>
                        <!--end::Input group-->
    
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    @endforeach --}}
<!--end::modal DELETE-->
