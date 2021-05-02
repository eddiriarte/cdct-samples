<?php

namespace App\Providers;

use App\Services\Clients\CustomerApiClient;
use App\Services\Clients\PaymentApiClient;
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
            PaymentApiClient::class,
            fn () => new PaymentApiClient(config('api-dependencies.payment_api.base_url'))
        );

        $this->app->bind(
            CustomerApiClient::class,
            fn () => new CustomerApiClient(config('api-dependencies.customer_api.base_url'))
        );
    }
}
