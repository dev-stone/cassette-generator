<?php
declare(strict_types=1);

namespace Vcg\Tests\Functional;

use Vcg\Core\Vcg;

class VcgTest extends FunctionalTestCase
{
    private string $integrationTestsDir;

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

    public function testRun()
    {
        $configPath = __DIR__ . '/../data/vcg_config.yaml';
        (new Vcg($configPath))->run();
        $this->assertFilesRecorded();
    }

    public function testNotValidConfig()
    {
        $this->expectException(\RuntimeException::class);

        $configPath = __DIR__ . '/../data/ConfigsCases/not_valid_records_defaults.yaml';
        (new Vcg($configPath))->run();
    }

    public function testConfigNotExist()
    {
        $this->expectException(\RuntimeException::class);

        $configPath = __DIR__ . '/../data/vcg_fig.yaml';
        (new Vcg($configPath))->run();
    }

    public function testConfigEmpty()
    {
        $this->expectException(\RuntimeException::class);

        $configPath = __DIR__ . '/../data/ConfigsCases/file_empty.yaml';
        (new Vcg($configPath))->run();
    }
}
