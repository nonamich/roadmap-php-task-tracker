<?php declare(strict_types=1);

namespace App;

use App\Enums\TaskStatus;

class TaskModel
{
    public function __construct(
        public readonly int $ID,
        public readonly string $description,
        public readonly int $createdAt,
        public readonly int $updatedAt = $this->$createdAt,
        public readonly TaskStatus $status = TaskStatus::TODO,
    ) {
    }
}
