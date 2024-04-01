{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'History Autorisasi')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">History Autorisasi
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @canany(['super-admin', 'admin-crm'])
                            {{-- @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)")) --}}
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
                            {{-- @endif --}}
                            @endcanany
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                        <!--begin::Card body-->
                        <div class="card-body pt-6 pb-3 mb-0">
                            @canany(['super-admin', 'admin-crm'])
                            {{-- @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)")) --}}

                            <!--Begin :: Filter-->
                            <div class="card">
                                <div class="card-title">
                                    <form action="/history-autorisasi" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <p class="mt-3 text-end">Periode Otorisasi : </p>
                                            </div>
                                            <div class="col-3">
                                                <!--begin::Select Options-->
                                                <select id="periode-prognosa" name="periode-prognosa"
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
                                            
                                            <div class="col-3">
                                                <!--begin::Select Options-->
                                                <select id="tahun-prognosa" name="tahun-prognosa"
                                                    class="form-select form-select-solid w-100 ms-2 "
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Tahun" data-select2-id="select2-data-tahun" tabindex="-1"
                                                    aria-hidden="true">
                                                    @php
                                                    $startYear = 2023;
                                                    $currentYear = date('Y');
                                                    $diffYear = $currentYear - $startYear;
                                                    @endphp
                                                    <option value=""></option>
                                                    @foreach (range(1,$diffYear+1) as $thn)
                                                        <option value="{{ $startYear }}"
                                                            {{ $filterTahun == $startYear ? 'selected' : '' }}>{{ $startYear }}
                                                        </option>
                                                    @php
                                                        $startYear++;
                                                    @endphp
                                                    @endforeach
                                                </select>
                                                <!--end::Select Options-->
                                            </div>

                                            <div class="col">
                                                <!--begin::Select Options-->
                                                <select id="jenis-proyek" name="jenis-proyek"
                                                    class="form-select form-select-solid w-100 ms-2 "
                                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Jenis Proyek" data-select2-id="select2-jenis-proyek" tabindex="-1"
                                                    aria-hidden="true">
                                                        <option value=""></option>
                                                        <option value="All" {{ $jenisProyek == 'All' ? 'selected' : '' }}>All</option>
                                                        <option value="N" {{ $jenisProyek == 'N' ? 'selected' : '' }}>Eksternal</option>
                                                </select>
                                                <!--end::Select Options-->
                                            </div>
                                                
                                            <div class="col">
                                                <div class="d-flex flex-row gap-3">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                    <a href="/history-autorisasi" class="btn btn-light">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--End :: Filter-->
                            
                        </div>
                        <!--end::Card body-->
                        
                        <!--begin::Card body-->
                        <div class="card-body pt-0">

                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">@sortablelink('unit_kerja','Unit Kerja')</th>
                                        {{-- <th class="min-w-auto text-center">DOP</th> --}}
                                        <th class="min-w-auto text-center">Bulan Pelaporan</th>
                                        <th class="min-w-auto text-center">Tahun Pelaporan</th>
                                        {{-- <th class="min-w-auto text-center">Total OK Review</th> --}}
                                        <th class="min-w-auto text-center">Total OK Awal</th>
                                        <th class="min-w-auto text-center">Total Forecast</th>
                                        <th class="min-w-auto text-center">Total Realisasi</th>
                                        <th class="min-w-auto text-center">Tanggal Locked</th>
                                        <th class="min-w-auto text-center">Tanggal Unlocked</th>
                                        <th class="min-w-auto text-center">Is Approve</th>
                                        {{-- <th class="min-w-auto text-center">@sortablelink('is_active','Is Locked')</th> --}}
                                        {{-- <th class="text-center">Action</th>
                                        <th class="text-center">Settings</th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($history_forecasts as $unit_kerja => $history)
                                        <tr>
                                            <td class="">
                                                <a target="_blank" href="/history-autorisasi/{{$history->first()->divcode}}/{{$jenisProyek}}/{{$periodeOtor}}/{{ $filterTahun }}/detail" id="click-name"
                                                    class="text-hover-primary mb-1">{{ $unit_kerja }}</a>
                                            </td>
                                            {{-- <td class="text-center">
                                                {{$history->dop}}
                                            </td> --}}
                                            <td class="text-center">
                                                @php
                                                    $periode_prognosa = $history->first()->periode_prognosa;
                                                @endphp
                                                @switch($periode_prognosa)
                                                    @case('1')
                                                    Januari
                                                    @break
                                                    
                                                    @case('2')
                                                    Februari
                                                    @break
                                                    
                                                    @case('3')
                                                    Maret
                                                    @break
                                                    
                                                    @case('4')
                                                    April
                                                    @break

                                                    @case('5')
                                                    Mei
                                                    @break

                                                    @case('6')
                                                        Juni
                                                    @break

                                                    @case('7')
                                                    Juli
                                                    @break
                                                    
                                                    @case('8')
                                                    Agustus
                                                    @break
                                                    
                                                    @case('9')
                                                    September
                                                    @break
                                                    
                                                    @case('10')
                                                    Oktober
                                                    @break
                                                    
                                                    @case('11')
                                                    November
                                                    @break
                                                    
                                                    @case('12')
                                                    Desember
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="text-center">
                                                {{-- {{ Carbon\Carbon::create($history->first()->created_at)->translatedFormat("Y")}} --}}
                                                {{ $filterTahun }}
                                                {{-- 2022 --}}
                                            </td>
                                            {{-- <td class="text-center">
                                                {{ number_format((int) $history->sum(function($f) {
                                                    return (int) $f->nilaiok_review;
                                                }), 0, ".", ".") }}
                                            </td> --}}
                                            <td class="text-end">
                                                {{number_format((int) $history->where("is_rkap", "=", True)->sum(function($f) {
                                                    return (int) $f->rkap_forecast;
                                                }), 0, ".", ".")}}
                                                {{-- {{number_format((int) $history->sum(function($f) {
                                                    return (int) $f->nilaiok_awal;
                                                }), 0, ".", ".")}} --}}
                                            </td>
                                            <td class="text-end">
                                                {{number_format((int) $history->sum(function($f) {
                                                    return (int) $f->nilai_forecast;
                                                }), 0, ".", ".")}}
                                            </td>
                                            <td class="text-end">
                                                {{number_format((int) $history->where("stage", "=", 8)->sum(function($f) use($periodeOtor) {
                                                    if($f->month_realisasi <= $periodeOtor) {
                                                        return (int) $f->realisasi_forecast;
                                                    }
                                                }), 0, ".", ".")}}
                                            </td>
                                            <td class="text-center">
                                                {{-- @dd($history->first()) --}}
                                                {{Carbon\Carbon::parse($history->first()->created_at)->translatedFormat("d F Y")}}
                                            </td>
                                            <td class="">
                                                @if($history->first()->is_request_unlock == "t")
                                                    {{Carbon\Carbon::parse($history->first()->updated_at)->translatedFormat("d F Y")}}
                                                @else 
                                                    <span class="badge badge-danger">Not request for unlock</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                @if($history->first()->is_approved_1 == null) 
                                                    <span class="badge badge-info">Pending</span>
                                                @else
                                                    @if($history->first()->is_approved_1 == true)
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-danger">Not Approve</span>
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- <td class="text-center">
                                                {{$history->dop}}
                                                Yes
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                    @php
                                        $total_rkap = $history_forecasts->sum(function ($f) {
                                            return $f->where("is_rkap", "=", true)->sum(function($f) {
                                                return (int) $f->rkap_forecast;
                                            });
                                        });
                                        $total_forecast = $history_forecasts->sum(function ($f) {
                                            return $f->where("is_cancel", "=", false)->sum(function($f) {
                                                return (int) $f->nilai_forecast;
                                            });
                                        });
                                        $total_realisasi = $history_forecasts->sum(function ($f) use($periodeOtor) {
                                            return $f->where("stage", "=", 8)->sum(function($f) use($periodeOtor) {
                                                if($f->month_realisasi <= $periodeOtor) {
                                                    return (int) $f->realisasi_forecast;
                                                }
                                            });
                                        });
                                    @endphp
                                    <tr class="bg-dark">
                                        <td class="text-white">Total</td>
                                        <td colspan="2"></td>
                                        <td class="text-end text-white">{{ number_format($total_rkap, 0, ".", "."); }}</td>
                                        <td class="text-end text-white">{{ number_format($total_forecast, 0, ".", "."); }}</td>
                                        <td class="text-end text-white">{{ number_format($total_realisasi, 0, ".", "."); }}</td>
                                    </tr>
                                    {{-- @foreach ($proyeks as $proyekArray)
                                        @foreach ($proyekArray as $proyek)
                                        <tr>
                                            <!--begin::Name-->
                                            <td class="">
                                                <a href="#" id="click-name"
                                                    class="text-gray-600 text-hover-primary mb-1">{{ $proyek->first()->UnitKerja->unit_kerja }}</a>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Pelaksanaan-->
                                            <td class="text-center">
                                                    {{ $proyek->first()->tahun_perolehan }}
                                            </td>
                                            <!--end::Pelaksanaan-->
                                            <!--begin::Coloumn-->
                                            @php
                                                $total_ok_awal = 0;
                                                $total_ok_review = 0;
                                                foreach ($proyek as $proyekTotal) {
                                                        $total_ok_awal += (int) str_replace(",", "", $proyekTotal->nilaiok_awal);
                                                        $total_ok_review += (int) str_replace(",", "", $proyekTotal->nilaiok_review);
                                                    }
                                                // dump($total_ok_awal, $total_ok_review);
                                                // dd();
                                                $total_ok_awal = number_format($total_ok_awal, 0, ",");
                                                $total_ok_review = number_format($total_ok_review, 0, ",");
                                            @endphp
                                            <td class="text-end">
                                                {{ $total_ok_awal }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td class="text-end">
                                                {{ $total_ok_review }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td class="text-center">
                                                {{ $proyek->first()->UnitKerja->is_active == 1 ? "Yes" : "No" }}
                                            </td>
                                            <!--end::Coloumn-->

                                        </tr>
                                        @endforeach
                                    @endforeach --}}
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                            
                            {{-- @endif --}}
                            @endcanany
                        </div>
                        <!--end::Card body-->
                        
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
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    
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