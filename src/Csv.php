<?php

namespace Macocci7\PhpCsv;

class Csv
{
    protected $csv;
    protected $headline;
    protected $offset;
    protected $columns;
    protected $castType;

    /**
     * constructor
     */
    public function __construct(string $path = null)
    {
        if (!is_null($path)) {
            $this->load($path);
        }
    }

    /**
     * loads csv fromt $path
     * @param   string  $path
     * @return  self
     */
    public function load(string $path)
    {
        if (!file_exists($path)) {
            throw new \Exception('File does not exist:[' . $path . ']');
        }
        $this->csv = array_map('str_getcsv', file($path));
        return $this;
    }

    /**
     * saves $this->csv into a csv file
     * @param   string  $path
     * @return  self
     */
    public function save(string $path = null)
    {
        if (is_null($path)) {
            $path = $this->newFilename();
        }
        if (strlen($path) < 1) {
            $path = $this->newFilename();
        }
        $f = function ($line): string {
            return '"' . implode('","', $line) . '"';
        };
        if (
            !file_put_contents($path, implode("\n", array_map($f, $this->csv)))
        ) {
            $message = "failed to save data into csv [" . $path . "].";
            throw new \Exception($message);
        }
        return $this;
    }

    /**
     * returns a new file name
     * @param
     * @return  string
     */
    public function newFilename()
    {
        $name = 'new.csv';
        $i = 0;
        while (file_exists($name)) {
            $i++;
            $name = 'new_' . $i . '.csv';
        }
        return $name;
    }

    /**
     * encodes csv from $from to $to
     * @param   string  $from
     * @param   string  $to
     * @return  self
     */
    public function encode(string $from, string $to)
    {
        foreach ($this->csv as $index => $row) {
            foreach ($row as $column => $value) {
                if (!is_null($value)) {
                    $this->csv[$index][$column]
                    = mb_convert_encoding($value, $to, $from);
                }
            }
        }
        return $this;
    }

    /**
     * returns rows of csv
     * @param
     * @return  integer
     */
    public function rows()
    {
        return count($this->csv);
    }

    /**
     * returns (max) columns of csv
     * @param
     * @return  integer
     */
    public function columns()
    {
        return max(array_map('count', $this->csv));
    }

    /**
     * sets casting type as bool
     * @param
     * @return self
     */
    public function bool()
    {
        $this->castType = 'bool';
        return $this;
    }

    /**
     * sets casting type as integer
     * @param
     * @return  self
     */
    public function int()
    {
        $this->castType = 'int';
        return $this;
    }

    /**
     * sets casting type as float
     * @param
     * @return  self
     */
    public function float()
    {
        $this->castType = 'float';
        return $this;
    }


    /**
     * sets casting type as string
     * @param
     * @return  self
     */
    public function string()
    {
        $this->castType = 'string';
        return $this;
    }

    /**
     * sets casting type as raw data
     * @param
     * @return  self
     */
    public function raw()
    {
        $this->castType = null;
        return $this;
    }

    /**
     * sets offset of lines to skip
     * @param   int $offset
     * @return  self
     */
    public function offset(int $offset)
    {
        if ($offset < 0) {
            throw new \Exception('specify a natural number.');
        }
        $this->offset = $offset;
        return $this;
    }

    /**
     * returns the ($row)th row
     * @param   int $row
     * @return  array
     */
    public function row(int $row)
    {
        if ($row < 1) {
            return;
        }
        if (empty($this->csv)) {
            return;
        }
        if ($row > count($this->csv)) {
            return;
        }
        return $this->csv[$row - 1];
    }

    /**
     * returns ($column)th column
     * @param   int $column
     * @return  array
     */
    public function column(int $column)
    {
        if ($column < 0) {
            return;
        }
        $csv = $this->offset
             ? array_slice($this->csv, $this->offset)
             : $this->csv;
        $data = array_column($csv, $column);
        if (!$data) {
            return;
        }
        if ($this->castType) {
            foreach ($data as $index => $value) {
                if (0 === strcmp('bool', $this->castType)) {
                    $data[$index] = (bool) $value;
                }
                if (0 === strcmp('int', $this->castType)) {
                    $data[$index] = (int) $value;
                }
                if (0 === strcmp('float', $this->castType)) {
                    $data[$index] = (float) $value;
                }
                if (0 === strcmp('string', $this->castType)) {
                    $data[$index] = (string) $value;
                }
            }
        }
        return $data;
    }

    /**
     * dumps $this->csv as csv
     * @param
     * @return  string
     */
    public function dump()
    {
        $f = function ($line): string {
            return '"' . implode('","', $line) . '"';
        };
        return implode("\n", array_map($f, $this->csv));
    }

    /**
     * returns csv as an array]
     * @param
     * @return  array
     */
    public function dumpArray()
    {
        return $this->csv;
    }

    /**
     * clears loaded csv data
     * @param
     * @return  self
     */
    public function clear()
    {
        $this->csv = null;
        return $this;
    }

    /**
     * future version
     */
    /*
    public function dumpHash()

    public function cell()

    public function rowsBetween()

    public function columnByName()

    public function columnsByNames()

    public function columnsBetween()

    public function deleteRows()

    public function deleteColumns()

    public function range()

    public function appendRows()

    public function appendColumns()

    public function insertRows()

    public function insertColumns()

    public function replaceCell()

    public function replaceRow()

    public function replaceColumn()

    public function swapCells()

    public function swapRows()

    public function swapColumns()
    */
}
