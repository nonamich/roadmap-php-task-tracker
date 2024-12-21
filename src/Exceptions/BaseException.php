<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Utils\Logger;

abstract class BaseException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct(message: $message);
    }

    public function getCustomMessage()
    {
        return Logger::error($this->getMessage());
    }
}
