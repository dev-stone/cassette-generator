<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit;

use Vcg\Configuration\Configuration;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\CassettesHolderModelList;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RecordModel;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;
use Vcg\ValueObject\Cassette;
use Vcg\ValueObject\CassetteHolderList;
use Vcg\ValueObject\CassettesHolder;
use Vcg\ValueObject\Record;

class ReplaceConfigFactory
{
    public static function createConfiguration(): Configuration
    {
        return new Configuration(__DIR__ . '/../data/replace_config.yaml');
    }

    public static function createRecordDefaults(): RecordDefaultsModel
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

    public static function createCassettesSettings(): CassettesHolderModelList
    {
        $getCoupons = (new RecordModel())
            ->setRequestBodyPath('game_play_request.xml')
            ->setResponseBodyPath('game_play_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/GetGameCoupons')
            ->addReplaceItems('response|body', [
                'date|{{{dateFrom}}}|-2 day|Y-m-d',
                'date|{{{dateTo}}}|+3 day|Y-m-d'
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

    public static function createCassettesHolders(Configuration $configuration, string $baseDir): CassetteHolderList
    {
        $dir = realpath($baseDir);
        $recordDefaultsModel = $configuration->getRecordDefaults();
        $getCouponsRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath($dir . '/fixturesInput/game_play_request.xml')
            ->setResponseBodyPath(realpath($baseDir . '/fixturesInput/game_play_response.xml'))
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/GetGameCoupons');

        $gamePlayCassette = (new Cassette())
            ->setOutputPath($dir . '/fixturesOutput/IntegrationTests/game_play.yaml')
            ->addRecord($getCouponsRecord);

        $cassettesHolder = (new CassettesHolder())
            ->addCassette($gamePlayCassette);

        return (new CassetteHolderList())->add($cassettesHolder);
    }
}
