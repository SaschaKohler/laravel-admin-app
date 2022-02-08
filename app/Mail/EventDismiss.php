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
        $time = $this->event->start;
        $date = Carbon::createFromDate($time)->format('d.m.y');

        return $this->subject('Auftragsänderung - ' . $this->event->type . ' Dirneder KG')
            ->markdown('emails.events.dismiss')
            ->with([
                'date' => $date
            ]);

    }
}
