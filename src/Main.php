<?php declare(strict_types=1);


namespace App;

use App\Commander;
use App\Commands\{
    AddCommand,
    UpdateCommand,
    DeleteCommand,
    ListCommand,
    MarkCommand
};
use App\FileJsonRepository;
use App\Interfaces\RepositoryInterface;

final class Main
{

    private function __construct(
        public readonly RepositoryInterface $repository,
        public readonly Commander $commander
    ) {
    }

    public static function instance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new self(
                repository: new FileJsonRepository(),
                commander: self::initCommander()
            );
        }

        return $instance;
    }

    private static function initCommander()
    {
        $commander = new Commander();

        $commander->addCommand(UpdateCommand::class);
        $commander->addCommand(AddCommand::class);
        $commander->addCommand(DeleteCommand::class);
        $commander->addCommand(ListCommand::class);
        $commander->addCommand(MarkCommand::class);

        return $commander;
    }
}
