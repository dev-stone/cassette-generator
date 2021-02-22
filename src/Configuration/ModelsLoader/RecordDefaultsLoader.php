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
    private ConfigReader $configReader;
    private RecordDefaultsModel $recordDefaultsModel;

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
        $this->recordDefaultsModel = new RecordDefaultsModel();
    }

    public function load(): RecordDefaultsModel
    {
        $recordDefaults = $this->configReader->getSettings(Config::RECORD_DEFAULTS);
        $request = $recordDefaults[Config::REQUEST];
        $requestModel = (new RequestModel())
            ->setMethod($request[Config::METHOD])
            ->setUrl($request[Config::URL]);
        foreach ($request[Config::HEADERS] as $key => $value) {
            $requestModel->addHeader($key, $value);
        }

        $responseModel = new ResponseModel();
        $response = $recordDefaults[Config::RESPONSE];
        foreach ($response[Config::STATUS] as $key => $value) {
            $responseModel->addStatus($key, $value);
        }
        foreach ($response[Config::HEADERS] as $key => $value) {
            $responseModel->addHeader($key, $value);
        }

        $this->recordDefaultsModel = (new RecordDefaultsModel())
            ->setRequestModel($requestModel)
            ->setResponseModel($responseModel);

        return $this->recordDefaultsModel;
    }
}
