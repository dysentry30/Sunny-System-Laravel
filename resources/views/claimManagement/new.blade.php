{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Claim Managements')
{{-- end:: title --}}

{{-- begin::content --}}
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header align-items-stretch">
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                    <!--begin::Navbar-->
                    <div class="d-flex align-items-stretch" id="kt_header_nav">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                            data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                            data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Navbar-->
                    <!--begin::Topbar-->
                    <div class="d-flex align-items-stretch flex-shrink-0">
                        <!--begin::Toolbar wrapper-->
                        <div class="d-flex align-items-stretch flex-shrink-0">

                            <!--begin::Notifications-->
                            <div class="d-flex align-items-center ms-1 ms-lg-3">
                                <!--begin::Menu- wrapper-->
                                <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen022.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none">
                                            <path
                                                d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                                fill="black"></path>
                                            <path
                                                d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                                fill="black"></path>
                                            <path opacity="0.3"
                                                d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                                fill="black"></path>
                                            <path opacity="0.3"
                                                d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                                fill="black"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                                    data-kt-menu="true">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                        style="background-image:url('../media/misc/pattern-1.jpg')">
                                        <!--begin::Title-->
                                        <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
                                            <span class="fs-8 opacity-75 ps-3">0 reports</span>
                                        </h3>
                                        <!--end::Title-->
                                        <!--begin::Tabs-->
                                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                                            <li class="nav-item">
                                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 "
                                                    data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
                                            </li>

                                        </ul>
                                        <!--end::Tabs-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Tab content-->

                                    <div class="tab-content">
                                        <!--begin::Tab panel-->
                                        <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                                            <!--begin::Items-->
                                            <div class="scroll-y mh-325px my-5 px-8">
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack py-4">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-35px me-4">
                                                            <span class="symbol-label bg-light-primary">
                                                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.3"
                                                                            d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z"
                                                                            fill="black"></path>
                                                                        <path
                                                                            d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z"
                                                                            fill="black"></path>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Title-->
                                                        <div class="mb-0 me-2">
                                                            <a href="#"
                                                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                                                                Alice</a>
                                                            <div class="text-gray-400 fs-7">Phase 1 development
                                                            </div>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Label-->
                                                    <span class="badge badge-light fs-8">1 hr</span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Items-->

                                        </div>
                                        <!--end::Tab panel-->


                                    </div>
                                    <!--end::Tab content-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Notifications-->


                            <!--begin::User-->
                            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                <!--begin::Menu wrapper-->
                                <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                                    data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    Hi,<strong>Indar Wiguna</strong>
                                    <img src="../../media/avatars/User-Icon.png" alt="user">
                                </div>

                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::User -->



                        </div>
                        <!--end::Toolbar wrapper-->
                    </div>
                    <!--end::Topbar-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->


        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Toolbar-->
            @isset($claimContract)
                <form action="/claim-management/update" method="post">
                    <input type="hidden" name="id-claim" value="{{ $claimContract->id_claim }}">
                @else
                    <form action="/claim-management/save" method="post">
                    @endisset
                    @csrf
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Contract
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                                    style="background-color:#ffa62b;">
                                    Save</button>
                                <!--end::Button-->

                                <!--begin::Button-->
                                <a href="/claim-management" class="btn btn-sm btn-primary" id="cloedButton"
                                    style="background-color:#f3f6f9;margin-left:10px;color: black;">
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

                                <!--begin::Header Contract-->
                                <div class="col-xl-15">
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                        <div class="card-body pt-5"
                                            style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                            <div class="form-group">

                                                <div id="stage-button" class="stage-list">

                                                    <a href="#"
                                                        class="stage-button color-is-default {{ $claimContract->stage ?? 1 > 0 ? 'stage-is-done' : 'stage-is-not-active' }}"
                                                        style="outline: 0px;">
                                                        Draft
                                                    </a>
                                                    <a href="#"
                                                        class="stage-button color-is-default {{ $claimContract->stage ?? 1 > 1 ? 'stage-is-done' : 'stage-is-not-active' }}"
                                                        style="outline: 0px;">
                                                        Submit
                                                    </a>
                                                    <a href="#"
                                                        class="stage-button color-is-default {{ $claimContract->stage ?? 1 > 2 ? 'stage-is-done' : 'stage-is-not-active' }}"
                                                        style="outline: 0px;">
                                                        Approve & Reject
                                                    </a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--end::Header Contract-->

                                {{-- begin::Alert --}}
                                @if (Session::has('failed'))
                                    <div class="col">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                            <symbol id="exclamation-triangle-fill" fill="red" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                            </symbol>
                                        </svg>
                                        <div class="alert alert-danger d-flex align-items-center alert-dismissible"
                                            role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                                aria-label="Danger:">
                                                <use xlink:href="#exclamation-triangle-fill" />
                                            </svg>
                                            <div>
                                                {{ Session::get('failed') }}
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- end::Alert --}}
                                @endif
                                @if (Session::has('success'))
                                    <div class="col">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                            <symbol id="check-circle-fill" fill="green" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </symbol>
                                        </svg>
                                        <div class="alert alert-success d-flex align-items-center alert-dismissible"
                                            role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                                aria-label="Success:">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div>
                                                {{ Session::get('success') }}
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- end::Alert --}}
                                @endif


                                <!--begin::Header Contract-->
                                <div class="col-xl-15">
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                        <form action="/claim-management/save" method="POST">
                                            <div class="card-body pt-5">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->

                                                        <!--begin::Input group Name-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span class="required">No. Claim</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                id="number-claim" name="number-claim"
                                                                value="{{ $kode_claim ?? ($claimContract->id_claim ?? '') }}"
                                                                placeholder="No. Claim" readonly>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group Name-->
                                                    </div>

                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Tanggal Pengajuan</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->

                                                            <a href="#" class="btn btn-sm mx-3"
                                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_calendar"><i
                                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                    style="color: #e08c16"></i></a>
                                                            <input type="Date" class="form-control form-control-solid ps-12"
                                                                placeholder="Select a date"
                                                                value="{{ date_format(date_create(old('approve-date') ?? ($claimContract->tanggal_claim ?? '')), 'Y-m-d') }}"
                                                                name="approve-date" id="approve-date">

                                                            {{-- begin::erorr message --}}
                                                            @error('approve-date')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}

                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>


                                                <div class="row fv-row">

                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>PIC</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                placeholder="Who is responsible for this contract?" id="pic"
                                                                name="pic"
                                                                value="{{ old('pic') ?? ($claimContract->pic ?? '') }}">
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('pic')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
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
                                                                <span>Total Claim</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                name="total-claim" id="total-claim"
                                                                onkeyup="reformatNumber(this)"
                                                                value="{{ number_format((int) ($claimContract->nilai_claim ?? 0), 0, ',', ',') }}"
                                                                placeholder="Type number here..." disabled>
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('total-claim')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>


                                                <div class="row fv-row">

                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="project-id" id="project-id"
                                                                class="form-select form-select-solid select2-hidden-accessible"
                                                                data-control="select2" data-hide-search="true"
                                                                data-placeholder="Pilih Proyek"
                                                                data-select2-id="select2-data-project-id" tabindex="-1"
                                                                aria-hidden="true">
                                                                <option value=""></option>
                                                                @foreach ($projects as $projectAll)
                                                                    <option value="{{ $projectAll->kode_proyek }}"
                                                                        {{ $projectAll->kode_proyek == (old('project-id') ?? ($claimContract->project->kode_proyek ?? '')) ? 'selected' : '' }}>
                                                                        {{ $projectAll->nama_proyek }}</option>
                                                                @endforeach
                                                                {{-- <option selected data-select2-id="select2-data-2-3jce">Pilih
                                                                Proyek...</option> --}}
                                                            </select>
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('project-id')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>

                                                    <!--End begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Contract</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select
                                                                class="form-select form-select-solid select2-hidden-accessible"
                                                                name="id-contract" id="id-contract" value=""
                                                                data-control="select2" data-hide-search="true"
                                                                data-select2-id="select2-data-contract-id"
                                                                data-placeholder="Pilih Contract">
                                                                <option value=""></option>
                                                                @foreach ($contractManagements as $contract)
                                                                    <option value="{{ $contract->id_contract }}"
                                                                        {{ $contract->id_contract == (old('id-contract') ?? ($claimContract->id_contract ?? '')) ? 'selected' : '' }}>
                                                                        {{ $contract->id_contract }}</option>
                                                                @endforeach
                                                            </select>
                                                            <!--end::Input-->
                                                            {{-- begin::erorr message --}}
                                                            @error('id-contract')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->

                                                </div>
                                                <h6 id="status-msg" style="display: none"></h6>

                                                <!--End begin::Row-->
                                        </form>

                                    </div>


                                </div>
                            </div>
                            <!--end::Header Contract-->

                            @isset($claimContract)
                                {{-- begin:: Footer --}}
                                <div class="col-xl-15">
                                    <!--begin::Contacts-->
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                        <!--begin::Card body-->
                                        <div class="card-body pt-5">
                                            <!--begin:::Tabs-->
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8"
                                                role="tablist">

                                                <!--begin:::Tab item Informasi Perusahaan-->
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                        href="#kt_user_view_overview_tab" style="font-size:14px;"
                                                        aria-selected="true" role="tab">Detail Pengajuan</a>
                                                </li>
                                                <!--end:::Tab item Informasi Perusahaan-->

                                                <!--begin:::Tab item History-->
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                        data-bs-toggle="tab" href="#kt_user_view_overview_history"
                                                        style="font-size:14px;" aria-selected="false" tabindex="-1"
                                                        role="tab">Attachment and Notes</a>
                                                </li>
                                                <!--end:::Tab item History-->
                                            </ul>
                                            <!--end:::Tabs-->

                                            <!--begin:::Tab content -->
                                            <div class="tab-content" id="myTabContent">
                                                <!--Informasi Perusahaan-->
                                                <div class="tab-pane fade show active" id="kt_user_view_overview_tab"
                                                    role="tabpanel">

                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Pengajuan Claim

                                                            <button type="button" class="btn btn-link mx-3 btn-lg"
                                                                id="tambah-pengajuan">+</button>
                                                        </h3>

                                                        <!--begin:Table: Draft Contract-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_pengajuan_claim">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Total</th>

                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @php
                                                                    $approval_claim_array = explode(';', trim($claimContract->approval_claim));
                                                                    array_pop($approval_claim_array);
                                                                @endphp
                                                                @if (count($approval_claim_array) > 0)
                                                                    @foreach ($approval_claim_array as $approval)
                                                                        @php
                                                                            $approval = json_decode($approval);
                                                                        @endphp
                                                                        <tr data-id="{{ $approval[0] }}">
                                                                            <td>
                                                                                <h6><b>{{ $approval[1] }}</b></h6>
                                                                            </td>
                                                                            <td>
                                                                                <h6><b>{{ number_format($approval[2], 0, ',', ',') }}</b>
                                                                                </h6>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    onclick="deleteApprovalClaim(this)"
                                                                                    class="btn btn-sm btn-link">
                                                                                    <i class="bi bi-trash3-fill"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td>
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                            <!--end::Table body-->

                                                        </table>
                                                        <!--End:Table: Draft Contract-->
                                                    </div>
                                                </div>
                                                <!--end:::Tab pane Informasi Perusahaan-->

                                                <!--begin:::Tab pane History-->
                                                <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel">
                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Attachment & Notes

                                                            <button type="button" data-bs-toggle="modal"
                                                                class="btn btn-link mx-3 btn-lg" id="Plus"
                                                                data-bs-target="#kt_modal_create_detail_claim">+</button>
                                                        </h3>

                                                        <!--begin:Table: Draft Contract-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_attachment-notes_claim">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama Dokumen</th>
                                                                    <th class="min-w-auto">Notes</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @forelse ($claimContract->claimDetails as $claimDetail)
                                                                    <tr>
                                                                        <td>
                                                                            <a class="text-hover-primary text-gray-800"
                                                                                href="/document/view/{{ $claimDetail->id_claim_detail }}/{{ $claimDetail->id_document }}">{{ $claimDetail->document_name }}</a>

                                                                        </td>
                                                                        <td>
                                                                            <h6 class="text-gray-800">
                                                                                {{ $claimDetail->document_name }}</h6>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td>
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                            <!--end::Table body-->

                                                        </table>
                                                        <!--End:Table: Draft Contract-->
                                                    </div>
                                                </div>
                                                <!--end:::Tab pane History-->


                                            </div>
                                            <!--end:::Tab content-->

                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Contacts-->
                                </div>
                                {{-- end:: Footer --}}
                            </div>
                        @endisset

                    </div>
        </div>
        </form>
        <!--end::Card body-->
    </div>
    <!--end::Contacts-->
    </div>

    {{-- begin::Modal --}}

    {{-- begin::Calendar --}}
    <!--begin::Modal - Calendar Start -->
    <div class="modal fade" id="kt_modal_calendar" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-300px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Approval Date</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin:: Calendar-->
                    <div class="fv-row mb-5">
                        <div class="calendar" id="approval-date">
                            <div class="calendar__opts">
                                <select name="calendar__month" id="calendar__month">
                                    <option value="1" selected>Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>

                                <select name="calendar__year" id="calendar__year">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option selected>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>

                            <div class="calendar__body">
                                {{-- <div class="calendar__days">
                                <div>M</div>
                                <div>T</div>
                                <div>W</div>
                                <div>T</div>
                                <div>F</div>
                                <div>S</div>
                                <div>S</div>
                            </div> --}}

                                <div class="calendar__dates">
                                    {{-- <div class="calendar__date calendar__date--grey"><span>27</span></div>
                                <div class="calendar__date calendar__date--grey"><span>28</span></div>
                                <div class="calendar__date calendar__date--grey"><span>29</span></div>
                                <div class="calendar__date calendar__date--grey"><span>30</span></div> --}}
                                    <div class="calendar__date"><span>1</span></div>
                                    <div class="calendar__date"><span>2</span></div>
                                    <div class="calendar__date"><span>3</span></div>
                                    <div class="calendar__date"><span>4</span></div>
                                    <div class="calendar__date"><span>5</span></div>
                                    <div class="calendar__date"><span>6</span></div>
                                    <div class="calendar__date"><span>7</span></div>
                                    <div class="calendar__date"><span>8</span></div>
                                    <div class="calendar__date"><span>9</span></div>
                                    <div class="calendar__date"><span>10</span></div>
                                    <div class="calendar__date"><span>11</span></div>
                                    <div class="calendar__date"><span>12</span></div>
                                    <div class="calendar__date"><span>13</span></div>
                                    <div class="calendar__date"><span>14</span></div>
                                    <div class="calendar__date"><span>15</span></div>
                                    <div class="calendar__date">
                                        <span>16</span>
                                    </div>
                                    <div class="calendar__date">
                                        <span>17</span>
                                    </div>
                                    <div class="calendar__date">
                                        <span>18</span>
                                    </div>
                                    <div class="calendar__date"><span>19</span></div>
                                    <div class="calendar__date"><span>20</span></div>
                                    <div class="calendar__date">
                                        <span>21</span>
                                    </div>
                                    <div class="calendar__date"><span>22</span></div>
                                    <div class="calendar__date"><span>23</span></div>
                                    <div class="calendar__date"><span>24</span></div>
                                    <div class="calendar__date"><span>25</span></div>
                                    <div class="calendar__date"><span>26</span></div>
                                    <div class="calendar__date"><span>27</span></div>
                                    <div class="calendar__date"><span>28</span></div>
                                    <div class="calendar__date"><span>29</span></div>
                                    <div class="calendar__date"><span>30</span></div>
                                    <div class="calendar__date"><span>31</span></div>
                                </div>
                            </div>

                            <div class="calendar__buttons">
                                <button class="btn btn-sm fw-normal btn-primary" style="background: #f3f6f9;color:black;"
                                    data-bs-dismiss="modal" id="cancel-date-btn-start">Back</button>

                                <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                                    style="background-color: #e08c16;color: white;" id="set-calendar-start">Apply</button>

                            </div>
                        </div>
                    </div>
                    <!--end::Calendar-->

                </div>
                <!--end::Input group-->

            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Calendar Start -->
    {{-- end::Calendar --}}

    {{-- Begin::Modal - Attachment & Notes --}}
    <div class="modal" id="kt_modal_create_detail_claim" tabindex="-1" aria-modal="true" role="dialog">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Claim Attachment</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                        fill="black"></rect>
                                </svg>
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
                            <form action="/detail-claim/save" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id-claim" value="{{ $claimContract->id_claim ?? 0 }}">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Attachment</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="hidden" value="12312" name="id-contract">
                                <input type="file" class="form-control form-control-solid" name="attach-file-claim-detail"
                                    id="attach-file-claim-detail" value="" style="font-weight: normal" accept=".docx"
                                    placeholder="Name Proyek">
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    name="document-name-claim-detail" id="document-name-claim-detail"
                                    style="font-weight: normal" value="{{ old('document-name-claim-detail') }}"
                                    placeholder="Nama Document">
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="note-claim-detail"
                                    id="note-claim-detail" value="{{ old('note-claim-detail') }}"
                                    style="font-weight: normal" placeholder="Catatan">
                                <!--end::Input-->
                                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                                <div id="froala-editor-claim-detail" class="my-4">
                                    <h1 class="text-center"><b>Attach DOCX format file only</b></h1>
                                </div>

                                <script>
                                    document.getElementById("attach-file-claim-detail").addEventListener("change", async function() {
                                        await readFile(this.files[0], "#froala-editor-claim-detail");
                                    });
                                </script>
                                <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                                    data-bs-dismiss="modal">Save</button>
                            </form>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- End::Modal - Attachment & Notes --}}
    {{-- End::Modal --}}
