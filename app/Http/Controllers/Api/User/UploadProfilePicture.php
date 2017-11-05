<?php

namespace Base\Http\Controllers\Api\User;

use Base\Http\Controllers\Api\APIController;
use Base\Http\Requests\UploadProfilePictureRequest;
use Base\Http\Resources\MediaResource;

class UploadProfilePicture extends APIController
{
    public function __invoke(UploadProfilePictureRequest $request)
    {
        $user = request()->user();

        $picture = $user->addMediaFromRequest('file')
            ->toMediaCollection('profile_picture');

        return new MediaResource($picture);
    }
}
