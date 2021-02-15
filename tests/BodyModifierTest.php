<?php
declare(strict_types=1);

namespace Vcg\Tests;

use Vcg\Collector\BodyModifier;
use Vcg\Configuration;
use PHPUnit\Framework\TestCase;

class BodyModifierTest extends TestCase
{
    public function testRequestBodyMaking()
    {
        $configuration = new Configuration(__DIR__.'/data/vcg_config.yaml');
        $bodyModifier = new BodyModifier($configuration);
        $fixturesSettings = $configuration->getFixturesSettings();
        $fixturesItem = $fixturesSettings[0];
        $requestBody = $bodyModifier->getRequestBody($fixturesItem);
        $this->assertEquals($this->expectedRequestBody(), $requestBody);
    }

    public function testResponseBodyMaking()
    {
        $configuration = new Configuration(__DIR__.'/data/vcg_config.yaml');
        $bodyModifier = new BodyModifier($configuration);
        $fixturesSettings = $configuration->getFixturesSettings();
        $fixturesItem = $fixturesSettings[0];
        $requestBody = $bodyModifier->getResponseBody($fixturesItem);
        $this->assertEquals($this->expectedResponseBody(), $requestBody);
    }

    private function expectedRequestBody(): string
    {
        return '"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://tempuri.org/\"><SOAP-ENV:Body><ns1:FindUser><ns1:User>test@example.com</ns1:User></ns1:FindUser></SOAP-ENV:Body></SOAP-ENV:Envelope>\n"';
    }

    private function expectedResponseBody(): string
    {
        return '\'<?xml version="1.0" encoding="UTF-8"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/"><SOAP-ENV:Body><ns1:FindUserResponse><ns1:FindUserResult>true</ns1:FindUserResult></ns1:FindUserResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>\'';
    }
}
