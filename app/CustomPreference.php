<?php

namespace Base;

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
}
