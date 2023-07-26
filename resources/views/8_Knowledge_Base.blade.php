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
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
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
                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                            
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="button" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_tambah_faq" id="tambah-faq"
                                    style="background-color:#008CB4; padding: 7px 30px 7px 30px">
                                    New</button>
                                <!--end::Button-->

                                <!--begin::Wrapper-->
                                {{-- <div class="me-4" style="margin-left:10px;">
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
                                </div> --}}
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
                        <div class="card-header border-0 pt-2">

                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <form class="d-flex flex-row w-auto" action=""  method="get">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6 mt-4">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="cari" name="cari" value="{{ $cari }}"
                                            class="form-control form-control-solid ps-15" placeholder="Judul/Deskripsi FAQ" />

                                        <!--begin:: Filter-->
                                        <button hidden type="submit" class="btn btn-sm btn-light btn-active-primary ms-4" id="kt_toolbar_primary_button">
                                        Filter</button>
                                        <!--end:: Filter-->

                                        <!--begin:: RESET-->
                                        <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-2" 
                                        onclick="resetFilter()"  id="kt_toolbar_primary_button">Reset</button>
                                        <script>
                                            function resetFilter() {
                                                $("#cari").text({
                                                    minimumResultsForSearch: -1
                                                }).val("").trigger("change");
                                            }
                                        </script>
                                        <!--end:: RESET-->
                                </form>
                                <!--end::Search-->
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
                                <pre class="card-text" style="font-family: Poppins;white-space: pre-wrap;word-wrap: break-word;">{{ $faq->deskripsi }}</pre>
                                @if (!empty($faq->link))
                                    <i><a target="_blank" href="{{ $faq->link }}" id="link1">klik disini untuk menuju link : {{ $faq->link }}</a></i>
                                @endif
                                
                                <div class="mt-3 d-flex justify-content-between d-inline align-items-center">
                                    @if (!$faq->faq_attachment)
                                    <a type="button" class="text-gray-500 text-hover-secondary">
                                    Attachement : <i> Attachment Tidak Tersedia </i></a>
                                    
                                        @if (auth()->user()->check_administrator)

                                            {{-- <a type="submit" class="btn btn-sm btn-light btn-active-primary px-0px py-0px" id="proyek_new_save">Delete</a> --}}
                                                <!--begin::Action=-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $faq->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                <!--end::Action=-->
                                        @endif
                                    @else
                                    <a target="_blank" href="{{ asset('faqs/'.$faq->faq_attachment) }}" type="button" class="text-gray-500 text-hover-primary">
                                    Attachement : {{ $faq->faq_attachment }}</a>
                                        
                                        @if (auth()->user()->check_administrator)

                                            {{-- <a type="submit" class="btn btn-sm btn-light btn-active-primary px-0px py-0px" id="proyek_new_save">Delete</a> --}}
                                                <!--begin::Action=-->
                                                    <button data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete{{ $faq->id }}"
                                                        id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete
                                                    </button>
                                                <!--end::Action=-->
                                        @endif
                                    @endif
                                </div>

                                <hr class="text-secondary border-1 opacity-75">
                            </div>

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

{{-- begin::modal Edit faq --}}
        @foreach ($faqs as $faq)
            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                <form action="/knowledge-base/update" method="post" enctype="multipart/form-data"> 
                    @csrf

                    <!--begin:: id_customer selected-->
                    <input type="hidden" name="id" value="{{ $faq->id }}" id="id">
                    <!--end:: id_customerid-->

                    <div class="modal fade" id="kt_modal_edit_faq{{ $faq->id }}" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-800px">
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
                                            <textarea rows="12" class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;">{{ $faq->deskripsi }}</textarea>
                                            <!--end::Input-->

                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span style="font-weight: normal">Attachement : </span>
                                            </label>

                                            @if (! $faq->faq_attachment )
                                                <input class="form-control form-control-md form-control-solid" id="faq-attachment" name="faq-attachment" type="file">
                                            @endif
                                            <a target="_blank" href="{{ asset('faqs/'.$faq->faq_attachment) }}" type="button" class="text-gray-500 text-hover-primary">
                                                {{ $faq->faq_attachment }}</a>
                                           <!--end::Label-->
                                           
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span style="font-weight: normal">Link :</span>
                                            </label>
                                            <!--end::Label-->
                
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" name="faq-link" id="faq-link"
                                                style="font-weight: normal" value="{{ $faq->link }}" placeholder="Masukan Link Web ( Jika Ada )">
                                            <!--end::Input-->
                
                
                                        </div><br>
                                    </div>
                                    <div class="modal-footer">
                                            
                                        <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save" style="background-color:#008CB4" >Update</button>
                                        
                
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
                    <div class="modal-dialog modal-dialog-centered mw-800px">
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
                                            style="font-weight: normal" value="{{ $faq->judul }}" placeholder="Input Judul" readonly>
                                        <!--end::Input-->
            
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Deskripsi :</span>
                                        </label>
                                        <!--end::Label-->
            
                                        <!--begin::Input-->
                                        {{-- <input type="text" class="form-control form-control-solid" name="deskripsi" id="deskripsi"
                                            style="font-weight: normal" value="{{ $faq->deskripsi }}" placeholder="Input Deskripsi"> --}}
                                        <textarea rows="12" class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;" readonly>{{ $faq->deskripsi }}</textarea>
                                        <!--end::Input-->

                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Attachement : </span>
                                        </label>
                                        <a target="_blank" href="{{ asset('faqs/'.$faq->faq_attachment) }}" type="button" class="text-gray-500 text-hover-primary">
                                            {{ $faq->faq_attachment }}</a>
                                        <!--end::Label-->
                                        {{-- <iframe src="{{ asset('faqs/'.$faq->faq_attachment) }}"></iframe> --}}

            
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
        @endforeach
{{-- end::modal Edit faq --}}

{{-- begin::modal Tambah faq --}}
	<form action="/knowledge-base/new" method="post" enctype="multipart/form-data"> 
    @csrf
    <div class="modal fade" id="kt_modal_tambah_faq" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
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
							<textarea rows="12" class="form-control form-control-solid" name="deskripsi" id="deskripsi" style="min-height:100px;" placeholder="Input Deskripsi"></textarea>
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachement :</span>
                            </label>
                            <!--end::Label-->
                            
                            <!--begin::Input-->
                            <div>
                                <input class="form-control form-control-md form-control-solid" id="faq-attachment" name="faq-attachment" type="file">
                            </div>
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-6">
                                <span style="font-weight: normal">Link :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="faq-link" id="faq-link"
                                style="font-weight: normal" value="" placeholder="Masukan Link Web ( Jika Ada )">
                            <!--end::Input-->


                        </div><br>
                    </div>
                    <div class="modal-footer">

						<button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save" style="background-color:#008CB4" >Save</button>

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



<!--begin::modal DELETE-->
    @foreach ($faqs as $faq)
        <form action="/knowledge-base/delete/{{ $faq->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $faq->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $faq->judul }}</h2>
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
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
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
    @endforeach
<!--end::modal DELETE-->


{{-- end::modal --}}

@endsection
{{-- End:: Content --}}
