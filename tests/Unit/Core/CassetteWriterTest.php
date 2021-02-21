<?php
declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use Vcg\Core\RecordDataCollector;
use Vcg\Tests\Unit\RecordTestCase;
use Vcg\Core\CassetteWriter;
use Vcg\Core\WriterPreprocessor;

class CassetteWriterTest extends RecordTestCase
{
    public function testWriteCassettes()
    {
        $configuration = $this->createConfiguration();
        $cassettesHolders = (new RecordDataCollector($configuration))->collect();

        $preprocessor = new WriterPreprocessor();
        $cassettesOutputs = $preprocessor->prepareCassettes($cassettesHolders);

        $cassettesWriter = new CassetteWriter();
        $cassettesWriter->write($cassettesOutputs);

        $expectedLoginContent = file_get_contents(__DIR__ . '/../../data/CassettesExpected/login_process_expected.yaml');
        $expectedRegistrationContent = file_get_contents(__DIR__ . '/../../data/CassettesExpected/registration_process_expected.yaml');
        $actualLoginContent = file_get_contents(__DIR__ . '/../../fixturesOutput/IntegrationTests/login_process.yaml');
        $actualRegistrationContent = file_get_contents(__DIR__ . '/../../fixturesOutput/IntegrationTests/registration_process.yaml');

        $this->assertEquals($expectedLoginContent, $actualLoginContent);
        $this->assertEquals($expectedRegistrationContent, $actualRegistrationContent);
    }
}
