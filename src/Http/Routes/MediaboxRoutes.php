<?php

namespace Codrasil\Mediabox\Http\Routes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

abstract class MediaboxRoutes
{
    /**
     * Register the route macros.
     *
     * @return void
     */
    public static function register(): void
    {
        if (! Route::hasMacro('mediaResource')) {
            Route::macro('mediaResource', function ($name, $controller) {
                Route::get("$name", "$controller@index")->name("$name.index");
                Route::get("$name/{media}", "$controller@show")->where('media', '.*')->name("$name.show");
                Route::patch("$name/{media}/rename", "$controller@rename")->where('media', '.*')->name("$name.rename");
                Route::post("$name/{media}/copy", "$controller@copy")->where('media', '.*')->name("$name.copy");
                Route::delete("$name/delete", "$controller@delete")->name("$name.delete");
                Route::patch("$name/move", "$controller@move")->name("$name.move");
                Route::post("$name/add", "$controller@add")->name("$name.add");
            });
        }
    }
}
