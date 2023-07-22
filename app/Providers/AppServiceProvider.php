<?php

namespace App\Providers;

use App\Services\FileUploadService;
use App\Services\Implementation\FileUploadServiceImplementation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileUploadService::class, FileUploadServiceImplementation::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
