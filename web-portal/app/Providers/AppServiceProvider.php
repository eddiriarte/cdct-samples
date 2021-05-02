<?php

namespace App\Providers;

use App\Services\Clients\CustomerApiClient;
use App\Services\Clients\OrderApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrderApiClient::class,
            fn () => new OrderApiClient(config('api-dependencies.order_api.base_url'))
        );

        $this->app->bind(
            CustomerApiClient::class,
            fn () => new CustomerApiClient(config('api-dependencies.auth_api.base_url'))
        );
    }
}
