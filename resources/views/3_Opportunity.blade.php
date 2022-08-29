{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Proyek')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Proyek
                                </h1>
                                <!--end::Title-->
                            </div>

                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator || auth()->user()->check_user_sales)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_proyek" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button>

                                    <!--begin::Wrapper-->
                                    <div class="me-4" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-folder2-open"></i>Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                            id="kt_menu_6155ac804a1c2">
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
                                                <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_import"
                                                    id="kt_toolbar_import">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_export"
                                                    id="kt_toolbar_export">
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


                                </div>
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

                        <div class="card-header">
                            <!--begin::Paginate-->
                            <div class="align-items-center d-flex flex-row-reverse">
												<div>
													{{ $oppor->links() }}
												</div>

												<div class="p-2" style="color:gray">
													Showing
													{{ $oppor->firstItem() }}
													to
													{{ $oppor->lastItem() }}
													of
													{{ $oppor->total()}}
													entries
												</div>
											</div>
                            <!--end::Paginate-->
                        </div>

                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table Proyek-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase text-sm gs-0">
                                        <th class="min-w-auto"><small>@sortablelink('kode_proyek', 'Kode Proyek')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nama_proyek', 'Nama Proyek')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('unit_kerja', 'Unit Kerja')</small></th>
                                        {{-- <th class="min-w-auto"><small>@sortablelink('stage', 'Stage')</small></th> --}}
                                        <th class="min-w-auto"><small>@sortablelink('tahun_perolehan', 'Tahun Perolehan')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('bulan_pelaksanaan', 'Bulan Pelaksanaan')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nilai_rkap', 'Nilai RKAP')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('forecast', 'Nilai Forecast')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nilai_kontrak_keseluruhan', 'Nilai Realisasi')</small></th>
                                        {{-- <th class="min-w-auto text-center"><small>@sortablelink('jenis_proyek', 'Jenis Proyek')</small></th> --}}
                                        @if (auth()->user()->check_administrator)
                                            <th class="min-w-auto text-center"><small>Action</small></th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    // $oppor = $oppor->reverse();
                                @endphp
                                <tbody class="fw-bold text-gray-800">
                                    @foreach ($oppor as $proyek)
                                        <tr>
                                            <!--begin::Name-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->UsrKodeProyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->UsrKodeProyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Email-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->UsrKodeProyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->Title }}</a>
                                                </small>
                                            </td>
                                            <!--end::Email-->
                                            <!--begin::Company-->
                                            <td>
                                                <small>
                                                    {{ $proyek->unit_kerja ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::Company-->

                                            <!--begin::Stage-->
                                            {{-- @php
                                                if ($proyek->stage == 0 || $proyek->stage == 7 ){
                                                    $stageColor = "text-danger";
                                                } else if ($proyek->stage == 8 || $proyek->stage == 9){
                                                    $stageColor = "text-success";
                                                } else {
                                                    $stageColor = "";
                                                }                                                    
                                            @endphp --}}
                                            {{-- <td> --}}
                                                {{-- <small>
                                                    @switch($proyek->stage)
                                                        @case('0')
                                                            Proyek Canceled
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

                                                        @default
                                                            Selesai
                                                    @endswitch
                                                </small> --}}
                                            {{-- </td> --}}
                                            <!--end::Stage-->
                                            <!--begin::Pelaksanaan-->
                                            <td class="text-center">
                                                <small>
                                                    {{ $proyek->UsrSTRING }}
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Pelaksanaan-->
                                            <td class="">
                                                <small>
                                                    @switch($proyek->UsrBulanPelaksanaan1Id)
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

                                                        @default
                                                            Bulan
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Nilai OK-->
                                            <td class="text-end">
                                                <small>
                                                    {{ number_format($proyek->UsrNilaiKontrakKeseluruhan, 0, ',', ',') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Nilai OK-->

                                            <!--begin::Forecast-->
                                            <td class="text-end">
                                                <small>
                                                    {{ number_format($proyek->UsrPrognosa, 0, ',', ',') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Forecast-->
                                            
                                            <!--begin::Realisasi-->
                                            <td class="text-end">
                                                <small>
                                                    {{ number_format($proyek->UsrNilaiPerolehan, 0, ',', ',') ?? '-' }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi-->


                                            <!--begin::Jenis Proyek-->
                                            {{-- <td class="text-center"> --}}
                                                {{-- <small>
                                                    {{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}
                                                </small> --}}
                                            {{-- </td> --}}
                                            <!--end::Jenis Proyek-->

                                            @if (auth()->user()->check_administrator)
                                                <!--begin::Action-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $proyek->kode_proyek }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Move
                                                    </button>
                                                    </form>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action-->
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table Proyek-->


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

@endsection

<!--end::Main-->
