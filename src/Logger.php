<?php declare(strict_types=1);

namespace App;

use App\Enums\LoggerColor;

abstract class Logger
{
    public static function error(string $message)
    {
        return self::getMessage($message, LoggerColor::ERROR);
    }

    public static function success(string $message)
    {
        return self::getMessage($message, LoggerColor::SUCCESS);
    }

    private static function getMessage(string $message, LoggerColor $scope)
    {
        $SCOPE = self::withColor($scope->name, $scope);

        return "[$SCOPE]: $message";
    }

    private static function withColor(string $text, LoggerColor $scope)
    {
        return "\033[" . $scope->value . "m" . $text . "\033[0m";
    }
}
