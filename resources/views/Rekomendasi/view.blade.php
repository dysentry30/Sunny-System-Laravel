{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Tinjauan Dokumen Kontrak')
{{-- End::Title --}}

<style>
    .buttons-html5 {
        border-radius: 5px !important;
        border: none !important;
        padding: 10 20 10 20 !important;
        font-weight: normal !important;
    }
    .buttons-colvis {
        border: none !important;
        border-radius: 5px !important;
    }
    .animate.slide {
        transition: .3s all linear;
    }
    .form-control.form-control-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }

    .form-select.form-select-solid {
        border-left: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-bottom: 1px dashed #b5b5c3 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
    }

    #nilai-kontrak-keseluruhan::placeholder {
        color: #D9214E;
        opacity: 1;
        /* Firefox */
    }
</style>

<!--begin::Main-->
@section('content')
    <!--begin::Root-->
    <div class=" d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!--begin::Header-->
                @include('template.header')
                <!--end::Header-->


                <!--begin::Content-->
                <div class="container mx-3 mt-0">
                    <h1>Add Tinjauan Dokumen Kontrak - {{ $contract->stages == 1 ? "Perolehan" : "Pelaksanaan" }}</h1>
                </div>
                

                

            </div>
            <!--end::Card body-->

        </div>
        <!--end::Content-->

    </div>
    <!--end::Contacts App- Edit Contact-->

@endsection

@section('js-script')
<!--begin::Data Tables-->

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
            $('#tinjauan-kontrak').DataTable( {
                // dom: 'Bfrtip',
                dom: 'Brti',
                pageLength : 45,
                ordering: false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data Tinjauan Dokumen Kontrak'
                    },
                        'copy', 'pdf', 'print'
                    ]
            } );
        });
    </script>
@endsection
