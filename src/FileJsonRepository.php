<?php declare(strict_types=1);

namespace App;

use App\Enums\TaskStatus;
use App\Interfaces\RepositoryInterface;

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

    public function getTaskByID(int $id): TaskModel|null
    {
        $tasks = $this->getTasks();

        foreach ($tasks as $task) {
            if ($task->ID !== $id) {
                continue;
            }

            return $task;
        }

        return null;
    }

    private function generateId()
    {
        $ids = array_map(fn($task) => $task->ID, $this->getTasks());
        $maxId = $ids ? max($ids) : 0;

        return (int) $maxId + 1;
    }

    public function add(string $description): TaskModel
    {
        $newTask = new TaskModel(
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

    public function update(TaskModel $newTask): void
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

            unset($tasks[$index]);

            break;
        }

        $this->saveTasks($tasks);
    }

    /**
     * @param TaskModel[] $tasks
     */
    private function saveTasks(array $tasks)
    {
        file_put_contents(
            $this->filePath,
            json_encode($tasks, JSON_PRETTY_PRINT)
        );
    }

    /**
     * @return TaskModel[]
     */
    public function list(): array
    {
        return $this->getTasks();
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
            return new TaskModel(
                ID: $item['ID'],
                description: $item['description'],
                status: TaskStatus::from($item['status']),
                createdAt: $item['createdAt'],
                updatedAt: $item['updatedAt'],
            );
        }, $data);
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
