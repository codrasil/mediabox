<?php

namespace Codrasil\Mediabox\Contracts;

interface MediaboxInterface
{
    /**
     * Retrieve the base path.
     *
     * @param  string $path
     * @return string
     */
    public function basePath($path = '');

    /**
     * Retrieve the root path.
     *
     * @param  string $path
     * @return string
     */
    public function rootPath($path = '');

    /**
     * Retrieve the list of files and folders.
     *
     * @return object
     */
    public function all();
}
