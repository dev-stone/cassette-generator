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

class VcgConfigFactory
{
    public static function createConfiguration(): Configuration
    {
        return new Configuration(__DIR__ . '/../data/vcg_config.yaml');
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
        $findUser = (new RecordModel())
            ->setRequestBodyPath('find_user_request.xml')
            ->setResponseBodyPath('find_user_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser');
        $userLogin = (new RecordModel())
            ->setRequestBodyPath('user_login_request.xml')
            ->setResponseBodyPath('user_login_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/Login');
        $cassetteLogin = (new CassetteModel())
            ->setOutputFile('login_process.yaml')
            ->addRecordModel($findUser)
            ->addRecordModel($userLogin);

        $checkCode = (new RecordModel())
            ->setRequestBodyPath('check_code_request.xml')
            ->setResponseBodyPath('check_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/CheckCode');
        $passCode = (new RecordModel())
            ->setRequestBodyPath('pass_code_request.xml')
            ->setResponseBodyPath('pass_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/PassCode');
        $cassetteRegister = (new CassetteModel())
            ->setOutputFile('registration_process.yaml')
            ->addRecordModel($checkCode)
            ->addRecordModel($passCode);

        $dir = realpath(__DIR__ . '/../');
        $cassettesHolder = new CassettesHolderModel();
        $cassettesHolder
            ->setName('integration_tests')
            ->setInputDir($dir . '/fixturesInput/')
            ->setOutputDir($dir . '/fixturesOutput/IntegrationTests/')
            ->addCassetteModel($cassetteLogin)
            ->addCassetteModel($cassetteRegister);

        return (new CassettesHolderModelList())->add($cassettesHolder);
    }

    public static function createCassettesHolders(Configuration $configuration, string $baseDir): CassetteHolderList
    {
        $dir = realpath($baseDir);
        $recordDefaultsModel = $configuration->getRecordDefaults();
        $findUserRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath($dir . '/fixturesInput/find_user_request.xml')
            ->setResponseBodyPath($dir . '/fixturesInput/find_user_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser');
        $userLoginRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath($dir . '/fixturesInput/user_login_request.xml')
            ->setResponseBodyPath($dir . '/fixturesInput/user_login_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/Login');
        $checkCodeRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath($dir . '/fixturesInput/check_code_request.xml')
            ->setResponseBodyPath($dir . '/fixturesInput/check_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/CheckCode');
        $passCodeRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath($dir . '/fixturesInput/pass_code_request.xml')
            ->setResponseBodyPath($dir . '/fixturesInput/pass_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/PassCode');

        $loginCassette = (new Cassette())
            ->setOutputPath(realpath($baseDir . '/fixturesOutput/IntegrationTests/login_process.yaml'))
            ->addRecord($findUserRecord)
            ->addRecord($userLoginRecord);
        $registerCassette = (new Cassette())
            ->setOutputPath(realpath($baseDir . '/fixturesOutput/IntegrationTests/registration_process.yaml'))
            ->addRecord($checkCodeRecord)
            ->addRecord($passCodeRecord);

        $cassettesHolder = (new CassettesHolder())
            ->addCassette($loginCassette)
            ->addCassette($registerCassette);

        return (new CassetteHolderList())->add($cassettesHolder);
    }
}
