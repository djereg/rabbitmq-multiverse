<?php

namespace App\MessageHandler;

use App\Message\UserCreatedMessage1;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserCreatedMessageHandler1
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
        //
    }

    public function __invoke(UserCreatedMessage1 $message): void
    {
        $id = $message->getPayload()['id'];
        $this->logger->info("Event [user.created] received { id: $id } @ UserCreatedMessageHandler1");
    }
}
