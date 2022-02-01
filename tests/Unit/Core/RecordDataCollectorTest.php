<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use Vcg\Core\RecordDataCollector;
use Vcg\Tests\Unit\RecordTestCase;

class RecordDataCollectorTest extends RecordTestCase
{
    public function testMake(): void
    {
        $configuration = $this->createConfiguration();
        $collector = new RecordDataCollector($configuration);

        $dir = __DIR__ . '/../..';
        $expectedCassettesHolders = $this->createCassettesHolders($configuration, $dir);
        $this->assertEquals($expectedCassettesHolders, $collector->collect());
    }
}
