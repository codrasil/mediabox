<?php

require_once __DIR__.'/../mediabox.php';

defined('CODRASIL_MEDIABOX_VERSION') or die('No access');

$name = $_GET['name'];
$parent = dirname($name);

$attributes = $_POST;

$mediabox->delete($attributes['name']);

header('Location: /'.url_params(['name' => null, 'p' => ltrim($parent, '.')]));
exit;
