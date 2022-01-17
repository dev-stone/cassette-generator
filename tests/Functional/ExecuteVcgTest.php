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

    /**
     * @dataProvider versionProvider
     *
     * @param string $version
     * @return void
     */
    public function testVcgCommandRunSuccess(string $version)
    {
        $this->executeVcgCommand($this->dataDir.'/vcg_config.yaml', $version);

        $this->assertReturnValueZero();
        $this->assertOutput(['Success.']);
        $this->assertFilesRecorded();
    }

    public function versionProvider(): array
    {
        return [
            'PHP 7.4' => ['7.4'],
            'PHP 8.0' => ['8.0'],
            'PHP 8.1' => ['8.1'],
        ];
    }

    public function testVcgCommandRunConfigFileNotFound()
    {
        $this->executeVcgCommand($this->configCasesDir.'/vcg_fig.yaml');

        $this->assertReturnValueZero();
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

    private function executeVcgCommand(string $configPath, string $version = '7.4')
    {
        $php = 'php' . $version;
        $vcgPath = realpath(__DIR__ . '/../../bin/vcg');

        $command = "$php $vcgPath $configPath";

        exec($command, $this->output, $this->returnValue);
    }

    private function assertReturnValueZero()
    {
        $this->assertEquals(0, $this->returnValue);
    }

    private function assertOutput(array $output)
    {
        $this->assertEquals($output, $this->output);
    }
}
