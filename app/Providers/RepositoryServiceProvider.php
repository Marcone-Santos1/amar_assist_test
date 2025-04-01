<?php

namespace App\Providers;

use App\Domain\Products\Repositories\EloquentProductImageRepository;
use App\Domain\Products\Repositories\ProductImageRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Domain\Products\Repositories\ProductRepositoryInterface;
use App\Domain\Products\Repositories\EloquentProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(ProductImageRepositoryInterface::class, EloquentProductImageRepository::class);
    }
}
