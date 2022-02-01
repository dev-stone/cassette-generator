<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Vcg\Tests\Unit\ReplaceConfigFactory;
use Vcg\Tests\Unit\VcgConfigFactory;

class ConfigurationTest extends TestCase
{
    public function testVcgConfigLoadsModels(): void
    {
        $configuration = VcgConfigFactory::createConfiguration();
        $expectedRecordDefaults = VcgConfigFactory::createRecordDefaults();
        $expectedCassettesSettings = VcgConfigFactory::createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $configuration->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $configuration->getCassettesHolderModelList());
    }

    public function testReplaceConfigLoadsModels(): void
    {
        $configuration = ReplaceConfigFactory::createConfiguration();
        $expectedRecordDefaults = ReplaceConfigFactory::createRecordDefaults();
        $expectedCassettesSettings = ReplaceConfigFactory::createCassettesSettings();
        $this->assertEquals($expectedRecordDefaults, $configuration->getRecordDefaults());
        $this->assertEquals($expectedCassettesSettings, $configuration->getCassettesHolderModelList());
    }
}
