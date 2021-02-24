<?php
declare(strict_types=1);

namespace Vcg\Configuration;

use Vcg\Configuration\Model\CassettesHolderModelList;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\ModelsLoader\ModelsLoader;
use Vcg\Validation\ConfigReaderValidator;

class Configuration
{
    private CassettesHolderModelList $cassettesHolderModelList;
    private RecordDefaultsModel $recordDefaults;

    public function __construct(string $configPath)
    {
        $configReader = new ConfigReader($configPath);
        (new ConfigReaderValidator($configReader))->validate();
        $modelsLoader = (new ModelsLoader($configReader))->load();
        $this->recordDefaults = $modelsLoader->getRecordDefaults();
        $this->cassettesHolderModelList = $modelsLoader->getCassettesSettings();
    }

    public function getRecordDefaults(): RecordDefaultsModel
    {
        return $this->recordDefaults;
    }

    public function getCassettesHolderModelList(): CassettesHolderModelList
    {
        return $this->cassettesHolderModelList;
    }
}
