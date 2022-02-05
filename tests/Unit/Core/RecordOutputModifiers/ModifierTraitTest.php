<?php

namespace Vcg\Tests\Unit\Core\RecordOutputModifiers;

use PHPUnit\Framework\TestCase;
use Vcg\Core\RecordOutputModifiers\ModifierTrait;

class ModifierTraitTest extends TestCase
{
    public function testPopulateLevels()
    {
        $modifierInstance = $this->createInstanceWithModifierTrait();

        $modifierInstance->populateLevels('request|headers|Host');
        $this->assertEquals('request', $modifierInstance->getLevel1());
        $this->assertEquals('headers', $modifierInstance->getLevel2());
        $this->assertEquals('Host', $modifierInstance->getLevel3());

        $modifierInstance->clearLevels();
        $this->assertNull($modifierInstance->getLevel1());
        $this->assertNull($modifierInstance->getLevel2());
        $this->assertNull($modifierInstance->getLevel3());
    }

    public function testModifyLevel2nd()
    {
        $modifierInstance = $this->createInstanceWithModifierTrait();

        $this->assertFalse($modifierInstance->canModifyLevel2nd());
        $modifierInstance->setOutputData($this->createOutputData());
        $modifierInstance->populateLevels('request|url');
        $this->assertTrue($modifierInstance->canModifyLevel2nd());

        $modifierInstance->setOutputItemLevel2nd('localhost');
        $this->assertEquals('localhost', $modifierInstance->getOutputItemLevel2nd());
    }

    public function testModifyLevel3rd()
    {
        $modifierInstance = $this->createInstanceWithModifierTrait();

        $this->assertFalse($modifierInstance->canModifyLevel3rd());
        $modifierInstance->setOutputData($this->createOutputData());
        $modifierInstance->populateLevels('request|headers|Host');
        $this->assertTrue($modifierInstance->canModifyLevel3rd());

        $modifierInstance->setOutputItemLevel3rd('localhost');
        $this->assertEquals('localhost', $modifierInstance->getOutputItemLevel3rd());
    }

    private function createInstanceWithModifierTrait(): object
    {
        return new class() {
            use ModifierTrait {
                populateLevels as public;
                clearLevels as public;
                canModifyLevel2nd as public;
                getOutputItemLevel2nd as public;
                setOutputItemLevel2nd as public;
                canModifyLevel3rd as public;
                getOutputItemLevel3rd as public;
                setOutputItemLevel3rd as public;
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

    private function createOutputData(): array
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
            ]
        ];
    }
}