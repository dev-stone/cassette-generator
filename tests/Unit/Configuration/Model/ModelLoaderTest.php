<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Configuration\Model;

use Vcg\Configuration\ConfigReader;
use Vcg\Configuration\ModelsLoader\ModelsLoader;
use Vcg\Tests\Unit\RecordTestCase;

class ModelLoaderTest extends RecordTestCase
{
    public function testModelsLoaded(): void
    {
        $config = new ConfigReader(__DIR__ . '/../../../data/vcg_config.yaml');
        $modelsLoader = new ModelsLoader($config);
        $modelsLoader->load();

        $expectedRecordDefaults = $this->createRecordDefaults();
        $expectedCassettesSettings = $this->createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $modelsLoader->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $modelsLoader->getCassettesSettings());
    }
}
