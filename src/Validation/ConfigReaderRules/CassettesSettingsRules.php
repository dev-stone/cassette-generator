<?php
declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\ConfigEnum;

class CassettesSettingsRules extends ConfigReaderRules
{
    public function validate()
    {
        $this->validCassettesSettings();
    }

    private function validCassettesSettings()
    {
        $this->validateFirstLevel(ConfigEnum::CASSETTES_SETTINGS);
        $this->validCassettesHolderAdded();
        $this->validateCassettesHolders();
    }

    private function validCassettesHolderAdded()
    {
        if (0 === count($this->configReaderData[ConfigEnum::CASSETTES_SETTINGS])) {
            throw new \RuntimeException('Should be at least one cassette holder under cassettes-settings.');
        }
    }

    private function validateCassettesHolders()
    {
        foreach ($this->configReaderData[ConfigEnum::CASSETTES_SETTINGS] as $cassetteHolder) {
            $this->validateInputDir($cassetteHolder);
            $this->validateInputDirExist($cassetteHolder);
            $this->validateOutputDir($cassetteHolder);
            $this->validateOutputDirExist($cassetteHolder);
            $this->validateCassettes($cassetteHolder);
            $this->validateCassettesAdded($cassetteHolder);
            $this->validateCassettesItems($cassetteHolder);
        }
    }

    private function validateCassettesItems(array $cassetteHolder)
    {
        foreach ($cassetteHolder[ConfigEnum::CASSETTES] as $cassette) {
            $this->validateCassetteOutputFile($cassette);
            $this->validateCassetteRecords($cassette);
            $this->validateRecordsAdded($cassette);
            $this->validateRecordsItems($cassetteHolder, $cassette);
        }
    }

    private function validateRecordsItems(array $cassetteHolder, array $cassette)
    {
        foreach ($cassette[ConfigEnum::RECORDS] as $record) {
            $this->validateRecordRequest($record);
            $this->validateRecordResponse($record);
            $this->validateRecordAppendKeys($record);
            $this->validateRecordRewriteKeys($record);
            $this->validateRecordRequestFileExist($cassetteHolder, $record);
            $this->validateRecordResponseFileExist($cassetteHolder, $record);
        }
    }

    private function validateInputDir(array $cassetteHolder)
    {
        $this->validateConfigKey(ConfigEnum::INPUT_DIR, $cassetteHolder);
    }

    private function validateInputDirExist(array $cassetteHolder)
    {
        $dir = $cassetteHolder[ConfigEnum::INPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Input directory not exist: %s', $dir));
        }
    }

    private function validateOutputDir(array $cassetteHolder)
    {
        $this->validateConfigKey(ConfigEnum::OUTPUT_DIR, $cassetteHolder);
    }

    private function validateOutputDirExist(array $cassetteHolder)
    {
        $dir = $cassetteHolder[ConfigEnum::OUTPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Output directory not exist: %s', $dir));
        }
    }

    private function validateCassettes(array $cassetteHolder)
    {
        $this->validateConfigKey(ConfigEnum::CASSETTES, $cassetteHolder);
    }

    private function validateCassettesAdded(array $cassetteHolder)
    {
        if (0 === count($cassetteHolder[ConfigEnum::CASSETTES])) {
            throw new \RuntimeException('You should add at least one cassette!');
        }
    }

    private function validateCassetteOutputFile(array $cassette)
    {
        $this->validateConfigKey(ConfigEnum::OUTPUT_FILE, $cassette);
    }

    private function validateCassetteRecords(array $cassette)
    {
        $this->validateConfigKey(ConfigEnum::RECORDS, $cassette);
    }

    private function validateRecordsAdded(array $cassette)
    {
        if (0 === count($cassette[ConfigEnum::RECORDS])) {
            throw new \RuntimeException('You should add at least one record to cassette!');
        }
    }

    private function validateRecordRequest(array $record)
    {
        $this->validateConfigKey(ConfigEnum::REQUEST, $record);
    }

    private function validateRecordResponse(array $record)
    {
        $this->validateConfigKey(ConfigEnum::RESPONSE, $record);
    }

    private function validateRecordAppendKeys(array $record)
    {
        if (!array_key_exists(ConfigEnum::APPEND, $record)) {
            return;
        }

        foreach ($record[ConfigEnum::APPEND] as $key => $value) {
            $applyParts = explode('|', $key);
            if (3 !== count($applyParts)) {
                throw new \RuntimeException('Append key should consist three parts split by pipes!');
            }
        }
    }

    private function validateRecordRewriteKeys(array $record)
    {
        if (!array_key_exists(ConfigEnum::REWRITE, $record)) {
            return;
        }

        foreach ($record[ConfigEnum::REWRITE] as $key => $value) {
            $rewriteParts = explode('|', $key);
            if (3 !== count($rewriteParts)) {
                throw new \RuntimeException('Rewrite key should consist three parts split by pipes');
            }
        }
    }

    private function validateRecordRequestFileExist(array $cassetteHolder, array $record)
    {
        $filePath = $cassetteHolder[ConfigEnum::INPUT_DIR] . $record[ConfigEnum::REQUEST];
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('Record request file not exist: %s', $filePath));
        }
    }

    private function validateRecordResponseFileExist(array $cassetteHolder, array $record)
    {
        $filePath = $cassetteHolder[ConfigEnum::INPUT_DIR] . $record[ConfigEnum::RESPONSE];
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('Record response file not exist: %s', $filePath));
        }
    }

    private function validateConfigKey(string $key, array $data)
    {
        if (!array_key_exists($key, $data)) {
            $message = sprintf('Missing %s when read configuration file.', $key);
            throw new \RuntimeException($message);
        }
    }
}
