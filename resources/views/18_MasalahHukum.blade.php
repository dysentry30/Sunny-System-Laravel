{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Masalah Hukum')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Masalah Hukum
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @canany(['super-admin', 'risk-crm'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_create_masalah"
                                        data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah Masalah Hukum</a>

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
                            <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                        <th class="min-w-auto text-white">No.</th>
                                        <th class="min-w-auto text-white">Nama Pelanggan</th>
                                        <th class="min-w-auto text-white">Nama Proyek</th>
                                        <th class="min-w-auto text-white">Bentuk Masalah Hukum</th>
                                        <th class="min-w-auto text-white">Status</th>
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
                                            <td class="text-center align-middle">{{ $no++ }}</td>
                                            <td class="align-middle">{{ $item->Customer->name }}</td>
                                            <td class="align-middle">{{ $item->Proyek->nama_proyek }}</td>
                                            <td class="align-middle">{{ $item->bentuk_masalah }}</td>
                                            <td class="text-center align-middle">{{ $item->status }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;" onclick="showModal('{{ $item->id_hukum }}', '{{ $item->id_customer }}')">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                                        onclick="deleteItem('{{ $item->id_hukum }}')">Delete</button>
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

    <!--begin::Modal Tambah Masalah Hukum-->
    <form action="/masalah-hukum/save" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_create_masalah" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Masalah Hukum
                        </h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
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
                                    <select name="kode-proyek-hukum" id="new-proyek" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                        data-placeholder="Pilih Nama Proyek">
                                        <option value=""></option>                                                                          
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--End:Nama Proyek-->
    
                        <!--Begin:Jenis Masalah Hukum-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Bentuk Masalah Hukum</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="bentuk_masalah_hukum" class="form-control form-control-solid"
                                        placeholder="Bentuk Masalah Hukum" />                                                                        
                                </div>
                                <!--End::Text-->
                            </div>
                        </div>
                        <!--End:Jenis Masalah Hukum-->
    
                        <!--Begin:Status-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Status</span>
                                </label>
                                <!--Begin::Select-->
                                <div id="div-status">
                                    <select name="status_hukum" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih status">
                                        <option value=""></option>                                                                            
                                        <option value="WIKA Menang">WIKA Menang</option>                                                                          
                                        <option value="WIKA Kalah">WIKA Kalah</option>                                                                          
                                        <option value="Dalam Proses">Dalam Proses</option>                                                                          
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--Begin:Status-->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
                    </div>
                    <!--end::Input group-->
    
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
    </form>
    <!--end::Modal Tambah Masalah Hukum-->

    <!--begin::Modal Edit Kriteria Green Line-->
    @foreach ($data as $item)
    <form action="/masalah-hukum/{{ $item->id_hukum }}/edit" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_edit_masalah_{{ $item->id_hukum }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Masalah Hukum
                        </h2>
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
                    <div class="modal-body py-lg-6 px-lg-6" style="overflow:hidden;">
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
                                    <select id="nama_pelanggan_{{ $item->id_hukum }}" name="nama_pelanggan"
                                        class="form-select form-select-solid"data-hide-search="false" data-placeholder="Pilh Pelanggan" aria-hidden="true">
                                        <option value="{{ $item->id_customer }}">{{ $item->Customer->name }}</option>
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
                                    <select name="kode-proyek-hukum" id="new-proyek-{{ $item->id_hukum }}" class="form-select form-select-solid" data-hide-search="false" data-control="select2"
                                        data-placeholder="Pilih Nama Proyek">
                                        <option value="{{ $item->kode_proyek }}">{{ $item->kode_proyek.' - '.$item->Proyek->nama_proyek }}</option>                                                                          
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--End:Nama Proyek-->
    
                        <!--Begin:Jenis Masalah Hukum-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Bentuk Masalah Hukum</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="bentuk_masalah_hukum" class="form-control form-control-solid" value="{{ $item->bentuk_masalah }}"
                                        placeholder="Bentuk Masalah Hukum" />                                                                        
                                </div>
                                <!--End::Text-->
                            </div>
                        </div>
                        <!--End:Jenis Masalah Hukum-->
    
                        <!--Begin:Status-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Status</span>
                                </label>
                                <!--Begin::Select-->
                                <div id="div-status">
                                    <select name="status_hukum" id="status-{{ $item->id_hukum }}" class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                        data-placeholder="Pilih status">
                                        <option value=""></option>                                                                            
                                        <option value="WIKA Menang" {{ $item->status == "WIKA Menang" ? "selected" : "" }}>WIKA Menang</option>                                                                          
                                        <option value="WIKA Kalah" {{ $item->status == "WIKA Kalah" ? "selected" : "" }}>WIKA Kalah</option>                                                                          
                                        <option value="Dalam Proses" {{ $item->status == "Dalam Proses" ? "selected" : "" }}>Dalam Proses</option>                                                                          
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--Begin:Status-->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save</button>
                    </div>
                    <!--end::Input group-->
    
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
    </form>
    @endforeach
    <!--end::Modal Edit Kriteria Green Line-->

    @endsection
    
    @section('js-script')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
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
    <script>
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })
        function deleteItem(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    LOADING_BODY.block();
                    try {
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        const req = await fetch(`{{ url('/masalah-hukum/${id}/delete') }}`, {
                            method: 'POST',
                            header: {
                                "content-type": "application/json",
                            },
                            body: formData
                        }).then(res => res.json());
                        LOADING_BODY.release();
                        if (req.Success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!'
                            }).then(res => window.location.reload())
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus!'
                        }).then(res => window.location.reload())
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: error
                        }).then(res => window.location.reload())
                    }
                }
            })
        }
    </script>

    <script>
        const perPage = 10;
        $(document).ready(function(){
            $("#nama_pelanggan").select2({
                ajax:{
                    url: '/masalah-hukum/get-customer',
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
                dropdownParent: $("#kt_modal_create_masalah")
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
                        dropdownParent: $("#kt_modal_create_masalah")
                    });
                }else{
                    eltSelectProyek.setAttribute('disabled', true);
                }
                
            });
        })

        function showModal(id, id_customer) {
            let modal = document.getElementById('kt_modal_edit_masalah_' + id);
            $(modal).modal('show');
            $(`#nama_pelanggan_${id}`).select2({
                ajax:{
                    url: '/masalah-hukum/get-customer',
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
                dropdownParent: modal
            }).on('select2:select', async function (e) {
                let dataCustomerSelected = e.params.data.id;
                const eltSelectProyek = document.querySelector(`#new-proyek-${id}`);
                if (dataCustomerSelected != null || dataCustomerSelected != undefined) {
                    eltSelectProyek.value = "";
                    eltSelectProyek.removeAttribute('disabled', true);
                    $(`#new-proyek-${id}`).select2({
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
                        dropdownParent: modal
                    });
                }else{
                    eltSelectProyek.setAttribute('disabled', true);
                }
                
            });
            if (id_customer != null || id_customer != undefined) {
                $(`#new-proyek-${id}`).select2({
                    ajax:{
                        url: `/masalah-hukum/get-proyek-customer/${id_customer}`,
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
                    dropdownParent: modal
                });                
            }
        }
    </script>
@endsection

<!--end::Main-->
