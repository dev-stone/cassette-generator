<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Configuration;
use Vcg\Validation\PreConfigValidator;

class Vcg
{
    private string $configPath;
    private PreConfigValidator $preConfigValidator;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        $this->preConfigValidator = new PreConfigValidator($configPath);
    }

    public function run(): void
    {
        $this->preConfigValidator->validate();
        $configuration = new Configuration($this->configPath);
        $cassettesHolders = (new RecordDataCollector($configuration))->collect();
        $cassettesOutputs = (new WriterPreprocessor())->prepareCassettes($cassettesHolders);

        $cassettesWriter = new CassetteWriter();
        $cassettesWriter->write($cassettesOutputs);
    }
}
