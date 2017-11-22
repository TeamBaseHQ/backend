<?php

namespace Base\Events\Team\Channel;

use Base\Models\Team;
use Base\Http\Resources\TeamResource;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelWasDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $channelSlug;

    /**
     * @var \Base\Models\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param int               $channelSlug
     * @param \Base\Models\Team $team
     *
     * @internal param \Base\Models\Channel $channel
     */
    public function __construct($channelSlug, Team $team)
    {
        $this->channelSlug = $channelSlug;
        $this->team = $team;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channelLine = 'channel.' . $this->channelSlug;
        info("KUNNU: " . $channelLine);
        return new PrivateChannel($channelLine);
    }

    public function broadcastWith()
    {
        $team = (new TeamResource($this->team))->toArray(request());
        $team['channel_slug'] = $this->channelSlug;

        return $team;
    }

    public function broadcastAs()
    {
        return 'channel.deleted';
    }
}
