<?php

namespace CaT\Libs\ExcelWrapper\Spout;

use \CaT\Plugins\MateriaList\ilActions;
use \CaT\Libs\ExcelWrapper\Writer;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Cell;
use Box\Spout\Writer\WriterInterface;
use Box\Spout\Common\Entity\Style\Style;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\BorderPart;

/**
 * Export a single material list
 */
class SpoutWriter implements Writer
{
    protected WriterInterface $writer;
    protected ?string $file_name = null;
    protected ?string $file_path = null;
    protected int $max_column_count;
    protected Style $style;

    public function __construct()
    {
        $this->writer = WriterEntityFactory::createXLSXWriter();
    }

    /**
     * Open file for spout
     *
     * @throws \LogicException if path or file name is not set.
     */
    public function openFile(): void
    {
        if ($this->file_path === null || $this->file_name === null) {
            throw new \LogicException(__METHOD__ . " path or filename is not set.");
        }

        $this->writer->openToFile($this->getFilePath());
    }

    /**
     * Set the number of columns the sheet will be filled in
     */
    public function setMaximumColumnCount(int $max_column_count): void
    {
        $this->max_column_count = $max_column_count;
    }

    /**
     * Get a values array according to max column count
     *
     * @return Cell[]
     */
    protected function getEmptyValueArray(bool $with_spaces = false): array
    {
        $ret = [];
        for ($i = 0; $i < $this->max_column_count; $i++) {
            if ($with_spaces) {
                $ret[] = new Cell(' ');
            } else {
                $ret[] = new Cell('');
            }
        }

        return $ret;
    }

    /**
     * @inheritdoc
     */
    public function setFileName(string $file_name): void
    {
        $this->file_name = $file_name;
    }

    /**
     * @inheritdoc
     */
    public function setPath(string $file_path): void
    {
        $this->file_path = $file_path;
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
    public function setColumnStyle(string $column, Style $style): void
    {
        $this->style = $style;
    }

    /**
     * @inheritdoc
     */
    public function addRow(array $values): void
    {
        $cells = array_map(
            fn ($value) => new Cell($value),
            $values
        );
        $row = new Row($cells, $this->style);
        $this->writer->addRow($row);
    }

    /**
     * @inheritdoc
     */
    public function addSeperatorRow(): void
    {
        $border_top = new BorderPart('top');
        $border = new Border([$border_top]);
        $style = new Style();
        $style->setBorder($border);

        $row = new Row($this->getEmptyValueArray(true), $style);
        $this->writer->addRow($row);
    }

    /**
     * @inheritdoc
     */
    public function addEmptyRow(): void
    {
        $row = new Row([], null);
        $this->writer->addRow($row);
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    protected function getFilePath(): string
    {
        return ($this->file_path ?? '') . ($this->file_name ?? '');
    }
}