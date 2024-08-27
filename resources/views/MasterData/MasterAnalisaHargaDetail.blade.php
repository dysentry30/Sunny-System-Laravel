a{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Master AHS')
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
                @include('template.header')
                <!--end::Header-->

                <!--begin::Content-->
                <form action="/analisa-harga-satuan/detail/save/{{ $masterAHS->id }}" method="post">
                    @csrf
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
                                    <h1 class="d-flex align-items-center fs-3 my-1">Master Analisa Harga Satuan
                                    </h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                                @if (auth()->user()->check_administrator || auth()->user()->email == "user-poc@sunny.com")
                                    <div class="d-flex align-items-center py-2">
                                        <!--begin::Button-->
                                        <button type="submit" class="btn btn-sm btn-primary" style="background-color:#008CB4;">Save</button>
                                        <!--save::Button-->
                                    </div>
                                @endif
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Toolbar-->


                        <!--begin::Post-->
                        <!--begin::Container-->
                        <!--begin::Card "style edited"-->
                        <div class="card" Id="List-vv" style="position: relative; overflow: hidden;">

                            <!--begin::Card body-->
                            <div class="card-body pt-3 ">
                                <br>
                                <br>

                                <h4>Kode AHS</h4>
                                <input type="text" class="form-control form-control-solid" id="kode-ahs" name="kode-ahs" value="{{ $masterAHS->kode_ahs }}" placeholder="Kode AHS" max="15"/>
                                <br>
                                <br>
                                
                                <h4>Uraian</h4>
                                <input type="text" class="form-control form-control-solid" id="uraian" name="uraian" value="{{ $masterAHS->uraian }}" placeholder="Uraian" />
                                
                                <br>
                                <br>
                                <br>
                                <br>

                                <!--begin::Table-->
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-2" id="user_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-auto">Kode Sumber Daya</th>
                                            <th class="min-w-400px">Uraian</th>
                                            <th class="min-w-auto">Satuan</th>
                                            <th class="min-w-auto">Action</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        <!--begin::Table row-->
                                        @foreach ($masterSumberDaya as $sumber_daya)
                                        <tr>
                                            <td class="text-center">{{ $sumber_daya->kode_sumber_daya }}</td>
                                            <td>{{ $sumber_daya->uraian }}</td>
                                            <td class="text-center">{{ $sumber_daya->satuan }}</td>
                                            <td class="text-center">
                                                <input class="form-check-input mt-0" type="checkbox"
                                                value="{{ $sumber_daya->kode_sumber_daya }}"
                                                id="sumber_daya_{{ $sumber_daya->kode_sumber_daya }}"
                                                name="checklist-sumber-daya[]"
                                                {{ $masterSumberDayaDetail->contains(function($item) use($sumber_daya){
                                                    return $item->kode_sumber_daya == $sumber_daya->kode_sumber_daya;
                                                }) ? "checked" : "" }}>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--end::Container-->
                        <!--end::Post-->


                    </div>
                </form>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Modal New User-->
    <!--end::Modal New User-->
@endsection

@section('js-script')
    <!--begin::Data Tables-->
    <script src="/datatables/jquery.dataTables.min.js"></script>
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.colVis.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    
    
    <script>
        $(document).ready(function() {
            $('#user_table').DataTable( {
                dom: '<"float-start"f><"#user_table"t>rtip',
                // dom: 'frtip',
                pageLength : 15,
                // ordering : false,
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ]
            } );
        } );
    </script>
    <!--end::Data Tables-->

@endsection
