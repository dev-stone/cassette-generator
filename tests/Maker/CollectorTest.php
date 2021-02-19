<?php
declare(strict_types=1);

namespace Vcg\Tests\Maker;

use Vcg\Core\RecordDataCollector;
use Vcg\Tests\RecordTestCase;

class CollectorTest extends RecordTestCase
{
    public function testMake()
    {
        $configuration = $this->createConfiguration();
        $collector = new RecordDataCollector($configuration);

        $expectedCassettesHolders = $this->createCassettesHolders($configuration);
        $this->assertEquals($expectedCassettesHolders, $collector->collect());
    }
}
