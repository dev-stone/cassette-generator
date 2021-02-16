<?php
declare(strict_types=1);

namespace Vcg\CassettesHolder;

use Vcg\Configuration;
use Vcg\Parser\YamlParser;

class RecordBuilder
{
    private Configuration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function createRecord(array $recordDefaults, array $recordSettings): Record
    {
        $recordDefaults = $this->configuration->getCassetteSettings();


        $parser = new DatumParser();
        $outputString = $parser->parse($recordDefaults);

        return (new Record())->setOutputString($outputString);
    }

    private function collectDatum()
    {

    }
}
