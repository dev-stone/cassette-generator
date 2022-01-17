<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\ValueObject\CassetteHolderList;
use Vcg\ValueObject\CassetteOutput;
use Vcg\ValueObject\CassetteOutputList;

class WriterPreprocessor
{
    private RecordOutputMaker $recordOutputMaker;

    public function __construct()
    {
        $this->recordOutputMaker = new RecordOutputMaker();
    }

    public function prepareCassettes(CassetteHolderList $cassetteHolderList): CassetteOutputList
    {
        $cassettesOutputList = new CassetteOutputList();

        foreach ($cassetteHolderList as $cassettesHolder) {
            foreach ($cassettesHolder->getCassettes() as $cassette) {
                $cassetteOutputString = '';
                foreach ($cassette->getRecords() as $record) {
                    $this->recordOutputMaker->make($record);
                    $recordParser = new RecordParser($record->getOutputData());
                    $cassetteOutputString .= $recordParser->parse();
                }
                $cassetteOutput = (new CassetteOutput())
                    ->setOutputPath($cassette->getOutputPath())
                    ->setOutputString($cassetteOutputString);
                $cassettesOutputList->add($cassetteOutput);
            }
        }

        return $cassettesOutputList;
    }
}
