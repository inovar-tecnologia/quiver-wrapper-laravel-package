<?php

namespace SegPartners\QuiverWrapper\Attachments;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class AttachmentsImageTypes extends Method
{

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }

    public function getMethodUri(): string
    {
        return 'api/attachments/image_types';
    }
}
