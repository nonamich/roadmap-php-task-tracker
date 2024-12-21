<?php declare(strict_types=1);

namespace App\Interfaces;

use App\TaskModel;

interface RepositoryInterface
{
  public function add(string $description): TaskModel;
  public function update(TaskModel $task): void;
  public function delete(int $id): void;
  public function list(): array;
  public function getTaskByID(int $id): TaskModel|null;
}

