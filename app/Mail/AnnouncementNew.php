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
    protected $member;
    public function __construct($member, Announcement $announcement)
    {
        $this->announcement = $announcement;
        $this->member = $member->name();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New announcement | 3D Printing Service')->markdown('emails.announcementNew')->with([
            'message' => $this->announcement->message,
            'from' => $this->announcement->user->name,
            'member' => $this->member
        ]);
    }
}
