<?php

namespace Janitor\Glide;

use League\Glide\Server;
use League\Glide\ServerFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;

class GlideServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/../config/glide.php' => config_path('glide.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(
            Server::class,
            function () {
                $filesystem = $this->app->make(Filesystem::class);

                return ServerFactory::create([
                    'source' => $filesystem->getDriver(),
                    'cache' => $filesystem->getDriver(),
                    'source_path_prefix' => config('glide.source_path_prefix'),
                    'cache_path_prefix' => config('glide.cache_path_prefix'),
                    'base_url' => config('glide.base_url'),
                ]);
            }
        );

        $this->app->singleton(
            Glide::class,
            function () {
                return new \Janitor\Glide\Glide(
                    $this->app->make(Server::class),
                    $this->app->make(Factory::class)
                );
            }
        );
    }

    public function provides()
    {
        return [
            Server::class,
            Glide::class,
        ];
    }
}
