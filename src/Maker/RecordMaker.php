<?php
declare(strict_types=1);

namespace Vcg\Maker;

use Vcg\Collector\AppendModifier;

class RecordMaker
{
    public function makeOutputData(Record $record): void
    {
        $recordDefaults = $record->getRecordDefaultsModel();
        $requestModel = $recordDefaults->getRequestModel();
        $responseModel = $recordDefaults->getResponseModel();
        $outputData = [
            'request' => [
                'method' => $requestModel->getMethod(),
                'url' => $requestModel->getUrl()
            ],
            'response' => []
        ];
        foreach ($requestModel->getHeaders() as $key => $value) {
            $outputData['request']['headers'][$key] = $value;
        }
        foreach ($responseModel->getStatus() as $key => $value) {
            $outputData['response']['status'][$key] = $value;
        }
        foreach ($responseModel->getHeaders() as $key => $value) {
            $outputData['response']['headers'][$key] = $value;
        }

        $record->setOutputData($outputData);
    }

    public function appendData(Record $record)
    {
        $outputData = $record->getOutputData();
        foreach ($record->getAppendItems() as $append => $value) {
            [$root, $list, $key] = explode('|', $append);
            $outputItem = $outputData[$root][$list][$key];

            $addQuote = '';
            if (strrpos($outputItem, "'") === strlen($outputItem)-1) {
                $addQuote = "'";
                $outputItem = substr($outputItem, 0, -1);
            }

            $outputItem = $outputItem . $value . $addQuote;
            $outputData[$root][$list][$key] = $outputItem;
        }

        $record->setOutputData($outputData);
    }

    public function makeRequestBody(Record $record)
    {

        $xmlContent = file_get_contents($record->getRequestBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = str_replace('"', '\"', $xmlContent);
        $xmlContent = $xmlContent . '\n';
        $xmlContent = '"' . $xmlContent . '"';

        $outputData = $record->getOutputData();
        $outputData['request']['body'] = $xmlContent;
        $record->setOutputData($outputData);
    }

    public function makeResponseBody(Record $record)
    {
        $xmlContent = file_get_contents($record->getResponseBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = '\'' . $xmlContent . '\'';

        $outputData = $record->getOutputData();
        $outputData['response']['body'] = $xmlContent;
        $record->setOutputData($outputData);
    }

    private function trimSpaces(string $xmlContent)
    {
        $xmlContent = trim($xmlContent);
        $xmlContent = preg_replace('/>\s*/', '>', $xmlContent);
        $xmlContent = preg_replace('/\s*</', '<', $xmlContent);

        return str_replace('?><', '?>\n<', $xmlContent);
    }
}
