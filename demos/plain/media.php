<?php

require_once __DIR__.'/mediabox.php';

defined('CODRASIL_MEDIABOX_VERSION') or die('No access');

$mediabox->fetch($file, ['Content-type' => $file->mimetype()])->send();

exit;
