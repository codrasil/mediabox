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
    'starred',
    'tasks',
    'videos',
    'README.txt'
]);

$mediabox->addFolder('documents');
$mediabox->addFolder('downloads');
$mediabox->addFolder('music');
$mediabox->addFolder('pictures');
$mediabox->addFolder('starred');
$mediabox->addFolder('tasks');
$mediabox->addFolder('videos');
$mediabox->addFile('README.txt', 'Run `composer run demo:prep` to reset and generate empty folders to storage folder.');
$mediabox->addFile('tasks/groceries.todo', "☐ Milk\n☐ Eggs\n☐ Ham");

unset($mediabox);
