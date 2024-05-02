<?php

namespace App\Service;

use Djereg\Symfony\RabbitMQ\Contract\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class NestService
{
    public function __construct(
        #[Autowire(service: 'nestjs_client')]
        private ClientInterface $client,
        private LoggerInterface $logger,
    ) {
        //
    }

    public function getName(): string
    {
        $this->logger->info("Calling NestJS service to get its name.");
        $startTime = microtime(true);
        $response = $this->client->call('getName', [], 5);
        $time = round((microtime(true) - $startTime) * 1000);
        $this->logger->info("Received response in $time ms from NestJS service: $response");

        return $response;
    }

    public function getBestFriend(): string
    {
        $this->logger->info("Calling NestJS service to get its best friend.");
        $startTime = microtime(true);
        $response = $this->client->call('getBestFriend', [], 5);
        $time = round((microtime(true) - $startTime) * 1000);
        $this->logger->info("Received response in $time ms from NestJS service: $response");

        return $response;
    }

    public function chainCall(int $counter): string
    {
        $this->logger->info("Making a chainCall to NestJS service { counter: $counter }");
        $startTime = microtime(true);
        $response = $this->client->call('chainCall', ['counter' => $counter], 5);
        $time = round((microtime(true) - $startTime) * 1000);
        $this->logger->info("Received response in $time ms from NestJS service: $response");

        return $response;
    }
}
