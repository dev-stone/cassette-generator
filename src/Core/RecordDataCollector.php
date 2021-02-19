<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Configuration;
use Vcg\ValueObject\Cassette;
use Vcg\ValueObject\CassettesHolder;
use Vcg\ValueObject\Record;

class RecordDataCollector
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

    public function collect(): array
    {
        $recordDefaultsModel = $this->configuration->getRecordDefaults();
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
                    $recordDefaultCloned = clone $recordDefaultsModel;
                    $record = (new Record())
                        ->setRecordDefaultsModel($recordDefaultCloned)
                        ->setRequestBodyPath($requestBodyPath)
                        ->setResponseBodyPath($responseBodyPath);
                    foreach ($recordModel->getAppendItems() as $key => $value) {
                        $record->addAppendItem($key, $value);
                    }
                    foreach ($recordModel->getRewriteItems() as $key => $value) {
                        $record->addRewriteItem($key, $value);
                    }
                    $cassette->addRecord($record);
                }
            }
        }

        return $this->cassettesHolder;
    }
}
