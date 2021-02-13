<?php
declare(strict_types=1);

namespace Acg;

class DataCollector
{
    public function getData(): array
    {
        return [
            [
                'request' => [
                    'method' => null,
                    'url' => null,
                    'headers' => [
                        'Host' => null,
                        'Content-Type' => null,
                        'SOAPAction' => null,
                    ],
                    'body' => null,
                ],
                'response' => [
                    'status' => [
                        'http_version' => null,
                        'code' => null,
                        'message' => null,
                    ],
                    'headers' => [
                        'Cache-Control' => null,
                        'Content-Length' => null,
                        'Content-Type' => null,
                        'Server' => null,
                        'X-AspNet-Version' => null,
                        'X-Powered-By' => null,
                        'Date' => null,
                    ],
                    'body' => null,
                ],
            ]
        ];
    }
}
