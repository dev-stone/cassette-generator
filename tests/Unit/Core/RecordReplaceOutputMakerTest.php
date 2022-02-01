<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Configuration;
use Vcg\Tests\Unit\ReplaceConfigFactory;
use Vcg\Tests\Unit\VcgConfigFactory;
use Vcg\ValueObject\Record;
use Vcg\Core\RecordOutputMaker;

class RecordReplaceOutputMakerTest extends TestCase
{
    private Configuration $configuration;

    protected function setUp(): void
    {
        $this->configuration = ReplaceConfigFactory::createConfiguration();
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
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesInput/game_play_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesInput/game_play_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser')
            ->addReplaceItems('response|body', [
                'date|{{{dateFrom}}}|-2 day|Y-m-d',
                'date|{{{dateTo}}}|+3 day|Y-m-d'
            ]);
    }

    private function expectedOutputData(): array
    {
        $dateFrom = (new \DateTime('-2 day'))->format('Y-m-d');
        $dateTo = (new \DateTime('+3 day'))->format('Y-m-d');

        return [
            'request' => [
                'method' => 'POST',
                'url' => "'http://127.0.0.1:8080/soap'",
                'headers' => [
                    'Host' => "'127.0.0.1:8080'",
                    'Content-Type' => "'text/xml; charset=utf-8;'",
                    'SOAPAction' => "'http://tempuri.org/IAppService/FindUser'"
                ],
                'body' => '"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://tempuri.org/\"><SOAP-ENV:Body><ns1:GetGameCoupons><ns1:GameId>123</ns1:GameId></ns1:GetGameCoupons></SOAP-ENV:Body></SOAP-ENV:Envelope>\n"'
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
                'body' => "'<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://schemas.datacontract.org\" xmlns:ns2=\"http://schemas.datacontract.org\" xmlns:ns3=\"http://tempuri.org/\"><SOAP-ENV:Body><ns3:GetGameCouponsResponse><ns3:GetGameCouponsResult><ns2:Coupons><ns1:Coupon><ns1:Id>44401</ns1:Id><ns1:DateFrom>$dateFrom</ns1:DateFrom><ns1:DateTo>$dateTo</ns1:DateTo><ns1:IsCouponActivated>false</ns1:IsCouponActivated></ns1:Coupon><ns1:Coupon><ns1:Id>44402</ns1:Id><ns1:DateFrom>$dateFrom</ns1:DateFrom><ns1:DateTo>$dateTo</ns1:DateTo><ns1:IsCouponActivated>true</ns1:IsCouponActivated></ns1:Coupon><ns1:Coupon><ns1:Id>44403</ns1:Id><ns1:DateFrom>$dateFrom</ns1:DateFrom><ns1:DateTo>$dateTo</ns1:DateTo><ns1:IsCouponActivated>false</ns1:IsCouponActivated></ns1:Coupon></ns2:Coupons></ns3:GetGameCouponsResult></ns3:GetGameCouponsResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>'"
            ]
        ];
    }
}
