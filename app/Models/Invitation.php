<?php

namespace Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Team, the invitation belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, "team_id");
    }
}
