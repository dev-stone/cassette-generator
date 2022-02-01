<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Configuration;
use Vcg\Tests\Unit\VcgConfigFactory;
use Vcg\ValueObject\Record;
use Vcg\Core\RecordOutputMaker;

class RecordVcgOutputMakerTest extends TestCase
{
    private Configuration $configuration;

    protected function setUp(): void
    {
        $this->configuration = VcgConfigFactory::createConfiguration();
    }

    public function testRecordMaker(): void
    {
        $record = $this->createRecord();
        $recordMaker = new RecordOutputMaker();
        $recordMaker->make($record);

        $expected = $this->expectedRecord();
        $this->assertEquals($expected, $record);
    }

    private function expectedRecord(): Record
    {
        $record = $this->createRecord();

        return $record->setOutputData($this->expectedOutputData());
    }

    private function createRecord(): Record
    {
        $recordDefaultsModel = $this->configuration->getRecordDefaults();

        return (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesInput/find_user_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesInput/find_user_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser');
    }

    private function expectedOutputData(): array
    {
        return [
            'request' => [
                'method' => 'POST',
                'url' => "'http://127.0.0.1:8080/soap'",
                'headers' => [
                    'Host' => "'127.0.0.1:8080'",
                    'Content-Type' => "'text/xml; charset=utf-8;'",
                    'SOAPAction' => "'http://tempuri.org/IAppService/FindUser'"
                ],
                'body' => '"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://tempuri.org/\"><SOAP-ENV:Body><ns1:FindUser><ns1:User>test@example.com</ns1:User></ns1:FindUser></SOAP-ENV:Body></SOAP-ENV:Envelope>\n"'
            ],
            'response' => [
                'status' => [
                    'http_version' => "'1.1'",
                    'code' => "'200'",
                    'message' => 'OK',
                ],
                'headers' => [
                    'Cache-Control' => 'private',
                    'Content-Length' => "'196'",
                    'Content-Type' => "'text/xml; charset=utf-8'",
                    'Server' => 'Microsoft-IIS/8.0',
                    'X-AspNet-Version' => '4.0.30319',
                    'X-Powered-By' => 'ASP.NET',
                    'Date' => "'Wed, 10 Feb 2021 07:35:56 GMT'",
                ],
                'body' => '\'<?xml version="1.0" encoding="UTF-8"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/"><SOAP-ENV:Body><ns1:FindUserResponse><ns1:FindUserResult>true</ns1:FindUserResult></ns1:FindUserResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>\''
            ]
        ];
    }
}
