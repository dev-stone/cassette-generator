<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use Vcg\ValueObject\CassetteOutput;
use Vcg\Tests\Unit\RecordTestCase;
use Vcg\Core\WriterPreprocessor;
use Vcg\ValueObject\CassetteOutputList;

class WriterPreprocessorTest extends RecordTestCase
{
    public function testPreprocessor(): void
    {
        $dir = __DIR__ . '/../..';
        $configuration = $this->createConfiguration();
        $cassettesHolder = $this->createCassettesHolders($configuration, $dir);

        $preprocessor = new WriterPreprocessor();
        $actual = $preprocessor->prepareCassettesOutput($cassettesHolder);
        $expected = $this->expectedCassettesList();
        $this->assertEquals($expected, $actual);
    }

    private function expectedCassettesList(): CassetteOutputList
    {
        $expectedLoginCassette = file_get_contents(__DIR__ . '/../../data/CassettesExpected/login_process_expected.yaml');
        $expectedRegistrationCassette = file_get_contents(__DIR__ . '/../../data/CassettesExpected/registration_process_expected.yaml');
        $outputPath = realpath(__DIR__ . '/../../fixturesOutput/IntegrationTests');
        $cassetteOutputLogin = (new CassetteOutput())
            ->setOutputPath($outputPath . '/login_process.yaml')
            ->setOutputString($expectedLoginCassette);
        $cassetteOutputRegister = (new CassetteOutput())
            ->setOutputPath($outputPath. '/registration_process.yaml')
            ->setOutputString($expectedRegistrationCassette);

        return (new CassetteOutputList())
            ->add($cassetteOutputLogin)
            ->add($cassetteOutputRegister);
    }
}
