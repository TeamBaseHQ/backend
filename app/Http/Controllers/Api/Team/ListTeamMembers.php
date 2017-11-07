<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Http\Resources\UserCollection;
use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class ListTeamMembers extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $members = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first()
            ->members;

        return new UserCollection($members);
    }
}
