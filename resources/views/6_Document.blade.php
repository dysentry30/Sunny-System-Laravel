{{-- begin:: template main --}}
@extends('template.main')
{{-- end:: template main --}}

{{-- begin:: title --}}
@section('title', 'Document')
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
                        <h1 class="d-flex align-items-center fs-3 my-1">Document
                        </h1>
                        <!--end::Title-->
                    </div>
                    <!--end::Page title-->

                </div>
                <!--end::Container-->
            </div>
            <!--end::Toolbar-->


            <!--begin::Post-->
            <!--begin::Container-->
            <!--begin::Card "style edited"-->
            <div class="card" id="List-vv" style="position: relative; overflow: hidden;">




                <!--begin::Card header-->
                <div class="card-header border-0 pt-">
                    {{-- @if (count($all_document) > 0) --}}

                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                            transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" data-kt-customer-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-15" placeholder="Search Document">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0 ">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-auto">No.</th>
                                <th class="min-w-auto">Nama Dokumen</th>
                                <th class="min-w-auto">Tanggal</th>

                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @php
                                $counter = 0;
                            @endphp
                            @foreach ($all_document as $i => $document)
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td><a href="/document/view/{{$id_documents[$i][0]}}/{{$document->id_document}}"
                                            class="text-hover-primary text-gray-500">{{ $documents_name[$i] }}</a>
                                    </td>
                                    <td>{{ date_format(date_create($document->created_at), 'd M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            {{-- @else
                <div class="text-center">
                    <img class="img-fluid my-5" height="300" width="300"
                        src="{{ asset('/media/illustrations/dozzy-1/18-dark.png') }}">
                    <h3 class=""><b>Data not found</b></h3>
                </div>
                @endif --}}

            </div>
            <!--end::Card-->
            <!--end::Container-->
            <!--end::Post-->


        </div>
        <!--end::Content-->
        <!--begin::Footer-->

        <!--end::Footer-->
    </div>
@endsection

@section('aside')
    @include('template.aside')
@endsection
