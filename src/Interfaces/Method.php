<?php

namespace SegPartners\QuiverWrapper\Interfaces;

use SegPartners\QuiverWrapper\Auth\NoAuthorization;
use SegPartners\QuiverWrapper\Client;

abstract class Method
{

    public function getFormParams(): array
    {
        return [];
    }

    public function getQueryParams(): array
    {
        return [];
    }

    public function getMultiPartParams(): array
    {
        return [];
    }

    abstract public function getMethodUri(): string;

    public function getMethod(): string
    {
        return Client::HTTP_METHOD_GET;
    }

    public function authorizeUsing(): AuthorizationInterface
    {
        return new NoAuthorization;
    }

    public function handle(): \stdClass
    {
        return app(Client::class)->handle($this);
    }

    protected function generateFileFormField($fieldName, $fileContent, $fileName): array
    {
        return [
          'name' => $fieldName,
          'contents' => $fileContent,
          'filename' => $fileName
        ];
    }
}
