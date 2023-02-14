@extends('template.main')
@section('title', 'CSI')
<!--begin::Main-->
@section('content')

    @php
        $is_super_user = str_contains(Auth::user()->name, "PIC") || Auth::user()->check_administrator;
    @endphp

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
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center fs-3 my-1">CSI</h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">
                        <br>
                        <!--begin::Card title-->
                        <div class="card-title">
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table CSI-->
                            <table class="table align-middle table-row-dashed fs-6" id="csi-table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Nomor SPK</th>
                                        <th class="min-w-auto">Nama Proyek</th>
                                        <th class="min-w-auto">Unit Kerja</th>
                                        <th class="min-w-auto">Progress</th>
                                        <th class="min-w-auto">Status</th>
                                        <th class="min-w-auto">Action</th>
                                        {{-- <th class="min-w-auto">ID Contract</th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ($csi as $c)
                                        <tr>
                                            <td>{{$c->no_spk}}</td>
                                            <td>{{$c->nama_proyek}}</td>
                                            <td>{{$c->UnitKerja->unit_kerja}}</td>
                                            <td>{{$c->progress}}</td>
                                            <td>{{$c->status}}</td>
                                            <td>
                                                <form action="#" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ $c->no_spk }}" name="no-spk">
                                                    <input type="submit" class="btn btn-sm btn-primary" value="send" name="send-btn">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            <!--end::Table CSI-->
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
    <!--end::Modals-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    {{-- <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script> --}}
    <!--end::Data Tables-->

    <script>
        $(document).ready(function() {
            $("#csi-table").DataTable( {
                dom: '<"float-start"f><"#example"t>rtip',
                // dom: 'Brti',
                // dom: 'frtip',
                pageLength : 20,
            } );
        });
    </script>
    

    {{-- <script>
        const modals = document.querySelectorAll(".modal");
        setTimeout(() => {
            modals.forEach(modal => {
                const inputs = modal.querySelectorAll(".modal-dialog .modal-content .modal-body input, .modal-dialog .modal-content .modal-body select, .modal-dialog .modal-content .modal-body textarea");
                inputs.forEach(input => {
                    input.setAttribute("readonly", true);
                })
            });
        }, 500);
    </script> --}}
@endsection

