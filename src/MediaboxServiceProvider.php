<?php

namespace Codrasil\Mediabox;

use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Http\Routes\MediaboxRoutes;
use Codrasil\Mediabox\Http\Routes\StorageRoutes;
use Codrasil\Mediabox\Mediabox;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MediaboxServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfigurationFiles();

        $this->registerMediaboxSingleton();

        $this->registerRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfigurationFile();

        $this->bindRouteParameters();
    }

    /**
     * Bind the alias parameter to the core.widget class.
     *
     * @return void
     */
    protected function bindRouteParameters()
    {
        $this->app['router']->bind('media', function ($value) {
            $mediabox = new Mediabox($value, config('mediabox.root_path'));
            return new File($mediabox->rootPath($value), config('mediabox.root_path'));
        });

        $this->app['router']->bind('file', function ($value) {
            $mediabox = new Mediabox($value, config('mediabox.root_path'));
            return new File($mediabox->all()->first(), config('mediabox.root_path'));
        });
    }

    /**
     * Register the package config files.
     *
     * @return void
     */
    protected function registerConfigurationFiles(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mediabox.php', 'mediabox');
    }

    /**
     * Register the Mediabox class.
     *
     * @return void
     */
    protected function registerMediaboxSingleton()
    {
        $this->app->bind(MediaboxInterface::class, Mediabox::class);

        $this->app->singleton(Mediabox::class, function ($app) {
            return new Mediabox(
                $app['request']->get('p') ?? config('mediabox.base_path'),
                config('mediabox.root_path')
            );
        });
    }

    /**
     * Publish the config file.
     *
     * @return void
     */
    protected function publishConfigurationFile(): void
    {
        $this->publishes([
            __DIR__.'/../config/mediabox.php' => config_path('mediabox.php'),
        ], 'mediabox');
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->registerMediaboxRoute();
        $this->registerStorageRoute();
    }

    /**
     * Register the media routes.
     *
     * @return void
     */
    protected function registerMediaboxRoute()
    {
        MediaboxRoutes::register();

        if (config('mediabox.routes.register')) {
            $route = Route::prefix(config('mediabox.routes.prefix'))->as('api.');

            if (! empty(config('mediabox.routes.middlewares', []))) {
                $route->middleware(config('mediabox.routes.middlewares'));
            }

            $route->group(function () {
                Route::mediaResource(config('mediabox.routes.name'), config('mediabox.routes.controller'));
            });
        }
    }

    /**
     * Register the storage routes.
     *
     * @return void
     */
    protected function registerStorageRoute()
    {
        StorageRoutes::register();

        if (config('mediabox.storage.register')) {
            $route = Route::prefix(config('mediabox.storage.prefix'));

            if (! empty(config('mediabox.storage.middlewares', []))) {
                $route->middleware(config('mediabox.storage.middlewares'));
            }

            $route->group(function () {
                Route::storageResource(config('mediabox.storage.name'), config('mediabox.storage.controller'));
            });
        }
    }
}
