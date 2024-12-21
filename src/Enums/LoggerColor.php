<?php declare(strict_types=1);

namespace App\Enums;

enum LoggerColor: int
{
    case ERROR = 31;
    case SUCCESS = 32;
    case WARNING = 33;
    case INFO = 36;
}
