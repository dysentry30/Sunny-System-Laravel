{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Customer')
{{-- End::Title --}}

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
                                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
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
                                                style="background-color:#ffa62b;">
                                                Save</button>
                                           <!--end::Button-->
    
                                           <!--begin::Button-->
                                            <a href="/customer" class="btn btn-sm btn-primary"	id="customer-edit-close"
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
                                                            <input type="text" id="name-customer" name="name-customer" class="form-control form-control-solid" 
                                                            value="{{ $customer->name }}" placeholder="Name" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group Name-->
                                                        
                                                        <!--begin::Options-->
                                                        @php
                                                            $check_customer = $customer->check_customer ? "checked" : '';
                                                            $check_partner = $customer->check_partner ? "checked" : '';
                                                            $check_competitor = $customer->check_competitor ? "checked" : '';
                                                        @endphp

                                                        <div class="d-flex" style="flex-direction: column;">
                                                            <!--begin::Options-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="checkbox" value="" {{ $check_customer }}  name="check-customer" />
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
                                                        
                                                        <!--begin::Input group Email-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span >Email</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="email" class="form-control form-control-solid" 
                                                            id="email" name="email" value="{{ $customer->email }}" placeholder="Email" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group Phone-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Phone Number</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="phone-number" name="phone-number" value="{{ $customer->phone_number }}" placeholder="Phone Number" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        
														<!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Website</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid" 
                                                            id="website" name="website" value="{{ $customer->website }}" placeholder="Website" />
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
                                                            <!--begin:::Tab item Informasi Perusahaan-->
                                                            <li class="nav-item">
                                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" 
                                                                href="#kt_user_view_overview_tab" style="font-size:14px;">COMPANY INFORMATION</a>
                                                            </li>
                                                            <!--end:::Tab item Informasi Perusahaan-->

                                                            <!--begin:::Tab item Atachment & Notes-->
                                                            <li class="nav-item">
                                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" 
                                                                href="#kt_user_view_overview_Performance" style="font-size:14px;">PERFORMANCE</a>
                                                            </li>
                                                            <!--end:::Tab item Atachment & Notes-->

                                                            <!--begin:::Tab item History-->
                                                            <li class="nav-item">
                                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" 
                                                                href="#kt_user_view_overview_history" style="font-size:14px;">HISTORY</a>
                                                            </li>
                                                            <!--end:::Tab item History-->

                                                            <!--begin:::Tab item Atachment & Notes-->
                                                            <li class="nav-item">
                                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" 
                                                                href="#kt_user_view_overview_AttNotes" style="font-size:14px;">ATTACHMENTS</a>
                                                            </li>
                                                            <!--end:::Tab item Atachment & Notes-->
        
                                                        </ul>
                                                        <!--end:::Tabs-->
                                                        
<!--begin:::Tab content -->
														<div class="tab-content" id="myTabContent">

															<!--begin:::Tab pane Informasi Perusahaan-->
															<div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
															
															<!--begin::Row-->
															<div class="row fv-row">
																<!--begin::Col-->
																<div class="col-6">
																<!--begin::Input group Website-->
																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="fs-6 fw-bold form-label mt-3">
																			<span>Instansi</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select name="jenis-instansi" 
																		class="form-select form-select-solid" 
																		data-control="select2" data-hide-search="true" 
																		data-placeholder="Pilih Instansi" >
																			<option ></option>
																			<option value="BUMN" {{ $customer->jenis_instansi == "BUMN" ? "selected" : "" }}>BUMN</option>
																			<option value="BUMND" {{ $customer->jenis_instansi == "BUMND" ? "selected" : "" }}>BUMND</option>
																			<option value="APBN" {{ $customer->jenis_instansi == "APBN" ? "selected" : "" }}>APBN</option>
																			<option value="Swasta" {{ $customer->jenis_instansi == "Swasta" ? "selected" : "" }}>Swasta</option>
																			<option value="Investasi" {{ $customer->jenis_instansi == "Investasi" ? "selected" : "" }}>Investasi</option>
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
																			<span>Kode Proyek Owner</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" 
																		name="kodeproyek-company" value="{{ $customer->kode_proyek }}" placeholder="Kode Proyek Owner" />
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
																			<span>NPWP</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" 
																		name="npwp-company" value="{{ $customer->npwp_company }}" placeholder="NPWP" />
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
																			<span>Kode Nasabah</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" 
																		name="kodenasabah-company" value="{{ $customer->kode_nasabah }}" placeholder="Kode Nasabah" />
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
																			<span>Customer Journey</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select name="journey-company" 
																		class="form-select form-select-solid" 
																		data-control="select2" data-hide-search="true" 
																		data-placeholder="Pilih Customer Journey">
																			<option ></option>
																			<option value="Customer" {{ $customer->journey_company == "Customer" ? "selected" : "" }}>Customer</option>
																			<option value="Loyal" {{ $customer->journey_company == "Loyal" ? "selected" : "" }}>Loyal</option>
																			<option value="Advocate" {{ $customer->journey_company == "Advocate" ? "selected" : "" }}>Advocate</option>
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
																			<span>Segmentation</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select name="segmentation-company" 
																		class="form-select form-select-solid" 
																		data-control="select2" data-hide-search="true" 
																		data-placeholder="Pilih Segmentation">
																			<option ></option>
																			<option value="Silver" {{ $customer->segmentation_company == "Silver" ? "selected" : "" }}>Silver</option>
																			<option value="Gold" {{ $customer->segmentation_company == "Gold" ? "selected" : "" }}>Gold</option>
																			<option value="VIP" {{ $customer->segmentation_company == "VIP" ? "selected" : "" }}>VIP</option>
																		</select>
																		<!--end::Input-->
																	</div>
																<!--end::Input group-->
															</div>
															<!--End begin::Col-->
															</div>
															<!--End begin::Row-->
															&nbsp;<br>
															&nbsp;<br>
															&nbsp;<br>


															<!--begin::Card title-->
															<div class="card-title m-0">
																<h3 class="fw-bolder m-0" style="font-size:14px;">Contact / PIC</h3>
															</div>
															<!--end::Card title-->
															<!--begin::Menu separator-->
															<div class="separator border-gray-200" style="margin-top: 10px;"></div>
															<!--end::Menu separator-->

															<!--begin::Row-->
															<div class="row fv-row">
																<!--begin::Col-->
																<div class="col-6">
																<!--begin::Input group Website-->
																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="fs-6 fw-bold form-label mt-3">
																			<span>Name</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" 
																		name="name-pic" value="{{ $customer->name_pic }}" placeholder="Name" />
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
																		<input type="text" class="form-control form-control-solid" 
																		name="kode-pic" value="{{ $customer->kode_pic }}" placeholder="Kode Nasabah" />
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
																		name="email-pic" value="{{ $customer->email_pic }}" placeholder="Email" />
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
																			<span>Phone Number</span>
																		</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<input type="text" class="form-control form-control-solid" 
																		name="phone-number-pic" value="{{ $customer->phone_number_pic }}" placeholder="Phone Number" />
																		<!--end::Input-->
																	</div>
																<!--end::Input group-->
															</div>
															<!--End begin::Col-->
															</div>
															<!--End begin::Row-->

															</div>
															<!--end:::Tab pane Informasi Perusahaan-->

                                                            
<!--begin:::Tab pane History-->
															<div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel">

                                                            {{-- @if ($proyekberjalan->stage > 0) --}}
                                                            <!--begin::Proyek Berjalan-->
                                                            <div class="card-title m-0">
                                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                    Proyek Berjalan
                                                                    {{-- <a href="#" Id="Plus"
                                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek">+</a> --}}
                                                                </h3>
                                                                &nbsp;<br>

                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                    <!--begin::Table head-->
                                                                    <thead>
                                                                        <!--begin::Table row-->
                                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-auto">Nama Proyek</th>
                                                                            <th class="min-w-auto">Kode Proyek</th>
                                                                            <th class="min-w-auto">Unit kerja</th>
                                                                            <th class="min-w-auto">Jenis Proyek</th>
                                                                            <th class="min-w-auto">Nama PIC</th>
                                                                            <th class="min-w-auto">Nilai OK</th>
                                                                        </tr>
                                                                        <!--end::Table row-->
                                                                    </thead>
                                                                    <!--end::Table head-->
                                                                    <!--begin::Table body-->
                                                                    <tbody class="fw-bold text-gray-600">
                                                                        @if (isset($proyekberjalan))
                                                                        @foreach ($proyekberjalan as $proyekberjalan0)
                                                                        @if ( $proyekberjalan0->stage <= 6)
                                                                        <tr>
                                                                            <!--begin::Name=-->
                                                                            <td>
                                                                                <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                                    {{ $proyekberjalan0->nama_proyek }}
                                                                                </a>
                                                                            </td>
                                                                            <!--end::Name=-->
                                                                            <!--begin::Kode=-->
                                                                            <td>
                                                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                                    {{ $proyekberjalan0->kode_proyek }}
                                                                                </a>
                                                                            </td>
                                                                            <!--end::Kode=-->
                                                                            <!--begin::Unit=-->
                                                                            <td>
                                                                                {{ $proyekberjalan0->UnitKerja->unit_kerja }}
                                                                            </td>
                                                                            <!--end::Unit=-->
                                                                            <!--begin::Jenis=-->
                                                                            <td>{{ $proyekberjalan0->jenis_proyek == "I" ? "Internal" : "External"}}</td>
                                                                            <!--end::Jenis=-->
                                                                            <!--begin::PIC=-->
                                                                            <td>{{ $proyekberjalan0->pic_proyek ?? "Belum ditetapkan" }}</td>
                                                                            <!--end::PIC=-->
                                                                            <!--begin::Nilai OK=-->
                                                                            <td>{{ $proyekberjalan0->nilaiok_proyek }}</td>
                                                                            <!--end::Nilai OK=-->

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
                                                            {{-- @endif --}}


                                                                    &nbsp;<br>
                                                                    &nbsp;<br>
                                                                    &nbsp;<br>
                                                                    
                                                                    
                                                                    <div class="card-title m-0">
                                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                                            Proyek Terkontrak
                                                                        </h3>
                                                                        <!--begin::Table-->
                                                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                            <!--begin::Table head-->
                                                                            <thead>
                                                                                <!--begin::Table row-->
                                                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                                    <th class="min-w-auto">Nama Proyek</th>
                                                                                    <th class="min-w-auto">Kode Proyek</th>
                                                                                    <th class="min-w-auto">Unit kerja</th>
                                                                                    <th class="min-w-auto">Jenis Proyek</th>
                                                                                    <th class="min-w-auto">Nama PIC</th>
                                                                                    <th class="min-w-auto">Nilai OK</th>
                                                                                    <th class="min-w-auto">Nilai Kontrak</th>
                                                                                    <th class="min-w-auto">Tanggal Mulai Kontrak</th>
                                                                                    <th class="min-w-auto">No.SPK</th>
                                                                                </tr>
																			    <!--end::Table row-->
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            <tbody class="fw-bold text-gray-600">


                                                                                @if (isset($proyekberjalan))
                                                                                @foreach ($proyekberjalan as $proyekberjalan6)
                                                                                @if ( $proyekberjalan6->stage > 6)
                                                                                <tr>
                                                                                    <!--begin::Name=-->
                                                                                    <td>
                                                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                                            {{ $proyekberjalan6->nama_proyek }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Name=-->
                                                                                    <!--begin::Kode=-->
                                                                                    <td>
                                                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                                            {{ $proyekberjalan6->kode_proyek }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <!--end::Kode=-->
                                                                                    <!--begin::Unit=-->
                                                                                    <td>{{ $proyekberjalan6->UnitKerja->unit_kerja }}</td>
                                                                                    <!--end::Unit=-->
                                                                                    <!--begin::Jenis=-->
                                                                                    <td>{{ $proyekberjalan6->jenis_proyek == "I" ? "Internal" : "External"}}</td>
                                                                                    <!--end::Jenis=-->
                                                                                    <!--begin::PIC=-->
                                                                                    <td>{{ $proyekberjalan6->pic_proyek ?? "Belum ditetapkan" }}</td>
                                                                                    <!--end::PIC=-->
                                                                                    <!--begin::Nilai OK=-->
                                                                                    <td>{{ $proyekberjalan6->nilaiok_proyek }}</td>
                                                                                    <!--end::Nilai OK=-->
                                                                                    <!--begin::Nilai Kontrak=-->
                                                                                    <td>-</td>
                                                                                    <!--end::Nilai Kontrak=-->
                                                                                    <!--begin::Tanggal Mulai Kontrak=-->
                                                                                    <td>-</td>
                                                                                    <!--end::Tanggal Mulai Kontrak=-->
                                                                                    <!--begin::No.SPK=-->
                                                                                    <td>-</td>
                                                                                    <!--end::No.SPK=-->
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
                                                            <!--begin::Menu separator-->
                                                            <div class="separator border-gray-200" style="margin-top: 10px;"></div>
                                                            <!--end::Menu separator-->
															</div>
<!--end:::Tab pane History-->




<!--begin:::Tab pane Atachment & Notes-->
															<div class="tab-pane fade" id="kt_user_view_overview_AttNotes" role="tabpanel">
																<input type="file" id="file" class="file" hidden>
																<!--begin::Attachment-->
																<h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
																	Attachments
																</h3>
                                                                
                                                                <div>
                                                                    <label for="doc-attachment" class="form-label"></label>
                                                                    <input class="form-control form-control-lg" id="doc-attachment" name="doc-attachment" type="file">
                                                                </div>
                                                                &nbsp;<br>
                                                                {{-- <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button> --}}

                                                                <!--End::Attachment-->


                                                                <!--EDITED begin::Attachement Table-->
                                                                <div style="background-color: #FFFF;width:100%;padding:10px;margin-top:5px;">
                                                                
                                                                <div>
                                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                                        <!--begin::Table head-->
                                                                        <thead>
                                                                            <!--begin::Table row-->
                                                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                                                                                <!--begin::Name=-->
                                                                                
                                                                                <td>
                                                                                    <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                                        {{ $attachment->name_customer }}
                                                                                    </a>
                                                                                </td>
                                                                                <!--end::Name=-->
                                                                                <!--begin::Kode=-->
                                                                                <td>
                                                                                    <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                                        {{ $attachment->name_attachment }}</a>
                                                                                </td>
                                                                                <!--end::Kode=-->
                                                                                <!--begin::Time=-->
                                                                                <td>
                                                                                    <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                                        {{ $attachment->created_at }}</a>
                                                                                    </td>
                                                                                    <!--end::Time=-->
                                                                                </tr>
                                                                            @endforeach
                                                                            @endif
                                                                            
                                                                        </tbody>
                                                                        <!--end::Table body-->
                                                                    </table>   
                                                                </div>
                                                                &nbsp;<br>
                                                                &nbsp;<br>
                                                                &nbsp;<br>

<!--end::Attachement Table-->



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
															</div>
															<!--end:::Tab pane Atachment & Notes-->



                                                            <!--begin:::Tab pane Performance-->
															<div class="tab-pane fade" id="kt_user_view_overview_Performance" role="tabpanel">
																<div class="tab-pane fade show active" id="kt_user_view_overview_Performance" role="tabpanel">
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
																				<input type="text" class="form-control form-control-solid reformat" 
																				id="nilaiok-performance" name="nilaiok-performance" value="{{ $customer->nilaiok }}" placeholder="Nilai OK" />
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
																				<input type="text" class="form-control form-control-solid reformat" 
																				name="piutang-performance" value="{{ $customer->piutang }}" placeholder="Piutang" />
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
																				<input type="text" class="form-control form-control-solid reformat" 
																				name="laba-performance" value="{{ $customer->laba }}" placeholder="Laba"/>
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
																				<input type="text" class="form-control form-control-solid reformat" 
																				name="rugi-performance" value="{{ $customer->rugi }}" placeholder="Rugi"/>
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
                            <i class="bi bi-x-circle-fill ts-8"></i>
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
                        {{-- @foreach ($proyekberjalan as $proyekberjalan ) --}}
                        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="required">Name Proyek</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                            <select name="nama-proyek" 
                                class="form-select form-select-solid" 
                                data-control="select2" data-hide-search="true" 
                                data-placeholder="Nama Proyek">
                                <option></option>
                                @foreach ($proyeks as $proyek)
                                    {{-- @if ( $proyekberjalans->nama_proyek == $proyek->nama_proyek )
                                        <option value="{{ $proyek->nama_proyek }}" disabled>{{$proyek->nama_proyek }}</option>
                                    @else --}}
                                        <option value="{{ $proyek->nama_proyek }}" >{{$proyek->nama_proyek }}</option>
                                    {{-- @endif --}}
                                @endforeach
                                
                            </select>
                            @error('nama-proyek')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror
                        <!--end::Input-->

                        {{-- @endforeach --}}

                        
                        {{-- <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="required">Kode Proyek</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                            <select name="kode-proyek" 
                                class="form-select form-select-solid" 
                                data-control="select2" data-hide-search="true" 
                                data-placeholder="Nama Proyek">
                                <option></option>
                                @foreach ($proyeks as $proyek)
                                    <option value="{{ $proyek->kode_proyek }}" >{{$proyek->kode_proyek }}</option>
                                @endforeach
                            </select>
                            @error('kode-proyek')
                                <h6 class="text-danger">{{ $message }}</h6>
                            @enderror
                        <!--end::Input-->
                        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span>Nama PIC</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" 
                        id="pic-proyek" name="pic-proyek" value="" placeholder="Nama PIC" />
                        <!--end::Input-->
                        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Unit Kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="unit-kerja" 
                                        class="form-select form-select-solid" 
                                        data-control="select2" data-hide-search="true" 
                                        data-placeholder="Unit Kerja">
                                        <option></option>
                                        <option value="Divisi Bangun Gedung">Divisi Bangun Gedung </option>
                                        <option value="Divisi Industri Plant">Divisi Industri Plant</option>
                                        <option value="Industri Infrastruktur 1">Industri Infrastruktur 1</option>
                                        <option value="Industri Infrastruktur 2">Industri Infrastruktur 2</option>
                                        <option value="Divis Luar Negri">Divis Luar Negri</option>
                                        <option value="Industri Power Energi">Industri Power Energi</option>
                                        <option value="Wika Beton">Wika Beton</option>
                                        <option value="Wika Bitumen">Wika Bitumen</option>
                                        <option value="Wika Gedung">Wika Gedung</option>
                                        <option value="Wika Industri & Konstruksi">Wika Industri & Konstruksi</option>
                                        <option value="Wika Reality">Wika Reality</option>
                                        <option value="Wika Rekayasa Konstruksi">Wika Rekayasa Konstruksi</option>
                                    </select>
                                <!--end::Input-->
                                
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Jenis Proyek</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="jenis-proyek" 
                                class="form-select form-select-solid" 
                                data-control="select2" data-hide-search="true" 
                                data-placeholder="Jenis Proyek">
                                <option></option>
                                <option value="Internal">Internal</option>
                                <option value="External">External</option>
                            </select>
                            <!--end::Input-->
                            
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Nilai OK</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="decimal" class="form-control form-control-solid" 
                            id="nilaiok-proyek" name="nilaiok-proyek" value="" placeholder="Nilai OK" onkeyup="reformatNilaiOkProyek()" />
                            <script>
                                var nilaiOkProyek = document.getElementById("nilaiok-proyek");
                                function reformatNilaiOkProyek() {
                                const valueFormatted = Intl.NumberFormat("en-US").format(nilaiOkProyek.value.toString().replace(/[^0-9]/gi, ""));
                                nilaiOkProyek.value = valueFormatted;
                                }
                            </script>
                            <!--end::Input--> --}}
                            
                            <!--begin::Label-->
                            {{-- <label class="fs-6 fw-bold form-label mt-3">
                                <span>Tanggal Input Proyek</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="Date" class="form-control form-control-solid" 
                            name="phone" value="" placeholder="Date" /> --}}
                            <!--end::Input-->
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
    {{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}
    <!--end::Footer and script for modal and assets-->