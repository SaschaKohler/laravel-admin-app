<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        return $this->subject('Auftragsänderung - ' . $this->event->type . ' Dirneder KG')
            ->markdown('emails.events.dismiss');

    }
}
