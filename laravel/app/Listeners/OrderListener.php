<?php

namespace App\Listeners;

use Djereg\Laravel\RabbitMQ\Events\MessageEvent;
use Djereg\Laravel\RabbitMQ\Listeners\MessageEventListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Log\LoggerInterface;

class OrderListener extends MessageEventListener implements ShouldQueue
{
    public static array $listen = [
        'order.created',
        'order.updated',
    ];

    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    protected function onOrderCreated(MessageEvent $event): void
    {
        $id = $event->get('id');
        $this->logger->info("Event [order.created] received { id: $id }");
    }

    protected function onOrderUpdated(MessageEvent $event): void
    {
        $id = $event->get('id');
        $this->logger->info("Event [order.updated] received { id: $id }");
    }
}
