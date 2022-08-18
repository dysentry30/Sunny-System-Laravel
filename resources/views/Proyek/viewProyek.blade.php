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
    color: red;
    opacity: 1; /* Firefox */
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
                @extends('template.header')
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
                                    <h1 class="d-flex align-items-center fs-3 my-1">
                                        Proyek - &nbsp;
                                        <div class="text-truncate" style="max-width: 500px"  data-bs-toggle="tooltip" data-bs-title="{{ $proyek->nama_proyek }}" data-bs-custom-class="text-start">
                                            {{ $proyek->nama_proyek }}
                                        </div>
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button type="submit" class="btn btn-sm btn-primary" id="customer_new_save"
                                        style="background-color:#008CB4">
                                        Save</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-danger ms-4" onclick="document.location.reload()" style="display: none;" id="cancel-button">
                                        Cancel</button>
                                    <!--end::Button-->

                                    <!--begin::Button-->
                                    {{-- <a class="btn btn-sm btn-light btn-active-primary fs-7 px-4 mx-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_approval" id="kt_toolbar_primary_button"
                                        style="padding: 8px">
                                        Req Approval
                                    </a> --}}
                                    <!--end::Button-->
                                    &nbsp;
                                    &nbsp;
                                    <!--begin::Button-->
                                    <a href="/proyek" class="btn btn-sm btn-light btn-active-primary"
                                        id="customer_new_close">
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
                                <div class="row">

<!--begin::Header Orange-->
                                    <div class="col-xl-15 mb-8">
                                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                            <div class="card-body pt-auto"
                                                style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                                <div class="form-group">
                                                    <div id="stage-button" class="stage-list">
                                                        <a href="#"
                                                            class="stage-button stage-action color-is-default stage-is-done"
                                                            style="outline: 0px; cursor: pointer;" stage="1">
                                                            Pasar Dini
                                                        </a>
                                                        @if ($proyek->stage > 1)
                                                            <a href="#"
                                                                class="stage-button stage-action color-is-default stage-is-done"
                                                                style="outline: 0px; cursor: pointer;" stage="2">
                                                                Pasar Potensial
                                                            </a>
                                                        @else
                                                            <a href="#"
                                                                class="stage-button stage-action color-is-default stage-is-not-active"
                                                                style="outline: 0px; cursor: pointer;" stage="2">
                                                                Pasar Potensial
                                                            </a>
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
                                                                style="font-size:14px;">Menang</a>
                                                        </li>
                                                        <!--end:::Tab item Menang-->
                                                    @endif

                                                    @if ($proyek->stage > 7)
                                                        <!--begin:::Tab item Terkontrak-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_terkontrak"
                                                                style="font-size:14px;">Terkontrak</a>
                                                        </li>
                                                        <!--end:::Tab item Terkontrak-->
                                                    @endif

                                                    <!--begin:::Tab item Forecast-->
                                                    {{-- <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_overview_forecast"
                                                            style="font-size:14px;">Forecast</a>
                                                    </li> --}}
                                                    <!--end:::Tab item Forecast-->

                                                    <!--begin:::Tab item Approval-->
                                                    <li class="nav-item">
                                                        <a class="nav-link text-active-primary pb-4"
                                                            data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                            href="#kt_user_view_overview_approval"
                                                            style="font-size:14px;">Approval</a>
                                                    </li>
                                                    <!--end:::Tab item Approval-->

                                                    @if ($proyek->stage > 9)
                                                        <!--begin:::Tab item Feedback-->
                                                        <li class="nav-item">
                                                            <a class="nav-link text-active-primary pb-4"
                                                                data-kt-countup-tabs="true" data-bs-toggle="tab"
                                                                href="#kt_user_view_overview_Feedback"
                                                                style="font-size:14px;">Feedback</a>
                                                        </li>
                                                        <!--end:::Tab item Feedback-->
                                                    @endif
                                                </ul>
