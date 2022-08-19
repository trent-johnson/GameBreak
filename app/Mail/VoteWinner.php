<?php

namespace App\Mail;

use App\Models\GameBreak;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoteWinner extends Mailable
{
    use Queueable, SerializesModels;

    public $invitee;
    public $break;
    public $secure;
    public $email_games;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitee $remind, GameBreak $break, $secure, $email_games)
    {
        $this->invitee = $remind;
        $this->break = $break;
        $this->secure = $secure;
        $this->email_games = $email_games;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('noreply@mail.gamebreak.app', 'Game Break')
            ->subject("Get Pumped! You'll be playing " . $this->email_games[0]['name'] . ' soon.')
            ->markdown('emails.break.vote-winner');
    }
}
