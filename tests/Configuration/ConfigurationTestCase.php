<?php
declare(strict_types=1);

namespace Vcg\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Model\CassetteModel;
use Vcg\Configuration\Model\CassettesHolderModel;
use Vcg\Configuration\Model\RecordDefaultsModel;
use Vcg\Configuration\Model\RecordModel;
use Vcg\Configuration\Model\RequestModel;
use Vcg\Configuration\Model\ResponseModel;

class ConfigurationTestCase extends TestCase
{
    protected function createRecordDefaults(): RecordDefaultsModel
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

    protected function createCassettesSettings(): array
    {
        $findUser = (new RecordModel())
            ->setRequestBodyPath('find_user_request.xml')
            ->setResponseBodyPath('find_user_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser')
            ->addRewriteItems('response|headers|Date');
        $userLogin = (new RecordModel())
            ->setRequestBodyPath('user_login_request.xml')
            ->setResponseBodyPath('user_login_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/Login')
            ->addRewriteItems('response|headers|Date');
        $cassetteLogin = (new CassetteModel())
            ->setOutputFile('login_process.yaml')
            ->addRecordModel($findUser)
            ->addRecordModel($userLogin);

        $checkCode = (new RecordModel())
            ->setRequestBodyPath('check_code_request.xml')
            ->setResponseBodyPath('check_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/CheckCode')
            ->addRewriteItems('response|headers|Date');
        $passCode = (new RecordModel())
            ->setRequestBodyPath('pass_code_request.xml')
            ->setResponseBodyPath('pass_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/PassCode')
            ->addRewriteItems('response|headers|Date');
        $cassetteRegister = (new CassetteModel())
            ->setOutputFile('registration_process.yaml')
            ->addRecordModel($checkCode)
            ->addRecordModel($passCode);

        $cassettesHolder = new CassettesHolderModel();
        $cassettesHolder
            ->setName('integration_tests')
            ->setInputDir('/var/www/cassette-generator/tests/fixturesSource/')
            ->setOutputDir('/var/www/cassette-generator/tests/fixtures/IntegrationTests/')
            ->addCassetteModel($cassetteLogin)
            ->addCassetteModel($cassetteRegister);

        return [$cassettesHolder];
    }
}
