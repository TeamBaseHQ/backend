<?php

namespace Base\Events\Team\Channel\Thread;

use Base\Http\Resources\ChannelResource;
use Base\Http\Resources\MessageResource;
use Base\Http\Resources\ThreadResource;
use Base\Models\Channel;
use Base\Models\Message;
use Base\Models\Thread;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageWasSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Base\Models\Message
     */
    public $message;

    /**
     * @var \Base\Models\Channel
     */
    public $channel;

    /**
     * @var \Base\Models\Thread
     */
    public $thread;

    /**
     * Create a new event instance.
     *
     * @param \Base\Models\Channel $channel
     * @param \Base\Models\Thread  $thread
     * @param \Base\Models\Message $message
     */
    public function __construct(Channel $channel, Thread $thread, Message $message)
    {
        $this->channel = $channel;
        $this->thread = $thread;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channelLine = 'channel.' . $this->channel->slug;

        return new \Illuminate\Broadcasting\Channel($channelLine);
    }

    public function broadcastWith()
    {
        $message = (new MessageResource($this->message))->toArray(request());
        $message['thread'] = (new ThreadResource($this->thread))->toArray(request());
        $message['thread']['channel'] = (new ChannelResource($this->channel))->toArray(request());

        return $message;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.received';
    }
}
