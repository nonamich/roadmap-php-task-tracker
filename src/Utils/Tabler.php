<?php declare(strict_types=1);

namespace App\Utils;

use App\Enums\LoggerColor;

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

            if ($rowIndex === 0) {
                $columns = array_map(
                    fn($column) => Logger::withColor($column, LoggerColor::INFO),
                    $columns
                );
            }

            $rows[] = implode(" | ", $columns);
        }

        return implode("\n", $rows);
    }
}
