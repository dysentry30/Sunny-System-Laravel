@extends('template.main')
<style>
    input[type="date"]::-webkit-input-placeholder {
        visibility: hidden !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        display: none;
    }
    #detailProyek .form-control.form-control-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 0px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: #eff2f5 !important;
    }

    #detailProyek .form-select.form-select-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 0px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: #eff2f5 !important;
    }
</style>
@empty($contract)
    @section('title', 'New Contract')
@else
@section('title', 'View Contract')
@endempty
@section('content')

<!--begin::Root-->
<div class=" d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        {{-- @extends('template.aside') --}}
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

            <!--begin::Header-->
            @include('template.header')
            <!--end::Header-->

            @if (!isset($contract))

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    <form action="/contract-management/save" method="post">
                        @csrf
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
                                <div class="row g-7">

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
                                                                <span class="required">No. Contract</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text"
                                                                class="form-control form-control-solid"
                                                                id="number-contract" name="number-contract"
                                                                value="{{ old('number-contract') }}"
                                                                placeholder="No. Contract" />
                                                            @error('number-contract')
                                                                <h6>
                                                                    <b
                                                                        style="color: rgb(209, 38, 38)">{{ $message }}</b>
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
                                                                <span class="required">Proyek</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="project-id" id="project-id"
                                                                class="form-select form-select-solid"
                                                                data-control="select2" data-hide-search="true"
                                                                data-placeholder="Pilih Proyek">
                                                                <option value=""></option>
                                                                @foreach ($projects as $project)
                                                                    <option value="{{ $project->kode_proyek }}"
                                                                        {{ old('project-id') == $project->kode_proyek ? 'selected' : '' }}>
                                                                        {{ $project->nama_proyek }}</option>
                                                                @endforeach
                                                            </select>

                                                            <!--end::Input-->
                                                        </div>
                                                        @error('project-id')
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
                                                            <!--end::Label-->
                                                            <!--begin::Input-->

                                                            <!--<a href="#" class="btn btn-sm mx-3"-->
                                                            <!--    style="background: transparent;width:1rem;height:2.3rem;"-->
                                                            <!--    data-bs-toggle="modal"-->
                                                            <!--    data-bs-target="#kt_modal_calendar-start"><i-->
                                                            <!--        class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"-->
                                                            <!--        style="color: #008CB4"></i></a>-->
                                                            <a class="btn btn-sm" href="#"
                                                                style="background: transparent; width:1rem;height:2.3rem"
                                                                onclick="showCalendarModal(this)" id="start-date-modal">
                                                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                    style="color: #008CB4"></i>
                                                            </a>
                                                            <input type="Date"
                                                                class="form-control form-control-solid ps-12"
                                                                placeholder="Select a date"
                                                                value="{{ old('start-date') }}" name="start-date"
                                                                id="start-date" />

                                                            @error('start-date')
                                                                <h6>
                                                                    <b
                                                                        style="color: rgb(209, 38, 38)">{{ $message }}</b>
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
                                                                <span>Tanggal Berakhir Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <a href="#" class="btn btn-sm mx-3"
                                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_calendar-end"><i
                                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                    style="color: #008CB4"></i></a>
                                                            <input type="Date"
                                                                class="form-control form-control-solid ps-12"
                                                                value="{{ old('due-date') }}"
                                                                placeholder="Select a date" id="due-date"
                                                                name="due-date" />
                                                            @error('due-date')
                                                                <h6>
                                                                    <b
                                                                        style="color: rgb(209, 38, 38)">{{ $message }}</b>
                                                                </h6>
                                                            @enderror
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                    <!--End begin::Col-->
                                                </div>


                                                <div class="row fv-row">
                                                    <!--begin::Col-->
                                                    <div class="col-6">
                                                        <!--begin::Input group Website-->
                                                        <div class="fv-row mb-7">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mt-3">
                                                                <span>No. SPK</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->

                                                            <input type="text"
                                                                class="form-control form-control-solid"
                                                                name="number-spk" id="number-spk"
                                                                value="{{ old('number-spk') }}"
                                                                placeholder="No. SPK" />
                                                            @error('number-spk')
                                                                <h6>
                                                                    <b
                                                                        style="color: rgb(209, 38, 38)">{{ $message }}</b>
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
                                                                <span>Nilai Kontrak</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="decimal" id="value-contract"
                                                                class="form-control form-control-solid"
                                                                onkeyup="reformatNumber(this)" name="value"
                                                                value="{{ old('value') }}"
                                                                placeholder="Nilai Kontrak" />
                                                            @error('value')
                                                                <h6>
                                                                    <b
                                                                        style="color: rgb(209, 38, 38)">{{ $message }}</b>
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
<!--end::Contacts App- Edit Contact-->
</div>
<!--end::Container-->
</div>
<!--end::Post-->


