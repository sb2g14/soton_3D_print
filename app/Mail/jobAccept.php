<?php

namespace App\Mail;

use App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class jobAccept extends Mailable
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
        return $this->subject('Your job "'.$this->job->job_title.'" with ID '.$this->job->id.' has been accepted. | 3D Printing Service')
            ->markdown('emails.jobAccept')->with([
                'customer_name' => $this->job->customer_name,
                'customer_email' => $this->job->customer_email,
                'customer_id' => $this->job->customer_id,
                'use_case' => $this->job->use_case,
                'created_at' => $this->job->created_at,
                'total_duration' => $this->job->total_duration,
                'total_material_amount' => $this->job->material_amount,
                'total_price' => $this->job->total_price
            ]);
    }
}
