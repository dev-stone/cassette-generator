<?php
declare(strict_types=1);

namespace Vcg\Maker;

class Record
{
    private string $requestBodyPath;
    private string $responseBodyPath;

    public function getRequestBodyPath(): string
    {
        return $this->requestBodyPath;
    }

    public function setRequestBodyPath(string $requestBodyPath): self
    {
        $this->requestBodyPath = $requestBodyPath;

        return $this;
    }

    public function getResponseBodyPath(): string
    {
        return $this->responseBodyPath;
    }

    public function setResponseBodyPath(string $responseBodyPath): self
    {
        $this->responseBodyPath = $responseBodyPath;

        return $this;
    }
}