</div>
<!--end::Content-->
</form>
@else
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0 !important;">
    <form action="/contract-management/update" method="post">
        @csrf
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
                <div class="row g-7">

                    <!--begin::Header Contract-->
                    <div class="col-xl-15">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <div class="card-body pt-5" style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                <div class="form-group">

                                    <div id="stage-button" class="stage-list">
                                        {{-- <a href="#" role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Perolehan
                                        </a> --}}
                                        <a href="#" role="link" class="stage-button color-is-default"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="Masuk ke <b>Perolehan</b> ketika <b>Proyek di CRM belum terkontrak</b>"
                                            style="outline: 0px; cursor: not-allowed;">
                                            Perolehan
                                        </a>
                                        <a href="#" role="link" class="stage-button color-is-default"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" data-bs-title="Masuk ke <b>Pelaksanaan</b> secara otomatis ketika <b>Proyek di CRM sudah terkontrak</b>"
                                            style="outline: 0px; cursor: not-allowed;">
                                            Pelaksanaan
                                        </a>
                                        {{-- <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract"
                                            role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Addendum Kontrak
                                        </a> --}}
                                        {{-- <a href="#" role="link" class="stage-button color-is-default"
                                            style="outline: 0px; cursor: pointer;">
                                            Serah Terima Pekerjaan
                                        </a> --}}
                                        <a href="#" role="link" class="stage-button color-is-default"
                                            style="outline: 0px;">
                                            Pemeliharaan
                                        </a>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- begin:: Stages script --}}
                    <script>
                        const stages = document.querySelectorAll(".stage-button");
                        stages.forEach((stage, i) => {
                            stage.setAttribute("stage", i + 1);
                            if (i + 1 <= Number("{{ $contract->stages }}")) {
                                stage.classList.add("stage-is-done");
                                stage.style.cursor = "cursor";
                            } else {
                                stage.classList.add("stage-is-not-active");
                                stage.style.cursor = "cursor";
                                if (i > Number("{{ $contract->stages }}")) {
                                    stage.style.cursor = "not-allowed";
                                    stage.style.pointerEvents = "none";
                                }

                            }
                            if (stage.innerText == "Pemeliharaan") {

                                stage.addEventListener("click", async e => {
                                    e.stopPropagation();
                                    Swal.fire({
                                        title: '',
                                        text: "Yakin Pindah Stage",
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
                                            // formData.append("id", "");
                                            formData.append("id_contract",
                                                "{{ $contract->id_contract }}");
                                            const setStage = await fetch("/stage/save", {
                                                method: "POST",
                                                body: formData
                                            }).then(res => res.json());
                                            if (setStage.link) {
                                                // window.location.href = setStage.link;
                                                window.location.reload();
                                            }
                                        }
                                    });
                                });
                            }
                        });
                    </script>
                    {{-- end:: Stages script --}}
                    <!--end::Header Contract-->
                    <!--begin::Header Contract-->
                    <div class="px-10" style="margin-bottom: 2rem;">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <div class="card-body pt-5">

                                <!--begin::Row-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        {{-- @dd($contract) --}}
                                        <!--begin::Input group Name-->
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">No. Contract: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                {{-- <b>{{ urldecode(urldecode($contract->id_contract)) ?? '' }}</b> --}}
                                                <b>{{ $contract->no_contract ?? '' }}</b>
                                            </div>
                                        </div>
                                        <!--end::Input group Name-->
                                    </div>
                                    <!--begin::Col-->
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-5">
                                                <span class="">Proyek: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ $contract->project->nama_proyek ?? '' }}</b>
                                            </div>
                                        </div>
                                        <!--begin::Input group Website-->
                                        <!--begin::Input group Name-->
                                        <!--end::Input group Name-->
                                    </div>
                                </div>


                                <div class="row fv-row my-5">

                                    <div class="d-flex align-items-center">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Input group Website-->

                                            <!--begin::Input group Name-->
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">Tanggal Mulai Kontrak: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ Carbon\Carbon::parse($contract->contract_in)->translatedFormat('d F Y') }}</b>
                                                </div>
                                            </div>
                                            <!--end::Input group Name-->
                                        </div>
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">Tanggal Berakhir Kontrak: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ Carbon\Carbon::parse($contract->contract_out)->translatedFormat('d F Y') }}</b>
                                                </div>
                                            </div>
                                            <!--begin::Input group Website-->
                                            <!--begin::Input group Name-->
                                            <!--end::Input group Name-->
                                        </div>
                                    </div>
                                </div>


                                <div class="row fv-row mb-5">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Col-->
                                        <div class="col">
                                            <!--begin::Input group Website-->

                                            <!--begin::Input group Name-->
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">No. SPK: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ $contract->project->nospk_external ?? 0 }}</b>
                                                </div>
                                            </div>
                                            <!--end::Input group Name-->
                                        </div>
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">Nilai Kontrak Awal: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ number_format($contract->project->nilai_rkap ?? 0, 0, '.', '.') }}</b>
                                                </div>
                                            </div>
                                            <!--begin::Input group Website-->
                                            <!--begin::Input group Name-->
                                            <!--end::Input group Name-->
                                        </div>
                                    </div>


                                </div>
                                <div class="fv-row">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <!--begin::Input group Website-->

                                            <!--begin::Input group Name-->
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">Unit Kerja: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ $contract->project->UnitKerja->unit_kerja }}</b>
                                                </div>
                                            </div>
                                            <!--end::Input group Name-->
                                        </div>
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="col-5 text-end me-5">
                                                    <span class="">Nilai Kontrak Review: </span>
                                                </div>
                                                <div class="text-dark text-start">
                                                    <b>{{ number_format($contract->project->nilaiok_review ?? 0, 0, '.', '.') }}</b>
                                                </div>
                                            </div>
                                            <!--begin::Input group Website-->
                                            <!--begin::Input group Name-->
                                            <!--end::Input group Name-->
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col text-end">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#detailProyek">Detail Proyek</button>
                                    </div>
                                </div>
                                <!--End begin::Col-->
                                {{-- <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-6">
                                                <span class="">Sumber Dana: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{ $contract->project->sumber_dana ?? '-' }}</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <div class="col-5 text-end me-3 ">
                                                <span class="">Tipe Proyek: </span>
                                            </div>
                                            <div class="text-dark text-start">
                                                <b>{{App\Models\JenisProyek::find($contract->project->jenis_proyek)->jenis_proyek}}</b>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <h6 id="status-msg" style="display: none"></h6>

                            <!--End begin::Row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!--end::Header Contract-->
</form>
<!--begin::Content-->
<div class="col-xl-15 mx-6">
    <!--begin::Contacts-->
    <div class="card card-flush" id="kt_contacts_main">

        <!--begin::Card body-->
        <div class="card-body pt-5">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                <!--begin:::Tab item Informasi Perusahaan-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 ms-6 active" data-bs-toggle="tab"
                        href="#kt_user_view_overview_tab" style="font-size:14px;">Perolehan</a>
                </li>
                <!--end:::Tab item Informasi Perusahaan-->

                {{-- @if ($contract->stages > 0)
                    <!--begin:::Tab item History-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 ms-6" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_overview_history" style="font-size:14px;">Terkontrak</a>
                    </li>
                    <!--end:::Tab item History-->
                @endif --}}

                @if ($contract->stages > 1)
                    <!--begin:::Tab item Atachment & Notes-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 ms-6" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_overview_Performance" style="font-size:14px;">Pelaksanaan</a>
                    </li>
                    <!--end:::Tab item Atachment & Notes-->

                @endif

                @if ($contract->stages > 2)
                    <!--begin:::Tab item Atachment & Notes-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 ms-6" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_overview_SerahTerima" style="font-size:14px;">Pemeliharaan</a>
                    </li>
                    <!--end:::Tab item Atachment & Notes-->

                @endif

                @if ($contract->stages > 3)
                    <!--begin:::Tab item Atachment & Notes-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_overview_penutupan_proyek" style="font-size:14px;">Penutupan
                            Proyek</a>
                    </li>
                    <!--end:::Tab item Atachment & Notes-->

                @endif

            </ul>
            <!--end:::Tabs-->

            <!--begin:::Tab content -->
            <div class="tab-content" id="myTabContent">
                <!--Informasi Perusahaan-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">

                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        {{-- <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Rekomendasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="rekomendasi-1" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Rekomendasi">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div> --}}
                        <!--End begin::Col-->
                        <div class="col">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->

                    <!--begin::Card title-->
                    <div class="card-title m-0">

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Aanwitjzing
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_question_proyek">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Item</th>
                                    <th class="min-w-125px">Sub Pasal</th>
                                    <th class="min-w-125px">Daftar Pertanyaan</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->questionsProjects as $questionProject)
                                        @if ($questionProject->tender_menang == 0)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    {{ $questionProject->item }}
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    {{ $questionProject->sub_pasal }}
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    {{ $questionProject->daftar_pertanyaan }}
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                        {{ date_format(new DateTime($questionProject->created_at), 'd M, Y') }}</a>
                                                </td>
                                                <!--end::Kode=-->
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        <br><br>

                        {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Draft Kontrak
                            <a href="/contract-management/view/{{ url_encode($contract->id_contract) }}/draft-contract"
                                Id="Plus">+</a>
                        </h3>

                        <!--begin:Table: Draft Contract-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->draftContracts as $draftContract)
                                        @if ($draftContract->tender_menang == 0)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $draftContract->id_draft }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $draftContract->title_draft }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $draftContract->id_document }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                        {{ date_format(new DateTime($draftContract->created_at), 'd M, Y') }}</a>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>{{ $draftContract->draft_note }}
                                                </td>
                                                <!--end::Unit=-->

                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Draft Contract--> --}}


                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Review
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_create_review">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Draft Contract Review</th>
                                    <th class="min-w-125px">Ketentuan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->reviewProjects as $reviewProject)
                                        @if ($reviewProject->stage == 1)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <a href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $reviewProject->id_draft_contract }}"
                                                        target="_blank">
                                                        <p>{{ $reviewProject->draftContract->title_draft }}</p>
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p>{{ $reviewProject->ketentuan }}</p>
                                                </td>
                                                <!--end::Name=-->
                                            </tr>
                                        @endif

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->


                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Input Resiko
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Verifikasi</th>
                                    <th class="min-w-125px">Kategori</th>
                                    <th class="min-w-125px">Kriteria</th>
                                    <th class="min-w-125px">Probis Level 1 - 2</th>
                                    <th class="min-w-125px">Probis Yang Terganggu</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if ($contract->inputRisks->contains('stage', 0))
                                    @forelse ($contract->inputRisks as $inputRisk)
                                        @if ($inputRisk->stage == 0)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->verifikasi }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kategori }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kriteria }}</p>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_1_2 }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_terganggu }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        <br>
                        
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen NDA
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                {{-- @if ($contract->inputRisks->contains('stage', 0))
                                    @forelse ($contract->inputRisks as $inputRisk)
                                        @if ($inputRisk->stage == 0)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->resiko }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->penyebab }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->dampak }}</p>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->mitigasi }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif --}}
                                @forelse ($contract->project->DokumenNda as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center"><b>There is no data</b></td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        <br>
                        <br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen MoU
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenMou as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        <br><br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen ECA
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenEca as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        <br><br>


                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen ICA
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenIca as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        <br><br>
                        
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen ITB / TOR
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenItbTor as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <br><br>
                        <!--End:Table: Review-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen RKS / Project Spesification
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenRks as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <br><br>
                        <!--End:Table: Review-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Draft Kontrak
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->DokumenDraft as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_dokumen}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        
                        <br><br>

                        <!--End:Table: Review-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen LOI
                            <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Upload dokumen ini ada di <b>CRM Detail Proyek</b>"
                            data-bs-html="true"></i>
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_risk_proyek">+</a> --}}
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->project->AttachmentMenang as $nda)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset("/words/$nda->id_document.pdf")}}" class="text-hover-primary">{{$nda->nama_attachment}}</a>
                                        </td>
                                        <td>
                                            {{Carbon\Carbon::createFromTimeString($nda->created_at)->translatedFormat("d F Y")}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <b>There is no data</b>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        
                        <br><br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                Usulan Perubahan Draft Kontrak
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_usulan_perubahan_draft_kontrak">+</a>
                            </h3>

                            <!--begin:Table: Review-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Isu</th>
                                        <th class="min-w-125px">Deskripsi Klausul Awal</th>
                                        <th class="min-w-125px">Usulan Perubahan</th>
                                        <th class="min-w-125px">Keterangan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @if ($contract->UsulanPerubahanDraft->contains('kategori', 1))
                                        <tr>
                                            <td colspan="5" class= "px-4 text-bg-dark">
                                                <b>Surat Perjanjian Kontrak</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                                @php
                                                    $pasals = collect(explode("|", $perubahan_draft->pasal_perbaikan));
                                                @endphp
                                                @if ($perubahan_draft->kategori == 1)
                                                    <td>{{$perubahan_draft->isu}}</td>
                                                    <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                    <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                    <td>{{$perubahan_draft->keterangan}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif

                                    @if ($contract->UsulanPerubahanDraft->contains('kategori', 2))
                                        <tr>
                                            <td colspan="5" class= "px-4 text-bg-dark">
                                                <b>Syarat-syarat Umum Kontrak (SSUK)</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                                @php
                                                    $pasals = collect(explode("|", $perubahan_draft->pasal_perbaikan));
                                                @endphp
                                                @if ($perubahan_draft->kategori == 2)
                                                    <td>{{$perubahan_draft->isu}}</td>
                                                    <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                    <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                    <td>{{$perubahan_draft->keterangan}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif

                                    @if ($contract->UsulanPerubahanDraft->contains('kategori', 3))
                                        <tr>
                                            <td colspan="5" class= "px-4 text-bg-dark">
                                                <b>Syarat-syarat Khusus Kontrak (SSKK)</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                                @php
                                                    $pasals = collect(explode("|", $perubahan_draft->pasal_perbaikan));
                                                @endphp
                                                @if ($perubahan_draft->kategori == 3)
                                                    <td>{{$perubahan_draft->isu}}</td>
                                                    <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                    <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                    <td>{{$perubahan_draft->keterangan}}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Review-->
                    </div>
                    
                {{-- </div>
                <!--end:::Tab pane Informasi Perusahaan-->

                <!--begin:::Tab pane History-->
                <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel"> --}}

                    <!--begin::Row-->
                    <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Rekomendasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="rekomendasi-2" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Rekomendasi">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                        <div class="col-6">

                            <div class="fv-row mb-7">

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--End begin::Col-->
                    </div>
                    <!--End begin::Row-->

                    &nbsp;<br>
                    &nbsp;<br>

                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Kontrak
                            <a href="/contract-management/view/{{ url_encode($contract->id_contract) }}/draft-contract/tender-menang/1"
                                Id="Plus">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->draftContracts as $draftContract)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $draftContract->id_draft }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $draftContract->title_draft }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $draftContract->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                    {{ date_format(new DateTime($draftContract->created_at), 'd M, Y') }}</a>
                                                </a>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>{{ $draftContract->draft_note }}
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Review-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Review
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_review_menang">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Draft Contract Review</th>
                                    <th class="min-w-125px">Ketentuan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->reviewProjects as $reviewProject)
                                        @if ($reviewProject->stage >= 2)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <a href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $reviewProject->id_draft_contract }}"
                                                        target="_blank">
                                                        <p>{{ $reviewProject->draftContract->title_draft }}</p>
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p>{{ $reviewProject->ketentuan }}</p>
                                                </td>
                                                <!--end::Name=-->
                                            </tr>
                                        @endif

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Hasil Klarifikasi dan Negosiasi CDA
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_klarifikasi_negosiasi">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh</th>
                                    <th class="min-w-125px">Dibuat Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->KlarifikasiNegosiasiCDA))
                                    @php
                                        // dd($contract->KlarifikasiNegosiasiCDA);
                                    @endphp
                                    @forelse ($contract->KlarifikasiNegosiasiCDA as $klarifikasi_negosiasi)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $klarifikasi_negosiasi->id_klarifikasi }}/{{ $klarifikasi_negosiasi->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $klarifikasi_negosiasi->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $klarifikasi_negosiasi->User->name }}
                                                </p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($klarifikasi_negosiasi->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $klarifikasi_negosiasi->note }}</p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                        {{-- @if ($KlarifikasiNegosiasiCDA->tender_menang == 0)
                                            @endif --}}
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Kontrak Tanda Tangan
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_kontrak_bertandatangan">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh</th>
                                    <th class="min-w-125px">Dibuat Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->KontrakTandaTangan))
                                    @forelse ($contract->KontrakTandaTangan as $kontrak_tanda_tangan)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $kontrak_tanda_tangan->id_kontrak_bertandatangan }}/{{ $kontrak_tanda_tangan->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $kontrak_tanda_tangan->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $kontrak_tanda_tangan->User->name }}
                                                </p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($kontrak_tanda_tangan->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $kontrak_tanda_tangan->note }}</p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspa colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Review Pembatalan Kontrak
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_review_pembatalan">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh</th>
                                    <th class="min-w-125px">Dibuat Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->ReviewPembatalanKontrak))
                                    @forelse ($contract->ReviewPembatalanKontrak as $review_pembatalan_kontrak)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $review_pembatalan_kontrak->id_review_pembatalan_kontrak }}/{{ $review_pembatalan_kontrak->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $review_pembatalan_kontrak->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ $review_pembatalan_kontrak->User->name }}</p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($review_pembatalan_kontrak->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $review_pembatalan_kontrak->note }}
                                                </p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspa colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Perjanjian KSO
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_perjanjian_kso">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh</th>
                                    <th class="min-w-125px">Dibuat Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->PerjanjianKSO))
                                    @forelse ($contract->PerjanjianKSO as $perjanjian_kso)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $perjanjian_kso->id_perjanjian_kso }}/{{ $perjanjian_kso->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $perjanjian_kso->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $perjanjian_kso->User->name }}</p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($perjanjian_kso->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $perjanjian_kso->note }}</p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Input Resiko
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_resiko_menang">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Verifikasi</th>
                                    <th class="min-w-125px">Kategori</th>
                                    <th class="min-w-125px">Kriteria</th>
                                    <th class="min-w-125px">Probis Level 1 - 2</th>
                                    <th class="min-w-125px">Probis Yang Terganggu</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if ($contract->inputRisks->contains('stage', 1))
                                    @forelse ($contract->inputRisks as $inputRisk)
                                        @if ($inputRisk->stage == 1)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->verifikasi }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kategori }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kriteria }}</p>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_1_2 }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_terganggu }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Pendukung
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_dokumen_pendukung">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh</th>
                                    <th class="min-w-125px">Dibuat Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->DokumenPendukung))
                                    @forelse ($contract->DokumenPendukung as $dokumen_pendukung)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $dokumen_pendukung->id_dokumen_pendukung }}/{{ $dokumen_pendukung->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $dokumen_pendukung->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->User->name }}
                                                </p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($dokumen_pendukung->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->note }}</p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                    </div>
                </div>
                <!--end:::Tab pane History-->

                <!--begin:::Tab pane Laporan Bulanan-->
                <div class="tab-pane fade" id="kt_user_view_overview_Performance" role="tabpanel">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Laporan Bulanan
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_laporan_bulanan">+</a>
                        </h3>

                        <!--begin:Table: Laporan Bulanan-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
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
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                    @forelse ($contract->monthlyReports as $monthlyReport)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                    class="text-gray-600 {{ $classes }} text-hover-primary mb-1">
                                                    {{ $monthlyReport->document_name_report }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $monthlyReport->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                    {{ date_format(new DateTime($monthlyReport->created_at), 'd M, Y') }}</a>
                                                </a>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                {{ $monthlyReport->note_report }}
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Laporan Bulanan-->
                        <br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Change Request
                            <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract"
                                Id="Plus">+</a>
                        </h3>

                        <!--begin:Table: Addendum Kontrak-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Change Request</th>
                                    <th class="min-w-125px">Dibuat Oleh
                                    </th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract))
                                    @forelse ($contract->addendumContracts as $addendumContract)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract/{{ $addendumContract->id_addendum }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $addendumContract->no_addendum }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $addendumContract->created_by }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                    {{ date_format(new DateTime($addendumContract->created_at), 'd M, Y') }}</a>
                                                </a>
                                            </td>
                                            <!--end::Kode=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Addendum Kontrak-->
                        <br>


                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Klaim Kontrak
                            <a href="/claim-management/{{ $contract->project->kode_proyek }}/{{ urlencode(urlencode($contract->id_contract)) }}/new"
                                Id="Plus">+</a>
                        </h3>
                        <!--begin:Table: Claim Contract-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Klaim</th>
                                    <th class="min-w-125px">Dibuat Oleh
                                    </th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (isset($contract->project->ClaimManagements))
                                    @forelse ($contract->project->ClaimManagements as $claimManagement)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/claim-management/view/{{ $claimManagement->id_claim }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $claimManagement->id_claim }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $claimManagement->pic }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                    {{ date_format(new DateTime($claimManagement->tanggal_claim), 'd M, Y') }}</a>
                                                </a>
                                            </td>
                                            <!--end::Kode=-->


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Claim Contract-->

                        <br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            MoM Kick Off Meeting
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_mom_meeting">+</a>
                        </h3>
                        <!--begin:Table: Claim Contract-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nama Dokumen</th>
                                    <th class="min-w-125px">Dibuat Oleh
                                    </th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Catatan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->MoMMeeting))
                                    @forelse ($contract->MoMMeeting as $mom_meeting)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                <a target="_blank"
                                                    href="/document/view/{{ $mom_meeting->id_mom }}/{{ $mom_meeting->id_document }}"
                                                    class="text-gray-600 text-hover-primary mb-1">
                                                    {{ $mom_meeting->document_name }}
                                                </a>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $mom_meeting->User->name }}</p>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Kode=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">
                                                    {{ date_format(new DateTime($mom_meeting->created_at), 'd-m-Y') }}
                                                </p>
                                            </td>
                                            <!--end::Kode=-->
                                            <!--begin::Unit=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $mom_meeting->note }}</p>
                                            </td>
                                            <!--end::Unit=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Claim Contract-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Input Resiko
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_resiko_pelaksanaan">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Verifikasi</th>
                                    <th class="min-w-125px">Kategori</th>
                                    <th class="min-w-125px">Kriteria</th>
                                    <th class="min-w-125px">Probis Level 1 - 2</th>
                                    <th class="min-w-125px">Probis Yang Terganggu</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if ($contract->inputRisks->contains('stage', 3))
                                    @forelse ($contract->inputRisks as $inputRisk)
                                        @if ($inputRisk->stage == 3)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->verifikasi }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kategori }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->kriteria }}</p>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_1_2 }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $inputRisk->probis_terganggu }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        <br><br>
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Rencana Kerja Manajemen Kontrak
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_rencana_kerja_kontrak">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">Ketentuan</th>
                                    <th class="min-w-125px">Informasi Kelengkapan <i>Check List</i> ADKON</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if ($contract->RencanaKerjaManajemen->count() > 0)
                                    @forelse ($contract->RencanaKerjaManajemen as $key => $rencana_kerja)
                                        <tr>
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $key + 1 }}</p>
                                            </td>
                                            <!--begin::Name=-->
                                            <td>
                                                <pre class="text-gray-600 mb-1" style="font-family: 'Khula';">{!! $rencana_kerja->ketentuan_rencana_kerja !!}</pre>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <pre class="text-gray-600 mb-1" style="font-family: 'Khula';">{!! $rencana_kerja->informasi_lengkap_adkon !!}</pre>
                                            </td>
                                            <!--end::Name=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Review-->
                        <br><br>
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Pasal Kontraktual
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_pasal_kontraktual">+</a>
                        </h3>

                        <!--begin:Table: Pasal Kontraktual-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-125px">Ketentuan</th>
                                    <th class="min-w-125px">Informasi Kelengkapan <i>Check List</i> ADKON</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if ($contract->RencanaKerjaManajemen->count() > 0)
                                    @forelse ($contract->RencanaKerjaManajemen as $key => $rencana_kerja)
                                        <tr>
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ $key + 1 }}</p>
                                            </td>
                                            <!--begin::Name=-->
                                            <td>
                                                <pre class="text-gray-600 mb-1" style="font-family: 'Khula';">{!! $rencana_kerja->ketentuan_rencana_kerja !!}</pre>
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Name=-->
                                            <td>
                                                <pre class="text-gray-600 mb-1" style="font-family: 'Khula';">{!! $rencana_kerja->informasi_lengkap_adkon !!}</pre>
                                            </td>
                                            <!--end::Name=-->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Pasal Kontraktual-->

                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Perubahan Kontrak
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_perubahan_kontrak">+</a>
                        </h3>

                        <!--begin:Table: Perubahan Kontrak-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">Jenis Perubahan</th>
                                    <th class="min-w-50px">Tanggal Perubahan</th>
                                    <th class="min-w-125px">Uraian Perubahan</th>
                                    <th class="min-w-125px">Jenis Dokumen</th>
                                    <th class="min-w-125px">No Surat / Instruksi Owner</th>
                                    <th class="min-w-125px">No Proposal Klaim</th>
                                    <th class="min-w-125px">Tanggal Pengajuan</th>
                                    <th class="min-w-125px">Biaya Pengajuan</th>
                                    <th class="min-w-125px">Waktu Pengajuan</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @forelse ($contract->PerubahanKontrak as $key => $pk)
                                    <tr>
                                        <td>
                                            <a href="/contract-management/view/{{url_encode($contract->id_contract)}}/perubahan-kontrak/{{$pk->id_perubahan_kontrak}}" class="text-gray-600 mb-1">{{ $pk->jenis_perubahan }}</a>
                                        </td>
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->tanggal_perubahan !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->uraian_perubahan !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->jenis_dokumen !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->instruksi_owner !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->proposal_klaim !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->tanggal_pengajuan !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! number_format($pk->biaya_pengajuan, 0, ".", ".") !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                        <!--begin::Name=-->
                                        <td>
                                            <pre class="text-gray-600 mb-1" style="font-family: 'BpmOpenSans-woff';">{!! $pk->waktu_pengajuan !!}</pre>
                                        </td>
                                        <!--end::Name=-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="fw-bolder">There is no data</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        <!--End:Table: Perubahan Kontrak-->

                        <br>
                        <!--Begin::Document Site Instruction-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Site Instruction
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_site_instruction">+</a>
                        </h3>
                        <!--begin:Table:Dokumen Site Instruction-->
                        
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                                                           
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                    @if (!empty($contract->SiteInstruction))
                                        @forelse ($contract->SiteInstruction as $site_instruction)
                                        <tr>
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$site_instruction->id_document) }}">
                                                    {{ $site_instruction->nomor_dokumen }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($site_instruction->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: BpmOpenSans-woff">{!! $site_instruction->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--End:Table: Dokumen Site Instruction-->
                        <br>
                        <!--End::Document Site Instruction-->

                        <!--Begin::Document Technical Form-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Technical Form
                            <a target="_blank" href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_technical_form">+</a>
                        </h3>
                        
                        <!--begin:: Table Dokumen Technical Form-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->TechnicalForm))
                                    @forelse ($contract->TechnicalForm as $technical_form)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$technical_form->id_document) }}">
                                                {{ $technical_form->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{ Carbon\Carbon::parse($technical_form->tanggal_dokumen)->translatedFormat("d F Y") }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $technical_form->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Technical Form-->
                        <br>
                        <!--End::Document Technical Form-->

                        <!--Begin::Document Technical Query-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Technical Query
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_technical_query">+</a>
                        </h3>
                        <!--begin:: Table Dokumen Technical Query-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->TechnicalQuery))
                                    @forelse ($contract->TechnicalQuery as $technical_query)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$technical_query->id_document) }}">
                                                {{ $technical_query->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{ Carbon\Carbon::parse($technical_query->tanggal_dokumen)->translatedFormat("d F Y")  }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $technical_query->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Technical Query-->
                        <br>
                        <!--End::Document Technical Query-->
                        
                        <!--Begin::Document Field Design Change-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Field Design Change
                            <a target="_blank" href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_field_design_change">+</a>
                        </h3>

                        <!--begin:: Table Dokumen Field Design Change-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->FieldChange))
                                    @forelse ($contract->FieldChange as $field_change)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$field_change->id_document) }}">
                                                {{ $field_change->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{ Carbon\Carbon::parse($field_change->tanggal_dokumen)->translatedFormat("d F Y") }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $field_change->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Field Design Change-->
                        <!--End::Document Field Design Change-->

                        <!--Begin::Document Contract Change Notice-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Contract Change Notice
                            <a target="_blank" href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_contract_change_notice">+</a>
                        </h3>

                        <!--begin:: Table Dokumen Contract Change Notice-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->ChangeNotice))
                                    @forelse ($contract->ChangeNotice as $change_notice)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$change_notice->id_document) }}">
                                                {{ $change_notice->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{ Carbon\Carbon::parse($change_notice->tanggal_dokumen)->translatedFormat("d F Y") }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $change_notice->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Table Dokumen Contract Change Notice-->
                        <!--End::Document Table Dokumen Contract Change Notice-->

                        <!--Begin::Document Contract Change Proposal-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Contract Change Proposal
                            <a target="_blank" href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_contract_change_proposal">+</a>
                        </h3>

                        <!--begin:: Table Dokumen Contract Change Proposal-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->ChangeProposal))
                                    @forelse ($contract->ChangeProposal as $change_proposal)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$change_proposal->id_document) }}">
                                                {{ $change_proposal->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{ Carbon\Carbon::parse($change_proposal->tanggal_dokumen)->translatedFormat("d F Y") }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $change_proposal->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Table Dokumen Contract Change Proposal-->
                        <!--End::Document Table Dokumen Contract Change Proposal-->

                        <!--Begin::Document Contract Change Order-->
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Dokumen Contract Change Order
                            <a target="_blank" href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_dokumen_contract_change_order">+</a>
                        </h3>

                        <!--begin:: Table Dokumen Contract Change Order-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">No. Dokumen</th>
                                    <th class="min-w-125px">Tanggal</th>
                                    <th class="min-w-125px">Uraian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $classes = '';
                                    if (isset($contract)) {
                                        $classes = 'form-control-solid';
                                    } else {
                                        $classes = 'border-bottom-dashed border-top-0 border-left-0 border-right-0';
                                    }
                                @endphp
                                @if (isset($contract))
                                @if (!empty($contract->ChangeOrder))
                                    @forelse ($contract->ChangeOrder as $change_order)
                                    <tr>
                                        <!--begin::Nomor Dokumen-->
                                        <td>
                                            <a target="_blank" href="{{ asset('words/'.$change_order->id_document) }}">
                                                {{ $change_order->nomor_dokumen }}
                                            </a>
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                            <!--begin::Nomor Dokumen-->
                                        <td>
                                            {{  Carbon\Carbon::parse($change_order->tanggal_dokumen)->translatedFormat("d F Y") }}
                                        </td>
                                        <!--end::Nomor Dokumen-->
                                        <!--begin::Uraian-->
                                        <td>
                                            <pre style="font-family: BpmOpenSans-woff">{!! $change_order->uraian_dokumen !!}</pre>
                                        </td>
                                        <!--end::Uraian-->
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end:: Table Dokumen Table Dokumen Contract Change Order-->
                        <!--End::Document Table Dokumen Contract Change Order-->
                    </div>
                </div>
                <!--end:::Tab pane Laporan Bulanan-->

                <!--begin:::Tab pane Serah Terima-->
                <div class="tab-pane fade" id="kt_user_view_overview_SerahTerima" role="tabpanel">
                    <div class="card-title m-0">
                        {{-- <form action="/contract-management/document-bast/upload" method="POST"
                            enctype="multipart/form-data"> --}}
                            @csrf
                            <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">
                            <div class="row">
                                <div class="col">
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Bast 1
                                        <a href="#" Id="Plus" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_bast_1">+</a>
                                    </h3>
                                    {{-- <input type="file" name="dokumen-bast-1" accept=".docx"
                                        class="form-control form-control-solid"> --}}
                                    {{-- @if (!empty($contract->dokumen_bast_1))
                                        <small>Lihat Dokumen Bast 1: 
                                            <a target="_blank" href="{{ asset('words/' . $contract->dokumen_bast_2 . '.docx') }}" class="text-gray-400 text-hover-primary">Klik disini</a>
                                        </small>
                                        <a target="_blank" class="text-gray-400 text-hover-primary"
                                            href="/document/view/{{ url_encode($contract->id_contract) }}/{{ $contract->dokumen_bast_1 }}">Klik disini</a></small>
                                    @else
                                        <small>Belum mendapatkan Dokumen Bast 1</small>
                                    @endif --}}
                                </div>
                                <div class="col">
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Bast 2
                                        <a href="#" Id="Plus" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_bast_2">+</a>
                                    </h3>
                                    {{-- @if (!empty($contract->dokumen_bast_1))
                                        <small>Lihat Dokumen Bast 2: 
                                            <a target="_blank" href="{{ asset('words/' . $contract->dokumen_bast_2 . '.docx') }}" class="text-gray-400 text-hover-primary">Klik disini</a>
                                        </small>
                                        <a target="_blank" class="text-gray-400 text-hover-primary"
                                            href="/document/view/{{ url_encode($contract->id_contract) }}/{{ $contract->dokumen_bast_2 }}">Klik disini</a></small>
                                    @else
                                        <small>Belum mendapatkan Dokumen Bast 2</small>
                                    @endif --}}
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2"
                                        id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="w-50px text-center">No.</th>
                                                <th class="w-auto">Jenis Dokumen</th>
                                                <th class="w-auto">File</th>
                                                {{-- <th class="w-auto text-center"></th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        @php
                                            $no = 1;
                                        @endphp
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            @foreach ($contract->ContractBast as $dokumen)
                                                @if ($dokumen->bast == 1)
                                                <tr>
                                                    <!--begin::Nomor-->
                                                    <td class="text-center">
                                                        {{ $no++ }}
                                                    </td>
                                                    <!--end::Nomor-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        {{ $dokumen->jenis_dokumen }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Name-->
                                                    <td>
                                                        @if (str_contains("$dokumen->nama_dokumen", '.pdf'))
                                                            <a href="{{ asset('words/' . $dokumen->id_document . '.pdf') }}"
                                                                class="text-hover-primary">{{ $dokumen->nama_dokumen }}</a>
                                                        @else
                                                            <a target="_blank" href="{{ asset('words/' . $dokumen->id_document . '.docx') }}"
                                                                class="text-hover-primary">{{ $dokumen->nama_dokumen }}</a>
                                                        @endif
                                                    </td>
                                                    <!--end::Name-->
                                                    <!--begin::Action-->
                                                    {{-- <td class="text-center">
                                                        <small>
                                                            <p data-bs-toggle="modal"
                                                                data-bs-target="#kt_dokumen_rks_delete"
                                                                id="modal-delete"
                                                                class="btn btn-sm btn-light btn-active-primary">
                                                                Delete
                                                            </p>
                                                        </small>
                                                    </td> --}}
                                                    <!--end::Action-->
                                                </tr>
                                                @endif
                                            @endforeach
                                            @if ($contract->ContractBast->count() == 0)
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <div class="col-6">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2"
                                        id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="w-50px text-center">No.</th>
                                                <th class="w-auto">Jenis Dokumen</th>
                                                <th class="w-auto">File</th>
                                                {{-- <th class="w-auto text-center"></th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        @php
                                            $no = 1;
                                        @endphp
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                                @foreach ($contract->ContractBast as $dokumen)
                                                    @if ($dokumen->bast == 2)
                                                    <tr>
                                                        <!--begin::Nomor-->
                                                        <td class="text-center">
                                                            {{ $no++ }}
                                                        </td>
                                                        <!--end::Nomor-->
                                                        <!--begin::Column-->
                                                        <td>
                                                            {{ $dokumen->jenis_dokumen }}
                                                        </td>
                                                        <!--end::Column-->
                                                        <!--begin::Name-->
                                                        <td>
                                                            @if (str_contains("$dokumen->nama_dokumen", '.pdf'))
                                                                <a href="{{ asset('words/' . $dokumen->id_document . '.pdf') }}"
                                                                    class="text-hover-primary">{{ $dokumen->nama_dokumen }}</a>
                                                            @else
                                                                <a target="_blank" href="{{ asset('words/' . $dokumen->id_document . '.docx') }}"
                                                                    class="text-hover-primary">{{ $dokumen->nama_dokumen }}</a>
                                                            @endif
                                                        </td>
                                                        <!--end::Name-->
                                                        <!--begin::Action-->
                                                        {{-- <td class="text-center">
                                                            <small>
                                                                <p data-bs-toggle="modal"
                                                                    data-bs-target="#kt_dokumen_rks_delete"
                                                                    id="modal-delete"
                                                                    class="btn btn-sm btn-light btn-active-primary">
                                                                    Delete
                                                                </p>
                                                            </small>
                                                        </td> --}}
                                                        <!--end::Action-->
                                                    </tr>
                                                    @endif
                                                @endforeach
                                                @if ($contract->ContractBast->count() == 0)
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                                @endif
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <br>
                            {{-- <button type="submit" class="btn btn-sm btn-active-primary text-white"
                                style="background-color: #008cb4;">Save Dokumen Bast</button> --}}
                        {{-- </form> --}}
                        <br>    

                        {{-- <hr> --}}
                        <div class="row">
                            <div class="col">
                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Input Resiko
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_input_resiko_serah_terima">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Verifikasi</th>
                                            <th class="min-w-125px">Kategori</th>
                                            <th class="min-w-125px">Kriteria</th>
                                            <th class="min-w-125px">Probis Level 1 - 2</th>
                                            <th class="min-w-125px">Probis Yang Terganggu</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-400">
                                        @if ($contract->inputRisks->contains('stage', 4))
                                            @forelse ($contract->inputRisks as $inputRisk)
                                                @if ($inputRisk->stage == 4)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <p class="text-gray-600 mb-1">{{ $inputRisk->resiko }}
                                                            </p>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <p class="text-gray-600 mb-1">{{ $inputRisk->penyebab }}
                                                            </p>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <p class="text-gray-600 mb-1">{{ $inputRisk->dampak }}
                                                            </p>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>
                                                            <p class="text-gray-600 mb-1">{{ $inputRisk->mitigasi }}
                                                            </p>
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <!--end::Table body-->

                                </table>

                            </div>
                        </div>

                    </div>

                    {{-- list_dokumen_ba_defect --}}

                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                        Daftar BA Defect
                        <a href="#" Id="Plus" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_defect_ba">+</a>
                    </h3>

                    <!--begin:Table: List Defect BA-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Dokumen</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        @php
                            $list_document_ba_defect = explode(',', $contract->list_dokumen_ba_defect);
                        @endphp
                        <tbody class="fw-bold text-gray-400">
                            @if (count($list_document_ba_defect) > 0 && $list_document_ba_defect[0] != '')
                                @forelse ($list_document_ba_defect as $key => $ba_defect)
                                    <tr>
                                        <!--begin::Name=-->
                                        <td>
                                            <a href="/document/view/{{ $contract->id_contract }}/{{ $ba_defect }}"
                                                class="text-gray-600 text-hover-primary">Dokumen BA Defect
                                                #{{ $key + 1 }}</a>
                                        </td>
                                        <!--end::Name=-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <!--end::Table body-->

                    </table>
                    <br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                        Pending Issue
                        <a href="#" Id="Plus" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_pending_issue">+</a>
                    </h3>

                    <!--begin:Table: List Defect BA-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Issue</th>
                                <th class="min-w-125px">Penyebab</th>
                                <th class="min-w-125px">Status</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-400">
                            @if ($contract->PendingIssue->count() > 0)

                                @foreach ($contract->PendingIssue as $key => $pending_issue)
                                    <tr>
                                        <td>
                                            <p class="text-gray-600">{{ $pending_issue->issue }}</p>
                                        </td>
                                        <!--end::Name=-->
                                        
                                        <td>
                                            <p class="text-gray-600">{{ $pending_issue->penyebab }}</p>
                                        </td>

                                        @if ($pending_issue->status)
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600">Open</p>
                                            </td>
                                            <!--end::Name=-->
                                        @else
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600">Closed</p>
                                            </td>
                                            <!--end::Name=-->
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <!--end::Table body-->

                    </table>
                    <br>
                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                        Dokumen Lainnya
                        <a href="#" Id="Plus" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_dokumen_pendukung_serah_terima">+</a>
                    </h3>

                    <!--begin:Table: List Defect BA-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">No Dokumen</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        @php
                            $list_document_dokumen_pendukung = explode(',', $contract->dokumen_pendukung);
                        @endphp
                        <tbody class="fw-bold text-gray-400">
                            @if (count($list_document_dokumen_pendukung) > 0 && $list_document_dokumen_pendukung[0] != '')
                                @forelse ($list_document_dokumen_pendukung as $key => $dokumen_pendukung)
                                    <tr>
                                        <!--begin::Name=-->
                                        <td>
                                            <a href="/document/view/{{ $contract->id_contract }}/{{ $dokumen_pendukung }}"
                                                class="text-gray-600 text-hover-primary">Dokumen Lainnya
                                                #{{ $key + 1 }}</a>
                                        </td>
                                        <!--end::Name=-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <h6><b>There is no data</b></h6>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <!--end::Table body-->

                    </table>

                    <br>

                {{-- </div>
                <!--begin:::Tab pane Serah Terima-->
                <div class="tab-pane fade" id="kt_user_view_overview_penutupan_proyek" role="tabpanel"> --}}
                    
                    <div class="card-title m-0">
                        <h3 class="fw-normal mb-2" style="font-size:14px;">
                            Upload Dokumen Kontrak dan Addendum
                        </h3>
                        <form action="/contract-management/penutupan-proyek/upload" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $contract->id_contract }}" name="id-contract">
                            <input type="file" accept=".docx" multiple name="kontrak-dan-addendum-file[]"
                                class="form-control form-control-solid">
                            <small>* Support multiple file upload</small>
                            <br><br>
                            <button type="submit" class="btn btn-sm btn-active-primary text-white"
                                style="background-color: #008CB4;">Save Dokumen</button>
                        </form>
                        <hr>
                        @php
                            $list_dokumen_kontrak_dan_addendum = explode(',', $contract->dokumen_kontrak_dan_addendum);
                        @endphp
                        @if (count($list_dokumen_kontrak_dan_addendum) > 0 && $list_dokumen_kontrak_dan_addendum[0] != '')
                            <b>Daftar Dokumen Kontrak dan Addendum</b>
                            <ul class="list-group list-group-flush">
                                @foreach ($list_dokumen_kontrak_dan_addendum as $key => $kontrak_dan_addendum)
                                    <li class="list-group-item">
                                        <a href="/document/view/{{ $contract->id_contract }}/{{ $kontrak_dan_addendum }}"
                                            class="text-gray-600 text-hover-primary">Dokumen #{{ $key + 1 }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Dokumen Belum Diupload</p>
                        @endif
                    </div>
                    {{-- list_dokumen_ba_defect --}}
                </div>
                <!--end:::Tab pane Serah Terima-->
            </div>
            <!--end:::Tab pane Serah Terima-->


        </div>
        <!--end:::Tab content-->
        </form>
    </div>
    <!--end::Card body-->
</div>
<!--end::Contacts-->
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
</div>
</div>
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Root-->
@endisset

<!--begin::Modal-->

<!--begin::Modal - Serah Terima Pekerjaan-->
<div class="modal fade" id="kt_modal_serah_terima" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Attachment</h2>
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
                <form action="/serah-terima/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                        name="id-contract">
                    <input type="hidden" class="modal-name" name="modal-name">
                    <input type="file" style="font-weight: normal" class="form-control form-control-solid"
                        name="attach-file-terima" id="attach-file-terima" value="" accept=".docx"
                        placeholder="Name terima" />
                    @error('attach-file-terima')
                        <h6>
                            <b style="color: rgb(209, 38, 38)">{{ $message }}</b>
                        </h6>
                    @enderror
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="document-name-terima"
                        id="document-name-terima" value="" style="font-weight: normal"
                        placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" style="font-weight: normal" class="form-control form-control-solid"
                        name="note-terima" id="note-terima" value="" placeholder="Catatan" />
                    <!--end::Input-->
                    <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-terima">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>

                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        let contentHtmlTerima = "";
                        document.getElementById("attach-file-terima").addEventListener("change", async function() {
                            contentHtmlTerima = await readFile(this.files[0], "#froala-editor-terima");
                            document.querySelector(`#content-word-terima`).innerText = contentHtmlTerima;

                        });
                    </script>
                    {{-- Begin::input textarea --}}
                    <textarea name="content-word-terima" class="form-control form-control-solid" id="content-word-terima"></textarea>
                    {{-- Begin::input textarea --}}
                    {{-- end::Read File --}}
            </div>
            <!--end::Input group-->

            <button type="submit" id="save-terima" class="btn btn-lg btn-primary"
                data-bs-dismiss="modal">Save</button>
            </form>


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Serah Terima Pekerjaan-->

<!--begin::Modal - Draft Contract-->
<div class="modal fade" id="kt_modal_create_proyek" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Attachment</h2>
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
                <form action="/draft-contract/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                        name="id-contract">
                    <input type="hidden" class="modal-name" name="modal-name">
                    <input type="file" class="form-control form-control-solid" name="attach-file-draft"
                        id="attach-file-draft" value="" style="font-weight: normal" accept=".docx"
                        placeholder="Name draft" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="document-name-draft"
                        id="document-name-draft" value="" style="font-weight: normal"
                        placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="note-draft"
                        id="note-draft" value="" placeholder="Catatan" style="font-weight: normal" />
                    <!--end::Input-->
                    <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-draft">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        document.getElementById("attach-file-draft").addEventListener("change", async function() {
                            await readFile(this.files[0], "#froala-editor-draft");
                        });
                    </script>
                    {{-- end::Read File --}}
            </div>
            <!--end::Input group-->

            <button type="submit" id="save-draft" class="btn btn-lg btn-primary"
                data-bs-dismiss="modal">Save</button>
            </form>


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Draft Contract-->
@isset($contract)

@if ($contract->stages >= 1)

    <!--begin::Modal - Draft Contract Tender Menang-->
    <div class="modal fade" id="kt_modal_draft_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
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
                        <form action="/draft-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid"
                                name="attach-file-draft-menang" id="attach-file-draft-menang"
                                style="font-weight: normal" value="" accept=".docx"
                                placeholder="Name draft" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name-draft" id="document-name-draft" style="font-weight: normal"
                                value="" placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-draft"
                                id="note-draft" value="" placeholder="Catatan"
                                style="font-weight: normal" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-draft-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-draft-menang").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-draft-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-draft-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Draft Contract Tender Menang-->

    <!--begin::Modal - Review Tender Menang-->
    <div class="modal fade" id="kt_modal_review_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Review</h2>
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
                        <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="2" name="stage">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col">
                                            <label for="id-draft-contract"
                                                class="fs-6 fw-bold form-label mt-3">Pilih Draft Kontrak</label>
                                            <select name="id-draft-contract"
                                                onchange="pilihDraftKontrak(this, '#input-pasal-2')"
                                                id="id-draft-contract-2" class="form-select form-select-solid"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilih Draft Kontrak" tabindex="-1"
                                                aria-hidden="true">
                                                <option value=""></option>
                                                @php
                                                    $draftContracts = $draftContracts->filter(function ($d) {
                                                        return $d->tender_menang == 1; // harusnya stage
                                                    });
                                                @endphp
                                                @foreach ($draftContracts as $draft)
                                                    <option value="{{ $draft->id_draft }}">
                                                        {{ $draft->title_draft }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-5">
                                        <div class="col">
                                            <label for="ketentuan-review"
                                                class="fs-6 fw-bold form-label mt-3">Ketentuan</label>
                                            <input type="text" name="ketentuan-review" id="ketentuan-review-2"
                                                placeholder="Ketik di sini..."
                                                class="form-control form-control-solid">
                                        </div>
                                        {{-- <div class="col-6 border-end">
                                    <div class="row ">
                                    </div>
                                    <br> --}}
                                        {{-- <div class="row">
                                        <div class="col">
                                            <label for="sub-pasal-review" class="fs-6 fw-bold form-label mt-3">Sub Pasal</label>
                                            <input type="text" name="sub-pasal-review" id="sub-pasal-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="uraian-penjelasan-review" class="fs-6 fw-bold form-label mt-3">Uraian Penjelasan</label>
                                            <input type="text" name="uraian-penjelasan-review" id="uraian-penjelasan-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="pic-cross-review" class="fs-6 fw-bold form-label mt-3">PIC <i class="text-dark">Cross Function</i></label>
                                            <input type="text" name="pic-cross-review" id="pic-cross-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="catatan-review" class="fs-6 fw-bold form-label mt-3">Catatan</label>
                                            <input type="text" name="catatan-review" id="catatan-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-6 d-flex flex-column justify-content-center">
                                    <label for="upload-review" class="fs-6 fw-bold form-label mt-3">Upload Excel di bawah ini</label>
                                    <input type="file" accept=".xlsx" class="form-control form-control-solid" name="upload-review">
                                </div> --}}
                                    </div>
                                </div>
                                <div class="col-1 d-flex w-20px">
                                    <div class="vr"></div>
                                </div>
                                <div class="col">
                                    <b>Buat perubahan pasal di bawah ini:</b>
                                    <textarea cols="5" rows="8" name="input-pasal" class="form-control form-textarea-solid"
                                        id="input-pasal-2"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-active-primary text-white"
                                    style="background-color: #008CB4">Save</button>
                            </div>

                        </form>


                        <!--begin::Input group Website-->
                        {{-- <div class="fv-row mb-5">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid"
                            name="attach-file-review" id="attach-file-review" value=""
                            style="font-weight: normal" accept=".docx" placeholder="Name Proyek" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid"
                            name="document-name-review" id="document-name-review" style="font-weight: normal"
                            value="" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-review"
                            id="note-review" value="" style="font-weight: normal"
                            placeholder="Catatan" />
                        <!--end::Input-->
                </div> --}}
                        <!--end::Input group-->

                        {{-- <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>

                </form> --}}

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
    <!--end::Modal - Review Tender Menang-->

    <!--begin::Modal - Hasil Klarifikasi dan Negosiasi CDA-->
    <div class="modal fade" id="kt_modal_input_klarifikasi_negosiasi" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Hasil Klarifikasi dan Negosiasi CDA </h2>
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
                        <form action="/klarifikasi-negosiasi/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-klarifikasi-negosiasi" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-klarifikasi-negosiasi">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-klarifikasi-negosiasi").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-klarifikasi-negosiasi");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-klarifikasi-negosiasi" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Hasil Klarifikasi dan Negosiasi CDA-->

    <!--begin::Modal - Kontrak Tanda Tangan-->
    <div class="modal fade" id="kt_modal_input_kontrak_bertandatangan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Kontrak Tanda Tangan </h2>
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
                        <form action="/kontrak-tanda-tangan/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-tandan-tangan" value="" accept=".docx" placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-kontrak-tanda-tangan">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-tandan-tangan").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-kontrak-tanda-tangan");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-kontrak-tanda-tangan" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Kontrak Tanda Tangan-->

    <!--begin::Modal - Perjanjian KSO -->
    <div class="modal fade" id="kt_modal_input_perjanjian_kso" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Perjanjian KSO </h2>
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
                        <form action="/perjanjian-kso/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-perjanjian-kso" value="" accept=".docx" placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-perjanjian-kso">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-perjanjian-kso").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-perjanjian-kso");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-perjanjian-kso" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Perjanjian KSO -->

    <!--begin::Modal - Review Pembatalan Kontrak -->
    <div class="modal fade" id="kt_modal_input_review_pembatalan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Review Pembatalan Kontrak </h2>
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
                        <form action="/review-pembatalan-kontrak/upload" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-pembatalan-kontrak" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name-pendukung" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-pembatalan-kontrak">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-pembatalan-kontrak").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-pembatalan-kontrak");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-pembatalan-kontrak" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Review Pembatalan Kontrak -->

    <!--begin::Modal - Dokumen Pendukung -->
    <div class="modal fade" id="kt_modal_input_dokumen_pendukung" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Dokumen Pendukung </h2>
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
                        <form action="/dokumen-pendukung/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-dokumen-pendukung" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name-pendukung" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-dokumen-pendukung">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-dokumen-pendukung").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-dokumen-pendukung");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-dokumen-pendukung" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Dokumen Pendukung -->
    <!--begin::Modal - MoM Meeting -->
    <div class="modal fade" id="kt_modal_mom_meeting" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | MoM Kick Off Meeting </h2>
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
                        <form action="/mom-meeting/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-mom-meeting" value="" accept=".docx" placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name"
                                id="document-name-pendukung" value="" style="font-weight: normal"
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note"
                                id="note" value="" style="font-weight: normal"
                                placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-mom-meeting">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-mom-meeting").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-mom-meeting");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review-mom-meeting" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - MoM Meeting -->

    <!--begin::Modal - Issue Project Tender Menang-->
    <div class="modal fade" id="kt_modal_issue_project_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
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
                        <form action="/issue-project/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid" name="attach-file-issue"
                                id="attach-file-issue-project-menang" style="font-weight: normal" value=""
                                accept=".docx" placeholder="Name Issue" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name-issue" id="document-name-issue-project"
                                style="font-weight: normal" value="" placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-issue"
                                id="note-issue-project-menang" value="" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-issue-project-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-issue-project-menang").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-issue-project-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-issue-project-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Issue Project Tender Menang-->

    <!--begin::Modal - Input Resiko Tender Menang-->
    <div class="modal fade" id="kt_modal_input_resiko_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Proyek</h2>
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

                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="1" name="is-tender-menang">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Verifikasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="verifikasi" id="verifikasi"
                                    style="font-weight: normal" value="" placeholder="Verifikasi" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kategori" id="kategori"
                                    style="font-weight: normal" value="" placeholder="Kategori" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kriteria" id="kriteria"
                                    value="" placeholder="Kriteria" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Sub Kriteria</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Level 1 - 2</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_1_2"
                                    id="probis_1_2" value="" placeholder="Probis Level 1 - 2" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_terganggu"
                                    id="probis_terganggu" value="" placeholder="Probis Yang Terganggu" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="penyebab"
                                    id="penyebab" value="" placeholder="Penyebab" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="resiko_peluang"
                                    id="resiko_peluang" value="" placeholder="Resiko / Peluang" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r0"
                                    id="nilai_resiko_r0" value="" placeholder="Nilai Resiko / Peluang (Ro)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Kontrol Eksisting</h5>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Item Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="item_kontrol"
                                    id="item_kontrol" value="" placeholder="Item Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probabilitas</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probabilitas"
                                    id="probabilitas" value="" placeholder="Probabilitas" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Skor</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="skor"
                                    id="skor" value="" placeholder="Skor" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_kontrol"
                                    id="tingkat_efektifitas_kontrol" value="" placeholder="Tingkat Efektifitas Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r1"
                                    id="nilai_resiko_r1" value="" placeholder="Nilai Sisa Risiko / Peluang (R1)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Proaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Proaktif</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_mitigasi"
                                    id="tindak_lanjut_mitigasi" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Proaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_tindak_lanjut"
                                    id="tingkat_efektifitas_tindak_lanjut" value="" placeholder="Tingkat Efektifitas Tindak Lanjut" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R2)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r2"
                                    id="nilai_resiko_r2" value="" placeholder="Nilai Sisa Risiko / Peluang (R2)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_proaktif"
                                    id="biaya_proaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Mulai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_mulai"
                                    id="tanggal_mulai" value="" placeholder="Tanggal Mulai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Selesai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_selesai"
                                    id="tanggal_selesai" value="" placeholder="Tanggal Selesai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Reaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Reaktif</span>
                                    {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a> --}}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_reaktif"
                                    id="tindak_lanjut_reaktif" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Reaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_reaktif"
                                    id="biaya_reaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">PIC RTL</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="pic_rtl"
                                    id="pic_rtl" value="" placeholder="PIC RTL" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Peluang</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Uraian</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="uraian"
                                    id="uraian" value="" placeholder="Uraian" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai"
                                    id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Tender Menang-->

    <!--begin::Modal - Input Resiko Tender Menang-->
    <div class="modal fade" id="kt_modal_input_resiko_pelaksanaan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Proyek</h2>
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

                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="3" name="stage">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Verifikasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="verifikasi" id="verifikasi"
                                    style="font-weight: normal" value="" placeholder="Verifikasi" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kategori" id="kategori"
                                    style="font-weight: normal" value="" placeholder="Kategori" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kriteria" id="kriteria"
                                    value="" placeholder="Kriteria" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Sub Kriteria</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Level 1 - 2</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_1_2"
                                    id="probis_1_2" value="" placeholder="Probis Level 1 - 2" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_terganggu"
                                    id="probis_terganggu" value="" placeholder="Probis Yang Terganggu" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="penyebab"
                                    id="penyebab" value="" placeholder="Penyebab" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="resiko_peluang"
                                    id="resiko_peluang" value="" placeholder="Resiko / Peluang" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r0"
                                    id="nilai_resiko_r0" value="" placeholder="Nilai Resiko / Peluang (Ro)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Kontrol Eksisting</h5>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Item Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="item_kontrol"
                                    id="item_kontrol" value="" placeholder="Item Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probabilitas</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probabilitas"
                                    id="probabilitas" value="" placeholder="Probabilitas" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Skor</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="skor"
                                    id="skor" value="" placeholder="Skor" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_kontrol"
                                    id="tingkat_efektifitas_kontrol" value="" placeholder="Tingkat Efektifitas Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r1"
                                    id="nilai_resiko_r1" value="" placeholder="Nilai Sisa Risiko / Peluang (R1)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Proaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Proaktif</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_mitigasi"
                                    id="tindak_lanjut_mitigasi" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Proaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_tindak_lanjut"
                                    id="tingkat_efektifitas_tindak_lanjut" value="" placeholder="Tingkat Efektifitas Tindak Lanjut" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R2)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r2"
                                    id="nilai_resiko_r2" value="" placeholder="Nilai Sisa Risiko / Peluang (R2)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_proaktif"
                                    id="biaya_proaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Mulai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_mulai"
                                    id="tanggal_mulai" value="" placeholder="Tanggal Mulai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Selesai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_selesai"
                                    id="tanggal_selesai" value="" placeholder="Tanggal Selesai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Reaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Reaktif</span>
                                    {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a> --}}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_reaktif"
                                    id="tindak_lanjut_reaktif" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Reaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_reaktif"
                                    id="biaya_reaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">PIC RTL</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="pic_rtl"
                                    id="pic_rtl" value="" placeholder="PIC RTL" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Peluang</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Uraian</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="uraian"
                                    id="uraian" value="" placeholder="Uraian" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai"
                                    id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Tender Menang-->

    <!--begin::Modal - Input Resiko Serah Terima-->
    <div class="modal fade" id="kt_modal_input_resiko_serah_terima" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Serah Terima Pekerjaan</h2>
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

                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="4" name="stage">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Verifikasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="verifikasi" id="verifikasi"
                                    style="font-weight: normal" value="" placeholder="Verifikasi" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kategori" id="kategori"
                                    style="font-weight: normal" value="" placeholder="Kategori" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="kriteria" id="kriteria"
                                    value="" placeholder="Kriteria" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Sub Kriteria</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Level 1 - 2</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_1_2"
                                    id="probis_1_2" value="" placeholder="Probis Level 1 - 2" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probis_terganggu"
                                    id="probis_terganggu" value="" placeholder="Probis Yang Terganggu" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="penyebab"
                                    id="penyebab" value="" placeholder="Penyebab" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="resiko_peluang"
                                    id="resiko_peluang" value="" placeholder="Resiko / Peluang" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r0"
                                    id="nilai_resiko_r0" value="" placeholder="Nilai Resiko / Peluang (Ro)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Kontrol Eksisting</h5>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Item Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="item_kontrol"
                                    id="item_kontrol" value="" placeholder="Item Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probabilitas</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="probabilitas"
                                    id="probabilitas" value="" placeholder="Probabilitas" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Skor</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="skor"
                                    id="skor" value="" placeholder="Skor" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Kontrol</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_kontrol"
                                    id="tingkat_efektifitas_kontrol" value="" placeholder="Tingkat Efektifitas Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r1"
                                    id="nilai_resiko_r1" value="" placeholder="Nilai Sisa Risiko / Peluang (R1)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Proaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Proaktif</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_mitigasi"
                                    id="tindak_lanjut_mitigasi" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Proaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_tindak_lanjut"
                                    id="tingkat_efektifitas_tindak_lanjut" value="" placeholder="Tingkat Efektifitas Tindak Lanjut" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R2)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r2"
                                    id="nilai_resiko_r2" value="" placeholder="Nilai Sisa Risiko / Peluang (R2)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_proaktif"
                                    id="biaya_proaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Mulai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_mulai"
                                    id="tanggal_mulai" value="" placeholder="Tanggal Mulai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Selesai</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal_selesai"
                                    id="tanggal_selesai" value="" placeholder="Tanggal Selesai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Reaktif</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Reaktif</span>
                                    {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a> --}}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_reaktif"
                                    id="tindak_lanjut_reaktif" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Reaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="biaya_reaktif"
                                    id="biaya_reaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">PIC RTL</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="pic_rtl"
                                    id="pic_rtl" value="" placeholder="PIC RTL" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <hr>
                        <h5 class="h5 fw-bolder text-center">Peluang</h5>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Uraian</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="uraian"
                                    id="uraian" value="" placeholder="Uraian" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="nilai"
                                    id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Serah Terima-->

    <!--begin::Modal - Input BA Defect Serah Terima-->
    <div class="modal fade" id="kt_modal_defect_ba" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add BA Defect</h2>
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

                    <form action="/contract-management/ba-defect/upload" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <input type="file" multiple accept=".docx" name="ba-defect[]"
                            class="form-control form-control-solid">
                        {{-- end::Read File --}}
                        <small>* Support multi file upload</small>
                        <br> <br>
                        <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>

                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input BA Defect Serah Terima-->

    <!--begin::Modal - Input BAST 1-->
    <div class="modal fade" id="kt_modal_bast_1" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Dokumen BAST 1</h2>
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
                <form action="/contract-management/document-bast/upload" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-lg-6 px-lg-6">

                        <input type="hidden" name="bast" value="1">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Jenis Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="jenis-bast"
                            class="form-select form-select-solid w-50"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Jenis Dokumen">
                            <option value=""></option>
                            <option value="Mechanical Completion">Mechanical Completion</option>
                            <option value="Commisioning">Commisioning</option>
                            <option value="Performance Test">Performance Test</option>
                            <option value="BAST 1 / PHO">BAST 1 / PHO</option>
                        </select>
                        <!--end::Input-->
                        <br>
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" multiple accept=".docx, .pdf" name="dokumen-bast-1"
                        class="form-control form-control-solid">
                        <!--end::Input-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </div>

                </form>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input BAST 1-->

    <!--begin::Modal - Input BAST 2-->
    <div class="modal fade" id="kt_modal_bast_2" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Dokumen BAST 2</h2>
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
                <form action="/contract-management/document-bast/upload" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-lg-6 px-lg-6">

                        <input type="hidden" name="bast" value="2">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Jenis Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="jenis-bast"
                            class="form-select form-select-solid w-50"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Jenis Dokumen">
                            <option value=""></option>
                            <option value="Mechanical Completion">Mechanical Completion</option>
                            <option value="Commisioning">Commisioning</option>
                            <option value="Performance Test">Performance Test</option>
                            <option value="BAST 1 / PHO">BAST 1 / PHO</option>
                        </select>
                        <!--end::Input-->
                        <br>
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" multiple accept=".docx, .pdf" name="dokumen-bast-1"
                        class="form-control form-control-solid">
                        <!--end::Input-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </div>

                </form>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input BAST 2-->

    <!--begin::Modal - Input Dokumen Lainnya Serah Terima-->
    <div class="modal fade" id="kt_modal_dokumen_pendukung_serah_terima" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Dokumen Lainnya</h2>
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

                    <form action="/contract-management/dokumen-pendukung/upload" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <input type="file" multiple accept=".docx,.xlsx" name="dokumen-pendukung[]"
                            class="form-control form-control-solid">
                        {{-- end::Read File --}}
                        <small>* Support multi file upload</small>
                        <br> <br>
                        <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>

                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Dokumen Lainnya Serah Terima-->

    <!--begin::Modal - Input Pending Issue Serah Terima-->
    <div class="modal fade" id="kt_modal_pending_issue" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Pending Issue</h2>
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

                    <form action="/contract-management/pending-issue/upload" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">
                        <input type="hidden" class="modal-name" name="modal-name">

                        <div class="row">
                            {{-- <div class="col d-flex flex-column justify-content-center">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Masukan file dibawah ini</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" accept=".jpg,.jpeg,.png" name="pending-issue-file"
                                    class="form-control form-control-solid">
                                <!--end::Read File-->
                                <small>* hanya menerima file dengan format <b>.jpg</b>, <b>.jpeg</b> dan
                                    <b>.png</b></small>
                            </div> --}}

                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Issue</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" name="pending-issue" value="" class="form-control form-control-solid">
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <textarea name="penyebab-issue" class="form-control form-control-solid"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko Biaya</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" name="resiko-biaya" value="" class="form-control form-control-solid">
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko Waktu</span>
                                </label>
                                <!--end::Label-->
                                <input type="date" name="resiko-waktu" class="form-control form-control-solid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Resiko Mutu</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" name="resiko-mutu" value="" class="form-control form-control-solid">
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Ancaman</span>
                                </label>
                                <!--end::Label-->
                                <textarea cols="1" name="ancaman" class="form-control form-control-solid"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Peluang</span>
                                </label>
                                <!--end::Label-->
                                <textarea cols="1" name="peluang" value="" class="form-control form-control-solid"></textarea>
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <textarea cols="1" name="rencana-tindak-lanjut" class="form-control form-control-solid"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Status</span>
                                </label>
                                <!--end::Label-->
                                <select name="status" id="status" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Status"
                                    data-select2-id="select2-data-project-id" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">Open</option>
                                    <option value="0">Close</option>
                                </select>
                            </div>
                        </div>
                        {{-- <hr> --}}
                        {{-- <div class="col">
                            <h3 class="text-center"><b>Resiko / Dampak</b></h3>
                            <div class="row">
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Biaya</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="text" class="form-control form-control-solid" name="biaya"
                                        id="biaya">
                                </div>
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Waktu</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="date" class="form-control form-control-solid" name="waktu"
                                        id="waktu">
                                </div>
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Mutu</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="text" class="form-control form-control-solid" name="mutu"
                                        id="mutu">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Ancaman</span>
                                </label>
                                <!--end::Label-->

                                <input type="text" class="form-control form-control-solid" name="ancaman"
                                    id="ancaman">
                            </div>

                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Peluang</span>
                                </label>
                                <!--end::Label-->

                                <input type="text" class="form-control form-control-solid" name="peluang"
                                    id="peluang">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Rencana Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->

                                <textarea class="form-control form-control-solid" rows="1" name="rencana-tindak-lanjut"
                                    id="rencana-tindak-lanjut"></textarea>
                            </div>

                            <div class="col d-flex flex-column justify-content-center">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Target Waktu Penyelesaian</span>
                                </label>
                                <!--end::Label-->

                                <input type="date" class="form-control form-control-solid"
                                    name="target-waktu-penyelesaian" id="target-waktu-penyelesaian">
                            </div>
                        </div> --}}

                        <br> <br>
                        <button type="submit" id="pending-issue" class="btn btn-lg btn-primary">Save</button>

                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Pending Issue Serah Terima-->

    <!--begin::Modal - Question Tender Menang-->
    <div class="modal fade" id="kt_modal_question_menang" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment</h2>
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
                        <form action="/question/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="1" name="is-tender-menang">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" class="form-control form-control-solid"
                                name="attach-file-question" id="attach-file-question-menang" value=""
                                accept=".docx" placeholder="Name draft" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name-question" id="document-name-question-menang"
                                style="font-weight: normal" value="" placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" style="font-weight: normal"
                                class="form-control form-control-solid" name="note-question" id="note-question"
                                value="" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-question-menang">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-question-menang").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-question-menang");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-question-tender-menang" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>


                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Question Tender Menang-->

    <!--begin::Modal - Question Tender Menang-->
    <div class="modal fade" id="kt_modal_input_rencana_kerja_kontrak" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Rencana Kerja Manajemen Kontrak</h2>
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
                    <form action="/contract-management/rencana-kerja-kontrak/upload" method="POST"
                        enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            <div class="col">
                                <!--begin::Label-->
                                <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Ketentuan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="hidden" value="1" name="is-tender-menang">
                    <input type="hidden" class="modal-name" name="modal-name">
                                 --}}
                                <textarea name="ketentuan-rencana-kerja" id="ketentuan-rencana-kerja" rows="10"
                                    class="form-control form-control-solid"></textarea>
                                <!--end::Input-->
                            </div>

                            <br><br>

                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Informasi Kelengkapan <i>Check List</i>
                                        ADKON</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="hidden" value="1" name="is-tender-menang">
                    <input type="hidden" class="modal-name" name="modal-name">
                                 --}}
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">
                                <textarea name="kelengkapan-adkon" id="kelengkapan-adkon" rows="10"
                                    class="form-control form-control-solid"></textarea>
                                <!--end::Input-->
                            </div>

                        </div>
                        <!--end::Input group-->
                        <div class="modal-footer mt-4">
                            <button type="submit" id="save-question-tender-menang"
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
    <!--end::Modal - Question Tender Menang-->

    <br><br>
    <!--Begin::Modal - Dokumen Site Instruction-->
    <div class="modal fade" id="kt_modal_dokumen_site_instruction" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Document Site Instruction</h2>
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
                        <form action="/dokumen-site-instruction/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->
        
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-dokumen-instruction"
                                id="nomor-dokumen" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Site Instruction" />
                            <!--end::Input-->
        
                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal_dokumen">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-dokumen-instruction"
                            id="tanggal_dokumen" value="" placeholder="Tanggal Dokumen" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
        
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-dokumen-instruction"></textarea>
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-dokumen-instruction"
                            id="file-dokumen-instruction" value="" style="font-weight: normal" accept=".docx,.pdf" />
                    </div>
                    <!--end::Input group-->
        
                    <button type="submit" id="save-dokumen-site-instruction" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
        
        
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Site Instruction-->

    <br><br>
    <!--Begin::Modal - Dokumen Technical Form-->
    <div class="modal fade" id="kt_modal_dokumen_technical_form" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachment | Document Technical Form</h2>
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
                        <form action="/dokumen-technical-form/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-technical-form"
                                id="nomor-technical-form" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Technical Form" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-technical-form">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-technical-form"
                            id="tanggal-technical-form" value="" placeholder="Tanggal Dokumen Technical Form" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-technical-form"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Text Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-technical-form"
                            id="file-dokumen-instruction" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Text Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-technical-form" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Technical Form-->

    <br><br>
    <!--Begin::Modal - Dokumen Technical Query-->
    <div class="modal fade" id="kt_modal_dokumen_technical_query" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachement | Document Technical Query</h2>
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
                        <form action="/dokumen-technical-query/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-technical-query"
                                id="nomor-technical-query" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Technical Query" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-technical-query">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-technical-query"
                            id="tanggal-technical-query" value="" placeholder="Tanggal Dokumen Technical Query" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-technical-query"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-technical-query"
                            id="file-dokumen-instruction" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-technical-query" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Technical Query-->

    <br><br>
    <!--Begin::Modal - Dokumen Field Design Change-->
    <div class="modal fade" id="kt_modal_dokumen_field_design_change" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachement | Document Field Design Change</h2>
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
                        <form action="/dokumen-field-design-change/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-field-design-change"
                                id="nomor-field-design-change" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Field Design Change" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-field-design-change">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-field-design-change"
                            id="tanggal-field-design-change" value="" placeholder="Tanggal Dokumen Field Design Change" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-field-design-change"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-field-design-change"
                            id="file-dokumen-instruction" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-field-design-change" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Field Design Change-->

    <br><br>
    <!--Begin::Modal - Dokumen Contract Change Notice-->
    <div class="modal fade" id="kt_modal_dokumen_contract_change_notice" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachement | Document Contract Change Notice</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/dokumen-contract-change-notice/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-contract-change-notice"
                                id="nomor-contract-change-notice" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Contract Change Notice" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-contract-change-notice">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-contract-change-notice"
                            id="tanggal-contract-change-notice" value="" placeholder="Tanggal Dokumen Contract Change Notice" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-contract-change-notice"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-contract-change-notice"
                            id="file-dokumen-contract-change-notice" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-contract-change-notice" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Contract Change Notice-->

    <br><br>
    <!--Begin::Modal - Dokumen Contract Change Proposal-->
    <div class="modal fade" id="kt_modal_dokumen_contract_change_proposal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachement | Document Contract Change Proposal</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                        <i class="bi bi-x-lg"></i>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/dokumen-contract-change-proposal/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-contract-change-proposal"
                                id="nomor-contract-change-proposal" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Contract Change Proposal" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-contract-change-proposal">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-contract-change-proposal"
                            id="tanggal-contract-change-proposal" value="" placeholder="Tanggal Dokumen Contract Change Proposal" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-contract-change-proposal"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-contract-change-proposal"
                            id="file-dokumen-contract-change-proposal" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-contract-change-proposal" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Contract Change Proposal-->

    <br><br>
    <!--Begin::Modal - Dokumen Contract Change Order-->
    <div class="modal fade" id="kt_modal_dokumen_contract_change_order" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Attachement | Document Contract Change order</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
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
                        <form action="/dokumen-contract-change-order/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nomor Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-contract-change-order"
                                id="nomor-contract-change-order" value="" style="font-weight: normal"
                                placeholder="No. Dokumen Contract Change Order" />
                            <!--end::Input-->

                            
                            <!--begin::Input-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tanggal</span>
                                <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal-contract-change-order">
                                    <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                </a>
                            </label>
                            <input type="date" class="form-control form-control-solid mb-3" name="tanggal-contract-change-order"
                            id="tanggal-contract-change-order" value="" placeholder="Tanggal Dokumen Contract Change Order" style="font-weight: normal" />
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                            <!--Begin::Text Area-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Uraian</span>
                            </label>
                            <textarea class="form-control form-control-solid" name="uraian-contract-change-order"></textarea>
                            <!--End::Text Area-->

                            <!--Begin::Input File-->
                            <label class="fs-6 fw-bold form-label mt-5">
                                <span style="font-weight: normal">Upload File</span>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="file-contract-change-order"
                            id="file-dokumen-contract-change-order" value="" style="font-weight: normal" accept=".docx,.pdf" />
                            <!--End::Input File-->
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-dokumen-contract-change-order" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </form>
                </div>
                <!--end::Modal body--> 
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--End::Modal = Dokumen Contract Change Order-->

    <div class="modal fade" id="kt_modal_input_perubahan_kontrak" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
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
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="hidden" class="modal-name" name="modal-name">
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
                            <div class="col">
                                <label class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Jenis Dokumen</span>
                                </label>
                                <select name="jenis-dokumen" id="jenis-dokumen" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Dokumen" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Site Instruction">Site Instruction</option>
                                    <option value="Technical Form">Technical Form</option>
                                    <option value="Technical Query">Technical Query</option>
                                    <option value="Field Design Change">Field Design Change</option>
                                    <option value="Contract Change Notice">Contract Change Notice</option>
                                    <option value="Contract Change Proposal">Contract Change Proposal</option>
                                    <option value="Contract Change Order">Contract Change Order</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">No Surat / Instruksi Owner</span>
                                </label>
                                <select name="instruksi-owner" id="instruksi-owner" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih No Surat" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Site Instruction">Site Instruction</option>
                                    <option value="Technical Form">Technical Form</option>
                                    <option value="Technical Query">Technical Query</option>
                                    <option value="Field Design Change">Field Design Change</option>
                                    <option value="Contract Change Notice">Contract Change Notice</option>
                                    <option value="Contract Change Proposal">Contract Change Proposal</option>
                                    <option value="Contract Change Order">Contract Change Order</option>
                                </select>
                            </div>
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
    <!--end::Modal - Perubahan Kontrak Menang-->

