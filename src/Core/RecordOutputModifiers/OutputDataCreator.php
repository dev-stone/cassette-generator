<?php
declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\Configuration\Config;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;
use Vcg\ValueObject\Record;

class OutputDataCreator
{
    private RequestModel $requestModel;
    private ResponseModel $responseModel;
    private array $outputData = [];

    public function makeOutputData(Record $record)
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
            Config::REQUEST => [],
            Config::RESPONSE => []
        ];

        return $this;
    }

    private function addRequestMethod(): self
    {
        $this->outputData[Config::REQUEST][Config::METHOD] = $this->requestModel->getMethod();

        return $this;
    }

    private function addRequestUrl(): self
    {
        $this->outputData[Config::REQUEST][Config::URL] = $this->requestModel->getUrl();

        return $this;

    }

    private function addRequestHeaders(): self
    {
        foreach ($this->requestModel->getHeaders() as $key => $value) {
            $this->outputData[Config::REQUEST][Config::HEADERS][$key] = $value;
        }

        return $this;
    }

    private function addResponseStatus(): self
    {
        foreach ($this->responseModel->getStatus() as $key => $value) {
            $this->outputData[Config::RESPONSE][Config::STATUS][$key] = $value;
        }

        return $this;
    }

    private function addResponseHeaders(): self
    {
        foreach ($this->responseModel->getHeaders() as $key => $value) {
            $this->outputData[Config::RESPONSE][Config::HEADERS][$key] = $value;
        }

        return $this;
    }
}
