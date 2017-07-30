<?php

namespace App\Mail;

use App\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnnouncementNew extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $announcement;
    public function __construct(User $user, Announcement $announcement)
    {
        $this->user = $user;
        $this->announcement = $announcement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New announcement from 3D printing workshop')->markdown('emails.announcementNew')->with([
            'name' => $this->user->name,
            'message' => $this->announcement->message,
            'from' => $this->announcement->user->name
        ]);
    }
}
