@extends('template.main')

@section('title', 'Addendum Contract')
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @extends('template.header')
                <!--end::Header-->


                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <!--begin::Toolbar-->
                    @if(empty($addendumContract))
                    <form action="/addendum-contract/upload" method="post" enctype="multipart/form-data">
                        @else
                        <form action="/addendum-contract/update" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="{{$addendumContract->id_addendum ?? old("id-addendum")}}" name="id-addendum">
                    @endif
                        @csrf
                        {{-- begin::input --}}
                        <input type="hidden" value="{{ $id_contract ?? 0 }}" id="id-contract" name="id-contract">
                        {{-- end::input --}}
                        <div class="toolbar" id="kt_toolbar">
                            <!--begin::Container-->
                            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                                <!--begin::Page title-->
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    <!--begin::Title-->
                                    <h1 class="d-flex align-items-center fs-3 my-1">Change Request
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
                                    <a href="/contract-management/view/{{ $id_contract }}" class="btn btn-sm btn-primary"
                                        id="cloedButton" style="background-color:#f3f6f9;margin-left:10px;color: black;">
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
                                <div class="col-xl-15">
                                    <div class="card card-flush" id="kt_contacts_main">

                                        <div class="card-body pt-5"
                                            style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                            <div class="form-group">
                                                <div id="stage-button" class="stage-list">
                                                    @isset($addendumContract)
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="1">
                                                                Draft
                                                            </a>
                                                        @if ($addendumContract->stages > 1)
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
                                                        
                                                        @if ($addendumContract->stages > 2)
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

                                                        @if ($addendumContract->stages > 3)
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

                                                        @if ($addendumContract->stages > 4)
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="5">
                                                                Amandemen
                                                            </a>
                                                        @else
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="5">
                                                                Amandemen
                                                            </a>
                                                        @endif
                                                        @else
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="1">
                                                                Draft
                                                            </a>
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="2">
                                                                Diajukan
                                                            </a>
                                                            
                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="3">
                                                                Negoisasi
                                                            </a>

                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="4">
                                                                Disetujui
                                                            </a>

                                                            <a href="#" role="link"
                                                                class="stage-button color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="5">
                                                                Amandemen
                                                            </a>
                                                    @endisset

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="toast align-items-center text-bg-primary border-0 position-relative end-0 top-0 my-5" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                      <div class="toast-body text-white">
                                        
                                      </div>
                                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                  </div>

                                @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ Session::get('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    {{ Session::forget('error') }}
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ Session::get('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    {{ Session::forget('success') }}
                                @endif
                                <!--begin::Contacts App- Edit Contact-->
                                <div class="row g-7">

                                    @isset($addendumContract)
                                        <!--begin::Header Contract-->
                                        <div class="col-xl-15">
                                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

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
                                                                    <span class="required">No. Addendum Kontrak</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid"
                                                                    id="addendum-contract-title" name="addendum-contract-title"
                                                                    value="{{ old('addendum-contract-title') ?? $addendumContract->no_addendum }}"
                                                                    placeholder="Title for this draft" />
                                                                @error('addendum-contract-title')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group Name-->
                                                        </div>
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <!--begin::Input group Name-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span class="required">Draft Version</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="addendum-contract-version"
                                                                    id="addendum-contract-version"
                                                                    class="form-select form-select-solid" data-control="select2"
                                                                    data-hide-search="true" data-placeholder="">
                                                                    <option selected>Choose draft version...</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '1' || $addendumContract->addendum_contract_version == '1' ? 'selected' : '' }}
                                                                        value="1">1</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '2' || $addendumContract->addendum_contract_version == '2' ? 'selected' : '' }}
                                                                        value="2">2</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '3' || $addendumContract->addendum_contract_version == '3' ? 'selected' : '' }}
                                                                        value="3">3</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '4' || $addendumContract->addendum_contract_version == '4' ? 'selected' : '' }}
                                                                        value="4">4</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '5' || $addendumContract->addendum_contract_version == '5' ? 'selected' : '' }}
                                                                        value="5">5</option>
                                                                </select>

                                                                <!--end::Input-->
                                                            </div>
                                                            @error('addendum-contract-version')
                                                                <h6>
                                                                    <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                </h6>
                                                            @enderror
                                                            <!--end::Input group Name-->
                                                        </div>
                                                    </div>


                                                    <div class="row fv-row">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Tanggal Mulai Kontrak</span>
                                                                </label>
                                                                {{-- <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_calendar_start"
                                                                    id="start-date-modal">&plus;</a> --}}
                                                                <a href="#" class="btn btn-sm mx-3"
                                                                    style="background: transparent;width:1rem;height:2.3rem;"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_calendar_start"><i
                                                                        class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                        style="color: #008cb4"></i></a>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="Date" class="form-control form-control-solid"
                                                                    placeholder="Select a date"
                                                                    value="{{ old('addendum-contract-start-date') ?? date_format(new DateTime($addendumContract->created_at), 'Y-m-d') }}"
                                                                    name="addendum-contract-start-date"
                                                                    id="addendum-contract-start-date" />

                                                                @error('addendum-contract-start-date')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Create By</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid"
                                                                    value="{{ auth()->user()->name }}"
                                                                    placeholder="Who create this draft?"
                                                                    id="addendum-contract-create-by"
                                                                    name="addendum-contract-create-by" readonly />
                                                                @error('addendum-contract-create-by')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                    </div>
                                                    <h6 id="status-msg" style="display: none"></h6>

                                                    <!--End begin::Row-->
                                                </div>

                                                
                                            </div>
                                        </div>
                                        <div class="col-xl-15 ">
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

                                                        @if ($addendumContract->stages > 1)
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link text-active-primary pb-4"
                                                                    data-bs-toggle="tab"
                                                                    href="#kt_user_diajukan"
                                                                    style="font-size:14px;" aria-selected="false"
                                                                    stage="2"
                                                                    role="tab">Diajukan</a>
                                                            </li>
                                                        @endif

                                                        @if ($addendumContract->stages > 2)
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link text-active-primary pb-4"
                                                                    data-bs-toggle="tab"
                                                                    href="#kt_user_negoisasi"
                                                                    style="font-size:14px;" aria-selected="false"
                                                                    stage="3"
                                                                    role="tab">Negoisasi</a>
                                                            </li>
                                                        @endif

                                                        @if ($addendumContract->stages > 3)
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link text-active-primary pb-4"
                                                                    data-bs-toggle="tab"
                                                                    href="#kt_user_disetujui"
                                                                    style="font-size:14px;" aria-selected="false"
                                                                    stage="4"
                                                                    role="tab">Disetujui</a>
                                                            </li>
                                                        @endif

                                                        @if ($addendumContract->stages > 4)
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link text-active-primary pb-4"
                                                                    data-bs-toggle="tab"
                                                                    href="#kt_user_amandemen"
                                                                    style="font-size:14px;" aria-selected="false"
                                                                    stage="5"
                                                                    role="tab">Amandemen</a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                    <!--end:::Tabs-->

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
                                                                        Addendum Kontrak Draft
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
                                                                                <th class="min-w-125px">No. Addendum Draft
                                                                                </th>
                                                                                <th class="min-w-125px">Uraian Perubahan
                                                                                </th>
                                                                                <th class="min-w-125px">Dokumen Surat / Instruksi
                                                                                </th>
                                                                                <th class="min-w-125px">Pasal</th>
                                                                                <th class="min-w-125px">Pengajuan Biaya </th>
                                                                                <th class="min-w-125px">Pengajuan Waktu / EOT</th>
                                                                                <th class="min-w-125px">Dokumen Draft Proposal Addendum</th>
                                                                                <th class="min-w-125px">Rekomendasi</th>
                                                                                <th class="min-w-125px">Uraian Rekomendasi</th>
                                                                                <th class="min-w-125px">List Dokumen Pendukng</th>
                                                                            </tr>
                                                                            <!--end::Table row-->
                                                                        </thead>
                                                                        <!--end::Table head-->
                                                                        <!--begin::Table body-->
                                                                        <tbody class="fw-bold text-gray-600">
                                                                            @foreach ($addendumContract->addendumContractDrafts as $key => $draft_addendum)
                                                                                <tr>
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

                                                                                </tr>
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
                                                                            @foreach ($addendumContract->addendumContractDiajukan as $key => $draft_addendum)
                                                                                <tr>
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
                                                                                </tr>
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
                                                                        Addendum Kontrak Negoisasi
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
                                                                            @foreach ($addendumContract->addendumContractNegoisasi as $key => $draft_addendum)
                                                                                <tr>
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
                                                                                </tr>
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
                                                                        Addendum Kontrak Disetujui
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
                                                                            @foreach ($addendumContract->addendumContractDisetujui as $key => $draft_addendum)
                                                                                <tr>
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
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <!--end::Table body-->
                                                                    </table>
                                                                </div>
                                                                <!--end::Input group-->

                                                            </div>
                                                        </div>
                                                        <!--end:::Tab pane Disetujui -->
                                                        <!--begin::Tab Pane Amandemen-->
                                                        <div class="tab-pane fade"
                                                            id="kt_user_amandemen" role="tabpanel">


                                                            <!--begin::Card title-->
                                                            <div class="card-title m-0">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-5">
                                                                    <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                        style="font-size:14px;">
                                                                        Addendum Kontrak Amandemen
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_amandemen"
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
                                                                                <th class="min-w-125px">Dokumen Amandemen
                                                                                </th>
                                                                                <th class="min-w-125px">Tanggal Amandemen</th>
                                                                                <th class="min-w-125px">Biaya Amandemen</th>
                                                                                <th class="min-w-125px">Waktu / EOT Amandemen</th>
                                                                                <th class="min-w-125px">Keterangan</th>
                                                                                <th class="min-w-125px">List Dokumen Pendukng</th>
                                                                            </tr>
                                                                            <!--end::Table row-->
                                                                        </thead>
                                                                        <!--end::Table head-->
                                                                        <!--begin::Table body-->
                                                                        <tbody class="fw-bold text-gray-600">
                                                                            @foreach ($addendumContract->addendumContractAmandemen as $key => $draft_addendum)
                                                                                <tr>
                                                                                    <td>
                                                                                        <a target="_blank" class="text-gray-600 text-hover-primary" href="/document/view/{{$draft_addendum->id_addendum_contract_amandemen}}/{{$draft_addendum->id_dokumen_amandemen}}">{{$draft_addendum->id_dokumen_amandemen}}</a>
                                                                                    </td>

                                                                                    <td class="text-gray-600">
                                                                                        {{ Carbon\Carbon::parse($draft_addendum->tanggal_amandemen)->translatedFormat("d F Y") }}
                                                                                    </td>

                                                                                    <td class="text-gray-600">
                                                                                        {{ number_format($draft_addendum->biaya_amandemen, 0, ",", ",")}}
                                                                                    </td>

                                                                                    <td class="text-gray-600">
                                                                                        {{ Carbon\Carbon::parse($draft_addendum->waktu_eot_amandemen)->translatedFormat("d F Y") }}
                                                                                    </td>

                                                                                    <td class="text-gray-600">
                                                                                        {{ $draft_addendum->keterangan }}
                                                                                    </td>

                                                                                    <td class="text-gray-600 min-w-100px text-break">
                                                                                        @php
                                                                                            $list_dokumen = explode(",", $draft_addendum->dokumen_pendukung);
                                                                                        @endphp
                                                                                        @foreach ($list_dokumen as $key => $dokumen_pendukung)
                                                                                           - <a target="_blank" href="/document/view/{{$draft_addendum->id_addendum_contract_amandemen}}/{{$dokumen_pendukung}}">Dokumen {{$key + 1}}</a> <br>
                                                                                        @endforeach
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td class="text-gray-600">{{$draft_addendum->uraian_perubahan}}</td>
                                                                                    

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
                                                        <!--end:::Tab pane Amandemen-->
                                                        <!--begin:::Tab pane Pasal-->
                                                        <div class="tab-pane fade" id="kt_user_view_overview_pasal"
                                                            role="tabpanel">
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                {{-- Begin::Col --}}
                                                                <div class="col-6">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                                style="font-size:14px;">
                                                                                Draft
                                                                                <a href="#"
                                                                                    data-bs-target="#kt_modal_draft"
                                                                                    data-bs-toggle="modal"
                                                                                    id="Plus">+</a>
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fv-row mb-7">
                                                                        

                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!-- end::Col-->
                                                            </div>
                                                            <!--end::Row-->
                                                        </div>
                                                        <!--end:::Tab pane Pasal-->
                                                    </div>
                                                    <!--end:::Tab content-->

                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Contacts-->
                                        </div>
                                    @else
                                        <!--begin::Header Contract-->
                                        <div class="col-xl-15">
                                            <div class="card card-flush h-lg-80 my-5" id="kt_contacts_main">

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
                                                                    <span class="required">No. Change Request</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                {{-- begin::input --}}
                                                                <input type="hidden"
                                                                    value="{{ $contract->id_contract ?? 0 }}"
                                                                    id="id-contract" name="id-contract">
                                                                {{-- end::input --}}
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid"
                                                                    id="addendum-contract-title" name="addendum-contract-title"
                                                                    value="{{ old('addendum-contract-title') }}"
                                                                    placeholder="" />
                                                                @error('addendum-contract-title')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group Name-->
                                                        </div>
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <!--begin::Input group Name-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span class="required">Draft Version</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="addendum-contract-version"
                                                                    id="addendum-contract-version"
                                                                    class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="Pilih Versi Draft...">
                                                                    <option value=""></option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '1' ? 'selected' : '' }}
                                                                        value="1">1</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '2' ? 'selected' : '' }}
                                                                        value="2">2</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '3' ? 'selected' : '' }}
                                                                        value="3">3</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '4' ? 'selected' : '' }}
                                                                        value="4">4</option>
                                                                    <option
                                                                        {{ old('addendum-contract-version') == '5' ? 'selected' : '' }}
                                                                        value="5">5</option>
                                                                </select>

                                                                <!--end::Input-->
                                                            </div>
                                                            @error('addendum-contract-version')
                                                                <h6>
                                                                    <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                </h6>
                                                            @enderror
                                                            <!--end::Input group Name-->
                                                        </div>
                                                    </div>


                                                    <div class="row fv-row">
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Tanggal Mulai Kontrak</span>
                                                                    {{-- <a href="#" class="btn btn-secondary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_calendar_start"
                                                                        id="start-date-modal">&plus;</a> --}}
                                                                    <a href="#" class="btn btn-sm mx-3"
                                                                        style="background: transparent;width:1rem;height:2.3rem;"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kt_modal_calendar_start"><i
                                                                            class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                            style="color: #008cb4"></i></a>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="Date" class="form-control form-control-solid"
                                                                    placeholder="Select a date"
                                                                    value="{{ old('addendum-contract-start-date') }}"
                                                                    name="addendum-contract-start-date"
                                                                    id="addendum-contract-start-date" />

                                                                @error('addendum-contract-start-date')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Input group Website-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                    <span>Create By</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid"
                                                                    value="{{ auth()->user()->name }}"
                                                                    id="addendum-contract-create-by"
                                                                    name="addendum-contract-create-by" readonly />
                                                                @error('addendum-contract-create-by')
                                                                    <h6>
                                                                        <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                    </h6>
                                                                @enderror
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--End begin::Col-->
                                                    </div>
                                                    <h6 id="status-msg" style="display: none"></h6>

                                                    <!--End begin::Row-->
                                                </div>

                                            </div>
                                        </div>
                                    @endisset
                                </div>
                                <!--end::Header Contract-->
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contacts-->
        </div>

        <!--end::Content-->
    </div>
    <!--end::Container-->
    </div>
    <!--end::Post-->

    </div>
    <!--end::Content-->

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
                <form action="/addendum-contract/draft/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{$addendumContract->id_addendum ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$addendumContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label for="uraian-perubahan" class="form-label fs-6 fw-normal">Uraian Perubahan</label>
                                        <textarea rows="3" placeholder="Input Perubahan" name="uraian-perubahan" class="form-control form-control-solid"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="surat-instruksi" class="form-label fs-6 fw-normal">Surat / Instruksi (Dari Owner)</label>
                                        <input type="file" accept=".docx" name="surat-instruksi" class="form-control form-control-solid fw-normal">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex flex-row">
                                            <button type="button" onclick="showModalPasal()" role="button" class="btn btn-sm btn-link text-dark fs-6 fw-normal">Pasal-pasal<i class="mx-2 bi bi-plus text-primary"></i></button>
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
                                        <input type="text" name="pengajuan-biaya" class="form-control form-control-solid">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="pengajuan-waktu" class="form-label fs-6 fw-normal">Pengajuan Waktu / EOT </label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="pengajuan-waktu" id="pengajuan-waktu" class="form-control form-control-solid">
                                    </div>
                                    <div class="col-6">
                                        <label for="draft-proposal-addendum" class="form-label fs-6 fw-normal">Draft Proposal Addendum</label>
                                        <input type="file" name="draft-proposal-addendum" accept=".docx" class="form-control form-control-solid fw-normal">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="draft-rekomendasi" class="form-label fs-6 fw-normal">Rekomendasi</label>
                                        <select name="draft-rekomendasi" id="draft-rekomendasi" style="z-index: 9999999;" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Apakah draft ini direkomendasi?" data-select2-id="select2-data-draft-rekomendasi" aria-hidden="true">
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
                <form action="/addendum-contract/diajukan/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{$addendumContract->id_addendum ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$addendumContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label for="proposal-addendum" class="form-label fs-6 fw-normal">Proposal Addendum</label>
                                        <input type="file" accept=".docx" name="proposal-addendum" class="form-control form-control-solid fw-normal">
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
                <form action="/addendum-contract/negosiasi/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{$addendumContract->id_addendum ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$addendumContract->id_contract ?? 0}}">
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
                <form action="/addendum-contract/disetujui/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{$addendumContract->id_addendum ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$addendumContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                            <div class="row">
                                <div class="col-6">
                                    <label for="surat-disetujui" class="form-label fs-6 fw-normal required">Surat Disetujui Dari Owner</label>
                                    <input type="file" accept=".docx" name="surat-disetujui" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="tanggal-disetujui" class="form-label fs-6 fw-normal required">Tanggal Disetujui</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="tanggal-disetujui" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="biaya-disetujui" class="form-label fs-6 fw-normal required">Biaya Disetujui</label>
                                        <input type="text" name="biaya-disetujui" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="waktu-eot-disetujui" class="form-label fs-6 fw-normal required">Waktu / EOT Disetujui</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="waktu-eot-disetujui" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="keterangan-disetujui" class="form-label fs-6 fw-normal required">Keterangan</label>
                                    <textarea rows="1" name="keterangan-disetujui" class="form-control form-control-solid fw-normal"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="dokumen-pendukung" class="form-label fs-6 fw-normal required">Dokumen Pendukung</label>
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

    <!--begin::Modal - Input Amandemen -->
    <div class="modal fade" id="kt_modal_amandemen" aria-labelledby="kt_modal_amandemen" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Data Amandemen</h2>
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
                <form action="/addendum-contract/amandemen/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id-addendum" value="{{$addendumContract->id_addendum ?? 0}}">
                    <input type="hidden" name="id-contract" value="{{$addendumContract->id_contract ?? 0}}">
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            {{-- <form action=""></form> --}}
                            <div class="row">
                                <div class="col-6">
                                    <label for="dokumen-amandemen" class="form-label fs-6 fw-normal">Dokumen Amandemen</label>
                                    <input type="file" accept=".docx" name="dokumen-amandemen" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="tanggal-amandemen" class="form-label fs-6 fw-normal">Tanggal Amandemen</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="tanggal-amandemen" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="biaya-amandemen" class="form-label fs-6 fw-normal">Biaya Amandemen</label>
                                    <input type="text" name="biaya-amandemen" class="form-control form-control-solid fw-normal">
                                </div>
                                <div class="col-6">
                                    <label for="waktu-eot-amandemen" class="form-label fs-6 fw-normal">Waktu / EOT Amandemen</label>
                                        <a href="#" class="btn btn-sm mx-3" style="background: transparent;width:.5rem;height:2.3rem;" onclick="showCalendarModal(this)" data-target="EOT"><i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008cb4"></i></a>
                                        <input type="date" name="waktu-eot-amandemen" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <label for="keterangan-amandemen" class="form-label fs-6 fw-normal">Keterangan</label>
                                    <textarea rows="1" name="keterangan-amandemen" class="form-control form-control-solid fw-normal"></textarea>
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
    <!--end::Modal - Input Amandemen -->
    
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
                        <div class="row">
                            <div class="d-flex col-3 justify-content-between align-items-center">
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
                            <div class="col d-flex justify-content-end align-items-end">
                                <button class="btn btn-sm btn-active-primary" onclick="showModalPasalImport()" style="background-color: #e6e6e6">Import Pasal</button>
                            </div>
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

    {{-- start:: Modal - Calendar --}}
    <div class="modal fade" id="kt_modal_calendar_start" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-300px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Start Date</h2>
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

                    <!--begin:: Calendar-->
                    <div class="fv-row mb-5">
                        <div class="calendar" id="start-date">
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

                                <div class="calendar__dates">
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

    {{-- start:: Modal - Import Pasal --}}
    <div class="modal fade" id="kt_modal_import_pasal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Import Pasal</h2>
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
                <form action="/pasal/import" method="POST" enctype="multipart/form-data">
                    <div class="modal-body py-lg-6 px-lg-6">
                            @csrf
                            <input type="hidden" name="id-addendum" value="{{ $addendumContract->id_addendum ?? 0 }}">
                            <input type="hidden" name="add_session" value="1">
                            <label for="import-file-upload">Import pasal di sini</label>
                            <input type="file" name="import-file-upload" accept=".xlsx" class="form-control form-control-solid">
                        </div>
                        <!--end::Input group-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-active-primary text-white" style="background-color: #008CB4;">Import</button>
                        </div>
                    </div>
                </form>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    {{-- End:: Modal - Import Pasal --}}
    <!--end::Modal dialog-->

    </div>
    <!--end::Modal - Calendar -->

