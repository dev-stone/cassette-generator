<?php
declare(strict_types=1);

namespace Vcg\Tests\CassettesHolder;

use PHPUnit\Framework\TestCase;
use Vcg\CassettesHolder\RecordBuilder;
use Vcg\Configuration;

class RecordTest extends TestCase
{
    public function testCreateRecord()
    {
        $this->markTestSkipped();

        $recordDefaults = $this->createRecordDefaults();
        $recordSettings = $this->createRecordSettings();
        $configuration = new Configuration(__DIR__.'/../data/vcg_config.yaml');
        $recordBuilder = new RecordBuilder($configuration);

        $record = $recordBuilder->createRecord($recordDefaults, $recordSettings);

        $this->assertEquals($this->expectedRecordString(), $record->getOutputString());

    }

    private function createRecordDefaults(): array
    {
        return [
            'request' => [
                'method' => 'POST',
                'url' => "'http =>//127.0.0.1:8080/soap'",
                'headers' => [
                    'Host' => "'127.0.0.1 =>8080'",
                    'Content-Type' => "'text/xml; charset=utf-8;'",
                    'SOAPAction' => "'http://tempuri.org/'",
                ],
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
            ],
        ];
    }

    private function createRecordSettings(): array
    {
        return [
            'name' => 'find_user',
            'request' => 'find_user_request.xml',
            'response' => 'find_user_response.xml',
            'append' => [
                'request|headers|SOAPAction' => 'IAppService/FindUser',
            ],
            'rewrite' => [
                'response|headers|Date' => null
            ],
        ];
    }

    private function expectedRecordString(): string
    {
        return <<< YAML
    request:
        method: POST
        url: 'http://127.0.0.1:8080/soap'
        headers:
            Host: '127.0.0.1:8080'
            Content-Type: 'text/xml; charset=utf-8;'
            SOAPAction: 'http://tempuri.org/IAppService/FindUser'
        body: "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://tempuri.org/\"><SOAP-ENV:Body><ns1:FindUser><ns1:User>test@example.com</ns1:User></ns1:FindUser></SOAP-ENV:Body></SOAP-ENV:Envelope>\n"
    response:
        status:
            http_version: '1.1'
            code: '200'
            message: OK
        headers:
            Cache-Control: private
            Content-Length: '196'
            Content-Type: 'text/xml; charset=utf-8'
            Server: Microsoft-IIS/8.0
            X-AspNet-Version: 4.0.30319
            X-Powered-By: ASP.NET
            Date: 'Wed, 10 Feb 2021 07:35:56 GMT'
        body: '<?xml version="1.0" encoding="UTF-8"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/"><SOAP-ENV:Body><ns1:FindUserResponse><ns1:FindUserResult>true</ns1:FindUserResult></ns1:FindUserResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>'

YAML;
    }
}
