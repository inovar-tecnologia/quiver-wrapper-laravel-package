<?php

namespace SegPartners\QuiverWrapper\Interfaces;

interface ClientInterface
{

    public function setMethodUri($uri): self;

    public function request(string $method);

    public function setFormParams(array $formParams): self;

    public function setQuery(array $query): self;

    public function setMultipartParams(array $multiPartParams): self;

    public function defineAuthorization(AuthorizationInterface $authorization): self;

    public function baseUri(): string;

    public function addHeader(string $name, string $value): ClientInterface;

    public function handle(Method $method): \stdClass;

}
