
@component('mail::message')
# Termin-Bestätigung {{ $event->type }}

Hallo {{$event->customer->prefix}} {{ $event->customer->title }} {{ $event->customer->last }}, <br><br>
Wir bestätigen hiermit Ihren Termin: <br>
<br>
**{{ $event->type }} am {{ $date }}** <br>
<br>
*kurzfristige Terminverschiebungen sind wetterbedingt möglich*<br>

Wir informieren Sie rechtzeitig<br>


Vielen Dank, Ihr Karl Dirneder<br>

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    @endcomponent
@endslot

@endcomponent
