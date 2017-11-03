<?php

namespace Base\Http\Controllers\Api;

use Base\Auth\LoginProxy;
use Illuminate\Http\Request;
use Base\Http\Controllers\Controller;

class LoginController extends Controller
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
        $client_id = $request->get('client_id');
        $client_secret = $request->get('client_secret');

        return response($this->loginProxy->attemptLogin($client_id, $client_secret, $email, $password));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function refresh(Request $request)
    {
        $client_id = $request->get('client_id');
        $refresh_token = $request->get('refresh_token');
        $client_secret = $request->get('client_secret');

        return response($this->loginProxy->attemptRefresh($client_id, $client_secret, $refresh_token));
    }
}
