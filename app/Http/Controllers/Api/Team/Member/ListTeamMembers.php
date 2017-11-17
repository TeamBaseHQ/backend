<?php

namespace Base\Http\Controllers\Api\Team\Member;

use Base\Http\Controllers\Api\APIController;
use Base\Http\Resources\UserCollection;
use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ListTeamMembers extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $members = $team->members()
            ->paginate($request->get('limit', 15));

        return new UserCollection($members);
    }
}
