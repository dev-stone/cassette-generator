<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

class RequestModel
{
    private string $method;
    private string $url;
    private array $headers = [];

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }
}
