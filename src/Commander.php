<?php declare(strict_types=1);

namespace App;


use App\Commands\{BaseCommand, AddCommand, UpdateCommand};

class Commander
{

    /**
     * @var array<BaseCommand>
     */
    private $commands = [
        AddCommand::class,
        UpdateCommand::class,
    ];

    /**
     * @param string[] $arguments
     */
    public function execute(string $commandName, array $arguments)
    {
        foreach ($this->commands as $CommandClass) {
            if ($CommandClass::getCommandName() !== $commandName) {
                continue;
            }

            $command = new $CommandClass($arguments);

            echo Logger::success($command->execute());

            return;
        }

        throw new \DomainException("Unknown $commandName command");
    }
}
