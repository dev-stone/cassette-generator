<?php
declare(strict_types=1);

namespace Vcg\Tests;

use Symfony\Component\Yaml\Yaml;
use Vcg\Collector\DataCollector;
use Vcg\Configuration;
use Vcg\Parser\YamlParser;
use Vcg\Writer\OutputWriter;
use PHPUnit\Framework\TestCase;

class WriteYamlOutputTest extends TestCase
{
    public function testYamlOutputToFile()
    {
        $configPath = __DIR__ . '/data/vcg_config.yaml';

        $config = new Configuration($configPath);
        $data = (new DataCollector($config))->getData();
        $yamlParser = new YamlParser($data);

        $yamlParserData = $yamlParser->getData();
        $file = $yamlParserData[0]['outputFile'];

        $outputWriter = (new OutputWriter())
            ->setParser($yamlParser)
            ->setOutputFile($file);

        $outputWriter->writeOutput();

        $expectedHash = Yaml::parseFile(__DIR__.'/data/expected_output.yaml');
        $outputHash = Yaml::parseFile(__DIR__ . '/fixtures/find_user.yaml');
        $this->assertEquals($expectedHash, $outputHash);
    }
}

