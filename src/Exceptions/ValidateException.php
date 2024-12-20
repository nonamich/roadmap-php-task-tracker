<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\LoggerColor;

class ValidateException extends BaseException
{
    protected LoggerColor $color = LoggerColor::ERROR;
}
