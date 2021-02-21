<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\Configuration\Config;
use Vcg\ValueObject\Record;

class RecordOutputMaker
{
    public function make(Record $record): self
    {
        $this->makeOutputData($record)
            ->appendData($record)
            ->rewriteData($record)
            ->makeRequestBody($record)
            ->makeResponseBody($record);

        return $this;
    }

    private function makeOutputData(Record $record): self
    {
        $recordDefaults = $record->getRecordDefaultsModel();
        $requestModel = $recordDefaults->getRequestModel();
        $responseModel = $recordDefaults->getResponseModel();
        $outputData = [
            Config::REQUEST => [
                Config::METHOD => $requestModel->getMethod(),
                Config::URL => $requestModel->getUrl()
            ],
            Config::RESPONSE => []
        ];
        foreach ($requestModel->getHeaders() as $key => $value) {
            $outputData[Config::REQUEST][Config::HEADERS][$key] = $value;
        }
        foreach ($responseModel->getStatus() as $key => $value) {
            $outputData[Config::RESPONSE][Config::STATUS][$key] = $value;
        }
        foreach ($responseModel->getHeaders() as $key => $value) {
            $outputData[Config::RESPONSE][Config::HEADERS][$key] = $value;
        }

        $record->setOutputData($outputData);

        return $this;
    }

    private function appendData(Record $record): self
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

        return $this;
    }

    private function rewriteData(Record $record): self
    {
        $outputData = $record->getOutputData();
        foreach ($record->getRewriteItems() as $rewrite => $value) {
            /**
             * @todo Rewrite feature
             */
        }

//        $record->setOutputData($outputData);

        return $this;
    }

    private function makeRequestBody(Record $record): self
    {

        $xmlContent = file_get_contents($record->getRequestBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = str_replace('"', '\"', $xmlContent);
        $xmlContent = $xmlContent . '\n';
        $xmlContent = '"' . $xmlContent . '"';

        $outputData = $record->getOutputData();
        $outputData[Config::REQUEST][Config::BODY] = $xmlContent;
        $record->setOutputData($outputData);

        return $this;
    }

    private function makeResponseBody(Record $record): self
    {
        $xmlContent = file_get_contents($record->getResponseBodyPath());
        $xmlContent = $this->trimSpaces($xmlContent);
        $xmlContent = '\'' . $xmlContent . '\'';

        $outputData = $record->getOutputData();
        $outputData[Config::RESPONSE][Config::BODY] = $xmlContent;
        $record->setOutputData($outputData);

        return $this;
    }

    private function trimSpaces(string $xmlContent)
    {
        $xmlContent = trim($xmlContent);
        $xmlContent = preg_replace('/>\s*/', '>', $xmlContent);
        $xmlContent = preg_replace('/\s*</', '<', $xmlContent);

        return str_replace('?><', '?>\n<', $xmlContent);
    }
}
