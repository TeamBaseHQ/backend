<?php

namespace Base\Models;

use Base\Helpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Team extends BaseModel implements HasMediaConversions
{
    use Sluggable, HasMediaTrait;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "teams";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'invitation_code', 'user_id'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'owner',
        'media'
    ];

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

    /**
     * Owner of the Team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Team Members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members', 'team_id', 'user_id')
            ->as('association')
            ->withTimestamps();
    }

    /**
     * Team Channels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, "team_id");
    }

    /**
     * Team Threads.
     */
    public function threads()
    {
        return $this->hasManyThrough(Thread::class, Channel::class);
    }

    /**
     * Team Invitations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, "team_id");
    }

    /**
     * Register Media Conversions.
     *
     * @param \Spatie\MediaLibrary\Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        $conversions = config('media.conversions.profile_picture');
        Helpers::registerConversions($this, $conversions, ['team_picture']);
    }
}
