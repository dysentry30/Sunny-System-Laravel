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
                <form action={{ url('/proyek/update/') }} method="post" enctype="multipart/form-data">
                    @csrf


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
                                        class="d-flex align-items-center fs-1 my-1 fw-bolder {{ $proyek->stage == 0 ? 'text-danger' : '' }}">
                                        @if ($proyek->stage == 0)
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
                                    <button type="button" class="btn btn-sm btn-light btn-active-danger ms-2"
                                        onclick="document.location.reload()" style="display: none;" id="cancel-button">
                                        Cancel <i class="bi bi-x"></i></button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-sm btn-primary ms-2" id="proyek-save"
                                        style="background-color:#008CB4">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <a class="btn btn-sm btn-light btn-active-danger ms-2" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_cancel_proyek" id="kt_toolbar_export">Cancel Proyek
                                    </a>
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
                                                        {{-- @if ($proyek->tipe_proyek != 'R') --}}
                                                        @if ($proyek->stage > 1)
                                                            <a href="#"
                                                                class="stage-button stage-action color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="2">
                                                                Pasar Potensial
                                                            </a>
                                                        @else
                                                            @if ($proyek->stage == 0)
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-not-active"
                                                                    style="outline: 0px; pointer-events: none"
                                                                    stage="2">
                                                                    Pasar Potensial
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action color-is-default stage-is-not-active"
                                                                    style="outline: 0px; cursor: pointer;" stage="2">
                                                                    Pasar Potensial
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if ($proyek->stage > 2)
                                                            <a href="#"
                                                                class="stage-button stage-action stage-is-done color-is-default"
                                                                style="outline: 0px; cursor: pointer;" stage="3">
                                                                Prakualifikasi
                                                            </a>
                                                        @else
                                                            @if (abs($proyek->stage - 3) != 1)
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer; pointer-events: none;"
                                                                    stage="3">
                                                                    Prakualifikasi
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="3">
                                                                    Prakualifikasi
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if ($proyek->stage > 3)
                                                            <a href="#"
                                                                class="stage-button stage-action stage-is-done color-is-default"
                                                                style="outline: 0px; cursor: pointer;" stage="4">
                                                                Tender Diikuti
                                                            </a>
                                                        @else
                                                            @if (abs($proyek->stage - 4) != 1)
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer; pointer-events: none;"
                                                                    stage="4">
                                                                    Tender Diikuti
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="4">
                                                                    Tender Diikuti
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if ($proyek->stage > 4)
                                                            <a href="#"
                                                                class="stage-button stage-action stage-is-done color-is-default"
                                                                style="outline: 0px; cursor: pointer;" stage="5">
                                                                Perolehan
                                                            </a>
                                                        @else
                                                            @if (abs($proyek->stage - 5) != 1)
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer; pointer-events: none;"
                                                                    stage="5">
                                                                    Perolehan
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="5">
                                                                    Perolehan
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if ($proyek->stage > 5)
                                                            @if ($proyek->stage == 6 || $proyek->stage > 7)
                                                                <a href="#"
                                                                    class="stage-button stage-is-done color-is-default"
                                                                    data-bs-toggle="dropdown" role="button"
                                                                    id="dropdownMenuButton1" aria-expanded="false"
                                                                    style="outline: 0px; cursor: pointer;" stage="1">
                                                                    <div class="d-flex flex-row">
                                                                        <span class="text-white">Menang</span>&nbsp;&nbsp;
                                                                        <span class=""
                                                                            style="position: relative;top: 15%;"
                                                                            stage="1"><i
                                                                                class="bi bi-caret-down-fill text-white"></i></span>
                                                                    </div>
                                                                </a>
                                                            @elseif($proyek->stage == 7)
                                                                <a href="#"
                                                                    class="stage-button stage-is-done color-is-danger"
                                                                    data-bs-toggle="dropdown" role="button"
                                                                    id="dropdownMenuButton1" aria-expanded="false"
                                                                    style="outline: 0px; cursor: pointer;" stage="1">
                                                                    <div class="d-flex flex-row">
                                                                        <span class="text-white">Kalah</span>&nbsp;&nbsp;
                                                                        <span class=""
                                                                            style="position: relative;top: 15%;"
                                                                            stage="1"><i
                                                                                class="bi bi-caret-down-fill text-white"></i></span>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton1">
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
                                                                            class="dropdown-item" name="stage-menang"
                                                                            value="Menang" /></li>
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-kalah"
                                                                            value="Kalah" /></li>
                                                                </form>
                                                            </ul>
                                                        @else
                                                            @if (abs($proyek->stage - 6) != 1 || abs($proyek->stage - 7) != 2)
                                                                <a href="#"
                                                                    class="stage-button stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer; pointer-events: none;"
                                                                    stage="8">
                                                                    Menang
                                                                    &nbsp;&nbsp;
                                                                    <span class=""
                                                                        style="position: relative;top: 15%;"
                                                                        stage="8"><i
                                                                            class="bi bi-caret-down-fill text-white"></i></span>
                                                                </a>
                                                            @else
                                                                {{-- <div class=""> --}}
                                                                <a href="#" data-bs-toggle="dropdown"
                                                                    role="button" id="dropdownMenuButton1"
                                                                    aria-expanded="false"
                                                                    class="stage-button stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="8">
                                                                    Menang
                                                                    &nbsp;&nbsp;
                                                                    <span class=""
                                                                        style="position: relative;top: 15%;"
                                                                        stage="8"><i
                                                                            class="bi bi-caret-down-fill text-white"></i></span>
                                                                </a>

                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <form action="/proyek/stage-save" method="POST">
                                                                    </form>
                                                                    <form action="/proyek/stage-save" method="POST"
                                                                        onsubmit="confirmAction(this); return false;"
                                                                        stage="8">
                                                                        @csrf
                                                                        <input type="hidden" name="kode_proyek"
                                                                            value="{{ $proyek->kode_proyek }}">
                                                                        <li><input type="submit"
                                                                                onclick="this.form.submitted=this.value"
                                                                                class="dropdown-item" name="stage-menang"
                                                                                value="Menang" />
                                                                        </li>
                                                                        <li><input type="submit"
                                                                                onclick="this.form.submitted=this.value"
                                                                                class="dropdown-item" name="stage-kalah"
                                                                                value="Kalah" />
                                                                        </li>
                                                                    </form>
                                                                </ul>
                                                                {{-- </div> --}}
                                                            @endif
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton1">
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
                                                                            class="dropdown-item" name="stage-menang"
                                                                            value="Menang" /></li>
                                                                    <li><input type="submit"
                                                                            onclick="this.form.submitted=this.value"
                                                                            class="dropdown-item" name="stage-kalah"
                                                                            value="Kalah" /></li>
                                                                </form>
                                                            </ul>
                                                        @endif
                                                        {{-- @endif --}}
                                                        @if ($proyek->stage > 7)
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
                                                        @endif



                                                        {{-- @if ($proyek->stage > 9)
                                                            <a href="#"
                                                                class="stage-button stage-action stage-is-done color-is-default"
                                                                style="outline: 0px; cursor: pointer;" stage="10">
                                                                Approval
                                                            </a>
                                                        @else
                                                            @if (abs($proyek->stage - 9) != 1)
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;pointer-events: none"
                                                                    stage="10">
                                                                    Approval
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    class="stage-button stage-action stage-is-not-active color-is-default"
                                                                    style="outline: 0px; cursor: pointer;" stage="10">
                                                                    Approval
                                                                </a>
                                                            @endif
                                                        @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        // const stages = document.querySelectorAll(".stage-button");
                                        // stages.forEach((stage, i) => {
                                        //     stage.setAttribute("stage", i + 1);
                                        //     if (i + 1 <= Number("{{ $proyek->stage }}")) {
                                        //         stage.classList.add("stage-is-done");
                                        //         stage.style.cursor = "cursor";
                                        //     } else {
                                        //         stage.classList.add("stage-is-not-active");
                                        //         stage.style.cursor = "cursor";
                                        //         if (i > Number("{{ $proyek->stage }}")) {
                                        //             stage.style.cursor = "not-allowed";
                                        //             stage.style.pointerEvents = "none";
                                        //         }
                                        //     }
                                        // });
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
<!--end::       -->


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
                                                            <a class="nav-link text-active-primary pb-4 active"
                                                                data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_pasardini"
                                                                style="font-size:14px;">Pasar Dini</a>
                                                        </li>
                                                        <!--end:::Tab item Pasar Dini-->
                                                    @endif

                                                    @if ($proyek->stage > 1)
                                                        <!--begin:::Tab item Pasar Potensial-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_potensial"
                                                                style="font-size:14px;">Pasar Potensial</a>
                                                        </li>
                                                        <!--end:::Tab item Pasar Potensial-->
                                                    @endif

                                                    @if ($proyek->stage > 2)
                                                        <!--begin:::Tab item Prakualifikasi-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_prakualifikasi"
                                                                style="font-size:14px;">Prakualifikasi</a>
                                                        </li>
                                                        <!--end:::Tab item Prakualifikasi-->
                                                    @endif

                                                    @if ($proyek->stage > 3)
                                                        <!--begin:::Tab item Tender Diikuti-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_tender"
                                                                style="font-size:14px;">Tender Diikuti</a>
                                                        </li>
                                                        <!--end:::Tab item Tender Diikuti-->
                                                    @endif

                                                    @if ($proyek->stage > 4)
                                                        <!--begin:::Tab item Perolehan-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_perolehan"
                                                                style="font-size:14px;">Perolehan</a>
                                                        </li>
                                                        <!--end:::Tab item Perolehan-->
                                                    @endif

                                                    @if ($proyek->stage > 5)
                                                        <!--begin:::Tab item Menang-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_menang"
                                                                style="font-size:14px;">{{ $proyek->stage == 7 ? 'Kalah' : 'Menang' }}</a>
                                                        </li>
                                                        <!--end:::Tab item Menang-->
                                                    @endif
                                                    @if ($proyek->stage > 7)
                                                        <!--begin:::Tab item Terkontrak-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_terkontrak"
                                                                style="font-size:14px;">{{ $proyek->stage == 9 ? 'Terendah' : 'Terkontrak' }}</a>
                                                        </li>
                                                        <!--end:::Tab item Terkontrak-->
                                                    @endif


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
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_forecast"
                                                                style="font-size:14px;">Forecast</a>
                                                        </li>
                                                </ul>
<!--end:::Tabs Navigas  i-->

                                                <!--begin:::Tab isi content  -->
                                                <div class="tab-content" id="myTabContent">

                                                    <!--begin:::Tab Pasar Dini-->
                                                    <div class="tab-pane fade show active"
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
                                                                        class="form-control form-control-solid"
                                                                        id="nama-proyek" name="nama-proyek"
                                                                        value="{{ $proyek->nama_proyek }}" />
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
                                                                        <option value="P"
                                                                            {{ $proyek->tipe_proyek == 'P' ? 'selected' : '' }}>
                                                                            Non-Retail</option>
                                                                    </select>
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="tipe-proyek" name="tipe-proyek"
                                                                        value="{{ $proyek->tipe_proyek == 'R' ? 'Retail' : 'Non-Retail' }}"
                                                                        readonly /> --}}
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
                                                                    {{-- @isset($proyek->jenis_proyek) --}}
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
                                                                    {{-- @endisset --}}
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="jenis-proyek" name="jenis-proyek"
                                                                        value="{{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}"
                                                                        readonly /> --}}
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
                                                            <!--End begin::Col-->
                                                            <div class="col-6">
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
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
                                                                        placeholder="Nilai OK (Excludde Ppn)" />
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
                                                                            value="{{ number_format((int) str_replace('.', '', $proyek->nilai_valas_review), 0, '.', '.') }}"
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
                                                                            value="{{ number_format((int) str_replace('.', '', $proyek->nilaiok_review), 0, '.', '.') }}"
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
                                                                    // console.log(hasilOkReview);
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
                                                        <div id="divRkapAwal" style="display:none">
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
                                                                            value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
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
                                                                            value="{{ $proyek->nilaiok_awal == null ? number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') : number_format((int) str_replace('.', '', $proyek->nilaiok_awal), 0, '.', '.') }}"
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


                                                    <!--begin:::Tab Pasar Potensial-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_potensial"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Negara</span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="negara" name="negara"
                                                                        value="{{ $proyek->negara }}"
                                                                        placeholder="Negara" /> --}}
                                                                    <select name="negara" id="negara"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Pilih Negara">
                                                                        <option value=""></option>
                                                                        @foreach ($data_negara as $negara)
                                                                            @if ($negara->country == $proyek->negara)
                                                                                <option value="{{ $negara->country }}"
                                                                                    selected>{{ $negara->country }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $negara->country }}">
                                                                                    {{ $negara->country }}</option>
                                                                            @endif
                                                                        @endforeach
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
                                                                        <span>SBU</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select onchange="getSBU(this)" id="sbu"
                                                                        name="sbu"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Pilih SBU">
                                                                        <option></option>
                                                                        @foreach ($sbus as $sbu)
                                                                            @if ($sbu->lingkup_kerja == $proyek->sbu)
                                                                                <option value="{{ $sbu->lingkup_kerja }}"
                                                                                    data-klasifikasi="{{ $sbu->klasifikasi }}"
                                                                                    data-sub="{{ $sbu->sub_klasifikasi }}"
                                                                                    selected>{{ $sbu->lingkup_kerja }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $sbu->lingkup_kerja }}"
                                                                                    data-klasifikasi="{{ $sbu->klasifikasi }}"
                                                                                    data-sub="{{ $sbu->sub_klasifikasi }}">
                                                                                    {{ $sbu->lingkup_kerja }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <!--end::Input-->
                                                                    <script>
                                                                        function getSBU(e) {
                                                                            // console.log(e);
                                                                            let klasifikasi = "";
                                                                            let subKlasifikasi = "";
                                                                            e.options.forEach(option => {
                                                                                if (option.selected) {
                                                                                    // console.log(option);
                                                                                    klasifikasi = option.getAttribute("data-klasifikasi");
                                                                                    subKlasifikasi = option.getAttribute("data-sub");
                                                                                }
                                                                                document.querySelector("#klasifikasi").value = klasifikasi;
                                                                                document.querySelector("#sub-klasifikasi").value = subKlasifikasi;
                                                                            })
                                                                        }
                                                                    </script>
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3 required">
                                                                        <span>Status Pasar <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    @php
                                                                        $jumlahBobot = 0;
                                                                        $statusPasar = '';
                                                                        foreach ($kriteriapasarproyek as $kriteria) {
                                                                            $jumlahBobot += $kriteria->bobot;
                                                                            $jumlahKriteria = count($kriteriapasarproyek);
                                                                            $statusPasar = round($jumlahBobot / $jumlahKriteria, 2);
                                                                        }
                                                                        if ($statusPasar == '') {
                                                                            $statusPasar = '*Kriteria Pasar Belum Diisi';
                                                                        } elseif ($statusPasar >= 0.75) {
                                                                            $statusPasar = 'Potensial';
                                                                        } else {
                                                                            $statusPasar = 'Non-Potensial';
                                                                        }
                                                                    @endphp
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $statusPasar == '*Kriteria Pasar Belum Diisi' ? 'text-danger' : '' }}"
                                                                        id="status-pasar" name="status-pasar"
                                                                        value="{{ $statusPasar }}" readonly />
                                                                    <!--end::Input-->
                                                                    <!--begin::Label-->
                                                                    {{-- <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Provinsi</span>
                                                                    </label> --}}
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="provinsi" name="provinsi"
                                                                        value="{{ $proyek->provinsi }}"
                                                                        placeholder="Provinsi" /> --}}
                                                                    {{-- <select name="provinsi" id="provinsi" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false" 
                                                                        data-placeholder="Pilih Provinsi">
                                                                        <option value=""></option>
                                                                        @foreach ($data_provinsi as $provinsi)
                                                                            @if ($provinsi->id == $proyek->provinsi)
                                                                                <option value="{{$provinsi->id}}" selected>{{ucwords(strtolower($provinsi->name))}}</option>
                                                                            @else
                                                                                <option value="{{$provinsi->id}}">{{ucwords(strtolower($provinsi->name))}}</option>
                                                                            @endif
                                                                        @endforeach
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
                                                                        <span>Klasifikasi <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="klasifikasi" name="klasifikasi"
                                                                        value="{{ $proyek->klasifikasi }}"
                                                                        placeholder="Klasifikasi" readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>DOP <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="dop" name="dop"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih DOP">
                                                                        <option selected>{{ $proyek->dop }}</option>
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
                                                                        <span>Sub-Klasifikasi <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="sub-klasifikasi" name="sub-klasifikasi"
                                                                        value="{{ $proyek->sub_klasifikasi }}"
                                                                        placeholder="Sub-Klasifikasi" readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Company <i class="bi bi-lock"></i>
                                                                        </span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="company" name="company"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Company">
                                                                        <option selected>{{ $proyek->company }}</option>
                                                                        {{-- @foreach ($companies as $company)
                                                                    @if ($company->nama_company == $proyek->company)
                                                                        <option value="{{ $company->nama_company }}" selected>{{$company->nama_company }}</option>
                                                                    @else
                                                                        <option value="{{ $company->nama_company }}">{{$company->nama_company }}</option>
                                                                    @endif
                                                                    @endforeach --}}
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                            {{-- <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Company <i class="bi bi-lock"></i>
                                                                        </span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="company" name="company"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Company">
                                                                        <option selected>{{ $proyek->company }}</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div> --}}
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->


                                                        <!--Begin::Title Biru Form: Kriteria pasar-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">
                                                            <!--begin::Options-->
                                                            <label
                                                                class="form-check form-check-custom form-check-solid me-6 m-0 align-middle">
                                                                <span class="me-4">Proyek Strategis : </span>
                                                                <input class="form-check-input" type="checkbox"
                                                                    style="border: 1px solid #b5b5c3" value=""
                                                                    id="proyek-strategis" name="proyek-strategis"
                                                                    {{ $proyek->proyek_strategis ? 'checked' : '' }} />&nbsp;
                                                                {{ $proyek->proyek_strategis ? ' Ya' : '' }}
                                                            </label>
                                                            <!--end::Options-->
                                                        </h3>
                                                        <br>

                                                        <!--Begin::Title Biru Form: Kriteria pasar-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Kriteria Pasar
                                                            @php
                                                                $style = '';
                                                                foreach ($kriteriapasarproyek as $kriteria) {
                                                                    if ($kriteria->count() > 0) {
                                                                        $style = 'none';
                                                                    }
                                                                }
                                                            @endphp
                                                            <a onclick="kategoriSelect()" href="#" Id="Plus"
                                                                style="display: {{ $style }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_kriteria_pasardini">+</a>
                                                        </h3>
                                                        <br>
                                                        <!--begin::Table Kriteria Pasar-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Kategori</th>
                                                                    <th class="w-auto">Kriteria</th>
                                                                    <th class="w-auto">Bobot</th>
                                                                    <th class="w-100px"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($kriteriapasarproyek as $kriteria)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Kategori-->
                                                                        <td>
                                                                            <a onclick="kategoriKlick(this)"
                                                                                data-value="{{ $kriteria->kategori }}"
                                                                                data-kriteria="edit-kriteria-pasar-{{ $kriteria->id }}"
                                                                                href="#"
                                                                                class="text-gray-800 text-hover-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_edit_kriteria_{{ $kriteria->id }}">{{ $kriteria->kategori }}</a>
                                                                        </td>
                                                                        <!--end::Kategori-->
                                                                        <!--begin::Kategori-->
                                                                        <td>
                                                                            {{ $kriteria->kriteria }}
                                                                        </td>
                                                                        <!--end::Kategori-->
                                                                        <!--begin::Kategori-->
                                                                        <td>
                                                                            {{ $kriteria->bobot }}
                                                                        </td>
                                                                        <!--end::Kategori-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_kriteria_delete_{{ $kriteria->id }}"
                                                                                    id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <!--begin::Kategori-->
                                                                    {{-- <td></td>
                                                                    <td></td> --}}
                                                                    <td colspan="3" class="text-end text-gray-400">
                                                                        Average Skor Pasar :</td>
                                                                    @php
                                                                        $jumlahBobot = 0;
                                                                        $statusPasar = '';
                                                                        foreach ($kriteriapasarproyek as $kriteria) {
                                                                            $jumlahBobot += $kriteria->bobot;
                                                                            $jumlahKriteria = count($kriteriapasarproyek);
                                                                            $statusPasar = round($jumlahBobot / $jumlahKriteria, 2);
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        {{ $statusPasar }}
                                                                    </td>
                                                                    <!--end::Kategori-->
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table Kriteria Pasar-->
                                                        <!--End::Title Biru Form: Kriteria pasar-->

                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        &nbsp;<br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-kualitatif-paspot" name="laporan-kualitatif-paspot" rows="7">{!! $proyek->laporan_kualitatif_paspot !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Pasar Potensial-->


                                                    <!--begin:::Tab Prakualifikasi-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_prakualifikasi"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Jadwal PQ</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        name="jadwal-pq"
                                                                        value="{{ $proyek->jadwal_pq }}"
                                                                        placeholder="Date" />
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
                                                                        <span class="required">HPS / Pagu (Rupiah)</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="hps-pagu" name="hps-pagu"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->hps_pagu), 0, '.', '.') }}"
                                                                        placeholder="HPS / Pagu (Rupiah)" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            {{-- <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Jadwal Proyek</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        name="jadwal-proyek"
                                                                        value="{{ $proyek->jadwal_proyek }}"
                                                                        placeholder="Date" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div> --}}
                                                            <!--End begin::Col-->
                                                            <div class="col-3">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Porsi JO (<i
                                                                                class="bi bi-percent text-dark"></i>) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="number" min="1" max="100"
                                                                        class="form-control form-control-solid"
                                                                        id="porsi-jo" name="porsi-jo"
                                                                        value="{{ $proyek->porsi_jo }}"
                                                                        placeholder="Porsi JO" readonly />
                                                                    {{-- @error('porsi-jo')
                                                                        <h6 class="text-danger fw-normal">{{ $message }}
                                                                        </h6>
                                                                    @enderror --}}
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-3">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                </label>
                                                                <p class="mt-12"><i class="bi bi-percent text-dark"></i>
                                                                </p>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->
                                                        <br>

                                                        @if ($proyek->jenis_proyek == 'J')
                                                            <!--Begin::Title Biru Form: Partner JO-->
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                                style="font-size:14px;">Partner JO
                                                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                    data-bs-target="#kt_modal_porsijo">+</a>
                                                            </h3>
                                                            <br>
                                                            <!--End::Title Biru Form: Partner JO-->

                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <!--begin::Table-->
                                                                        <table
                                                                            class="table align-middle table-row-dashed fs-6 gy-2"
                                                                            id="kt_customers_table">
                                                                            <!--begin::Table head-->
                                                                            <thead>
                                                                                <!--begin::Table row-->
                                                                                <tr
                                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                                    <th class="w-50px text-center">No.</th>
                                                                                    <th class="w-auto">Company</th>
                                                                                    <th class="w-auto">Porsi JO</th>
                                                                                    <th class="w-100px"></th>
                                                                                </tr>
                                                                                <!--end::Table row-->
                                                                            </thead>
                                                                            <!--end::Table head-->
                                                                            <!--begin::Table body-->
                                                                            @php
                                                                                $no = 1;
                                                                            @endphp
                                                                            @foreach ($porsiJO as $porsi)
                                                                                <tbody class="fw-bold text-gray-600">

                                                                                    <tr>
                                                                                        <!--begin::Name-->
                                                                                        <td class="text-center">
                                                                                            {{ $no++ }}
                                                                                        </td>
                                                                                        <!--end::Name-->
                                                                                        <!--begin::Column-->
                                                                                        <td>
                                                                                            <a href=#
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#kt_porsi_edit_{{ $porsi->id }}"
                                                                                                class="text-hover-primary">
                                                                                                {{ $porsi->company_jo }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <!--end::Column-->
                                                                                        <!--begin::Column-->
                                                                                        <td>
                                                                                            {{ $porsi->porsi_jo }}<i
                                                                                                class="bi bi-percent text-dark"></i>
                                                                                        </td>
                                                                                        <!--end::Column-->
                                                                                        <!--begin::Action-->
                                                                                        <td class="text-center">
                                                                                            <small>
                                                                                                <p data-bs-toggle="modal"
                                                                                                    data-bs-target="#kt_porsi_delete_{{ $porsi->id }}"
                                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                                    Delete
                                                                                                </p>
                                                                                            </small>
                                                                                        </td>
                                                                                        <!--end::Action-->
                                                                                </tbody>
                                                                            @endforeach
                                                                            <!--end::Table body-->
                                                                        </table>
                                                                        <!--end::Table-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                            </div>
                                                            <!--End begin::Row-->
                                                        @endif


                                                        <!--Begin::Title Biru Form: Document Prakualifikasi-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Document Prakualifikasi
                                                        </h3>
                                                        <br>
                                                        <div class="w-50">
                                                            <input type="file"
                                                                class="form-control form-control-sm form-input-solid"
                                                                name="dokumen-prakualifikasi" accept=".pdf">
                                                        </div>
                                                        <h6 id="error-dokumen-prakualifikasi"
                                                            class="text-danger fw-normal" style="display: none">*File
                                                            terlalu besar ! Max Size 50Mb</h6>
                                                        <br>
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed w-50 fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Nama Document</th>
                                                                    <th class="w-auto">Modified On</th>
                                                                    <th class="w-auto text-center"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($proyek->DokumenPrakualifikasi as $dokumen_prakualifikasi)
                                                                    <tr>
                                                                        <!--begin::Nomor-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Nomor-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            @if (str_contains("$dokumen_prakualifikasi->nama_dokumen", '.doc'))
                                                                                <a href="/document/view/{{ $dokumen_prakualifikasi->id_dokumen_prakualifikasi }}/{{ $dokumen_prakualifikasi->id_document }}"
                                                                                    class="text-hover-primary">{{ $dokumen_prakualifikasi->nama_dokumen }}</a>
                                                                            @else
                                                                                <a target="_blank"
                                                                                    href="{{ asset('words/' . $dokumen_prakualifikasi->id_document . '.pdf') }}"
                                                                                    class="text-hover-primary">{{ $dokumen_prakualifikasi->nama_dokumen }}</a>
                                                                            @endif
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ Carbon\Carbon::parse($dokumen_prakualifikasi->created_at)->translatedFormat('d F Y') }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_dokumen_prakualifikasi_delete_{{ $dokumen_prakualifikasi->id_dokumen_prakualifikasi }}"
                                                                                    id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>

                                                        <!--end::Table-->
                                                        <!--End::Title Biru Form: Document Prakualifikasi-->

                                                        <br>

                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Ketua Team Tender
                                                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_porsijo">+</a> --}}
                                                        </h3>
                                                        <br>
                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    {{-- <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Ketua Team Tender</span>
                                                                    </label> --}}
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select onchange="this.form.submit()"
                                                                        id="ketua-tender" name="ketua-tender"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false"
                                                                        data-placeholder="Ketua Team Tender">
                                                                        <option></option>
                                                                        @foreach ($users as $user)
                                                                            @if ($user->id == $proyek->ketua_tender)
                                                                                <option value="{{ $user->id }}"
                                                                                    selected>{{ $user->name }}</option>
                                                                            @endif
                                                                            <option value="{{ $user->id }}">
                                                                                {{ $user->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                        </div>
                                                        <!--End begin::Row-->


                                                        <!--Begin::Title Biru Form: SKT Personil-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">SKT Personil
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_add_user">+</a>
                                                        </h3>

                                                        <br>

                                                        <!--End::Title Biru Form: SKT Personil-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <!--begin::Table-->
                                                                    <table
                                                                        class="table align-middle table-row-dashed fs-6 gy-2"
                                                                        id="kt_customers_table">
                                                                        <!--begin::Table head-->
                                                                        <thead>
                                                                            <!--begin::Table row-->
                                                                            <tr
                                                                                class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                                <th class="w-50px text-center">No.</th>
                                                                                <th class="w-auto">Nama</th>
                                                                                <th class="w-auto">Bidang Sertifikasi</th>
                                                                                <th class="w-100px"></th>
                                                                            </tr>
                                                                            <!--end::Table row-->
                                                                        </thead>
                                                                        <!--end::Table head-->
                                                                        <!--begin::Table body-->
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($teams as $team)
                                                                            <tbody class="fw-bold text-gray-600">

                                                                                <tr>
                                                                                    <!--begin::Nomor-->
                                                                                    <td class="text-center">
                                                                                        {{ $no++ }}
                                                                                    </td>
                                                                                    <!--end::Nomor-->
                                                                                    <!--begin::Column-->
                                                                                    <td>
                                                                                        {{ $team->User->name }}
                                                                                    </td>
                                                                                    <!--end::Column-->
                                                                                    <!--begin::Column-->
                                                                                    <td>
                                                                                        {{ $team->role }}
                                                                                    </td>
                                                                                    <!--end::Column-->
                                                                                    <!--begin::Action-->
                                                                                    <td class="text-center">
                                                                                        <small>
                                                                                            <p data-bs-toggle="modal"
                                                                                                data-bs-target="#kt_team_delete_{{ $team->id }}"
                                                                                                id="modal-delete"
                                                                                                class="btn btn-sm btn-light btn-active-primary">
                                                                                                Delete
                                                                                            </p>
                                                                                        </small>
                                                                                    </td>
                                                                                    <!--end::Action-->
                                                                            </tbody>
                                                                        @endforeach
                                                                        <!--end::Table body-->
                                                                    </table>
                                                                    <!--end::Table-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <br>

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-prakualifikasi" name="laporan-prakualifikasi" rows="7">{!! $proyek->laporan_prakualifikasi !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Prakualifikasi-->



                                                    <!--begin:::Tab Tender Diikuti-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_tender"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Jadwal Pemasukan Tender</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="jadwal-tender" name="jadwal-tender"
                                                                        value="{{ $proyek->jadwal_tender }}"
                                                                        placeholder="Date" />
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
                                                                        <span>Lokasi Tender</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="lokasi-tender" name="lokasi-tender"
                                                                        value="{{ $proyek->lokasi_tender }}"
                                                                        placeholder="Lokasi Tender" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Nilai Penawaran
                                                                            Keseluruhan</span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="nilai-kontrak-penawaran"
                                                                        name="nilai-kontrak-penawaran"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->penawaran_tender), 0, '.', '.') }}"
                                                                        placeholder="Nilai Penawaran Keseluruhan" />
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
                                                                        <span>HPS / Pagu (Rupiah) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->hps_pagu == null ? 'text-danger' : '' }}"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->hps_pagu), 0, '.', '.') ?? '*HPS/Pagu Belum Ditentukan' }}"
                                                                        placeholder="HPS / Pagu (Rupiah)" readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--Begin::Title Biru Form: List Peserta Tender-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Kompetitor
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_peserta_tender">+</a>
                                                        </h3>
                                                        <!--End::Title Biru Form: List Peserta Tender-->
                                                        <br>
                                                        <!--begin::Col-->
                                                        <div class="col-6">
                                                            <!--begin::Table Kompetitor-->
                                                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                                id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                        <th class="w-50px text-center">No.</th>
                                                                        <th class="w-auto">Nama Peserta Tender</th>
                                                                        {{-- <th class="w-auto">Nilai Penawaran</th> --}}
                                                                        {{-- <th class="w-auto"><i class="bi bi-percent"></i>OE</th> --}}
                                                                        {{-- <th class="w-auto">Status</th> --}}
                                                                        <th class="w-100px"></th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                @php
                                                                    $no = 1;
                                                                @endphp
                                                                <tbody class="fw-bold text-gray-600">
                                                                    @foreach ($pesertatender as $peserta)
                                                                        <tr>
                                                                            <!--begin::Name-->
                                                                            <td class="text-center">
                                                                                {{ $no++ }}
                                                                            </td>
                                                                            <!--end::Name-->
                                                                            <!--begin::Column-->
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="text-gray-800 text-hover-primary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_modal_edit_tender_{{ $peserta->id }}">{{ $peserta->peserta_tender }}</a>
                                                                            </td>
                                                                            <!--end::Column-->
                                                                            <!--begin::Column-->
                                                                            {{-- <td>
                                                                                {{ $peserta->nilai_tender_peserta ?? "-" }}
                                                                            </td> --}}
                                                                            <!--end::Column-->
                                                                            <!--begin::Column-->
                                                                            {{-- <td>
                                                                                {{ $peserta->oe_tender ?? "-" }}
                                                                            </td> --}}
                                                                            <!--end::Column-->
                                                                            <!--begin::Column-->
                                                                            {{-- <td>
                                                                                {{ $peserta->status ?? "-" }}
                                                                            </td> --}}
                                                                            <!--end::Column-->
                                                                            <!--begin::Action-->
                                                                            <td class="text-center">
                                                                                <small>
                                                                                    <p data-bs-toggle="modal"
                                                                                        data-bs-target="#kt_tender_delete_{{ $peserta->id }}"
                                                                                        id="modal-delete"
                                                                                        class="btn btn-sm btn-light btn-active-primary">
                                                                                        Delete
                                                                                    </p>
                                                                                </small>
                                                                            </td>
                                                                            <!--end::Action-->
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--begin::Table Kompetitor-->
                                                        </div>
                                                        <!--End::Col-->

                                                        <br>

                                                        <!--Begin::Title Biru Form: Risk Peserta Tender-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Risk Peserta Tender
                                                        </h3>
                                                        <br>
                                                        <div class="w-50">
                                                            <input onchange="this.form.submit()" type="file"
                                                                class="form-control form-control-sm form-input-solid"
                                                                name="risk-tender" accept=".pdf">
                                                        </div>
                                                        <h6 id="error-risk-tender" class="text-danger fw-normal"
                                                            style="display: none">*File terlalu besar ! Max Size 50Mb</h6>
                                                        <br>
                                                        <!--begin::Table Kriteria Pasar-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Nama Documnet</th>
                                                                    <th class="w-auto">Modified On</th>
                                                                    <th class="w-auto">Upload By</th>
                                                                    <th class="w-100px"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($proyek->RiskTenderProyek as $riskTender)
                                                                    <tr>
                                                                        <!--begin::Nomor-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Nomor-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            @if (str_contains("$riskTender->nama_risk_tender", '.doc'))
                                                                                <a href="/document/view/{{ $riskTender->id }}/{{ $riskTender->id_document }}"
                                                                                    class="text-hover-primary">{{ $riskTender->nama_risk_tender }}</a>
                                                                            @else
                                                                                <a target="_blank"
                                                                                    href="{{ asset('words/' . $riskTender->id_document . '.pdf') }}"
                                                                                    class="text-hover-primary">{{ $riskTender->nama_risk_tender }}</a>
                                                                            @endif
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Modified On-->
                                                                        <td>
                                                                            {{ $riskTender->created_at ?? '-' }}
                                                                        </td>
                                                                        <!--end::Modified On-->
                                                                        <!--begin::Modified By-->
                                                                        <td>
                                                                            {{ $riskTender->created_by ?? '-' }}
                                                                        </td>
                                                                        <!--end::Modified By-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_risk_tender_delete_{{ $riskTender->id }}"
                                                                                    id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--End::Title Biru Form: Risk Peserta Tender-->

                                                        <br>
                                                        <br>

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        &nbsp;<br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-tender" name="laporan-tender" rows="7">{!! $proyek->laporan_tender !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Tender Diikuti-->


                                                    <!--begin:::Tab Perolehan-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_perolehan"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            {{-- <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Total Biaya Pra-Proyek</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="biaya-praproyek" name="biaya-praproyek"
                                                                        value="{{ $proyek->biaya_praproyek }}"
                                                                        placeholder="Total Biaya Pra-Proyek" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div> --}}
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>HPS / Pagu (Rupiah) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->hps_pagu == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->hps_pagu ?? '*HPS/Pagu Belum Ditentukan' }}"
                                                                        placeholder="HPS / Pagu (Rupiah)" readonly />
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
                                                                        <span>Nilai Penawaran Keseluruhan <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $proyek->penawaran_tender == null ? 'text-danger' : '' }}"
                                                                        id="penawaran-perolehan"
                                                                        name="penawaran-perolehan"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->penawaran_tender), 0, '.', '.') ?? '*Nilai Penawaran Keseluruhan Belum Ditentukan' }}"
                                                                        placeholder="Nilai Penawaran Keseluruhan"
                                                                        readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span class="required">Nilai Perolehan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="nilai-perolehan" name="nilai-perolehan"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_perolehan), 0, '.', '.') }}"
                                                                        placeholder="Nilai Perolehan" />
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
                                                                        <span>Peringkat Wika</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="peringkat-wika" name="peringkat-wika"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Peringkat">
                                                                        <option></option>
                                                                        <option value="Peringkat 1"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 1' ? 'selected' : '' }}>
                                                                            Peringkat 1</option>
                                                                        <option value="Peringkat 2"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 2' ? 'selected' : '' }}>
                                                                            Peringkat 2</option>
                                                                        <option value="Peringkat 3"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 3' ? 'selected' : '' }}>
                                                                            Peringkat 3</option>
                                                                        <option value="Peringkat 4"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 4' ? 'selected' : '' }}>
                                                                            Peringkat 4</option>
                                                                        <option value="Peringkat 5"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 5' ? 'selected' : '' }}>
                                                                            Peringkat 5</option>
                                                                        <option value="Peringkat 6"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 6' ? 'selected' : '' }}>
                                                                            Peringkat 6</option>
                                                                        <option value="Peringkat 7"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 7' ? 'selected' : '' }}>
                                                                            Peringkat 7</option>
                                                                        <option value="Peringkat 8"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 8' ? 'selected' : '' }}>
                                                                            Peringkat 8</option>
                                                                        <option value="Peringkat 9"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 9' ? 'selected' : '' }}>
                                                                            Peringkat 9</option>
                                                                        <option value="Peringkat 10"
                                                                            {{ $proyek->peringkat_wika == 'Peringkat 10' ? 'selected' : '' }}>
                                                                            Peringkat 10</option>
                                                                        <option value="Gugur"
                                                                            {{ $proyek->peringkat_wika == 'Gugur' ? 'selected' : '' }}>
                                                                            Gugur</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-3">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span><i class="bi bi-percent text-dark"></i> OE
                                                                            Wika <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="oe-wika" name="oe-wika"
                                                                        value="{{ $proyek->oe_wika }}"
                                                                        placeholder="OE Wika" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-3">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                </label>
                                                                <p class="mt-12"><i
                                                                        class="bi bi-percent text-dark"></i>
                                                                </p>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <br>

                                                        <!--Begin::Title Biru Form: List Peserta Tender-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">List Peserta Tender
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_peserta_tender">+</a>
                                                        </h3>
                                                        <br>
                                                        <!--begin::Table Kriteria Pasar-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Nama Peserta Tender</th>
                                                                    <th class="w-auto">Nilai Penawaran</th>
                                                                    <th class="w-auto"><i class="bi bi-percent"></i>OE
                                                                    </th>
                                                                    <th class="w-auto">Status</th>
                                                                    <th class="w-100px"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($pesertatender as $peserta)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-gray-800 text-hover-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_edit_tender_{{ $peserta->id }}">{{ $peserta->peserta_tender }}</a>
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $peserta->nilai_tender_peserta ?? '-' }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $peserta->oe_tender ?? '-' }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $peserta->status ?? '-' }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_tender_delete_{{ $peserta->id }}"
                                                                                    id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--End::Title Biru Form: List Peserta Tender-->

                                                        <br>

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-perolehan" name="laporan-perolehan" rows="7">{!! $proyek->laporan_perolehan !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Perolehan-->


                                                    <!--begin:::Tab Menang-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_menang"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: Analisa Sebab Kemenangan-->
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Analisa Sebab
                                                            {{ $proyek->stage == 7 ? 'Kekalahan' : 'Kemenangan' }} &nbsp;
                                                            <i onclick="hideMenang()" id="hide-menang"
                                                                class="bi bi-arrows-collapse"></i><i
                                                                onclick="showMenang()" id="show-menang"
                                                                style="display: none" class="bi bi-arrows-expand"></i>
                                                        </h3>
                                                        <script>
                                                            function hideMenang() {
                                                                document.getElementById("divMenang").style.display = "none";
                                                                document.getElementById("hide-menang").style.display = "none";
                                                                document.getElementById("show-menang").style.display = "";
                                                            }

                                                            function showMenang() {
                                                                document.getElementById("divMenang").style.display = "";
                                                                document.getElementById("hide-menang").style.display = "";
                                                                document.getElementById("show-menang").style.display = "none";
                                                            }
                                                        </script>
                                                        <!--End::Title Biru Form: Analisa Sebab Kemenangan-->

                                                        <br>

                                                        <div id="divMenang">
                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Aspek Pesaing</span>
                                                                        </label>
                                                                        <!--end::Label-->

                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control" id="aspek-pesaing" name="aspek-pesaing" rows="3">{{ $proyek->aspek_pesaing }}</textarea>
                                                                        {{-- <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="aspek-pesaing" name="aspek-pesaing"
                                                                            value="{{ $proyek->aspek_pesaing }}"
                                                                            placeholder="Aspek Pesaing" /> --}}
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
                                                                            <span>Aspek Non Pesaing</span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control" id="aspek-non-pesaing" name="aspek-non-pesaing" rows="3">{{ $proyek->aspek_non_pesaing }}</textarea>
                                                                        {{-- <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="aspek-non-pesaing" name="aspek-non-pesaing"
                                                                            value="{{ $proyek->aspek_non_pesaing }}"
                                                                            placeholder="Aspek Non Pesaing" /> --}}
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->

                                                            <!--begin::Row-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Usulan Saran Perbaikan</span>
                                                                        </label>
                                                                        <!--end::Label-->

                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control" id="saran-perbaikan" name="saran-perbaikan" rows="3">{{ $proyek->saran_perbaikan }}</textarea>
                                                                        {{-- <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="saran-perbaikan" name="saran-perbaikan"
                                                                            value="{{ $proyek->saran_perbaikan }}"
                                                                            placeholder="Saran Perbaikan" /> --}}
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End begin::Col-->
                                                            </div>
                                                            <!--End begin::Row-->
                                                        </div>
                                                        <!--divMenang-->

                                                        <!--Begin::Title Biru Form: Attachment Menang-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Dokumen SPPBJ / LOI / Penunjukan
                                                            Pemenangan
                                                        </h3>
                                                        <br>
                                                        <div class="w-50">
                                                            <input onchange="this.form.submit()" type="file"
                                                                class="form-control form-control-sm form-input-solid"
                                                                name="attachment-menang" accept=".pdf">
                                                        </div>
                                                        <h6 id="error-attachment-menang" class="text-danger fw-normal"
                                                            style="display: none">*File terlalu besar ! Max Size 50Mb</h6>
                                                        <br>
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed w-50 fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Nama Document</th>
                                                                    <th class="w-auto">Modified On</th>
                                                                    <th class="w-auto text-center"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($proyek->AttachmentMenang as $attachment)
                                                                    <tr>
                                                                        <!--begin::Nomor-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Nomor-->
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            @if (str_contains("$attachment->nama_attachment", '.doc'))
                                                                                <a href="/document/view/{{ $attachment->id }}/{{ $attachment->id_document }}"
                                                                                    class="text-hover-primary">{{ $attachment->nama_attachment }}</a>
                                                                            @else
                                                                                <a target="_blank"
                                                                                    href="{{ asset('words/' . $attachment->id_document . '.pdf') }}"
                                                                                    class="text-hover-primary">{{ $attachment->nama_attachment }}</a>
                                                                            @endif
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ Carbon\Carbon::parse($attachment->created_at)->translatedFormat('d F Y') }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Action-->
                                                                        @if ($proyek->stage < 8)
                                                                            <td class="text-center">
                                                                                <small>
                                                                                    <p data-bs-toggle="modal"
                                                                                        data-bs-target="#kt_attachment_delete_{{ $attachment->id }}"
                                                                                        id="modal-delete"
                                                                                        class="btn btn-sm btn-light btn-active-primary">
                                                                                        Delete
                                                                                    </p>
                                                                                </small>
                                                                            </td>
                                                                        @endif
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>

                                                        <!--end::Table-->
                                                        <br>
                                                        <!--End::Title Biru Form: Attachment Menang-->

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-menang" name="laporan-menang" rows="7">{!! $proyek->laporan_menang !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Menang-->


                                                    <!--begin:::Tab Pasar Terkontrak New-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_terkontrak"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>No SPK External <i
                                                                                class="bi bi-journal-text"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="nospk-external" name="nospk-external"
                                                                        value="{{ $proyek->nospk_external }}"
                                                                        placeholder="No SPK External" />
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
                                                                        <span>Jenis Proyek <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        value="{{ $proyek->jenis_proyek == 'I' ? 'Internal' : ($proyek->jenis_proyek == 'N' ? 'External' : 'JO') }}"
                                                                        readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Tanggal SPK Internal</i></span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tglspk-internal" name="tglspk-internal"
                                                                        value="{{ $proyek->tglspk_internal }}"
                                                                        placeholder="Date" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                            <div class="col-3">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Porsi JO (<i
                                                                                class="bi bi-percent text-dark"></i>) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $proyek->porsi_jo == null ? 'text-danger' : '' }}"
                                                                        value="{{ (int) $proyek->porsi_jo ?? '*Porsi JO Belum Ditentukan' }}"
                                                                        placeholder="Porsi JO" readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <div class="col-3">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-bold form-label mt-3">
                                                                </label>
                                                                <p class="mt-12"><i
                                                                        class="bi bi-percent text-dark"></i></p>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Tahun RI Perolehan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        id="" name="tahun-ri-perolehan"
                                                                        min="2020" max="2099" step="1"
                                                                        value="{{ $proyek->tahun_ri_perolehan == (int) '0' ? '' : $proyek->tahun_ri_perolehan }}"
                                                                        placeholder="Tahun Ri Perolehan" />
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
                                                                        <span>Nilai OK Review (Valas) (Exclude Tax) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->nilai_valas_review == null ? 'text-danger' : '' }}"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_valas_review), 0, '.', '.') ?? '*Nilai OK Review Belum Ditentukan' }}"
                                                                        placeholder="Nilai OK Review (Valas) (Exclude Tax)"
                                                                        readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Bulan RI Perolehan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--Begin::Input-->
                                                                    <select id="bulan-ri-perolehan"
                                                                        name="bulan-ri-perolehan"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Bulan RI Perolehan">
                                                                        <option></option>
                                                                        <option value="1"
                                                                            {{ $proyek->bulan_ri_perolehan == '1' ? 'selected' : '' }}>
                                                                            Januari</option>
                                                                        <option value="2"
                                                                            {{ $proyek->bulan_ri_perolehan == '2' ? 'selected' : '' }}>
                                                                            Februari</option>
                                                                        <option value="3"
                                                                            {{ $proyek->bulan_ri_perolehan == '3' ? 'selected' : '' }}>
                                                                            Maret</option>
                                                                        <option value="4"
                                                                            {{ $proyek->bulan_ri_perolehan == '4' ? 'selected' : '' }}>
                                                                            April</option>
                                                                        <option value="5"
                                                                            {{ $proyek->bulan_ri_perolehan == '5' ? 'selected' : '' }}>
                                                                            Mei</option>
                                                                        <option value="6"
                                                                            {{ $proyek->bulan_ri_perolehan == '6' ? 'selected' : '' }}>
                                                                            Juni</option>
                                                                        <option value="7"
                                                                            {{ $proyek->bulan_ri_perolehan == '7' ? 'selected' : '' }}>
                                                                            Juli</option>
                                                                        <option value="8"
                                                                            {{ $proyek->bulan_ri_perolehan == '8' ? 'selected' : '' }}>
                                                                            Agustus</option>
                                                                        <option value="9"
                                                                            {{ $proyek->bulan_ri_perolehan == '9' ? 'selected' : '' }}>
                                                                            September</option>
                                                                        <option value="10"
                                                                            {{ $proyek->bulan_ri_perolehan == '10' ? 'selected' : '' }}>
                                                                            Oktober</option>
                                                                        <option value="11"
                                                                            {{ $proyek->bulan_ri_perolehan == '11' ? 'selected' : '' }}>
                                                                            November</option>
                                                                        <option value="12"
                                                                            {{ $proyek->bulan_ri_perolehan == '12' ? 'selected' : '' }}>
                                                                            Desember</option>
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
                                                                        <span>Mata Uang <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--Begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $proyek->mata_uang_review == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->mata_uang_review ?? '*Mata Uang Belum Ditentukan' }}"
                                                                        readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--begin::Row Kanan+Kiri-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>No Kontrak <i
                                                                                class="bi bi-journal-text"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div
                                                                        class="d-flex align-items-center position-relative">
                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                                        {{-- <span id="view-kontrak" class="svg-icon svg-icon-1 position-absolute ms-4">
                                                                            <a href="/contract-management/view/{{ $proyek->nomor_terkontrak }}" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->nomor_terkontrak }}</a>
                                                                        </span>
                                                                        <input onclick="viewKontrak(this)" type="text" id="fake-terkontrak"
                                                                            class="form-control form-control-solid"
                                                                            value="" readonly/> --}}
                                                                        <!--end::Svg Icon-->
                                                                        <input onfocusout="displayKontrak(this)"
                                                                            type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="nomor-terkontrak"
                                                                            name="nomor-terkontrak"
                                                                            value="{{ $proyek->nomor_terkontrak }}"
                                                                            placeholder="" onpaste="return false" />
                                                                    </div>
                                                                    <p style="display: none" id="char-error"
                                                                        class="text-danger fw-normal">*Not Allowed : / \ ?
                                                                        #;</p>
                                                                    <script>
                                                                        // document.getElementById("nomor-terkontrak").onkeypress = function(e) {
                                                                        //     var chr = String.fromCharCode(e.which);
                                                                        //     if (`/ \ ? #`.indexOf(chr) >= 0){
                                                                        //     // if (`!?"'#%&()*/@[\]^_{|}><~;`.indexOf(chr) >= 0){
                                                                        //         document.getElementById('char-error').style.display = "";
                                                                        //     // showError(chr)
                                                                        //     return false;
                                                                        //     }
                                                                        //     return true
                                                                        // };
                                                                        // function viewKontrak(e) {
                                                                        //     document.getElementById('fake-terkontrak').style.display = "none";
                                                                        //     document.getElementById('view-kontrak').style.display = "none";
                                                                        //     document.getElementById('nomor-terkontrak').style.display = "";
                                                                        //     // e.value = "{{ $proyek->nomor_terkontrak }}";
                                                                        // }
                                                                        // function displayKontrak(e) {
                                                                        //     document.getElementById('view-kontrak').style.display = "";
                                                                        //     document.getElementById('view-kontrak').innerHTML = e.value;
                                                                        //     document.getElementById('fake-terkontrak').style.display = "";
                                                                        //     document.getElementById('nomor-terkontrak').style.display = "none";
                                                                        //     // console.log(e);
                                                                        // }
                                                                    </script>
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
                                                                        <span>Kurs Review <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input onkeyup="hitungReview()" type="text"
                                                                        class="form-control form-control-solid {{ $proyek->kurs_review == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->kurs_review ?? '*Kurs Review Belum Ditentukan' }}"
                                                                        placeholder="Kurs Review" readonly />
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
                                                                        <span>Tanggal Kontrak</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tanggal-terkontrak"
                                                                        name="tanggal-terkontrak"
                                                                        value="{{ $proyek->tanggal_terkontrak }}"
                                                                        placeholder="Date" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                            @php
                                                                if ($proyek->nilai_perolehan != null && $proyek->porsi_jo != null) {
                                                                    $nilaiPerolehan = (int) str_replace('.', '', $proyek->nilai_perolehan);
                                                                    $kontrakKeseluruhan = ($nilaiPerolehan * 100) / (int) $proyek->porsi_jo;
                                                                    $nilaiKontrakKeseluruhan = number_format((int) str_replace('.', '', $kontrakKeseluruhan), 0, '.', '.');
                                                                } else {
                                                                    $nilaiKontrakKeseluruhan = 0;
                                                                }
                                                            @endphp
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Nilai Kontrak Keseluruhan<i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $nilaiKontrakKeseluruhan == 0 ? 'text-danger' : '' }}"
                                                                        value="{{ $nilaiKontrakKeseluruhan == 0 ? '' : $nilaiKontrakKeseluruhan }}"
                                                                        id="nilai-kontrak-keseluruhan"
                                                                        name="nilai-kontrak-keseluruhan"
                                                                        placeholder="*Nilai Perolehan Belum Ditentukan"
                                                                        readonly />
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
                                                                        <span>Tanggal Mulai Kontrak <i
                                                                                class="bi bi-journal-text"></i></span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tanggal-mulai-kontrak"
                                                                        name="tanggal-mulai-kontrak"
                                                                        value="{{ $proyek->tanggal_mulai_terkontrak }}"
                                                                        placeholder="Date" />
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
                                                                        <span>Nilai Kontrak (Porsi WIKA) <i
                                                                                class="bi bi-journal-text"></i> <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->nilai_perolehan == null ? 'text-danger' : '' }}"
                                                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_perolehan), 0, '.', '.') ?? '*Nilai Perolehan Belum Ditentukan' }}"
                                                                        placeholder="Nilai Kontrak (Porsi WIKA)"
                                                                        readonly />
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
                                                                        <span>Tanggal Akhir Kontrak <i
                                                                                class="bi bi-journal-text"></i></span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tanggal-akhir-kontrak"
                                                                        name="tanggal-akhir-kontrak"
                                                                        value="{{ $proyek->tanggal_akhir_terkontrak }}"
                                                                        placeholder="Date" />
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
                                                                        <span>Klasifikasi Proyek</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="klasifikasi-terkontrak"
                                                                        name="klasifikasi-terkontrak"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Klasifikasi Proyek">
                                                                        <option></option>
                                                                        <option value="Proyek Besar"
                                                                            {{ $proyek->klasifikasi_terkontrak == 'Proyek Besar' ? 'selected' : '' }}>
                                                                            Proyek Besar</option>
                                                                        <option value="Proyek Menengah"
                                                                            {{ $proyek->klasifikasi_terkontrak == 'Proyek Menengah' ? 'selected' : '' }}>
                                                                            Proyek Menengah</option>
                                                                        <option value="Proyek Kecil"
                                                                            {{ $proyek->klasifikasi_terkontrak == 'Proyek Kecil' ? 'selected' : '' }}>
                                                                            Proyek Kecil</option>
                                                                        <option value="Mega Proyek"
                                                                            {{ $proyek->klasifikasi_terkontrak == 'Mega Proyek' ? 'selected' : '' }}>
                                                                            Mega Proyek</option>
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
                                                                        <span>Tanggal Selesai Bash PHO</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tanggal-selesai-kontrak-pho"
                                                                        name="tanggal-selesai-kontrak-pho"
                                                                        value="{{ $proyek->tanggal_selesai_pho }}"
                                                                        placeholder="Date" />
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
                                                                        <span>Jenis Kontrak</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="jenis-terkontrak"
                                                                        name="jenis-terkontrak"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Jenis Kontrak">
                                                                        <option></option>
                                                                        <option value="Cost-Plus"
                                                                            {{ $proyek->jenis_terkontrak == 'Cost-Plus' ? 'selected' : '' }}>
                                                                            Cost-Plus</option>
                                                                        <option value="Design & Build"
                                                                            {{ $proyek->jenis_terkontrak == 'Design & Build' ? 'selected' : '' }}>
                                                                            Design & Build</option>
                                                                        <option value="Lumpsum"
                                                                            {{ $proyek->jenis_terkontrak == 'Lumpsum' ? 'selected' : '' }}>
                                                                            Lumpsum</option>
                                                                        <option value="OM"
                                                                            {{ $proyek->jenis_terkontrak == 'OM' ? 'selected' : '' }}>
                                                                            OM</option>
                                                                        <option value="Turnkey"
                                                                            {{ $proyek->jenis_terkontrak == 'Turnkey' ? 'selected' : '' }}>
                                                                            Turnkey</option>
                                                                        <option value="Unit Price"
                                                                            {{ $proyek->jenis_terkontrak == 'Unit Price' ? 'selected' : '' }}>
                                                                            Unit Price</option>
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
                                                                        <span>Tanggal Selesai Bash FHO</span>
                                                                    </label>
                                                                    <a href="#" class="btn"
                                                                        style="background: transparent;"
                                                                        id="start-date-modal"
                                                                        onclick="showCalendarModal(this)">
                                                                        <i class="bi bi-calendar2-plus-fill"
                                                                            style="color: #008CB4"></i>
                                                                    </a>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="Date"
                                                                        class="form-control form-control-solid"
                                                                        id="tanggal-selesai-kontrak-fho"
                                                                        name="tanggal-selesai-kontrak-fho"
                                                                        value="{{ $proyek->tanggal_selesai_fho }}"
                                                                        placeholder="Date" />
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
                                                                        <span>Sistem Pembayaran</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="sistem-bayar" name="sistem-bayar"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Sistem Pembayaran">
                                                                        <option></option>
                                                                        <option value="CPF (Turn Key)"
                                                                            {{ $proyek->sistem_bayar == 'CPF (Turn Key)' ? 'selected' : '' }}>
                                                                            CPF (Turn Key)</option>
                                                                        <option value="Milestone"
                                                                            {{ $proyek->sistem_bayar == 'Milestone' ? 'selected' : '' }}>
                                                                            Milestone</option>
                                                                        <option value="Monthly"
                                                                            {{ $proyek->sistem_bayar == 'Monthly' ? 'selected' : '' }}>
                                                                            Monthly</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                        <!--Begin::Title Biru Form: History Adendum-->
                                                        {{-- <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">History Adendum
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_history_adendum">+</a>
                                                        </h3>
                                                        <br>
                                                        <!--begin::Table Kriteria Pasar-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-50px text-center">No.</th>
                                                                    <th class="w-auto">Nama Pelanggan</th>
                                                                    <th class="w-auto">Nomor Adendum</th>
                                                                    <th class="w-auto">Nilai Adendum</th>
                                                                    <th class="w-auto">Tanggal Adendum</th>
                                                                    <th class="w-auto">Tgl Selesai Proyek</th>
                                                                    <th class="w-100px"></th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($proyek->AdendumProyek as $adendum)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td class="text-center">
                                                                            {{ $no++ }}
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            <a href="#"
                                                                                class="text-gray-800 text-hover-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#kt_modal_edit_adendum_{{ $adendum->id }}">{{ $adendum->pelanggan_adendum }}</a>
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $adendum->nomor_adendum ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $adendum->nilai_adendum ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $adendum->tanggal_adendum ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $adendum->tanggal_selesai_proyek ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Action-->
                                                                        <td class="text-center">
                                                                            <small>
                                                                                <p data-bs-toggle="modal"
                                                                                    data-bs-target="#kt_adendum_delete_{{ $adendum->id }}"
                                                                                    id="modal-delete"
                                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                                    Delete
                                                                                </p>
                                                                            </small>
                                                                        </td>
                                                                        <!--end::Action-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table> --}}
                                                        <!--End::Title Biru Form: History Adendum-->

                                                        {{-- <br> --}}

                                                        <br>

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0 required" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="laporan-terkontrak" name="laporan-terkontrak" rows="7">{!! $proyek->laporan_terkontrak !!}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                        <h6 class="text-danger fw-normal">(*) Kolom Ini Harus Diisi !</h6>

                                                    </div>
                                                    <!--end:::Tab Pasar Terkontrak New-->