@endsection
{{-- end::content --}}

@section('aside')
    @include('template.aside')
@endsection

@section('js-script')

    <script>
        let month = 1;
        let year = 2020;
        let date = -1;
        let monthFix = 1;
        let yearFix = 2020;
        let dateFix = -1;

        // Begin Function Calendar Start
        const months = document.querySelector(`#approval-date #calendar__month`);
        const years = document.querySelector(`#approval-date #calendar__year`);
        months.addEventListener("change", elt => {
            month = elt.target.value;
            if (month == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            }
            setDateClickable("#approval-date");
        });
        years.addEventListener("change", elt => {
            year = elt.target.value;
            if (yearEnd == year) {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;


            }
            setDateClickable("#approval-date");
        });

        setDateClickable("#approval-date");

        function setDateClickable(rootElt) {
            const dates = document.querySelectorAll(`${rootElt} .calendar__body .calendar__dates .calendar__date`);
            dates.forEach(elt => {
                elt.addEventListener("click", e => {
                    dates.forEach(d => {
                        if (d.classList.contains("calendar__date--selected")) {
                            d.classList.remove("calendar__date--selected");
                            d.classList.remove("calendar__date--range-end");
                            d.classList.remove("calendar__date--first-date");
                        }
                    });

                    if (elt.classList.contains("calendar__date--selected")) {
                        elt.classList.remove("calendar__date--selected");
                        elt.classList.remove("calendar__date--range-end");
                        elt.classList.remove("calendar__date--first-date");
                    } else {
                        if (rootElt.toString().match("end")) {
                            dateEnd = Number(elt.firstElementChild.innerText);
                            const dateStart = document.querySelectorAll(
                                `#approval-date .calendar__body .calendar__dates .calendar__date`);
                            dateStart.forEach((d, i) => {
                                if (i + 1 == dateEndFix) {
                                    d.classList.add("calendar__date--range-start");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        } else {
                            date = Number(elt.firstElementChild.innerText);
                            const dateEnd = document.querySelectorAll(
                                `#end-date .calendar__body .calendar__dates .calendar__date`);
                            dateEnd.forEach((d, i) => {
                                if (i + 1 <= date && monthEndFix < month) {
                                    // d.classList.add("calendar__date--range-start");
                                    d.classList.add("calendar__date--grey");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        }
                        elt.classList.add("calendar__date--selected");
                        elt.classList.add("calendar__date--range-end");
                        elt.classList.add("calendar__date--first-date");
                    }
                });
            });
        }

        const setCalendarStartBtn = document.querySelector("#set-calendar-start");
        setCalendarStartBtn.addEventListener("click", e => {
            document.querySelector("#approve-date").setAttribute("value",
                `${year}-${month.toString().length < 2 ? month.toString().padStart(2, "0") : month}-${date.toString().length < 2 ? date.toString().padStart(2, "0") : date}`
            );
            dateFix = date;
            monthFix = month;
            yearFix = year;
            let html = ``;
            if (monthEnd == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
            setDateClickable("#end-date");
        })
        // End Function Calendar Start

        // begin reformat number
        function reformatNumber(elt) {
            const valueFormatted = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
            elt.value = valueFormatted;
        }
        // end reformat number

        // begin tambah pengajuan claim
        const plusPengajuanBtn = document.querySelector("#tambah-pengajuan");
        const tablePengajuanClaim = document.querySelector("#kt_customers_pengajuan_claim tbody");
        let isEnteringPengajuanClaim = false;
        plusPengajuanBtn.addEventListener("click", () => {
            if (!isEnteringPengajuanClaim) {
                let html = tablePengajuanClaim.innerHTML;
                const templateHtml = tablePengajuanClaim.innerHTML;

                if (tablePengajuanClaim.firstElementChild.innerText == "There is no data") {
                    html = `
                    <tr class='editable-row'>
                        <td>
                            <input placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-1">
                        </td>
                        <td>
                            <input onkeyup="reformatNumber(this)" placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-2">
                        </td>
                    </tr>`;
                } else {
                    html += `
                    <tr class='editable-row'>
                        <td>
                            <input placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-1">
                        </td>
                        <td>
                            <input onkeyup="reformatNumber(this)" placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-2">
                        </td>
                    </tr>`;
                }
                tablePengajuanClaim.innerHTML = html;
                const input1 = document.querySelector(".claim-input-1");
                const input2 = document.querySelector(".claim-input-2");
                window.scrollTo(0, document.querySelector("body").scrollHeight);
                input1.focus();
                isEnteringPengajuanClaim = true;

                input1.addEventListener("focusout", async e => {
                    const approvalName = e.target.value;
                    if (approvalName) {
                        input2.focus();
                        input2.addEventListener("focusout", async e => {
                            const total = e.target.value;
                            const totalFormattedNumber = Number(total.toString().replaceAll(
                                /[^0-9]/gi, ""));
                            const textFieldTotalClaim = document.querySelector(
                                "#total-claim");
                            if (typeof totalFormattedNumber == "number" || total != "") {
                                const formData = new FormData();
                                const editableRow = document.querySelector(".editable-row");
                                if (approvalName == "") {
                                    editableRow.remove();
                                    return;
                                }
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("approval-claim-name", approvalName);
                                formData.append("total", totalFormattedNumber);
                                formData.append("id_claim",
                                    "{{ $claimContract->id_claim ?? 0 }}");
                                html = `
                                <td>
                                    <h6 class="text-gray-500">${approvalName}</h6>
                                </td>
                                <td>
                                    <h6 class="text-gray-500">${total}</h6>
                                </td>
                                `;
                                editableRow.innerHTML = html;

                                const approvalClaimRes = await fetch(
                                    "/approval-claim/save", {
                                        method: "POST",
                                        header: {
                                            "content-type": "application/json",
                                        },
                                        body: formData,
                                    }).then(res => res.json());

                                if (approvalClaimRes.status == "success") {
                                    console.log(approvalClaimRes);
                                    html = `
                                    <tr data-id="${approvalClaimRes.index_array}">
                                        <td>
                                            <h6 class="text-gray-800">${approvalClaimRes.approval_name}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-gray-800">${total}</h6>
                                        </td>
                                        <td>
                                            <button type="button" onclick="deleteApprovalClaim(this)" class="btn btn-sm btn-link">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                    editableRow.remove();
                                    tablePengajuanClaim.innerHTML += html;
                                    textFieldTotalClaim.value = approvalClaimRes
                                        .nilai_claim;
                                }
                            } else {
                                input2.classList.add("form-invalid");

                            }
                            isEnteringPengajuanClaim = false;
                        });
                    } else {
                        isEnteringPengajuanClaim = false;
                        tablePengajuanClaim.innerHTML = templateHtml;
                    }
                });
            } else {
                isEnteringPengajuanClaim = false;
                return;
            }
        });
        // end tambah pengajuan claim

        // begin stage function
        const stages = document.querySelectorAll(".stage-button");
        stages.forEach((stage, i) => {
            stage.setAttribute("stage", i + 1);
            if (i + 1 <= Number("{{ $claimContract->stages ?? 0 }}")) {
                stage.classList.add("stage-is-done");
                stage.style.cursor = "cursor";
            } else {
                stage.classList.add("stage-is-not-active");
                stage.style.cursor = "cursor";
                if (i > Number("{{ $claimContract->stages ?? 0 }}")) {
                    stage.style.cursor = "not-allowed";
                    stage.style.pointerEvents = "none";
                }

            }

            stage.addEventListener("click", async e => {
                e.stopPropagation();
                const stage = e.target.getAttribute("stage");
                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("stage", stage);
                // formData.append("id", "");
                formData.append("id_claim", "{{ $claimContract->id_claim ?? 0 }}");
                const setStage = await fetch("/claim/stage/save", {
                    method: "POST",
                    body: formData
                }).then(res => res.json());
                if (setStage.status == "success") {
                    // window.location.href = setStage.link;
                    window.location.reload();
                }
            });
        });
        // end stage function

        // begin reformatNumber
        function reformatNumber(elt) {
            const valueFormatted = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
            elt.value = valueFormatted;
        }
        // end reformatNumber

        // start read file function
        // Convert DOCX format to HTML tag
        async function readFile(file, elt) {
            const docx2html = require("docx2html");
            const html = await docx2html(file);
            document.querySelector(` ${elt} > .fr-wrapper > .fr-view`).innerHTML = html;
            document.querySelector(`body > #A`).remove();
            return html;
        };
        // end read file function

        // start initialize Froala Editor
        new FroalaEditor("#froala-editor-claim-detail", {
            documentReady: true,
        });
        // end initialize Froala Editor

        // begin Delete Approval Claim
        async function deleteApprovalClaim(elt) {
            const parentElt = elt.parentElement.parentNode;
            const indexArray = parentElt.getAttribute("data-id");
            const tablePengajuanClaim = document.querySelector("#kt_customers_pengajuan_claim tbody");
            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("index_array", indexArray);
            formData.append("id_claim", "{{ $claimContract->id_claim ?? 0}}");
            const deleteArrayApprovalRes = await fetch("/approval-claim/delete", {
                method: "POST",
                header: {
                    "content-type": "application/json",
                },
                body: formData,
            }).then(res => res.json());
            if (deleteArrayApprovalRes.status == "success") {
                parentElt.remove();
                return;
            }
        }
        // end Delete Approval Claim
    </script>

@endsection
