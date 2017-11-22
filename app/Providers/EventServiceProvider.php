<?php

namespace Base\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Base\Events\User\UserWasCreated' => [
            'Base\Listeners\User\SendConfirmationEmail',
        ],
        'Base\Events\Team\TeamWasCreated' => [
        ],
        'Base\Events\Team\Invite\InvitationWasCreated' => [
            'Base\Listeners\Team\Invite\SendInvitationEmail',
        ],
        'Base\Events\Team\Channel\ChannelWasCreated' => [],
        'Base\Events\Team\Channel\ChannelWasUpdated' => [],
        'Base\Events\Team\Channel\ChannelWasDeleted' => [],
        'Base\Events\Team\Channel\ChannelMemberWasAdded' => [],
        'Base\Events\Team\Channel\ChannelMemberWasRemoved' => [],
        'Base\Events\Team\Channel\Thread\MessageWasSent' => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
