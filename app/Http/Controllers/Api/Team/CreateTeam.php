<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Http\Requests\Team\CreateTeamRequest;
use Base\Models\Team;
use Base\Events\Team\TeamWasCreated;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class CreateTeam extends APIController
{
    public function __invoke(CreateTeamRequest $request)
    {
        $currentUser = $request->user();
        // Fetch data from request
        $data = $request->only(['name', 'description']);
        // Generate Invitation Code
        $data['invitation_code'] = $data['name'] . "-" . str_random(20);

        // Create team
        $team = $currentUser->createdTeams()->create($data);
        // Add the User to the Team as a member
        $team->members()->attach($currentUser->id);

        // Fire Event
        event(new TeamWasCreated($team));

        // Return response
        return new TeamResource($team);
    }
}
