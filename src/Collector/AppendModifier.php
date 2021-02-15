<?php
declare(strict_types=1);

namespace Vcg\Collector;

class AppendModifier
{
    public function modifyItems(array &$cassette, array $fixturesItem)
    {
        foreach ($fixturesItem['append'] as $append => $value) {
            [$root, $list, $key] = explode('|', $append);
            $cassetteItem = $cassette[$root][$list][$key];

            $addQuote = '';
            if (strrpos($cassetteItem, "'") === strlen($cassetteItem)-1) {
                $addQuote = "'";
                $cassetteItem = substr($cassetteItem, 0, -1);
            }

            $cassetteItem = $cassetteItem . $value . $addQuote;

            $cassette[$root][$list][$key] = $cassetteItem;
        }
    }
}