@endif
@endisset

<!--Begin::Modal - Detail Proyek-->
<div class="modal fade" id="detailProyek" tabindex="-1" aria-labelledby="detailProyekLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="detailProyekLabel">Detail Proyek (Read Only)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <!--begin::Row-->
             <div class="row fv-row">
                <!--begin::Col-->
                <div class="col-6">
                    <!--begin::Input group Website-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span>No SPK External</span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="nospk-external" name="nospk-external"
                            value="{{ $contract->project->nospk_external ?? "Kosong" }}"
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
                            <span>Jenis Proyek</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" disabled readonly
                            class="form-control form-control-solid"
                            value="{{ $contract->project->jenis_proyek ?? "Kosong" == 'I' ? 'Internal' : ($contract->project->jenis_proyek ?? "Kosong" == 'N' ? 'External' : 'JO') }}"
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
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tglspk-internal" name="tglspk-internal"
                            value="{{ $contract->project->tglspk_internal ?? "Kosong" }}"
                            placeholder="Date" />
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
                            <span>Porsi JO (<i
                                    class="bi bi-percent text-dark"></i>)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid {{ $contract->project->porsi_jo == null ? 'text-danger' : '' }}"
                            value="{{ (int) $contract->project->porsi_jo ?? "Kosong" ?? '*Porsi JO Belum Ditentukan' }}"
                            placeholder="Porsi JO" readonly />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-1">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                    </label>
                    <p class="mt-16"><i class="bi bi-percent text-dark"></i>
                    </p>
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
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="" name="tahun-ri-perolehan"
                            value="{{ $contract->project->tahun_ri_perolehan ?? "Kosong" }}"
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
                            <span>Nilai OK Review (Valas) (Exclude Tax)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid reformat {{ $contract->project->nilai_valas_review ?? "Kosong" == null ? 'text-danger' : '' }}"
                            value="{{ number_format((int) str_replace('.', '', $contract->project->nilai_valas_review ?? "Kosong"), 0, '.', '.') ?? '*Nilai OK Review Belum Ditentukan' }}"
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
                        <select disabled id="bulan-ri-perolehan"
                            name="bulan-ri-perolehan"
                            class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Pilih Bulan RI Perolehan">
                            <option></option>
                            <option value="1"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '1' ? 'selected' : '' }}>
                                Januari</option>
                            <option value="2"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '2' ? 'selected' : '' }}>
                                Februari</option>
                            <option value="3"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '3' ? 'selected' : '' }}>
                                Maret</option>
                            <option value="4"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '4' ? 'selected' : '' }}>
                                April</option>
                            <option value="5"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '5' ? 'selected' : '' }}>
                                Mei</option>
                            <option value="6"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '6' ? 'selected' : '' }}>
                                Juni</option>
                            <option value="7"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '7' ? 'selected' : '' }}>
                                Juli</option>
                            <option value="8"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '8' ? 'selected' : '' }}>
                                Agustus</option>
                            <option value="9"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '9' ? 'selected' : '' }}>
                                September</option>
                            <option value="10"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '10' ? 'selected' : '' }}>
                                Oktober</option>
                            <option value="11"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '11' ? 'selected' : '' }}>
                                November</option>
                            <option value="12"
                                {{ $contract->project->bulan_ri_perolehan ?? "Kosong" == '12' ? 'selected' : '' }}>
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
                            <span>Mata Uang</span>
                        </label>
                        <!--end::Label-->
                        <!--Begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid {{ $contract->project->mata_uang_review == null && $contract->project->mata_uang_awal == null ? 'text-danger' : '' }}"
                            value="{{ $contract->project->mata_uang_review ?? ($contract->project->mata_uang_awal ?? '*Mata Uang Belum Ditentukan') }}"
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
                            <span>No Kontrak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="d-flex align-items-center position-relative">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            {{-- <span id="view-kontrak" class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <a href="/contract-management/view/{{ $contract->project->nomor_terkontrak ?? "Kosong" }}" class="text-gray-800 text-hover-primary mb-1">{{ $contract->project->nomor_terkontrak ?? "Kosong" }}</a>
                                </span>
                                <input disabled onclick="viewKontrak(this)" type="text" disabled readonly id="fake-terkontrak"
                                    class="form-control form-control-solid"
                                    value="" readonly/> --}}
                            <!--end::Svg Icon-->
                            <input disabled onfocusout="displayKontrak(this)"
                                type="text" disabled readonly
                                class="form-control form-control-solid"
                                id="nomor-terkontrak" name="nomor-terkontrak"
                                value="{{ $contract->project->nomor_terkontrak ?? "Kosong" }}"
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
                            //     // e.value = "{{ $contract->project->nomor_terkontrak ?? "Kosong" }}";
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
                            <span>Kurs Review</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled onkeyup="hitungReview()" type="text" disabled readonly
                            class="form-control form-control-solid {{ $contract->project->kurs_review == null ? 'text-danger' : '' }}"
                            value="{{ $contract->project->kurs_review ?? '*Kurs Review Belum Ditentukan' }}"
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
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-terkontrak" name="tanggal-terkontrak"
                            value="{{ $contract->project->tanggal_terkontrak ?? "Kosong" }}"
                            placeholder="Date" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--End begin::Col-->
                @php
                    if ($contract->project->stage == 8 || $contract->project->stage == 9) {
                        if ($contract->project->nilai_perolehan != null && $contract->project->porsi_jo != null) {
                            $nilaiPerolehan = (int) str_replace('.', '', $contract->project->nilai_perolehan);
                            $kontrakKeseluruhan = ($nilaiPerolehan * 100) / (int) $contract->project->porsi_jo;
                            $nilaiKontrakKeseluruhan = number_format((int) str_replace('.', '', round($kontrakKeseluruhan)), 0, '.', '.');
                        }
                    } else {
                        $nilaiKontrakKeseluruhan = 0;
                    }
                    // dump( $nilaiKontrakKeseluruhan)
                @endphp
                <div class="col-6">
                    <!--begin::Input group Website-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span>Nilai Kontrak Keseluruhan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        {{-- <input disabled type="text" disabled readonly
                                class="form-control form-control-solid reformat {{ $contract->project->nilai_kontrak_keseluruhan == null ? 'text-danger' : '' }}"
                                value="{{ number_format((int) str_replace('.', '', $contract->project->nilai_kontrak_keseluruhan), 0, '.', '.') ?? '*Nilai Perolehan Belum Ditentukan' }}"
                                id="nilai-kontrak-keseluruhan"
                                name="nilai-kontrak-keseluruhan"
                                placeholder="*Nilai Perolehan Belum Ditentukan"
                                readonly /> --}}
                        <input disabled type="text" disabled readonly
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
                            <span>Tanggal Mulai Kontrak</span>
                        </label>
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-mulai-kontrak"
                            name="tanggal-mulai-kontrak"
                            value="{{ $contract->project->tanggal_mulai_terkontrak ?? "Kosong" }}"
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
                            <span>Nilai Kontrak (Porsi WIKA)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid reformat {{ $contract->project->nilai_perolehan == null ? 'text-danger' : '' }}"
                            value="{{ number_format((int) str_replace('.', '', $contract->project->nilai_perolehan), 0, '.', '.') ?? '*Nilai Perolehan Belum Ditentukan' }}"
                            placeholder="Nilai Kontrak (Porsi WIKA)" readonly />
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
                            <span>Tanggal Akhir Kontrak</span>
                        </label>
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-akhir-kontrak"
                            name="tanggal-akhir-kontrak"
                            value="{{ $contract->project->tanggal_akhir_terkontrak ?? "Kosong" }}"
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
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-selesai-kontrak-fho"
                            name="tanggal-selesai-kontrak-fho"
                            value="{{ $contract->project->klasifikasi_terkontrak ?? "Kosong" ?? "" }}"
                            placeholder="" />
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
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-selesai-kontrak-pho"
                            name="tanggal-selesai-kontrak-pho"
                            value="{{ $contract->project->tanggal_selesai_pho ?? "Kosong" }}"
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
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-selesai-kontrak-pho"
                            name="tanggal-selesai-kontrak-pho"
                            value="{{ $contract->project->jenis_terkontrak ?? "Kosong" }}"
                            placeholder="Date" />
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
                        
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-selesai-kontrak-fho"
                            name="tanggal-selesai-kontrak-fho"
                            value="{{ $contract->project->tanggal_selesai_fho ?? "Kosong" }}"
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
                        <input disabled type="text" disabled readonly
                            class="form-control form-control-solid"
                            id="tanggal-selesai-kontrak-fho"
                            name="tanggal-selesai-kontrak-fho"
                            value="{{ $contract->project->sistem_bayar ?? "Kosong" }}"
                            placeholder="Date" />
                        {{-- <select disabled id="sistem-bayar" name="sistem-bayar"
                            class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Sistem Pembayaran">
                            <option></option>
                            <option value="CPF (Turn Key)"
                                {{ $contract->project->sistem_bayar ?? "Kosong" == 'CPF (Turn Key)' ? 'selected' : '' }}>
                                CPF (Turn Key)</option>
                            <option value="Milestone"
                                {{ $contract->project->sistem_bayar ?? "Kosong" == 'Milestone' ? 'selected' : '' }}>
                                Milestone</option>
                            <option value="Monthly"
                                {{ $contract->project->sistem_bayar ?? "Kosong" == 'Monthly' ? 'selected' : '' }}>
                                Monthly</option>
                        </select> --}}
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
                        @foreach ($contract->project->AdendumProyek ?? "Kosong" as $adendum)
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

            <br>

            <!--begin::Data Performance-->
            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                Proyek Performance
                <i onclick="hideperformance()" id="hide-performance"
                    class="bi bi-arrows-collapse"></i>
                <i onclick="showperformance()" id="show-performance"
                    style="display: none" class="bi bi-arrows-expand"></i>
            </h3>

            <script>
                function hideperformance() {
                    document.getElementById("divProyekPerformance").style.display = "none";
                    document.getElementById("hide-performance").style.display = "none";
                    document.getElementById("show-performance").style.display = "";
                }

                function showperformance() {
                    document.getElementById("divProyekPerformance").style.display = "";
                    document.getElementById("hide-performance").style.display = "";
                    document.getElementById("show-performance").style.display = "none";
                }
            </script>
            <br>
            <div id="divProyekPerformance">
                <!--end::Data Performance-->
                <!--begin::Row-->
                <div class="row fv-row">
                    <!--begin::Col-->
                    <div class="col-6">
                        <!--begin::Input group Website-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span>Nilai OK (Excludde Ppn)&nbsp;<i
                                        class="bi bi-lock"></i></span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input disabled type="text"
                                class="form-control form-control-solid reformat"
                                value="{{ number_format((int) str_replace('.', '', $contract->project->nilai_rkap ?? "Kosong"), 0, '.', '.') }}"
                                placeholder="Nilai OK" readonly />
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
                                <span>Piutang</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input disabled type="text"
                                class="form-control form-control-solid reformat"
                                name="piutang-performance"
                                value="{{ number_format((int) str_replace('.', '', $contract->project->piutang ?? "Kosong"), 0, '.', '.') }}"
                                placeholder="Piutang" />
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
                                <span>Laba</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input disabled type="text"
                                class="form-control form-control-solid reformat"
                                name="laba-performance"
                                value="{{ number_format((int) str_replace('.', '', $contract->project->laba ?? "Kosong"), 0, '.', '.') }}"
                                placeholder="Laba" />
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
                                <span>Rugi</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input disabled type="text"
                                class="form-control form-control-solid reformat"
                                name="rugi-performance"
                                value="{{ number_format((int) str_replace('.', '', $contract->project->rugi ?? "Kosong"), 0, '.', '.') }}"
                                placeholder="Rugi" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--End begin::Col-->
                </div>
                <!--End begin::Row-->
            </div>

            <!--Begin::Title Biru Form: Laporan Kualitatif-->
            <br>
            <h3 class="fw-bolder m-0 required" id="HeadDetail"
                style="font-size:14px;">Laporan Kualitatif
            </h3>
            <br>
            <div class="form-group">
                <textarea class="form-control" disabled id="laporan-terkontrak" name="laporan-terkontrak" rows="7">{!! $contract->project->laporan_terkontrak ?? "Kosong" !!}</textarea>
            </div>
            {{-- <!--End::Title Biru Form: Laporan Kualitatif--> --}}
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End::Modal - Detail Proyek-->

