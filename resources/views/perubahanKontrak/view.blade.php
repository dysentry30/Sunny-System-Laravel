@extends('template.main')

@section('title', 'Change Description')
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
                    {{-- @if (empty($perubahan_kontrak))
                        <form action="/addendum-contract/upload" method="post" enctype="multipart/form-data">
                        @else --}}
                            {{-- <form action="/perubahan-kontrak/upload" method="post" enctype="multipart/form-data"> --}}
                                <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? old('id-perubahan-kontrak') }}" name="id-perubahan-kontrak">
                    {{-- @endif --}}
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Change Description 
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                {{-- <button type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button" style="background-color:#008CB4;">
                                    Save</button> --}}
                                <!--end::Button-->

                                <!--begin::Button-->
                                @if (isset($perubahan_kontrak->periode))
                                    @if ($perubahan_kontrak->is_locked != true)
                                        <button class="btn btn-sm btn-danger" onclick="deleteAction('claim-management/{{ $perubahan_kontrak->id_perubahan_kontrak }}/delete')">Delete</button>
                                        @if ($perubahan_kontrak->stage < 5)
                                            {{-- <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-primary" id="editButton" data-bs-target="#kt_modal_edit_perubahan"
                                                style="margin-left:10px;">
                                                Edit</a>                                             --}}
                                            <button type="submit" class="btn btn-sm btn-primary ms-2" form="edit-form">Save</button>
                                        @else
                                            {{-- <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-primary" id="editButton" data-bs-target="#kt_modal_input_approve_claim"
                                                style="margin-left:10px;">
                                                Edit</a>                                             --}}
                                            
                                        @endif
                                    @endif
                                @else
                                <button class="btn btn-sm btn-danger" onclick="deleteAction('claim-management/{{ $perubahan_kontrak->id_perubahan_kontrak }}/delete')">Delete</button>
                                @if ($perubahan_kontrak->stage < 5)
                                            {{-- <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-primary" id="editButton" data-bs-target="#kt_modal_edit_perubahan"
                                                style="margin-left:10px;">
                                                Edit</a>                                             --}}
                                                <button type="submit" class="btn btn-sm btn-primary ms-2" form="edit-form">Save</button>
                                        @else
                                            {{-- <a href="#" data-bs-toggle="modal" class="btn btn-sm btn-primary" id="editButton" data-bs-target="#kt_modal_input_approve_claim"
                                                style="margin-left:10px;">
                                                Edit</a>                                             --}}
                                            
                                        @endif
                                @endif
                                <a href="/claim-management/proyek/{{ $contract->profit_center }}" class="btn btn-sm btn-primary" id="cloedButton"
                                    style="background-color:#f3f6f9;margin-left:10px;color: black;">
                                    Close</a>
                                {{-- <a href="/claim-management/proyek/{{ $contract->project_id }}/{{ $perubahan_kontrak->id_contract }}" class="btn btn-sm btn-primary" id="cloedButton"
                                    style="background-color:#f3f6f9;margin-left:10px;color: black;">
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
                            <div class="col-xl-15">
                                <div class="card card-flush" id="kt_contacts_main">

                                    <div class="card-body pt-5" style="background-color:#f1f1f1; border:1px solid #e6e6e6;">

                                        <div class="form-group">
                                            <div id="stage-button" class="stage-list">
                                                    {{-- @if ($perubahan_kontrak->stage >= 1)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}"
                                                            stage="1">
                                                            <div class="d-flex align-items-center text-white">Draft</div>
                                                        </a>
                                                    @else
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="1">
                                                            <div class="d-flex align-items-center text-white">Draft</div>
                                                        </a>
                                                    @endif --}}

                                                    @if ($perubahan_kontrak->stage >= 2)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}"
                                                            stage="2">
                                                            <div class="d-flex align-items-center text-white">Diajukan</div>
                                                        </a>
                                                    @else
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="2">
                                                            <div class="d-flex align-items-center text-white">Diajukan</div>
                                                        </a>
                                                    @endif

                                                    @if ($perubahan_kontrak->stage >= 3)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}"
                                                            stage="3">
                                                            <div class="d-flex align-items-center text-white">Revisi</div>
                                                        </a>
                                                    @else
                                                        @if ($perubahan_kontrak->stage == 2)
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                                stage="3">
                                                                <div class="d-flex align-items-center text-white">Revisi</div>
                                                            </a>
                                                        @else
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; pointer-events: none;"
                                                                stage="3">
                                                                <div class="d-flex align-items-center text-white">Revisi</div>
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if ($perubahan_kontrak->stage >= 4)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}"
                                                            stage="4">
                                                            <div class="d-flex align-items-center text-white">Negoisasi</div>
                                                        </a>
                                                    @else
                                                        @if ($perubahan_kontrak->stage == 3)
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="4">
                                                                <div class="d-flex align-items-center text-white">Negoisasi</div>
                                                            </a>
                                                        @else
                                                            <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; pointer-events: none;"
                                                            stage="4">
                                                                <div class="d-flex align-items-center text-white">Negoisasi</div>
                                                            </a>
                                                        @endif
                                                        
                                                    @endif
                                                    {{-- @dd($perubahan_kontrak->stage) --}}
                                                    @if ($perubahan_kontrak->stage > 4)
                                                        @if ($perubahan_kontrak->stage == 6 && !$perubahan_kontrak->is_dispute)
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Ditolak</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @else
                                                            @if ($perubahan_kontrak->is_dispute)
                                                                <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer; {{ auth()->user()->check_administrator ? '' : 'pointer-events: none;' }}">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span class="text-white me-3">Ditolak</span>
                                                                        {{-- <i class="bi bi-caret-down-fill text-white"></i> --}}
                                                                    </div>
                                                                </a>
                                                                <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer;">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <span class="text-white me-3">Dispute</span>
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
                                                        @endif
                                                    @else 
                                                        @if ($perubahan_kontrak->stage == 4)
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

                                                    {{-- @if ($perubahan_kontrak->stage == 5)
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
                                                    @endif --}}
                                                    <ul class="dropdown-menu">
                                                        @if ($perubahan_kontrak->stage == 6)
                                                            <form action=""></form>
                                                            <form action="/stage/perubahan-kontrak/save" method="POST">
                                                                {{-- <li><a href="#" class="dropdown-item clicked-stage" stage="5">Dispute</a></li> --}}
                                                                @csrf
                                                                <input type="hidden" name="id_perubahan_kontrak" value="{{ $perubahan_kontrak->id_perubahan_kontrak }}">
                                                                <input type="submit" class="btn btn-link text-dark fs-6 text-center w-100" name="is-dispute" value="Dispute">
                                                            </form>
                                                        @else
                                                            <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_input_approve_claim">Disetujui</a></li>
                                                            <li><a href="#" class="dropdown-item clicked-stage" stage="6">Ditolak</a></li>
                                                        @endif
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
                                        <form action="/claim-management/update/{{ $perubahan_kontrak->id_perubahan_kontrak }}" method="POST" id="edit-form" onsubmit="nilaiMinusChecked()">
                                            @csrf
                                            <div class="card-body pt-5">
                                                <div class="row g-7 pt-7">
                                                    <div class="row">
                                                        <div class="col mt-3">
                                                            <div class="mb-3">
                                                                <label for="jenis-perubahan" class="form-label fw-bold">Jenis Perubahan</label>
                                                                <input type="text" name="jenis-perubahan" id="jenis-perubahan" class="form-control form-control-solid" value="{{ $perubahan_kontrak->jenis_perubahan }}" disabled>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="jenis-perubahan" class="form-label fw-bold">
                                                                    <span style="font-weight: normal">Tanggal Kejadian Perubahan</span>
                                                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                    </a>
                                                                </label>
                                                                <input type="date" name="tanggal-perubahan" id="tanggal-perubahan" class="form-control form-control-solid" value="{{ $perubahan_kontrak->tanggal_perubahan }}">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="proposal-klaim" class="form-label fw-bold">No Proposal Klaim</label>
                                                                <input type="text" name="proposal-klaim" id="proposal-klaim" class="form-control form-control-solid" value="{{ $perubahan_kontrak->proposal_klaim }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <label for="biaya-pengajuan" class="form-label fw-bold">Uraian Perubahan</label>
                                                            <textarea cols="2" name="uraian-perubahan" class="form-control form-control-solid">{!! $perubahan_kontrak->uraian_perubahan !!}</textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="tanggal-pengajuan" class="form-label fw-bold">
                                                                    <span style="font-weight: normal">Tanggal Pengajuan</span>
                                                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                    </a>
                                                                </label>
                                                                <input type="date" name="tanggal-pengajuan" id="tanggal-pengajuan" class="form-control form-control-solid" value="{{ !empty($perubahan_kontrak->tanggal_pengajuan) ? \Carbon\Carbon::parse($perubahan_kontrak->tanggal_pengajuan)->translatedFormat("Y-m-d") : '' }}">
                                                            </div>
                                                        </div>
    
                                                        <div class="col mt-3">
                                                            <div class="mb-3">
                                                                <label for="biaya-pengajuan" class="form-label fw-bold d-flex flex-row justify-content-between">
                                                                    <span style="font-weight: normal">Nilai Pengajuan (Excld. PPN)</span>
                                                                    <div class="form-check form-switch {{ $perubahan_kontrak->jenis_perubahan == "VO" ? "" : "d-none" }}" id="div-nilai-negatif">
                                                                        <input class="form-check-input" type="checkbox" name="nilai-negatif" role="switch" id="nilai-negatif" {{ $perubahan_kontrak->jenis_perubahan == "VO" && $perubahan_kontrak->nilai_negatif ? "checked" : "" }} {{ $perubahan_kontrak->jenis_perubahan != "VO" ? "disabled" : "" }}>
                                                                        <label class="form-check-label" for="nilai-nilai-negatif">Nilai Negatif</label>
                                                                    </div>
                                                                </label>
                                                                <input type="text" name="biaya-pengajuan" id="biaya-pengajuan" class="form-control form-control-solid reformat" value="{{ number_format((int)$perubahan_kontrak->biaya_pengajuan, 0, ',', '.') }}">
                                                            </div>
                                                        </div>
    
                                                        <div class="col mt-3">
                                                            <div class="mb-3">
                                                                <label for="waktu-pengajuan" class="form-label fw-bold">Dampak Waktu (Hari)</label>
                                                                <input type="number" name="waktu-pengajuan" step="1" min="0" id="waktu-pengajuan" class="form-control form-control-solid reformat" value="{{ $perubahan_kontrak->waktu_pengajuan_new }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($perubahan_kontrak->stage == 5)
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label for="tanggal-disetujui" class="form-label fw-bold">
                                                                    <span style="font-weight: normal">Tanggal Disetujui</span>
                                                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                    </a>
                                                                </label>
                                                                <input type="date" name="tanggal-disetujui" id="tanggal-disetujui" class="form-control form-control-solid" value="{{ $perubahan_kontrak->tanggal_disetujui }}">
                                                            </div>
                                                        </div>
    
                                                        <div class="col mt-3">
                                                            <div class="mb-3">
                                                                <label for="nilai-disetujui" class="form-label fw-bold d-flex flex-row justify-content-between">
                                                                    <span style="font-weight: normal">Nilai Disetujui (Excld. PPN)</span>
                                                                    <div class="form-check form-switch {{ $perubahan_kontrak->jenis_perubahan == "VO" ? "" : "d-none" }}" id="div-nilai-negatif">
                                                                        <input class="form-check-input" type="checkbox" name="nilai-negatif" role="switch" id="nilai-negatif" {{ $perubahan_kontrak->jenis_perubahan == "VO" && $perubahan_kontrak->nilai_negatif ? "checked" : "" }} {{ $perubahan_kontrak->jenis_perubahan != "VO" ? "disabled" : "" }}>
                                                                        <label class="form-check-label" for="nilai-nilai-negatif">Nilai Negatif</label>
                                                                    </div>
                                                                </label>
                                                                <input type="text" name="nilai-disetujui" id="nilai-disetujui" class="form-control form-control-solid reformat" value="{{ number_format((int)$perubahan_kontrak->nilai_disetujui, 0, ',', '.') }}">
                                                            </div>
                                                        </div>
    
                                                        <div class="col mt-3">
                                                            <div class="mb-3">
                                                                <label for="waktu-disetujui" class="form-label fw-bold">Dampak Waktu Disetujui (Hari)</label>
                                                                <input type="number" name="waktu-disetujui" step="1" min="0" id="waktu-disetujui" class="form-control form-control-solid reformat" value="{{ $perubahan_kontrak->waktu_disetujui_new }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                        
                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <label for="biaya-pengajuan" class="form-label fw-bold">Keterangan</label>
                                                            <textarea cols="2" name="keterangan" class="form-control form-control-solid">{!! $perubahan_kontrak->keterangan !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                        
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!--end::Header Contract-->
                            
                            <!--begin::Content Card-->
                            {{-- <div class="row">
                                <div class="col">
                                    <div class="card card-flush h-lg-80 my-5">
                                        <div class="card-body">
                                            <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                List Jenis Dokumen
                                                <a href="#" Id="Plus" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_input_list_jenis_dokumen">+</a>
                                            </h3>
                    
                                            <!--begin:Table: Review-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-125px">Jenis Dokumen</th>
                                                        <th class="min-w-125px">Nomor Dokumen</th>
                                                        <th class="min-w-125px">File</th>
                                                        <th class="min-w-125px">Action</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-400">
                                                    @php
                                                        if(isset($perubahan_kontrak->periode)){
                                                            $jenisDokumen = $perubahan_kontrak->PerubahanKontrak->JenisDokumen;
                                                        }else{
                                                            $jenisDokumen = $perubahan_kontrak->JenisDokumen;
                                                        }
                                                    @endphp
                                                    @forelse ($jenisDokumen as $jd)
                                                        @php
                                                            $list_instruksi_owner = explode(",", $jd->list_instruksi_owner);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $jd->jenis_dokumen}}</td>
                                                            @foreach ($list_instruksi_owner as $lio)
                                                            <td>
                                                                    @switch($jd->jenis_dokumen)
                                                                        @case("Site Instruction")
                                                                                @php
                                                                                    $lio = App\Models\SiteInstruction::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-site-instruction';
                                                                                @endphp
                                                                            @break
                                                                        @case("Technical Form")
                                                                                @php
                                                                                    $lio = App\Models\TechnicalForm::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-technical-form';
                                                                                @endphp
                                                                            @break
                                                                        @case("Technical Query")
                                                                                @php
                                                                                    $lio = App\Models\TechnicalQuery::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-site-query';
                                                                                @endphp
                                                                            @break
                                                                        @case("Field Design Change")
                                                                                @php
                                                                                    $lio = App\Models\FieldChange::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-field-design-change';
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Notice")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeNotice::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-change-notice';
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Proposal")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeProposal::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-change-proposal';
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Order")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeOrder::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                    $path = 'dokumen-change-order';
                                                                                @endphp
                                                                            @break
                                                                    @endswitch
                                                                    {{$lio->nomor_dokumen}}
                                                                </td>
                                                                <td>
                                                                    <a target="blank" href="/contract-management/{{ $path }}/{{ $lio->id_document }}/download">{{ $lio->id_document }}</a> <br>
                                                                </td>
                                                            @endforeach
                                                            <td>
                                                                <div class="d-flex flex-row align-items-center justify-content-center">
                                                                    <button class="btn btn-sm btn-danger" onclick="deleteAction('jenis-dokumen/{{ $jd->id_jenis_dokumen }}/delete', 'delete-dokumen')">Delete</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="fw-bolder text-center">Data Tidak Ditemukan</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                <!--end::Table body-->
                    
                                            </table>
                                            <!--End:Table: Review-->
                                            <br>

                                            @if ($perubahan_kontrak->stage == 4 || $perubahan_kontrak->stage == 5 || !$perubahan_kontrak->is_dispute)
                                                
                                                <h3 class="fw-bolder m-0 required" id="HeadDetail" style="font-size:14px;">
                                                    Dokumen Pendukung Lain
                                                    <a href="#" Id="Plus" data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_input_dokumen_pendukung">+</a>
                                                </h3>
                        
                                                <!--begin:Table: Review-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th class="min-w-125px">Dibuat Oleh</th>
                                                            <th class="min-w-125px">Dibuat Tanggal</th>
                                                            <th class="min-w-125px">Catatan</th>
                                                            <th class="min-w-125px">File</th>
                                                            <th class="min-w-125px">Action</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-400">
                                                        @php
                                                            if(isset($perubahan_kontrak->periode)){
                                                                $dokumenPendukungs = $perubahan_kontrak->PerubahanKontrak->DokumenPendukungs;
                                                            }else{
                                                                $dokumenPendukungs = $perubahan_kontrak->DokumenPendukungs;
                                                            }
                                                        @endphp
                                                        @if (!empty($dokumenPendukungs))
                                                            @forelse ($dokumenPendukungs as $dokumen_pendukung)
                                                                <tr>
                                                                    <!--begin::Name-->
                                                                    <td>
                                                                        <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->User->name }}
                                                                        </p>
                                                                    </td>
                                                                    <!--end::Name-->
                                                                    <!--begin::Kode-->
                                                                    <td>
                                                                        <p class="text-gray-600 mb-1">
                                                                            {{ Carbon\Carbon::createFromTimeString(($dokumen_pendukung->created_at))->translatedFormat("d F Y") }}
                                                                        </p>
                                                                    </td>
                                                                    <!--end::Kode-->
                                                                    <!--begin::Unit-->
                                                                    <td>
                                                                        <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->note }}</p>
                                                                    </td>
                                                                    <!--end::Unit-->
                                                                    <!--begin::Unit-->
                                                                    <td>
                                                                        <a target="_blank" href="{{ asset("contract-managements/dokumen-pendukung-change/$dokumen_pendukung->id_document"); }}">{{$dokumen_pendukung->id_document}}</a>
                                                                    </td>
                                                                    <!--end::Unit-->
                                                                    <!--begin::Unit-->
                                                                    <td>
                                                                        <div class="d-flex flex-row align-items-center justify-content-center">
                                                                            <button class="btn btn-sm btn-danger" onclick="deleteAction('dokumen-pendukung/{{ $dokumen_pendukung->id_dokumen_pendukung }}/delete')">Delete</button>
                                                                        </div>
                                                                    </td>
                                                                    <!--end::Unit-->
                                                                </tr>
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

                                                @if ($perubahan_kontrak->stage > 4)
                                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                                        Dokumen Final
                                                    </h3>
                                                    
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                <th class="min-w-500px">File</th>
                                                                <th class="min-w-auto">Action</th>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="fw-bold text-gray-400">
                                                            @if (!empty($perubahan_kontrak->id_dokumen))
                                                                <tr>
                                                                    <td><a href="{{ asset('words') . '/' . $perubahan_kontrak->id_dokumen }}" class="text-hover-primary" target="_blank">{{ $perubahan_kontrak->dokumen_approve }}</a></td>
                                                                    <td class="text-center"><a href="{{ asset('words') . '/' . $perubahan_kontrak->id_dokumen }}" class="btn btn-sm btn-primary text-white" target="_blank">Download</a></td>
                                                                </tr>                                                                
                                                            @else
                                                                <tr>
                                                                    <td colspan="2">There is no data</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                        <!--begin::Table body-->
                                                    </table>                                                    
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="card card-flush h-lg-80 my-5">
                                <div class="card-body">

                                    <!--Begin :: Dokumen Site Instruction-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Site Instruction
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('site-instruction')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->SiteInstruction as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-site-instruction/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'site-instruction', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>                                            
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Site Instruction-->

                                    <!--Begin :: Dokumen Technical Form-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Technical Form
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('technical-form')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->TechnicalForm as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-technical-form/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'technical-form', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>                                            
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Technical Form-->

                                    <!--Begin :: Dokumen Technical Query-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Technical Query
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('technical-query')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->TechnicalQuery as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-technical-query/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'technical-query', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>                                            
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Technical Query-->

                                    <!--Begin :: Dokumen Field Design Change-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Field Design Change
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('field-design-change')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->FieldChange as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-field-design-change/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'field-design-, '{{ $dokumen->id_document }}'change')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Field Design Change-->

                                    <!--Begin :: Dokumen Contract Change Notice-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Contract Change Notice
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('change-notice')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->ChangeNotice as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-change-notice/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'change-notice', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Contract Change Notice-->

                                    <!--Begin :: Dokumen Contract Change Proposal-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Contract Change Proposal
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('change-proposal')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->ChangeProposal as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-change-proposal/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'change-proposal', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Contract Change Proposal-->

                                    <!--Begin :: Dokumen Contract Change Order-->
                                    <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                        Dokumen Contract Change Order
                                        <a href="#" Id="Plus" data-bs-toggle="modal" onclick="showModalUpload('change-order')">+</a>
                                    </h3>

                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No. Dokumen</th>
                                                <th class="min-w-125px">Tanggal</th>
                                                <th class="min-w-125px">Uraian</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="min-w-125px">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-400">
                                            <!--Begin::Row-->
                                            @forelse ($perubahan_kontrak->ChangeOrder as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->nomor_dokumen }}</td>
                                                    <td class="text-center">{{ !empty($dokumen->tanggal_dokumen) ? \Carbon\Carbon::parse($dokumen->tanggal_dokumen)->translatedFormat("d F Y") : '-' }}</td>
                                                    <td>{{ $dokumen->uraian_dokumen }}</td>
                                                    <td class="text-center">{{ $dokumen->nama_document }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="/contract-management/dokumen-change-order/{{ $dokumen->id_document }}/download" class="btn btn-primary btn-sm text-white">Download</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete(this, 'change-order', '{{ $dokumen->id_document }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No Data</td>
                                                </tr>
                                            @endforelse
                                            <!--End::Row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <br>
                                    <!--End :: Dokumen Contract Change Order-->
                                    
                                    
                                    <!--Begin :: Dokumen Final Change-->
                                    @if ($perubahan_kontrak->stage > 4)
                                        <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
                                            Dokumen Final
                                        </h3>
                                        
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="min-w-500px">File</th>
                                                    <th class="min-w-auto">Action</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-400">
                                                @if (!empty($perubahan_kontrak->id_dokumen))
                                                    <tr>
                                                        <td><a href="{{ asset('words') . '/' . $perubahan_kontrak->id_dokumen }}" class="text-hover-primary" target="_blank">{{ $perubahan_kontrak->dokumen_approve }}</a></td>
                                                        <td class="text-center"><a href="{{ asset('words') . '/' . $perubahan_kontrak->id_dokumen }}" class="btn btn-sm btn-primary text-white" target="_blank">Download</a></td>
                                                    </tr>                                                                
                                                @else
                                                    <tr>
                                                        <td colspan="2">There is no data</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <!--begin::Table body-->
                                        </table>                                                    
                                    @endif
                                    <!--End :: Dokumen Final Change-->
                                </div>
                            </div>
                            <!--end::Content Card-->

                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contacts-->
        </div>

        <!--begin::Modal - List Jenis Dokumen -->
            <div class="modal fade" id="kt_modal_input_list_jenis_dokumen" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-900px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Add Jenis Dokumen</h2>
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
                                <form action="/jenis-dokumen/upload" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id-perubahan-kontrak" value="{{$perubahan_kontrak->id_perubahan_kontrak}}">
                                    <div class="row">
                                        <div class="col-5">
                                            <label class="fs-6 fw-bold form-label">
                                                <span style="font-weight: normal">Jenis Dokumen</span>
                                            </label>
                                            <select name="jenis-dokumen" id="jenis-dokumen" class="form-select form-select-solid" data-control="select2"
                                                data-hide-search="true" onchange="getJenisDokumen(this, '{{ $contract->profit_center }}')" data-placeholder="Pilih Jenis Dokumen" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option  value="Site Instruction">Site Instruction</option>
                                                <option  value="Technical Form">Technical Form</option>
                                                <option  value="Technical Query">Technical Query</option>
                                                <option  value="Field Design Change">Field Design Change</option>
                                                <option  value="Contract Change Notice">Contract Change Notice</option>
                                                <option  value="Contract Change Proposal">Contract Change Proposal</option>
                                                <option  value="Contract Change Order">Contract Change Order</option>
                                            </select>
                                        </div>
                                        <div class="col-1 d-flex flex-col" style="height: 250px; width: 25px !important">
                                            <div class="vr"></div>
                                        </div>
                                        <div class="col-5">
                                            <label class="fs-6 fw-bold form-label">
                                                <span style="font-weight: normal">Nomor Dokumen </span>
                                            </label>
                                            <br>
                                            <div id="instruksi-owner" style="max-height: 250px; overflow: scroll; scroll-behavior: smooth;">
                                                <h5 class="text-center">Pilih Jenis Dokumen!</h5>
                                            </div>
                                            {{-- <select name="instruksi-owner" id="instruksi-owner" class="form-select form-select-solid" data-control="select2"
                                                data-hide-search="true" data-placeholder="Pilih No Surat" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                            </select> --}}
                                        </div>
                                    </div>
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
        <!--end::Modal - List Jenis Dokumen -->

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
                                <input type="hidden" class="modal-name" name="modal-name">
                                <input type="hidden" class="id_contract" name="id_contract" value="{{ $contract->id_contract }}">
                                <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? 0 }}" id="id-perubahan-kontrak"
                                    name="id-perubahan-kontrak">
                                <input type="file" style="font-weight: normal"
                                    class="form-control form-control-solid" name="attach-file"
                                    id="attach-file-dokumen-pendukung" value="" accept=".pdf"
                                    placeholder="" />
                                <!--end::Input-->

                                <!--begin::Label-->
                                {{-- <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Nama Dokumen</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="document-name"
                                    id="document-name-pendukung" value="" style="font-weight: normal"
                                    placeholder="Nama Document" /> --}}
                                <!--end::Input-->

                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Catatan</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea cols="4" class="form-control form-control-solid" name="note"
                                    id="note" value="" style="font-weight: normal"
                                    placeholder="Catatan" ></textarea>
                                <!--end::Input-->
                                <small id="file-error-msg" style="color: rgb(199, 42, 42); display:none"></small>
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

        <!--begin::Modal - Input Approve Claim -->
        <div class="modal fade" id="kt_modal_input_approve_claim" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Input Nilai Disetujui </h2>
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
                    <form action="/perubahan-kontrak/edit" method="POST" enctype="multipart/form-data">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">

                        <!--begin::Input group Website-->
                        <div class="fv-row mb-5">
                            @csrf
                            <!--begin::Input-->
                            <input type="hidden" class="modal-name" name="modal-name">
                            <input type="hidden" class="id_contract" name="id_contract" value="{{ $contract->id_contract }}">
                            <input type="hidden" class="profit-center" name="profit-center" value="{{ $contract->profit_center }}">
                            <input type="hidden" class="stage" name="stage" value="5">
                            <input type="hidden" value="{{ $perubahan_kontrak->id_perubahan_kontrak ?? 0 }}" id="id-perubahan-kontrak"
                                name="id-perubahan-kontrak">
                            <!--end::Input-->
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3 d-flex flex-row justify-content-between gap-3">
                                <span style="font-weight: normal">Nilai Disetujui <small><i>(Excld. PPN)</i></small></span>
                                @if (empty($perubahan_kontrak->biaya_pengajuan) && $perubahan_kontrak->stage < 5)
                                    <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-custom-class="custom-tooltip"
                                        data-bs-title="Tidak dapat mengisi Nilai Pengajuan karena tidak ada di pengajuan"
                                        data-bs-html="true"></i>
                                    <div class="form-check form-switch {{ $perubahan_kontrak->jenis_perubahan == 'VO' ? '' : 'd-none' }}" id="div-nilai-negatif">
                                @endif
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="nilai-negatif" role="switch" id="nilai-negatif" {{ $perubahan_kontrak->nilai_negatif ? "checked" : "" }} {{ !empty($perubahan_kontrak->biaya_pengajuan) ? "" : "readonly" }}>
                                    <label class="form-check-label" for="nilai-negatif">Nilai Negatif</label>
                                </div>
                            </label>
                            <!--end::Label-->
                            @if ($perubahan_kontrak->stage < 5)
                            <!--begin::Input-->
                            <input type="text" name="nilai-disetujui" class="form-control form-control-solid reformat" value="{{ number_format((int)$perubahan_kontrak->nilai_disetujui, 0, ',', '.') }}" {{ !empty($perubahan_kontrak->biaya_pengajuan) ? "" : "readonly" }}/>
                            <!--end::Input-->
                            @else
                            <p class="mb-3 fw-bold">Rp.{{ number_format($perubahan_kontrak->nilai_disetujui, 0, ',', '.') }}</p>
                            @endif
                            
                            <div class="tanggal-disetujui">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Tanggal Disetujui</span>
                                    @if ($perubahan_kontrak->stage < 5)
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>                                        
                                    @endif
                                </label>
                                <!--end::Label-->
                                @if ($perubahan_kontrak->stage < 5)
                                <!--begin::Input-->
                                <input type="date" name="tanggal-disetujui" value="{{ $perubahan_kontrak->tanggal_disetujui ?? null }}" class="form-control form-control-solid"/>
                                <!--end::Input-->
                                @else
                                <p class="mb-3 fw-bold">{{ \Carbon\Carbon::parse($perubahan_kontrak->tanggal_disetujui)->translatedFormat("d F Y") }}</p>
                                @endif
                                
                            </div>
                            
                            <div class="waktu-disetujui">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal">Waktu Disetujui <small><i>(Hari)</i></small></span>
                                    @if (!empty($perubahan_kontrak->waktu_pengajuan_new))
                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a> --}}
                                    @else
                                        <i class="bi-info-circle-fill" class="btn btn-secondary mx-4"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Tidak dapat mengisi dampak waktu karena tidak ada di pengajuan"
                                            data-bs-html="true"></i>
                                    @endif
                                </label>
                                <!--end::Label-->
                                @if ($perubahan_kontrak->stage < 5)
                                <!--begin::Input-->
                                <input type="number" min="0" step="1" name="waktu-disetujui" class="form-control form-control-solid" value="{{ $perubahan_kontrak->waktu_disetujui_new }}"/>
                                {{-- <input type="date" name="waktu-disetujui" value="{{ $perubahan_kontrak->waktu_disetujui ?? null }}" class="form-control form-control-solid" {{ !empty($perubahan_kontrak->waktu_pengajuan) ? "" : "readonly" }}/> --}}
                                <!--end::Input-->
                                @else
                                {{-- <p class="mb-3 fw-bold">{{ !empty($perubahan_kontrak->waktu_disetujui) ? \Carbon\Carbon::parse($perubahan_kontrak->waktu_disetujui)->translatedFormat("d F Y") : "" }}</p> --}}
                                <p class="m-0"><b>{{ $perubahan_kontrak->waktu_disetujui_new }} Hari</b></p>
                                @endif
                            </div>
                            
                            @if ($perubahan_kontrak->stage < 5)
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span style="font-weight: normal" class="required">Upload File </span>
                                </label>
                                <!--end::Label-->
                                
                                <!--begin::Input-->
                                <input type="file" style="font-weight: normal"
                                class="form-control form-control-solid" name="dokumen-approve"
                                id="dokumen-approve-claim" value="" accept=".pdf"
                                placeholder="" />
                                <!--end::Input-->
                                <small><i>Dokumen format wajib PDF</i></small>
                            @endif

                            <!--end::Input group-->
                        </div>
                        
                    </div>
                    <!--end::Modal body-->
                    @if ($perubahan_kontrak->stage < 5)
                    <div class="modal-footer">
                        <button type="submit" id="save-dokumen-approve" class="btn btn-sm btn-primary"
                        data-bs-dismiss="modal">Save</button>
                    </div>                        
                    @endif
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Input Approve Claim -->

        <!--Begin::Modal - Edit Claim-->
        <div class="modal fade" id="kt_modal_edit_perubahan" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Change Description</h2>
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
                        <form action="/claim-management/update/{{ $perubahan_kontrak->id_perubahan_kontrak }}" method="POST" onsubmit="nilaiMinusChecked()"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="modal-name" name="modal-name">
                            {{-- <input type="hidden" id="kode-proyek" name="kode-proyek" value="{{ $proyek->kode_proyek }}"> --}}
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label class="fs-6 fw-bold form-label">
                                        <span style="font-weight: normal">Jenis Perubahan</span>
                                    </label>
                                    <input type="text" name="jenis-perubahan" class="form-control form-control-solid" value="{{ $perubahan_kontrak->jenis_perubahan }}" disabled/>
                                </div>
    
                                <div class="col">
                                    <label class="text-center fw-bold form-label">
                                        <span style="font-weight: normal">Tanggal Kejadian Perubahan</span>
                                        <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a>
                                    </label>
                                    <input type="date" name="tanggal-perubahan" class="form-control form-control-solid" value="{{ !empty($perubahan_kontrak->tanggal_perubahan) ? Carbon\Carbon::parse($perubahan_kontrak->tanggal_perubahan)->translatedFormat('Y-m-d') : '' }}">
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
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label class="fs-6 fw-bold form-label">
                                        <span style="font-weight: normal">Keterangan</span>
                                    </label>
                                    <textarea cols="2" name="keterangan" class="form-control form-control-solid">{!! $perubahan_kontrak->keterangan !!}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label class="fs-6 fw-bold form-label">
                                        <span style="font-weight: normal">No Proposal Klaim</span>
                                    </label>
                                    <input type="text" name="proposal-klaim" class="form-control form-control-solid" value="{{ $perubahan_kontrak->proposal_klaim }}"/>
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
                                    <input type="date" name="tanggal-pengajuan" class="form-control form-control-solid" value="{{ !empty($perubahan_kontrak->tanggal_pengajuan) ? Carbon\Carbon::parse($perubahan_kontrak->tanggal_pengajuan)->translatedFormat('Y-m-d') : '' }}"/>
                                </div>
                                <div class="col mt-3">
                                    <label class="fs-6 fw-bold form-label d-flex flex-row justify-content-between">
                                        <span style="font-weight: normal">Nilai Pengajuan @if ($perubahan_kontrak->jenis_perubahan != "VO")<small><i>(Excld. PPN)</i></small>@endif</span>
                                        <div class="form-check form-switch {{ $perubahan_kontrak->jenis_perubahan == 'VO' ? '' : 'd-none' }}" id="div-nilai-negatif">
                                            <input class="form-check-input" type="checkbox" name="nilai-negatif" role="switch" id="nilai-negatif" {{ $perubahan_kontrak->nilai_negatif ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nilai-negatif">Nilai Negatif</label>
                                        </div>
                                    </label>
                                    <input type="text" name="biaya-pengajuan" id="biaya-pengajuan" class="form-control form-control-solid reformat" value="{{ number_format((int)$perubahan_kontrak->biaya_pengajuan, 0, ',', '.') }}"/>
                                    @if ($perubahan_kontrak->jenis_perubahan == "VO")
                                        <div id="emailHelp" class="form-text"><small><i>(Excld. PPN)</i></small></div>
                                    @endif
                                </div>
                                <div class="col mt-3">
                                    <label class="fs-6 fw-bold form-150pxbel">
                                        <span style="font-weight: 150px">Dampak Waktu <small><i>(Hari)</i></small></span>
                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                        </a> --}}
                                    </label>
                                    {{-- <input type="date" name="waktu-pengajuan" class="form-control form-control-solid" value="{{ !empty($perubahan_kontrak->waktu_pengajuan) ? Carbon\Carbon::parse($perubahan_kontrak->waktu_pengajuan)->translatedFormat('Y-m-d') : '' }}"/> --}}
                                    <input type="number" min="0" step="1" name="waktu-pengajuan" class="form-control form-control-solid mt-2" value="{{ $perubahan_kontrak->waktu_pengajuan_new }}"/>
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
        <!--End::Modal - Edit Claim-->

        <!--Begin::Modal - Upload Dokumen Pendukung-->
        <div class="modal fade" id="kt_modal_upload_file" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-700px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Upload File</h2>
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
                        <form id="upload-file" action="" method="POST" enctype="multipart/form-data" onsubmit="addLoading(this)">
                            @csrf
                            <input type="hidden" name="id-perubahan-kontrak" value="{{ $perubahan_kontrak->id_perubahan_kontrak }}">

                            <div class="mb-3">
                                <label for="nomor-dokumen" class="form-label required">Nomor Dokumen</label>
                                <input type="text" class="form-control" id="nomor-dokumen" name="nomor-dokumen" autofocus>
                            </div>

                            <div class="mb-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3 required">
                                    <span style="font-weight: normal">Tanggal Dokumen</span>
                                    <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)" id="start-date-modal">
                                        <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                    </a>
                                </label>
                                <input type="date" name="tanggal-dokumen" value="" class="form-control"/>
                                <!--end::Label-->
                            </div>

                            <div class="mb-3">
                                <label for="uraian-dokumen" class="form-label required">Uraian</label>
                                <textarea name="uraian-dokumen" id="uraian-dokumen" cols="15" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="upload-dokumen" class="form-label required">Upload Dokumen</label>
                                <input type="file" class="form-control" accept=".pdf" id="upload-dokumen" name="upload-dokumen">
                                <div class="form-text">Upload dokumen dengan format .pdf</div>
                            </div>
                        </form>
                    </div>
                    <!--end::Modal body-->
                    
                    <!--begin::Modal footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary" form="upload-file">Save</button>
                        <button type="button" class="btn btn-sm btn-hover-danger btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--begin::Modal dialog-->
        </div>
        <!--End::Modal - Upload Dokumen Pendukung-->

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
    const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    })
