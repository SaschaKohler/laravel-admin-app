@component('mail::message')
# Termin-Änderung {{ $event->type }}

Hallo {{ $event->customer->title }} {{ $event->customer->last }}, <br><br>
Leider müssen wir folgenden Termin: <br>
<br>
**{{ $event->type }} am {{ $event->start }}** <br>
<br>
vorerst absagen.<br>

Wir setzen uns mit Ihnen in Kürze in Verbindung um einen entsprechenden Termin neu zu avesieren<br>


Vielen Dank für Ihr Verständnis,<br>
Ihr Karl Dirneder<br>

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    @endcomponent
@endslot

@endcomponent
