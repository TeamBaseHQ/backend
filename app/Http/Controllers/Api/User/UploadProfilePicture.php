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

        $name = str_random(10) . '-' . time();
        $fileName = "{$name}.jpg";

        $picture = $user
            ->addMediaFromRequest('file')
            ->usingName($name)
            ->usingFileName($fileName)
            ->toMediaCollection('profile_picture');

        return new MediaResource($picture);
    }
}