<!--end:::Tabs Navigasi-->

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
                                                                        <span class="required">Kode Proyek <i class="bi bi-lock"></i></span>
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
                                                                        <span class="required">Tipe Proyek <i class="bi bi-key"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="tipe-proyek" name="tipe-proyek"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Tipe Proyek" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                                                        <option value="R" {{ $proyek->tipe_proyek == 'R' ? 'selected' : '' }}>Retail</option>
                                                                        <option value="P" {{ $proyek->tipe_proyek == 'P' ? 'selected' : '' }}>Non-Retail</option>
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
                                                                    data-placeholder="Pilih Jenis Proyek" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                                                        <option value="I" {{ $proyek->jenis_proyek == 'I' ? 'selected' : '' }}>Internal</option>
                                                                        <option value="E" {{ $proyek->jenis_proyek == 'E' ? 'selected' : '' }}>External</option>
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
                                                                        <span class="required">Tahun Perolehan <i
                                                                                class="bi bi-key"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    {{-- <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        name="tahun-perolehan" min="2021"
                                                                        max="2099" step="1"
                                                                        value="{{ $proyek->tahun_perolehan }}" readonly /> --}}
                                                                    @php
                                                                        $years = $proyek->tahun_perolehan;
                                                                    @endphp
                                                                    <!--begin::Input-->
                                                                    <select id="tahun-perolehan" name="tahun-perolehan"
                                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                                        data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                                                        @for ($i = 2021; $i < $years + 20; $i++)
                                                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
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
                                                                        <span class="required">Bulan Pelaksanaan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--Begin::Input-->
                                                                    <select id="bulan-pelaksanaan"
                                                                        name="bulan-pelaksanaan"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Bulan Pelaksanaan">
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
                                                                        <span class="required">Sumber Dana</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select id="sumber-dana" name="sumber-dana"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih Sumber Dana">
                                                                        <option></option>
                                                                        @foreach ($sumberdanas as $sumberdana)
                                                                            @if ($sumberdana->nama_sumber == $proyek->sumber_dana)
                                                                                <option
                                                                                    value="{{ $sumberdana->nama_sumber }}"
                                                                                    selected>
                                                                                    {{ $sumberdana->nama_sumber }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    value="{{ $sumberdana->nama_sumber }}">
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
                                                                        <span class="required">Nilai OK RKAP <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control reformat form-control-solid"
                                                                        id="nilai-rkap" name="nilai-rkap"
                                                                        value="{{ $proyek->nilai_rkap }}"
                                                                        placeholder="Nilai OK RKAP" readonly/>
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
                                                            <!--End begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Nama PIC <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="pic" name="pic"
                                                                        value="{{ $proyek->pic ?? auth()->user()->name }}"
                                                                        placeholder="Nama PIC" readonly/>
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
                                                            <i onclick="hideReview()" id="hide-review" class="bi bi-arrows-collapse"></i><i onclick="showReview()" id="show-review" style="display: none" class="bi bi-arrows-expand"></i> 
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
                                                        <div id="divRkapReview">
                                                        <!--End::Title Biru Form: Nilai RKAP Review-->

                                                            <!--begin::Row Kanan+Kiri-->
                                                            <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <!--begin::Input group Website-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                                            <span>Nilai OK Review (Valas) (Exclude Tax) <i class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" onkeyup="hitungReview()"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilai-valas-review" name="nilai-valas-review"
                                                                            value="{{ $proyek->nilai_valas_review }}"
                                                                            placeholder="Nilai OK Review (Valas) (Exclude Tax)" {{ auth()->user()->check_administrator ? '' : 'readonly'}} />
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
                                                                            <span>Mata Uang <i class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="mata-uang-review" name="mata-uang-review"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Mata Uang" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
                                                                            <option></option>
                                                                            <option value="IDR"
                                                                                {{ $proyek->mata_uang_review == 'IDR' ? 'selected' : '' }}>
                                                                                IDR</option>
                                                                            <option value="USD"
                                                                                {{ $proyek->mata_uang_review == 'USD' ? 'selected' : '' }}>
                                                                                USD</option>
                                                                            <option value="YUAN"
                                                                                {{ $proyek->mata_uang_review == 'YUAN' ? 'selected' : '' }}>
                                                                                YUAN</option>
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
                                                                            <span>Kurs Review <i class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input onkeyup="hitungReview()" type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="kurs-review" name="kurs-review"
                                                                            value="{{ $proyek->kurs_review }}"
                                                                            placeholder="Kurs Review" {{ auth()->user()->check_administrator ? '' : 'readonly'}} />
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
                                                                            <span>Bulan Pelaksanaan <i class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--Begin::Input-->
                                                                        <select id="bulan-pelaksanaan-review"
                                                                            name="bulan-pelaksanaan-review"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Pilih Bulan Pelaksanaan" {{ auth()->user()->check_administrator ? '' : 'disabled'}}>
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
                                                                            <span>Nilai OK (Exclude PPN) <i class="bi bi-key"></i></span>
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text"
                                                                            class="form-control form-control-solid reformat"
                                                                            id="nilaiok-review" name="nilaiok-review"
                                                                            value="{{ $proyek->nilaiok_review }}"
                                                                            placeholder="Nilai OK (Exclude PPN)" {{ auth()->user()->check_administrator ? '' : 'readonly'}} />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <!--End::Row Kanan+Kiri-->

                                                            <script>
                                                                function hitungReview() {
                                                                    let nilaiOkReview = document.getElementById("nilai-valas-review").value.replaceAll(",", "");
                                                                    // console.log(nilaiOkReview); 
                                                                    let kursReview = document.getElementById("kurs-review").value.replaceAll(",", "");
                                                                    let hasilOkReview = nilaiOkReview * kursReview;
                                                                    document.getElementById("nilaiok-review").value = Intl.NumberFormat({}).format(hasilOkReview);
                                                                }
                                                            </script>
                                                        </div> <!--divRkapReview--> 


                                                        <!--Begin::Title Biru Form: Nilai RKAP Awal-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Nilai RKAP Awal &nbsp;
                                                            <i onclick="hideColumn()" id="hide-button" class="bi bi-arrows-collapse"></i><i onclick="showColumn()" id="show-button" style="display: none" class="bi bi-arrows-expand"></i> 
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
                                                        <div id="divRkapAwal">
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
                                                                        value="{{ $proyek->nilai_rkap }}"
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
                                                                        <span>Mata Uang</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--Begin::Input-->
                                                                    <select id="mata-uang-awal" name="mata-uang-awal"
                                                                    class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="Pilih Mata Uang"  >
                                                                    <option></option>
                                                                    <option value="IDR"
                                                                    {{ $proyek->mata_uang_awal == 'IDR' ? 'selected' : '' }}>
                                                                    IDR</option>
                                                                    <option value="USD"
                                                                    {{ $proyek->mata_uang_awal == 'USD' ? 'selected' : '' }}>
                                                                    USD</option>
                                                                    <option value="YUAN"
                                                                    {{ $proyek->mata_uang_awal == 'YUAN' ? 'selected' : '' }}>
                                                                    YUAN</option>
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
                                                                            <span>Bulan Pelaksanaan <i
                                                                                class="bi bi-lock"></i></span>
                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <!--Begin::Input-->
                                                                            <select id="bulan-pelaksanaan-awal"
                                                                            name="bulan-pelaksanaan-awal"
                                                                            class="form-select form-select-solid"
                                                                            data-control="select2" data-hide-search="true"
                                                                            data-placeholder="Bulan Pelaksanaan" disabled>
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
                                                                                        Selesai
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
                                                                            value="{{ $proyek->nilaiok_awal }}"
                                                                            placeholder="Nilai OK (Exclude PPN)" readonly />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input group-->
                                                                    </div>
                                                                <!--End::Col-->
                                                            </div>
                                                            <script>
                                                                function hitungAwal() {
                                                                    let nilaiOkAwal = document.getElementById("nilai-valas-awal").value.replaceAll(",", "");
                                                                    let kursAwal = document.getElementById("kurs-awal").value.replaceAll(",", "");
                                                                    let hasilOkAwal = nilaiOkAwal * kursAwal;
                                                                    document.getElementById("nilaiok-awal").value = Intl.NumberFormat({}).format(hasilOkAwal);
                                                                }
                                                                </script>
                                                            <!--End::Row Kanan+Kiri-->
                                                        </div> <!--divRkapAwal-->

                                                        <!--Begin::Title Biru Form: Kriteria pasar-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Kriteria Pasar
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
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

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea id="laporan-kualitatif-pasdin" name="laporan-kualitatif-pasdin" class="form-control form-control-solid"
                                                                id="exampleFormControlTextarea1" rows="3">{{ $proyek->laporan_kualitatif_pasdin }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->



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
                                                                    <select name="negara" id="negara" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false" 
                                                                        onchange="selectProvinsi(this)"
                                                                        data-placeholder="Pilih Negara">
                                                                        <option value=""></option>
                                                                        @foreach ($data_negara as $negara)
                                                                            @if ($negara->country == $proyek->negara)
                                                                                <option value="{{$negara->country}}" selected>{{$negara->country}}</option>
                                                                            @else
                                                                                <option value="{{$negara->country}}">{{$negara->country}}</option>
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
                                                                    <select onchange="getSBU(this)" id="sbu" name="sbu"
                                                                        class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="true"
                                                                        data-placeholder="Pilih SBU">
                                                                        <option></option>
                                                                        @foreach ($sbus as $sbu)
                                                                            @if ($sbu->sbu == $proyek->sbu)
                                                                                <option value="{{ $sbu->sbu }}" data-klasifikasi="{{ $sbu->klasifikasi }}" data-sub="{{ $sbu->sub_klasifikasi }}" selected>{{ $sbu->sbu }}</option>
                                                                            @else
                                                                                <option value="{{ $sbu->sbu }}" data-klasifikasi="{{ $sbu->klasifikasi }}" data-sub="{{ $sbu->sub_klasifikasi }}">{{ $sbu->sbu }}</option>
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
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Provinsi</span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="provinsi" name="provinsi"
                                                                        value="{{ $proyek->provinsi }}"
                                                                        placeholder="Provinsi" /> --}}
                                                                    <select name="provinsi" id="provinsi" class="form-select form-select-solid"
                                                                        data-control="select2" data-hide-search="false" 
                                                                        onchange="selectProvinsi(this)"
                                                                        data-placeholder="Pilih Provinsi">
                                                                        <option value=""></option>
                                                                        @foreach ($data_provinsi as $provinsi)
                                                                            @if ($provinsi->id == $proyek->provinsi)
                                                                                <option value="{{$provinsi->id}}" selected>{{ucwords(strtolower($provinsi->name))}}</option>
                                                                            @else
                                                                                <option value="{{$provinsi->id}}">{{ucwords(strtolower($provinsi->name))}}</option>
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
                                                                        <span>Klasifikasi <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="klasifikasi" name="klasifikasi"
                                                                        value="{{ $proyek->klasifikasi }}"
                                                                        placeholder="Klasifikasi" readonly/>
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
                                                                        <span>Status Pasar <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    @php
                                                                        if ($statusPasar == '') {
                                                                            $statusPasar = '*Kriteria Pasar Belum Diisi';
                                                                        } elseif ($statusPasar >= 0.75) {
                                                                            $statusPasar = 'Potensial';
                                                                        } else {
                                                                            $statusPasar = 'Non-Potensial';
                                                                        }
                                                                    @endphp
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="status-pasar" name="status-pasar"
                                                                        value="{{ $statusPasar }}" readonly />
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
                                                                        <span>Sub-Klasifikasi <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="sub-klasifikasi" name="sub-klasifikasi"
                                                                        value="{{ $proyek->sub_klasifikasi }}"
                                                                        placeholder="Sub-Klasifikasi" readonly/>
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
                                                                        {{-- @foreach ($dops as $dop)
                                                                    @if ($dop->dop == $proyek->dop)
                                                                        <option value="{{ $dop->dop }}" selected>{{$dop->dop }}</option>
                                                                    @else
                                                                        <option value="{{ $dop->dop }}">{{$dop->dop }}</option>
                                                                    @endif
                                                                    @endforeach --}}
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
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--Begin::Title Biru Form: Kriteria pasar-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Kriteria Pasar
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
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
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        &nbsp;<br>
                                                        <div class="form-group">
                                                            <textarea class="form-control form-control-solid" id="laporan-kualitatif-paspot" name="laporan-kualitatif-paspot"
                                                                rows="3">{{ $proyek->laporan_kualitatif_paspot }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

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
                                                                        name="jadwal-pq" value="{{ $proyek->jadwal_pq }}"
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
                                                                        <span>HPS / Pagu</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="hps-pagu" name="hps-pagu"
                                                                        value="{{ $proyek->hps_pagu }}"
                                                                        placeholder="HPS / Pagu" />
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
                                                            </div>
                                                            <!--End begin::Col-->
                                                            <div class="col-3">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Porsi JO (<i class="bi bi-percent text-dark"></i>) <i class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="number" min="1" max="100"
                                                                        class="form-control form-control-solid"
                                                                        id="porsi-jo" name="porsi-jo"
                                                                        value="{{ $proyek->porsi_jo }}"
                                                                        placeholder="Porsi JO" readonly/>
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
                                                                                        {{ $porsi->company_jo }}
                                                                                    </td>
                                                                                    <!--end::Column-->
                                                                                    <!--begin::Column-->
                                                                                    <td>
                                                                                        {{ $porsi->porsi_jo }}<i class="bi bi-percent text-dark"></i>
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


                                                        <!--Begin::Title Biru Form: Document Prakualifikasi-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Document Prakualifikasi
                                                        </h3>
                                                        <br>
                                                        <div class="w-50">
                                                            <input type="file" class="form-control form-input-solid" name="dokumen-prakualifikasi" accept=".docx, .doc, .xlsx, .xls, .pdf">
                                                        </div>
                                                        <br>
                                                        <!--begin::Table-->
                                                        <table
                                                            class="table align-middle table-row-dashed w-50 fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="w-auto">Nama Document</th>
                                                                    <th class="w-auto">Dibuat Pada Tanggal</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @foreach ($proyek->DokumenPrakualifikasi as $dokumen_prakualifikasi)
                                                                    <tr>
                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            <a href="/document/view/{{$dokumen_prakualifikasi->id_dokumen_prakualifikasi}}/{{$dokumen_prakualifikasi->id_document}}" class="text-hover-primary">{{$dokumen_prakualifikasi->nama_dokumen}}</a>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{Carbon\Carbon::parse($dokumen_prakualifikasi->created_at)->translatedFormat("d F Y")}}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Table-->
                                                        {{-- proyek/dokumen-prakualifikasi/upload --}}
                                                        <br>
                                                        <!--End::Title Biru Form: Document Prakualifikasi-->


                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Ketua Team Tender</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="ketua-tender" name="ketua-tender"
                                                                        value="{{ $proyek->ketua_tender }}"
                                                                        placeholder="Ketua Team Tender" />
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
                                                                                <th class="w-auto">Role/Jabatan</th>
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
                                                                                    <!--begin::Name-->
                                                                                    <td class="text-center">
                                                                                        {{ $no++ }}
                                                                                    </td>
                                                                                    <!--end::Name-->
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

                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        <br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        <br>
                                                        <div class="form-group">
                                                            <textarea class="form-control form-control-solid" id="laporan-prakualifikasi" name="laporan-prakualifikasi"
                                                                rows="3">{{ $proyek->laporan_prakualifikasi }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->


                                                    </div>
                                                    <!--end:::Tab pane Prakualifikasi-->



                                                    <!--begin:::Tab pane Tender Diikuti-->
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
                                                                        <span>Jadwal Tender</span>
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
                                                                        <span>Nilai Penawaran</span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="nilai-kontrak-penawaran"
                                                                        name="nilai-kontrak-penawaran"
                                                                        value="{{ $proyek->penawaran_tender }}"
                                                                        placeholder="Nilai Penawaran" />
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
                                                                        <span>HPS/Pagu Rupiah <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->hps_pagu == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->hps_pagu ?? '*HPS/Pagu Belum Ditentukan' }}"
                                                                        placeholder="HPS / Pagu" readonly />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->


                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        &nbsp;<br>
                                                        <div class="form-group">
                                                            <textarea class="form-control form-control-solid" id="laporan-tender" name="laporan-tender" rows="3">{{ $proyek->laporan_tender }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                    </div>
                                                    <!--end:::Tab pane Tender Diikuti-->


                                                    <!--begin:::Tab Perolehan-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_perolehan"
                                                        role="tabpanel">

                                                        <!--begin::Row-->
                                                        <div class="row fv-row">
                                                            <!--begin::Col-->
                                                            <div class="col-6">
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
                                                            </div>
                                                            <!--End begin::Col-->
                                                            <div class="col-6">
                                                                <!--begin::Input group Website-->
                                                                <div class="fv-row mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-bold form-label mt-3">
                                                                        <span>Nilai Penawaran <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $proyek->penawaran_tender == null ? 'text-danger' : '' }}"
                                                                        id="penawaran-perolehan"
                                                                        name="penawaran-perolehan"
                                                                        value="{{ $proyek->penawaran_tender ?? '*Nilai Penawaran Belum Ditentukan'}}"
                                                                        placeholder="Nilai Penawaran" readonly />
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
                                                                        <span>HPS/Pagu Rupiah <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->hps_pagu == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->hps_pagu ?? '*HPS/Pagu Belum Ditentukan' }}"
                                                                        placeholder="HPS / Pagu" readonly />
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
                                                                        <span>Nilai Perolehan</span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat"
                                                                        id="nilai-perolehan" name="nilai-perolehan"
                                                                        value="{{ $proyek->nilai_perolehan }}"
                                                                        placeholder="Nilai Perolehan" />
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
                                                                        <span><i class="bi bi-percent text-dark"></i> OE
                                                                            Wika</span>
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
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->

                                                        <!--Begin::Title Biru Form: List Peserta Tender-->
                                                        &nbsp;<br>
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
                                                                    <th class="w-auto"><i class="bi bi-percent"></i>OE</th>
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
                                                                            {{ $peserta->nilai_tender_peserta ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $peserta->oe_tender ?? "-" }}
                                                                        </td>
                                                                        <!--end::Column-->
                                                                        <!--begin::Column-->
                                                                        <td>
                                                                            {{ $peserta->status ?? "-" }}
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


                                                        <!--Begin::Title Biru Form: Laporan Kualitatif-->
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Laporan Kualitatif
                                                        </h3>
                                                        &nbsp;<br>
                                                        <div class="form-group">
                                                            <textarea class="form-control form-control-solid" id="laporan-perolehan" name="laporan-perolehan"
                                                                rows="3">{{ $proyek->laporan_perolehan }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Laporan Kualitatif-->

                                                    </div>
                                                    <!--end:::Tab Perolehan-->


                                                    <!--begin:::Tab Menang-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_menang"
                                                        role="tabpanel">

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
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="aspek-pesaing" name="aspek-pesaing"
                                                                        value="{{ $proyek->aspek_pesaing }}"
                                                                        placeholder="Aspek Pesaing" />
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
                                                                    <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        id="aspek-non-pesaing" name="aspek-non-pesaing"
                                                                        value="{{ $proyek->aspek_non_pesaing }}"
                                                                        placeholder="Aspek Non Pesaing" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End begin::Col-->
                                                        </div>
                                                        <!--End begin::Row-->


                                                        <!--Begin::Title Biru Form: Usulan Saran Perbaikan-->
                                                        <label class="fs-6 fw-bold form-label mt-3">
                                                            <span>Usulan Saran Perbaikan</span>
                                                        </label>
                                                        <div class="form-group">
                                                            <textarea class="form-control form-control-solid" id="saran-perbaikan" name="saran-perbaikan" rows="3">{{ $proyek->saran_perbaikan }}</textarea>
                                                        </div>
                                                        <!--End::Title Biru Form: Usulan Saran Perbaikan-->

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
                                                                        <span>No SPK External <i class="bi bi-journal-text"></i></span>
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
                                                                        value="{{ $proyek->jenis_proyek == 'I' ? 'Internal' : 'External' }}"
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
                                                                        <span>Porsi JO (<i class="bi bi-percent text-dark"></i>) <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid {{ $proyek->porsi_jo == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->porsi_jo ?? '*Porsi JO Belum Ditentukan' }}"
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
                                                                        value="{{ $proyek->tahun_ri_perolehan }}"
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
                                                                        value="{{ $proyek->nilai_valas_review ?? '*Nilai OK Review Belum Ditentukan' }}"
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
                                                                        <span>Mata Uang <i
                                                                                class="bi bi-lock"></i></span>
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
                                                                        <span>No Kontrak <i class="bi bi-journal-text"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div class="d-flex align-items-center position-relative">
                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                                        <span id="view-kontrak" class="svg-icon svg-icon-1 position-absolute ms-4">
                                                                            <a href="/contract-management/view/{{ $proyek->nomor_terkontrak }}" class="text-gray-800 text-hover-primary mb-1">{{ $proyek->nomor_terkontrak }}</a>
                                                                        </span>
                                                                        <input onclick="viewKontrak(this)" type="text" id="fake-terkontrak"
                                                                            class="form-control form-control-solid"
                                                                            value="" readonly/>
                                                                        <!--end::Svg Icon-->
                                                                        <input onfocusout="displayKontrak(this)" type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="nomor-terkontrak" name="nomor-terkontrak"
                                                                            value="{{ $proyek->nomor_terkontrak }}"
                                                                            placeholder="" style="display: none" />
                                                                    </div>
                                                                    <script>
                                                                        function viewKontrak(e) {
                                                                            document.getElementById('fake-terkontrak').style.display = "none";
                                                                            document.getElementById('view-kontrak').style.display = "none";
                                                                            document.getElementById('nomor-terkontrak').style.display = "";
                                                                            // e.value = "{{ $proyek->nomor_terkontrak }}";
                                                                        }
                                                                        function displayKontrak(e) {
                                                                            document.getElementById('view-kontrak').style.display = "";
                                                                            document.getElementById('view-kontrak').innerHTML = e.value;
                                                                            document.getElementById('fake-terkontrak').style.display = "";
                                                                            document.getElementById('nomor-terkontrak').style.display = "none";
                                                                            // console.log(e);
                                                                        }
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
                                                                    $nilaiPerolehan = (int) str_replace(',', '', $proyek->nilai_perolehan);
                                                                    $kontrakKeseluruhan = ($nilaiPerolehan * 100) / $proyek->porsi_jo;
                                                                    $nilaiKontrakKeseluruhan = number_format($kontrakKeseluruhan, 0, ',', ',');
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
                                                                        id="nilai-kontrak-keseluruhan" name="nilai-kontrak-keseluruhan"
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
                                                                        <span>Tanggal Mulai Kontrak <i class="bi bi-journal-text"></i></span>
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
                                                                        <span>Nilai Kontrak (Porsi WIKA) <i class="bi bi-journal-text"></i> <i
                                                                                class="bi bi-lock"></i></span>
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text"
                                                                        class="form-control form-control-solid reformat {{ $proyek->nilai_perolehan == null ? 'text-danger' : '' }}"
                                                                        value="{{ $proyek->nilai_perolehan ?? '*Nilai Perolehan Belum Ditentukan' }}"
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
                                                                        <span>Tanggal Akhir Kontrak <i class="bi bi-journal-text"></i></span>
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
                                                                        id="tanggal-selesai-kontrak"
                                                                        name="tanggal-selesai-kontrak"
                                                                        value="{{ $proyek->tanggal_selesai_terkontrak }}"
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
                                                                        <option value="Cost-Plus" {{ $proyek->jenis_terkontrak == 'Cost-Plus' ? 'selected' : '' }}>Cost-Plus</option>
                                                                        <option value="Design & Build" {{ $proyek->jenis_terkontrak == 'Design & Build' ? 'selected' : '' }}>Design & Build</option>
                                                                        <option value="Lumpsum" {{ $proyek->jenis_terkontrak == 'Lumpsum' ? 'selected' : '' }}>Lumpsum</option>
                                                                        <option value="OM" {{ $proyek->jenis_terkontrak == 'OM' ? 'selected' : '' }}>OM</option>
                                                                        <option value="Turnkey" {{ $proyek->jenis_terkontrak == 'Turnkey' ? 'selected' : '' }}>Turnkey</option>
                                                                        <option value="Unit Price" {{ $proyek->jenis_terkontrak == 'Unit Price' ? 'selected' : '' }}>Unit Price</option>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                            </div>
                                                            <!--End::Col-->
                                                        </div>
                                                        <!--End::Row Kanan+Kiri-->

                                                    </div>
                                                    <!--end:::Tab Pasar Terkontrak New-->


<!--begin::-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_approval"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: Approval-->
                                                        &nbsp;<br>
                                                            <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Approval (user interface)
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_create_namemodal"> </a>
                                                        </h3>
                                                        &nbsp;<br>
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
                                                        &nbsp;<br>
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Approval (Head interface)
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal"> </a>
                                                        </h3>
                                                        &nbsp;<br>
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
                                                                                id="customer_new_save"
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

<!--begin:::Tab Feedback-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_feedback"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: Feed back-->
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">Proyek Feedback
                                                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_feedback">+</a>
                                                        </h3>
                                                        &nbsp;<br>
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
<!--end:::Tab Feedback-->


<!--begin:::Tab Forecast-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_forecast"
                                                        role="tabpanel">

                                                        <!--Begin::Title Biru Form: History-->
                                                        &nbsp;<br>
                                                        <h3 class="fw-bolder m-0" id="HeadDetail"
                                                            style="font-size:14px;">History Forecast</h3>
                                                        &nbsp;<br>
                                                        <!--End::Title Biru Form: List History-->

                                                        {{-- begin::Detail History Forecast --}}
                                                        <div class="d-flex flex-row-reverse mb-5">
                                                            <div>
                                                                Periode Prognosa
                                                                @php
                                                                    setlocale(LC_TIME, 'id.UTF-8');
                                                                    $periode_prognosa = count($historyForecast) > 0 ? strftime('%B', mktime(0, 0, 0, $historyForecast[0]->periode_prognosa)) : 'Belum Dibuat';
                                                                @endphp
                                                                <b class="mx-4">{{ $periode_prognosa }}</b>
                                                            </div>
                                                        </div>
                                                        {{-- end::Detail History Forecast --}}

                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2"
                                                            id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-auto">Nama Proyek</th>
                                                                    <th class="min-w-auto">Nilai OK</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                @for ($i = 0; $i < 12; $i++)
                                                                    <tr>

                                                                        <!--begin::Name-->
                                                                        <td>
                                                                            <h6 class="text-gray-600 fw-light">
                                                                                {{ $proyek->nama_proyek }}</h6>
                                                                        </td>
                                                                        <!--end::Name-->
                                                                        @if (count($historyForecast) > 0)
                                                                            @foreach ($historyForecast as $history)
                                                                                @if ($i + 1 == $history->periode_prognosa)
                                                                                    <!--begin::Nilai OK-->
                                                                                    <td class="text-dark">
                                                                                        {{ $proyek->nilai_rkap }}
                                                                                    </td>
                                                                                    <!--end::Nilai OK-->
                                                                                @break

                                                                            @else
                                                                                <!--begin::Nilai OK-->
                                                                                <td class="text-dark">
                                                                                    0
                                                                                </td>
                                                                                <!--end::Nilai OK-->
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <!--begin::Nilai OK-->
                                                                    <td class="text-dark">
                                                                        0
                                                                    </td>
                                                                    <!--end::Nilai OK-->
                                                                @endif

                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
<!--end:::Tab Forecast-->


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
<!--begin::modal ADD PESERTA TENDER-->
<form action="/proyek/peserta-tender/add" method="post" enctype="multipart/form-data">
@csrf
<input type="hidden" name="tender-kode-proyek" value="{{ $proyek->kode_proyek }}">
<div class="modal fade" id="kt_modal_peserta_tender" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Tambah List Peserta Tender :</h2>
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
                                <span>Nama Peserta Tender</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="peserta-tender" name="peserta-tender" class="form-select form-select-solid"
                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Team">
                                <option></option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->name }}"> {{ $customer->name }}</option>
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
                                <span>Nilai Penawaran</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid reformat" id="nilai-tender"
                                name="nilai-tender" placeholder="Nilai Penawaran" />
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
                                <span><i class="bi bi-percent text-dark"></i> OE</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid reformat" id="oe-tender"
                                name="oe-tender" placeholder="% OE" />
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
                                <span>Status</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" id="status-tender"
                                name="status-tender" placeholder="Status" />
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
<!--end::modal ADD PESERTA TENDER-->

