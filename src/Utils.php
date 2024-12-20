<?php declare(strict_types=1);

namespace App;

use App\Enums\LoggerColor;

abstract class Utils
{
    static function paintLog(string $text, LoggerColor $scope = LoggerColor::INFO)
    {
        return "\033[" . $scope->value . "m" . $text . "\033[0m\n";
    }
}
