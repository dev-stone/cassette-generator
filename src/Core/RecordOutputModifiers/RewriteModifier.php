<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class RewriteModifier implements RecordModifierInterface
{
    use ModifierTrait;

    public function apply(Record $record): void
    {
        $this->outputData = $record->getOutputData();
        $this->rewriteOutputDataItems($record);
        $record->setOutputData($this->outputData);
    }

    private function rewriteOutputDataItems(Record $record): void
    {
        foreach ($record->getRewriteItems() as $index => $value) {
            $this->populateLevels($index);

            if ($this->canModifyLevel2nd()) {
                $this->rewriteLevel2nd($value);
                continue;
            }

            if ($this->canModifyLevel3rd()) {
                $this->rewriteLevel3rd($value);
            }
        }
    }

    protected function rewriteLevel2nd($value): void
    {
        $this->outputData[$this->level1][$this->level2] = $value;
    }

    protected function rewriteLevel3rd($value): void
    {
        $this->outputData[$this->level1][$this->level2][$this->level3] = $value;
    }
}
