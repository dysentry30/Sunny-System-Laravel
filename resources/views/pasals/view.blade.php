@extends('template.main')
@section('title', 'Edit Pasal')
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

        <!--begin::Header-->
        @extends('template.header')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Edit Pasal
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->

                    @if (auth()->user()->check_administrator)
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <!--begin::Button-->
                                <a class="btn btn-sm btn-primary w-80px" 
                                data-bs-toggle="modal" data-bs-target="#kt_modal_tambah_pasal"  id="kt_toolbar_primary_button"
                                style="background-color:#008CB4; padding: 6px">
                                New</a>
                            <!--end::Button-->
                            <!--begin::Wrapper-->
                            <div class="me-4" style="margin-left:10px;">
                                <!--begin::Menu-->
                                <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-folder2-open"></i>Action</a>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6155ac804a1c2">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Form-->
                                    <div class="">
                                        <!--begin::Item-->
                                        <button type="submit" class="btn btn-active-primary dropdown-item rounded-0 rounded-0"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                        </button>
                                        <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export" disabled>
                                            <i class="bi bi-file-earmark-spreadsheet"></i>Export Excel
                                        </button>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Menu-->
                            </div>
                            <!--end::Wrapper--> 
                        </div>
                        <!--end::Actions-->
                    @endif
                </div>
                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Post-->
            <!--begin::Container-->
            <!--begin::Card-->
            <div class="card" id="List-vv">


                <!--begin::Card header-->
                <div class="card-header border-0 pt-">

                    <!--begin::Card title-->
                    <div class="card-title" style="width: 100%">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center my-1" style="width: 100%;">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <i class="bi bi-search"></i>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-15" placeholder="Search Contract">
                            <!--end::Search-->


                        </div>

                    </div>
                    <!--begin::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-0px text-center">No</th>
                                <th class="w-150px">Kategori Pasal</th>
                                <th class="text-break">Pasal</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600">
                            @foreach ($pasals as $i => $pasal)
                                <tr class="align-baseline">

                                    <!--begin::Nomor=-->
                                    <td>
                                        <p class="mb-1 text-center">
                                            {{ ++$i }}</p>
                                    </td>
                                    <!--end::Nomor=-->

                                    <!--begin::Pasal=-->
                                    <td>
                                        <p>{{ $pasal->tipe_pasal }}</p>
                                    </td>
                                    <!--end::Pasal=-->

                                    <!--begin::Pasal=-->
                                    <td>
                                        <pre type="button" data-bs-toggle="modal" onclick="editPasal(this)"
                                            data-id="{{ $pasal->id_pasal }}" data-bs-target="#kt_modal_edit_pasal"
                                            class="text-hover-primary mb-1 w-50%" 
                                            style="font-family: Poppins;white-space: pre-wrap;word-wrap: break-word;">{{ $pasal->pasal }}</pre>
                                    </td>
                                    <!--end::Pasal=-->

                                    @if (auth()->user()->check_administrator)
                                        <!--begin::Close Btn=-->
                                        <td>
                                            {{-- <a href="/pasal/delete/{{ $pasal->id_pasal }}"
                                            class="btn btn-sm btn-light btn-active-primary" aria-label="Close">Delete </a> --}}
                                            <a data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_delete{{ $pasal->id_pasal }}" id="modal-delete"
                                                class="btn btn-sm btn-light btn-active-primary">Delete</a>
                                        </td>
                                        <!--end::Close Btn=-->
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


        </div>
        <!--end::Content-->
    </div>

    {{-- begin::modal --}}
    {{-- begin::modal Tambah Pasal --}}
    <div class="modal fade" id="kt_modal_tambah_pasal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add Pasal</h2>
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
                <div class="modal-body">

                    <!--begin::Input group Website-->
                    <div class="fv-row">
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tipe Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input class="form-control form-control-solid" name="tipe-pasal" id="tipe-pasal"
                                style="font-weight: normal" rows="10" value="" placeholder="Tipe Pasal"/>
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="pasal" id="pasal"
                                style="font-weight: normal" rows="10" value="" placeholder="Ketikan pasal disini..."></textarea>
                            <!--end::Input-->


                        </div>
                        {{-- <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="add-pasal" style="background-color:#008CB4">Save</button> --}}
                    </div>
                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <button type="button" id="add-pasal" style="background-color:#008CB4"
                        class="btn btn-sm btn-light btn-active-primary text-white">
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-white">Save</span>
                            <span class="spinner-border spinner-border-sm" style="display: none; margin: 0 0 0 1rem;"
                            aria-hidden="true" role="status"></span>
                        </div>
                    </button>
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- end::modal Tambah Pasal --}}

    {{-- begin::modal Edit Pasal --}}
    <div class="modal fade" id="kt_modal_edit_pasal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-800px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Edit Pasal</h2>
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


                    {{-- begin:: loading screen --}}
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" id="loading-edit" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    {{-- end:: loading screen --}}
                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <div class="fv-row mb-5" id="input-grup-edit-pasal" style="display: none;">
                            <!--begin::Input-->
                            <input type="hidden" class="form-control form-control-solid" name="id-pasal"
                                id="id-pasal">
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Tipe Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="tipe-pasal-edit"
                                id="tipe-pasal-edit" style="font-weight: normal" value=""
                                placeholder="Ketikan pasal disini..." />
                            <!--end::Input-->

                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <textarea type="text" class="form-control form-control-solid" name="pasal-edit"
                                id="pasal-edit" style="font-weight: normal" rows="10" value=""
                                placeholder="Ketikan pasal disini..."></textarea>
                            <!--end::Input-->


                        </div>
                        {{-- <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="edit-pasal-btn" style="background-color:#008CB4">Update</button> --}}
                    </div>
                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <button type="button" id="edit-pasal-btn" style="background-color:#008CB4"
                        class="btn btn-sm btn-light btn-active-primary text-white">
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="text-white">Update</span>
                            <span class="spinner-border spinner-border-sm" id="loading-update"
                                style="display: none; margin: 0 0 0 1rem;" aria-hidden="true" role="status"></span>
                        </div>
                    </button>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- end::modal Edit Pasal --}}

    <!--begin::modal DELETE-->
    @foreach ($pasals as $pasal)
        <form action="/pasal/delete/{{ $pasal->id_pasal }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $pasal->id_pasal }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus Pasal :</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg text-white"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            <strong> &bull; {{ $pasal->pasal }}</strong>
                            <br>
                            <br>
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
    <!--end::modal DELETE-->

    <!--begin::Modal IMPORT-->
	<form action="/pasal/import" method="post" enctype="multipart/form-data"> 
        @csrf
        <div class="modal fade" id="kt_modal_import" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Import File</h2>
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
    
                        <!--begin::Input group Website-->
                        <div class="fv-row">
                            <div class="fv-row">
                                    
                                <!--begin::Input-->
                                <div>
                                    <label for="import-pasal" class="form-label">Import Pasal :</label>
                                    <input accept=".xls, .xlsx" class="form-control form-control-md form-control-solid" id="doc-attachment" name="import-file" type="file">
                                </div>
                                <!--end::Input-->
    
    
                            </div><br>

                        </div>
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" name="file-submit" class="btn btn-sm btn-primary" id="proyek_new_save" style="background-color:#008CB4" >Import File</button>
                    </div>
                    <!--end::Input group-->
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
    </form>
    <!--end::Modal IMPORT-->
    
