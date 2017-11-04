<?php

namespace Base\Listeners\User;

use Base\Events\User\UserWasCreated;
use Base\Mail\ConfirmUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendConfirmationEmail
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        Mail::send(new ConfirmUser($event->user));
    }
}
