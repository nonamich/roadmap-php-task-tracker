<?php declare(strict_types=1);

namespace App\Commands;

use App\Utils\Logger;
use App\Main;
use App\Interfaces\RepositoryInterface;

abstract class BaseCommand
{
    protected RepositoryInterface $repository;

    abstract public static function matchCommand($commandName): bool;

    abstract protected function run(): string;

    /**
     * @param string[] $arguments
     */
    public function __construct(
        readonly protected string $commandName,
        readonly protected array $arguments
    ) {
        $this->repository = Main::instance()->repository;

        $this->passOrThrow();
    }

    protected function passOrThrow()
    {
    }

    protected function output(string $message)
    {
        echo Logger::success($message);
    }

    final public function execute()
    {
        $this->output(
            $this->run()
        );
    }
}
