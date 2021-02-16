<?php
declare(strict_types=1);

namespace Vcg\Maker;

class CassettesHolder
{
    /**
     * @var Cassette[]
     */
    private array $cassettes = [];

    /**
     * @return Cassette[]
     */
    public function getCassettes(): array
    {
        return $this->cassettes;
    }

    public function addCassette(Cassette $cassette): self
    {
        $this->cassettes[] = $cassette;

        return $this;
    }
}
