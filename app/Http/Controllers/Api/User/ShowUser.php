<?php

namespace Base\Http\Controllers\Api\User;

use Base\Models\User;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;

class ShowUser extends APIController
{
    public function __invoke($id)
    {
        if ($id === "me") {
            return new UserResource(request()->user());
        }

        return new UserResource(User::findOrFail($id));
    }
}
