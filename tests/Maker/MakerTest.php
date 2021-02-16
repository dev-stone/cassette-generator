<?php
declare(strict_types=1);

namespace Vcg\Tests\Maker;

use PHPUnit\Framework\TestCase;
use Vcg\Configuration\Configuration;
use Vcg\Maker\Cassette;
use Vcg\Maker\CassettesHolder;
use Vcg\Maker\Maker;
use Vcg\Maker\Record;

class MakerTest extends TestCase
{
    public function testMake()
    {
        $configuration = new Configuration(__DIR__ . '/../data/models_config.yaml');
        $maker = new Maker($configuration);
        $maker->make();

        $this->assertEquals($this->expectedCassettesHolders(), $maker->getCassettesHolders());
    }

    /**
     * @return CassettesHolder[]
     */
    private function expectedCassettesHolders(): array
    {
        $findUserRecord = (new Record())
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/find_user_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/find_user_response.xml');
        $userLoginRecord = (new Record())
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/user_login_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/user_login_response.xml');
        $checkCodeRecord = (new Record())
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/check_code_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/check_code_response.xml');
        $passCodeRecord = (new Record())
            ->setRequestBodyPath('/var/www/cassette-generator/tests/fixturesSource/pass_code_request.xml')
            ->setResponseBodyPath('/var/www/cassette-generator/tests/fixturesSource/pass_code_response.xml');

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
