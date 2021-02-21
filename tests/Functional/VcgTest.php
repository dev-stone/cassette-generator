<?php
declare(strict_types=1);

namespace Vcg\Tests\Functional;

use Vcg\Core\Vcg;
use Vcg\Exception\ConfigurationNotExistException;
use Vcg\Exception\EmptyConfigurationException;
use Vcg\Exception\MissingConfigItemException;

class VcgTest extends FunctionalTestCase
{
    private string $integrationTestsDir;

    public function testRun()
    {
        $configPath = __DIR__ . '/../data/vcg_config.yaml';
        (new Vcg($configPath))->run();
        $this->assertFilesRecorded();
    }

    public function testNotValidConfig()
    {
        $this->expectException(MissingConfigItemException::class);

        $configPath = __DIR__ . '/../data/ConfigsCases/not_valid_records_defaults.yaml';
        (new Vcg($configPath))->run();
    }

    public function testConfigNotExist()
    {
        $this->expectException(ConfigurationNotExistException::class);

        $configPath = __DIR__ . '/../data/vcg_fig.yaml';
        (new Vcg($configPath))->run();
    }

    public function testConfigEmpty()
    {
        $this->expectException(EmptyConfigurationException::class);

        $configPath = __DIR__ . '/../data/ConfigsCases/file_empty.yaml';
        (new Vcg($configPath))->run();
    }

    protected function setUp(): void
    {
        $this->integrationTestsDir = __DIR__ . '/../fixturesOutput/IntegrationTests';
        $this->removeFiles($this->integrationTestsDir);
        $this->assertFilesNotExist($this->integrationTestsDir);
    }

    protected function tearDown(): void
    {
        $this->removeFiles($this->integrationTestsDir);
    }
}
