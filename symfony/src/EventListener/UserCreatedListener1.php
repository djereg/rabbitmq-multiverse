<?php

namespace App\EventListener;

use App\Message\UserCreatedMessage1;
use Djereg\Symfony\RabbitMQ\Attribute\AsMessageEventListener;
use Djereg\Symfony\RabbitMQ\EventListener\MessageEventListener;

#[AsMessageEventListener('user.created')]
class UserCreatedListener1 extends MessageEventListener
{
    protected string $message = UserCreatedMessage1::class;
}
