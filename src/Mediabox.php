<?php

namespace Codrasil\Mediabox;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class Mediabox extends Filesystem implements Contracts\MediaboxInterface
{
    use Concerns\CanAddFiles,
        Concerns\CanCopyFiles,
        Concerns\CanDeleteFiles,
        Concerns\CanRenameFiles;

    /**
     * The base path to be instanced.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The array of files and folders.
     *
     * @var array
     */
    protected $items;

    /**
     * The root path.
     *
     * @var string|null
     */
    protected $rootPath;

    /**
     * Pass in the base path of files and
     * folders to be instanced.
     *
     * @param string $path
     * @param array  $rootPath
     */
    public function __construct($basePath, $rootPath = null)
    {
        $this->rootPath = $rootPath ?? $basePath;

        $this->basePath = $this->rootPath($basePath);

        $this->items = $this->getFilesAndFolders();
    }

    /**
     * Retrieve the root path.
     *
     * @param  string $path
     * @return string
     */
    public function rootPath($path = '')
    {
        if ($this->rootPath == $path) {
            return $path;
        }

        $path = str_replace($this->rootPath, '', $path);

        return $this->rootPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Retrieve the files and folders from base path.
     *
     * @return object
     */
    protected function getFilesAndFolders(): object
    {
        return $this->onlyFolders()->merge($this->onlyFiles());
    }

    /**
     * Retrieve the base path.
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Alias for basePath method.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath();
    }

    /**
     * Retrieve the files from the base path.
     *
     * @return object
     */
    public function getItems(): object
    {
        return $this->items;
    }

    /**
     * Retrieve the folders from the base path.
     *
     * @return array
     */
    public function onlyFolders()
    {
        return Collection::make(
            $this->formatFileMetadata($this->directories($this->basePath))
        );
    }

    /**
     * Retrieve the folders from the base path.
     *
     * @return array
     */
    public function onlyFiles()
    {
        return Collection::make(
            $this->formatFileMetadata($this->files($this->basePath))
        );
    }

    /**
     * Normalize the retrieved files
     *
     * @param  array $files
     * @return \Illuminate\Support\Collection
     */
    protected function formatFileMetadata($files)
    {
        return array_map(function ($file) {
            return new File($file, $this->rootPath);
        }, $files);
    }

    /**
     * Retrieve the list of files and folders.
     *
     * @return object
     */
    public function all()
    {
        return $this->getItems();
    }

    /**
     * Before calling the parent Filesystem class' methods,
     * append the root path to the path and target paths.
     *
     * @param  string $method
     * @param  mixed  $attributes
     * @return mixed
     */
    public function __call($method, $attributes)
    {
        foreach ((array) $attributes as $i => $attribute) {
            $attributes[$i] = $this->rootPath($attribute);
        }

        call_user_func_array([$this, $method], $attributes);

        return $this;
    }
}
