<?php declare(strict_types=1);

namespace App\Interfaces;

use App\Enums\TaskStatus;
use App\Models\Task;

interface RepositoryInterface
{
  public function add(string $description): Task;
  public function update(Task $task): void;
  public function delete(int $id): void;
  public function list(TaskStatus|null $status = null): array;
  public function getByID(int $id): Task;
}

