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
        $this->locale= "de";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::parse($this->event->start)->translatedFormat('l\, d.F.Y');


        return $this->subject('Auftragsbestätigung - ' . $this->event->type . ' Dirneder KG')
            ->markdown('emails.events.confirm')
            ->with([
                'date' => $date
            ]);
    }
}
