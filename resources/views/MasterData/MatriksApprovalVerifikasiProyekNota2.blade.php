{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Matriks Approval Verifikasi Proyek Nota 2')
{{-- End::Title --}}

<!--begin::Main-->
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Matriks Approval Verifikasi Proyek Nota 2
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @canany(['super-admin'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#kt_modal_input_matriks_approval" data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">Tambah</a>

                                </div>
                                <!--end::Actions-->                                
                            @endcanany
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
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Nama Pegawai</th>
                                        <th class="min-w-100px">Unit Kerja</th>
                                        <th class="min-w-100px">Kode Unit Kerja</th>
                                        <th class="min-w-auto">Departemen</th>
                                        {{-- <th class="min-w-auto">Klasifikasi Proyek</th> --}}
                                        <th class="min-w-auto">Kategori</th>
                                        <th class="min-w-auto text-white">Start Periode</th>
                                        <th class="min-w-auto text-white">Finish Periode</th>
                                        <th class="min-w-auto">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    // $companies = $companies->reverse();
                                    $no = 1;
                                @endphp
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($matriks_all as $approval)
                                        @php
                                            switch($approval->start_bulan){
                                            case "1":
                                            $start_bulan = "Januari"."-".$approval->start_tahun;
                                            break;
                                            case "2":
                                            $start_bulan = "Februari"."-".$approval->start_tahun;
                                            break;
                                            case "3":
                                            $start_bulan = "Maret"."-".$approval->start_tahun;
                                            break;
                                            case "4":
                                            $start_bulan = "April"."-".$approval->start_tahun;
                                            break;
                                            case "5":
                                            $start_bulan = "Mei"."-".$approval->start_tahun;
                                            break;
                                            case "6":
                                            $start_bulan = "Juni"."-".$approval->start_tahun;
                                            break;
                                            case "7":
                                            $start_bulan = "Juli"."-".$approval->start_tahun;
                                            break;
                                            case "8":
                                            $start_bulan = "Agustus"."-".$approval->start_tahun;
                                            break;
                                            case "9":
                                            $start_bulan = "September"."-".$approval->start_tahun;
                                            break;
                                            case "10":
                                            $start_bulan = "Oktober"."-".$approval->start_tahun;
                                            break;
                                            case "11":
                                            $start_bulan = "November"."-".$approval->start_tahun;
                                            break;
                                            case "12":
                                            $start_bulan = "Desember"."-".$approval->start_tahun;
                                            break;
                                            default:
                                            $start_bulan = "-";
                                        }
                                        switch($approval->finish_bulan){
                                            case "1":
                                            $finish_bulan = "Januari"."-".$approval->finish_tahun;
                                            break;
                                            case "2":
                                            $finish_bulan = "Februari"."-".$approval->finish_tahun;
                                            break;
                                            case "3":
                                            $finish_bulan = "Maret"."-".$approval->finish_tahun;
                                            break;
                                            case "4":
                                            $finish_bulan = "April"."-".$approval->finish_tahun;
                                            break;
                                            case "5":
                                            $finish_bulan = "Mei"."-".$approval->finish_tahun;
                                            break;
                                            case "6":
                                            $finish_bulan = "Juni"."-".$approval->finish_tahun;
                                            break;
                                            case "7":
                                            $finish_bulan = "Juli"."-".$approval->finish_tahun;
                                            break;
                                            case "8":
                                            $finish_bulan = "Agustus"."-".$approval->finish_tahun;
                                            break;
                                            case "9":
                                            $finish_bulan = "September"."-".$approval->finish_tahun;
                                            break;
                                            case "10":
                                            $finish_bulan = "Oktober"."-".$approval->finish_tahun;
                                            break;
                                            case "11":
                                            $finish_bulan = "November"."-".$approval->finish_tahun;
                                            break;
                                            case "12":
                                            $finish_bulan = "Desember"."-".$approval->finish_tahun;
                                            break;
                                            default:
                                            $finish_bulan = "-";
                                        }
                                        @endphp
                                        <tr>
                                            {{-- @dump($approval->Departemen) --}}
                                            <td>
                                                <a href="#" class="text-hover-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_matriks_update_{{$approval->id}}">{{$approval->Pegawai->nama_pegawai}}</a>
                                            </td>
                                            <td>{{$approval->Divisi->nama_kantor}}</td>
                                            <td>
                                                {{ $approval->kode_unit_kerja }}
                                            </td>
                                            <td>
                                                @if (!empty($approval->Departemen->nama_departemen))
                                                    <p>{{ $approval->Departemen->nama_departemen }} ({{ $approval->Departemen?->UnitKerja?->unit_kerja }})</p>
                                                @else
                                                    <p></p>
                                                @endif
                                                {{-- {{$approval->Departemen->nama_departemen ?? ""}} --}}
                                            </td>
                                            {{-- <td>{{$approval->klasifikasi_proyek}}</td> --}}
                                            <td>{{$approval->kategori}}</td>
                                            <td class="text-center">{{$start_bulan}}</td>
                                            <td class="text-center">{{$finish_bulan}}</td>
                                            <td class="d-flex flex-column align-items-center gap-2">
                                                {{-- <a href="#kt_modal_edit_{{$approval->id }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a> --}}
                                                <button class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;" onclick="showModal('{{ $approval }}')">Edit</button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_matriks_delete_{{$approval->id}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->



                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--end::Container-->
                    <!--end::Post-->


                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    
    <!--begin::Modal Tambah Kriteria Green Line-->
    <div class="modal fade" id="kt_modal_input_matriks_approval" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Matriks Approval Verifikasi Proyek Nota 2</h2>
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

                <form action="/matriks-approval-varifikasi-proyek/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_input_matriks_approval">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
    
    
                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Start Periode</span>
                                    </label>
                                    @php
                                        $tahun = (int) date("Y");
                                    @endphp
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="bulan_start" name="bulan_start"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                            data-select2-id="select2-bulan-start" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                        <!--end::Input-->
                                        <!--begin::Input-->
                                        <select id="tahun_start" name="tahun_start"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_start" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            @foreach (range(1, 2) as $item)
                                                <option value="{{$tahun}}">{{$tahun}}</option>
                                                @php
                                                    $tahun++;
                                                @endphp
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pegawai</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="nama-pegawai" name="nama-pegawai"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Nama Pegawai..."
                                        data-select2-id="select2-nama-pegawai" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
    
                            <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Unit Kerja</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <div id="kriteria-penilaian-internal">
                                            <select id="unit-kerja" name="unit-kerja"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Unit Kerja..."
                                                data-select2-id="select2-unit-kerja" tabindex="-1" aria-hidden="true" onchange="setDepartemen(this)">
                                                <option value="" selected></option>
                                                @foreach ($divisi_all as $divisi)
                                                    <option value="{{$divisi->id_divisi}}" data-sap="{{ $divisi->kode_sap }}">{{$divisi->nama_kantor}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col">
                                    <div class="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kode Unit Kerja</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="text" name="kode-unit" class="form-control form-control-solid" placeholder="Input Kode Unit Kerja">
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-7" id="div-departemen">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Departemen</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <div id="kriteria-penilaian-internal">
                                            <select id="departemen-proyek" name="departemen"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Departemen"
                                                data-select2-id="select2-unit-kerja" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Klasifikasi Proyek</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="klasifikasi-proyek" name="klasifikasi-proyek"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi Proyek..."
                                            data-select2-id="select2-klasifikasi-proyek" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Proyek Kecil">Proyek Kecil</option>
                                            <option value="Proyek Menengah">Proyek Menengah</option>
                                            <option value="Proyek Besar">Proyek Besar</option>
                                            <option value="Mega Proyek">Mega Proyek</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kategori</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="kategori" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Kategori..."
                                            data-select2-id="select2-kategori" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Request Pengajuan">Request Pengajuan</option>
                                            <option value="Pengajuan">Pengajuan</option>
                                            <option value="Rekomendasi">Rekomendasi</option>
                                            <option value="Persetujuan">Persetujuan</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col">
                                    <div class="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Urutan</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <input type="number" name="urutan" class="form-control form-control-solid" min="1" max="10" placeholder="Input Urutan">
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7 d-none" id="finish-periode">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Finish Periode</span>
                                </label>
                                @php
                                    $tahun = (int) date("Y");
                                @endphp
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="bulan_finish" name="bulan_finish"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                        data-select2-id="select2_bulan_finish" tabindex="-1" aria-hidden="true" disabled>
                                        <option value="" selected></option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Input-->
                                    <select id="tahun_finish" name="tahun_finish"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                        data-select2-id="select2_tahun_finish" tabindex="-1" aria-hidden="true" disabled>
                                        <option value="" selected></option>
                                        @foreach (range(1, 2) as $item)
                                            <option value="{{$tahun}}">{{$tahun}}</option>
                                            @php
                                                $tahun++;
                                            @endphp
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Input group-->
                            <div class="row ms-1">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="create" name="isActive" id="active-periode" onchange="setActive(this)" checked>
                                    <label class="form-check-label" for="active-periode">
                                        Active
                                    </label>
                                </div>
                                <!--End::Input Checkbox-->
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->
    
    
    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>
    
                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal Tambah Kriteria Green Line-->

    @foreach ($matriks_all as $approval)
        <!--begin::Modal Tambah Kriteria Green Line-->
        <div class="modal fade" id="kt_modal_edit_{{ $approval->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Matriks Approval Verifikasi Proyek Nota 2</h2>
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

                    <form action="/matriks-approval-varifikasi-proyek/update" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_edit_{{ $approval->id }}">
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
        
                            <input type="hidden" name="id-matriks-approval" value="{{ $approval->id }}">
                            <!--begin::Row Kanan+Kiri-->
                            <div class="row fv-row">
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Start Periode</span>
                                        </label>
                                        @php
                                            $tahun = (int) date("Y");
                                        @endphp
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="bulan_start_{{ $approval->id }}" name="bulan_start"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                                data-select2-id="select2-bulan-start-{{ $approval->id }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option value="1" {{ $approval->start_bulan == "1" ? "selected" : "" }}>Januari</option>
                                                <option value="2" {{ $approval->start_bulan == "2" ? "selected" : "" }}>Februari</option>
                                                <option value="3" {{ $approval->start_bulan == "3" ? "selected" : "" }}>Maret</option>
                                                <option value="4" {{ $approval->start_bulan == "4" ? "selected" : "" }}>April</option>
                                                <option value="5" {{ $approval->start_bulan == "5" ? "selected" : "" }}>Mei</option>
                                                <option value="6" {{ $approval->start_bulan == "6" ? "selected" : "" }}>Juni</option>
                                                <option value="7" {{ $approval->start_bulan == "7" ? "selected" : "" }}>Juli</option>
                                                <option value="8" {{ $approval->start_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                                <option value="9" {{ $approval->start_bulan == "9" ? "selected" : "" }}>September</option>
                                                <option value="10" {{ $approval->start_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                                <option value="11" {{ $approval->start_bulan == "11" ? "selected" : "" }}>November</option>
                                                <option value="12" {{ $approval->start_bulan == "12" ? "selected" : "" }}>Desember</option>
                                            </select>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <select id="tahun_start_{{ $approval->id }}" name="tahun_start"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                                data-select2-id="select2_tahun_start_{{ $approval->id }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach (range(1, 2) as $item)
                                                    <option value="{{$tahun}}" {{$approval->start_tahun == $tahun ? "selected" : "" }}>{{$tahun}}</option>
                                                    @php
                                                        $tahun++;
                                                    @endphp
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nama Pegawai</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                            
                                        <select id="nama-pegawai-{{ $approval->id }}" name="nama-pegawai"
                                            class="form-select form-select-solid" data-hide-search="false" data-placeholder="Pilih Nama Pegawai..."aria-hidden="true">
                                            <option value="" selected></option>
                                            {{-- @foreach ($pegawai_all as $nip => $pegawai)
                                                <option value="{{$nip}}" {{ $nip == $approval->nama_pegawai ? 'selected' : '' }}>{{$pegawai}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
        
                                <div class="row mb-7">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Unit Kerja</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <div id="kriteria-penilaian-internal">
                                                <select id="unit-kerja-{{ $approval->id }}" name="unit-kerja"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Unit Kerja..."
                                                    data-select2-id="select2-unit-kerja-{{ $approval->id }}" tabindex="-1" aria-hidden="true" onchange="setDepartemen(this, '{{ $approval->id }}')">
                                                    <option value="" selected></option>
                                                    @foreach ($divisi_all as $divisi)
                                                        <option value="{{$divisi->id_divisi}}" {{ $divisi->id_divisi == (int)$approval->divisi_id ? 'selected' : '' }} data-sap="{{ $divisi->kode_sap }}">{{$divisi->nama_kantor}}</option>
                                                    @endforeach
                                                    {{-- @foreach ($sumber_danas as $sd)
                                                        <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-7">
                                    <div class="col">
                                        <div class="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Kode Unit Kerja</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="kode-unit" class="form-control form-control-solid" placeholder="Input Kode Unit Kerja" value="{{ $approval->kode_unit_kerja }}">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-7" id="div-departemen">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Departemen</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <div id="kriteria-penilaian-internal">
                                                <select id="departemen-proyek-{{ $approval->id }}" name="departemen"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Departemen"
                                                    data-select2-id="select2-departemen-{{ $approval->id }}" tabindex="-1" aria-hidden="true">
                                                    <option value=""></option>
                                                    {{-- @foreach ($departemens as $departemen)
                                                        <option value="{{$departemen->kode_departemen}}" {{ $departemen->kode_departemen == $approval->departemen_code ? 'selected' : '' }}>{{$departemen->nama_departemen}} ({{ $departemen->UnitKerja->unit_kerja ?? "-" }})</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row mb-7">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Klasifikasi Proyek</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <select id="klasifikasi-proyek-{{ $approval->id }}" name="klasifikasi-proyek"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi Proyek..."
                                                data-select2-id="select2-klasifikasi-proyek-{{ $approval->id }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Proyek Kecil" {{ $approval->klasifikasi_proyek == "Proyek Kecil" ? 'selected' : '' }}>Proyek Kecil</option>
                                                <option value="Proyek Menengah" {{ $approval->klasifikasi_proyek == "Proyek Menengah" ? 'selected' : '' }}>Proyek Menengah</option>
                                                <option value="Proyek Besar" {{ $approval->klasifikasi_proyek == "Proyek Besar" ? 'selected' : '' }}>Proyek Besar</option>
                                                <option value="Mega Proyek" {{ $approval->klasifikasi_proyek == "Mega Proyek" ? 'selected' : '' }}>Mega Proyek</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row mb-7">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Kategori</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <select id="kategori-{{$approval->id  }}" name="kategori"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Kategori..."
                                                data-select2-id="select2-kategori-{{ $approval->id }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Request Pengajuan" {{ $approval->kategori == "Request Pengajuan" ? 'selected' : '' }}>Request Pengajuan</option>
                                                <option value="Pengajuan" {{ $approval->kategori == "Pengajuan" ? 'selected' : '' }}>Pengajuan</option>
                                                <option value="Rekomendasi" {{ $approval->kategori == "Rekomendasi" ? 'selected' : '' }}>Rekomendasi</option>
                                                <option value="Persetujuan" {{ $approval->kategori == "Persetujuan" ? 'selected' : '' }}>Persetujuan</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col">
                                        <div class="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Urutan</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="number" name="urutan" class="form-control form-control-solid" min="1" max="10" placeholder="Input Urutan" value="{{ $approval->urutan }}">
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7 d-none" id="finish-periode-edit-{{ $approval->id }}">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Finish Periode</span>
                                    </label>
                                    @php
                                        $tahun = (int) date("Y");
                                    @endphp
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="bulan_finish_{{ $approval->id }}" name="bulan_finish"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                            data-select2-id="select2_bulan_finish_{{ $approval->id }}" tabindex="-1" aria-hidden="true" disabled>
                                            <option value="" selected></option>
                                            <option value="1" {{ $approval->finish_bulan == "1" ? "selected" : "" }}>Januari</option>
                                            <option value="2" {{ $approval->finish_bulan == "2" ? "selected" : "" }}>Februari</option>
                                            <option value="3" {{ $approval->finish_bulan == "3" ? "selected" : "" }}>Maret</option>
                                            <option value="4" {{ $approval->finish_bulan == "4" ? "selected" : "" }}>April</option>
                                            <option value="5" {{ $approval->finish_bulan == "5" ? "selected" : "" }}>Mei</option>
                                            <option value="6" {{ $approval->finish_bulan == "6" ? "selected" : "" }}>Juni</option>
                                            <option value="7" {{ $approval->finish_bulan == "7" ? "selected" : "" }}>Juli</option>
                                            <option value="8" {{ $approval->finish_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                            <option value="9" {{ $approval->finish_bulan == "9" ? "selected" : "" }}>September</option>
                                            <option value="10" {{ $approval->finish_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                            <option value="11" {{ $approval->finish_bulan == "11" ? "selected" : "" }}>November</option>
                                            <option value="12" {{ $approval->finish_bulan == "12" ? "selected" : "" }}>Desember</option>
                                        </select>
                                        <!--end::Input-->
                                        <!--begin::Input-->
                                        <select id="tahun_finish_{{ $approval->id }}" name="tahun_finish"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_finish_{{ $approval->id }}" tabindex="-1" aria-hidden="true" disabled>
                                            <option value="" selected></option>
                                            @foreach (range(1, 2) as $item)
                                                <option value="{{$tahun}}" {{ $approval->finish_tahun == $tahun ? "selected" : "" }}>{{$tahun}}</option>
                                                @php
                                                    $tahun++;
                                                @endphp
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="row ms-1">
                                    <!--Begin::Input Checkbox-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="edit" name="isActive" id="active-periode" onchange="setActive(this, '{{ $approval->id }}')" {{ $approval->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active-periode">
                                            Active
                                        </label>
                                    </div>
                                    <!--End::Input Checkbox-->
                                </div>
                            </div>
                            <!--End::Row Kanan+Kiri-->
        
        
        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                                style="background-color:#008CB4">Save</button>
        
                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal Tambah Kriteria Green Line-->
    @endforeach
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 

    <!--begin::modal DELETE-->
    @foreach ($matriks_all as $approval)
        <form action="/matriks-approval-varifikasi-proyek/delete" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id-matriks-approval" value="{{$approval->id}}">
            <div class="modal fade" id="kt_modal_matriks_delete_{{ $approval->id  }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $approval->Pegawai->nama_pegawai }}</h2>
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
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-danger min-w-100px fs-6">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#kt_modal_matriks_update_{{ $approval->id  }} select").select2({
                    dropdownParent: $('#kt_modal_matriks_update_{{ $approval->id  }}'),
                });
            });
        </script>
    @endforeach
    <!--end::modal DELETE-->
      
    
    <script>
        $('#example').DataTable({
            dom: '<"float-start"f><"#example"t>rtip',
            pageLength : 50,
            stateSave: true,
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    const perPage = 10;
    $(document).ready(function() {
        $("#nama-pegawai").select2({
            ajax: {
                url: '/proyek/get-data-pegawai',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        perPage: perPage,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1

                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                    const optionData = isPagination ? data.data : data;
                    const options = optionData.map(item => {
                        return {
                            id: item.nip, 
                            text: item.nama_pegawai
                        }
                    })
                    return {
                        results: options,
                        pagination: {
                            more: isPagination ? (params.page * (perPage || 10)) < data.total : false
                        }
                    }
                },
                cache: true,
                minimumResultsForSearch: 0
            },
            dropdownParent: $('#kt_modal_input_matriks_approval'),
        });
        $("#unit-kerja, #klasifikasi-proyek, #kategori").select2({
            dropdownParent: $('#kt_modal_input_matriks_approval'),
        })
    });

    function setActive(e, id = null) {
        if (e.value == "create") {
            const elementFinish = document.querySelector('#finish-periode');
            if(e.checked){
                elementFinish.classList.add('d-none');
                elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
            }else{
                elementFinish.classList.remove('d-none');
                elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
            }
        } else {
            const elementFinish = document.querySelector(`#finish-periode-edit-${id}`);
            if(e.checked){
                elementFinish.classList.add('d-none');
                elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
            }else{
                console.log(elementFinish);
                elementFinish.classList.remove('d-none');
                elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
            }    
        }
    }
</script>
<script>
    async function setDepartemen(e, id=null){
        const data = e.options[e.selectedIndex].getAttribute('data-sap');
        // console.log(data);
        let html = '<option value=""></option>'
        // console.log(data)
        if(data == 'A141' || data == 'A142' || data == 'A151' || data == 'A161'){
            // document.getElementById("div-departemen").style.visibility ='
            let departemenElt;

            if (id != null) {
                departemenElt = document.querySelector(`#departemen-proyek-${id}`);
            }else{
                departemenElt = document.getElementById("departemen-proyek");
            }

            const response = await fetch(`/proyek/get-departemen/${data}`, {
                method: 'GET',
            }).then(result => result.json())
            // console.log(response.data);
            response.data.forEach(data => {
                html += `<option value="${data.kode_departemen}">${data.nama_departemen}</option>`
            });
            
            departemenElt.innerHTML = html;
        }else{
            document.getElementById("div-departemen").style.value = null;
        }
    }
</script>
<script>
    function showModal(approval) {
        const approvalData = JSON.parse(approval);
        let modal = document.getElementById('kt_modal_edit_' + approvalData.id);

        $(modal).modal('show');

        let select2 = document.getElementById('nama-pegawai-' + approvalData.id);

        $(select2).select2({
            ajax: {
                url: '/proyek/get-data-pegawai',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        perPage: perPage,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1

                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                    const optionData = isPagination ? data.data : data;
                    const options = optionData.map(item => {
                        return {
                            id: item.nip, 
                            text: item.nama_pegawai
                        }
                    })
                    return {
                        results: options,
                        pagination: {
                            more: isPagination ? (params.page * (perPage || 10)) < data.total : false
                        }
                    }
                },
                cache: true,
                minimumResultsForSearch: 0
            },
            dropdownParent: $(modal)
        });

        const newOption = new Option(
            approvalData.pegawai?.nama_pegawai, 
            approvalData.pegawai?.nip, 
            true, 
            true
        )
        $(select2).append(newOption).trigger('change')
        $(select2).trigger({
            type: 'select2:select',
            params: {
                data: approvalData.pegawai?.nip
            }
        })

        $(`#unit-kerja-${approvalData.id}`).select2({
            dropdownParent: $(modal)
        });

        $(`#departemen-proyek-${approvalData.id}`).select2({
            dropdownParent: $(modal)
        })

        // $(`#departemen-proyek-${approvalData.id}`).select2({
        //     ajax: {
        //         url: `/get-data-divisi/${approvalData.divisi_id}`,
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function (data, params) {
        //             const parseData = data.map(item => {
        //                 return {
        //                     id : item.kode_departemen,
        //                     text : item.nama_departemen
        //                 }
        //             })
        //             return{
        //                 results:parseData
        //             }
        //         }
        //     },
        //     dropdownParent: $(modal)
        // });
        
        const newOption2 = new Option(
            approvalData.departemen?.nama_departemen, 
            approvalData.departemen?.kode_departemen, 
            true, 
            true
        )
        $(`#departemen-proyek-${approvalData.id}`).append(newOption2).trigger('change');
        $(`#departemen-proyek-${approvalData.id}`).trigger({
            type: 'select2:select',
            params: {
                data: approvalData.departemen?.kode_departemen
            }
        })
    }
</script>
@endsection

<!--end::Main-->
