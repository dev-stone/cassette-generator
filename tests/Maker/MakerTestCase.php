<?php
declare(strict_types=1);

namespace Vcg\Tests\Maker;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Configuration;
use Vcg\Maker\Cassette;
use Vcg\Maker\CassettesHolder;
use Vcg\Maker\Record;

class MakerTestCase extends TestCase
{
    /**
     * @param Configuration $configuration
     * @return CassettesHolder[]
     */
    protected function createCassettesHolders(Configuration $configuration): array
    {
        $recordDefaultsModel = $configuration->getRecordDefaults();
        $findUserRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/find_user_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/find_user_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/FindUser')
            ->addRewriteItem('response|headers|Date');
        $userLoginRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/user_login_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/user_login_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/Login')
            ->addRewriteItem('response|headers|Date');
        $checkCodeRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/check_code_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/check_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/CheckCode')
            ->addRewriteItem('response|headers|Date');
        $passCodeRecord = (new Record())
            ->setRecordDefaultsModel($recordDefaultsModel)
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/pass_code_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/pass_code_response.xml')
            ->addAppendItem('request|headers|SOAPAction', 'IAppService/PassCode')
            ->addRewriteItem('response|headers|Date');

        $loginCassette = (new Cassette())
            ->setOutputPath('/var/www/cassette-generator/tests/fixtures/IntegrationTests/login_process.yaml')
            ->addRecord($findUserRecord)
            ->addRecord($userLoginRecord);
        $registerCassette = (new Cassette())
            ->setOutputPath('/var/www/cassette-generator/tests/fixtures/IntegrationTests/registration_process.yaml')
            ->addRecord($checkCodeRecord)
            ->addRecord($passCodeRecord);

        $cassettesHolder = (new CassettesHolder())
            ->addCassette($loginCassette)
            ->addCassette($registerCassette);

        return [$cassettesHolder];
    }
}
