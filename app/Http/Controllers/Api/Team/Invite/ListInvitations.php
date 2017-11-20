<?php

namespace Base\Http\Controllers\Api\Team\Invite;

use Base\Events\Team\Invite\InvitationWasCreated;
use Base\Http\Resources\InputError;
use Base\Http\Resources\InvitationCollection;
use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ListInvitations extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $user = $request->user();

        $team = $user
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $invitations = $team
            ->invitations()
            ->latest()
            ->paginate($request->get('limit', 15));

        return new InvitationCollection($invitations);
    }
}
