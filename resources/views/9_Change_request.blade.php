{{-- Begin:: Template main --}}
@extends('template.main')
{{-- End:: Template main --}}

{{-- Begin:: Title --}}
@section('title', 'Change Request')
{{-- Begin:: Title --}}

{{-- Begin:: Content --}}
@section('content')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Change Request
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
                    <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">
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
                                    <form action="" class="d-flex flex-row w-auto" method="get">
                                        <!--Begin:: Select Options-->
                                        <select id="column" name="column" class="form-select form-select-solid select2-hidden-accessible" style="margin-right: 2rem" data-control="select2" data-hide-search="true" data-placeholder="Column" data-select2-id="select2-data-bulan" tabindex="-1" aria-hidden="true">
                                            <option {{$column == "" ? "selected": ""}}></option>
                                            <option value="no_addendum" {{$column == "no_addendum" ? "selected" : ""}}>No Addendum</option>
                                            <option value="created_at" {{$column == "created_at" ? "selected" : ""}}>Tanggal Diajukan</option>
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
                            <div class="card-body pt-0 ">
                                <!--begin::Table-->
                                <table class="table align-top table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto">@sortablelink('no_addendum','No Addendum')</th>
                                            <th class="min-w-auto">@sortablelink('created_at','Tanggal Diajukan')</th>
                                            {{-- <th class="min-w-auto">@sortablelink('uraian_perubahan','Uraian Perubahan')</th> --}}
                                            <th class="min-w-auto">Uraian Perubahan</th>
                                            <th class="min-w-auto">Tgl Disetujui/Ditolak</th>
                                            <th class="min-w-auto">Status</th>
                                            <th class="min-w-auto">Tanggal Amandemen</th>
                                            <th class="min-w-auto">Nilai Amandemen</th>
                                            <th class="min-w-auto">Waktu Amandemen</th>
                                            {{-- <th class="min-w-auto"></th> --}}
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @foreach ($addendumContracts as $addendumContract)
                                        <tr>
                                            <!--begin::No Adendum-->
                                            <td>
                                                <a class="text-gray-800 text-hover-primary mb-1" href="/contract-management/view/{{$addendumContract->id_contract}}/addendum-contract/{{$addendumContract->id_addendum}}">{{ $addendumContract->no_addendum }}</a>
                                            </td>
                                            <!--end::No Adendum-->
                                            <!--begin::Tanggal Diajukan-->
                                            <td>
                                                {{ date_format(date_create($addendumContract->created_at), 'd M Y') }}
                                            </td>
                                            <!--end::Tanggal Diajukan-->
                                            <!--begin::Uraian Perubahan-->
                                            <td>
                                                @forelse ($addendumContract->addendumContractDrafts as $adendumDraft)
                                                    <p class="">
                                                        {{ $adendumDraft->uraian_perubahan }}
                                                    </p>
                                                @empty
                                                    <p class="text-danger">
                                                        Harus buat <b>Addendum Kontrak Draft</b> dahulu
                                                    </p>
                                                @endforelse
                                            </td>
                                            <!--end::Uraian Perubahan-->
                                            <!--begin::Tanggal Disetujui-->
                                            <td>
                                                @forelse ($addendumContract->addendumContractDisetujui as $adendumDisetujui)
                                                    {{ date_format(date_create($adendumDisetujui->tanggal_disetujui), 'd M Y' ) }}
                                                @empty
                                                    <p class="text-danger">
                                                        Klaim belum disetujui
                                                    </p>
                                                @endforelse
                                            </td>
                                            <!--end::Tanggal Disetujui-->
                                            <!--begin::Status-->
                                            <td>
                                                @switch($addendumContract->stages)
                                                    @case("1") Draft
                                                        @break
                                                    @case("2") Diajukan
                                                        @break
                                                    @case("3") Negoisasi
                                                        @break
                                                    @case("4") Disetujui
                                                        @break
                                                    @case("5") Amandemen
                                                        @break
                                                    @case("6") Ditolak
                                                        @break
                                                    @default --
                                                @endswitch
                                            </td>
                                            <!--end::Status-->
                                            <!--begin::Tanggal Amandemen-->
                                            @forelse ($addendumContract->addendumContractAmandemen as $adendumAmandemen)
                                                <td>
                                                    {{ date_format(date_create($adendumAmandemen->tanggal_amandemen), 'd M Y') }}
                                                </td>
                                            @empty
                                                <td>
                                                    <p class="text-danger">
                                                        Klaim harus berada di <b>Amandemen</b>
                                                    </p>
                                                </td>
                                            @endforelse
                                            <!--end::Tanggal Amandemen-->
                                            <!--begin::Nilai Amandemen-->
                                            @forelse ($addendumContract->addendumContractAmandemen as $adendumAmandemen)
                                                <td>
                                                    {{ number_format($adendumAmandemen->biaya_amandemen, 0, '.', ',') }}
                                                </td>
                                            @empty
                                                <td>
                                                    <p class="text-danger">
                                                        Klaim harus berada di <b>Amandemen</b>
                                                    </p>
                                                </td>
                                            @endforelse
                                            <!--begin::Nilai Amandemen-->
                                            <!--begin::Waktu Amandemen-->
                                            @forelse ($addendumContract->addendumContractAmandemen as $adendumAmandemen)
                                                <td>
                                                {{ date_format(date_create($adendumAmandemen->waktu_eot_amandemen), 'd M Y') }}
                                                </td>
                                            @empty
                                                <td>
                                                    <p class="text-danger">
                                                        Klaim harus berada di <b>Amandemen</b>
                                                    </p>
                                                </td>
                                            @endforelse
                                            <td>
                                            </td>
                                            <!--begin::Waktu Amandemen-->
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
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
@endsection
{{-- End:: Content --}}
