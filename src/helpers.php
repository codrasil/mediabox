<?php

if (! function_exists('cm_human_filesize')) {
    /**
     * Convert bytes to human readable format.
     * phpcs:disable
     *
     * @param  integer $bytes
     * @param  integer $decimals
     * @return string
     */
    function cm_human_filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return @sprintf(
            "%.{$decimals}f",
            $bytes / pow(1024, $factor)).' '.@($sz[$factor] == 'B' ? $sz[$factor] : $sz[$factor].'B'
        );
    }
}

if (! function_exists('parse_size')) {
    /**
     * Parse the given file size.
     *
     * @param  string $size
     * @return integer|double
     */
    function parse_size($size)
    {
        // Remove the non-unit characters from the size.
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);

        // Remove the non-numeric characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size);

        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}

