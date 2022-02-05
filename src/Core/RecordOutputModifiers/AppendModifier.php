<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class AppendModifier implements RecordModifierInterface
{
    use ModifierTrait;

    public function apply(Record $record): void
    {
        $this->outputData = $record->getOutputData();
        $this->appendOutputDataItems($record);
        $record->setOutputData($this->outputData);
    }

    private function appendOutputDataItems(Record $record): void
    {
        foreach ($record->getAppendItems() as $index => $value) {
            $this->populateLevels($index);

            if ($this->canModifyLevel2nd()) {
                $this->appendLevel2nd($value);
                continue;
            }

            if ($this->canModifyLevel3rd()) {
                $this->appendLevel3rd($value);
            }
        }
    }

    private function appendLevel2nd(string $value): void
    {
        $outputItem = $this->getOutputItemLevel2nd();

        $addQuote = '';
        if ($this->isLastSymbolQuote($outputItem)) {
            $this->removeLastSymbol($outputItem);
            $addQuote = "'";
        }

        $this->setOutputItemLevel2nd($outputItem . $value . $addQuote);
    }

    private function appendLevel3rd(string $value): void
    {
        $outputItem = $this->getOutputItemLevel3rd();

        $addQuote = '';
        if ($this->isLastSymbolQuote($outputItem)) {
            $this->removeLastSymbol($outputItem);
            $addQuote = "'";
        }

        $this->setOutputItemLevel3rd($outputItem . $value . $addQuote);
    }

    private function isLastSymbolQuote(string $outputItem): bool
    {
        return strrpos($outputItem, "'") === strlen($outputItem) - 1;
    }

    private function removeLastSymbol(string &$outputItem)
    {
        $outputItem = substr($outputItem, 0, -1);
    }
}
