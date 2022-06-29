@extends('template.main')
@section('title', 'Contract Management')
<!--begin::Main-->
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Contract
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <a href="contract-management/view" class="btn btn-sm btn-primary w-80px"
                                    id="kt_toolbar_primary_button" style="background-color:#ffa62b; padding: 6px">
                                    New</a>
                                <!--end::Button-->

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
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">


                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-">

                            <!--begin::Card title-->
                            <div class="card-title" style="width: 100%">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15"
                                        placeholder="Search Contract" />
                                    <!--end::Search-->


                                    {{-- begin::pagination --}}
                                    {{-- end::pagination --}}
                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">No.Kontrak</th>
                                        <th class="min-w-auto">Proyek</th>
                                        <th class="min-w-auto">Proses Kontrak</th>
                                        <th class="min-w-auto">Tanggal Mulai Kontrak</th>
                                        <th class="min-w-auto">Tanggal Akhir kontrak</th>
                                        <th class="min-w-auto">Nilai Perolehan</th>
                                        <th class="min-w-auto text-center">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($contracts as $contract)
                                        <tr>

                                            <!--begin::Name=-->
                                            <td>
                                                <a href="/contract-management/view/{{ $contract->id_contract }}"
                                                    class="text-gray-800 text-hover-primary mb-1">
                                                    {{ $contract->id_contract }}</a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Email=-->
                                            <td>
                                                @isset($contract->project)
                                                    <a href="/proyek/view/{{ $contract->project->id }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $contract->project->nama_proyek }}</a>
                                                @else
                                                    <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                        Kosong</a>
                                                @endisset
                                            </td>
                                            <!--end::Email=-->

                                            <!--begin::Payment method=-->
                                            <td>
                                                {{ $contract->contract_proceed }}</td>
                                            <!--end::Payment method=-->
                                            <!--begin::Date=-->
                                            <td>{{ date_format($contract->contract_in, 'd M Y') }}</td>
                                            <!--end::Date=-->
                                            <!--begin::Action=-->
                                            <td>
                                                {{ date_format($contract->contract_out, 'd M Y') }}
                                            </td>
                                            <!--end::Action=-->
                                            <!--begin::Action=-->
                                            <td>
                                                {{ number_format($contract->value, 3, ',', ',') }}
                                            </td>
                                            <!--end::Action=-->

                                            <!--begin::Button Delete=-->
                                            <td class="text-center">
                                                    {{-- <a href="/contract-management/{{ $contract->id_contract }}/delete"
                                                        class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        Delete
                                                    </a> --}}
                                                    <a data-bs-toggle="modal" data-bs-target="#kt_modal_delete{{ $contract->id_contract }}" id="modal-delete"
                                                        class="btn btn-sm btn-light btn-active-primary">Delete</a>
                                            </td>
                                            <!--end::Button Delete=-->
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

    <!--end::Modals-->
    @endsection
    
<!--begin::modal DELETE-->
    @foreach ($contracts as $contract)
	<form action="/contract-management/{{ $contract->id_contract }}/delete" method="post" enctype="multipart/form-data">
        @method('delete')
        @csrf
        <div class="modal fade" id="kt_modal_delete{{ $contract->id_contract }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Hapus : Nomor Kontrak {{ $contract->id_contract }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <i class="bi bi-x-lg text-white"></i>
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