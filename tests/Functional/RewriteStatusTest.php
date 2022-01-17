<?php

declare(strict_types=1);

namespace Vcg\Tests\Functional;

use Vcg\Core\Vcg;

class RewriteStatusTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        $failingDir = __DIR__ . '/../fixturesOutput/Failing';
        $this->removeFiles($failingDir);
    }

    public function testRun(): void
    {
        $configPath = __DIR__ . '/../data/ConfigsCases/vcg_config_with_error.yaml';
        (new Vcg($configPath))->run();
        $this->assertFailingFilesRecorded();
    }

    private function assertFailingFilesRecorded(): void
    {
        $expected = __DIR__.'/../data/CassettesExpected/failing_process_expected.yaml';
        $actual = __DIR__.'/../fixturesOutput/Failing/server_error.yaml';
        $this->assertFilesContentsEqual($expected, $actual);
    }
}
