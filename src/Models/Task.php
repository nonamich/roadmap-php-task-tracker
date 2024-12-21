<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskStatus;

class Task
{
    public function __construct(
        public readonly int $ID,
        public string $description,
        public int $createdAt,
        public int $updatedAt,
        public TaskStatus $status = TaskStatus::TODO,
    ) {
    }
}
