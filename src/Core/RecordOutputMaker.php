<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Core\RecordOutputModifiers\AppendModifier;
use Vcg\Core\RecordOutputModifiers\OutputDataCreator;
use Vcg\Core\RecordOutputModifiers\RecordModifierInterface;
use Vcg\Core\RecordOutputModifiers\ReplaceModifier;
use Vcg\Core\RecordOutputModifiers\RequestBodyModifier;
use Vcg\Core\RecordOutputModifiers\ResponseBodyModifier;
use Vcg\Core\RecordOutputModifiers\RewriteModifier;
use Vcg\ValueObject\Record;

class RecordOutputMaker
{
    /**
     * @var RecordModifierInterface[]
     */
    private array $recordsModifiersList;
    private OutputDataCreator $outputDataCreator;

    public function __construct()
    {
        $this->outputDataCreator = new OutputDataCreator();
        $this->recordsModifiersList = [
            new AppendModifier(),
            new RewriteModifier(),
            new RequestBodyModifier(),
            new ResponseBodyModifier(),
            new ReplaceModifier(),
        ];
    }

    public function make(Record $record): self
    {
        $this->outputDataCreator->makeOutputData($record);
        $this->applyModifiers($record);

        return $this;
    }

    private function applyModifiers(Record $record): void
    {
        foreach ($this->recordsModifiersList as $modifier) {
            $modifier->apply($record);
        }
    }
}
