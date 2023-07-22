{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Detail Claim Management')
{{-- End::Title --}}

<style>
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
    /* .form-control.form-control-solid {
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
    } */

    #nilai-kontrak-keseluruhan::placeholder {
        color: #D9214E;
        opacity: 1;
        /* Firefox */
    }
</style>

<!--begin::Main-->
@section('content')
    <!--begin::Root-->
    <!--begin::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Page-->
            
            <!--begin::Header-->
            @include('template.header')
            <!--end::Header-->
            
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content"">
                    <!--begin::Toolbar-->
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                @php
                                    // $contract = $contracts->values();
                                @endphp
                                <h1 class="d-flex align-items-center fs-3 my-1">Datail Change - &nbsp; <b>{{ $contracts->project->nama_proyek }}</b>
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center justify-content-end py-1 gap-3">
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-primary"
                                    style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_input_perubahan">
                                    New</a>
                                </div>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-primary"
                                    style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_upload_final">
                                    Upload</a>
                                </div>
                                @if ($claim_all->isNotEmpty())
                                <div class="d-flex">
                                    <a href="#" onclick="exportToExcel(this, '#view_KlaimAll')" class="btn btn-sm btn-primary"
                                    style="background-color:#008CB4;">Export</a>
                                </div>
                                @endif
                                <!--begin::Button-->
                                <div class="d-flex">
                                    <a href="/claim-management" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                        id="customer_new_close" style="background-color:#f1f1f1;">
                                        Close</a>
                                </div>
                                <!--end::Button-->

                            </div>
                            <!--end::Actions-->
                        </div>

                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-fluid">
                            <div class="row">
                                <div class="col-xl-15">
                                    <div class="card card-flush h-lg-100 mt-7" id="kt_contacts_main">
                                        <div class="card-body pt-5 pb-0">
                                            <form action="" class="d-flex flex-row w-auto" method="get">
                                                <!--Begin:: Select Options-->
                                                {{-- <select style="display: none !important" id="column" name="column" onchange="changes(this)"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                                    data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                                    <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>
                
                                                </select> --}}
                                                <!--End:: Select Options-->
                
                                                 <!--begin::Select Options-->
                                                 {{-- <div style="" id="filterBulan" class="d-flex align-items-center position-relative me-2"> --}}
                                                    {{-- <select id="bulan-perubahan" name="bulan-perubahan" onchange="this.form.submit()"
                                                        class="form-select form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                        tabindex="-1" aria-hidden="true">
                                                        <option></option>
                                                        <option selected>{{date("M")}}</option>
                                                    </select> --}}
                                                {{-- </div> --}}
                                                <!--end::Select Options-->
                
                                                <div id="filterStatus" class="d-flex align-items-center position-relative">
                                                    <select name="stage"
                                                        class="form-select form-select-solid select2-hidden-accessible w-auto"
                                                        data-control="select2" data-hide-search="true" data-placeholder="Status"
                                                        tabindex="-1" aria-hidden="true">
                                                        <option></option>
                                                        <option value="1">Draft</option>
                                                        <option value="2">Diajukan</option>
                                                        <option value="3">Revisi</option>
                                                        <option value="4">Negoisasi</option>
                                                        <option value="5">Diterima</option>
                                                        <option value="6">Ditolak</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                                    id="kt_toolbar_primary_button">
                                                    Filter</button>
                                                <!--end:: Filter-->
                
                                                <!--begin:: RESET-->
                                                <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                                    onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                                    
                                                <script>
                                                    function resetFilter() {
                                                        window.location.href = "/claim-management/proyek/{{ $proyek->kode_proyek }}/{{ $contracts->id_contract }}";
                                                    }
                                                </script>
                                                <!--end:: RESET-->
                                            </form>
                                            <!--end:: BUTTON FILTER-->
                                            <!--begin:::Tabs Navigasi-->    
                                            <ul
                                            class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-0 p-0 mt-7">
                                            <!--begin:::Tab item Claim-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary {{ $link == "kt_user_view_claim_VO" ? "active" : "" }}" data-bs-toggle="tab" data-kt-countup-tabs="true"
                                                        href="#kt_user_view_claim_VO" style="font-size:14px;">VO</a>
                                                </li>
                                                <!--end:::Tab item Claim-->
                
                                                <!--begin:::Tab item Claim-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary {{ $link == "kt_user_view_claim" ? "active" : "" }}" data-bs-toggle="tab" data-kt-countup-tabs="true"
                                                        href="#kt_user_view_claim" style="font-size:14px;">Claim</a>
                                                </li>
                                                <!--end:::Tab item Claim-->
                
                                                <!--begin:::Tab item Anti Claim-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary {{ $link == "kt_user_view_overview_anticlaim" ? "active" : "" }}" data-kt-countup-tabs="true"
                                                        data-bs-toggle="tab" href="#kt_user_view_overview_anticlaim"
                                                        style="font-size:14px;">Anti Claim</a>
                                                </li>
                                                <!--end:::Tab item Anti Claim-->
                
                                                <!--begin:::Tab item -->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary {{ $link == "kt_user_view_overview_asuransi" ? "active" : "" }}" data-kt-countup-tabs="true"
                                                        data-bs-toggle="tab" href="#kt_user_view_overview_asuransi"
                                                        style="font-size:14px;">Claim Asuransi</a>
                                                </li>
                                                <!--end:::Tab item -->
                                            </ul>
                                            <!--end:::Tabs Navigasi-->
                                            @php
                                                $uploadFilePerubahan = $contracts->UploadFinal->where('id_contract', '=', $contracts->id_contract)->where('category', '=', "perubahan-kontrak")->first();
                                            @endphp
                                            <!--End:Table: Review-->
                                            @if (!empty($uploadFilePerubahan))
                                            <div class="d-flex justify-content-end">
                                            <p><b>Download File :</b> 
                                            <a target="_blank" href="{{ asset('words/'.$uploadFilePerubahan->id_document) }}" class="text-hover-primary">
                                            {{ $uploadFilePerubahan->nama_document }}
                                            </a></p>
                                            </div>
                                            @endif
                                            
                                            <div class="tab-content mt-5" id="myTabContent">
                                                <!--Begin::Tab Panel VO-->
                                                    <div class="tab-pane fade {{ $link == "kt_user_view_claim_VO" ? "show active" : "" }}" id="kt_user_view_claim_VO" role="tabpanel">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="view_VO">
                                                            <thead>
                                                                <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Tanggal Kejadian Perubahan</th>
                                                                    <th class="min-w-auto">Uraian Perubahan</th>
                                                                    <th class="min-w-auto">No Proposal Klaim</th>
                                                                    <th class="min-w-auto">Tanggal Pengajuan</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Biaya</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Waktu</th>
                                                                    <th class="min-w-auto">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if ($claims_vo->isNotEmpty())
                                                                @forelse ($claims_vo as $vo)
                                                                <tr>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($vo->tanggal_perubahan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contract-management/view/{{$vo->id_contract}}/perubahan-kontrak/{{$vo->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                        {{ $vo->uraian_perubahan }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $vo->proposal_klaim }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($vo->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                     <!--Begin::Dampak Biaya-->
                                                                     <td class="fw-bolder text-center">
                                                                        {{ (int) $vo->biaya_pengajuan != 0 ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ number_format($vo->biaya_pengajuan, 0, ".", ".") }}
                                                                    </td>
                                                                    <!--end::Dampak Biaya-->
                                                                    <!--begin::Dampak Waktu-->
                                                                    <td class="fw-bolder text-center">
                                                                        {{ !empty($vo->waktu_pengajuan) ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($vo->waktu_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Dampak Waktu-->
                                                                    @php
                                                                    $stage = "";
                                                                    $class_name = "";
                                                                    if ($vo->is_dispute) {
                                                                        $stage = "Dispute";
                                                                        $class_name = "badge fs-8 badge-light-danger";
                                                                    } else {
                                                                        switch ($vo->stage) {
                                                                            case 1:
                                                                                $stage = "Draft";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 2:
                                                                                $stage = "Diajukan";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 3:
                                                                                $stage = "Revisi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 4:
                                                                                $stage = "Negoisasi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 5:
                                                                                $stage = "Diterima";
                                                                                $class_name = "badge fs-8 badge-light-success";
                                                                                break;
                                                                            case 6:
                                                                                $stage = "Ditolak";
                                                                                $class_name = "badge fs-8 badge-light-danger";
                                                                                break;
                                                                        }
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        <small class="{{$class_name}}">
                                                                            {{ $stage }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endforelse
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!--End::Tab Pan VO-->
                        
                                                <!--Begin::Tab Panel Klaim-->
                                                    <div class="tab-pane fade {{ $link == "kt_user_view_claim" ? "show active" : "" }}" id="kt_user_view_claim" role="tabpanel">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="view_Klaim">
                                                            <thead>
                                                                <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Tanggal Kejadian Perubahan</th>
                                                                    <th class="min-w-auto">Uraian Perubahan</th>
                                                                    <th class="min-w-auto">No Proposal Klaim</th>
                                                                    <th class="min-w-auto">Tanggal Pengajuan</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Biaya</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Waktu</th>
                                                                    <th class="min-w-auto">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if ($claims_klaim->isNotEmpty())
                                                                @forelse ($claims_klaim as $klaim)
                                                                <tr>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim->tanggal_perubahan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contract-management/view/{{$klaim->id_contract}}/perubahan-kontrak/{{$klaim->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                        {{ $klaim->uraian_perubahan }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $klaim->proposal_klaim }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--Begin::Dampak Biaya-->
                                                                     <td class="fw-bolder text-center">
                                                                        {{ (int) $klaim->biaya_pengajuan != 0 ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ number_format($klaim->biaya_pengajuan, 0, ".", ".") }}
                                                                    </td>
                                                                    <!--end::Dampak Biaya-->
                                                                    <!--begin::Dampak Waktu-->
                                                                    <td class="fw-bolder text-center">
                                                                        {{ !empty($klaim->waktu_pengajuan) ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim->waktu_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Dampak Waktu-->
                                                                    @php
                                                                    $stage = "";
                                                                    $class_name = "";
                                                                    if ($klaim->is_dispute) {
                                                                        $stage = "Dispute";
                                                                        $class_name = "badge fs-8 badge-light-danger";
                                                                    } else {
                                                                        switch ($klaim->stage) {
                                                                            case 1:
                                                                                $stage = "Draft";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 2:
                                                                                $stage = "Diajukan";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 3:
                                                                                $stage = "Revisi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 4:
                                                                                $stage = "Negoisasi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 5:
                                                                                $stage = "Diterima";
                                                                                $class_name = "badge fs-8 badge-light-success";
                                                                                break;
                                                                            case 6:
                                                                                $stage = "Ditolak";
                                                                                $class_name = "badge fs-8 badge-light-danger";
                                                                                break;
                                                                        }
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        <small class="{{$class_name}}">
                                                                            {{ $stage }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endforelse
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!--End::Tab Pan Klaim-->
                        
                                                <!--Begin::Tab Panel Anti Klaim-->
                                                    <div class="tab-pane fade {{ $link == "kt_user_view_overview_anticlaim" ? "show active" : "" }}" id="kt_user_view_overview_anticlaim" role="tabpanel">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="view_AntiKlaim">
                                                            <thead>
                                                                <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Tanggal Kejadian Perubahan</th>
                                                                    <th class="min-w-auto">Uraian Perubahan</th>
                                                                    <th class="min-w-auto">No Proposal Klaim</th>
                                                                    <th class="min-w-auto">Tanggal Pengajuan</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Biaya</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Waktu</th>
                                                                    <th class="min-w-auto">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if ($claims_anti_klaim->isNotEmpty())
                                                                @forelse ($claims_anti_klaim as $anti_klaim)
                                                                <tr>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($anti_klaim->tanggal_perubahan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contract-management/view/{{$anti_klaim->id_contract}}/perubahan-kontrak/{{$anti_klaim->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                        {{ $anti_klaim->uraian_perubahan }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $anti_klaim->proposal_klaim }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($anti_klaim->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--Begin::Dampak Biaya-->
                                                                     <td class="fw-bolder text-center">
                                                                        {{ (int) $anti_klaim->biaya_pengajuan != 0 ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        (-) {{ number_format($anti_klaim->biaya_pengajuan, 0, ".", ".") }}
                                                                    </td>
                                                                    <!--end::Dampak Biaya-->
                                                                    <!--begin::Dampak Waktu-->
                                                                    <td class="fw-bolder text-center">
                                                                        {{ !empty($anti_klaim->waktu_pengajuan) ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($anti_klaim->waktu_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Dampak Waktu-->
                                                                    @php
                                                                    $stage = "";
                                                                    $class_name = "";
                                                                    if ($anti_klaim->is_dispute) {
                                                                        $stage = "Dispute";
                                                                        $class_name = "badge fs-8 badge-light-danger";
                                                                    } else {
                                                                        switch ($anti_klaim->stage) {
                                                                            case 1:
                                                                                $stage = "Draft";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 2:
                                                                                $stage = "Diajukan";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 3:
                                                                                $stage = "Revisi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 4:
                                                                                $stage = "Negoisasi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 5:
                                                                                $stage = "Diterima";
                                                                                $class_name = "badge fs-8 badge-light-success";
                                                                                break;
                                                                            case 6:
                                                                                $stage = "Ditolak";
                                                                                $class_name = "badge fs-8 badge-light-danger";
                                                                                break;
                                                                        }
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        <small class="{{$class_name}}">
                                                                            {{ $stage }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endforelse
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!--End::Tab Pan Anti Klaim-->
                        
                                                <!--Begin::Tab Panel Klaim Asuransi-->
                                                    <div class="tab-pane fade {{ $link == "kt_user_view_overview_asuransi" ? "show active" : "" }}" id="kt_user_view_overview_asuransi" role="tabpanel">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="view_KlaimAsuransi">
                                                            <thead>
                                                                <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Tanggal Kejadian Perubahan</th>
                                                                    <th class="min-w-auto">Uraian Perubahan</th>
                                                                    <th class="min-w-auto">No Proposal Klaim</th>
                                                                    <th class="min-w-auto">Tanggal Pengajuan</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Biaya</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Waktu</th>
                                                                    <th class="min-w-auto">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if ($claims_klaim_asuransi->isNotEmpty())
                                                                @forelse ($claims_klaim_asuransi as $klaim_asuransi)
                                                                <tr>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim_asuransi->tanggal_perubahan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contract-management/view/{{$klaim_asuransi->id_contract}}/perubahan-kontrak/{{$klaim_asuransi->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                        {{ $klaim_asuransi->uraian_perubahan }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $klaim_asuransi->proposal_klaim }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim_asuransi->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--Begin::Dampak Biaya-->
                                                                     <td class="fw-bolder text-center">
                                                                        {{ (int) $klaim_asuransi->biaya_pengajuan != 0 ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ number_format($klaim_asuransi->biaya_pengajuan, 0, ".", ".") }}
                                                                    </td>
                                                                    <!--end::Dampak Biaya-->
                                                                    <!--begin::Dampak Waktu-->
                                                                    <td>
                                                                        {{ !empty($klaim_asuransi->waktu_pengajuan) ? 'Yes' : 'No' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($klaim_asuransi->waktu_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <!--end::Dampak Waktu-->
                                                                    @php
                                                                    $stage = "";
                                                                    $class_name = "";
                                                                    if ($klaim_asuransi->is_dispute) {
                                                                        $stage = "Dispute";
                                                                        $class_name = "badge fs-8 badge-light-danger";
                                                                    } else {
                                                                        switch ($klaim_asuransi->stage) {
                                                                            case 1:
                                                                                $stage = "Draft";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 2:
                                                                                $stage = "Diajukan";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 3:
                                                                                $stage = "Revisi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 4:
                                                                                $stage = "Negoisasi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 5:
                                                                                $stage = "Diterima";
                                                                                $class_name = "badge fs-8 badge-light-success";
                                                                                break;
                                                                            case 6:
                                                                                $stage = "Ditolak";
                                                                                $class_name = "badge fs-8 badge-light-danger";
                                                                                break;
                                                                        }
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        <small class="{{$class_name}}">
                                                                            {{ $stage }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center"">
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!--End::Tab Pan Klaim Asuransi-->
                        
                                                <!--Begin::Tab Panel Klaim Asuransi-->
                                                    <div class="tab-pane fade" id="kt_user_view_overview_all" role="tabpanel">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="view_KlaimAll">
                                                            <thead>
                                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-125px">Jenis Perubahan</th>
                                                                    <th class="min-w-auto">Uraian Perubahan</th>
                                                                    <th class="min-w-auto">No Proposal Klaim</th>
                                                                    <th class="min-w-auto">Tanggal Pengajuan</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Biaya</th>
                                                                    <th class="min-w-125px" colspan="2">Dampak Waktu</th>
                                                                    <th class="min-w-auto">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="fw-bold text-gray-600">
                                                                @if ($claim_all->isNotEmpty())
                                                                @forelse ($claim_all as $claim)
                                                                <tr>
                                                                    <td>
                                                                        {{ $claim->jenis_perubahan }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="/contract-management/view/{{$claim->id_contract}}/perubahan-kontrak/{{$claim->id_perubahan_kontrak}}" id="click-name" class="text-gray-800 text-hover-primary mb-1">
                                                                        {{ $claim->uraian_perubahan }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $claim->proposal_klaim }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($claim->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    <td>
                                                                        {{ (int) $claim->biaya_pengajuan != 0 ? 'Yes' : 'No' }} | {{ number_format($claim->biaya_pengajuan, 0, ".", ".") }}
                                                                    </td>
                                                                    <td>
                                                                        {{ !empty($claim->waktu_pengajuan) ? 'Yes' : 'No' }} | {{ Carbon\Carbon::parse($claim->waktu_pengajuan)->translatedFormat('d F Y') }}
                                                                    </td>
                                                                    @php
                                                                    $stage = "";
                                                                    $class_name = "";
                                                                    if ($claim->is_dispute) {
                                                                        $stage = "Dispute";
                                                                        $class_name = "badge fs-8 badge-light-danger";
                                                                    } else {
                                                                        switch ($claim->stage) {
                                                                            case 1:
                                                                                $stage = "Draft";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 2:
                                                                                $stage = "Diajukan";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 3:
                                                                                $stage = "Revisi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 4:
                                                                                $stage = "Negoisasi";
                                                                                $class_name = "badge fs-8 badge-light-primary";
                                                                                break;
                                                                            case 5:
                                                                                $stage = "Diterima";
                                                                                $class_name = "badge fs-8 badge-light-success";
                                                                                break;
                                                                            case 6:
                                                                                $stage = "Ditolak";
                                                                                $class_name = "badge fs-8 badge-light-danger";
                                                                                break;
                                                                        }
                                                                        }
                                                                    @endphp
                                                                    <td>
                                                                        <small class="{{$class_name}}">
                                                                            {{ $stage }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center"">
                                                                            <h6><b>There is no data</b></h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                                @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center"">
                                                                        <h6><b>There is no data</b></h6>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <!--End::Tab Pan Klaim Asuransi-->
                                            </div>
                                        </div>
                                        
                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            <!--Begin::Modal = Input VO-->
            <div class="modal fade" id="kt_modal_input_perubahan" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-900px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Add Change Description</h2>
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
                            <form action="/perubahan-kontrak/upload" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $contract->id_contract ?? 0 }}" id="id-contract"
                                    name="id-contract">
                                <input type="hidden" class="modal-name" name="modal-name">
                                <input type="hidden" id="kode-proyek" name="kode-proyek" value="{{ $proyek->kode_proyek }}">
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
                                        <label class="text-center fw-bold form-label">
                                            <span style="font-weight: normal">Tanggal Kejadian Perubahan</span>
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
                                            <span style="font-weight: normal">Dampak Biaya</span>
                                        </label>
                                        <input type="text" name="biaya-pengajuan" class="form-control form-control-solid reformat"/>
                                    </div>
                                    <div class="col">
                                        <label class="fs-6 fw-bold form-150pxbel">
                                            <span style="font-weight: 150px">Dampak Waktu</span>
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
            <!--end::Modal - Input VO-->

             <!--begin::Modal - Upload Final Questions-->
             <div class="modal fade" id="kt_modal_upload_final" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-500px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Upload Final | Change Description</h2>
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
                                        <input type="hidden" value="{{ $contracts->id_contract ?? 0 }}" id="id-contract"
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
        <!--end::Content-->

    </div>
    <!--end::Contacts App- Edit Contact-->

@endsection

@section('js-script')
<!--begin::Data Tables-->

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
        }, 100);
    });
</script>
{{-- End :: Hide All Excel Btn --}}

<script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("/datatables/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.html5.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.colVis.min.js") }}"></script>
<script src="{{ asset("/datatables/jszip.min.js") }}"></script>
<script src="{{ asset("/datatables/pdfmake.min.js") }}"></script>
<script src="{{ asset("/datatables/vfs_fonts.js") }}"></script>
<!--end::Data Tables-->
    <!--begin:: Dokumen File Upload Max Size-->
    <script>
        $(document).ready(function() {
            $('#view_VO').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Change Description VO'
                    }
                    ]
            } );
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#view_Klaim').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Change Description Klaim'
                    }
                    ]
            } );
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#view_AntiKlaim').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Change Description Anti Klaim'
                    }
                    ]
            } );
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#view_KlaimAsuransi').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Change Description Klaim Asuransi'
                    }
                    ]
            } );
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#view_KlaimAll').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Change Description'
                    }
                    ]
            } );
        });
    </script>
@endsection
