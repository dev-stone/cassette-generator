<?php
declare(strict_types=1);

namespace Vcg\Collector;

use Vcg\Configuration;

class BodyModifier
{
    private Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getRequestBody(array $fixturesItem): string
    {
        $xmlContent = $this->getRequestContent($fixturesItem);
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = str_replace('"', '\"', $xmlContent);
        $xmlContent = $xmlContent . '\n';
        $xmlContent = '"' . $xmlContent . '"';

        return $xmlContent;
    }

    public function getResponseBody(array $fixturesItem): string
    {
        $xmlContent = $this->getResponseContent($fixturesItem);
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = '\'' . $xmlContent . '\'';

        return $xmlContent;
    }

    private function trimSpaces(string $xmlContent)
    {
        $xmlContent = trim($xmlContent);
        $xmlContent = preg_replace('/>\s*/', '>', $xmlContent);
        $xmlContent = preg_replace('/\s*</', '<', $xmlContent);

        return str_replace('?><', '?>\n<', $xmlContent);
    }

    private function getRequestContent(array $fixturesItem)
    {
        $testsSettings = $this->configuration->getTestsSettings();
        $filePath = $testsSettings['namespace_in'] . $fixturesItem['request'];

        return file_get_contents($filePath);
    }

    private function getResponseContent(array $fixturesItem)
    {
        $testsSettings = $this->configuration->getTestsSettings();
        $filePath = $testsSettings['namespace_in'] . $fixturesItem['response'];

        return file_get_contents($filePath);
    }
}
