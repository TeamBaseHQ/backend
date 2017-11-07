<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Http\Resources\TeamCollection;
use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class ListTeams extends APIController
{
    public function __invoke(Request $request)
    {
        $teams = $request->user()
            ->teams()
            ->paginate($request->get('limit', 5));

        return new TeamCollection($teams);
    }
}
