<?php
declare(strict_types=1);

namespace Vcg\CassettesHolder;

class Record
{
    private string $outputString;

    public function getOutputString(): string
    {
        return $this->outputString;
    }

    public function setOutputString(string $outputString): self
    {
        $this->outputString = $outputString;

        return $this;
    }
}
