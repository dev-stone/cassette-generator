<?php
declare(strict_types=1);

namespace Vcg\Tests\Configuration;

use Vcg\Configuration\Configuration;

class ConfigurationTest extends ConfigurationTestCase
{
    public function testConfigurationLoadsModels()
    {
        $configuration = new Configuration(__DIR__ . '/../data/models_config.yaml');

        $expectedRecordDefaults = $this->createRecordDefaults();
        $expectedCassettesSettings = $this->createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $configuration->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $configuration->getCassettesSettings());
    }
}
