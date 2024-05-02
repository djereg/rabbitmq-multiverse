<?php

namespace App\RemoteProcedure;

use Djereg\Symfony\RabbitMQ\Attribute\AsRemoteProcedure;
use Psr\Log\LoggerInterface;

#[AsRemoteProcedure('getName')]
readonly class GetName
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        //
    }

    public function __invoke(): string
    {
        $this->logger->info("Handling getName RPC request.");
        return 'Symfony';
    }
}
