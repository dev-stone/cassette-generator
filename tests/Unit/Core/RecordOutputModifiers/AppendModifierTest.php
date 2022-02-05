<?php

declare(strict_types=1);

namespace Vcg\Tests\Unit\Core\RecordOutputModifiers;

use PHPUnit\Framework\TestCase;
use Vcg\Core\RecordOutputModifiers\AppendModifier;
use Vcg\ValueObject\Record;

class AppendModifierTest extends TestCase
{
    /**
     * @dataProvider applyDataProvider
     */
    public function testApply(array $appendItems, array $expectedOutputData): void
    {
        $record = new Record();
        $record->setOutputData($this->initialOutputData());

        foreach ($appendItems as $key => $item) {
            $record->addAppendItem($key, $item);
        }

        $recordModifier = new AppendModifier();
        $recordModifier->apply($record);

        $this->assertEquals($expectedOutputData, $record->getOutputData());
    }

    public function applyDataProvider(): array
    {
        return [
            'regular' => [$this->createAppendItems(), $this->expectedOutputData()],
            'non existing keys' => [$this->createNonExistingKeys(), $this->initialOutputData()],
        ];
    }

    private function initialOutputData(): array
    {
        return [
            'request' => [
                'method' => "'P'",
                'url' => 'http://127.0.0.1:80',
                'headers' => [
                    'Host' => '127.0.0.1:80',
                    'Content-Type' => 'text/xml;',
                    'SOAPAction' => 'http://tempuri'
                ]
            ],
            'response' => [
                'status' => [
                    'http_version' => '1',
                    'code' => '2',
                    'message' => "'O'"
                ],
                'headers' => [
                    'Cache-Control' => 'p',
                    'Content-Length' => '1',
                    'Content-Type' => 'text/xml;',
                    'Server' => 'Microsoft-IIS',
                    'X-AspNet-Version' => '4.0',
                    'X-Powered-By' => 'ASP',
                    'Date' => 'Wed, 10 Feb 2021 07:35:56',
                ]
            ]
        ];
    }

    private function createAppendItems(): array
    {
        return [
            'request|method' => 'OST',
            'request|url' => '80/soap',
            'request|headers|Host' => '80',
            'request|headers|Content-Type' => ' charset=utf-8;',
            'request|headers|SOAPAction' => '.org/',
            'response|status|http_version' => '.2',
            'response|status|code' => '00',
            'response|status|message' => 'K',
            'response|headers|Cache-Control' => 'ublic',
            'response|headers|Content-Length' => '96',
            'response|headers|Content-Type' => ' charset=utf-8',
            'response|headers|Server' => '/8.0.3',
            'response|headers|X-AspNet-Version' => '.30319',
            'response|headers|X-Powered-By' => '.NET',
            'response|headers|Date' => ' GMT',
        ];
    }

    private function expectedOutputData(): array
    {
        return [
            'request' => [
                'method' => "'POST'",
                'url' => 'http://127.0.0.1:8080/soap',
                'headers' => [
                    'Host' => '127.0.0.1:8080',
                    'Content-Type' => 'text/xml; charset=utf-8;',
                    'SOAPAction' => 'http://tempuri.org/'
                ]
            ],
            'response' => [
                'status' => [
                    'http_version' => '1.2',
                    'code' => '200',
                    'message' => "'OK'"
                ],
                'headers' => [
                    'Cache-Control' => 'public',
                    'Content-Length' => '196',
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'Server' => 'Microsoft-IIS/8.0.3',
                    'X-AspNet-Version' => '4.0.30319',
                    'X-Powered-By' => 'ASP.NET',
                    'Date' => 'Wed, 10 Feb 2021 07:35:56 GMT',
                ]
            ]
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
