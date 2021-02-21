<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Config;

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
        $request = $this->data[Config::REQUEST] ?? [];
        $method = $request[Config::METHOD] ?? null;
        $url = $request[Config::URL] ?? null;
        $headers = $request[Config::HEADERS] ?? [];
        $body = $request[Config::BODY] ?? null;

        $this->addRequestLine();
        $this->addMethodLine($method);
        $this->addUrlLine($url);
        $this->addHeadersLine();
        $this->addLinesList($headers);
        $this->addBodyLine($body);
    }

    private function parseResponseLines(): void
    {
        $response = $this->data[Config::RESPONSE] ?? [];
        $status = $response[Config::STATUS] ?? [];
        $headers = $response[Config::HEADERS] ?? [];
        $body = $response[Config::BODY] ?? [];

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
        $this->addLine(Config::REQUEST);
    }

    private function addMethodLine(string $value = null)
    {
        $this->addLine(Config::METHOD, $value, $this->tab2);
    }

    private function addUrlLine(string $value = null)
    {
        $this->addLine(Config::URL, $value, $this->tab2);
    }

    private function addHeadersLine()
    {
        $this->addLine(Config::HEADERS, null, $this->tab2);
    }

    private function addBodyLine(string $value = null)
    {
        $this->addLine(Config::BODY, $value, $this->tab2);
    }

    private function addResponseLine()
    {
        $this->addLine(Config::RESPONSE);
    }

    private function addStatusLine()
    {
        $this->addLine(Config::STATUS, null, $this->tab2);
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
