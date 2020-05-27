<?php

namespace Codrasil\Mediabox;

use Codrasil\Mediabox\Console\Commands\MediaboxScaffoldCommand;
use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Http\Routes\MediaboxApiRoutes;
use Codrasil\Mediabox\Http\Routes\MediaboxRoutes;
use Codrasil\Mediabox\Http\Routes\StorageRoutes;
use Codrasil\Mediabox\Http\Views\Composers\FilesComposer;
use Codrasil\Mediabox\Mediabox;
use Codrasil\Mediabox\View\Components\AddFolderLink;
use Codrasil\Mediabox\View\Components\Breadcrumbs;
use Codrasil\Mediabox\View\Components\CopyLink;
use Codrasil\Mediabox\View\Components\DeleteLink;
use Codrasil\Mediabox\View\Components\DownloadLink;
use Codrasil\Mediabox\View\Components\FileLink;
use Codrasil\Mediabox\View\Components\PreviewLink;
use Codrasil\Mediabox\View\Components\RenameLink;
use Codrasil\Mediabox\View\Components\SortLink;
use Codrasil\Mediabox\View\Components\UploadLink;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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

        $this->loadViewComponentFiles();

        $this->loadConsoleCommands();

        $this->loadViewComposer();

        $this->publishViewFiles();

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
            $file = new File($mediabox->rootPath($value), config('mediabox.root_path'));

            if (! $file->exists()) {
                return abort(404);
            }

            return $file;
        });

        $this->app['router']->bind('file', function ($value) {
            $mediabox = new Mediabox($value, config('mediabox.root_path'));
            $file = new File($mediabox->rootPath($value), config('mediabox.root_path'));

            if (! $file->exists()) {
                return abort(404);
            }

            return $file;
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
     * Register the package view files.
     *
     * @return void
     */
    protected function publishViewFiles()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mediabox');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/mediabox'),
        ], 'mediabox:views');
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
            $mediabox = new Mediabox(
                $app['request']->get('p') ?? config('mediabox.base_path'),
                config('mediabox.root_path')
            );

            if (config('mediabox.title')) {
                $mediabox->setRootFolderName(config('mediabox.title'));
            }

            if (config('mediabox.show_hidden_files', false)) {
                $mediabox->showHiddenFiles(
                    config('mediabox.allow_hidden_files_toggle_via_url')
                        ? filter_var($app['request']->get('h') ?: false, FILTER_VALIDATE_BOOLEAN)
                        : config('mediabox.show_hidden_files', false)
                );
            }

            return $mediabox;
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
     * Register the package view components.
     *
     * @return void
     */
    protected function loadViewComponentFiles()
    {
        if (config('mediabox.register_blade_components')) {
            Blade::include('mediabox::includes.styles', 'mediaboxModalStyles');

            $this->loadViewComponentsAs('mediabox', [
                AddFolderLink::class,
                Breadcrumbs::class,
                CopyLink::class,
                DeleteLink::class,
                DownloadLink::class,
                FileLink::class,
                PreviewLink::class,
                RenameLink::class,
                SortLink::class,
                UploadLink::class,
            ]);
        }
    }

    /**
     * Register the console commands.
     *
     * @return void
     */
    protected function loadConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MediaboxScaffoldCommand::class,
            ]);
        }
    }

    /**
     * Register a view composer.
     *
     * @return void
     */
    protected function loadViewComposer()
    {
        View::composer(['mediabox::media.index'], FilesComposer::class);
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->registerStorageRoute();

        $this->registerMediaboxRoute();

        $this->registerApiMediaboxRoute();
    }

    /**
     * Register the media routes.
     *
     * @return void
     */
    protected function registerApiMediaboxRoute()
    {
        MediaboxApiRoutes::register();

        if (config('mediabox.routes.api.register')) {
            $route = Route::prefix(config('mediabox.routes.api.prefix'))->as('api.');

            if (! empty(config('mediabox.routes.api.middlewares', []))) {
                $route->middleware(config('mediabox.routes.api.middlewares'));
            }

            $route->group(function () {
                Route::apiMediaResource(config('mediabox.routes.api.name'), config('mediabox.routes.api.controller'));
            });
        }
    }

    /**
     * Register the media routes.
     *
     * @return void
     */
    protected function registerMediaboxRoute()
    {
        MediaboxRoutes::register();

        if (config('mediabox.routes.web.register')) {
            $route = Route::prefix(config('mediabox.routes.web.prefix'));

            if (! empty(config('mediabox.routes.web.middlewares', []))) {
                $route->middleware(config('mediabox.routes.web.middlewares'));
            }

            $route->group(function () {
                Route::mediaResource(config('mediabox.routes.web.name'), config('mediabox.routes.web.controller'));
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

        if (config('mediabox.routes.storage.register')) {
            $route = Route::prefix(config('mediabox.routes.storage.prefix'));

            if (! empty(config('mediabox.routes.storage.middlewares', []))) {
                $route->middleware(config('mediabox.routes.storage.middlewares'));
            }

            $route->group(function () {
                Route::storageResource(config('mediabox.routes.storage.name'), config('mediabox.routes.storage.controller'));
            });
        }
    }
}
