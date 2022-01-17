<?php

declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

abstract class ConfigReaderRules
{
    protected array $configReaderData;

    public function __construct(array $configReaderData)
    {
        $this->configReaderData = $configReaderData;
    }

    abstract public function validate(): void;

    protected function validateFirstLevel(string $key): void
    {
        if (!array_key_exists($key, $this->configReaderData)) {
            $message = sprintf('Missing %s when read configuration file.', $key);
            throw new \RuntimeException($message);
        }
    }

    protected function validateSecondLevel(string $parent, string $key): void
    {
        if (!array_key_exists($key, $this->configReaderData[$parent])) {
            $message = sprintf('Missing %s %s when read configuration file.', $parent, $key);
            throw new \RuntimeException($message);
        }
    }

    protected function validateThirdLevel(string $parent, string $item, string $key): void
    {
        if (!array_key_exists($key, $this->configReaderData[$parent][$item])) {
            $message = sprintf('Missing %s %s %s when read configuration file.', $parent, $item, $key);
            throw new \RuntimeException($message);
        }
    }
}
