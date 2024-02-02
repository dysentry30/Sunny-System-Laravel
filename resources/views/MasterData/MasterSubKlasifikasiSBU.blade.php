{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master Sub Klasifikasi SBU')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Master Sub Klasifikasi SBU
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            @canany(['super-admin', 'admin-crm'])
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                    <!--begin::Button-->
                                    <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create" id="kt_toolbar_primary_button"
                                        style="background-color:#008CB4; padding: 6px">
                                        New</a>
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
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-25px">No.</th>
                                        <th class="min-w-auto">Klasifikasi</th>
                                        <th class="min-w-auto">Sub Klasifikasi</th>
                                        <th class="min-w-100px">Kode Sub Klasifikasi</th>
                                        <th class="min-w-100px">Kode KBLI 2020</th>
                                        @canany(['super-admin'])
                                            <th class="min-w-100px">Action</th>
                                        @endcanany
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

                                            <!--begin::No-->
                                            <td class="text-center">
                                                {{ $no++ }}
                                            </td>
                                            <!--end::No-->

                                            <!--begin::Nama Company-->
                                            <td class="text-start">{{ $item->MasterKlasifikasiSBU->klasifikasi }}</td>
                                            <!--end::Nama Company-->
                                            <!--begin::Nama Company-->
                                            <td class="text-start">{{ $item->subklasifikasi }}</td>
                                            <!--end::Nama Company-->
                                            <!--begin::Nama Company-->
                                            <td class="text-center">{{ $item->kode_subklasifikasi }}</td>
                                            <!--end::Nama Company-->
                                            <!--begin::Nama Company-->
                                            <td class="text-center">{{ $item->kbli_2020 }}</td>
                                            <!--end::Nama Company-->

                                            @canany(['super-admin'])
                                                <!--begin::Action-->
                                                <td class="text-center">
                                                    <div class="d-flex flex-row gap-2 justify-content-center">
                                                        <!--begin::Button-->
                                                        <button class="btn btn-sm btn-light btn-primary" onclick="showModal('{{ $item }}')">Edit</button>
                                                        <button class="btn btn-sm btn-light btn-hover-danger"
                                                            onclick="deleteItem('{{ $item->id }}')">Delete</button>
                                                        <!--end::Button-->
                                                    </div>
                                                </td>
                                                <!--end::Action-->
                                            @endcanany
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
    <form action="/master-subklasifikasi-sbu/save" method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <input type="hidden" name="modal" value="kt_modal_create">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>New Sub Klasifikasi SBU</h2>
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
                                        <span class="required">Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select id="klasifikasi" name="klasifikasi"
                                        class="form-select form-select-solid select2-hidden-accessible"
                                        data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi"
                                        data-select2-id="select2-klasifikasi" tabindex="-1" aria-hidden="true">
                                        <option value="" selected></option>
                                        @foreach ($klasifikasiSBU as $klasifikasi)
                                            <option value="{{ $klasifikasi->id_klasifikasi }}">{{ $klasifikasi->klasifikasi }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--End begin::Col-->
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Sub Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="subklasifikasi"
                                    name="subklasifikasi" value="" placeholder="Sub Klasifikasi" />
                                    <!--end::Input-->
                                </div>
                                <!--begin::Input group Website-->
                            </div>
                            <!--begin::Col-->
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Kode Sub Klasifikasi</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kode_subklasifikasi"
                                    name="kode_subklasifikasi" value="" placeholder="Kode Sub Klasifikasi" />
                                    <!--end::Input-->
                                </div>
                                <!--begin::Input group Website-->
                            </div>
                            <!--begin::Col-->
                            <!--begin::Col-->
                            <div class="">
                                <!--begin::Input group Website-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">KBLI 2020</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" id="kbli_2020"
                                    name="kbli_2020" value="" placeholder="KBLI 2020" />
                                    <!--end::Input-->
                                </div>
                                <!--begin::Input group Website-->
                            </div>
                            <!--begin::Col-->
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
    <!--end::Modals-->

    <!--begin::Modals Edit-->
    @foreach ($data as $item)
        <form action="/master-subklasifikasi-sbu/{{ $item->id }}/edit" method="post"
            enctype="multipart/form-data">
            @csrf
            <!--begin::Modal - Create Proyek-->
            <div class="modal fade" id="kt_modal_edit_{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <input type="hidden" name="modal" value="kt_modal_edit_{{ $item->id }}">
            <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Edit Sub Klasifikasi SBU</h2>
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
                                            <span class="required">Klasifikasi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select id="klasifikasi_{{ $item->id }}" name="klasifikasi"
                                            class="form-select form-select-solid select2-hidden-accessible"
                                            data-control="select2" data-hide-search="false" data-placeholder="Pilih Klasifikasi"
                                            data-select2-id="select2-klasifikasi-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <option value=""></option>
                                            @foreach ($klasifikasiSBU as $klasifikasi)
                                                <option value="{{ $klasifikasi->id_klasifikasi }}" {{ $item->klasifikasi_id == $klasifikasi->id_klasifikasi ? 'selected' : '' }}>{{ $klasifikasi->klasifikasi }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--End begin::Col-->
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Sub Klasifikasi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="subklasifikasi"
                                        name="subklasifikasi" value="{{ $item->subklasifikasi }}" placeholder="Sub Klasifikasi" />
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Input group Website-->
                                </div>
                                <!--begin::Col-->
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Kode Sub Klasifikasi</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="kode_subklasifikasi"
                                        name="kode_subklasifikasi" value="{{ $item->kode_subklasifikasi }}" placeholder="Kode Sub Klasifikasi" />
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Input group Website-->
                                </div>
                                <!--begin::Col-->
                                <!--begin::Col-->
                                <div class="">
                                    <!--begin::Input group Website-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">KBLI 2020</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" id="kbli_2020"
                                        name="kbli_2020" value="{{ $item->kbli_2020 }}" placeholder="KBLI 2020" />
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Input group Website-->
                                </div>
                                <!--begin::Col-->
                            </div>
                            <!--End::Row Kanan+Kiri-->
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white"
                                id="new_save" style="background-color:#008CB4">Save</button>

                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Create App-->
        </form>
    @endforeach
    <!--end::Modals Edit-->
@endsection
<!--end::Main-->
@section('js-script')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kt_customers_table').DataTable({
                stateSave: true,
                ordering: false
            });
            $("#klasifikasi").select2({
                dropdownParent: $("#kt_modal_create")
            });
        });

        async function deleteItem(id) {
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
                        const req = await fetch(`{{ url('/master-subklasifikasi-sbu/${id}/delete') }}`, {
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
        
        function showModal(subklasifikasi) {
            const subKlasifikasiData = JSON.parse(subklasifikasi);
            let modal = document.getElementById('kt_modal_edit_' + subKlasifikasiData.id);

            $(modal).modal('show');

            let select2 = document.getElementById('klasifikasi_' + subKlasifikasiData.id);
            $(select2).select2({
                dropdownParent: modal
            })
        }
    </script>
@endsection