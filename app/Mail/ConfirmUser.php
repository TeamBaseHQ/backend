<?php

namespace Base\Mail;

use Base\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Base\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $url;

    /**
     * Create a new message instance.
     *
     * @param \Base\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = url('/');
        $this->subject = "Confirm your Account - " . $this->user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject($this->subject)
            ->markdown('emails.users.confirm');
    }
}
