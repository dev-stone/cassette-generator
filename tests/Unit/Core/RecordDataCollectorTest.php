<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use Vcg\Core\RecordDataCollector;
use Vcg\Tests\Unit\ReplaceConfigFactory;
use Vcg\Tests\Unit\VcgConfigFactory;

class RecordDataCollectorTest extends TestCase
{
    public function testVcgCollect(): void
    {
        $configuration = VcgConfigFactory::createConfiguration();
        $collector = new RecordDataCollector($configuration);

        $dir = __DIR__ . '/../..';
        $expectedCassettesHolders = VcgConfigFactory::createCassettesHolders($configuration, $dir);
        $this->assertEquals($expectedCassettesHolders, $collector->collect());
    }

    public function testReplaceCollect(): void
    {
        $configuration = ReplaceConfigFactory::createConfiguration();
        $collector = new RecordDataCollector($configuration);

        $dir = __DIR__ . '/../..';
        $expectedCassettesHolders = ReplaceConfigFactory::createCassettesHolders($configuration, $dir);
        $this->assertEquals($expectedCassettesHolders, $collector->collect());
    }
}
