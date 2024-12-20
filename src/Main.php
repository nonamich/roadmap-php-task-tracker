<?php declare(strict_types=1);


namespace App;

use App\Commander;
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
                commander: new Commander()
            );
        }

        return $instance;
    }
}
