<?php
declare(strict_types=1);

namespace Vcg\Maker;

use Vcg\Configuration\Configuration;

class Maker
{
    private Configuration $configuration;
    /**
     * @var CassettesHolder[]
     */
    private array $cassettesHolder;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function make()
    {
        foreach ($this->configuration->getCassettesSettings() as $cassettesHolderModel) {
            $cassettesHolder = new CassettesHolder();
            $this->cassettesHolder[] = $cassettesHolder;
            foreach ($cassettesHolderModel->getCassettesModels() as $cassetteModel) {
                $outputPath = $cassettesHolderModel->getOutputDir() . $cassetteModel->getOutputFile();
                $cassette = (new Cassette())->setOutputPath($outputPath);
                $cassettesHolder->addCassette($cassette);

                foreach ($cassetteModel->getRecordsModels() as $recordModel) {
                    $requestBodyPath = $cassettesHolderModel->getInputDir() . $recordModel->getRequestBodyPath();
                    $responseBodyPath = $cassettesHolderModel->getInputDir() . $recordModel->getResponseBodyPath();
                    $record = (new Record())
                        ->setRequestBodyPath($requestBodyPath)
                        ->setResponseBodyPath($responseBodyPath);
                    $cassette->addRecord($record);
                }
            }
        }
    }

    public function getCassettesHolders(): array
    {
        return $this->cassettesHolder;
    }
}
