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
                                    <div class="d-flex align-items-center py-2 gap-2">
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-sm btn-primary" style="background-color:#008CB4;">Save</button>
                                        <!--save::Button-->
                                        <!--begin::Button-->
                                        <a href="/analisa-harga-satuan" class="btn btn-sm btn-secondary">Back</a>
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
                                
                                <h4>Satuan</h4>
                                <input type="text" class="form-control form-control-solid" id="satuan" name="satuan" value="{{ $masterAHS->satuan }}" placeholder="Satuan" />
                                
                                <br>
                                <br>
                                <br>
                                <br>


                                <div class="">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <br>
                                        <br>
                                    @endif
                                    <h3>Sumber Daya AHS
                                        <a href="#" Id="Plus" data-bs-toggle="modal" data-bs-target="#kt_modal_tambah_sumber_daya">+</a>
                                    </h3>
                                    <br>

                                    <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="list-sumber-daya">
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
                                                <th class="min-w-auto">Koefisien</th>
                                                <th class="min-w-auto">Action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <!--begin::Table row-->
                                            @foreach ($masterSumberDayaDetail as $resource)
                                                <tr>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->code }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->parent_code }}</td>
                                                    <td class="text-start">{{ $resource->MasterSumberDaya?->name }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->uoms_name }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->material_code }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->jenis_material }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->material_name }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->valuation_class_code }}</td>
                                                    <td class="text-center">{{ $resource->MasterSumberDaya?->valuation_class_name }}</td>
                                                    <td class="text-start">{{ $resource->MasterSumberDaya?->keterangan }}</td>
                                                    <td class="text-center">{{ $resource->koef }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="showModal('{{ $resource->id }}', '{{ $resource->resource_code }}', '{{ !empty($resource->formula) ?: false }}')">Formula</button>
                                                        <a href="#" class="btn btn-sm btn-danger text-white">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!--end::Table row-->
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>


                                </div>
                                <!--begin::Table-->
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

                <!--begin::Modal-->
                <!--begin::Modal - Add Sumber Daya-->
                <div class="modal fade" id="kt_modal_tambah_sumber_daya" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2>Tambah Sumber Daya</h2>
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
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Modal body-->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save" onclick="saveSumberDaya()"
                                    style="background-color:#008CB4">Save</button>

                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Add Sumber Daya-->
                
                <!--begin::Modal - Add Formula-->
                @foreach ($masterSumberDayaDetail as $sumberDaya)
                    @if (empty($sumberDaya->formula))
                        <form method="POST" action="/analisa-harga-satuan/sumber-daya/{{ $sumberDaya->id }}/save" onsubmit="return handleFormSubmit(this)">
                            @csrf
                            <div class="modal fade" id="kt_modal_tambah_formula_{{ $sumberDaya->id }}" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2>Formula - {{ $sumberDaya->MasterSumberDaya?->name }}</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <span class="svg-icon svg-icon-1">
                                                    <i class="bi bi-x-lg"></i>
                                                </span>
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->

                                        <!--begin::Modal body-->
                                        <div class="modal-body py-lg-6 px-lg-6">
                                            <div id="formula-baru-{{ $sumberDaya->resource_code }}">
                                                <h3>Input Formula
                                                    &nbsp;
                                                    <span>
                                                        <button type="button" class="btn btn-sm btn-primary p-2" onclick="addNewRow('{{ $sumberDaya->resource_code }}', false)">Tambah</button>
                                                    </span>
                                                </h3>
                                                <br>
                                                
                                                <!-- Baris input dinamis -->
                                                <div class="row dynamic-input-row">
                                                    <div class="mb-3 col-3">
                                                        <label for="inputParameter" class="form-label">Parameter</label>
                                                        <input type="text" class="form-control form-control-solid" name="parameter-formula[]" onblur="validateParameter(this)">
                                                        <div id="parameterHelp" class="form-text">Contoh : AN1, AN2, dst.</div>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                                        <input type="text" class="form-control form-control-solid" name="deskripsi-formula[]">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="inputNilai" class="form-label">Nilai</label>
                                                        <input type="text" class="form-control form-control-solid" name="nilai-formula[]" pattern="^\d*(\.\d+)?$" inputmode="decimal">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="inputSatuan" class="form-label">Satuan</label>
                                                        <input type="text" class="form-control form-control-solid" name="satuan-formula[]">
                                                    </div>
                                                </div>
                                        
                                                <!-- Input formula yang harus berada di bawah input dinamis -->
                                                <div class="row">
                                                    <label for="inputFormula" class="form-label">Formula</label>
                                                    <input type="text" class="form-control form-control-solid" name="formula" id="formula">
                                                </div>
                                            </div>
                                        </div>                                
                                        
                                        <!--begin::Modal body-->

                                        <div class="modal-footer">
                                            <button class="btn btn-sm btn-secondary">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    @else
                        <form method="POST" action="/analisa-harga-satuan/sumber-daya/{{ $sumberDaya->id }}/edit" onsubmit="return handleFormSubmit(this)">
                            @csrf
                            <div class="modal fade" id="kt_modal_edit_formula_{{ $sumberDaya->id }}" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2>Formula - {{ $sumberDaya->MasterSumberDaya?->name }}</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <span class="svg-icon svg-icon-1">
                                                    <i class="bi bi-x-lg"></i>
                                                </span>
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
        
                                        <!--begin::Modal body-->
                                        <div class="modal-body py-lg-6 px-lg-6">
                                            <div id="formula-edit-{{ $sumberDaya->resource_code }}">
                                                <h3>Edit Formula
                                                    &nbsp;
                                                    <span>
                                                        <button type="button" class="btn btn-sm btn-primary p-2" onclick="addNewRow('{{ $sumberDaya->resource_code }}', true)">Tambah</button>
                                                    </span>
                                                </h3>
                                                <br>
                                                
                                                <!-- Baris input dinamis -->
                                                @php
                                                    $dataFormula = collect(json_decode($sumberDaya->formula));
                                                @endphp
                                                @forelse ($dataFormula as $item)
                                                    <div class="row dynamic-input-row">
                                                        <div class="mb-3 col-3">
                                                            <label for="inputParameter" class="form-label">Parameter</label>
                                                            <input type="text" class="form-control form-control-solid" name="parameter-formula[]" value="{{ $item->parameter }}" onblur="validateParameter(this)">
                                                            <div id="parameterHelp" class="form-text">Contoh : AN1, AN2, dst.</div>
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                                            <input type="text" class="form-control form-control-solid" name="deskripsi-formula[]" value="{{ $item->deskripsi }}">
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputNilai" class="form-label">Nilai</label>
                                                            <input type="text" class="form-control form-control-solid" name="nilai-formula[]" pattern="^\d*(\.\d+)?$" inputmode="decimal" value="{{ $item->nilai }}">
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputSatuan" class="form-label">Satuan</label>
                                                            <input type="text" class="form-control form-control-solid" name="satuan-formula[]" value="{{ $item->satuan }}">
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="row dynamic-input-row">
                                                        <div class="mb-3 col-3">
                                                            <label for="inputParameter" class="form-label">Parameter</label>
                                                            <input type="text" class="form-control form-control-solid" name="parameter-formula[]" onblur="validateParameter(this)">
                                                            <div id="parameterHelp" class="form-text">Contoh : AN1, AN2, dst.</div>
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                                            <input type="text" class="form-control form-control-solid" name="deskripsi-formula[]">
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputNilai" class="form-label">Nilai</label>
                                                            <input type="text" class="form-control form-control-solid" name="nilai-formula[]" pattern="^\d*(\.\d+)?$" inputmode="decimal">
                                                        </div>
                                                        <div class="mb-3 col-3">
                                                            <label for="inputSatuan" class="form-label">Satuan</label>
                                                            <input type="text" class="form-control form-control-solid" name="satuan-formula[]">
                                                        </div>
                                                    </div>
                                                @endforelse
                                                <!-- Input formula yang harus berada di bawah input dinamis -->
                                                <div class="row">
                                                    <label for="inputFormula" class="form-label">Formula</label>
                                                    <input type="text" class="form-control form-control-solid" name="formula" id="formula" value="{{ $dataFormula[0]->formula }}">
                                                </div>
                                            </div>
                                        </div>                                
                                        
                                        <!--begin::Modal body-->
        
                                        <div class="modal-footer">
                                            <button class="btn btn-sm btn-secondary">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    @endif
                @endforeach
                <!--end::Modal - Add Formula-->

                <!--end::Modals-->
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
        const LOADING_BODY = new KTBlockUI(document.querySelector('#kt_body'), {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        })
    </script>
    
    <script>
        function showModal(id, resourceCode, isEdit) {
            let modal;

            if (!isEdit) {
                modal = document.getElementById('kt_modal_tambah_formula_' + id);
            } else {
                modal = document.getElementById('kt_modal_edit_formula_' + id);
            }
            

            $(modal).modal('show');
        }
    </script>

    <script>
        // Fungsi untuk menambahkan baris input baru
        function addNewRow(resourceCode, isEdit) {
            let formulaContainer;

            if (!isEdit) {
                formulaContainer = document.getElementById(`formula-baru-${resourceCode}`);
            } else {
                formulaContainer = document.getElementById(`formula-edit-${resourceCode}`);
            }
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'dynamic-input-row');
            
            newRow.innerHTML = `
                <div class="mb-3 col-3">
                    <label for="inputParameter" class="form-label">Parameter</label>
                    <input type="text" class="form-control form-control-solid" name="parameter-formula[]" onblur="validateParameter(this)">
                    <div id="parameterHelp" class="form-text">Contoh : AN1, AN2, dst.</div>
                </div>
                <div class="mb-3 col-3">
                    <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control form-control-solid" name="deskripsi-formula[]">
                </div>
                <div class="mb-3 col-3">
                    <label for="inputNilai" class="form-label">Nilai</label>
                    <input type="text" class="form-control form-control-solid" name="nilai-formula[]">
                </div>
                <div class="mb-3 col-3">
                    <label for="inputSatuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control form-control-solid" name="satuan-formula[]">
                </div>`;
            
            // Menambahkan baris baru di atas input formula
            formulaContainer.insertBefore(newRow, formulaContainer.querySelector('.row:last-child'));
        }

        // Fungsi untuk hanya mengirim inputan yang lengkap
        function handleFormSubmit(form) {
            const rows = form.querySelectorAll('.dynamic-input-row');
            let valid = true;

            rows.forEach(row => {
                const inputs = row.querySelectorAll('input');
                const isEmpty = Array.from(inputs).some(input => input.value.trim() === '');

                if (isEmpty) {
                    row.remove(); // Hapus baris yang inputannya tidak lengkap
                }
            });

            const formulaInput = form.querySelector('#formula').value;

            if (!formulaInput.startsWith('=')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Input formula harus diawali dengan "="'
                });

                return false; // Mencegah form dari pengiriman
            }

            if (formulaInput.includes(';')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formula tidak boleh mengandung karakter ";". Mohon diubah menggunakan ",".'
                });

                return false; // Mencegah form dari pengiriman
            }

            return true; // Lanjutkan submit form
        }

        // Fungsi untuk memvalidasi input parameter
        function validateParameter(input) {
            const value = input.value.trim();
            const regex = /^AN\d+$/; // Regex untuk validasi "AN" diikuti angka
            if (!regex.test(value)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Input Parameter harus sesuai dengan format "AN" diikuti angka, contoh: AN1, AN2, dst.'
                });
            }
        }
    </script>
    
    <script>
        let selectedIds = []; // Array untuk menyimpan ID checkbox yang dipilih

        const configDataTable = {};
        configDataTable.processing = true
        configDataTable.serverSide = true
        configDataTable.destroy = true
        configDataTable.search = false
        configDataTable.paging = true
        configDataTable.pageLength = 10
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

        function saveSumberDaya() {
            Swal.fire({
                title: 'Apakah data anda sudah sesuai?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    LOADING_BODY.block();
                    try {
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("selectedId", JSON.stringify(selectedIds));
                        const req = await fetch(`{{ url('/analisa-harga-satuan/detail/sumberdaya/save/') . '/' . $masterAHS->id }}`, {
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
                                title: 'Data gagal ditambahkan',
                                text: req.message
                            })
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil ditambahkan'
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
        
    </script>
    <!--end::Data Tables-->

@endsection
