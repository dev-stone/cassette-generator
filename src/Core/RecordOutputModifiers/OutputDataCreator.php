<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\Configuration\ConfigEnum;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;
use Vcg\ValueObject\Record;

class OutputDataCreator
{
    private RequestModel $requestModel;
    private ResponseModel $responseModel;
    private array $outputData = [];

    public function makeOutputData(Record $record): void
    {
        $recordDefaults = $record->getRecordDefaultsModel();
        $this->requestModel = $recordDefaults->getRequestModel();
        $this->responseModel = $recordDefaults->getResponseModel();

        $this
            ->initOutputData()
            ->addRequestMethod()
            ->addRequestUrl()
            ->addRequestHeaders()
            ->addResponseStatus()
            ->addResponseHeaders();

        $record->setOutputData($this->outputData);
    }

    private function initOutputData(): self
    {
        $this->outputData = [
            ConfigEnum::REQUEST => [],
            ConfigEnum::RESPONSE => []
        ];

        return $this;
    }

    private function addRequestMethod(): self
    {
        $this->outputData[ConfigEnum::REQUEST][ConfigEnum::METHOD] = $this->requestModel->getMethod();

        return $this;
    }

    private function addRequestUrl(): self
    {
        $this->outputData[ConfigEnum::REQUEST][ConfigEnum::URL] = $this->requestModel->getUrl();

        return $this;
    }

    private function addRequestHeaders(): self
    {
        foreach ($this->requestModel->getHeaders() as $key => $value) {
            $this->outputData[ConfigEnum::REQUEST][ConfigEnum::HEADERS][$key] = $value;
        }

        return $this;
    }

    private function addResponseStatus(): self
    {
        foreach ($this->responseModel->getStatus() as $key => $value) {
            $this->outputData[ConfigEnum::RESPONSE][ConfigEnum::STATUS][$key] = $value;
        }

        return $this;
    }

    private function addResponseHeaders(): self
    {
        foreach ($this->responseModel->getHeaders() as $key => $value) {
            $this->outputData[ConfigEnum::RESPONSE][ConfigEnum::HEADERS][$key] = $value;
        }

        return $this;
    }
}
