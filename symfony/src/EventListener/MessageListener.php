<?php

namespace App\EventListener;

use Djereg\Symfony\RabbitMQ\Event\MessageProcessedEvent;
use Djereg\Symfony\RabbitMQ\Event\MessageProcessingEvent;
use Djereg\Symfony\RabbitMQ\Event\MessagePublishingEvent;
use Djereg\Symfony\RabbitMQ\Service\EnvelopeHeaders;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

readonly class MessageListener
{
    public function __construct(
        private LoggerInterface $logger,
        private EnvelopeHeaders $headers,
    ) {
    }

    #[AsEventListener(MessageProcessingEvent::class)]
    public function processing(MessageProcessingEvent $event): void
    {
        $type = $event->getHeaders()['X-Message-Type'] ?? 'unknown';
        $this->logger->info("Message processing { type: $type }");
    }

    #[AsEventListener(MessageProcessedEvent::class)]
    public function processed(MessageProcessedEvent $event): void
    {
        $type = $event->getHeaders()['X-Message-Type'] ?? 'unknown';
        $this->logger->info("Message processed { type: $type }");
    }

    #[AsEventListener(MessagePublishingEvent::class)]
    public function sending(MessagePublishingEvent $event): void
    {
        $envelope = $event->getEnvelope();
        $type = $this->headers->get($envelope, 'X-Message-Type', 'unknown');
        $this->logger->info("Message sending { type: $type }");
    }
}
