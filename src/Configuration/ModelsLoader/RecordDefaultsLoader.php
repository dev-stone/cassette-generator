<?php
declare(strict_types=1);

namespace Vcg\Configuration\ModelsLoader;

use Vcg\Configuration\Config;
use Vcg\Configuration\ConfigReader;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;

class RecordDefaultsLoader
{
    private RecordDefaultsModel $recordDefaultsModel;
    private array $settingsRecordDefaults;

    public function __construct(ConfigReader $configReader)
    {
        $this->settingsRecordDefaults = $configReader->getSettings(Config::RECORD_DEFAULTS);
    }

    public function load(): RecordDefaultsModel
    {
        $this->recordDefaultsModel = new RecordDefaultsModel();

        $this->loadRequestModel();
        $this->loadResponseModel();

        return $this->recordDefaultsModel;
    }

    private function loadRequestModel()
    {
        $request = $this->settingsRecordDefaults[Config::REQUEST];
        $requestModel = (new RequestModel())
            ->setMethod($request[Config::METHOD])
            ->setUrl($request[Config::URL]);
        foreach ($request[Config::HEADERS] as $key => $value) {
            $requestModel->addHeader($key, $value);
        }
        $this->recordDefaultsModel->setRequestModel($requestModel);
    }

    private function loadResponseModel(): void
    {
        $responseModel = new ResponseModel();
        $response = $this->settingsRecordDefaults[Config::RESPONSE];
        foreach ($response[Config::STATUS] as $key => $value) {
            $responseModel->addStatus($key, $value);
        }
        foreach ($response[Config::HEADERS] as $key => $value) {
            $responseModel->addHeader($key, $value);
        }

        $this->recordDefaultsModel->setResponseModel($responseModel);
    }
}
