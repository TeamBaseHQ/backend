<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Base\Http\Resources\TeamResource;
use Base\Http\Controllers\Api\APIController;

class DeleteTeam extends APIController
{
    public function __invoke(Request $request, $slug)
    {
        // Delete the Team
        $deleted = $request->user()
            ->createdTeams()
            ->where('slug', $slug)
            ->delete();

        abort_unless($deleted, 500);

        return response("");
    }
}
