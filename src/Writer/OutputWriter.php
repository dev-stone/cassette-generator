<?php
declare(strict_types=1);

namespace Vcg\Writer;

use Vcg\Parser\ParserInterface;

class OutputWriter
{
    private ParserInterface $parser;
    private ?string $outputFile = null;

    public function writeOutput()
    {
        $data = $this->parser->parse();
        file_put_contents($this->outputFile, $data);
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
