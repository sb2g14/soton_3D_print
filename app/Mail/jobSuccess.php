<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs;


class jobSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $job;
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
        return $this->subject('The job by '.$this->job->customer_name. ' with ID'.$this->job->id.' was successfully finished.')
            ->markdown('emails.jobSuccess')->with([
                'customer_name' => $this->job->customer_name,
                'customer_email' => $this->job->customer_email,
                'customer_id' => $this->job->customer_id,
                'use_case' => $this->job->use_case,
                'created_at' => $this->job->created_at,
            ]);
    }
}
