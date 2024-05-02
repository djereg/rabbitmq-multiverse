<?php

namespace App\Procedures;

use App\Services\NestService;
use App\Services\SymfonyService;
use Djereg\Laravel\RabbitMQ\Procedures\Procedure;
use Illuminate\Log\Logger;

class GetBestFriend extends Procedure
{
    public static string $name = 'getBestFriend';

    public function __construct(
        private readonly Logger $logger,
        private readonly NestService $nestjs,
        private readonly SymfonyService $symfony,
    ) {
        //
    }

    public function __invoke(): string
    {
        $this->logger->info("Handling getBestFriend RPC request to name my best friend.");
        $this->logger->info("Sending RPC request to my best friend to get their name.");

        $name = mt_rand(0, 1)
            ? $this->nestjs->getName()
            : $this->symfony->getName();

        $this->logger->info("My best friend's name: $name");
        return $name;
    }

}
