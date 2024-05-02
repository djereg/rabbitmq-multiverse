<?php

namespace App\EventListener;

use Djereg\Symfony\RabbitMQ\Event\MessageReceivedEvent;
use Djereg\Symfony\RabbitMQ\Event\MessagePublishingEvent;
use Djereg\Symfony\RabbitMQ\Service\EnvelopeHeaders;
use Djereg\Symfony\RabbitMQ\Stamp\HeaderStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


readonly class CustomHeaders
{
    public function __construct(
        private LoggerInterface $logger,
        private EnvelopeHeaders $headers,
    ) {
        //
    }

    #[AsEventListener(MessagePublishingEvent::class)]
    public function setAppName(MessagePublishingEvent $event): void
    {
        $this->logger->info('Adding X-App-Name custom header to the message.');
        $event->addStamps(
            new HeaderStamp(['X-App-Name' => 'Symfony'])
        );
    }

    #[AsEventListener(MessageReceivedEvent::class)]
    public function getAppName(MessageReceivedEvent $event): void
    {
        $envelope = $event->getEnvelope();
        $name = $this->headers->get($envelope, 'X-App-Name', 'unknown');
        $this->logger->info("Reading X-App-Name custom header from the message { appName: $name }");
    }
}
