<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Utils\Logger;

class NotFoundException extends BaseException
{

    public function getCustomMessage()
    {
        return Logger::info($this->getMessage());
    }
}
