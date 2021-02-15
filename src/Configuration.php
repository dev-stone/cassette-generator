<?php
declare(strict_types=1);

namespace Vcg;

use Symfony\Component\Yaml\Yaml;

class Configuration
{
    private string $configPath;
    private array $config = [];

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        $this->loadConfiguration();
    }

    public function loadConfiguration(): self
    {
        $this->config = Yaml::parseFile($this->configPath);

        return $this;
    }

    public function getCassetteSettings(): array
    {
       return $this->getSettings('cassette-settings');
    }

    public function getTestsSettings(): array
    {
        return $this->getSettings('tests-settings');
    }

    public function getFixturesSettings()
    {
        $testsSettings = $this->getTestsSettings();

        if (!array_key_exists('fixtures', $testsSettings)) {
            throw new \RuntimeException('Fixtures items not set.');
        }

        return $testsSettings['fixtures'];
    }

    private function getSettings(string $key): array
    {
        $this->validateSettings($key);

        return $this->config[$key];
    }

    private function validateSettings(string $key)
    {
        if (!file_exists($this->configPath)) {
            throw new \RuntimeException('Configuration file not found.');
        }
        if (!array_key_exists($key, $this->config)) {
            throw new \RuntimeException(sprintf('Missing %s when load configuration file.', $key));
        }
    }
}
