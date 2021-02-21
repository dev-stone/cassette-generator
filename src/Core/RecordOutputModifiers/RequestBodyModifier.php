<?php
declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\Configuration\Config;
use Vcg\ValueObject\Record;

class RequestBodyModifier extends BodyModifier
{
    public function apply(Record $record): void
    {
        $xmlContent = file_get_contents($record->getRequestBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);

        $xmlContent = str_replace('"', '\"', $xmlContent);
        $xmlContent = $xmlContent . '\n';
        $xmlContent = '"' . $xmlContent . '"';

        $outputData = $record->getOutputData();
        $outputData[Config::REQUEST][Config::BODY] = $xmlContent;
        $record->setOutputData($outputData);
    }
}
