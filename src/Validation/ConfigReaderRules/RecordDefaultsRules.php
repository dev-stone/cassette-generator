<?php
declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\ConfigEnum;

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
        $this->validateFirstLevel(ConfigEnum::RECORD_DEFAULTS);
    }

    private function validDefaultsRequest()
    {
        $this->validateSecondLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST);
    }

    private function validDefaultsRequestMethod()
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::METHOD);
    }

    private function validDefaultsRequestUrl()
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::URL);
    }

    private function validDefaultsRequestHeaders()
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::HEADERS);
    }

    private function validDefaultsResponse()
    {
        $this->validateSecondLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE);
    }

    private function validDefaultsResponseStatus()
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE, ConfigEnum::STATUS);
    }

    private function validDefaultsResponseHeaders()
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE, ConfigEnum::HEADERS);
    }
}
