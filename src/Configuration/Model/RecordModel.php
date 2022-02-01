<?php

declare(strict_types=1);

namespace Vcg\Configuration\Model;

class RecordModel
{
    private string $requestBodyPath;
    private string $responseBodyPath;
    private array $appendItems = [];
    private array $rewriteItems = [];
    private array $replaceItems = [];

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

    public function getAppendItems(): array
    {
        return $this->appendItems;
    }

    public function addAppendItem(string $key, string $value = null): self
    {
        $this->appendItems[$key] = $value;

        return $this;
    }

    public function getRewriteItems(): array
    {
        return $this->rewriteItems;
    }

    public function addRewriteItems(string $key, string $value = null): self
    {
        $this->rewriteItems[$key] = $value;

        return $this;
    }

    public function addReplaceItems(string $key, array $value = null): self
    {
        $this->replaceItems[$key] = $value;

        return $this;
    }

    public function getReplaceItems(): array
    {
        return $this->replaceItems;
    }
}