</script>
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
                    Toast.fire({
                        icon: "error",
                        html: setStage.msg,
                    });
                    // document.querySelector(".toast-body").innerText = setStage.msg;
                    // toasterBoots.show()
                }

            })
        });
    </script>

    {{-- Begin :: Get Jenis Dokumen --}}
    <script>
        async function getJenisDokumen(e, id) {
            const val = e.value;
            let html = `<option value=""></option>`;
            // const getJenisDokumenRes = await fetch(`/get-jenis-dokumen/${val}`).then(res => res.json());
            const getJenisDokumenRes = await fetch(`/get-jenis-dokumen/${val}/${id}`).then(res => res.json());
            if(getJenisDokumenRes.length > 0) {
                getJenisDokumenRes.forEach(element => {
                    html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="instruksi-owner[]" value="${element.nomor_dokumen}" id="${element.nomor_dokumen}">
                        <label class="form-check-label" for="${element.nomor_dokumen}">
                            ${element.nomor_dokumen}
                        </label>
                    </div>
                    <br>
                    `
                });
            } else {
                html = `<h5 class="text-center">Data tidak ditemukan!</h5>`;
            }
            document.querySelector("#instruksi-owner").innerHTML = html;
        }
    </script>
    {{-- End :: Get Jenis Dokumen --}}

    <script>
        async function deleteAction(url, kategori = null) {
            Swal.fire({
                title: '',
                text: "Apakah anda yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    LOADING_BODY.block();
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    // formData.append("id", id);
                    // formData.append("id-contract", "{{ $contract->id_contract }}");
                    // formData.append("profit-center", "{{ $contract->profit_center }}");
                    const sendData = await fetch(`{{ url('${url}') }}`, {
                        method: "POST",
                        body: formData
                    }).then(res => res.json());
                    if (sendData.success) {
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'success'}).then(()=>{
                            if (kategori == null) {
                                window.location = "{{ url('claim-management') }}"
                            }else{
                                location.reload();
                            }
                        })
                    } else{
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'error'}).then(()=>{
                            location.reload();
                        })
                    }
                }
    
            })
        }
    </script>

    <script>
        // function nilaiMinusChecked() {
        //     LOADING_BODY.block();

        //     const checkedElt = document.querySelector('#nilai-minus');
        //     const nilaiDampakBiaya = document.querySelector('#biaya-pengajuan');

        //     if (checkedElt.checked) {
        //         nilaiDampakBiaya.value = '-' + nilaiDampakBiaya.value;
        //     }else{
        //         if (nilaiDampakBiaya.value.includes("-")) {
        //             nilaiDampakBiaya.value = nilaiDampakBiaya.value.replace('-', '');
        //         }else{
        //             nilaiDampakBiaya.value = nilaiDampakBiaya.value;
        //         }
        //     }

        //     LOADING_BODY.release();

        //     return true;
        // }
    </script>

    <script>
        function showModalUpload(kategori) {
            const modalId = document.getElementById('kt_modal_upload_file');
            const modal = new bootstrap.Modal(modalId, {
                backdrop : "static"
            });            
            modal.show();

            const formElt = modalId.querySelector('#upload-file');            
            formElt.setAttribute('action', `/claim-management/${kategori}/upload`);            
        }

        function addLoading(elt) {
            LOADING_BODY.block();
            elt.form.submit();
        }

        function confirmDelete(elt, kategori, idDocument) {
            Swal.fire({
                title: '',
                text: "Apakah anda yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    LOADING_BODY.block();
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("kategori", kategori);
                    formData.append("id-document", idDocument);
                    formData.append("profit-center", '{{ $perubahan_kontrak->profit_center }}');
                    const sendData = await fetch(`/claim-management/dokumen-claim/dokumen-${kategori}/delete`, {
                        method: "POST",
                        body: formData
                    }).then(res => res.json());
                    if (sendData.success) {
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'success'}).then(()=>{
                            location.reload();
                        })
                    } else{
                        LOADING_BODY.release();
                        Swal.fire({title: sendData.message, icon: 'error'}).then(()=>{
                            location.reload();
                        })
                    }
                }
    
            })
        }
    </script>
@endsection

{{-- @section('aside')
    @include('template.aside')
@endsection --}}
