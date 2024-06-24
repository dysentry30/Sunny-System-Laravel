{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'History Laporan Autorisasi')
{{-- End::Title --}}

<style>
        .buttons-html5 {
            border-radius: 5px !important;
            border: none !important;
            font-weight: normal !important;
        }
        .buttons-colvis {
            border: none !important;
            border-radius: 5px !important;
        }
</style>

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
                                <h1 class="d-flex align-items-center fs-3 my-1">History Laporan Autorisasi
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @if (Auth::user()->canany(['super-admin', 'admin-crm']))
                                <!--begin::Actions-->
                                {{-- <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 7px 30px 7px 30px">
                                        New</a>

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
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                        <div class="card-title mt-5">
                            <form action="/history-autorisasi" method="get">
                                <div class="row">
                                    <div class="col-2">
                                        <p class="mt-3 text-end">Periode Otorisasi : </p>
                                    </div>
                                    <div class="col-3">
                                        <!--begin::Select Options-->
                                        <select onchange="this.form.submit()" id="periode-prognosa" name="periode-prognosa"
                                            class="form-select form-select-solid w-100 ms-2 "
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                            data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                            aria-hidden="true">
                                            <option {{ $periodeOtor == '' ? 'selected' : '' }}></option>
                                            <option value="1" {{ $periodeOtor == 1 ? 'selected' : '' }}>Januari</option>
                                            <option value="2" {{ $periodeOtor == 2 ? 'selected' : '' }}>Februari</option>
                                            <option value="3" {{ $periodeOtor == 3 ? 'selected' : '' }}>Maret</option>
                                            <option value="4" {{ $periodeOtor == 4 ? 'selected' : '' }}>April</option>
                                            <option value="5" {{ $periodeOtor == 5 ? 'selected' : '' }}>Mei</option>
                                            <option value="6" {{ $periodeOtor == 6 ? 'selected' : '' }}>Juni</option>
                                            <option value="7" {{ $periodeOtor == 7 ? 'selected' : '' }}>Juli</option>
                                            <option value="8" {{ $periodeOtor == 8 ? 'selected' : '' }}>Agustus</option>
                                            <option value="9" {{ $periodeOtor == 9 ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ $periodeOtor == 10 ? 'selected' : '' }}>Oktober</option>
                                            <option value="11" {{ $periodeOtor == 11 ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ $periodeOtor == 12 ? 'selected' : '' }}>Desember</option>
                                        </select>
                                        <!--end::Select Options-->
                                    </div>

                                    {{-- <div class="col">
                                        <!--begin::Select Options-->
                                        <select onchange="this.form.submit()" id="jenis-proyek" name="jenis-proyek"
                                            class="form-select form-select-solid w-100 ms-2 "
                                            style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                            data-placeholder="Jenis Proyek" data-select2-id="select2-jenis-proyek" tabindex="-1"
                                            aria-hidden="true">
                                                <option value=""></option>
                                                <option value="All" {{ $jenisProyek == 'All' ? 'selected' : '' }}>All</option>
                                                <option value="N" {{ $jenisProyek == 'N' ? 'selected' : '' }}>Eksternal</option>
                                        </select>
                                        <!--end::Select Options-->
                                    </div> --}}
                                        
                                    <div class="col">
                                        <form action=""></form>
                                        <form action="" method="GET">
                                            <button type="submit" class="btn btn-light">Reset</button>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (Auth::user()->canany(['super-admin', 'admin-ccm']))
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="overflow-scroll">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="{{ $historyClaims->isNotEmpty() && strlen($historyClaims->first()->unit_kerja) != 1 ? "example" : "examples" }}">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            @if ($historyClaims->isNotEmpty() && strlen($historyClaims->first()->unit_kerja) != 1)
                                            <th rowspan="3" class="min-w-auto text-center align-middle">Profit Center</th>
                                            <th rowspan="3" class="min-w-auto text-center align-middle">Unit Kerja</th>
                                            @endif
                                            <th rowspan="3" class="min-w-auto text-center align-middle">{{ $historyClaims->isNotEmpty() && strlen($historyClaims->first()->unit_kerja) == 1 ? "Unit Kerja" : "Nama Proyek" }}</th>
                                            <th rowspan="3" class="min-w-auto text-center align-middle">Bulan Pelaporan</th>
                                            @if ($historyClaims->isNotEmpty() && strlen($historyClaims->first()->unit_kerja) == 1)
                                            <th rowspan="3" class="min-w-auto text-center align-middle">Status</th>
                                            @endif
                                            <th colspan="4" class="min-w-auto text-center">VO</th>
                                            <th colspan="4" class="min-w-auto text-center">Klaim</th>
                                            <th colspan="4" class="min-w-auto text-center">Anti Klaim</th>
                                            <th colspan="4" class="min-w-auto text-center">Klaim Asuransi</th>
                                        </tr>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                        </tr>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            {{-- <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th> --}}
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                            {{-- <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th> --}}
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @foreach ($historyClaims as $key => $item)
                                        @php
                                            if ($item->is_approved) {
                                                $style = "badge-success";
                                                $text = "Approved";
                                            }elseif ($item->is_locked) {
                                                $style = "badge-primary";
                                                $text = "Waiting for Approval";
                                            }else {
                                                $style = "badge-warning";
                                                $text = "Request Unlock";
                                            }
                                        @endphp
                                            <tr>
                                                @if (strlen($item->unit_kerja) != 1)
                                                <td class="text-center">{{ $item->profit_center }}</td>
                                                <td class="text-center">{{ $item->unit_kerja }}</td>
                                                @endif
                                                @if (strlen($item->unit_kerja) == 1)
                                                <td class="text-center">
                                                    <a href="/history-laporan-approval/{{ $item->unit_kerja }}/{{ $periodeOtor }}" class="text-hover-primary">{{ $key }}</a>
                                                </td>
                                                @else
                                                <td class="text-start">{{ $key }}</td>
                                                @endif
                                                <td class="text-center">{{ $item->periode_laporan }}</td>
                                                @if (strlen($item->unit_kerja) == 1)
                                                <td class="text-center"><p class="m-0 badge badge-sm {{ $style }}">{{ $text }}</p></td>
                                                @endif
                                                <td class="text-center">{{ number_format($item->total_vo_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_vo_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_vo_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_vo_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_klaim_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_klaim_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_klaim_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_klaim_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_anti_klaim_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_anti_klaim_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_anti_klaim_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_anti_klaim_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_klaim_asuransi_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_klaim_asuransi_submitted, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->total_klaim_asuransi_approved, 0, ".", ".") }}</td>
                                                <td class="text-center">{{ number_format($item->jumlah_klaim_asuransi_approved, 0, ".", ".") }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table Footer-->
                                    <tfoot>
                                        <tr>
                                            <td colspan="{{ $historyClaims->isNotEmpty() && strlen($historyClaims->first()->unit_kerja) == 1 ? "3" : "4" }}" class="text-center">TOTAL</td>
                                            <td class="text-center">{{ number_format($totalItemVOAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahVOAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemVOAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahVOAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemKlaimAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahKlaimAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemKlaimAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahKlaimAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemAntiKlaimAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahAntiKlaimAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemAntiKlaimAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahAntiKlaimAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemKlaimAsuransiAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahKlaimAsuransiAll, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($totalItemKlaimAsuransiAllApproved, 0, ".", ".") }}</td>
                                            <td class="text-center">{{ number_format($jumlahKlaimAsuransiAllApproved, 0, ".", ".") }}</td>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table Footer-->
                                </table>
                                <!--end::Table-->
                            </div>
                            
                        </div>
                        <!--end::Card body-->
                        @endif
                        
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->


                
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

@endsection
@section('js-script')

    <!--begin::Data Tables-->
    <script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset("/datatables/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset("/datatables/buttons.html5.min.js") }}"></script>
    <script src="{{ asset("/datatables/buttons.colVis.min.js") }}"></script>
    <script src="{{ asset("/datatables/jszip.min.js") }}"></script>
    <script src="{{ asset("/datatables/pdfmake.min.js") }}"></script>
    <script src="{{ asset("/datatables/vfs_fonts.js") }}"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                pageLength : 20,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    <!--end::Data Tables-->

@endsection