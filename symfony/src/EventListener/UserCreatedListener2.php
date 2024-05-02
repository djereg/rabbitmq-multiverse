<?php

namespace App\EventListener;

use App\Message\UserCreatedMessage2;
use Djereg\Symfony\RabbitMQ\Attribute\AsMessageEventListener;
use Djereg\Symfony\RabbitMQ\EventListener\MessageEventListener;

#[AsMessageEventListener('user.created')]
class UserCreatedListener2 extends MessageEventListener
{
    protected string $message = UserCreatedMessage2::class;
}
