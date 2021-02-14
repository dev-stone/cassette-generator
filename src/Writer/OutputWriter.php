<?php
declare(strict_types=1);

namespace Acg\Writer;

use Acg\Parser\ParserInterface;

class OutputWriter
{
    private ?string $outputFile = null;
    private ParserInterface $parser;

    public function writeOutput()
    {
        file_put_contents($this->outputFile, $this->parser->parse());
    }

    public function setOutputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    public function setParser(ParserInterface $parser): self
    {
        $this->parser = $parser;

        return $this;
    }
}
