<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread;

use Base\Models\Channel;
use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\UserCollection;
use Base\Http\Controllers\Api\APIController;

class ListChannelThreads extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug)
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

        $members = $channel->members;

        return new UserCollection($members);
    }
}
