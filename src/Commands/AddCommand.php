<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Exceptions\ValidateException;

class AddCommand extends BaseCommand
{
    protected string $description;

    static public function matchCommand($commandName): bool
    {
        return $commandName === 'add';
    }

    protected function passOrThrow()
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

    protected function run(): string
    {
        $task = $this->repository->add($this->description);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID
        );
    }
}
