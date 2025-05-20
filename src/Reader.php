<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper;

/**
 * Interface for a Spout reader
 */
interface Reader
{
    /**
     * Open a file by filename/path
     * Sets the sheet iterator to the first sheet (if applicable)
     * and the row iterator to the first row
     */
    public function open(string $file_path): void;

    /**
     * Close the current file
     */
    public function close(): void;

    /**
     * Return the first row without moving the row iterator
     */
    public function getFirstRow(): ?array;

    /**
     * Return the current row and
     * move the row iterator to the next element
     */
    public function getRow(): ?array;
}