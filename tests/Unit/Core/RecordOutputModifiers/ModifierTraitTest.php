<?php

namespace Vcg\Tests\Unit\Core\RecordOutputModifiers;

use PHPUnit\Framework\TestCase;
use Vcg\Core\RecordOutputModifiers\ModifierTrait;

class ModifierTraitTest extends TestCase
{
    public function testTrait()
    {
        $modifierInstance = $this->createInstanceWithModifierTrait();

        $modifierInstance->populateLevels('request|headers|Host');
        $this->assertEquals('request', $modifierInstance->getLevel1());
        $this->assertEquals('headers', $modifierInstance->getLevel2());
        $this->assertEquals('Host', $modifierInstance->getLevel3());
    }

    private function createInstanceWithModifierTrait(): object
    {
        return new class() {
            use ModifierTrait {
                populateLevels as public;
            }

            public function getLevel1()
            {
                return $this->level1;
            }

            public function getLevel2()
            {
                return $this->level2;
            }

            public function getLevel3()
            {
                return $this->level3;
            }

            public function setOutputData(array $outputData)
            {
                $this->outputData = $outputData;
            }

            public function getOutputData()
            {
                return $this->outputData;
            }
        };
    }
}