<!--begin:::Tab Forecast Non Retail-->
                <div class="tab-pane fade" id="kt_user_view_overview_forecast" role="tabpanel">

                    <!--Begin::Title Biru Form: History-->
                    <br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">History Forecast</h3>
                    <!--End::Title Biru Form: List History-->

                    {{-- begin::Detail History Forecast --}}
                    <div class="d-flex flex-row-reverse mb-5">
                        <div>
                            Periode Prognosa :
                            @php
                                setlocale(LC_TIME, 'id.UTF-8');
                                $periode_prognosa = strftime('%B');
                            @endphp
                            <b class="mx-4">{{ $periode_prognosa }}</b>
                        </div>
                    </div>
                    <hr>
                    <br>
                    {{-- end::Detail History Forecast --}}

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-auto min-w-100px text-end"></th>
                                <th class="w-auto text-center">Bulan</th>
                                <th class="w-auto text-center">Nilai</th>
                                <th class="w-auto min-w-100px text-center"></th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            <!--begin::NILAI OK-->
                            <tr>
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>OK :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
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
                                        *Belum Ditentukan
                                @endswitch
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="rkap-forecast" name="rkap-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)" readonly/>
                                    <!--end::Input-->
                                </td>
                                <td></td>
                            </tr>
                            <!--end::NILAI OK-->
                            <!--begin::FORECAST-->
                            <tr>    
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>Forecast :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
                                    @php
                                        $bulans = (int) date('m');
                                        $proyek->Forecasts = $proyek->Forecasts->where("periode_prognosa", "=", $bulans);
                                    @endphp
                                    @foreach ($proyek->Forecasts as $forecast)
                                    @endforeach
                                        @switch($forecast->month_forecast)
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
                                                *Belum Ditentukan
                                        @endswitch
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="nilai-forecast" name="nilai-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $forecast->nilai_forecast), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)" readonly/>
                                    <!--end::Input-->
                                </td>
                                {{-- @dump(count($proyek->Forecasts)) --}}
                                @if (count($proyek->Forecasts) > 1 )
                                <td class="text-danger fw-bolder">*Proyek Non-Retail {{ $forecast->kode_proyek }},<br>&nbsp;Tidak Dapat Multi Bulan. Hub Admin !</td>
                                @endif
                                <!--end::input-->
                            </tr>
                            <!--end::FORECAST-->
                            <!--begin::Realisasi-->
                            <tr>
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>Realisasi :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
                                @switch($proyek->bulan_ri_perolehan)
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
                                        *Belum Ditentukan
                                @endswitch
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="realisasi-forecast" name="realisasi-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_perolehan), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)" readonly/>
                                    <!--end::Input-->
                                </td>
                                <td></td>
                                <!--end::input-->
                            </tr>
                            <!--end::Realisasi-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->

                    <br><hr><br>
                    
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-auto min-w-100px text-end"></th>
                                <th class="w-auto text-center">Bulan</th>
                                <th class="w-auto text-center">Nilai</th>
                                <th class="w-auto min-w-100px text-center"></th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                        {{-- <form action="/proyek/forecast/non-retail" method="post"> --}}
                            <!--begin::NILAI OK-->
                            <tr>
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>OK :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
                                    <select id="month-rkap"
                                    name="month-rkap"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Bulan OK">
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
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="rkap-forecast" name="rkap-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_rkap), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)"/>
                                    <!--end::Input-->
                                </td>
                                <td></td>
                            </tr>
                            <!--end::NILAI OK-->
                            <!--begin::FORECAST-->
                            <tr>    
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>Forecast :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
                                    @foreach ($proyek->Forecasts as $forecast)
                                    @endforeach
                                    <select id="month-forecast"
                                        name="month-forecast"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Bulan Forecast">
                                        <option></option>
                                        <option value="1"
                                            {{ $forecast->month_forecast == '1' ? 'selected' : '' }}>
                                            Januari</option>
                                        <option value="2"
                                            {{ $forecast->month_forecast == '2' ? 'selected' : '' }}>
                                            Februari</option>
                                        <option value="3"
                                            {{ $forecast->month_forecast == '3' ? 'selected' : '' }}>
                                            Maret</option>
                                        <option value="4"
                                            {{ $forecast->month_forecast == '4' ? 'selected' : '' }}>
                                            April</option>
                                        <option value="5"
                                            {{ $forecast->month_forecast == '5' ? 'selected' : '' }}>
                                            Mei</option>
                                        <option value="6"
                                            {{ $forecast->month_forecast == '6' ? 'selected' : '' }}>
                                            Juni</option>
                                        <option value="7"
                                            {{ $forecast->month_forecast == '7' ? 'selected' : '' }}>
                                            Juli</option>
                                        <option value="8"
                                            {{ $forecast->month_forecast == '8' ? 'selected' : '' }}>
                                            Agustus</option>
                                        <option value="9"
                                            {{ $forecast->month_forecast == '9' ? 'selected' : '' }}>
                                            September</option>
                                        <option value="10"
                                            {{ $forecast->month_forecast == '10' ? 'selected' : '' }}>
                                            Oktober</option>
                                        <option value="11"
                                            {{ $forecast->month_forecast == '11' ? 'selected' : '' }}>
                                            November</option>
                                        <option value="12"
                                            {{ $forecast->month_forecast == '12' ? 'selected' : '' }}>
                                            Desember</option>
                                    </select>
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="nilai-forecast" name="nilai-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $forecast->nilai_forecast), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)" />
                                    <!--end::Input-->
                                </td>
                                {{-- @dump(count($proyek->Forecasts)) --}}
                                @if (count($proyek->Forecasts) > 1 )
                                <td class="text-danger fw-bolder">*Proyek Non-Retail {{ $forecast->kode_proyek }},<br>&nbsp;Tidak Dapat Multi Bulan. Hub Admin !</td>
                                @endif
                                <!--end::input-->
                            </tr>
                            <!--end::FORECAST-->
                            <!--begin::Realisasi-->
                            <tr>
                                <!--begin::Name-->
                                <td class="text-end">
                                    <b>Realisasi :</b>
                                </td>
                                <!--end::Name-->
                                <!--begin::input-->
                                <td class="text-start ps-8">
                                    <select id="month_realisasi"
                                        name="month_realisasi"
                                        class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Bulan Realisasi">
                                        <option></option>
                                        <option value="1"
                                            {{ $proyek->bulan_ri_perolehan == '1' ? 'selected' : '' }}>
                                            Januari</option>
                                        <option value="2"
                                            {{ $proyek->bulan_ri_perolehan == '2' ? 'selected' : '' }}>
                                            Februari</option>
                                        <option value="3"
                                            {{ $proyek->bulan_ri_perolehan == '3' ? 'selected' : '' }}>
                                            Maret</option>
                                        <option value="4"
                                            {{ $proyek->bulan_ri_perolehan == '4' ? 'selected' : '' }}>
                                            April</option>
                                        <option value="5"
                                            {{ $proyek->bulan_ri_perolehan == '5' ? 'selected' : '' }}>
                                            Mei</option>
                                        <option value="6"
                                            {{ $proyek->bulan_ri_perolehan == '6' ? 'selected' : '' }}>
                                            Juni</option>
                                        <option value="7"
                                            {{ $proyek->bulan_ri_perolehan == '7' ? 'selected' : '' }}>
                                            Juli</option>
                                        <option value="8"
                                            {{ $proyek->bulan_ri_perolehan == '8' ? 'selected' : '' }}>
                                            Agustus</option>
                                        <option value="9"
                                            {{ $proyek->bulan_ri_perolehan == '9' ? 'selected' : '' }}>
                                            September</option>
                                        <option value="10"
                                            {{ $proyek->bulan_ri_perolehan == '10' ? 'selected' : '' }}>
                                            Oktober</option>
                                        <option value="11"
                                            {{ $proyek->bulan_ri_perolehan == '11' ? 'selected' : '' }}>
                                            November</option>
                                        <option value="12"
                                            {{ $proyek->bulan_ri_perolehan == '12' ? 'selected' : '' }}>
                                            Desember</option>
                                    </select>
                                </td>
                                <!--end::input-->
                                <!--begin::input-->
                                <td>
                                    <!--begin::Input-->
                                    <input type="text"
                                        class="form-control reformat form-control-solid"
                                        id="realisasi-forecast" name="realisasi-forecast"
                                        value="{{ number_format((int) str_replace('.', '', $proyek->nilai_perolehan), 0, '.', '.') }}"
                                        placeholder="Nilai OK (Excludde Ppn)"/>
                                    <!--end::Input-->
                                </td>
                                <td></td>
                                <!--end::input-->
                            </tr>
                            <!--end::Realisasi-->
                        {{-- </form> --}}
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->

