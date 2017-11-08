<?php

namespace Base\Http\Controllers\Api\Team\Member;

use Base\Models\Team;
use Base\Models\User;
use Illuminate\Http\Request;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowTeamMember extends APIController
{
    public function __invoke(Request $request, $slug, $id)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $member = $team->members()->find($id);

        if (!$member) {
            throw (new ModelNotFoundException())->setModel(User::class, $id);
        }

        return new UserResource($member);
    }
}
