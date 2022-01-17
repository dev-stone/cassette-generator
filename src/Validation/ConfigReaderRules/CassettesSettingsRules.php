<?php

declare(strict_types=1);

namespace Vcg\Validation\ConfigReaderRules;

use Vcg\Configuration\ConfigEnum;

class CassettesSettingsRules extends ConfigReaderRules
{
    public function validate(): void
    {
        $this->validCassettesSettings();
    }

    private function validCassettesSettings(): void
    {
        $this->validateFirstLevel(ConfigEnum::CASSETTES_SETTINGS);
        $this->validCassettesHolderAdded();
        $this->validateCassettesHolders();
    }

    private function validCassettesHolderAdded(): void
    {
        if (0 === count($this->configReaderData[ConfigEnum::CASSETTES_SETTINGS])) {
            throw new \RuntimeException('Should be at least one cassette holder under cassettes-settings.');
        }
    }

    private function validateCassettesHolders(): void
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

    private function validateCassettesItems(array $cassetteHolder): void
    {
        foreach ($cassetteHolder[ConfigEnum::CASSETTES] as $cassette) {
            $this->validateCassetteOutputFile($cassette);
            $this->validateCassetteRecords($cassette);
            $this->validateRecordsAdded($cassette);
            $this->validateRecordsItems($cassetteHolder, $cassette);
        }
    }

    private function validateRecordsItems(array $cassetteHolder, array $cassette): void
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

    private function validateInputDir(array $cassetteHolder): void
    {
        $this->validateConfigKey(ConfigEnum::INPUT_DIR, $cassetteHolder);
    }

    private function validateInputDirExist(array $cassetteHolder): void
    {
        $dir = $cassetteHolder[ConfigEnum::INPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Input directory not exist: %s', $dir));
        }
    }

    private function validateOutputDir(array $cassetteHolder): void
    {
        $this->validateConfigKey(ConfigEnum::OUTPUT_DIR, $cassetteHolder);
    }

    private function validateOutputDirExist(array $cassetteHolder): void
    {
        $dir = $cassetteHolder[ConfigEnum::OUTPUT_DIR];
        if (!file_exists($dir)) {
            throw new \RuntimeException(sprintf('Output directory not exist: %s', $dir));
        }
    }

    private function validateCassettes(array $cassetteHolder): void
    {
        $this->validateConfigKey(ConfigEnum::CASSETTES, $cassetteHolder);
    }

    private function validateCassettesAdded(array $cassetteHolder): void
    {
        if (0 === count($cassetteHolder[ConfigEnum::CASSETTES])) {
            throw new \RuntimeException('You should add at least one cassette!');
        }
    }

    private function validateCassetteOutputFile(array $cassette): void
    {
        $this->validateConfigKey(ConfigEnum::OUTPUT_FILE, $cassette);
    }

    private function validateCassetteRecords(array $cassette): void
    {
        $this->validateConfigKey(ConfigEnum::RECORDS, $cassette);
    }

    private function validateRecordsAdded(array $cassette): void
    {
        if (0 === count($cassette[ConfigEnum::RECORDS])) {
            throw new \RuntimeException('You should add at least one record to cassette!');
        }
    }

    private function validateRecordRequest(array $record): void
    {
        $this->validateConfigKey(ConfigEnum::REQUEST, $record);
    }

    private function validateRecordResponse(array $record): void
    {
        $this->validateConfigKey(ConfigEnum::RESPONSE, $record);
    }

    private function validateRecordAppendKeys(array $record): void
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

    private function validateRecordRewriteKeys(array $record): void
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

    private function validateRecordRequestFileExist(array $cassetteHolder, array $record): void
    {
        $filePath = $cassetteHolder[ConfigEnum::INPUT_DIR] . $record[ConfigEnum::REQUEST];
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('Record request file not exist: %s', $filePath));
        }
    }

    private function validateRecordResponseFileExist(array $cassetteHolder, array $record): void
    {
        $filePath = $cassetteHolder[ConfigEnum::INPUT_DIR] . $record[ConfigEnum::RESPONSE];
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('Record response file not exist: %s', $filePath));
        }
    }

    private function validateConfigKey(string $key, array $data): void
    {
        if (!array_key_exists($key, $data)) {
            $message = sprintf('Missing %s when read configuration file.', $key);
            throw new \RuntimeException($message);
        }
    }
}
