<?php
declare(strict_types=1);

namespace Vcg\Configuration;

use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Validation\ConfigReaderValidator;

class Configuration
{
    /**
     * @var CassettesHolderModel[]
     */
    private array $cassettesSettings;
    private RecordDefaultsModel $recordDefaults;

    public function __construct(string $configPath)
    {
        $configReader = new ConfigReader($configPath);
        (new ConfigReaderValidator($configReader))->validate();
        $modelsLoader = (new ModelsLoader($configReader))->load();
        $this->recordDefaults = $modelsLoader->getRecordDefaults();
        $this->cassettesSettings = $modelsLoader->getCassettesSettings();
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
