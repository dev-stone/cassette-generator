<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Configuration;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RecordModel;
use Vcg\ValueObject\Cassette;
use Vcg\ValueObject\CassetteHolderList;
use Vcg\ValueObject\CassettesHolder;
use Vcg\ValueObject\Record;

class RecordDataCollector
{
    private Configuration $configuration;
    private CassetteHolderList $cassettesHolderList;
    private RecordDefaultsModel $recordDefaultsModel;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function collect(): CassetteHolderList
    {
        $this->recordDefaultsModel = $this->configuration->getRecordDefaults();
        $this->cassettesHolderList = new CassetteHolderList();
        foreach ($this->configuration->getCassettesHolderModelList() as $cassettesHolderModel) {
            $this->processCassettesHolderModel($cassettesHolderModel);
        }

        return $this->cassettesHolderList;
    }

    private function processCassettesHolderModel(CassettesHolderModel $cassettesHolderModel): void
    {
        $cassettesHolder = new CassettesHolder();
        $this->cassettesHolderList->add($cassettesHolder);
        foreach ($cassettesHolderModel->getCassettesModels() as $cassetteModel) {
            $this->processCassetteModel($cassettesHolderModel, $cassetteModel, $cassettesHolder);
        }
    }

    private function processCassetteModel(
        CassettesHolderModel $cassettesHolderModel,
        CassetteModel $cassetteModel,
        CassettesHolder $cassettesHolder
    ): void {
        $outputPath = $cassettesHolderModel->getOutputDir() . $cassetteModel->getOutputFile();
        $cassette = (new Cassette())->setOutputPath($outputPath);
        $cassettesHolder->addCassette($cassette);

        foreach ($cassetteModel->getRecordsModels() as $recordModel) {
            $this->processRecordModel($cassettesHolderModel, $recordModel, $cassette);
        }
    }

    private function processRecordModel(
        CassettesHolderModel $cassettesHolderModel,
        RecordModel $recordModel,
        Cassette $cassette
    ): void {
        $requestBodyPath = $cassettesHolderModel->getInputDir() . $recordModel->getRequestBodyPath();
        $responseBodyPath = $cassettesHolderModel->getInputDir() . $recordModel->getResponseBodyPath();
        $recordDefaultCloned = clone $this->recordDefaultsModel;
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
