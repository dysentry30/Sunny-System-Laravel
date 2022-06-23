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
                    @isset($addendumContract)
                    <form action="/addendum-contract/upload" method="post" enctype="multipart/form-data">
                        @else
                        <form action="/addendum-contract/update" method="post" enctype="multipart/form-data">
                    @endisset
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
                                    <h1 class="d-flex align-items-center fs-3 my-1">Addendum Contract
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
                                                    <a href="#" role="link"
                                                        class="stage-button color-is-default stage-is-done"
                                                        style="outline: 0px; cursor: pointer;" stage="1">
                                                        Draft
                                                    </a>
                                                    <a href="#" role="link"
                                                        class="stage-button color-is-default stage-is-not-active"
                                                        style="outline: 0px; cursor: pointer;" stage="2">
                                                        Terkontrak
                                                    </a>


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
                                                                        style="color: #e08c16"></i></a>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="Date" class="form-control form-control-solid ps-12"
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
                                                                <input type="text" class="form-control form-control-solid ps-12"
                                                                    value="{{ old('addendum-contract-create-by') ?? $addendumContract->created_by }}"
                                                                    placeholder="Who create this draft?"
                                                                    id="addendum-contract-create-by"
                                                                    name="addendum-contract-create-by" />
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

                                                <div class="col-xl-15">
                                                    <!--begin::Contacts-->
                                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                                        <!--begin::Card body-->
                                                        <div class="card-body pt-5">
                                                            <!--begin:::Tabs-->
                                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8"
                                                                role="tablist">
                                                                @if (!empty($addendumContract))
                                                                    <!--begin:::Tab Attachment Draft Addendum-->
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link text-active-primary pb-4 active"
                                                                            data-bs-toggle="tab"
                                                                            href="#kt_user_view_overview_attachment"
                                                                            style="font-size:14px;" aria-selected="false"
                                                                            role="tab">Attachment</a>
                                                                    </li>
                                                                    <!--end:::Tab Attachment Draft Addendum-->
                                                                @endif

                                                                <!--begin:::Tab item Pasal-pasal -->
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link text-active-primary pb-4"
                                                                        data-bs-toggle="tab" href="#kt_user_view_overview_pasal"
                                                                        style="font-size:14px;" aria-selected="true"
                                                                        role="tab">Pasal-pasal</a>
                                                                </li>
                                                                <!--end:::Tab item Pasal-pasal -->




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
                                                                                <a href="/contract-management/view/{{ $id_contract }}/addendum-contract/{{ $addendumContract->id_addendum }}/new"
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
                                                                                        <th class="min-w-125px">Nama Dokumen
                                                                                        </th>
                                                                                        <th class="min-w-125px">No. Dokumen
                                                                                        </th>
                                                                                        <th class="min-w-125px">Tanggal</th>
                                                                                        <th class="min-w-125px">Catatan</th>
                                                                                    </tr>
                                                                                    <!--end::Table row-->
                                                                                </thead>
                                                                                <!--end::Table head-->
                                                                                <!--begin::Table body-->
                                                                                <tbody class="fw-bold text-gray-600">
                                                                                    @forelse ($addendumContract->addendumContractDrafts as $addendumDraft)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <h6>
                                                                                                    <b>
                                                                                                        <a href="/contract-management/view/{{ $id_contract }}/addendum-contract/{{ $addendumContract->id_addendum }}/{{ $addendumDraft->id_addendum_draft }}"
                                                                                                            class="text-gray-800 text-hover-primary">{{ $addendumDraft->document_name_addendum }}</a>
                                                                                                    </b>
                                                                                                </h6>
                                                                                            </td>
                                                                                            <td>
                                                                                                <h6>
                                                                                                    <b>
                                                                                                        <a href="/document/view/{{ $addendumDraft->id_addendum_draft }}/{{ $addendumDraft->id_document }}"
                                                                                                            class="text-gray-800 text-hover-primary">{{ $addendumDraft->id_document }}</a>
                                                                                                    </b>
                                                                                                </h6>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span>
                                                                                                    {{ date_format(new DateTime($addendumContract->created_at), 'd M, Y') }}
                                                                                                </span>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span>
                                                                                                    {{ $addendumDraft->note_addendum }}
                                                                                                </span>
                                                                                            </td>
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
                                                                        </div>
                                                                        <!--end::Input group-->

                                                                    </div>
                                                                </div>
                                                                <!--end:::Tab pane Attachment-->

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
                                                                                        Pasal
                                                                                        <a href="#"
                                                                                            data-bs-target="#kt_modal_laporan_pasal"
                                                                                            data-bs-toggle="modal"
                                                                                            id="Plus">+</a>
                                                                                    </h3>
                                                                                </div>
                                                                                @if (Session::has('pasals'))
                                                                                    <div class="col">
                                                                                        <a name="clear-pasal" id="clear-pasal"
                                                                                            class="btn btn-sm btn-danger">Clear
                                                                                            Pasal</a>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col">
                                                                                        <a name="clear-pasal" id="clear-pasal"
                                                                                            style="visibility: hidden"
                                                                                            class="btn btn-sm btn-danger">Clear
                                                                                            Pasal</a>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="fv-row mb-7">
                                                                                <table
                                                                                    class="table align-middle table-row-dashed fs-6 gy-5"
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

                                                                                        @if (Session::has('pasals'))
                                                                                            @foreach (Session::get('pasals') as $i => $pasal)
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        {{ ++$i }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        {{ $pasal->pasal }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <h6>
                                                                                                        <b>There is no data</b>
                                                                                                    </h6>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    </tbody>
                                                                                    <!--end::Table body-->

                                                                                </table>

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
                                            </div>


                                        </div>
                                    @else
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
                                                                    <span class="required">No. Addendum Contract</span>
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
                                                                    class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="">
                                                                    <option value="null" selected>Choose draft version...
                                                                    </option>
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
                                                                            style="color: #e08c16"></i></a>
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
                                                                    value="{{ old('addendum-contract-create-by') }}"
                                                                    placeholder="Who create this draft?"
                                                                    id="addendum-contract-create-by"
                                                                    name="addendum-contract-create-by" />
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

                                                <div class="col-xl-15">
                                                    <!--begin::Contacts-->
                                                    <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                                        <!--begin::Card body-->
                                                        <div class="card-body pt-5">
                                                            <!--begin:::Tabs-->
                                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8"
                                                                role="tablist">

                                                                <!--begin:::Tab item Attachment-->
                                                                @if (!empty($addendumDrafts))
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link text-active-primary pb-4 active"
                                                                            data-bs-toggle="tab"
                                                                            href="#kt_user_view_overview_attachment"
                                                                            style="font-size:14px;" aria-selected="false"
                                                                            role="tab">Attachment</a>
                                                                    </li>
                                                                @endif
                                                                <!--end:::Tab item Attachment-->

                                                                <!--begin:::Tab item History-->
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link text-active-primary pb-4 active"
                                                                        data-bs-toggle="tab" href="#kt_user_view_overview_pasal"
                                                                        style="font-size:14px;" aria-selected="true"
                                                                        role="tab">Pasal-pasal</a>
                                                                </li>
                                                                <!--end:::Tab item History-->




                                                            </ul>
                                                            <!--end:::Tabs-->

                                                            <!--begin:::Tab content -->
                                                            <div class="tab-content" id="myTabContent">
                                                                @if (!empty($addendumDrafts))
                                                                    <!--begin::Addendum Draft Kontrak-->
                                                                    <div class="tab-pane fade show active"
                                                                        id="kt_user_view_overview_attachment" role="tabpanel">
                                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                            style="font-size:14px;">
                                                                            Addendum Kontrak Draft
                                                                            <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract/draft/new"
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
                                                                                    <th class="min-w-125px">Nama Dokumen
                                                                                    </th>
                                                                                    <th class="min-w-125px">No. Dokumen</th>
                                                                                    <th class="min-w-125px">Tanggal</th>
                                                                                    <th class="min-w-125px">Catatan</th>
                                                                                </tr>
                                                                                <!--end::Table row-->
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            <tbody class="fw-bold text-gray-600">
                                                                                <tr>
                                                                                    <td>
                                                                                        <h6><b>There is no data</b></h6>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                            <!--end::Table body-->
                                                                        </table>
                                                                    </div>
                                                                @endif
                                                                <!--end:::Tab pane Addendum Draft Kontrak-->

                                                                <!--begin:::Tab pane Pasal-->
                                                                <div class="tab-pane fade show active"
                                                                    id="kt_user_view_overview_pasal" role="tabpanel">
                                                                    <!--begin::Row-->
                                                                    <div class="row fv-row">
                                                                        {{-- Begin::Col --}}
                                                                        <div class="col-6">
                                                                            <div class="row">
                                                                                <div class="col-2">
                                                                                    <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                                        style="font-size:14px;">
                                                                                        Pasal
                                                                                        <a href="#"
                                                                                            data-bs-target="#kt_modal_laporan_pasal"
                                                                                            data-bs-toggle="modal"
                                                                                            id="Plus">+</a>
                                                                                    </h3>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    @if (Session::has('pasals'))
                                                                                        <button type="button" name="clear-pasal"
                                                                                            id="clear-pasal"
                                                                                            class="btn btn-sm btn-danger">Clear
                                                                                            Pasal</button>
                                                                                    @else
                                                                                        <button type="button" name="clear-pasal"
                                                                                            style="visibility: hidden;"
                                                                                            id="clear-pasal"
                                                                                            class="btn btn-sm btn-danger">Clear
                                                                                            Pasal</button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="fv-row mb-7">
                                                                                <table
                                                                                    class="table align-middle table-row-dashed fs-6 gy-5"
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
                                                                                        @if (Session::has('pasals'))
                                                                                            @foreach (Session::get('pasals') as $i => $pasalSession)
                                                                                                <tr>
                                                                                                    <td><b>{{ ++$i }}</b>
                                                                                                    </td>
                                                                                                    <td>{{ $pasalSession->pasal }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <tr>
                                                                                                <td><b>There is no data</b></td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    </tbody>
                                                                                    <!--end::Table body-->

                                                                                </table>

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

    <!--begin::Modal - Pasal-Pasal -->
    <div class="modal fade" id="kt_modal_laporan_pasal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Choose Pasal</h2>
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
                        <button type="button" id="save-pasal" data-bs-dismiss="modal" class="btn btn-lg mt-5 btn-primary">
                            <span>Save</span>
                            <span class="spinner-border spinner-border-sm" style="display: none;" aria-hidden="true"
                                role="status"></span>
                        </button>
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
    <!--end::Modal - Calendar -->

@endsection

@section('js-script')
    <script>
        // begin::Script adding pasal
        const toaster = document.querySelector(".toast");
        const toasterBoots = new bootstrap.Toast(toaster, {});
        const savePasalBtn = document.querySelector("#save-pasal");
        // const clearPasalBtn = document.getElementById("clear-pasal");
        const loadingElt = document.querySelector("#save-pasal > .spinner-border");
        savePasalBtn.addEventListener("click", async e => {
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
                if (toaster.classList.contains("text-bg-danger")) {
                    toaster.classList.remove("text-bg-danger");
                }
                toaster.classList.add("text-bg-success");
                document.querySelector(".toast-body").innerText = savePasal.message
                pasals.forEach((pasal) => {
                    html += `
            <tr>
                <td>
                    ${counter++}
                </td>
                <td>
                    ${pasal.pasal}
                </td>
            </tr>
            `
                });
                document.querySelector("#kt_pasal_table tbody").innerHTML = html;
                toasterBoots.show();
                document.querySelector("#clear-pasal").style.visibility = "visible";

            } else {
                if (toaster.classList.contains("text-bg-success")) {
                    toaster.classList.remove("text-bg-success");
                }
                toaster.classList.add("text-bg-danger");
                document.querySelector(".toast-body").innerText = savePasal.message
                toasterBoots.show();

            }
            loadingElt.style.display = "none";
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
                toasterBoots.show();
                toaster.classList.add("text-bg-success");
                document.querySelector(".toast-body").innerText = clearPasalsRes.message
                html = `
                <tr>
                    <td>
                        <b>There is no data</b>
                    </td>
                </tr>
                `
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
        stages.forEach((stage, i) => {
            stage.addEventListener("click", async e => {
                const formData = new FormData()
                const step = stage.getAttribute("stage");

                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_addendum", "{{ $addendumContract->id_addendum ?? 0 }}");
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
                    document.querySelector(".toast-body").innerText = setStage.msg;
                    toasterBoots.show()
                    if (step < 1) {
                        stage.classList.add("stage-is-done");
                        stage.classList.remove("stage-is-not-active");
                        stages[i++].classList.remove("stage-is-done");
                        stages[i++].classList.add("stage-is-not-active");
                    } else {
                        stage.classList.add("stage-is-done");
                        stage.classList.remove("stage-is-not-active");
                    }
                } else {
                    toaster.classList.add("text-bg-danger");
                    document.querySelector(".toast-body").innerText = setStage.msg;
                    toasterBoots.show()
                }

            })
        });
    </script>

    {{-- begin::Draft Contract JS --}}
    <script src="{{ asset('/js/custom/addendumContract/addendumContract.js') }}"></script>
    {{-- end::Draft Contract JS --}}


@endsection

@section('aside')
    @include('template.aside')
@endsection
