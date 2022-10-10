@extends('template.main')
@section('title', 'Contract Management')
<!--begin::Main-->
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Contract
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <a href="contract-management/view" class="btn btn-sm btn-primary w-80px"
                                    id="kt_toolbar_primary_button" style="background-color:#008CB4; padding: 6px">
                                    New</a>
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
                                        <div class="">
                                            <!--begin::Item-->
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_import"
                                                id="kt_toolbar_import">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                            </button>
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_export"
                                                id="kt_toolbar_export">
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

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true"
                                                href="#kt_user_view_tender_awal" style="font-size:14px;">Perolehan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->

                                        <!--begin:::Tab item Anti Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_tender_menang"
                                                style="font-size:14px;">Terkontrak</a>
                                        </li>
                                        <!--end:::Tab item Anti Claim-->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_pelaksanaan"
                                                style="font-size:14px;">Pelaksanaan</a>
                                        </li>
                                        <!--end:::Tab item -->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_serah_terima"
                                                style="font-size:14px;">Serah Terima Pekerjaan</a>
                                        </li>
                                        <!--end:::Tab item -->

                                        <!--begin:::Tab item -->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4"
                                                data-bs-toggle="tab" href="#kt_user_view_overview_closing_proyek"
                                                style="font-size:14px;">Closing Proyek</a>
                                        </li>
                                        <!--end:::Tab item -->
                                    </ul>

                                </div>

                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div id="tab-content" class="tab-content">
                                {{-- Begin :: Tab Content Tender Awal --}}
                                <div class="tab-pane fade show active" id="kt_user_view_tender_awal" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @forelse ($proyeks_tender_awal as $proyek)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                            id="click-name"
                                                            class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Email=-->
                                                    <td>
                                                        {{ $proyek->UnitKerja->unit_kerja }}
                                                    </td>
                                                    <!--end::Email=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Tender Awal --}}
                                
                                {{-- Begin :: Tab Content Tender Menang --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_tender_menang" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed" id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @forelse ($proyeks_terkontrak as $proyek)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{-- <a class="text-hover-primary 
                                                                href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}
                                                            </a> --}}
                                                            <a href="/contract-management/view/{{ urlencode(urlencode($proyek->nomor_terkontrak)) }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Email=-->
                                                        <td>
                                                            {{ $proyek->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email=-->
                                                        <!--begin::Action=-->
                                                        <td>
                                                            {{-- <a href="/contract-management/view/{{ $proyek}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagements->id_contract }}</a> --}}
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>
                                                @empty 
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Tender Menang --}}
                                
                                {{-- Begin :: Tab Content Pelaksanaan --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_pelaksanaan" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed" id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @php
                                                $is_data_found = false;
                                            @endphp
                                            @forelse ($proyeks_pelaksanaan_serah_terima as $proyek)
                                                @if ($proyek->stages == 3)
                                                    @php
                                                        $is_data_found = true;
                                                    @endphp
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{-- <a class="text-hover-primary 
                                                    href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}
                                                </a> --}}
                                                            <a href="/contract-management/view/{{ $proyek->ContractManagements->id_contract }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Email=-->
                                                        <td>
                                                            {{ $proyek->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email=-->
                                                        <!--begin::Action=-->
                                                        <td>
                                                            {{-- <a href="/contract-management/view/{{ $proyek}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagements->id_contract }}</a> --}}
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>
                                                    @endif
                                                @empty 
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                @if (!$is_data_found && $proyeks_pelaksanaan_serah_terima->count() > 0)
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Pelaksanaan --}}
                                
                                {{-- Begin :: Tab Content Serah Terima Pekerjaan --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_serah_terima" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed" id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @php
                                                $is_data_found = false
                                            @endphp
                                            @forelse ($proyeks_pelaksanaan_serah_terima as $proyek)
                                                @if ($proyek->stages == 4)
                                                    @php
                                                        $is_data_found = true;
                                                    @endphp
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{-- <a class="text-hover-primary 
                                                    href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}
                                                </a> --}}
                                                            <a href="/contract-management/view/{{ $proyek->ContractManagements->id_contract }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                                id="click-name"
                                                                class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Email=-->
                                                        <td>
                                                            {{ $proyek->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email=-->
                                                        <!--begin::Action=-->
                                                        <td>
                                                            {{-- <a href="/contract-management/view/{{ $proyek}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagements->id_contract }}</a> --}}
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>
                                                    @endif
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            @if (!$is_data_found && $proyeks_pelaksanaan_serah_terima->count() > 0)
                                                <tr>
                                                    <td colspan="3">
                                                        <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Serah Terima Pekerjaan --}}

                                {{-- Begin :: Tab Content Closing Proyek --}}
                                <div class="tab-pane fade" id="kt_user_view_overview_closing_proyek" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed" id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                {{-- <th class="min-w-auto">ID Contract</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600 fs-6">
                                            @php
                                                $is_data_found = false
                                            @endphp
                                            @forelse ($proyeks_pelaksanaan_closing_proyek as $proyek)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <a href="/contract-management/view/{{ $proyek->ContractManagements->id_contract }}"
                                                        id="click-name"
                                                        class="text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <a href="/proyek/view/{{ $proyek->kode_proyek }}"
                                                        id="click-name"
                                                        class="text-hover-primary mb-1">{{ $proyek->nama_proyek }}</a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Email=-->
                                                <td>
                                                    {{ $proyek->UnitKerja->unit_kerja }}
                                                </td>
                                                <!--end::Email=-->
                                                <!--begin::Action=-->
                                                <td>
                                                    {{-- <a href="/contract-management/view/{{ $proyek}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagements->id_contract }}</a> --}}
                                                </td>
                                                <!--end::Action=-->
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            @if ($proyeks_pelaksanaan_closing_proyek->count() < 1)
                                                <tr>
                                                    <td colspan="3">
                                                        <p class="text-center bg-gray-200">Data proyek tidak ditemukan</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
                                {{-- End :: Tab Content Closing Proyek --}}

                            </div>
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
{{-- @foreach ($contracts as $contract)
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
    @endforeach --}}
<!--end::modal DELETE-->
