{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Claim Managements')
{{-- end:: title --}}

{{-- begin:: content --}}
@section('content')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Claim Managements
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <!--begin::Wrapper-->
                         <!--begin::Button-->
                         {{-- <a type="submit" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button"
                         style="background-color:#008CB4;" href="#" data-bs-toggle="modal"
                         data-bs-target="#kt_modal_input_perubahan_kontrak">
                         New</a> --}}
                        <!--end::Button-->

                        <!--begin::Button-->
                        {{-- <a href="/contract-management" class="btn btn-sm btn-primary" id="cloedButton"
                            style="background-color:#f3f6f9;margin-left:10px;color: black;">
                            Close</a> --}}
                        <!--end::Button-->
                        <!--end::Wrapper-->

                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Post-->
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <!--begin::Container-->
                <div id="kt_content_container" class="container-fluid">
                    <!--begin::Contacts App- Edit Contact-->
                    <div class="row">


                        <!--begin::All Content-->
                        <div class="col-xl-15">
                            <!--begin::Contacts-->
                            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                                <!--begin::Card header-->
                                <div class="card-header border-0 pt-1">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        {{-- <div class="d-flex align-items-center position-relative my-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <input type="text" data-kt-customer-table-filter="search"
                                                class="form-control form-control-solid w-250px ps-15" placeholder="Search Addendum" />
                                        </div> --}}
                                        <!--end::Search-->

                                        <!--Begin:: BUTTON FILTER-->
                                        <form action="#" class="d-flex flex-row w-auto" method="get">
                                            <!--Begin:: Select Options-->
                                            {{-- <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                                <option {{$column == "" ? "selected": ""}}></option>
                                                <option value="id_contract" {{$column == "id_contract" ? "selected" : ""}}>ID Contract</option>
                                                <option value="kode_proyek" {{$column ==    "kode_proyek" ? "selected" : ""}}>Kode Proyek</option>
                                            </select> --}}
                                            <!--End:: Select Options-->
                                            
                                            <!--begin:: Input Filter-->
                                            {{-- <div class="d-flex align-items-center position-relative">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter"
                                                class="form-control form-control-solid ms-2 ps-12 w-auto" placeholder="Input Filter" />
                                            </div> --}}
                                            <div class="d-flex">
                                                <select id="tahun-proyek" name="tahun-perubahan" onchange="this.form.submit()"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                    tabindex="-1" aria-hidden="true">
                                                    <option value="" selected>{{ date("Y") }}</option>
                                                    @foreach ($tahun_proyek as $tahun)
                                                        <option value="{{ $tahun }}"{{$filterTahun == $tahun ? "selected" : ""}}>{{ $tahun }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            <div class="d-flex ms-4">
                                                <select id="unit-kerja" name="unit-kerja" onchange="this.form.submit()"
                                                    class="form-select form-select-solid select2-hidden-accessible"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja"
                                                    tabindex="-1" aria-hidden="true">
                                                    <option></option>
                                                    @foreach ($unitkerjas as $unit)
                                                        <option value="{{ $unit->divcode }}" {{ $filterUnitKerja == $unit->divcode ? 'selected' : '' }}>{{ $unit->unit_kerja }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end:: Input Filter-->
                                            
                                            <!--begin:: Filter-->
                                            <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4" id="kt_toolbar_primary_button">
                                            Filter</button>
                                            <!--end:: Filter-->
                                            
                                            <!--begin:: RESET-->
                                            <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-2" 
                                            onclick="resetFilter()"  id="kt_toolbar_primary_button">Reset</button>
                                            <script>
                                                function resetFilter() {
                                                    // $("#column").select2({
                                                    //     minimumResultsForSearch: -1
                                                    // }).val("").trigger("change");
                                                    
                                                    $("#filter").text({
                                                        minimumResultsForSearch: -1
                                                    }).val("").trigger("change");
                                                }
                                            </script>
                                            <!--end:: RESET-->
                                        </form>
                                        <!--end:: BUTTON FILTER-->
                                    </div>
                                    <!--begin::Card title-->

                                </div>
                                <!--end::Card header-->

                                <div class="card-body pt-5">
                                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="claim-management">
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        {{-- @php
                                            $claim_get = $claim->map(function($p){
                                                return $p->first();
                                            })
                                        @endphp --}}
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @forelse ($claims as $claim)
                                            {{-- @dump($claim->ContractManagements) --}}
                                                    {{-- <tr>
                                                        <!--begin::Name-->
                                                        <td>
                                                            <a href="/claim-management/proyek/{{ $proyekClaims->ContractManagement->project->kode_proyek }}/Klaim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagement->project->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name-->
                                                        <!--begin::Name Proyek-->
                                                        <td>
                                                            {{ $proyekClaims->ContractManagement->project->nama_proyek }}
                                                        </td>
                                                        <!--end::Name Proyek-->
                                                        <!--begin::Unit Kerja-->
                                                        <td>
                                                            {{ $proyekClaims->ContractManagement->project->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Unit Kerja-->
                                                        <!--begin::Action-->
                                                        <td>
                                                            <a href="/contract-management/view/{{ $proyekClaims->ContractManagement->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagement->id_contract }}</a>
                                                        </td>
                                                        <!--end::Action-->
                                                    </tr> --}}
                                                    <tr>
                                                        <td>
                                                            <a href="/claim-management/proyek/{{ $claim->kode_proyek }}/{{ $claim->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim->kode_proyek }}</a>
                                                        </td>
                                                        <td>{{ $claim->nama_proyek }}</td>
                                                        <td>{{ $claim->UnitKerja->unit_kerja }}</td>
                                                        <td>
                                                            <a href="/contract-management/view/{{ $claim->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim->id_contract }}</a>
                                                        </td>
                                                    </tr>
                                            @empty
                                                <tr class="bg-gray-100 text-center">
                                                    <td colspan="4">
                                                        <b>There is no data</b>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>

                            </div>
                            <!--End::Contacts-->


                        </div>
                        <!--end::All Content-->
            
                    </div>
                    <!--end::Contacts App- Edit Contact-->
                </div>
                <!--end::Container-->


            </div>
            <!--end::Post-->
        </div>
        <!--end::Content-->
    </div>
@endsection
{{-- end:: content --}}

{{-- @section('aside')
    @include('template.aside')
@endsection --}}


@section('js-script')

<script src="{{ asset('/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset("/datatables/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.html5.min.js") }}"></script>
<script src="{{ asset("/datatables/buttons.colVis.min.js") }}"></script>
<script src="{{ asset("/datatables/jszip.min.js") }}"></script>
<script src="{{ asset("/datatables/pdfmake.min.js") }}"></script>
<script src="{{ asset("/datatables/vfs_fonts.js") }}"></script>
<!--end::Data Tables-->
    <!--begin:: Dokumen File Upload Max Size-->
    <script>
        $(document).ready(function() {
            $('#claim-management').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>rti',
                pageLength : 50,
                ordering: false,
            } );
        });
    </script>

@endsection