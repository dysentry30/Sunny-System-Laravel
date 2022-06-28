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
                                                <i class="bi bi-file-earmark-word"></i>
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

                    {{-- begin::Alert --}}
                    {{-- Display Error --}}
                    {{-- @if (Session::has('success'))
                        <div class="alert fade alert-success d-flex align-items-center show" style="margin-bottom: 2rem;" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                <symbol id="check-circle-fill" fill="#0f5132" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                </symbol>
                            </svg>

                            <div style="color: #0f5132;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                {{Session::get("success")}}
                            </div>
                        </div>
                    @endif
                    @if (Session::has('failed'))
                        <div class="alert fade alert-danger d-flex align-items-center show" style="margin-bottom: 2rem;" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                                <symbol id="exclamation-triangle-fill" fill="#842029" viewBox="0 0 16 16">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </symbol>
                            </svg>

                            <div style="color: #842029;">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                {{Session::get("failed")}}
                            </div>
                        </div>
                    @endif --}}
                    {{-- end::Alert --}}

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
                        <br>

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