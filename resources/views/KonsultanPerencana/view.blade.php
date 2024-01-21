{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Ubah Konsultan Perencana')
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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance:textfield; /* Firefox */
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
                    <form action="/konsultan-perencana/{{ $data->id }}/edit" method="post" enctype="multipart/form-data">
                        @csrf

                        <!--begin:: id_customer selected-->
                        <input type="hidden" name="id-konsultan-perencana" value="{{ $data->id }}" id="id-customer">
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
                                    <h1 class="d-flex align-items-center fs-3 my-1">Konsultan Perencana
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
                                    <a href="/konsultan-perencana" class="btn btn-sm btn-light btn-active-primary ms-3"
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
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                        <div class="card-body pt-5">
                                            <!--begin:::Tabs Navigasi-->
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                                <!--begin:::Tab item Pasar Dini-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                        href="#kt_user_view_overview_information"
                                                        style="font-size:14px;">Consultan Information</a>
                                                </li>
                                                <!--end:::Tab item Pasar Dini-->
                                            </ul>
                                            <!--END:::Tabs Navigasi-->
                                            <div class="tab-pane fade show active" id="kt_user_view_overview_information" role="tabpanel">
                                                <div class="row fv-row">
                                                    <div class="col-6">
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Nama</span>
                                                        </label>
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid @error('nama-konsultan') is-invalid @enderror"
                                                            id="nama-konsultan" name="nama-konsultan"
                                                            value="{{ $data->nama_konsultan }}"
                                                            placeholder="Nama Konsultan" />
                                                        @error('nama-konsultan')
                                                            <small class="invalid-feedback m-0 p-0">{{ $message }}</small>
                                                        @enderror
                                                        <br>
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Nomor Telpon</span>
                                                        </label>
                                                        <!--begin::Input-->
                                                        <input type="number" class="form-control form-control-solid"
                                                            id="nomor-telpon" name="nomor-telpon"
                                                            value="{{ $data->nomor_telpon }}"
                                                            placeholder="Nomor Telpon" />
                                                        <br>
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Alamat</span>
                                                        </label>
                                                        <!--begin::Input-->
                                                        <textarea name="alamat" id="alamat" rows="10" class="form-control form-control-solid">{!! $data->alamat !!}</textarea>
                                                        <br>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="required">Email</span>
                                                        </label>
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid @error('email') is-invalid @enderror"
                                                            id="email" name="email"
                                                            value="{{ $data->email }}"
                                                            placeholder="Email" />
                                                        @error('email')
                                                            <small class="invalid-feedback m-0 p-0">{{ $message }}</small>
                                                        @enderror
                                                        <br>
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span class="">Website</span>
                                                        </label>
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                            id="website" name="website"
                                                            value="{{ $data->website }}"
                                                            placeholder="Website" />
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection