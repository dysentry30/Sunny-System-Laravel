{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Pelanggan')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Pelanggan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                        <!--begin::Button-->
                                        {{-- <a href="customer/new" class="btn btn-sm btn-primary w-80px"
                                        id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
                                        New</a> --}}
                                        <button class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_pelanggan" id="kt_toolbar_primary_button"
                                        id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                        New</button>

                                        @if (Auth::user()->can('super-admin'))

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
                                        
                                         @endif

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
                        {{-- <div class="card-header border-0 py-1">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <form action="" method="get">
                                    <div class="d-flex align-items-center position-relative my-1 me-8">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="cari" name="cari" value="{{ $cari }}"
                                            class="form-control form-control-solid ps-15" placeholder="Name/Email Pelanggan"/>
                                    </div>
                                </form>
                                <!--end::Search-->

                                <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$column == "" ? "selected": ""}}></option>
                                        <option value="name" {{$column == "name" ? "selected" : ""}}>Nama Pelanggan</option>
                                        <option value="email" {{$column == "email" ? "selected" : ""}}>Email Pelanggan</option>
                                        <option value="kode_pelanggan" {{$column == "kode_pelanggan" ? "selected" : ""}}>Kode Pelanggan</option>
                                        <option value="kode_nasabah" {{$column == "kode_nasabah" ? "selected" : ""}}>Kode Nasabah</option>
                                        <option value="email" {{$column == "email" ? "selected" : ""}}>Email</option>
                                    </select>
                                    <!--End:: Select Options-->
                                    @php
                                        $iconSearch = '<i class="bi bi-search"></i>';
                                    @endphp
                                    
                                    <!--begin:: Input Filter-->
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}"
                                        class="form-control form-control-solid ms-2 ps-12 w-auto" placeholder="Input Filter" />
                                    </div>
                                    <!--end:: Input Filter-->
                                    
                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4" id="kt_toolbar_primary_button">
                                    Filter</button>
                                    <!--end:: Filter-->
                                    
                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/customer   ";
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER-->
                                
                            </div>
                            <!--end::Card header-->
                        </div> --}}
                        <!--begin::Card title-->

                        <!--begin::Card body-->
                        <div class="card-body pt-2">
                            
                            <div class="overflow-scroll">
                                <!--end::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            {{-- <th class="min-w-auto">No.</th> --}}
                                            <th class="min-w-auto">Kode Pelanggan</th>
                                            <th class="min-w-auto text-center">Pelanggan</th>
                                            <th class="min-w-auto">Email</th>
                                            <th class="min-w-auto">Kode BP</th>
                                            <th class="min-w-auto">Industry Sector</th>
                                            <th class="min-w-auto">Instansi</th>
                                            {{-- <th class="min-w-auto">Kontak Nomor</th> --}}
                                            {{-- <th class="max-w-auto">Customer</th> --}}
                                            {{-- <th class="min-w-auto">Partner</th> --}}
                                            {{-- <th class="min-w-auto">Competitor</th> --}}
                                            <th class="min-w-auto">Kode Nasabah</th>
                                            @if (Auth::user()->canany(['super-admin', 'admin-crm']))
                                            <th class="min-w-auto text-center">Action</th>
                                            @endif
                                            {{-- <th class="max-w-120px"><center>Action</center></th> --}}
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    
                                   
                                        <!-- Begin :: Results -->
                                        {{-- <tbody class="fw-bold text-gray-600" id="data-wrapper">
    
                                            <!-- Results :: Data Tabel Infinite Scroll -->
    
                                        </tbody> --}}
                                        <tbody class="fw-bold text-gray-600">
    
                                            <!-- Results :: Data Tabel Infinite Scroll -->
    
                                            {{-- @if ($column != null || $sort != null ) --}}
                                            
    
                                                @foreach ($results as $customers)
    
                                                <tr>
                                                    <!--begin::Kode Pelanggan-->
                                                    <td>
                                                    @if (empty($customers->kode_pelanggan))                                                    
                                                    <a target="_blank" href="/customer/view/{{ $customers->id_customer }}/{{ $customers->name }}" class="text-gray-800 text-hover-primary ps-6">-</a>
                                                    @else
                                                    <a target="_blank" href="/customer/view/{{ $customers->id_customer }}/{{ $customers->name }}" class="text-gray-800 text-hover-primary">{{ $customers->kode_pelanggan }}</a>
                                                    @endif
                                                    </td>
                                                    <!--end::Kode Pelanggan-->
                                                    <!--begin::Name-->
                                                    <td>
                                                    <a target="_blank" href="/customer/view/{{ $customers->id_customer }}/{{ $customers->name }}" class="text-gray-800 text-hover-primary">{{ $customers->name }}</a>
                                                    </td>
                                                    <!--end::Name-->
                                                    <!--begin::Email-->
                                                    <td>
                                                    <a href="#" class="text-gray-800 text-hover-primary">{{ ($customers->email) }}</a>
                                                    </td>
                                                    <!--end::Email-->
                                                    <!--begin::Column-->
                                                    <td>
                                                    {{ $customers->kode_bp ?? "-" }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                    {{ $customers->IndustrySector->description ?? "-" }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                    {{ $customers->jenis_instansi ?? "-" }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Nomor-->
                                                    {{-- <td>
                                                    {{ $customers->phone_number }}
                                                    </td> --}}
                                                    <!--end::Nomor-->
                                                    <!--begin::check_customer-->
                                                    {{-- <td>
                                                    {{ ($customers->check_customer == 1 ? "Yes" : "No") }}
                                                    </td> --}}
                                                    <!--end::check_customer-->
                                                    <!--begin::check_partner-->
                                                    {{-- <td>
                                                    {{ ($customers->check_partner == 1 ? "Yes" : "No") }}
                                                    </td> --}}
                                                    <!--end::check_partner-->
                                                    <!--begin::check_competitor-->
                                                    {{-- <td data-filter="mastercard">
                                                    {{ ($customers->check_competitor == 1 ? "Yes" : "No") }}
                                                    </td> --}}
                                                    <!--end::check_competitor-->
                                                    <!--begin::Kode Nasabah-->
                                                    <td>
                                                    {{ $customers->kode_nasabah }}
                                                    </td>
                                                    <!--end::Kode Nasabah-->
                                                    <!--begin::Action-->
                                                    @if (Auth::user()->canany(['super-admin', 'admin-crm']))
                                                        <td class="text-center">
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_delete{{ $customers->id_customer }}"
                                                                id="modal-delete"
                                                                class="btn btn-sm btn-light btn-active-danger">Delete
                                                            </button>
                                                        </td>
                                                    @endif
                                                    <!--end::Action-->
                                                </tr>
                                                @endforeach
                                                    
                                                <script>
                                                    const tbody = document.querySelector("#data-wrapper");
                                                    tbody.style.display = "none";
                                                </script>
                                            {{-- @endif --}}
    
                                        </tbody>
                                        <!-- End :: Results -->
    
                                </table>
                                <!--end::Table-->
                            </div>

                        <!-- Data Loader -->
                        {{-- <div class="auto-load text-center">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div> --}}
                            
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
<form action="/customer/save" method="post" enctype="multipart/form-data">
    @csrf
    
    <!--begin::Modal - Create Proyek-->
    <div class="modal fade" id="kt_modal_create_pelanggan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>New Pelanggan</h2>
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
                    
                    <!--begin::Get Modal JS-->
                    <input type="hidden" class="modal-name" name="modal-name">
                    <!--end::Get Modal JS-->

                    <!--begin::Row Kanan+Kiri-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="name-customer" name="name-customer" class="form-control form-control-solid" 
                                value="{{ old('name-customer') }}" placeholder="Name" />
                                @error('name-customer')
                                <h6 class="text-danger fw-normal">{{ $message }}</h6>
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
                                    <span class="required">Email</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" class="form-control form-control-solid" 
                                id="email" name="email" value="{{ old('email') }}" placeholder="Email" />
                                @error('email')
                                <h6 class="text-danger fw-normal">{{ $message }}</h6>
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
                                    <span class="required">Phone Number</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" 
                                id="phone-number" name="phone-number" value="{{ old('phone-number') }}" placeholder="Phone Number" />
                                @error('phone-number')
                                <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                 <!--begin::Label-->
                                 <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Website</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" 
                                id="website" name="website" value="" placeholder="Website" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End::Row Kanan+Kiri-->

                    <!--begin::Options-->
                    <br>
                    <div class="d-flex" style="flex-direction: row">
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-6 ms-4 align-middle">
                            <input class="form-check-input" type="checkbox" value="" id="check-customer" name="check-customer" />
                            <span class="form-check-label me-8"><b>Customer</b></span>
                        </label>
                        <!--end::Options-->
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                            <input class="form-check-input" type="checkbox" value="" id="check-partner" name="check-partner" />
                            <span class="form-check-label me-8"><b>Partner</b></span>
                        </label>
                        <!--end::Options-->
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-6">
                            <input class="form-check-input" type="checkbox" value="" id="check-competitor" name="check-competitor" />
                            <span class="form-check-label me-8"><b>Competitor</b></span>
                        </label>
                        <!--end::Options-->
                    </div>
                    <br>
                    <!--end::Options-->


                    <!--begin::Row Kanan+Kiri-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Address Line 1</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid" name="AddressLine1"></textarea>
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
                                    <span>Address Line 2</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid" name="AddressLine2"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->

                        <!--begin::Input group Kode Pos-->
                        <div class="fv-row mb-7">
                            <div class="col">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 ">
                                        <span>Kode Pos</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Kode Pos" name="kode-pos"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group Website-->
                            </div>

                            <div class="col">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 ">
                                        <span class="required">Industry Sector</span>
                                    </label>
                                    <!--end::Label-->
                                    <select name="industry-sector" id="industry-sector" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                            data-placeholder="Pilih Industry Sector">
                                        <option value="" selected></option>
                                        @foreach ($industrySectors as $is)
                                            <option value="{{ $is->id_industry_sector }}">
                                                {{ ucwords(strtolower($is->description)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group Website-->
                            </div>
                        </div>
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span class="">No NPWP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="npwp-company" value="{{ old('npwp-company') }}" placeholder="NPWP" />
                                    @error('npwp-company')
                                    <h6 class="text-danger fw-normal">{{ $message }}</h6>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->

                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Alamat NPWP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" name="npwp-address" placeholder="Alamat NPWP"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->

                        </div>
                        <!--End begin::Row-->
                        <!--end::Input group-->
                    </div>
                    <!--End::Row Kanan+Kiri-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            style="background-color:#008CB4" id="proyek_new_save">Save</button>
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
<!--begin::Modal Delete-->
    @foreach ($all_customer as $customers)
        <form action="/customer/delete/{{ $customers->id_customer }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $customers->id_customer }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $customers->name }}</h2>
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
<!--end::Modal Delete-->

@endsection
{{-- End::Main --}}

@section("js-script")
<!--begin::Data Tables-->
<script src="/datatables/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: '<"float-start"f><"#example"t>rtip',
            // dom: 'frtip',
            pageLength : 20,
            order: [[0, 'desc']]
            // ordering : false,
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ]
        } );
    } );
</script>
<!--end::Data Tables-->

<script>
    var ENDPOINT = "{{ url('/') }}";
    var page = 1;
    infinteLoadMore(page);
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            infinteLoadMore(page);
        }
    });
    function infinteLoadMore(page) {
        $.ajax({
                url: ENDPOINT + "/customer?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.length == 0) {
                    $('.auto-load').html('<div class="alert alert-secondary rounded-0" role="alert">Opss, Data Tidak Ditemukan !</div>');
                    return;
                }
                $('.auto-load').hide();
                $("#data-wrapper").append(response);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>
@endsection

