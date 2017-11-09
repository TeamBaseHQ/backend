<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Base\Http\Resources\TeamResource;
use Base\Http\Requests\UpdateTeamRequest;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateTeam extends APIController
{
    public function __invoke(UpdateTeamRequest $request, $slug)
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
