{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Except Greenlane')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Except Greenlane
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @canany(['super-admin', 'risk-crm'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_add_item" data-bs-toggle="modal"
                                        class="btn btn-sm btn-primary py-3" style="background-color:#008CB4; padding: 6px">
                                        Tambah Item</a>
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
                                <div class="d-flex align-items-center my-1" style="width: 100%;">

                                    <ul
                                        class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                        <!--begin:::Tab Owner Selection-->
                                        <li class="nav-item">
                                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                                aria-selected="true" href="#kt_view_owner_selection"
                                                style="font-size:14px;">Owner Selection</a>
                                        </li>
                                        <!--end:::Tab Owner Selection-->

                                </div>
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 overflow-scroll">
                            <div id="tab-content" class="tab-content">
                                <!--Begin::Owner Selection-->
                                <div class="tab-pane fade show active" id="kt_view_owner_selection" role="tabpanel">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr
                                                class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                                <th class="min-w-auto text-white">No.</th>
                                                <th class="min-w-auto text-white">Kategori</th>
                                                <th class="min-w-auto text-white">Sub Kategori</th>
                                                <th class="min-w-auto text-white">Item</th>
                                                <th class="min-w-auto text-white">Sub Item</th>
                                                <th class="min-w-auto text-white">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        @php
                                            $no = 1;
                                        @endphp
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $no++ }}</td>
                                                    <td class="align-middle">{{ $item->kategori }}</td>
                                                    <td class="align-middle">{{ $item->sub_kategori }}</td>
                                                    <td class="align-middle">{{ $item->sub_kategori == "Pemberi Kerja" ? $item->Customers?->name : $item->SumberDana?->kode_sumber }}</td>
                                                    <td class="align-middle">{{ !empty($item->Provinsi) ? $item->Provinsi->province_name : $item->sub_item }}</td>
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button class="btn btn-sm btn-primary text-white"
                                                                style="background-color: #008CB4;"
                                                                onclick="showModal('{{ $item->id }}', '{{ $item }}')">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-danger text-white"
                                                                onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--Begin::Owner Selection-->
                            </div>
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

    <!--begin::Modal Tambah Except Greenlane-->
    <form action="/except-greenlane/save" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_add_item" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Except Greenlane
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
                        <!--Begin:Kategori-->
                        <!--begin::Input group Website-->
                        <div class="">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="kategori" name="kategori" class="form-select form-select-solid"
                                        data-hide-search="true" data-placeholder="Pilh Kategori" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Kategori-->

                        <!--Begin:Sub Kategori-->
                        <!--begin::Input group Website-->
                        <div class="d-none" id="div-subkategori">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Sub Kategori</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="sub-kategori" name="sub-kategori" class="form-select form-select-solid"
                                        data-hide-search="true" data-placeholder="Pilh Sub Kategori" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Sub Kategori-->

                        <!--Begin:Item-->
                        <!--begin::Input group Website-->
                        <div class="d-none" id="div-item">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Item</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="item" name="item" class="form-select form-select-solid"
                                        data-hide-search="false" data-placeholder="Pilh Item" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Item-->

                        <!--Begin:Sub Item-->
                        <!--begin::Input group Website-->
                        <div class="d-none" id="div-subitem">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Item</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="sub-item" name="sub-item" class="form-select form-select-solid"
                                        data-hide-search="false" data-placeholder="Pilh Sub Item" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Sub Item-->
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
    <!--end::Modal Tambah Except Greenlane-->

    <!--begin::Modal Edit Except Greenlane-->
    @foreach ($data as $item)
    <form action="/except-greenlane/{{ $item->id }}/save" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_edit_item_{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Except Greenlane
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
                        <!--Begin:Kategori-->
                        <!--begin::Input group Website-->
                        <div class="">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kategori</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="kategori-{{ $item->id }}" name="kategori" class="form-select form-select-solid"
                                        data-hide-search="true" data-placeholder="Pilh Kategori" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Kategori-->

                        <!--Begin:Sub Kategori-->
                        <!--begin::Input group Website-->
                        <div class="{{ empty($item->sub_kategori) ? "d-none" : "" }}" id="div-subkategori-{{ $item->id }}">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Sub Kategori</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="sub-kategori-{{ $item->id }}" name="sub-kategori" class="form-select form-select-solid"
                                        data-hide-search="true" data-placeholder="Pilh Sub Kategori" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Sub Kategori-->

                        <!--Begin:Item-->
                        <!--begin::Input group Website-->
                        <div class="{{ empty($item->item) ? "d-none" : "" }}" id="div-item-{{ $item->id }}">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Item</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="item-{{ $item->id }}" name="item" class="form-select form-select-solid"
                                        data-hide-search="false" data-placeholder="Pilh Item" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Item-->

                        <!--Begin:Sub Item-->
                        <!--begin::Input group Website-->
                        <div class="{{ empty($item->sub_item) ? "d-none" : "" }}" id="div-subitem-{{ $item->id }}">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Sub Item</span>
                                </label>
                                <!--end::Label-->
                                <div class="d-flex flex-row gap-2">
                                    <!--begin::Input-->
                                    <select id="sub-item-{{ $item->id }}" name="sub-item" class="form-select form-select-solid"
                                        data-hide-search="false" data-placeholder="Pilh Sub Item" aria-hidden="true">
                                        <option value="" selected></option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--End:Sub Item-->
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
    <!--edit::Modal Edit Except Greenlane-->

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
                        const req = await fetch(`{{ url('/except-greenlane/${id}/delete') }}`, {
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
                                title: req.Message
                            }).then(res => window.location.reload())
                        }
                        Swal.fire({
                            icon: 'success',
                            title: req.Message
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
        let dataItemSelectedOption;
        $(document).ready(function() {
            $("#kategori").select2({
                data: [{
                    id: "Owner Selection",
                    text: "Owner Selection",
                }],
                dropdownParent: $("#kt_modal_add_item")
            }).on('select2:select', function(e) {
                const dataKategoriSelected = e.params.data.id;
                const eltSubKategori = document.querySelector('#div-subkategori');

                eltSubKategori.classList.remove('d-none');

                $('#sub-kategori').val(null).trigger('change');
                $('#item').val(null).trigger('change');
                $('#sub-item').val(null).trigger('change');

                let options = [];

                if (dataKategoriSelected == "Owner Selection") {
                    const opt1 = {
                        id: "Pemberi Kerja",
                        text: "Pemberi Kerja",
                    }
                    const opt2 = {
                        id: "Sumber Dana",
                        text: "Sumber Dana",
                    }
                    options.push(opt1, opt2);
                } else {
                    options.push("");
                }

                $("#sub-kategori").select2({
                    data: options,
                    dropdownParent: $("#kt_modal_add_item")
                }).on('select2:select', async function(e) {
                    const dataSubKategoriSelected = e.params.data.id;
                    const dataSubKategoriFormatted = dataSubKategoriSelected.replace(" ", "-").toLowerCase();
                    const eltItem = document.querySelector('#div-item');

                    dataItemSelectedOption = dataSubKategoriFormatted;
                    eltItem.classList.remove('d-none');

                    $('#item').val(null).trigger('change');
                    $('#sub-item').val(null).trigger('change');

                    $("#item").select2({
                        ajax: {
                            url: `/except-greenlane/${dataSubKategoriFormatted}/data-get`,
                            dataType: 'json',
                            delay: 250,
                            allowClear: true,
                            data: function(params) {
                                return {
                                    search: params.term,
                                    perPage: 10,
                                    page: params.page || 1
                                };
                            },
                            processResults: function(data, params) {

                                params.page = params.page || 1

                                const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                                const optionData = isPagination ? data.data : data;
                                const options = optionData.map(item => {
                                    return {
                                        id: item.value,
                                        text: item.name
                                    }
                                })
                                return {
                                    results: options,
                                    pagination: {
                                        more: isPagination ? (params.page * (
                                            perPage || 10)) < data.total : false
                                    }
                                }
                            },
                            cache: true,
                            minimumResultsForSearch: 0
                        },
                        dropdownParent: $("#kt_modal_add_item")
                    }).on('select2:select', async function(e){
                        let dataItemFormated;
                        const dataItemSelected = e.params.data.id;

                        if (typeof dataItemSelected === 'string') {
                            dataItemFormated = dataItemSelected.replace(" ", "-").toLowerCase();                            
                        }else{
                            dataItemFormated = dataItemSelected;
                        }

                        const eltSubItem = document.querySelector('#div-subitem');

                        eltSubItem.classList.remove('d-none');

                        $('#sub-item').val(null).trigger('change');

                        $("#sub-item").select2({
                            ajax: {
                                url: `/except-greenlane/${dataItemSelectedOption}/${dataItemFormated}/data-get`,
                                dataType: 'json',
                                delay: 250,
                                allowClear: true,
                                data: function(params) {
                                    return {
                                        search: params.term,
                                        perPage: 10,
                                        page: params.page || 1
                                    };
                                },
                                processResults: function(data, params) {

                                    params.page = params.page || 1

                                    console.log(data);

                                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                                    const optionData = isPagination ? data.data : data;
                                    const options = optionData.map(item => {
                                        return {
                                            id: item.value,
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
                            dropdownParent: $("#kt_modal_add_item")
                        });

                    });
                })
            })
        });

        function showModal(id, data) {
            const dataExceptSelected = JSON.parse(data);
            let modal = document.getElementById('kt_modal_edit_item_' + id);
            const kategoriSelect = document.querySelector(`#kategori-${id}`);
            const subKategoriSelect = document.querySelector(`#sub-kategori-${id}`);
            const itemSelect = document.querySelector(`#item-${id}`);
            const subItemSelect = document.querySelector(`#sub-item-${id}`);

            $(modal).modal('show');

            $(`#kategori-${id}`).select2({
                data: [{
                    id: "Owner Selection",
                    text: "Owner Selection",
                }],
                dropdownParent: modal
            }).on('select2:select', function(e) {
                const dataKategoriSelected = e.params.data.id;
                const eltSubKategori = document.querySelector(`#div-subkategori-${id}`);

                eltSubKategori.classList.remove('d-none');

                $(`#sub-kategori-${id}`).val(null).trigger('change');
                $(`#item-${id}`).val(null).trigger('change');
                $(`#sub-item-${id}`).val(null).trigger('change');

                let options = [];

                if (dataKategoriSelected == "Owner Selection") {
                    const opt1 = {
                        id: "Pemberi Kerja",
                        text: "Pemberi Kerja",
                    }
                    const opt2 = {
                        id: "Sumber Dana",
                        text: "Sumber Dana",
                    }
                    options.push(opt1, opt2);
                } else {
                    options.push("");
                }

                $(`#sub-kategori-${id}`).select2({
                    data: options,
                    dropdownParent: modal
                }).on('select2:select', async function(e) {
                    const dataSubKategoriSelected = e.params.data.id;
                    const dataSubKategoriFormatted = dataSubKategoriSelected.replace(" ", "-").toLowerCase();
                    const eltItem = document.querySelector(`#div-item-${id}`);

                    dataItemSelectedOption = dataSubKategoriFormatted;
                    eltItem.classList.remove('d-none');

                    $(`#item-${id}`).val(null).trigger('change');
                    $(`#sub-item-${id}`).val(null).trigger('change');

                    $(`#item-${id}`).select2({
                        ajax: {
                            url: `/except-greenlane/${dataSubKategoriFormatted}/data-get`,
                            dataType: 'json',
                            delay: 250,
                            allowClear: true,
                            data: function(params) {
                                return {
                                    search: params.term,
                                    perPage: 10,
                                    page: params.page || 1
                                };
                            },
                            processResults: function(data, params) {

                                params.page = params.page || 1

                                const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                                const optionData = isPagination ? data.data : data;
                                const options = optionData.map(item => {
                                    return {
                                        id: item.value,
                                        text: item.name
                                    }
                                })
                                return {
                                    results: options,
                                    pagination: {
                                        more: isPagination ? (params.page * (
                                            perPage || 10)) < data.total : false
                                    }
                                }
                            },
                            cache: true,
                            minimumResultsForSearch: 0
                        },
                        dropdownParent: modal
                    }).on('select2:select', async function(e){
                        let dataItemFormated;
                        const dataItemSelected = e.params.data.id;

                        if (typeof dataItemSelected === 'string') {
                            dataItemFormated = dataItemSelected.replace(" ", "-").toLowerCase();                            
                        }else{
                            dataItemFormated = dataItemSelected;
                        }

                        const eltSubItem = document.querySelector(`#div-subitem-${id}`);

                        eltSubItem.classList.remove('d-none');

                        $(`#sub-item-${id}`).val(null).trigger('change');

                        $(`#sub-item-${id}`).select2({
                            ajax: {
                                url: `/except-greenlane/${dataItemSelectedOption}/${dataItemFormated}/data-get`,
                                dataType: 'json',
                                delay: 250,
                                allowClear: true,
                                data: function(params) {
                                    return {
                                        search: params.term,
                                        perPage: 10,
                                        page: params.page || 1
                                    };
                                },
                                processResults: function(data, params) {

                                    params.page = params.page || 1

                                    console.log(data);

                                    const isPagination = data.hasOwnProperty('data') && Array.isArray(data.data) ? true : false
                                    const optionData = isPagination ? data.data : data;
                                    const options = optionData.map(item => {
                                        return {
                                            id: item.value,
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
                        });

                    });
                })
            })

            fetchDataForEdit(`/except-greenlane/${id}/fetch`).then((data)=>{

                const optionKategori = new Option(data.name_kategori, data.id_kategori, true, true);
                kategoriSelect.append(optionKategori)?.trigger('change');

                const optionSubKategori = new Option(data.name_sub_kategori, data.id_sub_kategori, true, true);
                subKategoriSelect.append(optionSubKategori)?.trigger('change');

                const optionItem = new Option(data.name_item, data.id_item, true, true);
                itemSelect.append(optionItem)?.trigger('change');

                const optionSubItem = new Option(data.name_sub_item, data.id_sub_item, true, true);
                subItemSelect.append(optionSubItem)?.trigger('change');
            });

            
        }
        
        async function fetchDataForEdit(url = "") {
            try {
                const fetchData = await fetch(url, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });
                return fetchData.json();                
            } catch (error) {
                return Swal.fire({
                    icon: 'error',
                    title: error
                }).then(res => window.location.reload());
            }            
        }
    </script>
@endsection

<!--end::Main-->
