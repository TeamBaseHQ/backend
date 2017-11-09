<?php

namespace Base\Http\Controllers\Api\Team\Member;

use Base\Http\Resources\InputError;
use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddTeamMember extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        // Validate Request
        $this->validate($request, ["user_id" => "bail|exists:users,id"]);

        $user = $request->user();
        $id = $request->get("user_id");

        $team = $user
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $exists = $team->members()->find($id);

        // Already a member
        $errorMessage = "User is already a member of this channel.";
        return InputError::build(["user_id" => [$errorMessage]]);

        $team->members()->attach($id);

        return response("");
    }
}
