{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Kriteria Green Lane')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Kriteria Green Lane
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
                                        Tambah Kriteria Green Lane</a>

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
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                        <th class="min-w-auto text-white">Item</th>
                                        <th class="min-w-auto text-white">Isi Item</th>
                                        <th class="min-w-auto text-white">Sub Item</th>
                                        <th class="min-w-auto text-white">Start Periode</th>
                                        <th class="min-w-auto text-white">Finish Periode</th>
                                        <th class="min-w-auto text-white">Action</th>
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
                                    @foreach ($kriteria_green_line_all->sortBy("id_kriteria_green_line") as $kriteria)
                                        @php
                                        switch($kriteria->start_bulan){
                                            case "1":
                                            $start_bulan = "Januari"."-".$kriteria->start_tahun;
                                            break;
                                            case "2":
                                            $start_bulan = "Februari"."-".$kriteria->start_tahun;
                                            break;
                                            case "3":
                                            $start_bulan = "Maret"."-".$kriteria->start_tahun;
                                            break;
                                            case "4":
                                            $start_bulan = "April"."-".$kriteria->start_tahun;
                                            break;
                                            case "5":
                                            $start_bulan = "Mei"."-".$kriteria->start_tahun;
                                            break;
                                            case "6":
                                            $start_bulan = "Juni"."-".$kriteria->start_tahun;
                                            break;
                                            case "7":
                                            $start_bulan = "Juli"."-".$kriteria->start_tahun;
                                            break;
                                            case "8":
                                            $start_bulan = "Agustus"."-".$kriteria->start_tahun;
                                            break;
                                            case "9":
                                            $start_bulan = "September"."-".$kriteria->start_tahun;
                                            break;
                                            case "10":
                                            $start_bulan = "Oktober"."-".$kriteria->start_tahun;
                                            break;
                                            case "11":
                                            $start_bulan = "November"."-".$kriteria->start_tahun;
                                            break;
                                            case "12":
                                            $start_bulan = "Desember"."-".$kriteria->start_tahun;
                                            break;
                                            default:
                                            $start_bulan = "-";
                                        }
                                        switch($kriteria->finish_bulan){
                                            case "1":
                                            $finish_bulan = "Januari"."-".$kriteria->finish_tahun;
                                            break;
                                            case "2":
                                            $finish_bulan = "Februari"."-".$kriteria->finish_tahun;
                                            break;
                                            case "3":
                                            $finish_bulan = "Maret"."-".$kriteria->finish_tahun;
                                            break;
                                            case "4":
                                            $finish_bulan = "April"."-".$kriteria->finish_tahun;
                                            break;
                                            case "5":
                                            $finish_bulan = "Mei"."-".$kriteria->finish_tahun;
                                            break;
                                            case "6":
                                            $finish_bulan = "Juni"."-".$kriteria->finish_tahun;
                                            break;
                                            case "7":
                                            $finish_bulan = "Juli"."-".$kriteria->finish_tahun;
                                            break;
                                            case "8":
                                            $finish_bulan = "Agustus"."-".$kriteria->finish_tahun;
                                            break;
                                            case "9":
                                            $finish_bulan = "September"."-".$kriteria->finish_tahun;
                                            break;
                                            case "10":
                                            $finish_bulan = "Oktober"."-".$kriteria->finish_tahun;
                                            break;
                                            case "11":
                                            $finish_bulan = "November"."-".$kriteria->finish_tahun;
                                            break;
                                            case "12":
                                            $finish_bulan = "Desember"."-".$kriteria->finish_tahun;
                                            break;
                                            default:
                                            $finish_bulan = "-";
                                        }
                                            
                                        try {
                                            $sub_isi = App\Models\Provinsi::where("province_id", "=" , $kriteria->sub_isi)->firstOrFail()->province_name;
                                        } catch (\Throwable $th) {
                                            $sub_isi = $kriteria->sub_isi;
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{$kriteria->item}}</td>
                                            <td>{{$kriteria->isi}}</td>
                                            <td>{{$sub_isi}}</td>
                                            <td class="text-center">{{$start_bulan}}</td>
                                            <td class="text-center">{{$finish_bulan}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#kt_modal_edit_{{$kriteria->id_kriteria_green_line }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a>
                                                    <form action="/kriteria-green-line/delete" class="ms-3" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id-kriteria" value="{{$kriteria->id_kriteria_green_line }}">
                                                        <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                                    </form>
                                                </div>
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
                    <h2>Tambah Kriteria Green Line</h2>
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

                <form action="/kriteria-green-line/save" method="POST">
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
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Item</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="Item" name="item"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" onchange="getData(this, '#isi')" data-hide-search="false" data-placeholder="Pilh Item..."
                                        data-select2-id="select2-item" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="Instansi">Instansi</option>
                                        <option value="Sumber Dana">Sumber Dana</option>
                                        <option value="Proyek Luar Negeri">Proyek Luar Negeri</option>
                                        
                                    </select>
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
                                        <span class="required">Isi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                        
                                    <select id="isi" name="isi"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" onchange="getData(this, '#provisi', true)" data-hide-search="false" data-placeholder="Pilih Isi..."
                                        data-select2-id="select2-isi" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
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
                                    <div id="tier" hidden>
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Sub Isi</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="tier-select" name="sub-isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Tier..."
                                            data-select2-id="select2-tier" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Tier A">Tier A</option>
                                            <option value="Tier B">Tier B</option>
                                            <option value="Tier C">Tier C</option>
                                            {{-- @foreach ($instansi as $ins)
                                                <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                            @endforeach --}}
                                            {{-- @foreach ($sumber_danas as $sd)
                                                <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                            @endforeach --}}
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <div id="provinsi" hidden>
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Sub Isi</span>
                                        </label>
                                        <!--end::Label-->
    
                                        <!--begin::Input-->
                                        <select id="provinsi-select" name="sub-isi[]"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Provinsi..."
                                            data-select2-id="select2-provinsi" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
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

    @foreach ($kriteria_green_line_all as $kriteria)
        <!--begin::Modal Edit Kriteria Green Line-->
        <div class="modal fade" id="kt_modal_edit_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Kriteria Green Line</h2>
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

                    <form action="/kriteria-green-line/update" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_input_kriteria_green_line">
                        <input type="hidden" name="id-kriteria" value="{{$kriteria->id_kriteria_green_line }}">
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
                                                data-select2-id="select2_bulan_start_{{ $kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
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
                                            <select id="tahun_start_{{$kriteria->id_kriteria_green_line }}" name="tahun_start"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                                data-select2-id="select2_tahun_start_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
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
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Item</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="Item_{{$kriteria->id_kriteria_green_line }}" name="item"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" onchange="getData(this, '#isi_{{$kriteria->id_kriteria_green_line }}')" data-hide-search="false" data-placeholder="Pilh Item..."
                                            data-select2-id="select2-item_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            <option value="Instansi" {{$kriteria->item == "Instansi" ? "selected" : ""}}>Instansi</option>
                                            <option value="Sumber Dana" {{$kriteria->item == "Sumber Dana" ? "selected" : ""}}>Sumber Dana</option>
                                            <option value="Proyek Luar Negeri" {{$kriteria->item == "Proyek Luar Negeri" ? "selected" : ""}}>Proyek Luar Negeri</option>
                                            
                                        </select>
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
                                            <span class="required">Isi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                            
                                        <select id="isi_{{$kriteria->id_kriteria_green_line }}" name="isi"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" onchange="getData(this, '#provisi_{{$kriteria->id_kriteria_green_line }}', true)" data-hide-search="false" data-placeholder="Pilih Isi..."
                                            data-select2-id="select2-isi_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            @if (!empty($kriteria->isi))
                                                <option value="{{$kriteria->isi}}" selected>{{$kriteria->isi}}</option>
                                            @endif
                                            
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
                                        @php
                                            $tier_hidden = "hidden";
                                            if (!empty($kriteria->sub_isi) && !str_contains($kriteria->sub_isi, "-")){
                                                $tier_hidden = "";
                                            } 
                                        @endphp
                                        <div id="tier_{{$kriteria->id_kriteria_green_line }}" {{$tier_hidden}}>
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="">Sub Isi</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <select id="tier-select_{{$kriteria->id_kriteria_green_line }}" name="sub-isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Tier..."
                                                data-select2-id="select2-tier_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                <option value="Tier A" {{$kriteria->sub_isi == "Tier A" ? "selected" : ""}}>Tier A</option>
                                                <option value="Tier B" {{$kriteria->sub_isi == "Tier B" ? "selected" : ""}}>Tier B</option>
                                                <option value="Tier C" {{$kriteria->sub_isi == "Tier C" ? "selected" : ""}}>Tier C</option>
                                                {{-- @foreach ($instansi as $ins)
                                                    <option value="{{$ins->instansi}}">{{$ins->instansi}}</option>
                                                @endforeach --}}
                                                {{-- @foreach ($sumber_danas as $sd)
                                                    <option value="{{$sd->kode}}">{{$sd->kode}}</option>
                                                @endforeach --}}
                                            </select>
                                            <!--end::Input-->
                                        </div>

                                        @php
                                            $provinsi_hidden = "hidden";
                                            $provinsi = [];
                                            if (!empty($kriteria->sub_isi) && str_contains($kriteria->sub_isi, "-")){
                                                $provinsi_hidden = "";
                                                $provinsi = App\Models\Provinsi::where("country_id", "=", "ID")->get();
                                            }
                                        @endphp
                                        <div id="provinsi_{{$kriteria->id_kriteria_green_line }}" {{$provinsi_hidden}}>
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="">Sub Isi</span>
                                            </label>
                                            <!--end::Label-->
        
                                            <!--begin::Input-->
                                            <select id="provinsi-select_{{$kriteria->id_kriteria_green_line }}" name="sub-isi[]"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="false" data-placeholder="Pilih Provinsi..."
                                                data-select2-id="select2-provinsi_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                @forelse ($provinsi as $p)
                                                    @if ($p->province_id == $kriteria->sub_isi)
                                                        <option value="{{$p->province_id}}" selected>{{ $p->province_name }}</option>
                                                    @else    
                                                        <option value="{{$p->province_id}}">{{ $p->province_name }}</option>
                                                    @endif
                                                @empty
                                                @endforelse
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
                                </div>
                                <!--begin::Input group Website-->
                                <div class="fv-row mt-7 {{ $kriteria->is_active ? 'd-none' : '' }}" id="finish-periode-edit-{{ $kriteria->id_kriteria_green_line }}">
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
                                            data-select2-id="select2_bulan_finish_{{ $kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true" {{ !empty($kriteria->finish_bulan) ? "disabled" : "" }}>
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
                                        <select id="tahun_finish_{{$kriteria->id_kriteria_green_line }}" name="tahun_finish"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_finish_{{$kriteria->id_kriteria_green_line }}" tabindex="-1" aria-hidden="true" {{ !empty($kriteria->finish_bulan) ? "disabled" : "" }}>
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
                                <!--end::Input group-->
                            </div>
                            <!--End::Row Kanan+Kiri-->
                            <div class="row ms-1 my-7">
                                <!--Begin::Input Checkbox-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="edit" id="active-periode" name="isActive" onchange="setActive(this, '{{ $kriteria->id_kriteria_green_line }}')" {{ !empty($kriteria->is_active) && $kriteria->is_active ? "checked" : "" }}>
                                    <label class="form-check-label" for="active-periode">
                                        Active
                                    </label>
                                </div>
                                <!--End::Input Checkbox-->
                            </div>        
        
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
                                        <span class="">Jenis Kode</span>
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
            ordering: false
        });
    </script>
    <!--end::Javascript-->
