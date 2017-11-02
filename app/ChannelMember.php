<?php

namespace Base;

use Illuminate\Database\Eloquent\Model;

class ChannelMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "channel_member";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id', 'user_id', 'last_viewed_at', 'messages_viewed'
    ];
}
