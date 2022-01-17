<?php

declare(strict_types=1);

namespace Vcg\Core\RecordOutputModifiers;

abstract class BodyModifier implements RecordModifierInterface
{
    protected function trimSpaces(string $xmlContent): string
    {
        $xmlContent = trim($xmlContent);
        $xmlContent = preg_replace('/>\s*/', '>', $xmlContent);
        $xmlContent = preg_replace('/\s*</', '<', $xmlContent);

        return str_replace('?><', '?>\n<', $xmlContent);
    }
}
