<?php

declare(strict_types=1);

namespace Vcg\Configuration\ModelsLoader;

use Vcg\Configuration\ConfigEnum;
use Vcg\Configuration\ConfigReader;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\CassettesHolderModelList;
use Vcg\Configuration\Model\RecordModel;

class CassettesSettingsLoader
{
    private ConfigReader $configReader;
    private CassettesHolderModelList $cassettesHolderModelsList;

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
    }

    public function load(): CassettesHolderModelList
    {
        $this->cassettesHolderModelsList = new CassettesHolderModelList();

        foreach ($this->configReader->getSettings(ConfigEnum::CASSETTES_SETTINGS) as $cassettesHolder) {
            $this->processCassettesHolder($cassettesHolder);
        }

        return $this->cassettesHolderModelsList;
    }

    private function processCassettesHolder(array $cassettesHolder): void
    {
        $cassettesHolderModel = new CassettesHolderModel();
        $this->cassettesHolderModelsList->add($cassettesHolderModel);

        $cassettesHolderModel
            ->setName($cassettesHolder[ConfigEnum::NAME])
            ->setInputDir($cassettesHolder[ConfigEnum::INPUT_DIR])
            ->setOutputDir($cassettesHolder[ConfigEnum::OUTPUT_DIR]);

        foreach ($cassettesHolder[ConfigEnum::CASSETTES] as $cassette) {
            $this->processCassette($cassettesHolderModel, $cassette);
        }
    }

    private function processCassette(CassettesHolderModel $cassettesHolderModel, array $cassette): void
    {
        $cassetteModel = (new CassetteModel())->setOutputFile($cassette[ConfigEnum::OUTPUT_FILE]);
        $cassettesHolderModel->addCassetteModel($cassetteModel);

        foreach ($cassette[ConfigEnum::RECORDS] as $record) {
            $this->processRecord($cassetteModel, $record);
        }
    }

    private function processRecord(CassetteModel $cassetteModel, array $record): void
    {
        $recordModel = new RecordModel();
        $cassetteModel->addRecordModel($recordModel);
        $recordModel
            ->setRequestBodyPath($record[ConfigEnum::REQUEST])
            ->setResponseBodyPath($record[ConfigEnum::RESPONSE]);

        $this->addAppendItems($recordModel, $record);
        $this->addRewriteItems($recordModel, $record);
        $this->addReplaceItems($recordModel, $record);
    }

    private function addAppendItems(RecordModel $recordModel, array $record): void
    {
        if (!array_key_exists(ConfigEnum::APPEND, $record)) {
            return;
        }

        foreach ($record[ConfigEnum::APPEND] as $key => $value) {
            $recordModel->addAppendItem($key, $value);
        }
    }

    private function addRewriteItems(RecordModel $recordModel, array $record): void
    {
        if (!array_key_exists(ConfigEnum::REWRITE, $record)) {
            return;
        }

        foreach ($record[ConfigEnum::REWRITE] as $key => $value) {
            $recordModel->addRewriteItems($key, $value);
        }
    }

    private function addReplaceItems(RecordModel $recordModel, array $record): void
    {
        if (!array_key_exists(ConfigEnum::REPLACE, $record)) {
            return;
        }

        foreach ($record[ConfigEnum::REPLACE] as $key => $value) {
            $recordModel->addReplaceItems($key, $value);
        }
    }
}
