<?php
declare(strict_types=1);

namespace Vcg;

use Vcg\Configuration\RawConfig;

class Configuration
{
    private RawConfig $rawConfig;

    public function __construct(string $configPath)
    {
        $this->rawConfig = new RawConfig($configPath);
    }

    public function getCassetteSettings(): array
    {
       return $this->rawConfig->getSettings('cassette-settings');
    }

    public function getTestsSettings(): array
    {
        return $this->rawConfig->getSettings('tests-settings');
    }

    public function getFixturesSettings()
    {
        $testsSettings = $this->getTestsSettings();

        if (!array_key_exists('fixtures', $testsSettings)) {
            throw new \RuntimeException('Fixtures items not set.');
        }

        return $testsSettings['fixtures'];
    }
}
