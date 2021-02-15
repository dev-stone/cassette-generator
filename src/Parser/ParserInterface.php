<?php
declare(strict_types=1);

namespace Vcg\Parser;

interface ParserInterface
{
    public function parse(): string;
}
