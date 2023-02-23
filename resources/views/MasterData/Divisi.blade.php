{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Divisi')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Divisi
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->

                            {{-- <button class="btn btn-sm btn-light btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create">Tambah Divisi</button> --}}

                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->


                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">


                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-60px text-center">@sortablelink('nomor_unit', 'Kode SAP')</th>
                                        <th class="min-w-auto">@sortablelink('unit_kerja', 'Nama Unit')</th>
                                        <th class="min-w-auto">@sortablelink('divcode', 'Divcode')</th>
                                        {{-- <th class="min-w-auto">@sortablelink('dop', 'DOP')</th> --}}
                                        {{-- <th class="min-w-auto">@sortablelink('company', 'Company')</th>
                                        <th class="min-w-auto">@sortablelink('divisi', 'Divisi PIC')</th>
                                        <th class="min-w-auto">@sortablelink('is_active', 'Is Active')</th>
                                        <th class="min-w-auto">@sortablelink('id_profit_center', 'ID Profit Center')</th> --}}
                                        @if (auth()->user()->check_administrator)
                                            {{-- <th class="text-center">Settings</th> --}}
                                            <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                {{-- @php
												$proyeks = $proyeks->reverse();
												@endphp --}}

                                <tbody class="fw-bold text-gray-600">
                                    @foreach ($divisi_all as $divisi)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td class="text-center">
                                                {{ $divisi->kode_sap }}
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                <a href="#kt_modal_update_{{$divisi->divcode}}" data-bs-toggle="modal" id="click-name"
                                                    class="text-gray-600 text-hover-primary mb-1">{{ $divisi->nama_kantor }}</a>
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->kode_kantor }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            {{-- <td>
                                                {{ $divisi->dop }}
                                            </td> --}}
                                            <!--end::Coloumn-->
                                            <td>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_divisi_{{$divisi->id_divisi}}">Delete</button>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <!--begin::Name=-->
                                            <td class="text-center">
                                                {{ $divisi->UnitKerja->nomor_unit }}
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                <a href="#kt_modal_update_{{$divisi->UnitKerja->divcode}}" data-bs-toggle="modal" id="click-name"
                                                    class="text-gray-600 text-hover-primary mb-1">{{ $divisi->UnitKerja->unit_kerja }}</a>
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->divcode }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->dop }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->company }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->divisi }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->is_active == 1 ? 'Yes' : 'No' }}
                                            </td>
                                            <!--end::Coloumn-->
                                            <!--begin::Coloumn-->
                                            <td>
                                                {{ $divisi->UnitKerja->id_profit_center ?? "-"}}
                                            </td>
                                            <!--end::Coloumn-->
                                            <td>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_delete_divisi_{{$divisi->id_divisi}}">Delete</button>
                                            </td>
                                        </tr> --}}
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
    <form action="/divisi/save" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="modal" value="kt_modal_create">

        <!--begin::Modal - Create App-->
        {{-- <input type="hidden" name="id-customer" value="{{ $customer->id_customer }}" id="id-customer"> --}}

        <!--begin::Modal - Create Proyek-->
        <div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Tambah Divisi</h2>
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
                            <div class="col">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Unit kerja</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--Begin:: Select Options-->
                                    <select id="unit-kerja" name="unit-kerja"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Unit kerja" data-select2-id="select2-data-unit-kerja">
                                    <option value=""></option>
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{$unit_kerja->divcode}}" >{{$unit_kerja->unit_kerja}}</option>
                                        {{-- <option value="{{$dop->id}}" {{$direktorat->dop == $dop->id ? "selected" : ""}}>{{$dop->dop}}</option> --}}
                                    @endforeach
                                </select>
                                <!--End:: Select Options-->
                                </div>
                                <!--end::Input group-->
                            </div>
                        </div>
                        <!--End::Row Kanan+Kiri-->


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary" id="proyek_new_save">Save</button>

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

    <!--begin::modal DELETE-->
    <!--end::modal DELETE-->


@endsection

<!--end::Main-->

@section('js-script')
    <script>
        // let choosenUserIDArray = {
        //     user_1: 0,
        //     user_2: 0,
        //     user_3: 0,
        // };
        let choosenUserIDArray = [];

        function refreshUserData(elt) {
            const choosenUserID = elt.value;
            const thisSelectName = elt.getAttribute("name");
            const selectElts = elt.parentElement.parentElement.querySelectorAll(".select-user");
            choosenUserIDArray = choosenUserIDArray.filter(item => {
                return item != choosenUserID;
            });
            choosenUserIDArray.push(choosenUserID);
            // if (thisSelectName == "user-1") {
            //     choosenUserIDArray.user_1 = choosenUserID;
            // } else if (thisSelectName == "user-2") {
            //     choosenUserIDArray.user_2 = choosenUserID;
            // } else {
            //     choosenUserIDArray.user_3 = choosenUserID;
            // }

            selectElts.forEach(select => {
                const options = select.querySelectorAll("option");
                const selectName = select.getAttribute("name");
                options.forEach(option => {
                    const userID = option.getAttribute("value");
                    const isHasSelect2 = option.hasAttribute("data-select2-id");
                    if (choosenUserIDArray.includes(userID)) {
                        option.setAttribute("disabled", "");
                    } else {
                        option.removeAttribute("disabled");
                    }
                })
            });
        }

        // Begin :: Reset Options for Setting Approval
        function resetSelectOptions(elt, resetAll = true) {
            const selectElts = elt.parentElement.parentElement.querySelectorAll("select");
            if (resetAll) {
                $(selectElts).select2("val", "All");
                selectElts.forEach(select => {
                    const options = select.querySelectorAll("option");
                    const selectName = select.getAttribute("name");
                    options.forEach(option => {
                        const userID = option.getAttribute("value");
                        if (choosenUserIDArray.includes(userID)) {
                            choosenUserIDArray = choosenUserIDArray.filter(item => item != userID);
                        }
                    });
                });
                choosenUserIDArray = choosenUserIDArray.filter(item => item != "");
            }
            refreshUserData(elt);
        }
        // End :: Reset Options for Setting Approval

        // Begin :: Restore All Data for Submtting
        function restoreData(form) {
            // const getFormID = form.getAttribute("id");
            const selectElts = form.parentElement.querySelectorAll(`select`);
            selectElts.forEach(select => {
                const options = select.querySelectorAll("option");
                const selectName = select.getAttribute("name");
                options.forEach(option => {
                    option.removeAttribute("disabled");
                });
            });
            return true;
        }
        // End :: Restore All Data for Submtting
    </script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 

<script>
    $('#kt_customers_table').DataTable({
        stateSave: true,
    });
</script>
@endsection
