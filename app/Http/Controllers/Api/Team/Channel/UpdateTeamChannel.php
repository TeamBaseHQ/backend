<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Http\Requests\UpdateTeamChannelRequest;
use Base\Http\Resources\ChannelResource;
use Base\Models\Channel;
use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateTeamChannel extends APIController
{
    public function __invoke(UpdateTeamChannelRequest $request, $slug, $chSlug)
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

        // Fetch the Channel
        $channel = $channel->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        // Prepare Data
        $data = $request->only(['name', 'description', 'color', 'is_private']);

        if (isset($data['is_private'])) {
            $data['type'] = $data['is_private'] ? Channel::TYPE_PRIVATE : Channel::TYPE_PUBLIC;
        }

        // Update the Channel
        $updated = $channel->update($data);

        abort_unless($updated, 500);

        return new ChannelResource($channel);
    }
}
