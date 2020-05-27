<?php

namespace Codrasil\Mediabox\Concerns;

trait CanRenameFiles
{
    /**
     * Move a file to a new location.
     *
     * @param  string $path
     * @param  string $target
     * @return boolean
     */
    public function move($path, $target)
    {
        return parent::move($this->rootPath($path), $this->rootPath($target));
    }

    /**
     * Move a file to a new location.
     *
     * @param  string       $path
     * @param  string|array $target
     * @return boolean
     */
    public function rename($path, $target)
    {
        if (is_array($target)) {
            $target = ltrim(($target['parent'] ?? null).DIRECTORY_SEPARATOR.$target['name'], DIRECTORY_SEPARATOR);
        }

        return parent::move($this->rootPath($path), $this->rootPath($target));
    }
}
