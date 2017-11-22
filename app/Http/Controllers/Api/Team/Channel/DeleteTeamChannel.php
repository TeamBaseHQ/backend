<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Events\Team\Channel\ChannelWasDeleted;
use Base\Models\Channel;
use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTeamChannel extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug)
    {
        $user = $request->user();

        $team = $user->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channelUserId = $user->id;

        $channel = $team->channels()->where("slug", $chSlug);

        // If the current user is not the team owner,
        // we'll add a constraint such that the current
        // user can only delete the channel if they had
        // created the channel. The Team owner can delete
        // the channel regardless of which user created it.
        if ($user->id !== $team->user_id) {
            $channel = $channel->where("user_id", $user->id);
        }

        // Delete the Channel
        $deleted = $channel->delete();

        abort_unless($deleted, 500, "You cannot delete this channel.");

        broadcast(new ChannelWasDeleted($chSlug, $team))->toOthers();

        return response("");
    }
}
