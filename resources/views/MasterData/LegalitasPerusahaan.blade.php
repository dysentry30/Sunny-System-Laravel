{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Legalitas Perusahaan')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Legalitas Perusahaan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)"))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a  href="#" data-bs-target="#kt_modal_create_otomasi_approval" data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah Legalitas Perusahaan</a>

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
                                        <th class="min-w-auto text-white">No.</th>
                                        <th class="min-w-auto text-white">Item</th>
                                        <th class="min-w-auto text-white">Bobot</th>
                                        <th class="min-w-auto text-white">Nota Rekomendasi</th>
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
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-center align-middle">{{$no++}}</td>
                                            <td class="align-middle">{!! nl2br($item->item) !!}</td>
                                            <td class="text-center align-middle">{{ $item->bobot }}</td>
                                            <td class="text-center align-middle">{{ $item->nota_rekomendasi }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" data-bs-target="#kt_modal_create_pengguna_jasa_{{$item->id }}" data-bs-toggle="modal" class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;">Edit</a>
                                                        <input type="hidden" name="id-otomasi" value="{{$item->id }}">
                                                        <button type="button" class="btn btn-sm btn-danger text-white" onclick="deleteItem('{{ $item->id }}')">Delete</button>
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
    <div class="modal fade" id="kt_modal_create_otomasi_approval" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Legalitas Perusahaan</h2>
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

                <form action="/legalitas-perusahaan/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_create_otomasi_approval">
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
                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Item</span>
                                </label>
                                <textarea name="item" id="item" cols="30" rows="10"></textarea>
                            </div>
                            <!--End begin::Col-->

                            <div class="row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Bobot</span>
                                </label>
                                <input type="number" name="bobot" class="form-control form-control-solid">
                            </div>

                            <div class="row mb-7">
                                 <!--begin::Label-->
                                 <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Nota Rekomendasi</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="nota_rekomendasi" name="nota_rekomendasi"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                        data-select2-id="select2-feature" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="Nota Rekomendasi 1">Nota Rekomendasi 1</option>
                                        <option value="Nota Rekomendasi 2">Nota Rekomendasi 2</option>
                                    </select>
                                    <!--end::Input-->
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

    <!--begin::Modal Edit Kriteria Green Line-->
    @foreach ($data as $item)
        <div class="modal fade" id="kt_modal_create_pengguna_jasa_{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Kriteria Pengguna Jasa</h2>
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

                    <form action="/legalitas-perusahaan/update/{{ $item->id }}" method="POST">
                        @csrf
                        <input type="hidden" name="modal" value="kt_modal_create_otomasi_approval">
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
                                                data-select2-id="select2_bulan_start_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected></option>
                                                <option value="1" {{ $item->start_bulan == "1" ? "selected" : "" }}>Januari</option>
                                                <option value="2" {{ $item->start_bulan == "2" ? "selected" : "" }}>Februari</option>
                                                <option value="3" {{ $item->start_bulan == "3" ? "selected" : "" }}>Maret</option>
                                                <option value="4" {{ $item->start_bulan == "4" ? "selected" : "" }}>April</option>
                                                <option value="5" {{ $item->start_bulan == "5" ? "selected" : "" }}>Mei</option>
                                                <option value="6" {{ $item->start_bulan == "6" ? "selected" : "" }}>Juni</option>
                                                <option value="7" {{ $item->start_bulan == "7" ? "selected" : "" }}>Juli</option>
                                                <option value="8" {{ $item->start_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                                <option value="9" {{ $item->start_bulan == "9" ? "selected" : "" }}>September</option>
                                                <option value="10" {{ $item->start_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                                <option value="11" {{ $item->start_bulan == "11" ? "selected" : "" }}>November</option>
                                                <option value="12" {{ $item->start_bulan == "12" ? "selected" : "" }}>Desember</option>
                                            </select>
                                            <!--end::Input-->
                                            <!--begin::Input-->
                                            <select id="tahun_start" name="tahun_start"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                                data-select2-id="select2_tahun_start_{{$item->id }}" tabindex="-1" aria-hidden="true">
                                                @foreach (range(1, 2) as $index)
                                                    <option value="{{$tahun}}" {{(!empty($item->start_tahun) && $item->start_tahun == $tahun) ? "selected" : "" }}>{{$tahun}}</option>
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
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Item</span>
                                    </label>
                                    <textarea name="item" id="item" cols="30" rows="10">{!! nl2br($item->item) !!}</textarea>
                                </div>
                                <!--End begin::Col-->
    
                                <div class="row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Bobot</span>
                                    </label>
                                    <input type="number" name="bobot" value="{{ $item->bobot }}" class="form-control form-control-solid">
                                </div>
    
    
                                <div class="row mb-7">
                                     <!--begin::Label-->
                                     <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nota Rekomendasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="nota_rekomendasi" name="nota_rekomendasi"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Nota Rekomendasi..."
                                            data-select2-id="select2-feature-{{ $item->id }}-{{ $no++ }}" tabindex="-1" aria-hidden="true">
                                            <option value="" selected></option>
                                            <option value="Nota Rekomendasi 1" {{ $item->nota_rekomendasi == "Nota Rekomendasi 1" ? "selected" : ""}}>Nota Rekomendasi 1</option>
                                            <option value="Nota Rekomendasi 2" {{ $item->nota_rekomendasi == "Nota Rekomendasi 2" ? "selected" : ""}}>Nota Rekomendasi 2</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>

                                
                                <!--begin::Input group Website-->
                                <div class="fv-row mt-7 {{ (!empty($item->is_active) && $item->is_active) || is_null($item->is_active) ? 'd-none' : '' }}" id="finish-periode-edit-{{ $item->id }}">
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
                                            data-select2-id="select2_bulan_finish_{{ $item->id }}" tabindex="-1" aria-hidden="true" {{ !empty($item->finish_bulan) ? "disabled" : "" }}>
                                            <option value="" selected></option>
                                            <option value="1" {{ $item->finish_bulan == "1" ? "selected" : "" }}>Januari</option>
                                            <option value="2" {{ $item->finish_bulan == "2" ? "selected" : "" }}>Februari</option>
                                            <option value="3" {{ $item->finish_bulan == "3" ? "selected" : "" }}>Maret</option>
                                            <option value="4" {{ $item->finish_bulan == "4" ? "selected" : "" }}>April</option>
                                            <option value="5" {{ $item->finish_bulan == "5" ? "selected" : "" }}>Mei</option>
                                            <option value="6" {{ $item->finish_bulan == "6" ? "selected" : "" }}>Juni</option>
                                            <option value="7" {{ $item->finish_bulan == "7" ? "selected" : "" }}>Juli</option>
                                            <option value="8" {{ $item->finish_bulan == "8" ? "selected" : "" }}>Agustus</option>
                                            <option value="9" {{ $item->finish_bulan == "9" ? "selected" : "" }}>September</option>
                                            <option value="10" {{ $item->finish_bulan == "10" ? "selected" : "" }}>Oktober</option>
                                            <option value="11" {{ $item->finish_bulan == "11" ? "selected" : "" }}>November</option>
                                            <option value="12" {{ $item->finish_bulan == "12" ? "selected" : "" }}>Desember</option>
                                        </select>
                                        <!--end::Input-->
                                        <!--begin::Input-->
                                        <select id="tahun_finish_{{$item->id }}" name="tahun_finish"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="true" data-placeholder="Pilh Tahun..."
                                            data-select2-id="select2_tahun_finish_{{$item->id }}" tabindex="-1" aria-hidden="true" {{ !empty($item->finish_bulan) ? "disabled" : "" }}>
                                            @foreach (range(1, 2) as $index)
                                                <option value="{{$tahun}}" {{(!empty($item->finish_tahun) && $item->finish_tahun == $tahun) ? "selected" : "" }}>{{$tahun}}</option>
                                                @php
                                                    $tahun++;
                                                @endphp
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->

                                <div class="row ms-1 my-7">
                                    <!--Begin::Input Checkbox-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="edit" id="active-periode" name="isActive" onchange="setActive(this, '{{ $item->id }}')" {{ (!empty($item->is_active) && $item->is_active) || is_null($item->is_active) ? "checked" : "" }}>
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
    @endforeach
    <!--end::Modal Edit Kriteria Green Line-->

    
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
    function deleteItem(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then(async (result)=>{
            if(result.isConfirmed){
                try {
                    const formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    const req = await fetch(`{{ url('/kriteria-pengguna-jasa/delete/') }}/${id}`, {
                        method: 'POST',
                        header: {
                            "content-type": "application/json",
                        },
                        body:formData
                    }).then(res => res.json());
                    if (req.Success != true) {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Data gagal dihapus!'
                        }).then(res=>window.location.reload())
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus!'
                    }).then(res=>window.location.reload())
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error
                    }).then(res=>window.location.reload())
                }
            }
        })
    }

    function setItem(elt, id=null, text=null) {
        // if (elt.value == "Legalitas Perusahaan") {
        //     let data = [
        //         {
        //             id: "Legalitas Institusi / Perusahaan",
        //             text: 'Legalitas Institusi / Perusahaan'
        //         }
        //     ]
        //     if (id != null) {
        //         $(`#item-${id}`).empty() 
        //         $(`#item-${id}`)
        //         $(`#item-${id}`).select2({
        //             minimumResultsForSearch: -1,
        //             data: data
        //         })
        //     } else {
        //         $(`#item`).empty() 
        //         $(`#item`).select2({
        //             minimumResultsForSearch: -1,
        //             data: data
        //         }) 
        //     }
        // } else 
        if(elt.value == "Reputasi Pemberi Kerja") {
            let data = [
                {
                    id: "",
                    text: ''
                },
                {
                    id: "Reputasi Pemberi Kerja Dalam Pemenuhan Kontrak (Historical)",
                    text: 'Reputasi Pemberi Kerja Dalam Pemenuhan Kontrak (Historical)'
                }
            ]
            if (id != null) {
                $(`#item-${id}`).empty() 
                $(`#item-${id}`)
                $(`#item-${id}`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                })
            } else {
                $(`#item`).empty() 
                $(`#item`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                }) 
            }
        } else {
            let data = [
                {
                    id: "",
                    text: ''
                },
                {
                    id: 'Current Ratio',
                    text: 'Current Ratio'
                },
                {
                    id: 'Cash Ratio',
                    text: 'Cash Ratio'
                },
                {
                    id: 'Debt to Equity Ratio',
                    text: 'Debt to Equity Ratio'
                },
                {
                    id: 'Kepatuhan Pembayaran Pajak',
                    text: 'Kepatuhan Pembayaran Pajak'
                }
            ]
            if (id != null) {
                $(`#item-${id}`).empty() 
                $(`#item-${id}`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                })
                $(`#item-${id}`).val()
            } else {
                $(`#item`).empty() 
                $(`#item`).select2({
                    minimumResultsForSearch: -1,
                    data: data
                }) 
            }
        }
    }

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
