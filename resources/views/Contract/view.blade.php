@extends('template.main')
<style>
    input[type="date"]::-webkit-input-placeholder {
        visibility: hidden !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        display: none;
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
            @extends('template.header')
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

                                                            <a href="#" class="btn btn-sm mx-3"
                                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_calendar-start"><i
                                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                                    style="color: #008CB4"></i></a>
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
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                                        <a href="#" role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Perolehan
                                        </a>
                                        <a href="#" role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Terkontrak
                                        </a>
                                        <a href="#" role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Pelaksanaan
                                        </a>
                                        {{-- <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract"
                                            role="link" class="stage-button color-is-default "
                                            style="outline: 0px; cursor: pointer;">
                                            Addendum Kontrak
                                        </a> --}}
                                        <a href="#" role="link" class="stage-button color-is-default"
                                            style="outline: 0px; cursor: pointer;">
                                            Serah Terima Pekerjaan
                                        </a>
                                        <a href="#" role="link" class="stage-button color-is-default"
                                            style="outline: 0px;">
                                            Penutupan Proyek
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
                            if (stage.innerText !== "Addendum Kontrak") {

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
                        @if (Session::has('failed') || Session::has('success'))
                            {{-- Begin:: Alert --}}
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="check-circle-fill" fill="#0f5132" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                </symbol>
                                <symbol id="exclamation-triangle-fill" fill="#842029" viewBox="0 0 16 16">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </symbol>
                            </svg>
                            @if (Session::has('failed'))
                                <div class="alert alert-danger alert-dismissible d-flex align-items-center"
                                    role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                        aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div style="color: #842029;">
                                        {{ Session::get('failed') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>

                                </div>
                            @elseif (Session::has('success'))
                                <div class="alert alert-success alert-dismissible d-flex align-items-center"
                                    role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                        aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <div style="color: #0f5132;">
                                        {{ Session::get('success') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- End:: Alert --}}
                        @endif
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
                                                class="form-control rounded-0 bg-white border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                id="number-contract" name="number-contract"
                                                value="{{ $contract->id_contract ?? '' }}"
                                                placeholder="No. Contract" />
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
                                                class="form-select border-bottom-dashed rounded-0 border-top-0 border-left-0 border-right-0"
                                                data-control="select2" data-hide-search="false"
                                                data-placeholder="Pilih Proyek">
                                                @foreach ($projects as $project_all)
                                                    <option value="{{ $project_all->kode_proyek }}"
                                                        {{ $contract->project->kode_proyek == $project_all->kode_proyek ? 'selected' : '' }}>
                                                        {{ $project_all->nama_proyek }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <!--end::Input-->
                                        </div>
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
                                            <a href="#" class="btn btn-sm mx-3"
                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_calendar-start"><i
                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                    style="color: #008CB4"></i></a>
                                            <input type="Date" data-bs-target="#kt_modal_calendar-start"
                                                class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                placeholder="Select a date"
                                                value="{{ date_format($contract->contract_in ?? now(), 'Y-m-d') }}"
                                                name="start-date" id="start-date" />
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

                                            <a href="#" class="btn btn-sm mx-3"
                                                style="background: transparent;width:1rem;height:2.3rem;"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_calendar-end"><i
                                                    class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center"
                                                    style="color: #008CB4"></i></a>
                                            <!--begin::Input-->
                                            <input type="Date"
                                                class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                value="{{ date_format($contract->contract_out ?? now(), 'Y-m-d') }}"
                                                placeholder="Select a date" id="due-date" name="due-date" />
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
                                                class="form-control rounded-0 border-bottom-dashed border-top-0 border-left-0 border-right-0"
                                                name="number-spk" id="number-spk"
                                                value="{{ $contract->number_spk ?? 0 }}" placeholder="No. SPK" />

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
                                                <span>Nilai Kontrak Awal</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="decimal" id="value-contract"
                                                class="form-control border-bottom-dashed rounded-0 border-top-0 border-left-0 border-right-0"
                                                onkeyup="reformatNumber(this)" name="value"
                                                value="{{ number_format($contract->value ?? 0, 0, ',', ',') }}"
                                                placeholder="Nilai Kontrak" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        {{-- begin:: Format Money --}}
                                        <script></script>
                                        {{-- end:: Format Money --}}

                                    </div>
                                    <!--End begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Nilai Kontrak Review</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="decimal" id="value-review"
                                                class="form-control border-bottom-dashed rounded-0 border-top-0 border-left-0 border-right-0"
                                                onkeyup="reformatNumber(this)" name="value-review"
                                                value="{{ number_format($contract->value_review ?? 0, 0, ',', ',') }}"
                                                placeholder="Nilai Kontrak Review" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        {{-- begin:: Format Money --}}
                                        <script></script>
                                        {{-- end:: Format Money --}}

                                    </div>
                                    <!--End begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Unit Kerja</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" id="unit-kerja"
                                                class="form-control border-bottom-dashed rounded-0 border-top-0 border-left-0 border-right-0"
                                                name="unit-kerja"
                                                value="{{ $contract->project->UnitKerja->unit_kerja }}"
                                                placeholder="Unit Kerja" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        {{-- begin:: Format Money --}}
                                        <script></script>
                                        {{-- end:: Format Money --}}

                                    </div>
                                    <!--End begin::Col-->
                                    <div class="col-6">
                                        <!--begin::Input group Website-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span>Sumber Dana</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" id="sumber-dana"
                                                class="form-control border-bottom-dashed rounded-0 border-top-0 border-left-0 border-right-0"
                                                name="sumber-dana" value="{{ $contract->project->sumber_dana }}"
                                                placeholder="Sumber Dana" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        {{-- begin:: Format Money --}}
                                        <script></script>
                                        {{-- end:: Format Money --}}

                                    </div>
                                    <!--End begin::Col-->
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
    <div class="col-xl-15">
        <!--begin::Contacts-->
        <div class="card card-flush h-lg-100" id="kt_contacts_main">

            <!--begin::Card body-->
            <div class="card-body pt-5">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                    @if ($contract->stages > 0)

                        <!--begin:::Tab item Informasi Perusahaan-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_user_view_overview_tab" style="font-size:14px;">Perolehan</a>
                        </li>
                        <!--end:::Tab item Informasi Perusahaan-->
                    @endif

                    @if ($contract->stages > 1)
                        <!--begin:::Tab item History-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#kt_user_view_overview_history"
                                style="font-size:14px;">Terkontrak</a>
                        </li>
                        <!--end:::Tab item History-->

                    @endif

                    @if ($contract->stages > 2)
                        <!--begin:::Tab item Atachment & Notes-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#kt_user_view_overview_Performance"
                                style="font-size:14px;">Pelaksanaan</a>
                        </li>
                        <!--end:::Tab item Atachment & Notes-->

                    @endif

                    @if ($contract->stages > 3)
                        <!--begin:::Tab item Atachment & Notes-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#kt_user_view_overview_SerahTerima"
                                style="font-size:14px;">Serah Terima Pekerjaan</a>
                        </li>
                        <!--end:::Tab item Atachment & Notes-->

                    @endif

                    @if ($contract->stages > 4)
                        <!--begin:::Tab item Atachment & Notes-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#kt_user_view_overview_penutupan_proyek"
                                style="font-size:14px;">Penutupan Proyek</a>
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
                            <div class="col-6">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Rekomendasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="rekomendasi" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Rekomendasi">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="col-6">
                                <!--begin::Input group Website-->
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
                                Draft Kontrak
                                {{-- <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_proyek">+</a> --}}
                                <a href="/contract-management/view/{{ $contract->id_contract }}/draft-contract"
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
                                                        {{-- <a target="_blank"
                                                                href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                                class="text-gray-600 text-hover-primary mb-1">
                                                                {{ $draftContract->draft_name }}
                                                            </a> --}}
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
                                                        <a href="#"
                                                            class="text-gray-400 text-hover-primary mb-1">
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Draft Contract-->

                            &nbsp;<br>
                            &nbsp;<br>

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
                                        <th class="min-w-125px">Ketentuan</th>
                                        <th class="min-w-125px">Sub Pasal</th>
                                        <th class="min-w-125px">Uraian Penjelasan</th>
                                        <th class="min-w-125px">PIC <i>Cross Function</i></th>
                                        <th class="min-w-125px">Catatan</th>
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
                                                        <p>{{$reviewProject->ketentuan}}</p>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <p>{{$reviewProject->sub_pasal}}</p>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <p>{{$reviewProject->uraian}}</p>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p>{{$reviewProject->pic_cross}}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p>{{$reviewProject->catatan}}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @endif

                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        <th class="min-w-125px">Item Resiko</th>
                                        <th class="min-w-125px">Penyebab</th>
                                        <th class="min-w-125px">Dampak</th>
                                        <th class="min-w-125px">Mitigasi</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->inputRisks->contains("tender_menang", 0))
                                        @forelse ($contract->inputRisks as $inputRisk)
                                            @if ($inputRisk->tender_menang == 0)
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        <th class="min-w-125px">Nama</th>
                                        <th class="min-w-125px">No. Dokumen</th>
                                        <th class="min-w-125px">Kategori</th>
                                        <th class="min-w-125px">Tanggal</th>
                                        <th class="min-w-125px">Catatan</th>
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
                                                        <a target="_blank"
                                                            href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ $questionProject->document_name_question }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ $questionProject->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ $questionProject->kategori_question }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#"
                                                            class="text-gray-400 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($questionProject->created_at), 'd M, Y') }}</a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $questionProject->note_question }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center bg-gray-100">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Review-->

                            <br>
                            <br>

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
                                        <th class="min-w-125px">Usulan Perubahan Klausul</th>
                                        <th class="min-w-125px">Keterangan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <tr>
                                        <td colspan="5" class="bg-gray-100">
                                            <b>Surat Perjanjian Kontrak</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                            @if ($perubahan_draft->kategori == 1)
                                                <td>{{$perubahan_draft->isu}}</td>
                                                <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                <td>{{$perubahan_draft->keterangan}}</td>
                                            @endif
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="bg-gray-100">
                                            <b>Syarat-syarat Umum Kontrak (SSUK)</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                            @if ($perubahan_draft->kategori == 2)
                                                <td>{{$perubahan_draft->isu}}</td>
                                                <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                <td>{{$perubahan_draft->keterangan}}</td>
                                            @endif
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="bg-gray-100">
                                            <b>Syarat-syarat Khusus Kontrak (SSKK)</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        @foreach ($contract->UsulanPerubahanDraft as $perubahan_draft)
                                            @if ($perubahan_draft->kategori == 3)
                                                <td>{{$perubahan_draft->isu}}</td>
                                                <td>{{$perubahan_draft->deskripsi_klausul_awal}}</td>
                                                <td>{{$perubahan_draft->usulan_perubahan_klausul}}</td>
                                                <td>{{$perubahan_draft->keterangan}}</td>
                                            @endif
                                        @endforeach
                                    </tr>

                                </tbody>
                                <!--end::Table body-->

                            </table>
                            <!--End:Table: Review-->
                        </div>
                    </div>
                    <!--end:::Tab pane Informasi Perusahaan-->

                    <!--begin:::Tab pane History-->
                    <div class="tab-pane fade" id="kt_user_view_overview_history" role="tabpanel">

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
                                    <select name="Instansi" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true" data-placeholder="Instansi">
                                        <option></option>
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
                                Draft Kontrak
                                <a href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/tender-menang/1"
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
                                                        href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        <th class="min-w-125px">Ketentuan</th>
                                        <th class="min-w-125px">Sub Pasal</th>
                                        <th class="min-w-125px">Uraian Penjelasan</th>
                                        <th class="min-w-125px">PIC <i>Cross Function</i></th>
                                        <th class="min-w-125px">Catatan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->reviewProjects->contains("stage", 2))
                                        @forelse ($contract->reviewProjects as $review)
                                            @if ($review->stage == 2)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <p>{{$reviewProject->ketentuan}}</p>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <p>{{$reviewProject->sub_pasal}}</p>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <p>{{$reviewProject->uraian}}</p>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p>{{$reviewProject->pic_cross}}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        <p>{{$reviewProject->catatan}}</p>
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-dark bg-gray-100">
                                                    <b>There is no data</b>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-dark bg-gray-100">
                                                <b>There is no data</b>
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
                                                    <a target="_blank" href="/document/view/{{$klarifikasi_negosiasi->id_klarifikasi}}/{{$klarifikasi_negosiasi->id_document}}" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $klarifikasi_negosiasi->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $klarifikasi_negosiasi->User->name }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($klarifikasi_negosiasi->created_at), "d-m-Y") }}</p>
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                                    <a target="_blank" href="/document/view/{{$kontrak_tanda_tangan->id_kontrak_bertandatangan}}/{{$kontrak_tanda_tangan->id_document}}" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $kontrak_tanda_tangan->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $kontrak_tanda_tangan->User->name }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($kontrak_tanda_tangan->created_at), "d-m-Y") }}</p>
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspa colspan="4" class="text-center bg-gray-100">
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
                                                    <a target="_blank" href="/document/view/{{$review_pembatalan_kontrak->id_review_pembatalan_kontrak}}/{{$review_pembatalan_kontrak->id_document}}" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $review_pembatalan_kontrak->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $review_pembatalan_kontrak->User->name }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($review_pembatalan_kontrak->created_at), "d-m-Y") }}</p>
                                                </td>
                                                <!--end::Kode=-->
                                                <!--begin::Unit=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $review_pembatalan_kontrak->note }}</p>
                                                </td>
                                                <!--end::Unit=-->
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspa colspan="4" class="text-center bg-gray-100">
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
                                                    <a target="_blank" href="/document/view/{{$perjanjian_kso->id_perjanjian_kso}}/{{$perjanjian_kso->id_document}}" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($perjanjian_kso->created_at), "d-m-Y") }}</p>
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        <th class="min-w-125px">Item Resiko</th>
                                        <th class="min-w-125px">Penyebab</th>
                                        <th class="min-w-125px">Dampak</th>
                                        <th class="min-w-125px">Mitigasi</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->inputRisks->contains("tender_menang", 1))
                                        @forelse ($contract->inputRisks as $inputRisk)
                                            @if ($inputRisk->tender_menang == 1)
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                                    <a target="_blank" href="/document/view/{{$dokumen_pendukung->id_dokumen_pendukung}}/{{$dokumen_pendukung->id_document}}" class="text-gray-600 text-hover-primary mb-1">
                                                        {{ $dokumen_pendukung->document_name }}
                                                    </a>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Name=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->User->name }}</p>
                                                </td>
                                                <!--end::Name=-->
                                                <!--begin::Kode=-->
                                                <td>
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($dokumen_pendukung->created_at), "d-m-Y") }}</p>
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        $classes = "";
                                        if(isset($contract)) {
                                            $classes = "form-control-solid";
                                        } else {
                                            $classes = "border-bottom-dashed border-top-0 border-left-0 border-right-0";
                                        }
                                    @endphp
                                    @if (isset($contract))
                                        @forelse ($contract->monthlyReports as $monthlyReport)
                                            <tr>
                                                <!--begin::Name=-->
                                                <td>
                                                    <a target="_blank"
                                                        href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                        class="text-gray-600 {{$classes}} text-hover-primary mb-1">
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                Addendum Kontrak
                                <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract"
                                    Id="Plus">+</a>
                            </h3>

                            <!--begin:Table: Addendum Kontrak-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">No. Dokumen</th>
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
                                                <td colspan="3" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center bg-gray-100">
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
                                <a href="/claim-management/{{ $contract->project->kode_proyek }}/{{ $contract->id_contract }}/new"
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
                                                <td colspan="3" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center bg-gray-100">
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
                                                    <a target="_blank" href="/document/view/{{$mom_meeting->id_mom}}/{{$mom_meeting->id_document}}" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <p class="text-gray-600 mb-1">{{ date_format(new DateTime($mom_meeting->created_at), "d-m-Y") }}</p>
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                        <th class="min-w-125px">Item Resiko</th>
                                        <th class="min-w-125px">Penyebab</th>
                                        <th class="min-w-125px">Dampak</th>
                                        <th class="min-w-125px">Mitigasi</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->inputRisks->contains("tender_menang", 3))
                                        @forelse ($contract->inputRisks as $inputRisk)
                                            @if ($inputRisk->tender_menang == 3)
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
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
                                                    <p class="text-gray-600 mb-1">{{$key + 1}}</p>
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
                                                <td colspan="2" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-center bg-gray-100">
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
                    <!--end:::Tab pane Laporan Bulanan-->

                    <!--begin:::Tab pane Serah Terima-->
                    <div class="tab-pane fade" id="kt_user_view_overview_SerahTerima" role="tabpanel">
                        <div class="card-title m-0">
                            <form action="/contract-management/document-bast/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id-contract" value="{{ $contract->id_contract }}">
                                <div class="row">
                                    <div class="col">
                                        <label for="dokumen-bast-1" class="form-label">Dokumen Bast 1</label>
                                        <input type="file" name="dokumen-bast-1" accept=".docx" class="form-control form-control-solid">
                                        @if (!empty($contract->dokumen_bast_1))
                                            <small>Lihat Dokumen Bast 1: <a class="text-gray-400 text-hover-primary" href="/document/view/{{$contract->id_contract}}/{{$contract->dokumen_bast_1}}">Klik disini</a></small>
                                        @else
                                            <small>Belum mendapatkan Dokumen Bast 1</small>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="dokumen-bast-2" class="form-label">Dokumen Bast 2</label>
                                        <input type="file" name="dokumen-bast-2" accept=".docx" class="form-control form-control-solid">
                                        @if (!empty($contract->dokumen_bast_1))
                                            <small>Lihat Dokumen Bast 2: <a class="text-gray-400 text-hover-primary" href="/document/view/{{$contract->id_contract}}/{{$contract->dokumen_bast_2}}">Klik disini</a></small>
                                        @else
                                            <small>Belum mendapatkan Dokumen Bast 2</small>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-sm btn-active-primary text-white" style="background-color: #008cb4;">Save Dokumen Bast</button>
                            </form>

                            <hr>
                            <div class="row">

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
                                        <th class="min-w-125px">Item Resiko</th>
                                        <th class="min-w-125px">Penyebab</th>
                                        <th class="min-w-125px">Dampak</th>
                                        <th class="min-w-125px">Mitigasi</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-400">
                                    @if ($contract->inputRisks->contains("stage", 4))
                                        @forelse ($contract->inputRisks as $inputRisk)
                                            @if ($inputRisk->stage == 4)
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
                                                <td colspan="4" class="text-center bg-gray-100">
                                                    <h6><b>There is no data</b></h6>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center bg-gray-100">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <!--end::Table body-->

                            </table>

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
                                    <th class="min-w-125px">No</th>
                                    <th class="min-w-125px">Dokumen</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            @php
                                $list_document_ba_defect = explode(",", $contract->list_dokumen_ba_defect);
                            @endphp
                            <tbody class="fw-bold text-gray-400">
                                @if (count($list_document_ba_defect) > 0 && $list_document_ba_defect[0] != "")
                                    @forelse ($list_document_ba_defect as $key => $ba_defect)
                                    <tr>
                                        <!--begin::Name=-->
                                        <td>
                                            <a class="text-gray-600 text-hover-primary">Dokumen BA Defect #{{$key + 1}}</a>
                                        </td>
                                        <!--end::Name=-->
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center bg-gray-100">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center bg-gray-100">
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
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px">Penyebab</th>
                                    <th class="min-w-125px">Biaya</th>
                                    <th class="min-w-125px">Waktu</th>
                                    <th class="min-w-125px">Mutu</th>
                                    <th class="min-w-125px">Ancaman</th>
                                    <th class="min-w-125px">Peluang</th>
                                    <th class="min-w-125px">Rencana Tindak Lanjut</th>
                                    <th class="min-w-125px">Target Waktu Penyelesaian</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-400">
                                @foreach ($contract->PendingIssue as $key => $pending_issue)
                                    <tr>
                                        @if (Str::isUuid($pending_issue->issue))
                                            <!--begin::Name=-->
                                            <td>
                                                <a href="/document/view/{{$contract->id_contract}}/{{$pending_issue->issue}}/pict" class="text-gray-600 text-hover-primary">Gambar #{{$key + 1}}</a>
                                            </td>
                                            <!--end::Name=-->
                                        @else
                                            <!--begin::Name=-->
                                            <td>
                                                <p class="text-gray-600">{{$pending_issue->issue}}</p>
                                            </td>
                                            <!--end::Name=-->
                                        @endif

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

                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->penyebab}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{number_format($pending_issue->biaya, 2, ",", ",")}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->waktu}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->mutu}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->ancaman}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->peluang}}</p>
                                        </td>
                                        
                                        <td>
                                            <p class="text-gray-600">{{$pending_issue->rencana_tindak_lanjut}}</p>
                                        </td>

                                        <td>
                                            <p class="text-gray-600">{{Carbon\Carbon::parse($pending_issue->target_waktu_penyelesaian)->translatedFormat("d F Y")}}</p>
                                        </td>
                                        
                                    </tr>
                                @endforeach
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
                                $list_document_dokumen_pendukung = explode(",", $contract->dokumen_pendukung);
                            @endphp
                            <tbody class="fw-bold text-gray-400">
                                @if (count($list_document_dokumen_pendukung) > 0 && $list_document_dokumen_pendukung[0] != "")
                                    @forelse ($list_document_dokumen_pendukung as $key => $dokumen_pendukung)
                                    <tr>
                                        <!--begin::Name=-->
                                        <td>
                                            <a href="/document/view/{{$contract->id_contract}}/{{$dokumen_pendukung}}" class="text-gray-600 text-hover-primary">Dokumen Lainnya #{{$key + 1}}</a>
                                        </td>
                                        <!--end::Name=-->
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center bg-gray-100">
                                                <h6><b>There is no data</b></h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center bg-gray-100">
                                            <h6><b>There is no data</b></h6>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <!--end::Table body-->

                        </table>
                        </div>
                    </div>
                    <!--end:::Tab pane Serah Terima-->

                    <!--begin:::Tab pane Serah Terima-->
                    <div class="tab-pane fade" id="kt_user_view_overview_penutupan_proyek" role="tabpanel">
                        <div class="card-title m-0">
                            <h3 class="fw-normal mb-2" style="font-size:14px;">
                                Upload Dokumen Kontrak dan Addendum
                            </h3>
                            <form action="/contract-management/penutupan-proyek/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$contract->id_contract}}" name="id-contract">
                                <input type="file" accept=".docx" multiple name="kontrak-dan-addendum-file[]" class="form-control form-control-solid">
                                <small>* Support multiple file upload</small>
                                <br><br>
                                <button type="submit" class="btn btn-sm btn-active-primary text-white" style="background-color: #008CB4;">Save Dokumen</button>
                            </form>
                            <hr>
                            @php
                                $list_dokumen_kontrak_dan_addendum = explode(",", $contract->dokumen_kontrak_dan_addendum);
                            @endphp
                            @if (count($list_dokumen_kontrak_dan_addendum) > 0 && $list_dokumen_kontrak_dan_addendum[0] != "")
                                <b>Daftar Dokumen Kontrak dan Addendum</b>
                                <ul class="list-group list-group-flush">
                                @foreach ($list_dokumen_kontrak_dan_addendum as $key => $kontrak_dan_addendum)
                                    <li class="list-group-item">
                                        <a href="/document/view/{{$contract->id_contract}}/{{$kontrak_dan_addendum}}" class="text-gray-600 text-hover-primary">Dokumen #{{$key + 1}}</a>
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

