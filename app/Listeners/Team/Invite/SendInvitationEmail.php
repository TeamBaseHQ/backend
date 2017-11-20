<?php

namespace Base\Listeners\Team\Invite;

use Base\Events\Team\Invite\InvitationWasCreated;
use Base\Mail\TeamInvitation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendInvitationEmail implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvitationWasCreated $event
     *
     * @return void
     */
    public function handle(InvitationWasCreated $event)
    {
        Mail::send(new TeamInvitation($event->invitation));
    }
}
