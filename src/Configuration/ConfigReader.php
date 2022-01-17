<?php

declare(strict_types=1);

namespace Vcg\Configuration;

use Symfony\Component\Yaml\Yaml;

class ConfigReader
{
    private string $configPath;
    private array $configData = [];

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        $this->readConfiguration();
    }

    public function getSettings(string $key): array
    {
        return $this->configData[$key];
    }

    public function getConfigData(): array
    {
        return $this->configData;
    }

    private function readConfiguration(): void
    {
        $this->configData = Yaml::parseFile($this->configPath);
    }
}
