<?php

namespace Base\Events\Team;

use Base\Models\Team;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TeamWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Base\Models\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param \Base\Models\Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
