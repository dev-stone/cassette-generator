<?php
declare(strict_types=1);

namespace Vcg\ValueObject;

class CassetteOutput
{
    private string $outputPath;
    private string $outputString;

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }

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
