<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

class CassettesHolderModel
{
    private string $name;
    private string $inputDir;
    private string $outputDir;
    /**
     * @var CassetteModel[]
     */
    private array $cassettesModels = [];

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInputDir(): string
    {
        return $this->inputDir;
    }

    public function setInputDir(string $inputDir): self
    {
        $this->inputDir = $inputDir;

        return $this;
    }

    public function getOutputDir(): string
    {
        return $this->outputDir;
    }

    public function setOutputDir(string $outputDir): self
    {
        $this->outputDir = $outputDir;

        return $this;
    }

    public function getCassettesModels(): array
    {
        return $this->cassettesModels;
    }

    public function addCassetteModel(CassetteModel $cassetteModel): self
    {
        $this->cassettesModels[] = $cassetteModel;

        return $this;
    }
}
