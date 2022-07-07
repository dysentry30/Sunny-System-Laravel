{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Dashboard')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Dashboard
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <a href="#" class="btn btn-sm btn-primary w-80px" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"
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
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_import"  id="kt_toolbar_import">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>Import Excel
                                            </button>
                                            <button type="submit" class="btn btn-active-primary dropdown-item rounded-0"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_export"  id="kt_toolbar_export">
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
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card "style edited"-->
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">


                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Dashboard" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->

                        </div>
                        <!--end::Card header-->


                        <!--begin::Card body-->
                        <div class="card-body pt-0 ">
                            <div id="forecast-line">
                                <!--begin::FORECAST LINE CHART-->
                                <!--end::FORECAST LINE CHART-->
                            </div>

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


@endsection
{{-- End::Main --}}
@section('js-script')
<!--begin::CDN High Chart-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!--end::CDN High Chart-->

<!--begin::FORECAST LINE-->
<script>
    let arrayHistoryForecast = JSON.parse("{!! json_encode($arrayHistoryForecast) !!}");
    console.log(arrayHistoryForecast);
        Highcharts.chart('forecast-line', {

        title: {
            text: 'Forecast Line Chart'
        },

        subtitle: {
            text: '2022'
        },

        yAxis: {
            title: {
                text: 'Data Forecast (Dalam Jutaan)'
            }
        },

        xAxis: {
            categories:[
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "oktober",
                "November",
                "Desember",
            ],
            // accessibility: {
            //     rangeDescription: 'Range: 2010 to 2017'
            // }
        },

        legend: {
            // layout: 'vertical',
            // align: 'right',
            // verticalAlign: 'middle'
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
        },

        plotOptions: {
            series: {
                allowPointSelect: true
            //     label: {
            //         connectorAllowed: false
            //     },
            //     pointStart: 2021
            }
        },

        series: [
        {
            name: 'Nilai OK',
            data: arrayHistoryForecast
        // }, 
        // {
        //     name: 'Forecast',
        //     data: [24916000, 54064000, 89742000, 99851000, 112490000, 138121000, 180282000, 238121000, 301434000, 381434000, 401434000, 501434000]
        // }, 
        // {
        //     name: 'Nilai Realisasi',
        //     data: [11744000, 17722000, 16005000, 19771000, 20185000, 24377000, 32147000, 39387000, 69771000, 90185000, 124377000, 232147000]
        // }, 
        // {
        //     name: 'Project Development',
        //     data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
        // }, 
        // {
        //     name: 'Other',
        //     data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

        });
        
</script>
<!--end::FORECAST LINE-->
@endsection