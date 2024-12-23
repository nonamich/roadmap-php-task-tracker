<?php declare(strict_types=1);

namespace App\Utils;

use App\Enums\LoggerColor;

abstract class Logger
{
    public static function error(string $message)
    {
        return self::getMessage($message, LoggerColor::ERROR);
    }

    public static function info(string $message)
    {
        return self::getMessage($message, LoggerColor::INFO);
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

    public static function withColor(string $text, LoggerColor $scope)
    {
        return "\033[" . $scope->value . "m" . $text . "\033[0m";
    }
}
