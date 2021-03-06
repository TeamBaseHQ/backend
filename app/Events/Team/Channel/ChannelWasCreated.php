<?php

namespace Base\Events\Team\Channel;

use Base\Models\Team;
use Base\Models\Channel;
use Base\Http\Resources\TeamResource;
use Illuminate\Queue\SerializesModels;
use Base\Http\Resources\ChannelResource;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelWasCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Base\Models\Channel
     */
    public $channel;

    /**
     * @var \Base\Models\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param \Base\Models\Channel $channel
     * @param \Base\Models\Team    $team
     */
    public function __construct(Channel $channel, Team $team)
    {
        $this->channel = $channel;
        $this->team = $team;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channelName = 'team.' . $this->team->slug;

        // Only broadcast to the current user.
        if ($this->channel->isPrivate()) {
            $channelName = 'user.' . $this->team->slug;
        }

        return new \Illuminate\Broadcasting\Channel($channelName);
    }

    public function broadcastWith()
    {
        $channel = (new ChannelResource($this->channel))->toArray(request());
        $channel['team'] = (new TeamResource($this->team))->toArray(request());

        return $channel;
    }

    public function broadcastAs()
    {
        return 'channel.created';
    }
}
