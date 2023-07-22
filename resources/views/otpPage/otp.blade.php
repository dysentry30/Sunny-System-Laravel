<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification OTP</title>
    <link href="{{ asset('/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
</head>

<style>
    .card {
        width: 350px;
        padding: 10px;
        border-radius: 20px;
        background: #fff;
        border: none;
        height: min-content;
        position: relative;
    }

    .container {
        height: 100vh;
    }

    body {
        background: #0DB0D9;
    }

    .mobile-text {
        color: #989696b8;
        font-size: 15px;
    }

    .form-control {
        margin-right: 12px;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #ff8880;
        outline: 0;
        box-shadow: none;
    }

    .cursor {
        cursor: pointer;
    }
</style>

<body>
    <div class="d-flex justify-content-center align-items-center container">
        <div class="card py-5 px-3">
            <form action="" method="get">
                @csrf
                <input type="hidden" name="user" id="user" value="{{$user->nip}}">
                <input type="hidden" name="open" id="open" value="{{$data["open"]}}">
                <h5 class="m-0">Mobile phone verification</h5><span class="mobile-text">Enter the code we just send on your mobile phone <b class="text-primary">{{$user->no_hp}}</b></span>
                <div class="d-flex flex-row mt-5">
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control" autofocus>
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control">
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control">
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control">
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control">
                    <input type="text" onkeyup="inputOneDigitOnly(this)" name="otp[]" class="form-control">
                </div>
                <br>
                <center>
                    <input type="submit" name="verify-otp" value="Verify OTP" class="btn btn-sm btn-primary"><br>
                </center>
                <small class="fs-10 text-danger">*The OTP code cannot be pasted to this page, please type it manually.</small>
            </form>
            <div class="text-center mt-5">
                @if (!empty($user->otp))
                    @php
                        $data_otp = json_decode($user->otp);
                    @endphp
                    @if ($data_otp->send_otp_counter < $max_attempt_resend_code)
                        <form action="/resend-otp" method="post">
                            @csrf
                            <span class="d-block mobile-text">Don't receive the code?</span>
                            <input type="hidden" name="user" id="user" value="{{$user->nip}}">
                            <input type="submit" class="btn btn-sm btn-dark"  value="Resend OTP Code">
                            <small class="d-block mobile-text">Resend Attempt: {{$data_otp->send_otp_counter}}/{{$max_attempt_resend_code}}</small>
                        </form>
                    @else
                        <span class="d-block mobile-text">Cannot resend OTP code.</span>
                        <small class="d-block mobile-text">Resend Attempt: {{$data_otp->send_otp_counter}}/{{$max_attempt_resend_code}}</small>
                    @endif
                    
                @else
                    <form action="/send-otp" method="post">
                        @csrf
                        <input type="hidden" name="user" id="user" value="{{$user->nip}}">
                        <input type="submit" class="btn btn-sm btn-dark"  value="Send OTP Code">
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll("input[type='text']");
        for (let i = 0; i < inputs.length; i++) {
            const element = inputs[i];
            element.addEventListener("keydown", (event) => {
                if(event.key === "Backspace" && !element.value) {
                    setTimeout(() => {
                        inputs[i - 1].focus();
                    }, 150);
                }
            });
        }

        function inputOneDigitOnly(e) {
            console.log(e.key);
            if(e.value.match(/[0-9]/gi)) {
                if(e.value) {
                    const value = e.value.split("").pop();
                    e.value = value;
                }
                for (let i = 0; i < inputs.length; i++) {
                    const element = inputs[i];
                    if(!element.value) {
                        element.focus();
                        break;       
                    }
                    
                }
            }
        }
    </script>
</body>

</html>
@include('sweetalert::alert')
