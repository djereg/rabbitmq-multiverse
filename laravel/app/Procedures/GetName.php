<?php

namespace App\Procedures;

use Djereg\Laravel\RabbitMQ\Procedures\Procedure;
use Illuminate\Log\Logger;

class GetName extends Procedure
{
    public static string $name = 'getName';

    public function __construct(
        private readonly Logger $logger,
    ) {
        //
    }

    public function __invoke(): string
    {
        $this->logger->info('Handling getName RPC request.');
        return 'Laravel';
    }
}
