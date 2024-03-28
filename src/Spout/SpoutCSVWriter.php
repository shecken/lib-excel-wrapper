<?php

namespace CaT\Libs\ExcelWrapper\Spout;

use Box\Spout\Common\Entity\Cell;
use \CaT\Plugins\MateriaList\ilActions;
use \CaT\Libs\ExcelWrapper\Writer;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\WriterInterface;
use Box\Spout\Common\Entity\Style\Style;

/**
 * Export a single material list
 */
class SpoutCSVWriter implements Writer
{
    protected WriterInterface $writer;
    protected ?string $file_name = null;
    protected ?string $file_path = null;

    public function __construct()
    {
        $this->writer = WriterEntityFactory::createCSVWriter();
    }

    /**
     * Open file for spout
     *
     * @return null
     * @throws \LogicException if path or file name is not set.
     *
     */
    public function openFile(): void
    {
        if ($this->file_path === null || $this->file_name === null) {
            throw new \LogicException(__METHOD__ . " path or filename is not set.");
        }

        $this->writer->openToFile($this->getFilePath());
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
        $row = new Row($cells, null);
        $this->writer->addRow($row);
    }

    /**
     * @inheritdoc
     */
    public function addSeperatorRow(): void
    {
        $row = new Row([], null);
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

    /**
     * Sets the field delimiter for the CSV
     *
     * @api
     */
    public function setFieldDelimiter(string $fieldDelimiter): void
    {
        $this->writer->setFieldDelimiter($fieldDelimiter);
    }

    /**
     * Sets the field enclosure for the CSV
     *
     * @api
     */
    public function setFieldEnclosure(string $fieldEnclosure): void
    {
        $this->writer->setFieldEnclosure($fieldEnclosure);
    }
}