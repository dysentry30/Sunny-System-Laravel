{{-- Begin:: Template main --}}
@extends('template.main')
{{-- End:: Template main --}}

{{-- Begin:: Title --}}
@section('title', 'Knowledge Base')
{{-- Begin:: Title --}}

{{-- Begin:: Content --}}
@section('content')
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            @extends('template.aside')
            <!--begin::Wrapper-->
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Knowledge - Base
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    @if (auth()->user()->check_administrator)
                    
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">

                        <!--begin::Button-->
                        <button type="button" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_tambah_faq" id="tambah-faq"
                            style="background-color:#ffa62b; padding: 7px 30px 7px 30px">
                            New</button>
                        <!--end::Button-->

                        <!--begin::Wrapper-->
                        <div class="me-4" style="margin-left:10px;">
                            <!--begin::Menu-->
                            <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi-folder2-open"></i>Action</a>
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
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
                                        <label class="form-label" style="margin-left:5px;">
                                            Export Excel</label><br>
                                        <i class="bi bi-file-earmark-spreadsheet"></i>
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
            <!--begin::Card-->
            <div class="card" id="List-vv">


                <!--begin::Card header-->
                <div class="card-header border-0 pt-">

                    <!--begin::Card title-->
                    <div class="card-title" style="width: 100%">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center my-1" style="width: 100%;">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-15" placeholder="Search FAQ">
                            <!--end::Search-->
                        </div>
                    </div>
                    <!--begin::Card title-->
                </div>
				<br>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">

					@foreach ($faqs as $i => $faq)
					<div class="card">
						  <h6 type="button" data-bs-toggle="modal"
							data-id="{{ $faq->id }}" data-bs-target="#kt_modal_edit_faq{{ $faq->id }}"
							class="text-gray-500 text-hover-primary">
							{{ ++$i }}. {{ $faq->judul }}</h6>
						  <p class="card-text">{{ $faq->deskripsi }}</p>
						  <hr class="text-secondary border-1 opacity-75">
					</div>
                    @if (auth()->user()->check_administrator)

{{-- begin::modal Edit faq --}}
				<form action="/knowledge-base/update" method="post" enctype="multipart/form-data"> 
					@csrf

					<!--begin:: id_customer selected-->
                    <input type="hidden" name="id" value="{{ $faq->id }}" id="id">
                    <!--end:: id_customerid-->

					<div class="modal fade" id="kt_modal_edit_faq{{ $faq->id }}" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-dialog-centered mw-900px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header">
									<!--begin::Modal title-->
									<h2>{{ $faq->judul }}</h2>
									<!--end::Modal title-->
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
										<span class="svg-icon svg-icon-1">
											<span class="svg-icon svg-icon-1">
												<i class="bi bi-x-lg"></i>
											</span>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Close-->
								</div>
								<!--end::Modal header-->
								<!--begin::Modal body-->
								<div class="modal-body py-lg-6 px-lg-6">

									<!--begin::Input group Website-->
									<div class="fv-row">
										<div class="fv-row">
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span style="font-weight: normal">Judul :</span>
											</label>
											<!--end::Label-->
				
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="judul" id="judul"
												style="font-weight: normal" value="{{ $faq->judul }}" placeholder="Input Judul">
											<!--end::Input-->
				
											<!--begin::Label-->
											<label class="fs-6 fw-bold form-label mt-3">
												<span style="font-weight: normal">Deskripsi :</span>
											</label>
											<!--end::Label-->
				
											<!--begin::Input-->
											{{-- <input type="text" class="form-control form-control-solid" name="deskripsi" id="deskripsi"
												style="font-weight: normal" value="{{ $faq->deskripsi }}" placeholder="Input Deskripsi"> --}}
											<textarea class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;">{{ $faq->deskripsi }}</textarea>
											<!--end::Input-->

                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span style="font-weight: normal">Attachement : File Lorem Ipsum.docx</span>
                                            </label>
                                            <!--end::Label-->
				
				
										</div><br>
				
										<button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save" style="background-color:#ffa62b" >Update</button>
				
									</div>
									<!--end::Input group-->

								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
				</form>
                @else 
                <div class="modal fade" id="kt_modal_edit_faq{{ $faq->id }}" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-900px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>{{ $faq->judul }}</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <span class="svg-icon svg-icon-1">
                                            <i class="bi bi-x-lg"></i>
                                        </span>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body py-lg-6 px-lg-6">

                                <!--begin::Input group Website-->
                                <div class="fv-row">
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Judul :</span>
                                        </label>
                                        <!--end::Label-->
            
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="judul" id="judul"
                                            style="font-weight: normal" value="{{ $faq->judul }}" placeholder="Input Judul">
                                        <!--end::Input-->
            
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Deskripsi :</span>
                                        </label>
                                        <!--end::Label-->
            
                                        <!--begin::Input-->
                                        {{-- <input type="text" class="form-control form-control-solid" name="deskripsi" id="deskripsi"
                                            style="font-weight: normal" value="{{ $faq->deskripsi }}" placeholder="Input Deskripsi"> --}}
                                        <textarea class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;">{{ $faq->deskripsi }}</textarea>
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Attachement : File Lorem Ipsum.docx</span>
                                        </label>
                                        <!--end::Label-->
            
                                    </div><br>
            
                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                @endif
{{-- end::modal Edit faq --}}
					@endforeach

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--end::Container-->
            <!--end::Post-->
        </div>
        <!--end::Content-->
    </div>

    {{-- begin::modal --}}

{{-- begin::modal Tambah faq --}}
	<form action="/knowledge-base/new" method="post" enctype="multipart/form-data"> 
    @csrf
    <div class="modal fade" id="kt_modal_tambah_faq" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Knowledge - Base</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin::Input group Website-->
                    <div class="fv-row">
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Judul :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="judul" id="judul"
                                style="font-weight: normal" value="" placeholder="Input Judul">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Deskripsi :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
							<textarea class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;" placeholder="Input Deskripsi"></textarea>
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachement :</span>
                            </label>
                            <!--end::Label-->
                            
                            <!--begin::Input-->
                            <div>
                                <label for="attachment" class="form-label"></label>
                                <input class="form-control form-control-md form-control-solid" id="doc-attachment" name="doc-attachment" type="file">
                            </div>
                            <!--end::Input-->


                        </div><br>

						<button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save" style="background-color:#ffa62b" >Save</button>

                    </div>
                    <!--end::Input group-->

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
	</form>
{{-- end::modal Tambah faq --}}


    {{-- end::modal --}}

@endsection
{{-- End:: Content --}}
