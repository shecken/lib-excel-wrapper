<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper\Spout;

use CaT\Libs\ExcelWrapper\Reader;
use OpenSpout\Reader\Common\Creator\ReaderFactory;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use OpenSpout\Reader\ReaderInterface;

abstract class SpoutAbstractReader implements Reader
{
    protected ?ReaderInterface $reader = null;
    protected \Iterator $sheet_iterator;
    protected \Iterator $row_iterator;

    public function open(string $file_path): void
    {
        $this->initReader();
        $this->getReader()->open($file_path);
        $this->initIterators();
    }

    public function close(): void
    {
        $this->getReader()->close();
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

    protected function initIterators(): void
    {
        $this->sheet_iterator = $this->getReader()->getSheetIterator();
        $this->sheet_iterator->rewind();
        $this->row_iterator = $this->sheet_iterator->current()->getRowIterator();
        $this->row_iterator->rewind();
    }

    protected function getReader(): ReaderInterface
    {
        if(is_null($this->reader)) {
            throw new ReaderNotOpenedException();
        }
        return $this->reader;
    }

    protected abstract function initReader(): void;
}

