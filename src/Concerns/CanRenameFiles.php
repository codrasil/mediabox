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
     * @param  string $path
     * @param  string $target
     * @return boolean
     */
    public function rename($path, $target)
    {
        $target = $this->rootPath($path).DIRECTORY_SEPARATOR.$target;

        return parent::move($this->rootPath($path), $target);
    }
}
