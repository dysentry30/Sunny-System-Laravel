{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Detail AHS')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Detail AHS
                                </h1>
                                <!--end::Title-->
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <button class="btn btn-sm btn-success" onclick="calculateTotal()">Calculate</button>
                                <button class="btn btn-sm btn-primary">Save</button>
                            </div>
                            <!--end::Page title-->
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
                                <div class="row my-5">
                                    <div class="col">
                                        <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="title-table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                    <th class="min-w-auto text-white">Kategori</th>
                                                    <th class="min-w-400px text-white">Uraian</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Kode AHS</td>
                                                    <td>{{ $ahs->kode_ahs }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama AHS</td>
                                                    <td>{{ $ahs->uraian }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total Harga</td>
                                                    <td id="total-harga-ahs"><p class="m-0 text-end">{{ number_format($total, 0, ',', '.') }}</p></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Volume BOQ</td>
                                                    <td id="total-volume-boq"><p class="m-0 text-end">530.194,79</p></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Harga BOQ</td>
                                                    <td id="total-harga-boq"><p class="m-0 text-end">49.187,50</p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Card title-->
                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">
                            <br>
                            <div id="material" class="mt-5">
                                <h3>Material</h3>
                                <div class="d-flex flex-row justify-content-end mb-3">
                                    <button type="button" class="btn btn-primary btn-sm">Tambah</button>
                                </div>
    
    
                                <!--begin::Table-->
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">Kode Sumber Daya</th>
                                            <th class="min-w-auto text-white">Nama Sumber Daya</th>
                                            <th class="min-w-auto text-white">Satuan</th>
                                            <th class="min-w-auto text-white">Koef</th>
                                            <th class="min-w-auto text-white">Volume</th>
                                            <th class="min-w-auto text-white">Harga Satuan</th>
                                            <th class="min-w-auto text-white">Total</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($materials as $material)
                                            <tr class="{{ $material->kode_sumber_daya }}" id="kategori">
                                                <td class="text-center">{{ $material->kode_sumber_daya }}</td>
                                                <td class="">{{ $material->MasterSumberDaya->uraian }}</td>
                                                <td class="text-center">{{ $material->MasterSumberDaya->satuan }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="text-hover-primary text-black" data-bs-toggle="modal" data-bs-target="#modal_kt_waste">{{ $material->koef }}</a>
                                                </td>
                                                <td class="text-center">{{ !empty($material->MasterHargaSatuan?->volume) ? number_format($material->MasterHargaSatuan->volume, 0, ',', '.') : "-" }}</td>
                                                <td class="text-end">{{ !empty($material->MasterHargaSatuan?->harga) ? number_format($material->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                                <td class="text-end">{{ !empty($material->MasterHargaSatuan?->harga) && !empty($material->MasterHargaSatuan?->volume) ? number_format((int)$material->MasterHargaSatuan->volume * (int)$material->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table footer-->
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td colspan="6" class="ps-2 text-white"><p class="m-0"><b>Total</b></p></td>
                                            {{-- <td class="text-center text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($materials->sum(function($material){
                                                            if (!empty($material->MasterHargaSatuan?->volume)) {
                                                                return (int) $material->MasterHargaSatuan->volume;
                                                            }else{
                                                                return 0;
                                                            }
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                            <td class="text-end text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($materials->sum(function($material){
                                                            if (!empty($material->MasterHargaSatuan?->harga)) {
                                                                return (int) $material->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                        
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td> --}}
                                            <td class="text-end text-white pe-2">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($materials->sum(function($material){
                                                            if (!empty($material->MasterHargaSatuan?->harga) && !empty($material->MasterHargaSatuan?->volume)) {
                                                                return (int)$material->MasterHargaSatuan->volume * (int)$material->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                    
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table footer-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <br>
                            <div id="upah" class="mt-5">
                                <h3>Upah</h3>
                                <div class="d-flex flex-row justify-content-end mb-3">
                                    <button type="button" class="btn btn-primary btn-sm">Tambah</button>
                                </div>
    
    
                                <!--begin::Table-->
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">Kode Sumber Daya</th>
                                            <th class="min-w-auto text-white">Nama Sumber Daya</th>
                                            <th class="min-w-auto text-white">Satuan</th>
                                            <th class="min-w-auto text-white">Koef</th>
                                            <th class="min-w-auto text-white">Volume</th>
                                            <th class="min-w-auto text-white">Harga Satuan</th>
                                            <th class="min-w-auto text-white">Total</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($upahs as $upah)
                                            <tr class="" id="kategori">
                                                <td class="text-center">{{ $upah->kode_sumber_daya }}</td>
                                                <td class="">{{ $upah->MasterSumberDaya->uraian }}</td>
                                                <td class="text-center">{{ $upah->MasterSumberDaya->satuan }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="text-hover-primary text-black" data-bs-toggle="modal" data-bs-target="#modal_kt_upah">{{ $upah->koef }}</a>
                                                </td>
                                                <td class="text-center">{{ !empty($upah->MasterHargaSatuan?->volume) ? number_format($upah->MasterHargaSatuan->volume, 0, ',', '.') : "-" }}</td>
                                                <td class="text-end">{{ !empty($upah->MasterHargaSatuan?->harga) ? number_format($upah->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                                <td class="text-end">{{ !empty($upah->MasterHargaSatuan?->harga) && !empty($upah->MasterHargaSatuan?->volume) ? number_format((int)$upah->MasterHargaSatuan->volume * (int)$upah->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table footer-->
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td colspan="6" class="ps-2 text-white"><p class="m-0"><b>Total</b></p></td>
                                            {{-- <td class="text-center text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($upahs->sum(function($upah){
                                                            if (!empty($upah->MasterHargaSatuan?->volume)) {
                                                                return (int) $upah->MasterHargaSatuan->volume;
                                                            }else{
                                                                return 0;
                                                            }
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                            <td class="text-end text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($upahs->sum(function($upah){
                                                            if (!empty($upah->MasterHargaSatuan?->harga)) {
                                                                return (int) $upah->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                        
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td> --}}
                                            <td class="text-end text-white pe-2">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($upahs->sum(function($upah){
                                                            if (!empty($upah->MasterHargaSatuan?->harga) && !empty($upah->MasterHargaSatuan?->volume)) {
                                                                return (int)$upah->MasterHargaSatuan->volume * (int)$upah->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                    
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table footer-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <br>
                            <div id="alat" class="mt-5">
                                <h3>Alat</h3>
                                <div class="d-flex flex-row justify-content-end mb-3">
                                    <button type="button" class="btn btn-primary btn-sm">Tambah</button>
                                </div>
    
    
                                <!--begin::Table-->
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">Kode Sumber Daya</th>
                                            <th class="min-w-auto text-white">Nama Sumber Daya</th>
                                            <th class="min-w-auto text-white">Satuan</th>
                                            <th class="min-w-auto text-white">Koef</th>
                                            <th class="min-w-auto text-white">Volume</th>
                                            <th class="min-w-auto text-white">Harga Satuan</th>
                                            <th class="min-w-auto text-white">Total</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($alats as $alat)
                                            <tr class="" id="kategori">
                                                <td class="text-center">{{ $alat->kode_sumber_daya }}</td>
                                                <td class="">{{ $alat->MasterSumberDaya->uraian }}</td>
                                                <td class="text-center">{{ $alat->MasterSumberDaya->satuan }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="text-hover-primary text-black" data-bs-toggle="modal" data-bs-target="{{ $alat->kode_sumber_daya == "D3716000" ? '#modal_kt_alat' : "#modal_kt_alat_2" }}">{{ $alat->koef }}</a>
                                                </td>
                                                <td class="text-center">{{ !empty($alat->MasterHargaSatuan?->volume) ? number_format($alat->MasterHargaSatuan->volume, 0, ',', '.') : "-" }}</td>
                                                <td class="text-end">{{ !empty($alat->MasterHargaSatuan?->harga) ? number_format($alat->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                                <td class="text-end">{{ !empty($alat->MasterHargaSatuan?->harga) && !empty($alat->MasterHargaSatuan?->volume) ? number_format((int)$alat->MasterHargaSatuan->volume * (int)$alat->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table footer-->
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td colspan="6" class="ps-2 text-white"><p class="m-0"><b>Total</b></p></td>
                                            {{-- <td class="text-center text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($alats->sum(function($alat){
                                                            if (!empty($alat->MasterHargaSatuan?->volume)) {
                                                                return (int) $alat->MasterHargaSatuan->volume;
                                                            }else{
                                                                return 0;
                                                            }
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                            <td class="text-end text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($alats->sum(function($alat){
                                                            if (!empty($alat->MasterHargaSatuan?->harga)) {
                                                                return (int) $alat->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                        
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td> --}}
                                            <td class="text-end text-white pe-2">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($alats->sum(function($alat){
                                                            if (!empty($alat->MasterHargaSatuan?->harga) && !empty($alat->MasterHargaSatuan?->volume)) {
                                                                return (int)$alat->MasterHargaSatuan->volume * (int)$alat->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                    
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table footer-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <br>
                            <div id="subkon" class="mt-5">
                                <h3>Subkon</h3>
                                <div class="d-flex flex-row justify-content-end mb-3">
                                    <button type="button" class="btn btn-primary btn-sm">Tambah</button>
                                </div>
    
    
                                <!--begin::Table-->
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">Kode Sumber Daya</th>
                                            <th class="min-w-auto text-white">Nama Sumber Daya</th>
                                            <th class="min-w-auto text-white">Satuan</th>
                                            <th class="min-w-auto text-white">Koef</th>
                                            <th class="min-w-auto text-white">Volume</th>
                                            <th class="min-w-auto text-white">Harga Satuan</th>
                                            <th class="min-w-auto text-white">Total</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($subKons as $subkon)
                                            <tr class="" id="kategori">
                                                <td class="text-center">{{ $subkon->kode_sumber_daya }}</td>
                                                <td class="">{{ $subkon->MasterSumberDaya->uraian }}</td>
                                                <td class="text-center">{{ $subkon->MasterSumberDaya->satuan }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="text-hover-primary text-black" data-bs-toggle="modal" data-bs-target="#modal_kt_subkon">{{ $subkon->koef }}</a>
                                                </td>
                                                <td class="text-center">{{ !empty($subkon->MasterHargaSatuan?->volume) ? number_format($subkon->MasterHargaSatuan->volume, 0, ',', '.') : "-" }}</td>
                                                <td class="text-end">{{ !empty($subkon->MasterHargaSatuan?->harga) ? number_format($subkon->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                                <td class="text-end">{{ !empty($subkon->MasterHargaSatuan?->harga) && !empty($subkon->MasterHargaSatuan?->volume) ? number_format((int)$subkon->MasterHargaSatuan->volume * (int)$subkon->MasterHargaSatuan->harga, 0, ',', '.') : 0 }}</td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    <!--end::Table body-->
                                    <!--begin::Table footer-->
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td colspan="6" class="ps-2 text-white"><p class="m-0"><b>Total</b></p></td>
                                            {{-- <td class="text-center text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($subKons->sum(function($subkon){
                                                            if (!empty($subkon->MasterHargaSatuan?->volume)) {
                                                                return (int) $subkon->MasterHargaSatuan->volume;
                                                            }else{
                                                                return 0;
                                                            }
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                            <td class="text-end text-white">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($subKons->sum(function($subkon){
                                                            if (!empty($subkon->MasterHargaSatuan?->harga)) {
                                                                return (int) $subkon->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                        
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td> --}}
                                            <td class="text-end text-white pe-2">
                                                <p class="m-0">
                                                    <b>
                                                        {{ number_format($subKons->sum(function($subkon){
                                                            if (!empty($subkon->MasterHargaSatuan?->harga) && !empty($subkon->MasterHargaSatuan?->volume)) {
                                                                return (int)$subkon->MasterHargaSatuan->volume * (int)$subkon->MasterHargaSatuan->harga;
                                                            } else {
                                                                return 0;
                                                            }                                                    
                                                        }), 0, ',', '.') }}

                                                    </b>
                                                </p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!--end::Table footer-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->

                    <!-- Begin::Modal -->
                    <div class="modal fade" id="modal_kt_alat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_alat" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Edit Alat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <label class="form-check-label" for="disabledFieldsetCheck">
                                              Is Formula
                                            </label>
                                            <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" onchange="showNilaiProduktivitas(this)" checked>
                                          </div>
                                    </div>
                                    <div class="is-formula-alat">
                                        <div class="mb-3">
                                            <label for="bbm" class="form-label">BBM</label>
                                            <input type="text" class="form-control" id="bbm" value="5">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jarak" class="form-label">Jarak</label>
                                            <input type="text" class="form-control" id="jarak" value="4">
                                        </div>
                                        <div class="mb-3">
                                            <label for="kecepatan" class="form-label">Kecepatan</label>
                                            <input type="text" class="form-control" id="kecepatan" value="20">
                                        </div>
                                        <div class="mb-3">
                                            <label for="muatan" class="form-label">Muatan</label>
                                            <input type="text" class="form-control" id="muatan" value="5">
                                        </div>
                                        <div class="mb-3">
                                            <label for="konstanta" class="form-label">Konstanta</label>
                                            <input type="text" class="form-control" id="konstanta" value="0.8" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="konstanta" class="form-label">Nilai Produktivitas <i class="bi bi-lock"></i></label>
                                            <input type="text" class="form-control" id="konstanta" value="10" readonly>
                                        </div>
                                    </div>
                                    <div class="is-non-formula-alat" style="display: none">
                                        <label for="konstanta" class="form-label">Nilai Produktivitas</label>
                                        <input type="text" class="form-control" id="konstanta" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" data-id-parent="" data-index-row="" data-kode-parent="" data-parent-boq-select="" onclick="savePilihan(this)">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="modal fade" id="modal_kt_alat_2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_alat_2" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Edit Alat</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <label class="form-check-label" for="disabledFieldsetCheck">
                                              Is Formula
                                            </label>
                                            <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" onchange="showNilaiProduktivitas(this)">
                                          </div>
                                    </div>
                                    
                                    <div class="is-formula-alat-2" style="display: none">
                                        <div class="mb-3">
                                            <label for="bbm" class="form-label">BBM</label>
                                            <input type="text" class="form-control" id="bbm" value="5">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jarak" class="form-label">Jarak</label>
                                            <input type="text" class="form-control" id="jarak" value="4">
                                        </div>
                                        <div class="mb-3">
                                            <label for="kecepatan" class="form-label">Kecepatan</label>
                                            <input type="text" class="form-control" id="kecepatan" value="20">
                                        </div>
                                        <div class="mb-3">
                                            <label for="muatan" class="form-label">Muatan</label>
                                            <input type="text" class="form-control" id="muatan" value="5">
                                        </div>
                                        <div class="mb-3">
                                            <label for="konstanta" class="form-label">Konstanta</label>
                                            <input type="text" class="form-control" id="konstanta" value="0.8" readonly>
                                        </div>
                                    </div>
                                    <div class="is-non-formula-alat-2" style="display: ">
                                        <label for="konstanta" class="form-label">Nilai Produktivitas</label>
                                        <input type="text" class="form-control" id="konstanta" value="120">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" data-id-parent="" data-index-row="" data-kode-parent="" data-parent-boq-select="" onclick="savePilihan(this)">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="modal fade" id="modal_kt_waste" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_waste" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Edit Material</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                    
                                    <div class="mb-3">
                                        <label for="konstanta" class="form-label">Nilai Waste</label>
                                        <input type="text" class="form-control" id="konstanta" value="0,14">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" data-id-parent="" data-index-row="" data-kode-parent="" data-parent-boq-select="" onclick="savePilihan(this)">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_kt_material" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_waste" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Edit Material</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                    
                                    <div class="mb-3">
                                        <label for="konstanta" class="form-label">Nilai Waste</label>
                                        <input type="text" class="form-control" id="konstanta" value="1">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="save-pilihan" class="btn btn-primary" data-bs-dismiss="modal" data-id-parent="" data-index-row="" data-kode-parent="" data-parent-boq-select="" onclick="savePilihan(this)">Save</button>
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

        function showNilaiProduktivitas(elt) {
            if (elt.checked) {
                elt.parentElement.parentElement.nextElementSibling.style.display = ""
                elt.parentElement.parentElement.nextElementSibling.nextElementSibling.style.display = "none"
            } else {
                elt.parentElement.parentElement.nextElementSibling.style.display = "none"
                elt.parentElement.parentElement.nextElementSibling.nextElementSibling.style.display = ""
            }
        }

        function calculateTotal(elt){
            LOADING_BODY.block();
            setTimeout(() => {
                LOADING_BODY.release();
                const totalHarga = document.querySelector("#total-harga-boq");
                const totalVolume = document.querySelector("#total-volume-boq");
                Swal.fire({title: "Calculate Berhasil", icon: 'success'}).then(()=>{
                    localStorage.setItem("total-hps", "193.216.866.700");
                    localStorage.setItem("total-harga-boq", "25.423.189.500");
                    localStorage.setItem("total-volume-boq", "861.636");
                    totalHarga.firstElementChild.innerHTML = "25.423.189.500";
                    totalVolume.firstElementChild.innerHTML = "861.636";
                })
            }, 5000);
        }
    </script>
@endsection

<!--end::Main-->
