@component('mail::message')
# Termin-Bestätigung {{ $event->type }}

Hallo {{ $event->customer->title }} {{ $event->customer->last }}, <br><br>
Wir bestätigen hiermit Ihren Termin: <br>
<br>
**{{ $event->type }} am {{ $event->start }}** <br>
<br>
*Mit kurzfristigen Terminverschiebungen sind wetterbedingt möglich*<br>

Wir informieren Sie rechtzeitig<br>


Vielen Dank, Ihr Karl Dirneder<br>

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    @endcomponent
@endslot

@endcomponent
