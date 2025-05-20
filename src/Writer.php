<?php

namespace CaT\Libs\ExcelWrapper;

use OpenSpout\Common\Entity\Style\Style AS SPOUT_STYLE;

interface Writer
{
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
	public function setColumnStyle(string $column, SPOUT_STYLE $style): void;

	/**
	 * Add a new row to the current sheet.
	 */
	public function addRow(array $values): void;

	/**
	 * Add a new empty row with border top
	 */
	public function addSeparatorRow(): void;

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