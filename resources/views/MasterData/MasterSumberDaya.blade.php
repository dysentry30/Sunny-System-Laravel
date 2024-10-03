{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Sumber Daya')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Sumber Daya
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
                        <div class="overflow-scroll card-body pt-3 ">

                            <!--begin::Table-->
                            <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="sumber-daya-table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-auto">Code</th>
                                        <th class="min-w-auto">Parent Code</th>
                                        <th class="min-w-auto">Name</th>
                                        <th class="min-w-auto">Uoms Name</th>
                                        <th class="min-w-auto">Material Code</th>
                                        <th class="min-w-auto">Jenis Material</th>
                                        <th class="min-w-auto">Nama Material</th>
                                        <th class="min-w-auto">Valuation Class Code</th>
                                        <th class="min-w-auto">Valuation Class Name</th>
                                        <th class="min-w-auto">Keterangan</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
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
        const configDataTable = {};
        configDataTable.processing = true
        configDataTable.serverSide = true
        configDataTable.destroy = true
        configDataTable.search = false
        configDataTable.paging = true
        configDataTable.pageLength = 30
        configDataTable.dom = '<"float-start me-3"f><"#example"t>rtip'

        document.addEventListener("DOMContentLoaded", () => {
            configDataTable.ajax = {
                dataType: "JSON",
                cache: false,
                contentType: "application/json; charset=utf-8",
                url:"{{ url('master-sumber-daya/datatable') }}",
                type: "GET"
            },

            configDataTable.columns = [ 
                {
                    data: 'code',
                    className: 'align-midle text-center'
                },
                {
                    data: 'parent_code',
                    className: 'align-midle'
                },
                {
                    data: 'name',
                    className: 'align-midle'
                },
                {
                    data: 'uoms_name',
                    className: 'align-midle text-center'
                },
                {
                    data: 'material_code',
                    className: 'align-midle text-center'
                },
                {
                    data: 'jenis_material',
                    className: 'align-midle'
                },
                {
                    data: 'material_name',
                    className: 'align-midle'
                },
                {
                    data: 'valuation_class_code',
                    className: 'align-midle'
                },
                {
                    data: 'valuation_class_name',
                    className: 'align-midle'
                },
                {
                    data: 'keterangan',
                    className: 'align-midle'
                },
            ];

            const dataTable = $('#sumber-daya-table').DataTable(configDataTable);
                
        });
    </script>
    <!--end::Data Tables-->

@endsection
