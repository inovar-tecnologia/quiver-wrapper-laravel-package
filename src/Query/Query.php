<?php

namespace SegPartners\QuiverWrapper\Query;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class Query extends Method
{

    public $sql;

    public function __construct(string $sql)
    {
        $this->sql = $sql;
    }

    public function getFormParams(): array
    {
        return [
            'sql' => $this->sql,
        ];
    }

    public function getMethodUri(): string
    {
        return 'api/query';
    }

    public function getMethod(): string
    {
        return 'post';
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization();
    }
}