{{-- end::modal --}}
@endsection

@section('js-script')
    <script>
        const addPasalBtn = document.querySelector("#add-pasal");
        const modalBoots = new bootstrap.Modal("#kt_modal_tambah_pasal", {});
        const editPasalModalBoots = new bootstrap.Modal("#kt_modal_edit_pasal", {});
        const loadingElt = document.querySelector(".spinner-border");
        const inputPasalElt = document.querySelector("#pasal");
        const inputTipePasalElt = document.querySelector("#tipe-pasal");
        const tableBodyElt = document.querySelector("table tbody");
        const toaster = document.getElementById("liveToastBtn");
        const toasterBoots = new bootstrap.Toast("#liveToastBtn", {
            delay: 3000,
        });
        const toastBodyElt = document.querySelector(".toast-body");

        // Tambah Pasal function
        addPasalBtn.addEventListener("click", async e => {
            loadingElt.style.display = "block";

            const pasal = inputPasalElt.value;
            const tipePasal = inputTipePasalElt.value;
            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("tipe-pasal", tipePasal);
            formData.append("pasal", pasal);

            const responsePasal = await fetch("/pasal/add", {
                method: "POST",
                header: {
                    "content-type": "application/json",
                },
                body: formData,
            }).then(res => res.json());

            if (responsePasal.status == "success") {
                window.location.reload();
                let html = "";
                const allPasalsData = responsePasal.pasals;
                allPasalsData.forEach((element, i) => {
                    html += `
                    <tr>
                        <!--begin::Nomor=-->
                        <td>
                            <h6
                                class="text-gray-800 text-hover-primary mb-1">
                               ${++i}</h6>
                        </td>
                        <!--end::Nomor=-->
                        <!--begin::Pasal=-->
                        <td>
                            <button type="button" data-bs-toggle="modal" onclick="editPasal(this)"
                            data-id="${element.id_pasal}" data-bs-target="#kt_modal_edit_pasal" class="text-gray-600 text-hover-primary mb-1">${element.pasal}</button>
                        </td>
                        <!--end::Pasal=-->

                        <!--begin::Close Btn=-->
                        <td>
                            <a href="/pasal/delete/${element.id_pasal}" class="btn-close btn-md"
                                aria-label="Close"></a>
                        </td>
                        <!--end::Close Btn=-->

                    </tr>
                    `;
                });
                loadingElt.style.display = "none";
                modalBoots.hide();
                document.querySelector(".modal-backdrop").remove();

                toastBodyElt.innerText = responsePasal.message;
                toaster.classList.add("text-bg-primary");
                toasterBoots.show();
                tableBodyElt.innerHTML = html;
                return;
            }
            loadingElt.style.display = "none";
            modalBoots.hide();
            document.querySelector(".modal-backdrop").remove();

            toastBodyElt.innerText = responsePasal.message;
            toasterBoots.classList.add("text-bg-danger");
            toasterBoots.show();
            return;

        });
        // End Tambah Pasal

        // Begin Edit Pasal
        const spinnerLoadingUpdate = document.querySelector("#loading-update");
        const editPasalBtn = document.querySelector("#edit-pasal-btn");
        editPasalBtn.addEventListener("click", updatePasal, true);
        let id_pasal = 0;
        async function editPasal(elt) {
            // Begin Fetching Data pasal
            id_pasal = elt.getAttribute("data-id");
            const editPasalModal = document.getElementById("kt_modal_edit_pasal");
            const inputGrupEditPasalElt = document.getElementById("input-grup-edit-pasal");
            const loadingEditElt = document.getElementById("loading-edit");
            loadingEditElt.style.display = "block";
            inputGrupEditPasalElt.style.display = "none";
            const getResponse = await fetch(`/pasal/${id_pasal}`).then(res => res.json());
            if (getResponse.pasal) {
                inputGrupEditPasalElt.style.display = "block";
                loadingEditElt.style.display = "none";
                document.getElementById("pasal-edit").value = getResponse.pasal.pasal;
                document.getElementById("tipe-pasal-edit").value = getResponse.pasal.tipe_pasal;
                document.getElementById("id-pasal").value = getResponse.pasal.id;
                document.getElementById("pasal-edit").focus();

            }
            // End Fetching Data pasal
        }

        async function updatePasal() {
            spinnerLoadingUpdate.style.display = "block";
            const formData = new FormData();
            const pasalChanges = document.querySelector("#pasal-edit").value;
            const tipePasalChanges = document.querySelector("#tipe-pasal-edit").value;
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("id_pasal", id_pasal);
            formData.append("pasal", pasalChanges);
            formData.append("tipe-pasal", tipePasalChanges);
            const updatePasal = await fetch("/pasal/update", {
                method: "POST",
                header: {
                    "content-type": "application/json",
                },
                body: formData,
            }).then(res => res.json());
            if (updatePasal.status == "success") {
                window.location.reload();
                let html = "";
                const allPasalsData = updatePasal.pasals;
                allPasalsData.forEach((element, i) => {
                    html += `
                    <tr>
                        <!--begin::Nomor=-->
                        <td>
                            <h6
                                class="text-gray-800 text-hover-primary mb-1">
                               ${++i}</h6>
                        </td>
                        <!--end::Nomor=-->

                        <!--begin::Pasal=-->
                        <td>
                            <a type="button" data-bs-toggle="modal" onclick="editPasal(this)"
                                data-id="${ element.id_pasal }" data-bs-target="#kt_modal_edit_pasal"
                                class="text-gray-600 text-hover-primary mb-1"><i class="bi bi-pencil-square"></i> ${ element.pasal }</a>
                        </td>
                        <!--end::Pasal=-->

                        <!--begin::Close Btn=-->
                        <td>
                            <a href="/pasal/delete/${element.id_pasal}" class="btn-close btn-md"
                                aria-label="Close"></a>
                        </td>
                        <!--end::Close Btn=-->

                    </tr>
                    `;
                });
                tableBodyElt.innerHTML = html;

                toastBodyElt.innerText = updatePasal.message;
                toaster.classList.add("text-bg-primary")
                toasterBoots.show()
            } else {
                toastBodyElt.innerText = updatePasal.message;
                toaster.classList.add("text-bg-danger")
                toasterBoots.show()
            }
            editPasalModalBoots.hide();
            document.querySelector(".modal-backdrop").remove();
            spinnerLoadingUpdate.style.display = "none";
        }
        // End Edit Pasal
    </script>
@endsection

<!--begin::Aside-->
{{-- @section('aside')
    @include('template.aside')
@endsection --}}
<!--end::Aside-->
