<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <title>Sunny System</title>
    <link href="/css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="parent clearfix">
        <div class="bg-illustration">
            @if (str_contains(Request::Path(), 'ccm'))
                <img style="margin-top: 100px; margin-left: 50px" src="/media/logos/logo-ccm.png" alt="logo">
            @else
                <img style="margin-top: 100px; margin-left: 50px" src="/media/logos/logo-wika.png" alt="logo">
            @endif
            {{-- <hr class="text-white mt-10"> --}}
            {{-- <h1 class="text-white mt-5" style="margin-left: 50px; font-size : 75px">WIKA</h1> --}}
            <p class="text-white mt-5" style="margin-left: 55px">Powered by Sunny System</p>
            <div class="burger-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    
        <div class="login ps-20 ">
            <div class="login-logo pb-lg-4 ms-10">
                @if (str_contains(Request::Path(), 'ccm'))
                <br><br><br><br>
                @else
                <img src="media/logos/logo-gray.png" alt="" style="height: 50px; margin-top:100px"/>
                @endif
            </div>
            <br>
            <div class="login-form">
                <form action="/login" method="post" class="form px-10" id="kt_sign_in_form" action="#">
                    @csrf
                    <!--begin::Heading-->
                    {{-- <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">Sunny System</h1>
                        <!--end::Title-->
                        <!--begin::Link-->
                        <div class="text-gray-400 fw-bold fs-4">New Here?
                        <a href="../../demo1/dist/authentication/flows/basic/sign-up.html" class="link-primary fw-bolder">Create an Account</a></div>
                        <!--end::Link-->
                    </div> --}}
                    <!--begin::Heading-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10" style="width: 60%">
                        <!--begin::Label-->
                        <label
                            class="font-size-h6 font-weight-bolder text-dark form-label fs-6 fw-bolder @error('email') is-invalid @enderror">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input value="{{ old('email') }}" class="form-control form-control-lg form-control-solid"
                            type="email" name="email" autocomplete="off" placeholder="example@Sunny" autofocus
                            required />
                        <!--end::Input-->
                        @error('email')
                            <h6 class="text-danger invalid-feedback">{{ $message }}</h6>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10" style="width: 60%">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class=" font-size-h6 font-weight-bolder text-darkform-label fw-bolder fs-6 mb-0">Password</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            {{-- <a href="" class="link-primary fs-6 fw-bolder">Forgot Password ?</a> --}}
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input
                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            type="password" name="password" autocomplete="off" placeholder="insert Password"
                            required />
                        @error('password')
                            <h6 class="text-danger invalid-feedback">{{ $message }}</h6>
                        @enderror
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center" style="width: 30%">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-primary w-100 my-5">
                            <span class="indicator-label">Continue</span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                </form>
            </div>
        
        </div>
    </div>
</body>
</html>

<!--begin::sweet alert-->
@include('sweetalert::alert')
<!--end::sweet alert-->