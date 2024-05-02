<?php

namespace App\Listeners;

use Djereg\Laravel\RabbitMQ\Events\MessageProcessing;
use Djereg\Laravel\RabbitMQ\Events\MessagePublishing;
use Illuminate\Log\Logger;

readonly class MessageListener
{
    public function __construct(
        private Logger $logger,
    ) {
        //
    }

    public function handleProcessing(MessageProcessing $event): void
    {
        $type = $event->headers->get('X-Message-Type');
        $this->logger->info("Message processing { type: $type }");
    }

    public function handleProcessed(MessageProcessing $event): void
    {
        $type = $event->headers->get('X-Message-Type');
        $this->logger->info("Message processed { type: $type }");
    }

    public function handlePublishing(MessagePublishing $event): void
    {
        $type = $event->getHeader('X-Message-Type', 'unknown');
        $this->logger->info("Message publishing { type: $type }");
    }
}
