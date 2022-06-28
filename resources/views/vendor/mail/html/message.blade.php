@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{asset("/media/logos/Logo2.png")}}" alt="Sunny System" style="background-repeat: no-repeat; background-size: cover" class="img-fluid" height="150" width="500">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} Sunny System. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
