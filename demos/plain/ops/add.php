<?php

require_once __DIR__.'/../mediabox.php';

defined('CODRASIL_MEDIABOX_VERSION') or die('No access');

$attributes = $_POST;

$mediabox->add($attributes['name'], ['parent' => $parent = $attributes['parent']]);

header('Location: /'.url_params(['p' => $parent]));
exit;
