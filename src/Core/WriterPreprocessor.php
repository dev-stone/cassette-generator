<?php
declare(strict_types=1);

namespace Vcg\Core;

use Vcg\ValueObject\CassetteOutput;
use Vcg\ValueObject\CassettesHolder;

class WriterPreprocessor
{
    private RecordOutputMaker $recordOutputMaker;

    public function __construct()
    {
        $this->recordOutputMaker = new RecordOutputMaker();
    }

    /**
     * @var CassettesHolder[] $cassettesHolders
     * @return CassetteOutput[]
     */
    public function prepareCassettes(array $cassettesHolders): array
    {
        $cassettesOutputs = [];

        foreach ($cassettesHolders as $cassettesHolder) {
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
                $cassettesOutputs[] = $cassetteOutput;
            }
        }

        return $cassettesOutputs;
    }
}
