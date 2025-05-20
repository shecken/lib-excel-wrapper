<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper\Spout;

use OpenSpout\Common\Helper\EncodingHelper;
use OpenSpout\Reader\CSV\Reader as CSVReader;
use OpenSpout\Reader\CSV\Options as CSVOptions;
use OpenSpout\Reader\ReaderInterface;

class SpoutCSVReader extends SpoutAbstractReader
{
    public function __construct(
        protected string $fieldDelimiter = ',',
        protected string $fieldEnclosure = '"',
        protected string $encoding = EncodingHelper::ENCODING_UTF8,
    ) {
    }

    protected function initReader(): void
    {
        $options = new CSVOptions();
        $options->FIELD_DELIMITER = $this->fieldDelimiter;
        $options->FIELD_ENCLOSURE = $this->fieldEnclosure;
        $options->ENCODING = $this->encoding;
        $this->reader = new CSVReader($options);
    }
}