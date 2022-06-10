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
 

                <!--begin::Form-->
                <form action="#" method="post" enctype="multipart/form-data"> 
                    @csrf
                    
                    
                    <!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Toolbar-->
                            <div class="toolbar" id="kt_toolbar">
                                <!--begin::Container-->
                                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                    <!--begin::Page title-->
                                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                        <!--begin::Title-->
                                        <h1 class="d-flex align-items-center fs-3 my-1">Forecast
                                        </h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center py-1">
                                        
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                        style="background-color:#ffa62b; margin-left:10px">
                                        Save</button>
                                        <!--end::Button-->

                                        <!--begin::Button-->
                                        <a href="/project" class="btn btn-sm btn-primary" id="customer_new_close"
                                        style="background-color:#f1f1f1; margin-left:10px; color: black;">
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
                                <div id="kt_content_container" style="overflow: auto; background-color:white; white-space: nowrap;">
                                    <!--begin::Contacts App- Edit Contact-->
                                    <div class="">


                                <!--begin::All Content-->
                                <div class="col-xl-15">
                                    <!--begin::Contacts-->
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main" >

                                        <!--begin::Card body-->
                                        <div class="card-body" style="background-color: white">

                                        
                                                    
<!--begin::Table Forecast-->
                                <table class="table align-middle table-row-dashed fs-6" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr style="border-bottom: 1px #f2f4f7 solid; border-right: 1px #f2f4f7 solid">
                                                <th class="min-w-auto"  rowspan="2" style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px;">
                                                    <!--Begin::Svg Icon and Input Searc-->
                                                    <span class="svg-icon svg-icon-1 position-absolute ms-6 mt-5">
                                                        <i class="bi bi-search"></i>
                                                    </span>
                                                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control w-250px ps-15" placeholder="Search" /><br>
                                                    <!--end::Svg Icon and Input Searc-->
                                                </th>
                                                <th class="min-w-auto" colspan="3"><center>Januari</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Februari</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Maret</center></th>
                                                <th class="min-w-auto" colspan="3"><center>April</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Mei</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Juni</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Juli</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Agustus</center></th>
                                                <th class="min-w-auto" colspan="3"><center>September</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Oktober</center></th>
                                                <th class="min-w-auto" colspan="3"><center>November</center></th>
                                                <th class="min-w-auto" colspan="3"><center>Desember</center></th>
                                                <th class="pinForecast HidePin min-w-auto" colspan="3" ><center>Total &nbsp;&nbsp; <i class="bi bi-pin-angle-fill" onclick="hidePin()"></i></center></th>
                                                <th class="pinForecast ShowPin min-w-auto" colspan="3" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;"><center>Total &nbsp;&nbsp; <i class="bi bi-pin-fill text-primary" onclick="hidePin()"></i></center></th>
                                            </tr>
                                            <tr>
                                                <!--begin::Sub-Judul Januari-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Januari-->
                                                <!--begin::Sub-Judul Februari-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Februari-->
                                                <!--begin::Sub-Judul Maret-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Maret-->
                                                <!--begin::Sub-Judul April-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul April-->
                                                <!--begin::Sub-Judul Mei-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Mei-->
                                                <!--begin::Sub-Judul Juni-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Juni-->
                                                <!--begin::Sub-Judul Juli-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Juli-->
                                                <!--begin::Sub-Judul Agustus-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Agustus-->
                                                <!--begin::Sub-Judul September-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul September-->
                                                <!--begin::Sub-Judul Oktober-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Oktober-->
                                                <!--begin::Sub-Judul November-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul November-->
                                                <!--begin::Sub-Judul Desember-->
                                                <th class="min-w-125px"><center>Oke</center></th>
                                                <th class="min-w-125px"><center>Forecast</center></th>
                                                <th class="min-w-125px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Desember-->
                                                <!--begin::Sub-Judul Total-->
                                                <th class="pinForecast HidePin min-w-100px"><center>Oke</center></th>
                                                <th class="pinForecast HidePin min-w-100px"><center>Forecast</center></th>
                                                <th class="pinForecast HidePin min-w-100px"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <th class="pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;"><center>Oke</center></th>
                                                <th class="pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;"><center>Forecast</center></th>
                                                <th class="pinForecast ShowPin min-w-100px" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;"><center>Realisasi <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_namemodal">+</a></center></th>
                                                <!--end::Sub-Judul Total-->
                                            </tr>
                                            <!--end::Table head-->
                                        </thead>
                                        
                                    <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <tr style="text-align: right; ">
                                                <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                    <a name="collalpse1" class="" data-bs-toggle="collapse" href="#collapse" aria-expanded="false" aria-controls="collapse">
                                                        <i class="bi bi-chevron-down"></i> DOP 1
                                                    </a>
                                                </td>

                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Januari Coloumn-->
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <td>000,000</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Total Coloumn-->
                                                <td class="pinForecast HidePin" >000,000</td>
                                                <td class="pinForecast HidePin" >000,000</td>
                                                <td class="pinForecast HidePin" >000,000</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">000,000</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">000,000</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">000,000</td>
                                                <!--end::Total Coloumn-->
                                            </tr>
                                            <tr class="collapse accordion-header" id="collapse" style="text-align: right;">
                                                <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                    <!--begin::Child=-->
                                                        <a class="ms-6" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                            <i class="bi bi-chevron-down"></i> Divisi Bangun Gedung
                                                        </a>
                                                    <!--end::Child=-->
                                                </td>
                                                <!--begin::Januari Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Februari Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Februari Coloumn-->
                                                <!--begin::Maret Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Maret Coloumn-->
                                                <!--begin::April Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::April Coloumn-->
                                                <!--begin::Mei Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Mei Coloumn-->
                                                <!--begin::Juni Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Juni Coloumn-->
                                                <!--begin::Juli Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Juli Coloumn-->
                                                <!--begin::Agustus Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Agustus Coloumn-->
                                                <!--begin::September Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::September Coloumn-->
                                                <!--begin::Oktober Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Oktober Coloumn-->
                                                <!--begin::November Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::November Coloumn-->
                                                <!--begin::Desember Coloumn-->
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <td>111,111</td>
                                                <!--end::Desember Coloumn-->
                                                <!--begin::Total Coloumn-->
                                                <td class="pinForecast HidePin" >1,333,332</td>
                                                <td class="pinForecast HidePin" >1,333,332</td>
                                                <td class="pinForecast HidePin" >1,333,332</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">1,333,332</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">1,333,332</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">1,333,332</td>
                                                <!--end::Total Coloumn-->
                                            </tr>
                                            <tr id="flush-collapseTwo" class="collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample" style="text-align: right;">
                                                <td style="position: -webkit-sticky; position: sticky; background-color: white; left: 0px; padding-left: 20px; text-align: left">
                                                    <!--begin::Child=-->
                                                        <p class="ms-12">
                                                            Pengadaan JPO Arkadia Tower
                                                        </p>
                                                    <!--end::Child=-->
                                                </td>
                                                <!--begin::Januari Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Januari Coloumn-->
                                                <!--begin::Februari Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Februari Coloumn-->
                                                <!--begin::Maret Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Maret Coloumn-->
                                                <!--begin::April Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::April Coloumn-->
                                                <!--begin::Mei Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Mei Coloumn-->
                                                <!--begin::Juni Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Juni Coloumn-->
                                                <!--begin::Juli Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Juli Coloumn-->
                                                <!--begin::Agustus Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Agustus Coloumn-->
                                                <!--begin::September Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::September Coloumn-->
                                                <!--begin::Oktober Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Oktober Coloumn-->
                                                <!--begin::November Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::November Coloumn-->
                                                <!--begin::Desember Coloumn-->
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <td>222,222</td>
                                                <!--end::Desember Coloumn-->
                                                <!--begin::Total Coloumn-->
                                                <td class="pinForecast HidePin" >2,666,664</td>
                                                <td class="pinForecast HidePin" >2,666,664</td>
                                                <td class="pinForecast HidePin" >2,666,664</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 200px;">2,666,664</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 100px;">2,666,664</td>
                                                <td class="pinForecast ShowPin" style="position: -webkit-sticky; position: sticky; background-color: #f2f4f7; right: 0px;">2,666,664</td>
                                                <!--end::Total Coloumn-->

                                            </tr>
                                        </tbody>
                                    <!--end::Table body-->
                                </table>
                                
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
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}
