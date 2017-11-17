<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread\Message;

use Base\Http\Controllers\Api\APIController;
use Base\Http\Resources\MessageCollection;
use Base\Models\Channel;
use Base\Models\Team;
use Base\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ListThreadMessages extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug, $thSlug)
    {
        $user = $request->user();

        $team = $user
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
            ->threads()
            ->where("slug", $thSlug)
            ->first();

        throw_if(!$thread, (new ModelNotFoundException())->setModel(Thread::class, $thSlug));

        $messages = $thread
            ->messages()
            ->latest()
            ->paginate($request->get('limit', 15));

        return new MessageCollection($messages);
    }
}
