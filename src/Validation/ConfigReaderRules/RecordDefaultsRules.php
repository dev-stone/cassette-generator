<?php
declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

class RecordDefaultsRules extends ConfigReaderRules
{
    public function validate()
    {
        $this->validRecordsDefaults();
        $this->validDefaultsRequest();
        $this->validDefaultsRequestMethod();
        $this->validDefaultsRequestUrl();
        $this->validDefaultsRequestHeaders();
        $this->validDefaultsResponse();
        $this->validDefaultsResponseStatus();
        $this->validDefaultsResponseHeaders();
    }

    private function validRecordsDefaults()
    {
        $this->validateFirstLevel('record-defaults');
    }

    private function validDefaultsRequest()
    {
        $this->validateSecondLevel('record-defaults', 'request');
    }

    private function validDefaultsRequestMethod()
    {
        $this->validateThirdLevel('record-defaults', 'request', 'method');
    }

    private function validDefaultsRequestUrl()
    {
        $this->validateThirdLevel('record-defaults', 'request', 'url');
    }

    private function validDefaultsRequestHeaders()
    {
        $this->validateThirdLevel('record-defaults', 'request', 'headers');
    }

    private function validDefaultsResponse()
    {
        $this->validateSecondLevel('record-defaults', 'response');
    }

    private function validDefaultsResponseStatus()
    {
        $this->validateThirdLevel('record-defaults', 'response', 'status');
    }

    private function validDefaultsResponseHeaders()
    {
        $this->validateThirdLevel('record-defaults', 'response', 'headers');
    }
}
