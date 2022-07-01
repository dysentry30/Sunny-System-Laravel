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
                            </div>

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
                                                                <input type="text" class="form-control form-control-solid"
                                                                    id="number-contract" name="number-contract" value="{{ old('number-contract') }}"
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
                                                                        <option value="{{ $project->kode_proyek}}" {{ old ('project-id' ) == $project->kode_proyek ? "selected" : "" }}>{{ $project->nama_proyek }}</option>
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
                                                                        style="color: #e08c16"></i></a>
                                                                <input type="Date"
                                                                    class="form-control form-control-solid ps-12"
                                                                    placeholder="Select a date" value="{{ old('start-date') }}" name="start-date"
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
                                                                        style="color: #e08c16"></i></a>
                                                                <input type="Date"
                                                                    class="form-control form-control-solid ps-12" value="{{ old('due-date') }}"
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

                                                                <input type="text" class="form-control form-control-solid"
                                                                    name="number-spk" id="number-spk" value="{{ old('number-spk') }}"
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
                                                                    class="form-control form-control-solid" name="value"
                                                                    value="{{ old('value') }}" placeholder="Nilai Kontrak" />
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

                        <!--begin::Header Contract-->
                        <div class="col-xl-15">
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">

                                <div class="card-body pt-5" style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                    <div class="form-group">

                                        <div id="stage-button" class="stage-list">
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Draft
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Terkontrak
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Pelaksanaan
                                            </a>
                                            <a href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract"
                                                role="link" class="stage-button color-is-default "
                                                style="outline: 0px; cursor: pointer;">
                                                Addendum Kontrak
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default"
                                                style="outline: 0px; cursor: pointer;">
                                                Serah Terima Pekerjaan
                                            </a>
                                            <a href="#" role="link" class="stage-button color-is-default"
                                                style="outline: 0px;">
                                                Closing Proyek
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
                                        const stage = e.target.getAttribute("stage");
                                        const formData = new FormData();
                                        formData.append("_token", "{{ csrf_token() }}");
                                        formData.append("stage", stage);
                                        // formData.append("id", "");
                                        formData.append("id_contract", "{{ $contract->id_contract }}");
                                        const setStage = await fetch("/stage/save", {
                                            method: "POST",
                                            body: formData
                                        }).then(res => res.json());
                                        if (setStage.link) {
                                            // window.location.href = setStage.link;
                                            window.location.reload();
                                        }
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
                                                <input type="text" class="form-control form-control-solid"
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
                                                    class="form-select form-select-solid" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Pilih Proyek">
                                                    @foreach ($projects as $project_all)
                                                        <option value="{{ $project_all->kode_proyek }}"
                                                            {{ $contract->project->kode_proyek == $project_all->kode_proyek ? "selected" : ""}}>
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
                                                        style="color: #e08c16"></i></a>
                                                <input type="Date" data-bs-target="#kt_modal_calendar-start"
                                                    class="form-control form-control-solid ps-12"
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
                                                        style="color: #e08c16"></i></a>
                                                <!--begin::Input-->
                                                <input type="Date" class="form-control form-control-solid ps-12"
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

                                                <input type="text" class="form-control form-control-solid"
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
                                                    <span>Nilai Kontrak</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="decimal" id="value-contract"
                                                    class="form-control form-control-solid" name="value"
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
                                    href="#kt_user_view_overview_tab" style="font-size:14px;">Tender
                                    Awal</a>
                            </li>
                            <!--end:::Tab item Informasi Perusahaan-->
                        @endif

                        @if ($contract->stages > 1)
                            <!--begin:::Tab item History-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                    data-bs-toggle="tab" href="#kt_user_view_overview_history"
                                    style="font-size:14px;">Tender
                                    Menang</a>
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
                                        <select name="Instansi" class="form-select form-select-solid"
                                            data-control="select2" data-hide-search="true" data-placeholder="Instansi">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->draftContracts as $draftContract)
                                                @if ($draftContract->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{-- <a target="_blank"
                                                                href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $draftContract->draft_name }}
                                                            </a> --}}
                                                            <a target="_blank"
                                                                href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/{{ $draftContract->id_draft }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $draftContract->title_draft }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $draftContract->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                            <th class="min-w-125px">Nama Dokumen</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->reviewProjects as $reviewProject)
                                                @if ($reviewProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $reviewProject->id_review }}/{{ $reviewProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $reviewProject->document_name_review }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $reviewProject->id_review }}/{{ $reviewProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $reviewProject->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($reviewProject->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $reviewProject->note_review }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif

                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Issue Project
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_issue_proyek">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->issueProjects as $issueProject)
                                                @if ($issueProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $issueProject->id_issue }}/{{ $issueProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $issueProject->document_name_issue }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $issueProject->id_issue }}/{{ $issueProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $issueProject->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($issueProject->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $issueProject->note_issue }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->inputRisks as $inputRisk)
                                                @if ($inputRisk->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $inputRisk->id_risk }}/{{ $inputRisk->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $inputRisk->document_name_risk }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $inputRisk->id_risk }}/{{ $inputRisk->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $inputRisk->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                                {{ date_format(new DateTime($inputRisk->created_at), 'd M, Y') }}</a>
                                                        </td>
                                                        <!--end::Kode=-->
                                                        <!--begin::Unit=-->
                                                        <td>{{ $inputRisk->note_risk }}
                                                        </td>
                                                        <!--end::Unit=-->
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->


                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Daftar Pertanyaan
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
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->questionsProjects as $questionProject)
                                                @if ($questionProject->tender_menang == 0)
                                                    <tr>
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $questionProject->document_name_question }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a target="_blank"
                                                                href="/document/view/{{ $questionProject->id_question }}/{{ $questionProject->id_document }}"
                                                                class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $questionProject->id_document }}
                                                            </a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Kode=-->
                                                        <td>
                                                            <a href="#" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                    <a href="/contract-management/view/{{ $contract->id_contract }}/draft-contract/tender-menang"
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->draftContracts as $draftContract)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $draftContract->title_draft }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $draftContract->id_draft }}/{{ $draftContract->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $draftContract->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                        @if (isset($contract))
                                            @forelse ($contract->reviewProjects as $review)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $review->id_review }}/{{ $review->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $review->document_name_review }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $review->id_review }}/{{ $review->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $review->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($review->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $review->note_review }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td><b>There is no data</b></td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td><b>There is no data</b></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <!--end::Table body-->

                                </table>
                                <!--End:Table: Review-->

                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Issue Project
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_issue_project_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->issueProjects as $issue)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="/document/view/{{ $issue->id_issue }}/{{ $issue->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $issue->document_name_issue }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $issue->id_issue }}/{{ $issue->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $issue->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($issue->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $issue->note_issue }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No. Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->inputRisks as $risk)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $risk->id_risk }}/{{ $risk->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $risk->document_name_risk }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="/document/view/{{ $risk->id_risk }}/{{ $risk->id_document }}"
                                                            target="_blank" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $risk->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($risk->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $risk->note_risk }}</td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->


                                &nbsp;<br>
                                &nbsp;<br>

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Daftar Pertanyaan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_question_menang">+</a>
                                </h3>

                                <!--begin:Table: Review-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nama</th>
                                            <th class="min-w-125px">No Dokumen</th>
                                            <th class="min-w-125px">Tanggal</th>
                                            <th class="min-w-125px">Catatan</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->questionsProjects as $question)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $question->id_question }}/{{ $question->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $question->document_name_question }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $question->id_question }}/{{ $question->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $question->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a target="_blank" href="#"
                                                            class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($question->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>{{ $question->note_question }}
                                                    </td>
                                                    <!--end::Unit=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->monthlyReports as $monthlyReport)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $monthlyReport->document_name_report }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $monthlyReport->id_report }}/{{ $monthlyReport->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $monthlyReport->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
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
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->addendumContracts as $addendumContract)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/contract-management/view/{{ $contract->id_contract }}/addendum-contract/{{ $addendumContract->id_addendum }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $addendumContract->no_addendum }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $addendumContract->created_by }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($addendumContract->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Addendum Kontrak-->

                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Klaim Kontrak
                                    <a href="/claim-management/{{$contract->project->kode_proyek}}/{{$contract->id_contract}}/new"
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract->project->ClaimManagements))
                                            @forelse ($contract->project->ClaimManagements as $claimManagement)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/claim-management/view/{{$claimManagement->id_claim}}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $claimManagement->id_claim }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $claimManagement->pic }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($claimManagement->tanggal_claim), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    
                                                    
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Claim Contract-->
                            </div>
                        </div>
                        <!--end:::Tab pane Laporan Bulanan-->

                        <!--begin:::Tab pane Serah Terima-->
                        <div class="tab-pane fade" id="kt_user_view_overview_SerahTerima" role="tabpanel">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                    Dokumen Serah Terima Pekerjaan
                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_serah_terima">+</a>
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
                                    <tbody class="fw-bold text-gray-600">
                                        @if (isset($contract))
                                            @forelse ($contract->handOvers as $hand_over)
                                                <tr>
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a target="_blank"
                                                            href="/document/view/{{ $hand_over->id_handover }}/{{ $hand_over->id_document }}"
                                                            class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $hand_over->document_name_terima }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="/document/view/{{ $hand_over->id_handover }}/{{ $hand_over->id_document }}"
                                                            target="_blank" class="text-gray-800 text-hover-primary mb-1">
                                                            {{ $hand_over->id_document }}
                                                        </a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Kode=-->
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">
                                                            {{ date_format(new DateTime($hand_over->created_at), 'd M, Y') }}</a>
                                                        </a>
                                                    </td>
                                                    <!--end::Kode=-->
                                                    <!--begin::Unit=-->
                                                    <td>
                                                        {{ $hand_over->note_terima }}
                                                    </td>
                                                    <!--end::Unit=-->

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        <h6><b>There is no data</b></h6>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                <!--End:Table: Review-->

                            </div>
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


