<?php

namespace Base\Http\Controllers\Api\Team\Member;

use Base\Http\Controllers\Api\APIController;
use Base\Http\Resources\UserCollection;
use Illuminate\Http\Request;

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
