<?php

namespace App\Listeners;

use Djereg\Laravel\RabbitMQ\Events\MessageEvent;
use Djereg\Laravel\RabbitMQ\Listeners\MessageEventListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Log\Logger;

class AsyncUserCreatedListener2 extends MessageEventListener implements ShouldQueue
{
    public static array $listen = [
        'user.created',
    ];

    public function __construct(
        private readonly Logger $logger,
    ) {
        //
    }

    public function onEvent(MessageEvent $event): void
    {
        $id = $event->get('id');
        $this->logger->info("Event [user.created] received { id: $id } @ AsyncUserCreatedListener2");
    }
}
