<?php

namespace App\Mail;

use App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class jobFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $message; // The data of a request to be sent
    protected $job;
    public function __construct(Jobs $job, $message)
    {
        $this->message = $message;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your job "'.$this->job->job_title.'" with ID '.$this->job->id.' has failed. | 3D Printing Service')
            ->markdown('emails.jobFailed')->with([
                'customer_name' => $this->job->customer_name,
                'customer_email' => $this->job->customer_email,
                'customer_id' => $this->job->customer_id,
                'use_case' => $this->job->use_case,
                'created_at' => $this->job->created_at,
                'message' => $this->message
            ]);
    }
}
