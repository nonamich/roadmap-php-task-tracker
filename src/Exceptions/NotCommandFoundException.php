<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Utils\Logger;

class NotCommandFoundException extends BaseException
{

    public function getCustomMessage()
    {
        return Logger::error($this->getMessage());
    }
}
