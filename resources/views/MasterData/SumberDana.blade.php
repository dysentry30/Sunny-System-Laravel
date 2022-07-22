{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Sumber Dana')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Sumber Dana
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
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Sumber Dana" />
                                </div> --}}
                                <!--end::Search-->

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$column == "" ? "selected": ""}}></option>
                                        <option value="nama_sumber" {{$column == "nama_sumber" ? "selected" : ""}}>Instansi</option>
                                        <option value="kategori" {{$column == "kategori" ? "selected" : ""}}>Kategori</option>
                                        <option value="unique_code" {{$column == "unique_code" ? "selected" : ""}}>Unique Code</option>
                                        <option value="sumber_dana_id" {{$column == "sumber_dana_id" ? "selected" : ""}}>Sumber Dana Id</option>
                                        
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
                                        <th class="min-w-auto">@sortablelink('nama_sumber','Instansi')</th>
                                        <th class="min-w-auto">@sortablelink('kategori','Kategori')</th>
                                        <th class="min-w-auto">@sortablelink('unique_code','Unique Code')</th>
                                        <th class="min-w-auto">@sortablelink('sumber_dana_id','Sumber Dana ID')</th>
                                        <th class="min-w-auto">@sortablelink('kode_proyek_id','Kode Proyek ID')</th>
										@if (auth()->user()->check_administrator)
											<th class="text-center">Action</th>
										@endif
										{{-- <th class=""><center>Action</center></th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                {{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}
                                @foreach ($sumberdana as $sumberdanas)
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>

                                            <!--begin::Name=-->
                                            <td>
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#kt_edit_{{ $sumberdanas->id }}" 
                                                    class="text-gray-600 text-gray text-hover-primary">{{ $sumberdanas->nama_sumber }}</a>
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Email=-->
                                            <td>
                                                {{ $sumberdanas->kategori }}
                                            </td>
                                            <!--end::Email=-->
                                            <!--begin::Coloumn=-->
                                            <td>
                                                {{ $sumberdanas->unique_code }}
                                            </td>
                                            <!--end::Coloumn=-->
                                            <!--begin::Coloumn=-->
                                            <td>
                                                {{ $sumberdanas->sumber_dana_id }}
                                            </td>
                                            <!--end::Coloumn=-->
                                            <!--begin::Coloumn=-->
                                            <td>
                                                {{ $sumberdanas->kode_proyek_id }}
                                            </td>
                                            <!--end::Coloumn=-->

											@if (auth()->user()->check_administrator)
                                            <!--begin::Action=-->
                                            <td class="text-center">
                                                <!--begin::Button-->
                                                <button data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_delete{{ $sumberdanas->id }}"
                                                    id="modal-delete" class="btn btn-sm btn-light btn-active-primary">Delete
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
    <form action="/sumber-dana/save" method="post" enctype="multipart/form-data">
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
                        <h2>Sumber Dana</h2>
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
                                        <span class="required">Instansi Pemberi Dana</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="nama-sumber"
                                        name="nama-sumber" value="{{ old('nama-sumber') }}"
                                        placeholder="Nama Pemberi Dana" />
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
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="kategori" class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Kategori">
                                        <option></option>
                                        <option value="BUMN">BUMN</option>
                                        <option value="Investasi">Investasi</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Pemerintah">Pemerintah</option>
                                        <option value="Swasta">Swasta</option>
                                    </select>
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
                                        <span class="required">Unique Code</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="unique-code" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unique Code">
                                        <option></option>
                                        <option value="NPWP">NPWP</option>
                                        <option value="Bussines Permite License">Bussines Permite License</option>
                                        <option value="Kode Anggaran Provinsi">Kode Anggaran Provinsi</option>
                                        <option value="kode Bagian Anggaran">kode Bagian Anggaran</option>
                                        <option value="Tax Identification Number">Tax Identification Number</option>
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
                                        <span>Jenis Perusahaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="jenis-perusahaan"
                                        name="jenis-perusahaan" value="" placeholder="Jenis Perusahaan" />
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
                                        <span>Tipe Lain</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="tipe-lain"
                                        name="tipe-lain" value="" placeholder="Tipe Lain" />
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
                                        <span>Kode</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kode-sumber"
                                        name="kode-sumber" value="" placeholder="Kode" />
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
                                        <span>Sumber Dana ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="sumber-dana-id"
                                        name="sumber-dana-id" value="" placeholder="Sumber Dana ID" />
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
                                        <span>Kode Proyek ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kode-proyek-id"
                                        name="kode-proyek-id" value="" placeholder="Kode Proyek ID" />
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
                                        <span>Tipe Perusahaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid"
                                        id="tipe-perusahaan" name="tipe-perusahaan" value=""
                                        placeholder="Tipe Perusahaan" />
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
                                        <span>COT ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="cot-id"
                                        name="cot-id" value="" placeholder="COT ID" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="proyek_new_save" style="background-color:#008CB4">Save</button>

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

<!--begin::EDIT-->
    @foreach ($sumberdana as $sumberdanas)
    <form action="/sumber-dana/{{ $sumberdanas->id }}/edit" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create App-->
        <input type="hidden" name="id-sumber" value="{{ $sumberdanas->id }}" id="id-customer">

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_edit_{{ $sumberdanas->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Sumber Dana</h2>
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
                                        <span class="required">Instansi Pemberi Dana</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="nama-sumber"
                                        name="nama-sumber" value="{{ $sumberdanas->nama_sumber }}"
                                        placeholder="Nama Pemberi Dana" />
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
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="kategori" class="form-select rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" data-control="select2"
                                        data-hide-search="true" data-placeholder="Kategori">
                                        <option value="{{ $sumberdanas->kategori }}">{{ $sumberdanas->kategori }}</option>
                                        <option value="BUMN">BUMN</option>
                                        <option value="Investasi">Investasi</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Pemerintah">Pemerintah</option>
                                        <option value="Swasta">Swasta</option>
                                    </select>
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
                                        <span class="required">Unique Code</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="unique-code" class="form-select rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                        data-control="select2" data-hide-search="true" data-placeholder="Unique Code">
                                        <option value="{{ $sumberdanas->unique_code }}">{{ $sumberdanas->unique_code }}</option>
                                        <option value="NPWP">NPWP</option>
                                        <option value="Bussines Permite License">Bussines Permite License</option>
                                        <option value="Kode Anggaran Provinsi">Kode Anggaran Provinsi</option>
                                        <option value="kode Bagian Anggaran">kode Bagian Anggaran</option>
                                        <option value="Tax Identification Number">Tax Identification Number</option>
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
                                        <span>Jenis Perusahaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="jenis-perusahaan"
                                        name="jenis-perusahaan" value="{{ $sumberdanas->jenis_perusahaan }}" placeholder="Jenis Perusahaan" />
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
                                        <span>Tipe Lain</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="tipe-lain"
                                        name="tipe-lain" value="{{ $sumberdanas->tipe_lain }}" placeholder="Tipe Lain" />
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
                                        <span>Kode</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="kode-sumber"
                                        name="kode-sumber" value="{{ $sumberdanas->kode_sumber }}" placeholder="Kode" />
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
                                        <span>Sumber Dana ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="sumber-dana-id"
                                        name="sumber-dana-id" value="{{ $sumberdanas->sumber_dana_id }}" placeholder="Sumber Dana ID" />
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
                                        <span>Kode Proyek ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="kode-proyek-id"
                                        name="kode-proyek-id" value="{{ $sumberdanas->kode_proyek_id }}" placeholder="Kode Proyek ID" />
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
                                        <span>Tipe Perusahaan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                        id="tipe-perusahaan" name="tipe-perusahaan" value="{{ $sumberdanas->tipe_perusahaan }}"
                                        placeholder="Tipe Perusahaan" />
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
                                        <span>COT ID</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="cot-id"
                                        name="cot-id" value="{{ $sumberdanas->cot_id }}" placeholder="COT ID" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    @endforeach
<!--end::EDIT-->


<!--begin::modal DELETE-->
    @foreach ($sumberdana as $sumberdanas)
        <form action="/sumber-dana/delete/{{ $sumberdanas->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $sumberdanas->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $sumberdanas->nama_sumber }}</h2>
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

<!--end::Main-->
