<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "messages";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'type', 'thread_id', 'sender_type', 'sender_id', 'meta'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = str_random(8) . "-" . $model->thread_id . "-" . str_random(8);
        });
    }

    /**
     * Message's Thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Message::class, "thread_id");
    }

    /**
     * Sender of the Message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sender(): MorphTo
    {
        return $this->morphTo();
    }
}
