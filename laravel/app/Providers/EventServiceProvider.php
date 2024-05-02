<?php

namespace App\Providers;

use Djereg\Laravel\RabbitMQ\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
