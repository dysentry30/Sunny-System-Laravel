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
									<a href="#" class="btn btn-sm btn-primary w-80px"
									data-bs-toggle="modal" 
									data-bs-target="#kt_modal_create" 
									id="kt_toolbar_primary_button"
									style="background-color:#ffa62b; padding: 6px">
									New</a>

								<!--begin::Wrapper-->
								<div class="me-4" style="margin-left:10px;">
									<!--begin::Menu-->
									<a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
										<i class="bi bi-folder2-open"></i>Action</a>
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
										<div class="">
											<!--begin::Item-->
											<button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
												data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
												<i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
											</button>
											<button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
												data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export">
												<i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
											</button>
											<!--end::Item-->
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
														<i class="bi bi-search"></i>
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
														<th class="min-w-auto">Nama Team</th>
														<th class="min-w-auto">Nama Proyek</th>
														<th class="min-w-auto">Kode Proyek</th>
														<th class="min-w-auto text-center">Proyek Stage</th>
														{{-- <th class="text-center">Action</th> --}}
													</tr>
													<!--end::Table row-->
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												@php
												// $companies = $companies->reverse();
												$no = 1;
												@endphp
												@foreach ($teams as $teamProyek)
												
												<tbody class="fw-bold text-gray-600">
													<tr>
														
														<!--begin::No=-->
														<td>
															{{ $no++ }}
														</td>
														<!--end::No=-->

														<!--begin::nama Team-->
														<td>
															{{ $teamProyek->User->name}}
														</td>
														<!--end::nama Team-->

														<!--begin::Nama Proyek=-->
														<td>
															<a href="/proyek/view/{{ $teamProyek->kode_proyek }}" class="text-hover-primary text-gray-500">{{ $teamProyek->Proyek->nama_proyek }}</a>
														</td>
														<!--end::Nama Proyek=-->
														<!--begin::Nama Proyek=-->
														<td>
															<a href="/proyek/view/{{ $teamProyek->kode_proyek }}" class="text-hover-primary text-gray-500">{{ $teamProyek->kode_proyek }}</a>
														</td>
														<!--end::Nama Proyek=-->
														
														<!--begin::Nama Proyek=-->
														<td class="text-center">
                                                            @switch($teamProyek->Proyek->stage)
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
														{{-- <td>
															{{ date_format(new DateTime($teamProyek->created_at), "d M Y") }}
														</td> --}}
														<!--end::Created at=-->
														
														<!--begin::Action=-->
														{{-- <td class="text-center">
														<!--begin::Button-->
															<form action="#" method="post" class="d-inline" >
																@method('delete')
																@csrf
																<button class="btn btn-sm btn-light btn-active-primary" onclick="return confirm('Deleted file can not be undo. Are You Sure ?')">Delete</button>
															</form>
														<!--end::Button-->
														</td> --}}
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
