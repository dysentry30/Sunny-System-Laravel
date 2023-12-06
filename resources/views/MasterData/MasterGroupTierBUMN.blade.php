{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Group Tier BUMN')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Group Tier BUMN
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @if (auth()->user()->check_administrator || str_contains(auth()->user()->name, '(PIC)'))
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" data-bs-target="#kt_modal_create_group_tier"
                                        data-bs-toggle="modal" class="btn btn-sm btn-primary py-3"
                                        style="background-color:#008CB4; padding: 6px">
                                        Tambah Group Tier BUMN</a>

                                </div>
                                <!--end::Actions-->
                            @endif
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
                                        <th class="min-w-auto text-white">Nama Pelanggan</th>
                                        <th class="min-w-auto text-white">Instansi</th>
                                        <th class="min-w-auto text-white">Kategori</th>
                                        <th class="min-w-auto text-white">Action</th>
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
                                            <td class="align-middle">{{ $item->nama_pelanggan }}</td>
                                            <td class="text-center align-middle">BUMN</td>
                                            <td class="text-center align-middle">{{ $item->kategori }}</td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-primary text-white" style="background-color: #008CB4;" onclick="showModal('{{ $item->id }}')">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-danger text-white"
                                                        onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                </div>
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

    <!--begin::Modal Tambah Kriteria Green Line-->
    <div class="modal fade" id="kt_modal_create_group_tier" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Tambah Group Tier</h2>
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

                <form action="/master-group-tier/save" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="kt_modal_create_otomasi_approval">
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
                                        <span class="required">Nama Pelanggan</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="d-flex flex-row gap-2">
                                        <!--begin::Input-->
                                        <select id="nama_pelanggan" name="nama_pelanggan"
                                            class="form-select form-select-solid"data-hide-search="false" data-placeholder="Pilh Pelanggan" aria-hidden="true">
                                            <option value="" selected></option>
                                            @foreach ($customer as $pelanggan)
                                            <option value="{{ $pelanggan->id_customer }}">{{ $pelanggan->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" name="nama_pelanggan"
                                            class="form-control form-control-solid"> --}}
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->

                            <div class="">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Kategori</span>
                                </label>
                                <!--Input-->
                                <select id="kategori" name="kategori"
                                    class="form-select form-select-solid"data-hide-search="false" data-placeholder="Pilh Kategori" aria-hidden="true">
                                    <option value="" selected></option>
                                    <option value="Tier A">Tier A</option>
                                    <option value="Tier B">Tier B</option>
                                    <option value="Tier C">Tier C</option>
                                </select>
                                <!--Input-->
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="new_save"
                            style="background-color:#008CB4">Save</button>

                    </div>
                    <!--end::Modal body-->
                </form>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal Tambah Kriteria Green Line-->

    <!--begin::Modal Edit Kriteria Green Line-->
    @foreach ($data as $item)
        <div class="modal fade" id="kt_modal_edit_group_{{ $item->id }}" tabindex="-1"
            aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Edit Group Tier</h2>
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

                    <form action="/master-group-tier/{{ $item->id }}/edit" method="POST">
                        @csrf
                        <input type="hidden" name="modal"
                            value="kt_modal_edit_group_{{ $item->id }}">
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
                                            <span class="required">Nama Pelanggan</span>
                                        </label>
                                        <!--end::Label-->
                                        <div class="d-flex flex-row gap-2">
                                            <!--begin::Input-->
                                            <select id="nama_pelanggan_{{ $item->id }}" name="nama_pelanggan"
                                                class="form-select form-select-solid" data-hide-search="false" data-placeholder="Pilh Pelanggan..." aria-hidden="true">
                                                <option value="" selected></option>
                                                @foreach ($customer as $pelanggan)
                                                    <option value="{{ $pelanggan->id_customer }}" {{ $pelanggan->id_customer == $item->id_pelanggan ? 'selected' : '' }}>{{ $pelanggan->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="nama_pelanggan"
                                                class="form-control form-control-solid"
                                                value="{{ $item->nama_pelanggan }}"> --}}
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->

                                <div class="">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kategori</span>
                                    </label>
                                    <!--Input-->
                                    <select id="kategori_{{ $item->id }}" name="kategori"
                                        class="form-select form-select-solid"data-hide-search="false" data-placeholder="Pilh Kategori" aria-hidden="true">
                                        <option value="" selected></option>
                                        <option value="Tier A" {{ $item->kategori == "Tier A" ? "selected" : "" }}>Tier A</option>
                                        <option value="Tier B" {{ $item->kategori == "Tier B" ? "selected" : "" }}>Tier B</option>
                                        <option value="Tier C" {{ $item->kategori == "Tier C" ? "selected" : "" }}>Tier C</option>
                                    </select>
                                    <!--Input-->
                                </div>
                            </div>
                            <!--End::Row Kanan+Kiri-->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </form>
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    @endforeach
    <!--end::Modal Edit Kriteria Green Line-->


    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
@endsection

@section('js-script')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        const req = await fetch(`{{ url('/master-group-tier/${id}/delete') }}`, {
                            method: 'POST',
                            header: {
                                "content-type": "application/json",
                            },
                            body: formData
                        }).then(res => res.json());
                        if (req.Success != true) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus!'
                            }).then(res => window.location.reload())
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus!'
                        }).then(res => window.location.reload())
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: error
                        }).then(res => window.location.reload())
                    }
                }
            })
        }

        function setActive(e, id = null) {
            if (e.value == "create") {
                const elementFinish = document.querySelector('#finish-periode');
                if (e.checked) {
                    elementFinish.classList.add('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                    elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
                } else {
                    elementFinish.classList.remove('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                    elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
                }
            } else {
                const elementFinish = document.querySelector(`#finish-periode-edit-${id}`);
                if (e.checked) {
                    elementFinish.classList.add('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').setAttribute('disabled', true);
                    elementFinish.querySelector('select[name="tahun_finish"]').setAttribute('disabled', true);
                } else {
                    console.log(elementFinish);
                    elementFinish.classList.remove('d-none');
                    elementFinish.querySelector('select[name="bulan_finish"]').removeAttribute('disabled');
                    elementFinish.querySelector('select[name="tahun_finish"]').removeAttribute('disabled');
                }
            }
        }
    </script>

    <script>
        function showModal(id) {
            let modal = document.getElementById('kt_modal_edit_group_' + id);
            $(modal).modal('show');
            let select2 = document.getElementById('nama_pelanggan_' + id);
            let select2Kategori = document.getElementById('kategori_' + id);
            $(select2).select2({
                dropdownParent: $(modal)
            });
            $(select2Kategori).select2({
                dropdownParent: $(modal)
            });
        }
    </script>

    <script>
        $(document).ready(function(){
            $("#nama_pelanggan").select2({
                dropdownParent: $("#kt_modal_create_group_tier")
            });
            $("#kategori").select2({
                dropdownParent: $("#kt_modal_create_group_tier")
            });
        })
    </script>
@endsection

<!--end::Main-->
