<?php

namespace SegPartners\QuiverWrapper\Interfaces;

interface AuthorizationInterface
{
    public function applyAuthentication(ClientInterface &$client);
}