@endsection

@section('js-script')
    <script>
        // begin::Script adding pasal
        const toaster = document.querySelector(".toast");
        const toasterBoots = new bootstrap.Toast(toaster, {});
        const savePasalBtn = document.querySelector("#save-pasal");
        const modalDraftElt = document.querySelector("#kt_modal_draft");
        const modalPasalElt = document.querySelector("#kt_modal_pasal");
        const modalDraftBoots = new bootstrap.Modal(modalDraftElt, {});
        const modalPasalBoots = new bootstrap.Modal(modalPasalElt, {});
        const pasalModalImportElt = document.querySelector("#kt_modal_import_pasal");
        const pasalModalImportBoots = new bootstrap.Modal(pasalModalImportElt, {});
        // begin :: Import Pasal
        function showModalPasal() {
            // pasalModalBoots.show();
            modalPasalBoots.show();
        }
        function showModalPasalImport() {
            // pasalModalBoots.show();
            pasalModalImportBoots.show();
        }
        // const clearPasalBtn = document.getElementById("clear-pasal");
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
                document.querySelector(".toast-body").innerText = savePasal.message
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
                document.querySelector(".toast-body").innerText = savePasal.message
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
                document.querySelector(".toast-body").innerText = clearPasalsRes.message
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

        const stages = document.querySelectorAll(".stage-button");
        let prevStep = Number("{{$addendumContract->stages ?? 1}}");
        const idAddendum = "{{ $addendumContract->id_addendum ?? 0 }}";
        stages.forEach((stage, i) => {
            stage.addEventListener("click", async e => {
                const formData = new FormData()
                const step = Number(stage.getAttribute("stage"));
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_addendum", idAddendum);
                formData.append("stage", step);


                const setStage = await fetch("/stage/addendum/save", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());

                if (setStage.status == "success") {
                    toaster.classList.add("text-bg-success");
                    // document.querySelector(".toast-body").innerText = setStage.msg;
                    Toast.fire({
                        icon: "success",
                        text: "Update Stage berhasil diperbarui",
                    });
                    // toasterBoots.show()
                    if (step > 1) {
                        stage.classList.add("stage-is-done");
                        stage.classList.remove("stage-is-not-active");
                        // stages[i++].classList.remove("stage-is-done");
                        // stages[i++].classList.add("stage-is-not-active");

                        // show tabs based on stage
                        const tabListElt = document.querySelector("#tab-list");
                        let title = "";
                        let hrefModal = "";
                        switch (step) {
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
                                    role="tab" stage="${step}">${title}</a>
                            </li>
                        `;


                        const isTabExist = tabListElt.querySelector(`.nav-item > a[stage="${step}"]`);
                        if(isTabExist) {
                            htmltabList = `
                                <a class="nav-link text-active-primary pb-4"
                                    data-bs-toggle="tab"
                                    href="#${hrefModal}"
                                    style="font-size:14px;" aria-selected="false"
                                    role="tab" stage="${step}">${title}</a>
                            `;
                            isTabExist.outerHTML = htmltabList;
                        } else {
                            tabListElt.innerHTML += htmltabList;
                        }
                    } 
                    if(step < prevStep) {
                        // const counter = Math.abs(step - prevStep);
                        for(let i = step ; i < stages.length; i++) {
                            stages[i].classList.remove("stage-is-done");
                            stages[i].classList.add("stage-is-not-active"); 
                            const tabListEltRemove = document.querySelector(`#tab-list > .nav-item > a[stage="${i + 1}"]`);
                            tabListEltRemove.parentElement.remove();
                        }
                    }
                    prevStep = step;
                    Toast.fire({
                        icon: "success",
                        text: "Update Stage berhasil diperbarui",
                    });
                } else {
                    toaster.classList.add("text-bg-danger");
                    Toast.fire({
                        icon: "error",
                        text: "Update Stage gagal diperbarui, pastikan anda membuat addendum terlebih dahulu!",
                    });
                    // document.querySelector(".toast-body").innerText = setStage.msg;
                    // toasterBoots.show()
                }

            })
        });
    </script>

    {{-- begin::Draft Contract JS --}}
    <script src="{{ asset('/js/custom/addendumContract/addendumContract.js') }}"></script>
    {{-- end::Draft Contract JS --}}


@endsection

{{-- @section('aside')
    @include('template.aside')
@endsection --}}
