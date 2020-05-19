<?php

namespace Codrasil\Mediabox\Contracts;

interface MediaboxInterface
{
    /**
     * Retrieve the base path.
     *
     * @return string
     */
    public function basePath();

    /**
     * Retrieve the list of files and folders.
     *
     * @return object
     */
    public function all();
}
