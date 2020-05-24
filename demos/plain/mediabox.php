<?php // phpcs:disabled

define('CODRASIL_MEDIABOX_VERSION', 'v1.0.0');

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/functions.php';

use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;

$rootStoragePath = realpath(__DIR__.DIRECTORY_SEPARATOR.'storage');

$baseStoragePath = $_GET['p'] ?: $rootStoragePath;
$showHiddenFiles = filter_var($_GET['h'] ?: false, FILTER_VALIDATE_BOOLEAN);

$mediabox = new Mediabox($baseStoragePath, $rootStoragePath);

$mediabox->showHiddenFiles($showHiddenFiles);

if ($f = $_GET['f']) {
    $file = new Mediabox($f, $rootStoragePath);
    $file = new File($file->rootPath($f), $rootStoragePath);
}
