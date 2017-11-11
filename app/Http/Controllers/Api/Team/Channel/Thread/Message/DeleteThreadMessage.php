<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread\Message;

use Base\Models\Team;
use Base\Models\Thread;
use Base\Models\Channel;
use Base\Models\Message;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteThreadMessage extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug, $thSlug, $mSlug)
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

        $message = $thread
            ->messages()
            ->where('slug', $mSlug)
            ->first();

        throw_if(!$message, (new ModelNotFoundException())->setModel(Message::class, $mSlug));

        // Delete the Message
        $deleted = $message->delete();

        abort_if(!$deleted, 403, "You cannot delete this message.");

        return response("");
    }
}
