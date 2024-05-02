<?php

namespace App\Procedures;

use App\Services\NestService;
use App\Services\SymfonyService;
use Djereg\Laravel\RabbitMQ\Procedures\Procedure;
use Psr\Log\LoggerInterface;

class ChainCall extends Procedure
{
    public static string $name = 'chainCall';

    public function __construct(
        private readonly NestService $nestjs,
        private readonly SymfonyService $symfony,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function __invoke(int $counter): string
    {
        $this->logger->info('Handling a chainCall RPC request.');

        if ($counter <= 0) {
            return 'Laravel';
        }

        $response = mt_rand(0, 1)
            ? $this->nestjs->chainCall($counter - 1)
            : $this->symfony->chainCall($counter - 1);

        return 'Laravel, ' . $response;
    }
}
