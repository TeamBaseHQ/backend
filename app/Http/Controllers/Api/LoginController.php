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

        return response($this->loginProxy->attemptLogin($email, $password));
    }
}
