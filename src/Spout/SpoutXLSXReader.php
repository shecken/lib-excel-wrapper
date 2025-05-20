<?php

namespace CaT\Libs\ExcelWrapper\Spout;

use CaT\Libs\ExcelWrapper\Reader;
use CaT\Libs\ExcelWrapper\XLSXReader;
use \OpenSpout\Reader\Common\Creator\ReaderEntityFactory;

class SpoutXLSXReader extends SpoutAbstractReader implements XLSXReader
{
    public function __construct()
    {
        $this->reader = ReaderEntityFactory::createXLSXReader();
    }

    public function selectSheet(int $sheet_number): void
    {
        $this->sheet_iterator->rewind();
        $current_sheet = 1;
        while ($current_sheet < $sheet_number) {
            $this->sheet_iterator->next();
            if (!$this->sheet_iterator->valid()) {
                throw new \Exception('Sheet '. $sheet_number . ' not found in file');
            }
            $current_sheet++;
        }
        $this->row_iterator = $this->sheet_iterator->current()->getRowIterator();
        $this->row_iterator->rewind();
    }

    public function selectNextSheet(): bool
    {
        $this->sheet_iterator->next();
        if (!$this->sheet_iterator->valid()) {
            return false;
        }
        $this->row_iterator = $this->sheet_iterator->current()->getRowIterator();
        $this->row_iterator->rewind();
        return true;
    }
}