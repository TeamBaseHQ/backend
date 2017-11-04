<?php

namespace Base\Auth;

use Exception;
use Base\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;

class LoginProxy
{
    /**
     * @var \Optimus\ApiConsumer\Router
     */
    private $apiConsumer;

    /**
     * @var mixed
     */
    private $auth;

    /**
     * @var mixed
     */
    private $db;

    /**
     * LoginProxy constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->apiConsumer = $app->make('apiconsumer');
        $this->auth = $app->make('auth');
        $this->db = $app->make('db');
    }

    /**
     * Attempt to create an access token using user credentials.
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function attemptLogin($client_id, $client_secret, $email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ], [
                'username' => $email,
                'password' => $password
            ]);
        }

        throw new AuthenticationException("Invalid Credentials.");
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array  $clientData
     * @param array  $data      the data to send to the server
     *
     * @return array
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function proxy($grantType, array $clientData = [], array $data = [])
    {
        $data = array_merge($data, $clientData, [
            'grant_type' => $grantType
        ]);

        $response = $this->apiConsumer->post('/oauth/token', $data);

        if (!$response->isSuccessful()) {
            throw new AuthenticationException("Unable to Authenticate.");
        }

        $data = json_decode($response->getContent());

        return [
            'access_token' => $data->access_token,
            'expires_in' => $data->expires_in,
            'refresh_token' => $data->refresh_token,
        ];
    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie.
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $refreshToken
     *
     * @return array
     */
    public function attemptRefresh($client_id, $client_secret, $refreshToken)
    {
        return $this->proxy('refresh_token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ], [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout()
    {
        $accessToken = $this->auth->user()->token();

        $refreshToken = $this->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
    }
}
