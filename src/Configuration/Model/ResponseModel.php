<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

class ResponseModel
{
    private array $status = [];
    private array $headers = [];

    public function getStatus(): array
    {
        return $this->status;
    }

    public function addStatus(string $key, string $value): self
    {
        $this->status[$key] = $value;

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
