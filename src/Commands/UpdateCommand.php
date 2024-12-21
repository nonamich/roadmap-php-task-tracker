<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidateException;

class UpdateCommand extends BaseCommand
{
    protected int $id;
    protected string $description;

    static public function getCommandName(): string
    {
        return 'update';
    }

    protected function parseArgumentsOrThrow()
    {
        @[$id, $description] = $this->arguments;

        if (empty($id) || !is_numeric($id)) {
            throw new ValidateException('id must be not empty');
        }

        if (empty($description)) {
            throw new ValidateException('Description must be not empty');
        }

        $this->id = (int) $id;
        $this->description = $description;
    }

    protected function getSuccessMessage(): string
    {
        return 'Task updated successfully (ID: %s)';
    }

    public function execute(): string
    {
        $task = $this->repository->getTaskByID($this->id);

        if (!$task) {
            throw new NotFoundException("Task (ID: $this->id) not found");
        }

        $task->description = $this->description;

        $this->repository->update($task);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID
        );
    }
}
