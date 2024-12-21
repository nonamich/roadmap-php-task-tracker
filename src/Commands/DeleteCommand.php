<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidateException;

class DeleteCommand extends BaseCommand
{
    protected int $id;

    static public function matchCommand($commandName): bool
    {
        return $commandName === 'delete';
    }

    protected function passOrThrow()
    {
        @[$id] = $this->arguments;

        if (empty($id) || !is_numeric($id)) {
            throw new ValidateException('id must be valid');
        }

        $this->id = (int) $id;
    }

    protected function getSuccessMessage(): string
    {
        return 'Task deleted successfully (ID: %s)';
    }

    protected function run(): string
    {
        $task = $this->repository->getByID($this->id);

        $this->repository->delete($task->ID);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID
        );
    }
}
