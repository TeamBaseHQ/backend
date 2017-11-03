<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
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
        'name', 'data_type', 'default_value', 'preference_category_id'
    ];

    /**
     * Preference's Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PreferenceCategory::class, "preference_category_id");
    }
}
