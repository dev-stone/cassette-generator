<?php
declare(strict_types=1);

namespace Vcg\Tests\Writer;

use Vcg\Maker\Collector;
use Vcg\Maker\RecordOutputMaker;
use Vcg\Tests\RecordTestCase;
use Vcg\Writer\CassetteWriter;
use Vcg\Writer\WriterPreprocessor;

class CassetteWriterTest extends RecordTestCase
{
    public function testWriteCassettes()
    {
        $configuration = $this->createModelsConfiguration();
        $collector = new Collector($configuration);
        $collector->collect();
        $cassettesHolders = $collector->getCassettesHolders();
        $recordOutputMaker = new RecordOutputMaker();

        $preprocessor = new WriterPreprocessor($recordOutputMaker);
        $cassettesOutputs = $preprocessor->prepareCassettes($cassettesHolders);

        $cassettesWriter = new CassetteWriter();
        $cassettesWriter->write($cassettesOutputs);

        $expectedLoginContent = file_get_contents(__DIR__.'/../data/login_process_expected.yaml');
        $expectedRegistrationContent = file_get_contents(__DIR__.'/../data/registration_process_expected.yaml');
        $actualLoginContent = file_get_contents(__DIR__.'/../fixtures/IntegrationTests/login_process.yaml');
        $actualRegistrationContent = file_get_contents(__DIR__.'/../fixtures/IntegrationTests/registration_process.yaml');

        $this->assertEquals($expectedLoginContent, $actualLoginContent);
        $this->assertEquals($expectedRegistrationContent, $actualRegistrationContent);
    }
}
