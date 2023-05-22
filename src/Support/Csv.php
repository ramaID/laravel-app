<?php

namespace Support;

class Csv
{
    public function __construct(
        public string $filePath,
    ) {
    }

    public function row($callback)
    {
        $this->open(function ($handle) use ($callback) {
            $columns = array_filter(fgetcsv($handle, 1000, ';'));

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                $row = [];

                for ($i = 0; $i < count($data); $i++) {
                    $row[$columns[$i]] = $data[$i];
                }

                $callback($row);
            }

            fclose($handle);
        });
    }

    public function open($callback)
    {
        $handle = fopen($this->filePath, 'r');

        return $callback($handle);
    }
}
