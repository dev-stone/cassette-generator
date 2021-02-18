<?php
declare(strict_types=1);

namespace Vcg\Writer;

use Vcg\Maker\CassettesHolder;
use Vcg\Maker\RecordOutputMaker;

class WriterPreprocessor
{
    private RecordOutputMaker $recordOutputMaker;

    public function __construct(RecordOutputMaker $recordOutputMaker)
    {
        $this->recordOutputMaker = $recordOutputMaker;
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
