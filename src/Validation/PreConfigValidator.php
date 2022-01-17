<?php

declare(strict_types=1);

namespace Vcg\Validation;

class PreConfigValidator
{
    private string $configPath;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
    }

    public function validate(): void
    {
        if (!file_exists($this->configPath) || !is_file($this->configPath)) {
            throw new \RuntimeException('Configuration file not exist!');
        }
        if (empty(file_get_contents($this->configPath))) {
            throw new \RuntimeException('Configuration file empty!');
        }
    }
}