<!--begin::Modal - Question Tender Menang-->
<div class="modal fade" id="kt_modal_usulan_perubahan_draft_kontrak" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Usulan Perubahan</h2>
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
            <form action="/contract-management/usulan-perubahan-draft/upload" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col">

                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Kategori</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        {{-- <input disabled type="hidden" value="1" name="is-tender-menang">
                    <input disabled type="hidden" class="modal-name" name="modal-name">
                            --}}
                        <select name="kategori" id="kategori" class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                            tabindex="-1" aria-hidden="true">
                            <option value=""></option>
                            <option value="1">Surat Perjanjian Kontrak</option>
                            <option value="2">Syarat-syarat Umum Kontrak (SSUK)</option>
                            <option value="3">Syarat-syarat Khusus Kontrak (SSKK)</option>
                        </select>
                        <!--end::Input-->

                        <br><br>

                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="hidden" class="modal-name" name="modal-name">

                        {{-- <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Pilih Review Kontrak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="id-review-contract" id="id-review-contract"
                            onchange="pilihDraftKontrak(this, '#pasal-perbaikan', true)"
                            class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true" data-placeholder="Pilih Review Kontrak" tabindex="-1"
                            aria-hidden="true">
                            <option value=""></option>
                            @foreach ($review_contracts as $review)
                                <option value="{{ $review->id_draft_contract }}">
                                    {{ $review->DraftContract->title_draft }}</option>
                            @endforeach
                        </select>
                        <!--end::Input--> --}}

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Isu</span>
                        </label>
                        <!--end::Label-->
                        
                        <!--Begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="isu" placeholder="Isu">
                        <!--End::Input-->
                        
                        <br>
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Deskripsi Klausul Awal</span>
                        </label>
                        <!--end::Label-->
                        
                        <!--Begin::Input-->
                        <textarea class="form-control form-control-solid" name="deskripsi-klausul-awal" cols="2" placeholder="Deskripsi Klausul Awal"></textarea>
                        <!--End::Input-->
                        
                        <br>
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Usulan Perubahan Klausul</span>
                        </label>
                        <!--end::Label-->
                        
                        <!--Begin::Input-->
                        <textarea class="form-control form-control-solid" name="usulan-perubahan-klausul" cols="2" placeholder="Usulan Perubahan Klausul"></textarea>
                        <!--End::Input-->
                        
                        <br>
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label">
                            <span style="font-weight: normal">Keterangan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea style="font-weight: normal" class="form-control form-control-solid" name="keterangan" id="keterangan"
                            rows="1" placeholder="Keterangan"></textarea>
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Input group-->
                <br><br>

                <button type="submit" id="save-question-tender-menang"
                    class="btn btn-lg btn-primary">Save</button>
            </form>


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Question Tender Menang-->

