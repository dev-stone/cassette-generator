<?php
declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\Config;

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
        $this->validateFirstLevel(Config::RECORD_DEFAULTS);
    }

    private function validDefaultsRequest()
    {
        $this->validateSecondLevel(Config::RECORD_DEFAULTS, Config::REQUEST);
    }

    private function validDefaultsRequestMethod()
    {
        $this->validateThirdLevel(Config::RECORD_DEFAULTS, Config::REQUEST, Config::METHOD);
    }

    private function validDefaultsRequestUrl()
    {
        $this->validateThirdLevel(Config::RECORD_DEFAULTS, Config::REQUEST, Config::URL);
    }

    private function validDefaultsRequestHeaders()
    {
        $this->validateThirdLevel(Config::RECORD_DEFAULTS, Config::REQUEST, Config::HEADERS);
    }

    private function validDefaultsResponse()
    {
        $this->validateSecondLevel(Config::RECORD_DEFAULTS, Config::RESPONSE);
    }

    private function validDefaultsResponseStatus()
    {
        $this->validateThirdLevel(Config::RECORD_DEFAULTS, Config::RESPONSE, Config::STATUS);
    }

    private function validDefaultsResponseHeaders()
    {
        $this->validateThirdLevel(Config::RECORD_DEFAULTS, Config::RESPONSE, Config::HEADERS);
    }
}