@endsection

@section('js-script')
<script>
    async function getData(e, dropdownElt, isShow = false) {
        const index = e.getAttribute("id").split("_")[1];
        const value = e.value;
        let html = '<option value="" selected></option>';
        const getDataKategoriRes = await fetch(`/kriteria/${value}`).then(res => res.json());
        getDataKategoriRes.forEach(item => {
            if(item.province_id) {
                html += `<option value="${item.province_id}">${item.province_name}</option>`
            } else {
                html += `<option value="${item}">${item}</option>`
            }
        }) 
        // $("#tier-select_" + index).select2("destroy");
        if(isShow) {
            if(value.includes("BUMN")) {
                if(index) {
                    document.querySelector("#tier_" + index).removeAttribute("hidden");
                    document.querySelector("#provinsi_" + index).setAttribute("hidden", true);
                    $('#tier-select_' + index).select2({
                        dropdownParent: $('#kt_modal_edit_' + index),
                        // minimumResultsForSearch: Infinity,
                    });
                    $('#provinsi-select_' + index).select2("destroy");
                } else {
                    document.querySelector("#tier").removeAttribute("hidden");
                    document.querySelector("#provinsi").setAttribute("hidden", true);
                    $('#tier-select').select2({
                        dropdownParent: $('#kt_modal_input_kriteria_green_line'),
                        // minimumResultsForSearch: Infinity,
                    });
                    $('#provinsi-select').select2("destroy");
                }
            } else if(value.includes("APBD") || value.includes("Provinsi")) {
                if(index) {
                    document.querySelector("#tier_"  + index).setAttribute("hidden", true);
                    document.querySelector("#provinsi_"  + index).removeAttribute("hidden");
                    document.querySelector("#provinsi-select_"  + index).innerHTML = html;
                    $('#tier-select_'  + index).select2("destroy");
                    $('#provinsi-select_'  + index).select2({
                        dropdownParent: $('#kt_modal_edit_' + index),
                        // minimumResultsForSearch: Infinity,
                    });
                } else {
                    document.querySelector("#tier").setAttribute("hidden", true);
                    document.querySelector("#provinsi").removeAttribute("hidden");
                    document.querySelector("#provinsi-select").innerHTML = html;
                    $('#tier-select').select2("destroy");
                    $('#provinsi-select').select2({
                        dropdownParent: $('#kt_modal_input_kriteria_green_line'),
                        // minimumResultsForSearch: Infinity,
                    });
                }
            } else {
                if(index) {
                    document.querySelector("#tier_"  + index).setAttribute("hidden", true);
                    document.querySelector("#provinsi_"  + index).setAttribute("hidden", true);
                    // document.querySelector("#provinsi-select_"  + index).innerHTML = html;
                    $("#tier-select_" + index).val("").trigger("change");
                    $("#provinsi-select_"  + index).val("").trigger("change");
                    // $('#tier-select_'  + index).select2("destroy");
                    // $('#provinsi-select_'  + index).select2("destroy");
                }
                document.querySelector("#tier").setAttribute("hidden", true);
                document.querySelector("#provinsi").setAttribute("hidden", true);
            }
            
        } else {
            document.querySelector(dropdownElt).innerHTML = html;
        }
        return;
    }
    $(document).ready(function() {
        $('#provinsi-select', "#tier-select").select2({
            dropdownParent: $('#kt_modal_input_kriteria_green_line'),
            // minimumResultsForSearch: Infinity,
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
