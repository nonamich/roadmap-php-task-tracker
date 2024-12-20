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

    protected function setArgumentsOrThrow()
    {
        @[$description] = $this->arguments;

        if (empty($description)) {
            throw new ValidateException();
        }

        $this->description = $description;
    }

    public function execute(): string
    {
        $task = $this->repository->add($this->description);

        return "$task->ID";
    }
}
