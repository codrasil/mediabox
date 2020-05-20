<?php

return [
    'routes' => [
        'controller' => 'Codrasil\Mediabox\Http\Controllers\MediaboxController',
        'middlewares' => ['api', 'bindings'],
        'name' => 'media',
        'prefix' => 'api/v1',
        'register' => true,
    ],
    'storage' => [
        'controller' => 'Codrasil\Mediabox\Http\Controllers\ShowStorageFile',
        'middlewares' => ['web'],
        'name' => 'storage/media',
        'register' => true,
    ],
    'root_path' => storage_path('app/public'),
    'base_path' => storage_path('app/public'),
];
