<?php

declare(strict_types=1);

namespace Vcg\Configuration\Model;

class CassetteModel
{
    private string $outputFile;
    /**
     * @var RecordModel[]
     */
    private array $recordsModels = [];

    public function getOutputFile(): string
    {
        return $this->outputFile;
    }

    public function setOutputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    public function getRecordsModels(): array
    {
        return $this->recordsModels;
    }

    public function addRecordModel(RecordModel $recordModel): self
    {
        $this->recordsModels[] = $recordModel;

        return $this;
    }
}
