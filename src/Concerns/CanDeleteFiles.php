<?php

namespace Codrasil\Mediabox\Concerns;

trait CanDeleteFiles
{
    /**
     * Delete the files or folders path.
     *
     * @param  string|array $paths
     * @return boolean
     */
    public function delete($paths)
    {
        foreach ((array) $paths as $path) {
            if (is_dir($this->rootPath($path))) {
                $this->deleteFolder($path);
            } elseif (is_file($this->rootPath($path))) {
                $this->deleteFile($path);
            }
        }

        return true;
    }

    /**
     * Delete the given folder.
     *
     * @param  string|array $paths
     * @return void
     */
    public function deleteFolder($paths)
    {
        $paths = array_map(function ($path) {
            return $this->rootPath($path);
        }, (array) $paths);

        foreach ($paths as $path) {
            parent::deleteDirectory($path);
        }
    }

    /**
     * Delete the given file.
     *
     * @param  string|array $paths
     * @return void
     */
    public function deleteFile($paths)
    {
        $paths = array_map(function ($path) {
            return $this->rootPath($path);
        }, (array) $paths);

        parent::delete($paths);
    }
}
