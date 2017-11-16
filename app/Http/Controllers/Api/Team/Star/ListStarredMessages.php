<?php

namespace Base\Http\Controllers\Api\Team\Star;

use Base\Models\Team;
use Illuminate\Http\Request;
use Base\Http\Resources\MessageCollection;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ListStarredMessages extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $user = $request->user();

        $team = $user
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $messages = $user
            ->starredMessagesInTeam($team->id)
            ->paginate($request->get('limit'));

        return new MessageCollection($messages);
    }
}
