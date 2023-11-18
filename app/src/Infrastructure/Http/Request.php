<?php

namespace SP\Infrastructure\Http;

readonly class Request implements \SP\Infrastructure\Request
{
    public function __construct(
        private string $uri,
        private string $method,
        private array  $requestParameters,
        private string $requestBody)
    {

    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getBody(): string
    {
        return $this->requestBody;
    }

    public function getParameters(): array
    {
        return $this->requestParameters;
    }
}
