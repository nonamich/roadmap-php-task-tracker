<?php declare(strict_types=1);

namespace App\Commands;

use App\Main;
use App\Interfaces\RepositoryInterface;

abstract class BaseCommand
{
    protected RepositoryInterface $repository;

    abstract public static function getCommandName(): string;

    abstract public function execute(): string;

    /**
     * @param string[] $arguments
     */
    public function __construct(readonly protected array $arguments)
    {
        $this->repository = Main::instance()->repository;

        $this->passOrThrow();
    }

    private function passOrThrow()
    {
        $this->parseArgumentsOrThrow();
    }

    protected function parseArgumentsOrThrow()
    {
    }

    abstract protected function getSuccessMessage(): string;
}
