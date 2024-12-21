<?php declare(strict_types=1);

namespace App\Utils;

abstract class Tabler
{
    /**
     * @param string[][] $table
     */
    static function output(array $table)
    {
        /**
         * @var string[]
         */
        $rows = [];
        /**
         * @var number[]
         */
        $columnsLength = [];

        foreach ($table as $rowIndex => $row) {
            foreach ($row as $columnIndex => $column) {
                $columnsLength[$columnIndex] = max(
                    $columnsLength[$columnIndex] ?? 0,
                    strlen($column)
                );
            }
        }

        foreach ($table as $rowIndex => $row) {
            $columns = [];

            foreach ($row as $columnIndex => $column) {
                $columnLength = $columnsLength[$columnIndex];

                $columns[] = str_pad($column, $columnLength);
            }

            $rows[] = implode(" | ", $columns);
        }

        return implode("\n", $rows);
    }
}
