<?php
declare(strict_types=1);

namespace Acg;

class OutputWriter
{
    private ?string $outputFile = null;
    private Frame $frame;

    public function writeOutput()
    {
        file_put_contents($this->outputFile, $this->frame->yaml());
    }

    public function setOutputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    public function setFrame(Frame $frame): self
    {
        $this->frame = $frame;

        return $this;
    }
}
