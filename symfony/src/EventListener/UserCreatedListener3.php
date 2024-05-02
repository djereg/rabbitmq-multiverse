<?php

namespace App\EventListener;

use App\Message\UserCreatedMessage3;
use Djereg\Symfony\RabbitMQ\Attribute\AsMessageEventListener;
use Djereg\Symfony\RabbitMQ\EventListener\MessageEventListener;

#[AsMessageEventListener('user.created')]
class UserCreatedListener3 extends MessageEventListener
{
    protected string $message = UserCreatedMessage3::class;
}
