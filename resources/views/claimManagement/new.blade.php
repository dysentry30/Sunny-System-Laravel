{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Claim Managements')
{{-- end:: title --}}

{{-- begin::content --}}
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

        <!--begin::Header-->
        @extends('template.header')
        <!--end::Header-->


        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Toolbar-->
            @isset($claimContract)
                <form action="/claim-management/update" method="post">
                    <input type="hidden" name="id-claim" value="{{ $claimContract->id_claim }}">
                @else
                    <form action="/claim-management/save" method="post">
                    @endisset
                    @csrf
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Claim
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                                    style="background-color:#ffa62b;">
                                    Save</button>
                                <!--end::Button-->

                                <!--begin::Button-->
                                <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                                    style="background-color:#f3f6f9;margin-left:10px;color: black;">
                                    Close</a>
                                <!--end::Button-->


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
                            <div class="row g-7">

                                {{-- begin::Alert --}}
                                @if (Session::has('failed'))
                                    <div class="col">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                            <symbol id="exclamation-triangle-fill" fill="red" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                            </symbol>
                                        </svg>
                                        <div class="alert alert-danger d-flex align-items-center alert-dismissible"
                                            role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                                aria-label="Danger:">
                                                <use xlink:href="#exclamation-triangle-fill" />
                                            </svg>
                                            <div>
                                                {{ Session::get('failed') }}
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- end::Alert --}}
                                @endif
                                @if (Session::has('success'))
                                    <div class="col">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                            <symbol id="check-circle-fill" fill="green" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </symbol>
                                        </svg>
                                        <div class="alert alert-success d-flex align-items-center alert-dismissible"
                                            role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                                aria-label="Success:">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div>
                                                {{ Session::get('success') }}
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                        </div>

                                    </div>
                                    {{-- end::Alert --}}
                                @endif


                                <!--begin::Header Contract-->
                                <div class="col-xl-15">
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                        <form action="/claim-management/save" method="POST">
                                            @csrf
                                            <div class="card-body pt-5">

                                                <!--begin::Row-->
                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->

                                                        <!--begin::Input group Name-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span class="required">No. Claim</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                id="number-claim" name="number-claim"
                                                                value="{{ $kode_claim ?? ($claimContract->id_claim ?? '') }}"
                                                                placeholder="No. Claim" readonly>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group Name-->
                                                    </div>

                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Tanggal Pengajuan</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->

                                                            <a href="#" class="btn btn-sm mx-3"
                                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_calendar"><i
                                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                    style="color: #e08c16"></i></a>
                                                            <input type="Date"
                                                                class="form-control form-control-solid ps-12"
                                                                placeholder="Select a date"
                                                                value="{{ date_format(date_create(old('approve-date') ?? ($claimContract->tanggal_claim ?? '')), 'Y-m-d') }}"
                                                                name="approve-date" id="approve-date">

                                                            {{-- begin::erorr message --}}
                                                            @error('approve-date')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}

                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>

                                                <!--End begin::Row-->
                                                {{-- @dd($proyek); --}}

                                                <div class="row fv-row">

                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="project-id" id="project-id"
                                                                class="form-select form-select-solid select2-hidden-accessible"
                                                                data-control="select2" data-hide-search="true"
                                                                data-placeholder="Pilih Proyek"
                                                                data-select2-id="select2-data-project-id" tabindex="-1"
                                                                aria-hidden="true">
                                                                <option value="{{ $proyek->kode_proyek }}" selected>
                                                                    {{ $proyek->nama_proyek }}</option>
                                                                {{-- @foreach ($projects as $projectAll)
                                                                    <option value="{{ $projectAll->kode_proyek }}"
                                                                        {{ $projectAll->kode_proyek == (old('project-id') ?? ($claimContract->project->kode_proyek ?? $proyek->kode_proyek)) ? 'selected' : '' }}>
                                                                        {{ $projectAll->nama_proyek }}</option>
                                                                @endforeach --}}
                                                                {{-- <option selected data-select2-id="select2-data-2-3jce">Pilih
                                                                Proyek...</option> --}}
                                                            </select>
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            {{-- @error('project-id')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror --}}
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>

                                                    <!--End begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Contract</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select
                                                                class="form-select form-select-solid select2-hidden-accessible"
                                                                name="id-contract" id="id-contract" value=""
                                                                data-control="select2" data-hide-search="true"
                                                                data-select2-id="select2-data-contract-id"
                                                                data-placeholder="Pilih Contract">
                                                                <option value="{{ $currentContract->id_contract }}" sel>
                                                                    {{ $currentContract->id_contract }}</option>
                                                                {{-- @foreach ($contractManagements as $contract)
                                                                    <option value="{{ $contract->id_contract }}"
                                                                        {{ $contract->id_contract == (old('id-contract') ?? ($claimContract->id_contract ?? $currentContract->id_contract)) ? 'selected' : '' }}>
                                                                        {{ $contract->id_contract }}</option>
                                                                @endforeach --}}
                                                            </select>
                                                            <!--end::Input-->
                                                            {{-- begin::erorr message --}}
                                                            {{-- @error('id-contract')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror --}}
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->

                                                </div>
                                                <h6 id="status-msg" style="display: none"></h6>


                                                <!--End begin::Row-->

                                                <div class="row fv-row">

                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>PIC</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                placeholder="Who is responsible for this contract?"
                                                                id="pic" name="pic"
                                                                value="{{ old('pic') ?? ($claimContract->pic ?? '') }}">
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('pic')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->

                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Total Claim</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control form-control-solid"
                                                                name="total-claim" id="total-claim"
                                                                onkeyup="reformatNumber(this)"
                                                                value="{{ number_format((int) ($claimContract->nilai_claim ?? 0), 0, ',', ',') }}"
                                                                placeholder="Type number here..." disabled>
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('total-claim')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>

                                                <!--End begin::Row-->

                                                <div class="row fv-row">

                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>Jenis Claim</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="jenis-claim" id="jenis-claim"
                                                                class="form-select form-select-solid select2-hidden-accessible"
                                                                data-control="select2" data-hide-search="true"
                                                                data-placeholder="Pilih Jenis Claim"
                                                                data-select2-id="select2-data-jenis-claim" tabindex="-1"
                                                                aria-hidden="true">
                                                                @isset($claimContract)
                                                                    <option value="{{ $claimContract->jenis_claim }}"
                                                                        selected>{{ $claimContract->jenis_claim }}</option>
                                                                @else
                                                                    <option value="Claim">Claim</option>
                                                                    <option value="Anti Claim">Anti Claim</option>
                                                                    <option value="Claim Asuransi">Claim Asuransi</option>
                                                                @endisset
                                                            </select>
                                                            <!--end::Input-->

                                                            {{-- begin::erorr message --}}
                                                            @error('project-id')
                                                                <h6 class="text-danger">{{ $message }}</h6>
                                                            @enderror
                                                            {{-- end::erorr message --}}
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>

                                                </div>

                                                <!--End begin::Row-->




                                        </form>

                                    </div>


                                </div>
                            </div>
                            <!--end::Header Contract-->

                            @isset($claimContract)
                                {{-- begin:: Footer --}}
                                <div class="col-xl-15">
                                    <!--begin::Contacts-->
                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                        <!--begin::Card body-->
                                        <div class="card-body pt-5">
                                            <!--begin:::Tabs-->
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8"
                                                role="tablist">

                                                <!--begin:::Tab item Informasi Perusahaan-->
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                        href="#kt_user_view_overview_tab" style="font-size:14px;"
                                                        aria-selected="true" role="tab">Detail Pengajuan</a>
                                                </li>
                                                <!--end:::Tab item Informasi Perusahaan-->

                                                <!--begin:::Tab item History-->
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                                        data-bs-toggle="tab" href="#kt_user_view_overview_history"
                                                        style="font-size:14px;" aria-selected="false" tabindex="-1"
                                                        role="tab">Attachment and Notes</a>
                                                </li>
                                                <!--end:::Tab item History-->
                                            </ul>
                                            <!--end:::Tabs-->

                                            <!--begin:::Tab content -->
                                            <div class="tab-content" id="myTabContent">
                                                <!--Informasi Perusahaan-->
                                                <div class="tab-pane fade show active" id="kt_user_view_overview_tab"
                                                    role="tabpanel">

                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Pengajuan Claim

                                                            <button type="button" class="btn btn-link mx-3 btn-lg"
                                                                id="tambah-pengajuan">+</button>
                                                        </h3>

                                                        <!--begin:Table: Draft Contract-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_pengajuan_claim">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama</th>
                                                                    <th class="min-w-auto">Total</th>

                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @php
                                                                    $approval_claim_array = explode(';', trim($claimContract->approval_claim));
                                                                    array_pop($approval_claim_array);
                                                                @endphp
                                                                @if (count($approval_claim_array) > 0)
                                                                    @foreach ($approval_claim_array as $approval)
                                                                        @php
                                                                            $approval = json_decode($approval);
                                                                        @endphp
                                                                        <tr data-id="{{ $approval[0] }}">
                                                                            <td>
                                                                                <h6><b>{{ $approval[1] }}</b></h6>
                                                                            </td>
                                                                            <td>
                                                                                <h6><b>{{ number_format($approval[2], 0, ',', ',') }}</b>
                                                                                </h6>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    onclick="deleteApprovalClaim(this)"
                                                                                    class="btn btn-sm btn-link">
                                                                                    <i class="bi bi-trash3-fill"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td>
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                            <!--end::Table body-->

                                                        </table>
                                                        <!--End:Table: Draft Contract-->
                                                    </div>
                                                </div>
                                                <!--end:::Tab pane Informasi Perusahaan-->

                                                <!--begin:::Tab pane History-->
                                                <div class="tab-pane fade" id="kt_user_view_overview_history"
                                                    role="tabpanel">
                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">

                                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                            Attachment & Notes

                                                            <button type="button" data-bs-toggle="modal"
                                                                class="btn btn-link mx-3 btn-lg" id="Plus"
                                                                data-bs-target="#kt_modal_create_detail_claim">+</button>
                                                        </h3>

                                                        <!--begin:Table: Draft Contract-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_attachment-notes_claim">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama Dokumen</th>
                                                                    <th class="min-w-auto">Notes</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @forelse ($claimContract->claimDetails as $claimDetail)
                                                                    <tr>
                                                                        <td>
                                                                            <a class="text-hover-primary text-gray-800"
                                                                                href="/document/view/{{ $claimDetail->id_claim_detail }}/{{ $claimDetail->id_document }}">{{ $claimDetail->document_name }}</a>

                                                                        </td>
                                                                        <td>
                                                                            <h6 class="text-gray-800">
                                                                                {{ $claimDetail->document_name }}</h6>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td>
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                            <!--end::Table body-->

                                                        </table>
                                                        <!--End:Table: Draft Contract-->
                                                    </div>
                                                </div>
                                                <!--end:::Tab pane History-->


                                            </div>
                                            <!--end:::Tab content-->

                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Contacts-->
                                </div>
                                {{-- end:: Footer --}}
                            </div>
                        @endisset

                    </div>
        </div>
        </form>
        <!--end::Card body-->
    </div>
    <!--end::Contacts-->
    </div>

    {{-- begin::Modal --}}

    {{-- begin::Calendar --}}
    <!--begin::Modal - Calendar Start -->
    <div class="modal fade" id="kt_modal_calendar" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-300px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Approval Date</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin:: Calendar-->
                    <div class="fv-row mb-5">
                        <div class="calendar" id="approval-date">
                            <div class="calendar__opts">
                                <select name="calendar__month" id="calendar__month">
                                    <option value="1" selected>Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>

                                <select name="calendar__year" id="calendar__year">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option selected>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>

                            <div class="calendar__body">
                                {{-- <div class="calendar__days">
                                <div>M</div>
                                <div>T</div>
                                <div>W</div>
                                <div>T</div>
                                <div>F</div>
                                <div>S</div>
                                <div>S</div>
                            </div> --}}

                                <div class="calendar__dates">
                                    {{-- <div class="calendar__date calendar__date--grey"><span>27</span></div>
                                <div class="calendar__date calendar__date--grey"><span>28</span></div>
                                <div class="calendar__date calendar__date--grey"><span>29</span></div>
                                <div class="calendar__date calendar__date--grey"><span>30</span></div> --}}
                                    <div class="calendar__date"><span>1</span></div>
                                    <div class="calendar__date"><span>2</span></div>
                                    <div class="calendar__date"><span>3</span></div>
                                    <div class="calendar__date"><span>4</span></div>
                                    <div class="calendar__date"><span>5</span></div>
                                    <div class="calendar__date"><span>6</span></div>
                                    <div class="calendar__date"><span>7</span></div>
                                    <div class="calendar__date"><span>8</span></div>
                                    <div class="calendar__date"><span>9</span></div>
                                    <div class="calendar__date"><span>10</span></div>
                                    <div class="calendar__date"><span>11</span></div>
                                    <div class="calendar__date"><span>12</span></div>
                                    <div class="calendar__date"><span>13</span></div>
                                    <div class="calendar__date"><span>14</span></div>
                                    <div class="calendar__date"><span>15</span></div>
                                    <div class="calendar__date">
                                        <span>16</span>
                                    </div>
                                    <div class="calendar__date">
                                        <span>17</span>
                                    </div>
                                    <div class="calendar__date">
                                        <span>18</span>
                                    </div>
                                    <div class="calendar__date"><span>19</span></div>
                                    <div class="calendar__date"><span>20</span></div>
                                    <div class="calendar__date">
                                        <span>21</span>
                                    </div>
                                    <div class="calendar__date"><span>22</span></div>
                                    <div class="calendar__date"><span>23</span></div>
                                    <div class="calendar__date"><span>24</span></div>
                                    <div class="calendar__date"><span>25</span></div>
                                    <div class="calendar__date"><span>26</span></div>
                                    <div class="calendar__date"><span>27</span></div>
                                    <div class="calendar__date"><span>28</span></div>
                                    <div class="calendar__date"><span>29</span></div>
                                    <div class="calendar__date"><span>30</span></div>
                                    <div class="calendar__date"><span>31</span></div>
                                </div>
                            </div>

                            <div class="calendar__buttons">
                                <button class="btn btn-sm fw-normal btn-primary" style="background: #f3f6f9;color:black;"
                                    data-bs-dismiss="modal" id="cancel-date-btn-start">Back</button>

                                <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                                    style="background-color: #e08c16;color: white;" id="set-calendar-start">Apply</button>

                            </div>
                        </div>
                    </div>
                    <!--end::Calendar-->

                </div>
                <!--end::Input group-->

            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Calendar Start -->
    {{-- end::Calendar --}}

    {{-- Begin::Modal - Attachment & Notes --}}
    <div class="modal" id="kt_modal_create_detail_claim" tabindex="-1" aria-modal="true" role="dialog">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Claim Attachment</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                        rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black"></rect>
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
                        <div class="fv-row mb-5">

                            <form action="/detail-claim/save" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id-claim" value="{{ $claimContract->id_claim ?? 0 }}">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Attachment</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="hidden" value="12312" name="id-contract">
                                <input type="file" class="form-control form-control-solid"
                                    name="attach-file-claim-detail" id="attach-file-claim-detail" value=""
                                    style="font-weight: normal" accept=".docx" placeholder="Name Proyek">
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    name="document-name-claim-detail" id="document-name-claim-detail"
                                    style="font-weight: normal" value="{{ old('document-name-claim-detail') }}"
                                    placeholder="Nama Document">
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="note-claim-detail"
                                    id="note-claim-detail" value="{{ old('note-claim-detail') }}"
                                    style="font-weight: normal" placeholder="Catatan">
                                <!--end::Input-->
                                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                                <div id="froala-editor-claim-detail" class="my-4">
                                    <h1 class="text-center"><b>Attach DOCX format file only</b></h1>
                                </div>

                                <script>
                                    document.getElementById("attach-file-claim-detail").addEventListener("change", async function() {
                                        await readFile(this.files[0], "#froala-editor-claim-detail");
                                    });
                                </script>
                                <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                                    data-bs-dismiss="modal">Save</button>
                            </form>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- End::Modal - Attachment & Notes --}}
    {{-- End::Modal --}}
