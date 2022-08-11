{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Buat Pelanggan')
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
                        <!--begin::Toolbar-->
                        <form action="/customer/save" method="post" enctype="multipart/form-data"> 
                            @csrf
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
                                        <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                            style="background-color:#008CB4;">
                                            Save</button>
                                        <!--end::Button-->

                                        <!--begin::Button-->
                                        <a href="/customer" class="btn btn-sm btn-light btn-active-primary" id="customer_new_close    "
                                            style="margin-left:10px">
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
                                                            <input type="text" id="name-customer" name="name-customer"                                                            class="form-control form-control-solid" 
                                                            value="{{ old('name-customer') }}" placeholder="Name" />
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
															<input type="email" class="form-control form-control-solid" 
															id="email" name="email" value="{{ old('email') }}" placeholder="Email" />
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
                                                                <span class="required">Phone Number</span>
															</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" class="form-control form-control-solid" 
															id="phone-number" name="phone-number" value="{{ old('phone-number') }}" placeholder="Phone Number" />
                                                            @error('phone-number')
                                                            <h6 class="text-danger">{{ $message }}eror</h6>
                                                            @enderror
															<!--end::Input-->
														</div>
														<!--end::Input group-->

                                                          <!--begin::Options-->
                                                          <div class="d-flex" style="flex-direction: column;">
                                                            <!--begin::Options-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="checkbox" value="" id="check-customer" name="check-customer" />
                                                                <span class="form-check-label">Customer</span>
                                                            </label>
                                                            <!--end::Options-->
                                                            <!--begin::Options-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="checkbox" value="" id="check-partner" name="check-partner" />
                                                                <span class="form-check-label">Partner</span>
                                                            </label>
                                                            <!--end::Options-->
                                                            <!--begin::Options-->
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                <input class="form-check-input" type="checkbox" value="" id="check-competitor" name="check-competitor" />
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
															id="website" name="website" value="" placeholder="Website" />
															<!--end::Input-->
														</div>
														<!--end::Input group-->

                                                        <!--begin::Input group Address 2-->
                                                        <div class="fv-row mb-7" style="margin-top:10px;">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Address Line 1</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <textarea class="form-control form-control-solid" name="AddressLine1"></textarea>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        
                                                        <!--begin::Input group Address 1-->
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
                                                                                <span class="required">Instansi</span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <select name="jenis-instansi" 
																				class="form-select form-select-solid" 
																				data-control="select2" data-hide-search="true" 
																				data-placeholder="Instansi">
																				<option></option>
																				<option value="BUMN">BUMN</option>
																				<option value="BUMND">BUMND</option>
																				<option value="APBN">APBN</option>
																				<option value="Swasta">Swasta</option>
																				<option value="Investasi">Investasi</option>
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
																				<span class="required">Kode Proyek Owner</span>
																			</label>
																			<!--end::Label-->
																			<!--begin::Input-->
																			<input type="text" class="form-control form-control-solid" 
																			name="kodepelanggan-company" value="" placeholder="Kode Proyek Owner" />
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
																				<span class="required">NPWP</span>
																			</label>
																			<!--end::Label-->
																			<!--begin::Input-->
																			<input type="text" class="form-control form-control-solid" 
																			name="npwp-company" value="" placeholder="NPWP" />
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
																				<span class="required">Kode Nasabah</span>
																			</label>
																			<!--end::Label-->
																			<!--begin::Input-->
																			<input type="text" class="form-control form-control-solid" 
																			name="kodenasabah-company" value="" placeholder="Kode Nasabah" />
																			<!--end::Input-->
																		</div>
																	<!--end::Input group-->
																</div>
																<!--End begin::Col-->
																</div>
																<!--End begin::Row-->

																<!--begin::Row-->
																{{-- <div class="row fv-row">
																	<!--begin::Col-->
																	<div class="col-6">
																	<!--begin::Input group Website-->
																		<div class="fv-row mb-7">
																			<!--begin::Label-->
																			<label class="fs-6 fw-bold form-label mt-3">
																				<span class="required">Customer Journey</span>
																			</label>
																			<!--end::Label-->
																			<!--begin::Input-->
																			<select name="journey-company" 
																				class="form-select form-select-solid" 
																				data-control="select2" data-hide-search="true" 
																				data-placeholder="Customer Journey">
																					<option></option>
																					<option value="Customer">Customer</option>
																					<option value="Loyal">Loyal</option>
																					<option value="Advocate">Advocate</option>
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
																				<span class="required">Segmentation</span>
																			</label>
																			<!--end::Label-->
																			<!--begin::Input-->
																			<select name="segmentation-company" 
																			class="form-select form-select-solid" 
																			data-control="select2" data-hide-search="true" 
																			data-placeholder="Segmentation">
																				<option></option>
																				<option value="Silver">Silver</option>
																				<option value="Gold">Gold</option>
																				<option value="VIP">VIP</option>
																			</select>
																			<!--end::Input-->
																		</div>
																	<!--end::Input group-->
																	</div>
																	<!--End begin::Col-->
																</div> --}}
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
																			name="name-pic" value="" placeholder="Name" />
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
																			<input type="text" class="form-control form-control-solid" 
																			name="kode-pic" value="" placeholder="Jabatan" />
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
																			name="email-pic" value="" placeholder="Email" />
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
																			name="phone-number-pic" value="" placeholder="Phone Number" />
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
															{{-- <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel">
																<!--begin::Card title-->
																<div class="card-title m-0">
																<h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
																	Proyek Berjalan
																	<a href="#" Id="Plus"
																	data-bs-toggle="modal" data-bs-target="#kt_modal_create_proyek">+</a>
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
																			<tr>
																				<!--begin::Name=-->
																				<td>
																					<a href="#" class="text-gray-800 text-hover-primary mb-1">
																						Proyek Pembangun Jalan Tol Cipularang
																					</a>
																				</td>
																				<!--end::Name=-->
																				<!--begin::Kode=-->
																				<td>
																					<a href="#" class="text-gray-600 text-hover-primary mb-1">
																						3EPA050</a>
																				</td>
																				<!--end::Kode=-->
																				<!--begin::Unit=-->
																				<td>Wika Industri Konstruksi</td>
																				<!--end::Unit=-->
																				<!--begin::Jenis=-->
																				<td>External</td>
																				<!--end::Jenis=-->
																				<!--begin::PIC=-->
																				<td>Erika Sartini</td>
																				<!--end::PIC=-->
																				<!--begin::Nilai OK=-->
																				<td>95,000,000,000</td>
																				<!--end::Nilai OK=-->
																			</tr>
																			<tr>
																				<!--begin::Name=-->
																				<td>
																					<a href="#" class="text-gray-800 text-hover-primary mb-1">
																						Proyek Pembangun Gedung Wisma K3
																					</a>
																				</td>
																				<!--end::Name=-->
																				<!--begin::Kode=-->
																				<td>
																					<a href="#" class="text-gray-600 text-hover-primary mb-1">
																						3EPA052</a>
																				</td>
																				<!--end::Kode=-->
																				<!--begin::Unit=-->
																				<td>Wika Bangun Gedung</td>
																				<!--end::Unit=-->
																				<!--begin::Jenis=-->
																				<td>External</td>
																				<!--end::Jenis=-->
																				<!--begin::PIC=-->
																				<td>Joe Satriani</td>
																				<!--end::PIC=-->
																				<!--begin::Nilai OK=-->
																				<td>15,432,000,000</td>
																				<!--end::Nilai OK=-->
																			</tr>
																			
																		</tbody>
																		<!--end::Table body-->
																	</table>
																<!--end::Table-->
																</div>
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
																				<tr>
																					<!--begin::Name=-->
																					<td>
																						<a href="#" class="text-gray-800 text-hover-primary mb-1">
																							Proyek Pembangun Jalan Tol Baru
																						</a>
																					</td>
																					<!--end::Name=-->
																					<!--begin::Kode=-->
																					<td>
																						<a href="#" class="text-gray-600 text-hover-primary mb-1">
																							3EPD142</a>
																					</td>
																					<!--end::Kode=-->
																					<!--begin::Unit=-->
																					<td>Wika Industri Plant</td>
																					<!--end::Unit=-->
																					<!--begin::Jenis=-->
																					<td>External</td>
																					<!--end::Jenis=-->
																					<!--begin::PIC=-->
																					<td>Shandy Austria</td>
																					<!--end::PIC=-->
																					<!--begin::Nilai OK=-->
																					<td>101,150,000,000</td>
																					<!--end::Nilai OK=-->
																					<!--begin::Nilai Kontrak=-->
																					<td>95,000,000,000</td>
																					<!--end::Nilai Kontrak=-->
																					<!--begin::Tanggal Mulai Kontrak=-->
																					<td>04/27/2022</td>
																					<!--end::Tanggal Mulai Kontrak=-->
																					<!--begin::No.SPK=-->
																					<td>SPK/XII/201/2022</td>
																					<!--end::No.SPK=-->
																				</tr>
																				<tr>
																					<!--begin::Name=-->
																					<td>
																						<a href="#" class="text-gray-800 text-hover-primary mb-1">
																							Proyek Pembangun Gedung Baru K4
																						</a>
																					</td>
																					<!--end::Name=-->
																					<!--begin::Kode=-->
																					<td>
																						<a href="#" class="text-gray-600 text-hover-primary mb-1">
																							3EPD172</a>
																					</td>
																					<!--end::Kode=-->
																					<!--begin::Unit=-->
																					<td>Wika Bangun Gedung</td>
																					<!--end::Unit=-->
																					<!--begin::Jenis=-->
																					<td>External</td>
																					<!--end::Jenis=-->
																					<!--begin::PIC=-->
																					<td>Joe Satriani</td>
																					<!--end::PIC=-->
																					<!--begin::Nilai OK=-->
																					<td>19,122,000,000</td>
																					<!--end::Nilai OK=-->
																					<!--begin::Nilai Kontrak=-->
																					<td>19,000,000,000</td>
																					<!--end::Nilai Kontrak=-->
																					<!--begin::Tanggal Mulai Kontrak=-->
																					<td>04/27/2022</td>
																					<!--end::Tanggal Mulai Kontrak=-->
																					<!--begin::No.SPK=-->
																					<td>SPK/XII/202/2022</td>
																					<!--end::No.SPK=-->
																				</tr>
																				
																			</tbody>
																			<!--end::Table body-->
																		</table>
																	<!--end::Table-->
																</div>
																<!--end::Card title-->
																<!--begin::Menu separator-->
																<!-- <div class="separator border-gray-200" style="margin-top: 10px;"></div> -->
																<!--end::Menu separator-->
															</div> --}}
															<!--end:::Tab pane History-->

															<!--begin:::Tab pane Atachment & Notes-->
															{{-- <div class="tab-pane fade" id="kt_user_view_overview_AttNotes" role="tabpanel">
																	<input type="file" id="file" class="file" hidden>
																	<!--begin::Attachment-->
																	<h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
																		Attachments
																	</h3>
																	<div>
																		<label for="doc-attachment" class="form-label"></label>
																		<input class="form-control form-control-lg" id="doc-attachment" name="doc-attachment" type="file">
																	</div>
																	<div style="background-color: #FFFF;width:100%;padding:10px;margin-top:5px;">
																	<!--End::Attachment-->
																	&nbsp;<br>
																	&nbsp;<br>
																<!--begin::Note-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
																		Note
																	</h3>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<textarea class="form-control form-control-solid" name="note-attachment" 
																	style="background-color:white;border-color:gainsboro; min-height:200px;">
																	</textarea>
																	<!--end::Input-->
																</div>
																<!--end::Input Note-->

																</div>
																</div>
																<!--end:::Tab pane Atachment & Notes-->

                                                                <!--begin:::Tab pane Performance-->
                                                                <div class="tab-pane fade" id="kt_user_view_overview_Performance" role="tabpanel">
                                                                    <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                                                
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
                                                                                    <input type="decimal" class="form-control form-control-solid reformat" 
                                                                                    id="nilaiok-performance" name="nilaiok-performance" value="" placeholder="Nilai OK" onkeyup="reformatNilaiOk()"/>
                                                                                    <!--end::Input-->
                                                                                </div>
                                                                            <!--end::Input group-->
                                                                        </div>
                                                                        <!--End begin::Col-->

                                                                        
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
                                                                                    <input type="decimal" class="form-control form-control-solid reformat" 
                                                                                    id="piutang-performance" name="piutang-performance" value="" placeholder="Piutang" />
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
                                                                                <input type="decimal" class="form-control form-control-solid reformat" 
                                                                                id="laba-performance" name="laba-performance" value="" placeholder="Laba" />
                                                                                <!--end::Input-->
                                                                            </div>
                                                                            <!--end::Input group-->
                                                                        </div>
                                                                        <!--End begin::Col-->
                                                                        
                                                                            
                                                                        
                                                                        <!--begin::Row-->
                                                                        <div class="col-6">
                                                                            <!--begin::Input group Website-->
                                                                                <div class="fv-row mb-7">
                                                                                    <!--begin::Label-->
                                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                                        <span>Rugi</span>
                                                                                    </label>
                                                                                    <!--end::Label-->
                                                                                    <!--begin::Input-->
                                                                                    <input type="decimal" class="form-control form-control-solid reformat" 
                                                                                    id="rugi-performance" name="rugi-performance" value="" placeholder="Rugi" />
                                                                                    <!--end::Input-->
                                                                                </div>
                                                                                <!--end::Input group-->
                                                                            </div>
                                                                            <!--End begin::Col-->
                                                                        </div>
                                                                       
                                                                        <!--End begin::Row-->
                                                                    </div>
															</div> --}}
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

@endsection
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script> --}}
