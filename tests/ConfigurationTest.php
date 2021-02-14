<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private Configuration $configuration;

    public function testCassetteSettings()
    {
        $cassetteSettings = $this->configuration->getCassetteSettings();
        $this->assertEquals($this->expectedSettings(), $cassetteSettings);
    }

    public function testTestsSettings()
    {
        $testsSettings = $this->configuration->getTestsSettings();
        $this->assertEquals($this->expectedTestsSettings(), $testsSettings);
    }

    protected function setUp(): void
    {
        $configFile = __DIR__.'/data/acg_config.yaml';
        $this->configuration = (new Configuration($configFile))->loadConfiguration();
    }

    private function expectedSettings(): array
    {
        return [
            'request' => [
                'method' => 'POST',
                'url' => "'http://127.0.0.1:8080/soap'",
                'headers' => [
                    'Host' => "'127.0.0.1:8080'",
                    'Content-Type' => "'text/xml; charset=utf-8;'",
                    'SOAPAction' => "'http://tempuri.org/'"
                ]
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
                    'Date' => "'Wed, 10 Feb 2021 07:35:56 GMT'"
                ]
            ]
        ];
    }

    private function expectedTestsSettings(): array
    {
        return [
            'namespace_in' => '/var/www/cassette-generator/tests/fixturesSource/',
            'namespace_out' => '/var/www/cassette-generator/tests/fixtures/',
            'fixtures' => [
                [
                    'name' => 'find_user',
                    'request' => 'find_user_request.xml',
                    'response' => 'find_user_response.xml',
                    'output' => 'find_user.yaml',
                    'append' => [
                        'request|headers|SOAPAction' => 'IAppService/FindUser'
                    ],
                    'rewrite' => [
                        'response|headers|Date' => null
                    ]
                ]
            ]
        ];
    }
}
