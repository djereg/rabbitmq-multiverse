<?php

namespace App\Event;

use Djereg\Symfony\RabbitMQ\Event\MessagePublishEvent;

class UserUpdated extends MessagePublishEvent
{
    protected string $event = 'user.updated';

    public function __construct(
        private readonly int $id,
    ) {
        //
    }

    public function payload(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
