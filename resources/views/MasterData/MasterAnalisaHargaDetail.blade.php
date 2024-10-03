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

                <!--begin::Content-->
                <form action="/analisa-harga-satuan/detail/save/{{ $masterAHS->id }}" method="post">
                    @csrf
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
                                    <div class="d-flex align-items-center py-2">
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-sm btn-primary" style="background-color:#008CB4;">Save</button>
                                        <!--save::Button-->
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
                                <br>
                                <br>

                                <h4>Kode AHS</h4>
                                <input type="text" class="form-control form-control-solid" id="kode-ahs" name="kode-ahs" value="{{ $masterAHS->kode_ahs }}" placeholder="Kode AHS" max="15"/>
                                <br>
                                <br>
                                
                                <h4>Uraian</h4>
                                <input type="text" class="form-control form-control-solid" id="uraian" name="uraian" value="{{ $masterAHS->uraian }}" placeholder="Uraian" />
                                
                                <br>
                                <br>
                                <br>
                                <br>

                                <!--begin::Table-->
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="sumber-daya-detail-table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto">Code</th>
                                            <th class="min-w-auto">Parent Code</th>
                                            <th class="min-w-auto">Description</th>
                                            <th class="min-w-auto">Uoms Name</th>
                                            <th class="min-w-auto">Material Code</th>
                                            <th class="min-w-auto">Jenis Material</th>
                                            <th class="min-w-auto">Nama Material</th>
                                            <th class="min-w-auto">Valuation Class Code</th>
                                            <th class="min-w-auto">Valuation Class Name</th>
                                            <th class="min-w-auto">Keterangan</th>
                                            <th class="min-w-auto">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <!--begin::Table row-->
                                        {{-- @foreach ($masterSumberDaya as $sumber_daya)
                                        <tr>
                                            <td class="text-center">{{ $sumber_daya->code }}</td>
                                            <td class="text-start">{{ $sumber_daya->parent_code }}</td>
                                            <td class="text-start">{{ $sumber_daya->description }}</td>
                                            <td class="text-center">{{ $sumber_daya->uoms_name }}</td>
                                            <td class="text-center">{{ $sumber_daya->material_code }}</td>
                                            <td class="text-center">{{ $sumber_daya->jenis_material }}</td>
                                            <td class="text-start">{{ $sumber_daya->material_name }}</td>
                                            <td class="text-start">{{ $sumber_daya->valuation_class_code }}</td>
                                            <td class="text-start">{{ $sumber_daya->valuation_class_name }}</td>
                                            <td class="text-start">{{ $sumber_daya->keterangan }}</td>
                                            <td class="text-center">
                                                <input class="form-check-input mt-0" type="checkbox"
                                                value="{{ $sumber_daya->kode_sumber_daya }}"
                                                id="sumber_daya_{{ $sumber_daya->kode_sumber_daya }}"
                                                name="checklist-sumber-daya[]"
                                                {{ $masterSumberDayaDetail->contains(function($item) use($sumber_daya){
                                                    return $item->kode_sumber_daya == $sumber_daya->kode_sumber_daya;
                                                }) ? "checked" : "" }}>
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--end::Container-->
                        <!--end::Post-->


                    </div>
                </form>
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
        let selectedIds = []; // Array untuk menyimpan ID checkbox yang dipilih

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
                    className: 'align-midle text-center'
                },
                {
                    data: 'material_name',
                    className: 'align-midle'
                },
                {
                    data: 'valuation_class_code',
                    className: 'align-midle text-center'
                },
                {
                    data: 'valuation_class_name',
                    className: 'align-midle'
                },
                {
                    data: 'keterangan',
                    className: 'align-midle'
                },
                {
                    data: null, // Kolom untuk checkbox
                    orderable: false,
                    render: function (data, type, row) {
                        // Cek apakah ID row sudah dipilih
                        let isChecked = selectedIds.includes(row.id) ? 'checked' : '';
                        return `<input type="checkbox" class="row-checkbox form-check-input" data-id="${row.id}" ${isChecked}>`;
                    },
                    className: 'align-middle text-center'
                },
            ];

            configDataTable.drawCallback = function () {
                // Ketika tabel di-*render* ulang (misalnya setelah search atau paginate), set ulang status checkbox
                $('#sumber-daya-detail-table tbody input.row-checkbox').each(function () {
                    let id = $(this).data('id');
                    if (selectedIds.includes(id)) {
                        $(this).prop('checked', true);
                    }
                });
                console.log(selectedIds);
            }

            const dataTable = $('#sumber-daya-detail-table').DataTable(configDataTable);
        });

        // Event listener untuk checkbox per baris
        $('#sumber-daya-detail-table tbody').on('change', 'input.row-checkbox', function () {
            let id = $(this).data('id');
            if ($(this).is(':checked')) {
                if (!selectedIds.includes(id)) {
                    selectedIds.push(id); // Tambahkan ID ke array jika belum ada
                }
            } else {
                selectedIds = selectedIds.filter(item => item !== id); // Hapus ID dari array jika tidak dicentang
            }
        });
        
    </script>
    <!--end::Data Tables-->

@endsection
