{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Kriteria Assessment')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Kriteria Assessment
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
                                        Tambah Kriteria Assessment</a>

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
                            <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto ps-5 text-white">Tahun</th>
                                        <th class="min-w-auto text-white">Kategori</th>
                                        <th class="min-w-auto text-white">Kriteria Penilaian</th>
                                        <th class="min-w-auto text-white">Klasifikasi</th>
                                        <th class="min-w-auto text-white">Isi</th>
                                        <th class="min-w-auto text-white">Nilai</th>
                                        <th class="min-w-auto text-white">Start Periode</th>
                                        <th class="min-w-auto text-white">Finish Periode</th>
                                        <th class="min-w-auto text-white text-center">Action</th>
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
                                    @foreach ($kriteria_assessments as $kriteria)
                                            @php
                                                $start_date = "-";
                                                $finish_date = "-";
                                                if(!empty($kriteria->start_bulan) && !empty($kriteria->start_tahun)) {
                                                    $start_date = Carbon\Carbon::createFromFormat("m/Y", $kriteria->start_bulan . "/" . $kriteria->start_tahun)->translatedFormat("F Y");
                                                }
                                                if(!empty($kriteria->finish_bulan) && !empty($kriteria->finish_tahun)) {
                                                    $finish_date = Carbon\Carbon::createFromFormat("m/Y", $kriteria->finish_bulan . "/" . $kriteria->finish_tahun)->translatedFormat("F Y");
                                                }
                                            @endphp
                                            <td class="text-center">{{$kriteria->tahun}}</td>
                                            <td>{{$kriteria->kategori}}</td>
                                            <td>{{$kriteria->kriteria_penilaian}}</td>
                                            <td>{{$kriteria->klasifikasi}}</td>
                                            <td>{{$kriteria->isi}}</td>
                                            <td>{{$kriteria->nilai}}</td>
                                            <td>{{$start_date}}</td>
                                            <td>{{$finish_date}}</td>
                                            <td class="d-flex justify-content-between">
                                                <a href="#kt_modal_edit_{{ $kriteria->id_kriteria_assessment }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a>
                                                <form action="/kriteria-assessment/delete" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id-kriteria" value="{{$kriteria->id_kriteria_assessment }}">
                                                    <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                                </form>
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
                    <h2>Tambah Assessment</h2>
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

                <form action="/kriteria-assessment/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_input_kriteria_green_line">
                    <!--begin::Modal body-->
                    <div class="modal-body py-lg-6 px-lg-6">
    
    
                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <div class="fv-row">
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
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="kategori" name="kategori"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" onchange="changeSelectView(this)" data-hide-search="false" data-placeholder="Pilih Kategori..."
                                        data-select2-id="select2-kategori" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="Internal">Internal</option>
                                        <option value="Eksternal">Eksternal</option>
                                        {{-- @foreach ($instansi as $ins)
                                            <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                        @endforeach --}}
                                        {{-- @foreach ($sumber_danas as $sd)
                                            <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                        @endforeach --}}
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
    
                            <div class="row">
                                <div class="col">
                                    <div id="tier">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kriteria Penilaian</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <div id="kriteria-penilaian-internal">
                                            <select id="kriteria-penilaian-internal-select" onchange="changeSelectView(this)" name="kriteria-penilaian[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Kriteria Penilaian..."
                                                data-select2-id="select2-kriteria-penilaian-internal-select" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Piutang">Piutang</option>
                                                <option value="Bowheer Bermasalah">Bowheer Bermasalah</option>
                                                <option value="Key Client">Key Client</option>
                                                
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="kriteria-penilaian-eksternal" style="display: none;">
                                            <select id="kriteria-penilaian-eksternal-select" onchange="changeSelectView(this)" name="kriteria-penilaian[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Kriteria Penilaian..."
                                                data-select2-id="select2-kriteria-penilaian-eksternal-select" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Industry Attractive">Industry Attractive</option>
                                                <option value="Top 100 Perusahan Besar di Indonesia">Top 100 Perusahan Besar di Indonesia</option>
                                                <option value="Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia">Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia</option>
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select id="klasifikasi" name="klasifikasi"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi..."
                                        data-select2-id="select2-klasifikasi" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        
                                        {{-- @foreach ($instansi as $ins)
                                            <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                        @endforeach --}}
                                        {{-- @foreach ($sumber_danas as $sd)
                                            <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                        @endforeach --}}
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Isi</span>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <div id="piutang">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-piutang" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Tidak Ada Piutang">Tidak Ada Piutang</option>
                                            <option value="Piutang < 3 Bulan">Piutang < 3 Bulan</option>
                                            <option value="Piutang > 3 Bulan">Piutang > 3 Bulan</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input-->
                                    <div id="bowheer-bermasalah" style="display: none">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-bowheer-bermasalah" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Tidak Berperkara Dengan WIKA">Tidak Berperkara Dengan WIKA</option>
                                            <option value="Ada Perkara, WIKA Menang">Ada Perkara, WIKA Menang</option>
                                            <option value="Ada Perkara, WIKA Kalah">Ada Perkara, WIKA Kalah</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input-->
                                    <div id="key-client" style="display: none">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-key-client" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Perusahaan menjadi bagian Key Client">Perusahaan menjadi bagian Key Client</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input-->
                                    <div id="industry-attractive" style="display: none">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-industry-attractive" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Menarik">Menarik</option>
                                            <option value="Cenderung Menarik">Cenderung Menarik</option>
                                            <option value="Netral">Netral</option>
                                            <option value="Cenderung Waspada">Cenderung Waspada</option>
                                            <option value="Waspada">Waspada</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input-->
                                    <div id="top-100" style="display: none">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-top-100" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Perusahaan berada pada urutan 1-50">Perusahaan berada pada urutan 1-50</option>
                                            <option value="Perusahaan berada pada urutan 51-100">Perusahaan berada pada urutan 51-100</option>
                                            <option value="Perusahaan tidak berada pada daftar Top Perusahaan">Perusahaan tidak berada pada daftar Top Perusahaan</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Input-->
                                    <div id="rating" style="display: none">
                                        <select id="isi" name="isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-rating" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Perusahaan berada pada urutan 1-50">Perusahaan berada pada urutan 1-50</option>
                                            <option value="Perusahaan berada pada urutan 51-100">Perusahaan berada pada urutan 51-100</option>
                                            <option value="Perusahaan tidak berada pada daftar Rating Perusahaan">Perusahaan tidak berada pada daftar Rating Perusahaan</option>
                                                                                        
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nilai</span>
                                    </label>
                                    <!--end::Label-->
                                    
                                    <!--begin::input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Nilai" name="nilai" id="nilai">
                                    <!--end::input-->
                                </div>
                            </div>

                            <div class="fv-row d-none"  id="finish-periode">
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
                                        data-select2-id="select2_bulan_finish" tabindex="-1" aria-hidden="true">
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
                                        data-select2-id="select2_tahun_finish" tabindex="-1" aria-hidden="true">
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

                            <div class="row ms-1 my-7">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="create" id="active-periode" name="isActive" onchange="setActive(this)" checked>
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

    @foreach ($kriteria_assessments as $kriteria)
        <!--begin::Modal Edit Kriteria Green Line-->
        <div class="modal fade" id="kt_modal_edit_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Assessment</h2>
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

                    <form action="/kriteria-assessment/update" method="POST">
                        @csrf
                        <input type="hidden" name="id-kriteria" value="{{ $kriteria->id_kriteria_assessment }}">
                        <input type="hidden" name="modal" value="kt_modal_edit_{{ $kriteria->id_kriteria_assessment }}">
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
                                                data-select2-id="select2_bulan_start_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="1" {{ $kriteria->start_bulan == "1" ? "selected" : "" }}>Januari</option>
                                                <option value="2" {{ $kriteria->start_bulan == "2" ? "selected" : "" }}>Februari</option>
                                                <option value="3" {{ $kriteria->start_bulan == "3" ? "selected" : "" }}>Maret</option>
                                                <option value="4" {{ $kriteria->start_bulan == "4" ? "selected" : "" }}>April</option>
                                                <option value="5" {{ $kriteria->start_bulan == "5" ? "selected" : "" }}>Mei</option>
                                                <option value="6" {{ $kriteria->start_bulan == "6" ? "selected" : "" }}>Juni</option>
                                                <option value="7" {{ $kriteria->start_bulan == "7" ? "selected" : "" }}>Juli</option>
                                                <option value="8" {{ $kriteria->start_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                                <option value="9" {{ $kriteria->start_bulan == "9" ? "selected" : "" }}>September</option>
                                                <option value="10" {{ $kriteria->start_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                                <option value="11" {{ $kriteria->start_bulan == "11" ? "selected" : "" }}>November</option>
                                                <option value="12" {{ $kriteria->start_bulan == "12" ? "selected" : "" }}>Desember</option>
                                            </select>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <select id="tahun_start_{{$kriteria->id_kriteria_assessment }}" name="tahun_start"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                                data-select2-id="select2_tahun_start_{{$kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                @foreach (range(1, 2) as $item)
                                                    <option value="{{$tahun}}" {{$kriteria->start_tahun == $tahun ? "selected" : "" }}>{{$tahun}}</option>
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
                                            <span class="required">Kategori</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                            
                                        <select id="kategori_{{ $kriteria->id_kriteria_assessment }}" name="kategori"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" onchange="changeSelectView(this)" data-hide-search="true" data-placeholder="Pilih Kategori..."
                                            data-select2-id="select2-kategori_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            <option value="Internal" {{ $kriteria->kategori == "Internal" ? "selected" : "" }}>Internal</option>
                                            <option value="Eksternal" {{ $kriteria->kategori == "Eksternal" ? "selected" : "" }}>Eksternal</option>
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
        
                                <div class="row">
                                    <div class="col">
                                        <div id="tier">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Kriteria Penilaian</span>
                                            </label>
                                            <!--end::Label-->

                                            @php
                                                $is_kategori_internal = $kriteria->kategori == "Internal" ? "" : "style='display: none'";
                                                $is_kategori_eksternal = $kriteria->kategori == "Eksternal" ? "" : "style='display: none'";
                                            @endphp
                                            
                                            <!--begin::Input-->
                                            <div id="kriteria-penilaian-internal_{{ $kriteria->id_kriteria_assessment }}" {!! $is_kategori_internal !!}>
                                                <select id="kriteria-penilaian-internal-select_{{ $kriteria->id_kriteria_assessment }}" onchange="changeSelectView(this)" name="kriteria-penilaian[]"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Kriteria Penilaian..."
                                                    data-select2-id="select2-kriteria-penilaian-internal-select_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                    <option value=""></option>
                                                    <option value="Piutang" {{ $kriteria->kriteria_penilaian == "Piutang" ? "selected" : "" }}>Piutang</option>
                                                    <option value="Bowheer Bermasalah" {{ $kriteria->kriteria_penilaian == "Bowheer Bermasalah" ? "selected" : "" }}>Bowheer Bermasalah</option>
                                                    <option value="Key Client" {{ $kriteria->kriteria_penilaian == "Key Client" ? "selected" : "" }}>Key Client</option>
                                                    
                                                    {{-- @foreach ($instansi as $ins)
                                                        <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                    @endforeach --}}
                                                    {{-- @foreach ($sumber_danas as $sd)
                                                        <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <!--end::Input-->

                                            <!--begin::Input-->
                                            <div id="kriteria-penilaian-eksternal_{{ $kriteria->id_kriteria_assessment }}" {!! $is_kategori_eksternal !!}>
                                                <select id="kriteria-penilaian-eksternal-select_{{ $kriteria->id_kriteria_assessment }}" onchange="changeSelectView(this)" name="kriteria-penilaian[]"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="false" data-placeholder="Pilih Kriteria Penilaian..."
                                                    data-select2-id="select2-kriteria-penilaian-eksternal-select_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                    <option value=""></option>
                                                    <option value="Industry Attractive" {{ $kriteria->kriteria_penilaian == "Industry Attractive" ? "selected" : "" }}>Industry Attractive</option>
                                                    <option value="Top 100 Perusahan Besar di Indonesia" {{ $kriteria->kriteria_penilaian == "Top 100 Perusahan Besar di Indonesia" ? "selected" : "" }}>Top 100 Perusahan Besar di Indonesia</option>
                                                    <option value="Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia" {{ $kriteria->kriteria_penilaian == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia" ? "selected" : "" }}>Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia</option>
                                                    {{-- @foreach ($instansi as $ins)
                                                        <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                    @endforeach --}}
                                                    {{-- @foreach ($sumber_danas as $sd)
                                                        <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Klasifikasi</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Input-->
                                        <select id="klasifikasi_{{ $kriteria->id_kriteria_assessment }}" name="klasifikasi"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi..."
                                            data-select2-id="select2-klasifikasi_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            <option value="A" {{ $kriteria->klasifikasi == "A" ? "selected" : "" }}>A</option>
                                            <option value="B" {{ $kriteria->klasifikasi == "B" ? "selected" : "" }}>B</option>
                                            <option value="C" {{ $kriteria->klasifikasi == "C" ? "selected" : "" }}>C</option>
                                            
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Isi</span>
                                        </label>
                                        <!--end::Label-->

                                        @php
                                            $is_kriteria_piutang = $kriteria->kriteria_penilaian == "Piutang" ? "" : "style='display: none;'";
                                            $is_kriteria_bowheer = $kriteria->kriteria_penilaian == "Bowheer Bermasalah" ? "" : "style='display: none;'";
                                            $is_kriteria_key_client = $kriteria->kriteria_penilaian == "Key Client" ? "" : "style='display: none;'";
                                            $is_kriteria_industry_attractive = $kriteria->kriteria_penilaian == "Industry Attractive" ? "" : "style='display: none;'";
                                            $is_kriteria_top_100 = $kriteria->kriteria_penilaian == "Top 100 Perusahan Besar di Indonesia" ? "" : "style='display: none;'";
                                            $is_kriteria_rating = $kriteria->kriteria_penilaian == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia" ? "" : "style='display: none;'";
                                            // dump($is_kriteria_piutang, $is_kriteria_bowheer, $is_kriteria_key_client, $is_kriteria_industry_attractive, $is_kriteria_top_100, $is_kriteria_rating);
                                        @endphp
                                        
                                        <!--begin::Input-->
                                        <div id="piutang_{{ $kriteria->id_kriteria_assessment }}" {!! $is_kriteria_piutang !!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" style="display: none" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-piutang_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option value="Tidak Ada Piutang" {{ empty($is_kriteria_piutang) && $kriteria->isi == "Tidak Ada Piutang" ? "selected" : "" }}>Tidak Ada Piutang</option>
                                                <option value="Piutang < 3 Bulan" {{ empty($is_kriteria_piutang) && $kriteria->isi == "Piutang < 3 Bulan" ? "selected" : "" }}>Piutang < 3 Bulan</option>
                                                <option value="Piutang > 3 Bulan" {{ empty($is_kriteria_piutang) && $kriteria->isi == "Piutang > 3 Bulan" ? "selected" : "" }}>Piutang > 3 Bulan</option>
                                                
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="bowheer-bermasalah_{{ $kriteria->id_kriteria_assessment }}" {!! $is_kriteria_bowheer !!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-bowheer-bermasalah_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option value="Tidak Berperkara Dengan WIKA" {{ empty($is_kriteria_bowheer) && $kriteria->isi == "Tidak Berperkara Dengan WIKA" ? "selected" : "" }}>Tidak Berperkara Dengan WIKA</option>
                                                <option value="Ada Perkara, WIKA Menang" {{ empty($is_kriteria_bowheer) && $kriteria->isi == "Ada Perkara, WIKA Menang" ? "selected" : "" }}>Ada Perkara, WIKA Menang</option>
                                                <option value="Ada Perkara, WIKA Kalah" {{ empty($is_kriteria_bowheer) && $kriteria->isi == "Ada Perkara, WIKA Kalah" ? "selected" : "" }}>Ada Perkara, WIKA Kalah</option>
                                                
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="key-client_{{ $kriteria->id_kriteria_assessment }}" {!! $is_kriteria_key_client !!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-key-client_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option value="Perusahaan menjadi bagian Key Client" {{ empty($is_kriteria_key_client) && $kriteria->isi == "Perusahaan menjadi bagian Key Client" ? "selected" : "" }}>Perusahaan menjadi bagian Key Client</option>
                                                
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="industry-attractive_{{ $kriteria->id_kriteria_assessment }}" {!!$is_kriteria_industry_attractive!!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-industry-attractive_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                {{-- <option value="Industri Menarik dan Cenderung Menarik" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Industri Menarik dan Cenderung Menarik" ? "selected" : "" }}>Industri Menarik dan Cenderung Menarik</option>
                                                <option value="Industri Netral dan Cenderung Waspada" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Industri Netral dan Cenderung Waspada" ? "selected" : "" }}>Industri Netral dan Cenderung Waspada</option>
                                                <option value="Industri Waspada" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Industri Waspada" ? "selected" : "" }}>Industri Waspada</option> --}}
                                                <option value="Menarik" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Menarik" ? "selected" : "" }}>Menarik</option>
                                                <option value="Cenderung Menarik" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Cenderung Menarik" ? "selected" : "" }}>Cenderung Menarik</option>
                                                <option value="Netral" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Netral" ? "selected" : "" }}>Netral</option>
                                                <option value="Cenderung Waspada" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Cenderung Waspada" ? "selected" : "" }}>Cenderung Waspada</option>
                                                <option value="Waspada" {{ empty($is_kriteria_industry_attractive) && $kriteria->isi == "Waspada" ? "selected" : "" }}>Waspada</option>
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="top-100" {!! $is_kriteria_top_100 !!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-top-100_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Perusahaan berada pada urutan 1-50" {{ empty($is_kriteria_top_100) && $kriteria->isi == "Perusahaan berada pada urutan 1-50" ? "selected" : "" }}>Perusahaan berada pada urutan 1-50</option>
                                                <option value="Perusahaan berada pada urutan 51-100" {{ empty($is_kriteria_top_100) && $kriteria->isi == "Perusahaan berada pada urutan 51-100" ? "selected" : "" }}>Perusahaan berada pada urutan 51-100</option>
                                                <option value="Perusahaan tidak berada pada daftar Top Perusahaan" {{ empty($is_kriteria_top_100) && $kriteria->isi == "Perusahaan tidak berada pada daftar Top Perusahaan" ? "selected" : "" }}>Perusahaan tidak berada pada daftar Top Perusahaan</option>
                                                
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->

                                        <!--begin::Input-->
                                        <div id="rating" {!! $is_kriteria_rating !!}>
                                            <select id="isi_{{ $kriteria->id_kriteria_assessment }}" name="isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Isi..."
                                                data-select2-id="select2-rating_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="Perusahaan berada pada urutan 1-50" {{ empty($is_kriteria_rating) && $kriteria->isi == "Perusahaan berada pada urutan 1-50" ? "selected" : "" }}>Perusahaan berada pada urutan 1-50</option>
                                                <option value="Perusahaan berada pada urutan 51-100" {{ empty($is_kriteria_rating) && $kriteria->isi == "Perusahaan berada pada urutan 51-100" ? "selected" : "" }}>Perusahaan berada pada urutan 51-100</option>
                                                <option value="Perusahaan tidak berada pada daftar Rating Perusahaan" {{ empty($is_kriteria_rating) && $kriteria->isi == "Perusahaan tidak berada pada daftar Rating Perusahaan" ? "selected" : "" }}>Perusahaan tidak berada pada daftar Rating Perusahaan</option>
                                                                                            
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Nilai</span>
                                        </label>
                                        <!--end::Label-->
                                        
                                        <!--begin::input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="Nilai" value=" {{ $kriteria->nilai }}" name="nilai" id="nilai">
                                        <!--end::input-->
                                    </div>
                                </div>

                                <!--begin::Input group Website-->
                                <div class="fv-row mt-7 {{ $kriteria->is_active ? 'd-none' : '' }}" id="finish-periode-edit-{{ $kriteria->id_kriteria_assessment }}">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Finish Periode</span>
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
                                            data-select2-id="select2_bulan_finish_{{ $kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true" {{ !empty($kriteria->finish_bulan) ? "disabled" : "" }}>
                                            <option value="" selected></option>
                                            <option value="1" {{ $kriteria->finish_bulan == "1" ? "selected" : "" }}>Januari</option>
                                            <option value="2" {{ $kriteria->finish_bulan == "2" ? "selected" : "" }}>Februari</option>
                                            <option value="3" {{ $kriteria->finish_bulan == "3" ? "selected" : "" }}>Maret</option>
                                            <option value="4" {{ $kriteria->finish_bulan == "4" ? "selected" : "" }}>April</option>
                                            <option value="5" {{ $kriteria->finish_bulan == "5" ? "selected" : "" }}>Mei</option>
                                            <option value="6" {{ $kriteria->finish_bulan == "6" ? "selected" : "" }}>Juni</option>
                                            <option value="7" {{ $kriteria->finish_bulan == "7" ? "selected" : "" }}>Juli</option>
                                            <option value="8" {{ $kriteria->finish_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                            <option value="9" {{ $kriteria->finish_bulan == "9" ? "selected" : "" }}>September</option>
                                            <option value="10" {{ $kriteria->finish_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                            <option value="11" {{ $kriteria->finish_bulan == "11" ? "selected" : "" }}>November</option>
                                            <option value="12" {{ $kriteria->finish_bulan == "12" ? "selected" : "" }}>Desember</option>
                                        </select>
                                        <!--end::Input-->
                                        <!--begin::Input-->
                                        <select id="tahun_finish_{{$kriteria->id_kriteria_assessment }}" name="tahun_finish"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_finish_{{$kriteria->id_kriteria_assessment }}" tabindex="-1" aria-hidden="true" {{ !empty($kriteria->finish_bulan) ? "disabled" : "" }}>
                                            @foreach (range(1, 2) as $item)
                                                <option value="{{$tahun}}" {{$kriteria->finish_tahun == $tahun ? "selected" : "" }}>{{$tahun}}</option>
                                                @php
                                                    $tahun++;
                                                @endphp
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--End::Row Kanan+Kiri-->
                                <div class="row ms-1 my-7">
                                    <!--Begin::Input Checkbox-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="edit" id="active-periode" name="isActive" onchange="setActive(this, '{{ $kriteria->id_kriteria_assessment }}')" {{ !empty($kriteria->is_active) && $kriteria->is_active ? "checked" : "" }}>
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
        <!--end::Modal Edit Kriteria Green Line-->
    @endforeach

    <!--begin::Modal-->
    {{-- <form action="/jenis-proyek/save" method="post" enctype="multipart/form-data">
        @csrf


        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New Jenis Proyek</h2>
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


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jenis Proyek</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="jenis-proyek"
                                        name="jenis-proyek" value="" placeholder="Jenis Proyek" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Jenis Kode</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="jenis-proyek"
                                        name="jenis-kode" value="" placeholder="jenis-kode" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form> --}}
    <!--end::Modals-->
    
    {{-- <!--begin::Modal EDIT-->
    @foreach ($js as $j)
    <form action="/dop/{{ $j->id }}/save" method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_edit_{{ $j->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New DOP</h2>
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


                        <!--begin::Row Kanan+Kiri-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">DOP</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="dop"
                                        name="dop" value="{{ $j->dop }}" placeholder="DOP" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                        </div>
                        <!--End::Row Kanan+Kiri-->



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Create App-->
    </form>
    @endforeach
    <!--end::Modal EDIT--> --}}

    <!--begin::modal DELETE-->
    {{-- @foreach ($industrySector as $j)
        <form action="/jenis-proyek/delete/{{ $j->id_industry_sector  }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $j->id_industry_sector  }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $j->description }}</h2>
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
                            <button class="btn btn-sm btn-light btn-active-primary min-w-100px fs-6">Delete</button>
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
    @endforeach --}}
    <!--end::modal DELETE-->
    
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    
    <script>
        $('#example').DataTable({
            stateSave: true,
            sorting: false,
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
     function changeSelectView(e) {
         const value = e.value;
         const index = e.getAttribute("id").split("_")[1];
         console.log(index);
        if(index) {
            if(value == "Internal") {
                document.querySelector("#kriteria-penilaian-internal_" + index).style.display = "";
                document.querySelector("#kriteria-penilaian-eksternal_" + index).style.display = "none";

                document.querySelector("#kriteria-penilaian-internal_" + index + " select").removeAttribute("disabled");
                document.querySelector("#kriteria-penilaian-eksternal_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Eksternal") {
                document.querySelector("#kriteria-penilaian-internal_" + index).style.display = "none";
                document.querySelector("#kriteria-penilaian-eksternal_" + index).style.display = "";
                
                document.querySelector("#kriteria-penilaian-internal_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#kriteria-penilaian-eksternal_" + index + " select").removeAttribute("disabled");
            } else if(value == "Piutang") {
                document.querySelector("#piutang_" + index).style.display = "";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "none";
                document.querySelector("#key-client_" + index).style.display = "none";
                document.querySelector("#industry-attractive_" + index).style.display = "none";
                document.querySelector("#top-100_" + index).style.display = "none";
                document.querySelector("#rating_" + index).style.display = "none";

                document.querySelector("#piutang_" + index + " select").removeAttribute("disabled");
                document.querySelector("#bowheer-bermasalah_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#key-client_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#industry-attractive_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#top-100_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#rating_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Bowheer Bermasalah") {
                document.querySelector("#piutang_" + index).style.display = "none";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "";
                document.querySelector("#key-client_" + index).style.display = "none";
                document.querySelector("#industry-attractive_" + index).style.display = "none";
                document.querySelector("#top-100_" + index).style.display = "none";
                document.querySelector("#rating_" + index).style.display = "none";

                document.querySelector("#piutang_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#bowheer-bermasalah_" + index + " select").removeAttribute("disabled");
                document.querySelector("#key-client_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#industry-attractive_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#top-100_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#rating_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Key Client") {
                document.querySelector("#piutang_" + index).style.display = "none";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "none";
                document.querySelector("#key-client_" + index).style.display = "";
                document.querySelector("#industry-attractive_" + index).style.display = "none";
                document.querySelector("#top-100_" + index).style.display = "none";
                document.querySelector("#rating_" + index).style.display = "none";
                
                document.querySelector("#piutang_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#bowheer-bermasalah_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#key-client_" + index + " select").removeAttribute("disabled");
                document.querySelector("#industry-attractive_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#top-100_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#rating_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Industry Attractive") {
                document.querySelector("#piutang_" + index).style.display = "none";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "none";
                document.querySelector("#key-client_" + index).style.display = "none";
                document.querySelector("#industry-attractive_" + index).style.display = "";
                document.querySelector("#top-100_" + index).style.display = "none";
                document.querySelector("#rating_" + index).style.display = "none";

                document.querySelector("#piutang_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#bowheer-bermasalah_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#key-client_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#industry-attractive_" + index + " select").removeAttribute("disabled");
                document.querySelector("#top-100_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#rating_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Top 100 Perusahan Besar di Indonesia") {
                document.querySelector("#piutang_" + index).style.display = "none";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "none";
                document.querySelector("#key-client_" + index).style.display = "none";
                document.querySelector("#industry-attractive_" + index).style.display = "none";
                document.querySelector("#top-100_" + index).style.display = "";
                document.querySelector("#rating_" + index).style.display = "none";

                document.querySelector("#piutang_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#bowheer-bermasalah_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#key-client_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#industry-attractive_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#top-100_" + index + " select").removeAttribute("disabled");
                document.querySelector("#rating_" + index + " select").setAttribute("disabled", true);
            } else if(value == "Lembaga Lain yang mengeluarkan rating perusahaan di Indonesia") {
                document.querySelector("#piutang_" + index).style.display = "none";
                document.querySelector("#bowheer-bermasalah_" + index).style.display = "none";
                document.querySelector("#key-client_" + index).style.display = "none";
                document.querySelector("#industry-attractive_" + index).style.display = "none";
                document.querySelector("#top-100_" + index).style.display = "none";
                document.querySelector("#rating_" + index).style.display = "";

                document.querySelector("#piutang_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#bowheer-bermasalah_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#key-client_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#industry-attractive_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#top-100_" + index + " select").setAttribute("disabled", true);
                document.querySelector("#rating_" + index + " select").removeAttribute("disabled");
            }
        } else {
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
    }
    // $(document).ready(function() {
    //     $('#provinsi-select', "#tier-select").select2({
    //         dropdownParent: $('#kt_modal_input_kriteria_green_line'),
    //         // minimumResultsForSearch: Infinity,
    //     });
    // });

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
                console.log("Tess");
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
