<?php

require_once __DIR__.'/../mediabox.php';

defined('CODRASIL_MEDIABOX_VERSION') or die('No access');

$download = $mediabox->download($file)->send();

header('Location: /'.url_params(['p' => null, 'name' => null]));
exit;
