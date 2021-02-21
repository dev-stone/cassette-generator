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
        $this->writeLines();

        return $this->yaml;
    }

    private function writeLines(): void
    {
        $this->beginLine();
        $this->parseRequestLines();
        $this->parseResponseLines();
    }

    private function parseRequestLines(): void
    {
        $request = $this->data[Config::REQUEST] ?? [];
        $method = $request[Config::METHOD] ?? null;
        $url = $request[Config::URL] ?? null;
        $headers = $request[Config::HEADERS] ?? [];
        $body = $request[Config::BODY] ?? null;

        $this->requestLine();
        $this->methodLine($method);
        $this->urlLine($url);
        $this->headersLine();
        $this->linesList($headers);
        $this->bodyLine($body);
    }

    private function parseResponseLines(): void
    {
        $response = $this->data[Config::RESPONSE] ?? [];
        $status = $response[Config::STATUS] ?? [];
        $headers = $response[Config::HEADERS] ?? [];
        $body = $response[Config::BODY] ?? [];

        $this->responseLine();
        $this->statusLine();
        $this->linesList($status);
        $this->headersLine();
        $this->linesList($headers);
        $this->bodyLine($body);
    }

    private function beginLine()
    {
        $this->yaml .= $this->mark;
    }

    private function requestLine()
    {
        $this->line(Config::REQUEST);
    }

    private function methodLine(string $value = null)
    {
        $this->line(Config::METHOD, $value, $this->tab2);
    }

    private function urlLine(string $value = null)
    {
        $this->line(Config::URL, $value, $this->tab2);
    }

    private function headersLine()
    {
        $this->line(Config::HEADERS, null, $this->tab2);
    }

    private function bodyLine(string $value = null)
    {
        $this->line(Config::BODY, $value, $this->tab2);
    }

    private function responseLine()
    {
        $this->line(Config::RESPONSE);
    }

    private function statusLine()
    {
        $this->line(Config::STATUS, null, $this->tab2);
    }

    private function linesList(array $items)
    {
        foreach ($items as $key => $value) {
            $this->line($key, $value, $this->tab3);
        }
    }

    private function line($key, $value = null, $tab = '    ')
    {
        $value = $value === null ? '' : " $value";
        $this->yaml .= $tab . $key. ':' . $value . PHP_EOL;
    }
}
