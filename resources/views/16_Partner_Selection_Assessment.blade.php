@extends('template.main')
@section('title', 'Partner Selection')

@section('content')
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
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body px-6 pt-0">
                            <!--begin::Table Proyek-->
                            <table class="table table-striped table-hover align-middle table-row-dashed fs-6 gy-2"
                                id="partner-selection">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr>
                                        <th class="min-w-auto">Nama Perusahaan</th>
                                        <th class="min-w-auto">Nama Proyek</th>
                                        <th class="min-w-auto">Jenis Instansi</th>
                                        <th class="min-w-auto">Status Kelengkapan Dokumen</th>
                                        <th class="min-w-auto">Score Pefindo</th>
                                        <th class="min-w-auto">Risk Kategori</th>
                                        <th class="min-w-auto">Score Partner Selection</th>
                                        <th class="min-w-auto">Risk Kategori Partner Selection</th>
                                        <th class="min-w-auto">Dokumen Kelengkapan Partner</th>
                                        <th class="min-w-auto">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    <!--begin::Table row-->
                                    @foreach ($customers as $partner)
                                        @php
                                        $partner = $partner->PartnerJO;
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
                                                    $style = '';
                                                    break;
                                            }

                                            $nilaiRisk = $partner->PartnerSelection?->where('kode_proyek', $partner->kode_proyek)->sum('nilai');
                                            if (empty($nilaiRisk)) {
                                                $kategoriRiskPartner = null;
                                            }else{
                                                $kategoriRiskPartner = $kriteriaPenilaian?->filter(function ($item) use ($nilaiRisk) {
                                                    return (float)$item->dari_nilai <= (int)$nilaiRisk && (float)$item->sampai_nilai >= (int)$nilaiRisk;
                                                })->first()?->nama;
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
                                                        $style_2 = '';
                                                        break;
                                                }
                                            }else {
                                                $style_2 = '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="">{{ $partner->Company->name ?? $partner->company_jo }}</td>
                                            <td class="text-start"> {{ $partner->Proyek->nama_proyek ?? '-' }}</td>
                                            <td class="text-center"> {{ $partner->Company->jenis_instansi ?? '-' }}</td>
                                            <td class="text-center"> <p class="m-0 badge rounded-pill badge-sm {{ $partner->DokumenKelengkapanPartnerKSO->count() < 4 ? "text-bg-danger" : "text-bg-success" }} }}">{{ $partner->DokumenKelengkapanPartnerKSO->count() < 4 ? "Belum Lengkap" : "Sudah Lengkap" }}</p></td>
                                            <td class="text-center"> {{ $partner->score_pefindo_jo }}</td>
                                            <td class="text-center">
                                                <p class="{{ $style }} m-0">{{ $partner->keterangan }}</p>
                                            </td>
                                            <td class="text-center"> {{ $nilaiRisk != 0 ?: '' }}</td>
                                            <td class="text-center">
                                                <p class="{{ $style_2 }} m-0">{{ $kategoriRiskPartner ?? '' }}</p>
                                            </td>
                                            <td class="text-center"> 
                                                <a href="#"
                                                    data-bs-target="#kt_porsi_upload_dokumen_{{ $partner->id }}"
                                                    data-bs-toggle="modal"
                                                    class="btn btn-sm btn-primary py-3 text-white">
                                                    Lihat Dokumen
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                    @if (empty($partner->PartnerSelection) || $partner->PartnerSelection->isEmpty())
                                                        @if ($partner->DokumenKelengkapanPartnerKSO->count() < 4)
                                                            <button type="button"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-html="true"
                                                                data-bs-title="<b>Belum dapat melakukan assessment,</b><br> dokumen belum lengkap"
                                                                class="btn btn-sm btn-secondary py-3">
                                                                Isi Assessment
                                                            </button>
                                                        @else
                                                            <a href="#"
                                                                data-bs-target="#kt_modal_create_assessment_{{ $partner->id }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary py-3 text-white">
                                                                Isi Assessment
                                                            </a>
                                                        @endif
                                                    @else
                                                        <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                                                            <a href="#"
                                                                data-bs-target="#kt_modal_lihat_assessment_{{ $partner->id }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-primary py-3 text-white">
                                                                Lihat Detail
                                                            </a>
                                                            <a href="#"
                                                                data-bs-target="#kt_modal_edit_assessment_{{ $partner->id }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-sm btn-active-primary py-3">
                                                                Edit Detail
                                                            </a>
                                                        </div>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!--end::Table row-->
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table Proyek-->
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
    @foreach ($customers as $partner)
        <form action="/assessment-partner-selection/{{ $partner->id }}/save" method="POST"
            id="form-kriteria-{{ $partner->id }}" enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
            @csrf
            <div class="modal fade" id="kt_modal_create_assessment_{{ $partner->id }}" tabindex="-1" aria-hidden="true">
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
                                            $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                                ->get()
                                                ->sortBy('position')
                                                ->values();
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
                                                    <textarea name="is_legalitas_keterangan[]" form="form-kriteria-{{ $partner->id }}" id="" cols="60"
                                                        rows="10"></textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_legalitas_{{ $key }}[]"
                                                        form="form-kriteria-{{ $partner->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $partner->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $partner->id }}-{{ $key + 1 }}">Total
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
                                data-bs-toggle="modal" data-bs-target="#kt_user_modal2_kriteria_{{ $partner->id }}"
                                id="new_save" style="background-color:#008CB4">Next</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <div class="modal fade" id="kt_user_modal2_kriteria_{{ $partner->id }}" tabindex="-1" aria-hidden="true">
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
                            <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $partner->id }}">
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
                                            $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                                ->get()
                                                ->sortBy('position')
                                                ->values();
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
                                                        form="form-kriteria-{{ $partner->id }}"
                                                        id="nilai_{{ $key }}" readonly>
                                                </td>
                                                <td>
                                                    <textarea name="keterangan[]" form="form-kriteria-{{ $partner->id }}" id="" cols="30"
                                                        rows="10"></textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_penilaian_{{ $key + 1 }}[]"
                                                        form="form-kriteria-{{ $partner->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $partner->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $partner->id }}-{{ $key + 1 }}">Total
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
                                data-bs-target="#kt_user_view_kriteria_{{ $partner->id }}" id="new_save">
                                Back</button>
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                form="form-kriteria-{{ $partner->id }}" id="save-{{ $partner->id }}-new"
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
    @foreach ($customers as $partner)
    @if (!empty($partner->PartnerSelection) && $partner->PartnerSelection->isNotEmpty())
        <form action="/assessment-partner-selection/{{ $partner->id }}/edit" method="POST"
            id="form-kriteria-edit-{{ $partner->id }}" enctype="multipart/form-data"
            onsubmit="return validateFileSize(this)">
            @csrf
            <div class="modal fade" id="kt_modal_edit_assessment_{{ $partner->id }}" tabindex="-1"
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
                                            $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                                ->get()
                                                ->sortBy('position')
                                                ->values();
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
                                                                id="is_legalitas_{{ $key }}_2" value="2"
                                                                {{ $partnerSelected[$key]->kriteria == 2 ? 'checked' : '' }}>
                                                            <label for="is_legalitas_{{ $key }}_2"
                                                                class="form-check-label">
                                                                {!! nl2br($item->item_2) !!}
                                                            </label>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <textarea name="is_legalitas_keterangan[]" form="form-kriteria-edit-{{ $partner->id }}" id="" cols="60"
                                                        rows="10">{!! nl2br($partnerSelected[$key]->keterangan) !!}</textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_legalitas_{{ $key }}[]"
                                                        form="form-kriteria-edit-{{ $partner->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $partner->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $partner->id }}-{{ $key + 1 }}">Total
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
                                                                            <a target="_blank" href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                class="text-hover-primary">{{ $file }}</a>
                                                                        </small>
                                                                    </td>
                                                                    <form action=""></form>
                                                                    <form action="/assessment-partner-selection/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="id" id="id" value="{{$id}}">
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="file-name" id="file-name" value="{{$file}}">
                                                                        <td class="text-center">
                                                                            <button type="submit" form="delete-file-{{$id}}-{{$file_index + 1}}" class="btn btn-sm btn-outline-danger text-hover-white">
                                                                                <i class="bi bi-trash3-fill text-danger"></i>
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
                                data-bs-toggle="modal" data-bs-target="#kt_user_modal2_edit_kriteria_{{ $partner->id }}"
                                id="new_save" style="background-color:#008CB4">Next</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <div class="modal fade" id="kt_user_modal2_edit_kriteria_{{ $partner->id }}" tabindex="-1" aria-hidden="true">
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
                            <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $partner->id }}">
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
                                            $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                                ->get()
                                                ->sortBy('position')
                                                ->values();
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
                                                                value="1" {{ $partnerSelected[$indexEdit]->kriteria == 1 ? 'checked' : '' }}>
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
                                                                value="2" {{ $partnerSelected[$indexEdit]->kriteria == 2 ? 'checked' : '' }}>
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
                                                                value="3" {{ $partnerSelected[$indexEdit]->kriteria == 3 ? 'checked' : '' }}>
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
                                                                value="4" {{ $partnerSelected[$indexEdit]->kriteria == 4 ? 'checked' : '' }}>
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
                                                        rows="10">{!! nl2br($partnerSelected[$indexEdit]->keterangan) !!}</textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="dokumen_penilaian_{{ $key + 1 }}[]"
                                                        form="form-kriteria-edit-{{ $partner->id }}" id="dokumen_kriteria"
                                                        multiple accept=".pdf"
                                                        onchange="checkSizeFile(this, '{{ $partner->id }}', {{ $key + 1 }}, 'save-{{ $partner->id }}-new')"
                                                        class="form-control form-control-sm form-control-solid">
                                                    <small class="text-danger d-none"
                                                        id="alert-file-{{ $partner->id }}-{{ $key + 1 }}">Total
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
                                                                            <a target="_blank" href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
                                                                                class="text-hover-primary">{{ $file }}</a>
                                                                        </small>
                                                                    </td>
                                                                    <form action=""></form>
                                                                    <form action="/assessment-partner-selection/delete-file" onsubmit="return confirmDeleteFile(this, '{{$file}}');" name="delete-file-{{$id}}-{{$file_index + 1}}" id="delete-file-{{$id}}-{{$file_index + 1}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="id" id="id" value="{{$id}}">
                                                                        <input type="hidden" form="delete-file-{{$id}}-{{$file_index + 1}}" name="file-name" id="file-name" value="{{$file}}">
                                                                        <td class="text-center">
                                                                            <button type="submit" form="delete-file-{{$id}}-{{$file_index + 1}}" class="btn btn-sm btn-outline-danger text-hover-white">
                                                                                <i class="bi bi-trash3-fill text-danger"></i>
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
                                data-bs-target="#kt_modal_edit_assessment_{{ $partner->id }}" id="new_save">
                                Back</button>
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                form="form-kriteria-edit-{{ $partner->id }}" id="save-{{ $partner->id }}-new"
                                style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
        </form>

        <div class="modal fade" id="kt_modal_lihat_assessment_{{ $partner->id }}" tabindex="-1"
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
                                        $legalitasJasa = App\Models\LegalitasPerusahaan::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                            ->get()
                                            ->sortBy('position')
                                            ->values();
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
                                                            {{ $partnerSelected[$key]->kriteria == 1 ? 'checked' : '' }} disabled>
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
                                                            {{ $partnerSelected[$key]->kriteria == 2 ? 'checked' : '' }} disabled>
                                                        <label for="is_legalitas_{{ $key }}_2"
                                                            class="form-check-label">
                                                            {!! nl2br($item->item_2) !!}
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <textarea name="is_legalitas_keterangan[]" form="form-kriteria-edit-{{ $partner->id }}" id="" cols="60"
                                                    rows="10" readonly>{!! nl2br($partnerSelected[$key]->keterangan) !!}</textarea>
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
                                                                        <a target="_blank" href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
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
                            data-bs-toggle="modal" data-bs-target="#kt_user_modal2_lihat_kriteria_{{ $partner->id }}"
                            id="new_save" style="background-color:#008CB4">Next</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <div class="modal fade" id="kt_user_modal2_lihat_kriteria_{{ $partner->id }}" tabindex="-1" aria-hidden="true">
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
                        <input type="hidden" name="modal" value="#kt_user_view_kriteria_{{ $partner->id }}">
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
                                        $kriteriaPengguna = App\Models\KriteriaPenggunaJasa::where('nota_rekomendasi', '=', 'Nota Rekomendasi 2')
                                            ->get()
                                            ->sortBy('position')
                                            ->values();
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
                                                            value="1" {{ $partnerSelected[$indexEdit]->kriteria == 1 ? 'checked' : '' }} disabled>
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
                                                            value="2" {{ $partnerSelected[$indexEdit]->kriteria == 2 ? 'checked' : '' }} disabled>
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
                                                            value="3" {{ $partnerSelected[$indexEdit]->kriteria == 3 ? 'checked' : '' }} disabled>
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
                                                            value="4" {{ $partnerSelected[$indexEdit]->kriteria == 4 ? 'checked' : '' }} disabled>
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
                                                                        <a target="_blank" href="{{ $partnerSelected->isNotEmpty() ? asset('file-selection-partner' . '\\' . $file) : '' }}"
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
                            data-bs-target="#kt_modal_lihat_assessment_{{ $partner->id }}" id="new_save">
                            Back</button>
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endif
    @endforeach
    <!--end::Modal Edit Assessment Partner Selection-->
    
    <!--Begin::Modal Dokumen Kelengkapan Partner-->
    @foreach ($customers as $partner)
        <!--begin::UPLOAD DOKUMEN PARTNER JO-->
            <div class="modal fade" id="kt_porsi_upload_dokumen_{{ $partner->id }}" tabindex="-1" aria-hidden="true">
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
                            <table class="table align-middle table-row-dashed fs-6 gy-2"
                            id="kt_customers_table">
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
                                                <a href="/proyek/porsi-jo/download/{{ $getDokumenAHU->id }}" class="text-gray-800 text-hover-primary">{{ $getDokumenAHU->nama_document }}</a>
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
                                                <a href="/proyek/porsi-jo/download/{{ $getDokumenLaporanKeuangan->id }}" class="text-gray-800 text-hover-primary">{{ $getDokumenLaporanKeuangan->nama_document }}</a>
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
                                                <a href="/proyek/porsi-jo/download/{{ $getDokumenPengalaman->id }}" class="text-gray-800 text-hover-primary">{{ $getDokumenPengalaman->nama_document }}</a>
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
                                                <a href="/proyek/porsi-jo/download/{{ $getDokumenSPT->id }}" class="text-gray-800 text-hover-primary">{{ $getDokumenSPT->nama_document }}</a>
                                            @else
                                                <p class="m-0 badge rounded-pill text-bg-danger">Belum Upload Dokumen</p>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        <!--end::UPLOAD DOKUMEN PARTNER JO-->
    @endforeach
    <!--end::Modal Dokumen Kelengkapan Partner-->

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
@endsection
