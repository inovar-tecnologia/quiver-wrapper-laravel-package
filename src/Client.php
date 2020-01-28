<?php

namespace SegPartners\QuiverWrapper;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\ClientInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;
use SegPartners\QuiverWrapper\Traits\ReadEnvProperties;

class Client implements ClientInterface
{
    use ReadEnvProperties;

    private $url;

    /**
     * @var HttpClient
     */
    private $client;

    private $options = [];

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
        $this->addHeader('Accept', 'application/json');
        $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    public function addHeader(string $name, string $value): ClientInterface
    {
        Arr::set($this->options, 'headers.' . $name, $value);
        return $this;
    }

    public function defineAuthorization(AuthorizationInterface $authorization): ClientInterface
    {
        $authorization->applyAuthentication($this);
        return $this;
    }

    public function handle(Method $method)
    {
        $this->setMultipartParams($method->getMultiPartParams());
        $this->setQueryParams($method->getQueryParams());
        $this->setFormParams($method->getFormParams());

        if ($method->authorizeUsing()) {
            $method->authorizeUsing()->applyAuthentication($this);
        }

        $this->setMethodUri($method->getMethodUri());
        $response = $this->request($method->getMethod());
        $bodyString = $response->getBody();

        return json_decode($bodyString);

    }

    public function setMultipartParams(array $multiPartParams): ClientInterface
    {
        Arr::set($this->options, 'multipart', $multiPartParams);
        return $this;
    }

    public function setQueryParams(array $queryParams): ClientInterface
    {
        Arr::set($this->options, 'query_params', $queryParams);
        return $this;
    }

    public function setFormParams(array $formParams): ClientInterface
    {
        Arr::set($this->options, 'form_params', $formParams);
        return $this;
    }

    public function setMethodUri($uri): ClientInterface
    {
        $this->url = $this->baseUri() . '/' . $uri;
        return $this;
    }

    public function baseUri(): string
    {
        return $this->getEnvProperty('QUIVER_WRAPPER_URL');
    }

    public function request(string $method)
    {
        return $this->client->request($method, $this->url, $this->options);
    }
}
