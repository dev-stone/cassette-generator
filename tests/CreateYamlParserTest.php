<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\Collector\DataCollector;
use Acg\Configuration;
use Acg\Parser\YamlParser;
use PHPUnit\Framework\TestCase;

class CreateYamlParserTest extends TestCase
{
    public function testCreateFrame()
    {

        $config = new Configuration(__DIR__.'/data/acg_config.yaml');
        $data = (new DataCollector($config))->getData();
        $frame = new YamlParser($data);
        $actual = $frame->parse();
        $expected = $this->expectedFrame();

        $this->assertEquals($expected, $actual);
    }

    private function expectedFrame(): string
    {
        return <<< YAML
-
    request:
        method: POST
        url: 'http://127.0.0.1:8080/soap'
        headers:
            Host: '127.0.0.1:8080'
            Content-Type: 'text/xml; charset=utf-8;'
            SOAPAction: 'http://tempuri.org/IAppService/FindUser'
        body:
    response:
        status:
            http_version: '1.1'
            code: '200'
            message: OK
        headers:
            Cache-Control: private
            Content-Length: '196'
            Content-Type: 'text/xml; charset=utf-8'
            Server: Microsoft-IIS/8.0
            X-AspNet-Version: 4.0.30319
            X-Powered-By: ASP.NET
            Date: 'Wed, 10 Feb 2021 07:35:56 GMT'
        body:

YAML;
    }
}
