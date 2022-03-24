<?php

namespace App\Providers;

use App\Repositories\Interfaces\UrlsRepository;
use App\Services\Interfaces\UrlChecker;
use App\Services\Interfaces\UrlCreator;
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
        $this->app->bind(UrlCreator::class, \App\Services\UrlCreator::class);
        $this->app->bind(UrlChecker::class, \App\Services\GoogleApiUrlChecker::class);
        $this->app->bind(UrlsRepository::class, \App\Repositories\UrlsRepository::class);
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
