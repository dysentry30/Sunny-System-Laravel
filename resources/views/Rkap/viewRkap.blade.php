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
                        <div class="card-header py-10 ">
                            @php
                                $rkap_istrue = $rkaps->proyeks->where("is_rkap", "=", true);
                            @endphp


                            <div class="d-flex w-100 align-items-center">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->

                                    <!--begin::Input group Name-->
                                    <div class="d-flex align-items-center">
                                        <div class="col-5 text-end me-5">
                                            <span class="">Unit Kerja: </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b>{{ $rkaps->unit_kerja ?? '' }}</b>
                                        </div>
                                    </div>
                                    <!--end::Input group Name-->
                                </div>

                                @php
                                    $total_ok_review = $rkap_istrue->where('tahun_perolehan', '=', $rkap_istrue->first()->tahun_perolehan)->map(function ($data) {
                                        return (int) str_replace(',', '', $data->nilaiok_review);
                                    });
                                    $total_ok_review = $total_ok_review->sum();
                                @endphp

                                <!--begin::Col-->
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="col-5 text-end px-4">
                                            <span class="">Total OK Review: </span>
                                        </div>
                                        <div class="text-dark text-start">
                                            <b>{{ number_format($total_ok_review, 0, '.', '.') ?? '' }}</b>
                                        </div>
                                    </div>
                                    <!--begin::Input group Website-->
                                    <!--begin::Input group Name-->
                                    <!--end::Input group Name-->
                                </div>
                            </div>


                            <div class="row w-100 fv-row my-5">

                                <div class="d-flex align-items-center">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->

                                        <!--begin::Input group Name-->
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Tahun Pelaksanaan: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ $rkap_istrue->last()->tahun_perolehan }}</b>
                                            </div>
                                        </div>
                                        <!--end::Input group Name-->
                                    </div>

                                    @php
                                        $total_ok_awal = $rkap_istrue->where('tahun_perolehan', '=', $rkap_istrue->first()->tahun_perolehan)->map(function ($data) {
                                            return (int) str_replace(',', '', $data->nilai_rkap);
                                        });
                                        $total_ok_awal = $total_ok_awal->sum();
                                    @endphp
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Total OK Awal: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ number_format($total_ok_awal, 0, '.', '.') }}</b>
                                            </div>
                                        </div>
                                        <!--begin::Input group Website-->
                                        <!--begin::Input group Name-->
                                        <!--end::Input group Name-->
                                    </div>
                                </div>
                            </div>


                            <div class="row w-100 fv-row mb-5">
                                <div class="d-flex align-items-center">

                                    @php
                                        $total_forecast = $rkap_istrue->where('tahun_perolehan', '=', $rkap_istrue->first()->tahun_perolehan)->map(function ($data) {
                                            return $data->forecast;
                                        });
                                        $total_forecast = $total_forecast->sum();
                                        
                                        // $total_realisasi = $rkap_istrue->where('tahun_perolehan', '=', $rkap_istrue->first()->tahun_perolehan)->map(function ($data) {
                                        //     return (int) str_replace(',', '', $data->perolehan);
                                        // });
                                        // $total_realisasi = $total_realisasi->sum();
                                        $realisasi = 0;
                                        foreach ($proyeks as $proyek) {
                                            if ($proyek->stage == 8) {
                                                $total_realisasi = $proyek->Forecasts->filter(function($f) use($tahun_pelaksanaan){
                                                    if($tahun_pelaksanaan < (int) date("Y")) {
                                                        $month = 12;
                                                    } else {
                                                        $month = (int) date("m");
                                                    }
                                                    return $f->periode_prognosa == $month && $f->tahun == (int) $tahun_pelaksanaan ;
                                                })->sum(function($f) {
                                                    return (int) $f->realisasi_forecast;
                                                });
                                            } else {
                                                $total_realisasi = 0;
                                            }
                                            // dump((int) $total_realisasi);
                                            $realisasi = $realisasi+=$total_realisasi;
                                        }

                                    @endphp
                                    

                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Input group Website-->

                                        <!--begin::Input group Name-->
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Total Forecast: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ number_format($total_forecast, 0, '.', '.') ?? 0 }}</b>
                                            </div>
                                        </div>
                                        <!--end::Input group Name-->
                                    </div>
                                    
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Total Realisasi: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ number_format($realisasi, 0, '.', '.') }}</b>
                                            </div>
                                        </div>
                                        <!--begin::Input group Website-->
                                        <!--begin::Input group Name-->
                                        <!--end::Input group Name-->
                                    </div>
                                </div>


                            </div>
                        </div>
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
                                                        <th class="min-w-auto text-center">Retail ?</th>
                                                        <th class="min-w-auto text-end">Total OK Awal</th>
                                                        <th class="min-w-auto text-end">Total OK Review</th>
                                                        <th class="min-w-auto text-center">Bulan Pelaksanaan</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @php
                                                        $is_data_found = false;
                                                    @endphp
                                                    @foreach ($proyeks as $proyek)
                                                        @if ($proyek->tahun_perolehan == $tahun_pelaksanaan)
                                                            @php
                                                                $is_data_found = true;
                                                            @endphp
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td class="">
                                                                    {{-- <a href="/rkap/{{ $proyek->first()->UnitKerja->divcode }}/{{ $proyek->first()->tahun_perolehan }}" id="click-name"
                                                                    class="text-gray-600 text-hover-primary mb-1">{{ $proyek->first()->UnitKerja->unit_kerja }}</a> --}}
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
                                                                    @php
                                                                        $total_ok_awal = 0;
                                                                        $total_ok_awal += $proyek->Forecasts->where("tahun", "=", (int) date("Y"))->where("periode_prognosa", "=", (int) date("m"))->sum(function($f) {
                                                                            return (int) $f->rkap_forecast;
                                                                        });
                                                                        // foreach ($proyek as $proyekTotal) {
                                                                        //         return (int) $f->rkap_forecast;
                                                                        //     });
                                                                        //     // $total_ok_review += (int) str_replace(",", "", $proyekTotal->nilaiok_review);
                                                                        // }
                                                                    @endphp
                                                                    {{-- {{ number_format((int)$proyek->nilaiok_awal, 0, '.', '.') ?? '-' }} --}}
                                                                    {{ number_format((int)$total_ok_awal, 0, '.', '.') ?? '-' }}
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
                                                        @endif
                                                    @endforeach
                                                    @if (!$is_data_found)
                                                        <tr>
                                                            <td colspan="7" class="text-center bg-gray-100">Data tidak
                                                                ditemukan</td>
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
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'rtip',
                // dom: 'frtip',
                pageLength : 50,
                // ordering : false,
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ]
            } );
        } );
    </script>
    <!--end::Data Tables-->
    @endsection

