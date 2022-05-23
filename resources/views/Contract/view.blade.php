@extends('template.header')
@section('title', 'View Contract')
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @extends('template.aside')
            <!--end::Aside-->
            <!--begin::Wrapper-->
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
                                <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                    data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                                    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
                                    data-kt-swapper="true" data-kt-swapper-mode="prepend"
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                                        fill="black" />
                                                    <path
                                                        d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                                        fill="black" />
                                                    <path opacity="0.3"
                                                        d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                                        fill="black" />
                                                    <path opacity="0.3"
                                                        d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                                        fill="black" />
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
                                                            data-bs-toggle="tab"
                                                            href="#kt_topbar_notifications_1">Alerts</a>
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
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                                fill="none">
                                                                                <path opacity="0.3"
                                                                                    d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z"
                                                                                    fill="black" />
                                                                                <path
                                                                                    d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z"
                                                                                    fill="black" />
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
                                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            Hi,<strong>Indar Wiguna</strong>
                                            <img src="../../media/avatars/User-Icon.png" alt="user" />
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
                @if (!isset($contract))

                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Toolbar-->
                        <form action="/contract-management/save" method="post">
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
                                        <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
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
                                                                class="stage-button color-is-default stage-is-done is-done"
                                                                style="outline: 0px; cursor: pointer;">
                                                                Draft
                                                            </a>
                                                            <a href="#"
                                                                class="stage-button color-is-default is-done stage-is-done"
                                                                style="outline: 0px; cursor: pointer;">
                                                                Terkontrak
                                                            </a>
                                                            <a href="#"
                                                                class="stage-button color-is-default is-done stage-is-done"
                                                                style="outline: 0px; cursor: pointer;">
                                                                Pelaksanaan
                                                            </a>
                                                            <a href="#"
                                                                class="stage-button color-is-default is-done stage-is-done"
                                                                style="outline: 0px; cursor: pointer;">
                                                                Addendum Kontrak
                                                            </a>
                                                            <a href="#"
                                                                class="stage-button stage-is-not-active color-is-default"
                                                                style="outline: 0px; cursor: pointer;">
                                                                Serah Terima Pekerjaan
                                                            </a>
                                                            <a href="#"
                                                                class="stage-button stage-is-not-active color-is-default"
                                                                disabled="" style="outline: 0px; cursor: not-allowed;">
                                                                Closing Proyek
                                                            </a>

                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Header Contract-->

                                        <!--begin::Header Contract-->
                                        <div class="col-xl-15">
                                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

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
                                                                    <span class="required">No. Contract</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid"
                                                                    id="number-contract" name="number-contract" value=""
                                                                    placeholder="No. Contract" />
                                                                @error('number-contract')
                                                                    <h6>
                                                                        <b
                                                                            style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group Name-->
                                                        </div>
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <!--begin::Input group Name-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span class="required">Proyek</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="project-id" id="project-id"
                                                                    class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="Pilih Proyek">
                                                                    <option selected>Pilih Proyek...</option>
                                                                    @isset($contracts)
                                                                        @foreach ($contracts as $contract_in_contracts)
                                                                            <option
                                                                                value="{{ $contract_in_contracts->project_id }}"
                                                                                @if (isset($contract)) {{ $contract_in_contracts->project_id == $contract->project_id ? 'selected' : '' }} @endif>
                                                                                {{ $contract_in_contracts->project_id }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endisset
                                                                </select>

                                                                <!--end::Input-->
                                                            </div>
                                                            @error('project-id')
                                                                <h6>
                                                                    <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                </h6>
                                                            @enderror
                                                            <!--end::Input group Name-->
                                                        </div>
                                                    </div>


                                                    <div class="row fv-row">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Tanggal Mulai Kontrak</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="Date"
                                                                    class="form-control form-control-solid ps-12"
                                                                    placeholder="Select a date" value="" name="start-date"
                                                                    id="start-date" />

                                                                @error('start-date')
                                                                    <h6>
                                                                        <b
                                                                            style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
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
                                                                    <span>Tanggal Berakhir Kontrak</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="Date"
                                                                    class="form-control form-control-solid ps-12" value=""
                                                                    placeholder="Select a date" id="due-date"
                                                                    name="due-date" />
                                                                @error('due-date')
                                                                    <h6>
                                                                        <b
                                                                            style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                    </div>


                                                    <div class="row fv-row">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>No. SPK</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="text" class="form-control form-control-solid"
                                                                    name="number-spk" id="number-spk" value=""
                                                                    placeholder="No. SPK" />
                                                                @error('number-spk')
                                                                    <h6>
                                                                        <b
                                                                            style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
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
                                                                    <span>Nilai Kontrak</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="decimal" id="value-contract"
                                                                    class="form-control form-control-solid" name="value"
                                                                    value="" placeholder="Nilai Kontrak" />
                                                                @error('value')
                                                                    <h6>
                                                                        <b
                                                                            style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                    </div>
                                                    <h6 id="status-msg" style="display: none"></h6>

                                                    <!--End begin::Row-->
                                                </div>


                                            </div>
                                        </div>
                                        <!--end::Header Contract-->

                                    </div>
                                </div>
                        </form>
                    </div>
                    <!--end::Card body-->
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


    </div>
    <!--end::Content-->
    </form>
@else
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <form action="/contract-management/update" method="post">
            @csrf
            <!--begin::Toolbar-->
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
                        <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
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

                                <div class="card-body pt-5" style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                    <div class="form-group">

                                        <div id="stage-button" class="stage-list">
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Draft
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Terkontrak
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Pelaksanaan
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Addendum Kontrak
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default"
                                                style="outline: 0px; cursor: pointer;">
                                                Serah Terima Pekerjaan
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default"
                                                style="outline: 0px;">
                                                Closing Proyek
                                            </a>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- begin:: Stages script --}}
                        <script>
                            const stages = document.querySelectorAll(".stage-button");
                            stages.forEach((stage, i) => {
                                stage.setAttribute("stage", i + 1);
                                if (i + 1 <= Number("{{ $contract->stages }}")) {
                                    stage.classList.add("stage-is-done");
                                    stage.style.cursor = "cursor";
                                } else {
                                    stage.classList.add("stage-is-not-active");
                                    stage.style.cursor = "cursor";
                                    if (i > Number("{{ $contract->stages }}")) {
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
                                    formData.append("id_contract", "{{ $contract->id_contract }}");
                                    const setStage = await fetch("/stage/save", {
                                        method: "POST",
                                        body: formData
                                    }).then(res => res.json());
                                    if (setStage.link) {
                                        // window.location.href = setStage.link;
                                        window.location.reload();
                                    }
                                })
                            });
                        </script>
                        {{-- end:: Stages script --}}
                        <!--end::Header Contract-->

                        <!--begin::Header Contract-->
                        <div class="col-xl-15">
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

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
                                                    <span class="required">No. Contract</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    id="number-contract" name="number-contract"
                                                    value="{{ $contract->id_contract ?? '' }}"
                                                    placeholder="No. Contract" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group Name-->
                                        </div>
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Input group Website-->
                                            <!--begin::Input group Name-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="required">Proyek</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="project-id" id="project-id"
                                                    class="form-select form-select-solid" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Pilih Proyek">
                                                    <option selected>Pilih Proyek...</option>
                                                    @isset($contracts)
                                                        @foreach ($contracts as $contract_in_contracts)
                                                            <option value="{{ $contract_in_contracts->project_id }}"
                                                                @if (isset($contract)) {{ $contract_in_contracts->id_contract == $contract->id_contract ? 'selected' : '' }} @endif>
                                                                {{ $contract_in_contracts->project_id }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>

                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group Name-->
                                        </div>
                                    </div>


                                    <div class="row fv-row">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Input group Website-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span>Tanggal Mulai Kontrak</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input type="Date" class="form-control form-control-solid ps-12"
                                                    placeholder="Select a date"
                                                    value="{{ date_format($contract->contract_in ?? now(), 'Y-m-d') }}"
                                                    name="start-date" id="start-date" />

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
                                                    <span>Tanggal Berakhir Kontrak</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="Date" class="form-control form-control-solid ps-12"
                                                    value="{{ date_format($contract->contract_out ?? now(), 'Y-m-d') }}"
                                                    placeholder="Select a date" id="due-date" name="due-date" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--End begin::Col-->
                                    </div>


                                    <div class="row fv-row">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Input group Website-->
                                            <div class="fv-row mb-7">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span>No. SPK</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <input type="text" class="form-control form-control-solid"
                                                    name="number-spk" id="number-spk"
                                                    value="{{ $contract->number_spk ?? 0 }}" placeholder="No. SPK" />

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
                                                    <span>Nilai Kontrak</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="decimal" id="value-contract"
                                                    class="form-control form-control-solid" name="value"
                                                    value="{{ number_format($contract->value ?? 0, 0, ',', ',') }}"
                                                    placeholder="Nilai Kontrak" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            {{-- begin:: Format Money --}}
                                            <script></script>
                                            {{-- end:: Format Money --}}

                                        </div>
                                        <!--End begin::Col-->
                                    </div>
                                    <h6 id="status-msg" style="display: none"></h6>

                                    <!--End begin::Row-->
                                </div>


                            </div>
                        </div>
                        <!--end::Header Contract-->
        </form>
        <!--begin::Content-->
        <div class="col-xl-15">
            <!--begin::Contacts-->
            <div class="card card-flush h-lg-100" id="kt_contacts_main">

                <!--begin::Card body-->
                <div class="card-body pt-5">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        @if ($contract->stages > 0)

                            <!--begin:::Tab item Informasi Perusahaan-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                    href="#kt_user_view_overview_tab" style="font-size:14px;">Tender
                                    Awal</a>
                            </li>
                            <!--end:::Tab item Informasi Perusahaan-->
                        @endif

                        @if ($contract->stages > 1)
                            <!--begin:::Tab item History-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                    data-bs-toggle="tab" href="#kt_user_view_overview_history"
                                    style="font-size:14px;">Tender
                                    Menang</a>
                            </li>
                            <!--end:::Tab item History-->

                        @endif

                        @if ($contract->stages > 2)
                            <!--begin:::Tab item Atachment & Notes-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                    data-bs-toggle="tab" href="#kt_user_view_overview_Performance"
                                    style="font-size:14px;">Pelaksanaan</a>
                            </li>
                            <!--end:::Tab item Atachment & Notes-->

                        @endif

                        @if ($contract->stages > 3)
                            <!--begin:::Tab item Atachment & Notes-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                    data-bs-toggle="tab" href="#kt_user_view_overview_SerahTerima"
                                    style="font-size:14px;">Serah Terima Pekerjaan</a>
                            </li>
                            <!--end:::Tab item Atachment & Notes-->

                        @endif

                    </ul>
                    <!--end:::Tabs-->

                    <!--begin:::Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <!--Informasi Perusahaan-->
                        <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Rekomendasi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="Instansi" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Instansi">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">

                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                            &nbsp;<br>
                            &nbsp;<br>

                            <!--begin::Card title-->
                            <div class="card-title m-0">

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Draft Kontrak
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_proyek">+</a>
                                </h3>
                                @isset($error)
                                    @foreach ($error->all() as $error)
                                        <small style="color: rgb(228, 31, 31)">{{ $error }}</small>
                                    @endforeach

                                @endisset

                                <!--begin:Table: Draft Contract-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen
                                            </th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->draftContracts as $draftContract)
                                                @if ($draftContract->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $draftContract->draft_name }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $draftContract->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($draftContract->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $draftContract->draft_note }}
                                                        </td>
                                                        <!--end::Unit=-->

                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Review
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_review">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->reviewProjects as $reviewProject)
                                                @if ($reviewProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $reviewProject->id_review }}/{{ $reviewProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $reviewProject->document_name_review }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $reviewProject->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($reviewProject->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $reviewProject->note_review }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif

                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Issue Project
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_issue_proyek">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->issueProjects as $issueProject)
                                                @if ($issueProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/${{ $issueProject->id_issue }}/{{ $issueProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $issueProject->document_name_issue }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $issueProject->id_contract }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($issueProject->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $issueProject->draft_note }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Input Resiko
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_risk_proyek">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->inputRisks as $inputRisk)
                                                @if ($inputRisk->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $inputRisk->id_risk }}/{{ $inputRisk->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $inputRisk->document_name_risk }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $inputRisk->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($inputRisk->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $inputRisk->note_risk }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->


                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Daftar Pertanyaan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_question_proyek">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->questionsProjects as $questionProject)
                                                @if ($questionProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $questionProject->document_name_question }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $questionProject->id_contract }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($questionProject->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $questionProject->note_question }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->
                            </div>
                        </div>
                        <!--end:::Tab pane Informasi Perusahaan-->

                        <!--begin:::Tab pane History-->
                        <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel">

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Rekomendasi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="Instansi" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Instansi">
                                            <option></option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-6">

                                    <div class="fv-row mb-7">

                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->

                            &nbsp;<br>
                            &nbsp;<br>

                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Draft Kontrak
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_draft_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen
                                            </th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->draftContracts as $draftContract)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $draftContract->draft_name }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $draftContract->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($draftContract->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $draftContract->draft_note }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Review
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_review_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen
                                            </th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->reviewProjects as $review)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $review->document_name_review }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $review->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($review->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $review->note_review }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td><b>There is no data</b></td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td><b>There is no data</b></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <!--end::Table body-->

                                </table>
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Issue Project
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_issue_project_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->issueProjects as $issue)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $issue->document_name_issue }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $issue->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($issue->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $issue->note_issue }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Input Resiko
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_input_resiko_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->inputRisks as $risk)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $risk->document_name_risk }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $risk->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($risk->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $risk->note_risk }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->


                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Daftar Pertanyaan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_question_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->questionsProjects as $question)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $question->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $question->document_name_question }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $question->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($question->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $question->note_question }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->
                            </div>
                        </div>
                        <!--end:::Tab pane History-->

                        <!--begin:::Tab pane Performance-->
                        <div class="tab-pane fade" id="kt_user_view_overview_Performance" role="tabpanel">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Laporan Bulanan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_laporan_bulanan">+</a>
                                </h3>

                                <!--begin:Table: Laporan Bulanan-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen
                                            </th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->monthlyReports as $monthlyReport)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $monthlyReport->document_name_report }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $monthlyReport->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($monthlyReport->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        {{ $monthlyReport->note_report }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Laporan Bulanan-->
                            </div>
                        </div>
                        <!--end:::Tab pane Performance-->

                        <!--begin:::Tab pane Serah Terima-->
                        <div class="tab-pane fade" id="kt_user_view_overview_SerahTerima" role="tabpanel">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Dokumen Serah Terima Pekerjaan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_serah_terima">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama Dokumen
                                            </th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->handOvers as $hand_over)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $hand_over->id_handover }}/{{ $hand_over->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $hand_over->document_name_terima }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $hand_over->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($hand_over->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        {{ $hand_over->note_terima }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                            </div>
                        </div>
                        <!--end:::Tab pane Serah Terima-->

                    </div>
                    <!--end:::Tab content-->
                    </form>
                </div>
                <!--end::Card body-->
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


    </div>
    <!--end::Content-->
    </div>
    </div>
    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Root-->
@endisset

<!--begin::Modal-->


<!--begin::Modal - Create App-->
<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Create App</h2>
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
            <div class="modal-body py-lg-10 px-lg-10">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                    id="kt_modal_create_app_stepper">
                    <!--begin::Aside-->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <!--begin::Nav-->
                        <div class="stepper-nav ps-lg-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Details</h3>
                                    <div class="stepper-desc">Name your App</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Frameworks</h3>
                                    <div class="stepper-desc">Define your app framework</div>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Database</h3>
                                    <div class="stepper-desc">Select the app database type</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">4</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Billing</h3>
                                    <div class="stepper-desc">Provide payment details</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">5</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Completed</h3>
                                    <div class="stepper-desc">Review and Submit</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 5-->
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid py-lg-5 px-lg-15">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_modal_create_app_form">
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2">
                                            <span class="required">App Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your unique app name"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="name" placeholder="" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Category</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Select your app category"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Options-->
                                        <div class="fv-row">
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Quick Online Courses</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            is just one SEO</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="1" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-danger">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="5" y="5" width="5" height="5" rx="1"
                                                                            fill="#000000" />
                                                                        <rect x="14" y="5" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                        <rect x="5" y="14" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                        <rect x="14" y="14" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Face to Face Discussions</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            is just one aspect</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="2" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-success">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen013.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M20.9 12.9C20.3 12.9 19.9 12.5 19.9 11.9C19.9 11.3 20.3 10.9 20.9 10.9H21.8C21.3 6.2 17.6 2.4 12.9 2V2.9C12.9 3.5 12.5 3.9 11.9 3.9C11.3 3.9 10.9 3.5 10.9 2.9V2C6.19999 2.5 2.4 6.2 2 10.9H2.89999C3.49999 10.9 3.89999 11.3 3.89999 11.9C3.89999 12.5 3.49999 12.9 2.89999 12.9H2C2.5 17.6 6.19999 21.4 10.9 21.8V20.9C10.9 20.3 11.3 19.9 11.9 19.9C12.5 19.9 12.9 20.3 12.9 20.9V21.8C17.6 21.3 21.4 17.6 21.8 12.9H20.9Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M16.9 10.9H13.6C13.4 10.6 13.2 10.4 12.9 10.2V5.90002C12.9 5.30002 12.5 4.90002 11.9 4.90002C11.3 4.90002 10.9 5.30002 10.9 5.90002V10.2C10.6 10.4 10.4 10.6 10.2 10.9H9.89999C9.29999 10.9 8.89999 11.3 8.89999 11.9C8.89999 12.5 9.29999 12.9 9.89999 12.9H10.2C10.4 13.2 10.6 13.4 10.9 13.6V13.9C10.9 14.5 11.3 14.9 11.9 14.9C12.5 14.9 12.9 14.5 12.9 13.9V13.6C13.2 13.4 13.4 13.2 13.6 12.9H16.9C17.5 12.9 17.9 12.5 17.9 11.9C17.9 11.3 17.5 10.9 16.9 10.9Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Full Intro Training</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            copywriting</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="3" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                        <!--end:Options-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Select Framework</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your apps framework"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="fab fa-html5 text-warning fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">HTML5</span>
                                                    <span class="fs-7 text-muted">Base Web Projec</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" checked="checked"
                                                    name="framework" value="1" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="fab fa-react text-success fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">ReactJS</span>
                                                    <span class="fs-7 text-muted">Robust and flexible app
                                                        framework</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="2" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="fab fa-angular text-danger fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Angular</span>
                                                    <span class="fs-7 text-muted">Powerful data mangement</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="3" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="fab fa-vuejs text-primary fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Vue</span>
                                                    <span class="fs-7 text-muted">Lightweight and responsive
                                                        framework</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="4" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="required fs-5 fw-bold mb-2">Database Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="dbname" placeholder="" value="master_db" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Select Database Engine</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Select your app database engine"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="fas fa-database text-success fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">MySQL</span>
                                                    <span class="fs-7 text-muted">Basic MySQL database</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    checked="checked" value="1" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="fab fa-google text-danger fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Firebase</span>
                                                    <span class="fs-7 text-muted">Google based app data
                                                        management</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    value="2" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="fab fa-amazon text-warning fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">DynamoDB</span>
                                                    <span class="fs-7 text-muted">Amazon Fast NoSQL Database</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    value="3" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                            <span class="required">Name On Card</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify a card holder's name"></i>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder=""
                                            name="card_name" value="Max Doe" />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-bold form-label mb-2">Card Number</label>
                                        <!--end::Label-->
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative">
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter card number" name="card_number"
                                                value="4111 1111 1111 1111" />
                                            <!--end::Input-->
                                            <!--begin::Card logos-->
                                            <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                <img src="../../../media/svg/card-logos/visa.svg" alt=""
                                                    class="h-25px" />
                                                <img src="../../../media/svg/card-logos/mastercard.svg" alt=""
                                                    class="h-25px" />
                                                <img src="../../../media/svg/card-logos/american-express.svg" alt=""
                                                    class="h-25px" />
                                            </div>
                                            <!--end::Card logos-->
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-10">
                                        <!--begin::Col-->
                                        <div class="col-md-8 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold form-label mb-2">Expiration
                                                Date</label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row fv-row">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_month"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Month">
                                                        <option></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_year"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Year">
                                                        <option></option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">CVV</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                    title="Enter a card CVV code"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative">
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    minlength="3" maxlength="4" placeholder="CVV" name="card_cvv" />
                                                <!--end::Input-->
                                                <!--begin::CVV icon-->
                                                <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                                    <span class="svg-icon svg-icon-2hx">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path d="M22 7H2V11H22V7Z" fill="black" />
                                                            <path opacity="0.3"
                                                                d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::CVV icon-->
                                            </div>
                                            <!--end::Input wrapper-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-bold form-label">Save Card for further
                                                billing?</label>
                                            <div class="fs-7 fw-bold text-muted">If you need more info, please check
                                                budget planning</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                checked="checked" />
                                            <span class="form-check-label fw-bold text-muted">Save Card</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100 text-center">
                                    <!--begin::Heading-->
                                    <h1 class="fw-bolder text-dark mb-3">Release!</h1>
                                    <!--end::Heading-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-bold fs-3">Submit your app to kickstart your project.
                                    </div>
                                    <!--end::Description-->
                                    <!--begin::Illustration-->
                                    <div class="text-center px-4 py-15">
                                        <img src="../../media/illustrations/sketchy-1/9.png" alt=""
                                            class="w-100 mh-300px" />
                                    </div>
                                    <!--end::Illustration-->
                                </div>
                            </div>
                            <!--end::Step 5-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-10">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                        data-kt-stepper-action="previous">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                        <span class="svg-icon svg-icon-3 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1"
                                                    fill="black" />
                                                <path
                                                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-lg btn-primary"
                                        data-kt-stepper-action="submit">
                                        <span class="indicator-label">Submit
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                        transform="rotate(-180 18 13)" fill="black" />
                                                    <path
                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="indicator-progress">Please wait...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-lg btn-primary"
                                        data-kt-stepper-action="next">Continue
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-3 ms-1 me-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="black" />
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->

<!--begin::Modal - Serah Terima Pekerjaan-->
<div class="modal fade" id="kt_modal_serah_terima" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Attachment</h2>
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

                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/serah-terima/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" style="font-weight: normal" class="form-control form-control-solid"
                            name="attach-file-terima" id="attach-file-terima" value="" accept=".docx"
                            placeholder="Name terima" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-terima"
                            id="document-name-terima" value="" style="font-weight: normal"
                            placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" style="font-weight: normal" class="form-control form-control-solid"
                            name="note-terima" id="note-terima" value="" placeholder="Catatan" />
                        <!--end::Input-->
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-terima">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        <script>
                            var editor = new FroalaEditor('#froala-editor-terima', {
                                documentReady: true,
                            });
                        </script>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-terima").addEventListener("change", function() {
                                readFile(this.files[0], "#froala-editor-terima");
                            });
                        </script>
                        {{-- end::Read File --}}
                </div>
                <!--end::Input group-->

                <button type="submit" id="save-terima" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>
                </form>


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Serah Terima Pekerjaan-->

<!--begin::Modal - Draft Contract-->
<div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Attachment</h2>
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

                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/draft-contract/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid" name="attach-file-draft"
                            id="attach-file-draft" value="" style="font-weight: normal" accept=".docx"
                            placeholder="Name draft" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-draft"
                            id="document-name-draft" value="" style="font-weight: normal" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-draft" id="note-draft"
                            value="" placeholder="Catatan" style="font-weight: normal" />
                        <!--end::Input-->
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-draft">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        <script>
                            var editor = new FroalaEditor('#froala-editor-draft', {
                                documentReady: true,
                            });
                        </script>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-draft").addEventListener("change", function() {
                                readFile(this.files[0], "#froala-editor-draft");
                            });
                        </script>
                        {{-- end::Read File --}}
                </div>
                <!--end::Input group-->

                <button type="submit" id="save-draft" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>
                </form>


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Draft Contract-->

