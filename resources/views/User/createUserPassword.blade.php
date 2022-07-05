{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}

{{-- Begin::Title --}}
@section('title', 'Lihat User')
{{-- End::Title --}}

{{-- Begin::Content --}}
@section('content')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

        {{-- begin::header --}}
        @extends('template.header')
        {{-- end::header --}}


        <!--begin::Delete Alert -->

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
                        <h1 class="d-flex align-items-center fs-3 my-1">Buat Password Baru
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

                <!--begin::Card body-->
                <div class="card-body pt-0">

                    <form action="/user/password/reset/save" method="POST">
                        @csrf
                        <div class="pt-9 d-flex flex-row align-items-center justify-content-center">
                            <div class="col-2">
                                <label for="new-password">Password</label>
                            </div>

                            <div class="col">
                                <input type="hidden" name="reset-password-token" value="{{ $reset_password_token }}">
                                <input type="password" class="form-control" name="reset-password-new" id="see-password">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-2">
                                {{-- ! THIS IS EMPTY --}}
                            </div>
                            <div class="col form-check">
                                <input class="form-check-input" onchange="seePassword()" type="checkbox"
                                    name="see-password-checkbox" id="see-password-checkbox" value="">
                                <label class="form-check-label" for="see-password-checkbox">
                                    Lihat Password
                                </label>
                            </div>
                        </div>
                        <br><br>
                        <div class="d-flex flex-row justify-content-end">
                            <button type="submit" name="reset-password" class="btn btn-sm btn-active-primary text-white"
                                style="background-color: #008CB4;">Terapkan</button>
                            {{-- <div class="col">
                            </div> --}}
                        </div>
                    </form>

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
@endsection
{{-- End::Content --}}

{{-- Begin:: JS SCRIPT --}}
@section('js-script')
    <script>
        function seePassword() {
            const inputPasswordElt = document.querySelector("#see-password");
            const getTypeInputPassword = inputPasswordElt.getAttribute("type");
            if (getTypeInputPassword == "text") {
                inputPasswordElt.setAttribute("type", "password");
            } else {
                inputPasswordElt.setAttribute("type", "text");
            }
        }
    </script>
@endsection
{{-- end:: JS SCRIPT --}}
