<?php

namespace SegPartners\QuiverWrapper\Attachments;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class AttachmentsIndex extends Method
{
    private $document;
    private $change;

    public function __construct(int $document, int $change)
    {
        $this->document = $document;
        $this->change = $change;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }

    public function getQueryParams(): array
    {
        return [
            'document' => $this->document,
            'change' => $this->change,
        ];
    }

    public function getMethodUri(): string
    {
        return 'api/attachments';
    }
}
