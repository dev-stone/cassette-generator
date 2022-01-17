<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Validation;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vcg\Configuration\ConfigReader;
use Vcg\Validation\ConfigReaderValidator;

class ConfigReaderValidatorTest extends TestCase
{
    private array $configReaderData;

    public function testRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']);
        $this->validateConfigReaderData();
    }

    public function testRequestRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['request']);
        $this->validateConfigReaderData();
    }

    public function testMethodRequestRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['request']['method']);
        $this->validateConfigReaderData();
    }

    public function testUrlRequestRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['request']['url']);
        $this->validateConfigReaderData();
    }

    public function testHeadersRequestRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['request']['headers']);
        $this->validateConfigReaderData();
    }

    public function testResponseRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['response']);
        $this->validateConfigReaderData();
    }

    public function testStatusResponseRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['response']['status']);
        $this->validateConfigReaderData();
    }

    public function testHeadersResponseRecordDefaultValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['record-defaults']['response']['headers']);
        $this->validateConfigReaderData();
    }

    public function testCassettesSettingsValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersAddedValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersInputDirValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['input-dir']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersInputDirExistValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->configReaderData['cassettes-settings'][0]['input-dir'] = '/not/exist/dir';
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersOutputDirValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['output-dir']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersOutputDirExistValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->configReaderData['cassettes-settings'][0]['output-dir'] = '/not/exist/dir';
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersCassettesValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersCassettesAddedValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]);
        $this->validateConfigReaderData();
    }

    public function testCassetteOutputFileValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['output-file']);
        $this->validateConfigReaderData();
    }

    public function testCassetteRecordsValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records']);
        $this->validateConfigReaderData();
    }

    public function testCassetteRecordsAddedValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]);
        $this->validateConfigReaderData();
    }

    public function testRecordRequestValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['request']);
        $this->validateConfigReaderData();
    }

    public function testRecordResponseValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['response']);
        $this->validateConfigReaderData();
    }

    public function testRecordAppendValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][0]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['append']);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['append']['request|headers'] = 'value';
        $this->validateConfigReaderData();
    }

    public function testRecordRewriteValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][0]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['rewrite']);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['rewrite']['request|headers'] = 'value';
        $this->validateConfigReaderData();
    }

    public function testRecordRequestFileExistValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['request'] = 'not-exist.xml';
        $this->validateConfigReaderData();
    }

    public function testRecordResponseFileExistValidation(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['response'] = 'not-exist.xml';
        $this->validateConfigReaderData();
    }

    protected function setUp(): void
    {
        $configReader =  new ConfigReader(__DIR__ . '/../../data/vcg_config.yaml');
        $this->configReaderData = $configReader->getConfigData();
    }

    private function validateConfigReaderData(): void
    {
        $configReader = $this->createConfigReaderMock($this->configReaderData);
        $configReaderValidator = new ConfigReaderValidator($configReader);
        $configReaderValidator->validate();
    }

    /**
     * @param array $configData
     * @return MockObject|ConfigReader
     */
    private function createConfigReaderMock(array $configData)
    {
        $configReader = $this->createMock(ConfigReader::class);
        $configReader->method('getConfigData')->willReturn($configData);

        return $configReader;
    }
}
