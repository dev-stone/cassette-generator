<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core\RecordOutputModifiers;

use PHPUnit\Framework\TestCase;
use Vcg\Core\RecordOutputModifiers\RewriteModifier;
use Vcg\ValueObject\Record;

class RewriteModifierTest extends TestCase
{
    /**
     * @dataProvider applyDataProvider
     */
    public function testApply(array $rewriteItems, array $expectedOutputData): void
    {
        $record = new Record();
        $record->setOutputData($this->initialOutputData());

        foreach ($rewriteItems as $key => $item) {
            $record->addRewriteItem($key, $item);
        }

        $recordModifier = new RewriteModifier();
        $recordModifier->apply($record);

        $this->assertEquals($expectedOutputData, $record->getOutputData());
    }

    public function applyDataProvider(): array
    {
        return [
            'regular' => [$this->createRewriteItems(), $this->expectedOutputData()],
            'non existing keys' => [$this->createNonExistingKeys(), $this->initialOutputData()],
        ];
    }

    private function initialOutputData(): array
    {
        return [
            'request' => [
                'method' => 'POST',
                'url' => 'http://127.0.0.1:8080/soap',
                'headers' => [
                    'Host' => '127.0.0.1:8080',
                    'Content-Type' => 'text/xml; charset=utf-8;',
                    'SOAPAction' => 'http://tempuri.org/'
                ]
            ],
            'response' => [
                'status' => [
                    'http_version' => '1.1',
                    'code' => '200',
                    'message' => 'OK'
                ],
                'headers' => [
                    'Cache-Control' => 'private',
                    'Content-Length' => '196',
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'Server' => 'Microsoft-IIS/8.0',
                    'X-AspNet-Version' => '4.0.30319',
                    'X-Powered-By' => 'ASP.NET',
                    'Date' => 'Wed, 10 Feb 2021 07:35:56 GMT',
                ]
            ]
        ];
    }

    private function expectedOutputData(): array
    {
        return [
            'request' => [
                'method' => 'GET',
                'url' => 'http://127.0.0.1:8888/soap',
                'headers' => [
                    'Host' => '127.0.0.1:8888',
                    'Content-Type' => 'text/xml; charset=utf-16;',
                    'SOAPAction' => 'https://tempuri.org/'
                ]
            ],
            'response' => [
                'status' => [
                    'http_version' => '1.2',
                    'code' => '500',
                    'message' => 'error'
                ],
                'headers' => [
                    'Cache-Control' => 'public',
                    'Content-Length' => '293',
                    'Content-Type' => 'text/xml; charset=utf-16',
                    'Server' => 'Microsoft-IIS/8.0.3',
                    'X-AspNet-Version' => '4.1.1',
                    'X-Powered-By' => 'ASP',
                    'Date' => 'Fri, 4 Feb 2022 08:17:39 GMT',
                ]
            ]
        ];
    }

    private function createRewriteItems(): array
    {
        return [
            'request|method' => 'GET',
            'request|url' => 'http://127.0.0.1:8888/soap',
            'request|headers|Host' => '127.0.0.1:8888',
            'request|headers|Content-Type' => 'text/xml; charset=utf-16;',
            'request|headers|SOAPAction' => 'https://tempuri.org/',
            'response|status|http_version' => '1.2',
            'response|status|code' => '500',
            'response|status|message' => 'error',
            'response|headers|Cache-Control' => 'public',
            'response|headers|Content-Length' => '293',
            'response|headers|Content-Type' => 'text/xml; charset=utf-16',
            'response|headers|Server' => 'Microsoft-IIS/8.0.3',
            'response|headers|X-AspNet-Version' => '4.1.1',
            'response|headers|X-Powered-By' => 'ASP',
            'response|headers|Date' => 'Fri, 4 Feb 2022 08:17:39 GMT',
        ];
    }

    private function createNonExistingKeys(): array
    {
        return [
            'request' => 'na',
            'request|input' => 'na',
            'request|headers|Content-length' => '0',
            'request|headers|Input|Output' => 'na',
            'response' => 'na',
            'response|input' => 'na',
            'response|headers|message' => 'error',
            'response|status|non-exist' => 'na',
            'input' => 'na',
        ];
    }
}
