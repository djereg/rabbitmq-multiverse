<?php

namespace App\Providers;

use App\Services\NestService;
use App\Services\SymfonyService;
use Djereg\Laravel\RabbitMQ\Services\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SymfonyService::class, function ($app) {

            // Create an instance of the RPC client
            $client = new Client('symfony', $app['queue.connection']);

            // Return a new instance of the service
            return new SymfonyService($client, $app['log']);
        });

        $this->app->singleton(NestService::class, function ($app) {

            // Create an instance of the RPC client
            $client = new Client('nestjs', $app['queue.connection']);

            // Return a new instance of the service
            return new NestService($client, $app['log']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
