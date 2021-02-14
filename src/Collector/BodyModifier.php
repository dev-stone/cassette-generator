<?php
declare(strict_types=1);

namespace Acg\Collector;

use Acg\Configuration;

class BodyModifier
{
    private Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getRequestBody(array $fixturesItem): string
    {
        $testsSettings = $this->configuration->getTestsSettings();
        $filePath = $testsSettings['namespace_in'] . $fixturesItem['request'];
        $xmlContent = file_get_contents($filePath);
        $xmlContent = str_replace("\t", '', $xmlContent);
        $xmlContent = str_replace("\n", '', $xmlContent);

        $xmlContent = preg_replace('/>\s*</', '><', $xmlContent);
        $xmlContent = str_replace('?><', '?>\n<', $xmlContent);
        $xmlContent = str_replace('"', '\"', $xmlContent);
        $xmlContent = $xmlContent . '\n';
        $xmlContent = '"' . $xmlContent . '"';

        return $xmlContent;
    }

    public function getResponseBody(array $fixturesItem): string
    {
        $testsSettings = $this->configuration->getTestsSettings();
        $filePath = $testsSettings['namespace_in'] . $fixturesItem['response'];
        $xmlContent = file_get_contents($filePath);
        $xmlContent = str_replace("\t", '', $xmlContent);
        $xmlContent = str_replace("\n", '', $xmlContent);

        $xmlContent = preg_replace('/>\s*</', '><', $xmlContent);
        $xmlContent = str_replace('?><', '?>\n<', $xmlContent);
        $xmlContent = '\'' . $xmlContent . '\'';

        return $xmlContent;
    }
}
