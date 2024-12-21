<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidateException;

class UpdateCommand extends BaseCommand
{
    protected int $id;
    protected string $description;

    static public function matchCommand($commandName): bool
    {
        return $commandName === 'update';
    }

    protected function passOrThrow()
    {
        @[$id, $description] = $this->arguments;

        if (empty($id) || !is_numeric($id)) {
            throw new ValidateException('id must be valid');
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

    protected function run(): string
    {
        $task = $this->repository->getByID($this->id);

        $task->description = $this->description;

        $this->repository->update($task);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID
        );
    }
}
