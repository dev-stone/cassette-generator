<?php
declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\Config;

class CassettesSettingsRules extends ConfigReaderRules
{
    public function validate()
    {
        $this->validCassettesSettings();
    }

    private function validCassettesSettings()
    {
        $this->validateFirstLevel(Config::CASSETTES_SETTINGS);
        $this->validCassettesHolderAdded();
        $this->validateCassettesHolders();
    }

    private function validCassettesHolderAdded()
    {
        if (0 === count($this->configReaderData[Config::CASSETTES_SETTINGS])) {
            throw new \RuntimeException('Should be at least one cassette holder under cassettes-settings.');
        }
    }

    private function validateCassettesHolders()
    {
        foreach ($this->configReaderData[Config::CASSETTES_SETTINGS] as $cassetteHolder) {
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
        foreach ($cassetteHolder[Config::CASSETTES] as $cassette) {
            $this->validateCassetteOutputFile($cassette);
            $this->validateCassetteRecords($cassette);
            $this->validateRecordsAdded($cassette);
            $this->validateRecordsItems($cassetteHolder, $cassette);
        }
    }

    private function validateRecordsItems(array $cassetteHolder, array $cassette)
    {
        foreach ($cassette[Config::RECORDS] as $record) {
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
        $this->validateConfigKey(Config::INPUT_DIR, $cassetteHolder);
    }

    private function validateInputDirExist(array $cassetteHolder)
    {
        $dir = $cassetteHolder[Config::INPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Input directory not exist: %s', $dir));
        }
    }

    private function validateOutputDir(array $cassetteHolder)
    {
        $this->validateConfigKey(Config::OUTPUT_DIR, $cassetteHolder);
    }

    private function validateOutputDirExist(array $cassetteHolder)
    {
        $dir = $cassetteHolder[Config::OUTPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Output directory not exist: %s', $dir));
        }
    }

    private function validateCassettes(array $cassetteHolder)
    {
        $this->validateConfigKey(Config::CASSETTES, $cassetteHolder);
    }

    private function validateCassettesAdded(array $cassetteHolder)
    {
        if (0 === count($cassetteHolder[Config::CASSETTES])) {
            throw new \RuntimeException('You should add at least one cassette!');
        }
    }

    private function validateCassetteOutputFile(array $cassette)
    {
        $this->validateConfigKey(Config::OUTPUT_FILE, $cassette);
    }

    private function validateCassetteRecords(array $cassette)
    {
        $this->validateConfigKey(Config::RECORDS, $cassette);
    }

    private function validateRecordsAdded(array $cassette)
    {
        if (0 === count($cassette[Config::RECORDS])) {
            throw new \RuntimeException('You should add at least one record to cassette!');
        }
    }

    private function validateRecordRequest(array $record)
    {
        $this->validateConfigKey(Config::REQUEST, $record);
    }

    private function validateRecordResponse(array $record)
    {
        $this->validateConfigKey(Config::RESPONSE, $record);
    }

    private function validateRecordAppendKeys(array $record)
    {
        if (!array_key_exists(Config::APPEND, $record)) {
            return;
        }

        foreach ($record[Config::APPEND] as $key => $value) {
            $applyParts = explode('|', $key);
            if (3 !== count($applyParts)) {
                throw new \RuntimeException('Append key should consist three parts split by pipes!');
            }
        }
    }

    private function validateRecordRewriteKeys(array $record)
    {
        if (!array_key_exists(Config::REWRITE, $record)) {
            return;
        }

        foreach ($record[Config::REWRITE] as $key => $value) {
            $rewriteParts = explode('|', $key);
            if (3 !== count($rewriteParts)) {
                throw new \RuntimeException('Rewrite key should consist three parts split by pipes');
            }
        }
    }

    private function validateRecordRequestFileExist(array $cassetteHolder, array $record)
    {
        $filePath = $cassetteHolder[Config::INPUT_DIR] . $record[Config::REQUEST];
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('Record request file not exist: %s', $filePath));
        }
    }

    private function validateRecordResponseFileExist(array $cassetteHolder, array $record)
    {
        $filePath = $cassetteHolder[Config::INPUT_DIR] . $record[Config::RESPONSE];
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
