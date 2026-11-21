<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Sections\SectionRepositoryInterface;
use App\Repositories\Sections\SectionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            SectionRepositoryInterface::class,
            SectionRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
