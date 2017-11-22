<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Events\Team\Channel\ChannelWasCreated;
use Base\Models\Team;
use Base\Models\Channel;
use Base\Http\Resources\ChannelResource;
use Base\Http\Controllers\Api\APIController;
use Base\Http\Requests\CreateChannelRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTeamChannel extends APIController
{
    public function __invoke(CreateChannelRequest $request, $slug)
    {
        $user = $request->user();

        $team = $user
            ->teams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        // Prepare Data
        $data = $request->only(['name', 'description', 'color', 'is_private']);
        $data['type'] = $data['is_private'] ? Channel::TYPE_PRIVATE : Channel::TYPE_PUBLIC;
        $data['user_id'] = $user->id;

        // Create the Channel
        $channel = $team->channels()->create($data);

        // Add the creator as a Channel Member
        $channel->members()->attach($user->id);

        broadcast(new ChannelWasCreated($channel, $team))->toOthers();

        return new ChannelResource($channel);
    }
}
