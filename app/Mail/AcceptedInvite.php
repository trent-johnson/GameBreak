<?php

namespace App\Mail;

use App\Models\GameBreak;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class AcceptedInvite extends Mailable
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
        /*
        return $this->from('noreply@mail.gamebreak.app','Game Break')
            ->subject('Calendar Invite: ' . $this->break->user->name . "'s Game Break")
            ->markdown('emails.break.accept')
            ->attachData($this->break->generateCalendar($this->invitee->id, $this->secure), 'game-break.ics', [
            'mime' => 'text/calendar',
        ]);
        */
        $this->from('noreply@mail.gamebreak.app','Game Break')
            ->subject('Calendar Invite: ' . $this->break->user->name . "'s Game Break")
            ->text('emails.break.rawical')
            ->with(['icaldata' => $this->break->generateCalendar($this->invitee->id, $this->secure)]);

        $this->withSymfonyMessage(function (Email $message) {
            $message->getHeaders()->addTextHeader(
                'Content-Type', 'text/calendar; charset=utf-8'
            );
        });

        return $this;
    }
}
