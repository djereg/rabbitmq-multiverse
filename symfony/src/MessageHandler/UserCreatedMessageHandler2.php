<?php

namespace App\MessageHandler;

use App\Message\UserCreatedMessage2;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserCreatedMessageHandler2
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        //
    }

    public function __invoke(UserCreatedMessage2 $message): void
    {
        $id = $message->getPayload()['id'];
        $this->logger->info("Event [user.created] received { id: $id } @ UserCreatedMessageHandler2");
    }
}
