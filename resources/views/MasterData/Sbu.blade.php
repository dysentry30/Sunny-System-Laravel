{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'SBU')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">SBU
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
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
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                {{-- <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search SBU" />
                                </div> --}}
                                <!--end::Search-->

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$column == "" ? "selected": ""}}></option>
                                        <option value="sbu" {{$column == "sbu" ? "selected" : ""}}>Nama SBU</option>
                                        <option value="kode_sbu" {{$column == "kode_sbu" ? "selected" : ""}}>Kode</option>
                                        <option value="klasifikasi" {{$column == "klasifikasi" ? "selected" : ""}}>Klasifikasi</option>
                                        <option value="sub_klasifikasi" {{$column == "sub_klasifikasi" ? "selected" : ""}}>Sub Klasifikasi</option>
                                        <option value="referensi1" {{$column == "referensi1" ? "selected" : ""}}>Referensi 1</option>
                                        <option value="referensi2" {{$column == "referensi2" ? "selected" : ""}}>Referensi 2</option>
                                        <option value="referensi3" {{$column == "referensi3" ? "selected" : ""}}>Referensi 3</option>
                                        
                                    </select>
                                    <!--End:: Select Options-->
                                    
                                    <!--begin:: Input Filter-->
                                    <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}"
                                    class="form-control form-control-solid ms-2" placeholder="Input Filter" />
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

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">@sortablelink('sbu','Nama')</th>
                                        <th class="min-w-auto">@sortablelink('kode_sbu','Kode')</th>
                                        <th class="min-w-auto">@sortablelink('klasifikasi','Klasifikasi')</th>
                                        <th class="min-w-auto">@sortablelink('referensi1','Referensi 1')</th>
                                        <th class="min-w-auto">@sortablelink('sub_klasifikasi','Sub-Klasifikasi')</th>
                                        <th class="min-w-auto">@sortablelink('referensi2','Referensi 2')</th>
                                        <th class="min-w-auto">@sortablelink('lingkup_kerja','Lingkup Pekerjaan')</th>
                                        <th class="min-w-auto">@sortablelink('referensi3','Referensi 3')</th>
                                        @if (auth()->user()->check_administrator)
                                            <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                {{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}
                                @foreach ($sbus as $sbu)
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>

                                            <!--begin::Name=-->
                                            <td>
                                                <a href="#" id="click-name"
                                                    class="text-gray-600 text-hover-primary mb-1">{{ $sbu->sbu }}</a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->kode_sbu }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->klasifikasi }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->referensi1 }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->sub_klasifikasi }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->referensi2 }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                <a href="#" id="click-no" class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $sbu->lingkup_kerja }}
                                                </a>
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $sbu->referensi3 }}
                                            </td>
                                            <!--end::Coloumn-->

                                            @if (auth()->user()->check_administrator)
                                                <!--begin::Action=-->
                                                <td class="text-center">
                                                    <!--begin::Button-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $sbu->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                    <!--end::Button-->
                                                </td>
                                                <!--end::Action=-->
                                            @endif
                                        </tr>
                                @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->



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

    <!--begin::Modal-->
    <form action="/sbu/save" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>SBU</h2>
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
                                        <span class="required">Nama SBU</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="sbu"
                                        name="sbu" value="{{ old('sbu') }}" placeholder="Nama SBU" />
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
                                        <span class="required">Kode SBU</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kode-sbu"
                                        name="kode-sbu" value="{{ old('kode-sbu') }}" placeholder="Kode SBU" />
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
                                        <span class="required">Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="klasifikasi" name="klasifikasi" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Klasifikasi">
                                        <option selected></option>
                                        <option value="Bangun Gedung">Bangun Gedung</option>
                                        <option value="Kontruksi manufaktur">Kontruksi manufaktur</option>
                                        <option value="Minyak dan Gas">Minyak dan Gas</option>
                                        <option value="Sumber Daya Air">Sumber Daya Air</option>
                                        <option value="Transportasi">Transportasi</option>
                                    </select>
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
                                        <span class="required">Sub-Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="sub-klasifikasi"
                                        name="sub-klasifikasi" value="{{ old('sub-klasifikasi') }}"
                                        placeholder="Sub-Klasifikasi" />
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
                                        <span>Lingkup Pekerjaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="lingkup"
                                        name="lingkup" value="" placeholder="Lingkup Pekerjaan" />
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
                                        <span>Referensi 1</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="referensi1"
                                        name="referensi1" value="" placeholder="Referensi 1" />
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
                                        <span>Referensi 2</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="referensi2"
                                        name="referensi2" value="" placeholder="Referensi 2" />
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
                                        <span>Referensi 3</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="referensi3"
                                        name="referensi3" value="" placeholder="Referensi 3" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->


                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="new_save" class="btn btn-sm btn-light btn-active-primary text-white" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>

    <!--end::Modals-->

    <!--begin::modal DELETE-->
    @foreach ($sbus as $sbu)
        <form action="/sbu/delete/{{ $sbu->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $sbu->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $sbu->nama_sbu }}</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg text-white"></i>
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
