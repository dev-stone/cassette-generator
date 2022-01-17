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
            $cassettesHolderModel = new CassettesHolderModel();
            $this->cassettesHolderModelsList->add($cassettesHolderModel);

            $cassettesHolderModel
                ->setName($cassettesHolder[ConfigEnum::NAME])
                ->setInputDir($cassettesHolder[ConfigEnum::INPUT_DIR])
                ->setOutputDir($cassettesHolder[ConfigEnum::OUTPUT_DIR]);
            foreach ($cassettesHolder[ConfigEnum::CASSETTES] as $cassette) {
                $cassetteModel = (new CassetteModel())->setOutputFile($cassette[ConfigEnum::OUTPUT_FILE]);
                $cassettesHolderModel->addCassetteModel($cassetteModel);

                foreach ($cassette[ConfigEnum::RECORDS] as $record) {
                    $recordModel = new RecordModel();
                    $cassetteModel->addRecordModel($recordModel);
                    $recordModel
                        ->setRequestBodyPath($record[ConfigEnum::REQUEST])
                        ->setResponseBodyPath($record[ConfigEnum::RESPONSE]);

                    if (array_key_exists(ConfigEnum::APPEND, $record)) {
                        foreach ($record[ConfigEnum::APPEND] as $key => $value) {
                            $recordModel->addAppendItem($key, $value);
                        }
                    }
                    if (array_key_exists(ConfigEnum::REWRITE, $record)) {
                        foreach ($record[ConfigEnum::REWRITE] as $key => $value) {
                            $recordModel->addRewriteItems($key, $value);
                        }
                    }
                }
            }
        }

        return $this->cassettesHolderModelsList;
    }
}
