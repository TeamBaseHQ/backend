<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RemoveTeamMember extends APIController
{
    public function __invoke(Request $request, $slug, $id)
    {
        $user = $request->user();

        $team = $user
            ->teams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $members = $team->members();

        // If the user is trying to remove themselves OR
        // if they're the creator of the Team, they can:
        if ($id === $user->id || $team->user_id === $user->id) {
            // Remove the Member
            $members->detach($id);
            return response("");
        }

        abort(500, "You cannot remove this user.");
    }
}
