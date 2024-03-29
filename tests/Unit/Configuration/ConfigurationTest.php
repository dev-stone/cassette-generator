<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Configuration;

use Vcg\Tests\Unit\RecordTestCase;

class ConfigurationTest extends RecordTestCase
{
    public function testConfigurationLoadsModels(): void
    {
        $configuration = $this->createConfiguration();
        $expectedRecordDefaults = $this->createRecordDefaults();
        $expectedCassettesSettings = $this->createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $configuration->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $configuration->getCassettesHolderModelList());
    }
}
