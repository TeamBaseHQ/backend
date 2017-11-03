<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "stars";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'user_id'
    ];
}
