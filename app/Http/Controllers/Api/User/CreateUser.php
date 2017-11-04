<?php

namespace Base\Http\Controllers\Api\User;

use Base\Http\Requests\CreateUserRequest;
use Base\Models\User;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;

class CreateUser extends APIController
{
    public function __invoke(CreateUserRequest $request, $id)
    {
        $data = $request->only(['name', 'email', 'username', 'password']);
        $user = User::create($data);

        return new UserResource($user);
    }
}
