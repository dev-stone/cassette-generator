<?php
declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use Vcg\ValueObject\CassetteOutput;
use Vcg\Tests\Unit\RecordTestCase;
use Vcg\Core\WriterPreprocessor;

class WriterPreprocessorTest extends RecordTestCase
{
    public function testPreprocessor()
    {
        $configuration = $this->createConfiguration();
        $cassettesHolder = $this->createCassettesHolders($configuration);

        $preprocessor = new WriterPreprocessor();
        $actual = $preprocessor->prepareCassettes($cassettesHolder);
        $expected = $this->expectedCassettesList();
        $this->assertEquals($expected, $actual);
    }

    private function expectedCassettesList(): array
    {
        $expectedLoginCassette = file_get_contents(__DIR__ . '/../../data/CassettesExpected/login_process_expected.yaml');
        $expectedRegistrationCassette = file_get_contents(__DIR__ . '/../../data/CassettesExpected/registration_process_expected.yaml');
        $cassetteOutputLogin = (new CassetteOutput())
            ->setOutputPath('/var/www/cassette-generator/tests/fixturesOutput/IntegrationTests/login_process.yaml')
            ->setOutputString($expectedLoginCassette);
        $cassetteOutputRegister = (new CassetteOutput())
            ->setOutputPath('/var/www/cassette-generator/tests/fixturesOutput/IntegrationTests/registration_process.yaml')
            ->setOutputString($expectedRegistrationCassette);

        return [$cassetteOutputLogin, $cassetteOutputRegister];
    }
}
