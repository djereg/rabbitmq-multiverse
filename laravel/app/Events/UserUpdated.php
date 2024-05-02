<?php

namespace App\Events;

use Djereg\Laravel\RabbitMQ\Events\MessagePublishEvent;

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
