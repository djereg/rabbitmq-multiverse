<?php

namespace App\Providers;

use Djereg\Laravel\RabbitMQ\Providers\ProcedureServiceProvider as ServiceProvider;

class ProcedureServiceProvider extends ServiceProvider
{
    public function shouldDiscoverProcedures(): bool
    {
        return true;
    }
}
