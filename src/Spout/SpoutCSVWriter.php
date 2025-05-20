<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper\Spout;

use OpenSpout\Common\Entity\Cell\StringCell;
use \CaT\Libs\ExcelWrapper\Writer;

use OpenSpout\Writer\CSV\Options;
use OpenSpout\Writer\CSV\Writer as CSVWriter;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use OpenSpout\Writer\WriterInterface;
use OpenSpout\Common\Entity\Style\Style;

/**
 * Export a single material list
 */
class SpoutCSVWriter implements Writer
{
    protected ?WriterInterface $writer = null;

    public function __construct(
        protected string $fieldDelimiter,
        protected string $fieldEnclosure,
    ) {
    }

    public function openFile(string $file_path, string $file_name): void
    {
        $options = new Options();
        $options->FIELD_DELIMITER = $this->fieldDelimiter;
        $options->FIELD_ENCLOSURE = $this->fieldEnclosure;
        $this->writer = new CSVWriter($options);
        $this->getWriter()->openToFile($file_path . $file_name);
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
            fn ($value) => new StringCell($value, null),
            $values
        );
        $row = new Row($cells, null);
        $this->getWriter()->addRow($row);
    }

    /**
     * @inheritdoc
     */
    public function addSeparatorRow(): void
    {
        $row = new Row([], null);
        $this->getWriter()->addRow($row);
    }

    /**
     * @inheritdoc
     */
    public function addEmptyRow(): void
    {
        $row = new Row([], null);
        $this->getWriter()->addRow($row);
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
        $this->getWriter()->close();
    }

    protected function getWriter(): WriterInterface
    {
        if(is_null($this->writer)) {
            throw new WriterNotOpenedException();
        }
        return $this->writer;
    }
}