<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\ChannelCollection;
use Base\Http\Controllers\Api\APIController;

class ListTeamChannels extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channels = $team->channels()
            ->paginate($request->get('limit', 15));

        return new ChannelCollection($channels);
    }
}
