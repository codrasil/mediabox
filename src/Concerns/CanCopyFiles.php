<?php

namespace Codrasil\Mediabox\Concerns;

trait CanCopyFiles
{
    /**
     * Copy a file to a new location.
     *
     * @param  string $path
     * @param  string $target
     * @return boolean
     */
    public function copy($path, $target)
    {
        if (is_dir($this->rootPath($path))) {
            return $this->copyDirectory($path, $target);
        }

        return parent::copy($this->rootPath($path), $this->rootPath($target));
    }

    /**
     * Copy a directory from one location to another.
     *
     * @param  string       $directory
     * @param  string       $destination
     * @param  integer|null $options
     * @return boolean
     */
    public function copyDirectory($directory, $destination, $options = null)
    {
        return parent::copyDirectory($this->rootPath($directory), $this->rootPath($destination), $options);
    }
}
