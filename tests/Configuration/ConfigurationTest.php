<?php
declare(strict_types=1);

namespace Vcg\Tests\Configuration;

use Vcg\Tests\RecordTestCase;

class ConfigurationTest extends RecordTestCase
{
    public function testConfigurationLoadsModels()
    {
        $configuration = $this->createConfiguration();
        $expectedRecordDefaults = $this->createRecordDefaults();
        $expectedCassettesSettings = $this->createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $configuration->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $configuration->getCassettesSettings());
    }
}
