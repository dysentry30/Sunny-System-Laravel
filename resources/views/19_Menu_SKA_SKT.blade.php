{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'SKK SKT')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">SKK SKT
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @canany(['super-admin'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-sm btn-primary py-3" style="background-color: #008CB4" onclick="updateSKASKT()">Update SKK SKT</button>
                                    <!--End::Button-->
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
                                        <th class="min-w-auto text-white">NIP</th>
                                        <th class="min-w-auto text-white">Nama Pegawai</th>
                                        <th class="min-w-auto text-white">Bidang</th>
                                        <th class="min-w-auto text-white">Lokasi Penempatan</th>
                                        <th class="min-w-auto text-white">Nomor Registrasi</th>
                                        <th class="min-w-auto text-white">Kualifikasi</th>
                                        <th class="min-w-auto text-white">Kategori Sertifikat</th>
                                        <th class="min-w-auto text-white">Penerbit Sertifikat</th>
                                        <th class="min-w-auto text-white">Unduh Sertifikat</th>
                                        <th class="min-w-auto text-white">Issued Date</th>
                                        <th class="min-w-auto text-white">Expired Date</th>
                                        <th class="min-w-auto text-white">Tgl Mulai SK Penempatan</th>
                                        <th class="min-w-auto text-white">Status Karyawan</th>
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
                                            <td class="align-middle">{{ $item->nip }}</td>
                                            <td class="align-middle">{{ $item->Pegawai?->nama_pegawai }}</td>
                                            <td class="align-middle">{{ $item->nama_sertifikat }}</td>
                                            <td class="align-middle">{{ $item->emp_position_name }}</td>
                                            <td class="text-center align-middle">{{ $item->no_sertifikat }}</td>
                                            <td class="text-center align-middle">{{ $item->level_sertifikat }}</td>
                                            <td class="text-center align-middle">{{ $item->category_sertifikat}}</td>
                                            <td class="text-center align-middle">{{ $item->institusi_penerbit_sertifikat }}</td>
                                            <td class="text-center align-middle">
                                                @if (!empty($item->file_sertifikat))
                                                    <a href="{{ $item->file_sertifikat }}" class="btn btn-sm btn-primary text-white">Download</a>
                                                @else
                                                    <p class="m-0">Belum ada sertifikat</p>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->issued_date)->translatedFormat('d F Y') }}</td>
                                            <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->expired_date)->translatedFormat('d F Y') }}</td>
                                            <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->emp_start_date)->translatedFormat('d F Y') }}</td>
                                            <td class="text-center align-middle"><p class="m-0 badge rounded-pill {{ $item->status_kepegawaian == "AKTIF" ? "bg-success" : "bg-danger" }}">{{ $item->status_kepegawaian }}</p></td>
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

        function updateSKASKT() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then(async (result)=>{
                if(result.isConfirmed){
                    LOADING_BODY.block();
                    try {
                        const req = await fetch(`{{ url('/ska-skt/get-data') }}`, {
                            method: 'GET',
                            header: {
                                "content-type": "application/json",
                            }
                        }).then(res => res.json());
                        LOADING_BODY.release();
                        if (req.Success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: req.Message
                            }).then(res=>window.location.reload())
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: req.Message
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
    </script>
@endsection

<!--end::Main-->
