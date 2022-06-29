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
                            <button type="button" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_tambah_pasal" id="tambah-pasal"
                                style="background-color:#ffa62b; padding: 6px">
                                New</button>
                            <a href="/contract-management/" class="btn btn-sm btn-active-primary w-80px"
                                style="background-color:#f3f6f9; margin-left:10px; padding: 6px">
                                Back</a>
                            <!--end::Button-->
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"></path>
                                </svg>
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
                                <th class="w-75px">No</th>
                                <th class="min-w-125px">Pasal</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @foreach ($pasals as $i => $pasal)
                                <tr>

                                    <!--begin::Nomor=-->
                                    <td>
                                        <p class="text-gray-700 mb-1">
                                            {{ ++$i }}</p>
                                    </td>
                                    <!--end::Nomor=-->

                                    <!--begin::Pasal=-->
                                    <td>
                                        <a type="button" data-bs-toggle="modal" onclick="editPasal(this)"
                                            data-id="{{ $pasal->id_pasal }}" data-bs-target="#kt_modal_edit_pasal"
                                            class="text-gray-600 text-hover-primary mb-1">{{ $pasal->pasal }}</a>
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
        <div class="modal-dialog modal-dialog-centered mw-900px">
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
                <div class="modal-body py-lg-6 px-lg-6">

                    <!--begin::Input group Website-->
                    <div class="fv-row mb-5">
                        <div class="fv-row mb-5">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="pasal" id="pasal"
                                style="font-weight: normal" value="" placeholder="Ketikan pasal disini...">
                            <!--end::Input-->


                        </div>
                        {{-- <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="add-pasal" style="background-color:#ffa62b">Save</button> --}}

                        <button type="button" id="add-pasal" style="background-color:#ffa62b"
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
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    {{-- end::modal Tambah Pasal --}}

    {{-- begin::modal Edit Pasal --}}
    <div class="modal fade" id="kt_modal_edit_pasal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
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
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mt-3">
                                <span style="font-weight: normal">Pasal :</span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="hidden" class="form-control form-control-solid" name="id-pasal"
                                id="id-pasal">
                            <!--end::Input-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" name="pasal-edit"
                                id="pasal-edit" style="font-weight: normal" value=""
                                placeholder="Ketikan pasal disini...">
                            <!--end::Input-->


                        </div>
                        {{-- <button type="submit" class="btn btn-sm btn-light btn-active-primary text-white" id="edit-pasal-btn" style="background-color:#ffa62b">Update</button> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="edit-pasal-btn" style="background-color:#ffa62b"
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
                <!--end::Modal body-->
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
    {{-- end::modal --}}
@endsection

@section('js-script')
    <script>
        const addPasalBtn = document.querySelector("#add-pasal");
        const modalBoots = new bootstrap.Modal("#kt_modal_tambah_pasal", {});
        const editPasalModalBoots = new bootstrap.Modal("#kt_modal_edit_pasal", {});
        const loadingElt = document.querySelector(".spinner-border");
        const inputPasalElt = document.querySelector("#pasal");
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
            const formData = new FormData();
            formData.append("_token", "{{ csrf_token() }}");
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
                document.getElementById("id-pasal").value = getResponse.pasal.id;
                document.getElementById("pasal-edit").focus();

            }
            // End Fetching Data pasal
        }

        async function updatePasal() {
            spinnerLoadingUpdate.style.display = "block";
            const formData = new FormData();
            const pasalChanges = document.querySelector("#pasal-edit").value;
            formData.append("_token", "{{ csrf_token() }}");
            formData.append("id_pasal", id_pasal);
            formData.append("pasal", pasalChanges);
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
@section('aside')
    @include('template.aside')
@endsection
<!--end::Aside-->
