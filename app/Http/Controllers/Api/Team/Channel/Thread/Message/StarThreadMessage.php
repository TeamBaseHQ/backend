<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread\Message;

use Base\Models\Team;
use Base\Models\Thread;
use Base\Models\Channel;
use Base\Models\Message;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StarThreadMessage extends APIController
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

        // If the user hasn't already starred the message
        if (!$user->starredMessagesInTeam($team->id)->find($message->id)) {
            $user->starredMessagesInTeam($team->id)->attach($message->id, ["team_id" => $team->id]);
        }

        return "";
    }
}
