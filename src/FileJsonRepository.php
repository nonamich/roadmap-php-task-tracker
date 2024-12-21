<?php declare(strict_types=1);

namespace App;

use App\Enums\TaskStatus;
use App\Exceptions\NotFoundException;
use App\Interfaces\RepositoryInterface;
use App\Models\Task;

class FileJsonRepository implements RepositoryInterface
{
    private const FILE_NAME = 'database.json';
    private const DIR_NAME = 'database';
    public readonly string $filePath;

    public function __construct()
    {
        $this->filePath = getcwd() . DIRECTORY_SEPARATOR . self::DIR_NAME . DIRECTORY_SEPARATOR . self::FILE_NAME;

        $this->provideFile();
    }

    public function getByID(int $id): Task
    {
        $tasks = $this->getTasks();

        foreach ($tasks as $task) {
            if ($task->ID !== $id) {
                continue;
            }

            return $task;
        }

        throw new NotFoundException("Task (ID: $id) not found");
    }

    private function generateId()
    {
        $ids = array_map(fn($task) => $task->ID, $this->getTasks());
        $maxId = $ids ? max($ids) : 0;

        return (int) $maxId + 1;
    }

    public function add(string $description): Task
    {
        $newTask = new Task(
            ID: $this->generateId(),
            description: $description,
            createdAt: time(),
            updatedAt: time()
        );
        $tasks = $this->getTasks();
        $tasks[] = $newTask;

        $this->saveTasks($tasks);

        return $newTask;
    }

    public function update(Task $newTask): void
    {
        $tasks = $this->getTasks();

        foreach ($tasks as $index => $task) {
            if ($task->ID !== $newTask->ID) {
                continue;
            }

            $tasks[$index] = $newTask;

            break;
        }

        $newTask->updatedAt = time();

        $this->saveTasks($tasks);
    }

    public function delete(int $id): void
    {
        $tasks = $this->getTasks();

        foreach ($tasks as $index => $task) {
            if ($task->ID !== $id) {
                continue;
            }

            array_splice($tasks, $index, 1);

            break;
        }

        $this->saveTasks($tasks);
    }

    /**
     * @param Task[] $tasks
     */
    private function saveTasks(array $tasks)
    {
        file_put_contents(
            $this->filePath,
            json_encode($tasks, JSON_PRETTY_PRINT)
        );
    }

    /**
     * @return Task[]
     */
    public function list(TaskStatus|null $status = null): array
    {
        $tasks = $this->getTasks();

        if ($status) {
            return array_filter($tasks, fn($task) => $task->status === $status);
        }

        return $tasks;
    }

    private function isFileExists()
    {
        return file_exists($this->filePath);
    }

    private function isFileValid()
    {
        try {
            $this->getTasksOrThrow();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function getTasks()
    {
        try {
            return $this->getTasksOrThrow();
        } catch (\Throwable $e) {
            $this->provideFile();

            return $this->getTasks();
        }
    }

    private function getTasksOrThrow()
    {
        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true, flags: JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new \DomainException();
        }

        return array_map(function ($item) {
            return new Task(
                ID: $item['ID'],
                description: $item['description'],
                status: TaskStatus::from($item['status']),
                createdAt: $item['createdAt'],
                updatedAt: $item['updatedAt'],
            );
        }, array_values($data));
    }

    private function isFileExistsAndValid()
    {
        return $this->isFileExists() && $this->isFileValid();
    }

    private function provideFile()
    {
        if ($this->isFileExistsAndValid()) {
            return;
        }

        $this->createEmptyFile();
    }

    private function createEmptyFile()
    {
        if ($this->isFileExists()) {
            $timestamp = time();
            $backupPath = "{$this->filePath}-{$timestamp}.backup";

            rename($this->filePath, $backupPath);
        }

        $this->saveTasks([]);
    }
}
