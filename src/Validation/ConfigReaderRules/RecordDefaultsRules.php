<?php

declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\ConfigEnum;

class RecordDefaultsRules extends ConfigReaderRules
{
    public function validate(): void
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

    private function validRecordsDefaults(): void
    {
        $this->validateFirstLevel(ConfigEnum::RECORD_DEFAULTS);
    }

    private function validDefaultsRequest(): void
    {
        $this->validateSecondLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST);
    }

    private function validDefaultsRequestMethod(): void
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::METHOD);
    }

    private function validDefaultsRequestUrl(): void
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::URL);
    }

    private function validDefaultsRequestHeaders(): void
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::REQUEST, ConfigEnum::HEADERS);
    }

    private function validDefaultsResponse(): void
    {
        $this->validateSecondLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE);
    }

    private function validDefaultsResponseStatus(): void
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE, ConfigEnum::STATUS);
    }

    private function validDefaultsResponseHeaders(): void
    {
        $this->validateThirdLevel(ConfigEnum::RECORD_DEFAULTS, ConfigEnum::RESPONSE, ConfigEnum::HEADERS);
    }
}
