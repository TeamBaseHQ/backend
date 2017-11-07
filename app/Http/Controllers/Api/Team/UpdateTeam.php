<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class UpdateTeam extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $data = $request->only(['name', 'description']);

        // Update the Team
        $team = $request->user()
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $team->update($data);

        return new TeamResource($team);
    }
}
