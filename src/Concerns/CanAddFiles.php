<?php

namespace Codrasil\Mediabox\Concerns;

trait CanAddFiles
{
    /**
     * Add a folder from specified parameters.
     *
     * @param  string  $path
     * @param  boolean $force
     * @param  integer $mode
     * @param  boolean $recursive
     * @return __CLASS__
     */
    public function addFolder(string $path, bool $force = false, int $mode = 0777, bool $recursive = true)
    {
        parent::makeDirectory(
            $this->rootPath($path), $mode, $recursive, $force
        );

        return $this;
    }

    /**
     * Add a new file to path.
     *
     * @param  string      $path
     * @param  string|null $content
     * @return __CLASS__
     */
    public function addFile(string $path, string $content = null)
    {
        parent::put($this->rootPath($path), $content);

        @chmod($this->rootPath($path), 0777);

        return $this;
    }
}
