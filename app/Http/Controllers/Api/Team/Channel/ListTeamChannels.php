<?php

namespace Base\Http\Controllers\Api\Team\Channel;

use Illuminate\Http\Request;
use Base\Http\Resources\ChannelCollection;
use Base\Http\Controllers\Api\APIController;

class ListTeamChannels extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        $channels = $request->user()
            ->teams()
            ->where('slug', $slug)
            ->first()
            ->channels;

        return new ChannelCollection($channels);
    }
}
