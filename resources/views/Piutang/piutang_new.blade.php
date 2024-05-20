{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Piutang')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Piutang
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            {{-- @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, "(PIC)")) --}}
                            @canany(['super-admin', 'risk-crm'])
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                {{-- <a href="#" class="btn btn-sm btn-primary px-8 py-2"
                                    style="background-color:#008CB4; padding: 6px">Get Data</a> --}}
                                <!--begin::Button-->
                                <a href="#" data-bs-target="#kt_modal_create"
                                    data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                    style="background-color:#008CB4; padding: 6px">
                                    Tambah</a>
                            </div>
                            <!--end::Actions-->                                
                            @endcanany
                            {{-- @endif --}}
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
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">No.</th>
                                        <th class="min-w-auto">Nama Pelanggan</th>
                                        <th class="min-w-auto">Kode Proyek</th>
                                        <th class="min-w-auto">Nama Proyek</th>
                                        <th class="min-w-auto">Kategori Piutang</th>
                                        <th class="min-w-auto">Tanggal Create</th>
                                        <th class="min-w-auto">Tanggal Update</th>
                                        <th class="min-w-auto">Created By</th>
                                        <th class="min-w-auto">Updated By</th>
                                        <th class="min-w-auto">Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    $no = 1;
                                @endphp
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($piutangs as $key => $piutang)
                                        <tr>
                                            <td class="text-start">{{ ++$key }}</td>
                                            <td class="text-start">{{ $piutang->Customer->name ?? "-" }}</td>
                                            <td class="text-center">{{ $piutang->Proyek->kode_proyek ?? "-" }}</td>
                                            <td class="text-start">{{ $piutang->Proyek->nama_proyek ?? "-" }}</td>
                                            <td class="text-center">{{ $piutang->kategori == 3 ? "Tidak Ada Piutang" : ($piutang->kategori == 2 ? "Piutang < 3 Bulan" : "Tidak ada Piutang") }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::create($piutang->created_at)->translatedFormat('d F Y') }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::create($piutang->updated_at)->translatedFormat('d F Y') }}</td>
                                            <td class="text-center">{{ $piutang->UserCreated->name }}</td>
                                            <td class="text-center">{{ $piutang->UserUpdated->name }}</td>
                                            <td class="text-center">
                                                <a href="#" data-bs-target="#kt_modal_edit_{{ $piutang->id }}"
                                                data-bs-toggle="modal" class="btn btn-sm btn-primary text-white">
                                                Edit</a>
                                                <a href="#" data-bs-target="#kt_modal_delete_{{ $piutang->id }}"
                                                data-bs-toggle="modal" class="btn btn-sm btn-secondary btn-hover-danger">
                                                Delete</a>
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


    <!--begin::Modal-->
    <form action="/piutang/save" method="post" enctype="multipart/form-data">
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
                        <h2>New Piutang</h2>
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
                            <!--Begin:Nama Pelanggan-->
                            <!--begin::Input group Website-->
                            <div class="">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pelanggan</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="nama_pelanggan" name="nama_pelanggan"
                                            class="form-select form-select-solid"data-hide-search="false" data-placeholder="Pilh Pelanggan" aria-hidden="true">
                                            <option value="" selected></option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--End:Nama Pelanggan-->

                            <!--Begin:Nama Proyek-->
                            <div class="">
                                <div class="row fv-row">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Nama Proyek</span>
                                    </label>
                                    <!--Begin::Select-->
                                    <div id="div-namaProyek">
                                        <select name="kode_proyek" id="new-proyek" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                            data-placeholder="Pilih Nama Proyek">
                                            <option value=""></option>                                                                          
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--End:Nama Proyek-->

                            <!--Begin:Status-->
                                <div class="">
                                    <div class="row fv-row my-3">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Status</span>
                                        </label>
                                        <!--Begin::Select-->
                                        <div id="div-status">
                                            <select name="status" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilih status">
                                                <option value=""></option>                                                                            
                                                <option value="1">Tidak Ada Piutang</option>                                                                          
                                                <option value="2">Piutang < 3 Bulan</option>                                                                          
                                                <option value="3">Piutang > 3 Bulan</option>                                                                          
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--Begin:Status-->
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
    <!--end::Modals-->
    
    <!--begin::Modal EDIT-->
    @foreach ($piutangs as $piutang)
    <form action="/piutang/{{ $piutang->id }}/edit" method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_edit_{{ $piutang->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Piutang</h2>
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
                            <!--Begin:Nama Pelanggan-->
                            <!--begin::Input group Website-->
                            <div class="">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Nama Pelanggan</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <input type="text" name="nama_pelanggan" class="form-control form-control-solid" value="{{ $piutang->Customer->name }}" disabled>
                                        <!--end::Input-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--End:Nama Pelanggan-->

                            <!--Begin:Nama Proyek-->
                            <div class="">
                                <div class="row fv-row">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="">Nama Proyek</span>
                                    </label>
                                    <!--begin::Input-->
                                    <input type="text" name="kode_proyek" class="form-control form-control-solid" value="{{ $piutang->Proyek?->nama_proyek }}" disabled>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--End:Nama Proyek-->

                            <!--Begin:Status-->
                                <div class="">
                                    <div class="row fv-row my-3">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="">Status</span>
                                        </label>
                                        <!--Begin::Select-->
                                        <div id="div-status">
                                            <select name="status" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                                data-placeholder="Pilih status">
                                                <option value=""></option>                                                                            
                                                <option value="1" {{ $piutang->kategori == "1" ? "selected" : "" }}>Tidak Ada Piutang</option>                                                                          
                                                <option value="2" {{ $piutang->kategori == "2" ? "selected" : "" }}>Piutang < 3 Bulan</option>                                                                          
                                                <option value="3" {{ $piutang->kategori == "3" ? "selected" : "" }}>Piutang > 3 Bulan</option>                                                                          
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--Begin:Status-->
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
    <!--end::Modal EDIT-->

    <!--begin::modal DELETE-->
    @foreach ($piutangs as $piutang)
    <form action="/piutang/{{ $piutang->id }}/delete" method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_delete_{{ $piutang->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Delete Piutang</h2>
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
                            <p>Apakah anda yakin ingin menghapus data ini?</p>
                            <br>
                            <span>Pelanggan : <b>{{ $piutang->Customer->name ?? "-" }}</b></span>
                            <span>Proyek : <b>{{ $piutang->Proyek->nama_proyek ?? "-" }}</b></span>
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
    <!--end::modal DELETE-->

@endsection
<!--end::Main-->

@section('js-script')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script>
    $('#kt_customers_table').DataTable({
        stateSave: true,
        ordering: false
    });
    const perPage = 10;
    $(document).ready(function(){
        $("#nama_pelanggan").select2({
            ajax:{
                url: '/customer/get-customer',
                dataType: 'json',
                delay: 250,
                allowClear : true,
                data: function (params) {
                    return {
                        search: params.term,
                        perPage: 10,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1

                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                    const optionData = isPagination ? data.data : data;
                    const options = optionData.map(item => {
                        return {
                            id: item.id_customer, 
                            text: item.name
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
            dropdownParent: $("#kt_modal_create")
        }).on('select2:select', async function (e) {
            let dataCustomerSelected = e.params.data.id;
            const eltSelectProyek = document.querySelector('#new-proyek');
            if (dataCustomerSelected != null || dataCustomerSelected != undefined) {
                eltSelectProyek.removeAttribute('disabled', true);
                $("#new-proyek").select2({
                    ajax:{
                        url: `/masalah-hukum/get-proyek-customer/${dataCustomerSelected}`,
                        dataType: 'json',
                        delay: 250,
                        allowClear : true,
                        data: function (params) {
                            return {
                                search: params.term,
                                perPage: 10,
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params) {

                            params.page = params.page || 1

                            const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                            const optionData = isPagination ? data.data : data;
                            const options = optionData.map(item => {
                                return {
                                    id: item.kode_proyek, 
                                    text: item.kode_proyek + ' - ' + item.nama_proyek
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
                    dropdownParent: $("#kt_modal_create")
                });
            }else{
                eltSelectProyek.setAttribute('disabled', true);
            }
            
        });
    })
</script>
@endsection
