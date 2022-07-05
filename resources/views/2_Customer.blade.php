{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Customer')
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
                                <h1 class="d-flex align-items-center fs-3 my-1">Pelanggan
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            @if (auth()->user()->check_administrator)
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-1">

                                        <!--begin::Button-->
                                        <a href="customer/new" class="btn btn-sm btn-primary w-80px"
                                        id="kt_toolbar_primary_button"
                                        style="background-color:#ffa62b; padding: 6px">
                                        New</a>

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
                            @endif
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Toolbar-->



                    <!--begin::Post-->
                    <!--begin::Container-->
                    <!--begin::Card-->
                    <div class="card" Id="List-vv">


                        <!--begin::Card header-->
                        <div class="card-header border-0">
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
                                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Pelanggan" />
                                </div>
                                <!--end::Search-->
                                <!--begin::Paginate-->
                                {{-- <div class="align-items-center d-flex justify-content-end">
                                    <div class="p-2" style="color:gray">
                                        Showing
                                        {{ $customer->firstItem() }}
                                        to
                                        {{ $customer->lastItem() }}
                                        of
                                        {{ $customer->total()}}
                                        entries
                                    </div>
                                    
                                    <div>
                                        {{ $customer->links() }}
                                    </div>
                                    
                                </div> --}}
                                <!--end::Paginate-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <table class="table align-middle table-row-dashed fs-6 gy-2" id="kt_customers_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        {{-- <th class="min-w-auto">No.</th> --}}
                                        <th class="min-w-auto">Customer Name</th>
                                        <th class="max-w-50px">Email</th>
                                        <th class="min-w-auto">Phone Number</th>
                                        <th class="min-w-auto">Website</th>
                                        <th class="min-w-auto">Created Date</th>
                                        <th class="min-w-auto">PIC</th>
                                        @if (auth()->user()->check_administrator)
                                        <th class="min-w-auto text-center">Action</th>
                                        @endif
                                        {{-- <th class="max-w-120px"><center>Action</center></th> --}}
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                
                               
                                    <!-- Begin :: Results -->
                                    <tbody class="fw-bold text-gray-600" id="data-wrapper">

                                        <!-- Results :: Data Tabel Infinite Scroll -->

                                    </tbody>
                                    <!-- End :: Results -->

                            </table>
                            <!--end::Table-->

                        <!-- Data Loader -->
                        <div class="auto-load text-center">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
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


{{-- begin::modal DELETE --}}
    @foreach ($results as $customers)
        <form action="/customer/delete/{{ $customers->id_customer }}" method="post" enctype="multipart/form-data">
            @method('delete')
            @csrf
            <div class="modal fade" id="kt_modal_delete{{ $customers->id_customer }}" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-800px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2>Hapus : {{ $customers->name }}</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg text-white"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-lg-6 px-lg-6">
                            Data yang dihapus tidak dapat dipulihkan, anda yakin ?
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-light btn-active-primary">Delete</button>
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
            </div>
        </form>
    @endforeach
{{-- end::modal DELETE --}}


@endsection
{{-- End::Main --}}

@section("js-script")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var ENDPOINT = "{{ url('/') }}";
    var page = 1;
    infinteLoadMore(page);
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            infinteLoadMore(page);
        }
    });
    function infinteLoadMore(page) {
        $.ajax({
                url: ENDPOINT + "/customer?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.length == 0) {
                    $('.auto-load').html('<div class="alert alert-secondary rounded-0" role="alert">Opss, Data Tidak Ditemukan !</div>');
                    return;
                }
                $('.auto-load').hide();
                $("#data-wrapper").append(response);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>
@endsection

