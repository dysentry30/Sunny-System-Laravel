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

                                        <!--Begin:: BUTTON FILTER-->
                                        <form action="" class="d-flex flex-row w-auto" method="get">
                                            <!--begin::Select Options-->
                                    <div style="" id="filterTahun" class="d-flex align-items-center position-relative me-3">
                                        <select id="tahun-proyek" name="tahun-proyek"
                                            class="form-select form-select-solid select2-hidden-accessible mx-3"
                                            data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="" selected>{{date("Y")}}</option>
                                            @foreach ($tahun_proyeks as $tahun)
                                                    <option value="{{$tahun}}" {{$filterTahun == $tahun ? "selected" : ""}}>{{$tahun}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <!--end::Select Options-->
                                     
                                    <!--begin::Select Options-->
                                     <div style="" id="filterBulan" class="d-flex align-items-center position-relative me-3">
                                        <select id="bulan-proyek" name="bulan-proyek"
                                            class="form-select form-select-solid select2-hidden-accessible mx-3"
                                            data-control="select2" data-hide-search="true" data-placeholder="Bulan"
                                            tabindex="-1" aria-hidden="true">
                                            <option {{ $month == '' ? 'selected' : '' }}></option>
                                            <option value="1" {{ $filterBulan == 1 ? 'selected' : '' }}>Januari</option>
                                            <option value="2" {{ $filterBulan == 2 ? 'selected' : '' }}>Februari</option>
                                            <option value="3" {{ $filterBulan == 3 ? 'selected' : '' }}>Maret</option>
                                            <option value="4" {{ $filterBulan == 4 ? 'selected' : '' }}>April</option>
                                            <option value="5" {{ $filterBulan == 5 ? 'selected' : '' }}>Mei</option>
                                            <option value="6" {{ $filterBulan == 6 ? 'selected' : '' }}>Juni</option>
                                            <option value="7" {{ $filterBulan == 7 ? 'selected' : '' }}>Juli</option>
                                            <option value="8" {{ $filterBulan == 8 ? 'selected' : '' }}>Agustus</option>
                                            <option value="9" {{ $filterBulan == 9 ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ $filterBulan == 10 ? 'selected' : '' }}>Oktober</option>
                                            <option value="11" {{ $filterBulan == 11 ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ $filterBulan == 12 ? 'selected' : '' }}>Desember</option>
                                        </select>
                                    </div>
                                    <!--end::Select Options-->

                                    <!--begin:: Input Filter-->
                                    <div id="filterUnit" class="d-flex align-items-center position-relative">
                                        <select id="unit-kerja" onchange="this.form.submit()" name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                            data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                            <option></option>
                                            @foreach ($unit_kerjas_select as $unitkerja)
                                                <option value="{{ $unitkerja->divcode }}"
                                                    {{ $filterUnitKerja == $unitkerja->divcode ? 'selected' : '' }}>
                                                    {{ $unitkerja->unit_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--begin:: Filter-->
                                    <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                        id="kt_toolbar_primary_button">
                                        Filter</button>
                                    <!--end:: Filter-->

                                    <!--begin:: RESET-->
                                    <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                        onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                        
                                    <script>
                                        function resetFilter() {
                                            window.location.href = "/claim-management";
                                        }
                                    </script>
                                    <!--end:: RESET-->
                                            <!--Begin:: Select Options-->
                                            {{-- <select style="display: none !important" id="column" name="column" onchange="changes(this)"
                                                class="form-select form-select-solid select2-hidden-accessible"
                                                style="margin-right: 2rem" data-control="select2" data-hide-search="true"
                                                data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="unit_kerja" {{$column == "unit_kerja" ? "selected" : ""}}>Unit Kerja</option>
                                                <option value="jenis_proyek" {{$column == "jenis_proyek" ? "selected" : ""}}>Jenis Proyek</option>

                                            </select> --}}
                                            <!--End:: Select Options-->

                                            <!--begin::Select Options-->
                                            {{-- <div style="" id="filterTahun" class="d-flex align-items-center position-relative me-3">
                                                <select id="tahun-proyek" name="tahun-proyek" onchange="selectFilter(this)"
                                                    class="form-select form-select-solid select2-hidden-accessible mx-3"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Tahun"
                                                    tabindex="-1" aria-hidden="true">
                                                    <option value="" selected>{{date("Y")}}</option>
                                                    @foreach ($tahun_proyek as $tahun)
                                                            <option value="{{$tahun}}" {{$filterTahun == $tahun ? "selected" : ""}}>{{$tahun}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <!--end::Select Options-->

                                            <!--begin:: Input Filter-->
                                            <div id="filterUnit" class="d-flex align-items-center position-relative">
                                                <select id="unit-kerja" onchange="selectFilter(this)" name="filter-unit" class="form-select form-select-solid w-200px ms-2"
                                                    data-control="select2" data-hide-search="true" data-placeholder="Unit Kerja">
                                                    <option></option>
                                                    @foreach ($unitkerjas as $unit)
                                                        <option value="{{ $unit->divcode }}"
                                                            {{ $filterUnitKerja == $unit->divcode ? 'selected' : '' }}>
                                                            {{ $unit->unit_kerja }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!--begin:: Filter-->
                                            <button type="submit" class="btn btn-sm btn-light btn-active-primary ms-4"
                                                id="kt_toolbar_primary_button">
                                                Filter</button>
                                            <!--end:: Filter-->

                                            <!--begin:: RESET-->
                                            <button type="button" class="btn btn-sm btn-light btn-active-primary ms-2"
                                                onclick="resetFilter()" id="kt_toolbar_primary_button">Reset</button>
                                                
                                            <script>
                                                function resetFilter() {
                                                    window.location.href = "/claim-management";
                                                }
                                            </script> --}}
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

<script>
    function selectFilter(e) {
        const value = e.value;
        const type = e.getAttribute("id");
        let url = "";
        if(type == "tahun-proyek") {
            url = `/claim-management?tahun-proyek=${value}`;
        } else if(type == "unit-kerja") {
            url = `/claim-management?unit-kerja=${value}`;
        } else {
            url = `/claim-management?jenis-proyek=${value}`;
        }
        window.location.href = url;
        return;
    }
</script>

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