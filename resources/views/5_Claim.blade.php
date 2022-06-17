{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Claim Managements')
{{-- end:: title --}}

{{-- begin:: content --}}
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

        <!--begin::Header-->
        @extends('template.header')
        <!--end::Header-->

        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Toolbar-->
            <div class="toolbar" id="kt_toolbar">
                <!--begin::Container-->
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <!--begin::Title-->
                        <h1 class="d-flex align-items-center fs-3 my-1">Claim Managements
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">

<!--begin::Wrapper-->
                        {{-- <div class="me-4" style="margin-left:10px;">
                            <!--begin::Menu-->
                            <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Action
                            </a>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_6155ac804a1c2">
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
                        </div> --}}
<!--end::Wrapper-->


                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <div class="row">
                <div class="col d-flex justify-content-center">
                    @if (Session::has('success'))
                        {{-- begin::Alert --}}
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="#54d2b6" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                        </svg>
                        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div class="text-success">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                        </div>
                        {{-- end::Alert --}}
                    @endif
                </div>
            </div>


            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-fluid">
                    <!--begin::Contacts App- Edit Contact-->
                    <div class="row">


                <!--begin::All Content-->
                <div class="col-xl-15">
                    <!--begin::Contacts-->
                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                        <!--begin::Card body-->
                        <div class="card-body pt-5">

<!--begin::Table Claim-->
				<table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_proyek_table">
					<!--begin::Table head-->
					<thead>
						<!--begin::Table row-->
						<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
							<th class="min-w-auto">Kode Proyek</th>
							<th class="min-w-auto">Nama Proyek</th>
							<th class="min-w-auto">ID Contract</th>
							<th class="min-w-auto"><center>Total Claim</center></th>
							{{-- <th class=""><center>Action</center></th> --}}
						</tr>
						<!--end::Table row-->
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						@foreach ($proyek_with_claim as $claimProyek)
						<tbody class="fw-bold text-gray-600">
							<tr>
								
							<!--begin::Name=-->
							<td>
								<a href="/claim-management/proyek/{{ $claimProyek->id }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claimProyek->kode_proyek }}</a>
							</td>
							<!--end::Name=-->
							<!--begin::Email=-->
							<td>
                                {{ $claimProyek->nama_proyek }}
							</td>
							<!--end::Email=-->
							<!--begin::Email=-->
							<td>
                                <a href="/contract-management/view/{{ $claimProyek->ContractManagements->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claimProyek->ContractManagements->id_contract }}</a>
							</td>
							<!--end::Email=-->
							<!--begin::Company=-->
							<td>
								<center>
                                    {{ count($claimProyek->ClaimManagements) }}
                                </center>
							</td>
							<!--end::Company=-->
							<!--begin::Action=-->
							<td>
							<!--begin::Button-->
							{{-- <form action="/claim/delete/{{ $proyek->id }}" method="post" class="d-inline" >
								@method('delete')
								@csrf
								<center>
									<button class="btn btn-sm btn-light btn-active-primary" onclick="return confirm('Deleted file can not be undo. Are You Sure ?')">Delete</button>
								</center>
							</form> --}}
							<!--end::Button-->
							</td>
							<!--end::Action=-->
						</tr>
						@endforeach
							
					</tbody>
				</table>
<!--end::Table -->

                </div>
                <!--end:::Tab isi content-->

                </div>
                <!--end::Card body-->

            </div>
            <!--end::Content-->
            </form>
            <!--end::Form-->
            
        </div>
        <!--end::Contacts App- Edit Contact-->


    </div>
    <!--end::Container-->
    </div>
    <!--end::Post-->


        </div>
        <!--end::Content-->
    </div>
@endsection
{{-- end:: content --}}

@section('aside')
    @include('template.aside')
@endsection


@section('js-script')


@endsection