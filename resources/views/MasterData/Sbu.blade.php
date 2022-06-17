{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'SBU')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')


		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" >
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				@extends('template.aside')
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					
					<!--begin::Header-->
					@extends('template.header')
					<!--end::Header-->
						
						
					<!--begin::Delete Alert -->
					{{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
					<!--end::Delete Alert -->
					
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center fs-3 my-1">SBU
									</h1>
									<!--end::Title-->
								</div>
								<!--end::Page title-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center py-1">

									<!--begin::Button-->
									<a href="#" class="btn btn-sm btn-primary"
									data-bs-toggle="modal" 
									data-bs-target="#kt_modal_create" 
									id="kt_toolbar_primary_button"
									style="background-color:#ffa62b; padding: 7px 30px 7px 30px">
									New</a>

								<!--begin::Wrapper-->
								<div class="me-4" style="margin-left:10px;">
										<!--begin::Menu-->
										<a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
										<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
										<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->Action</a>
										<!--begin::Menu 1-->
										<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6155ac804a1c2">
											<!--begin::Header-->
											<div class="px-7 py-5">
												<div class="fs-5 text-dark fw-bolder">Choose actions:</div>
											</div>
											<!--end::Header-->
											<!--begin::Menu separator-->
											<div class="separator border-gray-200"></div>
											<!--end::Menu separator-->
											<!--begin::Form-->
											<div class="px-7 py-5">
												<!--begin::Input group-->
												<div class="mb-10">
													<!--begin::Label-->
													
													<i class="fas fa-file-excel"></i>
													<label class="form-label" style="margin-left:5px;">
														Export Excel</label><br>
													<i class="fas fa-file"></i>
													<label class="form-label" style="margin-left:5px;">
														Import Excel</label><br>
													<!--end::Label-->
												</div>
											</div>
											<!--end::Form-->
										</div>
										<!--end::Menu 1-->
										<!--end::Menu-->
									</div>
									<!--end::Wrapper-->
									
									
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						

						<!--begin::Post-->
								<!--begin::Container-->
									<!--begin::Card "style edited"-->
									<div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


										<!--begin::Card header-->
										<div class="card-header border-0 pt-">
											<!--begin::Card title-->
											<div class="card-title">
												<!--begin::Search-->
												<div class="d-flex align-items-center position-relative my-1">
													<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
													<span class="svg-icon svg-icon-1 position-absolute ms-6">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Proyek" />
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->

										</div>
										<!--end::Card header-->

										
										<!--begin::Card body-->
										<div class="card-body pt-0 ">


											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
												<!--begin::Table head-->
												<thead>
													<!--begin::Table row-->
													<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
														<th class="min-w-auto">Nama</th>
														<th class="min-w-auto">Kode</th>
														<th class="min-w-auto">Klasifikasi</th>
														<th class="min-w-auto">Sub-Klasifikasi</th>
														<th class="min-w-auto">Referensi 1</th>
														<th class="min-w-auto">Referensi 2</th>
														<th class="min-w-auto">Referensi 3</th>
														<th class=""><center>Action</center></th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												{{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}
												@foreach ($sbu as $sbu)
												
												<tbody class="fw-bold text-gray-600">
													<tr>
														
														<!--begin::Name=-->
														<td>
															<a href="#" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $sbu->sbu }}</a>
														</td>
														<!--end::Name=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->kode_sbu }}
														</td>
														<!--end::Coloumn=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->klasifikasi }}
														</td>
														<!--end::Coloumn=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->sub_klasifikasi }}
														</td>
														<!--end::Coloumn=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->referensi1 }}
														</td>
														<!--end::Coloumn=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->referensi2 }}
														</td>
														<!--end::Coloumn=-->
														<!--begin::Coloumn=-->
														<td>
															{{ $sbu->referensi3 }}
														</td>
														<!--end::Coloumn=-->

														<!--begin::Action=-->
														<td>
														<!--begin::Button-->
														<center>
															<form action="#" method="post" class="d-inline" >
																@method('delete')
																@csrf
																<button class="btn btn-sm btn-light btn-active-primary" onclick="return confirm('Deleted file can not be undo. Are You Sure ?')">Delete</button>
															</form>
														</center>
														<!--end::Button-->
														</td>
														<!--end::Action=-->
													</tr>

												@endforeach
												</tbody>
												<!--end::Table body-->
											</table>
											<!--end::Table-->

											

										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->
									<!--end::Container-->
									<!--end::Post-->
									
									
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

			<form action="/sbu/save" method="post" enctype="multipart/form-data"> 
				@csrf
				
				<!--begin::Modal - Create Proyek-->
				<div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-900px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2>SBU</h2>
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

							
								<!--begin::Row Kanan+Kiri-->
								<div class="row fv-row">
									<!--begin::Col-->
									<div class="col-6">
										<!--begin::Input group Website-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span class="required">Nama SBU</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" 
											id="sbu" name="sbu" value="" placeholder="Nama SBU" />
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
												<span>Kode SBU</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" 
											id="kode-sbu" name="kode-sbu" value="" placeholder="Kode SBU" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
									<!--End::Col-->
								</div>
								<!--End::Row Kanan+Kiri-->

								<!--begin::Row Kanan+Kiri-->
								<div class="row fv-row">
									<!--begin::Col-->
									<div class="col-6">
										<!--begin::Input group Website-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span>Klasifikasi</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<select id="klasifikasi" name="klasifikasi" class="form-select form-select-solid" data-control="select2" data-hide-search="true" 
												data-placeholder="Klasifikasi">
												<option selected></option>
												<option value="Bangun Gedung">Bangun Gedung</option>
												<option value="Kontruksi manufaktur">Kontruksi manufaktur</option>
												<option value="Minyak dan Gas">Minyak dan Gas</option>
												<option value="Sumber Daya Air">Sumber Daya Air</option>
												<option value="Transportasi">Transportasi</option>
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
												<span class="required">Sub-Klasifikasi</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" 
											id="sub-klasifikasi" name="sub-klasifikasi" value="" placeholder="Sub-Klasifikasi" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
									<!--End::Col-->
								</div>
								<!--End::Row Kanan+Kiri-->
								
								<!--begin::Row Kanan+Kiri-->
								<div class="row fv-row">
									<!--begin::Col-->
									<div class="col-6">
										<!--begin::Input group Website-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span>Referensi 1</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid reformat" 
											id="referensi1" name="referensi1" value="" placeholder="Referensi 1" />
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
												<span>Referensi 2</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid reformat" 
											id="referensi2" name="referensi2" value="" placeholder="Referensi 2" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
									<!--End::Col-->
								</div>
								<!--End::Row Kanan+Kiri-->
								
								
								<!--begin::Row Kanan+Kiri-->
								<div class="row fv-row">
									<!--begin::Col-->
									<div class="col-6">
										<!--begin::Input group Website-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span>Referensi 3</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid reformat" 
											id="referensi3" name="referensi3" value="" placeholder="Referensi 3" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
								</div>
								<!--End::Row Kanan+Kiri-->
							
							
								
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
						<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</div>
			@endsection

			<!--end::Scrolltop-->
		<!--end::Main-->

		<script>var hostUrl = "assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/modals/create-app.js"></script>
		<script src="assets/js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->

	</body>
	<!--end::Body-->
</html>