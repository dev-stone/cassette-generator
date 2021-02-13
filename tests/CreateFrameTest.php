<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\DataCollector;
use Acg\Frame;
use PHPUnit\Framework\TestCase;

class CreateFrameTest extends TestCase
{
    public function testCreateFrame()
    {
        $data = (new DataCollector())->getData();
        $frame = new Frame($data);
        $actual = $frame->yaml();
        $expected = $this->expectedFrame();

        $this->assertEquals($expected, $actual);
    }

    private function expectedFrame(): string
    {
        return
"-
    request:
        method:
        url:
        headers:
            Host:
            Content-Type:
            SOAPAction:
        body:
    response:
        status:
            http_version:
            code:
            message:
        headers:
            Cache-Control:
            Content-Length:
            Content-Type:
            Server:
            X-AspNet-Version:
            X-Powered-By:
            Date:
        body:
";
    }
}
