<?php

namespace Base\Http\Controllers\Api\Team\Channel\Thread;

use Base\Http\Resources\ThreadResource;
use Base\Models\Team;
use Base\Http\Requests\CreateThreadRequest;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateChannelThread extends APIController
{
    public function __invoke(CreateThreadRequest $request, $slug, $chSlug)
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

        // Prepare Data
        $data = $request->only(['subject', 'description']);
        $data['user_id'] = $user->id;

        $thread = $channel
            ->threads()
            ->create($data);

        return new ThreadResource($thread);
    }
}
