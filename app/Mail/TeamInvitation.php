<?php

namespace Base\Mail;

use Base\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Base\Models\Invitation
     */
    public $invitation;

    /**
     * @var string
     */
    public $url;

    /**
     * Create a new message instance.
     *
     * @param \Base\Models\Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
        $this->subject = "Invitation to join {$invitation->team->name} on " . config('app.name');
        $this->url = url("/");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->invitation->email)
            ->markdown('emails.teams.invitation');
    }
}
