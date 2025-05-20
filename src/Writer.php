<?php

namespace CaT\Libs\ExcelWrapper;

/**
 * Interface for a excel stream writer.
 * Defines recommended and expected functions.
 *
 * @author Stefan Hecken    <stefan.hecken@concepts-and-training.de>
 */
interface Writer
{
    /**
     * Set name of the created xlsx file
     */
    public function setFileName(string $file_name): void;

    /**
     * Set path to save the file
     */
    public function setPath(string $file_path): void;

    /**
     * Creates a new sheet in the workbook
     */
    public function createSheet(string $sheet_name): void;

    /**
     * Switch the current sheet of workbook
     */
    public function selectSheet(string $sheet_name): void;

    /**
     * Set the style for a single column
     */
    public function setColumnStyle(string $column, \OpenSpout\Common\Entity\Style\Style $style): void;

    /**
     * Add a new row to the current sheet.
     */
    public function addRow(array $values): void;

    /**
     * Add a new empty row with border top
     */
    public function addSeperatorRow(): void;

    /**
     * Add new empty row
     */
    public function addEmptyRow(): void;

    /**
     * Save the created file
     */
    public function saveFile(): void;

    /**
     * Close the stream writer
     */
    public function close(): void;
}