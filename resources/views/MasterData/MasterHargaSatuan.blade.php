{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Harga Satuan')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Harga Satuan
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

                        <!--begin::Card body-->
                        <div class="card-body pt-3 ">

                            <!--begin::Table-->
                            <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="user_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Kode Sumber Daya</th>
                                        <th class="min-w-500px">Uraian</th>
                                        <th class="min-w-auto">Satuan</th>
                                        <th class="min-w-auto">Harga Satuan</th>
                                        <th class="min-w-auto">Provinsi</th>
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
                                    @foreach ($masterHargaSatuan as $harga_satuan)
                                        <tr>
                                            <td class="text-center">{{$harga_satuan->kode_sumber_daya}}</td>
                                            <td class="text-start">{{$harga_satuan->MasterSumberDaya->uraian}}</td>
                                            <td class="text-center">{{$harga_satuan->MasterSumberDaya->satuan}}</td>
                                            <td class="text-end">Rp. {{number_format($harga_satuan->harga, 0, ',', '.')}}</td>
                                            <td class="text-center">{{\App\Models\Provinsi::find($harga_satuan->province_id)->province_name}}</td>
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

    <!--begin::Modal New User-->
    <!--end::Modal New User-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    
    <script>
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
    </script>
    <!--end::Data Tables-->

@endsection
