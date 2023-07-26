<?php

namespace App\Providers;

use App\Services\FileUploadService;
use App\Services\Implementation\FileUploadServiceImplementation;
use App\Services\Implementation\LinkServiceImpl;
use App\Services\LinkService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileUploadService::class, FileUploadServiceImplementation::class);
        $this->app->bind(LinkService::class, LinkServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
