@extends('template.main')

@section('title', 'Change Request')
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
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <!--begin::Toolbar-->
                    @if (empty($perubahan_kontrak))
                        <form action="/addendum-contract/upload" method="post" enctype="multipart/form-data">
                        @else
                            <form action="/perubahan-kontrak/update" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? old('id-perubahan-kontrak') }}" name="id-perubahan-kontrak">
                    @endif
                    @csrf
                    {{-- begin::input --}}
                    <input type="hidden" value="{{ $perubahan_kontrak->id_contract ?? 0 }}" id="id-contract" name="id-contract">
                    {{-- end::input --}}
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Perubahan Kontrak
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button" style="background-color:#008CB4;">
                                    Save</button>
                                <!--end::Button-->

                                <!--begin::Button-->
                                <a href="/contract-management/view/{{ $perubahan_kontrak->id_contract }}" class="btn btn-sm btn-primary" id="cloedButton"
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
                            <div class="col-xl-15">
                                <div class="card card-flush" id="kt_contacts_main">

                                    <div class="card-body pt-5" style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                        <div class="form-group">
                                            <div id="stage-button" class="stage-list">
                                                    @if ($perubahan_kontrak->stage >= 1)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
                                                            stage="1">
                                                            <div class="d-flex align-items-center text-white">Diajukan</div>
                                                        </a>
                                                    @else
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="1">
                                                            <div class="d-flex align-items-center text-white">Diajukan</div>
                                                        </a>
                                                    @endif

                                                    @if ($perubahan_kontrak->stage >= 2)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
                                                            stage="2">
                                                            <div class="d-flex align-items-center text-white">Negoisasi</div>
                                                        </a>
                                                    @else
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="2">
                                                            <div class="d-flex align-items-center text-white">Negoisasi</div>
                                                        </a>
                                                    @endif
                                                    {{-- @dd($perubahan_kontrak->stage) --}}
                                                    @if ($perubahan_kontrak->stage > 2)
                                                        @if ($perubahan_kontrak->stage == 4)
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer;"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Ditolak</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Disetujui</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @else 
                                                        @if ($perubahan_kontrak->stage == 2)
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-default stage-is-not-active" style="cursor: pointer;"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Disetujui</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @else 
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-default stage-is-not-active" style="cursor: pointer; pointer-events: none"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Disetujui</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if ($perubahan_kontrak->stage == 5)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
                                                            stage="5">
                                                            <div class="d-flex align-items-center text-white">Amandemen</div>
                                                        </a>
                                                    @else
                                                        @if ($perubahan_kontrak->stage != 4 && $perubahan_kontrak->stage == 3)
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px;"
                                                                stage="5">
                                                                <div class="d-flex align-items-center text-white">Amandemen</div>
                                                            </a>
                                                        @else 
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; pointer-events: none;"
                                                                stage="5">
                                                                <div class="d-flex align-items-center text-white">Amandemen</div>
                                                            </a>
                                                        @endif
                                                    @endif
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" class="dropdown-item clicked-stage" stage="3">Disetujui</a></li>
                                                        <li><a href="#" class="dropdown-item clicked-stage" stage="4">Ditolak</a></li>
                                                    </ul>

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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                {{ Session::forget('error') }}
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                {{ Session::forget('success') }}
                            @endif
                            <!--begin::Contacts App- Edit Contact-->
                            <div class="row g-7">
                                <div class="col-xl-15">
                                    <div class="card card-flush h-lg-80 my-5" id="kt_contacts_main">

                                        <div class="card-body pt-5">
                                            <div class="row g-7">
                                                <div class="col-xl-15">
                                                    <div class="card card-flush h-lg-80 my-5" id="kt_contacts_main">

                                                        <div class="card-body pt-5">
                                                            @csrf
                                                            <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract" name="id-contract">
                                                            <input type="hidden" class="modal-name" name="modal-name">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Jenis Perubahan</span>
                                                                    </label>
                                                                    <select name="jenis-perubahan" id="jenis-perubahan" class="form-select form-select-solid" data-control="select2"
                                                                        data-hide-search="true" data-placeholder="Pilih Jenis Perubahan" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        <option value="VO" {{ $perubahan_kontrak->jenis_perubahan == "VO" ? "selected" : ""}}>Variation Order (VO)</option>
                                                                        <option value="Klaim" {{ $perubahan_kontrak->jenis_perubahan == "Klaim" ? "selected" : ""}}>Klaim</option>
                                                                        <option value="Anti Klaim" {{ $perubahan_kontrak->jenis_perubahan == "Anti Klaim" ? "selected" : ""}}>Anti Klaim</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Perubahan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="tanggal-perubahan" class="form-control form-control-solid" value="{{Carbon\Carbon::create($perubahan_kontrak->tanggal_perubahan)->format("Y-m-d")}}">
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Uraian Perubahan</span>
                                                                    </label>
                                                                    <textarea cols="2" name="uraian-perubahan" class="form-control form-control-solid">{!! $perubahan_kontrak->uraian_perubahan !!}</textarea>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Jenis Dokumen</span>
                                                                    </label>
                                                                    <select name="jenis-dokumen" id="jenis-dokumen" class="form-select form-select-solid" data-control="select2"
                                                                        data-hide-search="true" data-placeholder="Pilih Jenis Dokumen" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Site Instruction" ? "selected" : ""}} value="Site Instruction">Site Instruction</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Technical Form" ? "selected" : ""}} value="Technical Form">Technical Form</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Technical Query" ? "selected" : ""}} value="Technical Query">Technical Query</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Field Design Change" ? "selected" : ""}} value="Field Design Change">Field Design Change</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Notice" ? "selected" : ""}} value="Contract Change Notice">Contract Change Notice</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Proposal" ? "selected" : ""}} value="Contract Change Proposal">Contract Change Proposal</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Order" ? "selected" : ""}} value="Contract Change Order">Contract Change Order</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">No Surat / Instruksi Owner</span>
                                                                    </label>
                                                                    <select name="instruksi-owner" id="instruksi-owner" class="form-select form-select-solid" data-control="select2"
                                                                        data-hide-search="true" data-placeholder="Pilih No Surat" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Site Instruction" ? "selected" : ""}} value="Site Instruction">Site Instruction</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Technical Form" ? "selected" : ""}} value="Technical Form">Technical Form</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Technical Query" ? "selected" : ""}} value="Technical Query">Technical Query</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Field Design Change" ? "selected" : ""}} value="Field Design Change">Field Design Change</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Notice" ? "selected" : ""}} value="Contract Change Notice">Contract Change Notice</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Proposal" ? "selected" : ""}} value="Contract Change Proposal">Contract Change Proposal</option>
                                                                        <option {{$perubahan_kontrak->jenis_dokumen == "Contract Change Order" ? "selected" : ""}} value="Contract Change Order">Contract Change Order</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">No Proposal Klaim</span>
                                                                    </label>
                                                                    <input type="text" value="{{ $perubahan_kontrak->proposal_klaim }}" name="proposal-klaim" class="form-control form-control-solid" />
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Pengajuan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="tanggal-pengajuan" value="{{Carbon\Carbon::create($perubahan_kontrak->tanggal_pengajuan)->format("Y-m-d")}}" class="form-control form-control-solid" />
                                                                </div>
                                                                <div class="col mt-3">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Biaya Pengajuan</span>
                                                                    </label>
                                                                    <input type="text" name="biaya-pengajuan" value="{{ number_format($perubahan_kontrak->biaya_pengajuan, 0, ".", ".") }}" class="form-control form-control-solid reformat" />
                                                                </div>
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Waktu Pengajuan</span>
                                                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a>
                                                                    </label>
                                                                    <input type="date" name="waktu-pengajuan" value="{{Carbon\Carbon::create($perubahan_kontrak->waktu_pengajuan)->format("Y-m-d")}}" class="form-control form-control-solid" />
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
    <!--end::Container-->
    </div>
    <!--end::Post-->

    </div>
    <!--end::Content-->

    </div>
    <!--end::Modal - Calendar -->

