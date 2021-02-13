<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\DataCollector;
use Acg\Frame;
use Acg\OutputWriter;
use PHPUnit\Framework\TestCase;

class WriteFrameOutputTest extends TestCase
{
    public function testFrameFile()
    {
        $outputFile = __DIR__ . '/data/output.yaml';

        $data = (new DataCollector())->getData();
        $frame = new Frame($data);
        $outputWriter = (new OutputWriter())
            ->setOutputFile($outputFile)
            ->setFrame($frame);
        $outputWriter->writeOutput();

        $frameHash = yaml_parse_file(__DIR__.'/data/frame.yaml');
        $outputHash = yaml_parse_file($outputFile);
        $this->assertEquals($frameHash, $outputHash);
    }
}

