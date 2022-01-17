<?php
declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\Configuration\ConfigEnum;
use Vcg\ValueObject\Record;

class ResponseBodyModifier extends BodyModifier
{
    public function apply(Record $record): void
    {
        $xmlContent = file_get_contents($record->getResponseBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);

        $xmlContent = '\'' . $xmlContent . '\'';

        $outputData = $record->getOutputData();
        $outputData[ConfigEnum::RESPONSE][ConfigEnum::BODY] = $xmlContent;
        $record->setOutputData($outputData);
    }
}
