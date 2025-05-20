<?php

use \CaT\Libs\ExcelWrapper\Spout\SpoutCSVReader;
use \CaT\Libs\ExcelWrapper\Spout\SpoutXLSXReader;
use PHPUnit\Framework\TestCase;

class SpoutReaderTest extends TestCase
{
    protected SpoutCSVReader $csv_reader;
    protected SpoutXLSXReader $xlsx_reader;
    protected string $csv_filename;
    protected string $xlsx_filename;

    protected function setUp(): void
    {
        $this->csv_reader = new SpoutCSVReader();
        $this->csv_filename = __DIR__ . '/sample_data.csv';

        $this->xlsx_reader = new SpoutXLSXReader();
        $this->xlsx_filename = __DIR__ . '/sample_data.xlsx';
    }

    public function test_open_close_CSV()
    {
        $this->expectNotToPerformAssertions();
        $this->csv_reader->open($this->csv_filename);
        $this->csv_reader->close();
    }

    public function test_open_close_XLSX()
    {
        $this->expectNotToPerformAssertions();
        $this->xlsx_reader->open($this->xlsx_filename);
        $this->xlsx_reader->close();
    }

    public function test_getFirstRow()
    {
        $this->csv_reader->open($this->csv_filename);
        $this->assertEquals(['Firstname', 'Lastname', 'E-Mail'], $this->csv_reader->getFirstRow());
        $this->assertEquals(['Firstname', 'Lastname', 'E-Mail'], $this->csv_reader->getRow());
        $this->csv_reader->close();
    }

    public function test_getRow()
    {
        $this->csv_reader->open($this->csv_filename);
        $this->assertEquals(['Firstname', 'Lastname', 'E-Mail'], $this->csv_reader->getRow());
        $this->csv_reader->close();
    }

    public function test_getRow_multiple()
    {
        $this->csv_reader->open($this->csv_filename);
        $this->csv_reader->getRow();
        $this->csv_reader->getRow();
        $this->assertEquals(['Mia', 'Miller', 'mia@miller.org'], $this->csv_reader->getRow());
        $this->csv_reader->close();
    }

    public function test_end_of_file()
    {
        $this->csv_reader->open($this->csv_filename);
        $cnt = 0;
        while ($row = $this->csv_reader->getRow()) {
            $cnt++;
        }
        $this->assertEquals(3, $cnt);
        $this->csv_reader->close();
    }

    public function test_value_conversion()
    {
        $this->xlsx_reader->open($this->xlsx_filename);
        $this->xlsx_reader->selectSheet(2);
        $this->xlsx_reader->getRow();
        $row = $this->xlsx_reader->getRow();
        $this->assertIsString($row[0]);
        $this->assertIsInt($row[1]);
        $this->assertIsFloat($row[2]);
        $this->assertInstanceOf('DateTimeImmutable', $row[3]);
        $this->assertEquals(['Milk', 12345, 2.5, new DateTimeImmutable('2024-01-24')], $row);
        $this->xlsx_reader->close();
    }
}