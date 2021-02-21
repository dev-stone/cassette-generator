<?php
declare(strict_types=1);

namespace Vcg\Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\ConfigReader;
use Vcg\Exception\DirectoryNotExistException;
use Vcg\Exception\MissingConfigItemException;
use Vcg\Exception\NoCassetteAddedException;
use Vcg\Exception\NoRecordsAddedException;
use Vcg\Exception\RecordAppendKeyException;
use Vcg\Exception\RecordRewriteKeyException;
use Vcg\Validation\ConfigReaderValidator;

class ConfigReaderValidatorTest extends TestCase
{
    private array $configReaderData;

    public function testRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']);
        $this->validateConfigReaderData();
    }

    public function testRequestRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['request']);
        $this->validateConfigReaderData();
    }

    public function testMethodRequestRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['request']['method']);
        $this->validateConfigReaderData();
    }

    public function testUrlRequestRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['request']['url']);
        $this->validateConfigReaderData();
    }

    public function testHeadersRequestRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['request']['headers']);
        $this->validateConfigReaderData();
    }

    public function testResponseRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['response']);
        $this->validateConfigReaderData();
    }

    public function testStatusResponseRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['response']['status']);
        $this->validateConfigReaderData();
    }

    public function testHeadersResponseRecordDefaultValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['record-defaults']['response']['headers']);
        $this->validateConfigReaderData();
    }

    public function testCassettesSettingsValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersAddedValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersInputDirValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['input-dir']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersInputDirExistValidation()
    {
        $this->expectException(DirectoryNotExistException::class);
        $this->configReaderData['cassettes-settings'][0]['input-dir'] = '/not/exist/dir';
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersOutputDirValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['output-dir']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersOutputDirExistValidation()
    {
        $this->expectException(DirectoryNotExistException::class);
        $this->configReaderData['cassettes-settings'][0]['output-dir'] = '/not/exist/dir';
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersCassettesValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes']);
        $this->validateConfigReaderData();
    }

    public function testCassettesHoldersCassettesAddedValidation()
    {
        $this->expectException(NoCassetteAddedException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]);
        $this->validateConfigReaderData();
    }

    public function testCassetteOutputFileValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['output-file']);
        $this->validateConfigReaderData();
    }

    public function testCassetteRecordsValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records']);
        $this->validateConfigReaderData();
    }

    public function testCassetteRecordsAddedValidation()
    {
        $this->expectException(NoRecordsAddedException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]);
        $this->validateConfigReaderData();
    }

    public function testRecordRequestValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['request']);
        $this->validateConfigReaderData();
    }

    public function testRecordResponseValidation()
    {
        $this->expectException(MissingConfigItemException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['response']);
        $this->validateConfigReaderData();
    }

    public function testRecordAppendValidation()
    {
        $this->expectException(RecordAppendKeyException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][0]['append']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['append']);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['append']['request|headers'] = 'value';
        $this->validateConfigReaderData();
    }

    public function testRecordRewriteValidation()
    {
        $this->expectException(RecordRewriteKeyException::class);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][0]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][0]['records'][1]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][0]['rewrite']);
        unset($this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['rewrite']);
        $this->configReaderData['cassettes-settings'][0]['cassettes'][1]['records'][1]['rewrite']['request|headers'] = 'value';
        $this->validateConfigReaderData();
    }

    protected function setUp(): void
    {
        $configReader =  new ConfigReader(__DIR__ . '/../../data/vcg_config.yaml');
        $this->configReaderData = $configReader->getConfigData();
    }

    private function validateConfigReaderData()
    {
        $configReader = $this->createConfigReaderMock($this->configReaderData);
        $configReaderValidator = new ConfigReaderValidator($configReader);
        $configReaderValidator->validate();
    }

    private function createConfigReaderMock(array $configData)
    {
        $configReader = $this->createMock(ConfigReader::class);
        $configReader->method('getConfigData')->willReturn($configData);

        return $configReader;
    }
}