<!--begin::Modal - Laporan Bulanan-->
<div class="modal fade" id="kt_modal_laporan_bulanan" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Attachment</h2>
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
                <form action="/laporan-bulanan/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                        name="id-contract">
                    <input type="hidden" class="modal-name" name="modal-name">
                    <input type="file" class="form-control form-control-solid" name="attach-file-bulanan"
                        id="attach-file-bulanan" value="" style="font-weight: normal" accept=".docx"
                        placeholder="Name draft" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="document-name-bulanan"
                        id="document-name-bulanan" value="" style="font-weight: normal"
                        placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="note-bulanan"
                        id="note-bulanan" value="" style="font-weight: normal"
                        placeholder="Catatan" />
                    <!--end::Input-->
                    <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-bulanan-menang">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        document.getElementById("attach-file-bulanan").addEventListener("change", async function() {
                            await readFile(this.files[0], "#froala-editor-bulanan-menang");
                        });
                    </script>
                    {{-- end::Read File --}}
            </div>
            <!--end::Input group-->

            <button type="submit" id="save-bulanan-tender-menang" class="btn btn-lg btn-primary"
                data-bs-dismiss="modal">Save</button>
            </form>


        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Laporan Bulanan-->

<!--begin::Modal - Review-->
<div class="modal fade" id="kt_modal_create_review" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Review</h2>
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
                <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                    <input type="hidden" class="modal-name" name="modal-name">
                    <input type="hidden" value="1" name="stage">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col">
                                    <label for="id-draft-contract" class="fs-6 fw-bold form-label mt-3">Pilih
                                        Draft Kontrak</label>
                                    <select name="id-draft-contract"
                                        onchange="pilihDraftKontrak(this, '#input-pasal')"
                                        id="id-draft-contract" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih Draft Kontrak" tabindex="-1"
                                        aria-hidden="true">
                                        <option value=""></option>
                                        @foreach ($draftContracts as $draft)
                                            <option value="{{ $draft->id_draft }}">{{ $draft->title_draft }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-5">
                                <div class="col">
                                    <label for="ketentuan-review"
                                        class="fs-6 fw-bold form-label mt-3">Ketentuan</label>
                                    <input type="text" name="ketentuan-review" id="ketentuan-review"
                                        class="form-control form-control-solid">
                                </div>
                                {{-- <div class="col-6 border-end">
                                    <div class="row ">
                                    </div>
                                    <br> --}}
                                {{-- <div class="row">
                                        <div class="col">
                                            <label for="sub-pasal-review" class="fs-6 fw-bold form-label mt-3">Sub Pasal</label>
                                            <input type="text" name="sub-pasal-review" id="sub-pasal-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="uraian-penjelasan-review" class="fs-6 fw-bold form-label mt-3">Uraian Penjelasan</label>
                                            <input type="text" name="uraian-penjelasan-review" id="uraian-penjelasan-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="pic-cross-review" class="fs-6 fw-bold form-label mt-3">PIC <i class="text-dark">Cross Function</i></label>
                                            <input type="text" name="pic-cross-review" id="pic-cross-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="catatan-review" class="fs-6 fw-bold form-label mt-3">Catatan</label>
                                            <input type="text" name="catatan-review" id="catatan-review" class="form-control form-control-solid">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-6 d-flex flex-column justify-content-center">
                                    <label for="upload-review" class="fs-6 fw-bold form-label mt-3">Upload Excel di bawah ini</label>
                                    <input type="file" accept=".xlsx" class="form-control form-control-solid" name="upload-review">
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-1 d-flex w-20px">
                            <div class="vr"></div>
                        </div>
                        <div class="col">
                            <b>Buat perubahan pasal di bawah ini:</b>
                            <textarea cols="5" rows="8" name="input-pasal" class="form-control form-textarea-solid"
                                id="input-pasal"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-active-primary text-white"
                            style="background-color: #008CB4">Save</button>
                    </div>

                </form>




                <!--begin::Input group Website-->
                {{-- <div class="fv-row mb-5">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid"
                            name="attach-file-review" id="attach-file-review" value=""
                            style="font-weight: normal" accept=".docx" placeholder="Name Proyek" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid"
                            name="document-name-review" id="document-name-review" style="font-weight: normal"
                            value="" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-review"
                            id="note-review" value="" style="font-weight: normal"
                            placeholder="Catatan" />
                        <!--end::Input-->
                </div> --}}
                <!--end::Input group-->

                {{-- <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>

                </form> --}}

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
<!--end::Modal - Review-->

<!--begin::Modal - Risk Project-->
<div class="modal fade" id="kt_modal_risk_proyek" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Resiko Proyek</h2>
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

            <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="modal-name" name="modal-name">
                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Verifikasi</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="verifikasi" id="verifikasi"
                            style="font-weight: normal" value="" placeholder="Verifikasi" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Kategori</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="kategori" id="kategori"
                            style="font-weight: normal" value="" placeholder="Kategori" />
                        <!--end::Input-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Kriteria</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="kriteria" id="kriteria"
                            value="" placeholder="Kriteria" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <hr>
                <h5 class="h5 fw-bolder text-center">Sub Kriteria</h5>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Probis Level 1 - 2</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="probis_1_2"
                            id="probis_1_2" value="" placeholder="Probis Level 1 - 2" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Probis Yang Terganggu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="probis_terganggu"
                            id="probis_terganggu" value="" placeholder="Probis Yang Terganggu" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Penyebab</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="penyebab"
                            id="penyebab" value="" placeholder="Penyebab" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Resiko / Peluang</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="resiko_peluang"
                            id="resiko_peluang" value="" placeholder="Resiko / Peluang" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Dampak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                            id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r0"
                            id="nilai_resiko_r0" value="" placeholder="Nilai Resiko / Peluang (Ro)" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                
                <hr>
                <h5 class="h5 fw-bolder text-center">Kontrol Eksisting</h5>
                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Item Kontrol</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="item_kontrol"
                            id="item_kontrol" value="" placeholder="Item Kontrol" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Probabilitas</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="probabilitas"
                            id="probabilitas" value="" placeholder="Probabilitas" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Dampak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                            id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Skor</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="skor"
                            id="skor" value="" placeholder="Skor" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Tingkat Efektifitas Kontrol</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_kontrol"
                            id="tingkat_efektifitas_kontrol" value="" placeholder="Tingkat Efektifitas Kontrol" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r1"
                            id="nilai_resiko_r1" value="" placeholder="Nilai Sisa Risiko / Peluang (R1)" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                <hr>
                <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Proaktif</h5>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Proaktif</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_mitigasi"
                            id="tindak_lanjut_mitigasi" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Proaktif" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="tingkat_efektifitas_tindak_lanjut"
                            id="tingkat_efektifitas_tindak_lanjut" value="" placeholder="Tingkat Efektifitas Tindak Lanjut" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R2)</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="nilai_resiko_r2"
                            id="nilai_resiko_r2" value="" placeholder="Nilai Sisa Risiko / Peluang (R2)" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Biaya</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="biaya_proaktif"
                            id="biaya_proaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Tanggal Mulai</span>
                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                            </a>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control form-control-solid mb-3" name="tanggal_mulai"
                            id="tanggal_mulai" value="" placeholder="Tanggal Mulai" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Tanggal Selesai</span>
                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                            </a>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control form-control-solid mb-3" name="tanggal_selesai"
                            id="tanggal_selesai" value="" placeholder="Tanggal Selesai" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <hr>
                <h5 class="h5 fw-bolder text-center">Rencana Tindak Lanjut Reaktif</h5>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Rencana Tindak Lanjut (Mitigasi) Reaktif</span>
                            {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                            </a> --}}
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="tindak_lanjut_reaktif"
                            id="tindak_lanjut_reaktif" value="" placeholder="Rencana Tindak Lanjut (Mitigasi) Reaktif" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Biaya</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="biaya_reaktif"
                            id="biaya_reaktif" value="" placeholder="Biaya" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">PIC RTL</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="pic_rtl"
                            id="pic_rtl" value="" placeholder="PIC RTL" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>

                <hr>
                <h5 class="h5 fw-bolder text-center">Peluang</h5>

                <div class="row">
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Uraian</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="uraian"
                            id="uraian" value="" placeholder="Uraian" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                    <div class="col">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nilai</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="nilai"
                            id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                        <!--end::Input-->
                    </div>
                </div>
                <hr>
                <br>
                
                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>

                {{-- end::Read File --}}
                <button type="submit" id="save-risk" class="btn btn-lg btn-primary"
                    data-bs-dismiss="modal">Save</button>

            </form>
        </div>
        <!--end::Input group-->


    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Add Risk Project-->

<!--begin::Modal - List Questions-->
<div class="modal fade" id="kt_modal_question_proyek" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>Add Aanwitjzing</h2>
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
                <form action="/question/upload" enctype="multipart/form-data" method="POST">
                    @csrf
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                        name="id-contract">
                    <input type="hidden" class="modal-name" name="modal-name">

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Item</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid"
                        name="item" id="item" style="font-weight: normal"
                        value="" placeholder="Item" cols="2" ></textarea>
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Sub Pasal</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" name="sub-pasal"
                        id="sub-pasal" style="font-weight: normal" cols="2" value=""
                        placeholder="Sub"></textarea>
                    <!--end::Input-->
                    <small id="file-error-msg-question" style="color: rgb(199, 42, 42); display:none"></small>
                    
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Pertanyaan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea class="form-control form-control-solid" name="note-question"
                        id="note-question" style="font-weight: normal" cols="2" value=""
                        placeholder="Pertanyaan"></textarea>
                    <!--end::Input-->
                    <small id="file-error-msg-question" style="color: rgb(199, 42, 42); display:none"></small>

                    {{-- begin::Froala Editor --}}
                    {{-- <div id="froala-editor-question">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div> --}}
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    {{-- <script>
                        document.getElementById("attach-file-question").addEventListener("change", async function() {
                            await readFile(this.files[0], "#froala-editor-question");
                        });
                    </script> --}}
                    {{-- end::Read File --}}
                    <br><br>
                    <button type="submit" id="save-question" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>
                </form>
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Input group-->


    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - List Questions-->
<!--begin::Modal - Calendar Start -->
<div class="modal fade" id="kt_modal_calendar-start" data-bs-backdrop="static" tabindex="-1"
aria-hidden="true">
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
                    <i class="bi bi-x-lg"></i>
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
                        <button class="btn btn-sm fw-normal btn-primary"
                            style="background: #f3f6f9;color:black;" data-bs-dismiss="modal"
                            id="cancel-date-btn-start">Back</button>

                        <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                            style="background-color: #008CB4;color: white;"
                            id="set-calendar-start">Apply</button>

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

<!--begin::Modal - Calendar End -->
<div class="modal fade" data-bs-backdrop="static" id="kt_modal_calendar-end" tabindex="-1"
aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-300px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>End Date</h2>
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

            <!--begin:: Calendar-->
            <div class="fv-row mb-5">
                <div class="calendar" id="end-date">
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
                        <button class="btn btn-sm fw-normal btn-primary"
                            style="background: #f3f6f9;color:black;" data-bs-dismiss="modal"
                            id="cancel-date-btn-end">Back</button>

                        <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                            style="background-color: #008CB4;color: white;" id="set-calendar-end">Apply</button>
                        {{-- <button class="calendar__button calendar__button--grey" data-bs-dismiss="modal"
                                id="cancel-date-btn-end">Back</button>

                            <button class="calendar__button" data-bs-dismiss="modal"
                                style="background-color: #008CB4;color: white;" id="set-calendar-end">Apply</button> --}}
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
<!--end::Modal - Calendar End -->

<!--end::Modals-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
<span class="svg-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        fill="none">
        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
            transform="rotate(90 13 6)" fill="black" />
        <path
            d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
            fill="black" />
    </svg>
</span>
<!--end::Svg Icon-->
</div>
<!--end::Scrolltop-->
@endsection
@section('js-script')
<script src="{{ asset('/js/custom/pages/contract/contract.js') }}"></script>

<script>
    // const savePasalBtn = document.querySelector("#save-pasal");
    // const loadingElt = document.querySelector("#save-pasal > .spinner-border");
    // savePasalBtn.addEventListener("click", async e => {
    //     savePasalBtn.setAttribute("disabled", "");
    //     const pasalCheckboxes = document.querySelectorAll(".pasal");
    //     loadingElt.style.display = "block";
    //     let pasals = [];
    //     pasalCheckboxes.forEach((pasal) => {
    //         if (pasal.checked) {
    //             pasals.push(pasal.value);
    //         }
    //     });
    //     const formData = new FormData();
    //     let html = "";
    //     let counter = 1;
    //     formData.append("_token", '{{ csrf_token() }}');
    //     formData.append("pasals", pasals);
    //     const savePasal = await fetch("/pasal/save", {
    //         method: "POST",
    //         header: {
    //             "Content-Type": "application/json",
    //         },
    //         body: formData,
    //     }).then(res => res.json());
    //     if (savePasal.status == "success") {
    //         const pasals = JSON.parse(savePasal.pasals);
    //         modalDraftBoots.show();
    //         modalPasalBoots.hide();
    //         $("#draft-rekomendasi").select2({
    //             dropdownParent: $('#kt_modal_draft'),
    //             minimumResultsForSearch: Infinity,
    //         });
    //         // if (toaster.classList.contains("text-bg-danger")) {
    //         //     toaster.classList.remove("text-bg-danger");
    //         // }
    //         // toaster.classList.add("text-bg-success");
    //         document.querySelector(".toast-body").innerText = savePasal.message
    //         pasals.forEach((pasal) => {
    //             html += `
    //             <tr>
    //                 <td>
    //                     <span class="fw-normal fs-8">${counter++}</span>
    //                 </td>
    //                 <td>
    //                     <span class="fw-normal fs-8">${pasal.pasal}</span>
    //                 </td>
    //             </tr>
    //     `
    //         });
    //         document.querySelector("#kt_pasal_table tbody").innerHTML = html;
    //         // toasterBoots.show();
    //         document.querySelector("#clear-pasal").style.visibility = "visible";

    //     } else {
    //         // if (toaster.classList.contains("text-bg-success")) {
    //         //     toaster.classList.remove("text-bg-success");
    //         // }
    //         // toaster.classList.add("text-bg-danger");
    //         document.querySelector(".toast-body").innerText = savePasal.message
    //         // toasterBoots.show();

    //     }
    //     Toast.fire({
    //         html: savePasal.message,
    //         icon: savePasal.status,
    //     });
    //     loadingElt.style.display = "none";
    //     savePasalBtn.removeAttribute("disabled");
    // });
    // document.querySelector("#clear-pasal").addEventListener("click", async e => {
    //     const pasalCheckboxes = document.querySelectorAll(".pasal");
    //     const formData = new FormData();
    //     formData.append("_token", "{{ csrf_token() }}");
    //     const clearPasalsRes = await fetch("/pasal/clear", {
    //         method: "POST",
    //         body: formData,
    //     }).then(res => res.json());
    //     if (clearPasalsRes.status == "success") {
    //         document.querySelector(".toast-body").innerText = clearPasalsRes.message
    //         html = `
    //         <tr>
    //             <td colspan="2" class="text-center"><b>Pasal belum terpilih</b></td>
    //         </tr>
    //         `
    //         Toast.fire({
    //             icon: "success",
    //             text: "Pasal-pasal berhasil dihapus",
    //         });
    //         document.querySelector("#kt_pasal_table tbody").innerHTML = html;
    //         pasalCheckboxes.forEach(checkbox => {
    //             if (checkbox.checked) {
    //                 checkbox.checked = false;
    //             }
    //         })
    //     }

    //     document.querySelector("#clear-pasal").style.visibility = "hidden";
    // });
    // end::Script adding pasal

    new FroalaEditor('#froala-editor-terima', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-issue', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-review', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-draft', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-risk', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-question', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-draft-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-risk-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-question-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-issue-project-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-terima-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-bulanan-menang', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-klarifikasi-negosiasi', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-kontrak-tanda-tangan', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-perjanjian-kso', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-dokumen-pendukung', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-pembatalan-kontrak', {
        documentReady: true,
    });
    new FroalaEditor('#froala-editor-mom-meeting', {
        documentReady: true,
    });

    const proyekStage = Number("{{ $contract->stages ?? 0 }}");
    const tabContent = document.querySelector(`.nav li:nth-child(${proyekStage + 1}) a`);
    const tabBoots = new bootstrap.Tab(tabContent, {});
    tabBoots.show();

    async function pilihDraftKontrak(e, showEltResult, isList = false) {
        const idDraft = e.value;
        const idContract = "{{ $contract->id_contract ?? 0 }}";
        const getDraftContractRes = await fetch(
        `/contract-management/view/${idContract}/draft-contract/${idDraft}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            }
        }).then(res => res.json());
        if (getDraftContractRes.length > 0) {
            let html = "";
            if (isList) {
                getDraftContractRes.forEach(pasal => {
                    html += `
                    <li class="list-group-item">
                        <!--begin::Options-->
                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                        <input class="form-check-input" name="pasals[]" type="checkbox" value="${pasal}">
                        <span class="form-check-label">${pasal}</span>
                        </label>
                        <!--end::Options-->
                    </li>
                    `;
                });
            } else {
                getDraftContractRes.forEach(pasal => {
                    html += `- ${pasal} &#13;&#10;`;
                });
            }
            document.querySelector(showEltResult).innerHTML = html;
        } else {
            Toast.fire({
                icon: "error",
                text: "Pasal tidak ditemukan pada kontrak ini",
            });
        }
    }
</script>

@endsection


<!--begin::Aside-->
{{-- @section('aside')
@include('template.aside')
@endsection --}}
<!--end::Aside-->
