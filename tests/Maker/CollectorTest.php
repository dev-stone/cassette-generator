<?php
declare(strict_types=1);

namespace Vcg\Tests\Maker;

use Vcg\Configuration\Configuration;
use Vcg\Maker\Collector;
use Vcg\Tests\RecordTestCase;

class CollectorTest extends RecordTestCase
{
    public function testMake()
    {
        $configuration = new Configuration(__DIR__ . '/../data/models_config.yaml');
        $collector = new Collector($configuration);
        $collector->collect();

        $expectedCassettesHolders = $this->createCassettesHolders($configuration);
        $this->assertEquals($expectedCassettesHolders, $collector->getCassettesHolders());
    }
}
