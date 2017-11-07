<?php

namespace Base\Http\Controllers\Api\User;

use Base\Auth\LoginProxy;
use Illuminate\Http\Request;
use Base\Http\Controllers\Controller;
use Base\Http\Controllers\Api\APIController;

class LoginController extends APIController
{
    /**
     * @var \Base\Auth\LoginProxy
     */
    private $loginProxy;

    /**
     * LoginController constructor.
     *
     * @param \Base\Auth\LoginProxy $loginProxy
     */
    public function __construct(LoginProxy $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $client_id = $request->header('X-CLIENT-ID');
        $client_secret = $request->header('X-CLIENT-SECRET');

        return response(['data' => $this->loginProxy->attemptLogin($client_id, $client_secret, $email, $password)]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function refresh(Request $request)
    {
        $client_id = $request->header('X-CLIENT-ID');
        $client_secret = $request->header('X-CLIENT-SECRET');
        $refresh_token = $request->input('refresh_token');

        return response(['name' => $this->loginProxy->attemptRefresh($client_id, $client_secret, $refresh_token)]);
    }
}
