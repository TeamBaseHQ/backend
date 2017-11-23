<?php

namespace Base\Models;

use Base\Helpers;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Channel extends BaseModel implements HasMediaConversions
{
    use Sluggable, HasMediaTrait;

    const TYPE_PUBLIC = "public";

    const TYPE_PRIVATE = "private";

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

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['owner'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function isPublic()
    {
        return !$this->isPrivate();
    }

    public function isPrivate()
    {
        return $this->type === self::TYPE_PRIVATE;
    }

    /**
     * Team of the Channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, "team_id");
    }

    /**
     * Owner of the Channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Channel Members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'channel_members', 'channel_id', 'user_id')
            ->withPivot('last_viewed_at', 'messages_viewed')
            ->withTimestamps();
    }

    /**
     * Channel Threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class, "channel_id");
    }

    public function registerMediaConversions(Media $media = null)
    {
        $conversions = config('media.conversions.media.pictures');
        Helpers::registerConversions($this, $conversions, ['channel_media']);
    }
}
