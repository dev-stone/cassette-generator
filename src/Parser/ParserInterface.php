<?php
declare(strict_types=1);

namespace Acg\Parser;

interface ParserInterface
{
    public function parse(): string;
}
