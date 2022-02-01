<?php

declare(strict_types=1);

namespace Vcg\ValueObject;

use Vcg\Configuration\Model\RecordDefaultsModel;

class Record
{
    private RecordDefaultsModel $recordDefaultsModel;
    private string $requestBodyPath;
    private string $responseBodyPath;
    private array $appendItems = [];
    private array $rewriteItems = [];
    private array $replaceItems = [];
    private array $outputData = [];

    public function getRecordDefaultsModel(): RecordDefaultsModel
    {
        return $this->recordDefaultsModel;
    }

    public function setRecordDefaultsModel(RecordDefaultsModel $recordDefaultsModel): self
    {
        $this->recordDefaultsModel = $recordDefaultsModel;

        return $this;
    }

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

    public function addRewriteItem(string $key, string $value = null): self
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

    public function getOutputData(): array
    {
        return $this->outputData;
    }

    public function setOutputData(array $outputData): self
    {
        $this->outputData = $outputData;

        return $this;
    }
}
