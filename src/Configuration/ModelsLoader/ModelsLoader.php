<?php

declare(strict_types=1);

namespace Vcg\Configuration\ModelsLoader;

use Vcg\Configuration\ConfigReader;
use Vcg\Configuration\Model\CassettesHolderModelList;
use Vcg\Configuration\Model\RecordDefaultsModel;

class ModelsLoader
{
    private RecordDefaultsLoader $recordDefaultLoader;
    private CassettesSettingsLoader $cassettesSettingsLoader;
    private RecordDefaultsModel $recordDefaultsModel;
    private CassettesHolderModelList $cassettesSettings;

    public function __construct(ConfigReader $configReader)
    {
        $this->recordDefaultLoader = new RecordDefaultsLoader($configReader);
        $this->cassettesSettingsLoader = new CassettesSettingsLoader($configReader);
    }

    public function load(): self
    {
        $this->recordDefaultsModel = $this->recordDefaultLoader->load();
        $this->cassettesSettings = $this->cassettesSettingsLoader->load();

        return $this;
    }

    public function getRecordDefaults(): RecordDefaultsModel
    {
        return $this->recordDefaultsModel;
    }

    public function getCassettesSettings(): CassettesHolderModelList
    {
        return $this->cassettesSettings;
    }
}
