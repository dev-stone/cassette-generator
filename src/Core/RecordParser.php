<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\ConfigEnum;

class RecordParser
{
    private array $data;
    private string $yaml = '';
    private string $mark = "-\n";
    private string $tab1 = '    ';
    private string $tab2;
    private string $tab3;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->tab2 = $this->tab1 . $this->tab1;
        $this->tab3 = $this->tab1 . $this->tab1 . $this->tab1;
    }

    public function parse(): string
    {
        $this->addBeginLine();
        $this->parseRequestLines();
        $this->parseResponseLines();

        return $this->yaml;
    }

    private function parseRequestLines(): void
    {
        $request = $this->data[ConfigEnum::REQUEST] ?? [];
        $method = $request[ConfigEnum::METHOD] ?? null;
        $url = $request[ConfigEnum::URL] ?? null;
        $headers = $request[ConfigEnum::HEADERS] ?? [];
        $body = $request[ConfigEnum::BODY] ?? null;

        $this->addRequestLine();
        $this->addMethodLine($method);
        $this->addUrlLine($url);
        $this->addHeadersLine();
        $this->addLinesList($headers);
        $this->addBodyLine($body);
    }

    private function parseResponseLines(): void
    {
        $response = $this->data[ConfigEnum::RESPONSE] ?? [];
        $status = $response[ConfigEnum::STATUS] ?? [];
        $headers = $response[ConfigEnum::HEADERS] ?? [];
        $body = $response[ConfigEnum::BODY] ?? [];

        $this->addResponseLine();
        $this->addStatusLine();
        $this->addLinesList($status);
        $this->addHeadersLine();
        $this->addLinesList($headers);
        $this->addBodyLine($body);
    }

    private function addBeginLine()
    {
        $this->yaml .= $this->mark;
    }

    private function addRequestLine()
    {
        $this->addLine(ConfigEnum::REQUEST);
    }

    private function addMethodLine(string $value = null)
    {
        $this->addLine(ConfigEnum::METHOD, $value, $this->tab2);
    }

    private function addUrlLine(string $value = null)
    {
        $this->addLine(ConfigEnum::URL, $value, $this->tab2);
    }

    private function addHeadersLine()
    {
        $this->addLine(ConfigEnum::HEADERS, null, $this->tab2);
    }

    private function addBodyLine(string $value = null)
    {
        $this->addLine(ConfigEnum::BODY, $value, $this->tab2);
    }

    private function addResponseLine()
    {
        $this->addLine(ConfigEnum::RESPONSE);
    }

    private function addStatusLine()
    {
        $this->addLine(ConfigEnum::STATUS, null, $this->tab2);
    }

    private function addLinesList(array $items)
    {
        foreach ($items as $key => $value) {
            $this->addLine($key, $value, $this->tab3);
        }
    }

    private function addLine($key, $value = null, $tab = '    ')
    {
        $value = $value === null ? '' : " $value";
        $this->yaml .= $tab . $key. ':' . $value . PHP_EOL;
    }
}
