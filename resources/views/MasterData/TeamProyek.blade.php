{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Team Proyek')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')


		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" >
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
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
									<h1 class="d-flex align-items-center fs-3 my-1">Team Proyek
									</h1>
									<!--end::Title-->
								</div>
								<!--end::Page title-->

								@if (auth()->user()->check_administrator)
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
								@endif
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
														<th class="min-w-auto">No.</th>
														<th class="min-w-auto">User Name</th>
														<th class="min-w-auto">Email</th>
														<th class="min-w-auto">Unit Kerja</th>
														<th class="min-w-auto">Proyek Berjalan</th>
														<th class="min-w-auto">Role</th>
														<th class=""><center>Action</center></th>
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												@php
												// $companies = $companies->reverse();
												$no = 1;
												@endphp
												@foreach ($all_proyek as $proyek)
												
												<tbody class="fw-bold text-gray-600">
													<tr>
														
														<!--begin::No=-->
														<td>
															{{ $no++ }}
														</td>
														<!--end::No=-->

														<!--begin::Ketua tender=-->
														<td>
															{{ $proyek->ketua_tender ?? "Belum Ditetapkan"}}
														</td>
														<!--end::Ketua tender=-->

														<!--begin::Nama Proyek=-->
														<td>
															<a href="/proyek/view/{{ $proyek->id }}" class="text-hover-primary text-gray-500">{{ $proyek->nama_proyek }}</a>
														</td>
														<!--end::Nama Proyek=-->

														<!--begin::Nama Proyek=-->
														<td>
                                                            @switch($proyek->stage)
                                                                @case("1")
                                                                    Pasar Dini
                                                                    @break
                                                                @case("2")
                                                                    Pasar Potensial
                                                                    @break
                                                                @case("3")
                                                                    Prakualifikasi
                                                                    @break
                                                                @case("4")
                                                                    Tender Diikuti
                                                                    @break
                                                                @case("5")
                                                                    Perolehan
                                                                    @break
                                                                @case("6")
                                                                    Menang
                                                                    @break
                                                                @case("7")
                                                                    Terkontrak
                                                                    @break
                                                                @case("8")
                                                                    Approval
                                                                    @break
                                                                @case("9")
                                                                    Selesai
                                                                    @break
                                                                @default
                                                                    Kosong
                                                            @endswitch
														</td>
														<!--end::Nama Proyek=-->

														<!--begin::Created at=-->
														<td>
															{{ date_format(new DateTime($proyek->created_at), "d M Y") }}
														</td>
														<!--end::Created at=-->
														
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
@endsection
