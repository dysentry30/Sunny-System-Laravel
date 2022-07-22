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
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">ID Contract</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($proyekClaim as $proyekClaims)
                                                    <tr>

                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{-- <a class="text-hover-primary text-gray-500"
                                                                href="/claim-management/view/{{ $claim->id_claim }}">{{ $claim->id_claim }}
                                                            </a> --}}
                                                            <a href="/claim-management/proyek/{{ $proyekClaims->kode_proyek }}/Claim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->kode_proyek }}</a>
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{ $proyekClaims->nama_proyek }}
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Email=-->
                                                        <td>
                                                            {{ $proyekClaims->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email=-->
                                                        <!--begin::Action=-->
                                                        <td>
                                                            <a href="/contract-management/view/{{ $proyekClaims->ContractManagements->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekClaims->ContractManagements->id_contract }}</a>
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>
                                            @endforeach
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
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">ID Contract</th>
                                                {{-- <th class="min-w-auto">Total</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                        {{-- @foreach ($claims as $claim) --}}
                                            @foreach ($proyekAnti as $proyekAntis)
                                                <tr>

                                                    <!--begin::Name=-->
                                                    <td>
                                                        <a href="/claim-management/proyek/{{ $proyekAntis->kode_proyek }}/Anti-Claim" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->kode_proyek }}</a>
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Name=-->
                                                    <td>
                                                        {{ $proyekAntis->nama_proyek }}
                                                    </td>
                                                    <!--end::Name=-->
                                                    <!--begin::Email=-->
                                                    <td>
                                                        {{ $proyekAntis->UnitKerja->unit_kerja }}
                                                    </td>
                                                    <!--end::Email=-->
                                                    <!--begin::Action=-->
                                                    <td>
                                                        <a href="/contract-management/view/{{ $proyekAntis->ContractManagements->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAntis->ContractManagements->id_contract }}</a>
                                                    </td>
                                                    <!--end::Action=-->
                                                    <!--begin::Action=-->
                                                    {{-- <td>
                                                        {{ count($proyekAnti) }}
                                                    </td> --}}
                                                    <!--end::Action=-->
                                                </tr>
                                        @endforeach
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
                                                <th class="min-w-auto">Kode Proyek</th>
                                                <th class="min-w-auto">Nama Proyek</th>
                                                <th class="min-w-auto">Unit Kerja</th>
                                                <th class="min-w-auto">ID Contract</th>
                                                {{-- <th class="min-w-auto">Total</th> --}}
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($proyekAsuransi as $proyekAsuransis)
                                                    <tr>

                                                        <!--begin::Name=-->
                                                        <td>
                                                            <a href="/claim-management/proyek/{{ $proyekAsuransis->kode_proyek }}/Claim-Asuransi" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->kode_proyek }}</a>
                                                        <!--end::Name=-->
                                                        <!--begin::Name=-->
                                                        <td>
                                                            {{ $proyekAsuransis->nama_proyek }}
                                                        </td>
                                                        <!--end::Name=-->
                                                        <!--begin::Email=-->
                                                        <td>
                                                            {{ $proyekAsuransis->UnitKerja->unit_kerja }}
                                                        </td>
                                                        <!--end::Email=-->
                                                        <!--begin::Action=-->
                                                        <td>
                                                            <a href="/contract-management/view/{{ $proyekAsuransis->ContractManagements->id_contract }}" id="click-name" class="text-gray-800 text-hover-primary mb-1">{{ $proyekAsuransis->ContractManagements->id_contract }}</a>
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>
                                            @endforeach
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