<!--end:::Tab Forecast Non Retail-->


<!--begin:::Tab Approval    -->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_approval"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: Approval-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Approval (user interface)
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_create_namemodal"> </a>
                                                        </h3>
                                                        <br>
                                                        <!--End::Title Biru Form: Approval-->

                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="approval_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Kode Proyek</th>
                                                                    <th class="min-w-auto">Nama Proyek</th>
                                                                    <th class="min-w-auto">Unit Kerja</th>
                                                                    <th class="min-w-auto">Nilai RKAP</th>
                                                                    <th class="min-w-auto">Aprove By</th>
                                                                    <th class="min-w-auto">Approval Status</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                <tr>

                                                                    <!--begin::Name-->
                                                                    <td>
                                                                        <a href="/proyek/view/{{ $proyek->id }}"
                                                                            id="click-name"
                                                                            class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                                    </td>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <td>
                                                                        {{ $proyek->nama_proyek }}
                                                                    </td>
                                                                    <!--end::Email-->
                                                                    <!--begin::Company-->
                                                                    <td>
                                                                        {{ $proyek->UnitKerja->unit_kerja }}
                                                                    </td>
                                                                    <!--end::Company-->

                                                                    <!--begin::Action-->
                                                                    <td>
                                                                        {{ $proyek->nilai_rkap }}
                                                                    </td>
                                                                    <!--end::Action-->
                                                                    <!--begin::Action-->
                                                                    <td>
                                                                        Head Of Division
                                                                    </td>
                                                                    <!--end::Action-->
                                                                    <!--begin::Action-->
                                                                    <td>
                                                                        -
                                                                    </td>
                                                                    <!--end::Action-->
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->

                                                        <!--Begin::Title Biru Form: Approval-->
                                                        <br>
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Approval (Head interface)
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal"> </a>
                                                        </h3>
                                                        <br>
                                                        <!--End::Title Biru Form: Approval -->

                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Kode Proyek</th>
                                                                    <th class="min-w-auto">Nama Proyek</th>
                                                                    <th class="min-w-auto">Unit Kerja</th>
                                                                    <th class="min-w-auto">Nilai RKAP</th>
                                                                    <th class="min-w-auto text-center">Action</th>
                                                                    {{-- <th class="min-w-auto">Action</th> --}}
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                <tr>

                                                                    <!--begin::Name-->
                                                                    <td>
                                                                        <a href="/proyek/view/{{ $proyek->id }}"
                                                                            id="click-name"
                                                                            class="text-gray-800 text-hover-primary mb-1">{{ $proyek->kode_proyek }}</a>
                                                                    </td>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <td>
                                                                        {{ $proyek->nama_proyek }}
                                                                    </td>
                                                                    <!--end::Email-->
                                                                    <!--begin::Company-->
                                                                    <td>
                                                                        {{ $proyek->UnitKerja->unit_kerja }}
                                                                    </td>
                                                                    <!--end::Company-->

                                                                    <!--begin::Action-->
                                                                    <td>
                                                                        {{ $proyek->nilai_rkap }}
                                                                    </td>
                                                                    <!--end::Action-->
                                                                    <!--begin::Action-->
                                                                    <td class="text-center">
                                                                        <div class="d-grid gap-2 d-md-block">
                                                                            <!--begin::Button-->
                                                                            <button type="submit"
                                                                                class="btn btn-sm btn-primary"
                                                                                style="background-color:#008CB4; margin-left:10px">
                                                                                Approve</button>
                                                                            <!--end::Button-->

                                                                            <button
                                                                                class="btn btn-sm btn-light btn-active-danger"
                                                                                onclick="return confirm('Deleted file can not be undo. Are You Sure ?')">Reject</button>
                                                                        </div>
                                                                    </td>
                                                                    <!--end::Action-->
                                                                    {{-- <!--begin::Action-->
                                                            <td>
                                                                null
                                                            </td>
                                                            <!--end::Action--> --}}
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->

                                                    </div>
