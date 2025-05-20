<?php

use \CaT\Libs\ExcelWrapper\Spout\SpoutCSVReader;
use PHPUnit\Framework\TestCase;

class SpoutCSVReaderTest extends TestCase
{
    protected SpoutCSVReader $reader;
    protected string $filename;
    protected string $filename2;

    public function test_setFieldDelimiter()
    {
        $reader = new SpoutCSVReader(',');
        $reader->open(__DIR__ . '/sample_data.csv');
        $this->assertEquals(['Firstname','Lastname','E-Mail'], $reader->getRow());
        $reader->close();


        $reader = new SpoutCSVReader(';');
        $reader->open(__DIR__ . '/sample_data.csv');
        $this->assertEquals(['Firstname,Lastname,E-Mail'], $reader->getRow());
        $reader->close();
    }

    public function test_setFieldEnclosure()
    {
        // test file with enclosure
        $reader = new SpoutCSVReader(',', '"');
        $reader->open(__DIR__ . '/sample_data_2.csv');
        $this->assertEquals(['Firstname','Lastname','E-Mail'], $reader->getRow());
        $reader->close();

        // test if enclosure is optional
        $reader = new SpoutCSVReader(',', '"');
        $reader->open(__DIR__ . '/sample_data.csv');
        $this->assertEquals(['Firstname','Lastname','E-Mail'], $reader->getRow());
        $reader->close();
    }

    public function test_setEncoding()
    {
        $reader = new SpoutCSVReader(',', '"', 'UTF-8');
        $reader->open(__DIR__ . '/sample_data.csv');
        $reader->getRow();
        $row = $reader->getRow();
        $this->assertEquals('Müller', $row[1]);
        $reader->close();

        // test with incorrect encoding
        $reader = new SpoutCSVReader(',', '"', 'ISO-8859-1');
        $reader->open(__DIR__ . '/sample_data.csv');
        $reader->getRow();
        $row = $reader->getRow();
        $this->assertNotEquals('Müller', $row[1]);
        $reader->close();
    }
}