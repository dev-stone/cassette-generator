<?php
declare(strict_types=1);

namespace Vcg\Core;

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
        $request = $this->data['request'] ?? [];
        $method = $request['method'] ?? null;
        $url = $request['url'] ?? null;
        $headers = $request['headers'] ?? [];
        $body = $request['body'] ?? null;

        $this->requestLine();
        $this->methodLine($method);
        $this->urlLine($url);
        $this->headersLine();
        $this->linesList($headers);
        $this->bodyLine($body);
    }

    private function parseResponseLines(): void
    {
        $response = $this->data['response'] ?? [];
        $status = $response['status'] ?? [];
        $headers = $response['headers'] ?? [];
        $body = $response['body'] ?? [];

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
        $this->line('request');
    }

    private function methodLine(string $value = null)
    {
        $this->line('method', $value, $this->tab2);
    }

    private function urlLine(string $value = null)
    {
        $this->line('url', $value, $this->tab2);
    }

    private function headersLine()
    {
        $this->line('headers', null, $this->tab2);
    }

    private function bodyLine(string $value = null)
    {
        $this->line('body', $value, $this->tab2);
    }

    private function responseLine()
    {
        $this->line('response');
    }

    private function statusLine()
    {
        $this->line('status', null, $this->tab2);
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
