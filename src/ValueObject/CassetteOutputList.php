<?php
declare(strict_types=1);

namespace Vcg\ValueObject;

use Vcg\Util\ListIterator;

class CassetteOutputList extends ListIterator
{
    public function add(CassetteOutput $cassetteOutput): self
    {
        $this->items[] = $cassetteOutput;

        return $this;
    }
}
