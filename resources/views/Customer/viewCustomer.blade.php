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
</style>
<!--begin::Main-->
@section('content')

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
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
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
                                    <button type="submit" class="btn btn-sm btn-primary" id="customer-edit-save"
                                        style="background-color:#008CB4;">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-danger ms-3"
                                        onclick="document.location.reload()" style="display: none;" id="cancel-button">
                                        Cancel <i class="bi bi-x"></i></button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <a href="/customer" class="btn btn-sm btn-light btn-active-primary ms-3"
                                        id="customer-edit-close">
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
                                                            class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                            value="{{ $customer->name }}" placeholder="Nama" />
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
                                                        <input type="email"
                                                            class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                            id="email" name="email" value="{{ $customer->email }}"
                                                            placeholder="Email" />
                                                        @error('email')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Kontak Nomor</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text"
                                                            class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                            id="phone-number" name="phone-number"
                                                            value="{{ $customer->phone_number }}"
                                                            placeholder="Kontak Nomor" />
                                                        @error('phone-number')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                        @enderror
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Phone-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Nomor Handphone</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text"
                                                            class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                            id="handphone" name="handphone"
                                                            value="{{ $customer->handphone }}"
                                                            placeholder="Nomor Handphone" />
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
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                {{ $check_customer }} name="check-customer" />
                                                            <span class="form-check-label">Customer</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                {{ $check_partner }} name="check-partner" />
                                                            <span class="form-check-label">Partner</span>
                                                        </label>
                                                        <!--end::Options-->
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" {{ $check_competitor }}
                                                                name="check-competitor" />
                                                            <span class="form-check-label">Competitor</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </div>
                                                    <!--end::Options-->

                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Website</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                            id="website" name="website"
                                                            value="{{ $customer->website }}" placeholder="Website" />
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <!--begin::Input group Address 1-->
                                                    <div class="fv-row mb-7" style="margin-top:10px;">
                                                        <!--begin::Label-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Address Line 1</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <textarea class="form-control form-control-solid" name="AddressLine1">{{ $customer->address_1 }}</textarea>
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
                                                        <textarea class="form-control form-control-solid" name="AddressLine2">{{ $customer->address_2 }}</textarea>
                                                        <!--end::Input-->
                                                    </div>
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
                                                <ul
                                                    class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                                    <!--begin:::Tab Overview-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4 active"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_overview"
                                                            style="font-size:12px;">OVERVIEW</a>
                                                    </li>
                                                    <!--end:::Tab Overview-->

                                                    <!--begin:::Tab item Informasi Perusahaan-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                            href="#kt_user_view_company" style="font-size:12px;">COMPANY
                                                            INFORMATION</a>
                                                    </li>
                                                    <!--end:::Tab item Informasi Perusahaan-->

                                                    <!--begin:::Tab item Atachment & Notes-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_performance"
                                                            style="font-size:12px;">PERFORMANCE</a>
                                                    </li>
                                                    <!--end:::Tab item Atachment & Notes-->

                                                    <!--begin:::Tab item History-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_organisasi"
                                                            style="font-size:12px;">STRUKTUR ORGANISASI</a>
                                                    </li>
                                                    <!--end:::Tab item History-->

                                                    <!--begin:::Tab item History-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_history"
                                                            style="font-size:12px;">HISTORY</a>
                                                    </li>
                                                    <!--end:::Tab item History-->

                                                    <!--begin:::Tab item Atachment & Notes-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_Notes"
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
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Instansi</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select name="jenis-instansi"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Instansi">
                                                                        <option></option>
                                                                        @foreach ($sumberdanas as $sumberdana)
                                                                            @if ($sumberdana->nama_sumber == $customer->jenis_instansi)
                                                                                <option
                                                                                    value="{{ $sumberdana->nama_sumber }}"
                                                                                    selected>
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    value="{{ $sumberdana->nama_sumber }}">
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
                                                                        <span class="">Kode Pelanggan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="kodepelanggan-company"
                                                                        value="{{ $customer->kode_pelanggan }}"
                                                                        placeholder="Kode Pelanggan" />
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
                                                                        <span class="">NPWP</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="npwp-company"
                                                                        value="{{ $customer->npwp_company }}"
                                                                        placeholder="NPWP" />
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
                                                                        <span class="">Kode Nasabah</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="kodenasabah-company"
                                                                        value="{{ $customer->kode_nasabah }}"
                                                                        placeholder="Kode Nasabah" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->

                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span class="">Negara</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <select name="negara" id="negara"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2"
                                                                            data-hide-search="false"
                                                                            onchange="selectNegara(this)"
                                                                            data-placeholder="Pilih Negara">
                                                                            <option value=""></option>
                                                                            @foreach ($data_negara as $negara)
                                                                                @if ($negara->country == $customer->negara)
                                                                                    <option value="{{ $negara->country }}"
                                                                                        selected>{{ $negara->country }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $negara->country }}">
                                                                                        {{ $negara->country }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <!--Begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Provinsi</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="input-provinsi" name="provinsi"
                                                                        value="{{ $customer->provinsi }}"
                                                                        placeholder="Provinsi" style="display: none" />
                                                                    <div id="div-provinsi">
                                                                        <select name="provinsi" id="provinsi"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2"
                                                                            data-hide-search="false"
                                                                            onchange="selectProvinsi(this)"
                                                                            data-placeholder="Pilih Customer Provinsi">
                                                                            <option value="{{ $customer->provinsi }}">
                                                                                {{ $customer->provinsi }}</option>
                                                                            @foreach ($data_provinsi as $provinsi)
                                                                                @if ($provinsi->id == $customer->provinsi)
                                                                                    <option value="{{ $provinsi->id }}"
                                                                                        selected>
                                                                                        {{ ucwords(strtolower($provinsi->name)) }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $provinsi->id }}">
                                                                                        {{ ucwords(strtolower($provinsi->name)) }}
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
                                                            <!--end::Row-->

                                                            <!--begin::Row-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="">Kota / Kabupaten</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="input-kabupaten" name="kabupaten"
                                                                        value="{{ $customer->kota_kabupaten }}"
                                                                        placeholder="Kabupaten" style="display: none" />
                                                                    <div id="div-kabupaten">
                                                                        <select name="kabupaten" id="kabupaten"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2"
                                                                            data-hide-search="false" {{-- onchange="selectKabupaten(this)" --}}
                                                                            data-placeholder="Pilih Customer Kabupaten">
                                                                            <option
                                                                                value="{{ $customer->kota_kabupaten }}">
                                                                                {{ $customer->kota_kabupaten }}</option>
                                                                            @if (isset($data_kabupaten))
                                                                                @foreach ($data_kabupaten as $kabupaten)
                                                                                    @if ($kabupaten->id == $customer->kota_kabupaten)
                                                                                        <option
                                                                                            value="{{ $kabupaten->id }}"
                                                                                            selected>
                                                                                            {{ ucwords(strtolower($kabupaten->name)) }}
                                                                                        </option>
                                                                                    @else
                                                                                        <option
                                                                                            value="{{ $kabupaten->id }}">
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

                                                            <!--begin::Fungsi Select Provinsi-->
                                                            <script>
                                                                function selectNegara(e) {
                                                                    // console.log(e.value);

                                                                    if (e.value != "Indonesia") {
                                                                        document.querySelector("#input-provinsi").style.display = "";
                                                                        document.querySelector("#input-provinsi").value = "";
                                                                        document.querySelector("#provinsi").disabled = true;
                                                                        document.querySelector("#div-provinsi").style.display = "none";

                                                                        document.querySelector("#input-kabupaten").style.display = "";
                                                                        document.querySelector("#input-kabupaten").value = "";
                                                                        document.querySelector("#kabupaten").disabled = true;
                                                                        document.querySelector("#div-kabupaten").style.display = "none";
                                                                    } else {
                                                                        document.querySelector("#input-provinsi").style.display = "none";
                                                                        document.querySelector("#div-provinsi").style.display = "";
                                                                        document.querySelector("#provinsi").disabled = false;
                                                                        document.querySelector("#input-kabupaten").style.display = "none";
                                                                        document.querySelector("#div-kabupaten").style.display = "";
                                                                        document.querySelector("#kabupaten").disabled = false;

                                                                    }
                                                                }
                                                                async function selectProvinsi(elt) {
                                                                    const idProvinsi = elt.value;
                                                                    // console.log(elt.value);
                                                                    let html = ``;
                                                                    const getKabupaten = await fetch(`/get-kabupaten/${idProvinsi}`).then(res => res.json());
                                                                    getKabupaten.forEach(kabupaten => {
                                                                        html += `<option value="${kabupaten.id}">${kabupaten.name}</option>`;
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

                                                        <!--begin::INPUT PIC-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Contact / PIC
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_pic">+</a>
                                                        </h3>
                                                        <!--end::INPUT PIC-->
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="text-center">No.</th>
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Email</th>
                                                                    <th class="min-w-auto">Jabatan</th>
                                                                    <th class="min-w-auto">Kontak Nomor</th>
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
                                                                @foreach ($pics as $pic)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-gray-800 text-hover-primary"
                                                                                data-bs-toggle="modal"
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
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_pic_delete_{{ $pic->id }}"
                                                                                    id="modal-delete"
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
                                                    </div>
                                                    <!--end:::Tab pane Informasi Perusahaan-->

                                                    <!--begin:::Tab pane Performance-->
                                                    <div class="tab-pane fade" id="kt_user_view_performance"
                                                        role="tabpanel">
                                                        <div class="tab-pane fade show active"
                                                            id="kt_user_view_performance" role="tabpanel">
                                                            <!--begin::Data Performance-->
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">
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
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilaiok-performance"
                                                                            name="nilaiok-performance"
                                                                            value="{{ $customer->nilaiok }}"
                                                                            placeholder="Nilai OK" />
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
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            name="piutang-performance"
                                                                            value="{{ $customer->piutang }}"
                                                                            placeholder="Piutang" />
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
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            name="laba-performance"
                                                                            value="{{ $customer->laba }}"
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
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            name="rugi-performance"
                                                                            value="{{ $customer->rugi }}"
                                                                            placeholder="Rugi" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <br>

                                                            <!--begin::Data CSI-->
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">
                                                                CSI
                                                            </h3>
                                                            <!--end::Data CSI-->
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai RA</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            value="" placeholder="Nilai RA" />
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
                                                                            <span>Presentase</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            placeholder="Presentase" />
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
                                                                            <span>Nilai RI</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            placeholder="Nilai RI" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                        </div>
                                                    </div>
                                                    <!--end:::Tab pane Performance-->


                                                    <!--begin:::Tab pane Struktur Organisasi-->
                                                    <div class="tab-pane fade" id="kt_user_view_organisasi"
                                                        role="tabpanel">
                                                        <!--begin::Input-->
                                                        {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                Import Struktur :
                                                            </h3><br>
                                                            <input accept=".xls, .xlsx" class="form-control form-control-md form-control-solid" id="doc-attachment" name="import-file" type="file"> --}}
                                                        <!--end::Input-->

                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Input Struktur Organisasi
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_struktur">+</a>
                                                        </h3>
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="text-center">No.</th>
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Email</th>
                                                                    <th class="min-w-auto">Jabatan</th>
                                                                    <th class="min-w-auto">Kontak Nomor</th>
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
                                                                @foreach ($strukturs as $struktur)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-gray-800 text-hover-primary"
                                                                                data-bs-toggle="modal"
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
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_struktur_delete_{{ $struktur->id }}"
                                                                                    id="modal-delete"
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
                                                        <br>
                                                        <br>

                                                    </div>
                                                    <!--end:::Tab pane Struktur Organisasi-->


                                                    <!--begin:::Tab pane History-->
                                                    <div class="tab-pane fade" id="kt_user_view_history" role="tabpanel">

                                                        <!--begin::Proyek Berjalan-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">
                                                                Proyek Berjalan
                                                            </h3>

                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                                id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Nomor SPK</th>
                                                                        <th class="min-w-auto">Unit kerja</th>
                                                                        <th class="min-w-auto">Nilai OK</th>
                                                                        <th class="min-w-auto">Durasi</th>
                                                                        <th class="min-w-auto">Start/End</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">
                                                                    @if (isset($proyekberjalan))
                                                                        @foreach ($proyekberjalan as $proyekberjalan0)
                                                                            @if ($proyekberjalan0->stage <= 7)
                                                                                <tr>
                                                                                    <!--begin::Name-->
                                                                                    <td>
                                                                                        <a href="/proyek/view/{{ $proyekberjalan0->kode_proyek }}"
                                                                                            class="text-gray-800 text-hover-primary mb-1">
                                                                                            {{ $proyekberjalan0->nama_proyek }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name-->
                                                                                    <!--begin::Kode-->
                                                                                    <td>
                                                                                        <a href="#"
                                                                                            class="text-gray-600 text-hover-primary mb-1">
                                                                                            {{ $proyekberjalan0->proyek->nospk_external }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Kode-->
                                                                                    <!--begin::Unit-->
                                                                                    <td>
                                                                                        {{ $proyekberjalan0->UnitKerja->unit_kerja }}
                                                                                    </td>
                                                                                    <!--end::Unit-->
                                                                                    <!--begin::Nilai OK-->
                                                                                    <td>{{ $proyekberjalan0->nilaiok_proyek }}
                                                                                    </td>
                                                                                    <!--end::Nilai OK-->
                                                                                    <!--begin::Durasi-->
                                                                                    <td>
                                                                                        @php
                                                                                            $tglakhir = new DateTime($proyekberjalan0->proyek->tanggal_akhir_terkontrak);
                                                                                            $tglawal = new DateTime($proyekberjalan0->proyek->tanggal_mulai_terkontrak);
                                                                                            $durasi = $tglakhir->diff($tglawal);
                                                                                        @endphp
                                                                                        {{ $durasi->y }} Tahun,
                                                                                        {{ $durasi->m }} Bulan
                                                                                    </td>
                                                                                    <!--end::Durasi-->
                                                                                    <!--begin::Start-->
                                                                                    <td>{{ date_format($tglawal, 'd-M-Y') }}
                                                                                        /
                                                                                        {{ date_format($tglakhir, 'd-M-Y') }}
                                                                                    </td>
                                                                                    <!--end::End-->
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                        </div>
                                                        <!--end::Proyek Berjalan-->

                                                        <br><br>

                                                        <!--begin::Proyek Terkontrak-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">
                                                                Proyek Selesai
                                                            </h3>
                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                                id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Nomor SPK</th>
                                                                        <th class="min-w-auto">Unit kerja</th>
                                                                        {{-- <th class="min-w-auto">Stage</th> --}}
                                                                        <th class="min-w-auto">Divisi</th>
                                                                        <th class="min-w-auto">Nilai OK</th>
                                                                        <th class="min-w-auto">Tgl Mulai Kontrak</th>
                                                                        <th class="min-w-auto">Durasi</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">


                                                                    @if (isset($proyekberjalan))
                                                                        @foreach ($proyekberjalan as $proyekberjalan6)
                                                                            @if ($proyekberjalan6->stage > 7)
                                                                                <tr>
                                                                                    <!--begin::Name-->
                                                                                    <td>
                                                                                        <a href="/proyek/view/{{ $proyekberjalan6->kode_proyek }}"
                                                                                            class="text-gray-800 text-hover-primary mb-1 text-break">
                                                                                            {{ $proyekberjalan6->nama_proyek }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name-->
                                                                                    <!--begin::No.SPK-->
                                                                                    <td>{{ $proyekberjalan6->proyek->nospk_external }}
                                                                                    </td>
                                                                                    <!--end::No.SPK-->
                                                                                    <!--begin::Unit-->
                                                                                    <td>{{ $proyekberjalan6->UnitKerja->unit_kerja }}
                                                                                    </td>
                                                                                    <!--end::Unit-->
                                                                                    <!--begin::Nama Proyek-->
                                                                                    {{-- <td class="text-center">
                                                                                        @switch($proyekberjalan6->stage)
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
                                                                                    </td> --}}
                                                                                    <!--end::Nama Proyek-->
                                                                                    <!--begin::Divisi-->
                                                                                    <td>{{ $proyekberjalan6->proyek->UnitKerja->divisi }}
                                                                                    </td>
                                                                                    <!--end::Divisi-->
                                                                                    <!--begin::NilaiOK-->
                                                                                    <td>{{ $proyekberjalan6->proyek->nilai_rkap }}
                                                                                    </td>
                                                                                    <!--end::NilaiOK-->
                                                                                    <!--begin::Tanggal Kontrak-->
                                                                                    <td>{{ $proyekberjalan6->proyek->tanggal_mulai_terkontrak }}
                                                                                    </td>
                                                                                    <!--end::Tanggal Kontrak-->
                                                                                    <!--begin::Durasi-->
                                                                                    <td>
                                                                                        @php
                                                                                            $tglakhir = new DateTime($proyekberjalan6->proyek->tanggal_akhir_terkontrak);
                                                                                            $tglawal = new DateTime($proyekberjalan6->proyek->tanggal_mulai_terkontrak);
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
                                                        <!--end::Card title-->

                                                        <br><br>

                                                        <!--begin:: FORECAST Proyek-->
                                                        <div class="card-title m-0">
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">
                                                                Forecast Proyek
                                                            </h3>
                                                            <!--begin::Table-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                                id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="min-w-auto">Nama Proyek</th>
                                                                        <th class="min-w-auto">Unit kerja</th>
                                                                        <th class="min-w-auto">Stage</th>
                                                                        <th class="min-w-auto">Nilai Forecast</th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">

                                                                    @if (isset($proyekberjalan))
                                                                        @foreach ($proyekberjalan as $proyekberforecast)
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
                                                                                <td>{{ $proyekberjalan6->UnitKerja->unit_kerja }}
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
                                                                                <td>
                                                                                    @foreach ($proyekberforecast->proyek->Forecasts as $forecast)
                                                                                        @switch($forecast->month_forecast)
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
                                                                                                Selesai
                                                                                        @endswitch

                                                                                        :
                                                                                        {{ $forecast->nilai_forecast }};<br>
                                                                                    @endforeach
                                                                                </td>
                                                                                <!--end::Nilai Forecast-->
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif

                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Table-->
                                                        </div>
                                                        <!--end::Card title-->

                                                        <br><br>

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


                                                    <!--begin:::Tab pane Atachment & Notes-->
                                                    <div class="tab-pane fade" id="kt_user_view_Notes" role="tabpanel">
                                                        {{-- <input type="file" id="file" class="file" hidden> --}}
                                                        <!--begin::Attachment-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Attachments
                                                        </h3>

                                                        <div>
                                                            <label for="doc-attachment" class="form-label"></label>
                                                            <input onchange="this.form.submit()"
                                                                class="form-control form-control-sm" id="doc-attachment"
                                                                name="doc-attachment" type="file"
                                                                accept=".docx, .pdf">
                                                        </div>

                                                        <br>
                                                        {{-- <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button> --}}

                                                        <!--End::Attachment-->

                                                        <div class="ms-3">
                                                            <table class="table align-middle table-row-dashed fs-6"
                                                                id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
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
                                                                                    @if (str_contains("$attachments->name_attachment", '.doc'))
                                                                                        <a href="/document/view/{{ $attachments->id_customer }}/{{ $attachments->id_document }}"
                                                                                            class="text-hover-primary">{{ $attachments->name_attachment }}</a>
                                                                                    @else
                                                                                        <a target="_blank"
                                                                                            href="{{ asset('words/' . $attachments->id_document . '.pdf') }}"
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
                                                                                        <p data-bs-toggle="modal"
                                                                                            data-bs-target="#kt_attachment_delete_{{ $attachments->id }}"
                                                                                            id="modal-delete"
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
                                                        <div
                                                            style="background-color: #FFFF;width:100%;padding:10px;margin-top:5px;">

                                                            <!--begin::Note-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                    style="font-size:14px;">
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
                                                    </div>
                                                    <!--end:::Tab pane Atachment & Notes-->

                                                    <!--begin:::Tab pane Over View-->
                                                    <div class="tab-pane fade show active" id="kt_user_view_overview"
                                                        role="tabpanel">
                                                        <br>
                                                        <!--Begin::Title Biru Form: Nilai RKAP Review-->

                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Overview Project &nbsp;
                                                            <i onclick="hideOverview()" id="hide-overview"
                                                                class="bi bi-arrows-collapse"></i><i
                                                                onclick="showOverview()" id="show-overview"
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
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col py-3  text-center">
                                                                        <b class="h3">Proyek Forecast</b>
                                                                    </div>
                                                                    <div class="col py-3 text-center">
                                                                        <b class="h3">Proyek Berjalan</b>
                                                                    </div>
                                                                    <div class="col py-3 text-center">
                                                                        <b class="h3">Proyek Selesai</b>
                                                                    </div>
                                                                </div>

                                                                <br>

                                                                <div class="col py-6 text-center" id="proyek-forecast">
                                                                    <!--begin::proyek forecast-->
                                                                    <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                        style="font-size:20px;">
                                                                        {{ number_format($nilaiForecast, 0, '.', ',') }}
                                                                    </h3>
                                                                    <!--end::proyek forecast-->
                                                                </div>
                                                                <span class="vr" style="padding: 0.5px"></span>
                                                                <div class="col py-6 text-center" id="proyek-ongoing">
                                                                    <!--begin::proyek ongoing-->
                                                                    <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                        style="font-size:20px;">
                                                                        {{ $proyekOngoing }}
                                                                    </h3>
                                                                    <!--end::proyek ongoing-->
                                                                </div>
                                                                <span class="vr" style="padding: 0.5px"></span>
                                                                <div class="col py-6 text-center" id="proyek-close">
                                                                    <!--begin::proyek close-->
                                                                    <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                        style="font-size:20px;">
                                                                        {{ $proyekClosed }}
                                                                    </h3>
                                                                    <!--end::proyek close-->
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <hr>
                                                        </div>
                                                        <!--overViewProject-->

                                                        <!--Begin::Title Biru Form: Pelanggan Performance-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Pelanggan Performance &nbsp;
                                                            <i onclick="hidePerformance()" id="hide-performance"
                                                                class="bi bi-arrows-collapse"></i><i
                                                                onclick="showPerformance()" id="show-performance"
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
                                                            <div class="py-6" id="performance-pelanggan">
                                                                <!--begin::MONITORING PROYEK-->
                                                                <!--end::MONITORING PROYEK-->
                                                            </div>
                                                            <hr>

                                                            <div class="py-6" id="piutang-pelanggan">
                                                                <!--begin::MONITORING PROYEK-->
                                                                <!--end::MONITORING PROYEK-->
                                                            </div>
                                                            <hr>

                                                            <div class="py-6" id="labarugi-pelanggan">
                                                                <!--begin::MONITORING PROYEK-->
                                                                <!--end::MONITORING PROYEK-->
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <!--pelangganPerformance-->

                                                        <!--Begin::Title Biru Form: Pelanggan Performance-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Score CSI &nbsp;
                                                            <i onclick="hideCSI()" id="hide-csi"
                                                                class="bi bi-arrows-collapse"></i><i onclick="showCSI()"
                                                                id="show-csi" style="display: none"
                                                                class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <!--End::Title Biru Form: Pelanggan Performance-->
                                                        <script>
                                                            function hideCSI() {
                                                                document.getElementById("scoreCSI").style.display = "none";
                                                                document.getElementById("hide-csi").style.display = "none";
                                                                document.getElementById("show-csi").style.display = "";
                                                            }

                                                            function showCSI() {
                                                                document.getElementById("scoreCSI").style.display = "";
                                                                document.getElementById("hide-csi").style.display = "";
                                                                document.getElementById("show-csi").style.display = "none";
                                                            }
                                                        </script>
                                                        <div id="scoreCSI">
                                                            <figure class="highcharts-figure">
                                                                {{-- <div id="container-speed" class="chart-container"></div> --}}
                                                                <div id="score-csi" class="chart-container"></div>
                                                            </figure>
                                                            <hr>

                                                        </div>
                                                        <!--scoreCSI-->

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
                            <select name="nama-proyek" class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Nama Proyek">
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
                                    <input type="text" class="form-control form-control-solid" name="name-pic"
                                        value="" placeholder="Nama" />
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
                                    <input type="text" class="form-control form-control-solid" name="kode-pic"
                                        value="" placeholder="Jabatan" />
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
                                    <input type="text" class="form-control form-control-solid" name="email-pic"
                                        value="" placeholder="Email" />
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
                                    <input type="text" class="form-control form-control-solid" name="phone-number-pic"
                                        value="" placeholder="Kontak Nomor" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>

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
    @foreach ($pics as $pic)
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
                                        <input type="text" class="form-control form-control-solid" name="name-pic"
                                            value="{{ $pic->nama_pic }}" placeholder="Nama" />
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
                                        <input type="text" class="form-control form-control-solid" name="kode-pic"
                                            value="{{ $pic->jabatan_pic }}" placeholder="Jabatan" />
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
                                        <input type="text" class="form-control form-control-solid" name="email-pic"
                                            value="{{ $pic->email_pic }}" placeholder="Email" />
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
                                        <input type="text" class="form-control form-control-solid"
                                            name="phone-number-pic" value="{{ $pic->phone_pic }}"
                                            placeholder="Kontak Nomor" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

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
    <!--end::modal Edit PIC-->

    <!--begin::DELETE PIC-->
    @foreach ($pics as $pic)
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
                                    <input type="text" class="form-control form-control-solid" name="name-struktur"
                                        value="" placeholder="Nama" />
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
                                    <input type="text" class="form-control form-control-solid" name="jabatan-struktur"
                                        value="" placeholder="Jabatan" />
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
                                    <input type="text" class="form-control form-control-solid" name="email-struktur"
                                        value="" placeholder="Email" />
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
                                    <input type="text" class="form-control form-control-solid" name="phone-struktur"
                                        value="" placeholder="Kontak Nomor" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>

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
                                        <input type="text" class="form-control form-control-solid"
                                            name="name-struktur" value="{{ $struktur->nama_struktur }}"
                                            placeholder="Nama" />
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
                                        <input type="text" class="form-control form-control-solid"
                                            name="jabatan-struktur" value="{{ $struktur->jabatan_struktur }}"
                                            placeholder="Jabatan" />
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
                                        <input type="text" class="form-control form-control-solid"
                                            name="email-struktur" value="{{ $struktur->email_struktur }}"
                                            placeholder="Email" />
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
                                        <input type="text" class="form-control form-control-solid"
                                            name="phone-struktur" value="{{ $struktur->phone_struktur }}"
                                            placeholder="Kontak Nomor" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

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
    <!--end::modal EDIT Struktur Organisasi-->

    <!--begin::DELETE STRUKTUR-->
    @foreach ($strukturs as $struktur)
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
    @endforeach
    <!--end::DELETE STRUKTUR-->

    <!--begin::DELETE ATTACHMENT-->
    @foreach ($attachment as $attachments)
        <form action="/customer/attachment/{{ $attachments->id }}/delete" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_attachment_delete_{{ $attachments->id }}" tabindex="-1"
                aria-hidden="true">
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

    <!--end::Modals-->



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

    <!--begin::Performance Pelanggan-->
    <script>
        let namaProyek = {!! json_encode($namaProyek) !!};
        let nilaiOK = {!! json_encode($nilaiOK) !!};
        if (namaProyek.length == 0) {
            namaProyek = ["..."];
            nilaiOK = [0];
        }
        // console.log(namaProyek.length);
        // console.log(nilaiOK);

        Highcharts.chart('performance-pelanggan', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 5,
                    beta: 15,
                    viewDistance: 50,
                    depth: 100
                }
            },
            title: {
                align: 'center',
                text: '<b class="h3">Nilai OK Proyek</b>'
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
            xAxis: {
                categories: namaProyek,
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
                series: {
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                },
            },
            tooltip: {
                // headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}"><b>{point.name}</span></b> {point.data}<br/>'
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
        let nilaiPiutang = {!! $nilaiPiutang !!};
        Highcharts.chart('piutang-pelanggan', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 5,
                    beta: 15,
                    viewDistance: 50,
                    depth: 100
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
            xAxis: {
                categories: [''],
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
                series: {
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: true
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
                name: "Piutang : " + "{{ number_format($nilaiPiutang, 0, ',', ',') }}",
                colorByPoint: true,
                data: [{
                    name: 'Nilai Piutang',
                    y: nilaiPiutang,
                }]
            }],
        });
    </script>
    <!--end::Piutang Pelanggan-->

    <!--begin::Laba Rugi Pelanggan-->
    @php
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
                        name: "Laba : " + "{{ number_format($nilaiLaba, 0, ',', ',') }}",
                        y: nilaiLaba,
                    },
                    {
                        name: "Rugi : " + "{{ number_format($nilaiRugi, 0, ',', ',') }}",
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
    </script>
    <!--end::Laba Rugi Pelanggan-->

    <!--begin::Score CSI-->
    <script>
        let nilaiCsi = 20;
        Highcharts.chart('score-csi', {

            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: '<b class="h3">Gauge CSI</b>'
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
                min: 0,
                max: 100,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 1,
                // minorTickPosition: 'inside',
                // minorTickColor: '#ffffff00',

                // tickPixelInterval: 5,
                tickPositions: [0, 25, 50, 100],
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
                    from: 0,
                    to: 25,
                    thickness: 20,
                    color: '#ED6D3F' // red
                }, {
                    from: 25,
                    to: 50,
                    thickness: 20,
                    color: '#F7C13E' // yellow
                }, {
                    from: 50,
                    to: 100,
                    thickness: 20,
                    color: '#61CB65' // green
                }]
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
                        backgroundColor: (nilaiCsi > 50 ? '#61CB65' : nilaiCsi > 25 ? '#F7C13E' : '#ED6D3F'),
                        borderColor: (nilaiCsi > 50 ? '#61CB65' : nilaiCsi > 25 ? '#F7C13E' : '#ED6D3F'),
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
            //         format: `<span style="font-size:70px;">{y}</span><br/>`,
            //     },
            // }]
            series: [{
                name: "Score CSI",
                colorByPoint: true,
                data: [{
                    y: nilaiCsi,
                    dataLabels: {
                        format: `<span style="font-size:70px; ${nilaiCsi > 50 ? 'color:#61CB65' : nilaiCsi > 25 ? 'color:#F7C13E' : 'color:#ED6D3F' }">{y}</span><br/>`,
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


    <!--begin::MAP Leaflet-->
    {{-- <script>
    var map = L.map('map').setView([51.505, -0.09], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 13,
        minZoom: 6,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // let prevCityLayer = null;
    // let prevCityMarker = null;

    const proyekCoord = JSON.parse('{!! $area_proyeks->toJson() !!}');
    const proyekLocation = JSON.parse('{!! $kategoriProyek->flatten()->toJson() !!}');

    // console.log(proyekCoord[0]["JAWA BARAT"]);

    proyekCoord.forEach(coord => {
        proyekLocation.forEach(loc => {
            if (loc.proyek.provinsi == Object.keys(coord)) {
                const coordGeoJson = L.geoJSON().addTo(map);
                coordGeoJson.addData(coord[loc.proyek.provinsi].geojson);
                map.panTo(new L.LatLng(coord[loc.proyek.provinsi].lat, coord[loc.proyek.provinsi].lon));
            }
        });
        // coord.forEach(c => {
        // });
    });

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
        
    }
    // end select kabupaten
</script> --}}
    <!--end::MAP Leaflet-->
@endsection
