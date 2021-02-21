<?php
declare(strict_types=1);

namespace Vcg\Configuration;

use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RecordModel;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;

class ModelsLoader
{
    private ConfigReader $configReader;
    private RecordDefaultsModel $recordDefaultsModel;
    /**
     * @var CassettesHolderModel[]
     */
    private array $cassettesSettings = [];

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
        $this->recordDefaultsModel = new RecordDefaultsModel();
    }

    public function load(): self
    {
        $this->loadRecordDefaults();
        $this->loadCassettesSettings();

        return $this;
    }

    public function getRecordDefaults(): RecordDefaultsModel
    {
        return $this->recordDefaultsModel;
    }

    /**
     * @return CassettesHolderModel[]
     */
    public function getCassettesSettings(): array
    {
        return $this->cassettesSettings;
    }

    private function loadRecordDefaults(): void
    {
        $recordDefaults = $this->configReader->getSettings('record-defaults');
        $request = $recordDefaults['request'];
        $requestModel = (new RequestModel())
            ->setMethod($request['method'])
            ->setUrl($request['url']);
        foreach ($request['headers'] as $key => $value) {
            $requestModel->addHeader($key, $value);
        }

        $responseModel = new ResponseModel();
        $response = $recordDefaults['response'];
        foreach ($response['status'] as $key => $value) {
            $responseModel->addStatus($key, $value);
        }
        foreach ($response['headers'] as $key => $value) {
            $responseModel->addHeader($key, $value);
        }

        $this->recordDefaultsModel = (new RecordDefaultsModel())
            ->setRequestModel($requestModel)
            ->setResponseModel($responseModel);
    }

    private function loadCassettesSettings(): void
    {
        foreach ($this->configReader->getSettings(Config::CASSETTES_SETTINGS) as $cassettesHolder) {
            $cassettesHolderModel = new CassettesHolderModel();
            $this->cassettesSettings[] = $cassettesHolderModel;

            $cassettesHolderModel
                ->setName($cassettesHolder['name'])
                ->setInputDir($cassettesHolder['input-dir'])
                ->setOutputDir($cassettesHolder['output-dir']);
            foreach ($cassettesHolder['cassettes'] as $cassette) {
                $cassetteModel = (new CassetteModel())->setOutputFile($cassette['output-file']);
                $cassettesHolderModel->addCassetteModel($cassetteModel);

                foreach ($cassette['records'] as $record) {
                    $recordModel = new RecordModel();
                    $cassetteModel->addRecordModel($recordModel);
                    $recordModel
                        ->setRequestBodyPath($record['request'])
                        ->setResponseBodyPath($record['response']);
                    foreach ($record['append'] as $key => $value) {
                        $recordModel->addAppendItem($key, $value);
                    }
                    foreach ($record['rewrite'] as $key => $value) {
                        $recordModel->addRewriteItems($key, $value);
                    }
                }
            }
        }
    }
}