<!--begin::Modal - Create App-->
<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Create App</h2>
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
            <div class="modal-body py-lg-10 px-lg-10">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                    id="kt_modal_create_app_stepper">
                    <!--begin::Aside-->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <!--begin::Nav-->
                        <div class="stepper-nav ps-lg-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Details</h3>
                                    <div class="stepper-desc">Name your App</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Frameworks</h3>
                                    <div class="stepper-desc">Define your app framework</div>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">3</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Database</h3>
                                    <div class="stepper-desc">Select the app database type</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">4</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Billing</h3>
                                    <div class="stepper-desc">Provide payment details</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">5</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Completed</h3>
                                    <div class="stepper-desc">Review and Submit</div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 5-->
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid py-lg-5 px-lg-15">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_modal_create_app_form">
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-2">
                                            <span class="required">App Name</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your unique app name"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="name" placeholder="" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Category</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Select your app category"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Options-->
                                        <div class="fv-row">
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-primary">
                                                            <!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Quick Online Courses</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            is just one SEO</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="1" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-danger">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                    height="24px" viewBox="0 0 24 24">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="5" y="5" width="5" height="5" rx="1"
                                                                            fill="#000000" />
                                                                        <rect x="14" y="5" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                        <rect x="5" y="14" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                        <rect x="14" y="14" width="5" height="5" rx="1"
                                                                            fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Face to Face Discussions</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            is just one aspect</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="2" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                            <!--begin:Option-->
                                            <label class="d-flex flex-stack cursor-pointer">
                                                <!--begin:Label-->
                                                <span class="d-flex align-items-center me-2">
                                                    <!--begin:Icon-->
                                                    <span class="symbol symbol-50px me-6">
                                                        <span class="symbol-label bg-light-success">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen013.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M20.9 12.9C20.3 12.9 19.9 12.5 19.9 11.9C19.9 11.3 20.3 10.9 20.9 10.9H21.8C21.3 6.2 17.6 2.4 12.9 2V2.9C12.9 3.5 12.5 3.9 11.9 3.9C11.3 3.9 10.9 3.5 10.9 2.9V2C6.19999 2.5 2.4 6.2 2 10.9H2.89999C3.49999 10.9 3.89999 11.3 3.89999 11.9C3.89999 12.5 3.49999 12.9 2.89999 12.9H2C2.5 17.6 6.19999 21.4 10.9 21.8V20.9C10.9 20.3 11.3 19.9 11.9 19.9C12.5 19.9 12.9 20.3 12.9 20.9V21.8C17.6 21.3 21.4 17.6 21.8 12.9H20.9Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M16.9 10.9H13.6C13.4 10.6 13.2 10.4 12.9 10.2V5.90002C12.9 5.30002 12.5 4.90002 11.9 4.90002C11.3 4.90002 10.9 5.30002 10.9 5.90002V10.2C10.6 10.4 10.4 10.6 10.2 10.9H9.89999C9.29999 10.9 8.89999 11.3 8.89999 11.9C8.89999 12.5 9.29999 12.9 9.89999 12.9H10.2C10.4 13.2 10.6 13.4 10.9 13.6V13.9C10.9 14.5 11.3 14.9 11.9 14.9C12.5 14.9 12.9 14.5 12.9 13.9V13.6C13.2 13.4 13.4 13.2 13.6 12.9H16.9C17.5 12.9 17.9 12.5 17.9 11.9C17.9 11.3 17.5 10.9 16.9 10.9Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <!--end:Icon-->
                                                    <!--begin:Info-->
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bolder fs-6">Full Intro Training</span>
                                                        <span class="fs-7 text-muted">Creating a clear text structure
                                                            copywriting</span>
                                                    </span>
                                                    <!--end:Info-->
                                                </span>
                                                <!--end:Label-->
                                                <!--begin:Input-->
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="3" />
                                                </span>
                                                <!--end:Input-->
                                            </label>
                                            <!--end::Option-->
                                        </div>
                                        <!--end:Options-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Select Framework</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify your apps framework"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="fab fa-html5 text-warning fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">HTML5</span>
                                                    <span class="fs-7 text-muted">Base Web Projec</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" checked="checked"
                                                    name="framework" value="1" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="fab fa-react text-success fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">ReactJS</span>
                                                    <span class="fs-7 text-muted">Robust and flexible app
                                                        framework</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="2" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="fab fa-angular text-danger fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Angular</span>
                                                    <span class="fs-7 text-muted">Powerful data mangement</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="3" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <!--begin:Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin:Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="fab fa-vuejs text-primary fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end:Icon-->
                                                <!--begin:Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Vue</span>
                                                    <span class="fs-7 text-muted">Lightweight and responsive
                                                        framework</span>
                                                </span>
                                                <!--end:Info-->
                                            </span>
                                            <!--end:Label-->
                                            <!--begin:Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="framework"
                                                    value="4" />
                                            </span>
                                            <!--end:Input-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="required fs-5 fw-bold mb-2">Database Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            name="dbname" placeholder="" value="master_db" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                            <span class="required">Select Database Engine</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Select your app database engine"></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="fas fa-database text-success fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">MySQL</span>
                                                    <span class="fs-7 text-muted">Basic MySQL database</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    checked="checked" value="1" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer mb-5">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="fab fa-google text-danger fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">Firebase</span>
                                                    <span class="fs-7 text-muted">Google based app data
                                                        management</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    value="2" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                        <!--begin:Option-->
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <!--begin::Label-->
                                            <span class="d-flex align-items-center me-2">
                                                <!--begin::Icon-->
                                                <span class="symbol symbol-50px me-6">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="fab fa-amazon text-warning fs-2x"></i>
                                                    </span>
                                                </span>
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bolder fs-6">DynamoDB</span>
                                                    <span class="fs-7 text-muted">Amazon Fast NoSQL Database</span>
                                                </span>
                                                <!--end::Info-->
                                            </span>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" name="dbengine"
                                                    value="3" />
                                            </span>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                            <span class="required">Name On Card</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Specify a card holder's name"></i>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder=""
                                            name="card_name" value="Max Doe" />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-bold form-label mb-2">Card Number</label>
                                        <!--end::Label-->
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative">
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="Enter card number" name="card_number"
                                                value="4111 1111 1111 1111" />
                                            <!--end::Input-->
                                            <!--begin::Card logos-->
                                            <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                                <img src="../../../media/svg/card-logos/visa.svg" alt=""
                                                    class="h-25px" />
                                                <img src="../../../media/svg/card-logos/mastercard.svg" alt=""
                                                    class="h-25px" />
                                                <img src="../../../media/svg/card-logos/american-express.svg" alt=""
                                                    class="h-25px" />
                                            </div>
                                            <!--end::Card logos-->
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-10">
                                        <!--begin::Col-->
                                        <div class="col-md-8 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold form-label mb-2">Expiration
                                                Date</label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row fv-row">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_month"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Month">
                                                        <option></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <select name="card_expiry_year"
                                                        class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Year">
                                                        <option></option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">CVV</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                    title="Enter a card CVV code"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative">
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-solid"
                                                    minlength="3" maxlength="4" placeholder="CVV" name="card_cvv" />
                                                <!--end::Input-->
                                                <!--begin::CVV icon-->
                                                <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                                    <span class="svg-icon svg-icon-2hx">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path d="M22 7H2V11H22V7Z" fill="black" />
                                                            <path opacity="0.3"
                                                                d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::CVV icon-->
                                            </div>
                                            <!--end::Input wrapper-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Label-->
                                        <div class="me-5">
                                            <label class="fs-6 fw-bold form-label">Save Card for further
                                                billing?</label>
                                            <div class="fs-7 fw-bold text-muted">If you need more info, please check
                                                budget planning</div>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                checked="checked" />
                                            <span class="form-check-label fw-bold text-muted">Save Card</span>
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div data-kt-stepper-element="content">
                                <div class="w-100 text-center">
                                    <!--begin::Heading-->
                                    <h1 class="fw-bolder text-dark mb-3">Release!</h1>
                                    <!--end::Heading-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-bold fs-3">Submit your app to kickstart your project.
                                    </div>
                                    <!--end::Description-->
                                    <!--begin::Illustration-->
                                    <div class="text-center px-4 py-15">
                                        <img src="../../media/illustrations/sketchy-1/9.png" alt=""
                                            class="w-100 mh-300px" />
                                    </div>
                                    <!--end::Illustration-->
                                </div>
                            </div>
                            <!--end::Step 5-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-10">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                        data-kt-stepper-action="previous">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                        <span class="svg-icon svg-icon-3 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1"
                                                    fill="black" />
                                                <path
                                                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-lg btn-primary"
                                        data-kt-stepper-action="submit">
                                        <span class="indicator-label">Submit
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                        transform="rotate(-180 18 13)" fill="black" />
                                                    <path
                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="indicator-progress">Please wait...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-lg btn-primary"
                                        data-kt-stepper-action="next">Continue
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-3 ms-1 me-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="black" />
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->

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
                            id="document-name-draft" value="" style="font-weight: normal" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-draft" id="note-draft"
                            value="" placeholder="Catatan" style="font-weight: normal" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                                <input type="file" class="form-control form-control-solid" name="attach-file-draft-menang"
                                    id="attach-file-draft-menang" style="font-weight: normal" value="" accept=".docx"
                                    placeholder="Name draft" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="document-name-draft"
                                    id="document-name-draft" style="font-weight: normal" value=""
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
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Add Attachment</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                            <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
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
                                <input type="file" style="font-weight: normal" class="form-control form-control-solid"
                                    name="attach-file-review" id="attach-file-review-menang" value="" accept=".docx"
                                    placeholder="Name review" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="document-name-review"
                                    id="document-name-review" value="" style="font-weight: normal"
                                    placeholder="Nama Document" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="note-review"
                                    id="note-review" value="" style="font-weight: normal" placeholder="Catatan" />
                                <!--end::Input-->
                                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                                {{-- begin::Froala Editor --}}
                                <div id="froala-editor-review-menang">
                                    <h1>Attach file with <b>.DOCX</b> format only</h1>
                                </div>
                                {{-- end::Froala Editor --}}
                                {{-- begin::Read File --}}
                                <script>
                                    document.getElementById("attach-file-review-menang").addEventListener("change", async function() {
                                        await readFile(this.files[0], "#froala-editor-review-menang");
                                    });
                                </script>
                                {{-- end::Read File --}}
                        </div>
                        <!--end::Input group-->

                        <button type="submit" id="save-review-tender-menang" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
                        </form>


                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Review Tender Menang-->

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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                                <input type="text" class="form-control form-control-solid" name="document-name-issue"
                                    id="document-name-issue-project" style="font-weight: normal" value=""
                                    placeholder="Nama Document" />
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
                        <h2>Add Attachment</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                            <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
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
                                <input type="file" class="form-control form-control-solid" name="attach-file-risk"
                                    id="attach-file-risk-menang" value="" style="font-weight: normal" accept=".docx"
                                    placeholder="Name risk" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="document-name-risk"
                                    id="document-name-risk" style="font-weight: normal" value=""
                                    placeholder="Nama Document" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span>Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="note-risk" id="note-risk"
                                    value="" placeholder="Catatan" />
                                <!--end::Input-->
                                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                                {{-- begin::Froala Editor --}}
                                <div id="froala-editor-risk-menang">
                                    <h1>Attach file with <b>.DOCX</b> format only</h1>
                                </div>
                                {{-- end::Froala Editor --}}
                                {{-- begin::Read File --}}
                                <script>
                                    document.getElementById("attach-file-risk-menang").addEventListener("change", async function() {
                                        await readFile(this.files[0], "#froala-editor-risk-menang");
                                    });
                                </script>
                                {{-- end::Read File --}}
                        </div>
                        <!--end::Input group-->

                        <button type="submit" id="save-risk-tender-menang" class="btn btn-lg btn-primary"
                            data-bs-dismiss="modal">Save</button>
                        </form>


                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Input Resiko Tender Menang-->

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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
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
                                <input type="file" class="form-control form-control-solid" name="attach-file-question"
                                    id="attach-file-question-menang" value="" accept=".docx" placeholder="Name draft" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="document-name-question"
                                    id="document-name-question-menang" style="font-weight: normal" value=""
                                    placeholder="Nama Document" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" style="font-weight: normal" class="form-control form-control-solid"
                                    name="note-question" id="note-question" value="" placeholder="Catatan" />
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
                            id="note-bulanan" value="" style="font-weight: normal" placeholder="Catatan" />
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

