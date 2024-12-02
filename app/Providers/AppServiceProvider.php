<?php

namespace App\Providers;

use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Services\RajaOngkirService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepositoryImplement;
use App\Repositories\Category\CategoryRepositoryImplement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImplement::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImplement::class);
        $this->app->singleton(RajaOngkirService::class, function ($app) {
            return new RajaOngkirService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
    }
}
