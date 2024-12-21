<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Enums\TaskStatus;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidateException;
use App\Models\Task;
use App\Utils\Tabler;

class ListCommand extends BaseCommand
{
    private TaskStatus|null $status = null;

    static public function matchCommand($commandName): bool
    {
        return $commandName === 'list';
    }


    protected function passOrThrow()
    {
        @[$status] = $this->arguments;

        if ($status) {
            $statusEnum = TaskStatus::tryFrom($status);

            if ($statusEnum) {
                $this->status = $statusEnum;
            } else {
                throw new ValidateException('status must be valid');
            }
        }
    }

    protected function output(string $message)
    {
        echo $message . PHP_EOL;
    }

    /**
     * @return string[]
     */
    private function columns()
    {
        return ['ID', 'Description', 'Status', 'Create At', 'Updated At'];
    }


    /**
     * @return string[]
     */
    private function row(Task $task)
    {
        $format = 'Y-m-d G:i:s';
        $createAt = date($format, $task->createdAt);
        $updatedAt = date($format, $task->updatedAt);

        return [(string) $task->ID, $task->description, $task->status->value, $createAt, $updatedAt];
    }

    protected function run(): string
    {
        $tasks = $this->repository->list($this->status);

        if (!$tasks) {
            if ($this->status) {
                throw new NotFoundException("No tasks found with status '{$this->status->value}'");
            } else {
                throw new NotFoundException("No tasks found");
            }
        }

        /**
         * @var string[][]
         */
        $table = [
            $this->columns(),
        ];

        foreach ($tasks as $task) {
            $table[] = $this->row($task);
        }

        return Tabler::output($table);
    }
}
