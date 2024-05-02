<?php

namespace App\RemoteProcedure;

use App\Service\LaravelService;
use App\Service\NestService;
use Djereg\Symfony\RabbitMQ\Attribute\AsRemoteProcedure;
use Psr\Log\LoggerInterface;

readonly class GetBestFriend
{
    public function __construct(
        private NestService $nest,
        private LaravelService $laravel,
        private LoggerInterface $logger,
    ) {
        //
    }

    #[AsRemoteProcedure]
    public function getBestFriend(): string
    {
        $this->logger->info("Handling getBestFriend RPC request to name my best friend.");
        $this->logger->info("Sending RPC request to my best friend to get their name.");

        $name = mt_rand(0, 1)
            ? $this->nest->getName()
            : $this->laravel->getName();

        $this->logger->info("My best friend's name: $name");
        return $name;
    }

}
