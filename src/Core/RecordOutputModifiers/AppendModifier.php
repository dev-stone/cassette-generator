<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class AppendModifier implements RecordModifierInterface
{
    public function apply(Record $record): void
    {
        $outputData = $record->getOutputData();
        foreach ($record->getAppendItems() as $append => $value) {
            [$root, $list, $key] = explode('|', $append);
            $outputItem = $outputData[$root][$list][$key];

            $addQuote = '';
            if (strrpos($outputItem, "'") === strlen($outputItem)-1) {
                $addQuote = "'";
                $outputItem = substr($outputItem, 0, -1);
            }

            $outputItem = $outputItem . $value . $addQuote;
            $outputData[$root][$list][$key] = $outputItem;
        }

        $record->setOutputData($outputData);
    }
}