@endsection
{{-- end::content --}}

{{-- @section('aside')
    @include('template.aside')
@endsection --}}

@section('js-script')

    <script>
        let month = 1;
        let year = 2020;
        let date = -1;
        let monthFix = 1;
        let yearFix = 2020;
        let dateFix = -1;

        // Begin Function Calendar Start
        const months = document.querySelector(`#approval-date #calendar__month`);
        const years = document.querySelector(`#approval-date #calendar__year`);
        months.addEventListener("change", elt => {
            month = elt.target.value;
            if (month == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

                    } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            }
            setDateClickable("#approval-date");
        });
        years.addEventListener("change", elt => {
            year = elt.target.value;
            if (yearEnd == year) {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;

            } else {
                let html = ``;
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                        html +=
                            `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#approval-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;


            }
            setDateClickable("#approval-date");
        });

        setDateClickable("#approval-date");

        function setDateClickable(rootElt) {
            const dates = document.querySelectorAll(`${rootElt} .calendar__body .calendar__dates .calendar__date`);
            dates.forEach(elt => {
                elt.addEventListener("click", e => {
                    dates.forEach(d => {
                        if (d.classList.contains("calendar__date--selected")) {
                            d.classList.remove("calendar__date--selected");
                            d.classList.remove("calendar__date--range-end");
                            d.classList.remove("calendar__date--first-date");
                        }
                    });

                    if (elt.classList.contains("calendar__date--selected")) {
                        elt.classList.remove("calendar__date--selected");
                        elt.classList.remove("calendar__date--range-end");
                        elt.classList.remove("calendar__date--first-date");
                    } else {
                        if (rootElt.toString().match("end")) {
                            dateEnd = Number(elt.firstElementChild.innerText);
                            const dateStart = document.querySelectorAll(
                                `#approval-date .calendar__body .calendar__dates .calendar__date`);
                            dateStart.forEach((d, i) => {
                                if (i + 1 == dateEndFix) {
                                    d.classList.add("calendar__date--range-start");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        } else {
                            date = Number(elt.firstElementChild.innerText);
                            const dateEnd = document.querySelectorAll(
                                `#end-date .calendar__body .calendar__dates .calendar__date`);
                            dateEnd.forEach((d, i) => {
                                if (i + 1 <= date && monthEndFix < month) {
                                    // d.classList.add("calendar__date--range-start");
                                    d.classList.add("calendar__date--grey");
                                } else {
                                    d.classList.remove("calendar__date--range-start");
                                }
                            });
                        }
                        elt.classList.add("calendar__date--selected");
                        elt.classList.add("calendar__date--range-end");
                        elt.classList.add("calendar__date--first-date");
                    }
                });
            });
        }

        const setCalendarStartBtn = document.querySelector("#set-calendar-start");
        setCalendarStartBtn.addEventListener("click", e => {
            document.querySelector("#approve-date").setAttribute("value",
                `${year}-${month.toString().length < 2 ? month.toString().padStart(2, "0") : month}-${date.toString().length < 2 ? date.toString().padStart(2, "0") : date}`
            );
            dateFix = date;
            monthFix = month;
            yearFix = year;
            let html = ``;
            if (monthEnd == 2) {
                let html = ``;
                for (let i = 0; i < 29; i += 1) {
                    if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
                const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
                updateDates.innerHTML = html;
            } else {
                for (let i = 0; i < 31; i += 1) {
                    if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                        html +=
                            `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                    } else {
                        html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                    }
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
            setDateClickable("#end-date");
        })
        // End Function Calendar Start

        // begin reformat number
        function reformatNumber(elt) {
            const valueFormatted = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
            elt.value = valueFormatted;
        }
        // end reformat number

        // begin tambah pengajuan claim
        const plusPengajuanBtn = document.querySelector("#tambah-pengajuan");
        const tablePengajuanClaim = document.querySelector("#kt_customers_pengajuan_claim tbody");
        let isEnteringPengajuanClaim = false;
        plusPengajuanBtn.addEventListener("click", () => {
            if (!isEnteringPengajuanClaim) {
                let html = tablePengajuanClaim.innerHTML;
                const templateHtml = tablePengajuanClaim.innerHTML;

                if (tablePengajuanClaim.firstElementChild.innerText == "There is no data") {
                    html = `
                    <tr class='editable-row'>
                        <td>
                            <input placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-1">
                        </td>
                        <td>
                            <input onkeyup="reformatNumber(this)" placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-2">
                        </td>
                    </tr>`;
                } else {
                    html += `
                    <tr class='editable-row'>
                        <td>
                            <input placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-1">
                        </td>
                        <td>
                            <input onkeyup="reformatNumber(this)" placeholder="Click anywhere outside this field to continue" type="text" class="form-control claim-input-2">
                        </td>
                    </tr>`;
                }
                tablePengajuanClaim.innerHTML = html;
                const input1 = document.querySelector(".claim-input-1");
                const input2 = document.querySelector(".claim-input-2");
                window.scrollTo(0, document.querySelector("body").scrollHeight);
                input1.focus();
                isEnteringPengajuanClaim = true;

                input1.addEventListener("focusout", async e => {
                    const approvalName = e.target.value;
                    if (approvalName) {
                        input2.focus();
                        input2.addEventListener("focusout", async e => {
                            const total = e.target.value;
                            const totalFormattedNumber = Number(total.toString().replaceAll(
                                /[^0-9]/gi, ""));
                            const textFieldTotalClaim = document.querySelector(
                                "#total-claim");
                            if (typeof totalFormattedNumber == "number" || total != "") {
                                const formData = new FormData();
                                const editableRow = document.querySelector(".editable-row");
                                if (approvalName == "") {
                                    editableRow.remove();
                                    return;
                                }
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("approval-claim-name", approvalName);
                                formData.append("total", totalFormattedNumber);
                                formData.append("id_claim",
                                    "{{ $claimContract->id_claim ?? 0 }}");
                                html = `
                                <td>
                                    <h6 class="text-gray-500">${approvalName}</h6>
                                </td>
                                <td>
                                    <h6 class="text-gray-500">${total}</h6>
                                </td>
                                `;
                                editableRow.innerHTML = html;

                                const approvalClaimRes = await fetch(
                                    "/approval-claim/save", {
                                        method: "POST",
                                        header: {
                                            "content-type": "application/json",
                                        },
                                        body: formData,
                                    }).then(res => res.json());

                                if (approvalClaimRes.status == "success") {
                                    console.log(approvalClaimRes);
                                    html = `
                                    <tr data-id="${approvalClaimRes.index_array}">
                                        <td>
                                            <h6 class="text-gray-800">${approvalClaimRes.approval_name}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-gray-800">${total}</h6>
                                        </td>
                                        <td>
                                            <button type="button" onclick="deleteApprovalClaim(this)" class="btn btn-sm btn-link">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                                    editableRow.remove();
                                    tablePengajuanClaim.innerHTML += html;
                                    textFieldTotalClaim.value = approvalClaimRes
                                        .nilai_claim;
                                }
                            } else {
                                input2.classList.add("form-invalid");

                            }
                            isEnteringPengajuanClaim = false;
                        });
                    } else {
                        isEnteringPengajuanClaim = false;
                        tablePengajuanClaim.innerHTML = templateHtml;
                    }
                });
            } else {
                isEnteringPengajuanClaim = false;
                return;
            }
        });
        // end tambah pengajuan claim

        // begin stage function
        // const stages = document.querySelectorAll(".stage-button");
        // stages.forEach((stage, i) => {
        //     stage.setAttribute("stage", i + 1);
        //     if (i + 1 <= Number("{{ $claimContract->stages ?? 0 }}")) {
        //         stage.classList.add("stage-is-done");
        //         stage.style.cursor = "cursor";
        //     } else {
        //         stage.classList.add("stage-is-not-active");
        //         stage.style.cursor = "cursor";
        //         if (i > Number("{{ $claimContract->stages ?? 0 }}")) {
        //             stage.style.cursor = "not-allowed";
        //             stage.style.pointerEvents = "none";
        //         }

        //     }

        //     stage.addEventListener("click", async e => {
        //         e.stopPropagation();
        //         const stage = e.target.getAttribute("stage");
        //         const formData = new FormData();
        //         formData.append("_token", "{{ csrf_token() }}");
        //         formData.append("stage", stage);
        //         // formData.append("id", "");
        //         formData.append("id_claim", "{{ $claimContract->id_claim ?? 0 }}");
        //         const setStage = await fetch("/claim/stage/save", {
        //             method: "POST",
        //             body: formData
        //         }).then(res => res.json());
        //         if (setStage.status == "success") {
        //             // window.location.href = setStage.link;
        //             window.location.reload();
        //         }
        //     });
        // });
        // end stage function

        // begin reformatNumber
        function reformatNumber(elt) {
            const valueFormatted = Intl.NumberFormat("en-US", {
                maximumFractionDigits: 0,
            }).format(elt.value.toString().replace(/[^0-9]/gi, ""));
            elt.value = valueFormatted;
        }
        // end reformatNumber

        // start read file function
        // Convert DOCX format to HTML tag
        async function readFile(file, elt) {
            const docx2html = require("docx2html");
            const html = await docx2html(file);
            document.querySelector(` ${elt} > .fr-wrapper > .fr-view`).innerHTML = html;
            document.querySelector(`body > #A`).remove();
            return html;
        };
        // end read file function

        // start initialize Froala Editor
        new FroalaEditor("#froala-editor-claim-detail", {
            documentReady: true,
        });
        // end initialize Froala Editor

        // begin Delete Approval Claim
        async function deleteApprovalClaim(elt) {
            const parentElt = elt.parentElement.parentNode;
            const indexArray = parentElt.getAttribute("data-id");
            const tablePengajuanClaim = document.querySelector("#kt_customers_pengajuan_claim tbody");
            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("index_array", indexArray);
            formData.append("id_claim", "{{ $claimContract->id_claim ?? 0 }}");
            const deleteArrayApprovalRes = await fetch("/approval-claim/delete", {
                method: "POST",
                header: {
                    "content-type": "application/json",
                },
                body: formData,
            }).then(res => res.json());
            if (deleteArrayApprovalRes.status == "success") {
                parentElt.remove();
                return;
            }
        }
        // end Delete Approval Claim
    </script>

@endsection
