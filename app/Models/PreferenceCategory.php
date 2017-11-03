<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

class PreferenceCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "preference_categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