<!--end:::Tab Approval-->

<!--begin:::Tab Feedback    -->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_feedback"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: Feed back-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Proyek Feedback
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_feedback">+</a>
                                                        </h3>
                                                        <br>
                                                        <!--End::Title Biru Form: List Feed back-->

                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama Customer</th>
                                                                    <th class="min-w-auto">Ratings</th>
                                                                    <th class="min-w-400px">Approval Status</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                <tr>

                                                                    <!--begin::Email-->
                                                                    <td>
                                                                        PT. Membangun Negeri
                                                                    </td>
                                                                    <!--end::Email-->
                                                                    <!--begin::Company-->
                                                                    <td>
                                                                        &#9733;&#9733;&#9733;&#9733;&#9733;
                                                                    </td>
                                                                    <!--end::Company-->

                                                                    <!--begin::Action-->
                                                                    <td>
                                                                        Lorem Ipsum dolor sit amet guido lan gustom inercos
                                                                        tanttio, el bro sautires ki del proesa bukari
                                                                        oresro.
                                                                    </td>
                                                                    <!--end::Action-->
                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->

                                                    </div>
<!--end:::Tab Feed  back-->



                                                </div>
                                                <!--end:::Tab isi content-->

                                            </div>
                                            <!--end::Card body-->

                                        </div>
                                        <!--end::Content-->
                </form>
                <!--end::Form-->

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


    <!--begin::Modal-->

    <!--begin::modal HISTORY ADENDUM-->
    {{-- <form action="/proyek/adendum/add" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="adendum-kode-proyek" value="{{ $proyek->kode_proyek }}">
    <div class="modal fade" id="kt_modal_history_adendum" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah History Adendum :</h2>
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
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Adendum Ke</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid reformat" id="nomor-adendum"
                                    value="{{ old('nomor-adendum') }}" name="nomor-adendum" placeholder="Adendum ke" />
                                @error('nomor-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
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
                                    <span class="required">Nilai Adendum</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid reformat" id="nilai-adendum"
                                    value="{{ old('nilai-adendum') }}" name="nilai-adendum" placeholder="Nilai Adendum" />
                                @error('nilai-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
                                    </h6>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->
    
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Nama Pelanggan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="pelanggan-adendum" name="pelanggan-adendum" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Pelanggan">
                                    <option></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->name }}" {{ old('pelanggan-adendum') == $customer->name ? 'selected' : ''}}> {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('pelanggan-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
                                    </h6>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End begin::Row-->
    
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Tanggal Adendum</span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-adendum"
                                    name="tanggal-adendum"
                                    value=""
                                    placeholder="Tanggal Adendum" />
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
                                    <span>Tanggal Selesai Proyek</span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-selesai-adendum-proyek"
                                    name="tanggal-selesai-adendum-proyek"
                                    value=""
                                    placeholder="Tanggal Selesai Proyek" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->
    
                </div>
                <div class="modal-footer">
    
                    <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                        id="new_save" style="background-color:#008CB4">Save</button>
    
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</form> --}}
    <!--end::modal HISTORY ADENDUM-->

    <!--begin::edit HISTORY ADENDUM-->
    {{-- @foreach ($proyek->AdendumProyek as $adendum)
<form action="/proyek/adendum/{{ $adendum->id }}/edit" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="adendum-kode-proyek" value="{{ $proyek->kode_proyek }}">
    <div class="modal fade" id="kt_modal_edit_adendum_{{ $adendum->id }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Ubah History Adendum :</h2>
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
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Adendum Ke</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid reformat" id="nomor-adendum"
                                    value="{{ $adendum->nomor_adendum ?? old('nomor-adendum') }}" name="nomor-adendum" placeholder="Adendum ke" />
                                @error('nomor-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
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
                                    <span class="required">Nilai Adendum</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid reformat" id="nilai-adendum"
                                    value="{{ $adendum->nilai_adendum ?? "old('nilai-adendum')" }}" name="nilai-adendum" placeholder="Nilai Adendum" />
                                @error('nilai-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
                                    </h6>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->
    
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Nama Pelanggan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="pelanggan-adendum" name="pelanggan-adendum" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Team">
                                    <option></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->name }}" {{ $adendum->pelanggan_adendum == $customer->name ? 'selected' : ''}}> {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('pelanggan-adendum')
                                    <h6 class="text-danger fw-normal">{{ $message }}
                                    </h6>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End::Col-->
                    </div>
                    <!--End begin::Row-->
    
                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Tanggal Adendum</span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-adendum"
                                    name="tanggal-adendum"
                                    value="{{ $adendum->tanggal_adendum }}"
                                    placeholder="Tanggal Adendum" />
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
                                    <span>Tanggal Selesai Proyek</span>
                                </label>
                                <a href="#" class="btn"
                                    style="background: transparent;"
                                    id="start-date-modal"
                                    onclick="showCalendarModal(this)">
                                    <i class="bi bi-calendar2-plus-fill"
                                        style="color: #008CB4"></i>
                                </a>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="Date"
                                    class="form-control form-control-solid"
                                    id="tanggal-selesai-adendum-proyek"
                                    name="tanggal-selesai-adendum-proyek"
                                    value="{{ $adendum->tanggal_selesai_proyek}}"
                                    placeholder="Tanggal Selesai Proyek" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->
    
                </div>
                <div class="modal-footer">
    
                    <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                        id="new_save" style="background-color:#008CB4">Save</button>
    
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</form>
@endforeach --}}
    <!--end::edit HISTORY ADENDUM-->

    <!--begin::DELETE HISTORY ADENDUM-->
    {{-- @foreach ($proyek->AdendumProyek as $adendum)
<form action="/proyek/adendum/{{ $adendum->id }}/delete" method="post" enctype="multipart/form-data">
    @method('delete')
    @csrf
    <div class="modal fade" id="kt_adendum_delete_{{ $adendum->id }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Hapus History Adendum : {{ $adendum->pelanggan_adendum }}
                    </h2>
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
    <!--end::DELETE HISTORY ADENDUM-->

    <!--begin::modal ADD PESERTA TENDER-->
    <form action="/proyek/peserta-tender/add" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tender-kode-proyek" value="{{ $proyek->kode_proyek }}">
        <input type="hidden" name="stage-proyek" value="{{ $proyek->stage }}">
        <div class="modal fade" id="kt_modal_peserta_tender" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Peserta Tender :</h2>
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

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Peserta Tender</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="peserta-tender" name="peserta-tender"
                                        class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="false" data-placeholder="Pilih Peserta Tender">
                                        <option></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->name }}"> {{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            @if ($proyek->stage == 5)
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Nilai Penawaran</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid reformat"
                                            id="nilai-tender" name="nilai-tender" placeholder="Nilai Penawaran" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            @endif
                        </div>
                        <!--End begin::Row-->

                        @if ($proyek->stage == 5)
                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                {{-- <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span><i class="bi bi-percent text-dark"></i> OE</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid reformat" id="oe-tender"
                                name="oe-tender" placeholder="% OE" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div> --}}
                                <!--End begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Status</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                            id="status-tender" name="status-tender" placeholder="Status" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                            </div>
                            <!--End begin::Row-->
                        @endif

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::modal ADD PESERTA TENDER-->

    <!--begin::modal EDIT PESERTA TENDER-->
    @foreach ($pesertatender as $peserta)
        <form action="/proyek/peserta-tender/{{ $peserta->id }}/edit" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tender-kode-proyek" value="{{ $proyek->kode_proyek }}">
            <input type="hidden" name="tender-pagu" value="{{ $proyek->hps_pagu }}">
            <input type="hidden" name="stage-proyek" value="{{ $proyek->stage }}">
            <div class="modal fade" id="kt_modal_edit_tender_{{ $peserta->id }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Edit Peserta Tender :</h2>
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

                            <!--begin::Row-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nama Peserta Tender</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="edit-peserta-tender" name="edit-peserta-tender"
                                            class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Peserta Tender">
                                            <option></option>
                                            @foreach ($customers as $customer)
                                                @if ($customer->name == $peserta->peserta_tender)
                                                    <option value="{{ $customer->name }}" selected>
                                                        {{ $customer->name }}</option>
                                                @else
                                                    <option value="{{ $customer->name }}"> {{ $customer->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                @if ($proyek->stage == 5)
                                    <!--End begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Nilai Penawaran</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid reformat"
                                                id="nilai-tender" name="nilai-tender"
                                                value="{{ $peserta->nilai_tender_peserta }}"
                                                placeholder="Nilai Penawaran" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--End begin::Col-->
                                @endif
                            </div>
                            <!--End begin::Row-->

                            @if ($proyek->stage == 5)
                                <!--begin::Row-->
                                <div class="row fv-row">
                                    <!--begin::Col-->
                                    {{-- <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span><i class="bi bi-percent text-dark"></i> OE</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid reformat" id="oe-tender"
                                name="oe-tender" value="{{ $peserta->oe_tender }}" placeholder="% OE" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div> --}}
                                    <!--End begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Status</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid"
                                                id="status-tender" name="status-tender"
                                                value="{{ $peserta->status }}" placeholder="Status" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--End begin::Col-->
                                </div>
                                <!--End begin::Row-->
                            @endif

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::modal EDIT PESERTA TENDER-->

    <!--begin::DELETE PESERTA TENDER-->
    @foreach ($pesertatender as $peserta)
        <form action="/proyek/peserta-tender/{{ $peserta->id }}/delete" method="post"
            enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_tender_delete_{{ $peserta->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus Peserta Tender : {{ $peserta->peserta_tender }}
                            </h2>
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
    <!--end::DELETE PESERTA TENDER-->

    <!--begin::modal ADD USER SKAT-->
    <form action="/proyek/user/add" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="assign-kode-proyek" value="{{ $proyek->kode_proyek }}">
        <input type="hidden" name="assign-stage" value="{{ $proyek->stage }}">
        <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Assign Personil Proyek : {{ $proyek->nama_proyek }}</h2>
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

                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Personil</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="nama-team" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Team">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
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
                                        <span class="required">Bidang Sertifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="role-team"
                                        name="role-team" placeholder="Bidang Sertifikasi" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End begin::Row-->

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::modal ADD USER SKAT-->

    <!--begin::DELETE USER SKAT-->
    @foreach ($teams as $team)
        <form action="/proyek/user-delete/{{ $team->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_team_delete_{{ $team->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $team->User->name }} - {{ $team->role }}
                            </h2>
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
    <!--end::DELETE USER SKAT-->

    <!--begin::modal KRITERIA PASAR-->
    <form action="/proyek/kriteria-add" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="data-kriteria-proyek" value="{{ $proyek->kode_proyek }}">
        <div class="modal fade" id="kt_modal_kriteria_pasardini" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Kriteria Proyek : </h2>
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
                        @foreach ($kriteriapasar as $key => $kriteria)
                            @php
                                $kategories = strtolower(str_replace(' ', '', $kriteria->kategori));
                                $kategori = str_replace('/', '', $kategories);
                            @endphp
                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-4">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Kategori</span>
                                        </label>
                                        <!--end::Label-->
                                        <br>
                                        <!--begin::Input-->
                                        <label class="fs-6 fw-bolder form-label mt-3">
                                            <span class="kategori-pasar"
                                                data-id="{{ $kriteria->id }}">{{ $kriteria->kategori }}</span>
                                        </label>
                                        {{-- <input type="hidden" name="kategori-pasar-{{ $kategori }}" value="{{ $kriteria->kategori }}"> --}}
                                        <input type="hidden" name="kategori-pasar[]"
                                            value="{{ $kriteria->kategori }}">
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-5">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kriteria</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        {{-- <select onchange="setBobot(this)" id="kriteria-pasar-{{ $kriteria->id }}" name="kriteria-pasar-{{ $kriteria->id }}"
                                    class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Kriteria"> --}}
                                        <select onchange="setBobot(this)" id="kriteria-pasar-{{ $kriteria->id }}"
                                            name="kriteria-pasar[]" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true"
                                            data-placeholder="Pilih Kriteria">
                                            <option></option>
                                            {{-- @if ($kriteria->kategori != null) --}}
                                            {{-- <option value="{{ $kriteria->kriteria }}"> {{ $kriteria->kriteria }}</option> --}}
                                            {{-- @endif --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-2">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Bobot</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                            id="bobot-{{ $kategori }}" name="bobot[]" placeholder="" readonly />
                                        {{-- <input type="text" class="form-control form-control-solid" id="bobot-{{ $kategori }}"
                                    name="bobot-{{ $kategori }}" placeholder="" readonly /> --}}
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->
                            <script>
                                // let bobot = "";
                                async function kategoriSelect() {
                                    let e = document.getElementsByClassName('kategori-pasar')
                                    // e.forEach(el => {
                                    //     console.log(el.innerText);
                                    // });
                                    for (let i = 0; i < e.length; i++) {
                                        const elm = e[i];
                                        // console.log(elm.innerText);

                                        const kategori = elm.innerText;
                                        const formData = new FormData();
                                        let html = `<option value=""></option>`;
                                        formData.append("_token", "{{ csrf_token() }}");
                                        formData.append("kategori", kategori);

                                        const getKriteriaRes = await fetch("/proyek/get-kriteria", {
                                            method: "POST",
                                            header: {
                                                "Content-Type": "application/json",
                                            },
                                            body: formData,
                                        }).then(res => res.json());
                                        // console.log(getKriteriaRes);
                                        getKriteriaRes.forEach(data => {

                                            html +=
                                                `<option data-id="${data.kategori.replaceAll(" ", "").replaceAll("/", "")}" data-bobot="${data.bobot}" value="${data.kriteria}">${data.kriteria}</option>`;
                                        });
                                        let id = elm.getAttribute("data-id");
                                        // console.log(id);
                                        document.querySelector("#kriteria-pasar-" + id).innerHTML = html;
                                        // document.querySelector("#kriteria-pasar").setAttribute("bobot", data.bobot);
                                    }
                                }

                                function setBobot(e) {
                                    let bobot = "";
                                    let id = "";
                                    e.options.forEach(option => {
                                        // console.log(option.getAttribute("data-id"));
                                        if (option.selected) {
                                            id = option.getAttribute("data-id");
                                            console.log(option, id);
                                            bobot = option.getAttribute("data-bobot");
                                            // console.log(option.getAttribute("data-bobot"));
                                        }
                                    })
                                    // console.log(bobot, id);
                                    document.querySelector("#bobot-" + id).value = bobot;
                                }
                            </script>
                        @endforeach
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::modal KRITERIA PASAR-->

    <!--begin::modal KRITERIA PASAR-->
    {{-- <form action="/proyek/kriteria-add" method="post" enctype="multipart/form-data">
@csrf
<input type="hidden" name="data-kriteria-proyek" value="{{ $proyek->kode_proyek }}">
<div class="modal fade" id="kt_modal_kriteria_pasardini" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Kriteria Proyek : </h2>
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
                <!--begin::Row Kanan+Kiri-->
                <div class="row fv-row">
                    <!--begin::Col-->
                    <div class="col-5">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Kategori</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select onchange="kategoriSelect(this)" id="kategori-pasar" name="kategori-pasar"
                                class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Pilih Kategori">
                                <option></option>
                                @foreach ($kriteriapasar as $kriteria)
                                    <option value="{{ $kriteria->kategori }}">
                                        {{ $kriteria->kategori }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                    <div class="col-5">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Kriteria</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select onchange="setBobot(this)" id="kriteria-pasar" name="kriteria-pasar"
                                class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Pilih Kriteria">
                                <option></option>
                                @foreach ($kriteriapasar as $kriteria)
                                    <option value="{{ $kriteria->kriteria }}">
                                        {{ $kriteria->kriteria }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                    <div class="col-2">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Bobot</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" id="bobot"
                                name="bobot" placeholder="" readonly />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End::Col-->
                </div>
                <!--End::Row Kanan+Kiri-->
                <script>
                    // let bobot = "";
                    async function kategoriSelect(e) {
                        const kategori = e.value;
                        const formData = new FormData();
                        let html = `<option value=""></option>`;
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("kategori", kategori);
                        const getKriteriaRes = await fetch("/proyek/get-kriteria", {
                            method: "POST",
                            header: {
                                "Content-Type": "application/json",
                            },
                            body: formData,
                        }).then(res => res.json());
                        console.log(getKriteriaRes);
                        getKriteriaRes.forEach(data => {
                            html += `<option data-bobot="${data.bobot}" value="${data.kriteria}">${data.kriteria}</option>`;
                        });
                        document.querySelector("#kriteria-pasar").innerHTML = html;
                        // document.querySelector("#kriteria-pasar").setAttribute("bobot", data.bobot);
                    }
                    function setBobot(e) {
                        let bobot = "";
                        e.options.forEach(option => {
                            if (option.selected) {
                                bobot = option.getAttribute("data-bobot")
                                // console.log(option.getAttribute("data-bobot"));
                            }
                        })
                        // console.log(bobot);
                        document.querySelector("#bobot").value = bobot;
                    }
                </script>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                    id="new_save" style="background-color:#008CB4">Save</button>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
</form> --}}
    <!--end::modal KRITERIA PASAR-->

    <!--begin::modal EDIT KRITERIA PASAR-->
    @foreach ($kriteriapasarproyek as $kriteria)
        {{-- @dump($kriteriapasarproyek) --}}
        <form action="/proyek/{{ $kriteria->id }}/kriteria-edit" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="edit-kriteria-proyek" value="{{ $proyek->kode_proyek }}">

            <div class="modal fade" id="kt_modal_edit_kriteria_{{ $kriteria->id }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Edit Kriteria Proyek : </h2>
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


                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-5">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Kategori</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" value="{{ $kriteria->kategori }}"
                                            class="form-control form-control-solid" id="edit-kategori-pasar"
                                            name="edit-kategori-pasar" placeholder="" readonly />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-5">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Kriteria</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select onchange="editBobot(this)"
                                            id="edit-kriteria-pasar-{{ $kriteria->id }}" name="edit-kriteria-pasar"
                                            class="form-select form-select-solid" data-control="select2"
                                            data-edit-bobot="edit-bobot-{{ $kriteria->id }}" data-hide-search="true"
                                            data-placeholder="Pilih Kriteria">
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="col-2">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Bobot</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                            id="edit-bobot-{{ $kriteria->id }}" name="edit-bobot" placeholder=""
                                            readonly />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->
                        </div>
                        <script>
                            async function kategoriKlick(e) {
                                // console.log(e);
                                const kategori = e.getAttribute("data-value");
                                const editKriteria = e.getAttribute("data-kriteria");
                                // const kategori = document.getElementById('edit-kategori-pasar');
                                // console.log(editKriteria);
                                const formData = new FormData();
                                let html = `<option></option>`;
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("kategori", kategori);
                                const getKriteriaRes = await fetch("/proyek/get-kriteria", {
                                    method: "POST",
                                    header: {
                                        "Content-Type": "application/json",
                                    },
                                    body: formData,
                                }).then(res => res.json());
                                // console.log(getKriteriaRes);
                                getKriteriaRes.forEach(data => {
                                    html += `<option data-bobot="${data.bobot}" value="${data.kriteria}">${data.kriteria}</option>`;
                                });
                                // console.log(IDkriteriapasar);
                                document.querySelector("#" + editKriteria).innerHTML = html;
                            }

                            function editBobot(e) {
                                let bobot = "";
                                const editBobot = e.getAttribute("data-edit-bobot");
                                // console.log(editBobot);
                                e.options.forEach(option => {
                                    if (option.selected) {
                                        bobot = option.getAttribute("data-bobot");
                                    }
                                })
                                // console.log(bobot);
                                document.querySelector("#" + editBobot).value = bobot;
                            }
                        </script>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::modal EDIT KRITERIA PASAR-->

    <!--begin::DELETE KRITERIA-->
    @foreach ($kriteriapasarproyek as $kriteria)
        <form action="/proyek/kriteria-delete/{{ $kriteria->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_kriteria_delete_{{ $kriteria->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $kriteria->kategori }} - {{ $kriteria->kriteria }} : {{ $kriteria->bobot }}
                            </h2>
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
    <!--end::DELETE KRITERIA-->


    <!--begin::modal PORSI JO-->
    <form action="/proyek/porsi-jo" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="porsi-kode-proyek" value="{{ $proyek->kode_proyek }}">

        <div class="modal fade" id="kt_modal_porsijo" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Porsi JO : </h2>
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


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row">
                                    @php
                                        $joCompany = 0;
                                        foreach ($porsiJO as $porsi) {
                                            if ($porsi->count() > 0) {
                                                $joCompany += $porsi->porsi_jo;
                                            }
                                        }
                                    @endphp
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label">
                                        <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}"></b></span>
                                        {{-- <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}">Max Porsi JO : {{ $proyek->porsi_jo }}% </b></span> --}}
                                    </label>
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

                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Company</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="company-jo" name="company-jo" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="false"
                                        data-placeholder="Pilih Company JO">
                                        <option></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->name }}">
                                                {{ $customer->name }}</option>
                                        @endforeach
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
                                        <span>Porsi JO Company (1 - {{ $proyek->porsi_jo }} %)</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" min="1" max="{{ $proyek->porsi_jo }}"
                                        onkeyup="getJO()" onchange="getJO()" class="form-control form-control-solid"
                                        id="porsijo-company" name="porsijo-company" placeholder="Porsi JO" />
                                    <!--end::Input-->
                                    <!--begin::Hidden Input-->
                                    <input type="hidden" id="sisa-input" name="sisa-input" value="">
                                    <!--end::Hidden Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->
                        <script>
                            function getJO() {
                                let porsiJO = document.getElementById("porsijo-company");
                                let maxJO = document.getElementById("max-porsi");
                                let sisaJO = maxJO.getAttribute("value") - porsiJO.value;
                                // // console.log(maxJO);
                                // // console.log(porsiJO.value);
                                // document.getElementById("sisa-porsi").innerHTML = " = " + sisaJO + "%";
                                // document.getElementById("selisih-porsi").innerHTML = porsiJO.value;
                                document.getElementById("sisa-input").value = sisaJO;
                            }
                        </script>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                            id="new_save" style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::modal PORSI JO-->

    <!--begin::edit PORSI JO-->
    @foreach ($porsiJO as $porsi)
        <form action="/proyek/porsi-jo/{{ $porsi->id }}/edit" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="porsi-kode-proyek" value="{{ $proyek->kode_proyek }}">

            <div class="modal fade" id="kt_porsi_edit_{{ $porsi->id }}" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Ubah Porsi JO : </h2>
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


                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row">
                                        @php
                                            $joCompany = 0;
                                            foreach ($porsiJO as $porsi) {
                                                if ($porsi->count() > 0) {
                                                    $joCompany += $porsi->porsi_jo;
                                                }
                                            }
                                        @endphp
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label">
                                            <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}"></b></span>
                                            {{-- <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}">Max Porsi JO : {{ $proyek->porsi_jo }}% </b></span> --}}
                                        </label>
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

                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="col-6">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>Company</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="company-jo" name="company-jo"
                                            class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Company JO">
                                            <option></option>
                                            @foreach ($customers as $customer)
                                                @if ($porsi->company_jo == $customer->name)
                                                    <option value="{{ $customer->name }}" selected>
                                                        {{ $customer->name }}</option>
                                                @else
                                                    <option value="{{ $customer->name }}">{{ $customer->name }}
                                                    </option>
                                                @endif
                                            @endforeach
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
                                            <span>Porsi JO Company (1 - {{ $proyek->porsi_jo }} %)</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="number" min="1" max="{{ $proyek->porsi_jo }}"
                                            value="{{ $porsi->porsi_jo }}" onkeyup="getJO()" onchange="getJO()"
                                            class="form-control form-control-solid" id="porsijo-company"
                                            name="porsijo-company" placeholder="Porsi JO" />
                                        <!--end::Input-->
                                        <!--begin::Hidden Input-->
                                        <input type="hidden" id="porsijo-company-sebelumnya"
                                            name="porsijo-company-sebelumnya" value="{{ $porsi->porsi_jo }}">
                                        <!--end::Hidden Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::edit PORSI JO-->

    <!--begin::DELETE PORSI JO-->
    @foreach ($porsiJO as $porsi)
        <form action="/proyek/porsi-delete/{{ $porsi->id }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_porsi_delete_{{ $porsi->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus Porsi Partner JO : {{ $porsi->company_jo }} - {{ $porsi->porsi_jo }}%
                            </h2>
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
    <!--end::DELETE PORSI JO-->

    <!--begin::DELETE DOKUMEN PRAKUALIFIKASI-->
    @foreach ($proyek->DokumenPrakualifikasi as $dokumen_prakualifikasi)
        <form action="/proyek/dokumen-prakualifikasi/{{ $dokumen_prakualifikasi->id_dokumen_prakualifikasi }}/delete"
            method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade"
                id="kt_dokumen_prakualifikasi_delete_{{ $dokumen_prakualifikasi->id_dokumen_prakualifikasi }}"
                tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $dokumen_prakualifikasi->nama_dokumen }}</h2>
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
    <!--end::DELETE DOKUMEN PRAKUALIFIKASI-->

    <!--begin::DELETE RISK TENDER PROYEK-->
    @foreach ($proyek->RiskTenderProyek as $riskTender)
        <form action="/proyek/risk-tender/{{ $riskTender->id }}/delete" method="post"
            enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_risk_tender_delete_{{ $riskTender->id }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $riskTender->nama_risk_tender }}</h2>
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
    <!--end::DELETE RISK TENDER PROYEK-->

    <!--begin::DELETE ATTACHMENT MENANG-->
    @foreach ($proyek->AttachmentMenang as $attachment)
        <form action="/proyek/attachment-menang/{{ $attachment->id }}/delete" method="post"
            enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_attachment_delete_{{ $attachment->id }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $attachment->nama_attachment }}</h2>
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
    <!--end::DELETE ATTACHMENT MENANG-->

    <!--begin::modal Cancel Proyek-->
    <form action="/proyek/cancel-modal/{{ $proyek->kode_proyek }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal fade" id="kt_modal_cancel_proyek" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Cancel Proyek : {{ $proyek->kode_proyek }} - {{ $proyek->nama_proyek }}
                        </h2>
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
                    @if ($proyek->stage == 0)
                        <div class="modal-body py-lg-6 px-lg-6">
                            Proyek sudah ter-Cancel !
                            <br>
                        </div>
                    @else
                        <div class="modal-body py-lg-6 px-lg-6">
                            Proyek yang ter-Cancel tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-danger">Cancel Proyek</button>
                        </div>
                    @endif
                    <!--end::Input group-->

                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::modal Cancel Proyek-->

    {{-- <!--begin::modal APPROVAL-->
<form action="/proyek" method="post" enctype="multipart/form-data"> 
@csrf
<!--begin::Modal - Create Proyek-->
<div class="modal fade" id="kt_modal_create_approval" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Choose Approval Head :</h2>
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
            <!--begin::Row Kanan+Kiri-->
            <div class="row fv-row">
                <!--begin::Input-->
                <select name="head-approval" class="form-select form-select-solid" data-control="select2"
                    data-hide-search="true" data-placeholder="Select Head To Send Approval">
                    <option></option>
                    <option value="Head Divisi Bangun Gedung">Head Divisi Bangun Gedung</option>
                    <option value="Head Divisi Industri Plant">Head Divisi Industri Plant</option>
                    <option value="Head Industri Infrastruktur">Head Industri Infrastruktur</option>
                </select>
                <!--end::Input-->
            </div>
            <!--End::Row Kanan+Kiri-->
            <br>
            <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Send</button>
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->
</form>
<!--begin::modal APPROVAL--> --}}



    <!--begin::Feedback Modals-->
    {{-- <form action="/customer/save-modal" method="post" enctype="multipart/form-data"> 
        @csrf --}}

    {{-- <!--begin::Modal - Feedback-->
<div class="modal fade" id="kt_modal_feedback" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Feedback</h2>
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
                <div class="fv-row mb-5">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span>Nama Customer</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" id="nama-feedback"
                        name="nama-feedback" value="" placeholder="Nama Customer" />
                    <!--end::Input-->
                    <br>
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span>Peringkat :&nbsp;</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            value="option1">
                        <label class="form-check-label" for="inlineRadio1">1</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            value="option2">
                        <label class="form-check-label" for="inlineRadio2">2</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio3"
                            value="option3">
                        <label class="form-check-label" for="inlineRadio3">3</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio4"
                            value="option4">
                        <label class="form-check-label" for="inlineRadio4">4</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="" type="radio" name="inlineRadioOptions" id="inlineRadio5"
                            value="option5">
                        <label class="form-check-label" for="inlineRadio5">5</label>
                    </div>
                    <!--end::Input-->
                    <!--begin::Label-->
                    <div>
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span>Kritik dan saran</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        &nbsp;<br>
                        <div class="form-group">
                            <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control form-control-solid"
                                id="exampleFormControlTextarea1" rows="7">{{ $proyek->laporan_kualitatif_pasdin }}</textarea>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
                <button type="submit" class="btn btn-sm btn-primary" id="feedback_new_save">Save</button>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div> --}}
    <!--end:: Feedback Modals-->

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
@endsection
