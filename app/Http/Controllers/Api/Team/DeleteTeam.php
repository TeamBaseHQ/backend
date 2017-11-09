<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTeam extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        // Team
        $team = $request->user()
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $deleted = $team->delete();

        abort_unless($deleted, 500);

        return response("");
    }
}
