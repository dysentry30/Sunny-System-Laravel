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
                                <h1 class="d-flex align-items-center fs-3 my-1">{{$claimContract->jenis_claim ?? "Claim"}}
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                                    style="background-color:#008CB4;">
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
                            @isset($claimContract)
                                <div class="row g-7 mb-10">
                                    <div class="col-xl-15">
                                        <div class="card card-flush h-lg-50" id="kt_contacts_main">

                                            <div class="card-body pt-5"
                                                style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                                    <div class="form-group">
                                                        <div id="stage-button" class="stage-list">
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="1">
                                                                Draft
                                                            </a>
                                                            @if ($claimContract->stages > 1)
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-done"
                                                                    style="outline: 0px; cursor: pointer;" stage="2">
                                                                    Diajukan
                                                                </a>
                                                            @else
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-not-active"
                                                                    style="outline: 0px; cursor: pointer;" stage="2">
                                                                    Diajukan
                                                                </a>
                                                            @endif
                                                            
                                                            @if ($claimContract->stages > 2)
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-done"
                                                                    style="outline: 0px; cursor: pointer;" stage="3">
                                                                    Negoisasi
                                                                </a>
                                                            @else
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-not-active"
                                                                    style="outline: 0px; cursor: pointer;" stage="3">
                                                                    Negoisasi
                                                                </a>
                                                            @endif

                                                            @if ($claimContract->stages > 3)
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-done"
                                                                    style="outline: 0px; cursor: pointer;" stage="4">
                                                                    Disetujui
                                                                </a>
                                                            @else
                                                                <a href="#" role="link"
                                                                    class="stage-button color-is-default stage-is-not-active"
                                                                    style="outline: 0px; cursor: pointer;" stage="4">
                                                                    Disetujui
                                                                </a>
                                                            @endif
                                                        {{-- <form action=""></form>
                                                        <form action="/claim/stage/save" class="d-flex" style="position: relative;width: 100%;" method="POST" onsubmit="confirmAction(this); return false;">
                                                            @csrf
                                                            
                                                        </form> --}}
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            @endisset

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
                                                            <span class="required">No. {{$claimContract->jenis_claim ?? "Claim"}}</span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-solid"
                                                            id="number-claim" name="number-claim"
                                                            value="{{ $kode_claim ?? ($claimContract->id_claim ?? '') }}"
                                                            placeholder="No. {{$claimContract->jenis_claim ?? "Claim"}}" readonly>
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
                                                            data-bs-toggle="modal" data-bs-target="#kt_modal_calendar_start"><i
                                                                class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                style="color: #008cb4"></i></a>
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
                                                            id="pic" name="pic" {{-- value="{{ old('pic') ?? ($claimContract->pic ?? '') ?? auth()->user()->name }}"> --}}
                                                            value="{{ auth()->user()->name }}" readonly>
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
                                                                <option value="{{ $claimContract->jenis_claim ?? "Claim" }}" selected>
                                                                    {{ $claimContract->jenis_claim ?? "Claim" }}</option>
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
                                            id="tab-list"
                                            role="tablist">

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link text-active-primary pb-4 active"
                                                    data-bs-toggle="tab"
                                                    href="#kt_user_view_overview_attachment"
                                                    style="font-size:14px;" aria-selected="false"
                                                    role="tab" stage="1">Draft</a>
                                            </li>

                                            @if ($claimContract->stages > 1)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        data-bs-toggle="tab"
                                                        href="#kt_user_diajukan"
                                                        style="font-size:14px;" aria-selected="false"
                                                        stage="2"
                                                        role="tab">Diajukan</a>
                                                </li>
                                            @endif

                                            @if ($claimContract->stages > 2)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        data-bs-toggle="tab"
                                                        href="#kt_user_negoisasi"
                                                        style="font-size:14px;" aria-selected="false"
                                                        stage="3"
                                                        role="tab">Negoisasi</a>
                                                </li>
                                            @endif

                                            @if ($claimContract->stages > 3)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link text-active-primary pb-4"
                                                        data-bs-toggle="tab"
                                                        href="#kt_user_disetujui"
                                                        style="font-size:14px;" aria-selected="false"
                                                        stage="4"
                                                        role="tab">Disetujui</a>
                                                </li>
                                            @endif

                                        </ul>
                                        <!--end:::Tabs-->

                                        <!--begin:::Tab content -->
                                        <!--begin:::Tab content -->
                                        <div class="tab-content" id="myTabContent">
                                            <!--begin::Attachment-->
                                            <div class="tab-pane fade show active"
                                                id="kt_user_view_overview_attachment" role="tabpanel">


                                                <!--begin::Card title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-5">
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Klaim Kontrak Draft
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_draft"
                                                                id="Plus">+</a>
                                                        </h3>

                                                        <table
                                                            class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">No. Claim Draft
                                                                    </th>
                                                                    <th class="min-w-125px">Uraian Perubahan
                                                                    </th>
                                                                    <th class="min-w-125px">Dokumen Surat / Instruksi
                                                                    </th>
                                                                    <th class="min-w-125px">Pasal</th>
                                                                    <th class="min-w-125px">Pengajuan Biaya </th>
                                                                    <th class="min-w-125px">Pengajuan Waktu / EOT</th>
                                                                    <th class="min-w-125px">Dokumen Draft Proposal Claim</th>
                                                                    <th class="min-w-125px">Rekomendasi</th>
                                                                    <th class="min-w-125px">Uraian Rekomendasi</th>
                                                                    <th class="min-w-125px">List Dokumen Pendukng</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($claimContract->ClaimContractDrafts as $key => $draft_addendum)
                                                                    {{-- <tr>
                                                                        <td class="text-gray-600">{{$key + 1}}</td>
                                                                        <td class="text-gray-600">{{$draft_addendum->uraian_perubahan}}</td>
                                                                        <td class="text-gray-600">
                                                                            <a target="_blank" href="/document/view/{{$draft_addendum->id_addendum_draft}}/{{$draft_addendum->id_document_instruksi}}">{{$draft_addendum->id_document_instruksi}}</a>
                                                                        </td>

                                                                        @php
                                                                            $pasals_filter = [];
                                                                            $addendum_pasals = array_filter(explode(",", $draft_addendum->pasals), function($data) {
                                                                                return $data != "";
                                                                            });
                                                                            $is_pasals_exist = false;
                                                                            if(count($addendum_pasals) > 0) {
                                                                                $is_pasals_exist = true;
                                                                            }
                                                                            
                                                                        @endphp

                                                                        @if ($is_pasals_exist)
                                                                            @php
                                                                                foreach ($addendum_pasals as $pasal) {
                                                                                array_push($pasals_filter, $pasal);
                                                                            }
                                                                            @endphp
                                                                            <td class="text-gray-600">
                                                                                @foreach ($pasals_filter as $pasal)
                                                                                @php
                                                                                    $pasal = $pasals->where("id_pasal", (int) $pasal)->first();
                                                                                @endphp
                                                                                    - {{$pasal->pasal}} <br>
                                                                                    <hr>
                                                                                @endforeach
                                                                            </td>
                                                                        @else 
                                                                            <td class="text-gray-600">
                                                                                -
                                                                            </td>
                                                                        @endif

                                                                        <td class="text-gray-600">
                                                                            {{ number_format($draft_addendum->pengajuan_biaya, 0, ",", ",")}}
                                                                        </td>

                                                                        <td class="text-gray-600">
                                                                            {{ date_format(new DateTime($draft_addendum->pengajuan_waktu), "d-M-Y") }}
                                                                        </td>
                                                                        
                                                                        <td class="text-gray-600">
                                                                            <a target="_blank" href="/document/view/{{$draft_addendum->id_addendum_draft}}/{{$draft_addendum->id_document_draft_proposal_addendum}}">{{$draft_addendum->id_document_draft_proposal_addendum}}</a>
                                                                        </td>

                                                                        <td class="text-gray-600">
                                                                            {{ $draft_addendum->rekomendasi ? "Yes" : "No" }}
                                                                        </td>

                                                                        <td class="text-gray-600 min-w-100px text-break">
                                                                            {{ $draft_addendum->uraian_rekomendasi }}
                                                                        </td>

                                                                        <td class="text-gray-600 min-w-100px text-break">
                                                                            @php
                                                                                $list_dokumen = explode(",", $draft_addendum->list_id_document_pendukung);
                                                                            @endphp
                                                                            @foreach ($list_dokumen as $key => $dokumen_pendukung)
                                                                               - <a target="_blank" href="/document/view/{{$draft_addendum->id_addendum_draft}}/{{$dokumen_pendukung}}">Dokumen {{$key + 1}}</a> <br>
                                                                            @endforeach
                                                                        </td>

                                                                    </tr> --}}
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Input group-->

                                                </div>
                                            </div>
                                            <!--end:::Tab pane Attachment-->
                                            
                                            <!--begin::Tab Pane Diajukan-->
                                            <div class="tab-pane fade"
                                                id="kt_user_diajukan" role="tabpanel">


                                                <!--begin::Card title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-5">
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Addendum Kontrak Diajukan
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_diajukan"
                                                                id="Plus">+</a>
                                                        </h3>

                                                        <table
                                                            class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Dokumen Proposal Addendum
                                                                    </th>
                                                                    <th class="min-w-125px">Tanggal Diajukan</th>
                                                                    <th class="min-w-125px">Rekomendasi</th>
                                                                    <th class="min-w-125px">Uraian Rekomendasi</th>
                                                                    <th class="min-w-125px">List Dokumen Pendukng</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($claimContract->claimContractDiajukan as $key => $draft_addendum)
                                                                    {{-- <tr>
                                                                        <td class="text-gray-600">
                                                                            <a class="text-gray-600 text-hover-primary" target="_blank" href="/document/view/{{$draft_addendum->id_addendum_contract_diajukan }}/{{$draft_addendum->id_document_proposal_addendum}}">{{$draft_addendum->id_document_proposal_addendum}}</a>
                                                                        </td>

                                                                        <td class="text-gray-600">
                                                                            {{  Carbon\Carbon::parse($draft_addendum->tanggal_diajukan)->translatedFormat('d F Y');}}
                                                                        </td>

                                                                        <td class="text-gray-600">
                                                                            {{ $draft_addendum->rekomendasi ? "Yes" : "No" }}
                                                                        </td>

                                                                        <td class="text-gray-600 min-w-100px text-break">
                                                                            {{ $draft_addendum->uraian_rekomendasi }}
                                                                        </td>

                                                                        <td class="text-gray-600 min-w-100px text-break">
                                                                            @php
                                                                                $list_dokumen = explode(",", $draft_addendum->dokumen_pendukung);
                                                                            @endphp
                                                                            @foreach ($list_dokumen as $key => $dokumen_pendukung)
                                                                               - <a class="text-gray-600 text-hover-primary" target="_blank" href="/document/view/{{$draft_addendum->id_addendum_contract_diajukan }}/{{$dokumen_pendukung}}">Dokumen {{$key + 1}}</a> <br>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr> --}}
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Input group-->

                                                </div>
                                            </div>
                                            <!--end:::Tab pane Diajukan-->
                                            <!--begin::Tab Pane Negoisasi-->
                                            <div class="tab-pane fade"
                                                id="kt_user_negoisasi" role="tabpanel">


                                                <!--begin::Card title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-5">
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            {{$claimContract->jenis_claim ?? "Claim"}} Kontrak Negoisasi
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_Negoisasi"
                                                                id="Plus">+</a>
                                                        </h3>

                                                        <table
                                                            class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Uraian Activity
                                                                    </th>
                                                                    <th class="min-w-125px">Tanggal Activity</th>
                                                                    <th class="min-w-125px">Keterangan</th>
                                                                    <th class="min-w-125px">List Dokumen Pendukung</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($claimContract->claimContractNegoisasi as $key => $draft_addendum)
                                                                    {{-- <tr>
                                                                        <td>
                                                                            <p class="text-gray-600">{{$draft_addendum->uraian_activity}}</p>
                                                                        </td>

                                                                        <td>
                                                                            <p class="text-gray-600">{{ Carbon\Carbon::parse($draft_addendum->tanggal_activity)->translatedFormat("d F Y")}}</p>
                                                                        </td>

                                                                        <td>
                                                                            <p class="text-gray-600">{{$draft_addendum->keterangan}}</p>
                                                                        </td>

                                                                        <td class="text-gray-600 min-w-100px text-break">
                                                                            @php
                                                                                $list_dokumen = explode(",", $draft_addendum->dokumen_pendukung);
                                                                            @endphp
                                                                            @foreach ($list_dokumen as $key => $dokumen_pendukung)
                                                                               - <a class="text-gray-600 text-hover-primary" target="_blank" href="/document/view/{{$draft_addendum->id_addendum_contract_diajukan }}/{{$dokumen_pendukung}}">Dokumen {{$key + 1}}</a> <br>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr> --}}
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Input group-->

                                                </div>
                                            </div>
                                            <!--end:::Tab pane Negoisasi-->
                                            <!--begin::Tab Pane Disetujui-->
                                            <div class="tab-pane fade"
                                                id="kt_user_disetujui" role="tabpanel">
                                                <!--begin::Card title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Input group Website-->
                                                    <div class="fv-row mb-5">
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            Klaim Kontrak Disetujui
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_disetujui"
                                                                id="Plus">+</a>
                                                        </h3>

                                                        <table
                                                            class="table align-middle table-row-dashed fs-6 gy-5"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Dokumen Surat Disetujui</th>
                                                                    <th class="min-w-125px">Tanggal Disetujui</th>
                                                                    <th class="min-w-125px">Biaya Disetujui</th>
                                                                    <th class="min-w-125px">Waktu / EOT Disetujui</th>
                                                                    <th class="min-w-125px">Keterangan</th>
                                                                    <th class="min-w-125px">List Dokumen Pendukng</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($claimContract->claimContractDisetujui as $key => $draft_addendum)
                                                                    {{-- <tr>
                                                                        <td class="text-gray-600 text-hover-primary">
                                                                            <a target="_blank" class="text-gray-600 text-hover-primary" href="/document/view/{{$draft_addendum->id_addendum_contract_disetujui}}/{{$draft_addendum->id_document_surat_disetujui}}">{{$draft_addendum->id_document_surat_disetujui}}</a>
                                                                        </td>

                                                                        <td class="text-gray-600">{{Carbon\Carbon::parse($draft_addendum->tanggal_disetujui)->translatedFormat("d F Y")}}</td>
                                                                        
                                                                        <td class="text-gray-600">{{ number_format($draft_addendum->biaya_disetujui, 0, ",", ",") }}</td>

                                                                        <td class="text-gray-600">{{ Carbon\Carbon::parse($draft_addendum->waktu_eot_disetujui)->translatedFormat("d F Y") }}</td>

                                                                        <td class="text-gray-600">{{ $draft_addendum->waktu_eot_disetujui }}</td>

                                                                        <td class="min-w-100px text-break">
                                                                            @php
                                                                                $list_dokumen = explode(",", $draft_addendum->dokumen_pendukung);
                                                                            @endphp
                                                                            @foreach ($list_dokumen as $key => $dokumen_pendukung)
                                                                               - <a target="_blank" class="text-gray-600 text-hover-primary" href="/document/view/{{$draft_addendum->id_addendum_contract_disetujui}}/{{$dokumen_pendukung}}">Dokumen {{$key + 1}}</a> <br>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr> --}}
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>
                                                    <!--end::Input group-->

                                                </div>
                                            </div>
                                            <!--end:::Tab pane Disetujui -->
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

    @php
    @endphp

    <!--begin::Modal - Input Draft -->
    <div class="modal fade" id="kt_modal_draft" aria-labelledby="kt_modal_draft" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Draft</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <form action="/claim-contract/draft/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-claim" value="{{$claimContract->id_claim ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$claimContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="uraian-claim" class="form-label fs-6 fw-normal">Uraian {{$claimContract->jenis_claim ?? "Claim"}}</label>
                                        <input type="text" name="uraian-claim" class="form-control form-control-solid">
                                    </div>
                                    <div class="col">
                                        <label for="dokumen-pendukung" class="form-label fs-6 fw-normal">Dokumen Pendukung</label>
                                        <input type="file" name="dokumen-pendukung[]" multiple accept=".docx,.xsls" class="form-control form-control-solid fw-normal">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex flex-row">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_pasal" role="button" class="btn btn-sm btn-link text-dark fs-6 fw-normal">Pasal-pasal<i class="mx-2 bi bi-plus text-primary"></i></button>
                                            @if (Session::has('pasals') && count(Session::get('pasals')) > 1)
                                                <a name="clear-pasal" id="clear-pasal"
                                                    class="btn btn-sm btn-danger">Clear
                                                    Pasal</a>
                                            @else
                                                <a name="clear-pasal" id="clear-pasal"
                                                    style="visibility: hidden"
                                                    class="btn btn-sm btn-danger">Clear
                                                    Pasal</a>
                                            @endif
                                        </div>
                                        <table
                                            class="table align-middle table-row-dashed fs-6"
                                            id="kt_pasal_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr
                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="min-w-125px">#</th>
                                                    <th class="min-w-125px">Pasal
                                                    </th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @if (Session::has('pasals') && count(Session::get('pasals')) > 1)
                                                    @foreach (Session::get('pasals') as $i => $pasalSession)
                                                        <tr>
                                                            <td>
                                                                <span class="fw-normal fs-8">{{ ++$i }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="fw-normal fs-8">{{ $pasalSession->pasal }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2" class="text-center bg-gray-100"><b>Pasal belum terpilih</b></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <!--end::Table body-->
                                    </table>

                                    </div>
                                    <div class="col-6">
                                        <label for="pengajuan-biaya" class="form-label fs-6 fw-normal">Pengajuan Biaya</label>
                                        <input type="text" name="pengajuan-biaya" value="0" onkeyup="reformatNumber(this)" class="form-control form-control-solid">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="pengajuan-waktu" class="form-label fs-6 fw-normal">Pengajuan Waktu / EOT </label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="pengajuan-waktu" class="form-control form-control-solid">
                                    </div>
                                    <div class="col-6">
                                        <label for="proposal-claim" class="form-label fs-6 fw-normal">Draft Proposal {{$claimContract->jenis_claim ?? "Claim"}}</label>
                                        <input type="file" name="proposal-claim" accept=".docx" class="form-control form-control-solid fw-normal">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="rekomendasi" class="form-label fs-6 fw-normal">Rekomendasi</label>
                                        <select name="rekomendasi" id="rekomendasi" style="z-index: 9999999;" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Apakah draft ini direkomendasi?" data-select2-id="select2-data-claim-rekomendasi" aria-hidden="true">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="uraian-rekomendasi" class="form-label fs-6 fw-normal">Uraian Rekomendasi</label>
                                        <textarea name="uraian-rekomendasi" rows="1" class="form-control form-control-solid fw-normal"></textarea>
                                    </div>
                                </div>
                            {{-- <button type="button" id="save-pasal" data-bs-dismiss="modal" class="btn btn-lg mt-5 btn-primary">
                                <span>Save</span>
                                <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"
                                    role="status"></span>
                            </button> --}}
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm mt-5 btn-primary">Save</button>
                    </div>
                </form>

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Input Draft -->
    
    <!--begin::Modal - Input Diajukan -->
    <div class="modal fade" id="kt_modal_diajukan" aria-labelledby="kt_modal_diajukan" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Data Diajukan</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <form action="/claim-contract/diajukan/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-claim" value="{{$claimContract->id_claim ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$claimContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label for="proposal-claim" class="form-label fs-6 fw-normal">Proposal {{$claimContract->jenis_claim ?? "Claim"}}</label>
                                        <input type="file" accept=".docx" name="proposal-claim" class="form-control form-control-solid fw-normal">
                                    </div>
                                    <div class="col-6">
                                        <label for="tanggal-diajukan" class="form-label fs-6 fw-normal">Tanggal Diajukan</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="tanggal-diajukan" class="form-control form-control-solid">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="diajukan-rekomendasi" class="form-label fs-6 fw-normal">Rekomendasi</label>
                                        <select name="diajukan-rekomendasi" id="diajukan-rekomendasi" style="z-index: 9999999;" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Apakah draft ini direkomendasi?" data-select2-id="select2-data-draft-rekomendasi" aria-hidden="true">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="uraian-rekomendasi" class="form-label fs-6 fw-normal">Uraian Rekomendasi</label>
                                        <textarea name="uraian-rekomendasi" rows="1" class="form-control form-control-solid fw-normal"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="col">
                                    <label for="dokumen-pendukung" class="form-label fs-6 fw-normal">Dokumen Pendukung</label>
                                    <input type="file" name="dokumen-pendukung[]" multiple accept=".docx,.xsls" class="form-control form-control-solid fw-normal">
                                </div>
                            {{-- <button type="button" id="save-pasal" data-bs-dismiss="modal" class="btn btn-lg mt-5 btn-primary">
                                <span>Save</span>
                                <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"
                                    role="status"></span>
                            </button> --}}
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm mt-5 btn-primary">Save</button>
                    </div>
                </form>

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Input Diajukan -->

    <!--begin::Modal - Input Negoisasi -->
    <div class="modal fade" id="kt_modal_negoisasi" aria-labelledby="kt_modal_negoisasi" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Data Negosiasi</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <form action="/claim-contract/negosiasi/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-claim" value="{{$claimContract->id_claim ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$claimContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label for="uraian-activity" class="form-label fs-6 fw-normal">Uraian Activity</label>
                                        <input type="text" name="uraian-activity" class="form-control form-control-solid fw-normal">
                                    </div>
                                    <div class="col-6">
                                        <label for="tanggal-activity" class="form-label fs-6 fw-normal">Tanggal Activity</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="tanggal-activity" class="form-control form-control-solid">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="dokumen-pendukung" class="form-label fs-6 fw-normal">Dokumen Pendukung</label>
                                        <input type="file" name="dokumen-pendukung[]" multiple accept=".docx,.xsls" class="form-control form-control-solid fw-normal">
                                    </div>
                                    <div class="col-6">
                                        <label for="keterangan" class="form-label fs-6 fw-normal">Keterangan</label>
                                        <textarea name="keterangan" rows="1" class="form-control form-control-solid fw-normal"></textarea>
                                    </div>
                                </div>
                            {{-- <button type="button" id="save-pasal" data-bs-dismiss="modal" class="btn btn-lg mt-5 btn-primary">
                                <span>Save</span>
                                <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"
                                    role="status"></span>
                            </button> --}}
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm mt-5 btn-primary">Save</button>
                    </div>
                </form>

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Input Negoisasi -->

    <!--begin::Modal - Input Disetujui -->
    <div class="modal fade" id="kt_modal_disetujui" aria-labelledby="kt_modal_disetujui" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Data Disetujui</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <form action="/claim-contract/disetujui/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-claim" value="{{$claimContract->id_claim ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$claimContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                            <div class="row">
                                <div class="col-6">
                                    <label for="surat-disetujui" class="form-label fs-6 fw-normal">Surat Disetujui Dari Owner</label>
                                    <input type="file" accept=".docx" name="surat-disetujui" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="tanggal-disetujui" class="form-label fs-6 fw-normal">Tanggal Disetujui</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="tanggal-disetujui" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="biaya-disetujui" class="form-label fs-6 fw-normal">Biaya Disetujui</label>
                                    <input type="text" name="biaya-disetujui" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="waktu-eot-disetujui" class="form-label fs-6 fw-normal">Waktu / EOT Disetujui</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="waktu-eot-disetujui" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="keterangan-disetujui" class="form-label fs-6 fw-normal">Keterangan</label>
                                    <textarea rows="1" name="keterangan-disetujui" class="form-control form-control-solid fw-normal"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="dokumen-pendukung" class="form-label fs-6 fw-normal">Dokumen Pendukung</label>
                                    <input type="file" name="dokumen-pendukung[]" accept=".docx,.xlsx" multiple class="form-control form-control-solid">
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm mt-5 btn-primary">Save</button>
                    </div>
                </form>

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Input Disetujui -->

    <!--begin::Modal - Pasal-Pasal -->
    <div class="modal fade" id="kt_modal_pasal" aria-labelledby="kt_modal_pasal" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Pilih Pasal</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
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
                        @isset($pasals)
                            <div class="col">
                                <ul class="list-group list-group-flush">
                                    @if (Session::has('pasals'))
                                        <?php
                                        $is_choosen = false;
                                        ?>
                                        @foreach ($pasals as $pasal)
                                            @foreach (Session::get('pasals') as $pasalSession)
                                                @if ($pasalSession->id_pasal == $pasal->id_pasal)
                                                    <?php $is_choosen = true; ?>
                                                    <li class="list-group-item">
                                                        <!--begin::Options-->
                                                        <label
                                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                            <input class="form-check-input pasal"
                                                                name="{{ $pasal->id_pasal }}" type="checkbox"
                                                                value="{{ $pasal->id_pasal }}" checked="true">
                                                            <span class="form-check-label">{{ $pasal->pasal }}</span>
                                                        </label>
                                                        <!--end::Options-->
                                                    </li>
                                                @endif
                                            @endforeach
                                            @if (!$is_choosen)
                                                <li class="list-group-item">
                                                    <!--begin::Options-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input pasal" name="{{ $pasal->id_pasal }}"
                                                            type="checkbox" value="{{ $pasal->id_pasal }}">
                                                        <span class="form-check-label">{{ $pasal->pasal }}</span>
                                                    </label>
                                                    <!--end::Options-->
                                                </li>
                                            @endif
                                            <?php $is_choosen = false; ?>
                                        @endforeach
                                    @else
                                        @foreach ($pasals as $pasal)
                                            <li class="list-group-item">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input pasal" name="{{ $pasal->id_pasal }}"
                                                        type="checkbox" value="{{ $pasal->id_pasal }}">
                                                    <span class="form-check-label">{{ $pasal->pasal }}</span>
                                                </label>
                                                <!--end::Options-->
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @endisset
                        <div class="d-flex flex-row col align-items-center justify-content-between">
                            <button type="button" id="back-pasal" onclick="$('#draft-rekomendasi').select2('destroy');$('#draft-rekomendasi').select2({
                                dropdownParent: $('#kt_modal_draft'),
                                minimumResultsForSearch: Infinity,
                            });" data-bs-target="#kt_modal_draft" data-bs-toggle="modal" class="btn btn-sm mt-5 btn-secondary text-dark"><i class="bi bi-arrow-left"></i> Back</button>
                            <button type="button" id="save-pasal" class="btn btn-sm mt-5 d-flex btn-primary" style="background-color: #008cb4">
                                <span>Save</span>
                                <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"
                                role="status"></span>
                            </button>
                        </div>
                    </div>
                    <!--end::Input group-->

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Pasal-Pasal -->

    {{-- begin::Calendar --}}
    <!--begin::Modal - Calendar Start -->
    <div class="modal fade" id="kt_modal_calendar_start" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
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
                                <select name="calendar__month" onchange="monthCalendar(this)" id="calendar__month">
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
                                    <div class="calendar__date" id="tgl-30"><span>30</span></div>
                                    <div class="calendar__date" id="tgl-31"><span>31</span></div>
                                </div>
                            </div>

                            <div class="calendar__buttons">
                                <button class="btn btn-sm fw-normal btn-primary" style="background: #f3f6f9;color:black;"
                                    data-bs-dismiss="modal" id="cancel-date-btn-start">Back</button>

                                <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                                    style="background-color: #008cb4;color: white;" id="set-calendar-start">Apply</button>

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
    <!--end::Modal - Calendar  -->
    {{-- end::Calendar --}}
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

    {{-- Begin Confirm Action Claim --}}
    <script>
        // function confirmAction(form) {
        //     const formSend = document.createElement("form");
        //     formSend.setAttribute("method", "post");
        //     formSend.setAttribute("action", form.action);
        //     let html = `
        //                                             @csrf
        //                                             <input type="hidden" name="id_claim" value="{{ $claimContract->id_claim ?? 0 }}">
        //                                         `;
        //     if (form.submitted == "Disetujui") {
        //         html +=
        //             `<input type="hidden"
        //                 onclick="this.form.submitted=this.value"
        //                 class="dropdown-item" name="stage-disetujui"
        //                 value="Disetujui">`;
        //     } else if (form.submitted == "Ditolak") {
        //         html +=
        //             `<input type="hidden"
        //                 onclick="this.form.submitted=this.value"
        //                 class="dropdown-item" name="stage-ditolak"
        //                 value="Ditolak">`;
        //     } else if (form.submitted == "Cancel") {
        //         html +=
        //             `<input type="hidden"
        //                 onclick="this.form.submitted=this.value"
        //                 class="dropdown-item" name="stage-cancel"
        //                 value="cancel">`;
        //     }
        //     formSend.innerHTML = html;
        //     document.body.appendChild(formSend);
        //     Swal.fire({
        //         title: '',
        //         text: "Yakin Pindah Stage ?",
        //         icon: false,
        //         showCancelButton: true,
        //         confirmButtonColor: '#008CB4',
        //         cancelButtonColor: '#BABABA',
        //         confirmButtonText: 'Ya'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             formSend.submit();
        //         }
        //         return false;
        //     });
        // }
        const modalDraftElt = document.querySelector("#kt_modal_draft");
        const modalPasalElt = document.querySelector("#kt_modal_pasal");
        const modalDraftBoots = new bootstrap.Modal(modalDraftElt, {});
        const modalPasalBoots = new bootstrap.Modal(modalPasalElt, {});
        const savePasalBtn = document.querySelector("#save-pasal");
        const loadingElt = document.querySelector("#save-pasal > .spinner-border");
        savePasalBtn.addEventListener("click", async e => {
            savePasalBtn.setAttribute("disabled", "");
            const pasalCheckboxes = document.querySelectorAll(".pasal");
            loadingElt.style.display = "block";
            let pasals = [];
            pasalCheckboxes.forEach((pasal) => {
                if (pasal.checked) {
                    pasals.push(pasal.value);
                }
            });
            const formData = new FormData();
            let html = "";
            let counter = 1;
            formData.append("_token", '{{ csrf_token() }}');
            formData.append("pasals", pasals);
            const savePasal = await fetch("/pasal/save", {
                method: "POST",
                header: {
                    "Content-Type": "application/json",
                },
                body: formData,
            }).then(res => res.json());
            if (savePasal.status == "success") {
                const pasals = JSON.parse(savePasal.pasals);
                modalDraftBoots.show();
                modalPasalBoots.hide();
                $("#draft-rekomendasi").select2({
                    dropdownParent: $('#kt_modal_draft'),
                    minimumResultsForSearch: Infinity,
                });
                // if (toaster.classList.contains("text-bg-danger")) {
                //     toaster.classList.remove("text-bg-danger");
                // }
                // toaster.classList.add("text-bg-success");
                // document.querySelector(".toast-body").innerText = savePasal.message
                pasals.forEach((pasal) => {
                    html += `
                    <tr>
                        <td>
                            <span class="fw-normal fs-8">${counter++}</span>
                        </td>
                        <td>
                            <span class="fw-normal fs-8">${pasal.pasal}</span>
                        </td>
                    </tr>
            `
                });
                document.querySelector("#kt_pasal_table tbody").innerHTML = html;
                // toasterBoots.show();
                document.querySelector("#clear-pasal").style.visibility = "visible";

            } else {
                // if (toaster.classList.contains("text-bg-success")) {
                //     toaster.classList.remove("text-bg-success");
                // }
                // toaster.classList.add("text-bg-danger");
                // document.querySelector(".toast-body").innerText = savePasal.message
                // toasterBoots.show();

            }
            Toast.fire({
                html: savePasal.message,
                icon: savePasal.status,
            });
            loadingElt.style.display = "none";
            savePasalBtn.removeAttribute("disabled");
        });
        document.querySelector("#clear-pasal").addEventListener("click", async e => {
            const pasalCheckboxes = document.querySelectorAll(".pasal");
            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            const clearPasalsRes = await fetch("/pasal/clear", {
                method: "POST",
                body: formData,
            }).then(res => res.json());
            if (clearPasalsRes.status == "success") {
                html = `
                <tr>
                    <td colspan="2" class="text-center bg-gray-100"><b>Pasal belum terpilih</b></td>
                </tr>
                `
                Toast.fire({
                    icon: "success",
                    text: "Pasal-pasal berhasil dihapus",
                });
                document.querySelector("#kt_pasal_table tbody").innerHTML = html;
                pasalCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.checked = false;
                    }
                })
            }
            
            document.querySelector("#clear-pasal").style.visibility = "hidden";
        });

        // end::Script adding pasal

        const stageActions = document.querySelectorAll(".stage-button");
        let prevStage = "{{$claimContract->stages ?? 0}}";
        stageActions.forEach((stageAction, i) => {
            stageAction.addEventListener("click", async e => {
                Swal.fire({
                    title: '',
                    text: "Yakin Pindah Stage ?",
                    icon: false,
                    showCancelButton: true,
                    confirmButtonColor: '#008CB4',
                    cancelButtonColor: '#BABABA',
                    confirmButtonText: 'Ya'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const stage = Number(e.target.getAttribute("stage"));
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("stage", stage);
                        formData.append("id_claim", "{{$claimContract->id_claim ?? 0}}");
                        formData.append("kode_proyek", "{{ $proyek->kode_proyek ?? 0 }}");
                        const setStage = await fetch("/claim/stage/save", {
                            method: "POST",
                            body: formData
                        }).then(res => res.json());
                        if (setStage.status == "success") {
                            if(stage < prevStage) {
                                // Close Tabs based on stages
                                for(let i = stage ; i < stageActions.length; i++) {
                                    stageActions[i].classList.remove("stage-is-done");
                                    stageActions[i].classList.add("stage-is-not-active"); 
                                    const tabListEltRemove = document.querySelector(`#tab-list > .nav-item > a[stage="${i + 1}"]`);
                                    if(tabListEltRemove) {
                                        tabListEltRemove.parentElement.remove();
                                    }
                                }
                            } else {
                                stageAction.classList.add("stage-is-done");
                                stageAction.classList.remove("stage-is-not-active");

                                // show tabs based on stage
                                const tabListElt = document.querySelector("#tab-list");
                                let title = "";
                                let hrefModal = "";
                                switch (stage) {
                                    case 1:
                                        title = "Draft"
                                        hrefModal = "kt_user_view_overview_attachment"
                                        break;
                                        
                                    case 2:
                                        title = "Diajukan"
                                        hrefModal = "kt_user_diajukan"
                                    break;
                                
                                    case 3:
                                        title = "Negoisasi"
                                        hrefModal = "kt_user_negoisasi"
                                        break;
                                
                                    case 4:
                                        title = "Disetujui"
                                        hrefModal = "kt_user_disetujui"
                                        break;
                                
                                    case 5:
                                        title = "Amandemen"
                                        hrefModal = "kt_user_amandemen"
                                        break;
                                }
                                let htmltabList = `
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-active-primary pb-4"
                                            data-bs-toggle="tab"
                                            href="#${hrefModal}"
                                            style="font-size:14px;" aria-selected="false"
                                            role="tab" stage="${stage}">${title}</a>
                                    </li>
                                `;


                                const isTabExist = tabListElt.querySelector(`.nav-item > a[stage="${stage}"]`);
                                if(isTabExist) {
                                    htmltabList = `
                                        <a class="nav-link text-active-primary pb-4"
                                            data-bs-toggle="tab"
                                            href="#${hrefModal}"
                                            style="font-size:14px;" aria-selected="false"
                                            role="tab" stage="${stage}">${title}</a>
                                    `;
                                    isTabExist.outerHTML = htmltabList;
                                } else {
                                    tabListElt.innerHTML += htmltabList;
                                }
                            }
                            prevStage = stage;
                            // window.location.reload();
                        }
                    }
                })
            });
        });
    </script>
    {{-- End Confirm Action Claim --}}

@endsection
