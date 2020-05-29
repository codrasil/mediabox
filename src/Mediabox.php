<?php

namespace Codrasil\Mediabox;

use Codrasil\Mediabox\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class Mediabox extends Filesystem implements Contracts\MediaboxInterface
{
    use Concerns\CanAddFiles,
        Concerns\CanCopyFiles,
        Concerns\CanDeleteFiles,
        Concerns\CanDownloadFiles,
        Concerns\CanRenameFiles,
        Concerns\CanUploadFiles;

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
     * The folder name to be displayed.
     *
     * @var string
     */
    protected $rootFolderName;

    /**
     * Toggle hidden file visibility.
     *
     * @var boolean
     */
    protected $showHiddenFiles = false;

    /**
     * Pass in the base path of files and
     * folders to be instanced.
     *
     * @param string $basePath
     * @param array  $rootPath
     */
    public function __construct($basePath, $rootPath = null)
    {
        $this->rootPath = $rootPath ?? $basePath;

        $this->basePath = $this->rootPath($basePath);

        $this->items = $this->getFilesAndFolders();

        $this->setRootFolderName(ucfirst(basename($this->getRootPath())));
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
        $path = ltrim($path, DIRECTORY_SEPARATOR);

        return $this->rootPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Retrieve the root path.
     *
     * @return string
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }

    /**
     * Retrieve the current path.
     *
     * @return string
     */
    public function getCurrentPath()
    {
        return str_replace($this->getRootPath(), '', $this->basePath) ?: DIRECTORY_SEPARATOR;
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
     * @param  string $path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
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
        if (! is_dir($this->basePath)) {
            return Collection::make([]);
        }

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
        if (is_file($this->basePath)) {
            return Collection::make($this->formatFileMetadata([$this->basePath]));
        }

        if (! is_dir($this->basePath)) {
            return Collection::make([]);
        }

        return Collection::make(
            $this->formatFileMetadata($this->files($this->basePath, $this->showHiddenFiles))
        );
    }

    /**
     * Normalize the retrieved files
     *
     * @param  array $files
     * @return \Illuminate\Support\Collection
     */
    protected function formatFileMetadata(array $files)
    {
        return array_map(function ($file) {
            return $this->file($file);
        }, $files);
    }

    /**
     * Create a new File instance.
     *
     * @param  string $file
     * @param  string $rootPath
     * @return \Codrasil\Mediabox\File
     */
    public function file($file, $rootPath = null)
    {
        return new File($file, $rootPath ?? $this->rootPath);
    }

    /**
     * Retrieve the list of files and folders.
     *
     * @return object
     */
    public function all()
    {
        return $this->refresh()->getItems();
    }

    /**
     * Manually trigger to refresh items collection.
     *
     * @return __CLASS__
     */
    public function refresh()
    {
        $this->items = $this->getFilesAndFolders();

        return $this;
    }

    /**
     * Retrieve the full directory size.
     *
     * @return string
     */
    public function totalSize()
    {
        return cm_human_filesize($this->getItems()->sum('filesize'));
    }

    /**
     * Retrieve the memory usage.
     *
     * @return string|integer
     */
    public function memoryUsage(): string
    {
        return cm_human_filesize(memory_get_usage(true));
    }

    /**
     * Retrieve total disk space of the path.
     *
     * @return string
     */
    public function totalDiskSpace(): string
    {
        return cm_human_filesize(disk_total_space($this->rootPath()));
    }

    /**
     * Retrieve total free disk space of the path.
     *
     * @return string
     */
    public function freeDiskSpace(): string
    {
        return cm_human_filesize(disk_free_space($this->rootPath()));
    }

    /**
     * Retrieve the total file count.
     *
     * @return integer
     */
    public function totalFileCount(): int
    {
        return $this->getItems()->count();
    }

    /**
     * Retrieve the file or directory
     * from given name.
     *
     * @param  string $name
     * @param  string $key
     * @return mixed
     */
    public function find($name, $key = 'basename')
    {
        return $this->all()->filter(function ($file) use ($name, $key) {
            return $file[$key] == $this->basename($name);
        })->first();
    }

    /**
     * Toggle hidden file visibility.
     *
     * @param  boolean $show
     * @return void
     */
    public function showHiddenFiles($show = true)
    {
        $this->showHiddenFiles = $show;
    }

    /**
     * Retrieve showHiddenFiles value.
     *
     * @return boolean
     */
    public function getShowHiddenFilesValue()
    {
        return $this->showHiddenFiles;
    }

    /**
     * Set the rootFolderName property.
     *
     * @param  string $name
     * @return void
     */
    public function setRootFolderName($name)
    {
        $this->rootFolderName = $name;
    }

    /**
     * Retrieve the root folder's name.
     *
     * @return string
     */
    public function getRootFolderName()
    {
        return $this->rootFolderName;
    }

    /**
     * Retrieve the breadcrumb array.
     *
     * @return array
     */
    public function breadcrumbs()
    {
        $crumbs = Collection::make(explode(
            DIRECTORY_SEPARATOR, $this->getCurrentPath()
        ));

        return $crumbs->reject(function ($crumb) {
            return empty($crumb) || is_null($crumb);
        })->map(function ($crumb, $i) use ($crumbs) {
            $parents = array_slice($crumbs->toArray(), 0, $i);
            $url = implode(DIRECTORY_SEPARATOR, $parents).DIRECTORY_SEPARATOR.$crumb;
            $file = $this->file($this->rootPath($url));

            return json_decode(json_encode([
                'text' => $crumb,
                'url' => $file->fragment(),
            ]));
        });
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
        if (method_exists(Collection::class, $method)) {
            return call_user_func_array([$this->getItems(), $method], $attributes);
        }

        foreach ((array) $attributes as $i => $attribute) {
            $attributes[$i] = $this->rootPath($attribute);
        }

        call_user_func_array([$this, $method], $attributes);

        return $this;
    }
}
