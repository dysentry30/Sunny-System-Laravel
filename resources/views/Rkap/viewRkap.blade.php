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
                @extends('template.header')
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
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Group RKAP
                                </h1>
                                <!--end::Title-->
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

                        <!--begin::Card Tittle-->
                        <div class="card-body py-10">
                            <!--begin::Row-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
    
                                        <!--begin::Input group Name-->
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">No. Contract: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ $contract->id_contract ?? '' }}</b>
                                            </div>
                                        </div>
                                        <!--end::Input group Name-->
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Proyek: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ $contract->project->nama_proyek ?? '' }}</b>
                                            </div>
                                        </div>
                                        <!--begin::Input group Website-->
                                        <!--begin::Input group Name-->
                                        <!--end::Input group Name-->
                                    </div>
                                </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Card Tittle-->


                         <!--begin::Content-->
                        <div class="col-xl-15">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                <!--begin::Card body-->
                                <div class="card-body" style="padding: 1rem;">
                                    @if (auth()->user()->check_administrator)
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">@sortablelink('unit_kerja','Unit Kerja')</th>
                                                <th class="min-w-auto text-center">Tahun Pelaksanaan</th>
                                                <th class="min-w-auto text-center">Total OK Awal</th>
                                                <th class="min-w-auto text-center">Total OK Review</th>
                                                <th class="min-w-auto text-center">@sortablelink('is_active','Is Locked')</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            {{-- @foreach ($proyeks as $proyekArray)
                                                @foreach ($proyekArray as $proyek)
                                                <tr>
                                                    <!--begin::Name-->
                                                    <td class="">
                                                        <a href="/rkap/{{ $proyek->first()->UnitKerja->divcode }}/{{ $proyek->first()->tahun_perolehan }}" id="click-name"
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
                                    @endif
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

