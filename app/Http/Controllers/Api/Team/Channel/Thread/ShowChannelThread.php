<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread;

use Base\Models\Team;
use Base\Models\Thread;
use Base\Models\Channel;
use Illuminate\Http\Request;
use Base\Http\Resources\ThreadResource;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowChannelThread extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug, $thSlug)
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

        $thread = $channel
            ->threads
            ->where('slug', $thSlug)
            ->first();

        throw_if(!$thread, (new ModelNotFoundException())->setModel(Thread::class, $thSlug));

        return new ThreadResource($thread);
    }
}
