<?php
declare(strict_types=1);

namespace Vcg\Maker;

class Cassette
{
    private string $outputPath;
    /**
     * @var Record[]
     */
    private array $records;

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function setOutputPath(string $outputPath): self
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    /**
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    public function addRecord(Record $record): self
    {
        $this->records[] = $record;

        return $this;
    }
}
