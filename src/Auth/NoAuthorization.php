<?php

namespace SegPartners\QuiverWrapper\Auth;

use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\ClientInterface;

class NoAuthorization implements AuthorizationInterface
{
    public function applyAuthentication(ClientInterface &$client)
    {
    }
}
