<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\ValueObject\CassetteOutput;
use Vcg\ValueObject\CassetteOutputList;

class CassetteWriter
{
    public function write(CassetteOutputList $cassetteOutputList): void
    {
        foreach ($cassetteOutputList as $cassetteOutput) {
            file_put_contents($cassetteOutput->getOutputPath(), $cassetteOutput->getOutputString());
        }
    }
}
