{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Estimasi')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Estimasi Proyek - {{ $proyek->nama_proyek }}
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            {{-- <a href="{{ asset("estimasi/BoQ Print.xlsx") }}" class="btn btn-sm btn-primary">Print</a> --}}
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
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_data_umum"
                                                style="font-size:14px;">DATA UMUM</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" aria-controls="kt_view_boq_ekstern"
                                                aria-selected="false" href="#kt_view_boq_ekstern"
                                                style="font-size:14px;">BOQ EKSTERN</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="false" href="#kt_view_analisa_harsat"
                                                style="font-size:14px;">ANALISA HARSAT</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="false" href="#kt_view_sumber_daya"
                                                style="font-size:14px;">SUMBER DAYA</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="false" href="#kt_view_pareto_harsat"
                                                style="font-size:14px;">PARETO HARSAT</a>
                                        </li>
                                        <!--end:::Tab item-->
                                        <!--begin:::Tab item-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                                aria-selected="false" href="#kt_view_resume"
                                                style="font-size:14px;">RESUME</a>
                                        </li>
                                        <!--end:::Tab item-->
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

                                <!--Begin :: Tab Pane - Data Umum-->
                                <div class="tab-pane fade show active" id="kt_view_data_umum">
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="data-umum">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">No</th>
                                                <th class="min-w-auto text-white">Kategori</th>
                                                <th class="min-w-500px text-white">Uraian</th>
                                            </tr>
                                            <!--begin::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table Body-->
                                        @php
                                            $no = 1;
                                        @endphp
                                        <tbody>
                                            @foreach ($dataUmumField as $key => $value)
                                                @if (is_array($value))
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $key }}</td>
                                                        <td>
                                                            @foreach ($value as $partner)
                                                                <p>{{ $partner["nama_partner"] }} <span>| Porsi KSO: {{ $partner["porsi_jo"] }}%</span></p>
                                                                <hr>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                    </tr>                                                    
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <!--end::Table Body-->
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Data Umum-->

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
                                                <td><p class="m-0 text-end">108,010,230,787.42</p></td>
                                                <td class="text-center">55.90%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>1 MATERIAL</td>
                                                <td class="text-center">38.90%</td>
                                                <td><p class="m-0 text-end">56,084,762,346.11</p></td>
                                                <td class="text-center">29.03%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>2 UPAH</td>
                                                <td class="text-center">3.53%</td>
                                                <td><p class="m-0 text-end">5,082,634,951.22</p></td>
                                                <td class="text-center">2.63%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>3 ALAT</td>
                                                <td class="text-center">15.76%</td>
                                                <td><p class="m-0 text-end">22,719,446,290.08</p></td>
                                                <td class="text-center">11.76%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>4 SUBKON</td>
                                                <td class="text-center">16.73%</td>
                                                <td><p class="m-0 text-end">24,123,387,200.00</p></td>
                                                <td class="text-center">12.49%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>B</td>
                                                <td>INDIRECT COST</td>
                                                <td class="text-center">7.84%</td>
                                                <td><p class="m-0 text-end">11,300,000,000.00</p></td>
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
                                                <td><p class="m-0 text-end">500,000,000.00</p></td>
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
                                                <td><p class="m-0 text-end">10,800,000,000.00</p></td>
                                                <td class="text-center">5.59%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->  
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>A+B</td>
                                                <td>DIRECT + INDIRECT COST</td>
                                                <td class="text-center">82.75%</td>
                                                <td><p class="m-0 text-end">119,310,230,787.42</p></td>
                                                <td class="text-center">61.75%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->                                        
                                            <!--begin::Table row-->
                                            <tr class="bg-secondary">
                                                <td>C</td>
                                                <td>OTHER COST</td>
                                                <td class="text-center">17.25%</td>
                                                <td><p class="m-0 text-end">24,871,316,991.94</p></td>
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
                                                <td><p class="m-0 text-end">865,089,286.68</p></td>
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
                                                <td><p class="m-0 text-end">720,907,738.90</p></td>
                                                <td class="text-center">0.37%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>4. RESIKO</td>
                                                <td class="text-center">0.50%</td>
                                                <td><p class="m-0 text-end">720,907,738.90</p></td>
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
                                                <td><p class="m-0 text-end">3,820,811,016.15</p></td>
                                                <td class="text-center">1.98%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>8. CSR</td>
                                                <td class="text-center">3.00%</td>
                                                <td><p class="m-0 text-end">4,325,446,433.38</p></td>
                                                <td class="text-center">2.24%</td>
                                                <td></td>
                                            </tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr>
                                                <td></td>
                                                <td>8. MARGIN</td>
                                                <td class="text-center">10.00%</td>
                                                <td><p class="m-0 text-end">14,418,154,777.94</p></td>
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
                                                <td class="text-white"><p class="m-0 text-end">144,181,547,779.36</p></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">PPN(11%)</td>
                                                <td class="text-white">APBN</td>
                                                <td class="text-white"><p class="m-0 text-end">15,859,970,255.73</p></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">TOTAL INCLUDE PPN 11%</td>
                                                <td class="text-white">100.00%</td>
                                                <td class="text-white"><p class="m-0 text-end">160,041,518,000.00</p></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-primary">
                                                <td></td>
                                                <td class="text-white">PERKIRAAN HPS (INCLUDE PPN)</td>
                                                <td class="text-white">100%</td>
                                                <td class="text-white"><p class="m-0 text-end">193,216,866,700.00</p></td>
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
                                <div class="tab-pane fade" id="kt_view_analisa_harsat">
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
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Pareto-->

                                <!--Begin :: Tab Pane - Pareto-->
                                <div class="tab-pane fade" id="kt_view_pareto_harsat">
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
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!--End :: Tab Pane - Pareto-->

                                <!--Begin :: Tab Pane - Perhitungan-->
                                <div class="tab-pane fade" id="kt_view_boq_ekstern" role="tabpanel">
                                    <form action="/estimasi-proyek/detail/{{ $proyek->kode_proyek }}/edit" method="post" enctype="multipart/form-data" onsubmit="addLoading(this)">
                                        @csrf
                                        
                                        <div class="d-flex flex-row justify-content-end gap-3 my-5">
                                            <a href="{{ asset('dokumen-boq/Template BOQ.xlsx') }}" class="btn btn-primary">Download Template BOQ</a>
                                            @if ($proyek->BoqDetail->isEmpty())
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_kt_upload_boq">Upload BOQ</button>
                                            @else
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            @endif
                                        </div>
            
            
                                        <!--begin::Table-->
                                        <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                    <th class="min-w-auto text-white" rowspan="2">Kode BOQ</th>
                                                    <th class="min-w-auto text-white" rowspan="2">Kode Tahap (Parent)</th>
                                                    <th class="min-w-auto text-white" rowspan="2">Kode Tahap (Child)</th>
                                                    <th class="min-w-450px text-white" rowspan="2">Uraian Pekerjaan</th>
                                                    <th class="min-w-auto text-white" rowspan="2">Satuan</th>
                                                    <th class="min-w-auto text-white" rowspan="2">Volume</th>
                                                    <th class="min-w-auto text-white" rowspan="2">Action</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600" id="body-table">
                                                @foreach ($dataDetailBOQ as $data)
                                                    <tr>
                                                        <td>-</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="kode_tahap[]" value="{{ $data->kode_tahap }}">
                                                            <input type="hidden" name="index[]" value="{{ $data->id }}">
                                                        </td>
                                                        <td>-</td>
                                                        <td>{{ $data->uraian_pekerjaan }}</td>
                                                        <td class="text-center">{{ $data->satuan }}</td>
                                                        <td class="text-end">{{ number_format($data->volume, 0, ',', '.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </form>
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
                            <form action="/estimasi-proyek/upload" method="post" enctype="multipart/form-data" onsubmit="addLoading(this)">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Upload BOQ</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">                                    
                                        <div class="mb-3">
                                            <label for="konstanta" class="form-label" class="required">Upload</label>
                                            <input type="hidden" name="kode_proyek" value="{{ $dataUmumField['KODE PROYEK'] }}">
                                            <input type="file" class="form-control" id="file" name="file" value="" accept=".xlsx">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="save-pilihan" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>                            
                            </form>
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
            elt.form.submit();
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
    </script>
@endsection

<!--end::Main-->
