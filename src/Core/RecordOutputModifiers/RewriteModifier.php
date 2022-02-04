<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class RewriteModifier implements RecordModifierInterface
{
    public function apply(Record $record): void
    {
        $outputData = $record->getOutputData();
        foreach ($record->getRewriteItems() as $index => $value) {
            [$level1, $level2, $level3] = explode('|', $index);

            if (!array_key_exists($level3, $outputData[$level1][$level2])) {
                continue;
            }

            $outputData[$level1][$level2][$level3] = $value;
        }

        $record->setOutputData($outputData);
    }
}
