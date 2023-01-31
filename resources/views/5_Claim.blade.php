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
                        <h1 class="d-flex align-items-center fs-3 my-1">Claim Managements
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <!--begin::Wrapper-->
                         <!--begin::Button-->
                         <a type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                         style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                         data-bs-target="#kt_modal_input_perubahan_kontrak">
                         New</a>
                        <!--end::Button-->

                        <!--begin::Button-->
                        {{-- <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                            style="background-color:#f3f6f9;margin-left:10px;color: black;">
                            Close</a> --}}
                        <!--end::Button-->
                        <!--end::Wrapper-->

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
                    <div class="row">


                        <!--begin::All Content-->
                        <div class="col-xl-15">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-1">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        {{-- <div class="d-flex align-items-center position-relative my-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <input type="text" data-kt-customer-table-filter="search"
                                                class="form-control form-control-solid w-250px ps-15" placeholder="Search Addendum" />
                                        </div> --}}
                                        <!--end::Search-->

                                        <!--Begin:: BUTTON FILTER-->
                                        <form action="#" class="d-flex flex-row w-auto" method="get">
                                            <!--Begin:: Select Options-->
                                            <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                                <option {{$column == "" ? "selected": ""}}></option>
                                                <option value="id_contract" {{$column == "id_contract" ? "selected" : ""}}>ID Contract</option>
                                                <option value="kode_proyek" {{$column ==    "kode_proyek" ? "selected" : ""}}>Kode Proyek</option>
                                                {{-- <option value="uraian_perubahan" {{$column == "uraian_perubahan" ? "selected" : ""}}>Uraian Perubahan</option> --}}
                                            </select>
                                            <!--End:: Select Options-->
                                            
                                            <!--begin:: Input Filter-->
                                            <div class="d-flex align-items-center position-relative">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}"
                                                class="form-control form-control-solid ms-2 ps-12 w-auto" placeholder="Input Filter" />
                                            </div>
                                            <!--end:: Input Filter-->
                                            
                                            <!--begin:: Filter-->
                                            <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4" id="kt_toolbar_primary_button">
                                            Filter</button>
                                            <!--end:: Filter-->
                                            
                                            <!--begin:: RESET-->
                                            <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-2" 
                                            onclick="resetFilter()"  id="kt_toolbar_primary_button">Reset</button>
                                            <script>
                                                function resetFilter() {
                                                    $("#column").select2({
                                                        minimumResultsForSearch: -1
                                                    }).val("").trigger("change");
                                                    
                                                    $("#filter").text({
                                                        minimumResultsForSearch: -1
                                                    }).val("").trigger("change");
                                                }
                                            </script>
                                            <!--end:: RESET-->
                                        </form>
                                        <!--end:: BUTTON FILTER-->
                                    </div>
                                    <!--begin::Card title-->

                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-5">

                                        <!--begin:::Tabs Navigasi-->    
                                        <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                    href="#kt_user_view_claim_VO" style="font-size:14px;">VO</a>
                                            </li>
                                            <!--end:::Tab item Claim-->

                                            <!--begin:::Tab item Claim-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                    href="#kt_user_view_claim" style="font-size:14px;">Claim</a>
                                            </li>
                                            <!--end:::Tab item Claim-->

                                            <!--begin:::Tab item Anti Claim-->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_anticlaim"
                                                    style="font-size:14px;">Anti Claim</a>
                                            </li>
                                            <!--end:::Tab item Anti Claim-->

                                            <!--begin:::Tab item -->
                                            <li class="nav-item">
                                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                    data-bs-toggle="tab" href="#kt_user_view_overview_asuransi"
                                                    style="font-size:14px;">Claim Asuransi</a>
                                            </li>
                                            <!--end:::Tab item -->
                                        </ul>
                                        <!--end:::Tabs Navigasi-->

                                        <!--begin:::Tab isi content  -->
                                    <div class="tab-content" id="myTabContent">

                                        <!--begin:::Tab Claim-->
                                        <div class="tab-pane fade" id="kt_user_view_claim" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                        <th class="min-w-auto">Nama Proyek</th>
                                                        <th class="min-w-auto">Unit Kerja</th>
                                                        <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @forelse ($proyekClaim as $proyekClaims);
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $proyekClaims->ContractManagement->project->kode_proyek }}/Klaim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagement->project->kode_proyek }}</a>
                                                                </td>
                                                                <!--end::Name-->
                                                                <!--begin::Name Proyek-->
                                                                <td>
                                                                    {{ $proyekClaims->ContractManagement->project->nama_proyek }}
                                                                </td>
                                                                <!--end::Name Proyek-->
                                                                <!--begin::Unit Kerja-->
                                                                <td>
                                                                    {{ $proyekClaims->ContractManagement->project->UnitKerja->unit_kerja }}
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Action-->
                                                                <td>
                                                                    <a href="/contract-management/view/{{ $proyekClaims->ContractManagement->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagement->id_contract }}</a>
                                                                </td>
                                                                <!--end::Action-->
                                                            </tr>
                                                    @empty
                                                        <tr class="bg-gray-100 text-center">
                                                            <td colspan="4">Data Klaim tidak ditemukan</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!--end::Table -->
                                        </div>
                                        <!--end:::Tab Claim-->


                                        <!--begin:::Tab Anti Claim-->
                                        <div class="tab-pane fade" id="kt_user_view_overview_anticlaim" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                        <th class="min-w-auto">Nama Proyek</th>
                                                        <th class="min-w-auto">Unit Kerja</th>
                                                        <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                        {{-- <th class="min-w-auto">Total</th> --}}
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                {{-- @foreach ($claims as $claim) --}}
                                                    @forelse ($proyekAnti as $proyekAntis)
                                                        <tr>
                                                            <!--begin::Name-->
                                                            <td>
                                                                <a href="/claim-management/proyek/{{ $proyekAntis->ContractManagement->project->kode_proyek }}/Anti-Klaim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->ContractManagement->project->kode_proyek }}</a>
                                                            </td>
                                                            <!--end::Name-->
                                                            <!--begin::Name Proyek-->
                                                            <td>
                                                                {{ $proyekAntis->ContractManagement->project->nama_proyek }}
                                                            </td>
                                                            <!--end::Name Proyek-->
                                                            <!--begin::Unit Kerja-->
                                                            <td>
                                                                {{ $proyekAntis->ContractManagement->project->UnitKerja->unit_kerja }}
                                                            </td>
                                                            <!--end::Unit Kerja-->
                                                            <!--begin::Action-->
                                                            <td>
                                                                <a href="/contract-management/view/{{ $proyekAntis->ContractManagement->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->ContractManagement->id_contract }}</a>
                                                            </td>
                                                            <!--end::Action-->
                                                        </tr>
                                                @empty
                                                    <tr class="bg-gray-100 text-center">
                                                        <td colspan="4">Data Klaim tidak ditemukan</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                            <!--end::Table -->
                                        </div>
                                        <!--end:::Tab Anti Claim-->


                                        <!--begin:::Tab Claim Asuransi-->
                                        <div class="tab-pane fade" id="kt_user_view_overview_asuransi" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                        <th class="min-w-auto">Nama Proyek</th>
                                                        <th class="min-w-auto">Unit Kerja</th>
                                                        <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                        {{-- <th class="min-w-auto">Total</th> --}}
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @forelse ($proyekAsuransi as $proyekAsuransis)
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $proyekAsuransis->ContractManagement->project->kode_proyek }}/Klaim-Asuransi" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->ContractManagement->project->kode_proyek }}</a>
                                                                </td>
                                                                <!--end::Name-->
                                                                <!--begin::Name Proyek-->
                                                                <td>
                                                                    {{ $proyekAsuransis->ContractManagement->project->nama_proyek }}
                                                                </td>
                                                                <!--end::Name Proyek-->
                                                                <!--begin::Unit Kerja-->
                                                                <td>
                                                                    {{ $proyekAsuransis->ContractManagement->project->UnitKerja->unit_kerja }}
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Action-->
                                                                <td>
                                                                    <a href="/contract-management/view/{{ $proyekAsuransis->ContractManagement->no_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->ContractManagement->id_contract }}</a>
                                                                </td>
                                                                <!--end::Action-->
                                                            </tr>
                                                    @empty
                                                        <tr class="bg-gray-100 text-center">
                                                            <td colspan="4">Data Klaim tidak ditemukan</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!--end::Table -->
                                        </div>
                                        <!--end:::Tab pane Claim Asuransi-->

                                        <!--begin:::Tab Jenis VO-->
                                        <div class="tab-pane fade show active" id="kt_user_view_claim_VO" role="tabpanel">
                                            <!--begin::Table Claim-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                id="kt_proyek_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                        <th class="min-w-auto">Nama Proyek</th>
                                                        <th class="min-w-auto">Unit Kerja</th>
                                                        <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                        {{-- <th class="min-w-auto">Total</th> --}}
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @forelse ($proyekVos as $proyekVo)
                                                            <tr>
                                                                <!--begin::Name-->
                                                                <td>
                                                                    <a href="/claim-management/proyek/{{ $proyekVo->ContractManagement->project->kode_proyek }}/VO" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekVo->ContractManagement->project->kode_proyek }}</a>
                                                                </td>
                                                                <!--end::Name-->
                                                                <!--begin::Name Proyek-->
                                                                <td>
                                                                    {{ $proyekVo->ContractManagement->project->nama_proyek }}
                                                                </td>
                                                                <!--end::Name Proyek-->
                                                                <!--begin::Unit Kerja-->
                                                                <td>
                                                                    {{ $proyekVo->ContractManagement->project->UnitKerja->unit_kerja }}
                                                                </td>
                                                                <!--end::Unit Kerja-->
                                                                <!--begin::Action-->
                                                                <td>
                                                                    <a href="/contract-management/view/{{ $proyekVo->ContractManagement->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekVo->ContractManagement->id_contract }}</a>
                                                                </td>
                                                                <!--end::Action-->
                                                            </tr>
                                                    @empty
                                                        <tr class="bg-gray-100 text-center">
                                                            <td colspan="4">Data Klaim tidak ditemukan</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!--end::Table -->
                                        </div>
                                        <!--end:::Tab pane Claim Asuransi-->

                                        <!--Begin::Modal Perubahan Kontrak-->
                                        <div class="modal fade" id="kt_modal_input_perubahan_kontrak" tabindex="-1" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-700px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <!--begin::Modal title-->
                                                        <h2>Add Perubahan Kontrak</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                        height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                                        fill="black" />
                                                                    <rect x="7.41422" y="6" width="16" height="2"
                                                                        rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <!--end::Modal header-->
                                                    <!--begin::Modal body-->
                                                    <div class="modal-body py-lg-6 px-lg-6">
                                    
                                                        <!--begin::Input group Website-->
                                                        <form action="/perubahan-kontrak/upload" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            {{-- <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                                                name="id-contract"> --}}
                                                            <input type="hidden" class="modal-name" name="modal-name">
                                                            <br>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Nama Proyek</span>
                                                                    </label>
                                                                    <select name="kode-proyek" id="nama-proyek" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Jenis Perubahan" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        @foreach ($proyeks as $proyek)
                                                                        <option value="{{ $proyek->kode_proyek }}">{{ $proyek->nama_proyek }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Jenis Perubahan</span>
                                                                    </label>
                                                                    <select name="jenis-perubahan" id="jenis-perubahan" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Perubahan" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        <option value="VO">Variation Order (VO)</option>
                                                                        <option value="Klaim">Klaim</option>
                                                                        <option value="Anti Klaim">Anti Klaim</option>
                                                                        <option value="Klaim Asuransi">Klaim Asuransi</option>
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Perubahan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="tanggal-perubahan" class="form-control form-control-solid">
                                                                </div>
                                                            </div>
                                    
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Uraian Perubahan</span>
                                                                    </label>
                                                                    <textarea cols="2" name="uraian-perubahan" class="form-control form-control-solid"></textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">No Proposal Klaim</span>
                                                                    </label>
                                                                    <input type="text" name="proposal-klaim" class="form-control form-control-solid"/>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Pengajuan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="tanggal-pengajuan" class="form-control form-control-solid"/>
                                                                </div>
                                                                <div class="col mt-3">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Biaya Pengajuan</span>
                                                                    </label>
                                                                    <input type="text" name="biaya-pengajuan" class="form-control form-control-solid reformat"/>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Waktu Pengajuan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="waktu-pengajuan" class="form-control form-control-solid"/>
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->
                                                            <div class="modal-footer mt-4">
                                                                <button type="submit" id="save-perubahan-kontrak"
                                                                    class="btn btn-sm btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                    
                                    
                                                    </div>
                                                    <!--end::Modal body-->
                                                </div>
                                                <!--end::Modal content-->
                                            </div>
                                            <!--end::Modal dialog-->
                                        </div>
                                        <!--End::Modal Perubahan Kontrak-->

                                    </div>
                                    <!--end:::Tab isi content-->                            

                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--End::Contacts-->


                        </div>
                        <!--end::All Content-->
            
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

{{-- @section('aside')
    @include('template.aside')
@endsection --}}


@section('js-script')


@endsection