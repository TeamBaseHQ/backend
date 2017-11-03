<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Preference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preference()
    {
        return $this->belongsTo(Preference::class, "preference_id");
    }
}
