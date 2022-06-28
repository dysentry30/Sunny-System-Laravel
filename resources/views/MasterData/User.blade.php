{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Users')
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


                <!--begin::Delete Alert -->
                {{-- <div class="alert alert-success" role="alert">
						Delete Success !
					</div> --}}
                <!--end::Delete Alert -->

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
                                <h1 class="d-flex align-items-center fs-3 my-1">Users
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center py-1">

                                <!--begin::Button-->
                                <a href="/user/new" class="btn btn-sm btn-active-primary"
                                    style="background-color:#ffa62b; padding: 7px 30px 7px 30px">
                                    New</a>

                                <!--begin::Wrapper-->
                                <div class="me-4" style="margin-left:10px;">
                                    <!--begin::Menu-->
                                    <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                        <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Action
                                    </a>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                        id="kt_menu_6155ac804a1c2">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-dark fw-bolder">Choose actions:</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Menu separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Form-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->

                                                <i class="fas fa-file-excel"></i>
                                                <label class="form-label" style="margin-left:5px;">
                                                    Export Excel</label><br>
                                                <i class="fas fa-file"></i>
                                                <label class="form-label" style="margin-left:5px;">
                                                    Import Excel</label><br>
                                                <!--end::Label-->
                                            </div>
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

                    {{-- begin:: Alert --}}
                    @if (Session::has('failed') || Session::has('success'))
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="#0f5132" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="#842029" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-9 mb-8" role="alert">
                                <div class="d-flex align-items-center ">
                                    <div class="col-1">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                            aria-label="Success:">
                                            <use xlink:href="#check-circle-fill" />
                                        </svg>
                                    </div>
                                    <div class="col">
                                        {!! Session::get('success') !!}
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger alert-dismissible fade show mx-9 mb-8" role="alert">
                                <div class="d-flex align-items-center ">
                                    <div class="col-1">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                            aria-label="Danger:">
                                            <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                    </div>
                                    <div class="col">
                                        {!! Session::get('failed') !!}
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    {{-- end:: Alert --}}

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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                fill="black" />
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" data-kt-customer-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-15"
                                        placeholder="Search Proyek" />
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
                                        <th class="min-w-auto">Name</th>
                                        <th class="min-w-auto">Email</th>
                                        <th class="min-w-auto">Unit Kerja</th>
                                        <th class="min-w-auto">Role</th>
                                        <th class="">
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                @php
                                    // $companies = $companies->reverse();
                                    $no = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tbody class="fw-bold text-gray-600">
                                        <tr>

                                            <!--begin::No=-->
                                            <td>
                                                {{ $no++ }}
                                            </td>
                                            <!--end::No=-->

                                            <!--begin::Ketua tender=-->
                                            <td>
                                                <a href="/user/view/{{$user->id}}" class="text-hover-primary text-gray-500">{{ $user->name }}</a>
                                            </td>
                                            <!--end::Ketua tender=-->

                                            <!--begin::Email=-->
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <!--end::Email=-->

                                            <!--begin::unit=-->
                                            <td>
                                                {{ $user->UnitKerja->unit_kerja ?? '-' }}
                                            </td>
                                            <!--end::unit=-->

                                            <!--begin::Role=-->
                                            <td>
                                                @php
                                                    $roles = explode(',', $user->role_id);
                                                @endphp
                                                @if (count($roles) > 1)
                                                    @foreach ($roles as $i => $role)
                                                        @switch((int) $role)
                                                            @case(1)
                                                                - Administrator
																<br>
                                                            @break

                                                            @case(2)
                                                                - Admin Kontrak
																<br>
                                                            @break

                                                            @case(3)
                                                                - User Sales
																<br>
                                                            @break

                                                            @case(4)
                                                                - Team Proyek
																<br>
															@break

                                                            @default
                                                        @endswitch
                                                    @endforeach
                                                @else
                                                    @switch($user->role_id)
                                                        @case(1)
                                                            - Administrator
                                                        @break

                                                        @case(2)
                                                            - Admin Kontrak
                                                        @break

                                                        @case(3)
                                                            - User Sales
                                                        @break

                                                        @case(4)
                                                            - Team Proyek
                                                        @break

                                                        @default
                                                    @endswitch
                                                @endif
                                            </td>
                                            <!--end::Role=-->

                                            <!--begin::Created at=-->
                                            <td>
                                                {{ date_format(new DateTime($user->created_at), 'd M Y') }}
                                            </td>
                                            <!--end::Created at=-->

                                            <!--begin::Action=-->
                                            <td>
                                                <!--begin::Button-->
                                                <center>
                                                    <form action="#" method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-sm btn-light btn-active-primary"
                                                            onclick="return confirm('Deleted user can not be undo. Are You Sure ?')">Delete</button>
                                                    </form>
                                                </center>
                                                <!--end::Button-->
                                            </td>
                                            <!--end::Action=-->
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

@section('js-script')
    <script>
        function copyPassword(elt) {
            const pwGenerated = document.querySelector("#pw-generated");
            var r = document.createRange();
            r.selectNode(pwGenerated);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(r);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            elt.innerHTML = `
			<i class='bi bi-clipboard-check text-dark'></i>
			`;
        }
    </script>
@endsection

@section('aside')
    @extends('template.aside')
@endsection
