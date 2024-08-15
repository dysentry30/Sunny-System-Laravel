{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Approval Proyek Terkontrak')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Approval Proyek Terkontrak
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
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
                                        <th class="min-w-auto text-white">Kode Proyek</th>
                                        <th class="min-w-auto text-white">Nama Proyek</th>
                                        <th class="min-w-auto text-white">Diajukan Oleh</th>
                                        <th class="min-w-auto text-white">Tanggal Diajukan</th>
                                        <th class="min-w-auto text-white">Disetujui Oleh</th>
                                        <th class="min-w-auto text-white">Tanggal Disetujui</th>
                                        <th class="min-w-auto text-white">Status</th>
                                        <th class="min-w-auto text-white">Catatan Revisi</th>
                                        @if ($isCanApprove)
                                            <th class="min-w-auto text-white">Action</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($proyeks as $proyekApproval)
                                        <tr>
                                            <td class="text-center">
                                                <a href="/proyek/view/{{ $proyekApproval->kode_proyek }}" class="text-hover-primary">
                                                    {{ $proyekApproval->kode_proyek }}
                                                </a>
                                            </td>
                                            <td class="text-start">
                                                <a href="/proyek/view/{{ $proyekApproval->kode_proyek }}" class="text-hover-primary">
                                                    {{ $proyekApproval->Proyek->nama_proyek }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ $proyekApproval->PegawaiRequest?->nama_pegawai }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::create($proyekApproval->request_on)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="text-center">{{ $proyekApproval->PegawaiApproved?->nama_pegawai }}
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($proyekApproval->approved_on) ? \Carbon\Carbon::create($proyekApproval->approved_on)->translatedFormat('d F Y') : '' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($proyekApproval->is_revisi)
                                                    <p class="m-0 badge bg-danger">Revisi</p>
                                                @elseif ($proyekApproval->is_approved)
                                                    <p class="m-0 badge bg-success">Disetujui</p>
                                                @elseif (is_null($proyekApproval->is_approved))
                                                    <p class="m-0 badge bg-primary">Proses Persetujuan</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($proyekApproval->is_revisi)
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#kt_modal_catatan_revisi_{{ $proyekApproval->kode_proyek }}">Catatan
                                                    Revisi</button>
                                                @endif
                                            </td>
                                            @if ($isCanApprove)
                                            <td class="text-center">
                                            @if ((is_null($proyekApproval->is_approved)) && is_null($proyekApproval->is_revisi))
                                                <div class="d-flex flex-row justify-content-center">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_approved_{{ $proyekApproval->kode_proyek }}">Approve</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_revisi_{{ $proyekApproval->kode_proyek }}">Revisi</button>
                                                </div>
                                            @endif
                                            </td>                                                
                                            @endif
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

                    <!-- Begin::Modal Approved -->
                    @foreach ($proyeks as $proyekApproval)
                        <form action="/approval-terkontrak-proyek/{{ $proyekApproval->kode_proyek }}/set-approval" method="post" onsubmit="addLoading(this)">
                        @csrf
                            <div class="modal fade" id="kt_modal_approved_{{ $proyekApproval->kode_proyek }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="kt_modal_approvedLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Approved Proyek</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="m-0">Nama Proyek : <span><b>{{ $proyekApproval->Proyek->nama_proyek }}</b></span></p>
                                            <br>
                                            <p class="m-0">Apakah anda yakin proyek tersebut disetujui?</p>
                                            <small>(Pastikan data input proyek tersebut sudah sesuai)</small>
                                            <input type="hidden" name="button-selected" value="approved">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    @endforeach
                    <!-- End::Modal Approved -->
                    
                    <!-- Begin::Modal Revisi -->
                    @foreach ($proyeks as $proyekApproval)
                        <form action="/approval-terkontrak-proyek/{{ $proyekApproval->kode_proyek }}/set-approval" method="post" onsubmit="addLoading(this)">
                        @csrf
                        <div class="modal fade" id="kt_modal_revisi_{{ $proyekApproval->kode_proyek }}" aria-hidden="true" aria-labelledby="kt_modal_revisiLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="kt_modal_revisiLabel">Permohonan Revisi Approval</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="m-0">Nama Proyek : <span><b>{{ $proyekApproval->Proyek->nama_proyek }}</b></span></p>
                                    <br>
                                    <p class="m-0">Apakah anda yakin proyek tersebut direvisi?</p>
                                    <small>(Pastikan data input proyek tersebut sudah sesuai)</small>
                                    <input type="hidden" name="button-selected" value="revisi">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" id="next" data-bs-target="#kt_modal_revisi2_{{ $proyekApproval->kode_proyek }}" data-bs-toggle="modal">Next</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal fade" id="kt_modal_revisi2_{{ $proyekApproval->kode_proyek }}" aria-hidden="true" aria-labelledby="kt_modal_revisiLabel2" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="kt_modal_revisiLabel2">Permohonan Revisi Approval</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <textarea name="revisi-note" id="revisi-note" rows="10" class="form-control form-control-solid"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>                        
                    @endforeach
                    <!-- End::Modal Revisi -->

                    <!-- Begin::Modal Catatan Revisi -->
                    @foreach ($proyeks->where('is_revisi', true) as $proyekApproval)
                        <div class="modal fade" id="kt_modal_catatan_revisi_{{ $proyekApproval->kode_proyek }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="kt_modal_approvedLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="kt_modal_approvedLabel">Catatan Revisi</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="revisi-note" id="revisi-note" rows="15" class="form-control form-control-solid" disabled>{!! $proyekApproval->revisi_note !!}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    @endforeach
                    <!-- End::Modal Catatan Revisi -->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

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

        function addLoading(elt) {
            LOADING_BODY.block();
            return true;
        }
    </script>
@endsection

<!--end::Main-->
