<?php declare(strict_types=1);

namespace App\Enums;

enum TaskStatus
{
    case TODO = "todo";
    case DONE = "done";
    case IN_PROGRESS = "in-progress";
}
