<?php

namespace App\Providers;

use App\Services\GeneratorService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Сервис провайдер генерации случайной строки
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GeneratorService', function () {
            return new GeneratorService();
        });
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
    }
}
