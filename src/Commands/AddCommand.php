<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Exceptions\ValidateException;

class AddCommand extends BaseCommand
{
    protected string $description;

    static public function getCommandName(): string
    {
        return 'add';
    }

    protected function parseArgumentsOrThrow()
    {
        @[$description] = $this->arguments;

        if (empty($description)) {
            throw new ValidateException('Description must be not empty');
        }

        $this->description = $description;
    }

    protected function getSuccessMessage(): string
    {
        return 'Task added successfully (ID: %s)';
    }

    public function execute(): string
    {
        $task = $this->repository->add($this->description);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID
        );
    }
}
