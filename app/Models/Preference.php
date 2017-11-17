<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Preference extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "preferences";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "category",
        "name",
        "value",
        "user_id",
    ];

    /**
     * Get the route name for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return "name";
    }

    /**
     * User, the Preference belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Get Preference by Name for the given Team (ID).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string                            $team_id
     * @param string                                $name
     *
     * @return mixed
     */
    public function scopeForTeam($query, $team_id, $name)
    {
        return $query->where("name", "{$team_id}:{$name}");
    }
}
