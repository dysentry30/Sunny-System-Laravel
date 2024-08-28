{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'RAB Proyek Detail')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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
                                <h1 class="d-flex align-items-center fs-3 my-1">RAB Proyek - {{ $proyek->nama_proyek }}
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <a href="{{ asset("estimasi/BoQ Print.xlsx") }}" class="btn btn-sm btn-primary">Print</a>
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 py-2">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                    class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_resume"
                                                style="font-size:14px;">Resume</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_pareto"
                                                style="font-size:14px;">Pareto</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                        <!--begin:::Tab item Claim-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_perhitungan"
                                                style="font-size:14px;">Perhitungan</a>
                                        </li>
                                        <!--end:::Tab item Claim-->
                                    </ul>

                                </div>
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="overflow-scroll card-body pt-0 ">
                            <!--Begin :: Tab Content-->
                            <div id="tab-content" class="tab-content">

                                <!--Begin :: Tab Pane - Resuma-->
                                <div class="tab-pane fade" id="kt_view_resume">
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example2">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">No</th>
                                                <th class="min-w-450px text-white">Uraian</th>
                                                <th class="min-w-auto text-white">Bobot (%)</th>
                                                <th class="min-w-auto text-white">Total Harga</th>
                                                <th class="min-w-auto text-white">Bobot (%) THD Pagu/HPS</th>
                                                <th class="min-w-auto text-white">Keterangan</th>
                                            </tr>
                                            <!--begin::Table row-->
                                        </thead>
                                        <tbody>
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>A</td>
                                                <td>DIRECT COST</td>
                                                <td class="text-center">74.91%</td>
                                                <td>108,010,230,787.42</td>
                                                <td class="text-center">55.90%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1 MATERIAL</td>
                                                <td class="text-center">38.90%</td>
                                                <td>56,084,762,346.11</td>
                                                <td class="text-center">29.03%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2 UPAH</td>
                                                <td class="text-center">3.53%</td>
                                                <td>5,082,634,951.22</td>
                                                <td class="text-center">2.63%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3 ALAT</td>
                                                <td class="text-center">15.76%</td>
                                                <td>22,719,446,290.08</td>
                                                <td class="text-center">11.76%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>4 SUBKON</td>
                                                <td class="text-center">16.73%</td>
                                                <td>24,123,387,200.00</td>
                                                <td class="text-center">12.49%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>B</td>
                                                <td>INDIRECT COST</td>
                                                <td class="text-center">7.84%</td>
                                                <td>11,300,000,000.00</td>
                                                <td class="text-center">5.85%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1. SEKERTARIAT</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2. FASILITAS</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3. PERSONALIA</td>
                                                <td class="text-center"></td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->                                            
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3.1 PERSONIL PROYEK</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->                                            
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3.2 PERSONIL DIVISI</td>
                                                <td class="text-center">0.35%</td>
                                                <td>500,000,000.00</td>
                                                <td class="text-center">0.26%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->  
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>4. KEUANGAN</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>5. KENDARAAN</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->                                          
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>6. UMU</td>
                                                <td class="text-center">7.49%</td>
                                                <td>10,800,000,000.00</td>
                                                <td class="text-center">5.59%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->  
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>A+B</td>
                                                <td>DIRECT + INDIRECT COST</td>
                                                <td class="text-center">82.75%</td>
                                                <td>119,310,230,787.42</td>
                                                <td class="text-center">61.75%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->                                        
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>C</td>
                                                <td>OTHER COST</td>
                                                <td class="text-center">17.25%</td>
                                                <td>24,871,316,991.94</td>
                                                <td class="text-center">12.87%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1 GENERAL</td>
                                                <td class="text-center"></td>
                                                <td></td>
                                                <td class="text-center"></td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.1 CONSTRUCTION INSURANCE</td>
                                                <td class="text-center"></td>
                                                <td></td>
                                                <td class="text-center"></td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.1.1 ASURANSI CAR</td>
                                                <td class="text-center">0.60%</td>
                                                <td>865,089,286.68</td>
                                                <td class="text-center">0.45%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.1.2 JAMSOSTEK KONSTRUKSI</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.1.3 ASURANSI LAINNYA</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.2 OTHER</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center"></td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.2.1 PSL</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1.2.2 PERSIAPAN</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2 QSHE</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center"></td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2.1 SAFETY</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2.2 HEALTH</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2.3 ENVIRONMENT</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3. PEMELIHARAAN</td>
                                                <td class="text-center">0.50%</td>
                                                <td>720,907,738.90</td>
                                                <td class="text-center">0.37%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>4. RESIKO</td>
                                                <td class="text-center">0.50%</td>
                                                <td>720,907,738.90</td>
                                                <td class="text-center">0.37%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>5. ALOKASI BIAYA BUNGA </td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>6. PAJAK PENGHASILAN (PAJAK ATAS BILLING RATE)</td>
                                                <td class="text-center"></td>
                                                <td>-</td>
                                                <td class="text-center">0.00%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>7. BEBAN PPH FINAL</td>
                                                <td class="text-center">2.65%</td>
                                                <td>3,820,811,016.15</td>
                                                <td class="text-center">1.98%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>8. CSR</td>
                                                <td class="text-center">3.00%</td>
                                                <td>4,325,446,433.38</td>
                                                <td class="text-center">2.24%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>8. MARGIN</td>
                                                <td class="text-center">10.00%</td>
                                                <td>14,418,154,777.94</td>
                                                <td class="text-center">7.46%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">TOTAL OK</td>
                                                <td class="text-white">100%</td>
                                                <td class="text-white">144,181,547,779.36</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">PPN(11%)</td>
                                                <td class="text-white">APBN</td>
                                                <td class="text-white">15,859,970,255.73</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">TOTAL INCLUDE PPN 11%</td>
                                                <td class="text-white">100.00%</td>
                                                <td class="text-white">160,041,518,000.00</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">PERKIRAAN HPS (INCLUDE PPN)</td>
                                                <td class="text-white">100%</td>
                                                <td class="text-white">193,216,866,700.00</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">PROSENTASE OK TERHADAP HPS</td>
                                                <td class="text-white">100%</td>
                                                <td class="text-white">82.83%</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Resuma-->

                                <!--Begin :: Tab Pane - Pareto-->
                                <div class="tab-pane fade" id="kt_view_pareto">
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example2">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">Kode Sumber Daya</th>
                                                <th class="min-w-450px text-white">Uraian</th>
                                                <th class="min-w-auto text-white">Satuan</th>
                                                <th class="min-w-auto text-white">Volume</th>
                                                <th class="min-w-auto text-white">Harga Satuan</th>
                                                <th class="min-w-auto text-white">Jumlah</th>
                                                <th class="min-w-auto text-white">Bobot</th>
                                                <th class="min-w-auto text-white">Bobot Kumulatif</th>
                                            </tr>
                                            <!--begin::Table row-->
                                        </thead>
                                        <tbody>
                                            @foreach ($masterSumberDaya as $sumber_daya)
                                                <tr>
                                                    <td class="text-center">{{ $sumber_daya->kode_sumber_daya }}</td>
                                                    <td class="text-start">{{ $sumber_daya->uraian }}</td>
                                                    <td class="text-center">{{ $sumber_daya->satuan }}</td>
                                                    <td class="text-center">{{ $sumber_daya->volume }}</td>
                                                    <td class="text-center">{{ number_format($sumber_daya->harga_satuan, 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ number_format($sumber_daya->jumlah, 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ $sumber_daya->bobot }} %</td>
                                                    <td class="text-center">{{ $sumber_daya->bobot_kumulatif }} %</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Pareto-->

                                <!--Begin :: Tab Pane - Perhitungan-->
                                <div class="tab-pane fade show active" id="kt_view_perhitungan" role="tabpanel">
                                    <div class="d-flex flex-row justify-content-end gap-3 my-5">
                                        <button type="button" class="btn btn-primary" onclick="tambahTahap()">Tambah Tahap</button>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_kt_upload_boq">Upload BOQ</button>
                                    </div>
        
        
                                    <!--begin::Table-->
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white" rowspan="2">Kode</th>
                                                <th class="min-w-auto text-white" rowspan="2">Kode Parent</th>
                                                <th class="min-w-450px text-white" rowspan="2">Uraian Pekerjaan</th>
                                                <th class="min-w-auto text-white" rowspan="2">Satuan</th>
                                                <th class="min-w-auto text-white" rowspan="2">Volume</th>
                                                <th class="min-w-auto text-white" colspan="3">Internal</th>
                                                <th class="min-w-auto text-white" colspan="2">External</th>
                                                <th class="min-w-auto text-white" rowspan="2">Action</th>
                                            </tr>
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-150px text-white">Harga Satuan</th>
                                                <th class="min-w-150px text-white">Total Harga Satuan</th>
                                                <th class="min-w-auto text-white">Index</th>
                                                <th class="min-w-150px text-white">Harga Satuan</th>
                                                <th class="min-w-150px text-white">Total Harga Satuan</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600" id="body-table" style="display: none">
                                            <tr class="bg-secondary" id="kategori">
                                                <td>DC</td>
                                                <td></td>
                                                <td>Direct Cost</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm showModal" id="button-plus-boq-1" style="display: none">+</button>
                                                </td>
                                            </tr>
                                            <tr id="tahapan-1">
                                                <td>DC0001</td>
                                                <td>DC</td>
                                                <td>Pekerjaan Tanah</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm showModal" id="button-plus-boq-2" style="display: none">+</button>
                                                </td>
                                            </tr>
                                            <tr id="boq-1">
                                                <td id="kode-boq-1">DC0001001</td>
                                                <td id="kode-parent-boq">DC0001</td>
                                                <td id="uraian-boq">Galian Tanah Biasa Mekanik digunakan sebagai Timbunan Biasa dengan jarak 0 - 4000 m</td>
                                                <td id="satuan-boq" class="text-center">M3</td>
                                                <td id="volume-boq" class="text-end">861,636</td>
                                                <td id="harsat-internal-boq" class="text-end"></td>
                                                <td id="total-harsat-internal-boq" class="text-end"></td>
                                                <td id="index-internal-boq"></td>
                                                <td id="harsat-eksternal-boq" class="text-end"></td>
                                                <td id="total-harsat-eksternal-boq" class="text-end"></td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm showModal" id="button-plus-boq-3" data-boq="parent-boq-1">+</button>
                                                </td>
                                            </tr>
                                            <tr id="tahapan-2">
                                                <td>DC0002</td>
                                                <td>DC</td>
                                                <td>Pekerjaan Pengecoran</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm showModal" id="button-plus-boq-4" style="display: none">+</button>
                                                </td>
                                            </tr>
                                            <tr id="boq-2">
                                                <td id="kode-boq-2">DC0002001</td>
                                                <td id="kode-parent-boq">DC0002</td>
                                                <td id="uraian-boq">Beton fc = 25 Mpa</td>
                                                <td id="satuan-boq" class="text-center">M3</td>
                                                <td id="volume-boq" class="text-end">26,749</td>
                                                <td id="harsat-internal-boq" class="text-end"></td>
                                                <td id="total-harsat-internal-boq" class="text-end"></td>
                                                <td id="index-internal-boq"></td>
                                                <td id="harsat-eksternal-boq" class="text-end"></td>
                                                <td id="total-harsat-eksternal-boq" class="text-end"></td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm showModal" id="button-plus-boq-5" data-boq="parent-boq-2">+</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--Begin :: Tab Pane - Perhitungan-->
                            </div>

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->

                    <!-- Begin::Modal -->
                    <div class="modal fade" id="kt_modal_add_ahs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="kt_modal_approvedLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Tambah AHS</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select id="ahs" name="ahs" class="form-select form-select-solid" data-hide-search="false" data-placeholder="Pilh AHS" aria-hidden="true">
                                        <option value="" selected></option>
                                        @foreach ($masterAHS as $ahs)
                                            <option value="{{ $ahs->kode_ahs }}">{{ $ahs->uraian }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" data-id-parent="" data-index-row="" data-kode-parent="" data-parent-boq-select="" onclick="savePilihan(this)">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_kt_upload_boq" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_upload_boq" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Upload BOQ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                    
                                    <div class="mb-3">
                                        <label for="konstanta" class="form-label" class="required">Upload</label>
                                        <input type="file" class="form-control" id="file" value="" accept=".xlsx">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" onclick="uploadBOQ(this)">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <!-- End::Modal -->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

@endsection

@section('js-script')
    <!--end::Javascript-->
    <script>
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })

        $(document).ready(function(){
            $("#ahs").select2({
                dropdownParent: $("#kt_modal_add_ahs")
            });
            showingModal();
        });

        function addLoading(elt) {
            LOADING_BODY.block();
            return true;
        }

        function showingModal() {
            let totalButton = document.querySelectorAll(".showModal");
            for (let i = 0; i < totalButton.length; i++) {
                totalButton[i].addEventListener('click', function() {
                    $('#kt_modal_add_ahs').modal('show');
                    const buttonSave = document.getElementById("save-pilihan");
                    let parentBOQ = totalButton[i].getAttribute("data-boq");

                    let indexBOQ = parentBOQ.split("-")[2];
                    
                             
                    buttonSave.setAttribute("data-id-parent", totalButton[i].getAttribute("id"));
                    buttonSave.setAttribute("data-parent-boq-select", indexBOQ);
                    buttonSave.setAttribute("data-index-row", i);
                    buttonSave.setAttribute("data-kode-parent", totalButton[i].parentElement.parentElement.firstElementChild.innerHTML);
                })
            }            
        }

        async function savePilihan(elt) {
            LOADING_BODY.block();
            const buttonModalSelect = document.getElementById(elt.getAttribute("data-id-parent"));
            const optionSelected = elt.parentElement?.previousElementSibling?.firstElementChild?.value;
            const indexBOQSelected = elt.getAttribute("data-parent-boq-select");

            const parentBOQSelected = document.getElementById(`boq-${indexBOQSelected}`);

            const req = await fetch(`{{ url('/get-detail-ahs/${optionSelected}') }}`, {
                method: 'GET',
            }).then(res => res.json());            

            let table = document.getElementById("example").getElementsByTagName('tbody')[0];
            let totalRow = table.children.length;
            
            let newRow = table.insertRow(parseInt(elt.getAttribute("data-index-row")) + 1);
            newRow.id = `ahs-boq-${indexBOQSelected}`

            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);
            let cell3 = newRow.insertCell(2);
            let cell4 = newRow.insertCell(3);
            let cell5 = newRow.insertCell(4);
            let cell6 = newRow.insertCell(5);
            let cell7 = newRow.insertCell(6);
            let cell8 = newRow.insertCell(7);
            let cell9 = newRow.insertCell(8);
            let cell10 = newRow.insertCell(9);
            let cell11 = newRow.insertCell(10);

            cell1.innerHTML = req.kode_ahs;
            cell2.innerHTML = parentBOQSelected.firstElementChild.innerHTML;
            cell3.innerHTML = `<a href="/rab-proyek/detail-ahs/${req.kode_ahs}" class="text-hover-primary text-black" target="_blank">${req.uraian}</a>`;
            cell4.innerHTML = req.satuan;
            cell5.innerHTML = req.volume.toLocaleString();
            cell6.innerHTML = req.harsat.toLocaleString();
            cell7.innerHTML = req.total.toLocaleString();
            cell8.innerHTML = '<input type="number" class="form-control form-control-solid" value="1.3" onkeyup="' + `calculateIndex(this, ${req.harsat_eksternal}, ${req.total_eksternal}, 'boq-${indexBOQSelected}')` + '" />';
            cell9.innerHTML = req.harsat_eksternal.toLocaleString();
            cell10.innerHTML = req.total_eksternal.toLocaleString();
            cell11.innerHTML = `<button class="btn btn-primary btn-sm showModal" id="button-plus-boq-${totalRow + 1}" data-boq="parent-boq-${indexBOQSelected}">+</button>`;
            
            cell6.classList.add("text-end")
            cell7.classList.add("text-end")
            cell8.classList.add("text-center")
            cell9.classList.add("text-end")
            cell10.classList.add("text-end")
            cell11.classList.add("text-center")
            buttonModalSelect.style.display = "none";

            const arrAHS = document.querySelectorAll(`#ahs-boq-${indexBOQSelected}`);
            let totalVolumeBOQ = 0;
            let totalHarsatBOQInternal = 0;
            let totalTotalBOQInternal = 0;
            let totalHarsatBOQEksternal = 0;
            let totalTotalBOQEksternal = 0;

            arrAHS.forEach(element => {
                console.log(element.children[6].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
                          
                totalVolumeBOQ += parseInt(element.children[4].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
                totalHarsatBOQInternal += parseInt(element.children[5].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
                totalTotalBOQInternal += parseInt(element.children[6].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
                totalHarsatBOQEksternal += parseInt(element.children[8].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
                totalTotalBOQEksternal += parseInt(element.children[9].innerHTML.replace(",", "").replace(",", "").replace(",", ""));
            });

            
            parentBOQSelected.children[4].innerHTML = totalVolumeBOQ.toLocaleString();
            parentBOQSelected.children[5].innerHTML = totalHarsatBOQInternal.toLocaleString();
            parentBOQSelected.children[6].innerHTML = totalTotalBOQInternal.toLocaleString();
            parentBOQSelected.children[8].innerHTML = totalHarsatBOQEksternal.toLocaleString();
            parentBOQSelected.children[9].innerHTML = totalTotalBOQEksternal.toLocaleString();

            showingModal();
            LOADING_BODY.release();
        }


        function calculateIndex(elt, harsatEksternal, totalEksternal, indexBOQSelected) {
            let newIndex = Number(elt.value);
            let newHarsatEksternal = Number(harsatEksternal) * newIndex;
            let newTotalEksternal = Number(totalEksternal) * newIndex;

            console.log(indexBOQSelected);
            
            
            elt.parentElement.parentElement.children[8].innerHTML = newHarsatEksternal;
            elt.parentElement.parentElement.children[9].innerHTML = newTotalEksternal;
        }

        function tambahTahap() {

            let table = document.getElementById("example").getElementsByTagName('tbody')[0];
            let totalRow = table.children.length;
            
            
            let newRow = table.insertRow(totalRow);

            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);
            let cell3 = newRow.insertCell(2);
            let cell4 = newRow.insertCell(3);
            let cell5 = newRow.insertCell(4);
            let cell6 = newRow.insertCell(5);
            let cell7 = newRow.insertCell(6);
            let cell8 = newRow.insertCell(7);
            let cell9 = newRow.insertCell(8);
            let cell10 = newRow.insertCell(9);
            let cell11 = newRow.insertCell(10);

            cell1.innerHTML = "DC0003"
            cell2.innerHTML = "DC"
            cell3.innerHTML = "Pekerjaan Lantai 2"
            cell4.innerHTML = ""
            cell5.innerHTML = ""
            cell6.innerHTML = ""
            cell7.innerHTML = ""
            cell8.innerHTML = ""
            cell9.innerHTML = ""
            cell10.innerHTML = ""
            cell11.innerHTML = ""
        }

        function uploadBOQ(elt){
            LOADING_BODY.block();
            setTimeout(() => {
                const bodyTable = document.querySelector("#body-table");
                bodyTable.style.display = "";
                elt.value = "";
                LOADING_BODY.release();
            }, 5000);
        }
    </script>
@endsection

<!--end::Main-->
