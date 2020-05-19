<?php

if (! function_exists('cm_human_filesize')) {
    /**
     * Convert bytes to human readable format.
     *
     * @param  integer $bytes
     * @param  integer $decimals
     * @return string
     */
    function cm_human_filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@($sz[$factor] == 'B' ? $sz[$factor] : $sz[$factor].'B');
    }
}
