<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Djereg\Laravel\RabbitMQ\Events\MessageEvent;
use Djereg\Laravel\RabbitMQ\Listeners\MessageEventListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Log\Logger;

class UserListener extends MessageEventListener implements ShouldQueue
{
    public static array $listen = [
        'user.created',
        'user.updated',
    ];

    public function __construct(
        private readonly Logger $logger,
    ) {
        //
    }

    public function onUserCreated(MessageEvent $event): void
    {
        $id = $event->get('id');
        $this->logger->info("Event [user.created] received { id: $id }");

        $this->logger->info('Dispatching UserUpdated event');
        event(new UserUpdated($id));
    }

    public function onUserUpdated(MessageEvent $event): void
    {
        $id = $event->get('id');
        $this->logger->info("Event [user.updated] received { id: $id }");
    }
}
