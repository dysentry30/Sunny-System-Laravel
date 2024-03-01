@extends('template.main')
@section('title', 'Partner Selection')

@section('content')

    <style>
        .timeline-centered {
                position: relative;
                margin-bottom: 30px;
            }

            .timeline-centered:before,
            .timeline-centered:after {
                content: " ";
                display: table;
            }

            .timeline-centered:after {
                clear: both;
            }

            .timeline-centered:before,
            .timeline-centered:after {
                content: " ";
                display: table;
            }

            .timeline-centered:after {
                clear: both;
            }

            .timeline-centered:before {
                content: '';
                position: absolute;
                display: block;
                width: 4px;
                background: #f5f5f6;
                left: 50%;
                top: 20px;
                bottom: 20px;
                margin-left: -4px;
            }

            .timeline-centered .timeline-entry {
                position: relative;
                width: 50%;
                float: right;
                margin-bottom: 70px;
                clear: both;
            }

            .timeline-centered .timeline-entry:before,
            .timeline-centered .timeline-entry:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry:after {
                clear: both;
            }

            .timeline-centered .timeline-entry:before,
            .timeline-centered .timeline-entry:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry:after {
                clear: both;
            }

            .timeline-centered .timeline-entry.begin {
                margin-bottom: 0;
            }

            .timeline-centered .timeline-entry.left-aligned {
                float: left;
            }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner {
                margin-left: 0;
                margin-right: -18px;
            }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-time {
                left: auto;
                right: -100px;
                text-align: left;
            }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-icon {
                float: right;
            }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-content {
                margin-left: 0;
                margin-right: 70px;
            }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-content:after {
                left: auto;
                right: 0;
                margin-left: 0;
                margin-right: -9px;
                -moz-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                -webkit-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            .timeline-centered .timeline-entry .timeline-entry-inner {
                position: relative;
                margin-left: -22px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:before,
            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                clear: both;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:before,
            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                clear: both;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time {
                position: absolute;
                left: -100px;
                text-align: right;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span {
                display: block;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:first-child {
                font-size: 15px;
                font-weight: bold;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:last-child {
                font-size: 12px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon {
                background: #fff;
                color: #737881;
                display: block;
                width: 40px;
                height: 40px;
                -webkit-background-clip: padding-box;
                -moz-background-clip: padding;
                background-clip: padding-box;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
                border-radius: 20px;
                text-align: center;
                -moz-box-shadow: 0 0 0 5px #f5f5f6;
                -webkit-box-shadow: 0 0 0 5px #f5f5f6;
                box-shadow: 0 0 0 5px #f5f5f6;
                line-height: 40px;
                font-size: 15px;
                float: left;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-primary {
                background-color: #303641;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-secondary {
                background-color: #ee4749;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-success {
                background-color: #00a651;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-info {
                background-color: #21a9e1;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-warning {
                background-color: #fad839;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-danger {
                background-color: #cc2424;
                color: #fff;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content {
                position: relative;
                background: #f5f5f6;
                padding: 1.7em;
                margin-left: 70px;
                -webkit-background-clip: padding-box;
                -moz-background-clip: padding;
                background-clip: padding-box;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content:after {
                content: '';
                display: block;
                position: absolute;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 9px 9px 9px 0;
                border-color: transparent #f5f5f6 transparent transparent;
                left: 0;
                top: 10px;
                margin-left: -9px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2,
            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content p {
                color: #737881;
                font-family: "Noto Sans", sans-serif;
                font-size: 12px;
                margin: 0;
                line-height: 1.428571429;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content p+p {
                margin-top: 15px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 {
                font-size: 16px;
                margin-bottom: 10px;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 a {
                color: #303641;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-content h2 span {
                -webkit-opacity: .6;
                -moz-opacity: .6;
                opacity: .6;
                -ms-filter: alpha(opacity=60);
                filter: alpha(opacity=60);
            }
    </style>


    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
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
                    <div class="toolbar" id="kt_toolbar">
                        <!--begin::Container-->
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <!--begin::Page title-->
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">Partner Selection
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Page title-->
                        </div>
                        <!--begin::Container-->
                    </div>
                    <!--begin::Toolbar-->
                    <!--begin::Card "style edited"-->
                    <div class="card mx-6" Id="List-vv" style="position: relative; overflow: hidden;">
                        <!--begin::Card header-->
                        <div class="card-header border-0 ps-6 pt-2 mb-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab Assessment-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_prosess_assessment"
                                                style="font-size:14px;">Assessment</a>
                                        </li>
                                        <!--end:::Tab Assessment-->

                                </div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body px-6 pt-0">
                            <div id="tab-content" class="tab-content">
                                <!--Begin::Proses Approval-->
                                <!--End::Proses Approval-->
                                <!--Begin::Proses Assessment-->
                                <div class="tab-pane fade show active" id="kt_view_prosess_assessment" role="tabpanel">
                                    <!--begin::Table Proyek-->
                                    <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2"
                                        id="assessment-partner">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr>
                                                <th class="min-w-auto">Nama Perusahaan</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Jenis Instansi</th>
                                                <th class="min-w-auto">Status Kelengkapan Dokumen</th>
                                                <th class="min-w-auto">Hasil Assessment Eksternal</th>
                                                <th class="min-w-auto">Risk Kategori</th>
                                                <th class="min-w-auto">Hasil Assessment Internal</th>
                                                <th class="min-w-auto">Risk Kategori Partner Selection</th>
                                                <th class="min-w-auto">Dokumen Kelengkapan Partner</th>
                                                <th class="min-w-auto">Hasil Penentuan Rekomendasi</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            <!--begin::Table row-->
                                            @foreach ($customers as $assessment)
                                                @php
                                                    $partner = $assessment->PartnerJO;
                                                    switch ($partner->keterangan) {
                                                        case 'Very Low Risk':
                                                            $style = 'badge rounded-pill badge-success';
                                                            break;
                                                        case 'Low Risk':
                                                            $style = 'badge rounded-pill badge-light-success text-black';
                                                            break;
                                                        case 'Average Risk':
                                                            $style = 'badge rounded-pill badge-warning';
                                                            break;
                                                        case 'High Risk':
                                                            $style = 'badge rounded-pill badge-light-danger text-black';
                                                            break;
                                                        case 'Very High Risk':
                                                            $style = 'badge rounded-pill badge-danger';
                                                            break;

                                                        default:
                                                            $style = 'badge rounded-pill badge-danger';
                                                            break;
                                                    }

                                                    $nilaiRisk = $partner->PartnerSelection?->where('kode_proyek', $partner->kode_proyek)->sum('nilai');
                                                    if (empty($nilaiRisk)) {
                                                        $kategoriRiskPartner = null;
                                                    } else {
                                                        $kategoriRiskPartner = $kriteriaPenilaian
                                                            ?->filter(function ($item) use ($nilaiRisk) {
                                                                return (float) $item->dari_nilai <= (int) $nilaiRisk && (float) $item->sampai_nilai >= (int) $nilaiRisk;
                                                            })
                                                            ->first()?->nama;
                                                    }
                                                    if (!empty($kategoriRiskPartner)) {
                                                        switch ($kategoriRiskPartner) {
                                                            case 'Risiko Rendah':
                                                                $style_2 = 'badge rounded-pill badge-success';
                                                                break;
                                                            case 'Risiko Moderat':
                                                                $style_2 = 'badge rounded-pill badge-warning';
                                                                break;
                                                            case 'Risiko Tinggi':
                                                                $style_2 = 'badge rounded-pill badge-light-danger text-black';
                                                                break;
                                                            case 'Risiko Ekstrem':
                                                                $style_2 = 'badge rounded-pill badge-danger';
                                                                break;

                                                            default:
                                                                $style_2 = 'badge rounded-pill badge-danger';
                                                                break;
                                                        }
                                                    } else {
                                                        $style_2 = 'badge rounded-pill badge-danger';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="">
                                                        {{ $partner->Company->name ?? $partner->company_jo }}</td>
                                                    <td class="text-start"> {{ $partner->Proyek->nama_proyek ?? '-' }}</td>
                                                    <td class="text-center"> {{ $partner->Company->jenis_instansi ?? '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <p
                                                            class="m-0 badge rounded-pill badge-sm {{ $partner->DokumenKelengkapanPartnerKSO->count() < 4 ? 'text-bg-danger' : 'text-bg-success' }} }}">
                                                            {{ $partner->DokumenKelengkapanPartnerKSO->count() < 4 ? 'Belum Lengkap' : 'Sudah Lengkap' }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="m-0 {{ empty($partner->score_pefindo_jo) ? "badge rounded-pill badge-danger" : "" }}">{{ $partner->score_pefindo_jo ?? "*Belum ditentukan" }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="{{ $style }} m-0">{{ $partner->keterangan ?? "*Belum ditentukan" }}</p>
                                                    </td>
                                                    <td class="text-center"> 
                                                        <p class="m-0 {{ $nilaiRisk != 0 ? '' : $style_2 }}">{{ $nilaiRisk != 0 ? (float)$nilaiRisk : '*Belum ditentukan' }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="{{ $style_2 }} m-0">
                                                            {{ $kategoriRiskPartner ?? '*Belum ditentukan' }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#"
                                                            data-bs-target="#kt_porsi_upload_dokumen_{{ $assessment->id }}"
                                                            data-bs-toggle="modal"
                                                            class="btn btn-sm btn-primary py-3 text-white">
                                                            Lihat Dokumen
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="m-0 {{ !is_null($assessment->hasil_rekomendasi_final) && $assessment->hasil_rekomendasi_final != "Tidak Disetujui" ? "badge rounded-pill badge-primary" : "badge rounded-pill badge-danger" }}">{{ $assessment->hasil_rekomendasi_final ?? "*Belum ditentukan" }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        @canany(['admin-crm','approver-crm', 'risk-crm'])
                                                            @if (!empty($matriks_user) && $matriks_user->where('divisi_id', $assessment->divisi_id)->where('departemen_code', $assessment->departemen_id)->where('kategori', 'Rekomendasi')->first() && $assessment->is_penyusun_approved)
                                                                @if (is_null($assessment->is_rekomendasi_approved))
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    data-bs-target="#rekomendasi_{{ $assessment->id }}"
                                                                    data-bs-toggle="modal">Rekomendasi</button>                                                                
                                                                @endif
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $assessment->divisi_id)->where('departemen_code', $assessment->departemen_id)->where('kategori', 'Penyusun')->first() && $assessment->is_pengajuan_approved)
                                                                @if (empty($partner->PartnerSelection) || $partner->PartnerSelection->isEmpty())
                                                                    @if ($partner->DokumenKelengkapanPartnerKSO->count() < 4)
                                                                        <button type="button" data-bs-toggle="tooltip"
                                                                            data-bs-html="true"
                                                                            data-bs-title="<b>Belum dapat melakukan assessment,</b><br> dokumen belum lengkap"
                                                                            class="btn btn-sm btn-secondary py-3">
                                                                            Isi Assessment
                                                                        </button>
                                                                    @else
                                                                        <a href="#"
                                                                            data-bs-target="#kt_modal_create_assessment_{{ $assessment->id }}"
                                                                            data-bs-toggle="modal"
                                                                            class="btn btn-sm btn-primary py-3 text-white">
                                                                            Isi Assessment
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <button type="button" class="btn btn-sm btn-primary"
                                                                        data-bs-target="#penyusun_{{ $assessment->id }}"
                                                                        data-bs-toggle="modal">{{ is_null($assessment->is_penyusun_approved) ? "Submit" : "Lihat Detail" }}</button>
                                                                @endif                                                            
                                                            @elseif (!empty($matriks_user) && $matriks_user->where('divisi_id', $assessment->divisi_id)->where('departemen_code', $assessment->departemen_id)->where('kategori', 'Pengajuan')->first())
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    data-bs-target="#pengajuan_{{ $assessment->id }}"
                                                                    data-bs-toggle="modal">{{ is_null($assessment->is_pengajuan_approved) ? "Ajukan" : "Lihat Detail" }}</button>
                                                            @endif
                                                        @endcanany
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!--end::Table row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table Proyek-->
                                </div>
                                <!--End::Proses Assessment-->
                            </div>
                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--end::Card "style edited"-->
                </div>
                <!--begin::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--begin::Page-->
    </div>
    <!--begin::Root-->

    <!--begin::Modal Isi Assessment Partner Selection-->
    @foreach ($customers as $assessment)
    @php
        $partner = $assessment->PartnerJO;
    @endphp
        <form action="/assessment-partner-selection/{{ $assessment->id }}/save" method="POST"
            id="form-kriteria-{{ $assessment->id }}" enctype="multipart/form-data"
            onsubmit="return validateFileSize(this)">
            @csrf
            <div class="modal fade" id="kt_modal_create_assessment_{{ $assessment->id }}" tabindex="-1"
                aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Form Legalitas Penilaian Partner</h2>
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
                            <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $assessment->id }}">
                            <div class="row fv-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">Kategori</th>
                                            <th class="min-w-250px">Kriteria 1</th>
                                            <th class="min-w-250px">Kriteria 2</th>
                                            <th class="min-w-250px">Kriteria 3</th>
                                            <th class="min-w-250px">Kriteria 4</th>
                                            <th class="min-w-400px">Keterangan</th>
                                            <th class="min-w-300px">Upload Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                            $index = 0;
                                        @endphp
                                        @foreach ($legalitasJasa as $key => $item)
                                            <tr>
                                                <td>{{ $item->kategori }}</td>
                                                <td class="bg-secondary"></td>
                                                <td class="bg-secondary"></td>
                                                <td class="{{ is_null($item->item) ? 'bg-secondary' : '' }}">
                                                    @if (!is_null($item->item))
                                                        <div class="form-check" id="legalitas">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_legalitas_{{ $key + 1 }}"
                                                                id="is_legalitas_{{ $key }}_1" value="1">
                                                            <label for="is_legalitas_{{ $key }}_1"
                                                                class="form-check-label">
                                                                {!! nl2br($item->item) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="{{ is_null($item->item_2) ? 'bg-secondary' : '' }}">
                                                    @if (!is_null($item->item_2))
                                                        <div class="form-check" id="legalitas">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_legalitas_{{ $key + 1 }}"
                                                                id="is_legalitas_{{ $key }}_2" value="2">
                                                            <label for="is_legalitas_{{ $key }}_2"
                                                                class="form-check-label">
                                                                {!! nl2br($item->item_2) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <textarea name="is_legalitas_keterangan[]" form="form-kriteria-{{ $assessment->id }}" id="" cols="60"
                                                        rows="10"></textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_legalitas_{{ $key }}[]"
                                                        form="form-kriteria-{{ $assessment->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $assessment->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $assessment->id }}-{{ $key + 1 }}">Total
                                                        ukuran file max 20MB. Periksa kembali!</small>
                                                </td>
                                                <td class="d-none">
                                                    <input type="hidden" name="index[]" value="{{ $key + 1 }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" name="id_partner" value="{{ $partner->id }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                data-bs-toggle="modal" data-bs-target="#kt_user_modal2_kriteria_{{ $assessment->id }}"
                                id="new_save" style="background-color:#008CB4">Next</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <div class="modal fade" id="kt_user_modal2_kriteria_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Form Penilaian Partner</h2>
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
                            <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $assessment->id }}">
                            <div class="row fv-row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">Kategori</th>
                                            <th class="min-w-50px">Item</th>
                                            <th class="min-w-auto">Bobot</th>
                                            <th class="min-w-auto">Kriteria 1</th>
                                            <th class="min-w-auto">Kriteria 2</th>
                                            <th class="min-w-auto">Kriteria 3</th>
                                            <th class="min-w-auto">Kriteria 4</th>
                                            <th class="min-w-auto">Score</th>
                                            <th class="min-w-auto">Keterangan</th>
                                            <th class="min-w-auto">Upload Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                        @endphp
                                        @foreach ($kriteriaPengguna as $key => $item)
                                            <tr>
                                                <td>{{ $item->kategori }}</td>
                                                <td>{{ $item->item }}</td>
                                                <td class="text-center">
                                                    <p>{{ $item->bobot }}</p>
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_1))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_1"
                                                                onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 1 }}', '{{ $key }}')"
                                                                value="1">
                                                            <label for="is_kriteria_{{ $key }}_1"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_1) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_2))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_2"
                                                                onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 2 }}', '{{ $key }}')"
                                                                value="2">
                                                            <label for="is_kriteria_{{ $key }}_2"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_2) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_3))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_3"
                                                                onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 3 }}', '{{ $key }}')"
                                                                value="3">
                                                            <label for="is_kriteria_{{ $key }}_3"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_3) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!is_null($item->kriteria_4))
                                                        <div class="form-check" id="kriteria">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_kriteria_{{ $key + 1 }}"
                                                                id="is_kriteria_{{ $key }}_4"
                                                                onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 4 }}', '{{ $key }}')"
                                                                value="4">
                                                            <label for="is_kriteria_{{ $key }}_4"
                                                                class="form-check-label">
                                                                {!! nl2br($item->kriteria_4) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" name="nilai[]"
                                                        class="form-control form-control-solid"
                                                        form="form-kriteria-{{ $assessment->id }}"
                                                        id="nilai_{{ $key }}" readonly>
                                                </td>
                                                <td>
                                                    <textarea name="keterangan[]" form="form-kriteria-{{ $assessment->id }}" id="" cols="30"
                                                        rows="10"></textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_penilaian_{{ $key + 1 }}[]"
                                                        form="form-kriteria-{{ $assessment->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $assessment->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $assessment->id }}-{{ $key + 1 }}">Total
                                                        ukuran file max 20MB. Periksa kembali!</small>
                                                </td>
                                                <td class="d-none">
                                                    <input type="hidden" name="index[]" value="{{ $key + 1 }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" name="kode_proyek" value="{{ $partner->kode_proyek }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#kt_user_view_kriteria_{{ $assessment->id }}" id="new_save">
                                Back</button>
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                form="form-kriteria-{{ $assessment->id }}" id="save-{{ $assessment->id }}-new"
                                style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::Modal Isi Assessment Partner Selection-->


    <!--begin::Modal Edit Assessment Partner Selection-->
    @php
        $index = 0;
    @endphp
    @foreach ($customers as $assessment)
    @php
        $partner = $assessment->PartnerJO;
    @endphp
        @if (!empty($partner->PartnerSelection) && $partner->PartnerSelection->isNotEmpty())
            <form action="/assessment-partner-selection/{{ $partner->id }}/edit" method="POST"
                id="form-kriteria-edit-{{ $assessment->id }}" enctype="multipart/form-data"
                onsubmit="return validateFileSize(this)">
                @csrf
                <div class="modal fade" id="kt_modal_edit_assessment_{{ $assessment->id }}" tabindex="-1"
                    aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Form Legalitas Penilaian Partner</h2>
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
                                <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $assessment->id }}">
                                <div class="row fv-row">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="min-w-auto">Kategori</th>
                                                <th class="min-w-250px">Kriteria 1</th>
                                                <th class="min-w-250px">Kriteria 2</th>
                                                <th class="min-w-250px">Kriteria 3</th>
                                                <th class="min-w-250px">Kriteria 4</th>
                                                <th class="min-w-400px">Keterangan</th>
                                                <th class="min-w-300px">Upload Dokumen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                                $partnerSelected = $partnerDetail
                                                    ->where('partner_id', $partner->id)
                                                    ->where('kode_proyek', $partner->kode_proyek)
                                                    ->sortBy('id')
                                                    ->values();
                                            @endphp
                                            @foreach ($legalitasJasa as $key => $item)
                                                <tr>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td class="bg-secondary"></td>
                                                    <td class="bg-secondary"></td>
                                                    <td class="{{ is_null($item->item) ? 'bg-secondary' : '' }}">
                                                        @if (!is_null($item->item))
                                                            <div class="form-check" id="legalitas">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_legalitas_{{ $key + 1 }}"
                                                                    id="is_legalitas_{{ $key }}_1"
                                                                    value="1"
                                                                    {{ $partnerSelected[$key]->kriteria == 1 ? 'checked' : '' }}>
                                                                <label for="is_legalitas_{{ $key }}_1"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->item) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="{{ is_null($item->item_2) ? 'bg-secondary' : '' }}">
                                                        @if (!is_null($item->item_2))
                                                            <div class="form-check" id="legalitas">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_legalitas_{{ $key + 1 }}"
                                                                    id="is_legalitas_{{ $key }}_2"
                                                                    value="2"
                                                                    {{ $partnerSelected[$key]->kriteria == 2 ? 'checked' : '' }}>
                                                                <label for="is_legalitas_{{ $key }}_2"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->item_2) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <textarea name="is_legalitas_keterangan[]" form="form-kriteria-edit-{{ $assessment->id }}" id=""
                                                            cols="60" rows="10">{!! nl2br($partnerSelected[$key]->keterangan) !!}</textarea>
                                                    </td>
                                                    <td>
                                                        <input type="file"
                                                            name="dokumen_legalitas_{{ $key }}[]"
                                                            form="form-kriteria-edit-{{ $assessment->id }}"
                                                            id="dokumen_kriteria" multiple accept=".pdf"
                                                            onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $assessment->id }}-new')"
                                                            class="form-control form-control-sm form-control-solid">
                                                        <small class="text-danger d-none"
                                                            id="alert-file-{{ $assessment->id }}-{{ $key + 1 }}">Total
                                                            ukuran file max 20MB. Periksa kembali!</small>
                                                        <table class="mt-2" id="file-legalitas">
                                                            <thead>
                                                                <tr>
                                                                    <th class="min-w-250px">Dokumen</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $id = $partnerSelected[$key]->id;
                                                                    $files = json_decode($partnerSelected[$key]->id_document);
                                                                @endphp
                                                                @if (!empty($files))
                                                                    @foreach ($files as $file_index => $file)
                                                                        <tr>
                                                                            <td>
                                                                                <small>
                                                                                    <a target="_blank"
                                                                                        href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                        class="text-hover-primary">{{ $file }}</a>
                                                                                </small>
                                                                            </td>
                                                                            <form action=""></form>
                                                                            <form
                                                                                action="/assessment-partner-selection/delete-file"
                                                                                onsubmit="return confirmDeleteFile(this, '{{ $file }}');"
                                                                                name="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                id="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                    form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                    name="id" id="id"
                                                                                    value="{{ $id }}">
                                                                                <input type="hidden"
                                                                                    form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                    name="file-name" id="file-name"
                                                                                    value="{{ $file }}">
                                                                                <td class="text-center">
                                                                                    <button type="submit"
                                                                                        form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                        class="btn btn-sm btn-outline-danger text-hover-white">
                                                                                        <i
                                                                                            class="bi bi-trash3-fill text-danger"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </form>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="hidden" name="index[]"
                                                            value="{{ $key + 1 }}">
                                                    </td>
                                                    <input type="hidden" name="id_detail[]"
                                                        value="{{ $partnerSelected->isNotEmpty() ? $partnerSelected[$key]->id : '' }}">
                                                </tr>
                                                @php
                                                    $index++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="id_partner" value="{{ $partner->id }}">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kt_user_modal2_edit_kriteria_{{ $assessment->id }}" id="new_save"
                                    style="background-color:#008CB4">Next</button>

                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <div class="modal fade" id="kt_user_modal2_edit_kriteria_{{ $assessment->id }}" tabindex="-1"
                    aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Form Penilaian Partner</h2>
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
                                <input type="hidden" name="modal"
                                    value="#kt_user_view_kriteria_{{ $assessment->id }}">
                                <div class="row fv-row">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="min-w-auto">Kategori</th>
                                                <th class="min-w-50px">Item</th>
                                                <th class="min-w-auto">Bobot</th>
                                                <th class="min-w-auto">Kriteria 1</th>
                                                <th class="min-w-auto">Kriteria 2</th>
                                                <th class="min-w-auto">Kriteria 3</th>
                                                <th class="min-w-auto">Kriteria 4</th>
                                                <th class="min-w-auto">Score</th>
                                                <th class="min-w-auto">Keterangan</th>
                                                <th class="min-w-auto">Upload Dokumen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                                $indexEdit = $legalitasJasa->count();
                                            @endphp
                                            @foreach ($kriteriaPengguna as $key => $item)
                                                <tr>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td>{{ $item->item }}</td>
                                                    <td class="text-center">
                                                        <p>{{ $item->bobot }}</p>
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_1))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_1"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 1 }}', '{{ $key }}')"
                                                                    value="1"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 1 ? 'checked' : '' }}>
                                                                <label for="is_kriteria_{{ $key }}_1"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_1) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_2))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_2"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 2 }}', '{{ $key }}')"
                                                                    value="2"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 2 ? 'checked' : '' }}>
                                                                <label for="is_kriteria_{{ $key }}_2"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_2) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_3))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_3"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 3 }}', '{{ $key }}')"
                                                                    value="3"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 3 ? 'checked' : '' }}>
                                                                <label for="is_kriteria_{{ $key }}_3"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_3) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_4))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_4"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 4 }}', '{{ $key }}')"
                                                                    value="4"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 4 ? 'checked' : '' }}>
                                                                <label for="is_kriteria_{{ $key }}_4"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_4) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="number" name="nilai[]"
                                                            class="form-control form-control-solid"
                                                            form="form-kriteria-edit-{{ $assessment->id }}"
                                                            value="{{ $partnerSelected[$indexEdit]->nilai ?? 0 }}"
                                                            id="nilai_{{ $key }}" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea name="keterangan[]" form="form-kriteria-edit-{{ $assessment->id }}" id="" cols="30"
                                                            rows="10">{!! nl2br($partnerSelected[$indexEdit]->keterangan) !!}</textarea>
                                                    </td>
                                                    <td>
                                                        <input type="file"
                                                            name="dokumen_penilaian_{{ $key + 1 }}[]"
                                                            form="form-kriteria-edit-{{ $assessment->id }}"
                                                            id="dokumen_kriteria" multiple accept=".pdf"
                                                            onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $assessment->id }}-new')"
                                                            class="form-control form-control-sm form-control-solid">
                                                        <small class="text-danger d-none"
                                                            id="alert-file-{{ $assessment->id }}-{{ $key + 1 }}">Total
                                                            ukuran file max 20MB. Periksa kembali!</small>
                                                        <table class="mt-2" id="file-penilaian">
                                                            <thead>
                                                                <tr>
                                                                    <th class="min-w-250px">Dokumen</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $id = $partnerSelected[$indexEdit]->id;
                                                                    $files = json_decode($partnerSelected[$indexEdit]->id_document);
                                                                @endphp
                                                                @if (!empty($files))
                                                                    @foreach ($files as $file_index => $file)
                                                                        <tr>
                                                                            <td>
                                                                                <small>
                                                                                    <a target="_blank"
                                                                                        href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                        class="text-hover-primary">{{ $file }}</a>
                                                                                </small>
                                                                            </td>
                                                                            <form action=""></form>
                                                                            <form
                                                                                action="/assessment-partner-selection/delete-file"
                                                                                onsubmit="return confirmDeleteFile(this, '{{ $file }}');"
                                                                                name="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                id="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                    form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                    name="id" id="id"
                                                                                    value="{{ $id }}">
                                                                                <input type="hidden"
                                                                                    form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                    name="file-name" id="file-name"
                                                                                    value="{{ $file }}">
                                                                                <td class="text-center">
                                                                                    <button type="submit"
                                                                                        form="delete-file-{{ $id }}-{{ $file_index + 1 }}"
                                                                                        class="btn btn-sm btn-outline-danger text-hover-white">
                                                                                        <i
                                                                                            class="bi bi-trash3-fill text-danger"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </form>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="hidden" name="index[]"
                                                            value="{{ $key + 1 }}">
                                                    </td>
                                                    <input type="hidden" name="id_detail[]"
                                                        value="{{ $partnerSelected->isNotEmpty() ? $partnerSelected[$indexEdit]->id : '' }}">
                                                </tr>
                                                @php
                                                    $indexEdit++;
                                                    $index++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="kode_proyek" value="{{ $partner->kode_proyek }}">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_edit_assessment_{{ $assessment->id }}" id="new_save">
                                    Back</button>
                                <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                    form="form-kriteria-edit-{{ $assessment->id }}" id="save-{{ $assessment->id }}-new"
                                    style="background-color:#008CB4">Save</button>

                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </form>

            <form action="">
                <div class="modal fade" id="kt_modal_lihat_assessment_{{ $assessment->id }}" tabindex="-1"
                    aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Form Legalitas Penilaian Partner</h2>
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
                                <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $partner->id }}">
                                <div class="row fv-row">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="min-w-auto">Kategori</th>
                                                <th class="min-w-250px">Kriteria 1</th>
                                                <th class="min-w-250px">Kriteria 2</th>
                                                <th class="min-w-250px">Kriteria 3</th>
                                                <th class="min-w-250px">Kriteria 4</th>
                                                <th class="min-w-400px">Keterangan</th>
                                                <th class="min-w-300px">Upload Dokumen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                                $partnerSelected = $partnerDetail
                                                    ->where('partner_id', $partner->id)
                                                    ->where('kode_proyek', $partner->kode_proyek)
                                                    ->sortBy('id')
                                                    ->values();
                                            @endphp
                                            @foreach ($legalitasJasa as $key => $item)
                                                <tr>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td class="bg-secondary"></td>
                                                    <td class="bg-secondary"></td>
                                                    <td class="{{ is_null($item->item) ? 'bg-secondary' : '' }}">
                                                        @if (!is_null($item->item))
                                                            <div class="form-check" id="legalitas">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_legalitas_{{ $key + 1 }}"
                                                                    id="is_legalitas_{{ $key }}_1" value="1"
                                                                    {{ $partnerSelected[$key]->kriteria == 1 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_legalitas_{{ $key }}_1"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->item) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="{{ is_null($item->item_2) ? 'bg-secondary' : '' }}">
                                                        @if (!is_null($item->item_2))
                                                            <div class="form-check" id="legalitas">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_legalitas_{{ $key + 1 }}"
                                                                    id="is_legalitas_{{ $key }}_2" value="2"
                                                                    {{ $partnerSelected[$key]->kriteria == 2 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_legalitas_{{ $key }}_2"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->item_2) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <textarea name="is_legalitas_keterangan[]" form="form-kriteria-edit-{{ $partner->id }}" id=""
                                                            cols="60" rows="10" readonly>{!! nl2br($partnerSelected[$key]->keterangan) !!}</textarea>
                                                    </td>
                                                    <td>
                                                        <table class="mt-2" id="file-legalitas">
                                                            <thead>
                                                                <tr>
                                                                    <th class="min-w-250px">Dokumen</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $id = $partnerSelected[$key]->id;
                                                                    $files = json_decode($partnerSelected[$key]->id_document);
                                                                @endphp
                                                                @if (!empty($files))
                                                                    @foreach ($files as $file_index => $file)
                                                                        <tr>
                                                                            <td>
                                                                                <small>
                                                                                    <a target="_blank"
                                                                                        href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                        class="text-hover-primary">{{ $file }}</a>
                                                                                </small>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="hidden" name="index[]" value="{{ $key + 1 }}">
                                                    </td>
                                                    <input type="hidden" name="id_detail[]"
                                                        value="{{ $partnerSelected->isNotEmpty() ? $partnerSelected[$key]->id : '' }}">
                                                </tr>
                                                @php
                                                    $index++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="id_partner" value="{{ $partner->id }}">
                                </div>
    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light btn-active-primary text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#kt_user_modal2_lihat_kriteria_{{ $assessment->id }}" id="new_save"
                                    style="background-color:#008CB4">Next</button>
    
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <div class="modal fade" id="kt_user_modal2_lihat_kriteria_{{ $assessment->id }}" tabindex="-1"
                    aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Form Penilaian Partner</h2>
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
                                <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $assessment->id }}">
                                <div class="row fv-row">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="min-w-auto">Kategori</th>
                                                <th class="min-w-50px">Item</th>
                                                <th class="min-w-auto">Bobot</th>
                                                <th class="min-w-auto">Kriteria 1</th>
                                                <th class="min-w-auto">Kriteria 2</th>
                                                <th class="min-w-auto">Kriteria 3</th>
                                                <th class="min-w-auto">Kriteria 4</th>
                                                <th class="min-w-auto">Score</th>
                                                <th class="min-w-auto">Keterangan</th>
                                                <th class="min-w-auto">Upload Dokumen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')->get()->sortBy('position')->values();
                                                $indexEdit = $legalitasJasa->count();
                                            @endphp
                                            @foreach ($kriteriaPengguna as $key => $item)
                                                <tr>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td>{{ $item->item }}</td>
                                                    <td class="text-center">
                                                        <p>{{ $item->bobot }}</p>
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_1))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_1"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 1 }}', '{{ $key }}')"
                                                                    value="1"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 1 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_kriteria_{{ $key }}_1"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_1) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_2))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_2"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 2 }}', '{{ $key }}')"
                                                                    value="2"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 2 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_kriteria_{{ $key }}_2"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_2) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_3))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_3"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 3 }}', '{{ $key }}')"
                                                                    value="3"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 3 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_kriteria_{{ $key }}_3"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_3) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!is_null($item->kriteria_4))
                                                            <div class="form-check" id="kriteria">
                                                                <input class="form-check-input" type="radio"
                                                                    name="is_kriteria_{{ $key + 1 }}"
                                                                    id="is_kriteria_{{ $key }}_4"
                                                                    onchange="setNilaiKriteria(this, '{{ (float) $item->bobot * 4 }}', '{{ $key }}')"
                                                                    value="4"
                                                                    {{ $partnerSelected[$indexEdit]->kriteria == 4 ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="is_kriteria_{{ $key }}_4"
                                                                    class="form-check-label">
                                                                    {!! nl2br($item->kriteria_4) !!}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="number" name="nilai[]"
                                                            class="form-control form-control-solid"
                                                            form="form-kriteria-edit-{{ $partner->id }}"
                                                            value="{{ $partnerSelected[$indexEdit]->nilai ?? 0 }}"
                                                            id="nilai_{{ $key }}" readonly>
                                                    </td>
                                                    <td>
                                                        <textarea name="keterangan[]" form="form-kriteria-edit-{{ $partner->id }}" id="" cols="30"
                                                            rows="10" readonly>{!! nl2br($partnerSelected[$indexEdit]->keterangan) !!}</textarea>
                                                    </td>
                                                    <td>
                                                        <table class="mt-2" id="file-penilaian">
                                                            <thead>
                                                                <tr>
                                                                    <th class="min-w-250px">Dokumen</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $id = $partnerSelected[$indexEdit]->id;
                                                                    $files = json_decode($partnerSelected[$indexEdit]->id_document);
                                                                @endphp
                                                                @if (!empty($files))
                                                                    @foreach ($files as $file_index => $file)
                                                                        <tr>
                                                                            <td>
                                                                                <small>
                                                                                    <a target="_blank"
                                                                                        href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                        class="text-hover-primary">{{ $file }}</a>
                                                                                </small>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="hidden" name="index[]" value="{{ $key + 1 }}">
                                                    </td>
                                                    <input type="hidden" name="id_detail[]"
                                                        value="{{ $partnerSelected->isNotEmpty() ? $partnerSelected[$indexEdit]->id : '' }}">
                                                </tr>
                                                @php
                                                    $indexEdit++;
                                                    $index++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="kode_proyek" value="{{ $partner->kode_proyek }}">
                                </div>
    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_lihat_assessment_{{ $assessment->id }}" id="new_save">
                                    Back</button>
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
            </form>
        @endif
    @endforeach
    <!--end::Modal Edit Assessment Partner Selection-->

    @foreach ($customers as $assessment)
    <!--Begin::Modal Dokumen Kelengkapan Partner-->
        @php
            $partner = $assessment->PartnerJO;
        @endphp
        <div class="modal fade" id="kt_porsi_upload_dokumen_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Upload Dokumen Kelengkapan Partner KSO : {{ $partner->company_jo }}</h2>
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
                        <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-auto">Kategori</th>
                                    <th class="min-w-auto">Nama Dokumen</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600">
                                @php
                                    $collectDokumenKelengkapanPartner = $partner->DokumenKelengkapanPartnerKSO;
                                @endphp
                                <tr>
                                    <td>Dokumen AHU</td>
                                    <td class="text-center">
                                        @if ($collectDokumenKelengkapanPartner?->contains('kategori', 'Dokumen AHU'))
                                            @php
                                                $getDokumenAHU = $collectDokumenKelengkapanPartner->where('kategori', 'Dokumen AHU')->first();
                                            @endphp
                                            <a href="/proyek/porsi-jo/download/{{ $getDokumenAHU->id }}"
                                                class="text-gray-800 text-hover-primary">{{ $getDokumenAHU->nama_document }}</a>
                                        @else
                                            <p class="m-0 badge rounded-pill text-bg-danger">Belum Upload Dokumen</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dokumen Laporan Keuangan</td>
                                    <td class="text-center">
                                        @if ($collectDokumenKelengkapanPartner?->contains('kategori', 'Dokumen Laporan Keuangan'))
                                            @php
                                                $getDokumenLaporanKeuangan = $collectDokumenKelengkapanPartner->where('kategori', 'Dokumen Laporan Keuangan')->first();
                                            @endphp
                                            <a href="/proyek/porsi-jo/download/{{ $getDokumenLaporanKeuangan->id }}"
                                                class="text-gray-800 text-hover-primary">{{ $getDokumenLaporanKeuangan->nama_document }}</a>
                                        @else
                                            <p class="m-0 badge rounded-pill text-bg-danger">Belum Upload Dokumen</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dokumen Pengalaman</td>
                                    <td class="text-center">
                                        @if ($collectDokumenKelengkapanPartner?->contains('kategori', 'Dokumen Pengalaman'))
                                            @php
                                                $getDokumenPengalaman = $collectDokumenKelengkapanPartner->where('kategori', 'Dokumen Pengalaman')->first();
                                            @endphp
                                            <a href="/proyek/porsi-jo/download/{{ $getDokumenPengalaman->id }}"
                                                class="text-gray-800 text-hover-primary">{{ $getDokumenPengalaman->nama_document }}</a>
                                        @else
                                            <p class="m-0 badge rounded-pill text-bg-danger">Belum Upload Dokumen</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dokumen Laporan SPT Terakhir</td>
                                    <td class="text-center">
                                        @if ($collectDokumenKelengkapanPartner?->contains('kategori', 'Dokumen Laporan SPT'))
                                            @php
                                                $getDokumenSPT = $collectDokumenKelengkapanPartner->where('kategori', 'Dokumen Laporan SPT')->first();
                                            @endphp
                                            <a href="/proyek/porsi-jo/download/{{ $getDokumenSPT->id }}"
                                                class="text-gray-800 text-hover-primary">{{ $getDokumenSPT->nama_document }}</a>
                                        @else
                                            <p class="m-0 badge rounded-pill text-bg-danger">Belum Upload Dokumen</p>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    <!--end::Modal Dokumen Kelengkapan Partner-->

    @php
        switch ($partner->keterangan) {
            case 'Very Low Risk':
                $style = 'badge rounded-pill badge-success';
                break;
            case 'Low Risk':
                $style = 'badge rounded-pill badge-light-success text-black';
                break;
            case 'Average Risk':
                $style = 'badge rounded-pill badge-warning';
                break;
            case 'High Risk':
                $style = 'badge rounded-pill badge-light-danger text-black';
                break;
            case 'Very High Risk':
                $style = 'badge rounded-pill badge-danger';
                break;

            default:
                $style = 'badge rounded-pill badge-danger';
                break;
        }
    @endphp
    <!--begin::Modal Pengajuan-->
    <form action="/assessment-partner-selection/pengajuan/approval" method="post" onsubmit="addLoading(this)">
    @csrf
        <div class="modal fade" id="pengajuan_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Pengajuan Partner KSO :</h2>
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
                        <div class="container">
                            <table class="table display align-middle table-row-dashed fs-6">
                                <thead>
                                    <tr>
                                        <th class="min-w-auto">No.</th>
                                        <th class="min-w-auto">Item</th>
                                        <th class="min-w-auto">Uraian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Nama Perusahaan Partner</td>
                                        <td>{{ $partner->Company->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Nama Proyek</td>
                                        <td>{{ $partner->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Jenis Instansi</td>
                                        <td>{{ $partner->Company->jenis_instansi }}</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Hasil Assessment Eksternal</td>
                                        <td>
                                            <p class="m-0 {{ empty($partner->score_pefindo_jo) ? "badge rounded-pill badge-danger" : "" }}">{{ $partner->score_pefindo_jo ?? "*Belum ditentukan" }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Risk Kategori Eksternal</td>
                                        <td>
                                            <p class="{{ $style }} m-0">{{ $partner->keterangan ?? "*Belum ditentukan" }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Dokumen Partner</td>
                                        <td>
                                            <a href="#"
                                                data-bs-target="#kt_porsi_upload_dokumen_{{ $assessment->id }}"
                                                data-bs-toggle="modal"
                                                class="btn btn-sm btn-primary py-3 text-white">
                                                Lihat Dokumen
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h5>Dokumen Pendukung</h5>
                            @if (!empty($assessment->PartnerJO?->file_kelengkapan_merge))
                            <div class="text-center">
                                <iframe src="{{ asset('file-kelengkapan-partner' . '\\' . $assessment->PartnerJO->file_kelengkapan_merge) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer row">
                        @if (is_null($assessment->is_pengajuan_approved))
                            @if ($partner->DokumenKelengkapanPartnerKSO->count() < 4)
                                <button type="button" data-bs-toggle="tooltip"
                                    data-bs-html="true"
                                    data-bs-title="<b>Belum dapat melakukan assessment,</b><br> dokumen belum lengkap"
                                    class="btn btn-sm btn-primary py-3">
                                    Ajukan
                                </button>
                                <button type="button" data-bs-toggle="tooltip"
                                    data-bs-html="true"
                                    data-bs-title="<b>Belum dapat melakukan assessment,</b><br> dokumen belum lengkap"
                                    class="btn btn-sm btn-danger py-3">
                                    Tolak
                                </button>
                            @else
                                <input type="hidden" name="id_partner" value="{{ $assessment->id }}">
                                <input type="hidden" name="is_setuju" value="t">
                                <button type="submit" class="btn btn-sm btn-primary">Ajukan</button>
                                <button type="button" class="btn btn-sm btn-danger"
                                data-bs-target="#pengajuan_tolak_{{ $assessment->id }}"
                                data-bs-toggle="modal">Tolak</button>                            
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="/assessment-partner-selection/pengajuan/approval" method="post">
    @csrf
    <div class="modal fade" id="pengajuan_tolak_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Alasan Tolak :</h2>
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
                    <input type="hidden" name="id_partner" value="{{ $assessment->id }}">
                    <input type="hidden" name="is_form" value="true">
                    <input type="hidden" name="is_setuju" value="f">
                    <textarea name="alasan_tolak" id="alasan_tolak" rows="10" class="form-control form-control-solid"></textarea>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
                <!--end::Modal footer-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    </form>
    <!--end::Modal Pengajuan-->

    <!--begin::Modal Penyusun-->
    <form action="/assessment-partner-selection/penyusun/approval" method="post" onsubmit="addLoading(this)">
    @csrf
        <div class="modal fade" id="penyusun_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Penyusun Partner KSO :</h2>
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
                        <div class="container">
                            <table class="table display align-middle table-row-dashed fs-6">
                                <thead>
                                    <tr>
                                        <th class="min-w-auto">No.</th>
                                        <th class="min-w-auto">Item</th>
                                        <th class="min-w-auto">Uraian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Nama Perusahaan Partner</td>
                                        <td>{{ $partner->Company->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Nama Proyek</td>
                                        <td>{{ $partner->Proyek->nama_proyek }}</td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Jenis Instansi</td>
                                        <td>{{ $partner->Company->jenis_instansi }}</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Hasil Assessment Eksternal</td>
                                        <td>
                                            <p class="m-0 {{ empty($partner->score_pefindo_jo) ? "badge rounded-pill badge-danger" : "" }}">{{ $partner->score_pefindo_jo ?? "*Belum ditentukan" }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>Risk Kategori Eksternal</td>
                                        <td>
                                            <p class="{{ $style }} m-0">{{ $partner->keterangan ?? "*Belum ditentukan" }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>Dokumen Partner</td>
                                        <td>
                                            <a href="#"
                                                data-bs-target="#kt_porsi_upload_dokumen_{{ $assessment->id }}"
                                                data-bs-toggle="modal"
                                                class="btn btn-sm btn-primary py-3 text-white">
                                                Lihat Dokumen
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Assessment Internal</td>
                                        <td>
                                            @if (is_null($assessment->is_penyusun_approved))
                                                <a href="#"
                                                    data-bs-target="#kt_modal_edit_assessment_{{ $assessment->id }}"
                                                    data-bs-toggle="modal"
                                                    class="btn btn-sm btn-primary text-white py-3">
                                                    Edit Detail
                                                </a>
                                            @else
                                                <a href="#"
                                                    data-bs-target="#kt_modal_lihat_assessment_{{ $assessment->id }}"
                                                    data-bs-toggle="modal"
                                                    class="btn btn-sm btn-primary py-3 text-white">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <hr>
                            <h5>Dokumen Pendukung</h5>
                            @if (!empty($assessment->PartnerJO?->file_kelengkapan_merge))
                            <div class="text-center">
                                <iframe src="{{ asset('file-kelengkapan-partner' . '\\' . $assessment->PartnerJO->file_kelengkapan_merge) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                            @endif
                            <h5>Dokumen Assessment</h5>
                            @if (!empty($assessment->PartnerJO?->file_assessment_merge))
                            <div class="text-center">
                                <iframe src="{{ asset('file-nota-rekomendasi-2'.'\\'.'file-kriteria-partner' . '\\' . $assessment->PartnerJO->file_assessment_merge) }}"
                                    width="800px" height="600px"></iframe>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer row">
                        @if (is_null($assessment->is_penyusun_approved))
                            @if ($partner->DokumenKelengkapanPartnerKSO->count() < 4)
                                <button type="button" data-bs-toggle="tooltip"
                                    data-bs-html="true"
                                    data-bs-title="<b>Belum dapat melakukan assessment,</b><br> dokumen belum lengkap"
                                    class="btn btn-sm btn-primary py-3">
                                    Submit
                                </button>
                            @else
                                <input type="hidden" name="id_partner" value="{{ $assessment->id }}">
                                <input type="hidden" name="is_setuju" value="t">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>                           
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Modal Penyusun-->

    <!--begin::Modal Penyusun-->
    <form action="/assessment-partner-selection/rekomendasi/approval" method="post" onsubmit="addLoading(this)">
        @csrf
            <div class="modal fade" id="rekomendasi_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-900px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Penyusun Partner KSO :</h2>
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
                            <div class="container">
                                <table class="table display align-middle table-row-dashed fs-6">
                                    <thead>
                                        <tr>
                                            <th class="min-w-auto">No.</th>
                                            <th class="min-w-auto">Item</th>
                                            <th class="min-w-auto">Uraian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Nama Perusahaan Partner</td>
                                            <td>{{ $partner->Company->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Nama Proyek</td>
                                            <td>{{ $partner->Proyek->nama_proyek }}</td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Jenis Instansi</td>
                                            <td>{{ $partner->Company->jenis_instansi }}</td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Hasil Assessment Eksternal</td>
                                            <td>
                                                <p class="m-0 {{ empty($partner->score_pefindo_jo) ? "badge rounded-pill badge-danger" : "" }}">{{ $partner->score_pefindo_jo ?? "*Belum ditentukan" }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5.</td>
                                            <td>Risk Kategori Eksternal</td>
                                            <td>
                                                <p class="{{ $style }} m-0">{{ $partner->keterangan ?? "*Belum ditentukan" }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6.</td>
                                            <td>Dokumen Partner</td>
                                            <td>
                                                <a href="#"
                                                    data-bs-target="#kt_porsi_upload_dokumen_{{ $assessment->id }}"
                                                    data-bs-toggle="modal"
                                                    class="btn btn-sm btn-primary py-3 text-white">
                                                    Lihat Dokumen
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7.</td>
                                            <td>Assessment Internal</td>
                                            <td>
                                                @if (is_null($assessment->is_penyusun_approved))
                                                    <a href="#"
                                                        data-bs-target="#kt_modal_edit_assessment_{{ $assessment->id }}"
                                                        data-bs-toggle="modal"
                                                        class="btn btn-sm btn-primary text-white py-3">
                                                        Edit Detail
                                                    </a>
                                                @else
                                                    <a href="#"
                                                        data-bs-target="#kt_modal_lihat_assessment_{{ $assessment->id }}"
                                                        data-bs-toggle="modal"
                                                        class="btn btn-sm btn-primary py-3 text-white">
                                                        Lihat Detail
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <hr>
                                <h5>Dokumen Pendukung</h5>
                                @if (!empty($assessment->PartnerJO?->file_kelengkapan_merge))
                                <div class="text-center">
                                    <iframe src="{{ asset('file-kelengkapan-partner' . '\\' . $assessment->PartnerJO->file_kelengkapan_merge) }}"
                                        width="800px" height="600px"></iframe>
                                </div>
                                @endif
                                <h5>Dokumen Assessment</h5>
                                @if (!empty($assessment->PartnerJO?->file_assessment_merge))
                                <div class="text-center">
                                    <iframe src="{{ asset('file-nota-rekomendasi-2'.'\\'.'file-kriteria-partner' . '\\' . $assessment->PartnerJO->file_assessment_merge) }}"
                                        width="800px" height="600px"></iframe>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer row">
                            @if (is_null($assessment->is_rekomendasi_approved) &&$matriks_user->contains('kategori', 'Rekomendasi') &&
                            $matriks_user->where('kategori', 'Rekomendasi')?->where('departemen_code', $partner->Proyek->departemen_proyek)?->where('divisi_id', $partner->Proyek->UnitKerja->Divisi->id_divisi)?->first())
                            <label for="kategori-rekomendasi" class="text-start"><span class="required">Kategori Rekomendasi: </span></label>
                            <select id="kategori-rekomendasi" name="kategori-rekomendasi"
                                class="form-select form-select-solid w-auto" style="margin-right: 2rem;"
                                data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori"
                                data-select2-id="select2-data-kategori-rekomendasi" tabindex="-1"
                                aria-hidden="true">
                                <option value=""></option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Tidak Disetujui">Tidak Disetujui</option>
                            </select>
                            <br>
                            <label for="kategori-rekomendasi" class="text-start"><span class="">Catatan: </span></label>
                            <textarea name="alasan-ditolak" class="form-control form-control-solid"cols="1" rows="5"></textarea>
                            <br>
                            <input type="hidden" name="id_partner" value="{{ $assessment->id }}">
                            <input type="submit" class="btn btn-sm btn-success" name="rekomendasi-setujui"
                                value="Submit">
                            <a href="#"
                                data-bs-target="#revisi_{{ $assessment->id }}"
                                data-bs-toggle="modal"
                                class="btn btn-sm btn-primary text-white">
                                Revisi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Modal Penyusun-->

    <!--begin::Modal Pengajuan Revisi-->
    <form action="/assessment-partner-selection/pengajuan-revisi/approval" method="post" onsubmit="addLoading(this)">
    @csrf
        <div class="modal fade" id="revisi_{{ $assessment->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Catatan Revisi :</h2>
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
                        <input type="hidden" name="id_partner" value="{{ $assessment->id }}">
                        <input type="hidden" name="is_form" value="true">
                        <textarea name="catatan_revisi" id="catatan_revisi" rows="10" class="form-control form-control-solid"></textarea>
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                    <!--end::Modal footer-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::Modal Persetujuan Tolak-->

    <!--Begin::Modal Revisi Note-->
    <div class="modal fade" id="kt_modal_view_history_revisi_{{ $assessment->id }}" tabindex="-1"
        aria-labelledby="kt_modal_view_proyek_revisi_note_{{ $assessment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Revisi Nota Rekomendasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $revisi_note = collect(json_decode($assessment->approved_revisi));
                    @endphp
                    {{-- Begin :: History --}}
                    <div class="row">
                        @php
                            $row = 1;
                        @endphp
                        <div class="timeline-centered">
                            @forelse ($revisi_note as $key => $data)
                                <article class="timeline-entry {{ $row % 2 == 0 ? 'left-aligned' : '' }}">

                                    <div class="timeline-entry-inner">
                                        <time class="timeline-time"></time>
                                            <div class="timeline-icon bg-success">
                                                <i class="entypo-feather"></i>
                                            </div>

                                        <div class="timeline-content">
                                            <div class="row">
                                                <h5>Catatan Revisi {{ $row }}:</h5>
                                                <div class="card text-bg-light my-3">
                                                    <div class="card-body">
                                                        <small>
                                                            Nama:
                                                            <b>{{ App\Models\User::find($data->user_id)->name }}</b><br>
                                                            Jabatan:
                                                            <b>{{ App\Models\User::find($data->user_id)->Pegawai->Jabatan?->nama_jabatan }}</b><br>
                                                            @if (!empty($data->tanggal))
                                                                Tanggal:
                                                                <b>{{ Carbon\Carbon::create($data->tanggal)->translatedFormat('d F Y H:i:s') }}</b><br>
                                                            @endif
                                                            @if (!empty($data->catatan))
                                                                Catatan:
                                                                <b>{!! nl2br($data->catatan) !!}</b><br>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                @php
                                    $row++;
                                @endphp
                            @empty
                                <p class="text-center"><b>Belum ada catatan revisi</b></p>
                            @endforelse
                        </div>
                    </div>
                    {{-- End :: History --}}
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!--End::Modal Revisi Note-->
    @endforeach

@endsection

@section('js-script')
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>

    <script>
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })
        function addLoading(elt) {
            LOADING_BODY.block();
            elt.form.submit();
        }
        $('#partner-selection').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            order: [
                [0, 'desc']
            ],
            buttons: [
                'excel'
            ]
        });
        $('#assessment-partner').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            order: [
                [0, 'desc']
            ],
            buttons: [
                'excel'
            ]
        });
    </script>
    <script>
        function setNilaiKriteria(e, total, key) {

            let columnNilai = e.parentElement.parentElement.parentElement.querySelector(`#nilai_${key}`);
            return columnNilai.value = parseFloat(total);
        }
    </script>

    <script>
        function checkSizeFile(elt, kodeProyek, index, buttonSaveId, isEdit = null) {
            if (isEdit == null) {
                if (elt.files.length < 1) {
                    elt.nextElementSibling.classList.add('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.remove('disabled');
                    return;
                }
                // console.log(elt.files);
                let sizeFileCollect = 0;
                let fileOversize = [];

                elt.files.forEach(item => {
                    sizeFileCollect += item.size
                });

                if (sizeFileCollect > 20971520) {
                    elt.nextElementSibling.classList.remove('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.add('disabled');
                } else {
                    elt.nextElementSibling.innerHTML = ""
                    elt.nextElementSibling.classList.add('d-none');
                    document.querySelector(`#${buttonSaveId}`).classList.remove('disabled');
                }
            }
        }

        function validateFileSize(e) {
            const files = e.querySelectorAll("input[type='file']");
            let totalSizeFile = 0

            files.forEach(item => {
                if (item.files.length > 0) {
                    item.files.forEach(file => {
                        totalSizeFile += file.size;
                    })
                }
            })
            //Maximum file 40 MB => dibuat 42 MB
            if (totalSizeFile > 44040192) {
                Toast.fire({
                    html: "Ukuran file lebih dari 40 MB. Periksa kembali!",
                    icon: "error",
                });
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script>
        function deleteBackdrop() {
            let backdrop = document.querySelector('.modal-backdrop');
            backdrop.remove();
        }
    </script>

    <script>
        function assessmentPengajuan(id_partner, is_setuju) {
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Aksi tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then((res)=>{
                if (res.isConfirmed) {
                    setSetujuApprovalPengajuan(id_partner, is_setuju);
                }
            })
            
        }
        async function setSetujuApprovalPengajuan(id_partner, is_setuju) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_partner', id_partner);
            formData.append('is_setuju', is_setuju);

            try {
                const response = await fetch('/assessment-partner-selection/pengajuan/approval', {
                    method: 'POST',
                    header: {
                        'Content-Type' : 'application/json'
                    },
                    body: formData
                }).then(res => res.json());
                
                if (response.success) {
                    Swal.fire({
                        icon:'success',
                        title:'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(res => window.location.reload());
                }else{
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(res => window.location.reload());
                }
            } catch (error) {
                Swal.fire({
                    icon:'error',
                    title:'Error',
                    text: error,
                    showConfirmButton: false,
                    timer : 2000
                }).then(res => window.location.reload());
            }

        }

        function assessmentPersetujuan(id_partner, is_setuju) {
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Aksi tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#008CB4',
                cancelButtonColor: '#BABABA',
                confirmButtonText: 'Ya'
            }).then((res)=>{
                if (res.isConfirmed) {
                    setSetujuApprovalPersetujuan(id_partner, is_setuju);
                }
            })
            
        }
        async function setSetujuApprovalPersetujuan(id_partner, is_setuju) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_partner', id_partner);
            formData.append('is_setuju', is_setuju);

            try {
                const response = await fetch('/assessment-partner-selection/persetujuan/approval', {
                    method: 'POST',
                    header: {
                        'Content-Type' : 'application/json'
                    },
                    body: formData
                }).then(res => res.json());
                
                if (response.success) {
                    Swal.fire({
                        icon:'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(res => window.location.reload());
                }else{
                    Swal.fire({
                        icon:'error',
                        title: 'Error',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(res => window.location.reload());
                }
            } catch (error) {
                Swal.fire({
                    icon:'error',
                    title: 'Error',
                    text: error,
                    showConfirmButton: false,
                    timer: 2000
                }).then(res => window.location.reload());
            }

        }
    </script>
@endsection
