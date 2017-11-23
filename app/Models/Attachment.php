<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Attachment extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "attachments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'media_id'
    ];
}
