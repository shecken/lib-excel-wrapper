<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper\Spout;

use \CaT\Libs\ExcelWrapper\Writer;

use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Writer\WriterInterface;
use OpenSpout\Common\Entity\Style\Style AS SPOUT_STYLE;
use OpenSpout\Common\Entity\Style\Border AS SPOUT_BORDER;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;

/**
 * Export a single material list
 */
class SpoutWriter implements Writer
{
    protected WriterInterface $writer;
    protected ?SPOUT_STYLE $style = null;

	public function __construct(
        protected int $max_column_count,
    ) {

	}

	public function openFile(string $file_path, string $file_name): void
    {
        $this->writer = new XLSXWriter();
        $this->writer->openToFile($file_path.$file_name);
    }

	/**
	 * @return StringCell[]
	 */
	public function getEmptyValueArray(bool $with_spaces = false): array
    {
        $text = "";
        if($with_spaces) {
            $text = " ";
        }

        $cell = new StringCell($text, null);
		$ret = [];
		for ($i=0; $i < $this->max_column_count; $i++) {
            $ret = $cell;
		}

		return $ret;
	}

	/**
	 * @inheritdoc
	 */
	public function createSheet(string $sheet_name): void
    {
		$new_sheet = $this->writer->addNewSheetAndMakeItCurrent();
		$new_sheet->setName($sheet_name);
	}

	/**
	 * @inheritdoc
	 */
	public function selectSheet(string $sheet_name): void
    {
	}

	/**
	 * @inheritdoc
	 */
	public function setColumnStyle(string $column, SPOUT_STYLE $style): void
    {
		$this->style = $style;
	}

	/**
	 * @inheritdoc
	 */
	public function addRow(array $values): void
    {
        $values = array_map(
            fn ($v) => new StringCell($v, null),
            $values
        );
        $row = new Row($values, $this->style);
		$this->writer->addRow($row);
	}

	/**
	 * @inheritdoc
	 */
	public function addSeparatorRow(): void
    {
        $style = new SPOUT_STYLE();
        $part = new BorderPart(SPOUT_BORDER::BOTTOM);
        $spout_border = new SPOUT_BORDER($part);
        $style->setBorder($spout_border);

		$this->writer->addRow(new Row($this->getEmptyValueArray(true), $style));
	}

	/**
	 * Add new empty row
	 */
	public function addEmptyRow(): void
    {
		$this->writer->addRow(new Row($this->getEmptyValueArray(), null));
	}

    public function saveFile(): void
    {
    }

	/**
	 * @inheritdoc
	 */
	public function close(): void
    {
		$this->writer->close();
	}
}