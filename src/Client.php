<?php

namespace SegPartners\QuiverWrapper;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Arr;
use SegPartners\QuiverWrapper\Interfaces\AuthorizationInterface;
use SegPartners\QuiverWrapper\Interfaces\ClientInterface;
use SegPartners\QuiverWrapper\Interfaces\Method;
use SegPartners\QuiverWrapper\Traits\UseConfigs;

class Client implements ClientInterface
{
    public const HTTP_METHOD_POST = 'post';
    public const HTTP_METHOD_GET = 'get';

    use UseConfigs;

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

    public function handle(Method $method): \stdClass
    {
        $this->setMultipartParams($method->getMultiPartParams());
        $this->setQuery($method->getQueryParams());
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
        if(isset($this->options['multipart'])) {
            $this->options['multipart'] = array_merge($this->options['multipart'], $multiPartParams);
        } else {
            $this->options['multipart'] = $multiPartParams;
        }
        return $this;
    }

    public function setQuery(array $query): ClientInterface
    {
        Arr::set($this->options, 'query', $query);
        return $this;
    }

    public function setFormParams(array $formParams): ClientInterface
    {
        foreach ($formParams as $key => $value) {
            $this->options['multipart'][] = [
                'name' => $key,
                'contents' => $value,
            ];
        }
        return $this;
    }

    public function setMethodUri($uri): ClientInterface
    {
        $this->url = $this->baseUri() . '/' . $uri;
        return $this;
    }

    public function baseUri(): string
    {
        return $this->getConfig('url');
    }

    public function request(string $method)
    {
        return $this->client->request($method, $this->url, $this->options);
    }
}
