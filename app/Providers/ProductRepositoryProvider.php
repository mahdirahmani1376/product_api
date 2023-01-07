<?php

namespace App\Providers;

use App\Repositories\ProductInterface;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryProvider extends ServiceProvider
{

    /**
     * @var array
     */
    public $bindings = [
        ProductInterface::class => ProductRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
