<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

trait ModifierTrait
{
    protected array $outputData;
    protected ?string $level1 = null;
    protected ?string $level2 = null;
    protected ?string $level3 = null;

    private function populateLevels(string $index): void
    {
        $this->clearLevels();

        $levels = explode('|', $index);

        $this->level1 = $levels[0] ?? null;
        $this->level2 = $levels[1] ?? null;
        $this->level3 = $levels[2] ?? null;
    }

    private function clearLevels(): void
    {
        $this->level1 = null;
        $this->level2 = null;
        $this->level3 = null;
    }

    private function canModifyLevel2nd(): bool
    {
        return $this->hasLevel2nd()
            && $this->isKeyExistLevel2nd()
            && $this->isValueLevel2nd();
    }

    private function hasLevel2nd(): bool
    {
        return null !== $this->level1
            && null !== $this->level2;
    }

    private function isKeyExistLevel2nd(): bool
    {
        return array_key_exists($this->level2, $this->outputData[$this->level1]);
    }

    private function isValueLevel2nd(): bool
    {
        return !is_array($this->outputData[$this->level1][$this->level2]);
    }

    private function getOutputItemLevel2nd(): string
    {
        return $this->outputData[$this->level1][$this->level2];
    }

    private function setOutputItemLevel2nd(string $outputItem): void
    {
        $this->outputData[$this->level1][$this->level2] = $outputItem;
    }

    private function canModifyLevel3rd(): bool
    {
        return $this->hasLevel3rd()
            && $this->isKeyExistLevel3d();
    }

    private function hasLevel3rd(): bool
    {
        return null !== $this->level1
            && null !== $this->level2
            && null !== $this->level3;
    }

    private function isKeyExistLevel3d(): bool
    {
        return array_key_exists($this->level3, $this->outputData[$this->level1][$this->level2]);
    }

    private function getOutputItemLevel3rd(): string
    {
        return $this->outputData[$this->level1][$this->level2][$this->level3];
    }

    private function setOutputItemLevel3rd(string $outputItem): void
    {
        $this->outputData[$this->level1][$this->level2][$this->level3] = $outputItem;
    }
}