<!--end::Modals-->

<!--begin::Modal - Issue Project-->
<div class="modal fade" id="kt_modal_issue_proyek" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Add Issue Proyek</h2>
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
                    <form action="/issue-project/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Attachment</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                            name="id-contract">
                        <input type="file" class="form-control form-control-solid" name="attach-file-issue"
                            id="attach-file-issue" value="" style="font-weight: normal" accept=".docx"
                            placeholder="Name Proyek" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-issue"
                            id="document-name-issue" style="font-weight: normal" value="" placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-issue" id="note-issue"
                            value="" placeholder="Catatan" style="font-weight: normal" />
                        <!--end::Input-->
                        <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                        {{-- begin::Froala Editor --}}
                        <div id="froala-editor-issue">
                            <h1>Attach file with <b>.DOCX</b> format only</h1>
                        </div>
                        {{-- end::Froala Editor --}}
                        {{-- begin::Read File --}}
                        <script>
                            document.getElementById("attach-file-issue").addEventListener("change", async function() {
                                await readFile(this.files[0], "#froala-editor-issue");
                            });
                        </script>
                        {{-- end::Read File --}}

                        <button type="submit" class="btn btn-lg btn-primary" data-bs-dismiss="modal">Save
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

<!--end::Modal - Issue Project-->

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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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
                        <form action="/review-contract/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Attachment</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                            <input type="file" class="form-control form-control-solid" name="attach-file-review"
                                id="attach-file-review" value="" style="font-weight: normal" accept=".docx"
                                placeholder="Name Proyek" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Nama Dokumen</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="document-name-review"
                                id="document-name-review" style="font-weight: normal" value=""
                                placeholder="Nama Document" />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Catatan</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="note-review"
                                id="note-review" value="" style="font-weight: normal" placeholder="Catatan" />
                            <!--end::Input-->
                            <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                            {{-- begin::Froala Editor --}}
                            <div id="froala-editor-review">
                                <h1>Attach file with <b>.DOCX</b> format only</h1>
                            </div>
                            {{-- end::Froala Editor --}}
                            {{-- begin::Read File --}}
                            <script>
                                document.getElementById("attach-file-review").addEventListener("change", async function() {
                                    await readFile(this.files[0], "#froala-editor-review");
                                });
                            </script>
                            {{-- end::Read File --}}
                    </div>
                    <!--end::Input group-->

                    <button type="submit" id="save-review" class="btn btn-lg btn-primary"
                        data-bs-dismiss="modal">Save</button>

                    </form>

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

                <form action="/input-risk/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Attachment</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" name="id-contract">
                    <input type="file" class="form-control form-control-solid" name="attach-file-risk"
                        id="attach-file-risk" style="font-weight: normal" value="" accept=".docx"
                        placeholder="Name Proyek" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Nama Dokumen</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="document-name-risk"
                        id="document-name-risk" style="font-weight: normal" value="" placeholder="Nama Document" />
                    <!--end::Input-->

                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label mt-3">
                        <span style="font-weight: normal">Catatan</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" name="note-risk" id="note-risk" value=""
                        placeholder="Catatan" style="font-weight: normal" />
                    <!--end::Input-->
                    <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>


                    {{-- begin::Froala Editor --}}
                    <div id="froala-editor-risk">
                        <h1>Attach file with <b>.DOCX</b> format only</h1>
                    </div>
                    {{-- end::Froala Editor --}}
                    {{-- begin::Read File --}}
                    <script>
                        document.getElementById("attach-file-risk").addEventListener("change", async function() {
                            await readFile(this.files[0], "#froala-editor-risk");
                        });
                    </script>
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
                            <span style="font-weight: normal">Nama Dokumen</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="document-name-question"
                            id="document-name-question" style="font-weight: normal" value=""
                            placeholder="Nama Document" />
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span style="font-weight: normal">Catatan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" name="note-question"
                            id="note-question" style="font-weight: normal" value="" placeholder="Catatan" />
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
<div class="modal fade" id="kt_modal_calendar-start" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
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

<!--begin::Modal - Calendar End -->
<div class="modal fade" data-bs-backdrop="static" id="kt_modal_calendar-end" tabindex="-1" aria-hidden="true">
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
                            <button class="btn btn-sm fw-normal btn-primary" style="background: #f3f6f9;color:black;"
                                data-bs-dismiss="modal" id="cancel-date-btn-end">Back</button>

                            <button class="btn btn-sm fw-normal btn-primary" data-bs-dismiss="modal"
                                style="background-color: #e08c16;color: white;" id="set-calendar-end">Apply</button>
                            {{-- <button class="calendar__button calendar__button--grey" data-bs-dismiss="modal"
                                id="cancel-date-btn-end">Back</button>

                            <button class="calendar__button" data-bs-dismiss="modal"
                                style="background-color: #e08c16;color: white;" id="set-calendar-end">Apply</button> --}}
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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
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
    new FroalaEditor('#froala-editor-review-menang', {
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
</script>

@endsection


<!--begin::Aside-->
{{-- @section('aside')
@include('template.aside')
@endsection --}}
<!--end::Aside-->
