<?php
declare(strict_types=1);

namespace Vcg\CassettesHolder;

use Vcg\Exceptions\MissingRequestKeyException;
use Vcg\Exceptions\MissingResponseKeyException;

class DatumParser
{
    private string $yaml = '';
    private string $tab1 = '    ';
    private string $tab2;
    private string $tab3;

    public function __construct()
    {
        $this->tab2 = $this->tab1 . $this->tab1;
        $this->tab3 = $this->tab1 . $this->tab1 . $this->tab1;
    }

    public function parse(array $datum): string
    {
        $this->validateDatum($datum);
        $this->writeLines($datum);

        return $this->yaml;
    }

    private function writeLines(array $datum): void
    {
        $request = $datum['request'];
        $response = $datum['response'];

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

    private function validateDatum(array $datum)
    {
        if (!array_key_exists('request', $datum)) {
            throw new MissingRequestKeyException('request');
        }
        $request = $datum['request'];
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

        if (!array_key_exists('response', $datum)) {
            throw new MissingResponseKeyException('response');
        }
        $response = $datum['response'];
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

    private function resetYaml()
    {
        $this->yaml = '';
    }
}
