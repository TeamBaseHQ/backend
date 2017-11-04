<?php

namespace Base\Listeners\User;

use Mail;
use Base\Mail\ConfirmUser;
use Base\Events\User\UserWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

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
