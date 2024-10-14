{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master AHS')
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


                <!--begin::Delete Alert -->
                {{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
                <!--end::Delete Alert -->

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Analisa Harga Satuan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator || auth()->user()->email == "user-poc@sunny.com")
                                <div class="d-flex align-items-center py-1 gap-2">
    
                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#modal_kt_upload"
                                        data-bs-toggle="modal" class="btn btn-sm btn-success py-3">
                                        Upload AHS</a>
                                    <!--END::Button-->
                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_create"
                                        data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah AHS</a>
                                    <!--END::Button-->
                                </div>
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                        <!--begin::Card body-->
                        <div class="card-body pt-3 ">

                            <!--begin::Table-->
                            <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="user_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto px-4">Kode AHS</th>
                                        <th class="min-w-auto">Uraian</th>
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
                                    @foreach ($masterHargaSatuanAll as $harga_satuan)
                                        <tr>
                                            <td class="text-center">{{$harga_satuan->kode_ahs}}</td>
                                            <td>{{$harga_satuan->uraian}}</td>
                                            <td class="text-center">
                                                <a href="/analisa-harga-satuan/view/{{ $harga_satuan->id }}" target="_blank" class="btn btn-sm btn-primary text-white">View</a>
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
    <form action="/analisa-harga-satuan/save" method="post" enctype="multipart/form-data">
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
                        <h2>New Analisa Harga Satuan</h2>
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
                                        <span class="required">Kode AHS</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kode-ahs"
                                        name="kode-ahs" value="" placeholder="Kode AHS" max="15"/>
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
                                        <span class="">Uraian</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="uraian"
                                        name="uraian" value="" placeholder="Uraian" />
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

    <div class="modal fade" id="modal_kt_upload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_kt_upload" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/analisa-harga-satuan/upload" method="post" enctype="multipart/form-data" onsubmit="addLoading(this)">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Upload Analisa Harga Satuan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                                    
                        <div class="mb-3">
                            <label for="file" class="form-label" class="required">Upload</label>
                            <input type="file" class="form-control" id="file" name="file" value="" accept=".xlsx">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="save-pilihan" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>                            
            </form>
        </div>
    </div>
    <!--end::Modals-->

    <!--begin::Modal New User-->
    <!--end::Modal New User-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    
    <script>
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })

        $(document).ready(function() {
            $('#user_table').DataTable( {
                dom: '<"float-start"f><"#user_table"t>rtip',
                // dom: 'frtip',
                pageLength : 50,
                // ordering : false,
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ]
            } );
        } );

        function addLoading(elt) {
            LOADING_BODY.block();
            elt.form.submit();
        }
    </script>
    <!--end::Data Tables-->

@endsection
