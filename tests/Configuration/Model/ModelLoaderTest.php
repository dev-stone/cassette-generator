<?php
declare(strict_types=1);

namespace Vcg\Tests\Configuration\Model;

use Vcg\Configuration\RawConfig;
use Vcg\Configuration\Model\ModelsLoader;
use Vcg\Tests\Configuration\ConfigurationTestCase;

class ModelLoaderTest extends ConfigurationTestCase
{
    public function testModelsLoaded(): void
    {
        $config = new RawConfig(__DIR__ . '/../../data/models_config.yaml');
        $modelsLoader = new ModelsLoader($config);
        $modelsLoader->load();

        $expectedRecordDefaults = $this->createRecordDefaults();
        $expectedCassettesSettings = $this->createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $modelsLoader->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $modelsLoader->getCassettesSettings());
    }


}
