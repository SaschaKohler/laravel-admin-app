<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class EventDismiss extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::parse($this->event->start)->translatedFormat('l\, d.F.Y');  // z.B Freitag,25.Oktober 2022

        return $this->subject('Auftragsänderung - ' . $this->event->type . ' Dirneder KG')
            ->markdown('emails.events.dismiss')
            ->with([
                'date' => $date
            ]);

    }
}
