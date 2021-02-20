<?php
declare(strict_types=1);

namespace Vcg\Tests\Functional;

use PHPUnit\Framework\TestCase;

class RunVcgTest extends TestCase
{
    private string $integrationTestsDir;
    private string $dataDir;
    private ?int $returnValue;
    private ?array $output;

    public function testVcgCommandRunSuccess()
    {
        $this->executeVcgCommand($this->dataDir.'/vcg_config.yaml');

        $this->assertReturnValue(0);
        $this->assertOutput(['Success.']);
        $this->assertFilesRecorded();
    }

    public function testVcgCommandRunConfigFileNotFound()
    {
        $this->executeVcgCommand($this->dataDir.'/vcg_fig.yaml');

        $this->assertReturnValue(0);
        $this->assertOutput(['Configuration file not exist!']);
        $this->assertFilesNotExist();
    }

    public function testVcgCommandRunNotValidConfig()
    {
        $this->executeVcgCommand($this->dataDir.'/not_valid_records_defaults.yaml');
        $this->assertOutput(['Missing record-defaults when load configuration file.']);
    }

    public function testNotValidConfigCassettesSettings()
    {
        $this->executeVcgCommand($this->dataDir.'/not_valid_cassette_settings.yaml');
        $this->assertOutput(['Missing cassettes-settings when load configuration file.']);
    }

    public function testEmptyConfig()
    {
        $this->executeVcgCommand($this->dataDir.'/file_empty.yaml');
        $this->assertOutput(['Configuration file empty!']);
    }

    protected function setUp(): void
    {
        $testsDir = __DIR__.'/..';
        $this->integrationTestsDir = realpath($testsDir.'/fixturesOutput/IntegrationTests');
        $this->dataDir = realpath($testsDir.'/data');
        $this->removeIntegrationTestsFiles();
    }

    private function executeVcgCommand(string $configPath)
    {
        $vcgPath = realpath(__DIR__ . '/../../bin/vcg');

        $command = "php $vcgPath $configPath";

        exec($command, $this->output, $this->returnValue);
    }

    private function removeIntegrationTestsFiles():void
    {
        $allFiles = glob($this->integrationTestsDir . '/*');
        foreach ($allFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    private function assertReturnValue(int $returnValue)
    {
        $this->assertEquals($returnValue, $this->returnValue);
    }

    private function assertOutput(array $output)
    {
        $this->assertEquals($output, $this->output);
    }

    private function assertFilesRecorded()
    {
        $this->assertLoginFilesRecorded();
        $this->assertRegistrationFilesRecorded();

    }

    private function assertFilesNotExist()
    {
        $loginExist = file_exists($this->integrationTestsDir . '/login_process.yaml');
        $registrationExist = file_exists($this->integrationTestsDir . '/registration_process.yaml');
        $this->assertFalse($loginExist);
        $this->assertFalse($registrationExist);
    }

    private function assertLoginFilesRecorded(): void
    {
        $expectedLoginContent = file_get_contents($this->dataDir . '/login_process_expected.yaml');
        $actualLoginContent = file_get_contents($this->integrationTestsDir . '/login_process.yaml');
        $this->assertEquals($expectedLoginContent, $actualLoginContent);
    }

    private function assertRegistrationFilesRecorded(): void
    {
        $expectedRegistrationContent = file_get_contents($this->dataDir . '/registration_process_expected.yaml');
        $actualRegistrationContent = file_get_contents($this->integrationTestsDir . '/registration_process.yaml');
        $this->assertEquals($expectedRegistrationContent, $actualRegistrationContent);
    }
}
