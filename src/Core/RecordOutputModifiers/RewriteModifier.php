<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

class RewriteModifier implements RecordModifierInterface
{
    public function apply(Record $record): void
    {
        $outputData = $record->getOutputData();
        foreach ($record->getRewriteItems() as $rewrite => $value) {
            [$root, $list, $key] = explode('|', $rewrite);
            $outputData[$root][$list][$key] = $value;
        }

        $record->setOutputData($outputData);
    }
}
