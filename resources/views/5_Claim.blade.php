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
                        <h1 class="d-flex align-items-center fs-3 my-1">Claim Managements
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">

<!--begin::Wrapper-->
                        
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
                                    <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                        <option {{$column == "" ? "selected": ""}}></option>
                                        <option value="id_contract" {{$column == "id_contract" ? "selected" : ""}}>ID Contract</option>
                                        <option value="kode_proyek" {{$column ==    "kode_proyek" ? "selected" : ""}}>Kode Proyek</option>
                                        {{-- <option value="uraian_perubahan" {{$column == "uraian_perubahan" ? "selected" : ""}}>Uraian Perubahan</option> --}}
                                    </select>
                                    <!--End:: Select Options-->
                                    
                                    <!--begin:: Input Filter-->
                                    <div class="d-flex align-items-center position-relative">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" id="filter" name="filter" value="{{ $filter }}"
                                        class="form-control form-control-solid ms-2 ps-12 w-auto" placeholder="Input Filter" />
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
                                            $("#column").select2({
                                                minimumResultsForSearch: -1
                                            }).val("").trigger("change");
                                            
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

                        <!--begin::Card body-->
                        <div class="card-body pt-5">

<!--begin:::Tabs Navigasi-->    
                                <ul
                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                                <!--begin:::Tab item Claim-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                        href="#kt_user_view_claim" style="font-size:14px;">Claim</a>
                                </li>
                                <!--end:::Tab item Claim-->

                                <!--begin:::Tab item Anti Claim-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                        data-bs-toggle="tab" href="#kt_user_view_overview_anticlaim"
                                        style="font-size:14px;">Anti Claim</a>
                                </li>
                                <!--end:::Tab item Anti Claim-->

                                <!--begin:::Tab item -->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                        data-bs-toggle="tab" href="#kt_user_view_overview_asuransi"
                                        style="font-size:14px;">Claim Asuransi</a>
                                </li>
                                <!--end:::Tab item -->
                                </ul>
<!--end:::Tabs Navigasi-->

                                <!--begin:::Tab isi content  -->
                                <div class="tab-content" id="myTabContent">

<!--begin:::Tab Claim-->
                                <div class="tab-pane fade show active" id="kt_user_view_claim" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2"
                                        id="kt_proyek_table">
                                        <!--begin::Table head-->
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
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @forelse ($proyekClaim as $proyekClaims)
                                                    <tr>
                                                        <!--begin::Name-->
                                                        <td>
                                                            <a href="/claim-management/proyek/{{ $proyekClaims->kode_proyek }}/Claim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name-->
                                                        <!--begin::Name Proyek-->
                                                        <td>
                                                            {{ $proyekClaims->project->nama_proyek }}
                                                        </td>
                                                        <!--end::Name Proyek-->
                                                        <!--begin::Unit Kerja-->
                                                        <td>
                                                            {{ $proyekClaims->project->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Unit Kerja-->
                                                        <!--begin::Action-->
                                                        <td>
                                                            <a href="/contract-management/view/{{ $proyekClaims->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->id_contract }}</a>
                                                        </td>
                                                        <!--end::Action-->
                                                    </tr>
                                            @empty
                                                <tr class="bg-gray-100 text-center">
                                                    <td colspan="4">Data Klaim tidak ditemukan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
<!--end:::Tab Claim-->


<!--begin:::Tab Anti Claim-->
                                <div class="tab-pane fade" id="kt_user_view_overview_anticlaim" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2"
                                        id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                {{-- <th class="min-w-auto">Total</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                        {{-- @foreach ($claims as $claim) --}}
                                            @forelse ($proyekAnti as $proyekAntis)
                                                <tr>
                                                    <!--begin::Name-->
                                                    <td>
                                                        <a href="/claim-management/proyek/{{ $proyekAntis->kode_proyek }}/Anti-Claim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->kode_proyek }}</a>
                                                    </td>
                                                    <!--end::Name-->
                                                    <!--begin::Name Proyek-->
                                                    <td>
                                                        {{ $proyekAntis->project->nama_proyek }}
                                                    </td>
                                                    <!--end::Name Proyek-->
                                                    <!--begin::Unit Kerja-->
                                                    <td>
                                                        {{ $proyekAntis->project->UnitKerja->unit_kerja }}
                                                    </td>
                                                    <!--end::Unit Kerja-->
                                                    <!--begin::Action-->
                                                    <td>
                                                        <a href="/contract-management/view/{{ $proyekAntis->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->id_contract }}</a>
                                                    </td>
                                                    <!--end::Action-->
                                                </tr>
                                        @empty
                                            <tr class="bg-gray-100 text-center">
                                                <td colspan="4">Data Klaim tidak ditemukan</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
<!--end:::Tab Anti Claim-->


<!--begin:::Tab Claim Asuransi-->
                                <div class="tab-pane fade" id="kt_user_view_overview_asuransi" role="tabpanel">
                                    <!--begin::Table Claim-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-2"
                                        id="kt_proyek_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th>
                                                {{-- <th class="min-w-auto">Total</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @forelse ($proyekAsuransi as $proyekAsuransis)
                                                    <tr>
                                                        <!--begin::Name-->
                                                        <td>
                                                            <a href="/claim-management/proyek/{{ $proyekAsuransis->kode_proyek }}/Claim-Asuransi" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name-->
                                                        <!--begin::Name Proyek-->
                                                        <td>
                                                            {{ $proyekAsuransis->project->nama_proyek }}
                                                        </td>
                                                        <!--end::Name Proyek-->
                                                        <!--begin::Unit Kerja-->
                                                        <td>
                                                            {{ $proyekAsuransis->project->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Unit Kerja-->
                                                        <!--begin::Action-->
                                                        <td>
                                                            <a href="/contract-management/view/{{ $proyekAsuransis->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->id_contract }}</a>
                                                        </td>
                                                        <!--end::Action-->
                                                    </tr>
                                            @empty
                                                <tr class="bg-gray-100 text-center">
                                                    <td colspan="4">Data Klaim tidak ditemukan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table -->
                                </div>
<!--end:::Tab pane Claim Asuransi-->


                                </div>
                                <!--end:::Tab isi content-->                            

                </div>
                <!--end:::Tab isi content-->

                </div>
                <!--end::Card body-->

            </div>
            <!--end::Content-->
            </form>
            <!--end::Form-->
            
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


@endsection