<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Utils;
use App\Enums\LoggerColor;

abstract class BaseException extends \Exception
{
    protected LoggerColor $color;

    public function getCustomMessage()
    {
        $message = $this->getMessage();
        $SCOPE = Utils::paintLog(
            strtoupper($this->color->name),
            $this->color
        );

        return "[$SCOPE]: $message";
    }
}
