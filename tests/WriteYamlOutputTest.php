<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\Collector\DataCollector;
use Acg\Configuration;
use Acg\Parser\YamlParser;
use Acg\Writer\OutputWriter;
use PHPUnit\Framework\TestCase;

class WriteYamlOutputTest extends TestCase
{
    public function testYamlOutputToFile()
    {
        $outputFile = __DIR__ . '/data/output.yaml';

        $config = new Configuration(__DIR__.'/data/acg_config.yaml');
        $data = (new DataCollector($config))->getData();
        $yamlParser = new YamlParser($data);
        $outputWriter = (new OutputWriter())
            ->setOutputFile($outputFile)
            ->setParser($yamlParser);
        $outputWriter->writeOutput();

        $expectedHash = yaml_parse_file(__DIR__.'/data/expected_output.yaml');
        $outputHash = yaml_parse_file($outputFile);
        $this->assertEquals($expectedHash, $outputHash);
    }
}

