<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

use Vcg\ValueObject\Record;

interface RecordModifierInterface
{
    public function apply(Record $record): void;
}
