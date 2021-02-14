<?php
declare(strict_types=1);

namespace Acg\Collector;

use Acg\Configuration;

class DataCollector
{
    private Configuration $configuration;
    private AppendModifier $appendModifier;
    private BodyModifier $bodyModifier;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->appendModifier = new AppendModifier();
        $this->bodyModifier = new BodyModifier($configuration);
    }

    public function getData(): array
    {
        $cassetteSettings = $this->configuration->getCassetteSettings();
        $testsSettings = $this->configuration->getTestsSettings();

        $data = [];
        foreach ($testsSettings['fixtures'] as $fixturesItem) {
            $cassette = $cassetteSettings;
            $cassette['outputFile'] = $testsSettings['namespace_out'] . $fixturesItem['output'];
            $cassette['request']['body'] = $this->bodyModifier->getRequestBody($fixturesItem);
            $cassette['response']['body'] = $this->bodyModifier->getResponseBody($fixturesItem);

            $this->appendModifier->modifyItems($cassette, $fixturesItem);

            $data[] = $cassette;
        }

        return $data;
    }
}
