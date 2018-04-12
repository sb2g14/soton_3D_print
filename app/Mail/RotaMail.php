<?php

namespace App\Mail;

use App\Sessions;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class RotaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $sessions;
    protected $message; // The data of a request to be sent
    public function __construct($sessions, $message )
    {
        $this->message = $message;
        $this->sessions = $sessions->toArray();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('3D Printing Service rota for '.Carbon::parse($this->message['date'])->format('D, dS \\of M Y'))
            ->markdown('emails.rotaMail')->with([
                'date' => $this->message['date'],
                'message' => $this->message['comment'],
                'sessions' => $this->sessions
            ]);
    }
}
