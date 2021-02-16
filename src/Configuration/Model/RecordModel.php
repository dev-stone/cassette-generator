<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

class RecordModel
{
    private string $requestBodyPath;
    private string $responseBodyPath;
    private CassetteModel $cassetteModel;
    private array $appendItems = [];
    private array $rewriteItems = [];

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

    public function getCassetteModel(): CassetteModel
    {
        return $this->cassetteModel;
    }

    public function setCassetteModel(CassetteModel $cassetteModel): self
    {
        $this->cassetteModel = $cassetteModel;

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
}
