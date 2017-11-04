<?php

namespace Base\Http\Controllers\Api\User;

use Base\Http\Requests\CreateUserRequest;
use Base\Mail\ConfirmUser;
use Base\Models\User;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;

class CreateUser extends APIController
{
    public function __invoke(CreateUserRequest $request)
    {
        return new ConfirmUser(User::first());
        $data = $request->only(['name', 'email', 'password']);
        $user = User::create($data);

        return new UserResource($user);
    }
}
