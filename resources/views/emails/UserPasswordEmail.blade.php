@component('mail::message')
# Sunny System Account Created

Pastikan akun anda disimpan dan diganti passwordnya.

<hr>
<b>Detail User Information</b>

    - Email     : {{ $user->email }}
    - Password  : {{ $password }}
<hr>
    Thanks,<br>
    {{auth()->user()->name}} <br>
    {{ auth()->user()->email }}
@endcomponent
