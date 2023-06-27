{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Dokumen Template')
{{-- end:: title --}}

{{-- begin:: content --}}
@section('content')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Dokumen Template
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <div class="d-flex align-items-center justify-content-end py-1 gap-3 me-5">
                            <div class="d-flex">
                                <a class="btn btn-sm btn-primary"
                                style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_new">
                                New</a>
                            </div>
                        </div>
                        <!--begin::Wrapper-->
                         <!--begin::Button-->
                         {{-- <a type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                         style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                         data-bs-target="#kt_modal_input_perubahan_kontrak">
                         New</a> --}}
                        <!--end::Button-->

                        <!--begin::Button-->
                        {{-- <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                            style="background-color:#f3f6f9;margin-left:10px;color: black;">
                            Close</a> --}}
                        <!--end::Button-->
                        <!--end::Wrapper-->

                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-fluid">
                    <!--begin::Contacts App- Edit Contact-->
                    <div class="row">


                        <!--begin::All Content-->
                        <div class="col-xl-15">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-1">
                                    <!--begin::Card title-->
                                    <div class="card-title">

                                        <!--Begin:: BUTTON FILTER-->
                                        <form action="" class="d-flex flex-row w-auto" method="get">

                                            <!--begin:: Input Filter-->
                                            <div id="jenis-dokumen" class="d-flex align-items-center position-relative">
                                                <select id="jenis-dokumen" name="jenis-dokumen" class="form-select form-select-solid w-200px ms-2"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Jenis Dokumen">
                                                    <option></option>
                                                    <option value="Input Resiko (Perolehan)" {{ $category_get == 'Input Resiko (Perolehan)' ? 'selected' : '' }}>Input Resiko (Perolehan)</option>
                                                    <option value="Input Resiko (Pelaksanaan)" {{ $category_get == 'Input Resiko (Pelaksanaan)' ? 'selected' : '' }}>Input Resiko (Pelaksanaan)</option>
                                                    <option value="Input Resiko (Pemeliharaan)" {{ $category_get == 'Input Resiko (Pemeliharaan)' ? 'selected' : '' }}>Input Resiko (Pemeliharaan)</option>
                                                    {{-- @forelse ($category_document as $item)
                                                    @empty
                                                        <option value=""></option>
                                                    @endforelse --}}
                                                </select>
                                            </div>

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
                                                    window.location.href = "/document-template";
                                                }
                                            </script>
                                        </form>
                                            <!--end:: BUTTON FILTER-->
                                    </div>
                                    <!--begin::Card title-->

                                </div>
                                <!--end::Card header-->

                                <div class="card-body pt-5">
                                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="document">
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">No.</th>
                                                <th class="min-w-auto">@sortablelink('category','Jenis Dokumen')</th>
                                                <th class="min-w-auto">Nama Dokumen</th>
                                                <th class="min-w-auto">Tanggal Upload</th>
                                                <th class="min-w-auto">Action</th>
                                                {{-- <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        {{-- @php
                                            $claim_get = $claim->map(function($p){
                                                return $p->first();
                                            })
                                        @endphp --}}
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @php
                                                $no = 1;
                                            @endphp
                                            @forelse ($documents_template as $item)

                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->nama_dokumen }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <a target="_blank" class="btn btn-primary btn-sm text-white" href="{{ asset('template/'.$item->id_dokumen) }}">Download</a>&nbsp;
                                                    @if (auth()->user()->check_admin_kontrak)
                                                    <button type="button" class="btn btn-secondary btn-sm text-hover-danger" onclick="confirmDelete('{{ $item->id }}')">Delete</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>

                            </div>
                            <!--End::Contacts-->


                        </div>
                        <!--end::All Content-->
            
                    </div>
                    <!--end::Contacts App- Edit Contact-->
                    <!--Begin::Modal = New Document Template-->
                    <div class="modal fade" id="kt_modal_new" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-500px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2>Add Dokumen Template</h2>
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
                
                                    <!--begin::Input group Website-->
                                    <form action="/document-template/new" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="modal-name" name="modal-name">
                                        <div class="row">
                                            <div class="col">
                                                <label class="fs-6 fw-bold form-label">
                                                    <span style="font-weight: normal">Jenis Dokumen</span>
                                                </label>
                                                <select name="category" id="kategori" class="form-select form-select-solid"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Dokumen" tabindex="-1" aria-hidden="true">
                                                    <option value=""></option>
                                                    <option value="Input Resiko (Perolehan)">Input Resiko (Perolehan)</option>
                                                    <option value="Input Resiko (Pelaksanaan)">Input Resiko (Pelaksanaan)</option>
                                                    <option value="Input Resiko (Pemeliharaan)">Input Resiko (Pemeliharaan)</option>
                                                </select>
                                            </div>
                                        </div>
                
                                        <br>
                                        <div class="row">
                                            <input type="file" name="file-document" id="file-document" class="form-control form-control-solid">
                                        </div>
                                        <!--end::Input group-->
                                        <div class="modal-footer mt-4">
                                            <button type="submit" id="save-perubahan-kontrak"
                                                class="btn btn-sm btn-primary">Save</button>
                                        </div>
                                    </form>
                
                
                                </div>
                                <!--end::Modal body-->

                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Document Template-->
                </div>
                <!--end::Container-->


            </div>
            <!--end::Post-->
        </div>
        <!--end::Content-->
    </div>
@endsection
{{-- end:: content --}}

{{-- @section('aside')
    @include('template.aside')
@endsection --}}


@section('js-script')


<script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("/datatables/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.html5.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.colVis.min.js") }}"></script>
<script src="{{ asset("/datatables/jszip.min.js") }}"></script>
<script src="{{ asset("/datatables/pdfmake.min.js") }}"></script>
<script src="{{ asset("/datatables/vfs_fonts.js") }}"></script>
<!--end::Data Tables-->
    <!--begin:: Dokumen File Upload Max Size-->
    <script>
        $(document).ready(function() {
            $('#document').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>rti',
                pageLength : 50,
                ordering: false,
            } );
        });
    </script>
<script>
    async function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin menghapus dokumen ini?',
            text: "Aksi ini tidak dapat dikembalikan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#008CB4',
            cancelButtonColor: '#BABABA',
            confirmButtonText: 'Ya'
        }).then(async(result)=>{
            if(result.isConfirmed){
                const formData = new FormData();
                formData.append("_token", "{{ csrf_token() }}");
                const sendData = await fetch(`/document-template/delete/${id}`,{
                    method: "POST",
                    body: formData
                }).then(res => res.json());
            if(sendData.link){
                window.location.reload();
            }
            }

        })
    }
</script>

@endsection