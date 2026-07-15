<?php

namespace Infinity\Decorator\Providers;

use Infinity\Decorator\Database\QueryDecorator;
use Infinity\Decorator\Database\QueryDecoratorContract;
use Illuminate\Support\ServiceProvider;

/**
 *
 */
class QueryDecoratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/query-decorator.php' => config_path('query-decorator.php'),
        ]);
    }

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(QueryDecoratorContract::class, QueryDecorator::class);
    }
}