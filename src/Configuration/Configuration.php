<?php
declare(strict_types=1);

namespace Vcg\Configuration;

use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\ModelsLoader;
use Vcg\Configuration\Model\RecordDefaultsModel;

class Configuration
{
    private RawConfig $rawConfig;
    private RecordDefaultsModel $recordDefaults;
    /**
     * @var CassettesHolderModel[]
     */
    private array $cassettesSettings;

    public function __construct(string $configPath)
    {
        $this->rawConfig = new RawConfig($configPath);
        $modelsLoader = (new ModelsLoader($this->rawConfig))->load();
        $this->recordDefaults = $modelsLoader->getRecordDefaults();
        $this->cassettesSettings = $modelsLoader->getCassettesSettings();
    }

    /**
     * @return RawConfig
     */
    public function getRawConfig(): RawConfig
    {
        return $this->rawConfig;
    }

    /**
     * @return RecordDefaultsModel
     */
    public function getRecordDefaults(): RecordDefaultsModel
    {
        return $this->recordDefaults;
    }

    /**
     * @return CassettesHolderModel[]
     */
    public function getCassettesSettings(): array
    {
        return $this->cassettesSettings;
    }
}
