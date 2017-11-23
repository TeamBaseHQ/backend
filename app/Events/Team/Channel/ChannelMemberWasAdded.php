<?php

namespace Base\Events\Team\Channel;

use Base\Models\Team;
use Base\Models\User;
use Base\Models\Channel;
use Base\Http\Resources\TeamResource;
use Base\Http\Resources\UserResource;
use Illuminate\Queue\SerializesModels;
use Base\Http\Resources\ChannelResource;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelMemberWasAdded implements ShouldBroadcast
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
     * @var \Base\Events\Team\Channel\User
     */
    public $member;

    /**
     * Create a new event instance.
     *
     * @param \Base\Models\User    $member
     * @param \Base\Models\Channel $channel
     * @param \Base\Models\Team    $team
     */
    public function __construct(User $member, Channel $channel, Team $team)
    {
        $this->member = $member;
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
        $channelName = 'channel.' . $this->channel->slug;

        return new \Illuminate\Broadcasting\Channel($channelName);
    }

    public function broadcastWith()
    {
        $channel = (new ChannelResource($this->channel))->toArray(request());
        $channel['team'] = (new TeamResource($this->team))->toArray(request());
        $channel['member'] = (new UserResource($this->member))->toArray(request());

        return $channel;
    }

    public function broadcastAs()
    {
        return 'channel.member_added';
    }
}
