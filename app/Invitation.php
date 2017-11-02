<?php

namespace Base;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "invitations";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'message', 'team_id'
    ];
}
