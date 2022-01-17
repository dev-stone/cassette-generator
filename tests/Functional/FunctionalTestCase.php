<?php

declare(strict_types=1);

namespace Vcg\Tests\Functional;

use PHPUnit\Framework\TestCase;

class FunctionalTestCase extends TestCase
{
    protected function removeFiles(string $filesDir): void
    {
        $allFiles = glob($filesDir.'/*');
        foreach ($allFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    protected function assertFilesRecorded(): void
    {
        $this->assertLoginFilesRecorded();
        $this->assertRegistrationFilesRecorded();
    }

    protected function assertFilesNotExist(string $filesDir): void
    {
        $loginExist = file_exists($filesDir . '/login_process.yaml');
        $registrationExist = file_exists($filesDir.'/registration_process.yaml');
        $this->assertFalse($loginExist);
        $this->assertFalse($registrationExist);
    }

    protected function assertLoginFilesRecorded(): void
    {
        $loginPathExpected = __DIR__.'/../data/CassettesExpected/login_process_expected.yaml';
        $loginPathActual = __DIR__.'/../fixturesOutput/IntegrationTests/login_process.yaml';
        $this->assertFilesContentsEqual($loginPathExpected, $loginPathActual);
    }

    protected function assertRegistrationFilesRecorded(): void
    {
        $registrationPathExpected = __DIR__.'/../data/CassettesExpected/registration_process_expected.yaml';
        $registrationPathActual = __DIR__.'/../fixturesOutput/IntegrationTests/registration_process.yaml';
        $this->assertFilesContentsEqual($registrationPathExpected, $registrationPathActual);
    }

    protected function assertFilesContentsEqual(string $expected, string $actual): void
    {
        $expectedContent = file_get_contents($expected);
        $actualContent = file_get_contents($actual);
        $this->assertEquals($expectedContent, $actualContent);
    }
}
