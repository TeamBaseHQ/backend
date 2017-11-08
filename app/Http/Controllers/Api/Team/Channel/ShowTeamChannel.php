<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Base\Models\Team;
use Base\Models\Channel;
use Illuminate\Http\Request;
use Base\Http\Resources\ChannelResource;
use Base\Http\Controllers\Api\APIController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowTeamChannel extends APIController
{
    public function __invoke(Request $request, $slug, $chSlug)
    {
        $team = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first();

        throw_if(!$team, (new ModelNotFoundException())->setModel(Team::class, $slug));

        $channel = $team->channels()
            ->where("slug", $chSlug)
            ->first();

        throw_if(!$channel, (new ModelNotFoundException())->setModel(Channel::class, $chSlug));

        return new ChannelResource($channel);
    }
}
