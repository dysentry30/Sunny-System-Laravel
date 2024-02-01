{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Group RKAP')
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


                <!--begin::Delete Alert -->
                {{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
                <!--end::Delete Alert -->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center w-100 justify-content-between flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Group RKAP | {{ $rkaps->unit_kerja }}</h1>
                                <!--end::Title-->

                                {{-- Begin :: Close Button --}}
                                <a href="/rkap" class="btn btn-sm btn-active-primary"
                                    style="background-color: #f5f8fa;">Close</a>
                                {{-- End :: Close Button --}}
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                        {{-- Begin :: Card Header --}}
                        <div class="card-header py-10 "></div>
                        {{-- End :: Card Header --}}

                        <!--begin::Card Tittle-->
                        <div class="card-body py-10">
                            <!--begin::Content-->
                            <div class="col-xl-15">
                                <!--begin::Contacts-->
                                <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                    <!--begin::Card body-->
                                    <div class="card-body" style="padding: 1rem;">
                                        {{-- @if (auth()->user()->check_administrator) --}}
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">Kode Proyek</th>
                                                        <th class="min-w-auto">Proyek</th>
                                                        <th class="min-w-auto text-center">Jenis Proyek</th>
                                                        <th class="min-w-auto text-center">Tipe Proyek</th>
                                                        <th class="min-w-auto text-end">Total OK Awal</th>
                                                        <th class="min-w-auto text-end">Total OK Review</th>
                                                        <th class="min-w-auto text-center">Bulan Perolehan</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @forelse ($proyeks as $proyek)
                                                        <tr>
                                                            <!--begin::Name-->
                                                            <td class="">
                                                                <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                    id="click-name"
                                                                    class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                            </td>
                                                            <!--end::Name-->
                                                            <!--begin::Pelaksanaan-->
                                                            <td class="">
                                                                <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                    id="click-name"
                                                                    class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                            </td>
                                                            <!--end::Pelaksanaan-->

                                                            <!--begin::Pelaksanaan-->
                                                            <td class="text-center">
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

                                                                    @default
                                                                @endswitch
                                                            </td>
                                                            <!--end::Pelaksanaan-->

                                                            <!--begin::Coloumn-->
                                                            <td class="text-center">
                                                                @switch($proyek->tipe_proyek)
                                                                    @case('R')
                                                                        Retail
                                                                    @break

                                                                    @case('P')
                                                                        Non-Retail
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </td>
                                                            <!--end::Coloumn-->

                                                            <!--begin::Coloumn-->
                                                            <td class="text-end">
                                                                {{-- @php
                                                                    $total_ok_awal = 0;
                                                                    $total_ok_awal += $proyek->Forecasts->where("tahun", "=", (int) date("Y"))->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                                                        return (int) $f->rkap_forecast;
                                                                    });
                                                                    // foreach ($proyek as $proyekTotal) {
                                                                    //         return (int) $f->rkap_forecast;
                                                                    //     });
                                                                    //     // $total_ok_review += (int) str_replace(",", "", $proyekTotal->nilaiok_review);
                                                                    // }
                                                                @endphp --}}
                                                                {{ number_format((int)$proyek->nilai_rkap, 0, '.', '.') ?? '-' }}
                                                                {{-- {{ number_format((int)$total_ok_awal, 0, '.', '.') ?? '-' }} --}}
                                                            </td>
                                                            <!--end::Coloumn-->
                                                            <!--begin::Coloumn-->
                                                            <td class="text-end">
                                                                {{ number_format((int)$proyek->nilaiok_review, 0, '.', '.') ?? '-' }}
                                                            </td>
                                                            <!--end::Coloumn-->
                                                            <!--begin::Coloumn-->
                                                            <td class="text-center">
                                                                {{ Carbon\Carbon::create()->month($proyek->bulan_pelaksanaan)->translatedFormat('F') }}
                                                            </td>
                                                            <!--end::Coloumn-->

                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center bg-gray-100">Data tidak
                                                                ditemukan</td>
                                                        </tr>
                                                    @endforelse

                                                    @if (!empty($proyeks) || $proyeks->isNotEmpty())
                                                        <tr>
                                                            <td colspan="4" class="bg-dark text-white"><b class="px-3">Total</b></td>
                                                            <td class="bg-dark text-white text-end">{{ number_format((int)$proyeks->sum('nilai_rkap'), 0, '.', '.') ?? '0' }}</td>
                                                            <td class="bg-dark text-white text-end">{{ number_format((int)$proyeks->sum('nilaiok_review'), 0, '.', '.') ?? '0' }}</td>
                                                            <td class="bg-dark"></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        {{-- @endif --}}
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--begin::Content-->
                            </div>
                            <!--begin::Contacts-->
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
    @endsection
    @section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    
    <script>
        // $(document).ready(function() {
        //     $('#example').DataTable( {
        //         dom: 'rtip',
        //         // dom: 'frtip',
        //         pageLength : 50,
        //         // ordering : false,
        //         // buttons: [
        //         //     'copy', 'csv', 'excel', 'pdf', 'print'
        //         // ]
        //     } );
        // } );
    </script>
    <!--end::Data Tables-->
    @endsection

