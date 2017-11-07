<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\User;
use Illuminate\Http\Request;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowTeamMember extends APIController
{
    public function __invoke(Request $request, $slug, $id)
    {
        $member = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first()
            ->members
            ->find($id);

        if (!$member) {
            throw (new ModelNotFoundException())->setModel(User::class, $id);
        }

        return new UserResource($member);
    }
}
