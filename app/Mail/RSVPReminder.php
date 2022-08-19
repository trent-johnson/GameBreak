<?php

namespace App\Mail;

use App\Models\GameBreak;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RSVPReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $invitee;
    public $break;
    public $secure;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitee $remind, GameBreak $break, $secure)
    {
        $this->invitee = $remind;
        $this->break = $break;
        $this->secure = $secure;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@mail.gamebreak.app', 'Game Break')
            ->subject('Reminder: ' . $this->break->user->name . "'s invite is waiting")
            ->markdown('emails.break.rsvp-reminder');
    }
}
