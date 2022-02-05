<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class RewriteModifier implements RecordModifierInterface
{
    private array $outputData;
    private ?string $level1;
    private ?string $level2;
    private ?string $level3;

    public function apply(Record $record): void
    {
        $this->outputData = $record->getOutputData();

        foreach ($record->getRewriteItems() as $index => $value) {
            $this->populateLevels($index);

            if ($this->canRewriteLevel2nd()) {
                $this->rewriteLevel2nd($value);
                continue;
            }

            if ($this->canRewriteLevel3rd()) {
                $this->rewriteLevel3rd($value);
            }
        }

        $record->setOutputData($this->outputData);
    }

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

    private function canRewriteLevel2nd(): bool
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

    private function rewriteLevel2nd($value): void
    {
        $this->outputData[$this->level1][$this->level2] = $value;
    }

    private function canRewriteLevel3rd(): bool
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

    private function rewriteLevel3rd($value): void
    {
        $this->outputData[$this->level1][$this->level2][$this->level3] = $value;
    }
}
