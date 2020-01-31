<?php

namespace SegPartners\QuiverWrapper\Attachments;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class AttachmentsShow extends Method
{

    private $attachment;

    public function __construct(int $attachment)
    {
        $this->attachment = $attachment;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }

    public function getMethodUri(): string
    {
        return 'api/attachments/' . $this->attachment;
    }
}
