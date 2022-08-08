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
                                    <button class="btn btn-sm btn-primary w-80px"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" 
                                        style="background-color:#008CB4; padding: 6px">
                                        New</button>

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


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-1">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                {{-- <form action="" method="get">
                                    <div class="d-flex align-items-center position-relative my-1 me-8">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="cari" name="cari" value="{{ $cari }}"
                                            class="form-control form-control-solid ps-15" placeholder="Kode/Nama Proyek" />
                                    </div>
                                </form> --}}
                                <!--end::Search-->
                                
                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" onchange="changes(this)" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$column == "" ? "selected": ""}}></option>
                                        <option value="kode_proyek" {{$column == "kode_proyek" ? "selected" : ""}}>Kode Proyek</option>
                                        <option value="nama_proyek" {{$column == "nama_proyek" ? "selected" : ""}}>Nama Proyek</option>
                                        <option value="tahun_perolehan" {{$column == "tahun_perolehan" ? "selected" : ""}}>Tahun Perolehan</option>
                                        {{-- <option value="stage" {{$column == "stage" ? "selected" : ""}}>Stage</option>
                                        <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option> --}}
                                        
                                    </select>
                                    <!--End:: Select Options-->
                                    
                                    <!--begin:: Input Filter-->
                                    @if ($column == "stage")
                                    
                                    <select id="filter" name="filter" class="form-select form-select-solid select2-hidden-accessible w-200px ms-2" data-control="select2" data-hide-search="true" data-placeholder="Pilih Stage" data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        <option></option>
                                        <option value="1" {{$filter == "1" ? "selected" : ""}}>Pasar Dini</option>
                                        <option value="2" {{$filter == "2" ? "selected" : ""}}>Pasar Potensial</option>
                                        <option value="3" {{$filter == "3" ? "selected" : ""}}>Prakualifikasi</option>
                                        <option value="4" {{$filter == "4" ? "selected" : ""}}>Tender Diikuti</option>
                                        <option value="5" {{$filter == "5" ? "selected" : ""}}>Perolehan</option>
                                        <option value="6" {{$filter == "6" ? "selected" : ""}}>Menang</option>
                                        <option value="7" {{$filter == "7" ? "selected" : ""}}>Kalah</option>
                                        <option value="8" {{$filter == "8" ? "selected" : ""}}>Terkontrak</option>
                                        <option value="9" {{$filter == "9" ? "selected" : ""}}>Terendah</option>
                                        <option value="10" {{$filter == "10" ? "selected" : ""}}>Selesai</option>
                                    </select>
                                    
                                    @elseif ($column == "jenis_proyek")
                                    
                                    <select id="filter" name="filter" class="form-select form-select-solid select2-hidden-accessible w-200px ms-2" data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek" data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        <option></option>
                                        <option value="I" {{$filter == "I" ? "selected" : ""}}>Internal</option>
                                        <option value="E" {{$filter == "E" ? "selected" : ""}}>External</option>
                                    </select>
                                    
                                    @else
                                    
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}"
                                        class="form-control form-control-solid ms-2 ps-12 w-auto" placeholder="Input Filter" />
                                    </div>
                                    
                                    @endif

                                    <script>
                                        function changes(e) {
                                        if (e.value == "stage"){
                                            window.location.href="/proyek?column=stage";
                                        } else if (e.value == "jenis_proyek"){
                                            window.location.href="/proyek?column=jenis_proyek";
                                        } else {
                                            // window.location.href="/proyek?column="+e.value;
                                        }
                                    }
                                    </script>
                                    <!--end:: Input Filter-->
                                    
                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4" id="kt_toolbar_primary_button">
                                    Filter</button>
                                    <!--end:: Filter-->
                                    
                                    <!--begin:: RESET-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-2" 
                                    onclick="resetFilter()"  id="kt_toolbar_primary_button">Reset</button>
                                    <script>
                                        function resetFilter() {
                                            $("#column").select2({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                            
                                            $("#filter").text({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER-->
                                
                                
                            </div>
                            <!--begin::Card title-->

                            <!--begin::Paginate-->
                            {{-- <div class="align-items-center d-flex flex-row-reverse">
												<div>
													{{ $proyeks->links() }}
												</div>

												<div class="p-2" style="color:gray">
													Showing
													{{ $proyeks->firstItem() }}
													to
													{{ $proyeks->lastItem() }}
													of
													{{ $proyeks->total()}}
													entries
												</div>
											</div> --}}
                            <!--end::Paginate-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table Proyek-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase text-sm gs-0">
                                        <th class="min-w-auto"><small>@sortablelink('kode_proyek','Kode Proyek')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nama_proyek','Nama Proyek')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('unit_kerja','Unit Kerja')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('stage','Stage')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('tahun_perolehan','Tahun Perolehan')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('bulan_pelaksanaan','Bulan Pelaksanaan')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nilai_rkap','Nilai RKAP')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('forecast','Nilai Forecast')</small></th>
                                        <th class="min-w-auto"><small>@sortablelink('nilai_kontrak_keseluruhan','Nilai Realisasi')</small></th>
                                        <th class="min-w-auto text-center"><small>@sortablelink('jenis_proyek','Jenis Proyek')</small></th>
                                        @if (auth()->user()->check_administrator)
                                            <th class="min-w-auto text-center"><small>Action</small></th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    $proyeks = $proyeks->reverse();
                                @endphp
                                <tbody class="fw-bold text-gray-800">
                                    @foreach ($proyeks as $proyek)
                                        <tr>
                                            <!--begin::Name-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->kode_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Name-->
                                            <!--begin::Email-->
                                            <td>
                                                <small>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}" id="click-name"
                                                        class="text-gray-800 text-hover-primary">{{ $proyek->nama_proyek }}</a>
                                                </small>
                                            </td>
                                            <!--end::Email-->
                                            <!--begin::Company-->
                                            <td>
                                                <small>
                                                    {{ $proyek->UnitKerja->unit_kerja }}
                                                </small>
                                            </td>
                                            <!--end::Company-->

                                            <!--begin::Stage-->
                                            <td>
                                                <small>
                                                    @switch($proyek->stage)
                                                    @case("1") Pasar Dini
                                                        @break
                                                    @case("2") Pasar Potensial
                                                    @break
                                                    @case("3") Prakualifikasi
                                                    @break
                                                    @case("4") Tender Diikuti
                                                    @break
                                                    @case("5") Perolehan
                                                    @break
                                                    @case("6") Menang
                                                    @break
                                                    @case("7") Kalah
                                                    @break
                                                    @case("8") Terkontrak
                                                    @break
                                                    @case("9") Terendah
                                                        @break
                                                    @default Selesai
                                                    @endswitch
                                                </small>
                                            </td>
                                            <!--end::Stage-->
                                            <!--begin::Pelaksanaan-->
                                            <td class="text-center">
                                                <small>
                                                    {{ $proyek->tahun_perolehan }}
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Pelaksanaan-->
                                            <td class="">
                                                <small>
                                                    @switch($proyek->bulan_pelaksanaan)
                                                    @case("1") Januari
                                                        @break
                                                    @case("2") Februari
                                                        @break
                                                    @case("3") Maret
                                                        @break
                                                    @case("4") April
                                                        @break
                                                    @case("5") Mei
                                                        @break
                                                    @case("6") Juni
                                                        @break
                                                    @case("7") Juli
                                                        @break
                                                    @case("8") Agustus
                                                        @break
                                                    @case("9") September
                                                        @break
                                                    @case("10") Oktober
                                                        @break
                                                    @case("11") November
                                                        @break
                                                    @case("12") Desember
                                                        @break
                                                    @default Selesai
                                                        @endswitch
                                                </small>
                                            </td>
                                            <!--end::Pelaksanaan-->

                                            <!--begin::Nilai OK-->
                                            <td>
                                                <small>
                                                    {{ $proyek->nilai_rkap }}
                                                </small>
                                            </td>
                                            <!--end::Nilai OK-->
                                            
                                            <!--begin::Forecast-->
                                            <td class="text-end">
                                                <small>
                                                    {{ $proyek->forecast ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::Forecast-->

                                            <!--begin::Realisasi-->
                                            <td class="text-end">
                                                <small>
                                                    {{ $proyek->nilai_kontrak_keseluruhan ?? "-" }}
                                                </small>
                                            </td>
                                            <!--end::Realisasi-->

                                            
                                            <!--begin::Jenis Proyek-->
                                            <td class="text-center">
                                                <small>
                                                    {{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}
                                                </small>
                                            </td>
                                            <!--end::Jenis Proyek-->
                                            
                                            @if (auth()->user()->check_administrator)
                                                <!--begin::Action-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $proyek->kode_proyek }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
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


    <!--begin::Modal New Proyek-->

    <form action="/proyek/save" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New Proyek</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-circle-fill ts-8"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="nama-proyek"
                                        name="nama-proyek" value="{{ old('nama-proyek') }}"
                                        placeholder="Nama Proyek" />
                                    @error('nama-proyek')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Unit Kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="unit-kerja" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                        <option></option>
                                        @foreach ($unitkerjas as $unitkerja)
                                            <option value="{{ $unitkerja->divcode }}"
                                                {{ old('unit-kerja') == $unitkerja->divcode ? 'selected' : '' }}>
                                                {{ $unitkerja->unit_kerja }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit-kerja')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jenis Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="jenis-proyek" name="jenis-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Jenis Proyek">
                                        <option selected></option>
                                        <option value="I" {{ old('jenis-proyek') == 'I' ? 'selected' : '' }}>
                                            Internal</option>
                                        <option value="E" {{ old('jenis-proyek') == 'E' ? 'selected' : '' }}>
                                            External</option>
                                    </select>
                                    @error('jenis-proyek')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Tipe Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="tipe-proyek" name="tipe-proyek" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tipe Proyek">
                                        <option selected></option>
                                        <option value="R" {{ old('tipe-proyek') == 'R' ? 'selected' : '' }}>
                                            Retail</option>
                                        <option value="P" {{ old('tipe-proyek') == 'P' ? 'selected' : '' }}>
                                            Non-Retail</option>
                                    </select>
                                    @error('tipe-proyek')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nilai OK RKAP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid reformat"
                                        id="nilai-rkap" name="nilai-rkap" value="{{ old('nilai-rkap') }}"
                                        placeholder="Nilai OK RKAP" />
                                    @error('nilai-rkap')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Sumber Dana</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="sumber-dana" name="sumber-dana" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Sumber Dana">
                                        <option></option>
                                        @foreach ($sumberdanas as $sumberdana)
                                            <option value="{{ $sumberdana->nama_sumber }}"
                                                {{ old('sumber-dana') == $sumberdana->nama_sumber ? 'selected' : '' }}>
                                                {{ $sumberdana->nama_sumber }}</option>
                                        @endforeach
                                    </select>
                                    @error('sumber-dana')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Tahun Perolehan</span>
                                    </label>
                                    <!--end::Label-->
                                    @php
                                        $years = (int) date('Y');
                                        $bulans = (int) date('m');
                                        // dd($bulans);
                                    @endphp
                                    <!--begin::Input-->
                                    <select id="tahun-perolehan" name="tahun-perolehan" 
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                        @for ($i = 2021; $i < $years + 10; $i++)
                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('tahun-perolehan')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Bulan Pelaksanaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin::Input-->
                                    <select id="bulan-pelaksanaan" name="bulan-pelaksanaan"
                                        class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Bulan Pelaksanaan">
                                        <option></option>
                                        <option value="1" {{ $bulans == 1 ? 'selected' : '' }}>Januari</option>
                                        <option value="2" {{ $bulans == 2 ? 'selected' : '' }}>Februari</option>
                                        <option value="3" {{ $bulans == 3 ? 'selected' : '' }}>Maret</option>
                                        <option value="4" {{ $bulans == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ $bulans == 5 ? 'selected' : '' }}>Mei</option>
                                        <option value="6" {{ $bulans == 6 ? 'selected' : '' }}>Juni</option>
                                        <option value="7" {{ $bulans == 7 ? 'selected' : '' }}>Juli</option>
                                        <option value="8" {{ $bulans == 8 ? 'selected' : '' }}>Agustus</option>
                                        <option value="9" {{ $bulans == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ $bulans == 10 ? 'selected' : '' }}>Oktober</option>
                                        <option value="11" {{ $bulans == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ $bulans == 12 ? 'selected' : '' }}>Desember</option>
                                    </select>
                                    @error('bulan-pelaksanaan')
                                        <h6 class="text-danger">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" style="background-color:#008CB4" id="proyek_new_save">Save</button>
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::Modal New Proyek-->

    <!--begin::modal DELETE-->
    @foreach ($proyeks as $proyek)
        <form action="/proyek/delete/{{ $proyek->kode_proyek }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $proyek->kode_proyek }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}
                            </h2>
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
    @endforeach
    <!--end::modal DELETE-->


    @endsection

    <!--end::Main-->
