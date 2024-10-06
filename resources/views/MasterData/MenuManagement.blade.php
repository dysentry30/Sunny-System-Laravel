{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Menu Management')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Menu Management
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <div class="d-flex align-items-center py-1">
                                <!--begin::Button-->
                                <button type="submit" form="form-save" class="btn btn-sm btn-primary py-3" style="background-color:#008CB4; padding: 6px">Save</button>
                            </div>
                            <!--end::Actions-->
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

                            <p><b>Aplikasi</b></p>
                            <!--begin::Row-->
                            <div class="d-flex flex-row h-50px">
                                <!-- begin:: Form Input Group -->
                                @foreach ($masterAplikasi as $aplikasi)
                                    <!-- begin:: Form Input Administrator -->
                                    <div class="form-check me-12">
                                        <input class="form-check-input" type="checkbox"
                                            value=""
                                            name="{{ $aplikasi->kode_aplikasi }}" id="{{ $aplikasi->kode_aplikasi }}" {{ $aplikasi->kode_aplikasi == $kode_aplikasi ? "checked" : ""}} disabled>
                                        <label class="form-check-label"
                                            for="administrator">
                                            {{ $aplikasi->nama_aplikasi }}
                                        </label>
                                    </div>
                                    <!-- end:: Form Input Administrator -->                                    
                                @endforeach
                                <!-- end:: Form Input Group -->
                            </div>
                            <!--end::Row-->
                            <hr>
                            <br>
                            <br>

                            <p><b>List Menu</b></p>
                            <!--begin::Table-->
                            <form action="/menu-managements/{{ $kode_aplikasi }}/save" id="form-save" method="post">
                                @csrf
                                <table class="table align-middle table-bordered border-dark fs-6 gy-2" id="example">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0 bg-primary">
                                            <th class="min-w-auto text-white">No.</th>
                                            <th class="min-w-auto text-white">Nama Menu</th>
                                            <th class="min-w-auto text-white">Kode Menu</th>
                                            <th class="min-w-auto text-white">Kode Parent</th>
                                            <th class="min-w-auto text-white">Path</th>
                                            <th class="min-w-auto text-white d-flex flex-column align-items-center">
                                                Action
                                                <input type="checkbox" id="check-list-all" class="form-check-input">
                                            </th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @foreach ($collectMenu as $index => $menu)
                                            <tr>
                                                <td class="text-center">{{ ++$index }}</td>
                                                <td class="text-start">{{ $menu->nama_menu }}</td>
                                                <td class="text-center">{{ $menu->kode_menu }}</td>
                                                <td class="text-center">{{ $menu->kode_parrent }}</td>
                                                <td class="text-start"><a href="{{ $menu->path }}" class="text-hover-primary text-black" target="_blank">{{ $menu->path }}</a></td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="check-list" class="form-check-input" name="menu-list[]" value="{{ $menu->kode_menu }}" {{ $isExistAplikasi->isNotEmpty() && $isExistAplikasi->contains("kode_menu", $menu->kode_menu) ? "checked" : "" }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>                            
                            </form>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

    <script>
        // $('#example').DataTable({
        //     stateSave: true,
        //     ordering: false,
        //     pageLength : 50,
        // });

        // Select the 'check all' checkbox
        const checkAll = document.getElementById("check-list-all");

        // Select all checkboxes with the class 'checklist'
        const checklist = document.querySelectorAll("#check-list");

        // Add event listener to 'check all' checkbox
        checkAll.addEventListener("change", function() {
            // Set the checked status of each checkbox in the checklist
            checklist.forEach((checkbox) => {
                checkbox.checked = checkAll.checked;
            });
        });
    </script>
    <!--end::Javascript-->
@endsection

<!--end::Main-->
