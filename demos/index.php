<?php

require_once '../vendor/autoload.php';

use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;

$rootPath = '/home/lioneil/Projects/codrasil/mediabox';
$path = $_GET['p'] ?? $rootPath;
$mediabox = new Mediabox($path, $rootPath);
$f = $_GET['f'] ?? null;

foreach ($mediabox->all() as $file) {
    if ($file->isDir()) {
        echo "- <a href='?p=".$file->getCurrentPath()."'>"
            .$file->name()
            .'/'
            ."</a>"."<br>";
    } else {
        echo "+ <a href='//".$file->previewUrl()."'>"
            .$file->name()
            ."</a><br>";
    }
}

if ($f) {
    $file = new File($rootPath.'/'.$f, $rootPath);
    echo $file->previewUrl().'<br>';
    echo nl2br(file_get_contents($rootPath.'/'.$f));
}
