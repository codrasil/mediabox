<?php

namespace Codrasil\Mediabox\Concerns;

use Codrasil\Mediabox\Enums\FileKeys;

trait CanAddFiles
{
    /**
     * Add a file or folder to media.
     *
     * @param  string $path
     * @param  array  $attributes
     * @return __CLASS__
     */
    public function add(string $path, array $attributes = [])
    {
        $type = $attributes['type'] ?? FileKeys::DIR_KEY;
        $parent = $attributes['parent'] ?? null;
        $path = ($parent ? $parent.'/' : $parent).$path;

        if ($type == FileKeys::DIR_KEY) {
            return $this->addFolder(
                $path,
                $attributes['force'] ?? false,
                $attributes['mode'] ?? 0777,
                $attributes['recursive'] ?? true,
            );
        }

        if ($type == FileKeys::FILE_KEY) {
            return $this->addFile($path, $attributes['content'] ?? null);
        }

        return $this;
    }

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
     * phpcs:disable
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