@if ($contract->stages > 1)

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
                <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$contract->id_contract ?? 0}}" name="id-contract">
                    <input type="hidden" value="2" name="stage">
                    <div class="row mb-5">  
                        <div class="col-6 border-end">
                            <div class="row ">
                                <div class="col">
                                    <label for="ketentuan-review" class="fs-6 fw-bold form-label mt-3">Ketentuan</label>
                                    <input type="text" name="ketentuan-review" id="ketentuan-review" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
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
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-active-primary text-white" style="background-color: #008CB4">Save</button>
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
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-tandan-tangan" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
                    <h2>Add Attachment | Perjanjian KSO  </h2>
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
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-perjanjian-kso" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
                    <h2>Add Attachment | Review Pembatalan Kontrak  </h2>
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
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name-pendukung" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
                    <h2>Add Attachment | Dokumen Pendukung  </h2>
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
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name-pendukung" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
                    <h2>Add Attachment | MoM Kick Off Meeting  </h2>
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
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="attach-file"
                                id="attach-file-mom-meeting" value="" accept=".docx"
                                placeholder="" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid"
                                name="document-name" id="document-name-pendukung" value=""
                                style="font-weight: normal" placeholder="Nama Document" />
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
        
                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Resiko</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="1" name="is-tender-menang">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                        <input type="text" class="form-control form-control-solid" name="resiko" id="resiko"
                            style="font-weight: normal" value="" placeholder="Resiko" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Penyebab</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="penyebab" id="penyebab"
                            style="font-weight: normal" value="" placeholder="Penyebab" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Dampak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="dampak" id="dampak"
                            value="" placeholder="Dampak" style="font-weight: normal" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Mitigasi</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="mitigasi"
                            id="mitigasi" value="" placeholder="Mitigasi" style="font-weight: normal" />
                        <!--end::Input-->
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
        
                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Resiko</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="3" name="stage">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                        <input type="text" class="form-control form-control-solid" name="resiko" id="resiko"
                            style="font-weight: normal" value="" placeholder="Resiko" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Penyebab</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="penyebab" id="penyebab"
                            style="font-weight: normal" value="" placeholder="Penyebab" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Dampak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="dampak" id="dampak"
                            value="" placeholder="Dampak" style="font-weight: normal" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Mitigasi</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="mitigasi"
                            id="mitigasi" value="" placeholder="Mitigasi" style="font-weight: normal" />
                        <!--end::Input-->
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
        
                    <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Resiko</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="4" name="stage">
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                        <input type="text" class="form-control form-control-solid" name="resiko" id="resiko"
                            style="font-weight: normal" value="" placeholder="Resiko" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Penyebab</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="penyebab" id="penyebab"
                            style="font-weight: normal" value="" placeholder="Penyebab" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Dampak</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="dampak" id="dampak"
                            value="" placeholder="Dampak" style="font-weight: normal" />
                        <!--end::Input-->
        
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Mitigasi</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid mb-3" name="mitigasi"
                            id="mitigasi" value="" placeholder="Mitigasi" style="font-weight: normal" />
                        <!--end::Input-->
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
        
                    <form action="/contract-management/ba-defect/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id-contract" value="{{$contract->id_contract}}">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <input type="file" multiple accept=".docx" name="ba-defect[]" class="form-control form-control-solid">
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
        
                    <form action="/contract-management/dokumen-pendukung/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id-contract" value="{{$contract->id_contract}}">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Masukan file dibawah ini</span>
                        </label>
                        <!--end::Label-->
                        <input type="file" multiple accept=".docx,.xlsx" name="dokumen-pendukung[]" class="form-control form-control-solid">
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
        
                    <form action="/contract-management/pending-issue/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id-contract" value="{{$contract->id_contract}}">

                        <div class="row">
                            <div class="col d-flex flex-column justify-content-center">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Masukan file dibawah ini</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" accept=".jpg,.jpeg,.png" name="pending-issue-file" class="form-control form-control-solid">
                                {{-- end::Read File --}}
                                <small>* hanya menerima file dengan format <b>.jpg</b>, <b>.jpeg</b> dan <b>.png</b></small>
                            </div>

                            <div class="col-1 d-flex flex-col align-items-center justify-content-center mt-8">
                                <p><b>atau</b></p>
                            </div>

                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Issue</span>
                                </label>
                                <!--end::Label-->
                                <textarea name="pending-issue" rows="1" class="form-control form-control-solid"></textarea>
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
                                <select name="status" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Status" data-select2-id="select2-data-project-id" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">Open</option>
                                    <option value="0">Close</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col">
                            <h3 class="text-center"><b>Resiko / Dampak</b></h3>
                            <div class="row">
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Biaya</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="text" class="form-control form-control-solid" name="biaya" id="biaya">
                                </div>
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Waktu</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="date" class="form-control form-control-solid" name="waktu" id="waktu">
                                </div>
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span style="font-weight: normal">Mutu</span>
                                    </label>
                                    <!--end::Label-->

                                    <input type="text" class="form-control form-control-solid" name="mutu" id="mutu">
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

                                <input type="text" class="form-control form-control-solid" name="ancaman" id="ancaman">
                            </div>
                            
                            <div class="col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Peluang</span>
                                </label>
                                <!--end::Label-->
    
                                <input type="text" class="form-control form-control-solid" name="peluang" id="peluang">
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
    
                                <textarea class="form-control form-control-solid" rows="1" name="rencana-tindak-lanjut" id="rencana-tindak-lanjut"></textarea>
                            </div>

                            <div class="col d-flex flex-column justify-content-center">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Target Waktu Penyelesaian</span>
                                </label>
                                <!--end::Label-->
    
                                <input type="date" class="form-control form-control-solid" name="target-waktu-penyelesaian" id="target-waktu-penyelesaian">
                            </div>
                        </div>
                        
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
    <div class="modal fade" id="kt_modal_usulan_perubahan_draft_kontrak" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Usulan Perubahan Draft Kontrak</h2>
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
                    <div class="fv-row mb-5">
                        <form action="/contract-management/usulan-perubahan-draft/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Kategori</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            {{-- <input type="hidden" value="1" name="is-tender-menang"> --}}
                            <select name="kategori" id="kategori" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori" tabindex="-1" aria-hidden="false">
                                <option value=""></option>
                                <option value="1">Surat Perjanjian Kontrak</option>
                                <option value="2">Syarat-syarat Umum Kontrak (SSUK)</option>
                                <option value="3">Syarat-syarat Khusus Kontrak (SSKK)</option>
                            </select>
                            <!--end::Input-->

                            <br><br>

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Isu</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            {{-- <input type="hidden" value="1" name="is-tender-menang"> --}}
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                name="id-contract">
                            <input type="text" class="form-control form-control-solid"
                                name="isu-perubahan-draft" id="isu-perubahan-draft" value=""
                                placeholder="Isu" />
                            <!--end::Input-->

                            <br><br>

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Deskripsi Klausul Awal</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="deskripsi-klausul-awal" id="deskripsi-klausul-awal" rows="1"></textarea>
                            <!--end::Input-->

                            <br><br>

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Usulan Perubahan Klausul</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" style="font-weight: normal"
                                class="form-control form-control-solid" name="usulan-peurbahan-klausul" id="usulan-peurbahan-klausul"
                                value="" placeholder="Usulan" />
                            <!--end::Input-->

                            <br><br>

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label">
                                <span style="font-weight: normal">Keterangan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea style="font-weight: normal"
                                class="form-control form-control-solid" name="keterangan" id="keterangan" rows="1" placeholder="Keterangan"></textarea>
                            <!--end::Input-->

                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-question-tender-menang" class="btn btn-lg btn-primary">Save</button>
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
                    <form action="/contract-management/rencana-kerja-kontrak/upload" method="POST" enctype="multipart/form-data">
                        <div class="row">
                                @csrf
                                <div class="col">
                                    <!--begin::Label-->
                                    <label for="ketentuan-rencana-kerja" class="fs-6 fw-bold form-label">
                                        <span style="font-weight: normal">Ketentuan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    {{-- <input type="hidden" value="1" name="is-tender-menang"> --}}
                                    <textarea name="ketentuan-rencana-kerja" id="ketentuan-rencana-kerja" rows="10" class="form-control form-control-solid"></textarea>
                                    <!--end::Input-->
                                </div>

                                <br><br>

                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label">
                                        <span style="font-weight: normal">Informasi Kelengkapan <i>Check List</i> ADKON</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    {{-- <input type="hidden" value="1" name="is-tender-menang"> --}}
                                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                        name="id-contract">
                                    <textarea name="kelengkapan-adkon" id="kelengkapan-adkon" rows="10" class="form-control form-control-solid"></textarea>
                                    <!--end::Input-->
                                </div>

                        </div>
                        <!--end::Input group-->
                        <div class="modal-footer mt-4">
                            <button type="submit" id="save-question-tender-menang" class="btn btn-sm btn-primary">Save</button>
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
@endif
@endisset

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
                <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$contract->id_contract ?? 0}}" name="id-contract">
                    <input type="hidden" value="0" name="stage">
                    <div class="row mb-5">  
                        <div class="col-6 border-end">
                            <div class="row ">
                                <div class="col">
                                    <label for="ketentuan-review" class="fs-6 fw-bold form-label mt-3">Ketentuan</label>
                                    <input type="text" name="ketentuan-review" id="ketentuan-review" class="form-control form-control-solid">
                                </div>
                            </div>
                            <br>
                            <div class="row">
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
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-active-primary text-white" style="background-color: #008CB4">Save</button>
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

            <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label mt-3">
                    <span style="font-weight: normal">Resiko</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                <input type="text" class="form-control form-control-solid" name="resiko" id="resiko"
                    style="font-weight: normal" value="" placeholder="Resiko" />
                <!--end::Input-->

                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label mt-3">
                    <span style="font-weight: normal">Penyebab</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid" name="penyebab" id="penyebab"
                    style="font-weight: normal" value="" placeholder="Penyebab" />
                <!--end::Input-->

                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label mt-3">
                    <span style="font-weight: normal">Dampak</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid" name="dampak" id="dampak"
                    value="" placeholder="Dampak" style="font-weight: normal" />
                <!--end::Input-->

                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label mt-3">
                    <span style="font-weight: normal">Mitigasi</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid mb-3" name="mitigasi"
                    id="mitigasi" value="" placeholder="Mitigasi" style="font-weight: normal" />
                <!--end::Input-->
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
            <h2>Add Question</h2>
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
                <form action="/question/upload" enctype="multipart/form-data" method="POST">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                        name="id-contract">
                    <input type="file" class="form-control form-control-solid" name="attach-file-question"
                        id="attach-file-question" value="" style="font-weight: normal" accept=".docx"
                        placeholder="Name Proyek" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Kategori Pertanyaan</span>
                    </label>
                    <!--end::Label-->

                    {{-- Begin :: Select Kategori Dokumen --}}
                    <select name="kategori-Aanwitjzing" id="kategori-Aanwitjzing"
                        class="form-select form-select-solid"
                        data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori Pertanyaan"
                        data-select2-id="select2-data-kategori-Aanwitjzing" tabindex="-1" aria-hidden="true">
                        <option value=""></option>
                        <option value="Pertanyaan Aanwitjzing">
                            Pertanyaan Aanwitjzing
                        </option>
                        <option value="Jawaban Aanwitjzing">
                            Jawaban Aanwitjzing
                        </option>
                        <option value="Berita Acara Aanwitjzing">
                            Berita Acara Aanwitjzing
                        </option>
                    </select>
                    {{-- End :: Select Kategori Dokumen --}}

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid"
                        name="document-name-question" id="document-name-question" style="font-weight: normal"
                        value="" placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="note-question"
                        id="note-question" style="font-weight: normal" value=""
                        placeholder="Catatan" />
                    <!--end::Input-->
                    <small id="file-error-msg-question" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-question">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        document.getElementById("attach-file-question").addEventListener("change", async function() {
                            await readFile(this.files[0], "#froala-editor-question");
                        });
                    </script>
                    {{-- end::Read File --}}
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
        //             <td colspan="2" class="text-center bg-gray-100"><b>Pasal belum terpilih</b></td>
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
</script>

@endsection


<!--begin::Aside-->
{{-- @section('aside')
@include('template.aside')
@endsection --}}
<!--end::Aside-->
