@extends('template.main')

@section('title', 'Perubahan Kontrak')
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
                                                            <div class="d-flex align-items-center text-white">Draft</div>
                                                        </a>
                                                    @else
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-not-active" style="outline: 0px; cursor: pointer;"
                                                            stage="1">
                                                            <div class="d-flex align-items-center text-white">Draft</div>
                                                        </a>
                                                    @endif

                                                    @if ($perubahan_kontrak->stage >= 2)
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
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
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
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
                                                        <a href="#" role="link" class="stage-button clicked-stage color-is-default stage-is-done" style="outline: 0px; cursor: pointer;"
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
                                                            <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer;"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-white me-3">Ditolak</span>
                                                                    <i class="bi bi-caret-down-fill text-white"></i>
                                                                </div>
                                                            </a>
                                                        @else
                                                            @if ($perubahan_kontrak->is_dispute)
                                                                <a href="#" role="link" class="stage-button stage-dropdown color-is-danger stage-is-done" style="outline: 0px; cursor: pointer;">
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
                                                            <li><a href="#" class="dropdown-item clicked-stage" stage="5">Disetujui</a></li>
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
                                                                    </label><br>
                                                                    <b>{{$perubahan_kontrak->jenis_perubahan}}</b>
                                                                    {{-- <select name="jenis-perubahan" id="jenis-perubahan" class="form-select form-select-solid" data-control="select2"
                                                                        data-hide-search="true" data-placeholder="Pilih Jenis Perubahan" tabindex="-1" aria-hidden="true">
                                                                        <option value=""></option>
                                                                        <option value="VO" {{ $perubahan_kontrak->jenis_perubahan == "VO" ? "selected" : ""}}>Variation Order (VO)</option>
                                                                        <option value="Klaim" {{ $perubahan_kontrak->jenis_perubahan == "Klaim" ? "selected" : ""}}>Klaim</option>
                                                                        <option value="Anti Klaim" {{ $perubahan_kontrak->jenis_perubahan == "Anti Klaim" ? "selected" : ""}}>Anti Klaim</option>
                                                                    </select> --}}
                                                                </div>

                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Perubahan</span>
                                                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a> --}}
                                                                    </label><br>
                                                                    <b>{{Carbon\Carbon::create($perubahan_kontrak->tanggal_perubahan)->format("d F Y")}}</b>
                                                                    {{-- <input type="date" name="tanggal-perubahan" class="form-control form-control-solid" value="{{Carbon\Carbon::create($perubahan_kontrak->tanggal_perubahan)->format("Y-m-d")}}"> --}}
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Uraian Perubahan</span>
                                                                    </label>
                                                                    <textarea cols="4" name="uraian-perubahan" class="form-control">{!! $perubahan_kontrak->uraian_perubahan !!}</textarea>
                                                                </div>
                                                                
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">No Proposal Klaim</span>
                                                                    </label><br>
                                                                    <b>{{ $perubahan_kontrak->proposal_klaim }}</b>
                                                                    {{-- <input type="text" value="{{ $perubahan_kontrak->proposal_klaim }}" name="proposal-klaim" class="form-control form-control-solid" /> --}}
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Tanggal Pengajuan</span>
                                                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a> --}}
                                                                    </label><br>
                                                                    <b>{{Carbon\Carbon::create($perubahan_kontrak->tanggal_pengajuan)->translatedFormat("d F Y")}}</b>
                                                                    {{-- <input type="date" name="tanggal-pengajuan" value="{{Carbon\Carbon::create($perubahan_kontrak->tanggal_pengajuan)->format("Y-m-d")}}" class="form-control form-control-solid" /> --}}
                                                                </div>
                                                                <div class="col mt-3">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Biaya Pengajuan</span>
                                                                    </label><br>
                                                                    <b>{{ number_format($perubahan_kontrak->biaya_pengajuan, 0, ".", ".") }}</b>
                                                                    {{-- <input type="text" name="biaya-pengajuan" value="{{ number_format($perubahan_kontrak->biaya_pengajuan, 0, ".", ".") }}" class="form-control form-control-solid reformat" /> --}}
                                                                </div>
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Waktu Pengajuan</span>
                                                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a> --}}
                                                                    </label><br>
                                                                    <b>{{Carbon\Carbon::create($perubahan_kontrak->waktu_pengajuan)->translatedFormat("d F Y")}}</b>
                                                                    {{-- <input type="date" name="waktu-pengajuan" value="{{Carbon\Carbon::create($perubahan_kontrak->waktu_pengajuan)->format("Y-m-d")}}" class="form-control form-control-solid" /> --}}
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label class="fs-6 fw-bold form-label">
                                                                        <span style="font-weight: normal">Status</span>
                                                                        {{-- <a class="btn btn-sm" style="background: transparent; width:1rem;height:2.3rem" onclick="showCalendarModal(this)"
                                                                            id="start-date-modal">
                                                                            <i class="bi bi-calendar2-plus-fill d-flex justify-content-center align-items-center" style="color: #008CB4"></i>
                                                                        </a> --}}
                                                                    </label><br>
                                                                    <!--begin::Input-->
                                                                    <select name="status-perubahan-kontrak" id="status-perubahan-kontrak" class="form-select form-select-solid"
                                                                    data-control="select2" data-hide-search="true"
                                                                    data-placeholder="Pilih Status Perubahan Kontrak">
                                                                        <option value=""></option>
                                                                        <option {{$perubahan_kontrak->status == 0 ? "selected" : ""}} value="0">Open</option>
                                                                        <option {{$perubahan_kontrak->status == 1 ? "selected" : ""}} value="1">Closed</option>
                                                                    </select>
                                                                    <!--end::Input-->
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
                            
                            <!--begin::Content Card-->
                            <div class="row">
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
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-400">
                                                    @forelse ($perubahan_kontrak->JenisDokumen as $jd)
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
                                                                                @endphp
                                                                            @break
                                                                        @case("Technical Form")
                                                                                @php
                                                                                    $lio = App\Models\TechnicalForm::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                        @case("Technical Query")
                                                                                @php
                                                                                    $lio = App\Models\TechnicalQuery::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                        @case("Field Design Change")
                                                                                @php
                                                                                    $lio = App\Models\FieldChange::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Notice")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeNotice::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Proposal")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeProposal::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                        @case("Contract Change Order")
                                                                                @php
                                                                                    $lio = App\Models\ContractChangeOrder::where("nomor_dokumen" , "=", $lio)->get()->first();
                                                                                @endphp
                                                                            @break
                                                                    @endswitch
                                                                    {{$lio->nomor_dokumen}}
                                                                </td>
                                                                <td>
                                                                    - <a target="blank" href="{{ asset("words/$lio->id_document"); }}">{{$lio->id_document}}</a> <br>
                                                                </td>
                                                            @endforeach
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
                                                         <th class="min-w-125px">Jaminan</th>
                                                         <th class="min-w-125px">Tanggal Penerbitan</th>
                                                         <th class="min-w-125px">Tanggal Berakhir</th>
                                                         <th class="min-w-125px">Status</th>
                                                     </tr>
                                                     <!--end::Table row-->
                                                 </thead>
                                                 <!--end::Table head-->
                                                 <!--begin::Table body-->
                                                 <tbody class="fw-bold text-gray-400">
                                                    <tbody class="fw-bold text-gray-400">
                                                        @if (!empty($perubahan_kontrak->Jaminan))
                                                        @forelse ($perubahan_kontrak->Jaminan as $jaminan )
                                                        <tr>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{ $jaminan->kategori_jaminan }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($jaminan->tanggal_penerbitan)->format("d F Y")}}</p>
                                                            </td>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($jaminan->tanggal_berakhir)->format("d F Y")}}</p>
                                                            </td>
                                                            <td>
                                                                <p class="badge mb-1 {{ $jaminan->status == "Valid" ? "badge-light-success text-success" : "badge-light-danger text-danger" }}">{{ $jaminan->status }}</p>
                                                            </td>
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

                                            <!--Begin::Klaim Asuransi-->
                                            @if ($perubahan_kontrak->jenis_perubahan == "Klaim Asuransi")
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
                                                            <th class="min-w-125px">Asuransi</th>
                                                            <th class="min-w-125px">Tanggal Penerbitan</th>
                                                            <th class="min-w-125px">Tanggal Berakhir</th>
                                                            <th class="min-w-125px">Status</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-400">
                                                        @if (!empty($perubahan_kontrak->Asuransi))
                                                        @forelse ($perubahan_kontrak->Asuransi as $asuransi )
                                                        <tr>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{ $asuransi->kategori_asuransi }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($asuransi->tanggal_penerbitan)->format("d F Y")}}</p>
                                                            </td>
                                                            <td>
                                                                <p class="text-gray-600 mb-1">{{Carbon\Carbon::create($asuransi->tanggal_berakhir)->format("d F Y")}}</p>
                                                            </td>
                                                            <td>
                                                                <p class="badge mb-1 {{ $asuransi->status == "Valid" ? "badge-light-success text-success" : "badge-light-danger text-danger" }}">{{ $asuransi->status }}</p>
                                                            </td>
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
                                            @endif
                                            <!--End::Klaim Asuransi-->

                                            @if ($perubahan_kontrak->stage == 4 || $perubahan_kontrak->stage == 5 || !$perubahan_kontrak->is_dispute)
                                                
                                                <h3 class="fw-bolder m-0" id="HeadDetail" style="font-size:14px;">
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
                                                            {{-- <th class="min-w-125px">Nama Dokumen</th> --}}
                                                            <th class="min-w-125px">Dibuat Oleh</th>
                                                            <th class="min-w-125px">Dibuat Tanggal</th>
                                                            <th class="min-w-125px">Catatan</th>
                                                            <th class="min-w-125px">File</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody class="fw-bold text-gray-400">
                                                        @if (!empty($perubahan_kontrak->DokumenPendukungs))
                                                            @forelse ($perubahan_kontrak->DokumenPendukungs as $dokumen_pendukung)
                                                                <tr>
                                                                    <!--begin::Name-->
                                                                    {{-- <td>
                                                                        <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->document_name }}
                                                                        </p>
                                                                    </td> --}}
                                                                    <!--end::Name-->
                                                                    <!--begin::Name-->
                                                                    <td>
                                                                        <p class="text-gray-600 mb-1">{{ $dokumen_pendukung->User->name }}
                                                                        </p>
                                                                    </td>
                                                                    <!--end::Name-->
                                                                    <!--begin::Kode-->
                                                                    <td>
                                                                        <p class="text-gray-600 mb-1">
                                                                            {{ date_format(new DateTime($dokumen_pendukung->created_at), 'd-m-Y') }}
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
                                                                        <a target="_blank" href="{{ asset("words/$dokumen_pendukung->id_document"); }}">{{$dokumen_pendukung->id_document}}</a>
                                                                    </td>
                                                                    <!--end::Unit-->
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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Content Card-->

                        </div>
                    </div>
                    </form>
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
                                                data-hide-search="true" onchange="getJenisDokumen(this)" data-placeholder="Pilih Jenis Dokumen" tabindex="-1" aria-hidden="true">
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
                                <div class="status">
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
                                </div>
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

        <!--Begin::Modal - Asuransi-->
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
                                <div class="status">
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
                                </div>
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
        async function getJenisDokumen(e) {
            const val = e.value;
            let html = `<option value=""></option>`;
            const getJenisDokumenRes = await fetch(`/get-jenis-dokumen/${val}`).then(res => res.json());
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


@endsection

{{-- @section('aside')
    @include('template.aside')
@endsection --}}
