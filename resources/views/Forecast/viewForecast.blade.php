{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}


{{-- Begin::Title --}}
@section('title', 'View Forecast')
{{-- End::Title --}}

<!--begin::Main-->
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
                                                style="background-image:url('{{ asset('media/misc/pattern-1.jpg') }}')">
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
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none">
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

                {{-- begin:: Toaster Notification --}}
                <div aria-live="polite" aria-atomic="true" class="position-sticky mx-5" style="z-index: 999">
                    <div class="toast-container top-0 end-0">
                        <div class="toast fade align-items-center text-bg-success border-0 " role="alert"
                            aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body text-white">
                                    Hello, world! This is a toast message.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end:: Toaster Notification --}}


                <!--begin::Form-->
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf


                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Toolbar-->
                        <div style=" height:100px"class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 row">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Forecast
                                    </h1>
                                    <div>
                                        {{-- begin::Tabs Forecast --}}
                                        <ul
                                            class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold">
                                            <!--begin:::Tab item Forecast Bulanan-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                    href="#kt_user_view_overview_forecast_bulanan"
                                                    style="font-size:14px;">Forecast
                                                    Bulanan</a>
                                            </li>
                                            <!--end:::Tab item Forecast Bulanan-->

                                            <!--begin:::Tab item Forecast Internal-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_forecast_internal"
                                                    style="font-size:14px;">Forecast Internal</a>
                                            </li>
                                            <!--end:::Tab item Forecast Internal-->

                                            <!--begin:::Tab item Forecast S/D-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_forecast_sd"
                                                    style="font-size:14px;">Forecast S/D</a>
                                            </li>
                                            <!--end:::Tab item Forecast S/D-->

                                        </ul>
                                        {{-- end::Tabs Forecast --}}
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Toolbar-->






                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid mt-15" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container"
                                style="overflow: auto; background-color:white; white-space: nowrap;">
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="">

                                    <!--begin::All Content-->
                                    <div class="col-xl-15">

                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">


                                            <!--begin::Card body-->
                                            <div class="card-body" style="background-color: white;">

                                                <div class="tab-content" id="myTabContent">
                                                    {{-- begin::Tab Forecast Bulanan --}}
                                                    <div class="tab-pane fade show active"
                                                        id="kt_user_view_overview_forecast_bulanan" role="tabpanel">
                                                        <!--begin::Table Forecast-->
                                                        <table class="table align-middle table-row-dashed fs-6"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <tr
                                                                    style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                    <th class="min-w-auto" rowspan="2"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                        <!--Begin::Svg Icon and Input Searc-->
                                                                        <span
                                                                            class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                            <i class="bi bi-search"></i>
                                                                        </span>
                                                                        <input type="text"
                                                                            data-kt-customer-table-filter="search"
                                                                            class="form-control form-control w-250px ps-15"
                                                                            placeholder="Search" /><br>
                                                                        <!--end::Svg Icon and Input Searc-->
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Januari</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Februari</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Maret</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>April</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Mei</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Juni</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Juli</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Agustus</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>September</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Oktober</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>November</center>
                                                                    </th>
                                                                    <th class="min-w-auto" colspan="3">
                                                                        <center>Desember</center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-auto"
                                                                        colspan="3">
                                                                        <center>Total &nbsp;&nbsp; <i
                                                                                class="bi bi-pin-angle-fill"
                                                                                onclick="hidePin()"></i></center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-auto"
                                                                        colspan="3"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center>Total &nbsp;&nbsp; <i
                                                                                class="bi bi-pin-fill text-primary"
                                                                                onclick="hidePin()"></i></center>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <!--begin::Sub-Judul Januari-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Januari-->
                                                                    <!--begin::Sub-Judul Februari-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Februari-->
                                                                    <!--begin::Sub-Judul Maret-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Maret-->
                                                                    <!--begin::Sub-Judul April-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul April-->
                                                                    <!--begin::Sub-Judul Mei-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Mei-->
                                                                    <!--begin::Sub-Judul Juni-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Juni-->
                                                                    <!--begin::Sub-Judul Juli-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Juli-->
                                                                    <!--begin::Sub-Judul Agustus-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Agustus-->
                                                                    <!--begin::Sub-Judul September-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul September-->
                                                                    <!--begin::Sub-Judul Oktober-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Oktober-->
                                                                    <!--begin::Sub-Judul November-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul November-->
                                                                    <!--begin::Sub-Judul Desember-->
                                                                    <th class="min-w-125px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="min-w-125px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Desember-->
                                                                    <!--begin::Sub-Judul Total-->
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="pinForecast HidePin min-w-100px">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center>OK</center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        <center>Forecast</center>
                                                                    </th>
                                                                    <th class="pinForecast ShowPin min-w-100px"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center>Realisasi <a href="#" Id="Plus"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                        </center>
                                                                    </th>
                                                                    <!--end::Sub-Judul Total-->
                                                                </tr>
                                                                <!--end::Table head-->
                                                            </thead>

                                                            <!--begin::Table body-->

                                                            <tbody class="fw-bold text-gray-600" id="table-body">

                                                                @php
                                                                    $month_counter = 1;
                                                                    $is_data_found = false;
                                                                    $total_ok = 0;
                                                                    $total_year_ok = 0;
                                                                    $total_forecast = 0;
                                                                    $total_month_forecast = 0;
                                                                    $total_year_forecast = 0;
                                                                    $index = 1;
                                                                @endphp
                                                                @foreach ($dops as $dop)
                                                                    @if (count($dop->UnitKerjas) > 0)
                                                                        {{-- @foreach ($proyeks as $proyek) --}}

                                                                        <tr style="text-align: right; ">

                                                                            @php
                                                                                $dop_name = str_replace(' ', '-', $dop->dop);
                                                                            @endphp
                                                                            <td
                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                <a name="collalpse1" class=""
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#{{ $dop_name }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="{{ $dop_name }} ">
                                                                                    <i class="bi bi-chevron-down"></i>
                                                                                    {{-- {{ $dop->dop }} --}}
                                                                                    {{ $dop->dop }}
                                                                                </a>
                                                                            </td>

                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Total Coloumn-->
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                -</td>
                                                                            <!--end::Total Coloumn-->

                                                                        </tr>

                                                                        {{-- begin:: Foreach Unit Kerja --}}
                                                                        @foreach ($dop->UnitKerjas as $unitKerja)
                                                                            @if (count($unitKerja->proyeks) > 0)
                                                                                <tr class="collapse accordion-header"
                                                                                    id="{{ $dop_name }}"
                                                                                    style="text-align: right;">
                                                                                    <td
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                        <!--begin::Child=-->
                                                                                        <a class="ms-6" type="button"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="{{ $unitKerja->divcode }}">
                                                                                            <i
                                                                                                class="bi bi-chevron-down"></i>
                                                                                            {{ $unitKerja->unit_kerja }}
                                                                                        </a>
                                                                                        <!--end::Child=-->
                                                                                    </td>
                                                                                    <!--begin::Januari Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Januari Coloumn-->
                                                                                    <!--begin::Februari Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Februari Coloumn-->
                                                                                    <!--begin::Maret Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Maret Coloumn-->
                                                                                    <!--begin::April Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::April Coloumn-->
                                                                                    <!--begin::Mei Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Mei Coloumn-->
                                                                                    <!--begin::Juni Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Juni Coloumn-->
                                                                                    <!--begin::Juli Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Juli Coloumn-->
                                                                                    <!--begin::Agustus Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Agustus Coloumn-->
                                                                                    <!--begin::September Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::September Coloumn-->
                                                                                    <!--begin::Oktober Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Oktober Coloumn-->
                                                                                    <!--begin::November Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::November Coloumn-->
                                                                                    <!--begin::Desember Coloumn-->
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <td>-</td>
                                                                                    <!--end::Desember Coloumn-->
                                                                                    <!--begin::Total Coloumn-->
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast HidePin">-</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        -</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        -</td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        -</td>
                                                                                    <!--end::Total Coloumn-->
                                                                                </tr>
                                                                                {{-- begin:: Foreach Proyek --}}
                                                                                @foreach ($unitKerja->proyeks as $proyek)
                                                                                    <tr id="{{ $unitKerja->divcode }}"
                                                                                        class="collapse"
                                                                                        aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                        data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                        style="text-align: right;">
                                                                                        <td
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                            <!--begin::Child=-->
                                                                                            <p class="ms-12">
                                                                                                {{ $proyek->nama_proyek }}
                                                                                            </p>
                                                                                            <!--end::Child=-->
                                                                                        </td>

                                                                                        @for ($i = 0; $i < 12; $i++)
                                                                                            @if ($index > 3)
                                                                                                @php
                                                                                                    $index = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                            @foreach ($proyek->Forecasts as $forecast)
                                                                                                @if ($forecast->month_forecast == $i + 1)
                                                                                                    @php
                                                                                                        // if ($index % 2 == 0) {
                                                                                                        // }
                                                                                                        $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                        // $total_ok += (int)
                                                                                                    @endphp
                                                                                                    <td>{{ $proyek->nilai_rkap }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            data-id-proyek="{{ $proyek->id }}"
                                                                                                            data-month="{{ $month_counter }}"
                                                                                                            data-column-forecast="{{ $month_counter }}"
                                                                                                            class="form-control"
                                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                            id="nilai-forecast"
                                                                                                            name="nilai-forecast"
                                                                                                            onkeyup="reformatNumber(this)"
                                                                                                            value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                            placeholder=". . . , -" />
                                                                                                    </td>
                                                                                                    <td>10000</td>
                                                                                                    @php
                                                                                                        $is_data_found = true;
                                                                                                    @endphp
                                                                                                @break
                                                                                            @endif
                                                                                            @php
                                                                                                $index++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                        @if (!$is_data_found)
                                                                                            <td>{{ $proyek->nilai_rkap }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text"
                                                                                                    data-id-proyek="{{ $proyek->id }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value=""
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            <td>100000</td>
                                                                                        @endif
                                                                                        @php
                                                                                            $is_data_found = false;
                                                                                            $month_counter++;
                                                                                        @endphp
                                                                                    @endfor
                                                                                    <!--begin::Total Coloumn-->
                                                                                    <td class="pinForecast HidePin">
                                                                                        <center>
                                                                                            <b>{{ $total_ok }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin"
                                                                                        data-id-proyek="{{ $proyek->id }}">
                                                                                        <center>
                                                                                            <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin">
                                                                                        <center><b>2,666,664</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <center>
                                                                                            <b>{{ $proyek->nilai_rkap }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin total-month-x-forecast"
                                                                                        data-id-proyek="{{ $proyek->id }}"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <center>
                                                                                            <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <center><b>2,666,664</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <!--end::Total Coloumn-->
                                                                            @endforeach
                                                                            {{-- end:: Foreach Proyek --}}
                                                                        @endif
                                                                        @php
                                                                            $total_year_forecast += $total_forecast;
                                                                            $total_forecast = 0;
                                                                            $month_counter = 1;
                                                                        @endphp
                                                                    @endforeach
                                                                    {{-- end:: Foreach Unit Kerja --}}
                                                                @endif
                                                            @endforeach

                                                        <tfoot
                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                            <div class="m-4">
                                                                <tr>
                                                                    <td
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                        <!--begin::Child=-->
                                                                        Total
                                                                        <!--end::Child=-->
                                                                    </td>
                                                                    @for ($i = 0; $i < 12; $i++)
                                                                        <td>
                                                                            <center><b>10000</b></center>
                                                                        </td>
                                                                        <td
                                                                            data-total-forecast-column={{ $i + 1 }}>

                                                                        </td>
                                                                        <td>
                                                                            <center><b>10000</b></center>
                                                                        </td>
                                                                    @endfor
                                                                    {{-- begin::Total Year --}}
                                                                    <td class="pinForecast HidePin">
                                                                        <center>{{ $proyek->nilai_rkap }}</center>
                                                                    </td>
                                                                    <td
                                                                        class="pinForecast HidePin total-year-forecast-bulanan">
                                                                        <center>
                                                                            <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast HidePin">
                                                                        <center><b>2,666,664</b></center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        <center><b>{{ $proyek->nilai_rkap }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin total-year-forecast-bulanan"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        <center>
                                                                            <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                        </center>
                                                                    </td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        <center><b>2,666,664</b></center>
                                                                    </td>
                                                                    {{-- end::Total Year --}}
                                                                </tr>
                                                            </div>
                                                        </tfoot>

                                                        </tbody>

                                                        {{-- @endforeach --}}
                                                    </table>
                                                </div>
                                                <!--end::Table body-->
                                                <!--end:::Tab Forecast Bulanan-->

                                                <!--begin:::Tab pane Forecast Internal-->
                                                <div class="tab-pane fade"
                                                    id="kt_user_view_overview_forecast_internal" role="tabpanel">
                                                    <table class="table align-middle table-row-dashed fs-6"
                                                        id="kt_customers_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr
                                                                style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                                <th class="min-w-auto" rowspan="2"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                    <!--Begin::Svg Icon and Input Searc-->
                                                                    <span
                                                                        class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                        <i class="bi bi-search"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        data-kt-customer-table-filter="search"
                                                                        class="form-control form-control w-250px ps-15"
                                                                        placeholder="Search" /><br>
                                                                    <!--end::Svg Icon and Input Searc-->
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Januari</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Februari</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Maret</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>April</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Mei</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Juni</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Juli</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Agustus</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>September</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Oktober</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>November</center>
                                                                </th>
                                                                <th class="min-w-auto" colspan="3">
                                                                    <center>Desember</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-auto"
                                                                    colspan="3">
                                                                    <center>Total &nbsp;&nbsp; <i
                                                                            class="bi bi-pin-angle-fill"
                                                                            onclick="hidePin()"></i></center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-auto"
                                                                    colspan="3"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center>Total &nbsp;&nbsp; <i
                                                                            class="bi bi-pin-fill text-primary"
                                                                            onclick="hidePin()"></i></center>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <!--begin::Sub-Judul Januari-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Januari-->
                                                                <!--begin::Sub-Judul Februari-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Februari-->
                                                                <!--begin::Sub-Judul Maret-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Maret-->
                                                                <!--begin::Sub-Judul April-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul April-->
                                                                <!--begin::Sub-Judul Mei-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Mei-->
                                                                <!--begin::Sub-Judul Juni-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Juni-->
                                                                <!--begin::Sub-Judul Juli-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Juli-->
                                                                <!--begin::Sub-Judul Agustus-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Agustus-->
                                                                <!--begin::Sub-Judul September-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul September-->
                                                                <!--begin::Sub-Judul Oktober-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Oktober-->
                                                                <!--begin::Sub-Judul November-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul November-->
                                                                <!--begin::Sub-Judul Desember-->
                                                                <th class="min-w-125px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="min-w-125px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Desember-->
                                                                <!--begin::Sub-Judul Total-->
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="pinForecast HidePin min-w-100px">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                    <center>OK</center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                    <center>Forecast</center>
                                                                </th>
                                                                <th class="pinForecast ShowPin min-w-100px"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center>Realisasi <a href="#" Id="Plus"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                    </center>
                                                                </th>
                                                                <!--end::Sub-Judul Total-->
                                                            </tr>
                                                            <!--end::Table head-->
                                                        </thead>

                                                        <!--begin::Table body-->

                                                        <tbody class="fw-bold text-gray-600" id="table-body">

                                                            @php
                                                                $month_counter = 1;
                                                                $is_data_found = false;
                                                                $total_ok = 0;
                                                                $total_year_ok = 0;
                                                                $total_forecast = 0;
                                                                $total_month_forecast = 0;
                                                                $total_year_forecast = 0;
                                                                $index = 1;
                                                            @endphp
                                                            @foreach ($dops as $dop)
                                                                @if (count($dop->UnitKerjas) > 0)
                                                                    {{-- @foreach ($proyeks as $proyek) --}}

                                                                    <tr style="text-align: right; ">
                                                                        @php
                                                                            $dop_name = str_replace(' ', '-', $dop->dop);
                                                                        @endphp
                                                                        <td
                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                            <a name="collalpse1" class=""
                                                                                data-bs-toggle="collapse"
                                                                                href="#{{ $dop_name }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="{{ $dop_name }} ">
                                                                                <i class="bi bi-chevron-down"></i>
                                                                                {{-- {{ $dop->dop }} --}}
                                                                                {{ $dop->dop }}
                                                                            </a>
                                                                        </td>

                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Januari Coloumn-->
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <td>-</td>
                                                                        <!--end::Januari Coloumn-->
                                                                        <!--begin::Total Coloumn-->
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast HidePin">-</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                            -</td>
                                                                        <td class="pinForecast ShowPin"
                                                                            style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                            -</td>
                                                                        <!--end::Total Coloumn-->

                                                                    </tr>

                                                                    {{-- begin:: Foreach Unit Kerja --}}
                                                                    @foreach ($dop->UnitKerjas as $unitKerja)
                                                                        @if (count($unitKerja->proyeks) > 0)
                                                                            <tr class="collapse accordion-header"
                                                                                id="{{ $dop_name }}"
                                                                                style="text-align: right;">
                                                                                <td
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                    <!--begin::Child=-->
                                                                                    <a class="ms-6" type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="{{ $unitKerja->divcode }}">
                                                                                        <i
                                                                                            class="bi bi-chevron-down"></i>
                                                                                        {{ $unitKerja->unit_kerja }}
                                                                                    </a>
                                                                                    <!--end::Child=-->
                                                                                </td>
                                                                                <!--begin::Januari Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Januari Coloumn-->
                                                                                <!--begin::Februari Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Februari Coloumn-->
                                                                                <!--begin::Maret Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Maret Coloumn-->
                                                                                <!--begin::April Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::April Coloumn-->
                                                                                <!--begin::Mei Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Mei Coloumn-->
                                                                                <!--begin::Juni Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Juni Coloumn-->
                                                                                <!--begin::Juli Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Juli Coloumn-->
                                                                                <!--begin::Agustus Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Agustus Coloumn-->
                                                                                <!--begin::September Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::September Coloumn-->
                                                                                <!--begin::Oktober Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Oktober Coloumn-->
                                                                                <!--begin::November Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::November Coloumn-->
                                                                                <!--begin::Desember Coloumn-->
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <td>-</td>
                                                                                <!--end::Desember Coloumn-->
                                                                                <!--begin::Total Coloumn-->
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast HidePin">-
                                                                                </td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                    -</td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                    -</td>
                                                                                <td class="pinForecast ShowPin"
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                    -</td>
                                                                                <!--end::Total Coloumn-->
                                                                            </tr>
                                                                            {{-- begin:: Foreach Proyek --}}
                                                                            @foreach ($unitKerja->proyeks as $proyek)
                                                                                @if ($proyek->jenis_proyek == 'I')
                                                                                    <tr id="{{ $unitKerja->divcode }}"
                                                                                        class="collapse"
                                                                                        aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                        data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                        style="text-align: right;">
                                                                                        <td
                                                                                            style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                            <!--begin::Child=-->
                                                                                            <p class="ms-12">
                                                                                                {{ $proyek->nama_proyek }}
                                                                                            </p>
                                                                                            <!--end::Child=-->
                                                                                        </td>

                                                                                        @for ($i = 0; $i < 12; $i++)
                                                                                            @if ($index > 3)
                                                                                                @php
                                                                                                    $index = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                            @foreach ($proyek->Forecasts as $forecast)
                                                                                                @if ($forecast->month_forecast == $i + 1)
                                                                                                    @php
                                                                                                        // if ($index % 2 == 0) {
                                                                                                        // }
                                                                                                        $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                        // $total_ok += (int)
                                                                                                    @endphp
                                                                                                    <td>{{ $proyek->nilai_rkap }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            data-id-proyek-forecast-internal="{{ $proyek->id }}"
                                                                                                            data-month="{{ $month_counter }}"
                                                                                                            data-column-forecast-internal="{{ $month_counter }}"
                                                                                                            class="form-control"
                                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                            id="nilai-forecast"
                                                                                                            name="nilai-forecast"
                                                                                                            onkeyup="reformatNumber(this)"
                                                                                                            value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                            placeholder=". . . , -" />
                                                                                                    </td>
                                                                                                    <td>10000</td>
                                                                                                    @php
                                                                                                        $is_data_found = true;
                                                                                                    @endphp
                                                                                                @break
                                                                                            @endif
                                                                                            @php
                                                                                                $index++;
                                                                                            @endphp
                                                                                        @endforeach
                                                                                        @if (!$is_data_found)
                                                                                            <td>10000</td>
                                                                                            <td>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    data-id-proyek-forecast-internal="{{ $proyek->id }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast-internal="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value=""
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            <td>100000</td>
                                                                                        @endif
                                                                                        @php
                                                                                            $is_data_found = false;
                                                                                            $month_counter++;
                                                                                        @endphp
                                                                                    @endfor
                                                                                    <!--begin::Total Coloumn-->
                                                                                    <td
                                                                                        class="pinForecast HidePin">
                                                                                        <center>
                                                                                            <b>{{ $total_ok }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast HidePin"
                                                                                        data-id-proyek-forecast-internal="{{ $proyek->id }}">
                                                                                        <center>
                                                                                            <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td
                                                                                        class="pinForecast HidePin">
                                                                                        <center><b>2,666,664</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                        <center>
                                                                                            <b>{{ $proyek->nilai_rkap }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin total-month-x-forecast"
                                                                                        data-id-proyek-forecast-internal="{{ $proyek->id }}"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                        <center>
                                                                                            <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <td class="pinForecast ShowPin"
                                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                        <center><b>2,666,664</b>
                                                                                        </center>
                                                                                    </td>
                                                                                    <!--end::Total Coloumn-->
                                                                                    {{-- end:: Foreach Proyek --}}
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                    @php
                                                                        $total_year_forecast += $total_forecast;
                                                                        $total_forecast = 0;
                                                                        $month_counter = 1;
                                                                    @endphp
                                                                @endforeach
                                                                {{-- end:: Foreach Unit Kerja --}}
                                                            @endif
                                                        @endforeach

                                                    <tfoot
                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                        <div class="m-4">
                                                            <tr>
                                                                <td
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                    <!--begin::Child=-->
                                                                    Total
                                                                    <!--end::Child=-->
                                                                </td>
                                                                @for ($i = 0; $i < 12; $i++)
                                                                    <td>
                                                                        <center><b>10000</b></center>
                                                                    </td>
                                                                    <td
                                                                        data-total-forecast-internal-column={{ $i + 1 }}>

                                                                    </td>
                                                                    <td>
                                                                        <center><b>10000</b></center>
                                                                    </td>
                                                                @endfor
                                                                {{-- begin::Total Year --}}
                                                                <td class="pinForecast HidePin">
                                                                    <center>{{ $proyek->nilai_rkap }}
                                                                    </center>
                                                                </td>
                                                                <td
                                                                    class="pinForecast HidePin total-year-forecast-interal">
                                                                    <center>
                                                                        <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast HidePin">
                                                                    <center><b>2,666,664</b></center>
                                                                </td>
                                                                <td class="pinForecast ShowPin"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                    <center><b>{{ $proyek->nilai_rkap }}</b>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast ShowPin total-year-forecast-interal"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                    <center>
                                                                        <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                    </center>
                                                                </td>
                                                                <td class="pinForecast ShowPin"
                                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                    <center><b>2,666,664</b></center>
                                                                </td>
                                                                {{-- end::Total Year --}}
                                                            </tr>
                                                        </div>
                                                    </tfoot>

                                                    </tbody>

                                                    {{-- @endforeach --}}
                                                </table>
                                            </div>
                                            <!--end:::Tab pane Forecast Internal-->

                                            <!--begin:::Tab pane Forecast S/D-->
                                            <div class="tab-pane fade" id="kt_user_view_overview_forecast_sd"
                                                role="tabpanel">
                                                <table class="table align-middle table-row-dashed fs-6"
                                                    id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr
                                                            style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                            <th class="min-w-auto" rowspan="2"
                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                                <!--Begin::Svg Icon and Input Searc-->
                                                                <span
                                                                    class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                                    <i class="bi bi-search"></i>
                                                                </span>
                                                                <input type="text"
                                                                    data-kt-customer-table-filter="search"
                                                                    class="form-control form-control w-250px ps-15"
                                                                    placeholder="Search" /><br>
                                                                <!--end::Svg Icon and Input Searc-->
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Januari</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Februari</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Maret</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>April</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Mei</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Juni</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Juli</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Agustus</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>September</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Oktober</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>November</center>
                                                            </th>
                                                            <th class="min-w-auto" colspan="3">
                                                                <center>Desember</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-auto"
                                                                colspan="3">
                                                                <center>Total &nbsp;&nbsp; <i
                                                                        class="bi bi-pin-angle-fill"
                                                                        onclick="hidePin()"></i></center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-auto"
                                                                colspan="3"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center>Total &nbsp;&nbsp; <i
                                                                        class="bi bi-pin-fill text-primary"
                                                                        onclick="hidePin()"></i></center>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <!--begin::Sub-Judul Januari-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Januari-->
                                                            <!--begin::Sub-Judul Februari-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Februari-->
                                                            <!--begin::Sub-Judul Maret-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Maret-->
                                                            <!--begin::Sub-Judul April-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul April-->
                                                            <!--begin::Sub-Judul Mei-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Mei-->
                                                            <!--begin::Sub-Judul Juni-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Juni-->
                                                            <!--begin::Sub-Judul Juli-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Juli-->
                                                            <!--begin::Sub-Judul Agustus-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Agustus-->
                                                            <!--begin::Sub-Judul September-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul September-->
                                                            <!--begin::Sub-Judul Oktober-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Oktober-->
                                                            <!--begin::Sub-Judul November-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul November-->
                                                            <!--begin::Sub-Judul Desember-->
                                                            <th class="min-w-125px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="min-w-125px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Desember-->
                                                            <!--begin::Sub-Judul Total-->
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="pinForecast HidePin min-w-100px">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                <center>OK</center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                <center>Forecast</center>
                                                            </th>
                                                            <th class="pinForecast ShowPin min-w-100px"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center>Realisasi <a href="#" Id="Plus"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_create_namemodal">+</a>
                                                                </center>
                                                            </th>
                                                            <!--end::Sub-Judul Total-->
                                                        </tr>
                                                        <!--end::Table head-->
                                                    </thead>

                                                    <!--begin::Table body-->

                                                    <tbody class="fw-bold text-gray-600" id="table-body">

                                                        @php
                                                            $month_counter = 1;
                                                            $is_data_found = false;
                                                            $total_ok = 0;
                                                            $total_year_ok = 0;
                                                            $total_forecast = 0;
                                                            $total_month_forecast = 0;
                                                            $total_year_forecast = 0;
                                                            $index = 1;
                                                        @endphp
                                                        @foreach ($dops as $dop)
                                                            @if (count($dop->UnitKerjas) > 0)
                                                                {{-- @foreach ($proyeks as $proyek) --}}

                                                                <tr style="text-align: right; ">

                                                                    @php
                                                                        $dop_name = str_replace(' ', '-', $dop->dop);
                                                                    @endphp
                                                                    <td
                                                                        style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                        <a name="collalpse1" class=""
                                                                            data-bs-toggle="collapse"
                                                                            href="#{{ $dop_name }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="{{ $dop_name }} ">
                                                                            <i class="bi bi-chevron-down"></i>
                                                                            {{-- {{ $dop->dop }} --}}
                                                                            {{ $dop->dop }}
                                                                        </a>
                                                                    </td>

                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Januari Coloumn-->
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <!--end::Januari Coloumn-->
                                                                    <!--begin::Total Coloumn-->
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast HidePin">-</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                        -</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                        -</td>
                                                                    <td class="pinForecast ShowPin"
                                                                        style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                        -</td>
                                                                    <!--end::Total Coloumn-->

                                                                </tr>

                                                                {{-- begin:: Foreach Unit Kerja --}}
                                                                @foreach ($dop->UnitKerjas as $unitKerja)
                                                                    @if (count($unitKerja->proyeks) > 0)
                                                                        <tr class="collapse accordion-header"
                                                                            id="{{ $dop_name }}"
                                                                            style="text-align: right;">
                                                                            <td
                                                                                style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                <!--begin::Child=-->
                                                                                <a class="ms-6" type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#{{ $unitKerja->divcode }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="{{ $unitKerja->divcode }}">
                                                                                    <i
                                                                                        class="bi bi-chevron-down"></i>
                                                                                    {{ $unitKerja->unit_kerja }}
                                                                                </a>
                                                                                <!--end::Child=-->
                                                                            </td>
                                                                            <!--begin::Januari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Januari Coloumn-->
                                                                            <!--begin::Februari Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Februari Coloumn-->
                                                                            <!--begin::Maret Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Maret Coloumn-->
                                                                            <!--begin::April Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::April Coloumn-->
                                                                            <!--begin::Mei Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Mei Coloumn-->
                                                                            <!--begin::Juni Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Juni Coloumn-->
                                                                            <!--begin::Juli Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Juli Coloumn-->
                                                                            <!--begin::Agustus Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Agustus Coloumn-->
                                                                            <!--begin::September Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::September Coloumn-->
                                                                            <!--begin::Oktober Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Oktober Coloumn-->
                                                                            <!--begin::November Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::November Coloumn-->
                                                                            <!--begin::Desember Coloumn-->
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <!--end::Desember Coloumn-->
                                                                            <!--begin::Total Coloumn-->
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast HidePin">-</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                -</td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                -</td>
                                                                            <!--end::Total Coloumn-->
                                                                        </tr>
                                                                        {{-- begin:: Foreach Proyek --}}
                                                                        @foreach ($unitKerja->proyeks as $proyek)
                                                                            <tr id="{{ $unitKerja->divcode }}"
                                                                                class="collapse"
                                                                                aria-labelledby="{{ $unitKerja->divcode }}"
                                                                                data-bs-parent="#{{ $unitKerja->divcode }}"
                                                                                style="text-align: right;">
                                                                                <td
                                                                                    style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                                                    <!--begin::Child=-->
                                                                                    <p class="ms-12">
                                                                                        {{ $proyek->nama_proyek }}
                                                                                    </p>
                                                                                    <!--end::Child=-->
                                                                                </td>

                                                                                @for ($i = 0; $i < 12; $i++)
                                                                                    @if ($index > 3)
                                                                                        @php
                                                                                            $index = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @foreach ($proyek->Forecasts as $forecast)
                                                                                        @if ($forecast->month_forecast == $i + 1)
                                                                                            @php
                                                                                                // if ($index % 2 == 0) {
                                                                                                // }
                                                                                                $total_forecast += (int) $forecast->nilai_forecast;
                                                                                                // $total_ok += (int)
                                                                                            @endphp
                                                                                            <td>{{ $proyek->nilai_rkap }}
                                                                                            </td>
                                                                                            <td>
                                                                                                <input
                                                                                                    type="text"
                                                                                                    data-id-proyek-forecast-sd="{{ $proyek->id }}"
                                                                                                    data-month="{{ $month_counter }}"
                                                                                                    data-column-forecast-sd="{{ $month_counter }}"
                                                                                                    class="form-control"
                                                                                                    style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                                    id="nilai-forecast"
                                                                                                    name="nilai-forecast"
                                                                                                    onkeyup="reformatNumber(this)"
                                                                                                    value="{{ number_format((int) $forecast->nilai_forecast, 0, ',', ',') }}"
                                                                                                    placeholder=". . . , -" />
                                                                                            </td>
                                                                                            <td>10000</td>
                                                                                            @php
                                                                                                $is_data_found = true;
                                                                                            @endphp
                                                                                        @break
                                                                                    @endif
                                                                                    @php
                                                                                        $index++;
                                                                                    @endphp
                                                                                @endforeach
                                                                                @if (!$is_data_found)
                                                                                    <td>10000</td>
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            data-id-proyek-forecast-sd="{{ $proyek->id }}"
                                                                                            data-month="{{ $month_counter }}"
                                                                                            data-column-forecast-sd="{{ $month_counter }}"
                                                                                            class="form-control"
                                                                                            style="border: 0px; text-align: right; padding: 0px; margin: 0px"
                                                                                            id="nilai-forecast"
                                                                                            name="nilai-forecast"
                                                                                            onkeyup="reformatNumber(this)"
                                                                                            value=""
                                                                                            placeholder=". . . , -" />
                                                                                    </td>
                                                                                    <td>100000</td>
                                                                                @endif
                                                                                @php
                                                                                    $is_data_found = false;
                                                                                    $month_counter++;
                                                                                @endphp
                                                                            @endfor
                                                                            <!--begin::Total Coloumn-->
                                                                            <td class="pinForecast HidePin">
                                                                                <center>
                                                                                    <b>{{ $total_ok }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast HidePin"
                                                                                data-id-proyek-forecast-sd="{{ $proyek->id }}">
                                                                                <center>
                                                                                    <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast HidePin">
                                                                                <center><b>2,666,664</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                                <center>
                                                                                    <b>{{ $proyek->nilai_rkap }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin total-month-x-forecast"
                                                                                data-id-proyek-forecast-sd="{{ $proyek->id }}"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                                <center>
                                                                                    <b>{{ number_format((int) $total_forecast, 0, ',', ',') }}</b>
                                                                                </center>
                                                                            </td>
                                                                            <td class="pinForecast ShowPin"
                                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                                <center><b>2,666,664</b>
                                                                                </center>
                                                                            </td>
                                                                            <!--end::Total Coloumn-->
                                                                    @endforeach
                                                                    {{-- end:: Foreach Proyek --}}
                                                                @endif
                                                                @php
                                                                    $total_year_forecast += $total_forecast;
                                                                    $total_forecast = 0;
                                                                    $month_counter = 1;
                                                                @endphp
                                                            @endforeach
                                                            {{-- end:: Foreach Unit Kerja --}}
                                                        @endif
                                                    @endforeach

                                                <tfoot
                                                    style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0; z-index:99">
                                                    <div class="m-4">
                                                        <tr>
                                                            <td
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; left: 0px; padding-left: 20px; text-align: left">
                                                                <!--begin::Child=-->
                                                                Total
                                                                <!--end::Child=-->
                                                            </td>
                                                            @for ($i = 0; $i < 12; $i++)
                                                                <td>
                                                                    <center><b>10000</b></center>
                                                                </td>
                                                                <td
                                                                    data-total-column-forecast-sd={{ $i + 1 }}>

                                                                </td>
                                                                <td>
                                                                    <center><b>10000</b></center>
                                                                </td>
                                                            @endfor
                                                            {{-- begin::Total Year --}}
                                                            <td class="pinForecast HidePin">
                                                                <center>{{ $proyek->nilai_rkap }}</center>
                                                            </td>
                                                            <td
                                                                class="pinForecast HidePin total-year-forecast-sd">
                                                                <center>
                                                                    <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast HidePin">
                                                                <center><b>2,666,664</b></center>
                                                            </td>
                                                            <td class="pinForecast ShowPin"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">
                                                                <center><b>{{ $proyek->nilai_rkap }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast ShowPin total-year-forecast-sd"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">
                                                                <center>
                                                                    <b>{{ number_format((int) $total_year_forecast, 0, ',', ',') }}</b>
                                                                </center>
                                                            </td>
                                                            <td class="pinForecast ShowPin"
                                                                style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">
                                                                <center><b>2,666,664</b></center>
                                                            </td>
                                                            {{-- end::Total Year --}}
                                                        </tr>
                                                    </div>
                                                </tfoot>

                                                </tbody>

                                                {{-- @endforeach --}}
                                            </table>
                                        </div>
                                        <!--end:::Tab pane Forecast S/D-->
                                    </div>


                                </div>

                                <script>
                                    function hidePin() {
                                        var hide = document.getElementsByClassName('pinForecast');
                                        hide.forEach(element => {
                                            if (element.classList.contains("HidePin")) {
                                                element.classList.add("ShowPin");
                                                element.classList.remove("HidePin");
                                            } else {
                                                element.classList.add("HidePin");
                                                element.classList.remove("ShowPin");
                                            }
                                        });
                                    }
                                </script>
                                <!--end::Table Forecast-->

                            </div>
                        </div>



                    </div>
                    <!--end:::Tab isi content-->

                </div>
                <!--end::Card body-->


            </div>
            <!--end::Contacts App- Edit Contact-->

        </div>
        <!--end::Container-->
</div>
<!--end::Post-->

</div>
<!--end::Content-->
</form>
<!--end::Form-->

</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->


<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
<span class="svg-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
        transform="rotate(90 13 6)" fill="black" />
    <path
        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
        fill="black" />
</svg>
</span>
<!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
@endsection
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}

{{-- begin:: JS script --}}
@section('js-script')
<script>
    const toaster = document.querySelector(".toast");
    const toastBody = document.querySelector(".toast-body")
    const toastBoots = new bootstrap.Toast(toaster, {});

    function reformatNumber(elt) {
        const valueFormatted = Intl.NumberFormat("en-US", {
            maximumFractionDigits: 0,
        }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
        elt.value = valueFormatted;
    }

    function updateData(attribute) {
        let totalColumnAttribute = "";
        let dataColumnAttribute = "";
        let totalYearForecast = "";
        let totalMonthXForecast = "";
        if (attribute.includes("internal")) {
            totalColumnAttribute = "data-total-forecast-internal-column";
            dataColumnAttribute = "data-column-forecast-internal";
            totalYearForecast = "total-year-forecast-internal";
            totalMonthXForecast = "total-month-x-forecast-internal";
            // dataIdProyekForecast = "data-id-proyek-forecast-internal";
        } else if (attribute.includes("sd")) {
            totalColumnAttribute = "data-total-column-forecast-sd";
            dataColumnAttribute = "data-column-forecast-sd";
            totalYearForecast = "total-year-forecast-sd";
            totalMonthXForecast = "total-month-x-forecast-sd";
            // dataIdProyekForecast = "data-id-proyek-forecast-sd";

        } else {
            totalColumnAttribute = "data-total-forecast-column";
            dataColumnAttribute = "data-column-forecast";
            totalYearForecast = "total-year-forecast";
            totalMonthXForecast = "total-month-x-forecast";
            // dataIdProyekForecast = "data-id-proyek";
        }

        const inputForecasts = document.querySelectorAll(`input[${attribute}]`);
        inputForecasts.forEach(input => {
            input.addEventListener("focusout", async e => {
                const nilaiForecast = Number(e.target.value.toString().replaceAll(",", ""));
                const kodeProyek = input.getAttribute(attribute);
                const dataMonth = input.getAttribute("data-month");
                const dataColumn = input.getAttribute(dataColumnAttribute);
                const columnTotalYearForecast = document.querySelectorAll(`.${totalYearForecast}`);
                const columnDataYearForecast = document.querySelectorAll(`.${totalMonthXForecast}`);
                const columnForecastElt = document.querySelectorAll(
                    `input[${dataColumnAttribute}="${dataColumn}"]`);
                const rowForecastElt = document.querySelectorAll(
                    `input[${attribute}="${kodeProyek}"]`);
                const rowTotalForecastElt = document.querySelectorAll(
                    `td[${attribute}="${kodeProyek}"]`);
                console.log(`td[${totalColumnAttribute}="${dataColumn}"]`);

                const totalColumn = document.querySelector(
                    `td[${totalColumnAttribute}="${dataColumn}"]`);
                let totalColumnForecast = 0;
                let totalColumnYearForecast = 0;
                let totalRowForecast = 0;
                columnForecastElt.forEach(columnForecast => {
                    if (columnForecast.value != null) {
                        totalColumnForecast += Number(columnForecast.value.toString()
                            .replaceAll(",", ""));
                    }
                })
                rowForecastElt.forEach(rowForecast => {
                    if (rowForecast.value != null) {
                        totalRowForecast += Number(rowForecast.value.toString().replaceAll(
                            ",",
                            ""));
                    }
                });

                const formData = new FormData();
                const date = new Date();
                const dataColumnSame = document.querySelectorAll(`input[data-month="${dataMonth}"]`)

                formData.append("_token", "{{ csrf_token() }}");
                formData.append("nilai_forecast", nilaiForecast);
                formData.append("forecast_month", dataMonth);
                formData.append("kode_proyek", kodeProyek);
                const saveNilaiForecastRes = await fetch("/proyek/forecast/save", {
                    method: "POST",
                    header: {
                        "content-type": "application/json"
                    },
                    body: formData
                }).then(res => res.json());
                if (saveNilaiForecastRes.status == "success") {
                    const nilaiFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(nilaiForecast);
                    const rowValueFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(totalRowForecast);
                    const columnValueFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(totalColumnForecast);


                    input.value = nilaiFormatted;
                    toaster.classList.add("text-bg-success")
                    toaster.classList.remove("text-bg-danger")
                    toastBody.innerHTML = saveNilaiForecastRes.msg;
                    rowTotalForecastElt.forEach(rowForecast => {
                        rowForecast.innerHTML = `
                    <center>
                        <b>${rowValueFormatted}</b>
                    </center>
                    `;
                    });
                    dataColumnSame.forEach(dataColumn => {
                        dataColumn.value = nilaiFormatted;
                    });
                    totalColumn.innerHTML = `
                <td>
                    <center><b>${columnValueFormatted}</b></center>
                </td>
                `;

                    columnDataYearForecast.forEach(columnDataTotalYear => {
                        if (columnDataTotalYear.innerText != null || columnDataTotalYear
                            .innerText != "0") {
                            totalColumnYearForecast += Number(columnDataTotalYear.innerText
                                .toString().replaceAll(",",
                                    ""));
                        }
                    });

                    const columnTotalYearForecastFormatted = Intl.NumberFormat("en-US", {
                        maximumFractionDigits: 0,
                    }).format(totalColumnYearForecast);

                    columnTotalYearForecast.forEach(colTotal => {
                        colTotal.innerHTML = `
                    <center>
                        <b>${columnTotalYearForecastFormatted}</b>
                    </center>
                    `;
                    });

                    recalculateColumn();
                } else {
                    toaster.classList.remove("text-bg-success")
                    toaster.classList.add("text-bg-danger")
                    toastBody.innerHTML = saveNilaiForecastRes.msg;
                }
                toastBoots.show();
            });
        });
    }

    updateData("data-id-proyek");
    updateData("data-id-proyek-forecast-internal");
    updateData("data-id-proyek-forecast-sd");

    function recalculateColumn() {
        // begin Calculate Total Column Forecast Bulanan 
    const dataColumnTotalForecast = document.querySelectorAll(`td[data-total-forecast-column]`);
    let totalForecast = 0;
    dataColumnTotalForecast.forEach((forecast, i) => {
        const totalColumnForecast = forecast.getAttribute("data-total-forecast-column");
        const dataColumnForecast = document.querySelectorAll(
            `input[data-column-forecast="${totalColumnForecast}"]`);
        dataColumnForecast.forEach(dataForecast => {
            totalForecast += Number(dataForecast.value.replaceAll(",", ""));
        });
        if (totalColumnForecast) {
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalForecast);
            forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
        }
        totalForecast = 0;
    });
    // end Calculate Total Column Forecast Bulanan

    // begin Calculate Total Column Forecast Internal 
    const dataColumnTotalForecastInternal = document.querySelectorAll(`td[data-total-forecast-internal-column]`);
    let totalForecastInternal = 0;
    dataColumnTotalForecastInternal.forEach((forecast, i) => {
        const totalColumnForecast = forecast.getAttribute("data-total-forecast-internal-column");
        const dataColumnForecast = document.querySelectorAll(
            `input[data-column-forecast-internal="${totalColumnForecast}"]`);
        dataColumnForecast.forEach(dataForecast => {
            totalForecastInternal += Number(dataForecast.value.replaceAll(",", ""));
        });
        if (totalColumnForecast) {
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalForecastInternal);
            forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
        }
        totalForecastInternal = 0;
    });
    // end Calculate Total Column Forecast Internal

    // begin Calculate Total Column Forecast S/D 
    const dataColumnTotalForecastSD = document.querySelectorAll(`td[data-total-column-forecast-sd]`);
    let totalForecastSD = 0;
    dataColumnTotalForecastSD.forEach((forecast, i) => {
        const totalColumnForecast = forecast.getAttribute("data-total-column-forecast-sd");
        const dataColumnForecast = document.querySelectorAll(
            `input[data-column-forecast-sd="${totalColumnForecast}"]`);
        dataColumnForecast.forEach(dataForecast => {
            totalForecastSD += Number(dataForecast.value.replaceAll(",", ""));
        });
        if (totalColumnForecast) {
            const formattedForecastValue = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(totalForecastSD);
            forecast.innerHTML = `
            <td>
                <center><b>${formattedForecastValue}</b></center>
            </td>
            `;
        }
        totalForecastSD = 0;
    });
    // end Calculate Total Column Forecast S/D
    }

    recalculateColumn()

    
</script>
@endsection
{{-- end:: JS script --}}
