<?php

namespace App\Mail;

use App\Models\Invitee;
use App\Models\GameBreak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BreakInvite extends Mailable
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
    public function __construct(Invitee $invitee, GameBreak $break, $secure)
    {
        $this->invitee = $invitee;
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
        return $this->from('gamebreak@mail.gamebreak.app','Game Break')
            ->markdown('emails.break.invite');
    }
}
