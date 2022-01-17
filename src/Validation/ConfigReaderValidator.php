<?php

declare(strict_types=1);

namespace Vcg\Validation;

use Vcg\Configuration\ConfigReader;
use Vcg\Validation\ConfigReaderRules\CassettesSettingsRules;
use Vcg\Validation\ConfigReaderRules\RecordDefaultsRules;

class ConfigReaderValidator
{
    private ConfigReader $configReader;

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
    }

    public function validate(): self
    {
        $configReaderData = $this->configReader->getConfigData();
        (new RecordDefaultsRules($configReaderData))->validate();
        (new CassettesSettingsRules($configReaderData))->validate();

        return $this;
    }
}
