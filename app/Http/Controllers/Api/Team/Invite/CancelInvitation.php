<?php

namespace Base\Http\Controllers\Api\Team\Invite;

use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CancelInvitation extends APIController
{
    public function __invoke(Request $request, $slug, $id)
    {
        $user = $request->user();

        $team = $user
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $pendingInvitation = $team
            ->invitations()
            ->where('id', $id)
            ->where('is_accepted', false)
            ->delete();

        abort_unless($pendingInvitation, 404);

        return response("");
    }
}
