<?php

namespace Base\Http\Controllers\Api\User;

use Base\Http\Requests\UpdateUserRequest;
use Base\Models\User;
use Base\Http\Resources\UserResource;
use Base\Http\Controllers\Api\APIController;

class UpdateUser extends APIController
{
    public function __invoke(UpdateUserRequest $request)
    {
        // Fetch data from request
        $data = $request->only(['name', 'email', 'password']);

        if (isset($data['password'])) {
            // Hash the Password
            $data['password'] = bcrypt($data['password']);
        }

        // Update the User
        $request->user()->update($data);

        return new UserResource(request()->user());
    }
}
