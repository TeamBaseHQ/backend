<?php

namespace Base\Http\Controllers\Api\Team\Channel\Member;

use Base\Models\Team;
use Base\Models\Channel;
use Base\Models\User;
use Illuminate\Http\Request;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowChannelMember extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug, $id)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channel = $team
            ->channels()
            ->where("slug", $chSlug)
            ->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        $member = $channel->members->find($id);

        throw_if(!$member, (new ModelNotFoundException())->setModel(User::class, $id));

        return new UserResource($member);
    }
}
