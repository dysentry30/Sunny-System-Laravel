{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Knowladge Base {{ $kategori }}')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Knowladge Base {{ $kategori }}
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @canany(['super-admin', 'risk-crm'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_create"
                                        data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah</a>

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
                                        <th class="min-w-auto text-white">Title</th>
                                        <th class="min-w-auto text-white">Link</th>
                                        {{-- <th class="min-w-auto text-white">Created By</th>
                                        <th class="min-w-auto text-white">Updated By</th> --}}
                                        <th class="min-w-auto text-white">Created On</th>
                                        <th class="min-w-auto text-white">Updated On</th>
                                        @canany(['super-admin', 'admin-crm'])
                                            <th class="min-w-auto text-white">Action</th>                                            
                                        @endcanany
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($data as $key => $item)
                                    @php
                                        $isFile = !empty($item->documents) ? true : false;

                                        if ($isFile) {
                                            $documentsParse = collect(json_decode($item->documents));
                                        }
                                    @endphp
                                        <tr>
                                            <td class="text-center align-middle">{{ ++$key }}</td>

                                            <td class="align-middle">{{ $item->title }}</td>

                                            <td class="align-middle">
                                            @if ($isFile)
                                                @foreach ($documentsParse as $document)
                                                    <a href="/knowladge-base/{{ $kategori }}/{{ $item->uuid }}/{{ $document->id_file }}/download" target="_blank" class="text-primary">{{ $document->nama_file }}</a>,
                                                @endforeach
                                            @else
                                                <a href="{{ $item->url }}" class="text-primary">{{ $item->url }}</a>
                                            @endif
                                            </td>

                                            {{-- <td class="text-center align-middle">{{ $item->UserCreated->name }}</td>

                                            <td class="text-center align-middle">{{ $item->UserUpdated->name }}</td> --}}
                                            
                                            <td class="text-center align-middle">{{ \Carbon\Carbon::create($item->created_at)->translatedFormat('d F Y') }}</td>

                                            <td class="text-center align-middle">{{ \Carbon\Carbon::create($item->updated_at)->translatedFormat('d F Y') }}</td>

                                            @canany(['super-admin', 'admin-crm'])
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;" onclick="showModal('kt_modal_edit', '{{ $item->uuid }}', '{{ $kategori }}')">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                                        onclick="deleteItem('{{ $item->uuid }}', '{{ $kategori }}')">Delete</button>
                                                </div>
                                            </td>                                                
                                            @endcanany
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

    <!--begin::Modal Tambah Knowladge Base-->
    <form action="/knowladge-base/{{ $kategori }}/save" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Knowladge Base {{ $kategori }}</h2>
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!--Begin:Title-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Title</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="title" class="form-control form-control-solid" placeholder="Judul" value="{{ old('title') }}"/>                                                                        
                                </div>
                                <!--End::Text-->
                            </div>
                        </div>
                        <!--End:Title-->
                        
                        <!--End:Select-->
                        <div class="">
                            {{-- <div class="row fv-row my-3"> --}}
                                <div class="form-check form-check-inline my-3">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="url" value="option1" onchange="showInputNew(true, false)" checked>
                                    <label class="form-check-label" for="inlineRadio1">URL</label>
                                </div>
                                <div class="form-check form-check-inline my-3">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="file-upload" value="option2" onchange="showInputNew(false, true)">
                                    <label class="form-check-label" for="inlineRadio2">File Upload</label>
                                </div>
                                {{-- <div class="form-check form-check-inline my-3">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="all" value="option3" onchange="showInputNew(true, true)">
                                    <label class="form-check-label" for="inlineRadio3">All</label>
                                </div> --}}
                            {{-- </div> --}}
                        </div>
                        <!--End:Select-->

                        <!--End:Url-->
                        <div class="" id="input-url-new">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Link URL</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="url" class="form-control form-control-solid" placeholder="Link URL" id="url" value="{{ old('url') }}"/>
                                </div>
                                <!--End::Select-->
                            </div>
                        </div>
                        <!--End:Url-->

                        <!--End:Url-->
                        <div class="d-none" id="input-document-new">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Upload File</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="file" name="file[]" multiple class="form-control form-control-solid" placeholder="Upload File" accept=".pdf" id="file" value="{{ old('file') }}" disabled/>
                                </div>
                                <small class="text-danger">*can upload multiple file, pdf only</small>
                                <!--End::Select-->
                            </div>
                        </div>
                        <!--End:Url-->

                        <div class="">
                            <input type="hidden" name="kategori" multiple class="form-control form-control-solid" value="{{ $kategori }}"/>
                        </div>

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
    <!--end::Modal Tambah Knowladge Base-->

    <!--begin::Modal Tambah Knowladge Base-->
    <form action="" method="post" id="edit-form" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="kt_modal_edit" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Knowladge Base</h2>
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
                        <!--Begin:Title-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Title</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="title" class="form-control form-control-solid" placeholder="Judul" />                                                                        
                                </div>
                                <!--End::Text-->
                            </div>
                        </div>
                        <!--End:Title-->
                        
                        <!--End:Select-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="url" value="option1" selected>
                                    <label class="form-check-label" for="inlineRadio1">URL</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="file-upload" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">File Upload</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="all" value="option3">
                                    <label class="form-check-label" for="inlineRadio3">All</label>
                                </div>
                            </div>
                        </div>
                        <!--End:Select-->

                        <!--End:Url-->
                        <div class="">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Link URL</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="url" class="form-control form-control-solid" placeholder="Link URL" />                                                                        
                                </div>
                                <!--End::Select-->
                            </div>
                        </div>
                        <!--End:Url-->

                        <!--End:Url-->
                        <div class="d-none">
                            <div class="row fv-row my-3">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="">Upload File</span> <span class="text-danger">*can upload multiple file</span>
                                </label>
                                <!--Begin::Select-->
                                <div class="">
                                    <input type="text" name="file" multiple class="form-control form-control-solid" placeholder="Upload File" />                                                                        
                                </div>
                                <!--End::Select-->
                            </div>
                        </div>
                        <!--End:Url-->

                        <div class="d-none">
                            <div class="row fv-row my-3">
                                <table class="align-middle table-bordered border-dark fs-6 gy-2">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">Document</th>
                                            <th class="min-w-auto text-white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">
                                                <a href="/knowladge-base/{kategori}/{id_document}/delete"><i class="bi bi-x-square-fill text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

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
    <!--end::Modal Tambah Knowladge Base-->
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
    </script>

    <script>
        function deleteItem(idKnowladge, kategori) {
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
                        const req = await fetch(`{{ url('/knowladge-base/${kategori}/${idKnowladge}/delete') }}`, {
                            method: 'POST',
                            header: {
                                "content-type": "application/json",
                            },
                            body: formData
                        }).then(res => res.json());
                        LOADING_BODY.release();
                        if (req.success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!',
                                text: req.message
                            })
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus!'
                        }).then(res => window.location.reload())
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: error
                        })
                    }
                }
            })
        }

        function deleteDocument(idKnowladge, kategori, idDocument) {
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
                        const req = await fetch(`{{ url('/knowladge-base/${kategori}/${idKnowladge}/${idDocument}/delete-document') }}`, {
                            method: 'POST',
                            header: {
                                "content-type": "application/json",
                            },
                            body: formData
                        }).then(res => res.json());
                        LOADING_BODY.release();
                        if (req.success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!',
                                text: req.message
                            })
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus!'
                        }).then(res => {
                            let eltRowTableDocument = document.getElementById(idDocument);
                            const inputUrlOption = document.getElementById('url-option');
                            const inputDocumentOption = document.getElementById('file-upload-option');

                            eltRowTableDocument.remove();
                            inputUrlOption.setAttribute('onchange', `showInputEdit(true, false, ${req.isExistFile})`);
                            inputDocumentOption.setAttribute('onchange', `showInputEdit(false, true, ${req.isExistFile})`);
                        })
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: error
                        })
                    }
                }
            })
        }
    </script>

    <script>
        async function getDataKnowladge(idKnowladge, kategori) {
            try {
                const res = await fetch(`/knowladge-base/${kategori}/${idKnowladge}/get-data`).then(res => res.json());
                if (res.success) {
                    return res.data
                }
                alert(res.message);
            } catch (error) {
                alert(error)
            }
        }
    </script>

    <script>
        async function showModal(idModal, idKnowladge, kategori) {
            LOADING_BODY.block();

            const data = await getDataKnowladge(idKnowladge, kategori);
            let isDocument = data.documents != null ? true : false;
            let isUrl = data.url != null ? true : false;
            // let isAllInput = data.url && data.documents != null != null ? true : false;

            LOADING_BODY.release();

            const modalForm = document.getElementById("edit-form");
            const modalId = document.getElementById(idModal);
            const modalSelected = new bootstrap.Modal(modalId);

            const modalBody = modalId.querySelector('.modal-body');
            const modalFooter = modalId.querySelector('.modal-footer');
            let htmlFiles;

            modalForm.setAttribute("action", `/knowladge-base/${kategori}/${idKnowladge}/edit`);
            
            if(data.documents != null){
                const documentParse = JSON.parse(data.documents);
                let htmlTableDocument = '';
                documentParse.forEach(document => {
                    htmlTableDocument += `
                        <tr id='${document.id_file}'>
                            <td class="align-middle">${document.nama_file}</td>
                            <td class="text-center align-middle">
                                <button type="button" class='btn btn-danger btn-sm' onclick='deleteDocument("${data.uuid}", "${kategori}", "${document.id_file}")'><i class="bi bi-trash3-fill text-white"></i></button>
                            </td>
                        </tr>
                    `
                });
                htmlFiles = `
                    <div class="row fv-row my-3">
                        <table class="align-middle table-bordered border-dark fs-6 gy-2">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                    <th class="min-w-auto text-white">Document</th>
                                    <th class="min-w-auto text-white">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600">
                                ${htmlTableDocument}
                            </tbody>
                        </table>
                    </div>
                `
            }

            let htmlSelected = `
                <!--Begin:Title-->
                <div class="">
                    <div class="row fv-row my-3">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Title</span>
                        </label>
                        <!--Begin::Select-->
                        <div class="">
                            <input type="text" name="title" class="form-control form-control-solid" placeholder="Judul" value="${data.title}" />                                                                        
                        </div>
                        <!--End::Text-->
                    </div>
                </div>
                <!--End:Title-->
                
                <!--Begin:Select-->
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="url-option" value="option1" ${isUrl ? 'checked' : ''} onchange="showInputEdit(${true}, ${false}, ${isDocument})">
                        <label class="form-check-label" for="inlineRadio1">URL</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="file-upload-option" value="option2" ${isDocument ? 'checked' : ''} onchange="showInputEdit(${false}, ${true}, ${isDocument})">
                        <label class="form-check-label" for="inlineRadio2">File Upload</label>
                    </div>
                </div>
                <!--End:Select-->

                <!--Begin:Url-->
                <div class="${isUrl ? '' : 'd-none'}" id="input-url-edit">
                    <div class="row fv-row my-3">
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Link URL</span>
                        </label>
                        <!--Begin::Select-->
                        <div class="">
                            <input type="text" id="url" name="url" class="form-control form-control-solid" placeholder="Link URL" value="${data.url ?? ''}" ${!isUrl ? 'disabled' : ''}/>                                                                        
                        </div>
                        <!--End::Select-->
                    </div>
                </div>
                <!--End:Url-->

                <!--Begin:File-->
                <div class="${isDocument ? '' : 'd-none'}" id="input-document-edit">
                    <div class="row fv-row my-3">
                        <!--Begin::Select-->
                        <label class="fs-6 fw-bold form-label mt-3">
                            <span class="">Upload File</span>
                        </label>
                        <div class="">
                            <input type="file" id="file" name="file[]" multiple class="form-control form-control-solid" accept=".pdf" placeholder="Upload File" ${!isDocument ? 'disabled' : ''}/>                                                                        
                        </div>
                        <!--End::Select-->
                        <small class="text-danger">*can upload multiple file</small>
                    </div>
                </div>
                <!--End:File-->

                <!--Begin:Table-->
                <div class="${isDocument ? '' : 'd-none'}">${htmlFiles}</div>
                <!--End:Table-->
            `

            modalBody.innerHTML = htmlSelected;

            modalSelected.show();
        }
    </script>

    <script>
        function showInputNew(isUrl, isDocument){
            const inputUrlNew = document.getElementById('input-url-new');
            const eltInputUrl = inputUrlNew.querySelector('#url');

            const inputDocumentNew = document.getElementById('input-document-new');
            const eltInputDocument = inputDocumentNew.querySelector('#file');


            // if (isUrl && isDocument) {
            //     if (inputUrlNew.classList.contains('d-none')) {
            //         inputUrlNew.classList.remove('d-none');
            //         eltInputUrl.removeAttribute('disabled');
            //     }
                
            //     if (inputDocumentNew.classList.contains('d-none')) {
            //         inputDocumentNew.classList.remove('d-none');
            //         eltInputDocument.removeAttribute('disabled');
            //     }
            // }else if(isUrl) {
            //     if (inputUrlNew.classList.contains('d-none')) {
            //         inputUrlNew.classList.remove('d-none');
            //         eltInputUrl.removeAttribute('disabled');
            //     }

            //     inputDocumentNew.classList.add('d-none');
            //     eltInputDocument.setAttribute('disabled', true);
            // }else if(isDocument) {
            //     if (inputDocumentNew.classList.contains('d-none')) {
            //         inputDocumentNew.classList.remove('d-none');
            //         eltInputDocument.removeAttribute('disabled');
            //     }

            //     inputUrlNew.classList.add('d-none');
            //     eltInputUrl.setAttribute('disabled', true);
            // }

            if(isUrl) {
                if (inputUrlNew.classList.contains('d-none')) {
                    inputUrlNew.classList.remove('d-none');
                    eltInputUrl.removeAttribute('disabled');
                }

                inputDocumentNew.classList.add('d-none');
                eltInputDocument.setAttribute('disabled', true);
            }else if(isDocument) {
                if (inputDocumentNew.classList.contains('d-none')) {
                    inputDocumentNew.classList.remove('d-none');
                    eltInputDocument.removeAttribute('disabled');
                }

                inputUrlNew.classList.add('d-none');
                eltInputUrl.setAttribute('disabled', true);
            }
        }

        function showInputEdit(isUrl, isDocument, isDocumentExist){
            const inputUrlEdit = document.getElementById('input-url-edit');
            const eltInputUrl = inputUrlEdit.querySelector('#url');
            
            const inputDocumentEdit = document.getElementById('input-document-edit');
            const eltInputDocument = inputDocumentEdit.querySelector('#file');

            const inputUrlOption = document.getElementById('url-option');
            const inputDocumentOption = document.getElementById('file-upload-option');

            // if (isUrl && isDocument) {
            //     if (inputUrlEdit.classList.contains('d-none')) {
            //         inputUrlEdit.classList.remove('d-none');
            //         eltInputUrl.removeAttribute('disabled');
            //     }
                
            //     if (inputDocumentEdit.classList.contains('d-none')) {
            //         inputDocumentEdit.classList.remove('d-none');
            //         eltInputDocument.removeAttribute('disabled');
            //     }
            // }else if(isUrl) {
            //     if (inputUrlEdit.classList.contains('d-none')) {
            //         inputUrlEdit.classList.remove('d-none');
            //         eltInputUrl.removeAttribute('disabled');
            //     }

            //     inputDocumentEdit.classList.add('d-none');
            //     eltInputDocument.setAttribute('disabled', true);
            // }else if(isDocument) {
            //     if (inputDocumentEdit.classList.contains('d-none')) {
            //         inputDocumentEdit.classList.remove('d-none');
            //         eltInputDocument.removeAttribute('disabled');
            //     }

            //     inputUrlEdit.classList.add('d-none');
            //     eltInputUrl.setAttribute('disabled', true);
            // }

            if(isUrl) {
                if (isDocumentExist) {
                    Swal.fire({
                        title: "Error",
                        text: "Hapus File terlebih dahulu",
                        icon: "error"
                    });
                    inputUrlOption.removeAttribute('checked')
                    inputDocumentOption.setAttribute('checked', true)
                    return;
                }
                if (inputUrlEdit.classList.contains('d-none')) {
                    inputUrlEdit.classList.remove('d-none');
                    eltInputUrl.removeAttribute('disabled');
                }

                inputDocumentEdit.classList.add('d-none');
                eltInputDocument.setAttribute('disabled', true);
            }else if(isDocument) {
                if (inputDocumentEdit.classList.contains('d-none')) {
                    inputDocumentEdit.classList.remove('d-none');
                    eltInputDocument.removeAttribute('disabled');
                }

                inputUrlEdit.classList.add('d-none');
                eltInputUrl.setAttribute('disabled', true);
            }
        }
    </script>
@endsection

<!--end::Main-->
