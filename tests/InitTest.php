<?php
declare(strict_types=1);

namespace Acg\Tests;

use Acg\Init;
use PHPUnit\Framework\TestCase;

class InitTest extends TestCase
{
    public function testFeature()
    {
        $init = new Init();
        $this->assertTrue($init->feature());
    }
}