<!--begin::DELETE PESERTA TENDER-->
@foreach ($pesertatender as $peserta)
<form action="/proyek/peserta-tender/delete/{{ $peserta->id }}" method="post" enctype="multipart/form-data">
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
                <h2>Assign Team untuk proyek : {{ $proyek->nama_proyek }}</h2>
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
                                <span>Team Proyek</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="nama-team" class="form-select form-select-solid"
                                data-control="select2" data-hide-search="true" data-placeholder="Pilih Team">
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
                                <span>Role/Jabatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" id="role-team"
                                name="role-team" placeholder="Role/Jabatan" />
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
</form>
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
                <h2>Porsi JO : </h2>
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
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            @php
                                $joCompany = 0;
                                foreach ($porsiJO as $porsi) {
                                    if ($porsi->count() > 0) {
                                        $joCompany += $porsi->porsi_jo;
                                    }
                                }
                            @endphp
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span><b id="max-porsi" value="{{ $proyek->porsi_jo }}">Max Porsi JO : {{ $proyek->porsi_jo }}% </b></span>
                            </label>
                            <!--end::Label-->
                            <br>
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span><b>Sisa Porsi JO : {{ $proyek->porsi_jo }} - </b>
                                    <b id="selisih-porsi">0</b>
                                    <b id="sisa-porsi"> = {{ $proyek->porsi_jo }}%</b></span>
                            </label>
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
                        // console.log(maxJO);
                        // console.log(porsiJO.value);
                        document.getElementById("selisih-porsi").innerHTML = porsiJO.value;
                        document.getElementById("sisa-porsi").innerHTML = " = " + sisaJO + "%";
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
                    <h2>Hapus : {{ $porsi->company_jo }} - {{ $porsi->porsi_jo }}%
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
                        <span>Peringkat :&nbsp;&nbsp;</span>
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
                                id="exampleFormControlTextarea1" rows="3">{{ $proyek->laporan_kualitatif_pasdin }}</textarea>
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
{{-- <script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></scrip> --}}
@section('js-script')
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
