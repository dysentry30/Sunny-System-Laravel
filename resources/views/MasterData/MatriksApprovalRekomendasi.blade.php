{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Matriks Approval Rekomendasi')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')
    <!-- begin::DataTables -->
    <link rel="stylesheet" href="datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <!-- end::DataTables -->


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
                                <h1 class="d-flex align-items-center fs-3 my-1">Matriks Approval Rekomendasi
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#kt_modal_input_kriteria_green_line" data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah Matriks Approval Rekomendasi</a>

                                </div>
                                <!--end::Actions-->
                            @endif
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

                                {{-- <!--Begin:: BUTTON FILTER-->
                                <form action="" class="d-flex flex-row w-auto" method="get">
                                    <!--Begin:: Select Options-->
                                    <select id="column" name="column"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                        data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                        aria-hidden="true">
                                        <option {{ $column == '' ? 'selected' : '' }}></option>
                                        <option value="mata_uang" {{ $column == 'mata_uang' ? 'selected' : '' }}>Jenis Proyek</option>

                                    </select>
                                    <!--End:: Select Options-->

                                    <!--begin:: Input Filter-->
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter"
                                            name="filter" value="{{ $filter }}"
                                            class="form-control form-control-solid ms-2 ps-12 w-auto"
                                            placeholder="Input Filter" />
                                    </div>
                                    <!--end:: Input Filter-->

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                    <script>
                                        function resetFilter() {
                                            $("#column").select2({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");

                                            $("#filter").text({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                </form>
                                <!--end:: BUTTON FILTER--> --}}

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
                                        <th class="min-w-auto">Departemen</th>
                                        <th class="min-w-auto">Klasifikasi Proyek</th>
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
                                    @foreach ($approval_rekomendasi as $approval)
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
                                                <a href="#" class="text-hover-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_matriks_update_{{$approval->id_matriks_approval_rekomendasi}}">{{$approval->Pegawai->nama_pegawai}}</a>
                                            </td>
                                            <td>{{$approval->Divisi->nama_kantor}}</td>
                                            <td>
                                                @if (!empty($approval->Departemen->nama_departemen))
                                                    <p>{{ $approval->Departemen->nama_departemen }} ({{ $approval->Departemen->UnitKerja->unit_kerja }})</p>
                                                @else
                                                    <p></p>
                                                @endif
                                                {{-- {{$approval->Departemen->nama_departemen ?? ""}} --}}
                                            </td>
                                            <td>{{$approval->klasifikasi_proyek}}</td>
                                            <td>{{$approval->kategori}}</td>
                                            <td class="text-center">{{$start_bulan}}</td>
                                            <td class="text-center">{{$finish_bulan}}</td>
                                            <td class="d-flex flex-column align-items-center gap-2">
                                                <a href="#kt_modal_edit_{{$approval->id_matriks_approval_rekomendasi }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_matriks_delete_{{$approval->id_matriks_approval_rekomendasi}}">Delete</button>
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
    <div class="modal fade" id="kt_modal_input_kriteria_green_line" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Matriks Approval Rekomendasi</h2>
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

                <form action="/matriks-approval-rekomendasi/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_input_kriteria_green_line">
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
                                        @foreach ($pegawai_all as $pegawai)
                                            <option value="{{$pegawai->nip}}">{{$pegawai->nama_pegawai}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                {{-- <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jabatan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="jabatan" name="jabatan"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Jabatan..."
                                        data-select2-id="select2-jabatan" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{$jabatan->kode_jabatan}}">{{$jabatan->nama_jabatan}}</option>
                                        @endforeach
                                        @foreach ($sumber_danas as $sd)
                                            <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div> --}}
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
                                                data-select2-id="select2-unit-kerja" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($divisi_all as $divisi)
                                                    <option value="{{$divisi->id_divisi}}">{{$divisi->nama_kantor}}</option>
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
                                            <select id="departemen-proyek" name="departemen"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Departemen"
                                                data-select2-id="select2-unit-kerja" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                @foreach ($departemens as $departemen)
                                                    <option value="{{$departemen->kode_departemen}}">{{$departemen->nama_departemen}} ({{ $departemen->UnitKerja->unit_kerja ?? "-" }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-7">
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

                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
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
                                            <option value="Pengajuan">Pengajuan</option>
                                            <option value="Verifikasi">Verifikasi</option>
                                            <option value="Penyusun">Penyusun</option>
                                            <option value="Rekomendasi">Rekomendasi</option>
                                            <option value="Persetujuan">Persetujuan</option>
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
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

    @foreach ($approval_rekomendasi as $approval)
        <!--begin::Modal Tambah Kriteria Green Line-->
    <div class="modal fade" id="kt_modal_edit_{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Edit Matriks Approval Rekomendasi</h2>
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

                <form action="/matriks-approval-rekomendasi/update" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_edit_{{ $approval->id_matriks_approval_rekomendasi }}">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
    
                        <input type="hidden" name="id-matriks-approval" value="{{ $approval->id_matriks_approval_rekomendasi }}">
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
                                        <select id="bulan_start_{{ $approval->id_matriks_approval_rekomendasi }}" name="bulan_start"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                            data-select2-id="select2-bulan-start-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
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
                                        <select id="tahun_start_{{ $approval->id_matriks_approval_rekomendasi }}" name="tahun_start"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_start_{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
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
                                        
                                    <select id="nama-pegawai-{{ $approval->id_matriks_approval_rekomendasi }}" name="nama-pegawai"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Nama Pegawai..."
                                        data-select2-id="select2-nama-pegawai-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        @foreach ($pegawai_all as $pegawai)
                                            <option value="{{$pegawai->nip}}" {{ $pegawai->nip == $approval->nama_pegawai ? 'selected' : '' }}>{{$pegawai->nama_pegawai}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                {{-- <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jabatan</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="jabatan" name="jabatan"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Jabatan..."
                                        data-select2-id="select2-jabatan" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{$jabatan->kode_jabatan}}">{{$jabatan->nama_jabatan}}</option>
                                        @endforeach
                                        @foreach ($sumber_danas as $sd)
                                            <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div> --}}
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
                                            <select id="unit-kerja-{{ $approval->id_matriks_approval_rekomendasi }}" name="unit-kerja"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Unit Kerja..."
                                                data-select2-id="select2-unit-kerja-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($divisi_all as $divisi)
                                                    <option value="{{$divisi->id_divisi}}" {{ $divisi->id_divisi == $approval->unit_kerja }}>{{$divisi->nama_kantor}}</option>
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
                                            <select id="departemen-proyek-{{ $approval->id_matriks_approval_rekomendasi }}" name="departemen"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Departemen"
                                                data-select2-id="select2-departemen-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                @foreach ($departemens as $departemen)
                                                    <option value="{{$departemen->kode_departemen}}" {{ $departemen->kode_departemen == $approval->departemen ? 'selected' : '' }}>{{$departemen->nama_departemen}} ({{ $departemen->UnitKerja->unit_kerja ?? "-" }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Klasifikasi Proyek</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="klasifikasi-proyek-{{ $approval->id_matriks_approval_rekomendasi }}" name="klasifikasi-proyek"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi Proyek..."
                                            data-select2-id="select2-klasifikasi-proyek-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Proyek Kecil" {{ $approval->klasifikasi_proyek == "Proyek Kecil" ? 'selected' : '' }}>Proyek Kecil</option>
                                            <option value="Proyek Menengah" {{ $approval->klasifikasi_proyek == "Proyek Menengah" ? 'selected' : '' }}>Proyek Menengah</option>
                                            <option value="Proyek Besar" {{ $approval->klasifikasi_proyek == "Proyek Besar" ? 'selected' : '' }}>Proyek Besar</option>
                                            <option value="Mega Proyek" {{ $approval->klasifikasi_proyek == "Mega Proyek" ? 'selected' : '' }}>Mega Proyek</option>

                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kategori</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="kategori-{{$approval->id_matriks_approval_rekomendasi  }}" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Kategori..."
                                            data-select2-id="select2-kategori-{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Pengajuan" {{ $approval->kategori == "Pengajuan" ? 'selected' : '' }}>Pengajuan</option>
                                            <option value="Verifikasi" {{ $approval->kategori == "Verifikasi" ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="Penyusun" {{ $approval->kategori == "Penyusun" ? 'selected' : '' }}>Penyusun</option>
                                            <option value="Rekomendasi" {{ $approval->kategori == "Rekomendasi" ? 'selected' : '' }}>Rekomendasi</option>
                                            <option value="Persetujuan" {{ $approval->kategori == "Persetujuan" ? 'selected' : '' }}>Persetujuan</option>
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group Website-->
                            <div class="fv-row mb-7 d-none" id="finish-periode-edit-{{ $approval->id_matriks_approval_rekomendasi }}">
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
                                    <select id="bulan_finish_{{ $approval->id_matriks_approval_rekomendasi }}" name="bulan_finish"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Bulan..."
                                        data-select2-id="select2_bulan_finish_{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true" disabled>
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
                                    <select id="tahun_finish_{{ $approval->id_matriks_approval_rekomendasi }}" name="tahun_finish"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                        data-select2-id="select2_tahun_finish_{{ $approval->id_matriks_approval_rekomendasi }}" tabindex="-1" aria-hidden="true" disabled>
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
                                    <input class="form-check-input" type="checkbox" value="edit" name="isActive" id="active-periode" onchange="setActive(this, '{{ $approval->id_matriks_approval_rekomendasi }}')" {{ $approval->is_active ? 'checked' : '' }}>
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
    @foreach ($approval_rekomendasi as $approval)
        <form action="/matriks-approval-rekomendasi/delete" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id-matriks-approval" value="{{$approval->id_matriks_approval_rekomendasi}}">
            <div class="modal fade" id="kt_modal_matriks_delete_{{ $approval->id_matriks_approval_rekomendasi  }}" tabindex="-1" aria-hidden="true">
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
                $("#kt_modal_matriks_update_{{ $approval->id_matriks_approval_rekomendasi  }} select").select2({
                    dropdownParent: $('#kt_modal_matriks_update_{{ $approval->id_matriks_approval_rekomendasi  }}'),
                });
            });
        </script>
    @endforeach
    <!--end::modal DELETE-->
    
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}
    
    
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
     function changeSelectView(e) {
         const value = e.value;
        if(value == "Internal") {
            document.querySelector("#kriteria-penilaian-internal").style.display = "";
            document.querySelector("#kriteria-penilaian-eksternal").style.display = "none";

            document.querySelector("#kriteria-penilaian-internal select").removeAttribute("disabled");
            document.querySelector("#kriteria-penilaian-eksternal select").setAttribute("disabled", true);
        } else if(value == "Eksternal") {
            document.querySelector("#kriteria-penilaian-internal").style.display = "none";
            document.querySelector("#kriteria-penilaian-eksternal").style.display = "";
            
            document.querySelector("#kriteria-penilaian-internal select").setAttribute("disabled", true);
            document.querySelector("#kriteria-penilaian-eksternal select").removeAttribute("disabled");
        } else if(value == "Piutang") {
            document.querySelector("#piutang").style.display = "";
            document.querySelector("#bowheer-bermasalah").style.display = "none";
            document.querySelector("#key-client").style.display = "none";
            document.querySelector("#industry-attractive").style.display = "none";
            document.querySelector("#top-100").style.display = "none";
            document.querySelector("#rating").style.display = "none";

            document.querySelector("#piutang select").removeAttribute("disabled");
            document.querySelector("#bowheer-bermasalah select").setAttribute("disabled", true);
            document.querySelector("#key-client select").setAttribute("disabled", true);
            document.querySelector("#industry-attractive select").setAttribute("disabled", true);
            document.querySelector("#top-100 select").setAttribute("disabled", true);
            document.querySelector("#rating select").setAttribute("disabled", true);
        } else if(value == "Bowheer Bermasalah") {
            document.querySelector("#piutang").style.display = "none";
            document.querySelector("#bowheer-bermasalah").style.display = "";
            document.querySelector("#key-client").style.display = "none";
            document.querySelector("#industry-attractive").style.display = "none";
            document.querySelector("#top-100").style.display = "none";
            document.querySelector("#rating").style.display = "none";

            document.querySelector("#piutang select").setAttribute("disabled", true);
            document.querySelector("#bowheer-bermasalah select").removeAttribute("disabled");
            document.querySelector("#key-client select").setAttribute("disabled", true);
            document.querySelector("#industry-attractive select").setAttribute("disabled", true);
            document.querySelector("#top-100 select").setAttribute("disabled", true);
            document.querySelector("#rating select").setAttribute("disabled", true);
        } else if(value == "Key Client") {
            document.querySelector("#piutang").style.display = "none";
            document.querySelector("#bowheer-bermasalah").style.display = "none";
            document.querySelector("#key-client").style.display = "";
            document.querySelector("#industry-attractive").style.display = "none";
            document.querySelector("#top-100").style.display = "none";
            document.querySelector("#rating").style.display = "none";
            
            document.querySelector("#piutang select").setAttribute("disabled", true);
            document.querySelector("#bowheer-bermasalah select").setAttribute("disabled", true);
            document.querySelector("#key-client select").removeAttribute("disabled");
            document.querySelector("#industry-attractive select").setAttribute("disabled", true);
            document.querySelector("#top-100 select").setAttribute("disabled", true);
            document.querySelector("#rating select").setAttribute("disabled", true);
        } else if(value == "Industry Attractive") {
            document.querySelector("#piutang").style.display = "none";
            document.querySelector("#bowheer-bermasalah").style.display = "none";
            document.querySelector("#key-client").style.display = "none";
            document.querySelector("#industry-attractive").style.display = "";
            document.querySelector("#top-100").style.display = "none";
            document.querySelector("#rating").style.display = "none";

            document.querySelector("#piutang select").setAttribute("disabled", true);
            document.querySelector("#bowheer-bermasalah select").setAttribute("disabled", true);
            document.querySelector("#key-client select").setAttribute("disabled", true);
            document.querySelector("#industry-attractive select").removeAttribute("disabled");
            document.querySelector("#top-100 select").setAttribute("disabled", true);
            document.querySelector("#rating select").setAttribute("disabled", true);
        } else if(value == "Top 100 Perusahan Besar di Indonesia") {
            document.querySelector("#piutang").style.display = "none";
            document.querySelector("#bowheer-bermasalah").style.display = "none";
            document.querySelector("#key-client").style.display = "none";
            document.querySelector("#industry-attractive").style.display = "none";
            document.querySelector("#top-100").style.display = "";
            document.querySelector("#rating").style.display = "none";

            document.querySelector("#piutang select").setAttribute("disabled", true);
            document.querySelector("#bowheer-bermasalah select").setAttribute("disabled", true);
            document.querySelector("#key-client select").setAttribute("disabled", true);
            document.querySelector("#industry-attractive select").setAttribute("disabled", true);
            document.querySelector("#top-100 select").removeAttribute("disabled");
            document.querySelector("#rating select").setAttribute("disabled", true);
        } else if(value == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
            document.querySelector("#piutang").style.display = "none";
            document.querySelector("#bowheer-bermasalah").style.display = "none";
            document.querySelector("#key-client").style.display = "none";
            document.querySelector("#industry-attractive").style.display = "none";
            document.querySelector("#top-100").style.display = "none";
            document.querySelector("#rating").style.display = "";

            document.querySelector("#piutang select").setAttribute("disabled", true);
            document.querySelector("#bowheer-bermasalah select").setAttribute("disabled", true);
            document.querySelector("#key-client select").setAttribute("disabled", true);
            document.querySelector("#industry-attractive select").setAttribute("disabled", true);
            document.querySelector("#top-100 select").setAttribute("disabled", true);
            document.querySelector("#rating select").removeAttribute("disabled");
        }
    }
    $(document).ready(function() {
        // $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $("#nama-pegawai, #unit-kerja, #klasifikasi-proyek, #kategori").select2({
            dropdownParent: $('#kt_modal_input_kriteria_green_line'),
        });
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
@endsection

<!--end::Main-->
