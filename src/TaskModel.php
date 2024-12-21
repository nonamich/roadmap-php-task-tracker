<?php declare(strict_types=1);

namespace App;

use App\Enums\TaskStatus;

class TaskModel
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
