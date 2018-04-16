<?php

namespace App\Mail;

use App\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnnouncementNew extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $announcement;
    public function __construct($user, Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New announcement from 3D printing service')->markdown('emails.announcementNew')->with([
            'message' => $this->announcement->message,
            'from' => $this->announcement->user->name
        ]);
    }
}
