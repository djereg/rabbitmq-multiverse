<?php

namespace App\RemoteProcedure;

use App\Service\NestService;
use App\Service\LaravelService;
use Djereg\Symfony\RabbitMQ\Attribute\AsRemoteProcedure;
use Psr\Log\LoggerInterface;

#[AsRemoteProcedure('chainCall')]
readonly class ChainCall
{
    public function __construct(
        private NestService $nest,
        private LaravelService $laravel,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function __invoke(int $counter): string
    {
        $this->logger->info('Handling a chainCall RPC request.');

        if ($counter <= 0) {
            return 'Symfony';
        }

        $response = mt_rand(0, 1)
            ? $this->nest->chainCall($counter - 1)
            : $this->laravel->chainCall($counter - 1);

        return 'Symfony, ' . $response;

    }
}