@if ($contract->stages > 1)

    <!--begin::Modal - Draft Contract Tender Menang-->
    <div class="modal fade" id="kt_modal_draft_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/draft-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid" name="attach-file-draft-menang"
                                id="attach-file-draft" style="font-weight: normal" value="" accept=".docx"
                                placeholder="Name draft" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-draft"
                                id="document-name-draft" style="font-weight: normal" value=""
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-draft"
                                id="note-draft" value="" placeholder="Catatan" style="font-weight: normal" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-draft-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-draft-menang', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-draft-menang").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-draft-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-draft-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Draft Contract Tender Menang-->

    <!--begin::Modal - Review Tender Menang-->
    <div class="modal fade" id="kt_modal_review_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal" class="form-control form-control-solid"
                                name="attach-file-review-menang" id="attach-file-review" value="" accept=".docx"
                                placeholder="Name review" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-review"
                                id="document-name-review" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-review"
                                id="note-review" value="" style="font-weight: normal" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-review-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-review-menang', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-review-menang").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-review-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Review Tender Menang-->

    <!--begin::Modal - Issue Project Tender Menang-->
    <div class="modal fade" id="kt_modal_issue_project_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/issue-project/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid"
                                name="attach-file-issue-project-menang" id="attach-file-issue-project-menang"
                                style="font-weight: normal" value="" accept=".docx"
                                placeholder="Name issue-project-menang" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name-issue-project-menang" id="document-name-issue-project-menang"
                                style="font-weight: normal" value="" placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-issue-project-menang"
                                id="note-issue-project-menang" value="" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-issue-project-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-issue-project-menang', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-issue-project-menang").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-issue-project-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-issue-project-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Issue Project Tender Menang-->

    <!--begin::Modal - Input Resiko Tender Menang-->
    <div class="modal fade" id="kt_modal_input_resiko_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid" name="attach-file-risk-menang"
                                id="attach-file-risk" value="" style="font-weight: normal" accept=".docx"
                                placeholder="Name risk" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-risk-menang"
                                id="document-name-risk" style="font-weight: normal" value=""
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-risk" id="note-risk"
                                value="" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-risk-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-risk-menang', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-risk-menang").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-risk-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-risk-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Input Resiko Tender Menang-->

    <!--begin::Modal - Question Tender Menang-->
    <div class="modal fade" id="kt_modal_question_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/question/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid"
                                name="attach-file-question-menang" id="attach-file-question" value="" accept=".docx"
                                placeholder="Name draft" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-question"
                                id="document-name-question" style="font-weight: normal" value=""
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" style="font-weight: normal" class="form-control form-control-solid"
                                name="note-question" id="note-question" value="" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-question-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-question-menang', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-question-menang").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-question-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-question-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Question Tender Menang-->
