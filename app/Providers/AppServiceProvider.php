<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ApiProvider;
use App\Services\API\ApiProvider1;
use App\Services\API\ApiProvider2;
use App\Services\Planning\PlanningService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiProvider::class, ApiProvider2::class);
        $this->app->singleton(PlanningService::class, function($app){
            return new PlanningService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
