<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CustomPreference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "custom_preferences";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'owner_id', 'owner_type', 'preference_id'
    ];

    /**
     * Owner of the Preference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Preference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preference()
    {
        return $this->belongsTo(Preference::class, "preference_id");
    }
}
