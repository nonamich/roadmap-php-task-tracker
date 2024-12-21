<?php declare(strict_types=1);

namespace App;

use App\Commands\BaseCommand;

class Commander
{

    /**
     * @var class-string<BaseCommand>[]
     */
    private $Commands = [];

    /**
     * @param class-string<BaseCommand> $Command
     */
    public function addCommand(string $Command)
    {
        $this->Commands[] = $Command;
    }

    /**
     * @param string[] $arguments
     */
    public function execute(string $commandName, array $arguments)
    {
        foreach ($this->Commands as $Command) {
            if (!$Command::matchCommand($commandName)) {
                continue;
            }

            $command = new $Command($commandName, $arguments);

            $command->execute();

            return;
        }

        throw new \DomainException("Unknown $commandName command");
    }
}
