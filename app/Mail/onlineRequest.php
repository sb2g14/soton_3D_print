<?php

namespace App\Mail;

use App\Jobs;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class onlineRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $job; // The data of a request to be sent
    public function __construct(Jobs $job)
    {
        $this->job = $job;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Online request from '.$this->job->customer_name . ', ID ' .$this->job->customer_id)
            ->markdown('emails.requestOnline')->with([
            'customer_name' => $this->job->customer_name,
            'customer_email' => $this->job->customer_email,
            'customer_id' => $this->job->customer_id,
            'use_case' => $this->job->use_case,
            'claim_id' => $this->job->claim_id,
            'claim_passcode' => $this->job->claim_passcode,
            'created_at' => $this->job->created_at
        ]);
    }
}
