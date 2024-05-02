<?php

namespace App\EventListener;

use Djereg\Symfony\RabbitMQ\Attribute\AsMessageEventListener;
use Djereg\Symfony\RabbitMQ\Event\MessageEvent;
use Psr\Log\LoggerInterface;

readonly class UserListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        //
    }

    #[AsMessageEventListener('user.created')]
    public function userCreated(MessageEvent $event): void
    {
        $id = $event->getPayload()['id'];
        $this->logger->info("Event [user.created] received { id: $id }");
    }

    #[AsMessageEventListener('user.updated')]
    public function userUpdated(MessageEvent $event): void
    {
        $id = $event->getPayload()['id'];
        $this->logger->info("Event [user.updated] received { id: $id }");
    }
}
