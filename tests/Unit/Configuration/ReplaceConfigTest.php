<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Configuration;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\CassettesHolderModelList;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RecordModel;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;

class ReplaceConfigTest extends TestCase
{
    public function testReplaceConfig(): void
    {
        $configuration = new Configuration(__DIR__ . '/../../data/replace_config.yaml');

        $this->assertEquals($this->expectedRecordDefaults(), $configuration->getRecordDefaults());
        $this->assertEquals($this->expectedCassettesSettings(), $configuration->getCassettesHolderModelList());
    }

    private function expectedRecordDefaults(): RecordDefaultsModel
    {
        $requestModel = (new RequestModel())
            ->setMethod('POST')
            ->setUrl("'http://127.0.0.1:8080/soap'")
            ->addHeader('Host', "'127.0.0.1:8080'")
            ->addHeader('Content-Type', "'text/xml; charset=utf-8;'")
            ->addHeader('SOAPAction', "'http://tempuri.org/'");
        $responseModel = (new ResponseModel())
            ->addStatus('http_version', "'1.1'")
            ->addStatus('code', "'200'")
            ->addStatus('message', 'OK')
            ->addHeader('Cache-Control', 'private')
            ->addHeader('Content-Length', "'196'")
            ->addHeader('Content-Type', "'text/xml; charset=utf-8'")
            ->addHeader('Server', 'Microsoft-IIS/8.0')
            ->addHeader('X-AspNet-Version', '4.0.30319')
            ->addHeader('X-Powered-By', 'ASP.NET')
            ->addHeader('Date', "'Wed, 10 Feb 2021 07:35:56 GMT'");

        return (new RecordDefaultsModel())
            ->setRequestModel($requestModel)
            ->setResponseModel($responseModel);
    }

    private function expectedCassettesSettings(): CassettesHolderModelList
    {
        $getCoupons = (new RecordModel())
            ->setRequestBodyPath('game_play_request.xml')
            ->setResponseBodyPath('game_play_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/GetGameCoupons')
            ->addReplaceItems('response|body', [
                'date|{{{dateFrom}}}|-2 day',
                'date|{{{dateTo}}}|+3 day'
            ]);
        $cassetteGamePlay = (new CassetteModel())
            ->setOutputFile('game_play.yaml')
            ->addRecordModel($getCoupons);

        $cassettesHolder = new CassettesHolderModel();
        $cassettesHolder
            ->setName('replace_placeholder')
            ->setInputDir('/var/www/cassette-generator/tests/fixturesInput/')
            ->setOutputDir('/var/www/cassette-generator/tests/fixturesOutput/IntegrationTests/')
            ->addCassetteModel($cassetteGamePlay);

        return (new CassettesHolderModelList())->add($cassettesHolder);
    }
}
