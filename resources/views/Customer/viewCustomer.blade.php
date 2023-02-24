{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Ubah Pelanggan')
{{-- End::Title --}}
<style>
    #map {
        height: 350px;
    }
    .form-control.form-control-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 0px dashed #b5b5c3 !important;
        border-radius: 5px !important;
        background-color: #eff2f5 !important;
    }

    .form-select.form-select-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 0px dashed #b5b5c3 !important;
        border-radius: 5px !important;
        background-color: #eff2f5 !important;
    }
</style>
<!--begin::Main-->
@section('content')
    {{-- @dd(memory_get_usage(true)) --}}
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::form-->
                    <form action="/customer/save-edit" method="post" enctype="multipart/form-data">
                        @csrf

                        <!--begin:: id_customer selected-->
                        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">
                        <!--end:: id_customer selected-->

                        <!--begin::Toolbar-->
                        <div class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Account
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    @if ($customer->kode_nasabah)
                                        <div class="" data-bs-toggle="tooltip" data-bs-html="true" 
                                        data-bs-title="<b>Kode Nasabah</b> sudah didapatkan" >
                                            <button type="button"  class="btn disabled btn-sm btn-light btn-active-success me-3" onclick="getKodeNasabah(this)" id="get-kode-nasabah">
                                                Get Kode Nasabah</button>
                                        </div>
                                    @else 
                                        <button type="button" class="btn btn-sm btn-light btn-active-success me-3" onclick="getKodeNasabah(this)" id="get-kode-nasabah">
                                            Get Kode Nasabah</button>
                                    @endif
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-sm btn-primary" id="customer-edit-save" style="background-color:#008CB4;">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button onclick="document.location.reload()" type="reset" class="btn btn-sm btn-light btn-active-danger pe-3 mx-2" id="cancel-button">
                                        Discard <i class="bi bi-x"></i></button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <a href="/customer" class="btn btn-sm btn-light btn-active-primary ms-3" id="customer-edit-close">
                                        Close</a>
                                    <!--end::Button-->


                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-fluid">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="row g-7">
                                    <!--begin::Contact groups-->
                                    <div class="col-lg-6 col-xl-3">
                                        <!--begin::Contact group wrapper-->
                                        <div class="card card-flush">

                                            <!--begin::Card body-->
                                            <div class="card-body pt-5">

                                                <form id="kt_ecommerce_settings_general_form" class="form" action="#">

                                                    <!--begin::Input group Name-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Name</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" id="name-customer" name="name-customer"
                                                            class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" value="{{ $customer->name }}"
                                                            placeholder="Nama" />
                                                        @error('name-customer')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group Name-->

                                                    <!--begin::Input group Email-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Email</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="email" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="email" name="email"
                                                            value="{{ $customer->email }}" placeholder="Email" />
                                                        @error('email')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span class="">Nomor Telp</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="phone-number"
                                                            name="phone-number" value="{{ $customer->phone_number }}" placeholder="Kontak Nomor" />
                                                        @error('phone-number')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span>Nomor Handphone</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="handphone" name="handphone"
                                                            value="{{ $customer->handphone }}" placeholder="Nomor Handphone" />
                                                        {{-- @error('phone-number')
                                                        <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror --}}
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span>fax</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="fax" name="fax" value="{{ $customer->fax }}" placeholder="Fax" />
                                                        {{-- @error('phone-number')
                                                        <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror --}}
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Options-->
                                                    @php
                                                        $check_customer = $customer->check_customer ? 'checked' : '';
                                                        $check_partner = $customer->check_partner ? 'checked' : '';
                                                        $check_competitor = $customer->check_competitor ? 'checked' : '';
                                                    @endphp

                                                    <div class="d-flex" style="flex-direction: column;">
                                                        <!--begin::Options-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value="" {{ $check_customer }} name="check-customer" />
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value="" {{ $check_partner }} name="check-partner" />
                                                            <span class="form-check-label">Partner</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value="" {{ $check_competitor }} name="check-competitor" />
                                                            <span class="form-check-label">Competitor</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->

                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-6">
                                                            <span>Website</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" id="website" name="website" value="{{ $customer->website }}"
                                                            placeholder="Website" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Address 1-->
                                                    <div class="fv-row mb-7" style="margin-top:10px;">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span>Address Line 1</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <textarea class="form-control form-control-solid" rows="6" name="AddressLine1">{{ $customer->address_1 }}</textarea>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Address 2-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Address Line 2</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <textarea class="form-control form-control-solid" rows="4" name="AddressLine2">{{ $customer->address_2 }}</textarea>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Kode Pos-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span>Kode Pos</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0" value="{{ $customer->kode_pos }}" name="kode-pos"/>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Row-->
                                                    <div class="row">
                                                        <!--begin::Col-->
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="1" name="key-client" id="key-client" {{ $customer->key_client == true ? "checked" : "" }}>
                                                                    <label class="form-check-label" for="key-client">
                                                                    Key Client
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->

                                                    <!--begin::Input group Kode Pos-->
                                                    {{-- <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3 required">
                                                            <span>Tax Number</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid" name="tax-number">{{ $customer->tax_number }}</input>
                                                        <!--end::Input-->
                                                    </div> --}}
                                                    <!--end::Input group-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contact group wrapper-->
                                    </div>
                                    <!--end::Contact groups-->



                                    <!--begin::Content-->
                                    <div class="col-xl-9">
                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <!--begin::Card body-->
                                            <div class="card-body pt-5">
                                                <!--begin:::Tabs-->
                                                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                                    <!--begin:::Tab Overview-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview"
                                                            style="font-size:12px;">OVERVIEW</a>
                                                    </li>
                                                    <!--end:::Tab Overview-->

                                                    <!--begin:::Tab item Informasi Perusahaan-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_company" style="font-size:12px;">COMPANY
                                                            INFORMATION</a>
                                                    </li>
                                                    <!--end:::Tab item Informasi Perusahaan-->

                                                    <!--begin:::Tab item Atachment & Notes-->
                                                    {{-- <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_performance"
                                                            style="font-size:12px;">PERFORMANCE</a>
                                                    </li> --}}
                                                    <!--end:::Tab item Atachment & Notes-->

                                                    <!--begin:::Tab item History-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_organisasi"
                                                            style="font-size:12px;">STRUKTUR ORGANISASI</a>
                                                    </li>
                                                    <!--end:::Tab item History-->

                                                    <!--begin:::Tab item History-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_history"
                                                            style="font-size:12px;">HISTORY</a>
                                                    </li>
                                                    <!--end:::Tab item History-->

                                                    <!--begin:::Tab item Customer Excellence-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_excellence"
                                                            style="font-size:12px;">CUSTOMER EXCELLENCE</a>
                                                    </li>
                                                    <!--end:::Tab item Customer Excellence-->

                                                    <!--begin:::Tab item Atachment & Notes-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_Notes"
                                                            style="font-size:12px;">ATTACHMENTS</a>
                                                    </li>
                                                    <!--end:::Tab item Atachment & Notes-->


                                                </ul>
                                                <!--end:::Ta    bs-->

                                                <!--begin:::Tab content -->
                                                <div class="tab-content" id="myTabContent">

                                                    <!--begin:::Tab pane Informasi Perusahaan-->
                                                    <div class="tab-pane fade" id="kt_user_view_company" role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                                                        <span class="">Instansi</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select name="jenis-instansi" onchange="getValueInstansi(this)" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Instansi">
                                                                        <option></option>
                                                                        @foreach ($sumberdanas as $sumberdana)
                                                                            @if ($sumberdana->nama_sumber == $customer->jenis_instansi)
                                                                                <option value="{{ $sumberdana->nama_sumber }}" selected>
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $sumberdana->nama_sumber }}">
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
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
                                                                        <span class="">Kode Unik</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" name="kodepelanggan-company" value="{{ $customer->kode_pelanggan }}"
                                                                        placeholder="Kode Unik" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row space-between">
                                                            <!--begin::Col-->
                                                            {{-- <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Tipe Unik Kode</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" name="npwp-company" value="{{ $customer->npwp_company }}"
                                                                        placeholder="Tipe Unik Kode" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div> --}}
                                                            <!--End begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                                                        <span class="">Kode Nasabah</span><i
                                                                            class="bi bi-lock"></i>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" id="kode-nasabah" name="kodenasabah-company" value="{{ $customer->kode_nasabah }}"
                                                                        placeholder="Kode Nasabah" readonly/>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->

                                                            <!--begin::Row-->
                                                            <!--Begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Tipe Kode Unik</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" id="select-kode-unik" name="input-kode-unik"
                                                                        value="unique_code" placeholder="Tipe Kode Unik" style="display: none" />
                                                                    <div id="div-provinsi">
                                                                        <select name="unique_code" id="kode unik" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                            data-placeholder="Tipe Kode Unik">
                                                                            <option value=""></option>                                                                                                                                          
                                                                            <option value="Kode Bagian Anggaran" {{ $customer -> unique_code == "Kode Bagian Anggaran" ? "selected" : "" }}>Kode Bagian Anggaran</option>
                                                                            <option value="Kode Anggaran Provinsi" {{ $customer -> unique_code == "Kode Anggaran Provinsi" ? "selected" : "" }}>Kode Anggaran Provinsi</option>
                                                                            <option value="NPWP" {{ $customer -> unique_code == "NPWP" ? "selected" : "" }}>NPWP</option>
                                                                            <option value="Businesse Permit License" {{ $customer -> unique_code == "Businesse Permit License" ? "selected" : "" }}>Businesse Permit License</option>
                                                                            <option value="Tax Identification Number" {{ $customer -> unique_code == "Tax Identification Number" ? "selected" : "" }}>Tax Identification Number</option>                                         
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                            <!--end::Row-->

                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span class="required">Negara</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <select onchange="this.form.submit()" name="negara" id="negara" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                            {{-- onchange="selectNegara(this)" --}}
                                                                            data-placeholder="Pilih Negara">
                                                                            <option value=""></option>
                                                                            @foreach ($data_negara as $negara)
                                                                                @if ($negara->abbreviation == $customer->negara || $negara->country == $customer->negara)
                                                                                    <option value="{{ $negara->abbreviation }}" selected>{{ $negara->country }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $negara->abbreviation }}">
                                                                                        {{ $negara->country }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                                <!--begin::Col-->
                                                                @php
                                                                    $is_instansi_BUMN = $customer->jenis_instansi == "BUMN";
                                                                    $is_user_pic = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
                                                                    // $title_tooltip = collect('Hanya bisa diinput');
                                                                    // if(!$is_user_pic) {
                                                                    //     $title_tooltip->push("oleh <b>DMROP</b>");
                                                                    // }
                                                                    // if(!$is_instansi_BUMN) {
                                                                    //     $title_tooltip->push("jika instansi <b>BUMN</b> atau <b>Anak dan Turunan BUMN</b>");
                                                                    // }
                                                                    // if($title_tooltip->count() > 1) {
                                                                    //     $title_tooltip = ($title_tooltip->count() < 2) ? $title_tooltip->join(" ") : $title_tooltip->join(" ", " dan ");
                                                                    // } else {
                                                                    //     $title_tooltip = null;
                                                                    // }
                                                                @endphp
                                                                <div class="col-6" id="group-tier-div" style="{{$is_instansi_BUMN ? "" : "display: none;"}}">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span class="required">Group Tier</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <select name="group-tier" id="group-tier" {{!empty($title_tooltip) ? "readonly" : ""}} class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                            {{-- onchange="selectNegara(this)" --}}
                                                                            data-placeholder="Pilih Group Tier">
                                                                            <option value=""></option>
                                                                            <option value="Tier A" {{$customer->group_tier && $is_instansi_BUMN == "Tier A" ? "selected" : ""}}>Tier A</option>
                                                                            <option value="Tier B" {{$customer->group_tier && $is_instansi_BUMN == "Tier B" ? "selected" : ""}}>Tier B</option>
                                                                            <option value="Tier C" {{$customer->group_tier && $is_instansi_BUMN == "Tier C" ? "selected" : ""}}>Tier C</option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                        
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--Begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span class="required">Provinsi</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid" id="input-provinsi" name="provinsi"
                                                                            value="{{ $customer->provinsi }}" placeholder="Provinsi" style="display: none" />
                                                                        <div id="div-provinsi">
                                                                            <select name="provinsi" id="provinsi" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                                onchange="selectProvinsi(this)" 
                                                                                data-placeholder="Pilih Customer Provinsi">
                                                                                <option value=""></option>
                                                                                @foreach ($data_provinsi as $provinsi)
                                                                                    @if ($provinsi->province_id == $customer->provinsi)
                                                                                        <option value="{{ $provinsi->province_id }}" selected>
                                                                                            {{ ucwords(strtolower($provinsi->province_name)) }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option value="{{ $provinsi->province_id }}">
                                                                                            {{ ucwords(strtolower($provinsi->province_name)) }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
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
                                                                            <span class="required">Kota / Kabupaten</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid" id="input-kabupaten" name="kabupaten"
                                                                            value="{{ $customer->kota_kabupaten }}" placeholder="Kabupaten" style="display: none" />
                                                                        <div id="div-kabupaten">
                                                                            <select name="kabupaten" id="kabupaten" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                                onchange="selectKabupaten(this)" data-placeholder="Pilih Customer Kabupaten">
                                                                                <option value=""></option>
                                                                                @if (!empty($data_kabupaten))
                                                                                    @foreach ($data_kabupaten as $kabupaten)
                                                                                        @if ($kabupaten->name == $customer->kota_kabupaten)
                                                                                            <option value="{{ $kabupaten->name }}" selected>
                                                                                                {{ ucwords(strtolower($kabupaten->name)) }}
                                                                                            </option>
                                                                                        @else
                                                                                            <option value="{{ $kabupaten->name }}">
                                                                                                {{ ucwords(strtolower($kabupaten->name)) }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <!--begin:: Row-->
                                                            <div class="row fv-row">
                                                                <div class="col-6">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Industry Sector</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <select name="industry-sector" id="industry-sector" class="form-select form-select-solid pe-5" data-control="select2" data-hide-search="false"
                                                                            data-placeholder="Pilih Industry Sector" onchange=getIndustrySector(this)>
                                                                        <option value=""></option>
                                                                        @foreach ($industryOwners as $io)
                                                                            @if ($io->code_owner == $customer->industry_sector)
                                                                                <option value="{{ $io->code_owner }}" id="test" data-attract="{{ $io->owner_attractiveness }}" selected>
                                                                                    {{ ucwords(strtolower($io->owner_description)) }}
                                                                                </option>                                                                                                                                                
                                                                            @else
                                                                                <option value="{{ $io->code_owner }}" data-attract="{{ $io->owner_attractiveness }}" >
                                                                                    {{ ucwords(strtolower($io->owner_description)) }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <script>
                                                                    function getIndustrySector(e){
                                                                        let attractiveness = "";
                                                                        e.options.forEach(option => {
                                                                            if(option.selected){                                                                                
                                                                                attractiveness = option.getAttribute("data-attract")
                                                                            }
                                                                            document.querySelector("#attractiveness").value = attractiveness                                                                            
                                                                        })
                                                                    }
                                                                </script>  
                                                                <div class="col-6">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Industry Attractiveness</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                     <!--begin::Input-->
                                                                         <input type="text"
                                                                         class="form-control form-control-solid"
                                                                         id="attractiveness" name="attractiveness"
                                                                         value="{{ $customer->IndustryOwner->owner_attractiveness ?? null }}"
                                                                         placeholder="Attractiveness" readonly />
                                                                     <!--end::Input-->
                                                                </div>
                                                            </div>
                                                            <!--end:: Row-->

                                                            <!--Begin::Row-->
                                                            <div class="row fv-row my-7">
                                                                <!--begin::column-->
                                                                <div class="col-6">
                                                                    <!--begin::label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Jenis Perusahaan</span>
                                                                    </label>
                                                                    <!--end::label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" id="input-provinsi" name="jenis_perusahaan"
                                                                        value="{{ null }}" placeholder="Jenis Perusahaan" style="display: none" />
                                                                    <div id="div-jenis-perusahaan">
                                                                        <select name="jenis_perusahaan" id="jenis_perusahaan" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                            {{-- onchange="selectProvinsi(this)"  --}}
                                                                            data-placeholder="Pilih Jenis Perusahaan">
                                                                            <option value=""></option>
                                                                            @foreach ($jenisPerusahaan as $jp)
                                                                                @if ( !empty($customer->JenisPerusahaan) && $jp->kode_jenis == $customer->JenisPerusahaan->kode_jenis)
                                                                                    <option value="{{ $jp->kode_jenis }}" selected>
                                                                                        {{ $jp->deskripsi }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $jp->kode_jenis }}">
                                                                                        {{ $jp->deskripsi }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::column-->
                                                                
                                                                <!--begin::column-->
                                                                <div class="col-6">
                                                                    <!--begin::label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Term of Payment</span>
                                                                    </label>
                                                                    <!--end::label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" class="form-control form-control-solid" id="input-provinsi" name="syarat_pembayaran"
                                                                        value="{{ null }}" placeholder="Term of Payment" style="display: none" />
                                                                    <div id="div-syarat-pembayaran">
                                                                        <select name="syarat_pembayaran" id="syarat-pembayaran" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                            data-placeholder="Term of Payment">
                                                                            <option value=""></option>
                                                                            <option value="ZC00" {{ $customer->syarat_pembayaran == "ZC00" ? "selected" : ""}}>Payable immediately Due Net</option>
                                                                            <option value="ZC01" {{ $customer->syarat_pembayaran == "ZC01" ? "selected" : ""}}>within 14 days Due net</option>
                                                                            <option value="ZC02" {{ $customer->syarat_pembayaran == "ZC02" ? "selected" : ""}}>within 30 days Due net</option>
                                                                            <option value="ZC03" {{ $customer->syarat_pembayaran == "ZC03" ? "selected" : ""}}>within 45 days Due net</option>
                                                                            <option value="ZC04" {{ $customer->syarat_pembayaran == "ZC04" ? "selected" : ""}}>within 60 days Due net</option>
                                                                            <option value="ZC05" {{ $customer->syarat_pembayaran == "ZC05" ? "selected" : ""}}>within 90 days Due net</option>
                                                                            <option value="ZC06" {{ $customer->syarat_pembayaran == "ZC06" ? "selected" : ""}}>within 120 days Due net</option>
                                                                            <option value="ZC07" {{ $customer->syarat_pembayaran == "ZC07" ? "selected" : ""}}>within 180 days Due net</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::column-->
                                                            </div>
                                                            <!--End::Row-->

                                                            <!--Begin::Row-->
                                                            <!--begin::column-->
                                                            <div class="col-6">
                                                                <!--begin::label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span class="required">Tax</span>
                                                                </label>
                                                                <!--end::label-->
                                                                <!--begin::Input-->
                                                                <div id="div-tax">
                                                                    <select name="tax" id="tax" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Tax">
                                                                        <option value=""></option>
                                                                        {{-- <option value="0">Tax Exempt</option>
                                                                        <option value="1">Non WAPU Pihak 3</option>
                                                                        <option value="2">Non WAPU Berelasi</option>
                                                                        <option value="3">WAPU Pemerintah</option>
                                                                        <option value="4">WAPU BUMN/PIHAK LAIN</option>
                                                                        <option value="5">Ditanggung Pemerintah</option>
                                                                        <option value="6">Dibebaskan</option>
                                                                        <option value="7">Luar Negeri</option> --}}
                                                                        <option value="0" {{ $customer->tax == "0" ? "selected" : ""}}>Tax Exempt</option>
                                                                        <option value="1" {{ $customer->tax == "1" ? "selected" : ""}}>Non WAPU Pihak 3</option>
                                                                        <option value="2" {{ $customer->tax == "2" ? "selected" : ""}}>Non WAPU Berelasi</option>
                                                                        <option value="3" {{ $customer->tax == "3" ? "selected" : ""}}>WAPU Pemerintah</option>
                                                                        <option value="4" {{ $customer->tax == "4" ? "selected" : ""}}>WAPU BUMN/PIHAK LAIN</option>
                                                                        <option value="5" {{ $customer->tax == "5" ? "selected" : ""}}>Ditanggung Pemerintah</option>
                                                                        <option value="6" {{ $customer->tax == "6" ? "selected" : ""}}>Dibebaskan</option>
                                                                        <option value="7" {{ $customer->tax == "7" ? "selected" : ""}}>Luar Negeri</option>
                                                                    </select>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::column-->
                                                            <!--ENd::Row-->

                                                            <!--begin::Fungsi Select Provinsi-->
                                                            <script>
                                                                // async function selectNegara(e) {
                                                                //     // console.log(e.value);
                                                                //     const idProvinsi = e.value;
                                                                //     // console.log(elt.value);
                                                                //     let html = ``;
                                                                //     // Get Provinsi
                                                                //     const getKabupaten = await fetch(`/get-kabupaten/${idProvinsi}`).then(res => res.json());
                                                                //     getKabupaten.forEach(kabupaten => {
                                                                //         html += `<option value="${kabupaten.province_id}">${kabupaten.province_name}</option>`;
                                                                //     });
                                                                //     document.querySelector("#provinsi").innerHTML = html;
                                                                //     // if (e.value != "Indonesia") {
                                                                //     //     document.querySelector("#input-provinsi").style.display = "";
                                                                //     //     document.querySelector("#input-provinsi").value = "";
                                                                //     //     document.querySelector("#provinsi").disabled = true;
                                                                //     //     document.querySelector("#div-provinsi").style.display = "none";

                                                                //     //     document.querySelector("#input-kabupaten").style.display = "";
                                                                //     //     document.querySelector("#input-kabupaten").value = "";
                                                                //     //     document.querySelector("#kabupaten").disabled = true;
                                                                //     //     document.querySelector("#div-kabupaten").style.display = "none";
                                                                //     // } else {
                                                                //     //     document.querySelector("#input-provinsi").style.display = "none";
                                                                //     //     document.querySelector("#div-provinsi").style.display = "";
                                                                //     //     document.querySelector("#provinsi").disabled = false;
                                                                //     //     document.querySelector("#input-kabupaten").style.display = "none";
                                                                //     //     document.querySelector("#div-kabupaten").style.display = "";
                                                                //     //     document.querySelector("#kabupaten").disabled = false;

                                                                //     // }
                                                                // }
                                                                async function selectProvinsi(elt) {
                                                                    const idProvinsi = elt.value.split("-")[1];
                                                                    let html = ``;
                                                                    const getKabupaten = await fetch(`/get-kabupaten/${idProvinsi}`).then(res => res.json());
                                                                    
                                                                    getKabupaten.forEach(kabupaten => {
                                                                        html += `<option value="${kabupaten.name}">${kabupaten.name}</option>`;
                                                                    });
                                                                    document.querySelector("#kabupaten").innerHTML = html;
                                                                }
                                                            </script>
                                                            <!--end::Fungsi Select Provinsi-->

                                                        </div>
                                                        <!--End begin::Row-->
                                                        
                                                        <br>
                                                        <br>
                                                        <br>

                                                        <!--begin::Data SAP-->
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail" style="font-size:14px;">Legal
                                                        </h3>

                                                        <div id="divLegal">
                                                            <!--end::Data SAP-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span class="">No NPWP</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid char-counter" onkeyup="removeSymbol(this)" data-max-char="15" name="npwp-company" value="{{ $customer->npwp_company }}"
                                                                            placeholder="NPWP" />
                                                                        <div class="d-flex flex-row justify-content-end">
                                                                            <small class="">0/40</small>
                                                                        </div>
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
                                                                        <textarea class="form-control form-control-solid" name="npwp-address"
                                                                            placeholder="Alamat NPWP">{{ $customer->npwp_address }}</textarea>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->

                                                            </div>
                                                            <!--End begin::Row-->
                                                        </div>

                                                        <br>

                                                        <!--begin::INPUT PIC-->
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail" style="font-size:14px;">
                                                            Contact / PIC
                                                            <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_pic">+</a>
                                                        </h3>
                                                        <!--end::INPUT PIC-->
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="text-center">No.</th>
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Email</th>
                                                                    <th class="min-w-auto">Jabatan</th>
                                                                    <th class="min-w-auto">Kontak Nomor</th>
                                                                    <th class="min-w-auto">Tanggah Lahir PIC</th>
                                                                    <th class="min-w-auto"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($customer->pic as $pic)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            <a href="#" class="text-gray-800 text-hover-primary" data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_edit_pic_{{ $pic->id }}">{{ $pic->nama_pic }}</a>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Email-->
                                                                        <td>
                                                                            {{ $pic->email_pic ?? '-' }}
                                                                        </td>
                                                                        <!--end::Email-->
                                                                        <!--begin::Jabatan-->
                                                                        <td>
                                                                            {{ $pic->jabatan_pic ?? '-' }}
                                                                        </td>
                                                                        <!--end::Jabatan-->
                                                                        <!--begin::Phone-->
                                                                        <td>
                                                                            {{ $pic->phone_pic ?? '-' }}
                                                                        </td>
                                                                        <!--end::Phone-->
                                                                        <!--begin::Phone-->
                                                                        <td>
                                                                            {{ $pic->ultah_pic ?? '-' }}
                                                                        </td>
                                                                        <!--end::Phone-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal" data-bs-target="#kt_pic_delete_{{ $pic->id }}" id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->

                                                        <br>

                                                        <!--begin::Data PIC MANRISK-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">MANRISK
                                                            <i onclick="hideColumn(this, '#divMANRISK')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                onclick="showColumn(this, '#divMANRISK')" id="show-button" class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <br>
                                                        <div id="divMANRISK" style="display:none">
                                                            <!--Begin::Row-->
                                                            <div class="row fv-row my-7">
                                                                <!--Begin::Coloumn-->
                                                                <div class="col-6">
                                                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                                                        <span class="">Fortune Rank</span>
                                                                    </label>
                                                                    <!--Begin::Select-->
                                                                    <div id="div-forbes">
                                                                        <select name="forbes_rank" id="forbes_rank" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                            {{-- onchange="selectProvinsi(this)"  --}}
                                                                            data-placeholder="Pilih Rank Forbes">
                                                                            <option value=""></option>
                                                                            <option value="Urutan 1-50"{{ $customer -> forbes_rank == "Urutan 1-50" ? "selected" : "" }}>Urutan 1-50</option>
                                                                            <option value="Urutan 51-100"{{ $customer -> forbes_rank == "Urutan 51-100" ? "selected" : "" }}>Urutan 51-100</option>
                                                                            <option value="Diluar Top 100"{{ $customer -> forbes_rank == "Diluar Top 100" ? "selected" : "" }}>Diluar Top 100</option>                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <!--End::Select-->
                                                                <!--End::Coloumn-->

                                                                <!--Begin::Coloumn-->
                                                                <div class="col-6">
                                                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                                                        <span class="">LQ Rank</span>
                                                                    </label>
                                                                    <!--Begin::Select-->
                                                                    <div id="div-lq">
                                                                        <select name="lq_rank" id="lq_rank" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                                            {{-- onchange="selectProvinsi(this)"  --}}
                                                                            data-placeholder="Pilih Rank LQ">
                                                                            <option value=""></option>
                                                                            <option value="Urutan 1-20"{{ $customer -> lq_rank == "Urutan 1-20" ? "selected" : "" }}>Urutan 1-20</option>
                                                                            <option value="Urutan 21-45"{{ $customer -> lq_rank == "Urutan 21-45" ? "selected" : "" }}>Urutan 21-45</option>
                                                                            <option value="Diluar Top 45"{{ $customer -> lq_rank == "Diluar Top 45" ? "selected" : "" }}>Diluar Top 45</option>                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <!--End::Select-->
                                                                <!--End::Coloumn-->
                                                            </div>

                                                            <!--Begin::Row-->
                                                            {{-- <div class="row fv-row">
                                                                <div class="col">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Layer Segmentasi</span>
                                                                        <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-custom-class="custom-tooltip"
                                                                        data-bs-title="On Development"
                                                                        data-bs-html="true"></i>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select name="layer_segmentasi" id="layer_segmentasi" class="form-select form-select-solid pe-5" data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Pilih Layer Segmentasi">
                                                                        <option value="" selected></option>
                                                                        <option value="Decision Maker"{{ $customer -> layer_segmentasi == "Decision Maker" ? "selected" : "" }}>Decision Maker</option>
                                                                        <option value="Influencer"{{ $customer -> layer_segmentasi == "Influencer" ? "selected" : "" }}>Influencer</option>
                                                                        <option value="Buyer"{{ $customer -> layer_segmentasi == "Buyer" ? "selected" : "" }}>Buyer</option>
                                                                        <option value="User"{{ $customer -> layer_segmentasi == "User" ? "selected" : "" }}>User</option>
                                                                        <option value="Gate Keeper"{{ $customer -> layer_segmentasi == "Gate Keeper" ? "selected" : "" }}>Gate Keeper</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                            </div> --}}
                                                            <!--End::Row-->
                                                        </div>
                                                        <!--end::Data PIC MANRISK-->

                                                        <br><br>

                                                        <!--begin::Data SAP-->
                                                        {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">SAP
                                                            <i onclick="hideColumn(this, '#divSAP')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                onclick="showColumn(this, '#divSAP')" id="show-button" class="bi bi-arrows-expand"></i>
                                                        </h3> --}}

                                                        {{-- <div id="divSAP" style="display:none">
                                                            <!--end::Data SAP-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Supplier</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="supplier" class="form-control form-control-solid"
                                                                            value="" placeholder="Supplier" />
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
                                                                            <span>BP Grouping</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="bp-grouping" class="form-control form-control-solid"
                                                                            value="" placeholder="BP Grouping" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Name 2</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="name-2" class="form-control form-control-solid"
                                                                            value="" placeholder="Name 2" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Name 3</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="name-3" class="form-control form-control-solid"
                                                                            value="" placeholder="Name 3" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Search Term 1</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="search-term-1" class="form-control form-control-solid"
                                                                            value="" placeholder="Search Term 1" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Search Term 2</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="search-term-2" class="form-control form-control-solid"
                                                                            value="" placeholder="Search Term 2" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Industry Code 2</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="industry-code-2" class="form-control form-control-solid"
                                                                            value="" placeholder="Industry Code 2" />
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
                                                                            <span>Languange</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="languange" class="form-control form-control-solid"
                                                                            value="" placeholder="Languange" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>BP ROLE</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="bp-role" class="form-control form-control-solid"
                                                                            value="" placeholder="BP ROLE" />
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
                                                                            <span>Reconciliation Account</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="reconciliation-account" class="form-control form-control-solid"
                                                                            value="" placeholder="Reconciliation Account" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Check Double Invoice</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="check-double-invoice" class="form-control form-control-solid"
                                                                            value="" placeholder="Check Double Invoice" />
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
                                                                            <span>Withholding Tax Type</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="withholding-tax-type" class="form-control form-control-solid"
                                                                            value="" placeholder="Withholding Tax Type" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Subject</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="subject" class="form-control form-control-solid"
                                                                            value="" placeholder="Subject" />
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
                                                                            <span>Oblig. From</span>
                                                                            <a href="#" class="btn" style="background: transparent;" id="oblig-from" onclick="showCalendarModal(this)">
                                                                                <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                                                            </a>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="date" name="oblig-from" class="form-control form-control-solid"
                                                                            value="" placeholder="Oblig. From" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Oblig. To</span>
                                                                            <a href="#" class="btn" style="background: transparent;" id="oblig-to" onclick="showCalendarModal(this)">
                                                                                <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                                                            </a>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="date" name="oblig-to" class="form-control form-control-solid"
                                                                            value="" placeholder="Oblig. To" />
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
                                                                            <span>Sales Organization</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="sales-organization" class="form-control form-control-solid"
                                                                            value="" placeholder="Sales Organization" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Distribution Channel</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="distribution-channel" class="form-control form-control-solid"
                                                                            value="" placeholder="Distribution Channel" />
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
                                                                            <span>Customer Group</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="customer-group" class="form-control form-control-solid"
                                                                            value="" placeholder="Customer Group" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Price Procedure Term</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="price-procedure-term" class="form-control form-control-solid"
                                                                            value="" placeholder="Price Procedure Term" />
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
                                                                            <span>Shipping Condition</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="shipping-condition" class="form-control form-control-solid"
                                                                            value="" placeholder="Shipping Condition" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Account Assignment Group</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="account-assignment-group" class="form-control form-control-solid"
                                                                            value="" placeholder="Account Assignment Group" />
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
                                                                            <span>Purchasing Organization</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="purchasing-organization" class="form-control form-control-solid"
                                                                            value="" placeholder="Purchasing Organization" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Order Currency</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="order-currency" class="form-control form-control-solid"
                                                                            value="" placeholder="Order Currency" />
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
                                                                            <span>GR-Based Invoice Verification</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="gr-based-invoice-verification" class="form-control form-control-solid"
                                                                            value="" placeholder="GR-Based Invoice Verification" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Confirmation Control Key</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="confirmation-control-key" class="form-control form-control-solid"
                                                                            value="" placeholder="Confirmation Control Key" />
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
                                                                            <span>Tax Number Category</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="tax-number-category" class="form-control form-control-solid"
                                                                            value="" placeholder="Tax Number Category" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Tax Number</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="tax-number" class="form-control form-control-solid"
                                                                            value="" placeholder="Tax Number" />
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
                                                                            <span>Bank Country Key</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="bank-country-key" class="form-control form-control-solid"
                                                                            value="" placeholder="Bank Country Key" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Bank Keys</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="bank-keys" class="form-control form-control-solid"
                                                                            value="" placeholder="Bank Keys" />
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
                                                                            <span>Account No.</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="account-no" class="form-control form-control-solid"
                                                                            value="" placeholder="Account No." />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Account Holder Name</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="account-holder-name" class="form-control form-control-solid"
                                                                            value="" placeholder="Account Holder Name" />
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
                                                                            <span>Partner Function</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="partner-function" class="form-control form-control-solid"
                                                                            value="" placeholder="Partner Function" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Tax Category</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="tax-category" class="form-control form-control-solid"
                                                                            value="" placeholder="Tax Category" />
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
                                                                            <span>Tax Classification</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="tax-classification" class="form-control form-control-solid"
                                                                            value="" placeholder="Tax Classification" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Last Name</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="last-name" class="form-control form-control-solid"
                                                                            value="" placeholder="Last Name" />
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
                                                                            <span>Street</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="street" class="form-control form-control-solid"
                                                                            value="" placeholder="Street" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                        </div> --}}
                                                        <!--end::Data SAP-->
                                                        <br>

                                                    </div>
                                                    <!--end:::Tab pane Informasi Perusahaan-->

                                                    <!--begin:::Tab pane Performance-->
                                                    <div class="tab-pane fade" id="kt_user_view_performance" role="tabpanel">
                                                        <div class="tab-pane fade show active" id="kt_user_view_performance" role="tabpanel">
                                                            <!--begin::Data Performance-->
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Data Performance
                                                            </h3>
                                                            <!--end::Data Performance-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid reformat" id="nilaiok-performance" name="nilaiok-performance"
                                                                            value="{{ $customer->nilaiok }}" placeholder="Nilai OK" />
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
                                                                            <span>Piutang</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid reformat" name="piutang-performance"
                                                                            value="{{ $customer->piutang }}" placeholder="Piutang" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Laba</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid reformat" name="laba-performance" value="{{ $customer->laba }}"
                                                                            placeholder="Laba" />
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
                                                                            <span>Rugi</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" class="form-control form-control-solid reformat" name="rugi-performance" value="{{ $customer->rugi }}"
                                                                            placeholder="Rugi" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <br>
                                                        </div>
                                                    </div>
                                                    <!--end:::Tab pane Performance-->


                                                    <!--begin:::Tab pane Struktur Organisasi-->
                                                    <div class="tab-pane fade" id="kt_user_view_organisasi" role="tabpanel">

                                                        <!--begin::Attachment-->
                                                        <h3 class="fw-bolder    m-0" id="HeadDetail" style="font-size:14px;">
                                                            Upload Struktur Organisasi
                                                        </h3>

                                                        <div>
                                                            <label for="struktur-attachment" class="form-label"></label>
                                                            <input onchange="this.form.submit()" class="form-control form-control-sm" id="struktur-attachment" name="struktur-attachment"
                                                                type="file" accept=".pdf">
                                                        </div>

                                                        <br>
                                                        <div class="ms-3 col">
                                                            <table class="table align-middle table-row-dashed fs-6" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                                                                        <th class="min-w-auto">Struktur Organisasi Attachment</th>
                                                                        <th class="min-w-auto">Modified On</th>
                                                                        {{-- <th class="min-w-auto">Modified By</th> --}}
                                                                        <th class="w-100px"></th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">
                                                                    @foreach ($strukturAtttachment as $strAttachments)
                                                                        <tr>
                                                                            <!--begin::Name-->
                                                                            <td>
                                                                                @if (str_contains("$strAttachments->name_attachment", '.doc'))
                                                                                    <a href="/document/view/{{ $strAttachments->id_struktur_attachment }}/{{ $strAttachments->id_document }}"
                                                                                        class="text-hover-primary">{{ $strAttachments->nama_dokumen }}</a>
                                                                                @else
                                                                                    <a target="_blank" href="{{ asset('words/' . $strAttachments->id_document . '.pdf') }}"
                                                                                        class="text-hover-primary">{{ $strAttachments->nama_dokumen }}</a>
                                                                                @endif
                                                                            </td>
                                                                            <!--end::Name-->
                                                                            <!--begin::Time-->
                                                                            <td>
                                                                                <a>{{ Carbon\Carbon::create($strAttachments->created_at)->translatedFormat("d F Y") }}</a>
                                                                            </td>
                                                                            <!--end::Time-->
                                                                            <!--begin::Action-->
                                                                            <td class="text-center">
                                                                                <small>
                                                                                    <button type="button" onclick="deleteStrukturAttach(this)"
                                                                                        data-id-attach="{{ $strAttachments->id_struktur_attachment }}"
                                                                                        class="btn d-flex flex-row btn-sm btn-light btn-active-primary align-items-center">
                                                                                        <span>Delete</span>
                                                                                        <div class="spinner-border spinner-border-sm ms-3"style="display: none;" role="status"></div>
                                                                                    </button>
                                                                                </small>
                                                                            </td>
                                                                            <!--end::Action-->
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <!--begin::Input-->
                                                        {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Import Struktur :
                                                            </h3><br>
                                                            <input accept=".xls, .xlsx" class="form-control form-control-md form-control-solid" id="doc-attachment" name="import-file" type="file"> --}}
                                                        <!--end::Input-->

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Input Struktur Organisasi
                                                            <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_struktur">+</a>
                                                        </h3>
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6" id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="text-center">No.</th>
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Email</th>
                                                                    <th class="min-w-auto">Jabatan</th>
                                                                    <th class="min-w-auto">Kontak Nomor</th>
                                                                    <th class="min-w-auto">Tanggal Lahir</th>
                                                                    <th class="min-w-auto">Proyek Terkait</th>
                                                                    <th class="min-w-auto">Role</th>
                                                                    <th class="min-w-auto"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if (!empty($strukturs))
                                                                    @foreach ($strukturs as $struktur)
                                                                        <tr>
                                                                            <!--begin::Name-->
                                                                            <td class="text-center">
                                                                                {{ $no++ }}
                                                                            </td>
                                                                            <!--end::Name-->
                                                                            <!--begin::Name-->
                                                                            <td>
                                                                                <a href="#" class="text-gray-800 text-hover-primary" data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_modal_edit_struktur_{{ $struktur->id }}">{{ $struktur->nama_struktur }}</a>
                                                                            </td>
                                                                            <!--end::Name-->
                                                                            <!--begin::Email-->
                                                                            <td>
                                                                                {{ $struktur->email_struktur ?? '-' }}
                                                                            </td>
                                                                            <!--end::Email-->
                                                                            <!--begin::Jabatan-->
                                                                            <td>
                                                                                {{ $struktur->jabatan_struktur ?? '-' }}
                                                                            </td>
                                                                            <!--end::Jabatan-->
                                                                            <!--begin::Phone-->
                                                                            <td>
                                                                                {{ $struktur->phone_struktur ?? '-' }}
                                                                            </td>
                                                                            <!--end::Phone-->
                                                                            <!--begin::Column-->
                                                                            <td>
                                                                                {{ $struktur->ultah_struktur ?? '-' }}
                                                                            </td>
                                                                            <!--end::Column-->
                                                                            <!--begin::Column-->
                                                                            <td>
                                                                                {{-- {{ $struktur->proyek_struktur ?? '-' }} --}}
                                                                                @foreach ($proyeks as $proyek)
                                                                                    @if ($struktur->proyek_struktur == $proyek->kode_proyek)
                                                                                        {{ $proyek->nama_proyek ?? '-' }}
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <!--end::Column-->
                                                                            <!--begin::Column-->
                                                                            <td>
                                                                                {{ $struktur->role_struktur ?? '-' }}
                                                                            </td>
                                                                            <!--end::Column-->
                                                                            <!--begin::Action-->
                                                                            <td class="text-center">
                                                                                <small>
                                                                                    <p data-bs-toggle="modal" data-bs-target="#kt_struktur_delete_{{ $struktur->id }}" id="modal-delete"
                                                                                        class="btn btn-sm btn-light btn-active-primary">
                                                                                        Delete
                                                                                    </p>
                                                                                </small>
                                                                            </td>
                                                                            <!--end::Action-->
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        <br>
                                                        <br>
                                                        <br>

                                                    </div>
                                                    <!--end:::Tab pane Struktur Organisasi-->


                                                    <!--begin:::Tab pane History-->
                                                    <div class="tab-pane fade" id="kt_user_view_history" role="tabpanel">

                                                        <!--begin::Proyek Berjalan-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Proyek Berjalan
                                                                <i onclick="hideColumn(this, '#divProyekBerjalan')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                    onclick="showColumn(this, '#divProyekBerjalan')" id="show-button" class="bi bi-arrows-expand"></i>
                                                            </h3>

                                                            <br>
                                                            <div id="divProyekBerjalan" style="display:none">

                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Nomor SPK</th>
                                                                            <th class="min-w-auto">Nama Proyek</th>
                                                                            <th class="min-w-auto">Unit kerja</th>
                                                                            <th class="min-w-auto">Nilai OK</th>
                                                                            <th class="min-w-auto">Tanggal Mulai</th>
                                                                            <th class="min-w-auto">Tanggal Selesai</th>
                                                                            <th class="min-w-auto">Durasi</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">
                                                                        @if (isset($proyekberjalan))
                                                                            @foreach ($proyekberjalan as $proyekberjalan0)
                                                                                @if ($proyekberjalan0->stage == 8)
                                                                                    <tr>
                                                                                        <!--begin::Kode-->
                                                                                        <td>
                                                                                            {{-- @if (!empty($proyekberjalan0->proyek->ContractManagements))
                                                                                                <a target="_blank" href="/contract-management/view/{{ url_encode($proyekberjalan0->proyek->ContractManagements->id_contract) }}" class="text-gray-600 text-hover-primary mb-1">
                                                                                                    {{ $proyekberjalan0->proyek->nospk_external ?? '-' }}
                                                                                                </a>
                                                                                            @endif --}}
                                                                                            <a href="#" data-bs-toggle="modal"
                                                                                                data-bs-target="#proyek_berjalan_{{ $proyekberjalan0->kode_proyek }}"
                                                                                                id="modal-delete"
                                                                                                class="text-gray-600 {{ !empty($proyekberjalan0->proyek->nospk_external) ? 'text-hover-primary' : 'text-hover-danger' }} mb-1">{{ !empty($proyekberjalan0->proyek->nospk_external) ? $proyekberjalan0->proyek->nospk_external : '*Belum Ditentukan' }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <!--end::Kode-->
                                                                                        <!--begin::Name-->
                                                                                        <td>
                                                                                            <a target="_blank" href="/proyek/view/{{ $proyekberjalan0->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                                {{ $proyekberjalan0->nama_proyek }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <!--end::Name-->
                                                                                        <!--begin::Unit-->
                                                                                        <td>
                                                                                            {{ $proyekberjalan0->UnitKerja->unit_kerja ?? '-' }}
                                                                                        </td>
                                                                                        <!--end::Unit-->
                                                                                        <!--begin::Nilai OK-->
                                                                                        <td>{{ number_format($proyekberjalan0->proyek->nilai_rkap, 0, '.', '.') }}
                                                                                        </td>
                                                                                        <!--end::Nilai OK-->
                                                                                        <!--begin::Start-->
                                                                                        <td>
                                                                                            {{ Carbon\Carbon::create($proyekberjalan0->proyek->tanggal_mulai_terkontrak)->translatedFormat("d F Y") }}
                                                                                        </td>
                                                                                        <!--end::End-->
                                                                                        <!--begin::Start-->
                                                                                        <td>
                                                                                            {{ Carbon\Carbon::create($proyekberjalan0->proyek->tanggal_akhir_terkontrak)->translatedFormat("d F Y") }}
                                                                                        </td>
                                                                                        <!--end::End-->
                                                                                        <!--begin::Durasi-->
                                                                                        <td>
                                                                                            @php
                                                                                                $tglakhir = new DateTime($proyekberjalan0->proyek->tanggal_akhir_terkontrak ?? date('now'));
                                                                                                $tglawal = new DateTime($proyekberjalan0->proyek->tanggal_mulai_terkontrak ?? date('now'));
                                                                                                $durasi = $tglakhir->diff($tglawal);
                                                                                            @endphp
                                                                                            {{ $durasi->y }} Tahun,
                                                                                            {{ $durasi->m }} Bulan
                                                                                        </td>
                                                                                        <!--end::Durasi-->
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Proyek Berjalan-->

                                                        <br><br>

                                                        <!--begin::Proyek Terkontrak-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Proyek Selesai
                                                                <i onclick="hideColumn(this, '#divProyekSelesai')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                    onclick="showColumn(this, '#divProyekSelesai')" id="show-button" class="bi bi-arrows-expand"></i>
                                                            </h3>
                                                            <br>
                                                            <div id="divProyekSelesai" style="display:none">
                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Nomor SPK</th>
                                                                            <th class="min-w-auto">Nama Proyek</th>
                                                                            <th class="min-w-auto">Unit kerja</th>
                                                                            <th class="min-w-auto">Nilai OK</th>
                                                                            <th class="min-w-auto">Tanggal Mulai</th>
                                                                            <th class="min-w-auto">Tanggal Akhir</th>
                                                                            <th class="min-w-auto">Durasi</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">
                                                                        @if (isset($proyekberjalan))
                                                                            @foreach ($proyekberjalan as $proyekberjalan0)
                                                                            @if (!empty($proyekberjalan0->proyek->ContractManagements))
                                                                                @if ($proyekberjalan0->stage == 8 && $proyekberjalan0->proyek->ContractManagements->stages == 4 )
                                                                                    <tr>
                                                                                        <!--begin::Kode-->
                                                                                        <td>
                                                                                            <a href="#" data-bs-toggle="modal"
                                                                                                data-bs-target="#proyek_berjalan_{{ $proyekberjalan0->kode_proyek }}"
                                                                                                id="modal-delete"
                                                                                                class="text-gray-600 {{ !empty($proyekberjalan0->proyek->nospk_external) ? 'text-hover-primary' : 'text-hover-danger' }} mb-1">{{ !empty($proyekberjalan0->proyek->nospk_external) ? $proyekberjalan0->proyek->nospk_external : '*Belum Ditentukan' }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <!--end::Kode-->
                                                                                        <!--begin::Name-->
                                                                                        <td>
                                                                                            <a target="_blank" href="/proyek/view/{{ $proyekberjalan0->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                                {{ $proyekberjalan0->nama_proyek }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <!--end::Name-->
                                                                                        <!--begin::Unit-->
                                                                                        <td>
                                                                                            {{ $proyekberjalan0->UnitKerja->unit_kerja ?? '-' }}
                                                                                        </td>
                                                                                        <!--end::Unit-->
                                                                                        <!--begin::Nilai OK-->
                                                                                        <td>{{ number_format($proyekberjalan0->proyek->nilai_rkap, 0, '.', '.') }}
                                                                                        </td>
                                                                                        <!--end::Nilai OK-->
                                                                                        <!--begin::Start-->
                                                                                        <td>
                                                                                            {{ $proyekberjalan0->proyek->tanggal_mulai_terkontrak }}
                                                                                        </td>
                                                                                        <!--end::End-->
                                                                                        <!--begin::Start-->
                                                                                        <td>
                                                                                            {{ $proyekberjalan0->proyek->tanggal_akhir_terkontrak }}
                                                                                        </td>
                                                                                        <!--end::End-->
                                                                                        <!--begin::Durasi-->
                                                                                        <td>
                                                                                            @php
                                                                                                $tglakhir = new DateTime($proyekberjalan0->proyek->tanggal_akhir_terkontrak ?? date('now'));
                                                                                                $tglawal = new DateTime($proyekberjalan0->proyek->tanggal_mulai_terkontrak ?? date('now'));
                                                                                                $durasi = $tglakhir->diff($tglawal);
                                                                                            @endphp
                                                                                            {{ $durasi->y }} Tahun,
                                                                                            {{ $durasi->m }} Bulan
                                                                                        </td>
                                                                                        <!--end::Durasi-->
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Card title-->

                                                        <br><br>

                                                        <!--begin:: FORECAST Proyek-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Forecast Proyek
                                                                <i onclick="hideColumn(this, '#divForecastProyek')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                    onclick="showColumn(this, '#divForecastProyek')" id="show-button" class="bi bi-arrows-expand"></i>
                                                            </h3>
                                                            {{-- <script>
                                                                function hideColumn() {
                                                                    document.getElementById("divForecastProyek").style.display = "none";
                                                                    document.getElementById("hide-button").style.display = "none";
                                                                    document.getElementById("show-button").style.display = "";
                                                                }
    
                                                                function showColumn() {
                                                                    document.getElementById("divForecastProyek").style.display = "";
                                                                    document.getElementById("hide-button").style.display = "";
                                                                    document.getElementById("show-button").style.display = "none";
                                                                }
                                                            </script> --}}
                                                            <br>
                                                            <div id="divForecastProyek" style="display:none">
                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Nama Proyek</th>
                                                                            <th class="min-w-auto">Unit kerja</th>
                                                                            <th class="min-w-auto">Stage</th>
                                                                            <th class="min-w-auto text-center">Nilai ok</th>
                                                                            <th class="min-w-auto text-center">Bulan Forecast Perolehan</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">

                                                                        @if (isset($proyekberjalan))
                                                                            @foreach ($proyekberjalan as $proyekberforecast)
                                                                                @if ($proyekberforecast->stage < 7 || $proyekberforecast->stage == 9 )
                                                                                <tr>
                                                                                    <!--begin::Name-->
                                                                                    <td>
                                                                                        <a href="/proyek/view/{{ $proyekberforecast->kode_proyek }}"
                                                                                            class="text-gray-800 text-hover-primary mb-1 text-break">
                                                                                            {{ $proyekberforecast->nama_proyek }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name-->
                                                                                    <!--begin::Divisi-->
                                                                                    <td>
                                                                                        {{ $proyekberjalan0->UnitKerja->unit_kerja }}
                                                                                    </td>
                                                                                    <!--end::Divisi-->
                                                                                    <!--begin::Stage-->
                                                                                    <td class="">
                                                                                        @switch($proyekberforecast->stage)
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
                                                                                    </td>
                                                                                    <!--end::Stage-->
                                                                                    <!--begin::Nilai Forecast-->
                                                                                    <td class="text-end">
                                                                                        @isset($proyekberforecast->proyek->Forecasts)
                                                                                        @php
                                                                                            $nilai_forecast = (int) $proyekberforecast->proyek->Forecasts->sum(function ($f) {
                                                                                                if (!empty($f->month_forecast)) {
                                                                                                    return (int) $f->nilai_forecast;
                                                                                                }
                                                                                            });
                                                                                        @endphp
                                                                                            {{ number_format((int) $nilai_forecast, 0, '.', '.') }}
                                                                                        @endisset
                                                                                    </td>
                                                                                    <!--end::Nilai Forecast-->
                                                                                    <!--begin::Bulan Forecast-->
                                                                                    <td class="text-center">
                                                                                        @isset($proyekberforecast->proyek->Forecasts)
                                                                                        {{-- @dump($proyekberforecast->proyek->Forecasts->last()) --}}
                                                                                            @switch($proyekberforecast->proyek->Forecasts->sortByDesc('month_forecast')->last()->month_forecast ?? "-")
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
                                                                                                    -
                                                                                            @endswitch
                                                                                        @endisset
                                                                                    </td>
                                                                                    <!--end::Bulan Forecast-->
                                                                                </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::FORECAST Proyek-->

                                                        <br><br>

                                                        <!--begin::Masalah Hukum-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Masalah Hukum   
                                                                <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_input_masalah_hukum">+</a>
                                                                {{-- <i onclick="hideColumn(this, '#divMasalahHukum')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i>
                                                                <i onclick="showColumn(this, '#divMasalahHukum')" id="show-button" class="bi bi-arrows-expand"></i>                                          --}}
                                                            </h3>

                                                            <!--Begin::Row-->
                                                            <div id="divMasalahHukum">
                                                                <br>
                                                                <div id="table">
                                                                    <!--begin::Table-->
                                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                        <!--begin::Table head-->
                                                                        <thead>
                                                                            <!--begin::Table row-->
                                                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                                <th class="min-w-auto">Nama Proyek</th>
                                                                                <th class="min-w-auto">Bentuk Masalah Hukum</th>
                                                                                <th class="min-w-auto">Status</th>
                                                                            </tr>
                                                                            <!--end::Table row-->
                                                                        </thead>
                                                                        <!--end::Table head-->
                                                                        <!--begin::Table body-->
                                                                        {{-- @dump($customer->MasalahHukum) --}}
                                                                        <tbody class="fw-bold text-gray-600">                                                                            
                                                                            <!--begin::Nama Proyek-->
                                                                            @if (!empty($masalahHukum))
                                                                            @foreach ($customer->MasalahHukum as $mh)
                                                                            <tr>                                                                                    
                                                                                            {{-- @dump($mh) --}}
                                                                                            <td>
                                                                                                <a target="_blank" href="/proyek/view/{{ $mh->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                                    {{ $mh->Proyek->nama_proyek }}                                                                                                
                                                                                                </a>
                                                                                            </td>
                                                                                            <!--end::Name-->
                                                                                            <!--begin::Jenis Masalah Hukum-->
                                                                                            <td>
                                                                                            {{ $mh->bentuk_masalah }}
                                                                                            </td>
                                                                                            <!--end::Unit-->
                                                                                            <!--begin::Status-->
                                                                                            <td>
                                                                                                {{ $mh->status }}
                                                                                            </td>
                                                                                            <!--end::Status-->   
                                                                            </tr>
                                                                            @endforeach
                                                                            @else
                                                                            <tr>
                                                                                <td>
                                                                                    <p class="text-center">Belum ada data</p>
                                                                                </td>                                                                                
                                                                            </tr>
                                                                            @endif   
                                                                        </tbody>
                                                                        <!--end::Table body-->
                                                                    </table>
                                                                <!--end::Table-->
                                                                </div>
                                                            </div>
                                                            <!--End::Row-->

                                                            
                                                        </div>
                                                        <!--end::Masalah Hukum-->

                                                        <br>

                                                        {{-- <!--begin::Input Forecast Proyek-->
                                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Forecast Proyek
                                                            </h3>

                                                                <!--begin::Row-->
                                                                <div class="row fv-row">
                                                                    <!--begin::Col-->
                                                                    <div class="col-6">
                                                                        <!--begin::Input group Website-->
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                                <span>Nama Proyek</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" 
                                                                            name="nama-proyek" value="" placeholder="Nama Proyek" />
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
                                                                                <span>Stage</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" 
                                                                            name="stage-proyek" value="" placeholder="stage-proyek" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input group-->
                                                                    </div>
                                                                    <!--End begin::Col-->
                                                                </div>
                                                                <!--End begin::Row-->

                                                                <!--begin::Row-->
                                                                <div class="row fv-row">
                                                                    <!--begin::Col-->
                                                                    <div class="col-6">
                                                                        <!--begin::Input group Website-->
                                                                        <div class="fv-row mb-7">
                                                                            <!--begin::Label-->
                                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                                <span>Nilai Forecast</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" 
                                                                            name="nilai-forecast" value="" placeholder="Nilai Forecast" />
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
                                                                                <span>Unit Kerja</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" class="form-control form-control-solid" 
                                                                            name="unit-kerja" value="" placeholder="Unit Kerja" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input group-->
                                                                    </div>
                                                                    <!--End begin::Col-->
                                                                </div>
                                                                <!--End begin::Row-->
                                                            <!--end::Input Forecast Proyek--> --}}

                                                        <!--begin:: FORECAST Proyek-->
                                                    </div>
                                                    <!--end:::Tab pane History-->

                                                    <!--begin:::Tab pane Excellence-->
                                                    <div class="tab-pane fade" id="kt_user_view_excellence" role="tabpanel">
                                                        <div class="card-title m-0">
                                                            
                                                            <!--begin::CSI-->
                                                            <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                                                CSI
                                                                {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_input_csi">+</a> --}}
                                                            </h3>

                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Nama Proyek</th>
                                                                            <th class="min-w-auto">Tanggal</th>
                                                                            <th class="min-w-auto text-center">Score CSI</th>
                                                                            <th class="min-w-auto text-center">Score CLI</th>
                                                                            <th class="min-w-auto text-center">Score NPS</th>
                                                                            <th class="min-w-auto text-center">Progress</th>
                                                                            <th class="min-w-auto text-center">Status</th>
                                                                            {{-- <th class="min-w-auto">Action</th> --}}
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">                                                                            
                                                                        <!--begin::Nama Proyek-->
                                                                        @foreach ($customer->Csi as $item)
                                                                            @if ($item->status == "Done")
                                                                                <tr>                                                                                    
                                                                                    <td>
                                                                                        <a target="_blank" href="/proyek/view/{{ $item->Proyek->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                            {{ $item->Proyek->nama_proyek }}                                                                                                
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name-->
                                                                                    <!--begin::Tanggal CSI-->
                                                                                        <td>
                                                                                        {{  Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                                                    </td>
                                                                                    <!--end::Tanggal CSI-->
                                                                                    <!--begin::Score CSI-->
                                                                                    <td class="text-center">
                                                                                        {{ $item->score_csi }}
                                                                                    </td>
                                                                                    <!--end::Score CSI-->  
                                                                                    <!--begin::Score CSI-->
                                                                                    <td class="text-center">
                                                                                        {{ $item->score_cli }}
                                                                                    </td>
                                                                                    <!--end::Score CSI-->  
                                                                                    <!--begin::Score CSI-->
                                                                                    <td class="text-center">
                                                                                        {{ $item->score_nps }}
                                                                                    </td>
                                                                                    <!--end::Score CSI-->  
                                                                                    <!--begin::Progress-->
                                                                                    <td class="text-center">
                                                                                        {{ $item->progress }} %
                                                                                    </td>
                                                                                    <!--end::Progress-->  
                                                                                    <!--begin::Status-->
                                                                                    <td class="text-center">
                                                                                        <span class="px-4 fs-7 badge badge-light-success">
                                                                                            {{$item->status}}
                                                                                        </span>
                                                                                    </td>
                                                                                    <!--end::Status-->  
                                                                                    {{-- <td>
                                                                                        <a href="#" data-bs-target="#kt_modal_input_csi_{{ $item->kode_proyek }}" data-bs-toggle="modal" class="btn btn-sm btn-primary p-2 text-white">Edit</a>    
                                                                                    </td>  --}}
                                                                                </tr>
                                                                                @else
                                                                                {{-- <tr>
                                                                                    <td colspan="7" class="text-center bg-secondary">
                                                                                        <span class="px-4 fs-7 badge badge-danger">
                                                                                            Belum ada data !
                                                                                        </span>
                                                                                    </td>
                                                                                </tr> --}}
                                                                                @endif     
                                                                        @endforeach
                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                            <!--end::CSI-->

                                                            {{-- <br><br> --}}

                                                            <!--begin::CLI-->
                                                            {{-- <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                                                CLI
                                                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_input_cli">+</a>
                                                            </h3>
                                                            
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Tanggal</th>
                                                                        <th class="min-w-auto">Score</th>
                                                                        <th class="min-w-auto">Action</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">                                                                            
                                                                    <!--begin::Nama Proyek-->
                                                                    @if (!empty($cli))
                                                                    @foreach ($customer->Cli as $item)
                                                                    <tr>                                                                                    
                                                                        <td>
                                                                            <a target="_blank" href="/proyek/view/{{ $item->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                {{ $item->Proyek->nama_proyek }}                                                                                                
                                                                            </a>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                    <!--begin::Tanggal CLI-->
                                                                    <td>
                                                                        {{  Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Tanggal CLI-->
                                                                    <!--begin::Score CLI-->
                                                                    <td>
                                                                        {{ $item->score }}
                                                                    </td>
                                                                    <!--end::Score CLI-->  
                                                                    <td>
                                                                        <a href="#" data-bs-target="#kt_modal_input_cli_{{ $item->kode_proyek }}" data-bs-toggle="modal" class="btn btn-sm btn-primary p-2 text-white">Edit</a>       
                                                                    </td>  
                                                                    @endforeach
                                                                    </tr>
                                                                    @else
                                                                    <tr>
                                                                        <td>
                                                                            <p class="text-center">Belum ada data</p>
                                                                        </td>
                                                                    </tr>
                                                                    @endif                                                                                    
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table> --}}
                                                            <!--end::CLI-->

                                                            {{-- <br><br> --}}

                                                            <!--begin::NPS-->
                                                            {{-- <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                                                NPS
                                                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_input_nps">+</a>
                                                            </h3>

                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Tanggal</th>
                                                                        <th class="min-w-auto">Score</th>
                                                                        <th class="min-w-auto">Action</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">                                                                            
                                                                    <!--begin::Nama Proyek-->
                                                                    @if (!empty($nps))
                                                                    @foreach ($customer->Nps as $item)
                                                                    <tr>                                                                                    
                                                                        <td>
                                                                            <a target="_blank" href="/proyek/view/{{ $item->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                {{ $item->Proyek->nama_proyek }}                                                                                                
                                                                            </a>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                    <!--begin::Tanggal NPS-->
                                                                    <td>
                                                                        {{  Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Tanggal NPS-->
                                                                    <!--begin::Score NPS-->
                                                                    <td>
                                                                        {{ $item->score }}
                                                                    </td>
                                                                    <!--end::Score NPS-->  
                                                                    <td>
                                                                        <a href="#" data-bs-target="#kt_modal_input_nps_{{ $item->kode_proyek }}" data-bs-toggle="modal" class="btn btn-sm btn-primary p-2 text-white">Edit</a>       
                                                                    </td>  
                                                                    @endforeach
                                                                    </tr>
                                                                    @else
                                                                    <tr>
                                                                        <td>
                                                                            <p class="text-center">Belum ada data</p>
                                                                        </td>
                                                                    </tr>
                                                                    @endif                                                                                    
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table> --}}
                                                            <!--end::Table-->

                                                            <br><br>

                                                            <!--begin::Karya Inovasi-->
                                                            <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                                                Karya Inovasi
                                                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_input_karya_inovasi">+</a>
                                                            </h3>

                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Tanggal</th>
                                                                        <th class="min-w-auto">Nama Karya Inovasi</th>
                                                                        <th class="min-w-auto">Action</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">                                                                            
                                                                    <!--begin::Nama Proyek-->
                                                                    @if (!empty($inovasi))
                                                                    @foreach ($customer->KaryaInovasi as $item)
                                                                    <tr>                                                                                    
                                                                        <td>
                                                                            <a target="_blank" href="/proyek/view/{{ $item->kode_proyek }}" class="text-gray-800 text-hover-primary mb-1">
                                                                                {{ $item->Proyek->nama_proyek }}                                                                                                
                                                                            </a>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Tanggal Karya Inovasi-->
                                                                        <td>
                                                                            {{  Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                                        </td>
                                                                        <!--end::Tanggal Karya Inovasi-->
                                                                        <!--begin::Score Karya Inovasi-->
                                                                        <td>
                                                                            {{ $item->nama_inovasi }}
                                                                        </td>
                                                                        <!--end::Score Karya Inovasi-->
                                                                        <td>
                                                                            <a href="#" data-bs-target="#kt_modal_input_karya_inovasi_{{ $item->kode_proyek }}" data-bs-toggle="modal" class="btn btn-sm btn-primary p-2 text-white">Edit</a>        
                                                                        </td> 
                                                                    @endforeach
                                                                    </tr>
                                                                    @else
                                                                    <tr>
                                                                        <td>
                                                                            <p class="text-center">Belum ada data</p>
                                                                        </td>
                                                                    </tr>
                                                                    @endif                                                                                    
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                            <!--end::Karya Inovasi-->

                                                        </div>
                                                        <!--end::Karya Inovasi-->
                                                        <br>
                                                    </div>
                                                    <!--end:::Tab pane Excellence-->


                                                    <!--begin:::Tab pane Atachment & Notes-->
                                                    <div class="tab-pane fade" id="kt_user_view_Notes" role="tabpanel">
                                                        <!--begin::Attachment-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Attachments
                                                        </h3>

                                                        <div>
                                                            <label for="doc-attachment" class="form-label"></label>
                                                            <input onchange="this.form.submit()" class="form-control form-control-sm" id="doc-attachment" name="doc-attachment" type="file"
                                                                accept=".docx, .pdf">
                                                        </div>

                                                        <br>
                                                        <br>

                                                        <!--End::Attachment-->

                                                        <div class="ms-3">
                                                            <table class="table align-middle table-row-dashed fs-6" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                                                                        <th class="min-w-auto">Attachment Name</th>
                                                                        <th class="min-w-auto">Modified On</th>
                                                                        <th class="min-w-auto">Modified By</th>
                                                                        <th class="w-100px"></th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">
                                                                    @if (isset($attachment))
                                                                        @foreach ($attachment as $attachments)
                                                                            <tr>
                                                                                <!--begin::Name-->
                                                                                <td>
                                                                                    @if (str_contains("$attachments->name_attachment", '.docx'))
                                                                                        <a href="/document/view/{{ $attachments->id_customer }}/{{ $attachments->id_document }}"
                                                                                            class="text-hover-primary">{{ $attachments->name_attachment }}</a>
                                                                                    @else
                                                                                        <a target="_blank" href="{{ asset('words/' . $attachments->id_document . '.pdf') }}"
                                                                                            class="text-hover-primary">{{ $attachments->name_attachment }}</a>
                                                                                    @endif
                                                                                </td>
                                                                                <!--end::Name-->
                                                                                <!--begin::Time-->
                                                                                <td>
                                                                                    <a>{{ $attachments->created_at }}</a>
                                                                                </td>
                                                                                <!--end::Time-->
                                                                                <!--begin::Kode-->
                                                                                <td>
                                                                                    <a>{{ $attachments->created_by }}</a>
                                                                                </td>
                                                                                <!--end::Kode-->
                                                                                <!--begin::Action-->
                                                                                <td class="text-center">
                                                                                    <small>
                                                                                        <p data-bs-toggle="modal" data-bs-target="#kt_attachment_delete_{{ $attachments->id }}" id="modal-delete"
                                                                                            class="btn btn-sm btn-light btn-active-primary">
                                                                                            Delete
                                                                                        </p>
                                                                                    </small>
                                                                                </td>
                                                                                <!--end::Action-->
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif

                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                        </div>

                                                        <!--EDITED begin::Attachement Table-->
                                                        <div style="background-color: #FFFF;width:100%;padding:10px;margin-top:5px;">

                                                            <!--begin::Note-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                    Note
                                                                </h3>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <div class="form-group">
                                                                    <textarea class="form-control form-control-solid" name="note-attachment" style="min-height:200px;">{{ $customer->note_attachment }}</textarea>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input Note-->

                                                        </div>
                                                        <!--begin::Data CSI-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">CSI
                                                            <i onclick="hideColumn(this, '#divCSI')" id="hide-button" style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                onclick="showColumn(this, '#divCSI')" id="show-button" class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        {{-- <script>
                                                            function hideColumn() {
                                                                document.getElementById("divCSI").style.display = "none";
                                                                document.getElementById("hide-button").style.display = "none";
                                                                document.getElementById("show-button").style.display = "";
                                                            }

                                                            function showColumn() {
                                                                document.getElementById("divCSI").style.display = "";
                                                                document.getElementById("hide-button").style.display = "";
                                                                document.getElementById("show-button").style.display = "none";
                                                            }
                                                        </script> --}}
                                                        <br>
                                                        <div id="divCSI" style="display:none">
                                                            <!--end::Data CSI-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Customer Loyalty Rate</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="customer-loyalty-rate" class="form-control form-control-solid"
                                                                            value="{{ $customer->customer_loyalty_rate ?? 0 }}" placeholder="Customer Loyalty Rate" />
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
                                                                            <span>Net Promoter Score</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="net-promoter-score" class="form-control form-control-solid"
                                                                            value="{{ $customer->net_promoter_score ?? 0 }}" placeholder="Net Promoter Score" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Customer Satisfaction Index</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="customer-satisfaction-index" class="form-control form-control-solid"
                                                                            value="{{ $customer->customer_satisfaction_index ?? 0 }}" placeholder="Customer Satisfaction Index" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                        </div>
                                                    </div>
                                                    <!--end:::Tab pane Atachment & Notes-->

                                                    <!--begin:::Tab pane Over View-->
                                                    <div class="tab-pane fade show active" id="kt_user_view_overview" role="tabpanel">
                                                        <br>
                                                        <!--Begin::Title Biru Form: Nilai RKAP Review-->

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Overview Project &nbsp;
                                                            <i onclick="hideOverview()" id="hide-overview" class="bi bi-arrows-collapse"></i><i onclick="showOverview()" id="show-overview"
                                                                style="display: none" class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <script>
                                                            function hideOverview() {
                                                                document.getElementById("overViewProject").style.display = "none";
                                                                document.getElementById("hide-overview").style.display = "none";
                                                                document.getElementById("show-overview").style.display = "";
                                                            }

                                                            function showOverview() {
                                                                document.getElementById("overViewProject").style.display = "";
                                                                document.getElementById("hide-overview").style.display = "";
                                                                document.getElementById("show-overview").style.display = "none";
                                                            }
                                                        </script>

                                                        <div id="overViewProject">
                                                            <br>
                                                            {{-- <div class="row">
                                                                <div class="card text-white mb-3 me-3 text-center col" style="background-color: #008CB4">
                                                                    <span class="text-center pt-8" style="font-size: 1.2rem">Proyek Forecast</span>
                                                                    <hr>
                                                                    <p class="text-white py-4 fw-bolder" style="font-size: 1.5rem">{{ $nilaiForecast[0] }} / Rp.
                                                                        {{ number_format($nilaiForecast[1], 0, '.', '.') }}</p>
                                                                </div>
                                                                <div class="card text-white mb-3 me-3 text-center col" style="background-color: #008CB4">
                                                                    <span class="text-center pt-8" style="font-size: 1.2rem">Proyek Opportunity</span>
                                                                    <hr>
                                                                    <p class="text-white py-4 fw-bolder" style="font-size: 1.5rem">{{ $proyekOpportunity[0] }} / Rp.
                                                                        {{ number_format($proyekOpportunity[1], 0, '.', '.') }}</p>
                                                                </div>
                                                                <div class="card text-white mb-3 me-3 text-center col" style="background-color: #008CB4">
                                                                    <span class="text-center pt-8" style="font-size: 1.2rem">Proyek Closed</span>
                                                                    <hr>
                                                                    <p class="text-white py-4 fw-bolder" style="font-size: 1.5rem">{{ $proyekClosed[0] }} / Rp.
                                                                        {{ number_format($proyekClosed[1], 0, '.', '.') }}</p>
                                                                </div>
                                                                <div class="card text-white mb-3 me-3 text-center col" style="background-color: #008CB4">
                                                                    <span class="text-center pt-8" style="font-size: 1.2rem">Proyek Ongoing</span>
                                                                    <hr>
                                                                    <p class="text-white py-4 fw-bolder" style="font-size: 1.5rem">{{ $proyekOngoing[0] }} / Rp.
                                                                        {{ number_format($proyekOngoing[1], 0, '.', '.') }}</p>
                                                                </div>
                                                            </div> --}}
                                                            <!--begin::Card Status-->
                                                            <div class="row">
                                                                <!--begin::Card column-->
                                                                <div class="col-3">
                                                                    <!--begin::Card body-->
                                                                    <div class="card-body p-0">
                                                                        <!--begin::Card widget 20-->
                                                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #017EB8;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                                            <!--begin::Header-->
                                                                            <div class="card-header pt-2">
                                                                                <!--begin::Title-->
                                                                                <div class="card-title d-flex flex-column">
                                                                                    <!--begin::Amount-->
                                                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $nilaiForecast[0] }}</span>
                                                                                    <!--end::Amount-->
                                                                                    <!--begin::Subtitle-->
                                                                                    <span class="text-white pt-1 fs-12">Proyek Forecast</span>
                                                                                    <!--end::Subtitle-->
                                                                                </div>
                                                                                <!--end::Title-->
                                                                            </div>
                                                                            <!--end::Header-->
                                                                            <hr class="text-white">
                                                                            <!--begin::Card body-->
                                                                            <div class="card-body d-flex align-items-end pt-0">
                                                                                <!--begin::Progress-->
                                                                                <div class="text-start fs-1 text-white">
                                                                                    <span>{{ number_format($nilaiForecast[1], 0, '.', '.') }}</span>
                                                                                </div>
                                                                                <!--end::Progress-->
                                                                            </div>
                                                                            <!--end::Card body-->
                                                                        </div>
                                                                        <!--end::Card widget 20-->
                                                                    </div>
                                                                    <!--end::Card body-->
                                                                </div>
                                                                <!--end-begin::Card column-->
                                                                <div class="col-3">
                                                                    <!--begin::Card body-->
                                                                    <div class="card-body p-0">
                                                                        <!--begin::Card widget 20-->
                                                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #28B3AC;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                                            <!--begin::Header-->
                                                                            <div class="card-header pt-2">
                                                                                <!--begin::Title-->
                                                                                <div class="card-title d-flex flex-column">
                                                                                    <!--begin::Amount-->
                                                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $proyekClosed[0] }}</span>
                                                                                    <!--end::Amount-->
                                                                                    <!--begin::Subtitle-->
                                                                                    <span class="text-white pt-1 fs-12">Opportunity</span>
                                                                                    <!--end::Subtitle-->
                                                                                </div>
                                                                                <!--end::Title-->
                                                                            </div>
                                                                            <!--end::Header-->
                                                                            <hr class="text-white">
                                                                            <!--begin::Card body-->
                                                                            <div class="card-body d-flex align-items-end pt-0">
                                                                                <!--begin::Progress-->
                                                                                <div class="text-start fs-1 text-white">
                                                                                    <span>{{ number_format($proyekClosed[1], 0, '.', '.') }}</span>
                                                                                </div>
                                                                                <!--end::Progress-->
                                                                            </div>
                                                                            <!--end::Card body-->
                                                                        </div>
                                                                        <!--end::Card widget 20-->
                                                                    </div>
                                                                    <!--end::Card body-->
                                                                </div>
                                                                <!--end-begin::Card column-->
                                                                <div class="col-3">
                                                                    <!--begin::Card body-->
                                                                    <div class="card-body p-0">
                                                                        <!--begin::Card widget 20-->
                                                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #F7AD1A;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                                            <!--begin::Header-->
                                                                            <div class="card-header pt-2">
                                                                                <!--begin::Title-->
                                                                                <div class="card-title d-flex flex-column">
                                                                                    <!--begin::Amount-->
                                                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $proyekClosed[0] }}</span>
                                                                                    <!--end::Amount-->
                                                                                    <!--begin::Subtitle-->
                                                                                    <span class="text-white pt-1 fs-12">Proyek Closed</span>
                                                                                    <!--end::Subtitle-->
                                                                                </div>
                                                                                <!--end::Title-->
                                                                            </div>
                                                                            <!--end::Header-->
                                                                            <hr class="text-white">
                                                                            <!--begin::Card body-->
                                                                            <div class="card-body d-flex align-items-end pt-0">
                                                                                <!--begin::Progress-->
                                                                                <div class="text-start fs-1 text-white">
                                                                                    <span>{{ number_format($proyekClosed[1], 0, '.', '.') }}</span>
                                                                                </div>
                                                                                <!--end::Progress-->
                                                                            </div>
                                                                            <!--end::Card body-->
                                                                        </div>
                                                                        <!--end::Card widget 20-->
                                                                    </div>
                                                                    <!--end::Card body-->
                                                                </div>
                                                                <!--end-begin::Card column-->
                                                                <div class="col-3">
                                                                    <!--begin::Card body-->
                                                                    <div class="card-body p-0">
                                                                        <!--begin::Card widget 20-->
                                                                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-90 mb-5 mb-xl-10" style="background-color: #E86340;background-image:url('/media/patterns/vector-1.png');background-repeat: no-repeat;background-size: auto;">
                                                                            <!--begin::Header-->
                                                                            <div class="card-header pt-2">
                                                                                <!--begin::Title-->
                                                                                <div class="card-title d-flex flex-column">
                                                                                    <!--begin::Amount-->
                                                                                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $proyekOngoing[0] }}</span>
                                                                                    <!--end::Amount-->
                                                                                    <!--begin::Subtitle-->
                                                                                    <span class="text-white pt-1 fs-12">Proyek Ongoing</span>
                                                                                    <!--end::Subtitle-->
                                                                                </div>
                                                                                <!--end::Title-->
                                                                            </div>
                                                                            <!--end::Header-->
                                                                            <hr class="text-white">
                                                                            <!--begin::Card body-->
                                                                            <div class="card-body d-flex align-items-end pt-0">
                                                                                <!--begin::Progress-->
                                                                                <div class="text-start fs-1 text-white">
                                                                                    <span>{{ number_format($proyekOngoing[1], 0, '.', '.') }}</span>
                                                                                </div>
                                                                                <!--end::Progress-->
                                                                            </div>
                                                                            <!--end::Card body-->
                                                                        </div>
                                                                        <!--end::Card widget 20-->
                                                                    </div>
                                                                    <!--end::Card body-->
                                                                </div>
                                                                <!--end::Card column-->
                                                            </div>
                                                            <!--end::Card Status--> 
                                                        </div>
                                                        <!--overViewProject-->

                                                        <!--Begin::Title Biru Form: Pelanggan Performance-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Pelanggan Performance &nbsp;
                                                            <i onclick="hidePerformance()" id="hide-performance" class="bi bi-arrows-collapse"></i><i onclick="showPerformance()" id="show-performance"
                                                                style="display: none" class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <!--End::Title Biru Form: Pelanggan Performance-->
                                                        <script>
                                                            function hidePerformance() {
                                                                document.getElementById("pelangganPerformance").style.display = "none";
                                                                document.getElementById("hide-performance").style.display = "none";
                                                                document.getElementById("show-performance").style.display = "";
                                                            }

                                                            function showPerformance() {
                                                                document.getElementById("pelangganPerformance").style.display = "";
                                                                document.getElementById("hide-performance").style.display = "";
                                                                document.getElementById("show-performance").style.display = "none";
                                                            }
                                                        </script>
                                                        <div id="pelangganPerformance">
                                                            <figure class="highcharts-figure py-12">
                                                                <div class="py-6" id="nilai-ok">
                                                                    <!--begin::NILAI OK-->
                                                                    <!--end::NILAI OK-->
                                                                </div>
                                                                <div class="" id="datatable-nilai-ok" style="display: none;">
                                                                    <div class="text-center">
                                                                        <h2 id="title-table"></h2>
                                                                        <h4 id="total"></h4>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="button" class="btn btn-sm btn-light btn-active-primary fs-6 me-3" onclick="hideTable('#datatable-nilai-ok','#nilai-ok')"><i
                                                                                class="bi bi-bar-chart-fill fs-6"></i> Show
                                                                            Chart</button>
                                                                        <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i
                                                                                class="bi bi-download"></i> Export Excel</a>
                                                                        <button class="btn btn-sm btn-light btn-active-danger fs-6" onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                                                class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                                        {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                                                    </div>
                                                                    <br>
                                                                    <div class="" style="max-height: 500px; overflow-y:scroll">
                                                                        <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                                            <!--begin::Table head-->
                                                                            <thead id="table-line-head" class="bg-white" style="position: sticky; top: 0">
                                                                                {{-- THead Here --}}
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            <tbody class="fw-bold" id="table-line-body">
                                                                                {{-- Data Here --}}
                                                                            </tbody>
                                                                            <!--end::Table body-->
                                                                        </table>
                                                                    </div>
                                                                    <!--end::Table Proyek-->
                                                                </div>
                                                            </figure>
                                                            <hr>

                                                            
                                                            <figure class="highcharts-figure py-12">
                                                                <div class="py-6" id="piutang-pelanggan">
                                                                    <!--begin::PIUTANG PELANGGAN-->
                                                                    <!--end::PIUTANG PELANGGAN-->
                                                                </div>
                                                                <div class="" id="datatable-piutang-pelanggan" style="display: none;">
                                                                    <div class="text-center">
                                                                        <h2 id="title-table"></h2>
                                                                        <h4 id="total"></h4>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="button" class="btn btn-sm btn-light btn-active-primary fs-6 me-3" onclick="hideTable('#datatable-piutang-pelanggan','#piutang-pelanggan')"><i
                                                                                class="bi bi-bar-chart-fill fs-6"></i> Show
                                                                            Chart</button>
                                                                        <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i
                                                                                class="bi bi-download"></i> Export Excel</a>
                                                                        <button class="btn btn-sm btn-light btn-active-danger fs-6" onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                                                class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                                        {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                                                    </div>
                                                                    <br>
                                                                    <div class="" style="max-height: 500px; overflow-y:scroll">
                                                                        <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                                            <!--begin::Table head-->
                                                                            <thead id="table-line-head" class="bg-white" style="position: sticky; top: 0">
                                                                                {{-- THead Here --}}
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            <tbody class="fw-bold" id="table-line-body">
                                                                                {{-- Data Here --}}
                                                                            </tbody>
                                                                            <!--end::Table body-->
                                                                        </table>
                                                                    </div>
                                                                    <!--end::Table Proyek-->
                                                                </div>
                                                            </figure>
                                                            <hr>

                                                            <figure class="highcharts-figure py-12">
                                                                <div class="py-6" id="labarugi-pelanggan">
                                                                    <!--begin::LABARUGI-PELANGGAN-->
                                                                    <!--end::LABARUGI-PELANGGAN-->
                                                                </div>
                                                                <div class="" id="datatable-labarugi-pelanggan" style="display: none;">
                                                                    <div class="text-center">
                                                                        <h2 id="title-table"></h2>
                                                                        <h4 id="total"></h4>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="button" class="btn btn-sm btn-light btn-active-primary fs-6 me-3" onclick="hideTable('#datatable-labarugi-pelanggan','#labarugi-pelanggan')"><i
                                                                                class="bi bi-bar-chart-fill fs-6"></i> Show
                                                                            Chart</button>
                                                                        <a href="#" target="_blank" id="export-excel-btn" class="btn btn-sm btn-light btn-active-primary fs-6 me-3"><i
                                                                                class="bi bi-download"></i> Export Excel</a>
                                                                        <button class="btn btn-sm btn-light btn-active-danger fs-6" onclick="toggleFullscreen()" id="exit-fullscreen"><i
                                                                                class="bi bi-fullscreen-exit fs-6"></i> Exit Fullscreen</button>
                                                                        {{-- <button class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;"><i class="bi bi-graph-up-arrow text-white"></i></button> --}}
                                                                    </div>
                                                                    <br>
                                                                    <div class="" style="max-height: 500px; overflow-y:scroll">
                                                                        <table class="table align-middle table-row-dashed fs-6 gy-2">
                                                                            <!--begin::Table head-->
                                                                            <thead id="table-line-head" class="bg-white" style="position: sticky; top: 0">
                                                                                {{-- THead Here --}}
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            <tbody class="fw-bold" id="table-line-body">
                                                                                {{-- Data Here --}}
                                                                            </tbody>
                                                                            <!--end::Table body-->
                                                                        </table>
                                                                    </div>
                                                                    <!--end::Table Proyek-->
                                                                </div>
                                                            </figure>
                                                            <hr>
                                                        </div>
                                                        <!--pelangganPerformance-->

                                                        <!--Begin::Title Biru Form: Pelanggan Performance-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">Score CSI &nbsp;
                                                            <i onclick="hideCSI()" id="hide-csi" class="bi bi-arrows-collapse"></i><i onclick="showCSI()" id="show-csi" style="display: none"
                                                                class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <!--End::Title Biru Form: Pelanggan Performance-->
                                                        <script>
                                                            function hideCSI() {
                                                                document.getElementById("divCSI").style.display = "none";
                                                                document.getElementById("hide-csi").style.display = "none";
                                                                document.getElementById("show-csi").style.display = "";
                                                            }

                                                            function showCSI() {
                                                                document.getElementById("divCSI").style.display = "";
                                                                document.getElementById("hide-csi").style.display = "";
                                                                document.getElementById("show-csi").style.display = "none";
                                                            }
                                                        </script>

                                                        <div id="divCSI" class="row">
                                                            <div class="col-4">
                                                                <div id="scoreCLR">
                                                                    <figure class="highcharts-figure">
                                                                        {{-- <div id="container-speed" class="chart-container"></div> --}}
                                                                        <div id="score-clr" style="height: 300px" class="chart-container"></div>
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div id="scoreNPS">
                                                                    <figure class="highcharts-figure">
                                                                        {{-- <div id="container-speed" class="chart-container"></div> --}}
                                                                        <div id="score-nps" style="height: 300px" class="chart-container"></div>
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div id="scoreCSI">
                                                                    <figure class="highcharts-figure">
                                                                        {{-- <div id="container-speed" class="chart-container"></div> --}}
                                                                        <div id="score-csi" style="height: 300px" class="chart-container"></div>
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <br>
                                                        <div class="col">
                                                            <div id="map"></div>
                                                        </div> --}}
                                                    </div>
                                                    <!--end:::Tab pane Over View-->

                                                </div>
                                                <!--end:::Tab content-->
                    </form>
                </div>
                <!--end::Contacts-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Contacts App- Edit Contact-->
    </div>
    <!--end::Container-->
    </div>
    <!--end::Post-->
    </form>
    <!--end::Form-->
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

    <form action="/customer/save-modal" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Modal - Create App-->
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">



        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Proyek</h2>
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


                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">

                            {{-- @dd($proyekberjalan) --}}
                            {{-- @foreach ($proyekberjalan as $proyekberjalan) --}}

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span class="required">Name Proyek</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="nama-proyek" class="form-select form-select-solid" data-control="select2" data-hide-search="false" data-placeholder="Nama Proyek">
                                <option></option>
                                @foreach ($proyeks as $proyek)
                                    {{-- @if ($proyekberjalans->nama_proyek == $proyek->nama_proyek)
                                        <option value="{{ $proyek->nama_proyek }}" disabled>{{$proyek->nama_proyek }}</option>
                                    @else --}}
                                    <option value="{{ $proyek->nama_proyek }}">{{ $proyek->nama_proyek }}</option>
                                    {{-- @endif --}}
                                @endforeach

                            </select>
                            @error('nama-proyek')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror
                            <!--end::Input-->

                            {{-- @endforeach --}}

                        </div>
                        <!--end::Input group-->

                        <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>

    <!--begin::modal PIC-->
    <form action="/customer/pic" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_pic" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Contact / PIC : </h2>
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

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="name-pic" value="" placeholder="Nama" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span>Jabatan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="kode-pic" value="" placeholder="Jabatan" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span>Email</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="email-pic" value="" placeholder="Email" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span>Kontak Nomor</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="phone-number-pic" value="" placeholder="Kontak Nomor" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->
                        
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Tanggal Lahir</span>
                                    </label>
                                    <!--end::Label-->
                                    <a href="#" class="btn" style="background: transparent;" id="start-date-modal" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" class="form-control form-control-solid" name="ultah-pic" value="" placeholder="Tanggal Lahir" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->

                            <!--Begin::Col-->
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Layer Segmentasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="layer_segmentasi" id="layer_segmentasi" class="form-select form-select-solid pe-5" data-control="select2" data-hide-search="false"
                                    data-placeholder="Pilih Layer Segmentasi">
                                    <option value="" selected></option>
                                    <option value="Decision Maker"{{ $customer -> layer_segmentasi == "Decision Maker" ? "selected" : "" }}>Decision Maker</option>
                                    <option value="Influencer"{{ $customer -> layer_segmentasi == "Influencer" ? "selected" : "" }}>Influencer</option>
                                    <option value="Buyer"{{ $customer -> layer_segmentasi == "Buyer" ? "selected" : "" }}>Buyer</option>
                                    <option value="User"{{ $customer -> layer_segmentasi == "User" ? "selected" : "" }}>User</option>
                                    <option value="Gate Keeper"{{ $customer -> layer_segmentasi == "Gate Keeper" ? "selected" : "" }}>Gate Keeper</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--End::Col-->

                        </div>
                        <!--End begin::Row-->

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::modal PIC-->

    <!--begin::modal Edit PIC-->
    @foreach ($customer->pic as $pic)
        <form action="/customer/pic/{{ $pic->id }}/edit" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">

            <!--begin::Modal - Create Proyek-->
            <div class="modal fade" id="kt_modal_edit_pic_{{ $pic->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Edit Contact / PIC : </h2>
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

                                <!--begin::Row-->
                                <div class="row fv-row">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Nama</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" name="name-pic" value="{{ $pic->nama_pic }}" placeholder="Nama" />
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
                                                <span>Jabatan</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" name="kode-pic" value="{{ $pic->jabatan_pic }}" placeholder="Jabatan" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--End begin::Col-->
                                </div>
                                <!--End begin::Row-->

                                <!--begin::Row-->
                                <div class="row fv-row">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Email</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" name="email-pic" value="{{ $pic->email_pic }}" placeholder="Email" />
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
                                                <span>Kontak Nomor</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" name="phone-number-pic" value="{{ $pic->phone_pic }}" placeholder="Kontak Nomor" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--End begin::Col-->
                                </div>
                                <!--End begin::Row-->

                                <!--begin::Row-->
                                <div class="row fv-row">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Tanggal Lahir</span>
                                            </label>
                                            @php
                                                $tanggal_lahir_pic = Carbon\Carbon::create($pic->ultah_pic)->format("Y-m-d");
                                            @endphp
                                            <!--end::Label-->
                                            <a href="#" class="btn" style="background: transparent;" id="start-date-modal" onclick="showCalendarModal(this)">
                                                <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                            </a>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" class="form-control form-control-solid" name="ultah-pic" value="{{ $tanggal_lahir_pic }}" placeholder="Tanggal Lahir" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--End::Col-->

                                    <!--Begin::Col-->
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Layer Segmentasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="layer_segmentasi" id="layer_segmentasi_{{$pic->id}}" class="form-select form-select-solid pe-5" data-control="select2" data-hide-search="false"
                                        data-placeholder="Pilih Layer Segmentasi">
                                        <option value="" selected></option>
                                        <option value="Decision Maker"{{ $pic -> layer_segmentasi == "Decision Maker" ? "selected" : "" }}>Decision Maker</option>
                                        <option value="Influencer"{{ $pic -> layer_segmentasi == "Influencer" ? "selected" : "" }}>Influencer</option>
                                        <option value="Buyer"{{ $pic -> layer_segmentasi == "Buyer" ? "selected" : "" }}>Buyer</option>
                                        <option value="User"{{ $pic -> layer_segmentasi == "User" ? "selected" : "" }}>User</option>
                                        <option value="Gate Keeper"{{ $pic -> layer_segmentasi == "Gate Keeper" ? "selected" : "" }}>Gate Keeper</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--End begin::Row-->
                                
                            </div>
                            <div class="modal-footer">

                                <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" style="background-color:#008CB4">Save</button>

                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </div>
            <!--end::Modal - Create App-->
        </form>
    @endforeach
    <!--end::modal Edit PIC-->

<!--begin::DELETE PIC-->
@foreach ($customer->pic as $pic)
    <form action="/customer/pic/{{ $pic->id }}/delete" method="post" enctype="multipart/form-data">
        @method('delete')
        @csrf
        <div class="modal fade" id="kt_pic_delete_{{ $pic->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Hapus : {{ $pic->nama_pic }}
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
<!--end::DELETE PIC-->

<!--Begin::Input Modal Masalah Hukum-->
<form action="/customer/masalah-hukum/save" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
    <div class="modal fade" id="kt_modal_input_masalah_hukum" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Masalah Hukum
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
                <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                    <!--Begin:Nama Proyek-->
                    <div class="row fv-row">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Nama Proyek</span>
                        </label>
                        <!--Begin::Select-->
                        <div id="div-namaProyek">
                            <select name="kode-proyek-hukum" id="new-proyek" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                data-placeholder="Pilih Nama Proyek">
                                <option value=""></option>
                                @foreach ($proyekberjalan as $pb)
                                @if (!empty($pb->id_customer))
                                <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>
                                @else
                                <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>
                                @endif                                                                          
                                @endforeach                                                                           
                            </select>
                        </div>
                    </div>
                    <!--End:Nama Proyek-->

                    <!--Begin:Jenis Masalah Hukum-->
                    <div class="row fv-row my-3">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Bentuk Masalah Hukum</span>
                        </label>
                        <!--Begin::Select-->
                        <div class="">
                            <input type="text" name="bentuk_masalah_hukum" class="form-control form-control-solid"
                                placeholder="Bentuk Masalah Hukum" />                                                                        
                        </div>
                        <!--End::Text-->
                    </div>
                    <!--End:Jenis Masalah Hukum-->

                    <!--Begin:Status-->
                    <div class="row fv-row my-3">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Status</span>
                        </label>
                        <!--Begin::Select-->
                        <div id="div-status">
                            <select name="status_hukum" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                data-placeholder="Pilih status">
                                <option value=""></option>                                                                            
                                <option value="WIKA Menang">WIKA Menang</option>                                                                          
                                <option value="WIKA Kalah">WIKA Kalah</option>                                                                          
                            </select>
                        </div>
                    </div>
                    <!--Begin:Status-->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary">Save</button>
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

    <!--begin::modal Struktur Organisasi-->
    <form action="/customer/struktur" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_struktur" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Input Struktur Organisasi : </h2>
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


                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="name-struktur" value="" placeholder="Nama" />
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
                                        <span class="required">Jabatan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="jabatan-struktur" value="" placeholder="Jabatan" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Email</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="email-struktur" value="" placeholder="Email" />
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
                                        <span>Kontak Nomor</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="phone-struktur" value="" placeholder="Kontak Nomor" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Tanggal Lahir</span>
                                    </label>
                                    <!--end::Label-->
                                    <a href="#" class="btn" style="background: transparent;" id="start-date-modal" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" class="form-control form-control-solid" name="ultah-struktur" value="" placeholder="Tanggal Lahir" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End begin::Row-->

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                        <span>Proyek Tekait</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="proyek-struktur" name="proyek-struktur" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                        data-placeholder="Proyek Terkait">
                                        <option></option>
                                        @foreach ($proyeks as $pBerjalan)
                                            <option value="{{ $pBerjalan->kode_proyek }}">
                                                {{ $pBerjalan->nama_proyek }}
                                            </option>
                                        @endforeach
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
                                        <span>Role</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <!--Begin::Input-->
                                    <select id="role-struktur" name="role-struktur" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Role">
                                        <option></option>
                                        <option value="Decision Maker">Decision Maker</option>
                                        <option value="Influencer">Influencer</option>
                                        <option value="Gatekeeper">Gatekeeper</option>
                                        <option value="Buyer">Buyer</option>
                                        <option value="User">User</option>
                                    </select>
                                    <!--end::Input-->
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    <!--end::modal Struktur Organisasi-->

    <!--begin::modal EDIT Struktur Organisasi-->
    @if (!empty($strukturs))
    @foreach ($strukturs as $struktur)
        <form action="/customer/struktur/{{ $struktur->id }}/edit" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer">

            <!--begin::Modal - Create Proyek-->
            <div class="modal fade" id="kt_modal_edit_struktur_{{ $struktur->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Input Struktur Organisasi : </h2>
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


                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nama</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="name-struktur" value="{{ $struktur->nama_struktur }}" placeholder="Nama" />
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
                                            <span class="required">Jabatan</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="jabatan-struktur" value="{{ $struktur->jabatan_struktur }}" placeholder="Jabatan" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Email</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="email-struktur" value="{{ $struktur->email_struktur }}" placeholder="Email" />
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
                                            <span>Kontak Nomor</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="phone-struktur" value="{{ $struktur->phone_struktur }}" placeholder="Kontak Nomor" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Tanggal Lahir</span>
                                        </label>
                                        <!--end::Label-->
                                        <a href="#" class="btn" style="background: transparent;" id="start-date-modal" onclick="showCalendarModal(this)">
                                            <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                        </a>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" class="form-control form-control-solid" name="ultah-struktur" value="{{ $struktur->ultah_struktur }}"
                                            placeholder="Tanggal Lahir" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End begin::Row-->

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Proyek Tekait</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="proyek-struktur" name="proyek-struktur" class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                                            data-placeholder="Proyek Terkait">
                                            <option></option>
                                            @foreach ($proyeks as $pBerjalan)
                                                @if ($pBerjalan->kode_proyek == $struktur->proyek_struktur)
                                                    <option value="{{ $pBerjalan->kode_proyek }}" selected>
                                                        {{ $pBerjalan->nama_proyek }}
                                                    </option>
                                                @else
                                                    <option value="{{ $pBerjalan->kode_proyek }}">
                                                        {{ $pBerjalan->nama_proyek }}
                                                    </option>
                                                @endif
                                            @endforeach
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
                                            <span>Role</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <!--Begin::Input-->
                                        <select id="role-struktur" name="role-struktur" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilih Role">
                                            <option></option>
                                            <option value="Decision Maker" {{ $struktur->role_struktur == 'Decision Maker' ? 'selected' : '' }}>
                                                Decision Maker</option>
                                            <option value="Influencer" {{ $struktur->role_struktur == 'Influencer' ? 'selected' : '' }}>
                                                Influencer</option>
                                            <option value="Gatekeeper" {{ $struktur->role_struktur == 'Gatekeeper' ? 'selected' : '' }}>
                                                Gatekeeper</option>
                                            <option value="Buyer" {{ $struktur->role_struktur == 'Buyer' ? 'selected' : '' }}>
                                                Buyer</option>
                                            <option value="User" {{ $struktur->role_struktur == 'User' ? 'selected' : '' }}>
                                                User</option>
                                        </select>
                                        <!--end::Input-->
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" style="background-color:#008CB4">Save</button>

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
    @endif
    <!--end::modal EDIT Struktur Organisasi-->

    <!--begin::DELETE STRUKTUR-->
    {{-- @foreach ($strukturs as $struktur)
        <form action="/customer/struktur/{{ $struktur->id }}/delete" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_struktur_delete_{{ $struktur->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $struktur->nama_struktur }}
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
    @endforeach --}}
    <!--end::DELETE STRUKTUR-->

    <!--begin::DELETE ATTACHMENT-->
    @foreach ($attachment as $attachments)
        <form action="/customer/attachment/{{ $attachments->id }}/delete" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_attachment_delete_{{ $attachments->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $attachments->name_attachment }}</h2>
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
    <!--end::DELETE ATTACHMENT-->

        <!--begin::modal Detail Proyek-->
    @foreach ($proyekberjalan as $proyek)
    <div class="modal fade" id="proyek_berjalan_{{ $proyek->kode_proyek }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>{{ $proyek->nama_proyek }}
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
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Durasi Proyek: </span>
                                </div>
                                @php
                                    $tglakhir = new DateTime($proyek->proyek->tanggal_akhir_terkontrak ?? date('now'));
                                    $tglawal = new DateTime($proyek->proyek->tanggal_mulai_terkontrak ?? date('now'));
                                    $durasi = $tglakhir->diff($tglawal);
                                @endphp
                                <div class="col text-dark text-start">
                                    <b>
                                    {{ $durasi->y }} Tahun,
                                    {{ $durasi->m }} Bulan
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Unit Kerja: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyekberjalan0->UnitKerja->unit_kerja ?? '-' }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Tanggal Mulai Kontrak: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->proyek->tanggal_mulai_terkontrak ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Tanggal Berakhir Kontrak: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->proyek->tanggal_mulai_terkontrak ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Lokasi: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->proyek->lokasi_tender ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Nama MP: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->customer->name_pic ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">History Adendum: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->proyek->lokasi_tender ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Lsp: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->customer->name_pic ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Masalah Potensial: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->proyek->lokasi_tender ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Resume Resiko: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    <b>{{ $proyek->customer->name_pic ?? "-" }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row fv-row my-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Curve RA: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    {{-- <b>{{ $proyek->proyek->lokasi_tender ?? "-" }}</b> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="col text-end me-5">
                                    <span class="">Curve RI: </span>
                                </div>
                                <div class="col text-dark text-start">
                                    {{-- <b>{{ $proyek->customer->name_pic ?? "-" }}</b> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Modal body-->

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    @endforeach
    <!--end::modal Detail Proyek-->

    <!--end::Modals-->

<!--Begin::Modal-->
<!--Begin:: Modal Insert CSI-->
<div class="pop-up csi">
        <div class="modal fade" id="kt_modal_input_csi" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add CSI</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <form action="/customer/csi/save" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
                            <div class="row fv-row">
                                <div class="input_csi">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Nama Proyek</span>
                                    </label>
                                    <!--Begin::Select-->
                                    @php
                                        $csi_not_proyek = $csi->mergeRecursive($proyekberjalan)->unique("kode_proyek")->filter(function($item){
                                            return $item instanceof App\Models\ProyekBerjalans;
                                        });
                                    @endphp
                                        {{-- @dd($csi_not_proyek) --}}
                                    <div id="div-namaProyek">
                                        <select name="kode-proyek-csi" id="namaProyekCSI" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                            data-placeholder="Pilih Nama Proyek" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            @foreach ($csi_not_proyek as $pb)
                                            <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>          
                                            @endforeach                                                                           
                                        </select>
                                    </div>
                                    
                                    {{-- @dd($csi); --}}

                                    <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                        <span class="">Tanggal</span>
                                        <a href="#" class="btn" style="background: transparent;" id="date_csi" onclick="showCalendarModal(this)">
                                            <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                        </a>
                                    </label>
                                    <!--Begin::Select-->
                                    <input type="date" name="csi_date" class="form-control form-control-solid" placeholder="Tanggal" />
                                    
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Score</span>
                                    </label>
                                    <!--Begin::Select-->
                                    <input type="text" name="score_csi" id="score-csi" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-sm btn-primary">Save</button>
                            </div>
                            <!--end::Input group-->
                        </form>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
</div>

<!--Begin::Update Modal CSI-->
<div class="pop-up csi-update">
    {{-- @dd($item) --}}
    @foreach ($csi as $item)
    <form action="/customer/csi/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_csi_{{ $item->kode_proyek }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit CSI</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_csi">
                                @php
                                    $nama_proyek = collect($proyekberjalan)->where("kode_proyek", "=", $item->kode_proyek)->first();
                                @endphp

                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                <!--Begin::Select-->
                                <div id="div-namaProyek">
                                    <label class="fw-bold fs-6">{{ $item->Proyek->nama_proyek }}</label>
                                    <input type="hidden" class="form-control form-control-solid" name="kode-proyek-csi" value="{{ $item->kode_proyek }}" readonly>
                                </div>

                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_csi" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="csi_date" class="form-control form-control-solid" placeholder="Tanggal" value="{{ $item->tanggal }}"/>
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Score</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="score_csi" id="score-csi" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100" value="{{ $item->score }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End::Update Modal CSI-->

<!--Begin:: Modal CLI-->
<div class="pop-up cli">
    <form action="/customer/cli/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_cli" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add CLI</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_cli">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                @php
                                    $cli_not_proyek = $cli->mergeRecursive($proyekberjalan)->unique("kode_proyek")->filter(function($item){
                                        return $item instanceof App\Models\ProyekBerjalans;
                                    });
                                 @endphp
                                    {{-- @dd($csi_not_proyek) --}}
                                <div id="div-namaProyek">
                                    <select name="kode-proyek-cli" id="namaProyekCLI" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                        data-placeholder="Pilih Nama Proyek" tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        @foreach ($cli_not_proyek as $pb)
                                        <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>          
                                        @endforeach                                                                           
                                    </select>    
                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_csi" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="cli_date" class="form-control form-control-solid" placeholder="Tanggal" />
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Score</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="score_cli" id="score-cli" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End:: Modal CLI-->

<!--Begin::Update Modal CSI-->
<div class="pop-up cli-update">
    {{-- @dd($item) --}}
    @foreach ($cli as $item)
    <form action="/customer/cli/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_cli_{{ $item->kode_proyek }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit CLI</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_cli">
                                @php
                                    $nama_proyek = collect($proyekberjalan)->where("kode_proyek", "=", $item->kode_proyek)->first();
                                @endphp

                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                <!--Begin::Select-->
                                <div id="div-namaProyek">
                                    <label class="fw-bold fs-6">{{ $nama_proyek->nama_proyek }}</label>
                                    <input type="hidden" class="form-control form-control-solid" name="kode-proyek-cli" value="{{ $item->kode_proyek }}" readonly>
                                </div>

                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_cli" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="cli_date" class="form-control form-control-solid" placeholder="Tanggal" value="{{ $item->tanggal }}"/>
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Score</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="score_cli" id="score-cli" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100" value="{{ $item->score }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End::Update Modal CLI-->

<!--Begin:: Modal NPS-->
<div class="pop-up nps">
    <form action="/customer/nps/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_nps" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add NPS</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_nps">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                <!--Begin::Select-->
                                @php
                                    $nps_not_proyek = $nps->mergeRecursive($proyekberjalan)->unique("kode_proyek")->filter(function($item){
                                        return $item instanceof App\Models\ProyekBerjalans;
                                    });
                                 @endphp
                                    {{-- @dd($nps_not_proyek) --}}
                                <div id="div-namaProyek">
                                    <select name="kode-proyek-nps" id="namaProyekNPS" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                        data-placeholder="Pilih Nama Proyek" tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        @foreach ($nps_not_proyek as $pb)
                                        <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>          
                                        @endforeach                                                                           
                                    </select>
    
                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_nps" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="nps_date" class="form-control form-control-solid" placeholder="Tanggal" />
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Score</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="score_nps" id="score_nps" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End:: Modal CLI-->
<!--Begin:: Modal NPS-->

<!--Begin::Update Modal NPS-->
<div class="pop-up nps-update">
    {{-- @dd($item) --}}
    @foreach ($nps as $item)
    <form action="/customer/nps/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_nps_{{ $item->kode_proyek }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit NPS</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_nps">
                                @php
                                    $nama_proyek = collect($proyekberjalan)->where("kode_proyek", "=", $item->kode_proyek)->first();
                                @endphp

                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                <!--Begin::Select-->
                                <div id="div-namaProyek">
                                    <label class="fw-bold fs-6">{{ $nama_proyek->nama_proyek }}</label>
                                    <input type="hidden" class="form-control form-control-solid" name="kode-proyek-nps" value="{{ $item->kode_proyek }}" readonly>
                                </div>

                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_nps" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="nps_date" class="form-control form-control-solid" placeholder="Tanggal" value="{{ $item->tanggal }}"/>
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Score</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="score_nps" id="score-nps" placeholder="Range 1 - 100" pattern="^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$" class="form-control form-control-solid" min="0" max="100" value="{{ $item->score }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End::Update Modal NPS-->

<!--End:: Modal Karya Inovasi-->
<div class="pop-up karya-inovasi">
    <form action="/customer/karya-inovasi/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_karya_inovasi" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Karya Inovasi</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_karya_inovasi">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Proyek</span>
                                </label>
                                <!--Begin::Select-->
                                @php
                                    $inovasi_not_proyek = $inovasi->mergeRecursive($proyekberjalan)->unique("kode_proyek")->filter(function($item){
                                        return $item instanceof App\Models\ProyekBerjalans;
                                    });
                                 @endphp
                                    {{-- @dd($inovasi_not_proyek) --}}
                                <div id="div-namaProyek">
                                    <select name="kode-proyek-inovasi" id="namaProyekKaryaInovasi" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                        data-placeholder="Pilih Nama Proyek" tabindex="-1" aria-hidden="true">
                                        <option value=""></option>
                                        @foreach ($inovasi_not_proyek as $pb)
                                        <option value="{{ $pb->kode_proyek }}">{{ $pb->nama_proyek }}</option>          
                                        @endforeach                                                                           
                                    </select>
    
                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_karya_inovasi" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="inovasi_date" class="form-control form-control-solid" placeholder="Tanggal" />
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Karya Inovasi</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="nama_inovasi" id="score-inovasi" placeholder="Nama Karya Inovasi" class="form-control form-control-solid">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End:: Modal Karya Inovasi-->


<!--End:: Modal Update Karya Inovasi-->
<div class="pop-up karya-inovasi">
    @foreach ($inovasi as $item)
    <form action="/customer/karya-inovasi/save" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}">
        <div class="modal fade" id="kt_modal_input_karya_inovasi_{{ $item->kode_proyek }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-500px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Karya Inovasi</h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
                        <!--Begin:Nama Proyek-->
                        <div class="row fv-row">
                            <div class="input_karya_inovasi">
                                @php
                                $nama_proyek = collect($proyekberjalan)->where("kode_proyek", "=", $item->kode_proyek)->first();
                                @endphp

                            <label class="fs-6 fw-bold form-label mt-3">
                                <span class="">Nama Proyek</span>
                            </label>
                            <!--Begin::Select-->
                            <div id="div-namaProyek">
                                <label class="fw-bold fs-6">{{ $nama_proyek->nama_proyek }}</label>
                                <input type="hidden" class="form-control form-control-solid" name="kode-proyek-inovasi" value="{{ $item->kode_proyek }}" readonly>
                            </div>
    
                                <label class="fs-6 fw-b                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     old form-label mt-3">
                                    <span class="">Tanggal</span>
                                    <a href="#" class="btn" style="background: transparent;" id="date_karya_inovasi" onclick="showCalendarModal(this)">
                                        <i class="bi bi-calendar2-plus-fill" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--Begin::Select-->
                                <input type="date" name="inovasi_date" class="form-control form-control-solid" placeholder="Tanggal" value="{{ $item->tanggal }}"/>
                                
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Nama Karya Inovasi</span>
                                </label>
                                <!--Begin::Select-->
                                <input type="text" name="nama_inovasi" id="score-inovasi" placeholder="Nama Karya Inovasi" class="form-control form-control-solid" value="{{ $item->nama_inovasi }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
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
</div>
<!--End:: Modal Karya Inovasi-->
<!--End::Modal-->

@php
    $nilai_cli = 0;
    $nilai_csi = 0;
    $nilai_nps = 0;
    $countItem = $customer->Csi->where("status", "=", "Done")->count();
    if ($countItem != 0) {
        foreach ($customer->Csi as $item) {
            if($item->status == "Done"){
                $nilai_cli += $item->score_cli;
                $nilai_csi += $item->score_csi;
                $nilai_nps += $item->score_nps;
            }
        }
        $nilai_cli = (int) $nilai_cli / $countItem;
        $nilai_csi = (int) $nilai_csi / $countItem;
        $nilai_nps = (int) $nilai_nps / $countItem;
    }
    // dump($nilai_cli, $nilai_csi, $nilai_nps, $countItem )
@endphp


@endsection


@section('js-script')

    <!--begin::CDN High Chart-->
    <script src="/js/highcharts/highcharts.js"></script>
    {{-- <script src="/js/highcharts/series-label.js"></script> --}}
    {{-- <script src="/js/highcharts/exporting.js"></script> --}}
    {{-- <script src="/js/highcharts/export-data.js"></script> --}}
    {{-- <script src="/js/highcharts/drilldown.js"></script> --}}
    {{-- <script src="/js/highcharts/funnel.js"></script> --}}
    {{-- <script src="/js/highcharts/accessibility.js"></script> --}}
    <script src="/js/highcharts/highcharts-3d.js"></script>
    <script src="/js/highcharts/highcharts-more.js"></script>
    <script src="/js/highcharts/solid-gauge.js"></script>
    <!--end::CDN High Chart-->

    <script>
        Highcharts.setOptions({
            chart: {
                style: {
                    fontFamily: 'Poppins'
                }
            },
            colors: ["#017EB8", "#28B3AC", "#F7AD1A", "#9FE7F5", "#E86340", "#063F5C"],
        });
    </script>

    <!--begin::Performance Pelanggan-->
    <script>
        let namaUnit = {!! json_encode($namaUnit) !!};
        let namaProyek = {!! json_encode($namaProyek) !!};
        let nilaiOK = {!! json_encode($nilaiOK) !!};
        // if (namaProyek.length == 0) {
        //     namaProyek = ["..."];
        //     nilaiOK = [0];
        // }
        // console.log(nilaiOK);
        // console.log(namaProyek.length);

        Highcharts.chart('nilai-ok', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 50,
                }
            },
            title: {
                align: 'center',
                text: '<b class="h3">Nilai OK</b>'
            },
            subtitle: {
                align: 'center',
                text: ' '
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            // xAxis: {
            //     type: 'category'
            // },
            // xAxis: {
            //     categories: namaProyek,
            //     labels: {
            //         skew3d: true,
            //         style: {
            //             fontSize: '16px'
            //         }
            //     }
            // },
            // yAxis: {
            //     title: {
            //         text: ''
            //     }

            // },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                // format : '<b>{point.key} : {point.y}</b><br>',
                itemStyle: {
                    fontSize: '15px',
                    // color: '#A0A0A0'
                },
                itemMarginTop: 10,
                itemMarginBottom: 10,
                x: -120,
            },
            // colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD", "#083AA9", "#CD104D", "#1C6758"],
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    allowPointSelect: false,
                    cursor: 'pointer',
                },
                series: {
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true,
                    states: {
                        inactive: {
                            opacity: 1
                        },
                        hover: {
                            enabled: false
                        },
                    },
                },

            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                // headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b><br/>'
            },

            // series: [{
            //     name: "Pelanggan Proyek",
            //     colorByPoint: true,
            //     data: [{
            //             name: "Proyek Forecast",
            //             y: 3,
            //         },
            //         {
            //             name: "Proyek OnGoing",
            //             y: 4,
            //         },
            //         {
            //             name: "Proyek Closed",
            //             y: 2,
            //         }
            //     ]
            // }],
            credits: {
                enabled: false
            },
            series: [{
                name: 'Nilai OK',
                colorByPoint: true,
                data: nilaiOK,
                // stack: 'male'
            }]
        });
    </script>
    <!--end::Performance Pelanggan-->

    <!--begin::Piutang Pelanggan-->
    @php
        $nilaiPiutang = (int) str_replace(',', '', $customer->piutang);
    @endphp
    <script>
        let nilaiPiutang = {!! json_encode($piutangProyek) !!};
        Highcharts.chart('piutang-pelanggan', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 50,
                }
            },
            title: {
                align: 'center',
                text: '<b class="h3">Piutang</b>'
            },
            subtitle: {
                align: 'center',
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            // xAxis: {
            //     type: 'category'
            // },
            // xAxis: {
            //     categories: namaUnit,
            // },
            // yAxis: {
            //     title: {
            //         text: ''
            //     }

            // },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                // format : '<b>{point.key} : {point.y}</b><br>',
                itemStyle: {
                    fontSize: '15px',
                    // color: '#A0A0A0'
                },
                itemMarginTop: 10,
                itemMarginBottom: 10,
                x: -150,
            },
            // colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD", "#083AA9", "#CD104D", "#1C6758"],
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: true,
                },
                series: {
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true,
                    states: {
                        inactive: {
                            opacity: 1
                        },
                        hover: {
                            enabled: false
                        },
                    },
                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b><br/>'
            },

            credits: {
                enabled: false
            },
            series: [{
                name: "Piutang",
                colorByPoint: true,
                data: nilaiPiutang
            }],
        });
    </script>
    <!--end::Piutang Pelanggan-->

    <!--begin::Laba Rugi Pelanggan-->
    <script>
        let labaProyek = {!! json_encode($labaProyek) !!};
        let rugiProyek = {!! json_encode($rugiProyek) !!};
        Highcharts.chart('labarugi-pelanggan', {
            chart: {
                type: 'column'
            },
            title: {
                text: '<b class="h3">Laba / Rugi</b>',
                align: 'center'
            },
            xAxis: {
                categories: namaUnit,
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            // colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            credits: {
                enabled: false
            },
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                // format : '<b>{point.key} : {point.y}</b><br>',
                itemStyle: {
                    fontSize: '15px',
                    // color: '#A0A0A0'
                },
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    },
                    innerSize: 75,
                    depth: 25,
                    cursor: 'pointer',
                },
                series: {
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true,
                    states: {
                        inactive: {
                            opacity: 1
                        },
                        hover: {
                            enabled: false
                        },
                    },
                },
            },
            series: [{
                name: 'Laba',
                data: labaProyek
            }, {
                name: 'Rugi',
                data: rugiProyek
            }]
        });
    </script>
    {{-- @php
        $nilaiLaba = (int) str_replace(',', '', $customer->laba);
        $nilaiRugi = (int) str_replace(',', '', $customer->rugi);
    @endphp
    <script>
        let nilaiLaba = {!! $nilaiLaba !!};
        let nilaiRugi = {!! $nilaiRugi !!};
        // console.log(typeof(nilaiLaba), nilaiLaba);
        Highcharts.chart('labarugi-pelanggan', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                align: 'center',
                text: '<b class="h3">Laba / Rugi</b>'
            },
            subtitle: {
                align: 'center',
                text: ' '
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            xAxis: {
                // categories: namaLabaRugi,
                labels: {
                    skew3d: true,
                    style: {
                        fontSize: '16px'
                    }
                }
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            colors: ["#46AAF5", "#61CB65", "#F7C13E", "#ED6D3F", "#9575CD"],
            plotOptions: {
                // series: {
                //     dataLabels: {
                //         enabled: true
                //     },
                //     showInLegend: true
                // },
                pie: {
                    innerSize: 75,
                    depth: 25,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        format: '{point.y}',
                    },
                    showInLegend: true
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b><br/>'
            },
            series: [{
                name: "Laba / Rugi",
                colorByPoint: true,
                data: [{
                        name: "Laba : " + "{{ number_format($nilaiLaba, 0, '.', '.') }}",
                        y: nilaiLaba,
                    },
                    {
                        name: "Rugi : " + "{{ number_format($nilaiRugi, 0, '.', '.') }}",
                        y: nilaiRugi,
                    }
                ]
            }],
            credits: {
                enabled: false
            },
            // series: [{
            //     name: 'Laba / Rugi',
            //     data: nilaiLabaRugi,
            //     // stack: 'male'
            // }]
        });
    </script> --}}
    <!--end::Laba Rugi Pelanggan-->

    <!--begin::Score Customer Loyalty Rate-->
    
    <script>
        //let nilaiClr = Number("{{ $customer->customer_loyalty_rate == 0 || $customer->customer_loyalty_rate == null ? 1 : $customer->customer_loyalty_rate }}");
        let nilaiClr = Number("{{ $nilai_cli }}");
        let bgColorClr = "";
        // nilaiClr >= 1 ? '#a9b8eb' : nilaiClr >= 1.8 ? '#8092cf' : nilaiClr >= 2.6 ? "#8092cf" : nilaiClr >= 3.4 ? "#2f448a" : nilaiClr >= 4.2 ? "#152866" : "" 
        if (nilaiClr >= 1 && nilaiClr < 1.8) {
            bgColorClr = "#1DB6FD";
        } else if (nilaiClr >= 1.8 && nilaiClr < 2.6) {
            bgColorClr = "#1DB6FD";
        } else if (nilaiClr >= 2.6 && nilaiClr < 3.4) {
            bgColorClr = "#019AE1";
        } else if (nilaiClr >= 3.4 && nilaiClr < 4.2) {
            bgColorClr = "#0073A9";
        } else if (nilaiClr >= 4.2 && nilaiClr <= 5) {
            bgColorClr = "#004D70";
        } else {
            bgColorClr = "#8A0000";
        }
        Highcharts.chart('score-clr', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: '<b class="h3">Customer Loyalty Rate</b>'
            },

            pane: {
                center: ['50%', '70%'],
                size: '100%',
                startAngle: -100,
                endAngle: 100,
                background: [{
                    backgroundColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, '#ffffff00'],
                            [1, '#ffffff00']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '10%'
                }]
            },

            // the value axis
            yAxis: {
                min: 1,
                max: 5,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 1,
                // minorTickPosition: 'inside',
                // minorTickColor: '#ffffff00',

                // tickPixelInterval: 5,
                tickPositions: [1, 1.8, 2.6, 3.4, 4.2, 5],
                tickWidth: 0,
                tickPosition: 'inside',
                // tickLength: 5,
                // tickColor: '#666',
                labels: {
                    distance: -35,
                    step: 1,
                    rotation: 'auto'
                },
                title: {
                    // text: '<span style="color:{point.color}"><b>{point.name}</span></b> {point.data}<br/>'
                    // text: '<span style="font-size:11px">{series.data}</span><br>'
                },
                plotBands: [{
                    from: 1,
                    to: 1.8,
                    thickness: 20,
                    color: '#55c8fe' // white blue
                }, {
                    from: 1.8,
                    to: 2.6,
                    thickness: 20,
                    color: '#1db6fd' // darker white blue
                }, {
                    from: 2.6,
                    to: 3.4,
                    thickness: 20,
                    color: '#019ae1' // darker white blue
                }, {
                    from: 3.4,
                    to: 4.2,
                    thickness: 20,
                    color: '#0073a9' // blue
                }, {
                    from: 4.2,
                    to: 5,
                    thickness: 20,
                    color: '#004d70' // dark blue
                }, ]
            },
            tooltip: {
                enabled: false
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        enabled: true,
                        borderColor: false,
                    },
                    dial: {
                        radius: '60%',
                        backgroundColor: bgColorClr,
                        borderColor: bgColorClr,
                        borderWidth: 1,
                        baseWidth: 0,
                        topWidth: 18,
                        baseLength: '120%', // of radius
                        rearLength: '-100%'
                    },
                    pivot: {
                        radius: 0
                    }
                }
            },

            // series: [{
            //     name: 'Score Customer Loyalty Rate',
            //     data: [75,50],
            //     dataLabels: {
            //         format: `<span style="font-size:65px;">{y}</span><br/>`,
            //     },
            // }]
            series: [{
                name: "Score Customer Loyalty Rate",
                colorByPoint: true,
                data: [{
                    y: nilaiClr,
                    dataLabels: {
                        format: `<span style="font-size:45px; color:${bgColorClr}">{y}</span><br/>`,
                    },
                }]
            }],
            // },
            // // Add some life
            // function (chart) {
            // if (!chart.renderer.forExport) {
            //     setInterval(function () {
            //         var point = chart.series[0].points[0],
            //             newVal,
            //             inc = Math.round((Math.random() - 0.5) * 20);

            //         newVal = point.y + inc;
            //         if (newVal < 0 || newVal > 200) {
            //             newVal = point.y - inc;
            //         }

            //         point.update(newVal);

            //     }, 3000);
            // }
        });
    </script>
    <!--end::Score Customer Loyalty Rate-->

    <!--begin::Score Net Promoter Score-->
    <script>
        //let nilaiNps = Number("{{ $customer->net_promoter_score == 0 || $customer->net_promoter_score == null ? 1 : $customer->net_promoter_score }}");
        let nilaiNps = Number("{{ $nilai_nps }}");
        let bgColorNps = "";
        // nilaiClr >= 1 ? '#a9b8eb' : nilaiClr >= 1.8 ? '#8092cf' : nilaiClr >= 2.6 ? "#8092cf" : nilaiClr >= 3.4 ? "#2f448a" : nilaiClr >= 4.2 ? "#152866" : "" 
        if (nilaiNps >= 1 && nilaiNps < 1.8) {
            bgColorNps = "#74DFDA";
        } else if (nilaiNps >= 1.8 && nilaiNps < 2.6) {
            bgColorNps = "#74DFDA";
        } else if (nilaiNps >= 2.6 && nilaiNps < 3.4) {
            bgColorNps = "#45D5CE";
        } else if (nilaiNps >= 3.4 && nilaiNps < 4.2) {
            bgColorNps = "#29B9B2";
        } else if (nilaiNps >= 4.2 && nilaiNps <= 5) {
            bgColorNps = "#1F8A85";
        } else {
            bgColorNps = "#8A0000";
        }
        Highcharts.chart('score-nps', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: '<b class="h3">Net Promoter Score</b>'
            },

            pane: {
                center: ['50%', '70%'],
                size: '100%',
                startAngle: -100,
                endAngle: 100,
                background: [{
                    backgroundColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, '#ffffff00'],
                            [1, '#ffffff00']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '10%'
                }]
            },

            // the value axis
            yAxis: {
                min: 1,
                max: 5,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 1,
                // minorTickPosition: 'inside',
                // minorTickColor: '#ffffff00',

                // tickPixelInterval: 5,
                tickPositions: [1, 1.8, 2.6, 3.4, 4.2, 5],
                tickWidth: 0,
                tickPosition: 'inside',
                // tickLength: 5,
                // tickColor: '#666',
                labels: {
                    distance: -35,
                    step: 1,
                    rotation: 'auto'
                },
                title: {
                    // text: '<span style="color:{point.color}"><b>{point.name}</span></b> {point.data}<br/>'
                    // text: '<span style="font-size:11px">{series.data}</span><br>'
                },
                plotBands: [{
                    from: 1,
                    to: 1.8,
                    thickness: 20,
                    color: '#a2eae6' // white blue
                }, {
                    from: 1.8,
                    to: 2.6,
                    thickness: 20,
                    color: '#74dfda' // darker white blue
                }, {
                    from: 2.6,
                    to: 3.4,
                    thickness: 20,
                    color: '#45d5ce' // darker white blue
                }, {
                    from: 3.4,
                    to: 4.2,
                    thickness: 20,
                    color: '#29b9b2' // blue
                }, {
                    from: 4.2,
                    to: 5,
                    thickness: 20,
                    color: '#1f8a85' // dark blue
                }, ]
            },
            tooltip: {
                enabled: false
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        enabled: true,
                        borderColor: false,
                    },
                    dial: {
                        radius: '60%',
                        backgroundColor: bgColorNps,
                        borderColor: bgColorNps,
                        borderWidth: 1,
                        baseWidth: 0,
                        topWidth: 18,
                        baseLength: '120%', // of radius
                        rearLength: '-100%'
                    },
                    pivot: {
                        radius: 0
                    }
                }
            },

            // series: [{
            //     name: 'Score Net Promoter Score',
            //     data: [75,50],
            //     dataLabels: {
            //         format: `<span style="font-size:45px;">{y}</span><br/>`,
            //     },
            // }]
            series: [{
                name: "Score Net Promoter Score",
                colorByPoint: true,
                data: [{
                    y: nilaiNps,
                    dataLabels: {
                        format: `<span style="font-size:45px; color:${bgColorNps}">{y}</span><br/>`,
                    },
                }]
            }],
            // },
            // // Add some life
            // function (chart) {
            // if (!chart.renderer.forExport) {
            //     setInterval(function () {
            //         var point = chart.series[0].points[0],
            //             newVal,
            //             inc = Math.round((Math.random() - 0.5) * 20);

            //         newVal = point.y + inc;
            //         if (newVal < 0 || newVal > 200) {
            //             newVal = point.y - inc;
            //         }

            //         point.update(newVal);

            //     }, 3000);
            // }
        });
    </script>
    <!--end::Score Net Promoter Score-->

    <!--begin::Score nps-->
    <script>
        //let nilaiCsi = Number("{{ $customer->customer_satisfaction_index == 0 || $customer->customer_satisfaction_index == null ? 1 : $customer->customer_satisfaction_index }}");
        let nilaiCsi = Number("{{ $nilai_csi }}");
        let bgColorCsi = "";
        if (nilaiCsi >= 1 && nilaiCsi < 1.8) {
            bgColorCsi = "#FBD791";
        } else if (nilaiCsi >= 1.8 && nilaiCsi < 2.6) {
            bgColorCsi = "#FBD791";
        } else if (nilaiCsi >= 2.6 && nilaiCsi < 3.4) {
            bgColorCsi = "#F9C45A";
        } else if (nilaiCsi >= 3.4 && nilaiCsi < 4.2) {
            bgColorCsi = "#F7B023";
        } else if (nilaiCsi >= 4.2 && nilaiCsi <= 5) {
            bgColorCsi = "#DB9407";
        } else {
            bgColorCsi = "#8A0000";
        }
        Highcharts.chart('score-csi', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: '<b class="h3">Customer Satisfaction Index</b>'
            },

            pane: {
                center: ['50%', '70%'],
                size: '100%',
                startAngle: -100,
                endAngle: 100,
                background: [{
                    backgroundColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, '#ffffff00'],
                            [1, '#ffffff00']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '10%'
                }]
            },

            // the value axis
            yAxis: {
                min: 1,
                max: 5,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 1,
                // minorTickPosition: 'inside',
                // minorTickColor: '#ffffff00',

                // tickPixelInterval: 5,
                tickPositions: [1, 1.8, 2.6, 3.4, 4.2, 5],
                tickWidth: 0,
                tickPosition: 'inside',
                // tickLength: 5,
                // tickColor: '#666',
                labels: {
                    distance: -35,
                    step: 1,
                    rotation: 'auto'
                },
                title: {
                    // text: '<span style="color:{point.color}"><b>{point.name}</span></b> {point.data}<br/>'
                    // text: '<span style="font-size:11px">{series.data}</span><br>'
                },
                plotBands: [{
                    from: 1,
                    to: 1.8,
                    thickness: 20,
                    color: '#fdebc8' // white blue
                }, {
                    from: 1.8,
                    to: 2.6,
                    thickness: 20,
                    color: '#fbd791' // darker white blue
                }, {
                    from: 2.6,
                    to: 3.4,
                    thickness: 20,
                    color: '#f9c45a' // darker white blue
                }, {
                    from: 3.4,
                    to: 4.2,
                    thickness: 20,
                    color: '#f7b023' // blue
                }, {
                    from: 4.2,
                    to: 5,
                    thickness: 20,
                    color: '#db9407' // dark blue
                }, ]
            },
            tooltip: {
                enabled: false
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                gauge: {
                    dataLabels: {
                        enabled: true,
                        borderColor: false,
                    },
                    dial: {
                        radius: '60%',
                        backgroundColor: bgColorCsi,
                        borderColor: bgColorCsi,
                        borderWidth: 1,
                        baseWidth: 0,
                        topWidth: 18,
                        baseLength: '120%', // of radius
                        rearLength: '-100%'
                    },
                    pivot: {
                        radius: 0
                    }
                }
            },

            // series: [{
            //     name: 'Score CSI',
            //     data: [75,50],
            //     dataLabels: {
            //         format: `<span style="font-size:45px;">{y}</span><br/>`,
            //     },
            // }]
            series: [{
                name: "Score CSI",
                colorByPoint: true,
                data: [{
                    y: nilaiCsi,
                    dataLabels: {
                        format: `<span style="font-size:45px; color:${bgColorCsi}">{y}</span><br/>`,
                    },
                }]
            }],
            // },
            // // Add some life
            // function (chart) {
            // if (!chart.renderer.forExport) {
            //     setInterval(function () {
            //         var point = chart.series[0].points[0],
            //             newVal,
            //             inc = Math.round((Math.random() - 0.5) * 20);

            //         newVal = point.y + inc;
            //         if (newVal < 0 || newVal > 200) {
            //             newVal = point.y - inc;
            //         }

            //         point.update(newVal);

            //     }, 3000);
            // }
        });
    </script>
    <!--end::Score CSI-->

    <!--begin::Score CSI-->
    <script>
        function deleteStrukturAttach(e) {
            e.classList.add("disabled");
            const getIdAttachStruktur = e.getAttribute("data-id-attach");
            const getSpinnerElt = e.querySelector(".spinner-border");
            getSpinnerElt.style.display = "";
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus Attachment ini?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const deleteAttachRes = await fetch(`/customer/struktur/${getIdAttachStruktur}/attach/delete`);
                    const parent = e.parentElement.parentElement.parentElement;
                    parent.remove();
                    Swal.fire({
                        title: 'Attachment ini berhasil dihapus',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else {
                    e.classList.remove("disabled");
                    getSpinnerElt.style.display = "none";
                }
            })
        }
    </script>
    <!--end::Score CSI-->

    <!--Begin:: show / hide element-->
    <script>
        function hideColumn(e, elt) {
            e.parentElement.parentElement.querySelector(elt).style.display = "none";
            e.parentElement.querySelector("#hide-button").style.display = "none";
            e.parentElement.querySelector("#show-button").style.display = "";
        }

        function showColumn(e, elt) {
            e.parentElement.parentElement.querySelector(elt).style.display = "";
            e.parentElement.querySelector("#hide-button").style.display = "";
            e.parentElement.querySelector("#show-button").style.display = "none";
        }
    </script>
    <!--End:: show / hide element-->

    {{-- BEGIN:: NILAI OK CHART CLICKABLE --}}
    <script>
        const nilaiOKPointsChartElts = document.querySelectorAll("#nilai-ok .highcharts-point");
        nilaiOKPointsChartElts.forEach(point => {
            point.addEventListener("click", async e => {
                const fillColor = point.getAttribute("fill");
                const unitKerja = document.querySelector(`#nilai-ok .highcharts-legend-item .highcharts-point[fill="${fillColor}"]`).parentElement.querySelector("text").innerHTML
                    .toString().split(":")[0];
                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_customer", "{{ $customer->id_customer }}");
                formData.append("unit_kerja", decodeHTMLEntities(unitKerja.trim()));
                const result = await fetch("/customer/get-nilai-ok", {
                    method: "POST",
                    header: {
                        "Content-Type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                getDataTable("#datatable-nilai-ok", "#nilai-ok", result, "Nilai OK");
                // console.log({
                //     href,
                //     data
                // });
            });
        });
    </script>
    {{-- END:: NILAI OK CHART CLICKABLE --}}

    {{-- BEGIN:: NILAI PIUTANG CLICKABLE --}}
    <script>
        const nilaiPiutangPointsChartElts = document.querySelectorAll("#piutang-pelanggan .highcharts-point");
        nilaiPiutangPointsChartElts.forEach(point => {
            point.addEventListener("click", async e => {
                const fillColor = point.getAttribute("fill");
                const unitKerja = document.querySelector(`#piutang-pelanggan .highcharts-legend-item .highcharts-point[fill="${fillColor}"]`).parentElement.querySelector("text").innerHTML
                    .toString().split(":")[0];
                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_customer", "{{ $customer->id_customer }}");
                formData.append("unit_kerja", decodeHTMLEntities(unitKerja.trim()));
                const result = await fetch("/customer/get-nilai-piutang", {
                    method: "POST",
                    header: {
                        "Content-Type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                getDataTable("#datatable-piutang-pelanggan", "#piutang-pelanggan", result, "Piutang");
                // console.log({
                //     href,
                //     data
                // });
            });
        });
    </script>
    {{-- END:: NILAI PIUTANG CLICKABLE --}}
    
    {{-- BEGIN:: LABA RUGI CLICKABLE --}}
    <script>
        const nilaiLabaRugiPointsChartElts = document.querySelectorAll("#labarugi-pelanggan .highcharts-point");
        const totalUnitKerja = Number("{{$kategoriProyek->count()}}");
        let counter = 1;
        nilaiLabaRugiPointsChartElts.forEach((point, i) => {
            if(counter > totalUnitKerja) counter = 1;
            point.setAttribute("data-index", counter);
            point.addEventListener("click", async e => {
                const fillColor = point.getAttribute("fill");
                const index = point.getAttribute("data-index");
                let unitKerja = document.querySelector(`#labarugi-pelanggan .highcharts-axis-labels text:nth-child(${index})`);
                const type = document.querySelector(`#labarugi-pelanggan .highcharts-legend-item .highcharts-point[fill="${fillColor}"]`).parentElement.querySelector("text").innerHTML
                    .toString().split(":")[0];
                    
                unitKerja = unitKerja.childNodes;
                if(unitKerja.length > 0) {
                    let unitKerjaJoin = "";
                    unitKerja.forEach(elt => {
                        if(elt.nodeName == "#text") {
                            unitKerjaJoin += elt.data + " ";
                        }
                    });
                    unitKerja = unitKerjaJoin;
                } else {
                    unitKerja = unitKerja[0];
                }

                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_customer", "{{ $customer->id_customer }}");
                formData.append("type", type);
                formData.append("unit_kerja", decodeHTMLEntities(unitKerja.trim()));
                const result = await fetch("/customer/get-nilai-laba-rugi", {
                    method: "POST",
                    header: {
                        "Content-Type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());
                getDataTable("#datatable-labarugi-pelanggan", "#labarugi-pelanggan", result, type);
            });
            counter++;
        });
    </script>
    {{-- END:: LABA RUGI CLICKABLE --}}


    {{-- BEGIN:: HIDE TABLE FUNCTION --}}
    <script>
        function hideTable(tableElt, chartElt) {
            const table = document.querySelector(tableElt);
            const chartLine = document.querySelector(chartElt);
            table.style.display = "none";
            chartLine.style.display = "";
        }
    </script>
    {{-- END:: HIDE TABLE FUNCTION --}}

    {{-- Begin :: Decode Entity  --}}
    <script>
        function decodeHTMLEntities(rawStr) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = rawStr;
            return textArea.value;
        }
    </script>
    {{-- End :: Decode Entity  --}}

    {{-- BEGIN :: CONVERT DATA TO TABLE --}}
    <script>
        async function getDataTable(tableElt, chartElt, results, type) {
            // let {
            //     href,
            //     data: filterRes
            // } = await fetch(url).then(res => res.json());
            const table = document.querySelector(tableElt);
            const exportExcelBtn = table.querySelector("#export-excel-btn");
            const thead = table.querySelector("#table-line-head");
            const tbody = table.querySelector("#table-line-body");
            const titleTable = table.querySelector("#title-table");
            const total = table.querySelector("#total");
            // console.log(type);

            if (type == "Nilai OK") {
                let tbodyHTML = ``;
                let totalForecast = 0;

                let theadHTML =
                    '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    // '<th>Bulan</th>' +
                    `<th class="text-end">Nilai OK</th>`
                '</tr>';

                [results.data].forEach(proyek => {
                    for (let filter in proyek) {
                        filter = proyek[filter];
                        let stage = "";
                        totalForecast += Number(filter.nilai_rkap);
                        switch (Number(filter.stage)) {
                            case 1:
                                stage = "Pasar Dini";
                                break;
                            case 2:
                                stage = "Pasar Potensial";
                                break;
                            case 3:
                                stage = "Prakualifikasi";
                                break;
                            case 4:
                                stage = "Tender Diikuti";
                                break;
                            case 5:
                                stage = "Perolehan";
                                break;
                            case 6:
                                stage = "Menang";
                                break;
                            case 7:
                                stage = "Kalah";
                                break;
                            case 8:
                                stage = "Terkontrak";
                                break;
                            case 9:
                                stage = "Terendah";
                                break;
                            case 10:
                                stage = "Approval";
                                break;
                            default:
                                break;
                        }

                        // let bulan = "";
                        // // console.log(filter.bulan_pelaksanaan);
                        // switch (Number(filter.month_forecast)) {
                        //     case 1:
                        //         bulan = "Januari";
                        //         break;
                        //     case 2:
                        //         bulan = "Februari";
                        //         break;
                        //     case 3:
                        //         bulan = "Maret";
                        //         break;
                        //     case 4:
                        //         bulan = "April";
                        //         break;
                        //     case 5:
                        //         bulan = "Mei";
                        //         break;
                        //     case 6:
                        //         bulan = "Juni";
                        //         break;
                        //     case 7:
                        //         bulan = "Juli";
                        //         break;
                        //     case 8:
                        //         bulan = "Agustus";
                        //         break;
                        //     case 9:
                        //         bulan = "September";
                        //         break;
                        //     case 10:
                        //         bulan = "Oktober";
                        //         break;
                        //     case 11:
                        //         bulan = "November";
                        //         break;
                        //     case 12:
                        //         bulan = "Desember";
                        //         break;
                        //     default:
                        //         bulan = "Bulan Unknown"
                        //         break;
                        // }

                        tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                            <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                            class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin) }
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat((["id"])).format(filter.nilai_rkap)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });

                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `${type}`;
                total.innerHTML = `Total ${type} = <b>${Intl.NumberFormat((["id"])).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else if (type == "Piutang") {
                let tbodyHTML = ``;
                let totalForecast = 0;

                let theadHTML =
                    '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    // '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Piutang</th>`
                '</tr>';

                [results.data].forEach(proyek => {
                    for (let filter in proyek) {
                        filter = proyek[filter];
                        let stage = "";
                        totalForecast += Number(filter.piutang);
                        switch (Number(filter.stage)) {
                            case 1:
                                stage = "Pasar Dini";
                                break;
                            case 2:
                                stage = "Pasar Potensial";
                                break;
                            case 3:
                                stage = "Prakualifikasi";
                                break;
                            case 4:
                                stage = "Tender Diikuti";
                                break;
                            case 5:
                                stage = "Perolehan";
                                break;
                            case 6:
                                stage = "Menang";
                                break;
                            case 7:
                                stage = "Kalah";
                                break;
                            case 8:
                                stage = "Terkontrak";
                                break;
                            case 9:
                                stage = "Terendah";
                                break;
                            case 10:
                                stage = "Approval";
                                break;
                            default:
                                break;
                        }

                        // let bulan = "";
                        // // console.log(filter.bulan_pelaksanaan);
                        // switch (Number(filter.month_forecast)) {
                        //     case 1:
                        //         bulan = "Januari";
                        //         break;
                        //     case 2:
                        //         bulan = "Februari";
                        //         break;
                        //     case 3:
                        //         bulan = "Maret";
                        //         break;
                        //     case 4:
                        //         bulan = "April";
                        //         break;
                        //     case 5:
                        //         bulan = "Mei";
                        //         break;
                        //     case 6:
                        //         bulan = "Juni";
                        //         break;
                        //     case 7:
                        //         bulan = "Juli";
                        //         break;
                        //     case 8:
                        //         bulan = "Agustus";
                        //         break;
                        //     case 9:
                        //         bulan = "September";
                        //         break;
                        //     case 10:
                        //         bulan = "Oktober";
                        //         break;
                        //     case 11:
                        //         bulan = "November";
                        //         break;
                        //     case 12:
                        //         bulan = "Desember";
                        //         break;
                        //     default:
                        //         bulan = "Bulan Unknown"
                        //         break;
                        // }

                        tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                            <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                            class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin) }
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat((["id"])).format(filter.piutang)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });

                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `${type}`;
                total.innerHTML = `Total ${type} = <b>${Intl.NumberFormat((["id"])).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else if (type == "Laba") {
                let tbodyHTML = ``;
                let totalForecast = 0;

                let theadHTML =
                    '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    // '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Laba</th>`
                '</tr>';

                [results.data].forEach(proyek => {
                    for (let filter in proyek) {
                        filter = proyek[filter];
                        let stage = "";
                        totalForecast += Number(filter.laba);
                        switch (Number(filter.stage)) {
                            case 1:
                                stage = "Pasar Dini";
                                break;
                            case 2:
                                stage = "Pasar Potensial";
                                break;
                            case 3:
                                stage = "Prakualifikasi";
                                break;
                            case 4:
                                stage = "Tender Diikuti";
                                break;
                            case 5:
                                stage = "Perolehan";
                                break;
                            case 6:
                                stage = "Menang";
                                break;
                            case 7:
                                stage = "Kalah";
                                break;
                            case 8:
                                stage = "Terkontrak";
                                break;
                            case 9:
                                stage = "Terendah";
                                break;
                            case 10:
                                stage = "Approval";
                                break;
                            default:
                                break;
                        }

                        // let bulan = "";
                        // // console.log(filter.bulan_pelaksanaan);
                        // switch (Number(filter.month_forecast)) {
                        //     case 1:
                        //         bulan = "Januari";
                        //         break;
                        //     case 2:
                        //         bulan = "Februari";
                        //         break;
                        //     case 3:
                        //         bulan = "Maret";
                        //         break;
                        //     case 4:
                        //         bulan = "April";
                        //         break;
                        //     case 5:
                        //         bulan = "Mei";
                        //         break;
                        //     case 6:
                        //         bulan = "Juni";
                        //         break;
                        //     case 7:
                        //         bulan = "Juli";
                        //         break;
                        //     case 8:
                        //         bulan = "Agustus";
                        //         break;
                        //     case 9:
                        //         bulan = "September";
                        //         break;
                        //     case 10:
                        //         bulan = "Oktober";
                        //         break;
                        //     case 11:
                        //         bulan = "November";
                        //         break;
                        //     case 12:
                        //         bulan = "Desember";
                        //         break;
                        //     default:
                        //         bulan = "Bulan Unknown"
                        //         break;
                        // }

                        tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                            <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                            class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin) }
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat((["id"])).format(filter.laba)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `${type}`;
                total.innerHTML = `Total ${type} = <b>${Intl.NumberFormat((["id"])).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            } else if (type == "Rugi") {
                let tbodyHTML = ``;
                let totalForecast = 0;

                let theadHTML =
                    '<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">' +
                    '<th>Nama Proyek</th>' +
                    '<th>Status Pasar</th>' +
                    '<th>Stage</th>' +
                    '<th>Unit Kerja</th>' +
                    // '<th>Bulan</th>' +
                    `<th class="text-end">Nilai Rugi</th>`
                '</tr>';

                [results.data].forEach(proyek => {
                    for (let filter in proyek) {
                        filter = proyek[filter];
                        let stage = "";
                        totalForecast += Number(filter.rugi);
                        switch (Number(filter.stage)) {
                            case 1:
                                stage = "Pasar Dini";
                                break;
                            case 2:
                                stage = "Pasar Potensial";
                                break;
                            case 3:
                                stage = "Prakualifikasi";
                                break;
                            case 4:
                                stage = "Tender Diikuti";
                                break;
                            case 5:
                                stage = "Perolehan";
                                break;
                            case 6:
                                stage = "Menang";
                                break;
                            case 7:
                                stage = "Kalah";
                                break;
                            case 8:
                                stage = "Terkontrak";
                                break;
                            case 9:
                                stage = "Terendah";
                                break;
                            case 10:
                                stage = "Approval";
                                break;
                            default:
                                break;
                        }

                        // let bulan = "";
                        // // console.log(filter.bulan_pelaksanaan);
                        // switch (Number(filter.month_forecast)) {
                        //     case 1:
                        //         bulan = "Januari";
                        //         break;
                        //     case 2:
                        //         bulan = "Februari";
                        //         break;
                        //     case 3:
                        //         bulan = "Maret";
                        //         break;
                        //     case 4:
                        //         bulan = "April";
                        //         break;
                        //     case 5:
                        //         bulan = "Mei";
                        //         break;
                        //     case 6:
                        //         bulan = "Juni";
                        //         break;
                        //     case 7:
                        //         bulan = "Juli";
                        //         break;
                        //     case 8:
                        //         bulan = "Agustus";
                        //         break;
                        //     case 9:
                        //         bulan = "September";
                        //         break;
                        //     case 10:
                        //         bulan = "Oktober";
                        //         break;
                        //     case 11:
                        //         bulan = "November";
                        //         break;
                        //     case 12:
                        //         bulan = "Desember";
                        //         break;
                        //     default:
                        //         bulan = "Bulan Unknown"
                        //         break;
                        // }

                        tbodyHTML += `<tr>

                            <!--begin::Email-->
                            <td>
                            <a target="_blank" href="/proyek/view/${ filter.kode_proyek }" id="click-name"
                            class="text-gray-800 text-hover-primary mb-1">${filter.nama_proyek}</a>
                            </td>
                            <!--end::Email-->
                            <!--begin::Name-->
                            <td>
                                ${filter.status_pasdin == null ? "-" : (filter.status_pasdin == "" ? "-" : filter.status_pasdin) }
                            </td>
                            <!--end::Name-->
                            <!--begin::Stage-->
                            <td>
                                ${stage}
                            </td>
                            <!--end::Stage-->

                            <!--begin::Unit Kerja-->
                            <td>
                                ${filter.unit_kerja}
                            </td>
                            <!--end::Unit Kerja-->

                            <!--begin::Nilai Forecast-->
                            <td class="text-end">
                                ${Intl.NumberFormat((["id"])).format(filter.rugi)}
                            </td>
                            <!--end::Nilai Forecast-->
                            </tr>`;
                    }
                });
                thead.innerHTML = theadHTML;
                tbody.innerHTML = tbodyHTML;
                titleTable.innerHTML = `${type}`;
                total.innerHTML = `Total ${type} = <b>${Intl.NumberFormat((["id"])).format(totalForecast)}</b>`;
                table.style.display = "";
                const chartLine = document.querySelector(chartElt);
                chartLine.style.display = "none";
            }
            exportExcelBtn.setAttribute("href", `/download/${results.href}`);
        }

        const pic = JSON.parse(`{!! $customer->pic->takeWhile(function ($item) {
                                    return !empty($item);
                                })->toJson() !!}`)[0];
        // console.log(pic);
        const now = new Date();
        // BEGIN :: GET KODE NASABAH
        async function getKodeNasabah(e) {
            const npwp = "{{$customer->npwp_company}}";
            if(pic == undefined || npwp == "") {
                Toast.fire({
                    html: "Field PIC is empty",
                    icon: "error",
                });
                return;
            }
                let grouping = "";
                let kdgrp = "";
                let ktgrd = "";
                let cust_akont = "";
                let witht = "";
                if("{{$customer->jenis_instansi}}" == "Kementrian / Pemerintah Pusat" || "{{$customer->jenis_instansi}}" == "Pemerintah Provinsi" || "{{$customer->jenis_instansi}}" == "Pemerintah Kota / Kabupaten") {
                    kdgrp = "03";
                    grouping = "ZN01";
                    ktgrd = "Z1";
                    cust_akont = "1104111000";
                    witht = "J7";
                } else if("{{$customer->jenis_instansi}}" == "BUMN") {
                    kdgrp = "04";
                    grouping = "ZN01";
                    ktgrd = "Z1";
                    cust_akont = "1104111000";
                    witht = "J7";
                } else if("{{$customer->jenis_instansi}}" == "BUMD" || "{{$customer->jenis_instansi}}" == "Swasta Nasional") {
                    kdgrp = "05";
                    grouping = "ZN02";
                    ktgrd = "Z2";
                    cust_akont = "1104211000";
                    witht = "J7";
                } else if("{{$customer->jenis_instansi}}" == "Pemerintah Asing" || "{{$customer->jenis_instansi}}" == "Swasta Asing") {
                    kdgrp = "06";
                    grouping = "ZN02";
                    ktgrd = "Z2";
                    cust_akont = "1104211000";
                    witht = "J7";
                } else if("{{$customer->jenis_instansi}}" == "Perusahaan JO") {
                    kdgrp = "08";
                    grouping = "ZN05";
                    ktgrd = "Z4";
                    cust_akont = "";
                    witht = "";
                }
            const data = {
                nmnasabah: "{{$customer->name}}",
                alamat: `{{$customer->address_1}}`,
                kota: "{{$customer->kota_kabupaten ?? 'Jakarta'}}",
                email: "{{$customer->email}}",
                kode_pos: "{{$customer->kode_pos}}",
                ext: "-",
                telepon: "{{$customer->phone_number}}",
                fax: `{{$customer->fax}}`,
                npwp: npwp,
                nama_kontak: pic.nama_pic,
                jenisperusahaan: "{{$customer->jenis_instansi}}",
                jabatan: pic.jabatan_pic,
                email1: pic.email_pic,
                telpon1: pic.phone_pic,
                handphone: pic.phone_pic,
                tipe_perusahaan: "-",
                tipe_lain_perusahaan: "-",
                cotid: "11",
                "dtsap": [
                            {
                                "devid": "YMMI002",
                                "packageid": "",
                                "cocode": "A000",
                                "prctr": "",
                                "timestamp": now.getYear() + now.getMonth() + now.getDate() + "10000",
                                "data": [
                                    {
                                        "BPARTNER": "{{$customer->kode_nasabah}}",
                                        "GROUPING": grouping,
                                        "LVORM": "",
                                        "TITLE": "Z001",
                                        "NAME": "",
                                        "TITLELETTER": "{{$customer->name ?? ""}}",
                                        "SEARCHTERM1": "",
                                        "SEARCHTERM2": "",
                                        "STREET": `{{$customer->address_1}}`,
                                        "HOUSE_NO": "",
                                        "POSTL_COD1": "{{$customer->kode_pos}}",
                                        "CITY": "",
                                        "ADDR_COUNTRY": "ID",
                                        "REGION": "",
                                        "PO_BOX": "",
                                        "POSTL_COD3": "",
                                        "LANGU": "E",
                                        "TELEPHONE": "{{$customer->phone_number ?? ""}}",
                                        "PHONE_EXTENSION": "",
                                        "MOBPHONE": "{{$customer->handphone ?? ""}}",
                                        "FAX": "{{$customer->fax}}",
                                        "FAX_EXTENSION": "",
                                        "E_MAIL": "{{$customer->email}}",
                                        "VALIDFROMDATE":  now.getYear()+ "-" + now.getMonth() + "-" + now.getDate() ,
                                        "VALIDTODATE": now.getYear()+ "-" + (now.getMonth() + 1) + "-" + now.getDate(),
                                        "IDENTIFICATION": [
                                        {
                                            "TAXTYPE": "",
                                            "TAXNUMBER": "{{$customer->npwp_company ?? ""}}"
                                        }],
                                        "BANK": [
                                        {
                                            "BANK_DET_ID": "",
                                            "BANK_CTRY": "",
                                            "BANK_KEY": "",
                                            "BANK_ACCT": "",
                                            "BK_CTRL_KEY": "",
                                            "BANK_REF": "",
                                            "EXTERNALBANKID": "",
                                            "ACCOUNTHOLDER": "",
                                            "BANKACCOUNTNAME": ""
                                        }],
                                        "CUST_BUKRS": "",
                                        "KUNNR": "",
                                        "CUST_AKONT": cust_akont,
                                        "CUST_C_ZTERM": "{{$customer->syarat_pembayaran}}",
                                        "CUST_WTAX": [
                                        {
                                            "WITHT": witht,
                                            "WT_AGENT": "",
                                            "WT_AGTDF": "",
                                            "WT_AGTDT": ""
                                        }],
                                        "VKORG": "",
                                        "VTWEG": "",
                                        "SPART": "",
                                        "KDGRP": "kdgrp",
                                        "CUST_WAERS": "IDR",
                                        "KALKS": "",
                                        "VERSG": "",
                                        "VSBED": "",
                                        "INCO1": "",
                                        "INCO2_L": "",
                                        "CUST_S_ZTERM": "{{$customer->syarat_pembayaran}}",
                                        "KTGRD": ktgrd,
                                        "TAXKD": "{{$customer->tax}}",
                                        "VEND_BUKRS": "",
                                        "LIFNR": "",
                                        "VEND_AKONT": "",
                                        "VEND_C_ZTERM": "",
                                        "REPRF": "X",
                                        "VEND_WTAX": [
                                            []
                                        ],
                                        "EKORG": "",
                                        "VEND_P_ZTERM": "",
                                        "WEBRE": "",
                                        "VEND_WAERS": "",
                                        "LEBRE": "",
                                        "BRAN2": "{{$customer->IndustrySector->id_industry_sector ?? ""}}"
                                    }
                                ]
                            }
                        ]
            };
            
            // switch(data.jenisperusahaan) {
            //     case this.includes("Pemerintah"):
            // }
            if(data.jenisperusahaan.includes("Pemerintah")) {
                data.jenisperusahaan = "Pemerintah";
            } else if(data.jenisperusahaan.includes("BUMD")) {
                data.jenisperusahaan = "BUMD";
            } else if(data.jenisperusahaan.includes("BUMN")) {
                data.jenisperusahaan = "BUMN";
            } else {
                data.jenisperusahaan = "lainnya";
            }
            
            if(data.nmnasabah.includes("Kementerian") || data.nmnasabah.includes("Pemerintah")){
                data.tipe_perusahaan = "Pemerintah";
            } else if(data.nmnasabah.includes("PT")) {
                data.tipe_perusahaan = "PT";
            } else if(data.nmnasabah.includes("CV")) {
                data.tipe_perusahaan = "CV";
            } else if(data.nmnasabah.includes("LTD")) {
                data.tipe_perusahaan = "LTD";
            } else {
                data.tipe_perusahaan = "BUT";
            }
            const getKodeNasabahRes = await fetch("/customer/get-kode-nasabah", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": "{{csrf_token()}}"
                },
                body: JSON.stringify(data),
            }).then(res => res.json());
            if(getKodeNasabahRes.status) {
                document.querySelector("#kode-nasabah").value = getKodeNasabahRes.kode_nasabah;
                document.querySelector("#customer-edit-save").click();
                return;
            } else {
                Toast.fire({
                    html: getKodeNasabahRes.msg,
                    icon: "error",
                });
                return;
            }
        }
        // END :: GET KODE NASABAH

        // BEGIN :: REMOVE SYMBOL CHAR
        function removeSymbol(e) {
            const valueFiltered = e.value.replaceAll(/[^0-9]/gi, "");
            e.value = valueFiltered;
        }
        // END :: REMOVE SYMBOL CHAR

    </script>
    {{-- END :: CONVERT DATA TO TABLE --}}

    <!--begin::MAP Leaflet-->
    <script>
    // var map = L.map('map').setView([51.505, -0.09], 7);
    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     maxZoom: 13,
    //     minZoom: 6,
    //     attribution: '© OpenStreetMap'
    // }).addTo(map);

    // let prevCityLayer = null;
    // let prevCityMarker = null;

    // const proyekCoord = JSON.parse('{!! $area_proyeks->toJson() !!}');
    // const proyekLocation = JSON.parse('{!! $kategoriProyek->flatten()->toJson() !!}');

    // console.log(proyekCoord[0]["JAWA BARAT"]);

    // proyekCoord.forEach(coord => {
    //     proyekLocation.forEach(loc => {
    //         if (loc.proyek.provinsi == Object.keys(coord)) {
    //             const coordGeoJson = L.geoJSON().addTo(map);
    //             coordGeoJson.addData(coord[loc.proyek.provinsi].geojson);
    //             map.panTo(new L.LatLng(coord[loc.proyek.provinsi].lat, coord[loc.proyek.provinsi].lon));
    //         }
    //     });
    //     // coord.forEach(c => {
    //     // });
    // });

    // begin select kabupaten
    async function selectKabupaten(elt) {
        // let kabupatenName = elt.options[elt.selectedIndex].innerText.replaceAll(/Kabupaten|Kota|/gi, "");
        // const getCoorKabupaten = await fetch(`/get-kabupaten-coordinate/${kabupatenName}`).then(res => res.json());
        // const kotaCoord = getCoorKabupaten.geojson;
        // map.panTo(new L.LatLng(getCoorKabupaten.lat, getCoorKabupaten.lon));
        // const cityMarker = L.marker([getCoorKabupaten.lat, getCoorKabupaten.lon]).addTo(map)
        // const cityLayer = L.geoJSON().addTo(map);
        // cityLayer.addData(kotaCoord);

        // if (prevCityLayer && prevCityMarker) {
        //     map.removeLayer(prevCityLayer);
        //     map.removeLayer(prevCityMarker);
        // }
        // prevCityLayer = cityLayer;
        // prevCityMarker = cityMarker;

        // L.polygon(kotaCoord, {color: "blue"}).addTo(map);
        // kotaCoord.forEach(coor => {
        // });
        // L.polygon([[...kotaCoord]]).addTo(map);

        // console.log(elt.value);
        
    }
    // end select kabupaten
</script>
    <!--end::MAP Leaflet-->

<!--begin::Show/Hide Group Tier When Instansi is BUMN-->
<script>
    function getValueInstansi(e) {
        const value = e.value;
        console.log(value);
        if(value.includes("BUMN")) {
            document.querySelector("#group-tier-div").style.display = "";
        } else {
            document.querySelector("#group-tier-div").style.display = "none";
            $("#group-tier").select2({
                minimumResultsForSearch: -1
            }).val("").trigger("change");
        }
    }
</script>
<!--end::Show/Hide Group Tier When Instansi is BUMN-->

<!--begin::Enable Search Bar Select2-->
<script>
    $('#kt_modal_input_masalah_hukum').on('show.bs.modal', function() {
        $("#new-proyek").select2({
            dropdownParent: $("#kt_modal_input_masalah_hukum")
        });
    });
</script>
<script>
    $('#kt_modal_input_csi').on('show.bs.modal', function() {
        $("#namaProyekCSI").select2({
            dropdownParent: $("#kt_modal_input_csi")
        });
    });
</script>
<script>
    $('#kt_modal_input_cli').on('show.bs.modal', function() {
        $("#namaProyekCLI").select2({
            dropdownParent: $("#kt_modal_input_cli")
        });
    });
</script>
<script>
    $('#kt_modal_input_nps').on('show.bs.modal', function() {
        $("#namaProyekNPS").select2({
            dropdownParent: $("#kt_modal_input_nps")
        });
    });
</script>
<script>
    $('#kt_modal_input_karya_inovasi').on('show.bs.modal', function() {
        $("#namaProyekKaryaInovasi").select2({
            dropdownParent: $("#kt_modal_input_karya_inovasi")
        });
    });
</script>
<!--end::Enable Search Bar Select2-->
@endsection
