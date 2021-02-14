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
        $configPath = __DIR__ . '/data/acg_config.yaml';

        $config = new Configuration($configPath);
        $data = (new DataCollector($config))->getData();
        $yamlParser = new YamlParser($data);
        $yamlParserData = $yamlParser->getData();
        $file = $yamlParserData[0]['outputFile'];
        $outputWriter = (new OutputWriter())
            ->setParser($yamlParser)
            ->setOutputFile($file);

        $outputWriter->writeOutput();

        $expectedHash = yaml_parse_file(__DIR__.'/data/expected_output.yaml');
        $outputHash = yaml_parse_file(__DIR__ . '/fixtures/find_user.yaml');
        $this->assertEquals($expectedHash, $outputHash);
    }
}

