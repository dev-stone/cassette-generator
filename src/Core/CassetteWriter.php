<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\ValueObject\CassetteOutput;

class CassetteWriter
{
    /**
     * @param CassetteOutput[] $cassettesOutputs
     */
    public function write(array $cassettesOutputs): void
    {
        foreach ($cassettesOutputs as $cassetteOutput) {
            file_put_contents($cassetteOutput->getOutputPath(), $cassetteOutput->getOutputString());
        }
    }
}
