#!/usr/bin/env php
<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Codrasil\Mediabox\Mediabox;

$baseStoragePath = realpath(__DIR__.DIRECTORY_SEPARATOR.'storage');

$mediabox = new Mediabox($baseStoragePath);

$mediabox->delete([
    'documents',
    'downloads',
    'music',
    'pictures',
    'videos',
    'README.txt'
]);

$mediabox->addFolder('documents');
$mediabox->addFolder('downloads');
$mediabox->addFolder('music');
$mediabox->addFolder('pictures');
$mediabox->addFolder('videos');
$mediabox->addFile('README.txt', 'Hello there.');

unset($mediabox);
