<?php
declare(strict_types=1);

namespace Vcg\Tests\Writer;

use Vcg\Maker\RecordOutputMaker;
use Vcg\Tests\RecordTestCase;
use Vcg\Writer\CassetteOutput;
use Vcg\Writer\WriterPreprocessor;

class WriterPreprocessorTest extends RecordTestCase
{
    public function testPreprocessor()
    {
        $configuration = $this->createModelsConfiguration();
        $cassettesHolder = $this->createCassettesHolders($configuration);

        $recordOutputMaker = new RecordOutputMaker();

        $preprocessor = new WriterPreprocessor($recordOutputMaker);
        $actual = $preprocessor->prepareCassettes($cassettesHolder);
        $expected = $this->expectedCassettesList();
        $this->assertEquals($expected, $actual);
    }

    private function expectedCassettesList(): array
    {
        $expectedLoginCassette = file_get_contents(__DIR__ . '/../data/login_process_expected.yaml');
        $expectedRegistrationCassette = file_get_contents(__DIR__ . '/../data/registration_process_expected.yaml');
        $cassetteOutputLogin = (new CassetteOutput())
            ->setOutputPath('/var/www/cassette-generator/tests/fixtures/IntegrationTests/login_process.yaml')
            ->setOutputString($expectedLoginCassette);
        $cassetteOutputRegister = (new CassetteOutput())
            ->setOutputPath('/var/www/cassette-generator/tests/fixtures/IntegrationTests/registration_process.yaml')
            ->setOutputString($expectedRegistrationCassette);

        return [$cassetteOutputLogin, $cassetteOutputRegister];
    }
}
