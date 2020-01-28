<?php

namespace SegPartners\QuiverWrapper\Interfaces;

interface AuthenticationInterface
{
    public function handleAuthentication();

    public function getBearerToken();
}
