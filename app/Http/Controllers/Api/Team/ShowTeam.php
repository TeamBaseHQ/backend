<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class ShowTeam extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();


        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        return new TeamResource($team);
    }
}
