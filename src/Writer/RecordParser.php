<?php
declare(strict_types=1);

namespace Vcg\Writer;

use Vcg\Exceptions\MissingRequestKeyException;
use Vcg\Exceptions\MissingResponseKeyException;

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
        $this->validateData();
        $this->writeLines();

        return $this->yaml;
    }

    private function validateData()
    {
        if (!array_key_exists('request', $this->data)) {
            throw new MissingRequestKeyException('request');
        }
        $request = $this->data['request'];
        if (!array_key_exists('method', $request)) {
            throw new MissingRequestKeyException('method');
        }
        if (!array_key_exists('url', $request)) {
            throw new MissingRequestKeyException('url');
        }
        if (!array_key_exists('headers', $request)) {
            throw new MissingRequestKeyException('headers');
        }
        if (!array_key_exists('body', $request)) {
            throw new MissingRequestKeyException('body');
        }

        if (!array_key_exists('response', $this->data)) {
            throw new MissingResponseKeyException('response');
        }
        $response = $this->data['response'];
        if (!array_key_exists('status', $response)) {
            throw new MissingResponseKeyException('status');
        }
        if (!array_key_exists('headers', $response)) {
            throw new MissingResponseKeyException('headers');
        }
        if (!array_key_exists('body', $response)) {
            throw new MissingResponseKeyException('body');
        }
    }

    private function markBegin()
    {
        $this->yaml .= $this->mark;
    }

    private function addRequest()
    {
        $this->addLine('request');
    }

    private function addMethod(string $value = null)
    {
        $this->addLine('method', $value, $this->tab2);
    }

    private function addUrl(string $value = null)
    {
        $this->addLine('url', $value, $this->tab2);
    }

    private function addHeaders()
    {
        $this->addLine('headers', null, $this->tab2);
    }

    private function addBody(string $value = null)
    {
        $this->addLine('body', $value, $this->tab2);
    }

    private function addResponse()
    {
        $this->addLine('response');
    }

    private function addStatus()
    {
        $this->addLine('status', null, $this->tab2);
    }

    private function addList(array $items)
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

    private function writeLines(): void
    {
        $this->markBegin();

        $request = $this->data['request'];
        $response = $this->data['response'];

        $this->addRequest();
        $this->addMethod($request['method']);
        $this->addUrl($request['url']);
        $this->addHeaders();
        $this->addList($request['headers']);
        $this->addBody($request['body']);

        $this->addResponse();
        $this->addStatus();
        $this->addList($response['status']);
        $this->addHeaders();
        $this->addList($response['headers']);
        $this->addBody($response['body']);
    }
}
