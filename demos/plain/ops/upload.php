<?php

require_once __DIR__.'/../mediabox.php';

defined('CODRASIL_MEDIABOX_VERSION') or die('No access');

$attributes = $_POST;
$parent = $attributes['parent'];

$file = $_FILES['file'];

$mediabox->upload($file, $parent);

header('Location: /'.url_params(['p' => $parent]));
exit;
