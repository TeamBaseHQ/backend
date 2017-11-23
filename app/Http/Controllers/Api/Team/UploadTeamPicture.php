<?php

namespace Base\Http\Controllers\Api\Team;

use Base\Http\Controllers\Api\APIController;
use Base\Http\Requests\UploadProfilePictureRequest;
use Base\Http\Resources\MediaResource;
use Base\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UploadTeamPicture extends APIController
{
    public function __invoke(UploadProfilePictureRequest $request, $slug)
    {
        $user = request()->user();

        // Fetch the Team
        $team = $user
            ->createdTeams()
            ->where('slug', $slug)
            ->first();

        if (!$team) {
            throw (new ModelNotFoundException())->setModel(Team::class, $slug);
        }

        $name = str_random(10) . '-' . time();
        $fileName = "{$name}.jpg";

        $picture = $team
            ->addMediaFromRequest('file')
            ->usingName($name)
            ->usingFileName($fileName)
            ->toMediaCollection('team_picture');

        // Delete all team pictures
        $existing = $user->getMedia('team_picture')->first();

        if ($existing) {
            $existing->delete();
        }

        return new MediaResource($picture);
    }
}
