{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Change Managements')
{{-- end:: title --}}

<style>
    .buttons-html5 {
        border-radius: 5px !important;
        border: none !important;
        font-weight: normal !important;
    }
    .buttons-colvis {
        border: none !important;
        border-radius: 5px !important;
    }
    .dataTables_filter{
        padding: 0 !important;
        margin-left: 5px !important;
        color: #B5B5C3;

    }
</style>
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Change Managements
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
                                            
                                        </form>
                                        <!--end:: BUTTON FILTER-->
                                    </div>
                                    <!--begin::Card title-->
                                            
                                    <!--begin::Card title-->
                                    <div class="card-title" style="width: 100%">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center my-1" style="width: 100%;">

                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">

                                                <!--begin:::Tab item -->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_pelaksanaan" style="font-size:14px;">Pelaksanaan</a>
                                                </li>
                                                <!--end:::Tab item -->

                                                <!--begin:::Tab item -->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_pemeliharaan" style="font-size:14px;">Pemeliharaan</a>
                                                </li>
                                                <!--end:::Tab item -->
                                            </ul>

                                        </div>

                                    </div>
                                    <!--begin::Card title-->
                                </div>
                                <!--end::Card header-->

                                <div class="card-body pt-5">
                                    <div id="tab-content" class="tab-content">
                                        <!-- Begin :: Tab Content Pelaksanaan -->
                                        <div class="tab-pane fade show active" id="kt_user_view_overview_pelaksanaan" role="tabpanel">
                                            <!--begin::Table -->
                                            <div class="overflow-scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="claim-management">
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th rowspan="3" class="min-w-auto">Profit Center</th>
                                                            <th rowspan="3" class="min-w-auto">Nama Proyek</th>
                                                            <th rowspan="3" class="min-w-auto">Unit Kerja</th>
                                                            <th colspan="4" class="min-w-auto text-center">VO</th>
                                                            <th colspan="4" class="min-w-auto text-center">Klaim</th>
                                                            <th colspan="4" class="min-w-auto text-center">Anti Klaim</th>
                                                            <th colspan="4" class="min-w-auto text-center">Klaim Asuransi</th>
                                                        </tr>
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                        </tr>
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            {{-- <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th> --}}
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            {{-- <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th> --}}
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
                                                    {{-- @dd($filterBulan) --}}
                                                    <tbody class="fw-bold text-gray-600">
                                                        @foreach ($claims as $claim)
                                                        <tr>
                                                            <td>
                                                                {{-- <a href="/claim-management/proyek/{{ $claim['kode_proyek'] }}/{{ $claim['id_contract'] }}?link=kt_user_view_claim_VO" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim['profit_center'] }}</a> --}}
                                                                <a href="/claim-management/proyek/{{ ($claim['profit_center']) }}?link=kt_user_view_claim_VO" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim['profit_center'] }}</a>
                                                            </td>
                                                            <td>{{ $claim['nama_proyek'] }}</td>
                                                            <td>{{ $claim['unit_kerja'] }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_vo'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_vo'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_vo_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_vo_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_anti_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_anti_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_anti_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_anti_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_asuransi'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_asuransi'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_asuransi_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_asuransi_approved'], 0, ".", ",") }}</td>
                                                            {{-- <td>
                                                                <a href="/contract-management/view/{{ $claim->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim->id_contract }}</a>
                                                            </td> --}}
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-white" style="background-color: #0DB0D9"><b>Total</b></td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahVOAll, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalVOAll, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahVOAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalVOAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAll, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAll, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahAntiClaimAll, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalAntiClaimAll, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahAntiClaimAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalAntiClaimAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAsuransiAll, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAsuransiAll, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAsuransiAllApproved, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAsuransiAllApproved, 0, ".", ",") }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <!--end::Table -->
                                        </div>
                                        <!-- End :: Tab Content Pelaksanaan -->

                                        <!-- Begin :: Tab Content Pemeliharaan -->
                                        <div class="tab-pane fade" id="kt_user_view_overview_pemeliharaan" role="tabpanel">
                                            <!--begin::Table -->
                                            <div class="overflow-scroll">
                                                <table class="table align-middle table-row-dashed fs-6 gy-2" id="claim-management-pemeliharaan">
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th rowspan="3" class="min-w-auto">Profit Center</th>
                                                            <th rowspan="3" class="min-w-auto">Nama Proyek</th>
                                                            <th rowspan="3" class="min-w-auto">Unit Kerja</th>
                                                            <th colspan="4" class="min-w-auto text-center">VO</th>
                                                            <th colspan="4" class="min-w-auto text-center">Klaim</th>
                                                            <th colspan="4" class="min-w-auto text-center">Anti Klaim</th>
                                                            <th colspan="4" class="min-w-auto text-center">Klaim Asuransi</th>
                                                        </tr>
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                            <th colspan="2" class="min-w-auto text-center">Submitted</th>
                                                            <th colspan="2" class="min-w-auto text-center">Approved</th>
                                                        </tr>
                                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                            {{-- <th class="min-w-auto">@sortablelink('kode_proyek','Kode Proyek')</th> --}}
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            <th colspan="1" class="min-w-auto text-center">Item</th>
                                                            <th colspan="1" class="min-w-auto text-center">Nilai</th>
                                                            {{-- <th class="min-w-auto">@sortablelink('id_contract','ID Contract')</th> --}}
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
                                                    {{-- @dd($filterBulan) --}}
                                                    <tbody class="fw-bold text-gray-600">
                                                        @foreach ($claims_pemeliharaan as $claim)
                                                        <tr>
                                                            <td>
                                                                {{-- <a href="/claim-management/proyek/{{ $claim['kode_proyek'] }}/{{ $claim['id_contract'] }}?link=kt_user_view_claim_VO" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim['profit_center'] }}</a> --}}
                                                                <a href="/claim-management/proyek/{{ ($claim['profit_center']) }}?link=kt_user_view_claim_VO" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim['profit_center'] }}</a>
                                                            </td>
                                                            <td>{{ $claim['nama_proyek'] }}</td>
                                                            <td>{{ $claim['unit_kerja'] }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_vo'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_vo'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_vo_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_vo_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_anti_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_anti_klaim'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_anti_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_anti_klaim_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_asuransi'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_asuransi'], 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($claim['jumlah_klaim_asuransi_approved'], 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($claim['total_klaim_asuransi_approved'], 0, ".", ",") }}</td>
                                                            {{-- <td>
                                                                <a href="/contract-management/view/{{ $claim->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $claim->id_contract }}</a>
                                                            </td> --}}
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-white" style="background-color: #0DB0D9"><b>Total</b></td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahVOAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalVOAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahVOAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalVOAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahAntiClaimAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalAntiClaimAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahAntiClaimAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalAntiClaimAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAsuransiAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAsuransiAllPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center bg-secondary">{{ number_format($jumlahClaimAsuransiAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                            <td class="text-center">{{ number_format($totalClaimAsuransiAllApprovedPemeliharaan, 0, ".", ",") }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <!--end::Table -->
                                        </div>
                                        <!-- End :: Tab Content Pemeliharaan -->
                                    </div>
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
                dom: '<"float-start"f><"#example"t>Brtip',
                pageLength : 10,
                order: [[4, 'desc']],
                language: {
                    decimal: '.',
                    thousands: ','
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data Change Managements',
                        footer: true,
                        header: true,
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    data = $('<p>' + data + '</p>').text();
                                    // return $.isNumeric(data.replace('.', ',')) ? data.replace('.', ',') : data;
                                    return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                },
                                footer: function(data, row, column, node) {
                                    data = $('<p>' + data + '</p>').text();
                                    // return $.isNumeric(data.replace('.', ',')) ? data.replace('.', ',') : data;
                                    return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                }
                            }
                        }
                    },
                        'pdf', 'print'
                    ],
                fixedHeader: {
                    footer: true
                }
            } );

            $('#claim-management-pemeliharaan').DataTable( {
                // dom: 'Bfrtip',
                dom: '<"float-start"f><"#example"t>Brtip',
                pageLength : 10,
                order: [[4, 'desc']],
                language: {
                    decimal: '.',
                    thousands: ','
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data Change Managements',
                        footer: true,
                        header: true,
                        exportOptions: {
                            format: {
                                body: function(data, row, column, node) {
                                    data = $('<p>' + data + '</p>').text();
                                    // return $.isNumeric(data.replace('.', ',')) ? data.replace('.', ',') : data;
                                    return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                },
                                footer: function(data, row, column, node) {
                                    data = $('<p>' + data + '</p>').text();
                                    // return $.isNumeric(data.replace('.', ',')) ? data.replace('.', ',') : data;
                                    return $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                                }
                            }
                        }
                    },
                        'pdf', 'print'
                    ],
                fixedHeader: {
                    footer: true
                }
            } );
        });
    </script>

@endsection