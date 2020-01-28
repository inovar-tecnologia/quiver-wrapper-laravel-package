<?php

namespace SegPartners\QuiverWrapper\Auth;

use SegPartners\QuiverWrapper\Interfaces\Method;
use SegPartners\QuiverWrapper\Traits\ReadEnvProperties;

class OauthAuthentication extends Method
{

    use ReadEnvProperties;

    private $refresh_token;
    private $username;
    private $password;
    private $client_id;
    private $client_secret;

    public function __construct($refresh_token = null)
    {

        $this->refresh_token = $refresh_token;

        $this->username = $this->getEnvProperty('QUIVER_WRAPPER_USERNAME');
        $this->password = $this->getEnvProperty('QUIVER_WRAPPER_PASSWORD');
        $this->client_id = $this->getEnvProperty('QUIVER_WRAPPER_CLIENT_ID');
        $this->client_secret = $this->getEnvProperty('QUIVER_WRAPPER_CLIENT_SECRET');

    }

    public function getMethodUri(): string
    {
        return 'oauth/token';
    }

    public function getMethod(): string
    {
        return 'post';
    }

    public function getFormParams(): array
    {
        $form_params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ];

        if ($this->refresh_token) {
            $form_params['grant_type'] = 'refresh_token';
            $form_params['refresh_token'] = $this->refresh_token;
        } else {
            $form_params['grant_type'] = 'password';
            $form_params['username'] = $this->username;
            $form_params['password'] = $this->password;
        }

        return $form_params;
    }
}
