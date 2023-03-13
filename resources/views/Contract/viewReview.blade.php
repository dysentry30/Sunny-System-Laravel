{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Tinjauan Dokumen Kontrak')
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
    .form-control.form-control-solid {
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
    }

    #nilai-kontrak-keseluruhan::placeholder {
        color: #D9214E;
        opacity: 1;
        /* Firefox */
    }
</style>

<!--begin::Main-->
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
                @php
                    $is_approved = $contract->ContractApproval->where("periode", "=", (int)date("m") + 1)->where("is_locked", "=", true);
                @endphp
                <div class="container mx-3 mt-0">
                    <h1>
                        Add Tinjauan Dokumen Kontrak - {{ $stage == 1 ? "Perolehan" : "Pelaksanaan" }}
                        @if ($is_approved->isNotEmpty())
                        <span><i class="bi bi-info-circle-fill p-3" data-bs-toggle="tooltip" data-bs-title="Contract sudah dilock, silahkan request unlock jika ingin mengubah"></i></span>
                        @endif
                    </h1>
                </div>
                

                <div class="px-8" style="margin-bottom: 2rem;">
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


                    <!--begin:::Isi Data-->
                    <!--begin::Table-->
                    
                    <div class="d-flex flex-column bg-white px-15 py-8 mx-7">
                        <span class="mb-4 fw-bold fs-4">
                            @if (!empty($review))
                            <a href="#" onclick="exportToExcel(this, '#tinjauan-kontrak')" class="">(Klik di sini untuk Export ke Excel)</a>
                            @endif
                        </span>
                        <form action="/review-contract/upload" method="POST" class="card card-flush">
                            @csrf
                            <input type="hidden" class="form-control form-control-solid" name="id-contract" value="{{ $contract->id_contract }}" {{ $is_approved->isEmpty() ? "" : "disabled" }}>
                            <input type="hidden" class="form-control form-control-solid" name="stage" value="{{ $stage }}" {{ $is_approved->isEmpty() ? "" : "disabled" }}>
                            
                            <table class="table align-middle table-row-dashed fs-6 gy-2 card-body" id="tinjauan-kontrak">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Ketentuan</th>
                                        <th class="min-w-auto">Sub Pasal</th>
                                        <th class="min-w-auto">Uraian / Penjelasan</th>
                                        <th class="min-w-auto">PIC Cross Function</th>
                                        <th class="min-w-auto">Catatan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <!--begin::Row Nama Proyek-->
                                    {{-- @dump($review) --}}
                                    {{-- @dd($review->isEmpty()) --}}
                                    @if ($review->isNotEmpty())
                                        @foreach ($review as $item)
                                            {{-- @dd($item) --}}
                                            <tr class="text-grey">
                                                <td>
                                                    <label><b>{{ $item->kategori }}</b></label>
                                                    <input type="hidden" class="form-control form-control-solid" name="kategori[]" value="{{ $item->kategori }}" {{ $is_approved->isEmpty() ? "" : "readonly" }}>
                                                </td>
                                                <td>
                                                    <p hidden>{{ $item->sub_pasal }}</p>
                                                    <input name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal" value="{{ $item->sub_pasal }}" {{ $is_approved->isEmpty() ? "" : "readonly" }}>
                                                </td>
                                                <td>
                                                    <p hidden>{{ $item->uraian }}</p>
                                                    <input name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan" value="{{ $item->uraian }}" {{ $is_approved->isEmpty() ? "" : "readonly" }}>
                                                </td>
                                                <td>
                                                    <p hidden>{{ $item->pic }}</p>
                                                    <input name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function" value="{{ $item->pic }}" {{ $is_approved->isEmpty() ? "" : "readonly" }}>
                                                </td>
                                                <td>
                                                    <p hidden>{{ $item->catatan }}</p>
                                                    <input name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan" value="{{ $item->catatan }}" {{ $is_approved->isEmpty() ? "" : "readonly" }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <!--end::Row Nama Proyek-->
                                        <!--begin::Row Nama Proyek-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Nama Proyek</b></label>
                                                <input type="hidden" class="form-control form-control-solid" name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Nama Proyek">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Lokasi Proyek-->

                                        <!--begin::Row Lokasi Proyek-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Lokasi Proyek</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Lokasi Proyek">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Lokasi Proyek-->
        
                                        <!--begin::Row Nama Pemilik Proyek-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Nama Pemilik Proyek</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Nama Pemilik Proyek">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Nama Pemilik Proyek-->
                                        
                                        <!--begin::Row Nama dan Alamat Engineer/Konsultan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Nama dan Alamat Engineer/Konsultan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Nama dan Alamat Engineer/Konsultan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Nama dan Alamat Engineer/Konsultan-->
                                        
                                        <!--begin::Row Ruang Lingkup-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Ruang Lingkup</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Ruang Lingkup">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Ruang Lingkup-->

                                        <!--begin::Row Nilai Pugu/HPS-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Nilai Pugu/HPS (jika ada)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Nilai Pugu/HPS (jika ada)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Nilai Pugu/HPS-->

                                        <!--begin::Row Sumber Dana-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Sumber Dana</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Sumber Dana">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Sumber Dana-->

                                        <!--begin::Row Jenis Kontrak-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jenis Kontrak</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jenis Kontrak">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jenis Kontrak-->

                                        <!--begin::Row Hirarki Dokumen-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hirarki Dokumen</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hirarki Dokumen">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hirarki Dokumen-->

                                        <!--begin::Row Waktu Penyelesaisan Pekerjaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Waktu Penyelesaisan Pekerjaan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Waktu Penyelesaisan Pekerjaan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Waktu Penyelesaisan Pekerjaan-->

                                        <!--begin::Row Jangka Waktu Masa Pemeliharaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jangka Waktu Masa Pemeliharaan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jangka Waktu Masa Pemeliharaan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jangka Waktu Masa Pemeliharaan-->

                                        <!--begin::Row Jangka Waktu Masa Performa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jangka Waktu Masa Performa (jika ada)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jangka Waktu Masa Performa (jika ada)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jangka Waktu Masa Performa-->

                                        <!--begin::Row Hukum dan Bahasa yang Berlaku-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hukum dan Bahasa yang Berlaku</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hukum dan Bahasa yang Berlaku">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hukum dan Bahasa yang Berlaku-->

                                        <!--begin::Row Cara Pembayaran-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Cara Pembayaran</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Cara Pembayaran">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Cara Pembayaran-->
                                        
                                        <!--begin::Row Dokumen Syarat Pembayaran-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Dokumen Syarat Pembayaran</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Dokumen Syarat Pembayaran">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Dokumen Syarat Pembayaran-->

                                        <!--begin::Row Uang Muka-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Uang Muka</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Uang Muka">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Uang Muka-->

                                        <!--begin::Row Hak dan Kewajiban Pengguna Jasa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hak dan Kewajiban Pengguna Jasa</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hak dan Kewajiban Pengguna Jasa">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hak dan Kewajiban Pengguna Jasa-->

                                        <!--begin::Row Hak dan Kewajiban Penyedia Jasa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hak dan Kewajiban Penyedia Jasa</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hak dan Kewajiban Penyedia Jasa">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hak dan Kewajiban Penyedia Jasa-->

                                        <!--begin::Row Akses ke Lokasi/Lapangan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Akses ke Lokasi/Lapangan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Akses ke Lokasi/Lapangan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Akses ke Lokasi/Lapangan-->

                                        <!--begin::Row Serah Terima Lahan/Lokasi Pekerjaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Serah Terima Lahan/Lokasi Pekerjaan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Serah Terima Lahan/Lokasi Pekerjaan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Serah Terima Lahan/Lokasi Pekerjaan-->

                                        <!--begin::Row Jaminan Uang Muka-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jaminan Uang Muka</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jaminan Uang Muka">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jaminan Uang Muka-->

                                        <!--begin::Row Pengembalian Uang Muka-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Pengembalian Uang Muka</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Pengembalian Uang Muka">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Pengembalian Uang Muka-->

                                        <!--begin::Row Jaminan Pelaksanaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jaminan Pelaksanaan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jaminan Pelaksanaan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jaminan Pelaksanaan-->

                                        <!--begin::Row Retensi-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Retensi</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Retensi">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Retensi-->

                                        <!--begin::Row Jaminan Pemeliharaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jaminan Pemeliharaan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jaminan Pemeliharaan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jaminan Pemeliharaan-->

                                        <!--begin::Row Jaminan Performa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Jaminan Performa (jika ada)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Jaminan Performa (jika ada)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Jaminan Performa-->

                                        <!--begin::Row Asuransi-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Asuransi (CAR/CECR)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Asuransi (CAR/CECR)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Asuransi-->

                                        <!--begin::Row Serah Terima Pekerjaan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Serah Terima Pekerjaan (parsial/tidak)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Serah Terima Pekerjaan (parsial/tidak)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Serah Terima Pekerjaan-->

                                        <!--begin::Row Pembayaran Material On Site-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Pembayaran Material On Site (jika ada)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Pembayaran Material On Site (jika ada)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Pembayaran Material On Site-->

                                        <!--begin::Row Denda/Sanksi-->
                                        <tr>
                                            <th colspan="5" style="color: rgb(76, 76, 76);">
                                                <b>Denda/Sanksi</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><b>a. Keterlambatan Pekerjaan</b></small>
                                            </td>
                                            <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Denda/Sanksi - Keterlambatan Pekerjaan">
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><b>b. Keterlambatan Pembayaran</b></small>
                                            </td>
                                            <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Denda/Sanksi - Keterlambatan Pembayaran">
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Denda/Sanksi-->

                                        <!--begin::Row Peristiwa Kompensasi/Klaim-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Peristiwa Kompensasi/Klaim</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Peristiwa Kompensasi/Klaim">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Peristiwa Kompensasi/Klaim-->

                                        <!--begin::Row Variasi/Tambah Kurang-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Variasi/Tambah Kurang</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Variasi/Tambah Kurang">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Variasi/Tambah Kurang-->

                                        <!--begin::Row Perpanjangan Waktu (EOT)-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Perpanjangan Waktu (EOT)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Perpanjangan Waktu (EOT)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Perpanjangan Waktu (EOT)-->

                                        <!--begin::Row Penyesuaian Harga (Eskalasi)-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Penyesuaian Harga (Eskalasi)</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Penyesuaian Harga (Eskalasi)">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Penyesuaian Harga (Eskalasi)-->

                                        <!--begin::Row TKDN-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>TKDN</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="TKDN">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row TKDN-->

                                        <!--begin::Row Hak Pemutusan Kontrak atau Penghentian Pekerjaan oleh Penyedia Jasa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hak Pemutusan Kontrak atau Penghentian Pekerjaan oleh Penyedia Jasa</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hak Pemutusan Kontrak atau Penghentian Pekerjaan oleh Penyedia Jasa">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hak Pemutusan Kontrak atau Penghentian Pekerjaan oleh Penyedia Jasa-->

                                        <!--begin::Row Hak Penundaan Pekerjaan oleh Penyedia Jasa-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Hak Penundaan Pekerjaan oleh Penyedia Jasa</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Hak Penundaan Pekerjaan oleh Penyedia Jasa">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Hak Penundaan Pekerjaan oleh Penyedia Jasa-->

                                        <!--begin::Row Penyelesaian Perselisihan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Penyelesaian Perselisihan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Penyelesaian Perselisihan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Penyelesaian Perselisihan-->

                                        <!--begin::Row Kegagalan Bangunan-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Kegagalan Bangunan</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Kegagalan Bangunan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Kegagalan Bangunan-->

                                        <!--begin::Row Force Majeure/Keadaan Kahar-->
                                        <tr class="text-grey">
                                            <td>
                                                <label><b>Force Majeure/Keadaan Kahar</b></label>
                                                <input type="hidden" class="form-control form-control-solid" {{ $is_approved->isEmpty() ? "" : "readonly" }} name="kategori[]" {{ $is_approved->isEmpty() ? "" : "readonly" }} value="Force Majeure/Keadaan Kahar">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="sub-pasal[]" type="text" class="form-control form-control-solid" placeholder="Isi Sub Pasal">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="uraian[]" type="text" class="form-control form-control-solid" placeholder="Isi Uraian / Penjelasan">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="pic[]" type="text" class="form-control form-control-solid" placeholder="Isi PIC Cross Function">
                                            </td>
                                            <td>
                                                <input {{ $is_approved->isEmpty() ? "" : "readonly" }} name="catatan[]" type="text" class="form-control form-control-solid" placeholder="Isi Catatan">
                                            </td>
                                        </tr>
                                        <!--end::Row Force Majeure/Keadaan Kahar-->
                                    @endif

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <div class="align-items-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                </div>
                        </form>
                    </div>
                    <!--end::Table-->
                    <!--end:::Tab Forecast Retail-->

            </div>
            <!--end::Card body-->

        </div>
        <!--end::Content-->

    </div>
    <!--end::Contacts App- Edit Contact-->

@endsection

@section('js-script')
<!--begin::Data Tables-->

<script>
    function exportToExcel(e, tableElt) {
        // console.log(e.parentElement);
        document.querySelector(`${tableElt}_wrapper .buttons-excel`).click();
        return;
    }
</script>

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
            $('#tinjauan-kontrak').DataTable( {
                // dom: 'Bfrtip',
                dom: 'Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data Tinjauan Dokumen Kontrak'
                    },
                    
                    ]
            } );
        });
    </script>
@endsection
