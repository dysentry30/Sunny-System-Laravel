{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'View Proyek')
{{-- End::Title --}}

<style>
    .form-control.form-control-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }

    .form-control.form-control-solid:disabled {
        background: #e7e7e7 !important;
    }

    .form-select.form-select-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }

    #nilai-kontrak-keseluruhan::placeholder {
        color: #D9214E;
        opacity: 1;
        /* Firefox */
    }
</style>

<!--begin::Main-->
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->


                <!--begin::Content-->
                <!--begin::Form-->
                @if ($proyek->is_cancel == false)
                    <form action={{ url('/proyek/update/retail') }} method="post" enctype="multipart/form-data">
                    @csrf
                @endif


                    <!--begin:: id_customer selected-->
                    <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}" id="kode-proyek">
                    <!--end:: id_customerid-->


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
                                    <h1
                                        class="d-flex align-items-center fs-1 my-1 fw-bolder {{ $proyek->is_cancel == true ? 'text-danger' : '' }}">
                                        @if ($proyek->is_cancel == true)
                                            Proyek Canceled - &nbsp;
                                        @else
                                            Proyek - &nbsp;
                                        @endif
                                        <div class="text-truncate" style="max-width: 500px" data-bs-toggle="tooltip"
                                            data-bs-title="{{ $proyek->nama_proyek }}" data-bs-custom-class="text-start">
                                            {{ $proyek->nama_proyek }}
                                        </div>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button onclick="document.location.reload()" type="reset" class="btn btn-sm btn-light btn-active-danger pe-3 mx-2" id="cancel-button">
                                    Discard <i class="bi bi-x"></i></button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    @if ($proyek->is_cancel == false)
                                    <button type="submit" class="btn btn-sm btn-primary ms-2" id="proyek-save"
                                        style="background-color:#008CB4">
                                        Save</button>
                                    @endif
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    {{-- <a class="btn btn-sm btn-light btn-active-danger ms-2" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_cancel_proyek" id="kt_toolbar_export">Cancel Proyek
                                    </a> --}}
                                    <!--end::Button-->

                                    <!--begin::Action-->
                                    <!--begin::Wrapper-->
                                    {{-- <div class="me-2" style="margin-left:10px;">
                                        <!--begin::Menu-->
                                        <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Action</a>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-auto" data-kt-menu="true"
                                            id="kt_menu_6155ac804a1c2">
                                            <!--begin::Header-->
                                            <!--end::Header-->
                                            <!--begin::Menu separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Form-->
                                            <div class="">
                                                <!--begin::Item-->
                                                <button type="submit"
                                                    class="btn btn-active-primary dropdown-item rounded-0" style="font-size: 10px" disabled>
                                                    Req Approval
                                                </button>
                                                <a class="btn btn-active-primary dropdown-item" style="font-size: 10px; border-radius: 0px 0px 5px 5px;"
                                                        data-bs-toggle="modal" data-bs-target="#kt_modal_cancel_proyek" id="kt_toolbar_export">
                                                    Cancel Proyek
                                                </a>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Menu-->
                                    </div> --}}
                                    <!--end::Wrapper-->
                                    <!--end::Action-->

                                    <!--begin::Button-->
                                    {{-- <a class="btn btn-sm btn-light btn-active-primary fs-7 px-4 mx-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_approval" id="kt_toolbar_primary_button"
                                        style="padding: 8px">
                                        Req Approval
                                    </a> --}}
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        id="proyek-back">
                                        Back</a>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    {{-- <a href="/proyek" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        id="proyek-close">
                                        Close</a> --}}
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
                                <div class="row">

                                    <!--begin::Header Orange-->
                                    <div class="col-xl-15 mb-8">
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <div class="card-body pt-auto"
                                                style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                                <div class="form-group">
                                                    <div id="stage-button" class="stage-list">
                                                        @if ($proyek->stage >= 1)
                                                            @if ($proyek->tipe_proyek == 'R')
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-done"
                                                                    style="outline: 0px; cursor: pointer;" stage="1">
                                                                    Pasar Dini Retail
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-done"
                                                                    style="outline: 0px; cursor: pointer;" stage="1">
                                                                    Pasar Dini
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a href="#"
                                                                class="stage-button stage-action color-is-default stage-is-not-active"
                                                                style="outline: 0px; pointer-events: none" stage="1">
                                                                Pasar Dini
                                                            </a>
                                                        @endif
                                                        @if ($proyek->stage > 1)
                                                            <a href="#"
                                                                class="stage-button stage-action color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="2">
                                                                Terkontrak
                                                            </a>
                                                        @else
                                                            @if ($proyek->is_cancel == true)
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-not-active"
                                                                    style="outline: 0px; pointer-events: none"
                                                                    stage="8">
                                                                    Terkontrak
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-not-active"
                                                                    style="outline: 0px; cursor: pointer;" stage="8">
                                                                    Terkontrak
                                                                </a>
                                                            @endif
                                                        @endif

                                                        {{-- @if ($proyek->stage > 7)
                                                            @if ($proyek->stage == 8 || $proyek->stage > 9)
                                                                <a href="#" data-bs-toggle="dropdown"
                                                                    role="button" id="terkontrak" aria-expanded="false"
                                                                    aria-controls="#terkontrak"
                                                                    class="stage-button stage-is-done color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="8">
                                                                    Terkontrak
                                                                    &nbsp;&nbsp;
                                                                    <span class=""
                                                                        style="position: relative;top: 15%;"
                                                                        stage="8"><i
                                                                            class="bi bi-caret-down-fill text-white"></i></span>
                                                                </a>
                                                            @elseif($proyek->stage == 9)
                                                                <a href="#" data-bs-toggle="dropdown"
                                                                    role="button" id="terkontrak" aria-expanded="false"
                                                                    aria-controls="#terkontrak"
                                                                    class="stage-button stage-is-done color-is-danger"
                                                                    style="outline: 0px; cursor: pointer;" stage="8">
                                                                    Terendah
                                                                    &nbsp;&nbsp;
                                                                    <span class=""
                                                                        style="position: relative;top: 15%;"
                                                                        stage="8"><i
                                                                            class="bi bi-caret-down-fill text-white"></i></span>
                                                                </a>
                                                            @endif
                                                            <ul class="dropdown-menu" id="terkontrak"
                                                                aria-labelledby="terkontrak">
                                                                <form action="/proyek/stage-save" method="POST">
                                                                </form>
                                                                <form action="/proyek/stage-save" method="POST"
                                                                    onsubmit="confirmAction(this); return false;"
                                                                    stage="1">
                                                                    @csrf
                                                                    <input type="hidden" name="kode_proyek"
                                                                        value="{{ $proyek->kode_proyek }}">
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-terkontrak"
                                                                            value="Terkontrak" /></li>
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-terendah"
                                                                            value="Terendah" /></li>
                                                                </form>
                                                            </ul>
                                                        @else
                                                            @php
                                                                $selisih = abs($proyek->stage - 8);
                                                            @endphp
                                                            @if ($selisih == 2)
                                                                <a href="#" data-bs-toggle="dropdown"
                                                                    role="button" id="terkontrak" aria-expanded="false"
                                                                    aria-controls="#terkontrak"
                                                                    class="stage-button stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="8">
                                                                    Terkontrak
                                                                    &nbsp;&nbsp;
                                                                    <span class=""
                                                                        style="position: relative;top: 15%;"
                                                                        stage="8"><i
                                                                            class="bi bi-caret-down-fill text-white"></i></span>
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;pointer-events: none;"
                                                                    stage="8">
                                                                    Terkontrak
                                                                </a>
                                                            @endif
                                                            <ul class="dropdown-menu" id="terkontrak"
                                                                aria-labelledby="terkontrak">
                                                                <form action="/proyek/stage-save" method="POST">
                                                                </form>
                                                                <form action="/proyek/stage-save" method="POST"
                                                                    onsubmit="confirmAction(this); return false;"
                                                                    stage="1">
                                                                    @csrf
                                                                    <input type="hidden" name="kode_proyek"
                                                                        value="{{ $proyek->kode_proyek }}">
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-terkontrak"
                                                                            value="Terkontrak" /></li>
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-terendah"
                                                                            value="Terendah" /></li>
                                                                </form>
                                                            </ul>
                                                        @endif --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($proyek->is_cancel == false)
                                    <script>
                                        function confirmAction(form) {
                                            const formSend = document.createElement("form");
                                            formSend.setAttribute("method", "post");
                                            formSend.setAttribute("action", "/proyek/stage-save");
                                            let html = `
                                                    @csrf
                                                    <input type="hidden" name="kode_proyek" value="{{ $proyek->kode_proyek }}">
                                                `;
                                            if (form.submitted == "Menang") {
                                                html +=
                                                    `<input type="hidden" onclick="this.form.submitted=this.value" class="dropdown-item" name="stage-menang" value="Menang"/>`;
                                            } else if (form.submitted == "Kalah") {
                                                html +=
                                                    `<input type="hidden" onclick="this.form.submitted=this.value" class="dropdown-item" name="stage-kalah" value="Kalah"/>`;
                                            }

                                            if (form.submitted == "Terkontrak") {
                                                html +=
                                                    `<input type="hidden" onclick="this.form.submitted=this.value" class="dropdown-item" name="stage-terkontrak" value="Terkontrak"/>`;

                                            } else if (form.submitted == "Terendah") {
                                                html +=
                                                    `<input type="hidden" onclick="this.form.submitted=this.value" class="dropdown-item" name="stage-terendah" value="Terendah"/>`;
                                            }
                                            formSend.innerHTML = html;
                                            document.body.appendChild(formSend);
                                            Swal.fire({
                                                title: '',
                                                text: "Yakin Pindah Stage ?",
                                                icon: false,
                                                showCancelButton: true,
                                                confirmButtonColor: '#008CB4',
                                                cancelButtonColor: '#BABABA',
                                                confirmButtonText: 'Ya'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    formSend.submit();
                                                }
                                                return false;
                                            });
                                        }
                                        const stageActions = document.querySelectorAll(".stage-action");
                                        stageActions.forEach(stageAction => {
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
                                                        const stage = e.target.getAttribute("stage");
                                                        const formData = new FormData();
                                                        formData.append("_token", "{{ csrf_token() }}");
                                                        formData.append("stage", stage);
                                                        formData.append("is_ajax", true);
                                                        // formData.append("id", "");
                                                        formData.append("kode_proyek", "{{ $proyek->kode_proyek }}");
                                                        const setStage = await fetch("/proyek/stage-save", {
                                                            method: "POST",
                                                            body: formData
                                                        }).then(res => res.json());
                                                        console.log(setStage);
                                                        if (setStage.link) {
                                                            window.location.reload();
                                                        }
                                                    }
                                                })
                                            });
                                        });
                                    </script>
                                    @endif
                                    <!--end::Header Orange-->


                                    <!--begin::All Content-->
                                    <div class="col-xl-15">
                                        <!--begin::Contacts-->
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <!--begin::Card body-->
                                            <div class="card-body pt-5">

                                                <!--begin:::Tabs Navigasi-->
                                                <ul
                                                    class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">

                                                    @if ($proyek->stage == 0)
                                                        <!--begin:::Tab item Pasar Dini-->
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_pasardini"
                                                                style="font-size:14px;">Proyek Canceled</a>
                                                        </li>
                                                        <!--end:::Tab item Pasar Dini-->
                                                    @endif

                                                    @if ($proyek->stage > 0)
                                                        <!--begin:::Tab item Pasar Dini-->
                                                        <li class="nav-item">
                                                            <a onclick="showSave()"
                                                                class="nav-link text-active-primary pb-4 {{ $tabPane == 'kt_user_view_overview_forecast' ? 'active' : '' }}"
                                                                data-bs-toggle="tab" href="#kt_user_view_overview_pasardini"
                                                                style="font-size:14px;">Pasar Dini</a>
                                                        </li>
                                                        <!--end:::Tab item Pasar Dini-->
                                                    @endif

                                                    <!--begin:::Tab item Forecast-->
                                                    <li class="nav-item">
                                                        <a onclick="hideSave()"
                                                            class="nav-link text-active-primary pb-4 {{ $tabPane == 'kt_user_view_overview_forecast' ? '' : 'active' }}"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_overview_forecast"
                                                            style="font-size:14px;">Forecast Retail</a>
                                                    </li>
                                                    <script>
                                                        function hideSave() {
                                                            document.getElementById('proyek-save').style.display = "none";
                                                        }

                                                        function showSave() {
                                                            document.getElementById('proyek-save').style.display = "";
                                                        }
                                                    </script>
                                                    <!--end:::Tab item Forecast-->

                                                    <!--begin:::Tab item Approval-->
                                                    {{-- <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                        data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_overview_approval"
                                                            style="font-size:14px;">Approval</a>
                                                        </li> --}}
                                                    <!--end:::Tab item Approval-->

                                                    @if ($proyek->stage > 9)
                                                        <!--begin:::Tab item Feedback-->
                                                        {{-- <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_Feedback"
                                                                style="font-size:14px;">Feedback</a>
                                                            </li> --}}
                                                        <!--end:::Tab item Feedback-->
                                                    @endif

                                                    @if ($proyek->stage > 9)
                                                        <!--begin:::Tab item Feedback-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                {{-- href="#kt_user_view_overview_Feedback" --}}
                                                                style="font-size:14px; color:#D9214E">*Gugur
                                                                Prakualifikasi</a>
                                                        </li>
                                                        <!--end:::Tab item Feedback-->
                                                    @endif
                                                </ul>
                                                <!--end:::Tabs Navigasi-->

                                                <!--begin:::Tab isi content  -->
                                                <div class="tab-content" id="myTabContent">

                                                    <!--begin:::Tab Pasar Dini-->
                                                    <div class="tab-pane fade "
                                                        id="kt_user_view_overview_pasardini" role="tabpanel">

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Nama Proyek</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid char-counter"
                                                                        data-max-char="36"
                                                                        id="nama-proyek" name="nama-proyek"
                                                                        value="{{ $proyek->nama_proyek }}" />
                                                                    <div class="d-flex flex-row justify-content-end">
                                                                        <small class="">0/36</small>
                                                                    </div>
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
                                                                        <span class="required">Unit Kerja <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- <select name="unit-kerja"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Unit Kerja">
                                                                        <option></option>
                                                                        @foreach ($unitkerjas as $unitkerja)
                                                                        @if ($unitkerja->divcode == $proyek->unit_kerja)
                                                                        <option
                                                                        value="{{ $unitkerja->divcode }}"
                                                                        selected>{{ $unitkerja->unit_kerja }}
                                                                    </option>
                                                                    @endif
                                                                    @endforeach
                                                                    </select> --}}
                                                                    @foreach ($unitkerjas as $unitkerja)
                                                                        @if ($unitkerja->divcode == $proyek->unit_kerja)
                                                                            <input type="text"
                                                                                class="form-control form-control-solid"
                                                                                value="{{ $unitkerja->unit_kerja }}"
                                                                                readonly />
                                                                        @endif
                                                                    @endforeach
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Kode Proyek <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    @isset($proyek->kode_proyek)
                                                                        <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="edit-kode-proyek" name="edit-kode-proyek"
                                                                            value="{{ $proyek->kode_proyek }}" readonly />
                                                                    @endisset
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                            <div class="col-6 mt-5">
                                                                <div>
                                                                    @if ((bool) $proyek->is_rkap)
                                                                        <span class="px-4 fs-4 badge badge-light-success">
                                                                            Proyek RKAP
                                                                        </span>
                                                                    @else
                                                                        <span class="px-4 fs-4 badge badge-light-danger">
                                                                            Proyek Non RKAP
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Pelanggan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- <option value="{{ $proyekberjalans->kode_proyek }}" selected>{{$proyekberjalans->kode_proyek }}</option> --}}
                                                                    <select id="customer" name="customer"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Pilih Customer">
                                                                        <option></option>
                                                                        @if (isset($proyekberjalans))
                                                                            @foreach ($customers as $customer)
                                                                                @if ($customer->id_customer == $proyekberjalans->id_customer)
                                                                                    <option
                                                                                        value="{{ $customer->id_customer }}"
                                                                                        selected>{{ $customer->name }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $customer->id_customer }}">
                                                                                        {{ $customer->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach ($customers as $customer)
                                                                                <option
                                                                                    value="{{ $customer->id_customer }}">
                                                                                    {{ $customer->name }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Tipe Proyek <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="tipe-proyek" name="tipe-proyek"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Tipe Proyek"
                                                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                                                        <option value="R"
                                                                            {{ $proyek->tipe_proyek == 'R' ? 'selected' : '' }}>
                                                                            Retail</option>
                                                                        {{-- <option value="P" {{ $proyek->tipe_proyek == 'P' ? 'selected' : '' }}>Non-Retail</option> --}}
                                                                    </select>
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
                                                                        <span class="required">Jenis Proyek <i
                                                                                class="bi bi-key"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- @dump($proyek->jenis_proyek) --}}
                                                                    <select id="jenis-proyek" name="jenis-proyek"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Jenis Proyek"
                                                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                                                        <option value="I"
                                                                            {{ $proyek->jenis_proyek == 'I' ? 'selected' : '' }}>
                                                                            Internal</option>
                                                                        <option value="N"
                                                                            {{ $proyek->jenis_proyek == 'N' ? 'selected' : '' }}>
                                                                            External</option>
                                                                        <option value="J"
                                                                            {{ $proyek->jenis_proyek == 'J' ? 'selected' : '' }}>
                                                                            JO</option>
                                                                    </select>
                                                                    {{-- <input type="hidden" name="jo-category" id="jo-category" value="">
                                                                    @php
                                                                        $jenis_jo = "";
                                                                        switch ($proyek->jenis_jo) {
                                                                            case 30:
                                                                                $jenis_jo = "JO Integrated Leader";
                                                                                break;
                                                                            case 31:
                                                                                $jenis_jo = "JO Integrated Member";
                                                                                break;
                                                                            case 40:
                                                                                $jenis_jo = "JO Portion Leader";
                                                                                break;
                                                                            case 41:
                                                                                $jenis_jo = "JO Portion Member";
                                                                                break;
                                                                            case 50:
                                                                                $jenis_jo = "JO Mix Integrated - Portion";
                                                                                break;
                                                                            default:
                                                                                $jenis_jo = "Proyek ini bukan JO";
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    @if(!empty($proyek->jenis_jo))
                                                                        <small>JO Category: <b>{{ $jenis_jo }}</b></small>
                                                                    @else 
                                                                        <small>JO Category: <b class="text-danger">{{ $jenis_jo }}</b></small>
                                                                    @endif --}}
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->


                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">RA Tahun Perolehan <i
                                                                                class="bi bi-key"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- @php
                                                                        $years = $proyek->tahun_perolehan;
                                                                    @endphp --}}
                                                                    {{-- @for ($i = 2021; $i < $years + 20; $i++)
                                                                        <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                                            {{ $i }}</option>
                                                                    @endfor --}}
                                                                    <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        name="tahun-perolehan" min="2021"
                                                                        max="{{ $proyek->tahun_perolehan + 10 }}"
                                                                        step="1"
                                                                        value="{{ $proyek->tahun_perolehan }}"
                                                                        {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
                                                                    <!--begin::Input-->
                                                                    {{-- <select id="tahun-perolehan" name="tahun-perolehan"
                                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                                                        @for ($i = 2021; $i < $years + 20; $i++)
                                                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select> --}}
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
                                                                        <span>RA Bulan Perolehan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--Begin::Input-->
                                                                    <select id="bulan-pelaksanaan"
                                                                        name="bulan-pelaksanaan"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Bulan Perolehan">
                                                                        <option></option>
                                                                        <option value="1"
                                                                            {{ $proyek->bulan_pelaksanaan == '1' ? 'selected' : '' }}>
                                                                            Januari</option>
                                                                        <option value="2"
                                                                            {{ $proyek->bulan_pelaksanaan == '2' ? 'selected' : '' }}>
                                                                            Februari</option>
                                                                        <option value="3"
                                                                            {{ $proyek->bulan_pelaksanaan == '3' ? 'selected' : '' }}>
                                                                            Maret</option>
                                                                        <option value="4"
                                                                            {{ $proyek->bulan_pelaksanaan == '4' ? 'selected' : '' }}>
                                                                            April</option>
                                                                        <option value="5"
                                                                            {{ $proyek->bulan_pelaksanaan == '5' ? 'selected' : '' }}>
                                                                            Mei</option>
                                                                        <option value="6"
                                                                            {{ $proyek->bulan_pelaksanaan == '6' ? 'selected' : '' }}>
                                                                            Juni</option>
                                                                        <option value="7"
                                                                            {{ $proyek->bulan_pelaksanaan == '7' ? 'selected' : '' }}>
                                                                            Juli</option>
                                                                        <option value="8"
                                                                            {{ $proyek->bulan_pelaksanaan == '8' ? 'selected' : '' }}>
                                                                            Agustus</option>
                                                                        <option value="9"
                                                                            {{ $proyek->bulan_pelaksanaan == '9' ? 'selected' : '' }}>
                                                                            September</option>
                                                                        <option value="10"
                                                                            {{ $proyek->bulan_pelaksanaan == '10' ? 'selected' : '' }}>
                                                                            Oktober</option>
                                                                        <option value="11"
                                                                            {{ $proyek->bulan_pelaksanaan == '11' ? 'selected' : '' }}>
                                                                            November</option>
                                                                        <option value="12"
                                                                            {{ $proyek->bulan_pelaksanaan == '12' ? 'selected' : '' }}>
                                                                            Desember</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->


                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Sumber Dana</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="sumber-dana" name="sumber-dana"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Sumber Dana">
                                                                        <option></option>
                                                                        @foreach ($sumberdanas as $sumberdana)
                                                                            @if ($sumberdana->kode_sumber == $proyek->sumber_dana)
                                                                                <option
                                                                                    value="{{ $sumberdana->kode_sumber }}"
                                                                                    selected>
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    value="{{ $sumberdana->kode_sumber }}">
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--Begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>RA Klasifikasi Proyek</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="ra-klasifikasi-proyek" name="ra-klasifikasi-proyek"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="RA Klasifikasi Proyek">
                                                                        <option value="" selected></option>
                                                                        <option value="Proyek Kecil">Proyek Kecil</option>
                                                                        <option value="Proyek Menengah">Proyek Menengah</option>
                                                                        <option value="Proyek Besar">Proyek Besar</option>
                                                                        <option value="Proyek Mega">Proyek Mega</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                            <!--End begin::Col-->
                                                            {{-- <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Nilai OK (Excludde Ppn)</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control reformat form-control-solid"
                                                                        id="nilai-rkap" name="nilai-rkap"
                                                                        value="{{ $proyek->nilai_rkap }}"
                                                                        placeholder="Nilai OK (Excludde Ppn)" readonly/>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div> --}}
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Status Pasar Dini</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="status-pasardini" name="status-pasardini" placeholder="Status Pasar Dini"
                                                                        value="{{ $proyek->status_pasdin }}" /> --}}
                                                                    <select id="status-pasardini" name="status-pasardini"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Status Pasar Dini">
                                                                        <option value=""></option>
                                                                        <option value="Cadangan"
                                                                            {{ $proyek->status_pasdin == 'Cadangan' ? 'selected' : '' }}>
                                                                            Cadangan</option>
                                                                        <option value="Potensial"
                                                                            {{ $proyek->status_pasdin == 'Potensial' ? 'selected' : '' }}>
                                                                            Potensial</option>
                                                                        <option value="Sasaran"
                                                                            {{ $proyek->status_pasdin == 'Sasaran' ? 'selected' : '' }}>
                                                                            Sasaran</option>
                                                                    </select>
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
                                                                        <span>Asal Info Proyek</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="info-proyek" name="info-proyek"
                                                                        placeholder="Asal Info Proyek"
                                                                        value="{{ $proyek->info_asal_proyek }}" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->


                                                        <!--Begin::Title Biru Form: Nilai RKAP Review-->
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Nilai RKAP Review &nbsp;
                                                            <i onclick="hideReview()" id="hide-review"
                                                                style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                onclick="showReview()" id="show-review"
                                                                class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <script>
                                                            function hideReview() {
                                                                document.getElementById("divRkapReview").style.display = "none";
                                                                document.getElementById("hide-review").style.display = "none";
                                                                document.getElementById("show-review").style.display = "";
                                                            }

                                                            function showReview() {
                                                                document.getElementById("divRkapReview").style.display = "";
                                                                document.getElementById("hide-review").style.display = "";
                                                                document.getElementById("show-review").style.display = "none";
                                                            }
                                                        </script>
                                                        <br>
                                                        <div id="divRkapReview" style="display:none">
                                                            <!--End::Title Biru Form: Nilai RKAP Review-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK Review (Valas) (Exclude Tax) <i
                                                                                    class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" onkeyup="hitungReview()"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilai-valas-review"
                                                                            name="nilai-valas-review"
                                                                            value="{{ $proyek->nilai_valas_review }}"
                                                                            placeholder="Nilai OK Review (Valas) (Exclude Tax)"
                                                                            {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
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
                                                                            <span>Mata Uang Review <i
                                                                                    class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="mata-uang-review"
                                                                            name="mata-uang-review"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Mata Uang"
                                                                            {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                                                            <option></option>
                                                                            <option value="Rupiah"
                                                                                {{ $proyek->mata_uang_review == 'Rupiah' ? 'selected' : '' }}>
                                                                                Rupiah</option>
                                                                            <option value="US Dollar"
                                                                                {{ $proyek->mata_uang_review == 'US Dollar' ? 'selected' : '' }}>
                                                                                US Dollar</option>
                                                                            <option value="Chinese Yuan"
                                                                                {{ $proyek->mata_uang_review == 'Chinese Yuan' ? 'selected' : '' }}>
                                                                                Chinese Yuan</option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Kurs Review <i
                                                                                    class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input onkeyup="hitungReview()" type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="kurs-review" name="kurs-review"
                                                                            value="{{ $proyek->kurs_review }}"
                                                                            placeholder="Kurs Review"
                                                                            {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
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
                                                                            <span>Bulan Pelaksanaan Review <i
                                                                                    class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="bulan-pelaksanaan-review"
                                                                            name="bulan-pelaksanaan-review"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Bulan Pelaksanaan"
                                                                            {{ auth()->user()->check_administrator ? '' : 'readonly' }}>
                                                                            <option></option>
                                                                            <option value="1"
                                                                                {{ $proyek->bulan_review == '1' ? 'selected' : '' }}>
                                                                                Januari</option>
                                                                            <option value="2"
                                                                                {{ $proyek->bulan_review == '2' ? 'selected' : '' }}>
                                                                                Februari</option>
                                                                            <option value="3"
                                                                                {{ $proyek->bulan_review == '3' ? 'selected' : '' }}>
                                                                                Maret</option>
                                                                            <option value="4"
                                                                                {{ $proyek->bulan_review == '4' ? 'selected' : '' }}>
                                                                                April</option>
                                                                            <option value="5"
                                                                                {{ $proyek->bulan_review == '5' ? 'selected' : '' }}>
                                                                                Mei</option>
                                                                            <option value="6"
                                                                                {{ $proyek->bulan_review == '6' ? 'selected' : '' }}>
                                                                                Juni</option>
                                                                            <option value="7"
                                                                                {{ $proyek->bulan_review == '7' ? 'selected' : '' }}>
                                                                                Juli</option>
                                                                            <option value="8"
                                                                                {{ $proyek->bulan_review == '8' ? 'selected' : '' }}>
                                                                                Agustus</option>
                                                                            <option value="9"
                                                                                {{ $proyek->bulan_review == '9' ? 'selected' : '' }}>
                                                                                September</option>
                                                                            <option value="10"
                                                                                {{ $proyek->bulan_review == '10' ? 'selected' : '' }}>
                                                                                Oktober</option>
                                                                            <option value="11"
                                                                                {{ $proyek->bulan_review == '11' ? 'selected' : '' }}>
                                                                                November</option>
                                                                            <option value="12"
                                                                                {{ $proyek->bulan_review == '12' ? 'selected' : '' }}>
                                                                                Desember</option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK (Exclude PPN) <i
                                                                                    class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilaiok-review" name="nilaiok-review"
                                                                            value="{{ $proyek->nilaiok_review }}"
                                                                            placeholder="Nilai OK (Exclude PPN)"
                                                                            {{ auth()->user()->check_administrator ? '' : 'readonly' }} />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <script>
                                                                function hitungReview() {
                                                                    let nilaiOkReview = document.getElementById("nilai-valas-review").value.replaceAll(".", "");
                                                                    // console.log(nilaiOkReview); 
                                                                    let kursReview = document.getElementById("kurs-review").value.replaceAll(".", "");
                                                                    let hasilOkReview = nilaiOkReview * kursReview;
                                                                    document.getElementById("nilaiok-review").value = Intl.NumberFormat(["id"]).format(hasilOkReview);
                                                                }
                                                            </script>
                                                        </div>
                                                        <!--divRkapReview-->


                                                        <!--Begin::Title Biru Form: Nilai RKAP Awal-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Nilai RKAP Awal &nbsp;
                                                            <i onclick="hideColumn()" id="hide-button"
                                                                style="display: none" class="bi bi-arrows-collapse"></i><i
                                                                onclick="showColumn()" id="show-button"
                                                                class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <script>
                                                            function hideColumn() {
                                                                document.getElementById("divRkapAwal").style.display = "none";
                                                                document.getElementById("hide-button").style.display = "none";
                                                                document.getElementById("show-button").style.display = "";
                                                            }

                                                            function showColumn() {
                                                                document.getElementById("divRkapAwal").style.display = "";
                                                                document.getElementById("hide-button").style.display = "";
                                                                document.getElementById("show-button").style.display = "none";
                                                            }
                                                        </script>
                                                        <br>
                                                        <div id="divRkapAwal" style="display: none">
                                                            <!--End::Title Biru Form: Nilai RKAP Awal-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK Awal (Valas) (Exclude Tax) <i
                                                                                    class="bi bi-lock"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" onkeyup="hitungAwal()"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilai-valas-awal" name="nilai-valas-awal"
                                                                            value="{{ number_format((int) $proyek->nilai_rkap, 0, '.', '.') }}"
                                                                            placeholder="Nilai OK Awal (Valas) (Exclude Tax)"
                                                                            readonly />
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
                                                                            <span>Mata Uang Awal</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="mata-uang-awal" name="mata-uang-awal"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Mata Uang">
                                                                            <option></option>
                                                                            <option value="Rupiah"
                                                                                {{ $proyek->mata_uang_awal == 'Rupiah' ? 'selected' : '' }}>
                                                                                Rupiah</option>
                                                                            <option value="US Dollar"
                                                                                {{ $proyek->mata_uang_awal == 'US Dollar' ? 'selected' : '' }}>
                                                                                US Dollar</option>
                                                                            <option value="Chinese Yuan"
                                                                                {{ $proyek->mata_uang_awal == 'Chinese Yuan' ? 'selected' : '' }}>
                                                                                Chinese Yuan</option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Kurs Awal</span>
                                                                        </label>
                                                                        <!--end::Label-->

                                                                        <!--begin::Input-->
                                                                        <input onkeyup="hitungAwal()" type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="kurs-awal" name="kurs-awal"
                                                                            value="{{ $proyek->kurs_awal }}"
                                                                            placeholder="Kurs Awal" />
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
                                                                            <span>Bulan Pelaksanaan Awal <i
                                                                                    class="bi bi-lock"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="bulan-pelaksanaan-awal"
                                                                            name="bulan-pelaksanaan-awal"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Bulan Pelaksanaan" readonly>
                                                                            <option></option>
                                                                            <option selected>
                                                                                @switch($proyek->bulan_pelaksanaan)
                                                                                    @case('1')
                                                                                        Januari
                                                                                    @break

                                                                                    @case('2')
                                                                                        Februari
                                                                                    @break

                                                                                    @case('3')
                                                                                        Maret
                                                                                    @break

                                                                                    @case('4')
                                                                                        April
                                                                                    @break

                                                                                    @case('5')
                                                                                        Mei
                                                                                    @break

                                                                                    @case('6')
                                                                                        Juni
                                                                                    @break

                                                                                    @case('7')
                                                                                        Juli
                                                                                    @break

                                                                                    @case('8')
                                                                                        Agustus
                                                                                    @break

                                                                                    @case('9')
                                                                                        September
                                                                                    @break

                                                                                    @case('10')
                                                                                        Oktober
                                                                                    @break

                                                                                    @case('11')
                                                                                        November
                                                                                    @break

                                                                                    @case('12')
                                                                                        Desember
                                                                                    @break

                                                                                    @default
                                                                                        *Bulan Belum Ditentukan
                                                                                @endswitch
                                                                            </option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK (Exclude PPN) <i
                                                                                    class="bi bi-lock"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->

                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilaiok-awal" name="nilaiok-awal"
                                                                            value="{{ $proyek->nilaiok_awal == null ? number_format((int) $proyek->nilai_rkap, 0, '.', '.') : number_format((int) $proyek->nilaiok_awal, 0, '.', '.') }}"
                                                                            placeholder="Nilai OK (Exclude PPN)"
                                                                            readonly />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <script>
                                                                function hitungAwal() {
                                                                    let nilaiOkAwal = document.getElementById("nilai-valas-awal").value.replaceAll(".", "");
                                                                    let kursAwal = document.getElementById("kurs-awal").value.replaceAll(".", "");
                                                                    let hasilOkAwal = nilaiOkAwal * kursAwal;
                                                                    document.getElementById("nilaiok-awal").value = Intl.NumberFormat(["id"]).format(hasilOkAwal);
                                                                }
                                                            </script>
                                                            <!--End::Row Kanan+Kiri-->
                                                        </div>
                                                        <!--divRkapAwal-->


                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control" rows="7">{!! $proyek->laporan_kualitatif_pasdin !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Pasar Dini-->

                </form>
                <!--end::Form-->

                {{-- Begin :: Modal Jenis Proyek JO Detail --}}
    <div class="modal fade" id="kt_modal_jo_detail" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                {{-- <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Pilih JO: </h2>
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
                </div> --}}
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">


                    <!--begin::Row Kanan+Kiri-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Input group Website-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label">
                                    <span><b>Pilih JO:</b></span>
                                    {{-- <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}">Max Porsi JO : {{ $proyek->porsi_jo }}% </b></span> --}}
                                </label>
                                <select id="detail-jo" name="detail-jo" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis JO" readonly="" tabindex="-1" aria-hidden="true" data-select2-id="select2-data-jenis-jo">
                                    <option value="" selected></option>
                                    <option value="30">JO Integrated Leader</option>
                                    <option value="31">JO Integrated Member</option>
                                    <option value="40">JO Portion Leader</option>
                                    <option value="41">JO Portion Member</option>
                                    <option value="50">JO Mix Integrated - Portion</option>
                                </select>
                                <!--end::Label-->
                                <!--begin::Label-->
                                {{-- <label class="fs-6 fw-bold form-label mt-3">
                            <span><b>Sisa Porsi JO : {{ $proyek->porsi_jo }} - </b>
                                <b id="selisih-porsi">0</b>
                                <b id="sisa-porsi"> = {{ $proyek->porsi_jo }}%</b></span>
                        </label> --}}
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--End::Row Kanan+Kiri-->

                </div>
                <div class="modal-footer">

                    <button type="button" onclick="changeValueJODetail(this)" class="btn btn-sm btn-light btn-active-primary text-white"
                        id="jo_detail_save" style="background-color:#008CB4">Save</button>

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- End :: Modal Jenis Proyek JO Detail --}}



<!--begin:::Tab Forecast Retail-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_forecast" role="tabpanel">

                    <!--Begin::Title Biru Form: History-->
                    <br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">History Forecast (Input nilai real)</h3>
                    <!--End::Title Biru Form: List History-->

                    <!-- begin::Detail History Forecast -->
                    <div class="row">
                        <div class="d-flex flex-row-reverse">
                            @php
                                $now = Carbon\Carbon::now();
                                $now = $now->setDays(1)->subMonths(5);
                            @endphp
                            <ul
                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-5">
                                @foreach (range(1,6) as $item)
                                    <!--begin:::Tab item Pasar Dini-->
                                    <li class="nav-item">
                                        <a class="nav-link text-active-primary {{$item == 6 ? "active" : ""}}" data-bs-toggle="tab"
                                            href="#kt_user_view_forecasts_{{(int) $now->format("m")}}_{{$now->format("Y")}}"
                                            style="font-size:14px;">{{$now->translatedFormat("F Y")}}</a>
                                    </li>
                                    @php
                                        $now = $now->addMonths(1);
                                    @endphp
                                    <!--end:::Tab item Pasar Dini-->
                                @endforeach
                            </ul>
                            <!--end::Input-->
                            
                        </div>
                        <!--end:::Tab isi content-->
                            
                        </div>
                        <hr>

                        @php
                        $now_pane = Carbon\Carbon::now()->setDays(1)->subMonths(5);
                        @endphp
                        <div class="tab-content">
                            @foreach (range(1,6) as $item)
                                <!--begin:::Tab Pane Forecasts-->
                                <div class="tab-pane fade {{$item == 6 ? "show active" : ""}}" id="kt_user_view_forecasts_{{(int) $now_pane->format("m")}}_{{$now_pane->format("Y")}}" role="tabpanel">
                                    <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="min-w-auto text-end">Periode</th>
                                                    <th class="min-w-auto text-center">Nilai OK</th>
                                                    <th class="min-w-auto text-center">Forecast</th>
                                                    <th class="min-w-auto text-center">Realisasi</th>
                                                    <th class="min-w-auto text-center"></th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <form action="/proyek/forecast/{{ $i }}/{{ (int) $now_pane->format("m") }}/{{(int) $now_pane->format("Y")}}/retail" onsubmit="disabledSubmitButton(this)" method="post">                                    @csrf
                                                        <input type="hidden" name="kode-proyek" value="{{ $proyek->kode_proyek }}"
                                                            id="kode-proyek">
                                                        <tr>
                                                            <!--begin::Name-->
                                                            <td class="text-end"><b>
                                                                    @switch($i)
                                                                        @case('1')
                                                                            Januari :
                                                                        @break
    
                                                                        @case('2')
                                                                            Februari :
                                                                        @break
    
                                                                        @case('3')
                                                                            Maret :
                                                                        @break
    
                                                                        @case('4')
                                                                            April :
                                                                        @break
    
                                                                        @case('5')
                                                                            Mei :
                                                                        @break
    
                                                                        @case('6')
                                                                            Juni :
                                                                        @break
    
                                                                        @case('7')
                                                                            Juli :
                                                                        @break
    
                                                                        @case('8')
                                                                            Agustus :
                                                                        @break
    
                                                                        @case('9')
                                                                            September :
                                                                        @break
    
                                                                        @case('10')
                                                                            Oktober :
                                                                        @break
    
                                                                        @case('11')
                                                                            November :
                                                                        @break
    
                                                                        @case('12')
                                                                            Desember :
                                                                        @break
    
                                                                        @default
                                                                            -
                                                                    @endswitch
                                                                </b>
                                                            </td>
                                                            <!--end::Name-->
                                                            <!--begin::input-->
                                                            @php
                                                                $forecasts = $proyek->Forecasts->where("periode_prognosa", "=", (int) $now_pane->format("m"))->filter(function ($f) use ($i) {
                                                                    return $f->month_forecast == $i;
                                                                });
                                                                $history = $proyek->HistoryForecasts->where("periode_prognosa", (int) $now_pane->format("m"));
                                                                $is_periode_unlock = $history->every(function($item) {
                                                                    return empty($item->is_approved_1);
                                                                });
                                                                $currMonth = (int) date("m");
                                                            @endphp
                                                            @if (count($forecasts) > 0)
                                                                @php
                                                                    $forecast = $forecasts->first();
                                                                    // dd($forecast);
                                                                @endphp
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilaiok-{{ $i }}"
                                                                        name="nilaiok-{{ $i }}"
                                                                        value="{{ number_format((int) $forecast->rkap_forecast, 0, '.', '.') }}"
                                                                        placeholder="Nilai Perolehan" {{ $is_periode_unlock && $i < $forecast->periode_prognosa && !$is_admin ? "disabled" : "" }} />
                                                                </td>
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilaiforecast-{{ $i }}"
                                                                        name="nilaiforecast-{{ $i }}"
                                                                        value="{{ number_format((int) $forecast->nilai_forecast, 0, '.', '.') }}"
                                                                        placeholder="Nilai Forecast" {{ $is_periode_unlock && $i < $forecast->periode_prognosa && !$is_admin ? "disabled" : "" }} />
                                                                </td>
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilairealisasi-{{ $i }}"
                                                                        name="nilairealisasi-{{ $i }}"
                                                                        value="{{ number_format((int) $forecast->realisasi_forecast, 0, '.', '.') }}"
                                                                        placeholder="Nilai Realisasi" {{ $is_periode_unlock && $i < $forecast->periode_prognosa && !$is_admin ? "disabled" : "" }} />
                                                                </td>
                                                            @else
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilaiok-{{ $i }}"
                                                                        name="nilaiok-{{ $i }}"
                                                                        placeholder="Isi Nilai Perolehan" {{ ($i < $currMonth) && !$is_admin ? "disabled" : "" }} />
                                                                </td>
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilaiforecast-{{ $i }}"
                                                                        name="nilaiforecast-{{ $i }}"
                                                                        placeholder="Isi Nilai Forecast" {{ ($i < $currMonth) && !$is_admin ? "disabled" : "" }} 
                                                                        {{-- placeholder="Isi Nilai Forecast"  --}}
                                                                    />
                                                                </td>
                                                                <td class="text-dark">
                                                                    <input type="text"
                                                                        class="text-end form-control form-control-solid reformat-retail"
                                                                        id="nilairealisasi-{{ $i }}"
                                                                        name="nilairealisasi-{{ $i }}"
                                                                        placeholder="Isi Nilai Realisasi" {{ ($i < $currMonth) && !$is_admin ? "disabled" : "" }} 
                                                                        {{-- placeholder="Isi Nilai Realisasi" --}}
                                                                    />
                                                                </td>
                                                            @endif
                                                            <!--begin::input-->
                                                            <td>
                                                                @if (($proyek->is_cancel != false || (!empty($forecast) && $i >= $forecast->periode_prognosa)) || $is_admin)
                                                                {{-- @if ($proyek->is_cancel == false && !empty($forecast)) --}}
                                                                <button type="submit" class="btn btn-sm btn-light btn-active-primary"
                                                                    id="forecast-save">
                                                                    Save</button>
                                                                </button>
                                                                @endif
                                                            </td>
                                                            <!--end::Button-->
                                                        </tr>
                                                    </form>
                                                @endfor
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    @php
                                        $now_pane = $now_pane->addMonths(1);
                                    @endphp
                                </div>
                                <!--end:::Tab Pane Forecasts-->
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    <!-- end::Detail History Forecast -->
                    
<!--end:::Tab Forecast Retail-->



            </div>
            <!--end::Card body-->

        </div>
        <!--end::Content-->

    </div>
    <!--end::Contacts App- Edit Contact-->

    </div>
    <!--end::Container-->
    </div>
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

@endsection

@section('js-script')
    <!--begin:: Dokumen File Upload Max Size-->
    <script>
        var inputs = document.getElementsByTagName('input');

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type.toLowerCase() == 'file') {
                inputs[i].onchange = function() {
                    if (this.files[0].size > 52428800) { //50MB dalam byte
                        // console.log(this.name);
                        document.getElementById("error-" + this.name).style.display = "";
                        this.value = "";
                    } else {
                        this.form.submit()
                    };
                }
            }
        };
    </script>
    <!--end:: Dokumen File Upload Max Size-->

    <!--begin:: Info Pada ToolTip-->
    <script>
        let journal = document.getElementsByClassName("bi-journal-text");
        for (i = 0; i < journal.length; ++i) {
            journal[i].setAttribute("data-bs-toggle", "tooltip");
            journal[i].setAttribute("data-bs-html", "true");
            journal[i].setAttribute("data-bs-placement", "right");
            journal[i].setAttribute("data-bs-custom-class", "text-start");
            journal[i].setAttribute("data-bs-title", "Mandatori / Required untuk lanjut ke Contract Management");
        }
        let gembok = document.getElementsByClassName("bi-lock");
        for (i = 0; i < gembok.length; ++i) {
            gembok[i].setAttribute("data-bs-toggle", "tooltip");
            gembok[i].setAttribute("data-bs-html", "true");
            gembok[i].setAttribute("data-bs-placement", "right");
            gembok[i].setAttribute("data-bs-custom-class", "text-start");
            gembok[i].setAttribute("data-bs-title", "Tidak Dapat Diubah dan Mandatori, Readonly!");
        }
        let admin = document.getElementsByClassName("bi-key");
        for (i = 0; i < admin.length; ++i) {
            admin[i].setAttribute("data-bs-toggle", "tooltip");
            admin[i].setAttribute("data-bs-html", "true");
            admin[i].setAttribute("data-bs-placement", "right");
            admin[i].setAttribute("data-bs-custom-class", "text-start");
            admin[i].setAttribute("data-bs-title", "Hanya Bisa Diubah Oleh Admin");
        }
    </script>
    <!--end:: Info Pada ToolTip-->

    <script>
        $('#kt_modal_porsijo').on('show.bs.modal', function() {
            $("#company-jo").select2({
                dropdownParent: $("#kt_modal_porsijo")
            });
        });
        $('#kt_modal_peserta_tender').on('show.bs.modal', function() {
            $("#peserta-tender").select2({
                dropdownParent: $("#kt_modal_peserta_tender")
            });
        });
    </script>
    <script>
        let proyekStage = Number("{{ $proyek->stage }}");
        if (proyekStage == 6 || proyekStage == 7) {
            // const tabContent = document.querySelector(`.nav li:nth-child(${proyekStage}) a`);
            proyekStage = 6;
        } else if (proyekStage == 8 || proyekStage == 9) {
            proyekStage = 7;
        }
        const tabContent = document.querySelector(`.nav li:nth-child(${proyekStage}) a`);
        const tabBoots = new bootstrap.Tab(tabContent, {});
        tabBoots.show();
    </script>

    {{-- Begin :: Change periode --}}
    {{-- /proyek/view/{kode_proyek}/{periodePrognosa} --}}
    <script>
        const kodeProyek = "{{$proyek->kode_proyek}}";
        function periodePrognosa(e) {
            const periode = e.value;
            window.location.href = `/proyek/view/${kodeProyek}/${periode}`;
            return;
        }
    </script>
    {{-- End :: Change periode --}}
    
    {{-- Begin :: JO Detail Modal Pop Up --}}
    <script>
        const modalJODetail = new bootstrap.Modal("#kt_modal_jo_detail", {});
        function tampilJOCategory(e) {
            const valueJO = e.value;
            if(valueJO == "J") {
                modalJODetail.show();
            }
        }
    </script>
    {{-- End :: JO Detail Modal Pop Up --}}

    {{-- Begin :: JO Detail Save --}}
    <script>
        function changeValueJODetail(e) {
            const selectJOElt = e.parentElement.parentElement.querySelector("select");
            const valueJODetail = {value: selectJOElt.value, text: selectJOElt.options[selectJOElt.selectedIndex].text};
            const inputJODetail = document.querySelector("#jo-category");
            const textJODetail = inputJODetail.parentElement.querySelector("small");
            inputJODetail.value = valueJODetail.value;
            textJODetail.innerHTML = `JO Category: <b>${valueJODetail.text}</b>`;
            modalJODetail.hide();
        }
    </script>
    {{-- End :: JO Detail Save --}}

    {{-- Begin :: Disabled Input Function --}}
    <script>
        const isPeriodeExistInHistory = JSON.parse(`{{ $listPeriodeExistInHistory->toJson() }}`);
        isPeriodeExistInHistory.forEach(periode => disabledPeriodeInputs(periode)); 
        function disabledPeriodeInputs(periode) {
            const tab = document.querySelector(`a.nav-link[href="#kt_user_view_forecasts_${periode}_2023"]`);
            if(tab) {
                const inputs = document.querySelectorAll(`#kt_user_view_forecasts_${periode}_2023 input`);
                const buttons = document.querySelectorAll(`#kt_user_view_forecasts_${periode}_2023 button`);
                if(inputs.length > 0) {
                    inputs.forEach(input => {
                        input.setAttribute("disabled", "");
                        const tooltip = new bootstrap.Tooltip(input);
                        tooltip.show();
                    });
                }
                if(buttons.length > 0) {
                    buttons.forEach(button => button.style.display = "none");
                }
                tab.addEventListener('show.bs.tab', event => {
                    
                });
            }
        }
    </script>
    {{-- End :: Disabled Input Function --}}
@endsection