@endsection

@section('js-script')
    <script>
        const stages = document.querySelectorAll(".clicked-stage");
        let prevStep = Number("{{ $perubahan_kontrak->stage ?? 1 }}");
        const idPerubahan = "{{ $perubahan_kontrak->id_perubahan_kontrak ?? 0 }}";
        stages.forEach((stage, i) => {
            stage.addEventListener("click", async e => {
                const formData = new FormData()
                const step = Number(stage.getAttribute("stage"));
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id_perubahan_kontrak", idPerubahan);
                formData.append("stage", step);


                const setStage = await fetch("/stage/perubahan-kontrak/save", {
                    method: "POST",
                    header: {
                        "content-type": "application/json",
                    },
                    body: formData,
                }).then(res => res.json());

                if (setStage.status == "success") {
                    Toast.fire({
                        icon: "success",
                        html: "<b>Update Stage berhasil</b><br><small>tunggu 3 detik untuk me-refresh otomatis</small>",
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    toaster.classList.add("text-bg-danger");
                    Toast.fire({
                        icon: "error",
                        html: "Update Stage gagal diperbarui, pastikan anda membuat addendum terlebih dahulu!",
                    });
                    // document.querySelector(".toast-body").innerText = setStage.msg;
                    // toasterBoots.show()
                }

            })
        });
    </script>


@endsection

{{-- @section('aside')
    @include('template.aside')
@endsection --}}
