<?php

/** merge url params */
function url_params(array $params = [])
{
    return '?'.http_build_query(array_merge($_GET, $params));
}

/** retrieve the p value */
function get_p_value()
{
    return $_GET['p'] ?: null;
}

/** retrieve dirname */
function get_dirname($param)
{
    return dirname($param);
}

/** retrieve the sort partial file */
function get_sort($label, $sortKey)
{
    include __DIR__.'/partials/sort.php';
}
