<?php

namespace Base\Http\Controllers\Api\User;

use Base\Events\User\UserWasCreated;
use Base\Http\Requests\CreateUserRequest;
use Base\Mail\ConfirmUser;
use Base\Models\User;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;

class CreateUser extends APIController
{
    public function __invoke(CreateUserRequest $request)
    {
        // Fetch data from request
        $data = $request->only(['name', 'email', 'password']);
        // Create user
        $user = User::create($data);
        // Fire Event
        event(new UserWasCreated($user));
        // Return response
        return new UserResource($user);
    }
}
