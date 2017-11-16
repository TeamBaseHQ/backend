<?php

namespace Base\Models;

use Base\Helpers;
use Spatie\MediaLibrary\Media;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class User extends Authenticatable implements HasMediaConversions
{
    use HasApiTokens, Notifiable, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        "is_verified" => "boolean"
    ];

    /**
     * Teams created by the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTeams(): HasMany
    {
        return $this->hasMany(Team::class, "user_id");
    }

    /**
     * Channels created by the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdChannels(): HasMany
    {
        return $this->hasMany(Channel::class, "user_id");
    }

    /**
     * Teams, the User is a Member of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members', 'user_id', 'team_id')
            ->as('association')
            ->withTimestamps();
    }

    /**
     * Channels, the User is a Member of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class, 'channel_members', 'user_id', 'channel_id')
            ->withPivot('last_viewed_at', 'messages_viewed')
            ->withTimestamps();
    }

    /**
     * Threads created by the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdThreads(): HasMany
    {
        return $this->hasMany(Thread::class, "user_id");
    }

    /**
     * Messages sent by the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'sender');
    }

    /**
     * Messages starred by the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function starredMessages(): BelongsToMany
    {
        return $this->belongsToMany(Message::class, "stars", "user_id", "message_id")
            ->withTimestamps();
    }

    /**
     * Messages starred by the User in the given Team (ID).
     *
     * @param $team_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function starredMessagesInTeam($team_id): BelongsToMany
    {
        return $this->belongsToMany(Message::class, "stars", "user_id", "message_id")
            ->withPivot("team_id")
            ->where("team_id", $team_id)
            ->withTimestamps();
    }

    /**
     * User's Custom Preferences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function customPreferences(): MorphMany
    {
        return $this->morphMany(CustomPreference::class, "owner");
    }

    /**
     * Register Media Conversions.
     *
     * @param \Spatie\MediaLibrary\Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        $conversions = config('media.conversions.display_picture');
        Helpers::registerConversions($this, $conversions);
    }
}
