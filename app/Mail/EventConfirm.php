<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Event;
use Carbon\CarbonTimeZone;
use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventConfirm extends Mailable
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
        $this->locale= "de_AT";
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

        return $this->subject('Auftragsbestätigung - ' . $this->event->type . ' Dirneder KG')
            ->markdown('emails.events.confirm')
            ->with([
                'date' => $date
            ]);
    }
}
