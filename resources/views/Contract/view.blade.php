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
    .buttons-html5 {
        border-radius: 5px !important;
        border: none !important;
        padding: 10 20 10 20 !important;
        font-weight: normal !important;
    }
    .buttons-colvis {
        border: none !important;
        border-radius: 5px !important;
    }
    .animate.slide {
        transition: .3s all linear;
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
<form action="/contract-management/update" method="post">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0 !important;">
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
                    @if ($contract->where("id_contract", "=", $contract->id_contract)->where("stages", "!=", 1)->get()->isNotEmpty())
                    <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                        style="background-color:#008CB4;">
                        Save</button>
                    @endif
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
                        {{-- <div class="row fv-row">
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
                                    <select name="rekomendasi-1" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Rekomendasi">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">

                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div> --}}
                        <!--End begin::Row-->

                        <!--begin::Card title-->
                        <div class="card-title m-0">

                            <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                Aanwitjzing
                                @if (!empty($contract->questionsProjects->toArray()))
                                    <a href="#" onclick="exportToExcel(this, '#data-aanwitjzing')" class="">(Klik di sini untuk Export ke Excel)</a>
                                @endif
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_question_proyek">+</a>
                                    @if (!empty($contract->questionsProjects->toArray()))
                                        <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_upload_aanwitjzing" class="btn btn-primary btn-sm p-2 mx-3 text-end">Upload</a>
                                    @endif
                            </h3>

                            <!--begin:Table: Review-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="data-aanwitjzing">
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
                                                    <!--begin::Column-->
                                                    <td>
                                                        {{ $questionProject->item }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        {{ $questionProject->sub_pasal }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        {{ $questionProject->note_question }}
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-400 text-hover-primary mb-1">
                                                            {{ Carbon\Carbon::createFromTimeString($questionProject->created_at)->translatedFormat("d F Y") }}</a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                </tr>
                                            @endif
                                        @empty
                                            
                                        @endforelse
                                    @else
                                        
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            @php
                                $uploadFileAanwitjzing = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "aanwitjzing")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFileAanwitjzing))
                            <a target="_blank" href="{{ asset('words/'.$uploadFileAanwitjzing->id_document) }}" class="text-hover-primary">
                            <small> <b>Download File :</b> {{ $uploadFileAanwitjzing->nama_document }}
                            </small></a>
                            @endif

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
                                                    <!--begin::Column-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $draftContract->id_draft }}"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ $draftContract->title_draft }}
                                                        </a>
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ $draftContract->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Column-->
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

                            <br>
                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                Tinjauan Dokumen Kontrak - Perolehan
                                @if ($contract->reviewProjects->where('stage', '=', 1)->isEmpty())
                                    <a href="/review-contract/view/{{ $contract->id_contract }}/stage/1" target="_blank" Id="Plus">+</a>    
                                    @else
                                    <a href="/review-contract/view/{{ $contract->id_contract }}/stage/1" target="_blank" class="btn btn-primary btn-sm p-2 px-3 mx-3">view</a>    
                                @endif
                                @if (!empty($contract->reviewProjects->toArray()))
                                        <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_upload_tinjauan_perolehan" class="btn btn-primary btn-sm p-2 text-end">Upload</a>
                                @endif
                            </h3>

                            @php
                                $uploadFilePerubahan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "tinjauan-perolehan")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePerubahan))
                                <a target="_blank" href="{{ asset('words/'.$uploadFilePerubahan->id_document) }}" class="text-hover-primary">
                                <small><b>Download File :</b> {{ $uploadFilePerubahan->nama_document }}</small>
                                </a>
                            @endif

                            <br><br>
                            <!--begin:Table: Review-->
                            {{-- <table class="table align-middle table-row-dashed fs-6 gy-5" id="tinjauan-kontrak">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Data</th>
                                        <th class="min-w-125px">Keterangan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <tbody class="fw-bold text-gray-400">
                                    @if (!empty($review[1]))
                                        <!--begin::Table body-->   
                                        <tr>
                                        <td>
                                            <a href="#" data-bs-target="#kt_modal_tabel_review_kontrak" class="text-hover-primary"><p>Lihat Review Kontrak Perolehan</p></a>
                                        </td>
                                        <td>
                                            <p>Terisi</p>
                                        </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>
                                                <p><b>There is no data.</b></p>
                                            </td>
                                        </tr>
                                        <!--end::Table body-->
                                    @endif
                                </tbody>
                            </table> --}}
                            <!--End:Table: Review-->


                            {{-- &nbsp;<br>
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
                                                    <!--begin::Column-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->verifikasi }}</p>
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->kategori }}</p>
                                                    </td>
                                                    <!--end::Column-->
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

                            </table> --}}
                            <!--End:Table: Review-->
                            <br>

                            

                        <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                            Input Resiko - Perolehan (<i class="text-hover-primary text-gray"><a 
                                                            href="https://crm.wika.co.id/faqs/104625_RiskTender_Input-Kosong.rev.xlsx"> Download
                                                            Template Risk Tender </a></i>)
                            {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_input_resiko_perolehan">+</a> --}}
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_upload_resiko_perolehan">+</a>
                        </h3>

                        <!--begin:Table: Review-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">File</th>
                                    <th class="min-w-125px">Tanggal</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @php
                                    $uploadResikoPerolehan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "resiko-perolehan")->first();
                                @endphp
                                    @if (!empty($uploadResikoPerolehan))
                                        <tr>
                                            <!--begin::Column-->
                                            <td>
                                                <!--End:Table: Review-->
                                                <a target="_blank" href="{{ asset('words/'.$uploadResikoPerolehan->id_document) }}" class="text-hover-primary">
                                                <p>{{ $uploadResikoPerolehan->nama_document }}</p>
                                                </a>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::tanggal=-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ Carbon\Carbon::createFromTimeString($uploadResikoPerolehan->created_at)->translatedFormat("d F Y") }}</p>
                                            </td>
                                            <!--end::tanggal=-->
                                        </tr>
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

                            <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                Usulan Perubahan Draft Kontrak
                                @if (!empty($contract->UsulanPerubahanDraft->toArray()))
                                    <a href="#" onclick="exportToExcel(this, '#usulan-draft')" class="">(Klik di sini untuk Export ke Excel)</a>
                                @endif
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_usulan_perubahan_draft_kontrak">+</a>
                                    @if (!empty($contract->UsulanPerubahanDraft->toArray()))
                                        <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_upload_perubahan_kontrak" class="btn btn-primary btn-sm p-2 mx-3 text-end">Upload</a>
                                    @endif
                            </h3>

                            <!--begin:Table: Review-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="usulan-draft">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Isu</th>
                                        <th class="min-w-auto">Kategori</th>
                                        <th class="min-w-auto">Deskripsi Klausul Awal</th>
                                        <th class="min-w-auto">Usulan Perubahan</th>
                                        <th class="min-w-auto">Keterangan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                        @php
                                            switch ($perubahan_draft->kategori) {
                                                case 1:
                                                    $kategori = "Surat Perjanjian Kontrak";
                                                    break;
                                                case 2:
                                                    $kategori = "Syarat-syarat Umum Kontrak (SSUK)";
                                                    # code...
                                                    break;
                                                case 3:
                                                    $kategori = "Syarat-syarat Khusus Kontak (SSKK)";
                                                    # code...
                                                    break;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{$perubahan_draft->isu}}</td>
                                            <td>{{$kategori}}</td>
                                            <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                            <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                            <td>{{$perubahan_draft->keterangan}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Review-->
                            @php
                            $uploadFilePerubahan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "usulan-perubahan")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePerubahan))
                            <a target="_blank" href="{{ asset('words/'.$uploadFilePerubahan->id_document) }}" class="text-hover-primary">
                            <small><b>Download File :</b> {{ $uploadFilePerubahan->nama_document }}</small>
                            </a>
                            @endif

                            &nbsp;<br>
                            &nbsp;<br>
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
                                                    <!--begin::Column-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->resiko }}</p>
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Column-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->penyebab }}</p>
                                                    </td>
                                                    <!--end::Column-->
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
    
                        </div>
                        
                    {{-- </div>
                    <!--end:::Tab pane Informasi Perusahaan-->

                    <!--begin:::Tab pane History-->
                    <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel"> --}}

                        <!--begin::Row-->
                        {{-- <div class="row fv-row">
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
                        </div> --}}
                        <!--End begin::Row-->

                        &nbsp;<br>
                        &nbsp;<br>

                        <!--begin::Card title-->
                        <div class="card-title m-0">

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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $perjanjian_kso->id_perjanjian_kso }}/{{ $perjanjian_kso->id_document }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $perjanjian_kso->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $perjanjian_kso->User->name }}</p>
                                                </td>
                                                <!--end::Column-->
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

                            {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $dokumen_pendukung->id_dokumen_pendukung }}/{{ $dokumen_pendukung->id_document }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $dokumen_pendukung->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->User->name }}
                                                    </p>
                                                </td>
                                                <!--end::Column-->
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
                            <!--End:Table: Review--> --}}
                        </div>
                    </div>
                    <!--end:::Tab pane History-->

                    <!--begin:::Tab pane Laporan Bulanan-->
                    <div class="tab-pane fade" id="kt_user_view_overview_Performance" role="tabpanel">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                        class="text-gray-600 {{ $classes }} text-hover-primary mb-1">
                                                        {{ $monthlyReport->document_name_report }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $monthlyReport->id_document }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
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
                            <!--End:Table: Laporan Bulanan--> --}}

                            {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract/{{ $addendumContract->id_addendum }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $addendumContract->no_addendum }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $addendumContract->created_by }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
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
                            <br> --}}


                            {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/claim-management/view/{{ $claimManagement->id_claim }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $claimManagement->id_claim }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $claimManagement->pic }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
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
                            <!--End:Table: Claim Contract--> --}}

                            {{-- <br> --}}

                            {{-- <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $mom_meeting->id_mom }}/{{ $mom_meeting->id_document }}"
                                                        class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $mom_meeting->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $mom_meeting->User->name }}</p>
                                                </td>
                                                <!--end::Column-->
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
                            <!--End:Table: Claim Contract--> --}}

                            <div class="row mb-5">
                                <div class="col-6">
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        LAW
                                    </h3>
                                </div>
                                <div class="col-6">
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        LD
                                    </h3>
                                </div>
                            </div>
                            {{-- <form action="/ld-law/upload" enctype="multipart/form-data" method="POST">
                                @csrf --}}
                                <div class="row">
                                    <div class="col-6 mr-3">
                                        <!--begin::Input-->
                                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                        name="id-contract">
                                    <input type="hidden" class="modal-name" name="modal-name">
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Governing Law</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" id="governing-law" name="governing-law" class="form-control form-control-solid" 
                                    value="{{ !empty($contract->law_governing) ? $contract->law_governing : "" }}">
                                    <!--end::Input-->
    
                                    <br>
                                    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Dispute Resolution</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" id="dispute-resolution" name="dispute-resolution" class="form-control form-control-solid"
                                    value="{{ !empty($contract->law_dispute_resolution) ? $contract->law_dispute_resolution : "" }}">
                                    <!--end::Input-->
                                    
                                    <br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Prevailing Language</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" id="prevailing-language" name="prevailing-language" class="form-control form-control-solid"
                                    value="{{ !empty($contract->law_prevailing_language) ? $contract->law_prevailing_language : "" }}">
                                    <!--end::Input-->
                                    </div>
                                    <div class="col-6">
                                        <!--begin::Input-->
                                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                            name="id-contract">
                                        <input type="hidden" class="modal-name" name="modal-name">
        
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Delay</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="delay" name="delay" class="form-control form-control-solid"
                                        value="{{ !empty($contract->ld_delay) ? $contract->ld_delay : "" }}">
                                        <!--end::Input-->
        
                                        <br>
                                        
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Performance</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="performance" name="performance" class="form-control form-control-solid"
                                        value="{{ !empty($contract->ld_performance) ? $contract->ld_performance : "" }}">
                                        <!--end::Input-->
                                    </div>
                                </div>
{{-- 
                                <div class="d-flex justify-content-end">
                                    <button type="submit" id="save-question" class="btn btn-sm btn-primary"
                                        data-bs-dismiss="modal">Save</button>
                                </div>
                            </form> --}}

                        <hr>
                        <br>
                        <br>


                            <h3 class="fw-bolder m-0 mb-3" id="HeadDetail" style="font-size:14px;">
                                Input Resiko - Pelaksanaan (<i class="text-hover-primary text-gray"><a 
                                    href="https://crm.wika.co.id/faqs/104625_RiskTender_Input-Kosong.rev.xlsx"> Download
                                    Template Risk Tender </a></i>)
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_input_resiko_pelaksanaan">+</a>
                            </h3>

                            <!--begin:Table: Review-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="input-risk">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Periode</th>
                                        <th class="min-w-125px">File</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @php
                                        $uploadResikoPelaksanaan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "resiko-pelaksanaan");
                                    @endphp
                                    @forelse ($uploadResikoPelaksanaan as $inputRisk)
                                        <tr>
                                            <!--begin::Column-->
                                            <td>
                                                <p class="text-gray-600 mb-1">{{ Carbon\Carbon::createFromFormat("m-Y", $inputRisk->periode)->translatedFormat("F Y") }}</p>
                                            </td>
                                            <td>
                                                <!--End:Table: Review-->
                                                <a target="_blank" href="{!! asset('words/'.$inputRisk->id_document) !!}" class="text-hover-primary">
                                                <p>{{ $inputRisk->nama_document }}</p>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Review-->
                            
                            @php
                            $uploadFileResiko = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "resiko-pelaksanaan")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFileResiko))
                            <a target="_blank" href="{{ asset('words/'.$uploadFileResiko->id_document) }}" class="text-hover-primary">
                            <small><b>Download File :</b> {{ $uploadFileResiko->nama_document }}</small>
                            </a>
                            @endif
                            <br><br><br>

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
                                        <th class="min-w-125px">Nama File</th>
                                        <th class="min-w-125px">Tanggal Upload</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->RencanaKerjaManajemen->count() > 0)
                                        @forelse ($contract->RencanaKerjaManajemen as $key => $rencana_kerja)
                                            <tr>
                                                <!--begin::Column-->
                                                <td>
                                                    <a target="_blank" href="{{ asset('words/'.$rencana_kerja->id_document) }}" class="text-hover-primary">
                                                        {{ $rencana_kerja->nama_document }}
                                                    </a>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ Carbon\Carbon::parse($rencana_kerja->created_at)->translatedFormat("d F Y") }}</p>
                                                </td>
                                                <!--end::Column-->
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

                            <br>
                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                Tinjauan Dokumen Kontrak - Pelaksanaan
                                @if ($contract->reviewProjects->where('stage', '=', 2)->isEmpty())
                                    <a href="/review-contract/view/{{ $contract->id_contract }}/stage/2" target="_blank" Id="Plus">+</a>    
                                    @else
                                    <a href="/review-contract/view/{{ $contract->id_contract }}/stage/2" target="_blank" class="btn btn-primary btn-sm p-2 px-3 mx-3">view</a>    
                                @endif
                            </h3>

                            <br><br>
                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                Idetifikasi Pasal Kontraktual
                                @if ($contract->PasalKontraktual->isNotEmpty())
                                <a href="#" onclick="exportToExcel(this, '#kt_pasal_kontraktual')" class="">(Klik di sini untuk Export ke Excel)</a>
                                @endif
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_input_pasal_kontraktual">+</a>
                                @if (!empty($contract->PasalKontraktual->toArray()))
                                    <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_upload_pasal_kontraktual" class="btn btn-primary btn-sm p-2 mx-3 text-end">Upload</a>
                                @endif
                            </h3>

                            <!--begin:Table: Pasal Kontraktual-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="pasal_kontraktual">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-125px">Item</th>
                                        <th class="min-w-125px">Pasal</th>
                                        <th class="min-w-125px">Perpanjangan Waktu</th>
                                        <th class="min-w-125px">Tambahan Biaya</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->PasalKontraktual->count() > 0)
                                        @forelse ($contract->PasalKontraktual as $key => $pk)
                                            <tr>
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $key + 1 }}</p>
                                                </td>
                                                <!--begin::Column-->
                                                <td>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! $pk->item !!}</pre>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! $pk->pasal !!}</pre>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! Carbon\Carbon::create($pk->perpanjangan_waktu)->translatedFormat("d F Y") !!}</pre>
                                                </td>
                                                <!--end::Column-->
                                                <!--begin::Column-->
                                                <td>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! number_format($pk->tambahan_biaya, 0, ".", ".") !!}</pre>
                                                </td>
                                                <!--end::Column-->
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
                                            <td colspan="5" class="text-center">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Pasal Kontraktual-->
                            @php
                            $uploadFilePasalKontraktual = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "pasal-kontraktual")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePasalKontraktual))
                            <a target="_blank" href="{{ asset('words/'.$uploadFilePasalKontraktual->id_document) }}" class="text-hover-primary">
                            <small><b>Download File :</b> {{ $uploadFilePasalKontraktual->nama_document }}</small>
                            </a>
                            @endif
                            <br><br><br>

                            <h3 class="fw-bolder m-0 mb-3 " id="HeadDetail" style="font-size:14px;">
                                Perubahan Kontrak
                                @if (!empty($contract->PerubahanKontrak->toArray()))
                                    <a href="#" onclick="exportToExcel(this, '#perubahan-kontrak')" class="">(Klik di sini untuk Export ke Excel)</a>
                                @endif
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_input_perubahan_kontrak">+</a>
                                @if (!empty($contract->PerubahanKontrak->toArray()))
                                    <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_upload_perubahan" class="btn btn-primary btn-sm p-2 mx-3 text-end">Upload</a>
                                @endif
                            </h3>


                            <!--begin:Table: Perubahan Kontrak-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 w-100 p-3" id="perubahan-kontrak">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Jenis Perubahan</th>
                                        <th class="min-w-auto">Tanggal Perubahan</th>
                                        <th class="min-w-auto">Uraian Perubahan</th>
                                        <th class="min-w-auto">Jenis Dokumen</th>
                                        <th class="min-w-auto">Nomor Dokumen</th>
                                        <th class="min-w-auto">No Proposal Klaim</th>
                                        <th class="min-w-auto">Tanggal Pengajuan</th>
                                        <th class="min-w-auto">Biaya Pengajuan</th>
                                        <th class="min-w-auto">Waktu Pengajuan</th>
                                        <th class="min-w-auto">Status</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @forelse ($contract->PerubahanKontrak as $key => $pk)
                                        <tr class="fw-bold">
                                            <td>
                                                <small>
                                                    <a target="_blank" href="/contract-management/view/{{url_encode($contract->id_contract)}}/perubahan-kontrak/{{$pk->id_perubahan_kontrak}}" class="text-hover-primary">{{ $pk->jenis_perubahan }}</a>
                                                </small>
                                            </td>
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! Carbon\Carbon::create($pk->tanggal_perubahan)->translatedFormat("d F Y") !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! $pk->uraian_perubahan !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            @if (!empty($pk->JenisDokumen->toArray()))
                                                @php
                                                    $jenis_dokumen = $pk->JenisDokumen;
                                                    $kategori_dokumen_list = $jenis_dokumen->map(function($item) {
                                                        return $item->jenis_dokumen;
                                                    });
                                                    $dokumen_list = $jenis_dokumen->map(function($item) {
                                                        $new_class = new stdClass();
                                                        $new_class->jenis_dokumen = $item->jenis_dokumen;
                                                        $new_class->list_instruksi_owner = explode(",", $item->list_instruksi_owner);
                                                        return $new_class;
                                                    });
                                                    // dd($dokumen_list);
                                                @endphp
                                                <td class="align-middle">
                                                    @foreach ($kategori_dokumen_list as $kategori)
                                                        <small class="text-gray-600 mb-1 fw-normal">
                                                            {{-- <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';"></pre> --}}
                                                            - {!! $kategori !!}   
                                                        </small><br><br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <small>
                                                        @foreach ($dokumen_list as $lio)
                                                            @foreach ($lio->list_instruksi_owner as $dokumen)
                                                                @switch($lio->jenis_dokumen)
                                                                    @case("Site Instruction")
                                                                            @php
                                                                                $lio = App\Models\SiteInstruction::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Technical Form")
                                                                            @php
                                                                                $lio = App\Models\TechnicalForm::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Technical Query")
                                                                            @php
                                                                                $lio = App\Models\TechnicalQuery::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Field Design Change")
                                                                            @php
                                                                                $lio = App\Models\FieldChange::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Contract Change Notice")
                                                                            @php
                                                                                $lio = App\Models\ContractChangeNotice::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Contract Change Proposal")
                                                                            @php
                                                                                $lio = App\Models\ContractChangeProposal::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                    @case("Contract Change Order")
                                                                            @php
                                                                                $lio = App\Models\ContractChangeOrder::where("nomor_dokumen" , "=", $dokumen)->get()->first();
                                                                            @endphp
                                                                        @break
                                                                @endswitch
                                                                - <a target="_blank" class="text-hover-primary" href="{{ asset("words/$lio->id_document.pdf"); }}">{{$lio->nomor_dokumen}}</a> <br>
                                                            @endforeach
                                                        @endforeach
                                                    </small>
                                                </td>
                                            @else
                                                <td>
                                                    <small>
                                                        <p class="mb-1 fw-normal badge badge-light-danger" style="font-family: 'Poppins';">Belum Ditentukan</p>
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>
                                                        <p class="mb-1 fw-normal badge badge-light-danger" style="font-family: 'Poppins';">Belum Ditentukan</p>
                                                    </small>
                                                </td>
                                            @endif
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! $pk->proposal_klaim !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! Carbon\Carbon::create($pk->tanggal_pengajuan)->translatedFormat("d F Y") !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! number_format($pk->biaya_pengajuan, 0, ".", ".") !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                <small>
                                                    <pre class="text-gray-600 mb-1 fw-normal" style="font-family: 'Poppins';">{!! Carbon\Carbon::create($pk->waktu_pengajuan)->translatedFormat("d F Y") !!}</pre>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                            <!--begin::Column-->
                                            <td>
                                                @php
                                                    $class_name = "";
                                                    $status = "";
                                                    if($pk->status) {
                                                        $class_name = "badge badge-light-danger";
                                                        $status = "Open";
                                                    } else {
                                                        $class_name = "badge badge-light-success";
                                                        $status = "Closed";
                                                    }
                                                @endphp
                                                <small>
                                                    <p class="{{$class_name}}">{{$status}}</p>
                                                </small>
                                            </td>
                                            <!--end::Column-->
                                        </tr>
                                    @empty
                                    @endforelse
                                    
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Perubahan Kontrak-->
                            @php
                                $uploadFilePerubahan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "perubahan-kontrak")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePerubahan))
                                <a target="_blank" href="{{ asset('words/'.$uploadFilePerubahan->id_document) }}" class="text-hover-primary">
                                <small><b>Download File :</b> {{ $uploadFilePerubahan->nama_document }}</small>
                                </a>
                            @endif

                            <br>
                            <br>

                            <!--Begin::Klaim Jaminan-->
                            <h3 class="fw-bolder m-0 mb-3 " id="HeadDetail" style="font-size:14px;">
                                Jaminan
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_jaminan">+</a>
                            </h3>

                            <!--Begin::Tabel-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Kategori Jaminan</th>
                                        <th class="min-w-125px">Nomor Jaminan</th>
                                        <th class="min-w-125px">Penerbit Jaminan</th>
                                        <th class="min-w-125px">Tanggal Penerbitan</th>
                                        <th class="min-w-125px">Tanggal Berakhir</th>
                                        {{-- <th class="min-w-125px">Status</th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                <tbody class="fw-bold text-gray-400">
                                    @if (!empty($contract->Jaminan))
                                    @forelse ($contract->Jaminan as $jaminan )
                                    <tr>
                                        <td>
                                            <p class="text-gray-600 mb-1">{{ $jaminan->kategori_jaminan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-gray-600 mb-1">{{ $jaminan->nomor_jaminan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-gray-600 mb-1">{{ $jaminan->penerbit_jaminan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($jaminan->tanggal_penerbitan)->translatedFormat("d F Y")}}</p>
                                        </td>
                                        <td>
                                            <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($jaminan->tanggal_berakhir)->translatedFormat("d F Y")}}</p>
                                        </td>
                                        {{-- <td>
                                            <p class="badge mb-1 {{ $jaminan->status == "Valid" ? "badge-light-success text-success" : "badge-light-danger text-danger" }}">{{ $jaminan->status }}</p>
                                        </td> --}}
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
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--End::Tabel-->

                        <!--End::Klaim Jaminan--> 
                        <br>
                        <br>

                        <!--Begin::Klaim Asuransi-->
                        <h3 class="fw-bolder m-0 mb-3 " id="HeadDetail" style="font-size:14px;">
                            Asuransi
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_asuransi">+</a>
                        </h3>

                        <!--Begin::Tabel-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    {{-- <th class="min-w-125px">Nama Dokumen</th> --}}
                                    <th class="min-w-125px">Kategori Asuransi</th>
                                    <th class="min-w-125px">Nomor Polis</th>
                                    <th class="min-w-125px">Penerbit Polis</th>
                                    <th class="min-w-125px">Tanggal Penerbitan</th>
                                    <th class="min-w-125px">Tanggal Berakhir</th>
                                    {{-- <th class="min-w-125px">Status</th> --}}
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @if (!empty($contract->Asuransi))
                                @forelse ($contract->Asuransi as $asuransi )
                                <tr>
                                    <td>
                                        <p class="text-gray-600 mb-1">{{ $asuransi->kategori_asuransi }}</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 mb-1">{{ $asuransi->nomor_polis }}</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 mb-1">{{ $asuransi->penerbit_polis }}</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($asuransi->tanggal_penerbitan)->translatedFormat("d F Y")}}</p>
                                    </td>
                                    <td>
                                        <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($asuransi->tanggal_berakhir)->translatedFormat("d F Y")}}</p>
                                    </td>
                                    {{-- <td>
                                        <p class="badge mb-1 {{ $asuransi->status == "Valid" ? "badge-light-success text-success" : "badge-light-danger text-danger" }}">{{ $asuransi->status }}</p>
                                    </td> --}}
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
                        <!--End::Tabel-->
                    <!--End::Klaim Asuransi-->
                    <br>
                    <br>

                            <h3 class="fw-bolder m-0 mb-3 " id="HeadDetail" style="font-size:14px;">
                                Checklist Manajemen Kontrak
                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_input_checklist_manajemen">+</a>
                                @if (!empty($contract->ChecklistManajemen->toArray()))
                                <a href="#" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_upload_checklist_manajemen" class="btn btn-primary btn-sm p-2 text-end ml-2">Upload</a>
                                @endif
                            </h3>

                            <!--begin:Table: Checklist Manajemen Kontrak-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="checklist-manajemen-kontrak">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Kategori</th>
                                        <th class="min-w-auto">Tanggal Pembuatan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @forelse ($contract->ChecklistManajemen as $key => $cm)
                                        <tr>
                                            <td><a onclick="getChecklistManajemen(this)" style="cursor: pointer;" data-url="/contract-management/view/{{ $contract->id_contract}}/get-manajemen-kontrak/{{ $cm->id }}" class="text-hover-primary">{{ $cm->kategori }}</a></td>
                                            <td>{{ Carbon\Carbon::create($cm->created_at)->translatedFormat("d F Y") }}</td>
                                        </tr>
                                    @empty
                                    @endforelse                                
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Checklist Manajemen Kontrak-->
                            @php
                                $uploadFilePerubahan = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "checklist-pelaksanaan")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePerubahan))
                                <a target="_blank" href="{{ asset('words/'.$uploadFilePerubahan->id_document) }}" class="text-hover-primary">
                                <small><b>Download File :</b> {{ $uploadFilePerubahan->nama_document }}</small>
                                </a>
                            @endif

                            <br>
                            <br>
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
                                        <th class="min-w-125px">File</th>
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
                                                <!--begin::Uraian-->
                                                <td>
                                                    {{ $site_instruction->nomor_dokumen }}
                                                </td>
                                                <!--end::Uraian-->
                                                <!--begin::Nomor Dokumen-->
                                                <td>
                                                    {{ Carbon\Carbon::parse($site_instruction->tanggal_dokumen)->translatedFormat("d F Y") }}
                                                </td>
                                                <!--end::Nomor Dokumen-->
                                                <!--begin::Uraian-->
                                                <td>
                                                    <pre style="font-family: Poppins">{!! $site_instruction->uraian_dokumen !!}</pre>
                                                </td>
                                                <!--end::Uraian-->
                                                <!--begin::Nomor Dokumen-->
                                                <td>
                                                    <a target="_blank" href="{{ asset('words/'.$site_instruction->id_document) }}" class="text-hover-primary">
                                                        {{ $site_instruction->id_document }}
                                                    </a>
                                                </td>
                                                <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $technical_form->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($technical_form->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $technical_form->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$technical_form->id_document) }}" class="text-hover-primary">
                                                    {{ $technical_form->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $technical_query->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($technical_query->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $technical_query->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$technical_query->id_document) }}" class="text-hover-primary">
                                                    {{ $technical_query->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $field_change->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($field_change->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $field_change->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$field_change->id_document) }}" class="text-hover-primary">
                                                    {{ $field_change->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $change_notice->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($change_notice->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $change_notice->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$change_notice->id_document) }}" class="text-hover-primary">
                                                    {{ $change_notice->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $change_proposal->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($change_proposal->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $change_proposal->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$change_proposal->id_document) }}" class="text-hover-primary">
                                                    {{ $change_proposal->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                        <th class="min-w-125px">File</th>
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
                                            <!--begin::Uraian-->
                                            <td>
                                                {{ $change_order->nomor_dokumen }}
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                {{ Carbon\Carbon::parse($change_order->tanggal_dokumen)->translatedFormat("d F Y") }}
                                            </td>
                                            <!--end::Nomor Dokumen-->
                                            <!--begin::Uraian-->
                                            <td>
                                                <pre style="font-family: Poppins">{!! $change_order->uraian_dokumen !!}</pre>
                                            </td>
                                            <!--end::Uraian-->
                                            <!--begin::Nomor Dokumen-->
                                            <td>
                                                <a target="_blank" href="{{ asset('words/'.$change_order->id_document) }}" class="text-hover-primary">
                                                    {{ $change_order->id_document }}
                                                </a>
                                            </td>
                                            <!--end::Nomor Dokumen-->
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
                                                            <!--begin::Column-->
                                                            <td>
                                                                {{-- <a href="/document/view/{{ $contract->id_contract }}/{{ $ba_defect }}"
                                                                    class="text-gray-600 text-hover-primary">Dokumen BA Defect
                                                                    #{{ $key + 1 }}</a> --}}
                                                                <a target="_blank" href="{{ asset('words/' . $ba_defect . '.pdf') }}" class="text-gray-400 text-hover-primary">Klik Dokumen BA Defect Disini</a>
                                                            </td>
                                                            <!--end::Column-->
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
                                    </div>
                                </div>

                                @if (!empty($contract->list_dokumen_ba_defect))
                                
                                <br>
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
                                    <br>
                                @endif
                                {{-- <button type="submit" class="btn btn-sm btn-active-primary text-white"
                                    style="background-color: #008cb4;">Save Dokumen Bast</button> --}}
                            {{-- </form> --}}
                            <br>    

                            {{-- <hr> --}}
                            <div class="row">
                                <div class="col">
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Input Resiko - Pemeliharaan
                                        <a href="#" Id="Plus" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_input_resiko_pemeliharaan">+</a>
                                    </h3>

                                    <!--begin:Table: Review-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">Kategori</th>
                                                <th class="min-w-125px">Kriteria</th>
                                                <th class="min-w-125px">Penyebab</th>
                                                <th class="min-w-125px">Risiko</th>
                                                <th class="min-w-125px">Dampak</th>
                                                <th class="min-w-125px">Status</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            @forelse ($contract->inputRisks as $inputRisk)
                                                @if ($inputRisk->stage <= 3)
                                                <tr>
                                                    <!--begin::Column-->
                                                    <td>
                                                        <a href="#" Id="edit_resiko_perolehan" data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_edit_resiko_perolehan_{{ $inputRisk->id_risk }}"><p class="text-gray-600 mb-1 text-hover-primary">{{ $inputRisk->kategori }}</p></a>
                                                    </td>
                                                    <!--end::Column-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->kriteria }}</p>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->penyebab }}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->resiko_peluang }}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p class="text-gray-600 mb-1">{{ $inputRisk->dampak }}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        @php
                                                            $status = $inputRisk->is_closed == 0 ? "Open" : "Closed";
                                                            $class = $inputRisk->is_closed == 0 ? "badge-light-success text-success" : "badge-light-danger text-danger";
                                                        @endphp
                                                        <p class="mb-1 badge {{$class}}">{{ $status }}</p>
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
                                        </tbody>
                                        <!--end::Table body-->

                                    </table>

                                </div>
                            </div>

                        </div>

                        {{-- list_dokumen_ba_defect --}}
                        <br>
                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                            Pending Issue
                            @if (!empty($contract->PendingIssue->toArray()))
                                <a href="#" onclick="exportToExcel(this, '#pending-issue')" class="">(Klik di sini untuk Export ke Excel)</a>
                            @endif
                            <a href="#" Id="Plus" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_pending_issue">+</a>
                            @if (!empty($contract->PendingIssue->toArray()))
                                <a href="#" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_upload_pending_issue" class="btn btn-primary btn-sm p-2 mx-3 text-end">Upload</a>
                            @endif
                        </h3><br>

                        <!--begin:Table: List Defect BA-->
                        <table class="table align-middle table-row-dashed dataTable fs-6 gy-5" id="pending-issue">
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
                                            <!--end::Column-->
                                            
                                            <td>
                                                <p class="text-gray-600">{{ $pending_issue->penyebab }}</p>
                                            </td>

                                            @if ($pending_issue->status)
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600">Open</p>
                                                </td>
                                                <!--end::Column-->
                                            @else
                                                <!--begin::Column-->
                                                <td>
                                                    <p class="text-gray-600">Closed</p>
                                                </td>
                                                <!--end::Column-->
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        @php
                            $uploadFilePending = $contract->UploadFinal->where('id_contract', '=', $contract->id_contract)->where('category', '=', "Pending Issue")->first();
                            @endphp
                            <!--End:Table: Review-->
                            @if (!empty($uploadFilePending))
                                <a target="_blank" href="{{ asset('words/'.$uploadFilePending->id_document) }}" class="text-hover-primary">
                                <small><b>Download File :</b> {{ $uploadFilePending->nama_document }}</small>
                                </a>
                            @endif
                        <br><br>


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
                                            <!--begin::Column-->
                                            <td>
                                                <a href="/document/view/{{ $contract->id_contract }}/{{ $dokumen_pendukung }}"
                                                    class="text-gray-600 text-hover-primary">Dokumen Lainnya
                                                    #{{ $key + 1 }}</a>
                                            </td>
                                            <!--end::Column-->
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

            <button type="submit" id="save-terima" class="btn btn-sm btn-primary"
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

            <button type="submit" id="save-draft" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-draft-tender-menang" class="btn btn-sm btn-primary"
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
    {{--  --}}
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

                    <button type="submit" id="save-review-klarifikasi-negosiasi" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-review-kontrak-tanda-tangan" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-review-perjanjian-kso" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-review-pembatalan-kontrak" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-review-dokumen-pendukung" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-review-mom-meeting" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-issue-project-tender-menang" class="btn btn-sm btn-primary"
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

    <!--begin::Modal - Input Resiko Perolehan-->
    <div class="modal fade" id="kt_modal_input_resiko_perolehan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Proyek - Perolehan</h2>
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
                        <input type="hidden" value="0" name="is-closed">
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
                                    style="font-weight: normal" value="{{ auth()->user()->UnitKerja->unit_kerja ?? auth()->user()->name }}" placeholder="Verifikasi" readonly/>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kategori" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih kategori"
                                    tabindex="-1" aria-hidden="true" required>
                                    <option value=""></option>
                                    <option value="Kategori 1">Kategori 1</option>
                                    <option value="Kategori 2">Kategori 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kriteria" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Kriteria 1">Kriteria 1</option>
                                    <option value="Kriteria 2">Kriteria 2</option>
                                </select>
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
                                <select name="probis_1_2" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Level 1 - 2"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Probis 1">Probis 1</option>
                                    <option value="Probis 2">Probis 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="probis_terganggu" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Yang Terganggu"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Probis Terganggu 1">Probis Terganggu 1</option>
                                    <option value="Probis Terganggu 2">Probis Terganggu 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="penyebab" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Penyebab"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Penyebab 1">Penyebab 1</option>
                                    <option value="Penyebab 2">Penyebab 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="resiko_peluang" id="resiko_peluang" class="form-control form-control-solid mb-3" style="font-weight: normal" value=""></textarea>
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="dampak" id="dampak" class="form-control form-control-solid mb-3" style="font-weight: normal" value=""></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai_resiko_r0"
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
                                <select name="probabilitas" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probabilitas"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            {{-- <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div> --}}
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Skor</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="skor"
                                    id="skor" value="100" placeholder="Skor" style="font-weight: normal" readonly />
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
                                <select name="tingkat_efektifitas_kontrol" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Kontrol"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Tingkat Efektifitas Kontrol 1">Tingkat Efektifitas Kontrol 1</option>
                                    <option value="Tingkat Efektifitas Kontrol 2">Tingkat Efektifitas Kontrol 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai_resiko_r1"
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
                                <textarea name="tindak_lanjut_mitigasi" id="tindak_lanjut_mitigasi" class="form-control form-control-solid mb-3"></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="tingkat_efektifitas_tindak_lanjut" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Tindak lanjut"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 1">Tingkat Efektifitas Tindak lanjut 1</option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 2">Tingkat Efektifitas Tindak lanjut 2</option>
                                </select>
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
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_proaktif"
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
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_reaktif"
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
                                <select name="pic_rtl" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="PIC RTL"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="PIC RTL 1">PIC RTL 1</option>
                                    <option value="PIC RTL 2">PIC RTL 2</option>
                                </select>
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
                                <textarea name="uraian" id="uraian" class="form-control form-control-solid mb-3"></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai"
                                    id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
                            data-bs-dismiss="modal">Save</button>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Perolehan-->

    <!--begin::Modal - Upload Final Resiko Perolehan-->
    <div class="modal fade" id="kt_modal_upload_resiko_perolehan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Upload File Resiko Perolehan</h2>
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
                    <form action="/contract-management/final-dokumen/upload" method="POST"
                        enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            <div class="col mt-4">
                                <!--begin::Label-->
                                <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Upload Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="hidden" name="kategori" value="resiko-perolehan">
                                <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".xlsx">
                                <!--end::Input-->
                            </div>
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">
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
    <!--end::Modal - Upload Final Resiko Perolehan-->

    <!--begin::Modal - Input Resiko Perolehan-->
    @foreach ($contract->inputRisks as $inputRisk)
    <div class="modal fade" id="kt_modal_edit_resiko_perolehan_{{$inputRisk->id_risk}}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Edit Resiko Proyek - Perolehan</h2>
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

                    <form action="/input-risk/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="1" name="is-tender-menang">
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" value="{{ $contract->id_contract}}" name="id-contract">
                        <input type="hidden" value="{{ $inputRisk->id_risk}}" name="id-risk">
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Verifikasi</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="verifikasi" id="verifikasi"
                                    style="font-weight: normal" value="{{ auth()->user()->UnitKerja->unit_kerja ?? auth()->user()->name }}" placeholder="Verifikasi" readonly/>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kategori" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih kategori"
                                    tabindex="-1" aria-hidden="true" required>
                                    <option value=""></option>
                                    @if (!empty($inputRisk->kategori))
                                    <option value="{{ $inputRisk->kategori }}" selected>{{ $inputRisk->kategori }}</option>
                                    <option value="Kategori 1">Kategori 1</option>
                                    @else
                                    <option value="Kategori 1">Kategori 1</option>
                                    <option value="Kategori 2">Kategori 2</option>    
                                    @endif
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kriteria" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->kriteria))
                                    <option value="{{ $inputRisk->kriteria }}" selected>{{ $inputRisk->kriteria }}</option>
                                    <option value="Kriteria 1">Kriteria 1</option>
                                    @else
                                    <option value="Kriteria 1">Kriteria 1</option>
                                    <option value="Kriteria 2">Kriteria 2</option>    
                                    @endif
                                </select>
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
                                <select name="probis_1_2" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Level 1 - 2"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value=""></option>
                                    @if (!empty($inputRisk->probis_1_2))
                                    <option value="{{ $inputRisk->probis_1_2 }}" selected>{{ $inputRisk->probis_1_2 }}</option>
                                    <option value="Probis 1">Probis 1</option>
                                    <option value="Probis 2">Probis 2</option>
                                    @else
                                    <option value="Probis 1">Probis 1</option>
                                    <option value="Probis 2">Probis 2</option>    
                                    @endif
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="probis_terganggu" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Yang Terganggu"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->probis_terganggu))
                                    <option value="{{ $inputRisk->probis_terganggu }}" selected>{{ $inputRisk->probis_terganggu }}</option>
                                    <option value="Probis Terganggu 1">Probis Terganggu 1</option>
                                    <option value="Probis Terganggu 2">Probis Terganggu 2</option>
                                    @else
                                    <option value="Probis Terganggu 1">Probis Terganggu 1</option>
                                    <option value="Probis Terganggu 2">Probis Terganggu 2</option>
                                    @endif
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="penyebab" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Penyebab"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->penyebab))
                                    <option value="{{ $inputRisk->penyebab }}" selected>{{ $inputRisk->penyebab }}</option>
                                    <option value="Penyebab 1">Penyebab 1</option>
                                    <option value="Penyebab 2">Penyebab 2</option>
                                    @else
                                    <option value="Penyebab 1">Penyebab 1</option>
                                    <option value="Penyebab 2">Penyebab 2</option>
                                    @endif
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="resiko_peluang" id="resiko_peluang" class="form-control form-control-solid mb-3">{!! $inputRisk->resiko_peluang !!}</textarea>
                                <!--end::Input-->
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="dampak" id="dampak" class="form-control form-control-solid mb-3">{!! $inputRisk->dampak !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai_resiko_r0"
                                    id="nilai_resiko_r0" value="{{ $inputRisk->nilai_resiko_r0 }}" placeholder="Nilai Resiko / Peluang (Ro)" style="font-weight: normal" />
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
                                    id="item_kontrol" value="{{ $inputRisk->item_kontrol }}" placeholder="Item Kontrol" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probabilitas</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="probabilitas" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probabilitas"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->probabilitas))
                                    <option value="{{ $inputRisk->probabilitas }}" selected>{{ $inputRisk->probabilitas }}</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    @else
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    @endif
                                </select>
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
                                    id="skor" value="{{ $inputRisk->skor }}" placeholder="Skor" style="font-weight: normal" readonly />
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
                                <select name="tingkat_efektifitas_kontrol" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Kontrol"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->tingkat_efektifitas_kontrol))
                                    <option value="{{ $inputRisk->tingkat_efektifitas_kontrol }}" selected>{{ $inputRisk->tingkat_efektifitas_kontrol }}</option>
                                    <option value="Tingkat Efektifitas Kontrol 1">Tingkat Efektifitas Kontrol 1</option>
                                    <option value="Tingkat Efektifitas Kontrol 2">Tingkat Efektifitas Kontrol 2</option>
                                    @else
                                    <option value="Tingkat Efektifitas Kontrol 1">Tingkat Efektifitas Kontrol 1</option>
                                    <option value="Tingkat Efektifitas Kontrol 2">Tingkat Efektifitas Kontrol 2</option>
                                    @endif
                                </select>
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
                                    id="nilai_resiko_r1" value="{{ $inputRisk->nilai_resiko_r1 }}" placeholder="Nilai Sisa Risiko / Peluang (R1)" style="font-weight: normal" />
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
                                <textarea name="tindak_lanjut_mitigasi" id="tindak_lanjut_mitigasi" class="form-control form-control-solid mb-3">{!! $inputRisk->tindak_lanjut_mitigasi !!}</textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="tingkat_efektifitas_tindak_lanjut" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Tindak lanjut"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->tingkat_efektifitas_tindak_lanjut))
                                    <option value="{{ $inputRisk->tingkat_efektifitas_tindak_lanjut }}" selected>{{ $inputRisk->tingkat_efektifitas_tindak_lanjut }}</option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 1">Tingkat Efektifitas Tindak lanjut 1</option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 2">Tingkat Efektifitas Tindak lanjut 2</option>
                                    @else
                                    <option value="Tingkat Efektifitas Tindak lanjut 1">Tingkat Efektifitas Tindak lanjut 1</option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 2">Tingkat Efektifitas Tindak lanjut 2</option>
                                    @endif
                                </select>
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
                                    id="nilai_resiko_r2" value="{{ $inputRisk->nilai_resiko_r2 }}" placeholder="Nilai Sisa Risiko / Peluang (R2)" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_proaktif"
                                    id="biaya_proaktif" value="{{ $inputRisk->biaya_proaktif }}" placeholder="Biaya" style="font-weight: normal" />
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
                                    id="tanggal_mulai" value="{{ Carbon\Carbon::parse($inputRisk->tanggal_mulai)->translatedFormat('Y-m-d') }}" placeholder="Tanggal Mulai" style="font-weight: normal" />
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
                                    id="tanggal_selesai" value="{{ Carbon\Carbon::parse($inputRisk->tanggal_selesai)->translatedFormat('Y-m-d') }}" placeholder="Tanggal Selesai" style="font-weight: normal" />
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
                                    id="tindak_lanjut_reaktif" value="{{ $inputRisk->tindak_lanjut_reaktif }}" placeholder="Rencana Tindak Lanjut (Mitigasi) Reaktif" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Biaya</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_reaktif"
                                    id="biaya_reaktif" value="{{ $inputRisk->biaya_reaktif }}" placeholder="Biaya" style="font-weight: normal" />
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
                                <select name="pic_rtl" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="PIC RTL"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (!empty($inputRisk->pic_rtl))
                                    <option value="{{ $inputRisk->pic_rtl }}" selected>{{ $inputRisk->pic_rtl }}</option>
                                    <option value="PIC RTL 1">PIC RTL 1</option>
                                    <option value="PIC RTL 2">PIC RTL 2</option>
                                    @else
                                    <option value="PIC RTL 1">PIC RTL 1</option>
                                    <option value="PIC RTL 2">PIC RTL 2</option>
                                    @endif
                                </select>
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
                                <textarea cols="2" class="form-control form-control-solid mb-3" name="uraian"
                                    id="uraian" placeholder="Uraian" style="font-weight: normal" >{{ $inputRisk->uraian }}</textarea>
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
                                    id="nilai" value="{{ $inputRisk->nilai }}" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Status</span>
                                </label>
                                <!--begin::Input-->
                                <select name="status" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Status"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    @if (isset($inputRisk->is_closed))
                                        <option value="{{ $inputRisk->is_closed }}" selected>{{ (bool) $inputRisk->is_closed == true ? "Closed" : "Open" }}</option>
                                        <option value="0">Open</option>
                                        <option value="1">Closed</option>
                                    @else
                                        <option value="0">Open</option>
                                        <option value="1">Closed</option>
                                    @endif
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <br>

                        <div class="modal-footer">
                            <button type="submit" id="edit-risk" class="btn btn-sm btn-primary"
                                data-bs-dismiss="modal">Save</button>
                        </div>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    @endforeach
    <!--end::Modal - Input Resiko Perolehan-->

    <!--begin::Modal - Input Resiko Pelaksanaan-->
    <div class="modal fade" id="kt_modal_input_resiko_pelaksanaan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Proyek - Pelaksanaan</h2>
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

                    <form action="/contract-management/final-dokumen/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="modal-name" name="modal-name">
                        <input type="hidden" value="resiko-pelaksanaan" name="kategori">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
        
                        {{-- @php
                            $month = (int) date("m") - 1 == 0 ? 12 : (int) date("m") - 1;
                            $year = (int) date("m") - 1 == 0 ?  (int) date("Y") - 1 : (int) date("Y");

                        @endphp
                        <div class="row">
                            <div class="col">
                                Bulan:
                            </div>
                            <div class="col">
                                Tahun:
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select id="periode-resiko" name="periode-resiko"
                                    class="form-select form-select-solid select2-hidden-accessible w-auto"
                                    style="margin-right: 2rem;" data-control="select2" data-hide-search="true"
                                    data-placeholder="Bulan" data-select2-id="select2-data-bulan" tabindex="-1"
                                    aria-hidden="true">
                                    <option {{ $month == '' ? 'selected' : '' }}></option>
                                    <option value="1" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div class="col">
                                <select id="tahun-resiko" name="tahun-resiko"
                                    class="form-select form-select-solid select2-hidden-accessible w-auto"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                    data-select2-id="select2-data-tahun" tabindex="-1" aria-hidden="true">
                                    @if ($year == null)
                                        @for ($i = $years - 2; $i < $years + 10; $i++)
                                            <option value="{{ $i }}" {{ $years == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    @else
                                        @for ($i = $year - 2; $i < $year + 10; $i++)
                                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                        </div> --}}
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="resiko-file">Upload File</label>
                                <input type="file" class="form-control form-control-solid" name="file-document" accept=".pdf">
                            </div>
                        </div>

                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <div class="modal-footer">
                            <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
                                data-bs-dismiss="modal">Save</button>
                        </div>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Pelaksanaan-->

    <!--begin::Modal - Input Resiko Pemeliharaan-->
    <div class="modal fade" id="kt_modal_input_resiko_pemeliharaan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Resiko Proyek - Pemeliharaan</h2>
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
                        <input type="hidden" value="0" name="is-closed">
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
                                    style="font-weight: normal" value="{{ auth()->user()->UnitKerja->unit_kerja ?? auth()->user()->name }}" placeholder="Verifikasi" readonly/>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kategori" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih kategori"
                                    tabindex="-1" aria-hidden="true" required>
                                    <option value=""></option>
                                    <option value="Kategori 1">Kategori 1</option>
                                    <option value="Kategori 2">Kategori 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Kriteria</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="kriteria" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Kriteria 1">Kriteria 1</option>
                                    <option value="Kriteria 2">Kriteria 2</option>
                                </select>
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
                                <select name="probis_1_2" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Level 1 - 2"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Probis 1">Probis 1</option>
                                    <option value="Probis 2">Probis 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Probis Yang Terganggu</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="probis_terganggu" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probis Yang Terganggu"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Probis Terganggu 1">Probis Terganggu 1</option>
                                    <option value="Probis Terganggu 2">Probis Terganggu 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Penyebab</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="penyebab" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Penyebab"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Penyebab 1">Penyebab 1</option>
                                    <option value="Penyebab 2">Penyebab 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Resiko / Peluang</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="resiko_peluang" id="resiko_peluang" class="form-control form-control-solid mb-3" style="font-weight: normal" value=""></textarea>
                                <!--end::Input-->
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="dampak" id="dampak" class="form-control form-control-solid mb-3" style="font-weight: normal" value=""></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Resiko / Peluang (Ro)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai_resiko_r0"
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
                                <select name="probabilitas" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Probabilitas"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            {{-- <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dampak</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="dampak"
                                    id="dampak" value="" placeholder="Dampak" style="font-weight: normal" />
                                <!--end::Input-->
                            </div> --}}
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Skor</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3" name="skor"
                                    id="skor" value="100" placeholder="Skor" style="font-weight: normal" readonly />
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
                                <select name="tingkat_efektifitas_kontrol" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Kontrol"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Tingkat Efektifitas Kontrol 1">Tingkat Efektifitas Kontrol 1</option>
                                    <option value="Tingkat Efektifitas Kontrol 2">Tingkat Efektifitas Kontrol 2</option>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai Sisa Risiko / Peluang (R1)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai_resiko_r1"
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
                                <textarea name="tindak_lanjut_mitigasi" id="tindak_lanjut_mitigasi" class="form-control form-control-solid mb-3"></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tingkat Efektifitas Tindak Lanjut</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="tingkat_efektifitas_tindak_lanjut" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Tingkat Efektifitas Tindak lanjut"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 1">Tingkat Efektifitas Tindak lanjut 1</option>
                                    <option value="Tingkat Efektifitas Tindak lanjut 2">Tingkat Efektifitas Tindak lanjut 2</option>
                                </select>
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
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_proaktif"
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
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="biaya_reaktif"
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
                                <select name="pic_rtl" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="PIC RTL"
                                    tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="PIC RTL 1">PIC RTL 1</option>
                                    <option value="PIC RTL 2">PIC RTL 2</option>
                                </select>
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
                                <textarea name="uraian" id="uraian" class="form-control form-control-solid mb-3"></textarea>
                                <!--end::Input-->
                            </div>
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nilai</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid mb-3 reformat" name="nilai"
                                    id="nilai" value="" placeholder="Nilai" style="font-weight: normal" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <hr>
                        <br>
                        
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
        
                        {{-- end::Read File --}}
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
                            data-bs-dismiss="modal">Save</button>
        
                    </form>
                </div>
                <!--end::Input group-->


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal - Input Resiko Pemeliharaan-->

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
                        <input type="file" multiple accept=".pdf" name="ba-defect[]"
                            class="form-control form-control-solid">
                        {{-- end::Read File --}}
                        <small>* Support multi file upload</small>
                        <br> <br>
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
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
                        <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
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
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
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
                        <button type="submit" id="pending-issue-btn" class="btn btn-sm btn-primary">Save</button>

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

                    <button type="submit" id="save-question-tender-menang" class="btn btn-sm btn-primary"
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
        <div class="modal-dialog modal-dialog-centered mw-500px">
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
                            <div class="col mt-4">
                                <!--begin::Label-->
                                <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Upload RKAP Bab 12</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="hidden" value="1" name="is-tender-menang">
                                <input type="hidden" class="modal-name" name="modal-name">
                                 --}}
                                {{-- <textarea name="ketentuan-rencana-kerja" id="ketentuan-rencana-kerja" rows="10"
                                    class="form-control form-control-solid"></textarea> --}}
                                <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">

                                <!--end::Input-->
                            </div>
                            {{-- 
{{-- 
                            {{-- 
{{-- 
                            {{-- 
{{-- 
                            {{-- 
                            <br><br>

                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label">
                                    <span style="font-weight: normal">Informasi Kelengkapan <i>Check List</i>
                                        ADKON</span>
                                </label> --}}
                                <!--end::Label-->
                                <!--begin::Input-->
                                {{-- <input type="hidden" value="1" name="is-tender-menang">
                                <input type="hidden" class="modal-name" name="modal-name">
                                 --}}
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">
                                {{-- <textarea name="kelengkapan-adkon" id="kelengkapan-adkon" rows="10"
                                    class="form-control form-control-solid"></textarea> --}}
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
        
                    <button type="submit" id="save-dokumen-site-instruction" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-technical-form" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-technical-query" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-field-design-change" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-contract-change-notice" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-contract-change-proposal" class="btn btn-sm btn-primary"
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

                    <button type="submit" id="save-dokumen-contract-change-order" class="btn btn-sm btn-primary"
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
    <!--end::Modal - Perubahan Kontrak Menang-->

    <!--Begin::Modal - Jaminan-->
    <div class="modal fade" id="kt_modal_jaminan" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Jaminan</h2>
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
                        <form action="/jaminan-pelaksanaan/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? 0 }}" id="id-perubahan-kontrak" name="id-perubahan-kontrak">
                            <!--end::Input-->
        
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Kategori</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="kategori-jaminan" id="kategori-jaminan" class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Pilih Kategori Jaminan">
                                <option value=""></option>
                                <option value="Advance Payment">Advance Payment</option>
                                <option value="Performance">Performance</option>
                                <option value="Warranty">Warranty</option>
                                <option value="Partner">Partner</option>
                            </select>
                            <!--end::Input-->
                            
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">No. Jaminan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-jaminan"
                                id="nomor-jaminan" value="" style="font-weight: normal"
                                placeholder="Input No. Jaminan" />
                            <!--end::Input-->
                            
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Penerbit Jaminan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="penerbit-jaminan"
                                id="penerbit-jaminan" value="" style="font-weight: normal"
                                placeholder="Input Penerbit Jaminan" />
                            <!--end::Input-->
        
                            <!--begin::Input-->
                            <div class="tanggal-penerbitan">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Penerbitan</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal_dokumen">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal-penerbitan-jaminan"
                                id="tanggal_penerbitan" value="" placeholder="Tanggal Penerbitan" style="font-weight: normal" />
                            </div>
                            <!--end::Input-->
                            
                            <!--begin::Input-->
                            <div class="tanggal-berakhir">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Berakhir</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal_dokumen">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal-berakhir-jaminan"
                                id="tanggal_berakhir" value="" placeholder="Tanggal Berakhir" style="font-weight: normal" />
                            </div>
                            <!--end::Input-->

                            <!--begin::Input-->
                            {{-- <div class="status">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Status</span>
                                </label>
                                <select name="status-jaminan" id="status-jaminan" class="form-select form-select-solid"
                                data-control="select2" data-hide-search="true"
                                data-placeholder="Pilih Status">
                                    <option value=""></option>
                                    <option value="Valid">Valid</option>
                                    <option value="Expired">Expired</option>
                                </select>                                    
                            </div> --}}
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
                            
                            <button type="submit" id="save-dokumen-site-instruction" class="btn btn-sm btn-primary mt-5"
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
    <!--End::Modal - Jaminan-->

    <!--Begin::Modal - Asuransi-->
    <div class="modal fade" id="kt_modal_asuransi" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Asuransi</h2>
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
                        <form action="/asuransi-pelaksanaan/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? 0 }}" id="id-perubahan-kontrak" name="id-perubahan-kontrak">
                            <!--end::Input-->
        
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Kategori</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="kategori-asuransi" id="kategori-asuransi" class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true"
                            data-placeholder="Pilih Kategori Asuransi">
                                <option value=""></option>
                                <option value="CAR/EAR">CAR/EAR</option>
                                <option value="Third Party Liability">Third Party Liability</option>
                                <option value="Professional Indemnity">Professional Indemnity</option>
                            </select>
                            <!--end::Input-->
                            
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">No. Polis</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="nomor-polis-asuransi"
                                id="nomor-polis" value="" style="font-weight: normal"
                                placeholder="Input No. Polis" />
                            <!--end::Input-->
                            
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Penerbit Polis</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="penerbit-polis-asuransi"
                                id="penerbit-polis" value="" style="font-weight: normal"
                                placeholder="Input Penerbit Polis" />
                            <!--end::Input-->
        
                            <!--begin::Input-->
                            <div class="tanggal-penerbitan">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Penerbitan</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal_dokumen">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal-penerbitan-asuransi"
                                id="tanggal_penerbitan" value="" placeholder="Tanggal Dokumen" style="font-weight: normal" />
                            </div>
                            <!--end::Input-->
                            
                            <!--begin::Input-->
                            <div class="tanggal-berakhir">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Berakhir</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="tanggal_dokumen">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <input type="date" class="form-control form-control-solid mb-3" name="tanggal-berakhir-asuransi"
                                id="tanggal_berakhir" value="" placeholder="Tanggal Dokumen" style="font-weight: normal" />
                            </div>
                            <!--end::Input-->

                            <!--begin::Input-->
                            {{-- <div class="status">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Status</span>
                                </label>
                                <select name="status-asuransi" id="status-asuransi" class="form-select form-select-solid"
                                data-control="select2" data-hide-search="true"
                                data-placeholder="Pilih Status">
                                    <option value=""></option>
                                    <option value="Valid">Valid</option>
                                    <option value="Expired">Expired</option>
                                </select>
                            </div> --}}
                            <!--end::Input-->

                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
                            
                            <button type="submit" id="save-asuransi" class="btn btn-sm btn-primary mt-5"
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
    <!--End::Modal - Asuransi-->

    <!--begin::Modal - Pasal Kontraktual-->
<div class="modal fade" id="kt_modal_input_pasal_kontraktual" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Identifikasi Pasal Kontraktual</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
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
    
                <!--begin::Input group Website-->
                <div class="fv-row mb-5">
                    <form action="/pasal-kontraktual/upload" method="POST">
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
                            value="" placeholder="Item" cols="1" ></textarea>
                        <!--end::Input-->
                        <br>
    
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Pasal</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea class="form-control form-control-solid" name="pasal"
                            id="pasal" style="font-weight: normal" cols="1" value=""
                            placeholder="Pasal"></textarea>
                        <!--end::Input-->
                        <br>
                        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Perpanjangan Waktu</span>
                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                            </a>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control form-control-solid" name="perpanjangan-waktu"
                            id="perpanjangan-waktu" style="font-weight: normal" value=""
                            placeholder="Perpanjangan Waktu"/>
                        <!--end::Input-->
                        <br>
                        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Tambahan Biaya</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid reformat" name="tambahan-biaya"
                            id="tambahan-biaya" style="font-weight: normal" value="0"
                            placeholder="Tambahan Biaya"/>
                        <!--end::Input-->

                        <br><br>
                        <button type="submit" id="save-pasal-kontraktual" class="btn btn-lg btn-primary"
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
<!--end::Modal - Pasal Kontraktual-->
@endif
@endisset

<!--begin::Modal - Checklist Menejemen Kontrak-->
<div class="modal fade" id="kt_modal_input_checklist_manajemen" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Checklist Manajemen Kontrak</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
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
        
                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <form action="/checklist-manajemen-kontrak/upload" method="POST">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
                            
                            <div id="slide-1" class="animate slide">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select id="kategori-checklist"
                                    name="kategori"
                                    onchange="updateChange(this)"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Pilih Kategori Checklist Manajemen Kontrak">
                                    <option value="" selected></option>
                                    <option value="Progress 0-20%" data-id="#progress_0-20">Progress 0-20%</option>
                                    <option value="Progress 20%-90%" data-id="#progress_20-90">Progress 20%-90%</option>
                                    <option value="Progress 90%-100%" data-id="#progress_90-100">Progress 90%-100%</option>
                                </select>
                                <!--end::Input-->
                            </div>

                            <!--Begin::Modal Progress 0% - 20%-->
                            <div id="progress_0-20">
                                <div id="slide-2" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah SPK telah diterima?</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-1" value="Ya">
                                            <span>Ya, Tanggal</span>
                                        </div>
                                        <input type="date" class="form-control" name="sub-jawaban-1[]" aria-label="">
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-1" value="Belum">
                                            <span>Belum, Sebab</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-1[]" aria-label="">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                </div>
                                
                                <div id="slide-3" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah sudah ada berita Acara serah terima lapangan?</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Ya">
                                        <span>Ya, Tanggal</span>
                                        </div>
                                        <input type="date" class="form-control" name="sub-jawaban-2[]" aria-label="Text input with checkbox">
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Belum">
                                        <span>Belum, Sebab</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-2[]" aria-label="">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                </div>
                                
                                <div id="slide-4" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jadwal Pelaksanaan telah disetujui oleh Engineer?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Network Planning" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Network Planning
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Sub-Network Planning" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Sub-Network Planning
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Barchart" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Barchart
                                        </label>
                                    </div>
                                    <br>
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah jadwal diatas mengutamakan ketergantungan kegiatan WIKA kepada Pemberi Kerja dan Mitranya?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-5" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Siapa yang membuat Construction Schedule?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Kontraktor" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Kontraktor
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Konsultan (Engineer)" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Konsultan (Engineer)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Pemberi Tugas (Employer)" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pemberi Tugas (Employer)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Bersama-sama" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Bersama-sama
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-6" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek memiliki Buku Harian tentang?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Kegiatan Harian" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Kegiatan Harian
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Keadaan Cuaca" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Keadaan Cuaca
                                        </label>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-6" value="Lainnya">
                                            <span>Lainnya...</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-6" aria-label="Text input with checkbox">
                                    </div>
                                    <br>
                                </div>
    
                                <div id="slide-7" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Penanggung Jawab Pelaksanaan Penghitungan / Pengukuran Nilai Pekerjaan Terlaksana?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <h5>Siapa</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Kontraktor" name="jawaban-7[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Kontraktor
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Konsultan" name="jawaban-7[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Konsultan
                                        </label>
                                    </div>
                                    <br><br>
                                    <h5>Kapan</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Bulanan" name="jawaban-8[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Bulanan
                                        </label>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-8[]" value="Setiap Tanggal">
                                            <span>Dilakukan pada tanggal...</span>
                                        </div>
                                        <input type="date" class="form-control" name="sub-jawaban-8[]" aria-label="Text input with checkbox">
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-9[]" value="Cara Lain">
                                            <span>Cara lain?</span>
                                        </div>
                                        <input type="date" class="form-control" name="sub-jawaban-8[]" aria-label="Text input with checkbox">
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </div>
                                    <br><br>
                                    <h5>Bagaimana cara melaksanakannya ?</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Dilakukan Konsultan" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Dilakukan Konsultan
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Kontraktor Menyetujui" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Kontraktor Menyetujui
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Dilakukan Kontraktor" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Dilakukan Kontraktor
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Konsultan Menyetujui" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Konsultan Menyetujui
                                        </label>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="Cara Lain" value="Cara Lain">
                                            <span>Cara Lain...</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-9[]" aria-label="Text input with checkbox">
                                    </div>
                                </div>
    
                                <div id="slide-8" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek memiliki Identifikasi Gambar ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Issued for Construction (IFC)" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Issued for Construction (IFC)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Issued for Approval (IFA)" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Issued for Approval (IFA)
                                        </label>
                                    </div>
                                    <br><br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek memiliki Pengarsipan Surat-menyurat ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Arsip Kronologis" name="jawaban-11[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Arsip Kronologis
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Arsip Menurut Subyek" name="jawaban-11[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Arsip Menurut Subyek
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Arsip Foto-foto Pekerjaan" name="jawaban-11[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Arsip Foto-foto Pekerjaan
                                        </label>
                                    </div>
                                    <br>
                                </div>
    
                                <div id="slide-9" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek memiliki Sistem Pendistribusian Dokumen ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-12[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-12[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div><br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek memiliki ketetapan tertulis tentang <b>Bench Mark</b> ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-10" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Penawaran telah ditarik Kembali ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-14" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-14" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div><br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Pelaksanaan telah Diterbitkan ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-15" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-15" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-11" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Uang Muka telah Diterbitkan ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-16" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-16" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div><br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Program Asuransi telah disetujui oleh Pemberi Tugas (Employer) ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Asuransi Contractors All Risks" name="jawaban-17" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Asuransi Contractors All Risks
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Asuransi Tenaga Kerja (Jamsostek atau Personal Accident)" name="jawaban-17" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Asuransi Tenaga Kerja (Jamsostek atau Personal Accident)
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="slide-12" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Material Damage</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Contract Works" name="jawaban-18" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Contract Works
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Const. Plant & Eqpt" name="jawaban-18" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Const. Plant & Eqpt
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Const. Machinery" name="jawaban-18" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Const. Machinery
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Clearence of Debris" name="jawaban-18" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Clearence of Debris
                                        </label>
                                    </div>
                                    
                                    <br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Third Party Liability</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Bodily Injury" name="jawaban-19" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Bodily Injury
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Property Damage" name="jawaban-19" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Property Damage
                                        </label>
                                    </div>
                                    
                                    <br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Polis tersebut dibuat atas nama</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Employer" name="jawaban_20" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Employer
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Kontraktor" name="jawaban_20" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Kontraktor
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Subcon" name="jawaban_20" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Subcon
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Konsultan" name="jawaban-20" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Konsultan
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-13" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Perubahan-perubahan yang terjadi telah dilaporkan kepada Asuransi (antisipasi atas perpanjangan waktu dan/atau No Risk Period) ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-21" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-21" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div><br><br>
    
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah upaya penghindaran kecelakaan sudah dilaksanakan ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tindakan Pengamanan" name="jawaban-22" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tindakan Pengamanan
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Prosedur Keselamatan Kerja" name="jawaban-22" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Prosedur Keselamatan Kerja
                                        </label>
                                    </div>
                                    <br><br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah kerugian yang terjadi akibat kejadian yang diasuransikan telah dilaporkan kepada Perusahaan Asuransi? ?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-23" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-23" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
    
                                <div id="slide-14" class="animate slide" style="display: none; opacity: 0;">
                                    <h5 class="h5 text-center">Silahkan submit data</h5>
                                </div>
                            </div>
                            <!--End::Modal Progress 0% - 20%-->

                            <!--Begin::Modal Progress 20% - 90%-->
                            <div id="progress_20-90">
                                <div id="slide-2" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek mengalami keterlambatan?</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-1" value="Terlambat">
                                            <span>Terlambat</span>
                                        </div>
                                        <input type="number" class="form-control" name="sub-jawaban-1[]" aria-label="" min="0" max="100">
                                        <span><h3>%</h3></span>
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio"aria-label="" name="jawaban-1" value="Lebih Awal">
                                            <span>Lebih Awal</span> 
                                        </div>
                                            <input type="number" class="form-control" name="sub-jawaban-1[]" aria-label="" min="0" max="100">
                                            <span><h3>%</h3></span>
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                </div>

                                <div id="slide-3" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek mengadakan Rapat rutin?</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Mingguan">
                                        <span>Mingguan</span>
                                        </div>
                                        <input type="number" class="form-control" name="sub-jawaban-2[]" aria-label="" placeholder="Total Rapat s/d saat ini">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Bulanan">
                                            <span>Bulanan</span>
                                        </div>
                                            <input type="number" class="form-control" name="sub-jawaban-2[]" aria-label="" placeholder="Total Rapat s/d saat ini">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Per Kasus">
                                            <span>Per Kasus</span>
                                        </div>
                                            <input type="number" class="form-control" name="sub-jawaban-2[]" aria-label="" placeholder="Total Rapat s/d saat ini">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-2" value="Lainnya">
                                            <span>Lainnya</span>
                                        </div>
                                            <input type="number" class="form-control" name="sub-jawaban-2[]" aria-label="" placeholder="Total Rapat s/d saat ini">
                                    </div>
                                    <br>
                                    <!--end::Input-->
                                </div>

                                <div id="slide-4" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah ada kejadian yang dapat menyebabkan perubahan jadwal?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah ada kejadian yang dapat menyebabkan Perubahan Pekerjaan / Change Order / Variation Order?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah ada kejadian yang dapat menyebabkan Penghentian Pekerjaan (Suspension)?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah ada kemungkinan kegiatan/kejadian yang mungkin menyebabkan Percepatan / Acceleration Pekerjaan?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Perintah/Instruksi resmi Lapangan mengenai perubahan telah terbit?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-7[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-7[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah perubahan yang terjadi telah dimintakan konfirmasi dari Engineer / Pengawas Ahli?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-8[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-8[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                </div>

                                <div id="slide-5" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Tahapan yang telah dicapai dalam pengajuan Kompensasi atas perubahan - perubahan yang terjadi :</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Pemberitahuan kepada Engineer/Pengawas Ahli secara segera" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pemberitahuan kepada Engineer/Pengawas Ahli secara segera
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Pembuatan Perincian Jumlah Kompensasi" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pembuatan Perincian Jumlah Kompensasi
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Pengajuan Perincian Jumlah Kompensasi kepada Engineer" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pengajuan Perincian Jumlah Kompensasi kepada Engineer
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Negosiasi" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Negosiasi
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Persetujuan nilai Kompensasi oleh Engineer" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Persetujuan nilai Kompensasi oleh Engineer
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Persetujuan nilai Kompensasi oleh Employer" name="jawaban-9[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Persetujuan nilai Kompensasi oleh Employer
                                        </label>
                                    </div>
                                </div>

                                <div id="slide-6" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Klausul Kontrak yang mengatur tentang perubahan (waktu/biaya/mutu)</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Perjanjian Kontrak (Contract Agreement)" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Perjanjian Kontrak (Contract Agreement)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Persyaratan Umum Kontrak (General Condition of Contract)" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Persyaratan Umum Kontrak (General Condition of Contract)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Persyaratan Khusus Kontrak (Special Condition of Contract)" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Persyaratan Khusus Kontrak (Special Condition of Contract)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" aria-label="" name="jawaban-10" value="Addenda">
                                            <span>Addenda</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-10" aria-label="">
                                    </div>
                                </div>

                                <div id="slide-7" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Proyek akan membutuhkan Perpanjangan Waktu?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-11[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-11[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>

                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah keinginan ini telah disampaikan kepada Engineer secara formal?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-12[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-12[]" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>

                                <div id="slide-8" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apa yang menjadi dasar kebutuhan akan Perpanjangan Waktu?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Pekerjaan Tambah" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pekerjaan Tambah
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Perubahan Desain" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Perubahan Desain
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Adanya hambatan Pekerjaan (Cuaca, Perintah Engineer, Dll)" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Adanya hambatan Pekerjaan (Cuaca, Perintah Engineer, Dll)
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Perubahan Metoda Kerja" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Perubahan Metoda Kerja
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ketergantungan pada Pekerjaan NSC/Kontraktor ahli" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ketergantungan pada Pekerjaan NSC/Kontraktor ahli
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Berlarutnya proses persetujuan dari Engineer" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Berlarutnya proses persetujuan dari Engineer
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ketidakjelasan Gambar- gambar / Spesifikasi" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ketidakjelasan Gambar- gambar / Spesifikasi
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ketidakjelasan bahasa Kontrak (arti ganda), perintah yang saling kontradiksi" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ketidakjelasan bahasa Kontrak (arti ganda), perintah yang saling kontradiksi
                                        </label>
                                    </div>
                                    <br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0 me-2" type="radio" name="jawaban-13" value="Lain-lain" aria-label="">
                                            <span>Lain-lain</span>
                                        </div>
                                        <input type="text" class="form-control" name="sub-jawaban-13" aria-label="">
                                    </div>
                                </div>
                                
                                <div id="slide-9" class="animate slide" style="display: none; opacity: 0;">
                                    <h5 class="h5 text-center">Silahkan submit data</h5>
                                </div>
                            </div>
                            <!--End::Modal Progress 20% - 90%-->

                            <!--Begin::Modal Progress 90% - 100%-->
                            <div id="progress_90-100">
                                <div id="slide-2" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah besarnya Jaminan Uang Muka telah disesuaikan dengan jumlah Uang Muka yang masih terhutang?</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                     <!--begin::Label-->
                                     <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Uang Muka telah ditarik kembali?</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-2" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-2" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah permohonan untuk melaksanakan Serah Terima Pertama telah diajukan kepada Engineer?</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-3" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div id="slide-3" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Tahapan yang telah dicapai dalam program Serah Terima Pertama :</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Permohonan kepada Engineer untuk mengadakan Serah Terima Pertama" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Permohonan kepada Engineer untuk mengadakan Serah Terima Pertama
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Mempersiapkan data-data yang menjadi prasyarat Serah Terima Pertama" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Mempersiapkan data-data yang menjadi prasyarat Serah Terima Pertama
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Panitia/Tim Serah Terima Pertama terbentuk" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Panitia/Tim Serah Terima Pertama terbentuk
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tinjauan Lapangan oleh Panitian / Tim" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tinjauan Lapangan oleh Panitian / Tim
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Serah Terima Pertama telah dilaksanakan" name="jawaban-4" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Serah Terima Pertama telah dilaksanakan
                                        </label>
                                    </div>
                                </div>
                                <div id="slide-4" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Pelaksanaan telah ditarik kembali?</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-5" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah Jaminan Pemeliharaan telah diganti dengan Bank Garansi?</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-6" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                    <div class="garansi">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Bank Garansi seluruhnya akan ditarik kembali pada tanggal</span>
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </label><br>
                                    <!--end::Label-->
                                        <input type="date" class="form-control" name="jawaban-7[]" aria-label="Text input with checkbox">
                                    </div>
                                    <br>
                                    <div class="masa-pemeliharaan">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Masa Pemeliharaan akan berakhir pada tanggal</span>
                                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                            </a>
                                        </label><br>
                                        <!--end::Label-->
                                        <input type="date" class="form-control" name="jawaban-8[]" aria-label="Text input with checkbox">
                                    </div>
                                    <br>
                                    <div class="serah-terima">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span style="font-weight: normal">Permohonan Serah Terima Akhir akan diajukan pada tanggal</span>
                                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                            </a>
                                        </label><br>
                                        <!--end::Label-->
                                        <input type="date" class="form-control" name="jawaban-9[]" aria-label="Text input with checkbox">
                                    </div>
                                    <br>
                                </div>
                                <div id="slide-5" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Nilai Kontrak Akhir :</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Dalam proses penghitungan bersama" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Dalam proses penghitungan bersama
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Disetujui Pemberi Kerja" name="jawaban-10" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Disetujui Pemberi Kerja
                                        </label>
                                    </div>
                                </div>
                                <div id="slide-6" class="animate slide" style="display: none; opacity: 0;">
                                   <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Pembayaran Akhir (Final Payment) akan dilaksanakan pada tanggal</span>
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </label><br>
                                    <!--end::Label-->
                                    <input type="date" class="form-control" name="jawaban-11[]" aria-label="Text input with checkbox">
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Termin yang sudah diterima</span>
                                    </label><br>
                                    <!--end::Label-->
                                    <input type="text" class="form-control reformat" value="0" name="jawaban-12[]">
                                </div>
                                <div id="slide-7" class="animate slide" style="display: none; opacity: 0;">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah ada kejadian yang dapat menyebabkan perubahan pekerjaan (Change Order) / Variation Order?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-13" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah perintah/Instruksi resmi lapangan mengenai perubahan telah diterbitkan?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-14" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-14" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                    <br>
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Apakah perubahan yang telah terjadi telah dikonfirmasikan kepada konsultan/pengawas?</span>
                                    </label><br><br>
                                    <!--end::Label-->
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Ya" name="jawaban-15" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ya
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Tidak" name="jawaban-15" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div id="slide-8" class="animate slide" style="display: none; opacity: 0;">
                                    <h5 class="h5 text-center">Silahkan submit data</h5>
                                </div>
                            </div>
                            <!--End::Modal Progress 90% - 100%-->
                            <br>
                            <hr>
                            <br>
                            Progress <br>
                            <div class="progress">
                                <div class="progress-bar" id="progress-bar" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <br><br>
                            <div class="modal-footer">
                                <button type="button" onclick="animateSlideChecklist(this)" class="btn btn-sm btn-primary" data-current-slide="1" data-next-slide="2" data-previous-slide="0">Next</button>
                                <button type="submit" id="submit-checklist" class="btn btn-sm btn-primary" style="display: none">Submit</button>
                            </div>
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
<!--end::Modal - Checklist Menejemen Kontrak-->

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
                    class="btn btn-sm btn-primary">Save</button>
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

            <button type="submit" id="save-bulanan-tender-menang" class="btn btn-sm btn-primary"
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


<!--begin::Modal - Risk Project-->
{{-- <div class="modal fade" id="kt_modal_risk_proyek" tabindex="-1" aria-hidden="true">
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
                            <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                            </a>
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
                <button type="submit" id="save-risk" class="btn btn-sm btn-primary"
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
</div> --}}
<!--end::Modal - Add Risk Project-->

<!--begin::Modal - List Questions-->
    <div class="modal fade" id="kt_modal_question_proyek" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-500px">
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
                                    <button type="submit" id="save-question" class="btn btn-sm btn-primary"
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
<!--end::Modal - List Questions-->

<!--begin::Modal - Upload Final Questions-->
<div class="modal fade" id="kt_modal_upload_aanwitjzing" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Aanwitjzing</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="aanwitjzing">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Questions-->
<!--begin::Modal - Upload Final Questions-->
<div class="modal fade" id="kt_modal_upload_pasal_kontraktual" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Pasal Kontraktual</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="pasal-kontraktual">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Questions-->

<!--begin::Modal - Upload Final Tinjauan Perolehan-->
<div class="modal fade" id="kt_modal_upload_tinjauan_perolehan" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Tinjauan Dokumen Perolehan</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="tinjauan-perolehan">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Tinjauan Perolehan-->

<!--begin::Modal - Upload Final Tinjauan Perolehan-->
<div class="modal fade" id="kt_modal_upload_checklist_manajemen" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Checklist Manajemen Kontrak</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="checklist-pelaksanaan">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Tinjauan Perolehan-->

<div class="modal fade" id="kt_modal_tabel_review_kontrak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tinjauan Kontrak - Perolehan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
            <thead>
                <th>Ketentuan</th>
                <th>Ketentuan</th>
                <th>Ketentuan</th>
            </thead>
          </table>
        </div>
      </div>
    </div>
</div>

<!--begin::Modal - LD-->
<div class="modal fade" id="kt_modal_ld" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
            <!--begin::Modal content-->
            <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add LD</h2>
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
                            <form action="/ld/upload" enctype="multipart/form-data" method="POST">
                                @csrf
                                <!--begin::Input-->
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Delay</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="delay" name="delay" class="form-control form-control-solid">
                                <!--end::Input-->

                                <br>
                                
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Performance</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="performance" name="performance" class="form-control form-control-solid">
                                <!--end::Input-->

                                <br><br>
                                <button type="submit" id="save-question" class="btn btn-sm btn-primary"
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
<!--end::Modal - LD-->

<!--begin::Modal - LD-->
<div class="modal fade" id="kt_modal_law" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
            <!--begin::Modal content-->
            <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add LAW</h2>
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
                            <form action="/law/upload" enctype="multipart/form-data" method="POST">
                                @csrf
                                <!--begin::Input-->
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Governing Law</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="governing-law" name="governing-law" class="form-control form-control-solid">
                                <!--end::Input-->

                                <br>
                                
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Dispute Resolution</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="dispute-resolution" name="dispute-resolution" class="form-control form-control-solid">
                                <!--end::Input-->
                                
                                <br>

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Prevailing Language</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" id="prevailing-language" name="prevailing-language" class="form-control form-control-solid">
                                <!--end::Input-->

                                <br><br>
                                <button type="submit" id="save-question" class="btn btn-sm btn-primary"
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
<!--end::Modal - LD-->

<!--begin::Modal - Upload Final Pending Issue-->
<div class="modal fade" id="kt_modal_upload_pending_issue" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Pending Issue</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="pending-issue">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Pending Issue-->

<!--begin::Modal - Upload Final Usulan Perubahan-->
<div class="modal fade" id="kt_modal_upload_perubahan_kontrak" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Usulan Perubahan Kontrak</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="usulan-perubahan">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Usulan Perubahan-->

<!--begin::Modal - Upload Final Perubahan Kontrak-->
<div class="modal fade" id="kt_modal_upload_perubahan" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Perubahan Kontrak</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="perubahan-kontrak">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Pending Issue-->

<!--begin::Modal - Upload Final Resiko Pelaksanaan-->
<div class="modal fade" id="kt_modal_upload_resiko_pelaksanaan" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Upload Final | Input Resiko - Pelaksanaan</h2>
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
                <form action="/contract-management/final-dokumen/upload" method="POST"
                    enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col mt-4">
                            <!--begin::Label-->
                            <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Upload Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" name="kategori" value="resiko-pelaksanaan">
                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid" accept=".pdf">
                            <!--end::Input-->
                        </div>
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="hidden" class="modal-name" name="modal-name">
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
<!--end::Modal - Upload Final Resiko Pelaksanaan-->

<!--begin::Modal - Upload Final Resiko Pelaksanaan-->
<div class="modal fade" id="kt_modal_detail_checklist" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Detail Checklist</h2>
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
            <div>
                <a href="#" class="btn btn-md btn-secondary m-5" onclick="generateChecklistToExcel(this)">Export to Excel</a>
                <div class="table-datatable" hidden>
                    <table id="table-checklist">
                        <thead>
                            <th>Ketentuan</th>
                            <th>Jawaban</th>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-lg-6 px-lg-6">
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Upload Final Resiko Pelaksanaan-->

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
    const tabContent = document.querySelector(`.nav li:nth-child(${proyekStage}) a`);
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

{{-- Begin :: Animating Slide Checklist Manajemen Kontrak --}}
<script>
    let dataId = ""
    function updateChange(e){
        const data = e.options[e.selectedIndex];
        dataId = data.getAttribute("data-id");
    }
    function animateSlideChecklist(e) {
        const currentSlide = e.getAttribute("data-current-slide");
        const nextSlide = e.getAttribute("data-next-slide");
        const progressId = dataId;
        const previousSlide = e.getAttribute("data-previous-slide");
        const nextSlideElt = document.querySelector(`${progressId} #slide-${nextSlide}`);
        let currentSlideElt = "";
        if(currentSlide == 1){
            currentSlideElt = document.querySelector(`#slide-${currentSlide}`);
        }else{
            currentSlideElt = document.querySelector(`${progressId} #slide-${currentSlide}`);
        }

        // function validateInput(){
        //     const getInputGroup = currentSlideElt.querySelectorAll('.input-group');
        //     const getInputFormCheck = currentSlideElt.querySelectorAll('.form-check');
        //     const getLabelForm = currentSlideElt.querySelectorAll('.form-label');
        //     if(getInputGroup){
        //         if(getInputFormCheck){
        //             for(let data of getInputFormCheck){
        //                 // console.log(data.querySelector('input:checked'))
        //                 // console.log(data)
        //                 let counter = 0
        //                 const checkedCounter = currentSlideElt.querySelectorAll('input')

        //                 for(let item of checkedCounter){
        //                     if(item.checked){
        //                         counter++
        //                     }else if(item.getAttribute('type') != 'radio' && (item.value)){
        //                         console.log(item.value)
        //                         if(item.value.trim() == '0'){
        //                             continue
        //                         }else{
        //                             counter++
        //                         }
        //                     }
        //                 }
        //                 const is_inputHasValue = counter == getLabelForm.length ? true : false
        //                 console.log(is_inputHasValue, getLabelForm.length, counter)
        //                 if (!is_inputHasValue) {
        //                     return false;
        //                 }
        //                 return true
        //             }
        //             // getInputFormCheck.forEach((data)=>{
                        
        //             // })
        //         }
        //         // getInputGroup.forEach((data)=>{
        //         //         const inputGroup = data.querySelectorAll('input')
        //         //         inputGroup.forEach((input)=>{
        //         //             console.log(input)
        //         //             const is_inputHasValue = input.value != null ? true : false
        //         //             if (!is_inputHasValue) {
        //         //                 return false;
        //         //             }
        //         //         })
        //         //     }
        //         // )
        //         return true
        //     }
        // }

        // const checkValidate = validateInput()
        // console.log(checkValidate)
        // if(!checkValidate){
        //     return
        // }

        // Animasi Slide Opacity
        showSlide(currentSlideElt, nextSlideElt);

        // Animasi Progress Bar
        animateProgressBar(currentSlide);

        // Nimpa data slide sesuai dengan data slide selanjutnya
        e.setAttribute("data-current-slide", nextSlide);
        e.setAttribute("data-next-slide", Number(nextSlide) + 1);
        e.setAttribute("data-previous-slide", Number(previousSlide) + 1);

        // Check Slide Terakhir
        const checkNextSlideElt = document.querySelector(`${progressId} #slide-${Number(nextSlide) + 1}`);
        if(!checkNextSlideElt) {
            console.log("Slide Terakhir");
            const buttonSubmit = document.querySelector("#submit-checklist");
            buttonSubmit.style.display = "";
            e.style.display = "none";
            
        }
    }

    function animateProgressBar(currentSlide) {
        const categorySelected = document.getElementById(dataId.slice(1));
        const totalSlide = categorySelected.querySelectorAll('.animate.slide').length;
        console.log({
            "current-slide" : Number(currentSlide),
            "total-slide" : totalSlide
        })
        const persen = (Number(currentSlide) / totalSlide) * 100;
        setTimeout(() => {
            document.querySelector("#progress-bar").setAttribute("aria-valuenow",`${persen}%`);
            document.querySelector("#progress-bar").style.width = `${persen}%`;
        }, 100);
        if (persen == 100) {
            document.querySelector("#progress-bar").classList.add("bg-success");
        }
    }

    function showSlide(slide1, slide2) {
        slide1.style.opacity = "0";
        setTimeout(() => {
            slide1.style.display = "none";
            slide2.style.display = "";
        }, 450);
        setTimeout(() => {
            slide2.style.opacity = "1";
        }, 450);
    }
</script>
{{-- End :: Animating Slide Checklist Manajemen Kontrak --}}

{{-- Begin :: Export To Excel Data --}}
<script>
    function exportToExcel(e, tableElt) {
        // console.log(e.parentElement);
        document.querySelector(`${tableElt}_wrapper .buttons-excel`).click();
        return;
    }
</script>
{{-- End :: Export To Excel Data --}}

{{-- Begin :: Hide All Excel Btn --}}
<script>
    window.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            const exportBtn = document.querySelectorAll(".buttons-excel");
            exportBtn.forEach(item => {
                item.style.display = "none";
            }); 
        }, 1000);
    });
</script>
{{-- End :: Hide All Excel Btn --}}

<!--begin::Data Tables-->
<script src="/datatables/jquery.dataTables.min.js"></script>
<script src="/datatables/dataTables.buttons.min.js"></script>
<script src="/datatables/buttons.html5.min.js"></script>
<script src="/datatables/buttons.colVis.min.js"></script>
<script src="/datatables/jszip.min.js"></script>
<script src="/datatables/pdfmake.min.js"></script>
<script src="/datatables/vfs_fonts.js"></script>
<!--end::Data Tables-->

{{-- Begin :: Get Checklist Manajemen Kontrak Data --}}
<script>
    async function getChecklistManajemen(e) {
        const element = document.querySelector("#kt_modal_detail_checklist");
        const body = element.querySelector(".modal-body");
        const elementBoots = new bootstrap.Modal(element, {});
        const url = e.getAttribute("data-url");
        const getChecklistManajemenRes = await fetch(url).then(res => res.text());
        body.innerHTML = getChecklistManajemenRes;
        DOMtoTable(body, element);
        elementBoots.show();
        return;
    }
    let kategoriChecklist = "";
    function DOMtoTable(dom, elementBoots) {
        const content = dom.querySelectorAll(".data");
        let html = '';
        content.forEach(item => {
            const children = item.children;
            children.forEach(child => {
                if(child.tagName == "LABEL") {
                    html += '<tr>';
                }
                if(child.tagName == "BR") {
                    html += '</tr>';
                }
                if(child.innerText.trim() != "") {
                    html += `<td>${child.innerText.trim()}</td>`;
                }
                if(child.innerText.trim().includes("Progress")) {
                    kategoriChecklist = child.innerText.trim();
                }
            });
        });    
        document.querySelector("#table-checklist tbody").innerHTML = html;
        const datatable = $('#table-checklist').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            sorting: false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: `Data Checklist Manajemen Kontrak - ${kategoriChecklist}`
                },
                ]
        });
        elementBoots.addEventListener('hidden.bs.modal', event => {
            if(datatable) {
                datatable.destroy();
            }
        })
    }

    function generateChecklistToExcel(e) {
        e.parentElement.querySelector(".buttons-excel").click();
    }
</script>
{{-- End :: Get Checklist Manajemen Kontrak Data --}}


<script>
    $(document).ready(function() {
        $('#perubahan-kontrak').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Perubahan Kontrak'
                },
                   
                ]
        } );
    });
</script>
<script>
    $(document).ready(function() {
        $('#data-aanwitjzing').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Aanwitjzing'
                },
                   
                ]
        } );
    });
</script>
<script>
    $(document).ready(function() {
        $('#input-risk').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Input Risk'
                },
                   
                ]
        } );
    });
</script>
<script>
    $(document).ready(function() {
        $('#usulan-draft').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Usulan Draft'
                },
                   
                ]
        } );
    });
</script>
<script>
    $(document).ready(function() {
        $('#pasal_kontraktual').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Daftar Identifikasi Pasal Kontraktual'
                },
                   
                ]
        } );
    });
</script>

<script>
    $(document).ready(function() {
        $('#pending-issue').DataTable( {
            // dom: 'Bfrtip',
            dom: 'Brti',
            pageLength : 50,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Pending Issue'
                },
                   
                ]
        } );
    });
</script>

@endsection


<!--begin::Aside-->
{{-- @section('aside')
@include('template.aside')
@endsection --}}
<!--end::Aside-->
