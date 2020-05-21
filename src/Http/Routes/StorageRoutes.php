<?php

namespace Codrasil\Mediabox\Http\Routes;

use Codrasil\Mediabox\Http\Controllers\DownloadStorageFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

abstract class StorageRoutes
{
    /**
     * Register the route macros.
     *
     * @return void
     */
    public static function register(): void
    {
        if (! Route::hasMacro('storageResource')) {
            Route::macro('storageResource', function ($name, $controller) {
                Route::get(
                    "$name/{file}/download", DownloadStorageFile::class
                )->where('file', '.*')->name("$name.download");

                Route::get("$name/{file}", "$controller")->where('file', '.*')->name("$name.show");
            });
        }
    }
}
