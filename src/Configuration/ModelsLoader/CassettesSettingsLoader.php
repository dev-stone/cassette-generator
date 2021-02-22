<?php
declare(strict_types=1);

namespace Vcg\Configuration\ModelsLoader;

use Vcg\Configuration\Config;
use Vcg\Configuration\ConfigReader;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\RecordModel;

class CassettesSettingsLoader
{
    private ConfigReader $configReader;
    /**
     * @var CassettesHolderModel[]
     */
    private array $cassettesSettings = [];

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
    }

    /**
     * @return CassettesHolderModel[]
     */
    public function load(): array
    {
        foreach ($this->configReader->getSettings(Config::CASSETTES_SETTINGS) as $cassettesHolder) {
            $cassettesHolderModel = new CassettesHolderModel();
            $this->cassettesSettings[] = $cassettesHolderModel;

            $cassettesHolderModel
                ->setName($cassettesHolder[Config::NAME])
                ->setInputDir($cassettesHolder[Config::INPUT_DIR])
                ->setOutputDir($cassettesHolder[Config::OUTPUT_DIR]);
            foreach ($cassettesHolder[Config::CASSETTES] as $cassette) {
                $cassetteModel = (new CassetteModel())->setOutputFile($cassette[Config::OUTPUT_FILE]);
                $cassettesHolderModel->addCassetteModel($cassetteModel);

                foreach ($cassette[Config::RECORDS] as $record) {
                    $recordModel = new RecordModel();
                    $cassetteModel->addRecordModel($recordModel);
                    $recordModel
                        ->setRequestBodyPath($record[Config::REQUEST])
                        ->setResponseBodyPath($record[Config::RESPONSE]);

                    if (array_key_exists(Config::APPEND, $record)) {
                        foreach ($record[Config::APPEND] as $key => $value) {
                            $recordModel->addAppendItem($key, $value);
                        }
                    }
                    if (array_key_exists(Config::REWRITE, $record)) {
                        foreach ($record[Config::REWRITE] as $key => $value) {
                            $recordModel->addRewriteItems($key, $value);
                        }
                    }
                }
            }
        }

        return $this->cassettesSettings;
    }
}
