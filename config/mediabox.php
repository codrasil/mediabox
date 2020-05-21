<?php

use Codrasil\Mediabox\Http\Controllers\MediaboxController;
use Codrasil\Mediabox\Http\Controllers\ShowStorageFile;

return [

    /*
    |--------------------------------------------------------------------------
    | Media Base Path
    |--------------------------------------------------------------------------
    |
    | The 'root_path' value holds the location of the storage folder
    | from local disk.
    |
    | The 'base_path' holds the current folder we are in.
    | It should match the 'root_path' value initially.
    |
    */

    'root_path' => storage_path('app/public'),
    'base_path' => storage_path('app/public'),

    /*
    |--------------------------------------------------------------------------
    | Routes & Storage Resource
    |--------------------------------------------------------------------------
    |
    | The package comes with its own routes and controllers.
    | The 'routes' key holds the operations like addding, copying, renaming
    | of file. The 'storage' key holds the displaying and downloading of the
    | files to the browser.
    |
    | The 'register' key for both 'routes' and 'storage' determines whether to
    | install these routes or not. If you've set these values to false but still
    | want to use the routes, you may use the route macros in your
    | AppServiceProvider, routes/api.php or routes/web.php file:
    |
    |  routes  - Codrasil\Mediabox\Http\Routes\MediaboxRoutes::register()
    |  storage - Codrasil\Mediabox\Http\Routes\StorageRoutes::register()
    |
    */

    'routes' => [
        'controller' => MediaboxController::class,
        'middlewares' => ['api', 'bindings'],
        'name' => 'media',
        'prefix' => 'api/v1',
        'register' => true,
    ],
    'storage' => [
        'controller' => ShowStorageFile::class,
        'middlewares' => ['web'],
        'name' => 'storage',
        'register' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hidden Files
    |--------------------------------------------------------------------------
    |
    | The 'show_hidden_files' value determines whether to fetch hidden files
    | or not, while 'allow_hidden_files_toggle_via_url' enables the toggle of
    | hidden files via url parameter 'h'.
    |
    | E.g. The url /media?h=true will fetch hidden files.
    |
    | The key 'allow_hidden_files_toggle_via_url' will not work if
    | 'show_hidden_files' is set to false.
    |
    */

    'show_hidden_files' => true,
    'allow_hidden_files_toggle_via_url' => false,
];
