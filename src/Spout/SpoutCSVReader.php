<?php

namespace CaT\Libs\ExcelWrapper\Spout;

use \CaT\Libs\ExcelWrapper\Reader;
use \CaT\Libs\ExcelWrapper\CSVReader;
use \OpenSpout\Reader\Common\Creator\ReaderEntityFactory;

class SpoutCSVReader extends SpoutAbstractReader implements CSVReader
{
    public function __construct()
    {
        $this->reader = ReaderEntityFactory::createCSVReader();
    }

    public function setFieldDelimiter(string $fieldDelimiter): void
    {
        $this->reader->setFieldDelimiter($fieldDelimiter);

    }

    public function setFieldEnclosure(string $fieldEnclosure): void
    {
        $this->reader->setFieldEnclosure($fieldEnclosure);
    }

    public function setEncoding(string $encoding): void
    {
        $this->reader->setEncoding($encoding);
    }
}