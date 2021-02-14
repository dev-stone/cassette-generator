<?php
declare(strict_types=1);

namespace Acg\Collector;

use Acg\Configuration;

class DataCollector
{
    private Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getData(): array
    {
        $cassetteSettings = $this->configuration->getCassetteSettings();
        $testsSettings = $this->configuration->getTestsSettings();

        $data = [];
        foreach ($testsSettings['fixtures'] as $testItem) {
            $cassette = $cassetteSettings;
            $cassette['request']['body'] = null;
            $cassette['response']['body'] = null;

            foreach ($testItem['append'] as $append => $value) {
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

            $data[] = $cassette;
        }

        return $data;
    }
}
