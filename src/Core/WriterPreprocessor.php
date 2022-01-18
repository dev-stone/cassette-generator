<?php

declare(strict_types=1);

namespace Vcg\Core;

use Vcg\ValueObject\Cassette;
use Vcg\ValueObject\CassetteHolderList;
use Vcg\ValueObject\CassetteOutput;
use Vcg\ValueObject\CassetteOutputList;
use Vcg\ValueObject\CassettesHolder;
use Vcg\ValueObject\Record;

class WriterPreprocessor
{
    private RecordOutputMaker $recordOutputMaker;
    private CassetteOutputList $cassettesOutputList;

    public function __construct()
    {
        $this->recordOutputMaker = new RecordOutputMaker();
    }

    public function prepareCassettesOutput(CassetteHolderList $cassetteHolderList): CassetteOutputList
    {
        $this->cassettesOutputList = new CassetteOutputList();

        foreach ($cassetteHolderList as $cassettesHolder) {
            $this->processCassettesHolder($cassettesHolder);
        }

        return $this->cassettesOutputList;
    }

    private function processCassettesHolder(CassettesHolder $cassettesHolder): void
    {
        foreach ($cassettesHolder->getCassettes() as $cassette) {
            $this->processCassette($cassette);
        }
    }

    private function processCassette(Cassette $cassette): void
    {
        $cassetteOutputString = $this->makeCassetteOutputString($cassette);
        $cassetteOutput = (new CassetteOutput())
            ->setOutputPath($cassette->getOutputPath())
            ->setOutputString($cassetteOutputString);
        $this->cassettesOutputList->add($cassetteOutput);
    }

    private function makeCassetteOutputString(Cassette $cassette): string
    {
        $cassetteOutputString = '';
        foreach ($cassette->getRecords() as $record) {
            $cassetteOutputString = $this->makeRecordOutputString($record, $cassetteOutputString);
        }

        return $cassetteOutputString;
    }

    private function makeRecordOutputString(Record $record, string $cassetteOutputString): string
    {
        $this->recordOutputMaker->make($record);
        $recordParser = new RecordParser($record->getOutputData());
        $cassetteOutputString .= $recordParser->parse();

        return $cassetteOutputString;
    }
}
