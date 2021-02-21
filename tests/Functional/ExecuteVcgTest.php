<?php
declare(strict_types=1);

namespace Vcg\Tests\Functional;

class ExecuteVcgTest extends FunctionalTestCase
{
    private string $integrationTestsDir;
    private string $dataDir;
    private string $configCasesDir;
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
        $this->executeVcgCommand($this->configCasesDir.'/vcg_fig.yaml');

        $this->assertReturnValue(0);
        $this->assertOutput(['Configuration file not exist!']);
        $this->assertFilesNotExist($this->integrationTestsDir);
    }

    public function testVcgCommandRunNotValidConfig()
    {
        $this->executeVcgCommand($this->configCasesDir.'/not_valid_records_defaults.yaml');
        $this->assertOutput(['Missing record-defaults when read configuration file.']);
    }

    public function testNotValidConfigCassettesSettings()
    {
        $this->executeVcgCommand($this->configCasesDir.'/not_valid_cassette_settings.yaml');
        $this->assertOutput(['Missing cassettes-settings when read configuration file.']);
    }

    public function testEmptyConfig()
    {
        $this->executeVcgCommand($this->configCasesDir.'/file_empty.yaml');
        $this->assertOutput(['Configuration file empty!']);
    }

    protected function setUp(): void
    {
        $testsDir = realpath(__DIR__.'/..');
        $this->integrationTestsDir = $testsDir.'/fixturesOutput/IntegrationTests';
        $this->dataDir = $testsDir.'/data';
        $this->configCasesDir = $this->dataDir.'/ConfigsCases';

        $this->removeFiles($this->integrationTestsDir);
        $this->assertFilesNotExist($this->integrationTestsDir);
    }

    protected function tearDown(): void
    {
        $this->removeFiles($this->integrationTestsDir);
    }

    private function executeVcgCommand(string $configPath)
    {
        $vcgPath = realpath(__DIR__ . '/../../bin/vcg');

        $command = "php $vcgPath $configPath";

        exec($command, $this->output, $this->returnValue);
    }

    private function assertReturnValue(int $returnValue)
    {
        $this->assertEquals($returnValue, $this->returnValue);
    }

    private function assertOutput(array $output)
    {
        $this->assertEquals($output, $this->output);
    }
}
