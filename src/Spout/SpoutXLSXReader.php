<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper\Spout;

use CaT\Libs\ExcelWrapper\Reader;
use OpenSpout\Reader\ReaderInterface;
use OpenSpout\Reader\XLSX\Reader as XLSXReader;

class SpoutXLSXReader extends SpoutAbstractReader implements Reader
{
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

    protected function initReader(): void
    {
        $this->reader = new XLSXReader();
    }
}