@endif

<!--begin::Modal - Laporan Bulanan-->
<div class="modal fade" id="kt_modal_laporan_bulanan" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Attachment</h2>
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

                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/laporan-bulanan/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid" name="attach-file-bulanan"
                            id="attach-file-bulanan" value="" style="font-weight: normal" accept=".docx"
                            placeholder="Name draft" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-bulanan"
                            id="document-name-bulanan" value="" style="font-weight: normal"
                            placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-bulanan"
                            id="note-bulanan" value="" style="font-weight: normal" placeholder="Catatan" />
                        <!--end::Input-->
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-bulanan">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        <script>
                            var editor = new FroalaEditor('#froala-editor-bulanan-menang', {
                                documentReady: true,
                            });
                        </script>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-bulanan").addEventListener("change", function() {
                                readFile(this.files[0], "#froala-editor-bulanan-menang");
                            });
                        </script>
                        {{-- end::Read File --}}
                </div>
                <!--end::Input group-->

                <button type="submit" id="save-bulanan-tender-menang" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>
                </form>


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Laporan Bulanan-->

<!--end::Modals-->

<!--begin::Modal - Issue Project-->
<div class="modal fade" id="kt_modal_issue_proyek" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Issue Proyek</h2>
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

                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/issue-project/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid" name="attach-file-issue"
                            id="attach-file-issue" value="" style="font-weight: normal" accept=".docx"
                            placeholder="Name Proyek" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-issue"
                            id="document-name-issue" style="font-weight: normal" value="" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-issue" id="note-issue"
                            value="" placeholder="Catatan" style="font-weight: normal" />
                        <!--end::Input-->
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-issue">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        <script>
                            var editor = new FroalaEditor('#froala-editor-issue', {
                                documentReady: true,
                            });
                        </script>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-issue").addEventListener("change", function() {
                                readFile(this.files[0], "#froala-editor-issue");
                            });
                        </script>
                        {{-- end::Read File --}}

                        <button type="submit" class="btn btn-lg btn-primary" data-bs-dismiss="modal">Save
                    </form>
                </div>
                <!--end::Input group-->



            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<!--end::Modal - Issue Project-->
