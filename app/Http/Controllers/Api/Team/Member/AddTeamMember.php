<?php

namespace Base\Http\Controllers\Api\Team\Member;

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

        $exists = $team->members->find($id);

        abort_if($exists, 500, "The User is already a member of this Team.");

        $team->members()->attach($id);

        return response("");
    }
}
