{{-- Begin::Extend Header --}}
@extends('template.main')
{{-- End::Extend Header --}}
<style>
    body{
        background-color: #0db0d9 !important;
		/* background-image: url('/media/logos/welcome.png');
		background-repeat: no-repeat;
		/* background-attachment: fixed; */
		/* background-size: cover; */ */
    }
</style>

{{-- Begin::Title --}}
@section('title', 'Welcome to Sunny System')
{{-- End::Title --}}

<!--begin::Main-->
@section('content')

{{-- @if (Session::has("LoginError"))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get("LoginError") }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif --}}

<div >
        <!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					{{-- <img src="/media/logos/welcome.png" style="" alt=""> --}}
					<!--begin::Logo-->
                    <a href="/" style="background-color:#0db0d9;">
                        <img alt="Logo" src="/media/logos/Logo2.png" class="h-70px logo"
                            style="margin-top:30px;margin-left:-20px;" />
                    </a>
                    <br>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-450px shadow-md p-10 p-lg-15 mx-auto rounded-5" 
							style="background: rgba(255, 255, 255, 0.71);
							border-radius: 16px;
							box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
							backdrop-filter: blur(8.7px);
							-webkit-backdrop-filter: blur(8.7px);">
						<!--begin::Form-->
						{{-- <form action="/createUser" method="post" class="form w-100" id="kt_sign_in_form" action="#"> --}}
						<form action="/login" method="post" class="form w-100" id="kt_sign_in_form" action="#">
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
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder @error('email') is-invalid @enderror">Email</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input value="{{ old('email') }}" class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" placeholder="example@Email.com" autofocus required/>
								<!--end::Input-->
                                @error('email')
                                <h6 class="text-danger invalid-feedback">{{ $message }}</h6>
                                @enderror
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									{{-- <a href="" class="link-primary fs-6 fw-bolder">Forgot Password ?</a> --}}
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" type="password" name="password" autocomplete="off" placeholder="insert Password" required/>
                                @error('password')
                                <h6 class="text-danger invalid-feedback">{{ $message }}</h6>
                                @enderror
								<!--end::Input-->
							</div>
							<!--end::Input group-->

							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Continue</span>
								</button>
								<!--end::Submit button-->
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					{{-- <div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div> --}}
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Main-->
</div>

@endsection
{{-- End::Main --}}
