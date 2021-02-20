<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Configuration;

class Vcg
{
    private string $configPath;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
    }

    public function run()
    {
        $configuration = new Configuration($this->configPath);
        $cassettesHolders = (new RecordDataCollector($configuration))->collect();
        $cassettesOutputs = (new WriterPreprocessor())->prepareCassettes($cassettesHolders);

        $cassettesWriter = new CassetteWriter();
        $cassettesWriter->write($cassettesOutputs);
    }
}
