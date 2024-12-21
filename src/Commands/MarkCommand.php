<?php declare(strict_types=1);

namespace App\Commands;

use App\Commands\BaseCommand;
use App\Enums\TaskStatus;
use App\Exceptions\{NotFoundException, ValidateException};

class MarkCommand extends BaseCommand
{
    private const COMMAND_PREFIX = "mark-";
    protected int $id;

    private TaskStatus $status;

    static public function matchCommand($commandName): bool
    {
        try {
            self::getStatusByCommand($commandName);

            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    static function getStatusByCommand(string $commandName)
    {
        $guessStatus = str_replace(
            self::COMMAND_PREFIX,
            '',
            $commandName
        );
        $status = TaskStatus::tryFrom($guessStatus);

        if (!$status) {
            throw new NotFoundException("No status found with '{$guessStatus}'");
        }

        return $status;
    }

    protected function passOrThrow()
    {
        @[$id] = $this->arguments;

        if (empty($id) || !is_numeric($id)) {
            throw new ValidateException('id must be valid');
        }

        $this->status = self::getStatusByCommand($this->commandName);
        $this->id = (int) $id;
    }

    protected function getSuccessMessage(): string
    {
        return 'Task (ID: %s) marked as %s';
    }

    protected function run(): string
    {
        $task = $this->repository->getByID($this->id);

        $task->status = $this->status;

        $this->repository->update($task);

        return sprintf(
            $this->getSuccessMessage(),
            $task->ID,
            $task->status->value
        );
    }
}