<!--begin::Modal - Review-->
<div class="modal fade" id="kt_modal_create_review" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Review</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract-review">
                            <input type="hidden" value="{{ csrf_token() }}" id="csrf_token_file_review">
                            <input type="file" class="form-control form-control-solid" name="attach-file-review"
                                id="attach-file-review" value="" style="font-weight: normal" accept=".docx"
                                placeholder="Name Proyek" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-review"
                                id="document-name-review" style="font-weight: normal" value=""
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-review"
                                id="note-review" value="" style="font-weight: normal" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-review">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            <script>
                                var editor = new FroalaEditor('#froala-editor-review', {
                                    documentReady: true,
                                });
                            </script>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-review").addEventListener("change", function() {
                                    readFile(this.files[0], "#froala-editor-review");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>

                    </form>

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
<!--end::Modal - Review-->

<!--begin::Modal - Risk Project-->
<div class="modal fade" id="kt_modal_risk_proyek" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Resiko Proyek</h2>
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

                <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                    <input type="file" class="form-control form-control-solid" name="attach-file-risk"
                        id="attach-file-risk" style="font-weight: normal" value="" accept=".docx"
                        placeholder="Name Proyek" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="document-name-risk"
                        id="document-name-risk" style="font-weight: normal" value="" placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="note-risk" id="note-risk" value=""
                        placeholder="Catatan" style="font-weight: normal" />
                    <!--end::Input-->
                    <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-risk">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>
                    <script>
                        var editor = new FroalaEditor('#froala-editor-risk', {
                            documentReady: true,
                        });
                    </script>
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        document.getElementById("attach-file-risk").addEventListener("change", function() {
                            readFile(this.files[0], "#froala-editor-risk");
                        });
                    </script>
                    {{-- end::Read File --}}
                    <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>

                </form>
            </div>
            <!--end::Input group-->


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Add Risk Project-->

<!--begin::Modal - List Questions-->
<div class="modal fade" id="kt_modal_question_proyek" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Question</h2>
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

                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/question/upload" enctype="multipart/form-data" method="POST">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid" name="attach-file-question"
                            id="attach-file-question" value="" style="font-weight: normal" accept=".docx"
                            placeholder="Name Proyek" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-question"
                            id="document-name-question" style="font-weight: normal" value=""
                            placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-question"
                            id="note-question" style="font-weight: normal" value="" placeholder="Catatan" />
                        <!--end::Input-->
                        <small id="file-error-msg-question" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-question">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        <script>
                            var editor = new FroalaEditor('#froala-editor-question', {
                                documentReady: true,
                            });
                        </script>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-question").addEventListener("change", function() {
                                readFile(this.files[0], "#froala-editor-question");
                            });
                        </script>
                        {{-- end::Read File --}}
                        <button type="submit" id="save-question" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Input group-->


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - List Questions-->

<!--end::Modals-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
            <path
                d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                fill="black" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
@endsection
<script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script>
@extends('template.footer')
