<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class ReplaceModifier
{
    public function apply(Record $record): void
    {
        $outputData = $record->getOutputData();
        foreach ($record->getReplaceItems() as $replace => $value) {
            [$root, $list] = explode('|', $replace);
            $outputItem = $outputData[$root][$list];

            foreach ($value as $valueItem) {
                [$type, $placeholder, $modify, $format] = explode('|', $valueItem);
                if ($type === 'date') {
                    $date = (new \DateTime($modify))->format($format);
                    $outputItem = str_replace($placeholder, $date, $outputItem);
                }
            }

            $outputData[$root][$list] = $outputItem;
        }

        $record->setOutputData($outputData);
    }
}
