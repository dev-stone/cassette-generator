<?php
declare(strict_types=1);

namespace Vcg\Configuration\Model;

use Vcg\Util\ListIterator;

class CassettesHolderModelList extends ListIterator
{
    public function add(CassettesHolderModel $cassettesHolderModel): self
    {
        $this->items[] = $cassettesHolderModel;

        return $this;
    }
}
