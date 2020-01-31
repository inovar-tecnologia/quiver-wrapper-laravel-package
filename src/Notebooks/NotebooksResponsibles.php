<?php

namespace SegPartners\QuiverWrapper\Notebooks;

use SegPartners\QuiverWrapper\Auth\BearerTokenAuthorization;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;

class NotebooksResponsibles extends Method
{
    private $broker;
    private $search;
    private $with_inactive;

    public function __construct($broker = null, $with_inactive = false)
    {
        $this->broker = $broker;
        $this->with_inactive = $with_inactive;
    }

    public function search(string $search)
    {
        $this->search = $search;
        return $this;
    }

    public function getQueryParams(): array
    {
        $queryParams = [];

        foreach (get_object_vars($this) as $property => $value) {
            $queryParams[$property] = $value;
        }

        return $queryParams;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new BearerTokenAuthorization;
    }

    public function getMethodUri(): string
    {
        return 'api/notebooks/responsibles';
    }
}