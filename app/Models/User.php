<?php

namespace Base\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        return $this->belongsToMany(Team::class, 'team_members', 'user_id', 'team_id');
    }

    /**
     * Channels, the User is a Member of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class, 'channel_members', 'user_id', 'channel_id');
    }
}
