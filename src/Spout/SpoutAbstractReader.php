<?php

namespace CaT\Libs\ExcelWrapper\Spout;

use CaT\Libs\ExcelWrapper\Reader;
use \OpenSpout\Reader\ReaderInterface;
use \OpenSpout\Common\Entity\Row;

abstract class SpoutAbstractReader implements Reader
{
    protected ReaderInterface $reader;
    protected \Iterator $sheet_iterator;
    protected \Iterator $row_iterator;

    public function open(string $file_path): void
    {
        $this->reader->open($file_path);
        $this->initIterators();
    }

    public function close(): void
    {
        $this->reader->close();
    }

    public function getFirstRow(): ?array
    {
        $this->row_iterator->rewind();
        if (!$this->row_iterator->valid()) {
            return null;
        }

        return $this->row_iterator
            ->current()
            ->toArray();
    }

    public function getRow(): ?array
    {
        if (!$this->row_iterator->valid()) {
            return null;
        }

        $row = $this->row_iterator
            ->current()
            ->toArray();
        $this->row_iterator->next();
        return $row;
    }

    protected function initIterators()
    {
        $this->sheet_iterator = $this->reader->getSheetIterator();
        $this->sheet_iterator->rewind();
        $this->row_iterator = $this->sheet_iterator->current()->getRowIterator();
        $this->row_iterator->rewind();
    }
}

