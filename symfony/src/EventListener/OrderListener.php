<?php

namespace App\EventListener;

use App\Event\UserUpdated;
use Djereg\Symfony\RabbitMQ\Attribute\AsMessageEventListener;
use Djereg\Symfony\RabbitMQ\Event\MessageEvent;
use Djereg\Symfony\RabbitMQ\Service\EventDispatcher;
use Psr\Log\LoggerInterface;

readonly class OrderListener
{
    public function __construct(
        private LoggerInterface $logger,
        private EventDispatcher $dispatcher,
    ) {
        //
    }

    #[AsMessageEventListener('order.created')]
    public function orderCreated(MessageEvent $event): void
    {
        $id = $event->getPayload()['id'];
        $this->logger->info("Event [order.created] received { id: $id }");

        $this->logger->info("Dispatching UserUpdated event");
        $this->dispatcher->dispatch(new UserUpdated(mt_rand(1, 1000)));
    }

    #[AsMessageEventListener('order.updated')]
    public function orderUpdated(MessageEvent $event): void
    {
        $id = $event->getPayload()['id'];
        $this->logger->info("Event [order.updated] received { id: $id }");

        $this->logger->info("Dispatching UserUpdated event");
        $this->dispatcher->dispatch(new UserUpdated(mt_rand(1, 1000)));
    }
}
