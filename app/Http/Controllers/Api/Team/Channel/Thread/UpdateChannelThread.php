<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread;

use Base\Http\Resources\ThreadResource;
use Base\Models\Team;
use Base\Models\Channel;
use Base\Http\Requests\UpdateThreadRequest;
use Base\Http\Controllers\Api\APIController;
use Base\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateChannelThread extends APIController
{
    public function __invoke(UpdateThreadRequest $request, $slug, $chSlug, $thSlug)
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
            // Thus, in order to update the thread, the user
            // must be the creator of the thread.
            $thread = $thread->where("user_id", $user->id);
        }

        // The Thread
        $thread = $thread->first();

        throw_if(!$thread, (new ModelNotFoundException())->setModel(Thread::class, $thSlug));

        $data = $request->only(['subject', 'description']);

        // Update the Thread
        $updated = $thread->update($data);

        abort_if(!$updated, 403, "You cannot update this thread.");

        return new ThreadResource($thread);
    }
}
