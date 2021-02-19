<?php
declare(strict_types=1);

namespace Vcg\Configuration;

use Symfony\Component\Yaml\Yaml;

class ConfigReader
{
    private string $configPath;
    private array $config = [];

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        $this->readConfiguration();
    }

    public function getSettings(string $key): array
    {
        $this->validateSettings($key);

        return $this->config[$key];
    }

    private function readConfiguration(): void
    {
        $this->config = Yaml::parseFile($this->configPath);
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
