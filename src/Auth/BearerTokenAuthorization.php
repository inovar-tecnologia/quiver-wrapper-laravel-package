<?php

namespace SegPartners\QuiverWrapper\Auth;

use Illuminate\Support\Facades\Cache;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\ClientInterface;

class BearerTokenAuthorization implements AuthorizationInterface
{

    const ACCESS_TOKEN_KEY = self::class . 'BearerTokenAuthorization::$access_token_key';
    const REFRESH_TOKEN_KEY = self::class . 'BearerTokenAuthorization::$refresh_token_key';

    public function applyAuthentication(ClientInterface &$client)
    {
        $token = $this->getAccessToken();
        $client->addHeader('Authorization', 'Bearer ' . $token);
    }

    private function getAccessToken()
    {
        return $this->getStoredAccessToken() ?? $this->requestAccessToken();
    }

    private function getStoredAccessToken()
    {
        return Cache::get($this::ACCESS_TOKEN_KEY);
    }

    private function requestAccessToken()
    {

        $response = (new OauthAuthentication($this->getStoredRefreshToken()))->handle();


        Cache::put($this::ACCESS_TOKEN_KEY, $response->access_token, $response->expires_in);
        Cache::forever($this::REFRESH_TOKEN_KEY, $response->refresh_token);

        return $this->getAccessToken();

    }

    private function getStoredRefreshToken()
    {
        return Cache::get($this::REFRESH_TOKEN_KEY);
    }

}
