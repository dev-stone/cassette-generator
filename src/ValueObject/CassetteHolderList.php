<?php

declare(strict_types=1);

namespace Vcg\ValueObject;

use Vcg\Util\ListIterator;

class CassetteHolderList extends ListIterator
{
    public function add(CassettesHolder $cassettesHolder): self
    {
        $this->items[] = $cassettesHolder;

        return $this;
    }
}
