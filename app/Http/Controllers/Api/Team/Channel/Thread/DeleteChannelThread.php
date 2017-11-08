<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread;

use Base\Models\Channel;
use Base\Models\Team;
use Base\Models\Thread;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteChannelThread extends APIController
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
            ->where("slug", $thSlug);

        // The current user is neither the creator of the Team and nor the Channel
        if ($user->id !== $team->user_id && $user->id !== $channel->user_id) {
            // Thus, in order to delete the thread, the user
            // must be the creator of the thread.
            $thread = $thread->where("user_id", $user->id);
        }

        // Delete the Thread
        $deleted = $thread->delete();

        abort_if(!$deleted, 403, "You cannot delete this thread.");

        return response("");
    }
}
