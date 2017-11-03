<?php

namespace Base;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "channels";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type', 'team_id', 'user_id', 'color', 'notification_meta'
    ];
}
