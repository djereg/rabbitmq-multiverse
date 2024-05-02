<?php

namespace App\Listeners;

use Djereg\Laravel\RabbitMQ\Events\MessageProcessing;
use Djereg\Laravel\RabbitMQ\Events\MessagePublishing;
use Psr\Log\LoggerInterface;

readonly class CustomHeaders
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        //
    }

    public function handlePublishing(MessagePublishing $event): void
    {
        $this->logger->info('Adding X-App-Name custom header to the message.');
        $event->setHeaders(['X-App-Name' => 'Laravel']);
    }

    public function handleProcessing(MessageProcessing $event): void
    {
        $name = $event->headers->get('X-App-Name') ?? 'unknown';
        $this->logger->info("Reading X-App-Name custom header from the message { appName: $name }");
    }
}
