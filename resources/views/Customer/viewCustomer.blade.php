{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Ubah Pelanggan')
{{-- End::Title --}}
<style>
    #map { height: 350px; }
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
                @extends('template.header')
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
                                    <button type="button" class="btn btn-sm btn-light btn-active-danger ms-3" onclick="document.location.reload()" style="display: none;" id="cancel-button">
                                        Cancel</button>
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
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                {{ $check_competitor }} name="check-competitor" />
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
                                                            id="website" name="website" value="{{ $customer->website }}"
                                                            placeholder="Website" />
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
                                                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
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
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-bs-toggle="tab" href="#kt_user_view_company"
                                                            style="font-size:12px;">COMPANY INFORMATION</a>
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
                                                <!--end:::Tabs-->

                                                <!--begin:::Tab content -->
                                                <div class="tab-content" id="myTabContent">

<!--begin:::Tab pane Informasi Perusahaan-->
                                                    <div class="tab-pane fade" id="kt_user_view_company"
                                                        role="tabpanel">

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
                                                                        <option value="BUMN"
                                                                            {{ $customer->jenis_instansi == 'BUMN' ? 'selected' : '' }}>
                                                                            BUMN</option>
                                                                        <option value="BUMND"
                                                                            {{ $customer->jenis_instansi == 'BUMND' ? 'selected' : '' }}>
                                                                            BUMND</option>
                                                                        <option value="APBN"
                                                                            {{ $customer->jenis_instansi == 'APBN' ? 'selected' : '' }}>
                                                                            APBN</option>
                                                                        <option value="Swasta"
                                                                            {{ $customer->jenis_instansi == 'Swasta' ? 'selected' : '' }}>
                                                                            Swasta</option>
                                                                        <option value="Investasi"
                                                                            {{ $customer->jenis_instansi == 'Investasi' ? 'selected' : '' }}>
                                                                            Investasi</option>
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
                                                                        <span class="">Kode Owner</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="kodepelanggan-company"
                                                                        value="{{ $customer->kode_pelanggan }}"
                                                                        placeholder="Kode Owner" />
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
                                                                    <select name="negara" id="negara" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false" 
                                                                        onchange="selectNegara(this)"
                                                                        data-placeholder="Pilih Negara">
                                                                        <option value=""></option>
                                                                        @foreach ($data_negara as $negara)
                                                                            @if ($negara->country == $customer->negara)
                                                                                <option value="{{$negara->country}}" selected>{{$negara->country}}</option>
                                                                            @else
                                                                                <option value="{{$negara->country}}">{{$negara->country}}</option>
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
                                                                        value="{{$customer->provinsi}}"
                                                                        placeholder="Provinsi" style="display: none"/>
                                                                    <div id="div-provinsi">
                                                                        <select name="provinsi" id="provinsi" class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="false" 
                                                                            onchange="selectProvinsi(this)"
                                                                            data-placeholder="Pilih Customer Provinsi">
                                                                            <option value="{{$customer->provinsi}}">{{$customer->provinsi}}</option>
                                                                            @foreach ($data_provinsi as $provinsi)
                                                                                @if ($provinsi->id == $customer->provinsi)
                                                                                    <option value="{{$provinsi->id}}" selected>{{ucwords(strtolower($provinsi->name))}}</option>
                                                                                @else
                                                                                    <option value="{{$provinsi->id}}">{{ucwords(strtolower($provinsi->name))}}</option>
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
                                                                        value="{{$customer->kota_kabupaten}}"
                                                                        placeholder="Kabupaten" style="display: none"/>
                                                                    <div  id="div-kabupaten">
                                                                        <select name="kabupaten" id="kabupaten" class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="false" 
                                                                            {{-- onchange="selectKabupaten(this)" --}}
                                                                            data-placeholder="Pilih Customer Kabupaten">
                                                                            <option value="{{$customer->kota_kabupaten}}">{{$customer->kota_kabupaten}}</option>
                                                                            @if (isset($data_kabupaten))
                                                                                @foreach ($data_kabupaten as $kabupaten)
                                                                                    @if ($kabupaten->id == $customer->kota_kabupaten)
                                                                                        <option value="{{$kabupaten->id}}" selected>{{ucwords(strtolower($kabupaten->name))}}</option>
                                                                                    @else
                                                                                        <option value="{{$kabupaten->id}}">{{ucwords(strtolower($kabupaten->name))}}</option>
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
                                                        </h3>
                                                        <!--end::INPUT PIC-->
                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Nama</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="name-pic" value="{{ $customer->name_pic }}"
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
                                                                        <span>Jabatan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="kode-pic" value="{{ $customer->kode_pic }}"
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
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="email-pic"
                                                                        value="{{ $customer->email_pic }}"
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
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        name="phone-number-pic"
                                                                        value="{{ $customer->phone_number_pic }}"
                                                                        placeholder="Kontak Nomor" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->
                                                    </div>
<!--end:::Tab pane Informasi Perusahaan-->

<!--begin:::Tab pane Performance-->
                                                    <div class="tab-pane fade" id="kt_user_view_performance"
                                                        role="tabpanel">
                                                        <div class="tab-pane fade show active"
                                                            id="kt_user_view_performance" role="tabpanel">
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

                                                        <!--begin::Table-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Input Struktur Organisasi
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_struktur">+</a>
                                                        </h3>
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Email</th>
                                                                    <th class="min-w-auto">Jabatan</th>
                                                                    <th class="min-w-auto">Kontak Nomor</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($strukturs as $struktur)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            {{ $struktur->nama_struktur }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Email-->
                                                                        <td>
                                                                            {{ $struktur->email_struktur }}
                                                                        </td>
                                                                        <!--end::Email-->
                                                                        <!--begin::Jabatan-->
                                                                        <td>
                                                                            {{ $struktur->jabatan_struktur }}
                                                                        </td>
                                                                        <!--end::Jabatan-->
                                                                        <!--begin::Phone-->
                                                                        <td>
                                                                            {{ $struktur->phone_struktur }}
                                                                        </td>
                                                                        <!--end::Phone-->
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
                                                                        <th class="min-w-auto">Stage</th>
                                                                        <th class="min-w-auto">Divisi</th>
                                                                        <th class="min-w-auto">Provinsi</th>
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
                                                                                    <td class="text-center">
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
                                                                                    </td>
                                                                                    <!--end::Nama Proyek-->
                                                                                    <!--begin::Divisi-->
                                                                                    <td>{{ $proyekberjalan6->proyek->UnitKerja->divisi }}
                                                                                    </td>
                                                                                    <!--end::Divisi-->
                                                                                    <!--begin::Provinsi-->
                                                                                    <td>{{ $proyekberjalan6->proyek->provinsi }}
                                                                                    </td>
                                                                                    <!--end::Provinsi-->
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
                                                                                <td class="text-center">
                                                                                    @switch($proyekberforecast->stage)
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
                                                        <input type="file" id="file" class="file" hidden>
                                                        <!--begin::Attachment-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Attachments
                                                        </h3>

                                                        <div>
                                                            <label for="doc-attachment" class="form-label"></label>
                                                            <input class="form-control form-control-lg"
                                                                id="doc-attachment" name="doc-attachment" type="file">
                                                        </div>
                                                        <br>
                                                        {{-- <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button> --}}

                                                        <!--End::Attachment-->


                                                        <!--EDITED begin::Attachement Table-->
                                                        <div
                                                            style="background-color: #FFFF;width:100%;padding:10px;margin-top:5px;">

                                                            <div>
                                                                <table
                                                                    class="table align-middle table-row-dashed fs-6 gy-5"
                                                                    id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr
                                                                            class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Customer Name</th>
                                                                            <th class="min-w-auto">Attachment Name</th>
                                                                            <th class="min-w-auto">Updated at</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">


                                                                        @if (isset($attachment))
                                                                            @foreach ($attachment as $attachment)
                                                                                <tr>
                                                                                    <!--begin::Name-->

                                                                                    <td>
                                                                                        <a href="#"
                                                                                            class="text-gray-800 text-hover-primary mb-1">
                                                                                            {{ $attachment->name_customer }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name-->
                                                                                    <!--begin::Kode-->
                                                                                    <td>
                                                                                        <a href="#"
                                                                                            class="text-gray-600 text-hover-primary mb-1">
                                                                                            {{ $attachment->name_attachment }}</a>
                                                                                    </td>
                                                                                    <!--end::Kode-->
                                                                                    <!--begin::Time-->
                                                                                    <td>
                                                                                        <a href="#"
                                                                                            class="text-gray-600 text-hover-primary mb-1">
                                                                                            {{ $attachment->created_at }}</a>
                                                                                    </td>
                                                                                    <!--end::Time-->
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif

                                                                    </tbody>
                                                                    <!--end::Table body-->
                                                                </table>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <!--end::Attachement Table-->



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
                                                    <div class="tab-pane fade show active" id="kt_user_view_overview" role="tabpanel">
                                                        <br>
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="col py-6 text-center">
                                                                    <b class="h3">Proyek Forecast</b>
                                                                </div>
                                                                <div class="col py-6 text-center">
                                                                    <b class="h3">Proyek Berjalan</b>
                                                                </div>
                                                                <div class="col py-6 text-center">
                                                                    <b class="h3">Proyek Selesai</b>
                                                                </div>
                                                            </div>

                                                            <br><br>
                                                            <div class="col py-12 pb-20 text-center" id="proyek-forecast">
                                                                <!--begin::proyek forecast-->
                                                                <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                    style="font-size:20px;">
                                                                    {{ number_format($nilaiForecast, 0, '.', ',') }}
                                                                </h3>
                                                                <!--end::proyek forecast-->
                                                            </div>
                                                            <span class="vr" style="padding: 0.5px"></span>
                                                            <div class="col py-12 text-center" id="proyek-ongoing">
                                                                <!--begin::proyek ongoing-->
                                                                <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                    style="font-size:20px;">
                                                                    {{ $proyekOngoing }}
                                                                </h3>
                                                                <!--end::proyek ongoing-->
                                                            </div>
                                                            <span class="vr" style="padding: 0.5px"></span>
                                                            <div class="col py-12 text-center" id="proyek-close">
                                                                <!--begin::proyek close-->
                                                                <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                    style="font-size:20px;">
                                                                    {{ $proyekClosed }}
                                                                </h3>
                                                                <!--end::proyek close-->
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <hr>
                                                        
                                                        <div class="py-12" id="performance-pelanggan">
                                                            <!--begin::MONITORING PROYEK-->
                                                            <!--end::MONITORING PROYEK-->
                                                        </div>
                                                        <hr>

                                                        <div class="col">
                                                            <div id="map"></div>
                                                        </div>
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
                                        <span>Jabatan</span>
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

    <!--end::Modals-->



@endsection


@section('js-script')

<!--begin::CDN High Chart-->
<script src="/js/highcharts/highcharts.js"></script>
<script src="/js/highcharts/series-label.js"></script>
<script src="/js/highcharts/exporting.js"></script>
<script src="/js/highcharts/export-data.js"></script>
<script src="/js/highcharts/drilldown.js"></script>
<script src="/js/highcharts/funnel.js"></script>
<script src="/js/highcharts/accessibility.js"></script>
<script src="/js/highcharts/highcharts-3d.js"></script>
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


<script>
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
</script>
@endsection