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
        return $this->subject('3D Printing Workshop rota for '.Carbon::parse($this->message['date'])->format('D, dS \\of M Y'))
            ->markdown('emails.rotaMail')->with([
                'date' => $this->message['date'],
                'message' => $this->message['comment'],
                'sessions' => $this->sessions
            ]);
    }
//    public function build()
//    {
//        return $this->subject('The job by '.$this->job->customer_name. ' with ID'.$this->job->id.' has been rejected.')
//            ->markdown('emails.jobReject')->with([
//                'customer_name' => $this->job->customer_name,
//                'customer_email' => $this->job->customer_email,
//                'customer_id' => $this->job->customer_id,
//                'use_case' => $this->job->use_case,
//                'created_at' => $this->job->created_at,
//                'message' => $this->message
//            ]);
//    }
}
